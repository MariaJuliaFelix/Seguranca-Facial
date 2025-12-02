<?php
require '../php/sessoes.php';
require '../php/conexao.php';

$busca_nome = $_GET['busca_nome'] ?? '';
$busca_cpf = $_GET['busca_cpf'] ?? '';

$sql = "SELECT 
            r.id, r.nome_completo, r.cpf, r.telefone, r.email, r.parentesco,
            GROUP_CONCAT(DISTINCT a.nome_completo SEPARATOR ', ') as alunos_associados
        FROM 
            responsaveis r
        JOIN 
            aluno_responsavel ar ON r.id = ar.id_responsavel
        JOIN 
            alunos a ON ar.id_aluno = a.id
        WHERE 
            a.id_instituicao = :id_instituicao";

$params = ['id_instituicao' => $id_instituicao];

if (!empty($busca_nome)) {
    $sql .= " AND r.nome_completo LIKE :busca_nome";
    $params['busca_nome'] = '%' . $busca_nome . '%';
}

if (!empty($busca_cpf)) {
    $sql .= " AND r.cpf LIKE :busca_cpf";
    $params['busca_cpf'] = '%' . $busca_cpf . '%';
}

$sql .= " GROUP BY r.id, r.nome_completo, r.cpf, r.telefone, r.email, r.parentesco";
$sql .= " ORDER BY r.nome_completo";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$responsaveis = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Responsáveis</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    
    <link rel="stylesheet" href="../css/gerenciar_responsaveis.css"> 
    
    <link rel="stylesheet" href="../css/filtros-pesquisa.css">
    
    <script type="module" defer src="../js/script.js"></script>
</head>
<body>
    <?php require '../templates/sidebar.php'; ?>
    <div class="main-content">
        
        <header><h1>Gerenciar Responsáveis</h1></header>
        
        <main>
            <?php if (isset($_GET['sucesso'])): ?><p class="success"><?php echo htmlspecialchars($_GET['sucesso']); ?></p><?php endif; ?>

            <form action="" method="GET" class="search-filter-container">
    
    <div class="search-box-stylized">
        
        <div class="search-icon-circle">
            <img src="../assets/icone-usuario-pesquisa.svg" alt="Ícone Usuário" class="input-icon">
        </div>
        
        <input type="text" name="busca_nome" class="search-input" 
               placeholder="Nome do responsável..." 
               value="<?php echo htmlspecialchars($busca_nome); ?>">
    </div>


    <div class="search-box-stylized" style="min-width: 200px;">
        
        <div class="search-icon-circle">
            <img src="../assets/icone-cpf-pesquisa.svg" alt="Ícone CPF" class="input-icon">
        </div>
        
        <input type="text" name="busca_cpf" class="search-input" 
               placeholder="CPF..." 
               value="<?php echo htmlspecialchars($busca_cpf); ?>">
    </div>


    <div class="buttons-container">
        <button type="submit" class="btn-pill btn-primary">Filtrar</button>
        <a href="gerenciar_responsaveis.php" class="btn-pill btn-secondary" style="display:flex; align-items:center; text-decoration:none;">Limpar</a>
    </div>

</form>

            <table>
                <thead>
                    <tr>
                        <th>Responsável</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Parentesco</th>
                        <th>Aluno(s) Associado(s)</th> <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($responsaveis)): ?>
                        <tr>
                            <td colspan="7">Nenhum responsável encontrado com os critérios de busca.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($responsaveis as $responsavel): ?>
                            <tr>
                                <td data-label="Responsável"><?php echo htmlspecialchars($responsavel['nome_completo']); ?></td>
                                <td data-label="CPF"><?php echo htmlspecialchars($responsavel['cpf']); ?></td>
                                <td data-label="Telefone"><?php echo htmlspecialchars($responsavel['telefone']); ?></td>
                                <td data-label="Email"><?php echo htmlspecialchars($responsavel['email']); ?></td>
                                <td data-label="Parentesco"><?php echo htmlspecialchars($responsavel['parentesco']); ?></td>
                                
                                <td data-label="Aluno(s)"><?php echo htmlspecialchars($responsavel['alunos_associados']); ?></td>
                                
                                <td data-label="Ações">
                                    <a class="btn-action btn-edit" href="editar_responsavel.php?id=<?php echo $responsavel['id']; ?>">Editar</a>
                                    <a class="btn-action btn-delete" href="../php/processa_exclusao.php?id=<?php echo $responsavel['id']; ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </main>
    </div>
</body>
</html>