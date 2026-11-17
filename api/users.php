<?php

include_once("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri);
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id) {
            // Obter detalhes do user pelo id
            buscarUsuarioPorId($conn, $id);
        } else {
            // Lista os usuarios
            listarUsuarios($conn);
        }
        break;

    case 'POST':
        // Cadastrar usuário
        cadastrarUsuario($conn);
        break;

    case 'PUT':
    case 'PATCH':
        // Alterar dados de um usuário
        if ($id) {
            atualizarUsuario($conn, $id);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID não fornecido para atualização."]);
        }
        break;

    case 'DELETE':
        // Excluir usuário
        if ($id) {
            deletarUsuario($conn, $id);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID não fornecido para exclusão."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido"]);
        break;
}


function listarUsuarios($conn)
{
    // Retorna todos os usuários
    $sql = "SELECT id, name, login, email, active, created_at FROM users";
    $result = $conn->query($sql);
    $users = [];

    while ($row = $result->fetch_assoc()) {
        // Converte o campo active para booleano real
        $row['active'] = (bool) $row['active'];
        $users[] = $row;
    }

    http_response_code(200);
    echo json_encode($users);
}

function buscarUsuarioPorId($conn, $id)
{
    $stmt = $conn->prepare("SELECT id, name, login, email, active, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $row['active'] = (bool) $row['active'];
        http_response_code(200);
        echo json_encode($row);
    } else {
        // Retornar 404 Not Found se não achar o usuário
        http_response_code(404);
        echo json_encode(["error" => "Usuário não encontrado."]);
    }
    $stmt->close();
}

function cadastrarUsuario($conn)
{
    // Pega os dados enviados em formato JSON via requisição HTTP
    $data = json_decode(file_get_contents("php://input"), true);

    $name = isset($data['name']) ? trim($data['name']) : '';
    $login = isset($data['login']) ? trim($data['login']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $password = isset($data['password']) ? $data['password'] : '';
    $active = isset($data['active']) ? (int)$data['active'] : 1; // Padrão true (1)

    // Nome obrigatório com no mínimo 3 caracteres válidos
    if (strlen($name) < 3) {
        http_response_code(400);
        echo json_encode(["error" => "O campo name é obrigatório e deve ter no mínimo 3 caracteres."]);
        return;
    }

    // Login obrigatório com no mínimo 3 caracteres e único
    if (strlen($login) < 3) {
        http_response_code(400);
        echo json_encode(["error" => "O campo login é obrigatório e deve ter no mínimo 3 caracteres."]);
        return;
    }

    // E-mail obrigatório e formato válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "E-mail inválido ou ausente."]);
        return;
    }

    // Senha obrigatória com no mínimo 8 caracteres
    if (strlen($password) < 8) {
        http_response_code(400);
        echo json_encode(["error" => "A senha deve ter no mínimo 8 caracteres."]);
        return;
    }

    // Verifica se login são únicos
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE login = ? OR email = ?");
    $stmtCheck->bind_param("ss", $login, $email);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows > 0) {
        http_response_code(400);
        echo json_encode(["error" => "Login ou E-mail já cadastrados no sistema."]);
        return;
    }
    $stmtCheck->close();

    // Armazenar senha segura (BCrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insere no banco
    $stmt = $conn->prepare("INSERT INTO users (name, login, email, password, active) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $login, $email, $hashedPassword, $active);

    if ($stmt->execute()) {
        $novoId = $stmt->insert_id;

        // Retornar status 201 Created
        http_response_code(201);
        echo json_encode([
            "id" => $novoId,
            "name" => $name,
            "login" => $login,
            "email" => $email,
            "active" => (bool)$active
        ]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Erro ao cadastrar usuário no banco de dados."]);
    }
    $stmt->close();
}

function atualizarUsuario($conn, $id)
{
    $data = json_decode(file_get_contents("php://input"), true);

    $name = isset($data['name']) ? trim($data['name']) : '';
    $login = isset($data['login']) ? trim($data['login']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $password = isset($data['password']) ? $data['password'] : '';

    if (strlen($name) < 3) {
        http_response_code(400);
        echo json_encode(["error" => "O nome precisa ter pelo menos 3 caracteres."]);
        return;
    }

    if (strlen($login) < 3) {
        http_response_code(400);
        echo json_encode(["error" => "O login precisa ter pelo menos 3 caracteres."]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "E-mail inválido."]);
        return;
    }

    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE (login = ? OR email = ?) AND id != ?");
    $stmtCheck->bind_param("ssi", $login, $email, $id);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows > 0) {
        http_response_code(400);
        echo json_encode(["error" => "Este login ou e-mail já está em uso por outro usuário."]);
        return;
    }
    $stmtCheck->close();

    if (!empty($password)) {
        
        if (strlen($password) < 8) {
            http_response_code(400);
            echo json_encode(["error" => "A nova senha deve ter no mínimo 8 caracteres."]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

   $stmt = $conn->prepare("UPDATE users SET name = ?, login = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $login, $email, $hashedPassword, $id);
    } else {
        
        $stmt = $conn->prepare("UPDATE users SET name = ?, login = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $login, $email, $id);
    }

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Usuário atualizado com sucesso!"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Erro ao atualizar usuário."]);
    }
    $stmt->close();
}

function deletarUsuario($conn, $id)
{
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Status 200 OK ou 204 No Content na exclusão
        http_response_code(200);
        echo json_encode(["message" => "Usuário excluído com sucesso!"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Erro ao excluir usuário."]);
    }
    $stmt->close();
}
