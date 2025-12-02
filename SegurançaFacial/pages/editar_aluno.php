<?php
require '../php/sessoes.php';
require '../php/conexao.php';

$id_aluno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_aluno) { header("Location: gerenciar_alunos.php"); exit(); }

$sql = "SELECT * FROM alunos WHERE id = :id AND id_instituicao = :id_instituicao";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_aluno, 'id_instituicao' => $id_instituicao]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) { header("Location: gerenciar_alunos.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/formularios_cadastro.css">
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Editar Aluno: <?php echo htmlspecialchars($aluno['nome_completo']); ?></h1></header>
        <main>
          <form id="formEditaAluno" action="../php/processa_atualizacao_aluno.php" method="POST">
    <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">

    <label for="nome_completo">Nome Completo:</label>
    <input type="text" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($aluno['nome_completo']); ?>" required>
    
    <label for="cpf">CPF (não pode ser alterado):</label>
    <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($aluno['cpf']); ?>" readonly>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($aluno['data_nascimento']); ?>" required>

    <label for="turma">Turma:</label>
    <input type="text" id="turma" name="turma" value="<?php echo htmlspecialchars($aluno['turma']); ?>">
    
    <div id="formStatus" class="status-message" style="display: none;"></div>
    
    <button type="submit">Salvar Alterações</button>
</form>
        </main>
    </div>
</body>
</html>