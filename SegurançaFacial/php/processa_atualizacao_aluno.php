<?php
require 'sessoes.php';
require 'conexao.php';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit();
}

$id_aluno = $_POST['id_aluno'] ?? 0;
$nome_completo = $_POST['nome_completo'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';
$turma = $_POST['turma'] ?? '';


$id_aluno_validado = filter_var($id_aluno, FILTER_VALIDATE_INT);
if (!$id_aluno_validado || empty($nome_completo) || empty($data_nascimento)) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Dados inválidos ou campos obrigatórios não preenchidos.']);
    exit();
}

try {
    $sql = "UPDATE alunos 
            SET nome_completo = :nome, data_nascimento = :data_nasc, turma = :turma 
            WHERE id = :id AND id_instituicao = :id_instituicao";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => $nome_completo,
        'data_nasc' => $data_nascimento,
        'turma' => $turma,
        'id' => $id_aluno_validado,
        'id_instituicao' => $id_instituicao
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Aluno atualizado com sucesso!']);
    } else {
        
        echo json_encode(['success' => true, 'message' => 'Nenhuma alteração foi detectada.']);
    }
    exit();

} catch (Exception $e) {
    http_response_code(500); 
    echo json_encode(['success' => false, 'message' => 'Erro no servidor ao tentar atualizar o aluno.']);
    exit();
}
?>