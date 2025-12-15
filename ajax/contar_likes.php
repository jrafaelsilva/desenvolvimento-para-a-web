<?php
// 1. Ligar à base de dados
require('../includes/connection.php');

// 2. Lê o corpo da requisição (JSON)
$input = file_get_contents("php://input");

// 3. Converte JSON para array associativo
$data = json_decode($input, true);
$id = isset($data["id"]) ? $data["id"] : null; // Previne erro se não vier ID

if ($id === null) {
    echo json_encode(['total' => 0]);
    exit;
}

// 4. Query SQL (Conta apenas os ativos)
$sql = 'SELECT COUNT(id) AS total FROM favoritos WHERE id_receita = :id AND ativado = 1';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();

$total = 0;

if($stmt){
    // Busca o resultado como objeto, tal como no teu exemplo
    $total = $stmt->fetchObject()->total;
}

// 5. Devolve o JSON final
echo json_encode(['total' => $total]);

$stmt = null;
exit;
?>