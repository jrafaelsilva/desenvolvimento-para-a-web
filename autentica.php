<?php
session_start();
include 'includes/connection.php';

$utilizador = trim($_POST['utilizador']);
$pass = $_POST['pass'];

$stmt = mysqli_prepare($link, "SELECT iduser, utilizador, pass FROM utilizadores WHERE utilizador = ?");
mysqli_stmt_bind_param($stmt, "s", $utilizador);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($result)) {
    if (password_verify($pass, $row['pass'])) {
        $_SESSION['iduser'] = $row['iduser'];
        $_SESSION['utilizador'] = $row['utilizador'];
        $_SESSION['logado'] = true;

        header("Location: index.php");
        exit();
    }
}

header("Location: login.php?erro=1");
exit();