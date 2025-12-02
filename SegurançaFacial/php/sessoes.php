<?php
session_start();
if (!isset($_SESSION['id_instituicao'])) {
    header("Location: ../index.php?erro=login_necessario");
    exit();
}
$id_instituicao = $_SESSION['id_instituicao'];
$nome_instituicao = $_SESSION['nome_instituicao'];
?>