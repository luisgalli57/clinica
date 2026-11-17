<?php

session_start();

// Verifica se a variável de sessão do usuário não existe
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para o login com uma mensagem ou parâmetro opcional
    header("Location: login.php?erro=nao_autenticado");
    exit;
}
