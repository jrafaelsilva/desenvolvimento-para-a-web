<?php
session_start();

// 1. GERAR TOKEN CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. LER ERROS
$erro = "";
if (isset($_SESSION['erro_registo'])) {
    $erro = $_SESSION['erro_registo'];
    unset($_SESSION['erro_registo']);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registo - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 min-vh-100 bg-fade">

<main class="form-signin ms-auto me-auto p-3" style="max-width: 550px; width: 100%;"> 

  <div class="card shadow-lg border-0 rounded-4">
    
    <div class="card-body p-4 p-md-5 position-relative">

      <!-- ÍCONE DE VOLTAR ATRÁS -->
      <a href="login.php" class="text-dark position-absolute top-0 start-0 m-3" title="Voltar à Página Inicial">
        <i class="bi bi-arrow-left fs-4"></i>
      </a>

      <form method="POST" action="auth/proc_registo.php">
        
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <a href="index.php" class="d-flex justify-content-center mx-auto mb-4">
          <img src="imgs/pitada.logo.png" height="80" width="120" alt="Logótipo Pitada na Mesa"/>
        </a>
        
        <h1 class="fs-4 mb-3 fw-normal text-center">Criar Conta</h1>
        
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger text-center py-2 fs-6" role="alert">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

        <!-- CAMPO UTILIZADOR (Estilo Atualizado) -->
        <div class="mb-3">
          <label for="floatingUser" class="form-label fw-medium text-dark">Nome de utilizador</label>
          <input type="text" class="form-control form-control-lg fs-6" id="floatingUser" name="utilizador" required placeholder="Escolha um nome de utilizador">
        </div>
        
        <!-- CAMPO EMAIL (Estilo Atualizado) -->
        <div class="mb-3">
          <label for="floatingEmail" class="form-label fw-medium text-dark">Endereço de Email</label>
          <input type="email" class="form-control form-control-lg fs-6" id="floatingEmail" name="email" required placeholder="Insira o seu email">
        </div>
        
        <!-- CAMPO PASSWORD (Estilo Atualizado) -->
        <div class="mb-1">
          <label for="floatingPassword" class="form-label fw-medium text-dark">Palavra-Passe</label>
          <input type="password" class="form-control form-control-lg fs-6" id="floatingPassword" name="pass" required placeholder="********" minlength="8">
        </div>
        
        <div class="form-text text-dark small mb-4 text-end">
            Mínimo de 8 caracteres.
        </div>

        <button class="btn btn-style2 w-100 py-2 fw-bold shadow-sm" type="submit">Realizar registo</button>
        
        <p class="mt-4 text-center text-dark mb-0">
          Já tem conta? 
          <a href="login.php" class="fw-semibold text-decoration-none text-success">Faça login</a>
        </p>
        
      </form>

    </div>
  </div>
</main>
</body>
</html>