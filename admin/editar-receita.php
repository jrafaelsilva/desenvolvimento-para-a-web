<?php
require('includes/connection.php');

//  VERIFICAÇÃO DE ID DA RECEITA
if (!isset($_GET['id'])) {
    header("Location: gerir-receitas.php");
    exit;
}

$idReceita = (int)$_GET['id'];
$mensagem = "";
$erro = "";

//  BUSCAR DADOS DA RECEITA 
$stmt = $dbh->prepare("SELECT titulo FROM receitas WHERE id = ?");
$stmt->execute([$idReceita]);
$receita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receita) {
    echo "Receita não encontrada.";
    exit;
}

//  LÓGICA DE GRAVAÇÃO (UPSERT - UPDATE OR INSERT)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Arrays de Ingredientes (IDs e Textos)
    $ing_ids = $_POST['ing_id'] ?? [];
    $ing_textos = $_POST['ing_texto'] ?? [];
    
    // Arrays de Passos (IDs e Textos)
    $passo_ids = $_POST['passo_id'] ?? [];
    $passo_textos = $_POST['passo_texto'] ?? [];

    try {
        $dbh->beginTransaction();

        // PROCESSAR INGREDIENTES 
        $sqlUpdIng = $dbh->prepare("UPDATE ingredientes SET nome = ? WHERE id = ? AND id_receita = ?");
        $sqlInsIng = $dbh->prepare("INSERT INTO ingredientes (id_receita, nome) VALUES (?, ?)");

        // Percorrer todos os ingredientes enviados
        foreach ($ing_textos as $key => $texto) {
            $texto = trim($texto);
            $id = isset($ing_ids[$key]) ? (int)$ing_ids[$key] : 0;

            if (!empty($texto)) {
                if ($id > 0) {
                    // SE TEM ID > ATUALIZA (UPDATE)
                    $sqlUpdIng->execute([$texto, $id, $idReceita]);
                } else {
                    // SE NÃO TEM ID > CRIA NOVO (INSERT)
                    $sqlInsIng->execute([$idReceita, $texto]);
                }
            }
        }

        // PROCESSAR PASSOS 
        $sqlUpdPasso = $dbh->prepare("UPDATE preparacao SET passo = ?, ordem = ? WHERE id = ? AND id_receita = ?");
        $sqlInsPasso = $dbh->prepare("INSERT INTO preparacao (id_receita, ordem, passo) VALUES (?, ?, ?)");

        // A ordem é definida pela posição no array (1, 2, 3...)
        $ordem = 1;

        foreach ($passo_textos as $key => $texto) {
            $texto = trim($texto);
            $id = isset($passo_ids[$key]) ? (int)$passo_ids[$key] : 0;

            if (!empty($texto)) {
                if ($id > 0) {
                    // SE TEM ID > ATUALIZA (UPDATE)
                    $sqlUpdPasso->execute([$texto, $ordem, $id, $idReceita]);
                } else {
                    // SE NÃO TEM ID > CRIA NOVO (INSERT)
                    $sqlInsPasso->execute([$idReceita, $ordem, $texto]);
                }
                $ordem++; // Incrementa ordem para o próximo
            }
        }

        $dbh->commit();
        $mensagem = "Conteúdos atualizados com sucesso!";
        
    } catch (PDOException $e) {
        $dbh->rollBack();
        $erro = "Erro ao gravar: " . $e->getMessage();
    }
}

//  BUSCAR DADOS ATUAIS 
$stmtIng = $dbh->prepare("SELECT * FROM ingredientes WHERE id_receita = ?");
$stmtIng->execute([$idReceita]);
$listaIngredientes = $stmtIng->fetchAll(PDO::FETCH_ASSOC);

// Passos
$stmtPassos = $dbh->prepare("SELECT * FROM preparacao WHERE id_receita = ? ORDER BY ordem ASC");
$stmtPassos->execute([$idReceita]);
$listaPassos = $stmtPassos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Conteúdos - <?php echo htmlspecialchars($receita['titulo']); ?></title>
    <link rel="shortcut icon" href="../imgs/pitada.logo.png">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

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
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Editar Conteúdos</h2>
                    <p class="text-muted fs-5">A editar: <strong class="text-primary"><?php echo htmlspecialchars($receita['titulo']); ?></strong></p>
                </div>

                <?php if($mensagem): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i><?php echo $mensagem; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if($erro): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $erro; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="fw-bold m-0"><i class="bi bi-basket me-2 text-warning"></i>Ingredientes</h5>
                        </div>
                        <div class="card-body p-4">
                            <div id="lista-ingredientes">
                                <?php if(count($listaIngredientes) > 0): ?>
                                    <?php foreach($listaIngredientes as $ing): ?>
                                        <div class="input-group mb-2">
                                            <input type="hidden" name="ing_id[]" value="<?php echo $ing['id']; ?>">
                                            <input type="text" name="ing_texto[]" class="form-control" value="<?php echo htmlspecialchars($ing['nome']); ?>" required>
                                            
                                            <span class="input-group-text bg-white text-secondary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="input-group mb-2">
                                        <input type="hidden" name="ing_id[]" value="">
                                        <input type="text" name="ing_texto[]" class="form-control" placeholder="Ex: 500g de batatas" required>
                                        <span class="input-group-text bg-white text-secondary">
                                            <i class="bi bi-pencil-fill"></i>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mt-2" onclick="adicionarIngrediente()">
                                <i class="bi bi-plus-lg me-1"></i> Adicionar Ingrediente
                            </button>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="fw-bold m-0"><i class="bi bi-list-ol me-2 text-primary"></i>Modo de Preparação</h5>
                        </div>
                        <div class="card-body p-4">
                            <div id="lista-passos">
                                <?php if(count($listaPassos) > 0): ?>
                                    <?php foreach($listaPassos as $index => $passo): ?>
                                        <div class="d-flex gap-2 mb-2 align-items-start passo-item">
                                            <span class="badge bg-dark rounded-circle p-2 mt-1 step-number"><?php echo $index + 1; ?></span>
                                            
                                            <input type="hidden" name="passo_id[]" value="<?php echo $passo['id']; ?>">
                                            <textarea name="passo_texto[]" class="form-control" rows="2" required><?php echo htmlspecialchars($passo['passo']); ?></textarea>
                                            
                                            <span class="input-group-text bg-white text-secondary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="d-flex gap-2 mb-2 align-items-start passo-item">
                                        <span class="badge bg-dark rounded-circle p-2 mt-1 step-number">1</span>
                                        <input type="hidden" name="passo_id[]" value="">
                                        <textarea name="passo_texto[]" class="form-control" rows="2" placeholder="Descreva o passo..." required></textarea>
                                        <div class="pt-2 ps-1">
                                            <i class="bi bi-pencil-fill text-secondary"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mt-2" onclick="adicionarPasso()">
                                <i class="bi bi-plus-lg me-1"></i> Adicionar Passo
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm py-3">
                            <i class="bi bi-check2-circle me-2"></i>Guardar Alterações
                        </button>
                        <a href="gerir-receitas.php" class="btn btn-light rounded-pill py-2 text-muted">Cancelar</a>
                    </div>

                </form>
                
                <div class="mb-5"></div>

            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
        function adicionarIngrediente() {
            const container = document.getElementById('lista-ingredientes');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 fade-in';
            div.innerHTML = `
                <input type="hidden" name="ing_id[]" value="">
                <input type="text" name="ing_texto[]" class="form-control" placeholder="Novo Ingrediente" required>
                <span class="input-group-text bg-white text-secondary">
                    <i class="bi bi-pencil-fill"></i>
                </span>
            `;
            container.appendChild(div);
        }

        function adicionarPasso() {
            const container = document.getElementById('lista-passos');
            const numPassos = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-2 align-items-start passo-item fade-in';
            div.innerHTML = `
                <span class="badge bg-dark rounded-circle p-2 mt-1 step-number">${numPassos}</span>
                <input type="hidden" name="passo_id[]" value="">
                <textarea name="passo_texto[]" class="form-control" rows="2" placeholder="Descreva o passo..." required></textarea>
                <div class="pt-2 ps-1">
                    <i class="bi bi-pencil-fill text-secondary"></i>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>