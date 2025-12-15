<?php
session_start();
require('includes/connection.php');

// 1. Receber o tipo de categoria pelo URL
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// 2. Configuração: Mapear o URL para o Nome na Base de Dados
$mapa_categorias = [
    'carne' => [
        'bd'     => 'Receitas de carne', 
        'titulo' => 'Receitas de Carne'
    ],
    'peixe' => [
        'bd'     => 'Peixe', 
        'titulo' => 'Receitas de Peixe'
    ],
    'sobremesa' => [
        'bd'     => 'Sobremesa', 
        'titulo' => 'Sobremesas'
    ],
    'sopa' => [
        'bd'     => 'Sopas e Cremes', 
        'titulo' => 'Sopas e Cremes'
    ],
    'comunidade' => [
        'bd'     => 'Comunidade', 
        'titulo' => 'Comunidade'
    ]
];

// 3. Verificar se a categoria é válida
if (array_key_exists($tipo, $mapa_categorias)) {
    $cat_atual = $mapa_categorias[$tipo];
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $cat_atual['titulo']; ?> - Pitada na Mesa</title>
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
            <li class="breadcrumb-item active" aria-current="page"><?php echo $cat_atual['titulo']; ?></li>
        </ol>
    </div>

    <div class="container">
        <div class="fw-bold mb-4 mt-5 fs-4 text-start"><?php echo $cat_atual['titulo']; ?></div>

        <!-- 'align-items-stretch' garante que as colunas esticam -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-3 align-items-stretch">
            
            <?php
            // Preparar ID para verificar favoritos
            $id_utilizador_logado = 0;
            if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
                $id_utilizador_logado = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];
            }

            // 4. QUERY DINÂMICA COM JOIN PARA BUSCAR O CHEF
            $sql = "SELECT r.*, c.id as id_chef, c.nome as nome_chef, c.imagem as imagem_chef 
                    FROM receitas r 
                    LEFT JOIN chefs c ON r.id_chef = c.id 
                    WHERE r.categoria = ? AND r.estado = 1";
            
            $stmt = $dbh->prepare($sql);
            $stmt->execute([$cat_atual['bd']]);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $nome = $row['titulo'];
                    $imagem = $row['imagem'];
                    $descricao = !empty($row['descricao']) ? $row['descricao'] : "Uma receita deliciosa para experimentar.";

                    // Verificar Favorito (ATIVO)
                    $e_favorito = false;
                    if ($id_utilizador_logado > 0) {
                        $checkFav = $dbh->prepare("SELECT id FROM favoritos WHERE id_utilizador = ? AND id_receita = ? AND ativado = 1");
                        $checkFav->execute([$id_utilizador_logado, $id]);
                        if ($checkFav->rowCount() > 0) {
                            $e_favorito = true;
                        }
                    }
                    $classe_coracao = $e_favorito ? "text-danger" : "text-secondary";

                    // Verificar se tem chef para mostrar a bolinha
                    $temChef = !empty($row['id_chef']);
                    $imgChef = ($temChef && file_exists($row['imagem_chef'])) ? $row['imagem_chef'] : 'imgs/avatar/avpadrao.jpg';
            ?>
                    <div class="col">
                        <!-- ALTERAÇÃO AQUI: Mudei de 'h-1' para 'h-100' -->
                        <div class="card h-100 position-relative shadow-sm border-0">
                            
                            <!-- CÍRCULO DO CHEF -->
                            <?php if ($temChef): ?>
                                <a href="chefs.php#chef-<?php echo $row['id_chef']; ?>" 
                                   class="position-absolute top-0 start-0 m-2 rounded-circle shadow-sm border border-2 border-white overflow-hidden bg-white" 
                                   style="width: 45px; height: 45px; z-index: 10;"
                                   title="Receita do Chef <?php echo htmlspecialchars($row['nome_chef']); ?>">
                                    <img src="<?php echo $imgChef; ?>" class="w-100 h-100 object-fit-cover" alt="Chef">
                                </a>
                            <?php endif; ?>

                            <!-- IMAGEM -->
                            <div style="height: 200px; overflow: hidden;" class="rounded-top">
                                <img src="<?php echo $imagem; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $nome; ?>">
                            </div>

                            <!-- BOTÃO FAVORITO -->
                            <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm favorite-btn" 
                                    onclick="toggleFavorito(this, <?= $id ?>, '<?= addslashes($nome) ?>', '<?= $imagem ?>', 'receita.php?id=<?= $id ?>')">
                                <i class="bi bi-heart-fill <?php echo $classe_coracao; ?>"></i>
                            </button>

                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title fw-bold"><?php echo $nome; ?></h5>
                                <p class="card-text text-truncate-2"><?php echo $descricao; ?></p>
                                <a href="receita.php?id=<?php echo $id; ?>" class="btn btn-style2 mt-auto">Abrir receita</a>
                            </div>
                        </div>
                    </div>
            <?php
                } 
            } else {
                echo '<div class="col-12 text-center py-5 text-muted">';
                echo '<i class="bi bi-journal-x display-1 opacity-25"></i>';
                echo '<p class="mt-3">Ainda não existem receitas de ' . strtolower($cat_atual['titulo']) . '.</p>';
                echo '</div>';
            }
            ?>

        </div>
    </div>

    <!-- MODAL DE LOGIN -->
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
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