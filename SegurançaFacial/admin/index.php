<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Segurança Facial</title>
    
    <link rel="stylesheet" href="../css/login.css">
    
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<body class="admin-page"> <div class="auth-wrapper">

        <button id="theme-toggle" class="mudar-tema">
            <div class="bola"></div>
        </button>

        <div class="branding-section">
            <div id="particles-js"></div>
            
            <div class="branding-content">
                <img src="../assets/logo-escuro.svg" alt="Logo Segurança Facial" class="branding-logo">
                <div class="branding-text">
                    <h2>SEGURANÇA FACIAL</h2>
                    <p>Ferramenta de Administração</p>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-container">
                <h1>Área Administrativa</h1>
                <p>Faça login para continuar.</p>

                <form action="actions/processa_login_admin.php" method="POST">
                    <label for="username">Usuário:</label>
                    <input type="text" name="username" id="username" required>

                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password" required>

                    <button type="submit">Entrar</button>
                </form>

                <?php if(isset($_GET['erro'])): ?>
                    <p class="status-message error" style="margin-top: 20px;">Usuário ou senha inválidos.</p>
                <?php endif; ?>
            </div>
        </div>

    </div> 
    
    <script defer src="../js/theme-login.js"></script>
    <script src="../js/modules/particles.js"></script> 
</body>
</html>