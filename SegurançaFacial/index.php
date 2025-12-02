<?php
session_start();
if (isset($_SESSION['id_instituicao'])) {
    header("Location: pages/painel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Segurança Facial</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="auth-wrapper">
        <button id="theme-toggle" class="mudar-tema">
            <div class="bola"></div>
        </button>
        <div class="form-section">
            <div class="form-container">
                <h1>Bem-vindo!</h1>
                <p>Faça login para continuar.</p>

                <form action="php/processa_login.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                    
                    <button type="submit">Entrar</button>
                </form>

                <p style="margin-top: 20px;">Não tem uma conta? <a href="cadastro_inst.php">Cadastre-se</a></p>

                <?php
                if (isset($_GET['erro'])) { echo '<p class="error">Usuário ou senha inválidos!</p>'; }
                if (isset($_GET['sucesso'])) { echo '<p class="success">Cadastro realizado! Faça o login.</p>'; }
                ?>
            </div>
        </div>
        <div class="branding-section">
    <div id="particles-js"></div>
    
    <div class="branding-content">
    
    <img src="assets/logo-escuro.svg" alt="Logo Segurança Facial" class="branding-logo">
    <h2> Segurança Facial</h2>
    <p>Mais que tecnologia, uma solução segura para o cuidado das nossas crianças.</p>
    
</div>
    
</div>
  <script src="js/modules/particles.js"></script>
  <script defer src="js/theme-login.js"></script>
</body>

</html>