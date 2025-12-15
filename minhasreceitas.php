<?php
session_start();
require('includes/connection.php');

// 1. Verificar se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

// 2. Definir o ID do utilizador
$id_utilizador = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id'];

// 3. BUSCAR FAVORITOS (Query 1 - Com verificação de estado)
// ALTERAÇÃO: JOIN com receitas para garantir que r.estado = 1
$sqlFav = "SELECT f.* FROM favoritos f
           JOIN receitas r ON f.id_receita = r.id
           WHERE f.id_utilizador = ? 
             AND f.ativado = 1 
             AND r.estado = 1 
           ORDER BY f.id DESC";

$stmtFav = $dbh->prepare($sqlFav);
$stmtFav->execute([$id_utilizador]);
$meus_favoritos = $stmtFav->fetchAll(PDO::FETCH_ASSOC);

// 4. BUSCAR SUBMISSÕES (Query 2 - Receitas criadas por este utilizador)
$stmtSub = $dbh->prepare("SELECT * FROM receitas WHERE id_utilizador = ? AND estado = 1 ORDER BY id DESC");
$stmtSub->execute([$id_utilizador]);
$minhas_submissoes = $stmtSub->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minhas Receitas - Pitada na Mesa</title>
    <link rel="shortcut icon" href="imgs/pitada.logo.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php require('includes/nav.php'); ?>

    <div class="container" style="margin-top: 100px; margin-bottom: 80px;">
        
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5" style="color: rgb(182, 125, 95);">O meu Livro de Receitas</h1>
            <p class="lead text-muted">Gere os teus favoritos e as tuas próprias criações.</p>
        </div>

        <!-- ================================================= -->
        <!-- SECÇÃO 1: FAVORITOS -->
        <!-- ================================================= -->
        <div class="mb-4 border-bottom pb-2 d-flex align-items-center">
            <h3 class="fw-bold m-0">
                <i class="bi bi-heart-fill me-2 text-danger"></i>Meus Favoritos
            </h3>
            <span class="badge bg-secondary ms-2 rounded-pill"><?php echo count($meus_favoritos); ?></span>
        </div>

        <?php if (count($meus_favoritos) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="listaFavoritos">
                <?php foreach ($meus_favoritos as $fav): ?>
                    <div class="col" id="fav-card-<?php echo $fav['id_receita']; ?>">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                            
                            <!-- Botão remover favorito -->
                            <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-sm text-danger" 
                                    title="Remover dos favoritos"
                                    onclick="removerFavorito(this, <?= $fav['id_receita'] ?>, '<?= addslashes($fav['titulo_receita']) ?>', '<?= $fav['imagem_receita'] ?>', '<?= $fav['referencia'] ?>')">
                                <i class="bi bi-heart-fill"></i>
                            </button>

                            <div style="height: 200px; overflow: hidden;">
                                <img src="<?php echo file_exists($fav['imagem_receita']) ? $fav['imagem_receita'] : 'imgs/banner.jpeg'; ?>" 
                                     class="w-100 h-100 object-fit-cover" alt="Favorito">
                            </div>
                            
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold"><?php echo $fav['titulo_receita']; ?></h5>
                            </div>
                            
                            <div class="card-footer bg-transparent border-top-0 pb-3">
                                <!-- BOTÃO PADRÃO -->
                                <a href="<?php echo $fav['referencia']; ?>" class="btn btn-style2 w-100">Cozinhar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-4 bg-light rounded-4 border border-dashed text-muted mb-5">
                <p class="mb-2">Ainda não guardaste nenhuma receita.</p>
                <a href="index.php" class="text-success text-decoration-none fw-bold">Explorar Receitas &rarr;</a>
            </div>
        <?php endif; ?>


        <!-- Espaçamento -->
        <div class="my-5"></div>


        <!-- ================================================= -->
        <!-- SECÇÃO 2: MINHAS SUBMISSÕES -->
        <!-- ================================================= -->
        <div class="mb-4 border-bottom pb-2 d-flex justify-content-between align-items-center">
            <h3 class="fw-bold m-0">
                <i class="bi bi-journal-text me-2 text-warning"></i>Minhas Contribuições
            </h3>
            <a href="submeterreceita.php" class="btn btn-sm btn-success rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i>Nova Receita
            </a>
        </div>

        <?php if (count($minhas_submissoes) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <?php foreach ($minhas_submissoes as $rec): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            
                            <div style="height: 200px; overflow: hidden; position: relative;">
                                <img src="<?php echo $rec['imagem']; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $rec['titulo']; ?>">
                                <!-- Badge "Minha" -->
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success shadow-sm">Minha Receita</span>
                            </div>
                            
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold"><?php echo $rec['titulo']; ?></h5>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-clock me-1"></i><?php echo $rec['tempo_preparo']; ?> min
                                </p>
                            </div>
                            
                            <div class="card-footer bg-transparent border-top-0 pb-3">
                                <!-- BOTÃO ATUALIZADO: Agora igual ao de cima (btn-style2 w-100) -->
                                <a href="receita.php?id=<?php echo $rec['id']; ?>" class="btn btn-style2 w-100">Ver Receita</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            
            <!-- Estado Vazio para Submissões -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
                <i class="bi bi-egg-fried display-1 text-warning opacity-50"></i>
                <h4 class="mt-3 text-muted">Ainda não partilhaste nenhuma receita.</h4>
                <p class="mb-4">Mostra os teus dotes culinários à comunidade!</p>
                <a href="submeterreceita.php" class="btn btn-style2 btn-lg">Enviar a minha primeira receita</a>
            </div>

        <?php endif; ?>

    </div>

    <!-- MODAL DE CONFIRMAÇÃO DE REMOÇÃO -->
    <div class="modal fade" id="modalRemover" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
          
          <div class="modal-body text-center py-4">
            <div class="mb-3">
                <span class="bg-danger bg-opacity-10 text-danger rounded-circle p-3 d-inline-block">
                    <i class="bi bi-trash3-fill fs-1"></i>
                </span>
            </div>
            <h5 class="fw-bold mb-2">Remover Receita?</h5>
            <p class="text-muted px-4">Tens a certeza que queres remover <br><strong id="nomeReceitaModal" class="text-dark">esta receita</strong> dos teus favoritos?</p>
          </div>

          <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger rounded-pill px-4" id="btnConfirmarRemocao">Sim, remover</button>
          </div>

        </div>
      </div>
    </div>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        // Variável global para guardar dados
        let dadosRemocao = null;
        let modalInstancia = null;

        function removerFavorito(btn, id, titulo, imagem, referencia) {
            dadosRemocao = {
                id: id,
                titulo: titulo,
                imagem: imagem,
                referencia: referencia
            };
            document.getElementById('nomeReceitaModal').innerText = titulo;
            const modalElement = document.getElementById('modalRemover');
            modalInstancia = new bootstrap.Modal(modalElement);
            modalInstancia.show();
        }

        document.getElementById('btnConfirmarRemocao').addEventListener('click', function() {
            if (!dadosRemocao) return;
            if (modalInstancia) modalInstancia.hide();

            fetch('ajax/ajax_favorito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_receita: dadosRemocao.id,
                    titulo: dadosRemocao.titulo,
                    imagem: dadosRemocao.imagem,
                    referencia: dadosRemocao.referencia
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'removido') {
                    const cardCol = document.getElementById('fav-card-' + dadosRemocao.id);
                    if(cardCol) {
                        cardCol.style.transition = "all 0.5s ease";
                        cardCol.style.opacity = "0";
                        cardCol.style.transform = "scale(0.8)";
                        setTimeout(() => {
                            cardCol.remove();
                            // Verifica se a lista de favoritos ficou vazia
                            const lista = document.getElementById('listaFavoritos');
                            if(lista && lista.children.length === 0) {
                                location.reload();
                            }
                        }, 500);
                    }
                } else {
                    alert("Erro ao remover: " + data.mensagem);
                }
            })
            .catch(error => console.error('Erro:', error));
        });
    </script>
</body>
</html>