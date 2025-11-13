<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pitada na Mesa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <?php
      require('includes/connection.php');
      require('includes/nav.php');
    ?>

    <!-- Banner principal -->
    <div class="container">
      <img src="imgs/banner.jpeg" class="banner" alt="Banner Pitada na Mesa">
    </div>

    <!-- Receitas em destaque -->
    <div class="container">
      <div class="fw-bold mt-5 fs-4 text-start">Receitas em destaque</div>

      <div class="row align-items-stretch mt-3 g-4 row-cols-1 row-cols-sm-2 row-cols-lg-4">
        <?php
          $stmt = $dbh->prepare("SELECT * FROM receitasdestaque");
          $stmt->execute();

          if ($stmt && $stmt->rowCount() > 0) {
            while ($receitasdestaque = $stmt->fetchObject()) {
              $id         = $receitasdestaque->id;
              $nome       = $receitasdestaque->nome;
              $descricao  = $receitasdestaque->descricao;
              $imagem     = $receitasdestaque->imagem;
              $referencia = $receitasdestaque->referencia;
        ?>
              <div class="col">
                <div class="card h-100 position-relative">
                  <img src="<?= $imagem ?>" class="card-img-top" alt="nome <?= $id ?>">

                  <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                          aria-label="Adicionar aos favoritos">
                    <i class="bi bi-heart-fill"></i>
                  </button>

                  <div class="card-body text-center">
                    <h5 class="card-title"><?= $nome ?></h5>
                    <p class="card-text text-truncate-2"><?= $descricao ?></p>
                    <a href="<?= $referencia ?>" class="btn btn-style2">Abrir receita</a>
                  </div>
                </div>
              </div>
        <?php
            } // while
          } // if
        ?>
      </div>
    </div>

    <!-- Secção dos Chefs -->
    <div class="container mt-5 my-4">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="fw-bold fs-4 text-start">Conheça os nossos Chefs</div>
        <a href="#" class="text-decoration-none fw-semibold">
          Ver tudo <i class="bi bi-chevron-right ms-1"></i>
        </a>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        <div class="col">
          <a href="chef-carlos-afonso.php" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Carlos.Afonos.webp" alt="Carlos Afonso" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Carlos Afonso</p>
          </a>
        </div>

        <div class="col">
          <a href="chef-margarita.php" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Margarita.Pugovka.webp" alt="Margarita Pugovka" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Margarita Pugovka</p>
          </a>
        </div>

        <div class="col">
          <a href="chef-miguel-mesquita.php" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Miguel.Mesquita.webp" alt="Miguel Mesquita" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Miguel Mesquita</p>
          </a>
        </div>

        <div class="col">
          <a href="chef-henrique.php" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Henrique.Sá.Pes.webp" alt="Henrique Sá Pes" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Henrique Sá Pes</p>
          </a>
        </div>
      </div>
    </div>

    <!-- Carrossel de receitas de utilizadores -->
    <div class="container text-center mt-5 mb-5">
      <h2 class="mb-4">As receitas dos nossos utilizadores!</h2>
      <p class="text-muted mb-5">Descobre as criações deliciosas dos nossos visitantes 🍰</p>
    </div>

    <div class="d-flex justify-content-center">
      <div id="carouselExampleInterval" class="carousel slide w-100 w-lg-60 carrossel-responsivo" 
           data-bs-ride="carousel" data-bs-touch="true">

        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="2000">
            <img src="imgs/bolo.morango.webp" class="d-block w-100 carousel-img-fixed rounded-3" alt="bolo de ananas">
          </div>

          <div class="carousel-item" data-bs-interval="2000">
            <img src="imgs/receitadeuti.jpg" class="d-block w-100 carousel-img-fixed rounded-3" alt="picanha">
            <div class="carousel-caption d-none d-md-block">
              <h5>Picanha</h5>
              <p>confecionada pelo Joaquim Pereira</p>
            </div>
          </div>

          <div class="carousel-item" data-bs-interval="2000">
            <img src="imgs/receitadeuti2.webp" class="d-block w-100 carousel-img-fixed rounded-3" alt="bolo de cenoura">
            <div class="carousel-caption d-none d-md-block">
              <h5>Bolo de cenoura</h5>
              <p>confecionado pela Odete Soares</p>
            </div>
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Seguinte</span>
        </button>
      </div>
    </div>

    <!-- Script dos favoritos -->
    <script>
      document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          btn.classList.toggle('active');
        });
      });
    </script>

    <?php
      require('includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
