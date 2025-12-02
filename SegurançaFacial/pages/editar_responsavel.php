<?php
require '../php/sessoes.php';
require '../php/conexao.php';

$id_responsavel = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_responsavel) { header("Location: gerenciar_responsaveis.php"); exit(); }


$sql = "SELECT * FROM responsaveis WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_responsavel]);
$responsavel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$responsavel) { header("Location: gerenciar_responsaveis.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Responsável</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/formularios_cadastro.css">
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Editar Responsável: <?php echo htmlspecialchars($responsavel['nome_completo']); ?></h1></header>
        <main>
            <form id="formEditaResponsavel" action="../php/processa_atualizacao_responsavel.php" method="POST">
                <input type="hidden" name="id_responsavel" value="<?php echo $responsavel['id']; ?>">

                <label for="nome_completo">Nome Completo:</label>
                <input type="text" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($responsavel['nome_completo']); ?>" required>

                <label for="cpf">CPF (não pode ser alterado):</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($responsavel['cpf']); ?>" readonly>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($responsavel['telefone']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($responsavel['email']); ?>" required>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($responsavel['endereco']); ?>" required>

                <label for="parentesco">Parentesco:</label>
                <input type="text" id="parentesco" name="parentesco" value="<?php echo htmlspecialchars($responsavel['parentesco']); ?>" required>

                <div id="formStatus" class="status-message" style="display: none;"></div>
                <button type="submit">Salvar Alterações</button>
            </form>
        </main>
    </div>
</body>
</html>