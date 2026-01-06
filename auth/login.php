<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

$erro = "";
if (isset($_SESSION['erro_login'])) {
    $erro = $_SESSION['erro_login'];
    unset($_SESSION['erro_login']);
}

$mensagem_sucesso = "";
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    $mensagem_sucesso = "Conta criada com sucesso! Já pode fazer login.";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pitada na Mesa</title>  
  <link rel="shortcut icon" href="../imgs/pitada.logo.png">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 min-vh-100 bg-fade">

<main class="form-signin ms-auto me-auto p-3" style="max-width: 550px; width: 100%;">
  
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5 position-relative">

      <a href="../index.php" class="text-dark position-absolute top-0 start-0 m-3" title="Voltar à Página Inicial">
        <i class="bi bi-arrow-left fs-4"></i>
      </a>

      <a href="../index.php" class="d-flex justify-content-center mx-auto mb-4">
        <img src="../imgs/pitada.logo.png" height="80" width="120" alt="Logótipo Pitada na Mesa"/>
      </a>
      
      <h2 class="text-center fw-bold mb-4 text-dark">Iniciar Sessão</h2>

      <?php if (!empty($mensagem_sucesso)): ?>
          <div class="alert alert-success text-center py-2 fs-6" role="alert">
              <?php echo htmlspecialchars($mensagem_sucesso); ?>
          </div>
      <?php endif; ?>

      <?php if (!empty($erro)): ?>
          <div class="alert alert-danger text-center py-2 fs-6" role="alert">
              <?php echo htmlspecialchars($erro); ?>
          </div>
      <?php endif; ?>

      <form action="proc_login.php" method="POST">
        
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="mb-3">
          <label for="email" class="form-label fw-medium text-dark">Email</label>
          <input type="email" class="form-control form-control-lg fs-6" id="email" name="email" required placeholder="Insira o seu email">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-medium text-dark">Palavra-passe</label>
          <input type="password" class="form-control form-control-lg fs-6" id="password" name="pass" required placeholder="********">
        </div>

        <button class="btn btn-style2 w-100 py-2 mt-3 fw-bold shadow-sm" type="submit">Entrar</button>
        
        <p class="mt-4 text-center text-dark fs-6 mb-0">
          Não tem uma conta? 
          <a href="registo.php" class="fw-semibold text-decoration-none text-success">Registe-se</a>
        </p>
        
      </form>
    </div>
  </div>
</main>
</body>
</html>