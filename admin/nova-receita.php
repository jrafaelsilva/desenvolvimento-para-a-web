<?php
session_start();
require('../includes/connection.php');

$erro = "";
$sucesso = "";

// Buscar Chefs para o select
$chefs = $dbh->query("SELECT id, nome FROM chefs ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);

// LÓGICA DE GRAVAÇÃO 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo = trim($_POST['titulo']);
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $tempo = (int)$_POST['tempo'];
    $idChef = !empty($_POST['id_chef']) ? $_POST['id_chef'] : null;
    
    // Captura os arrays de ingredientes e passos
    $ingredientes = $_POST['ingredientes'] ?? [];
    $passos = $_POST['passos'] ?? [];

    // Validação Simples
    if (empty($titulo) || empty($categoria) || empty($tempo) || empty($ingredientes) || empty($passos)) {
        $erro = "Preencha todos os campos obrigatórios, incluindo pelo menos um ingrediente e um passo.";
    } 
    // Upload da Imagem
    elseif (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

if (in_array($ext, $permitidos)) {
            
            // --- 1. DEFINIR PASTA DE ACORDO COM A CATEGORIA ---
            $mapaPastas = [
                'Receitas de carne' => 'carne',
                'Peixe'             => 'peixe',
                'Sobremesa'         => 'sobremesa',
                'Sopas e Cremes'    => 'sopas',
                'Comunidade'        => 'comunidade'
            ];

            $pastaDestino = isset($mapaPastas[$categoria]) ? $mapaPastas[$categoria] : '';
            $novoNome = "receita_" . time() . "_" . rand(100,999) . "." . $ext;
            
            if ($pastaDestino) {
                $destino = "../imgs/" . $pastaDestino . "/" . $novoNome;
                $caminhoBD = "imgs/" . $pastaDestino . "/" . $novoNome;
                
             
            } else {
                $destino = "../imgs/" . $novoNome;
                $caminhoBD = "imgs/" . $novoNome;
            }

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                
                try {
                    // Iniciar Transação 
                    $dbh->beginTransaction();

                    // 1. Inserir Receita (Estado = 1 -> Ativo)
                    $stmt = $dbh->prepare("INSERT INTO receitas (titulo, descricao, categoria, tempo_preparo, imagem, id_chef, estado, id_utilizador) VALUES (?, ?, ?, ?, ?, ?, 1, NULL)");
                    $stmt->execute([$titulo, $descricao, $categoria, $tempo, $caminhoBD, $idChef]);
                    
                    // Recuperar o ID da receita acabada de criar
                    $idReceita = $dbh->lastInsertId();

                    // 2. Inserir Ingredientes (Loop)
                    $stmtIng = $dbh->prepare("INSERT INTO ingredientes (id_receita, nome) VALUES (?, ?)");
                    foreach ($ingredientes as $ing) {
                        $ing = trim($ing);
                        if (!empty($ing)) $stmtIng->execute([$idReceita, $ing]);
                    }

                    // 3. Inserir Passos de Preparação (Loop)
                    $stmtPrep = $dbh->prepare("INSERT INTO preparacao (id_receita, ordem, passo) VALUES (?, ?, ?)");
                    $ordem = 1;
                    foreach ($passos as $passo) {
                        $passo = trim($passo);
                        if (!empty($passo)) {
                            $stmtPrep->execute([$idReceita, $ordem, $passo]);
                            $ordem++;
                        }
                    }

                    // Confirmar Gravação
                    $dbh->commit();
                    
                    $sucesso = true;

                } catch (PDOException $e) {
                    $dbh->rollBack(); // Anula tudo se der erro
                    if(file_exists($destino)) unlink($destino); // Apaga a imagem se falhar
                    $erro = "Erro na base de dados: " . $e->getMessage();
                }

            } else {
                $erro = "Falha ao gravar a imagem no servidor.";
            }
        } else {
            $erro = "Formato de imagem inválido (apenas JPG, PNG, WEBP).";
        }
    } else {
        $erro = "A imagem é obrigatória.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Nova Receita</title>
    <link rel="shortcut icon" href="../imgs/pitada.logo.png">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: rgb(245, 240, 214);">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../index.php">
          <img src="../imgs/pitada.logo.png" alt="Logótipo" width="100" class="me-2">
          <span class="badge bg-danger rounded-pill">ADMINISTRAÇÃO</span>
        </a>
        <div class="d-flex align-items-center gap-3">
             <a href="../index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-house-door me-1"></i>Voltar ao Site</a>
             <a href="gerir-receitas.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-left me-1"></i>Voltar à Lista</a>
        </div>
      </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                        <h2 class="fw-bold display-6 text-dark">Adicionar Nova Receita</h2>
                        <p class="text-muted">Preencha os dados completos para criar uma receita.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <?php if (!empty($erro)): ?>
                            <div class="alert alert-danger rounded-3 mb-4 text-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo htmlspecialchars($erro); ?>
                            </div>
                        <?php endif; ?>

                        <!-- O action="" envia para a própria página -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            
                            <!-- 1. TÍTULO -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Nome da Receita</label>
                                <input type="text" name="titulo" class="form-control form-control-lg" placeholder="Ex: Arroz de Pato à Antiga" required>
                            </div>
                            
                            <!-- descrição-->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Descrição da Receita</label>
                                <input type="text" name="descricao" class="form-control form-control-lg" placeholder="Ex:Uma receita deliciosa para experimentar." required>
                            </div>

                            <!-- 2. CATEGORIA E CHEF -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Categoria</label>
                                    <select name="categoria" class="form-select form-select-lg" required>
                                        <option value="" selected disabled>Escolher...</option>
                                        <option value="Receitas de carne">Carne</option>
                                        <option value="Peixe">Peixe</option>
                                        <option value="Sobremesa">Sobremesa</option>
                                        <option value="Sopas e Cremes">Sopas</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Chef (Opcional)</label>
                                    <select name="id_chef" class="form-select form-select-lg">
                                        <option value="">-- Sem Chef Associado --</option>
                                        <?php foreach($chefs as $chef): ?>
                                            <option value="<?php echo $chef['id']; ?>"><?php echo $chef['nome']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- 3. TEMPO E IMAGEM -->
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
                                    <div class="form-text">JPG, PNG ou WEBP</div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- 4. INGREDIENTES -->
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

                            <!-- 5. MODO DE PREPARAÇÃO-->
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

                            <!-- BOTÃO ENVIAR -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3 fw-bold rounded-pill shadow-sm">
                                    <i class="bi bi-check2-circle me-2"></i>Criar Receita
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
              
     <!-- ESTRUTURA DO MODAL BOOTSTRAP -->
    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 rounded-4 shadow">
                <div class="modal-body">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success display-1"></i>
                    </div>
                    <h3 class="fw-bold mb-3 text-dark">Sucesso!</h3>
                    <p class="text-muted mb-4 fs-5">A receita foi criada com sucesso.</p>
                    <button type="button" class="btn btn-success btn-lg w-100 rounded-pill" id="btnRedirect">
                        Continuar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <!-- Scripts JS para adicionar campos -->
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

        // --- SCRIPT DO MODAL BOOTSTRAP ---
        <?php if ($sucesso): ?>
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            document.getElementById('btnRedirect').addEventListener('click', function() {
                window.location.href = 'gerir-receitas.php';
            });
        <?php endif; ?>
    </script>
</body>
</html>