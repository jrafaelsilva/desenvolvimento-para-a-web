<?php
session_start();
require('../includes/connection.php');

// 1. Validações de Acesso
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../submeterreceita.php");
    exit;
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: ../login.php");
    exit;
}

// 2. Validação CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['erro_submissao'] = "Erro de segurança. Tente novamente.";
    header("Location: ../submeterreceita.php");
    exit;
}

// 3. Receber Dados
$titulo = trim($_POST['titulo']);
$descricao = $_POST['descricao'];
$tempo = (int)$_POST['tempo'];
$ingredientes = $_POST['ingredientes']; 
$passos = $_POST['passos']; 

// AQUI: Definimos a categoria fixa e obtemos o ID do utilizador da sessão
$categoria = "Comunidade";
$idUtilizador = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];

if (empty($titulo) || empty($tempo) || empty($ingredientes) || empty($passos)) {
    $_SESSION['erro_submissao'] = "Por favor, preencha todos os campos obrigatórios.";
    header("Location: ../submeterreceita.php");
    exit;
}

// 4. Processar Upload da Imagem
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
    
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (!in_array($extensao, $permitidos)) {
        $_SESSION['erro_submissao'] = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";
        header("Location: ../submeterreceita.php");
        exit;
    }

    $novoNome = "receita_user_" . $idUtilizador . "_" . time() . "." . $extensao;
    $destino = "../imgs/comunidade/" . $novoNome;
    $caminhoBD = "imgs/comunidade/" . $novoNome;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $_SESSION['erro_submissao'] = "Falha ao guardar a imagem no servidor.";
        header("Location: ../submeterreceita.php");
        exit;
    }

} else {
    $_SESSION['erro_submissao'] = "É obrigatório enviar uma imagem.";
    header("Location: ../submeterreceita.php");
    exit;
}

try {
    // Iniciar Transação (Segurança da BD)
    $dbh->beginTransaction();

    // A. Inserir na tabela RECEITAS (Com id_utilizador)
    $sqlRec = "INSERT INTO receitas (titulo, descricao, imagem, categoria, tempo_preparo, id_utilizador) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtRec = $dbh->prepare($sqlRec);
    $stmtRec->execute([$titulo, $descricao, $caminhoBD, $categoria, $tempo, $idUtilizador]);
    
    // Obter o ID gerado
    $idReceita = $dbh->lastInsertId();

    // B. Inserir INGREDIENTES na respetiva tabela
    $sqlIng = "INSERT INTO ingredientes (id_receita, nome) VALUES (?, ?)";
    $stmtIng = $dbh->prepare($sqlIng);
    
    foreach ($ingredientes as $ing) {
        $ing = trim($ing);
        if (!empty($ing)) {
            $stmtIng->execute([$idReceita, $ing]);
        }
    }

    // C. Inserir PREPARAÇÃO na respetiva tabela
    $sqlPrep = "INSERT INTO preparacao (id_receita, ordem, passo) VALUES (?, ?, ?)";
    $stmtPrep = $dbh->prepare($sqlPrep);
    
    $ordem = 1;
    foreach ($passos as $passo) {
        $passo = trim($passo);
        if (!empty($passo)) {
            $stmtPrep->execute([$idReceita, $ordem, $passo]);
            $ordem++;
        }
    }

    // Confirmar tudo
    $dbh->commit();

    // Redireciona para a página da receita criada
    header("Location: ../receita.php?id=" . $idReceita);
    exit;

} catch (PDOException $e) {
    $dbh->rollBack();
    
    // Apaga a imagem se a BD falhar
    if (file_exists($destino)) {
        unlink($destino);
    }

    $_SESSION['erro_submissao'] = "Erro ao gravar receita: " . $e->getMessage();
    header("Location: ../submeterreceita.php");
    exit;
}
?>