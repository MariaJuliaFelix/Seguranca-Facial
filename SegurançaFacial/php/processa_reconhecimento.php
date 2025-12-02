<?php
require 'sessoes.php';
require 'conexao.php';

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erro ao decodificar o JSON recebido.");
    }
    
    $imagem_base64 = $input['image'] ?? null;
    if (!$imagem_base64) {
        throw new Exception("Imagem não recebida do frontend.");
    }

    $python_service_url = 'http://127.0.0.1:5000/recognize_face';
    $data = ['image' => $imagem_base64];
    $ch = curl_init($python_service_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'], CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_TIMEOUT => 30,
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception("Erro de cURL ao contatar o serviço Python: " . curl_error($ch));
    }
    curl_close($ch);

    $responseData = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Resposta inválida (não-JSON) do serviço Python. Resposta: " . $response);
    }

    if ($responseData && isset($responseData['success']) && $responseData['success']) {
        $id_responsavel = $responseData['id_responsavel'];
        
        $sql_resp = "SELECT * FROM responsaveis WHERE id = :id";
        $stmt_resp = $pdo->prepare($sql_resp);
        $stmt_resp->execute(['id' => $id_responsavel]);
        $responsavel = $stmt_resp->fetch(PDO::FETCH_ASSOC);

        $sql_alunos = "SELECT a.* FROM alunos a
                       JOIN aluno_responsavel ar ON a.id = ar.id_aluno
                       WHERE ar.id_responsavel = :id_resp AND a.id_instituicao = :id_inst";
        $stmt_alunos = $pdo->prepare($sql_alunos);
        $stmt_alunos->execute(['id_resp' => $id_responsavel, 'id_inst' => $id_instituicao]);
        $alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

        if (empty($alunos)) {
            echo json_encode(['success' => false, 'message' => 'Responsável não autorizado para esta instituição.']);
            exit;
        }

        $id_aluno_saindo = $alunos[0]['id'];
        $sql_ultimo_registro = "SELECT data_saida FROM historico_saidas 
                                WHERE id_aluno = :id_aluno AND id_responsavel = :id_responsavel
                                ORDER BY data_saida DESC LIMIT 1";
        
        $stmt_ultimo = $pdo->prepare($sql_ultimo_registro);
        $stmt_ultimo->execute(['id_aluno' => $id_aluno_saindo, 'id_responsavel' => $id_responsavel]);
        $ultimo_registro = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
        
        $pode_registrar = true;
        if ($ultimo_registro) {
            $fuso_horario = new DateTimeZone('America/Sao_Paulo');
            $agora = new DateTime("now", $fuso_horario);
            $ultimo_horario = new DateTime($ultimo_registro['data_saida'], $fuso_horario);
            $diferenca = $agora->getTimestamp() - $ultimo_horario->getTimestamp();
            $cooldown_em_segundos = 300; // 5 minutos
            if ($diferenca < $cooldown_em_segundos) {
                $pode_registrar = false;
            }
        }

        if ($pode_registrar) {
            $sql_hist = "INSERT INTO historico_saidas (id_aluno, id_responsavel) VALUES (:id_aluno, :id_resp)";
            $stmt_hist = $pdo->prepare($sql_hist);
            $stmt_hist->execute(['id_aluno' => $id_aluno_saindo, 'id_resp' => $id_responsavel]);
        }
        
        echo json_encode(['success' => true, 'responsavel' => $responsavel, 'alunos' => $alunos]);

    } else {
        echo json_encode(['success' => false, 'message' => $responseData['message'] ?? 'Responsável não reconhecido.']);
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 'message' => 'Ocorreu um erro interno no servidor PHP.',
        'error_details' => [ 'message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine() ]
    ]);
}
?>