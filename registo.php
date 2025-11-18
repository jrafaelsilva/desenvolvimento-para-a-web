<?php
session_start();
require 'includes/connection.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilizador = trim($_POST['utilizador']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];

    $stmt = mysqli_prepare($link, "SELECT iduser FROM utilizadores WHERE utilizador = ? OR email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $utilizador, $email);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $erro = "Utilizador ou email já existem!";
    } else {
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($link, "INSERT INTO utilizadores (utilizador, email, pass) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $utilizador, $email, $pass_hash);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?sucesso=1");
            exit(); 
        } else {
            $erro = "Erro ao criar conta: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registo - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
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
    
    <h1 class="fs-4 mb-3 fw-normal text-center">Faça o seu registo</h1>
    
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>


    <div class="form-floating ">
      <input type="text" class="form-control mb-2" id="floatingUser" name="utilizador" placeholder="utilizador" required/>
      <label for="floatingUser">Nome de utilizador</label>
    </div>
    
    <div class="form-floating ">
      <input type="email" class="form-control mb-2" id="floatingEmail" name="email" placeholder="your-email@gmail.com" required/>
      <label for="floatingEmail">Endereço de Email</label>
    </div>
    
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" required/>
      <label for="floatingPassword">Palavra-Passe</label>
    </div>

    <button class="btn btn-success w-100 py-2 mt-3" type="submit">Realizar registo</button>
    
    <p class="mt-3 text-center text-body-secondary mb-0">
      Já tem conta? 
      <a href="login.php" class="fw-semibold text-decoration-none">Faça login</a>
    </p>
    
</form>

    </div>
  </div>
</main>
</body>
</html>