<?php require '../php/sessoes.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Responsável</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/formularios_cadastro.css">
    <link rel="stylesheet" href="../css/reconhecimento.css">
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Cadastro de Responsável Autorizado</h1></header>
        <main>
           <form id="cadastroForm" action="../php/processa_cadastro_responsavel.php" method="POST">
    <h3>Dados do Responsável</h3>
    
    <label for="nome_responsavel">Nome Completo:</label>
<input type="text" id="nome_responsavel" name="nome_completo" required>

<label for="cpf_responsavel">CPF do Responsável:</label>
<input type="text" id="cpf_responsavel" name="cpf" placeholder="000.000.000-00" required>

<label for="telefone">Telefone:</label>
<input type="text" id="telefone" name="telefone" placeholder="(00)00000-0000" required>

<label for="email">Email:</label>
<input type="email" id="email" name="email" placeholder="exemplo@gmail.com" required>

<label for="endereco">Endereço:</label>
<input type="text" id="endereco" name="endereco" required>

<label for="parentesco">Parentesco (Mãe, Pai, etc.):</label>
<input type="text" id="parentesco" name="parentesco" required>

    <h3>Vincular a Aluno(s)</h3>
    <label for="cpfs_alunos">CPF do(s) Aluno(s) (separe por vírgula):</label>
    <input type="text" id="cpfs_alunos" name="cpfs_alunos" placeholder="000.000.000-00, 111.111.111-11" required>
    
    <hr>

    <h3>Cadastro Facial (5 Posições)</h3>
    <p>Capture uma foto para cada uma das 5 posições solicitadas.</p>
    <div class="video-container">
        <video id="video" width="600" height="450" autoplay muted></video>
    </div>
    <div id="capture-controls">
        <div class="capture-box">
            <button type="button" class="capture-btn" data-target="imagem_base64_1">1. Rosto Centralizado</button>
            <img id="preview_1" class="preview-img" alt="Prévia Central"/>
        </div>
        <div class="capture-box">
            <button type="button" class="capture-btn" data-target="imagem_base64_2">2. Rosto p/ Esquerda</button>
            <img id="preview_2" class="preview-img" alt="Prévia Esquerda"/>
        </div>
        <div class="capture-box">
            <button type="button" class="capture-btn" data-target="imagem_base64_3">3. Rosto p/ Direita</button>
            <img id="preview_3" class="preview-img" alt="Prévia Direita"/>
        </div>
        <div class="capture-box">
            <button type="button" class="capture-btn" data-target="imagem_base64_4">4. Rosto p/ Cima</button>
            <img id="preview_4" class="preview-img" alt="Prévia Cima"/>
        </div>
        <div class="capture-box">
            <button type="button" class="capture-btn" data-target="imagem_base64_5">5. Rosto p/ Baixo</button>
            <img id="preview_5" class="preview-img" alt="Prévia Baixo"/>
        </div>
    </div>

    <input type="hidden" name="imagem_base64_1" id="imagem_base64_1">
    <input type="hidden" name="imagem_base64_2" id="imagem_base64_2">
    <input type="hidden" name="imagem_base64_3" id="imagem_base64_3">
    <input type="hidden" name="imagem_base64_4" id="imagem_base64_4">
    <input type="hidden" name="imagem_base64_5" id="imagem_base64_5">
    
    <div id="formStatus" class="status-message" style="display: none;"></div>

    <button type="submit" id="submitBtn" disabled>Salvar Cadastro do Responsável</button>
</form>
        </main>
    </div>
</body>
</html>