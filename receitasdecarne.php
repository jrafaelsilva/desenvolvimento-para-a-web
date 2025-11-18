<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receitas de carne</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php 
    require('includes/nav.php');
    ?>


  <div class="ms-3 mt-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Receitas de carne</li>
    </ol>
</div>

   <div class="container">
    <div class="fw-bold mb-4 mt-5 fs-4 text-start">Receitas de carne</div>

    <div class="row align-items-start mt-5">
      <div class="col mb-3">
        <div class="card" >
          <img src="imgs/picanha.jpg" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Picanha grelhada</h5>
            <p class="card-text">Deliciosa receita que combina o suculento sabor da picanha... </p>
            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>

      <div class="col mb-3">
        <div class="card" >
          <img src="imgs/bolonhesa.jpg" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolonhesa</h5>
            <p class="card-text">Deliciosa receita que combina o suculento sabor da picanha... </p>
            <a href="bolonhesa.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>
            <div class="col mb-3">
        <div class="card" >
          <img src="imgs/bolonhesa.jpg" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolonhesa</h5>
            <p class="card-text">Deliciosa receita que combina o suculento sabor da picanha... </p>
            <a href="bolonhesa.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>
            <div class="col mb-3">
        <div class="card" >
          <img src="imgs/bolonhesa.jpg" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolonhesa</h5>
            <p class="card-text">Deliciosa receita que combina o suculento sabor da picanha... </p>
            <a href="bolonhesa.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>

    </div>
  </div>
    


  <footer class="text-center text-lg-start mt-5" style="background-color: rgb(245, 240, 214); color: rgb(51, 51, 51);">
  <div class="container p-4">
    <div class="row">
      <!-- Sobre -->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Pitada na Mesa</h5>
        <p>
          Partilhamos receitas simples, saborosas e cheias de amor.
          Da cozinha tradicional às novas tendências gastronómicas,
          inspira-te e traz mais sabor ao teu dia!
        </p>
      </div>

      <!-- Links úteis -->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Links úteis</h5>
        <ul class="list-unstyled mb-0">
          <li><a href="#" class="text-decoration-none text-dark">Página Inicial</a></li>
          <li><a href="#" class="text-decoration-none text-dark">Contactos</a></li>
        </ul>
      </div>

      <!-- Redes sociais -->
      <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-start">
        <h5 class="fw-bold mb-3">Segue-nos</h5>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/_.diogo11._" class="text-dark me-3 fs-4"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-youtube"></i></a>
        <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-pinterest"></i></a>
      </div>
    </div>
  </div>

    <!-- Direitos -->
    <div class="text-center p-3" style="background-color: rgb(236, 230, 198);">
    © 2025 Pitada na Mesa — Todos os direitos reservados.
    </div>
  </footer>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
