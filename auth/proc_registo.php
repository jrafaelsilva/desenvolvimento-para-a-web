<?php
session_start();
require('../includes/connection.php');

# 1. VALIDAÇÃO DO MÉTODO
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../registo.php');
    exit;
}

# 2. VALIDAÇÃO CSRF
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    unset($_SESSION['csrf_token']);
    $_SESSION['erro_registo'] = 'Erro de segurança. Tente novamente.';
    header('Location: ../403.php');
    exit;
}

# 3. RECEBER DADOS
$utilizador = isset($_POST['utilizador']) ? trim($_POST['utilizador']) : '';
$email      = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass       = isset($_POST['pass']) ? trim($_POST['pass']) : '';

# 4. VALIDAÇÕES
if (empty($utilizador) || empty($email) || empty($pass)) {
    $_SESSION['erro_registo'] = 'Por favor, preencha todos os campos.';
    header('Location: ../registo.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erro_registo'] = 'O formato do email é inválido.';
    header('Location: ../registo.php');
    exit;
}

if (strlen($pass) < 8) {
    $_SESSION['erro_registo'] = 'A palavra-passe deve ter pelo menos 8 caracteres.';
    header('Location: ../registo.php');
    exit;
}

# 5. VERIFICAÇÃO NA BD 
try {
    // A. Verificar se o EMAIL já existe
    $stmt = $dbh->prepare("SELECT iduser FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['erro_registo'] = 'Este endereço de email já está registado.';
        header('Location: ../registo.php');
        exit;
    }

    // B. CRIAR A CONTA
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    
    // Usamos três ? para os três valores (Utilizador, Email, Pass)
    $stmtInsert = $dbh->prepare("INSERT INTO utilizadores (utilizador, email, pass) VALUES (?, ?, ?)");
    
    // A ordem do array TEM de ser a mesma da query acima
    $sucesso = $stmtInsert->execute([$utilizador, $email, $pass_hash]);
    
    if ($sucesso) {
        header('Location: ../login.php?sucesso=1');
        exit;
    } else {
        $_SESSION['erro_registo'] = 'Erro ao criar conta. Tente novamente.';
        header('Location: ../registo.php');
        exit;
    }

} catch (PDOException $e) {
    // Debug: Mostra o erro exato
    $_SESSION['erro_registo'] = 'Erro BD: ' . $e->getMessage();
    header('Location: ../registo.php');
    exit;
}
?>