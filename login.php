<?php
session_start();
require 'includes/connection.php';
$erro = "";

if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    $mensagem_sucesso = "Conta criada com sucesso! Pode fazer login.";
}

if (isset($_GET['erro']) && $_GET['erro'] == 1) {
    $erro = "Email e/ou password incorretos!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];

    $stmt = mysqli_prepare($link, "SELECT * FROM utilizadores WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($pass, $user['pass'])) {

            $_SESSION['iduser'] = $user['iduser'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logado'] = true;

            header("Location: home.php");
exit();

        } else {
            $erro = "Email e/ou password incorretos!";
        }
    } else {
        $erro = "Email e/ou password incorretos!";
    }
}
?>


<!DOCTYPE html>
<html lang="pt" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pitada na Mesa</title>  
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 h-100 bg-fade">

<main class="form-signin ms-auto me-auto p-3">

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">

      <form method="POST" action="">
    <a href="index.php" class="d-flex justify-content-center mx-auto mb-4">
      <img src="imgs/pitada.logo.png" height="80" width="120" alt="Logótipo Pitada na Mesa"/>
    </a>
    
    <h1 class="fs-4 mb-3 fw-normal text-center">Entrar</h1>

    <?php if (!empty($mensagem_sucesso)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($mensagem_sucesso); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    
    <div class="form-floating ">
      <input type="text" class="form-control mb-2" id="floatingUser" name="email" placeholder="email" required/>
      <label for="floatingUser">Email</label> </div>
    
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" required/>
      <label for="floatingPassword">Palavra-Passe</label>
    </div>

    <button class="btn btn-success w-100 py-2 mt-3" type="submit">Login</button>
    
    <p class="mt-3 text-center text-body-secondary mb-0">
      Ainda não tem conta? 
      <a href="registo.php" class="fw-semibold text-decoration-none">Faça o seu registo</a>
    </p>
    
</form>
    </div>
  </div>
</main>
</body>
</html>