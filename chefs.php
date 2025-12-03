<?php 
session_start();
require('includes/connection.php');

// 1. Buscar todos os Chefs por ordem alfabética
$stmtChefs = $dbh->query("SELECT * FROM chefs ORDER BY nome ASC");
$lista_chefs = $stmtChefs->fetchAll(PDO::FETCH_ASSOC);

// Preparar ID do utilizador para os corações (Favoritos)
$id_utilizador_logado = 0;
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    $id_utilizador_logado = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Os nossos Chefs - Pitada na Mesa</title>
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
            <li class="breadcrumb-item active" aria-current="page">Os nossos Chefs</li>
        </ol>
    </div>

    <div class="container">
        <div class="fw-bold mb-5 mt-5 fs-4 text-start">Os nossos Chefs</div>

        <?php if (count($lista_chefs) > 0): ?>
            
            <?php foreach($lista_chefs as $chef): ?>
                <!-- BLOCO DO CHEF (Usa o ID para o link, ex: #chef-1) -->
                <div id="chef-<?php echo $chef['id']; ?>" class="mb-5 pb-4 border-bottom">
                    
                    <!-- PERFIL DO CHEF -->
                    <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                        <div class="mb-3 mb-md-0">
                            <?php 
                                // Verifica se a imagem existe na pasta
                                // Nota: Guarda as imagens dos chefs em "imgs/" ou "imgs/chefs/" e o caminho completo na BD
                                $imgChef = !empty($chef['imagem']) && file_exists($chef['imagem']) ? $chef['imagem'] : 'imgs/avatar/avpadrao.jpg';
                            ?>
                            <img src="<?php echo $imgChef; ?>" alt="<?php echo $chef['nome']; ?>" 
                                 class="rounded-circle shadow-sm" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 3px solid rgb(182, 125, 95); padding: 3px;">
                        </div>
                        
                        <div class="ms-md-4 text-center text-md-start">
                            <h2 class="fw-bold display-6" style="color: rgb(182, 125, 95);"><?php echo $chef['nome']; ?></h2>
                            <p class="text-muted mt-2" style="max-width: 800px;"><?php echo nl2br($chef['descricao']); ?></p>
                        </div>
                    </div>
                    
                    <!-- RECEITAS DESTE CHEF (Sub-Query) -->
                    <?php
                        // Buscar até 4 receitas deste chef específico
                        $sqlRec = "SELECT * FROM receitas WHERE id_chef = ? LIMIT 12";
                        $stmtRec = $dbh->prepare($sqlRec);
                        $stmtRec->execute([$chef['id']]);
                        $receitasChef = $stmtRec->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (count($receitasChef) > 0): ?>
                        <h4 class="fw-semibold mb-3 text-center text-md-start">Receitas de <?php echo $chef['nome']; ?></h4>
                        
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                            <?php foreach($receitasChef as $row): 
                                $id = $row['id'];
                                $nome = $row['titulo'];
                                $imagem = $row['imagem'];
                                $descricao = !empty($row['descricao']) ? $row['descricao'] : "Uma receita deliciosa.";
                                $referencia = "receita.php?id=" . $id;

                                // Verificar Favorito (Lógica ATIVA)
                                $e_favorito = false;
                                if ($id_utilizador_logado > 0) {
                                    $checkFav = $dbh->prepare("SELECT id FROM favoritos WHERE id_utilizador = ? AND id_receita = ? AND ativado = 1");
                                    $checkFav->execute([$id_utilizador_logado, $id]);
                                    if ($checkFav->rowCount() > 0) $e_favorito = true;
                                }
                                $classe_coracao = $e_favorito ? "text-danger" : "text-secondary";
                            ?>
                                <div class="col">
                                    <div class="card h-100 position-relative shadow-sm border-0">
                                        <div style="height: 200px; overflow: hidden;" class="rounded-top">
                                            <img src="<?php echo $imagem; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $nome; ?>">
                                        </div>

                                        <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                                onclick="toggleFavorito(this, <?= $id ?>, '<?= addslashes($nome) ?>', '<?= $imagem ?>', '<?= $referencia ?>')"
                                                aria-label="Adicionar aos favoritos">
                                            <i class="bi bi-heart-fill <?php echo $classe_coracao; ?>"></i>
                                        </button>

                                        <div class="card-body text-center d-flex flex-column">
                                            <h5 class="card-title fw-bold"><?php echo $nome; ?></h5>
                                            <p class="card-text text-truncate-2 small"><?php echo $descricao; ?></p>
                                            <a href="<?php echo $referencia; ?>" class="btn btn-style2 mt-auto">Abrir receita</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted fst-italic ms-1 text-center text-md-start">Este chef ainda não publicou receitas.</p>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <!-- Caso a tabela de chefs esteja vazia -->
            <div class="text-center py-5">
                <i class="bi bi-people display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Ainda não existem chefs registados.</p>
            </div>
        <?php endif; ?>

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

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT DE LIKES (Aponta para a pasta AJAX) -->
    <script>
      const isLogado = <?php echo (isset($_SESSION['logado']) && $_SESSION['logado'] === true) ? 'true' : 'false'; ?>;

      function toggleFavorito(btn, id, titulo, imagem, referencia) {
        
        if (!isLogado) {
            const modalElement = document.getElementById('modalLogin');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            return;
        }

        fetch('ajax/ajax_favorito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
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
            } else if (data.status === 'removido') {
                icon.classList.remove('text-danger');
                icon.classList.add('text-secondary'); 
            } else if (data.status === 'erro') {
                alert('Erro: ' + data.mensagem);
            }
        })
        .catch(error => console.error('Erro:', error));
      }
    </script>
</body>
</html>