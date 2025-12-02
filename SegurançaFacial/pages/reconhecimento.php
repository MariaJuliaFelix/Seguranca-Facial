<?php require '../php/sessoes.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Reconhecimento Facial</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/reconhecimento.css">
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
     <div class="main-content">
        <header><h1>Realizar Reconhecimento para Retirada</h1></header>
        <main>
            <p>Aponte a câmera para o rosto do responsável.</p>
            <div class="video-container">
                <video id="video" width="720" height="560" autoplay muted></video>
                <canvas id="canvas"></canvas>
            </div>
            <div id="resultado" class="status-message">Aguardando reconhecimento...</div>
        </main>
    </div>
</body>
</html>