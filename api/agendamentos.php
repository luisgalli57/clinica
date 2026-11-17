<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
        
    case 'POST':
        criarAgendamento($conn);
        break;
        
    default:
        http_response_code(405);
        echo json_encode(["message" => "Método não suportado."]);
        break;
}

// CRIAR AGENDAMENTO
function criarAgendamento($conn) {
    $dados = json_decode(file_get_contents("php://input"), true);
    
    $titulo = trim($dados['titulo'] ?? '');
    $data_hora = trim($dados['data_hora'] ?? '');
    $descricao = trim($dados['descricao'] ?? '');
    
    

    // Validação formato da data/hora
    $d = DateTime::createFromFormat('Y-m-d\TH:i', $data_hora);
    if (!$d || $d->format('Y-m-d\TH:i') !== $data_hora) {
        
        $d2 = DateTime::createFromFormat('Y-m-d H:i:s', $data_hora);
        if (!$d2) {
            http_response_code(400);
            echo json_encode(["message" => "Formato de data e hora inválido."]);
            return;
        }
    }
    
    $sql = "INSERT INTO agendamentos (titulo, data_hora, descricao) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sss", $titulo, $data_hora, $descricao);
        
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                "message" => "Agendamento criado com sucesso!",
                "id" => $stmt->insert_id
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro interno ao salvar o registro."]);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erro na preparação da consulta SQL."]);
    }
}


?>