<?php
require 'sessoes.php';
require 'conexao.php';

if (!isset($_GET['id'])) {
    header("Location: ../pages/gerenciar_responsaveis.php?erro=ID não fornecido");
    exit();
}
$id_responsavel = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_responsavel) {
    header("Location: ../pages/gerenciar_responsaveis.php?erro=ID inválido");
    exit();
}

$pdo->beginTransaction();
try {
    $sql = "DELETE FROM responsaveis WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_responsavel]);

    $project_root = dirname(__DIR__);
    
    function delete_files_by_pattern($pattern) {
        $files_to_delete = glob($pattern);
        foreach ($files_to_delete as $file) {
            if (is_writable($file)) {
                if (!unlink($file)) {
                    throw new Exception("Não foi possível excluir o arquivo: " . basename($file));
                }
            } else {
                throw new Exception("Sem permissão para excluir o arquivo: " . basename($file) . ". Verifique as permissões da pasta.");
            }
        }
    }

    $path_pattern_npy = $project_root . DIRECTORY_SEPARATOR . "python_service" . DIRECTORY_SEPARATOR . "known_faces" . DIRECTORY_SEPARATOR . "{$id_responsavel}_*.npy";
    delete_files_by_pattern($path_pattern_npy);
    
    $path_pattern_npy_antigo = $project_root . DIRECTORY_SEPARATOR . "python_service" . DIRECTORY_SEPARATOR . "known_faces" . DIRECTORY_SEPARATOR . "{$id_responsavel}.npy";
    delete_files_by_pattern($path_pattern_npy_antigo);

    $pdo->commit();
    header("Location: ../pages/gerenciar_responsaveis.php?sucesso=Responsável e todos os seus dados foram excluídos com sucesso!");

} catch (Exception $e) {
    $pdo->rollBack();
    header("Location: ../pages/gerenciar_responsaveis.php?erro=" . urlencode($e->getMessage()));
    exit();
}
?>