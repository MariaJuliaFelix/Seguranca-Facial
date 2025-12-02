<?php
require '../php/sessoes.php';
require '../php/conexao.php';

$termo_busca = $_GET['busca'] ?? '';
$filtro_turma = $_GET['turma'] ?? '';

$sql = "SELECT id, nome_completo, cpf, data_nascimento, turma 
        FROM alunos 
        WHERE id_instituicao = :id_instituicao";

$params = ['id_instituicao' => $id_instituicao];

if (!empty($termo_busca)) {
    $sql .= " AND (nome_completo LIKE :busca OR cpf LIKE :busca)";
    $params['busca'] = '%' . $termo_busca . '%';
}
if (!empty($filtro_turma)) {
    $sql .= " AND turma = :turma";
    $params['turma'] = $filtro_turma;
}

$sql .= " ORDER BY nome_completo ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_turmas = "SELECT DISTINCT turma FROM alunos WHERE id_instituicao = :id_instituicao AND turma IS NOT NULL AND turma != '' ORDER BY turma ASC";
$stmt_turmas = $pdo->prepare($sql_turmas);
$stmt_turmas->execute(['id_instituicao' => $id_instituicao]);
$turmas = $stmt_turmas->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Alunos</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/gerenciar_alunos.css"> <link rel="stylesheet" href="../css/filtros-pesquisa.css"> <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        <header><h1>Gerenciar Alunos</h1></header>
        <main>
            <?php if (isset($_GET['sucesso'])): ?><p class="success"><?php echo htmlspecialchars($_GET['sucesso']); ?></p><?php endif; ?>
            <?php if (isset($_GET['erro'])): ?><p class="error"><?php echo htmlspecialchars($_GET['erro']); ?></p><?php endif; ?>

            <form action="gerenciar_alunos.php" method="GET" class="search-filter-container">
    
    <div class="search-box-stylized">
        <div class="search-icon-circle">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        
        <input type="text" name="busca" class="search-input" 
               placeholder="Search..." 
               value="<?php echo htmlspecialchars($termo_busca); ?>">
    </div>

    <div class="filter-box-stylized">
        <select name="turma" class="filter-select">
            <option value="">Todas as Turmas</option>
            <?php foreach ($turmas as $turma): ?>
                <option value="<?php echo htmlspecialchars($turma); ?>" <?php echo ($filtro_turma == $turma) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($turma); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="buttons-container">
        <button type="submit" class="btn-pill btn-primary">Filtrar</button>
        <a href="gerenciar_alunos.php" class="btn-pill btn-secondary" style="display:flex; align-items:center; text-decoration:none;">Limpar</a>
    </div>

</form>
            
            <table>
                <thead>
                    <tr><th>Nome Completo</th><th>CPF</th><th>Data de Nasc.</th><th>Turma</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td data-label="Nome Completo"><?php echo htmlspecialchars($aluno['nome_completo']); ?></td>
                        <td data-label="CPF"><?php echo htmlspecialchars($aluno['cpf']); ?></td>
                        <td data-label="Data de Nasc."><?php echo date('d/m/Y', strtotime($aluno['data_nascimento'])); ?></td>
                        <td data-label="Turma"><?php echo htmlspecialchars($aluno['turma']); ?></td>
                        <td data-label="Ações">
                            <a class="btn-action btn-edit" href="editar_aluno.php?id=<?php echo $aluno['id']; ?>">Editar</a>
                            <a class="btn-action btn-delete" href="../php/processa_exclusao_aluno.php?id=<?php echo $aluno['id']; ?>" onclick="return confirm('ATENÇÃO: Excluir um aluno também removerá permanentemente os responsáveis associados APENAS a ele. Deseja continuar?');">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($alunos)): ?>
                    <tr><td colspan="5">Nenhum aluno encontrado com os critérios de busca.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>