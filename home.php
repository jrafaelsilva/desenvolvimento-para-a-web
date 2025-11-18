<?php session_start(); 
require 'includes/connection.php'; 
?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pitada na Mesa</title>  
    <link rel="shortcut icon" href="imgs/pitada.logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
 <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgb(245, 240, 214);">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="imgs/pitada.logo.png" alt="Logótipo" width="100" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-start" id="navbarSupportedContent">
            
            <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 me-4"> 
                
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Receitas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="receitasdecarne.php">Carne</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="receitasdepeixe.php">Peixe</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="receitasdesobremesa.php">Sobremesa</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="receitasdesopas.php">Sopas e Cremes</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link active fs-5 ms-3" href="#">Minhas Receitas</a></li>
            </ul>

            <form class="d-flex align-items-center position-relative me-lg-3 my-2 my-lg-0 w-100 w-lg-auto align-self-lg-center" role="search" style="max-width: 250px;">
                <i class="bi bi-search position-absolute ms-2 text-dark"></i>
                <input 
                    class="form-control ps-5 border-0 shadow-sm" type="search" 
                    placeholder="Pesquise por receitas ..." 
                    aria-label="Search" 
                    style="border-radius: 50px; background-color: rgba(229, 223, 194, 1);" />
            </form>
            
            <ul class="navbar-nav">
    <li class="nav-item dropdown d-flex align-items-center align-self-lg-center"> 
        <a class="nav-link p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-3"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>

              

                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Terminar Sessão</a></li>
            
            <?php else: ?>
                
                <li><a class="dropdown-item" href="login.php">Login</a></li>
                <li><a class="dropdown-item" href="registo.php">Registar</a></li>
            
            <?php endif; ?>

        </ul>
    </li>
</ul>
        </div>
    </div>
</nav>
    <div class="container">
      <img src="imgs/banner.jpeg" class="banner" alt="Banner Pitada na Mesa">
    </div>

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

    <div class="container mt-5 ">
      <div class="d-flex justify-content-between mb-5">
        <div class="fw-bold fs-4 text-start">Conheça os nossos Chefs</div>
        <a href="chefs.php" class=" fw-semibold cor-vertudo">
          Ver tudo <i class="bi bi-chevron-right ms-1"></i>
        </a>
      </div>

      <div class="row row-cols-2 row-cols-lg-4 g-4">
        <div class="col">
          <a href="chefs.php#chef-carlos" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Carlos.Afonos.webp" alt="Carlos Afonso" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Carlos Afonso</p>
          </a>
        </div>

        <div class="col">
          <a href="chefs.php#chef-margarida" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Margarita.Pugovka.webp" alt="Margarita Pugovka" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Margarita Pugovka</p>
          </a>
        </div>

        <div class="col">
          <a href="chefs.php#chef-miguel" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Miguel.Mesquita.webp" alt="Miguel Mesquita" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Miguel Mesquita</p>
          </a>
        </div>

        <div class="col">
          <a href="chefs.php#chef-henrique" class="text-decoration-none text-dark d-block text-center">
            <div class="chef-wrapper mx-auto">
              <img src="imgs/Henrique.Sá.Pes.webp" alt="Henrique Sá Pessoa" class="img-fluid rounded-circle">
            </div>
            <p class="mt-3 fw-semibold fs-5">Henrique Sá Pessoa</p>
          </a>
        </div>
      </div>
    </div>

    <div class="container text-center mt-5 mb-5">
      <h2 class="mb-4">As receitas dos nossos utilizadores!</h2>
      <p class="text-muted mb-5">Descobre as criações deliciosas dos nossos visitantes 🍰</p>
    </div>

    <div class="d-flex justify-content-center">
      <div id="carouselExampleInterval" class="carousel slide carousel-fade w-100 w-lg-60 carrossel-responsivo" 
           data-bs-ride="carousel" data-bs-touch="true">

        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="2000">
            <img src="imgs/bolo.morango.webp" class="d-block w-100 carousel-img-fixed rounded-3" alt="bolo de ananas">
            <div class="carousel-caption">
            <div class="caixa-texto">
              <h5>Bolo de cenoura</h5>
              <p>confecionado pela Odete Soares</p>
            </div>
          </div>
          </div>

          <div class="carousel-item" data-bs-interval="2000">
            <img src="imgs/receitadeuti.jpg" class="d-block w-100 carousel-img-fixed rounded-3" alt="picanha">
            <div class="carousel-caption">
              <div class="caixa-texto">
              <h5>Picanha</h5>
              <p>confecionada pelo Joaquim Pereira</p>
            </div>
          </div>
          </div>

          <div class="carousel-item" data-bs-interval="2000">
            <img src="imgs/cenoura-uti.jpg" class="d-block w-100 carousel-img-fixed rounded-3" alt="bolo de cenoura">
            <div class="carousel-caption">
            <div class="caixa-texto">
              <h5>Bolo de cenoura</h5>
              <p>confecionado pela Odete Soares</p>
            </div>
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

  <div class="container-fluid" >
    <div class="container text-center py-5 my-4">
        <h2 class="fw-bold mb-3">Tem uma receita que o mundo precisa de conhecer?</h2>
        <p class="lead text-muted mb-4">
            Partilhe a sua obra-prima com a nossa comunidade e veja-a em destaque no nosso site!
        </p>
        
        <a href="submeter-receita.php" class="btn btn-style2 btn-lg">
            <i class="bi bi-upload me-2"></i>Enviar a minha receita
        </a>
    </div>
</div>
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
