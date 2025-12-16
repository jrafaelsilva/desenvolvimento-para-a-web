<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: auth/login.php");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erro = "";
if (isset($_SESSION['erro_submissao'])) {
    $erro = $_SESSION['erro_submissao'];
    unset($_SESSION['erro_submissao']);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enviar Receita - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php require('includes/nav.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                        <h2 class="fw-bold display-6" style="color: rgb(182, 125, 95);">Partilha a tua Receita</h2>
                        <p class="text-muted">A tua receita será publicada na secção da <strong>Comunidade</strong>.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <?php if (!empty($erro)): ?>
                            <div class="alert alert-danger rounded-3 mb-4 text-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($erro); ?>
                            </div>
                        <?php endif; ?>

                        <form action="auth/proc_submissao.php" method="POST" enctype="multipart/form-data">
                            
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Nome da Receita</label>
                                <input type="text" name="titulo" class="form-control form-control-lg" placeholder="Ex: O meu Bacalhau com Natas" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Descrição da receita</label>
                                <input type="text" name="descricao" class="form-control form-control-lg" placeholder="Ex: Uma receita deliciosa para experimentar." required>
                            </div>

                            <div class="row g-3 mb-5">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Tempo (minutos)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-stopwatch"></i></span>
                                        <input type="number" name="tempo" class="form-control" placeholder="45" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold text-dark">Foto do Prato</label>
                                    <input type="file" name="imagem" class="form-control" accept="image/*" required>
                                    <div class="form-text">Formatos aceites: JPG, PNG, WEBP.</div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fw-bold mb-0 text-center w-100">Ingredientes</h4>
                                </div>
                                
                                <div id="lista-ingredientes">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text bg-white"><i class="bi bi-basket"></i></span>
                                        <input type="text" name="ingredientes[]" class="form-control" placeholder="Ex: 500g de batatas" required>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" onclick="adicionarIngrediente()">
                                        <i class="bi bi-plus-lg me-1"></i> Adicionar outro ingrediente
                                    </button>
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fw-bold mb-0 text-center w-100">Modo de Preparação</h4>
                                </div>

                                <div id="lista-passos">
                                    <div class="d-flex gap-2 mb-2 align-items-start passo-item">
                                        <span class="badge bg-dark rounded-circle p-2 mt-1">1</span>
                                        <textarea name="passos[]" class="form-control" rows="2" placeholder="Descreva este passo..." required></textarea>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" onclick="adicionarPasso()">
                                        <i class="bi bi-plus-lg me-1"></i> Adicionar próximo passo
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3 fw-bold rounded-pill shadow-sm">
                                    <i class="bi bi-check2-circle me-2"></i>Partilhar Receita
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        function adicionarIngrediente() {
            const container = document.getElementById('lista-ingredientes');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 fade-in';
            div.innerHTML = `
                <span class="input-group-text bg-white"><i class="bi bi-basket"></i></span>
                <input type="text" name="ingredientes[]" class="form-control" placeholder="Ingrediente..." required>
                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
            `;
            container.appendChild(div);
        }

        let contadorPassos = 1;
        function adicionarPasso() {
            contadorPassos++;
            const container = document.getElementById('lista-passos');
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-start passo-item fade-in';
            div.innerHTML = `
                <span class="badge bg-dark rounded-circle p-2 mt-1">${contadorPassos}</span>
                <textarea name="passos[]" class="form-control" rows="2" placeholder="Próximo passo..." required></textarea>
                <button type="button" class="btn btn-outline-danger mt-1" onclick="removerPasso(this)"><i class="bi bi-x-lg"></i></button>
            `;
            container.appendChild(div);
        }

        function removerPasso(btn) {
            btn.parentElement.remove();
        }
    </script>
</body>
</html>