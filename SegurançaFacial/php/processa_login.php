<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM instituicoes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $instituicao = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($instituicao && password_verify($senha, $instituicao['senha'])) {
        $_SESSION['id_instituicao'] = $instituicao['id'];
        $_SESSION['nome_instituicao'] = $instituicao['nome'];
        header("Location: ../pages/painel.php");
    } else {
        header("Location: ../index.php?erro=login_invalido");
    }
}
?>