<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO instituicoes (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha]);
        header("Location: ../index.php?sucesso=cadastro");
    } catch (PDOException $e) {
        die("Erro ao cadastrar: " . $e->getMessage());
    }
}
?>