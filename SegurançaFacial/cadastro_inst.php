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
    <title>Cadastro - Segurança Facial</title>
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
                <h1>Cadastro</h1>
                <p>Crie uma conta para sua instituição.</p>

                <form action="php/processa_cadastro_inst.php" method="POST">
                    <label for="nome">Instituição</label>
                    <input type="text" name="nome" id="nome" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                    
                    <button type="submit">Cadastrar</button>
                </form>

                <p style="margin-top: 20px;">Já tem uma conta? <a href="index.php">Faça login</a></p>
            </div>
        </div>
        <div class="branding-section">
    <div id="particles-js"></div>
    
    <div class="branding-content">
        <img src="assets/logo-escuro.svg" alt="Logo Segurança Facial" class="branding-logo">
        
        <h2>Segurança Facial</h2>
        
        <p>Mais que tecnologia, uma solução segura para o cuidado das nossas crianças.</p>
    </div>
</div>
    <script src="js/modules/particles.js"></script>
    <script defer src="js/theme-login.js"></script>
</body>
</html>