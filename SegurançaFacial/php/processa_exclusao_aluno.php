<?php
require 'sessoes.php';
require 'conexao.php';

$id_aluno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_aluno) {
    header("Location: ../pages/gerenciar_alunos.php?erro=ID de aluno inválido.");
    exit();
}

function delete_files_by_pattern($pattern) {
    $files = glob($pattern);
    foreach ($files as $file) {
        if (is_writable($file)) {
            if (!unlink($file)) {
                throw new Exception("Não foi possível excluir o arquivo do sistema: " . basename($file));
            }
        } else {
            throw new Exception("Sem permissão para excluir o arquivo: " . basename($file) . ". Verifique as permissões da pasta.");
        }
    }
}

$pdo->beginTransaction();
try {
    $project_root = dirname(__DIR__);
    $sql_responsaveis = "SELECT id_responsavel FROM aluno_responsavel WHERE id_aluno = :id_aluno";
    $stmt_responsaveis = $pdo->prepare($sql_responsaveis);
    $stmt_responsaveis->execute(['id_aluno' => $id_aluno]);
    $responsaveis_ligados = $stmt_responsaveis->fetchAll(PDO::FETCH_COLUMN);

    foreach ($responsaveis_ligados as $id_responsavel) {
        $sql_check = "SELECT COUNT(*) FROM aluno_responsavel WHERE id_responsavel = :id_responsavel AND id_aluno != :id_aluno";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute(['id_responsavel' => $id_responsavel, 'id_aluno' => $id_aluno]);
        $contagem = $stmt_check->fetchColumn();

        if ($contagem == 0) {
            $path_pattern_npy_novo = $project_root . "/python_service/known_faces/{$id_responsavel}_*.npy";
            delete_files_by_pattern($path_pattern_npy_novo);
            
            $path_pattern_npy_antigo = $project_root . "/python_service/known_faces/{$id_responsavel}.npy";
            delete_files_by_pattern($path_pattern_npy_antigo);
        
            $sql_delete_resp = "DELETE FROM responsaveis WHERE id = :id_responsavel";
            $stmt_delete_resp = $pdo->prepare($sql_delete_resp);
            $stmt_delete_resp->execute(['id_responsavel' => $id_responsavel]);
        }
    }

    $sql_delete_aluno = "DELETE FROM alunos WHERE id = :id_aluno";
    $stmt_delete_aluno = $pdo->prepare($sql_delete_aluno);
    $stmt_delete_aluno->execute(['id_aluno' => $id_aluno]);

    $pdo->commit();
    header("Location: ../pages/gerenciar_alunos.php?sucesso=Aluno e responsáveis foram excluídos com sucesso!");

} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: ../pages/gerenciar_alunos.php?erro=" . urlencode($e->getMessage()));
    exit();
}
?>