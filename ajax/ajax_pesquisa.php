<?php
require('../includes/connection.php');

header('Content-Type: application/json');

// Recebe o termo via GET 
$termo = isset($_GET['termo']) ? trim($_GET['termo']) : '';

if (strlen($termo) < 1) {
    echo json_encode([]); 
    exit;
}

try {
    // Procura no título (limita a 5 para não encher o ecrã)
    $stmt = $dbh->prepare("SELECT id, titulo, imagem FROM receitas WHERE titulo LIKE ? LIMIT 5");
    $stmt->execute(["%" . $termo . "%"]);
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($resultados);

} catch (PDOException $e) {
    echo json_encode([]);
}
?>