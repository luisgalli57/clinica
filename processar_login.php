<?php
// processar_login.php
session_start();
require_once 'api/conexao.php'; // Certifique-se de que este arquivo define a variável $conn (mysqli)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['password'] ?? '';

    if (empty($login) || empty($senha)) {
        header("Location: login.php?erro=campos_vazios");
        exit;
    }

    // Query usando prepared statements com MySQLi (buscando por login ou email)
    $sql = "SELECT id, login, password FROM users WHERE login = ? OR email = ? LIMIT 1";
    
    if ($stmt = $conn->prepare($sql)) {
        // 'ss' indica que estamos passando duas strings como parâmetros
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            // Valida a senha usando password_verify (compatível com o hash gerado no cadastro)
            if (password_verify($senha, $usuario['password'])) {
                // Regenera o ID da sessão por segurança (previne Session Fixation)
                session_regenerate_id(true);

                // Armazena dados essenciais na sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_login'] = $usuario['login'];

                // Redireciona para a tela de agendamento ou painel
                header("Location: agendamentos.php");
                exit;
            } else {
                // Senha incorreta
                header("Location: login.php?erro=credenciais_invalidas");
                exit;
            }
        } else {
            // Usuário não encontrado
            header("Location: login.php?erro=credenciais_invalidas");
            exit;
        }

        $stmt->close();
    } else {
        // Erro na preparação da query
        header("Location: login.php?erro=sistema");
        exit;
    }

    $conn->close();
} else {
    header("Location: login.php");
    exit;
}
?>