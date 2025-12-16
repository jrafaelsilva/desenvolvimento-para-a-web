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

// Validação básica
$idReceita = $input['id_receita'] ?? null;
if ($idReceita === null) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido']);
    exit;
}

try {

    $sqlReceita = "SELECT titulo, imagem, categoria FROM receitas WHERE id = :idReceita";
    $stmtRec = $dbh->prepare($sqlReceita);
    $stmtRec->bindValue(':idReceita', $idReceita);
    $stmtRec->execute();
    $dadosReceita = $stmtRec->fetch(PDO::FETCH_ASSOC);

    // Valores por defeito caso a receita não seja encontrada ou venha do input
    $tituloFinal = $dadosReceita['titulo'] ?? $input['titulo'] ?? 'Sem título';
    $imagemNome  = $dadosReceita['imagem'] ?? $input['imagem'] ?? ''; 
    $categoria   = $dadosReceita['categoria'] ?? '';
    
    $apenasNomeFicheiro = basename($imagemNome); 

    // 2. Aplicar o teu MAPA DE PASTAS
    $mapaPastas = [
        'Receitas de carne' => 'carne',
        'Peixe'             => 'peixe',
        'Sobremesa'         => 'sobremesa',
        'Sopas e Cremes'    => 'sopas',
        'Comunidade'        => 'comunidade'
    ];

    // Verificar qual a pasta com base na categoria
    $pastaDestino = isset($mapaPastas[$categoria]) ? $mapaPastas[$categoria] : '';

    // 3. Construir o caminho final para guardar nos favoritos (caminhoBD)
    if ($pastaDestino) {
        $imagemFinal = "imgs/" . $pastaDestino . "/" . $apenasNomeFicheiro;
    } else {
        $imagemFinal = "imgs/" . $apenasNomeFicheiro;
    }
    
    // Referência 
    $referencia = $input['referencia'] ?? '#';



    // 4. Verificar se o registo JÁ EXISTE nos favoritos
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

        $status = ($novoEstado == 1) ? 'adicionado' : 'removido';

    } else {
        // === CENÁRIO B: Nunca deu like, criar novo registo ===
        
        $sqlAdd = "INSERT INTO favoritos (id_utilizador, id_receita, titulo_receita, imagem_receita, referencia, ativado) 
                   VALUES (:idUser, :idReceita, :titulo, :imagem, :ref, 1)";
        $stmtAdd = $dbh->prepare($sqlAdd);
        $stmtAdd->bindValue(':idUser', $idUser);
        $stmtAdd->bindValue(':idReceita', $idReceita);
        $stmtAdd->bindValue(':titulo', $tituloFinal); 
        $stmtAdd->bindValue(':imagem', $imagemFinal); 
        $stmtAdd->bindValue(':ref', $referencia);
        $stmtAdd->execute();

        $status = 'adicionado';
    }

    echo json_encode(['status' => $status]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
?>