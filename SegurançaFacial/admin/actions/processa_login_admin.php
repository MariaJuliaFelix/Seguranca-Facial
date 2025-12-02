<?php
session_start();
require '../../php/conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password_digitada = $_POST['password']; 

    
    $sql = "SELECT * FROM super_admins WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($admin && $password_digitada === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: ../dashboard.php"); 
        exit();

    } else {
        header("Location: ../index.php?erro=1"); 
        exit();
    }
}
?>