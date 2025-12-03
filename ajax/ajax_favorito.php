<?php
session_start();
ob_clean(); 
require('../includes/connection.php');
header('Content-Type: application/json');

// 1. Verifica Autenticação
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Login necessário']);
    exit;
}

$idUser = $_SESSION['iduser'] ?? $_SESSION['id'] ?? 0;
$input = json_decode(file_get_contents("php://input"), true);

// Validação dos dados
$idReceita  = $input['id_receita'] ?? null;
$titulo     = $input['titulo'] ?? 'Sem título';
$imagem     = $input['imagem'] ?? '';
$referencia = $input['referencia'] ?? '#';

if ($idReceita === null) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido']);
    exit;
}

try {
    // 2. Verificar se o registo JÁ EXISTE (independentemente de estar ativo ou inativo)
    $sqlCheck = "SELECT id, ativado FROM favoritos WHERE id_utilizador = :idUser AND id_receita = :idReceita";
    $stmt = $dbh->prepare($sqlCheck);
    $stmt->bindValue(':idUser', $idUser);
    $stmt->bindValue(':idReceita', $idReceita);
    $stmt->execute();
    
    $favorito = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($favorito) {
        
        // Se estava 1 passa a 0, se estava 0 passa a 1
        $novoEstado = ($favorito['ativado'] == 1) ? 0 : 1;
        
        $sqlUpdate = "UPDATE favoritos SET ativado = :estado WHERE id = :id";
        $stmtUpd = $dbh->prepare($sqlUpdate);
        $stmtUpd->bindValue(':estado', $novoEstado);
        $stmtUpd->bindValue(':id', $favorito['id']);
        $stmtUpd->execute();

        // Dizemos ao JS se foi "adicionado" (ativo) ou "removido" (inativo) para ele pintar o coração
        $status = ($novoEstado == 1) ? 'adicionado' : 'removido';

    } else {
        // === CENÁRIO B: Nunca deu like, criar novo registo (ativado = 1) ===
        
        $sqlAdd = "INSERT INTO favoritos (id_utilizador, id_receita, titulo_receita, imagem_receita, referencia, ativado) 
                   VALUES (:idUser, :idReceita, :titulo, :imagem, :ref, 1)";
        $stmtAdd = $dbh->prepare($sqlAdd);
        $stmtAdd->bindValue(':idUser', $idUser);
        $stmtAdd->bindValue(':idReceita', $idReceita);
        $stmtAdd->bindValue(':titulo', $titulo);
        $stmtAdd->bindValue(':imagem', $imagem);
        $stmtAdd->bindValue(':ref', $referencia);
        $stmtAdd->execute();

        $status = 'adicionado';
    }

    echo json_encode(['status' => $status]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
?>