<?php
session_start();

# 1. VALIDAÇÃO DO MÉTODO DE ENVIO
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se tentarem aceder direto pelo link, manda para o 403
    header('Location: ../403.php'); 
    exit;
}


# 2. VALIDAÇÃO CSRF (SEGURANÇA CONTRA ATAQUES)
if (!isset($_POST['csrf_token']) || 
    !isset($_SESSION['csrf_token']) || 
    $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    
    // Se o token não bater certo (ataque ou sessão expirada)
    unset($_SESSION['csrf_token']);
    $_SESSION['erro_login'] = 'Erro de segurança (Sessão expirada). Tente novamente.';
    header('Location: ../403.php');
    exit;
}

# 3. LIGAÇÃO À BD E RECOLHA DE DADOS
require('../includes/connection.php');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass  = isset($_POST['pass']) ? trim($_POST['pass']) : ''; 

// Validação simples
if (empty($email) || empty($pass)) {
    $_SESSION['erro_login'] = 'Por favor, preencha todos os campos.';
    header('Location: login.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erro_login'] = 'Formato de email inválido.';
    header('Location: login.php');
    exit;
}

# 4. VERIFICAÇÃO NA BASE DE DADOS
try {
    // Busca o ID, NOME (utilizador) e SENHA (pass)
    $stmt = $dbh->prepare("SELECT iduser, utilizador, pass, estado FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se user existe E a senha bate certo com a encriptação
    if ($user && password_verify($pass, $user['pass'])) {
    // --- Verificar se a conta está ativa ---
        if ($user['estado'] == 0) {
            $_SESSION['erro_login'] = 'A sua conta foi bloqueada. Por favor, contacte o administrador.';
            header('Location: login.php');
            exit;
        }
        # --- LOGIN SUCESSO ---
        session_regenerate_id(true); // Previne roubo de sessão

        $_SESSION['logado'] = true;           
        $_SESSION['iduser'] = $user['iduser'];
        $_SESSION['utilizador'] = $user['utilizador']; 
        $_SESSION['email'] = $email;

        header('Location: ../index.php');
        exit;

    } else {
        # --- LOGIN FALHOU ---
        $_SESSION['erro_login'] = 'Email e/ou palavra-passe incorreto(s).';
        header('Location: login.php');
        exit;
    }

} catch (PDOException $e) {
    // Erro técnico (BD em baixo, etc)
    $_SESSION['erro_login'] = 'Erro no sistema. Tente mais tarde.';
    header('Location: login.php');
    exit;
}
?>