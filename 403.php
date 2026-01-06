<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro 403 - Acesso Negado</title>
    <link rel="shortcut icon" href="imgs/pitada.logo.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-4">
    
    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 text-center" style="max-width: 550px; width: 100%;">
        
        <div class="fw-bold text-danger mb-2 user-select-none fs-1">
            403
        </div>
        
        <h1 class="fw-bold text-dark mt-2 mb-3">
            Acesso Negado
        </h1>
        
        <p class="lead text-secondary mb-5 fs-6">
            Lamentamos, mas não tem permissão para aceder a esta página. 
            Esta área é restrita a utilizadores autenticados ou com privilégios.
        </p>
        
        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
            
            <a href="auth/login.php" class="btn btn-primary btn-lg px-4 fw-semibold shadow-sm">
                Fazer Login
            </a>
            
            <a href="index.php" class="btn btn-light btn-lg px-4 fw-semibold border shadow-sm">
                Ir para a Página Inicial
            </a>
            
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>