<?php
require '../php/sessoes.php';
require '../php/conexao.php';

$sql = "SELECT h.data_saida, a.nome_completo AS nome_aluno, r.nome_completo AS nome_responsavel
        FROM historico_saidas h
        JOIN alunos a ON h.id_aluno = a.id
        JOIN responsaveis r ON h.id_responsavel = r.id
        WHERE a.id_instituicao = :id_instituicao
        ORDER BY h.data_saida DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_instituicao' => $id_instituicao]);
$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Saídas</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/historico.css">
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Histórico de Saídas</h1></header>
        <main>
            <table>
                <thead><tr><th>Data e Hora da Saída</th><th>Aluno</th><th>Responsável</th></tr></thead>
                <tbody>
                    <?php foreach ($historico as $registro): ?>
                    <tr>
                        <td data-label="Data Saida"><?php echo date('d/m/Y H:i:s', strtotime($registro['data_saida'])); ?></td>
                        <td data-label="Nome Aluno"><?php echo htmlspecialchars($registro['nome_aluno']); ?></td>
                        <td data-label="Nome Responsavel"><?php echo htmlspecialchars($registro['nome_responsavel']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($historico)): ?>
                    <tr><td colspan="3">Nenhum registro encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>