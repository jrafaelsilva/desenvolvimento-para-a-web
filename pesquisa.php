<?php
session_start();
require('includes/connection.php');

// Se não houver termo, define como vazio
$termo = isset($_GET['q']) ? trim($_GET['q']) : '';

// Se a pesquisa estiver vazia, volta para o index 
if (empty($termo)) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesquisa: <?php echo htmlspecialchars($termo); ?> - Pitada na Mesa</title>
  <link rel="shortcut icon" href="imgs/pitada.logo.png">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php require('includes/nav.php'); ?>

    <div class="container min-vh-100"> <div class="mt-5 mb-4">
            <h4>Resultados para: <span class="fw-bold fst-italic">"<?php echo htmlspecialchars($termo); ?>"</span></h4>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-3">
            
            <?php
            $sql = "SELECT * FROM receitas WHERE titulo LIKE :termo OR categoria LIKE :termo";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([':termo' => "%" . $termo . "%"]);

            // Verifica se encontrou alguma coisa
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $nome = $row['titulo'];
                    $imagem = $row['imagem'];
                    $descricao = !empty($row['descricao']) ? $row['descricao'] : "Uma receita deliciosa para experimentar.";
            ?>
                    <div class="col">
                        <div class="card h-100 position-relative shadow-sm border-0">
                            <div style="height: 200px; overflow: hidden;" class="rounded-top">
                                <img src="<?php echo $imagem; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $nome; ?>">
                            </div>
                            
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title fw-bold"><?php echo $nome; ?></h5>
                                <p class="card-text text-truncate-2"><?php echo $descricao; ?></p>
                                <a href="receita.php?id=<?php echo $id; ?>" class="btn btn-style2 mt-auto">Abrir receita</a>
                            </div>
                        </div>
                    </div>
            <?php
                } 
            } else {
                // SE NÃO ENCONTRAR NADA
            ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search display-1 text-muted opacity-25"></i>
                    <h3 class="mt-3 text-muted">Ops! Não encontrámos nada.</h3>
                    <p>Tente pesquisar outra receita.</p>
                    <a href="index.php" class="btn btn-success mt-2">Voltar ao Início</a>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <?php require('includes/footer.php'); ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>