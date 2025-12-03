<?php
session_start();
require('includes/connection.php');

// 1. Verificar Login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$nomeUtilizador = htmlspecialchars($_SESSION['utilizador']);
$id_utilizador = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : $_SESSION['id']; 

$mensagem = "";
$tipo_alerta = "";

// 2. BUSCAR DADOS ATUAIS (Fazemos isto ANTES de processar o POST para saber o que já existe)
$stmt = $dbh->prepare("SELECT idade, prato_favorito, avatar FROM dados_perfil WHERE id_utilizador = ?");
$stmt->execute([$id_utilizador]);
$dados_atuais = $stmt->fetch(PDO::FETCH_ASSOC);

// Define valores iniciais baseados no que está na BD ou vazio
$idade_db = $dados_atuais ? $dados_atuais['idade'] : "";
$prato_db = $dados_atuais ? $dados_atuais['prato_favorito'] : "";
$avatar_db = ($dados_atuais && !empty($dados_atuais['avatar'])) ? $dados_atuais['avatar'] : "avpadrao.jpg"; 

// 3. PROCESSAR O FORMULÁRIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Tratamento da Idade: Se estiver vazio, define como NULL
    $nova_idade = !empty($_POST['idade']) ? $_POST['idade'] : NULL;
    
    // Tratamento do Prato: Se estiver vazio, define como NULL
    $novo_prato = !empty($_POST['prato_favorito']) ? $_POST['prato_favorito'] : NULL;
    
    // Tratamento do Avatar:
    // Se o utilizador escolheu um novo no formulário, usa esse.
    // Se não escolheu nada, mantém o que já tinha ($avatar_db).
    $novo_avatar = isset($_POST['avatar']) ? $_POST['avatar'] : $avatar_db;

    // Verifica se vamos fazer INSERT ou UPDATE
    if ($dados_atuais) {
        // ATUALIZAR (UPDATE)
        $sql = "UPDATE dados_perfil SET idade = ?, prato_favorito = ?, avatar = ? WHERE id_utilizador = ?";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute([$nova_idade, $novo_prato, $novo_avatar, $id_utilizador])) {
            $mensagem = "Perfil atualizado com sucesso!";
            $tipo_alerta = "success";
            
            // Atualiza as variáveis visuais para mostrar as mudanças imediatamente
            $idade_db = $nova_idade;
            $prato_db = $novo_prato;
            $avatar_db = $novo_avatar;
        }
    } else {
        // CRIAR NOVO (INSERT)
        $sql = "INSERT INTO dados_perfil (id_utilizador, idade, prato_favorito, avatar) VALUES (?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        if($stmt->execute([$id_utilizador, $nova_idade, $novo_prato, $novo_avatar])) {
            $mensagem = "Perfil criado com sucesso!";
            $tipo_alerta = "success";
            
            // Atualiza as variáveis visuais
            $idade_db = $nova_idade;
            $prato_db = $novo_prato;
            $avatar_db = $novo_avatar;
        }
    }
}

// Lógica de exibição (Texto bonito)
$mostrar_idade = !empty($idade_db) ? $idade_db . " anos" : '<span class="text-muted fst-italic">Não definido</span>';
$mostrar_prato = !empty($prato_db) ? $prato_db : '<span class="text-muted fst-italic">Não definido</span>';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O Meu Perfil - Pitada na Mesa</title>
    <link rel="shortcut icon" href="imgs/pitada.logo.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        /* Estilo para a seleção de avatar */
        .avatar-option { display: none; }
        .avatar-label img {
            border: 3px solid transparent;
            border-radius: 50%;
            cursor: pointer;
            width: 60px; height: 60px;
            object-fit: cover;
            transition: transform 0.2s;
        }
        .avatar-option:checked + .avatar-label img {
            border-color: rgb(182, 125, 95);
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <?php require('includes/nav.php'); ?>

    <div class="container">
        
        <div class="row justify-content-center mt-5 mb-4">
            <div class="col-md-8 text-center d-flex flex-column align-items-center">
                
                <div class="mx-auto mb-3">
                    <?php if($avatar_db != 'default' && file_exists("imgs/avatar/" . $avatar_db)): ?>
                        <img src="imgs/avatar/<?php echo $avatar_db; ?>" 
                             style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid rgb(182, 125, 95); object-fit: cover;">
                    <?php else: ?>
                        <img src="imgs/avatar/av1.png" 
                             style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid rgb(182, 125, 95); object-fit: cover;">
                    <?php endif; ?>
                </div>

                <h2 class="fw-bold">Olá, <?php echo $nomeUtilizador; ?>!</h2>
                <p class="text-muted">Bem-vindo à sua área pessoal.</p>
            </div>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show w-75 mx-auto" role="alert">
                <?php echo $mensagem; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center g-4 mb-5">
            
            <div class="col-md-5">
                <div class="card profile-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold m-0" style="color: rgb(182, 125, 95);">Meus Dados</h4>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-fill me-1"></i> Alterar
                            </button>
                        </div>
                        
                        <div class="mb-3 border-bottom pb-2">
                            <label class="text-uppercase text-muted small fw-bold">Nome de Utilizador</label>
                            <div class="fs-5 text-dark"><?php echo $nomeUtilizador; ?></div>
                        </div>

                        <div class="mb-3 border-bottom pb-2">
                            <label class="text-uppercase text-muted small fw-bold">Idade</label>
                            <div class="fs-5 text-dark"><?php echo $mostrar_idade; ?></div>
                        </div>

                        <div class="mb-2">
                            <label class="text-uppercase text-muted small fw-bold">Prato Preferido</label>
                            <div class="fs-5 text-dark"><?php echo $mostrar_prato; ?></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card profile-card h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-center text-center">
                        <div class="mb-3"><i class="bi bi-patch-check display-4" style="color: rgb(182, 125, 95);"></i></div>
                        <h4 class="card-title fw-bold mb-3">Torne-se um Chef Pitada</h4>
                        <p class="card-text text-muted mb-4">Partilhe a sua receita secreta.</p>
                        <a href="submeterreceita.php" class="btn btn-style2 py-3"><i class="bi bi-plus-circle me-2"></i>Submeter Nova Receita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: rgb(253, 249, 243);">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="perfil.php" method="POST">
                        
                        <div class="mb-4 text-center">
                            <label class="form-label fw-bold d-block text-muted mb-3">Escolha o seu Avatar</label>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <input type="radio" name="avatar" id="av1" value="av1.png" class="avatar-option" <?php if($avatar_db == 'av1.png') echo 'checked'; ?>>
                                <label for="av1" class="avatar-label"><img src="imgs/avatar/av1.png" title="Avatar 1"></label>
                                <input type="radio" name="avatar" id="av2" value="av2.png" class="avatar-option" <?php if($avatar_db == 'av2.png') echo 'checked'; ?>>
                                <label for="av2" class="avatar-label"><img src="imgs/avatar/av2.png" title="Avatar 2"></label>
                                <input type="radio" name="avatar" id="av3" value="av3.png" class="avatar-option" <?php if($avatar_db == 'av3.png') echo 'checked'; ?>>
                                <label for="av3" class="avatar-label"><img src="imgs/avatar/av3.png" title="Avatar 3"></label>
                                <input type="radio" name="avatar" id="av4" value="av4.png" class="avatar-option" <?php if($avatar_db == 'av4.png') echo 'checked'; ?>>
                                <label for="av4" class="avatar-label"><img src="imgs/avatar/av4.png" title="Avatar 4"></label>
                                <input type="radio" name="avatar" id="av5" value="av5.png" class="avatar-option" <?php if($avatar_db == 'av5.png') echo 'checked'; ?>>
                                <label for="av5" class="avatar-label"><img src="imgs/avatar/av5.png" title="Avatar 5"></label>
                                <input type="radio" name="avatar" id="avpadrao" value="avpadrao.jpg" class="avatar-option" <?php if($avatar_db == 'avpadrao.jpg') echo 'checked'; ?>>
                                <label for="avpadrao" class="avatar-label"><img src="imgs/avatar/avpadrao.jpg" title="Avatar Padrao"></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Idade</label>
                            <input type="number" class="form-control custom-input" name="idade" 
                                   value="<?php echo htmlspecialchars($idade_db); ?>" placeholder="Opcional">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Prato Preferido</label>
                            <input type="text" class="form-control custom-input" name="prato_favorito" 
                                   value="<?php echo htmlspecialchars($prato_db ??''); ?>" placeholder="Opcional">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-style2">Guardar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>