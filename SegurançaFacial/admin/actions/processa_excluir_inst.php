<?php
require '../auth.php';

$id_instituicao = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_instituicao) {
    die("ID de instituição inválido.");
}

$pdo->beginTransaction();
try {
    $sql_responsaveis = "SELECT DISTINCT r.id 
                         FROM responsaveis r
                         JOIN aluno_responsavel ar ON r.id = ar.id_responsavel
                         JOIN alunos a ON ar.id_aluno = a.id
                         WHERE a.id_instituicao = :id_instituicao";
    $stmt_responsaveis = $pdo->prepare($sql_responsaveis);
    $stmt_responsaveis->execute(['id_instituicao' => $id_instituicao]);
    $responsaveis_ids = $stmt_responsaveis->fetchAll(PDO::FETCH_COLUMN);

    $project_root = dirname(__DIR__, 2);
    foreach ($responsaveis_ids as $id_responsavel) {
        $files_to_delete = glob($project_root . "/python_service/known_faces/{$id_responsavel}_*.npy");
        foreach ($files_to_delete as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    $sql_delete = "DELETE FROM instituicoes WHERE id = :id_instituicao";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute(['id_instituicao' => $id_instituicao]);

    $pdo->commit();
    header("Location: ../dashboard.php?sucesso=Instituição e todos os seus dados foram excluídos com sucesso!");

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro ao excluir a instituição: " . $e->getMessage());
}
?>