<?php
require '../php/sessoes.php';
require '../php/conexao.php';


$sql_alunos = "SELECT COUNT(*) as total FROM alunos WHERE id_instituicao = :id";
$stmt = $pdo->prepare($sql_alunos);
$stmt->execute(['id' => $id_instituicao]);
$total_alunos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$sql_resp = "SELECT COUNT(DISTINCT id_responsavel) as total FROM aluno_responsavel 
             JOIN alunos ON aluno_responsavel.id_aluno = alunos.id 
             WHERE alunos.id_instituicao = :id";
$stmt = $pdo->prepare($sql_resp);
$stmt->execute(['id' => $id_instituicao]);
$total_responsaveis = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Segurança Facial</title>

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/painel.css">
    
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Página Inicial</h1>
        </header>

        <main>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-content">
                        <img src="../assets/icone-alunos-cadastrados.svg" class="card-icon" alt="Ícone Alunos">
                        <div>
                            <span class="numero"><?php echo $total_alunos; ?></span>
                            <h3>Alunos Cadastrados</h3>
                        </div>
                    </div>
                    <a href="gerenciar_alunos.php" class="card-link">Ver Alunos ➔</a>
                </div>

                <div class="dashboard-card">
                    <div class="card-content">
                        <img src="../assets/icone-responsaveis-cadastrados.svg" class="card-icon" alt="Ícone Alunos">
                        <div>
                            <span class="numero"><?php echo $total_responsaveis; ?></span>
                            <h3>Responsáveis Vinculados</h3>
                        </div>
                    </div>
                    <a href="gerenciar_responsaveis.php" class="card-link">Ver Responsáveis ➔</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>