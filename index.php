<?php
session_start();
require('includes/connection.php');
?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pitada na Mesa</title>  
    <link rel="shortcut icon" href="imgs/pitada.logo.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <?php require('includes/nav.php'); ?>

    <div class="container">
      <img src="imgs/banner.jpeg" class="banner" alt="Banner Pitada na Mesa">
    </div>

    <div class="container">
      <div class="fw-bold mt-5 fs-4 text-start">Receitas em Destaque</div>

      <div class="row align-items-stretch mt-3 g-4 row-cols-1 row-cols-sm-2 row-cols-lg-4">
        <?php
          // 1. Preparar ID do utilizador
          $id_utilizador_logado = 0;
          if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
              $id_utilizador_logado = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];
          }

          // 2. QUERY DINÂMICA
          // ALTERAÇÃO: Adicionado o JOIN com a tabela CHEFS para buscar a imagem e nome
          $sql = "SELECT r.*, c.id as id_chef, c.nome as nome_chef, c.imagem as imagem_chef, COUNT(f.id) as total_likes 
                  FROM receitas r 
                  LEFT JOIN chefs c ON r.id_chef = c.id 
                  LEFT JOIN favoritos f ON r.id = f.id_receita AND f.ativado = 1
                  GROUP BY r.id 
                  ORDER BY total_likes DESC, r.id DESC 
                  LIMIT 8";
          
          $stmt = $dbh->prepare($sql);
          $stmt->execute();

          if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $id         = $row['id'];
              $nome       = $row['titulo'];
              $imagem     = $row['imagem'];
              $descricao  = !empty($row['descricao']) ? $row['descricao'] : "Uma receita deliciosa da Pitada na Mesa.";
              
              $referencia = "receita.php?id=" . $id;

              // Verificar Favorito
              $e_favorito = false;
              if ($id_utilizador_logado > 0) {
                  $checkFav = $dbh->prepare("SELECT id FROM favoritos WHERE id_utilizador = ? AND id_receita = ? AND ativado = 1");
                  $checkFav->execute([$id_utilizador_logado, $id]);
                  if ($checkFav->rowCount() > 0) {
                      $e_favorito = true;
                  }
              }
              $classe_coracao = $e_favorito ? "text-danger" : "text-secondary";

              // ALTERAÇÃO: Verificar se tem chef para mostrar a bolinha
              $temChef = !empty($row['id_chef']);
              $imgChef = ($temChef && file_exists($row['imagem_chef'])) ? $row['imagem_chef'] : 'imgs/avatar/avpadrao.jpg';
        ?>
              <div class="col">
                <div class="card h-100 position-relative border-0 shadow-sm">
                  
                  <!-- ALTERAÇÃO: CÍRCULO DO CHEF (Canto Superior Esquerdo) -->
                  <?php if ($temChef): ?>
                      <a href="chefs.php#chef-<?php echo $row['id_chef']; ?>" 
                         class="position-absolute top-0 start-0 m-2 rounded-circle shadow-sm border border-2 border-white overflow-hidden bg-white" 
                         style="width: 45px; height: 45px; z-index: 10;"
                         title="Receita do Chef <?php echo htmlspecialchars($row['nome_chef']); ?>">
                          <img src="<?php echo $imgChef; ?>" class="w-100 h-100 object-fit-cover" alt="Chef">
                      </a>
                  <?php endif; ?>

                  <div style="height: 200px; overflow: hidden;" class="rounded-top">
                    <img src="<?= $imagem ?>" class="w-100 h-100 object-fit-cover" alt="<?= $nome ?>">
                  </div>

                  <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                          onclick="toggleFavorito(this, <?= $id ?>, '<?= addslashes($nome) ?>', '<?= $imagem ?>', '<?= $referencia ?>')"
                          aria-label="Adicionar aos favoritos">
                    <i class="bi bi-heart-fill <?= $classe_coracao ?>"></i>
                  </button>

                  <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title fw-bold"><?= $nome ?></h5>
                    
                    <div class="mb-2 small text-muted">
                      <i class="bi bi-heart-fill text-danger"></i> 
                      <span id="likes-texto-<?= $id ?>">
                        <?php 
                            if ($row['total_likes'] == 1) {
                                echo "1 pessoa gostou";
                            } else {
                                echo $row['total_likes'] . " pessoas gostaram";
                            }
                        ?>        
                      </span>            
                    </div>

                    <p class="card-text text-truncate-2"><?= $descricao ?></p>
                    <a href="<?= $referencia ?>" class="btn btn-style2 mt-auto">Abrir receita</a>
                  </div>
                </div>
              </div>
        <?php
            } // while
          } // if
        ?>
      </div>
    </div>
        <!-- secção dos chefs -->
      <div class="container mt-5 ">
      <div class="d-flex justify-content-between mb-5">
        <div class="fw-bold fs-4 text-start">Conheça os nossos Chefs</div>
        <a href="chefs.php" class=" fw-semibold cor-vertudo">
          Ver tudo <i class="bi bi-chevron-right ms-1"></i>
        </a>
      </div>

      <div class="row row-cols-2 row-cols-lg-4 g-4">
        <?php
            // 1. Buscar apenas os 4 primeiros chefs para o index
            $stmtChefsHome = $dbh->query("SELECT id, nome, imagem FROM chefs LIMIT 4");
            
            while($chef = $stmtChefsHome->fetch(PDO::FETCH_ASSOC)):
                // Fallback para a imagem
                $imgChef = !empty($chef['imagem']) && file_exists($chef['imagem']) ? $chef['imagem'] : 'imgs/avatar/avpadrao.jpg';
                // Link com âncora para a página de detalhes (chefs.php#chef-1)
                $linkChef = "chefs.php#chef-" . $chef['id'];
        ?>
            <div class="col">
              <a href="<?php echo $linkChef; ?>" class="text-decoration-none text-dark d-block text-center">
                <div class="chef-wrapper mx-auto">
                  <img src="<?php echo $imgChef; ?>" alt="<?php echo $chef['nome']; ?>" class="img-fluid rounded-circle" >
                </div>
                <p class="mt-3 fw-semibold fs-5"><?php echo $chef['nome']; ?></p>
              </a>
            </div>
        <?php endwhile; ?>
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
            <img src="imgs/sobremesa/bolo.morango.webp" class="d-block w-100 carousel-img-fixed rounded-3" alt="bolo de ananas">
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

<!-- MODAL DE LOGIN -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow border-0">
      
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center py-4">
        <div class="mb-3">
            <span class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-block">
                <i class="bi bi-person-lock fs-1"></i>
            </span>
        </div>
        <h5 class="fw-bold mb-2">Login Necessário</h5>
        <p class="text-muted px-4">Para adicionar esta receita aos teus favoritos, precisas de entrar na tua conta primeiro.</p>
      </div>

      <div class="modal-footer border-0 justify-content-center pb-4">
        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
        <a href="login.php" class="btn btn-success rounded-pill px-4">Fazer Login</a>
      </div>

    </div>
  </div>
</div>

    <script>
    const isLogado = <?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] === true) ? 'true' : 'false'; ?>;

    function atualizarLikes(idReceita) {
        fetch("ajax/contar_likes.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: idReceita })
        })
        .then(response => response.json())
        .then(data => {
            const elementoTexto = document.getElementById('likes-texto-' + idReceita);
            if (elementoTexto) {
                let textoFinal = "";
                if (data.total == 1) {
                    textoFinal = "1 pessoa gostou";
                } else {
                    textoFinal = data.total + " pessoas gostaram";
                }
                elementoTexto.innerText = textoFinal;
            }
        })
        .catch(err => console.error("Erro ao atualizar likes:", err));
    }

    function toggleFavorito(btn, id, titulo, imagem, referencia) {
        
        if (!isLogado) {
            const modalElement = document.getElementById('modalLogin');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            return;
        }

        fetch('ajax/ajax_favorito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_receita: id,
                titulo: titulo,
                imagem: imagem,
                referencia: referencia
            })
        })
        .then(response => response.json())
        .then(data => {
            const icon = btn.querySelector('i');
            
            if (data.status === 'adicionado') {
                icon.classList.remove('text-secondary');
                icon.classList.add('text-danger');
                atualizarLikes(id); 

            } else if (data.status === 'removido') {
                icon.classList.remove('text-danger');
                icon.classList.add('text-secondary');
                atualizarLikes(id);

            } else if (data.status === 'erro') {
                alert("Erro: " + data.mensagem);
            }
        })
        .catch(error => console.error('Erro:', error));
    }
</script>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>