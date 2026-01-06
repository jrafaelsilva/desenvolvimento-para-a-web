<?php
session_start();
require('includes/connection.php');

$mensagem = "";
$erro = "";

//  LÓGICA DE EDITAR (POST) 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $idReceita = $_POST['id_receita'] ?? 0;
    
    $titulo = trim($_POST['titulo']);
    $categoria = $_POST['categoria'];
    $tempo = (int)$_POST['tempo_preparo'];
    $idChef = !empty($_POST['id_chef']) ? $_POST['id_chef'] : null;
    $caminhoImagem = $_POST['imagem_atual'] ?? ''; 
    
    // Upload de Imagem 
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($ext, $permitidos)) {
            $novoNome = "receita_" . time() . "_" . rand(100,999) . "." . $ext;
            $destino = "../imgs/" . $novoNome;
            $caminhoBD = "imgs/" . $novoNome;
            
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $caminhoImagem = $caminhoBD;// Atualiza o caminho para a nova imagem
            } else {
                $erro = "Falha ao gravar a imagem no servidor.";
            }
        } else {
            $erro = "Formato de imagem inválido.";
        }
    }

    if (empty($erro)) {
        if ($acao === 'editar') {
            try {
                $stmt = $dbh->prepare("UPDATE receitas SET titulo=?, categoria=?, tempo_preparo=?, imagem=?, id_chef=? WHERE id=?");
                if ($stmt->execute([$titulo, $categoria, $tempo, $caminhoImagem, $idChef, $idReceita])) {
                    $mensagem = "Receita atualizada com sucesso!";
                }
            } catch (PDOException $e) {
                $erro = "Erro BD: " . $e->getMessage();
            }
        }
    }
}

// LÓGICA DE ATIVAR/DESATIVAR 
if (isset($_GET['toggle_id']) && isset($_GET['novo_estado'])) {
    $idToggle = (int)$_GET['toggle_id'];
    $novoEstado = (int)$_GET['novo_estado'];
    
    $stmtUpd = $dbh->prepare("UPDATE receitas SET estado = ? WHERE id = ?");
    $stmtUpd->execute([$novoEstado, $idToggle]);
}

// BUSCAR DADOS
$chefs = $dbh->query("SELECT id, nome FROM chefs ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todas';

$sql = "SELECT r.*, c.nome as nome_chef, u.utilizador as nome_utilizador 
        FROM receitas r 
        LEFT JOIN chefs c ON r.id_chef = c.id
        LEFT JOIN utilizadores u ON r.id_utilizador = u.iduser
        ORDER BY r.categoria ASC";
$stmt = $dbh->query($sql);
$todasReceitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separar em arrays diferentes
$receitasOficiais = [];
$receitasComunidade = [];

foreach ($todasReceitas as $rec) {
    // Aplicar Filtro de Categoria
    $mostrar = true;
    if ($filtro !== 'todas') {
        $mapaFiltro = [
            'carne' => 'Receitas de carne',
            'peixe' => 'Peixe',
            'sobremesa' => 'Sobremesa',
            'sopa' => 'Sopas e Cremes',
            'comunidade' => 'Comunidade'
        ];
        
        if (isset($mapaFiltro[$filtro])) {
            if ($rec['categoria'] !== $mapaFiltro[$filtro]) {
                $mostrar = false;
            }
        }
    }

    if ($mostrar) {
        if ($rec['categoria'] === 'Comunidade') {
            $receitasComunidade[] = $rec;
        } else {
            $receitasOficiais[] = $rec;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Gestão de Receitas</title>
    <link rel="shortcut icon" href="../imgs/pitada.logo.png">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body >
    
    <nav class="navbar navbar-expand-lg  shadow-sm fixed-top" style="background-color: rgb(245, 240, 214);">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../index.php">
          <img src="../imgs/pitada.logo.png" alt="Logótipo" width="100" class="me-2">
          <span class="badge bg-danger rounded-pill">ADMINISTRAÇÃO</span>
        </a>
        <div class="d-flex align-items-center gap-3">
             <a href="../index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-house-door me-1"></i>Voltar ao Site</a>
             <a href="utilizadores.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-people me-1"></i>Utilizadores</a>
        </div>
      </div>
    </nav>

    <div class="container my-5">
        
        <?php if($mensagem): ?>
            <div class="alert alert-success alert-dismissible fade show"><?php echo $mensagem; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
        <?php if($erro): ?>
            <div class="alert alert-danger alert-dismissible fade show"><?php echo $erro; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold m-0 text-dark">Receitas</h2>
                <span class="text-muted small">Total: <?php echo count($todasReceitas); ?></span>
            </div>
            <a href="nova-receita.php" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Nova Receita
            </a>
        </div>

        <?php if (count($receitasComunidade) > 0 || $filtro == 'comunidade'): ?>
        <h5 class="fw-bold text-dark mb-3 mt-5 ps-3 border-start border-4 border-warning">Receitas da Comunidade <span class="badge bg-light text-dark border ms-2"><?php echo count($receitasComunidade); ?></span></h5>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-2 py-3" style="width: 40%;">Prato</th>
                            <th style="width: 15%;">Categoria</th>
                            <th style="width: 15%;">Utilizador</th>
                            <th style="width: 10%;">Tempo</th>
                            <th style="width: 10%;">Estado</th>
                            <th class="text-end pe-4" style="width: 10%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-top-0">
                        <?php if(count($receitasComunidade) > 0): ?>
                            <?php foreach($receitasComunidade as $rec): 
                                $img = (!empty($rec['imagem']) && file_exists("../".$rec['imagem'])) ? "../".$rec['imagem'] : "../imgs/banner.jpeg";
                                $estado = isset($rec['estado']) ? $rec['estado'] : 1;
                            ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $img; ?>" class="rounded-3 me-3 border shadow-sm" width="50" height="50" style="object-fit:cover;">
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($rec['titulo']); ?></div>
                                            <small class="text-muted">ID: #<?php echo $rec['id']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light  text-dark border">Comunidade</span></td>

                                <td class="text-secondary fw-medium">
                                    <i class="bi bi-person-circle me-1"></i>
                                    <?php echo !empty($rec['nome_utilizador']) ? htmlspecialchars($rec['nome_utilizador']) : 'Desconhecido'; ?>
                                </td>
                                <td class="text-muted small"><i class="bi bi-clock me-1"></i><?php echo $rec['tempo_preparo']; ?>m</td>
                                <td>
                                    <?php if($estado == 1): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Visível</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Oculto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" 
                                            data-receita='<?php echo htmlspecialchars(json_encode($rec), ENT_QUOTES, 'UTF-8'); ?>'
                                            onclick="abrirModalEditar(this)" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <?php if($estado == 1): ?>
                                        <button class="btn btn-sm btn-outline-danger rounded-circle"
                                                onclick="abrirModalStatus(<?= $rec['id'] ?>, 0, '<?= addslashes($rec['titulo']) ?>')" title="Ocultar">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success rounded-circle" 
                                                onclick="abrirModalStatus(<?= $rec['id'] ?>, 1, '<?= addslashes($rec['titulo']) ?>')" title="Publicar">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Nenhuma receita da comunidade encontrada.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>


        <?php if (count($receitasOficiais) > 0 || $filtro != 'comunidade'): ?>
        <h5 class="fw-bold text-dark mb-3 mt-5 ps-3 border-start border-4 border-primary">Receitas Oficiais <span class="badge bg-light text-dark border ms-2"><?php echo count($receitasOficiais); ?></span></h5>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3" style="width: 40%;">Prato</th>
                            <th style="width: 15%;">Categoria</th>
                            <th style="width: 15%;">Chef</th>
                            <th style="width: 10%;">Tempo</th>
                            <th style="width: 10%;">Estado</th>
                            <th class="text-end pe-4" style="width: 10%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-top-0">
                        <?php if(count($receitasOficiais) > 0): ?>
                            <?php foreach($receitasOficiais as $rec): 
                                $img = (!empty($rec['imagem']) && file_exists("../".$rec['imagem'])) ? "../".$rec['imagem'] : "../imgs/banner.jpeg";
                                $estado = isset($rec['estado']) ? $rec['estado'] : 1;
                            ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $img; ?>" class="rounded-3 me-3 border shadow-sm" width="50" height="50" style="object-fit:cover;">
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($rec['titulo']); ?></div>
                                            <small class="text-muted">ID: #<?php echo $rec['id']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($rec['categoria']); ?></span></td>
                                <td class="text-muted small">
                                    <?php echo $rec['nome_chef'] ? htmlspecialchars($rec['nome_chef']) : '-'; ?>
                                </td>
                                <td class="text-muted small"><i class="bi bi-clock me-1"></i><?php echo $rec['tempo_preparo']; ?>m</td>
                                <td>
                                    <?php if($estado == 1): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Visível</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Oculto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" 
                                            data-receita='<?php echo htmlspecialchars(json_encode($rec), ENT_QUOTES, 'UTF-8'); ?>'
                                            onclick="abrirModalEditar(this)" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <?php if($estado == 1): ?>
                                        <button class="btn btn-sm btn-outline-danger rounded-circle"
                                                onclick="abrirModalStatus(<?= $rec['id'] ?>, 0, '<?= addslashes($rec['titulo']) ?>')" title="Ocultar">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success rounded-circle" 
                                                onclick="abrirModalStatus(<?= $rec['id'] ?>, 1, '<?= addslashes($rec['titulo']) ?>')" title="Publicar">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Nenhuma receita oficial encontrada.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="modal fade" id="modalReceita" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
          <form method="POST" action="gerir-receitas.php" enctype="multipart/form-data">
              <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Editar Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id_receita" id="idInput" value="">
                <input type="hidden" name="imagem_atual" id="imgInput" value="">

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label text-muted fw-bold small">Título</label>
                        <input type="text" name="titulo" id="tituloField" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted fw-bold small">Tempo (min)</label>
                        <input type="number" name="tempo_preparo" id="tempoField" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small">Categoria</label>
                        <select name="categoria" id="categoriaField" class="form-select" required>
                            <option value="Receitas de carne">Carne</option>
                            <option value="Peixe">Peixe</option>
                            <option value="Sobremesa">Sobremesa</option>
                            <option value="Sopas e Cremes">Sopas</option>
                            <option value="Comunidade">Comunidade</option>
                        </select>
                    </div>

                    <div class="col-md-6" id="chefFieldContainer">
                        <label class="form-label text-muted fw-bold small">Chef</label>
                        <select name="id_chef" id="chefField" class="form-select">
                            <option value="">-- Nenhum --</option>
                            <?php foreach($chefs as $chef): ?>
                                <option value="<?php echo $chef['id']; ?>"><?php echo $chef['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-muted fw-bold small">Imagem</label>
                        <input type="file" name="imagem" class="form-control" accept="image/*">
                        <div id="previewImg" class="mt-2 text-muted small fst-italic"></div>
                    </div>
                    
                </div>

              </div>
              <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <a href="editar-receita.php" id="btnEditarConteudos" class="btn btn-warning fw-bold text-dark">
                               Editar Ingredientes e Modo de Preparo
                            </a>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Guardar Alterações</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalStatus" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
          <div class="modal-body text-center py-4">
            <div id="statusIconContainer" class="mb-3 rounded-circle p-3 d-inline-block">
                <i id="statusIcon" class="bi"></i>
            </div>
            <h5 class="fw-bold mb-2" id="modalStatusTitle">Alterar Estado</h5>
            <p class="text-muted px-4" id="modalStatusBody">Tem a certeza?</p>
          </div>
          <div class="modal-footer border-0 justify-content-center pb-4 pt-0">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="btnConfirmStatus" class="btn rounded-pill px-4 fw-bold">Confirmar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>

    <script>
        const modalEl = document.getElementById('modalReceita');
        const modal = new bootstrap.Modal(modalEl);

        // Função para mostrar/esconder o campo do Chef
        function verificarCategoria() {
            const cat = document.getElementById('categoriaField').value;
            const chefContainer = document.getElementById('chefFieldContainer');
            
            if (cat === 'Comunidade') {
                chefContainer.style.display = 'none'; // Esconde
                document.getElementById('chefField').value = ""; // Limpa a seleção
            } else {
                chefContainer.style.display = 'block'; // Mostra
            }
        }

        // Apenas função de editar, o criar é noutra página
        function abrirModalEditar(btn) {
            const rec = JSON.parse(btn.getAttribute('data-receita'));
            document.getElementById('idInput').value = rec.id;
            document.getElementById('imgInput').value = rec.imagem; 
            document.getElementById('tituloField').value = rec.titulo;
            document.getElementById('tempoField').value = rec.tempo_preparo;
            document.getElementById('categoriaField').value = rec.categoria;
            document.getElementById('chefField').value = rec.id_chef || "";

            // Atualizar o link do botão de conteúdos
            document.getElementById('btnEditarConteudos').href = "editar-receita.php?id=" + rec.id;

            ///Atualiza a visibilidade do campo Chef ao abrir ---
            verificarCategoria(); 
            
            if(rec.imagem) {
                document.getElementById('previewImg').innerHTML = 
                    '<i class="bi bi-image me-1"></i> Imagem atual: <strong>' + rec.imagem + '</strong>';
            } else {
                document.getElementById('previewImg').innerText = "Sem imagem atual.";
            }
            modal.show();
        }
        

        // Lógica do Modal de Estado
        let urlDestino = "";

        function abrirModalStatus(id, novoEstado, titulo) {
            const modalTitle = document.getElementById('modalStatusTitle');
            const modalBody = document.getElementById('modalStatusBody');
            const btnConfirm = document.getElementById('btnConfirmStatus');
            const iconContainer = document.getElementById('statusIconContainer');
            const icon = document.getElementById('statusIcon');

            urlDestino = "gerir-receitas.php?toggle_id=" + id + "&novo_estado=" + novoEstado;

            if (novoEstado === 0) {
                modalTitle.innerText = "Ocultar Receita";
                modalBody.innerHTML = "Tem a certeza que deseja ocultar <strong>" + titulo + "</strong>?";
                iconContainer.className = "mb-3 bg-danger bg-opacity-10 text-danger rounded-circle p-3 d-inline-block";
                icon.className = "bi bi-eye-slash-fill fs-1";
                btnConfirm.className = "btn btn-danger rounded-pill px-4 fw-bold";
                btnConfirm.innerText = "Sim, Ocultar";
            } else {
                modalTitle.innerText = "Publicar Receita";
                modalBody.innerHTML = "Tem a certeza que deseja publicar <strong>" + titulo + "</strong>?";
                iconContainer.className = "mb-3 bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block";
                icon.className = "bi bi-eye-fill fs-1";
                btnConfirm.className = "btn btn-success rounded-pill px-4 fw-bold";
                btnConfirm.innerText = "Sim, Publicar";
            }
            const modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
            modalStatus.show();
        }

        document.getElementById('btnConfirmStatus').addEventListener('click', function() {
            window.location.href = urlDestino;
        });
    </script>
</body>
</html>