<?php require '../php/sessoes.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/formularios_cadastro.css">
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Cadastro de Aluno</h1></header>
        <main>
            <form id="formCadastroAluno" action="../php/processa_cadastro_aluno.php" method="POST">
            <h3>Dados do Aluno</h3>
            <div id="formStatus" class="status-message" style="display: none;"></div>

            <label for="nome_aluno">Nome Completo do Aluno:</label>
            <input type="text" id="nome_aluno" name="nome_aluno" required>
    
    <label for="cpf">CPF do Aluno:</label>
    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
    
    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" required>
    
    <label for="turma">Turma:</label>
    <input type="text" id="turma" name="turma">
    
    <button type="submit">Salvar Aluno</button>
</form>
             <?php
                if (isset($_GET['sucesso'])) { echo '<p class="success">Aluno cadastrado com sucesso!</p>'; }
                if (isset($_GET['erro'])) { echo '<p class="error">' . htmlspecialchars($_GET['erro']) . '</p>';}
            ?>
        </main>
    </div>
</body>
</html>