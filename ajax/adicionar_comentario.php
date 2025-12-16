<?php
session_start();
require('../includes/connection.php');

header('Content-Type: application/json');

// 1. Verificar Login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Precisa de fazer login.']);
    exit;
}

// 2. Receber dados (JSON)
$input = json_decode(file_get_contents('php://input'), true);
$id_receita = $input['id_receita'] ?? 0;
$texto = trim($input['comentario'] ?? '');
$id_user = $_SESSION['iduser'] ?? $_SESSION['id'];

if (empty($texto) || empty($id_receita)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Comentário vazio.']);
    exit;
}

try {
    // 3. Inserir na Base de Dados
    $stmt = $dbh->prepare("INSERT INTO comentarios (id_receita, id_utilizador, comentario, data_comentario) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$id_receita, $id_user, $texto]);

    // 4. Buscar dados do utilizador para desenhar o cartão (Avatar e Nome)
    $stmtUser = $dbh->prepare("SELECT u.utilizador, dp.avatar 
                               FROM utilizadores u 
                               LEFT JOIN dados_perfil dp ON u.iduser = dp.id_utilizador 
                               WHERE u.iduser = ?");
    $stmtUser->execute([$id_user]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    $avatar_final = "imgs/avatar/avpadrao.jpg";
    $avatar_db = $user['avatar'] ?? '';
    
    // Ajuste de caminhos
    if (!empty($avatar_db) && $avatar_db != 'default') {
        if (file_exists("../imgs/avatar/" . $avatar_db)) {
            $avatar_final = "imgs/avatar/" . $avatar_db;
        } elseif (file_exists("../" . $avatar_db)) {
            $avatar_final = $avatar_db;
        }
    }

    // 5. Construir o HTML do novo comentário
    $html = '
    <div class="card mb-3 border-0 shadow-sm comentario-item" style="background-color: rgb(253, 249, 243); animation: fadeIn 0.5s;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <img src="' . $avatar_final . '" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover; border: 2px solid #8B4513;">
                <div>
                    <h6 class="fw-bold mb-0">' . htmlspecialchars($user['utilizador']) . '</h6>
                    <small class="text-muted">Agora mesmo</small>
                </div>
            </div>
            <p class="card-text ps-5">' . nl2br(htmlspecialchars($texto)) . '</p>
        </div>
    </div>';

    echo json_encode(['status' => 'sucesso', 'html' => $html]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro SQL: ' . $e->getMessage()]);
}
?>