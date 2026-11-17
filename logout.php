<?php
session_start();


$_SESSION = array();


session_destroy();

// Redireciona para o login
header("Location: login.php?sucesso=logout");
exit;
?>