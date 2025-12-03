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

// 3. BUSCAR APENAS OS FAVORITOS ATIVOS
// ALTERAÇÃO AQUI: Adicionado 'AND ativado = 1' para não mostrar os removidos
$stmtFav = $dbh->prepare("SELECT * FROM favoritos WHERE id_utilizador = ? AND ativado = 1 ORDER BY id DESC");
$stmtFav->execute([$id_utilizador]);
$meus_favoritos = $stmtFav->fetchAll(PDO::FETCH_ASSOC);
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
            <p class="lead text-muted">As tuas receitas favoritas guardadas num só lugar.</p>
        </div>

        <div class="mb-4 border-bottom pb-2">
            <h3 class="fw-bold">
                <i class="bi bi-heart-fill me-2 text-danger"></i>Meus Favoritos
            </h3>
        </div>

        <?php if (count($meus_favoritos) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="listaFavoritos">
                <?php foreach ($meus_favoritos as $fav): ?>
                    <div class="col" id="fav-card-<?php echo $fav['id_receita']; ?>">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                            
                            <!-- Botão para remover (aciona o JS em baixo) -->
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
                                <a href="<?php echo $fav['referencia']; ?>" class="btn btn-style2 w-100">Cozinhar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border mt-4">
                <i class="bi bi-heartbreak display-1 text-muted opacity-25"></i>
                <h4 class="mt-3 text-muted">Ainda não tens favoritos.</h4>
                <p class="mb-4">Explora as nossas receitas e clica no coração para as guardares aqui!</p>
                <a href="index.php" class="btn btn-style2">Explorar Receitas</a>
            </div>

        <?php endif; ?>

    </div>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        function removerFavorito(btn, id, titulo, imagem, referencia) {
            // Pergunta de segurança
            if(!confirm("Tens a certeza que queres remover esta receita dos favoritos?")) {
                return;
            }

            // Envia o pedido para o PHP
            // Nota: O backend vai mudar o estado de 1 para 0 e devolver "removido"
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
                if (data.status === 'removido') {
                    // Efeito visual: Faz o cartão desaparecer suavemente
                    const cardCol = document.getElementById('fav-card-' + id);
                    if(cardCol) {
                        cardCol.style.transition = "all 0.5s";
                        cardCol.style.opacity = "0";
                        cardCol.style.transform = "scale(0.9)";
                        
                        // Remove do HTML após a animação (500ms)
                        setTimeout(() => {
                            cardCol.remove();
                            
                            // Verifica se ficou sem favoritos e recarrega para mostrar a mensagem de vazio
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
        }
    </script>
</body>
</html>