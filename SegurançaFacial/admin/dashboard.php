<?php
require 'auth.php';

$sql = "SELECT i.id, i.nome, i.email, i.data_cadastro,
            (SELECT COUNT(*) FROM alunos WHERE id_instituicao = i.id) AS total_alunos
        FROM instituicoes i ORDER BY i.data_cadastro DESC";
$stmt = $pdo->query($sql);
$instituicoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    
    <link rel="stylesheet" href="../css/gerenciar_alunos.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script type="module" defer src="../js/script.js"></script>
</head>
<body>

    <button id="sidebarToggleBtn" class="sidebar-toggle">☰</button>
    <button id="themeToggle" class="btn-theme-toggle">
        <div class="bolaa"></div>
    </button>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <img src="../assets/logo-claro.svg" alt="Logo" class="sidebar-logo logo-light">
                <img src="../assets/logo-escuro.svg" alt="Logo" class="sidebar-logo logo-dark">
            </div>
            <h2>Admin</h2>
        </div>
        
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
        
        <ul>
            <li>
                <a href="dashboard.php" class="active">
                    <i class="fa-solid fa-chart-line sidebar-icon"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <img src="../assets/sair.svg" class="sidebar-icon" alt="Sair"> Sair
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header><h1>Gerenciamento de Instituições</h1></header>
        <main>
            <?php if(isset($_GET['sucesso'])): ?>
                <p class="success"><?php echo htmlspecialchars($_GET['sucesso']); ?></p>
            <?php endif; ?>
            
            <table>
                <thead>
                    <tr>
                        <th>Nome da Instituição</th>
                        <th>Email</th>
                        <th>Alunos</th>
                        <th>Data de Cadastro</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instituicoes as $inst): ?>
                    <tr>
                        <td data-label="Nome"><?php echo htmlspecialchars($inst['nome']); ?></td>
                        <td data-label="Email"><?php echo htmlspecialchars($inst['email']); ?></td>
                        <td data-label="Alunos"><?php echo $inst['total_alunos']; ?></td>
                        <td data-label="Data"><?php echo date('d/m/Y H:i', strtotime($inst['data_cadastro'])); ?></td>
                        <td data-label="Ação">
                            <a class="btn-action btn-delete" href="actions/processa_excluir_inst.php?id=<?php echo $inst['id']; ?>" onclick="return confirm('ATENÇÃO: Excluir esta instituição irá apagar TODOS os seus dados permanentemente. Continuar?');">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>