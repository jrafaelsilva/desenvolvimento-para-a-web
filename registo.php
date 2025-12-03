<?php
session_start();

// 1. GERAR TOKEN CSRF
// Gera um token de segurança se ainda não existir um na sessão
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. LER ERROS
// Verifica se o processador enviou algum erro e limpa-o da sessão após ler
$erro = "";
if (isset($_SESSION['erro_registo'])) {
    $erro = $_SESSION['erro_registo'];
    unset($_SESSION['erro_registo']);
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

      <!-- O FORMULÁRIO APONTA PARA A PASTA AUTH -->
      <form method="POST" action="auth/proc_registo.php">
        
        <!-- CAMPO OCULTO DE SEGURANÇA (CSRF) -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <a href="index.php" class="d-flex justify-content-center mx-auto mb-4">
          <img src="imgs/pitada.logo.png" height="80" width="120" alt="Logótipo Pitada na Mesa"/>
        </a>
        
        <h1 class="fs-4 mb-3 fw-normal text-center">Criar Conta</h1>
        
        <!-- EXIBIÇÃO DE ERROS -->
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger text-center py-2 fs-6" role="alert">
                <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

        <div class="form-floating">
          <input type="text" class="form-control mb-2" id="floatingUser" name="utilizador" placeholder="utilizador" required/>
          <label for="floatingUser">Nome de utilizador</label>
        </div>
        
        <div class="form-floating">
          <input type="email" class="form-control mb-2" id="floatingEmail" name="email" placeholder="email@exemplo.com" required/>
          <label for="floatingEmail">Endereço de Email</label>
        </div>
        
        <div class="form-floating mb-1">
          <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" minlength="8" required/>
          <label for="floatingPassword">Palavra-Passe</label>
        </div>
        <div class="form-text text-muted small mb-3 text-end">
            Mínimo de 8 caracteres.
        </div>

        <button class="btn btn-style2 w-100 py-2 fw-bold shadow-sm" type="submit">Realizar registo</button>
        
        <p class="mt-4 text-center text-body-secondary mb-0">
          Já tem conta? 
          <a href="login.php" class="fw-semibold text-decoration-none text-success">Faça login</a>
        </p>
        
      </form>

    </div>
  </div>
</main>
</body>
</html>