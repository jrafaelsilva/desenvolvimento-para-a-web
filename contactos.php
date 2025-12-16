<?php
session_start();
require('includes/connection.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contactos - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php require('includes/nav.php'); ?>

    <div class="ms-3 mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contactos</li>
        </ol>
    </div>

    <div class="container my-5">
        
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5" style="color: rgb(182, 125, 95);">Contacte-nos</h1>
            <p class="lead text-muted">Tem dúvidas ou sugestões? Estamos aqui para ajudar!</p>
        </div>

        <div class="row justify-content-center g-4">
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light">
                    <div class="mb-3 text-success">
                        <i class="bi bi-envelope-paper display-4"></i>
                    </div>
                    <h4 class="fw-bold">Email</h4>
                    <p class="text-muted">Para parcerias ou questões:</p>
                    <a href="mailto:geral@pitadanamesa.pt" class="btn btn-outline-success rounded-pill px-4">geral@pitadanamesa.pt</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-people display-4"></i>
                    </div>
                    <h4 class="fw-bold">Redes Sociais</h4>
                    <p class="text-muted">Segue-nos e partilha as tuas receitas:</p>
                    <div class="d-flex justify-content-center gap-3 fs-4">
                        <a href="#" class="text-dark text-decoration-none hover-scale"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-dark text-decoration-none hover-scale"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-dark text-decoration-none hover-scale"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-light">
                    <div class="mb-3 text-danger">
                        <i class="bi bi-geo-alt display-4"></i>
                    </div>
                    <h4 class="fw-bold">Onde Estamos</h4>
                    <p class="text-muted mb-1">Coimbra, Portugal</p>
                    <small class="text-muted">Disponíveis online 24/7 para ti.</small>
                </div>
            </div>

        </div>

    </div>

    <?php require('includes/footer.php'); ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    
</body>
</html>