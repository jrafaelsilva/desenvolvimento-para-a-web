<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receitas de sobremesas</title>
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
      <li class="breadcrumb-item active" aria-current="page">Receitas de sobremesas</li>
    </ol>
</div>


  <div class="container">
    <div class="fw-bold mb-4 mt-5 fs-4 text-start">Receitas de sobremesas</div>

    <div class="row align-items-start mt-5">
      <div class="col mb-3">
        <div class="card">
          <img src="imgs/bolo.morango.webp" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolo de morango</h5>
            <p class="card-text">Deliciosa receita que combina o sabor magnífico do morango com...</p>
            <a href="bolodemorango.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>

      <div class="col mb-3">
        <div class="card">
          <img src="imgs/bolo.morango.webp" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolo de morango</h5>
            <p class="card-text">Deliciosa receita que combina o sabor magnífico do morango com...</p>
            <a href="bolodemorango.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>

      <div class="col mb-3">
        <div class="card">
          <img src="imgs/bolo.morango.webp" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolo de morango</h5>
            <p class="card-text">Deliciosa receita que combina o sabor magnífico do morango com...</p>
            <a href="bolodemorango.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>

      <div class="col mb-3">
        <div class="card">
          <img src="imgs/bolo.morango.webp" class="card-img-top" alt="...">
          <button class="btn btn-light position-absolute bottom-1 end-0 m-2 rounded-circle shadow-sm favorite-btn">
            <i class="bi bi-heart-fill"></i>
          </button>
          <div class="card-body text-center">
            <h5 class="card-title ">Bolo de morango</h5>
            <p class="card-text">Deliciosa receita que combina o sabor magnífico do morango com...</p>
            <a href="bolodemorango.php" class="btn btn-style2">Abrir receita</a>
          </div>
        </div>
      </div>
    </div>
  </div>


    <?php
      require('includes/footer.php');
    ?>
    
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
