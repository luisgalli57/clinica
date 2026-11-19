<?php
session_start();
require_once '../api/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['password'] ?? '';

    if (empty($login) || empty($senha)) {
        header("Location: ../login.php?erro=campos_vazios");
        exit;
    }

    $sql = "SELECT id, login, password FROM users WHERE login = ? OR email = ? LIMIT 1";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            // Valida a senha
            if (password_verify($senha, $usuario['password'])) {
                // Regenera o ID da sessão
                session_regenerate_id(true);

                // Armazena dados essenciais
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_login'] = $usuario['login'];

                // Redireciona para a tela de agendamento automaticamente
                header("Location: ../agendamentos.php");
                exit;
            } else {
                // Senha incorreta
                header("Location: ../login.php?erro=credenciais_invalidas");
                exit;
            }
        } else {
            // Usuário não encontrado
            header("Location: ../login.php?erro=credenciais_invalidas");
            exit;
        }

        $stmt->close();
    } else {
        // Erro na preparação da query
        header("Location: ../login.php?erro=sistema");
        exit;
    }

    $conn->close();
} else {
    header("Location: ../login.php");
    exit;
}
?>