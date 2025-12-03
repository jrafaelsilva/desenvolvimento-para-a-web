<?php
// 1. Ler o JSON recebido (antes da conexão)
$input = json_decode(file_get_contents("php://input"), true);

// Usa o operador '??' para evitar erros se 'id' não existir
$idReceita = $input["id"] ?? null;

// Validação simples
if ($idReceita === null) {
    echo json_encode(["total" => 0, "erro" => "ID não informado"]);
    exit;
}

// 2. Ligar à Base de Dados
require('../includes/connection.php');

// Definir cabeçalho JSON
header('Content-Type: application/json');

// 3. Query SQL para contar os favoritos
$sql = 'SELECT COUNT(id) AS total FROM favoritos WHERE id_receita = :id AND ativado = 1';

$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $idReceita);
$stmt->execute();

$total = 0;

if ($stmt) {
    // Busca o resultado como objeto e acede à propriedade 'total' definida no SQL
    $total = $stmt->fetchObject()->total;
}

// 4. Devolver a resposta
echo json_encode([
    "total" => $total
]);

// 5. Limpeza
$stmt = null;
exit;
?>