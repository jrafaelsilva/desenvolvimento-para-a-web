<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Os nossos Chefs - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php 
        // Inclui a barra de navegação
        require('includes/nav.php');
    ?>

    <!-- Breadcrumb -->
    <div class="ms-3 mt-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Os nossos Chefs</li>
        </ol>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <div class="fw-bold mb-5 mt-5 fs-4 text-start">Os nossos Chefs</div>

        <!-- Chef 1: Carlos Afonso -->
        <div id="chef-carlos" class="mb-5">
            <!-- Info do Chef: Stacks on mobile, side-by-side on desktop -->
            <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                
                <!-- Imagem: Reutiliza o estilo de borda do index.php -->
                <div class="mb-3 mb-md-0">
                    <img src="imgs/Carlos.Afonos.webp" alt="Carlos Afonso" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid rgb(182, 125, 95); box-shadow: inset 0 0 0 5px rgb(243, 226, 212);">
                </div>
                
                <!-- Texto: Alinha ao centro no mobile, à esquerda no desktop -->
                <div class="ms-md-4 text-center text-md-start">
                    <h2 class="fw-bold">Carlos Afonso</h2>
                    <p class="text-muted">O Chef Carlos Afonso é uma referência na cozinha de mar em Portugal, conhecido pela sua paixão por ostras e produtos frescos. É o rosto do aclamado "Ostras & Coisas" em Lisboa, onde celebra os sabores autênticos. A sua cozinha é uma fusão de tradição e criatividade com o melhor produto nacional.</p>
                </div>
            </div>
            
            <!-- Receitas do Chef -->
            <h4 class="fw-semibold mb-3 text-center text-md-start">Receitas do Chef Carlos</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                
                <!-- Card de Receita 1 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
                
                <!-- Card de Receita 2 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Receita 3 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Receita 4 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-5"> <!-- Separador -->

        <!-- Chef 2: Margarita Pugovka -->
        <div id="chef-margarida" class="mb-5">
            <!-- Info do Chef -->
            <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                <div class="mb-3 mb-md-0">
                    <img src="imgs/Margarita.Pugovka.webp" alt="Margarita Pugovka" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid rgb(182, 125, 95); box-shadow: inset 0 0 0 5px rgb(243, 226, 212);">
                </div>
                <div class="ms-md-4 text-center text-md-start">
                    <h2 class="fw-bold">Margarita Pugovka</h2>
                    <p class="text-muted">Margarita Pugovka é uma aclamada chef de pastelaria de origem letã, mas com uma forte presença em Portugal. Ganhou notoriedade após a sua passagem pela "Ladurée" e tornou-se um fenómeno digital com as suas criações elegantes. É especialista em sobremesas que combinam técnica francesa com um toque moderno.</p>
                </div>
            </div>
            
            <!-- Receitas do Chef -->
            <h4 class="fw-semibold mb-3 text-center text-md-start">Receitas da Chef Margarita</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <!-- Card de Receita 1 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Receita 2 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Receita 3 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Receita 4 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5"> <!-- Separador -->

        <!-- Chef 3: Miguel Mesquita (Mockup) -->
        <div id="chef-miguel" class="mb-5">
            <!-- Info do Chef -->
            <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                <div class="mb-3 mb-md-0">
                    <img src="imgs/Miguel.Mesquita.webp" alt="Miguel Mesquita" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid rgb(182, 125, 95); box-shadow: inset 0 0 0 5px rgb(243, 226, 212);">
                </div>
                <div class="ms-md-4 text-center text-md-start">
                    <h2 class="fw-bold">Miguel Mesquita</h2>
                    <p class="text-muted">O Chef Miguel Mesquita é conhecido por transformar a cozinha de conforto em experiências gastronómicas de luxo. Ganhou destaque na "Cantina de Ventozelo", no Douro, onde aposta em produtos locais. A sua filosofia foca-se na sazonalidade e no respeito pelo ingrediente, reinventando receitas tradicionais.</p>
                </div>
            </div>
    
            <h4 class="fw-semibold mb-3 text-center text-md-start">Receitas do Chef Miguel</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5"> 


        <div id="chef-henrique" class="mb-5">
            <!-- Info do Chef -->
            <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                <div class="mb-3 mb-md-0">
                    <img src="imgs/Henrique.Sá.Pes.webp" alt="Henrique Sá Pes" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid rgb(182, 125, 95); box-shadow: inset 0 0 0 5px rgb(243, 226, 212);">
                </div>
                <div class="ms-md-4 text-center text-md-start">
                    <h2 class="fw-bold">Henrique Sá Pessoa</h2>
                    <p class="text-muted">Um dos chefs portugueses mais conceituados, Henrique Sá Pessoa é a mente criativa por trás do "Alma", galardoado com duas estrelas Michelin. A sua carreira é marcada pela excelência técnica e uma cozinha de autor inovadora. É também o cérebro por trás de projetos de sucesso como o "Tapisco".</p>
                </div>
            </div>
            <!-- Grelha de receitas adicionada -->
            <h4 class="fw-semibold mb-3 text-center text-md-start">Receitas do Chef Henrique</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <!-- Card 1 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col">
                    <div class="card h-100 position-relative">
                        <img src="imgs/picanha.jpg" class="card-img-top" alt="Picanha Grelhada">
                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                aria-label="Adicionar aos favoritos">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                        <div class="card-body text-center">
                            <h5 class="card-title">Picanha Grelhada</h5>
                            <p class="card-text text-truncate-2">A picanha perfeita, suculenta e com um toque especial do chef.</p>
                            <a href="picanha.php" class="btn btn-style2">Abrir receita</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Script dos favoritos (copiado do index.php) -->
    <script>
      document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          btn.classList.toggle('active');
        });
      });
    </script>

    <?php 
        // Inclui o footer
        require('includes/footer.php');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>