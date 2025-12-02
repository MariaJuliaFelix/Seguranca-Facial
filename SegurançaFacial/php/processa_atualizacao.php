<?php
require 'sessoes.php';
require 'conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.'], JSON_UNESCAPED_UNICODE);
    exit();
}

try {
    $id_responsavel = $_POST['id_responsavel'] ?? 0;
    $nome_completo = $_POST['nome_completo'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $parentesco = $_POST['parentesco'] ?? '';

    
    $id_responsavel_validado = filter_var($id_responsavel, FILTER_VALIDATE_INT);
    if (!$id_responsavel_validado || empty($nome_completo) || empty($telefone) || empty($email) || empty($endereco) || empty($parentesco)) {
        throw new Exception("Todos os campos são obrigatórios.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("O formato do email é inválido.");
    }

    
    $sql = "UPDATE responsaveis 
            SET nome_completo = :nome, telefone = :telefone, email = :email, endereco = :endereco, parentesco = :parentesco 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => $nome_completo,
        'telefone' => $telefone,
        'email' => $email,
        'endereco' => $endereco,
        'parentesco' => $parentesco,
        'id' => $id_responsavel_validado
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Dados do responsável atualizados com sucesso!'], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['success' => true, 'message' => 'Nenhuma alteração foi detectada.'], JSON_UNESCAPED_UNICODE);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>