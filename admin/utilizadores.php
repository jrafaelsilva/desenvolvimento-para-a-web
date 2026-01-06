<?php
session_start();
require('includes/connection.php');


$mensagem = "";
$erro = "";

//  LÓGICA DE CRIAR / EDITAR (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $idUser = $_POST['id_user'] ?? 0;
    $utilizador = trim($_POST['utilizador']);
    $email = trim($_POST['email']);
    $novaPass = $_POST['password'] ?? '';

    if (empty($utilizador) || empty($email)) {
        $erro = "Preencha o nome e o email.";
    } else {
        if ($acao === 'criar') {
            // --- CRIAR NOVO ---
            if (empty($novaPass)) {
                $erro = "A password é obrigatória para novos utilizadores.";
            } else {
                $check = $dbh->prepare("SELECT iduser FROM utilizadores WHERE email = ?");
                $check->execute([$email]);
                if ($check->rowCount() > 0) {
                    $erro = "Este email já existe.";
                } else {
                    $passHash = password_hash($novaPass, PASSWORD_DEFAULT);
                    $stmt = $dbh->prepare("INSERT INTO utilizadores (utilizador, email, pass, estado) VALUES (?, ?, ?, 1)");
                    if ($stmt->execute([$utilizador, $email, $passHash])) {
                        $mensagem = "Utilizador criado com sucesso!";
                    } else {
                        $erro = "Erro ao criar utilizador.";
                    }
                }
            }
        } elseif ($acao === 'editar') {
            // EDITAR EXISTENTE
            if (!empty($novaPass)) {
                $passHash = password_hash($novaPass, PASSWORD_DEFAULT);
                $stmt = $dbh->prepare("UPDATE utilizadores SET utilizador = ?, email = ?, pass = ? WHERE iduser = ?");
                $res = $stmt->execute([$utilizador, $email, $passHash, $idUser]);
            } else {
                $stmt = $dbh->prepare("UPDATE utilizadores SET utilizador = ?, email = ? WHERE iduser = ?");
                $res = $stmt->execute([$utilizador, $email, $idUser]);
            }
            
            if ($res) {
                $mensagem = "Utilizador atualizado com sucesso!";
            } else {
                $erro = "Erro ao atualizar.";
            }
        }
    }
}

// bloquaer (GET)
if (isset($_GET['toggle_id']) && isset($_GET['novo_estado'])) {
    $idToggle = (int)$_GET['toggle_id'];
    $novoEstado = (int)$_GET['novo_estado'];
    $stmtUpd = $dbh->prepare("UPDATE utilizadores SET estado = ? WHERE iduser = ?");
    $stmtUpd->execute([$novoEstado, $idToggle]);
    header("Location: utilizadores.php");
    exit;
}

//  BUSCAR UTILIZADORES
$sql = "SELECT u.iduser, u.utilizador, u.email, u.estado, dp.avatar 
        FROM utilizadores u 
        LEFT JOIN dados_perfil dp ON u.iduser = dp.id_utilizador 
        ORDER BY u.iduser DESC";
$stmt = $dbh->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Gestão de Utilizadores</title>
    <link rel="shortcut icon" href="../imgs/pitada.logo.png">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm  " style="background-color: rgb(245, 240, 214);">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../index.php">
          <img src="../imgs/pitada.logo.png" alt="Logótipo" width="100" class="me-2">
          <span class="badge bg-danger rounded-pill">ADMINISTRAÇÃO</span>
        </a>
        <div class="d-flex align-items-center gap-3">
             <a href="../index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-house-door me-1"></i>Voltar ao Site</a>
             <a href="gerir-receitas.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-people me-1"></i>Receitas</a>

        </div>
      </div>
    </nav>

    <div class="container my-5">
        
        <?php if($mensagem): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensagem; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if($erro): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $erro; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Utilizadores</h2>
                <span class="text-muted small">Total: <?php echo count($users); ?></span>
            </div>
            <button class="btn btn-success rounded-pill px-4 shadow-sm" onclick="abrirModalCriar()">
                <i class="bi bi-person-plus-fill me-2"></i>Novo Utilizador
            </button>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Utilizador</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Estado</th>
                            <th class="text-end pe-4 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-top-0">
                        <?php if(count($users) > 0): ?>
                            <?php foreach($users as $user): 
                                $avatar = '../imgs/avatar/avpadrao.jpg';
                                if (!empty($user['avatar']) && $user['avatar'] != 'default' && file_exists('../imgs/avatar/' . $user['avatar'])) {
                                    $avatar = '../imgs/avatar/' . $user['avatar'];
                                }
                                $estado = isset($user['estado']) ? $user['estado'] : 1; 
                            ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $avatar; ?>" class="rounded-circle me-3 border shadow-sm" width="40" height="40" style="object-fit:cover;">
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($user['utilizador']); ?></div>
                                    </div>
                                </td>
                                <td class="text-muted"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <?php if($estado == 1): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-10">Ativo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border border-danger border-opacity-10">Bloqueado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1" 
                                            onclick='abrirModalEditar(<?php echo json_encode($user); ?>)'>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <?php if($estado == 1): ?>
                                        <button class="btn btn-sm btn-outline-danger rounded-circle me-1"
                                                onclick="abrirModalStatus(<?= $user['iduser'] ?>, 0, '<?= addslashes($user['utilizador']) ?>')">
                                            <i class="bi bi-ban"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-success rounded-circle me-1"
                                                onclick="abrirModalStatus(<?= $user['iduser'] ?>, 1, '<?= addslashes($user['utilizador']) ?>')">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted">Nenhum utilizador encontrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
          <form method="POST" action="utilizadores.php">
              <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Novo Utilizador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4">
                <input type="hidden" name="acao" id="acaoInput" value="criar">
                <input type="hidden" name="id_user" id="idUserInput" value="">
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold small">Nome de Utilizador</label>
                    <input type="text" name="utilizador" id="nomeInput" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold small">Email</label>
                    <input type="email" name="email" id="emailInput" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold small" id="passLabel">Palavra-passe</label>
                    <input type="password" name="password" id="passInput" class="form-control" placeholder="Deixe vazio para manter a atual">
                    <div class="form-text small text-muted" id="passHelp">Obrigatório para novos utilizadores.</div>
                </div>
              </div>
              <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Guardar</button>
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
        // --- FUNÇÕES DE CRIAR/EDITAR ---
        const modalEl = document.getElementById('modalUser');
        const modal = new bootstrap.Modal(modalEl);

        function abrirModalCriar() {
            document.getElementById('modalTitle').innerText = "Novo Utilizador";
            document.getElementById('acaoInput').value = "criar";
            document.getElementById('idUserInput').value = "";
            document.getElementById('nomeInput').value = "";
            document.getElementById('emailInput').value = "";
            document.getElementById('passInput').value = "";
            
            document.getElementById('passInput').required = true;
            document.getElementById('passInput').placeholder = "********";
            document.getElementById('passHelp').style.display = "block";
            
            modal.show();
        }

        function abrirModalEditar(user) {
            document.getElementById('modalTitle').innerText = "Editar Utilizador";
            document.getElementById('acaoInput').value = "editar";
            document.getElementById('idUserInput').value = user.iduser;
            document.getElementById('nomeInput').value = user.utilizador;
            document.getElementById('emailInput').value = user.email;
            document.getElementById('passInput').value = "";
            
            document.getElementById('passInput').required = false;
            document.getElementById('passInput').placeholder = "Deixe vazio para não alterar";
            document.getElementById('passHelp').style.display = "none";
            
            modal.show();
        }

        // --- FUNÇÕES DE BLOQUEAR/Desbloquear (NOVO) ---
        let urlDestino = ""; // Variável global para guardar o link

        function abrirModalStatus(id, novoEstado, nomeUser) {
            const modalTitle = document.getElementById('modalStatusTitle');
            const modalBody = document.getElementById('modalStatusBody');
            const btnConfirm = document.getElementById('btnConfirmStatus');
            const iconContainer = document.getElementById('statusIconContainer');
            const icon = document.getElementById('statusIcon');

            // Constrói o URL para onde vai redirecionar se confirmar
            urlDestino = "utilizadores.php?toggle_id=" + id + "&novo_estado=" + novoEstado;

            if (novoEstado === 0) {
                // MODO BLOQUEAR 
                modalTitle.innerText = "Bloquear Utilizador";
                modalBody.innerHTML = "Tem a certeza que deseja <strong>bloquear</strong> o acesso a " + nomeUser + "?";
                
                iconContainer.className = "mb-3 bg-danger bg-opacity-10 text-danger rounded-circle p-3 d-inline-block";
                icon.className = "bi bi-slash-circle fs-1";
                
                btnConfirm.className = "btn btn-danger rounded-pill px-4 fw-bold";
                btnConfirm.innerText = "Sim, Bloquear";
            } else {
                // MODO desbloquear 
                modalTitle.innerText = "Desbloquear Utilizador";
                modalBody.innerHTML = "Tem a certeza que deseja <strong>Desbloquear</strong> o acesso a " + nomeUser + "?";

                iconContainer.className = "mb-3 bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-block";
                icon.className = "bi bi-check-circle fs-1";

                btnConfirm.className = "btn btn-success rounded-pill px-4 fw-bold";
                btnConfirm.innerText = "Sim, Desbloquear";
            }

            const modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
            modalStatus.show();
        }

        // Ao clicar em Confirmar, vai para o link PHP
        document.getElementById('btnConfirmStatus').addEventListener('click', function() {
            window.location.href = urlDestino;
        });
    </script>
</body>
</html>