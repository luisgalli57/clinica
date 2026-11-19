<?php
require_once 'api/verificar_sessao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/tabelas.css">

</head>

<body class="body">
    <main style="padding: 20px;">
        <h1>Lista de Usuários</h1>

        <div class="user-info">
            <span style="color: black;">Bem-vindo (a), <strong><?php echo htmlspecialchars($_SESSION['usuario_login']); ?></strong>!</span>
            <a href="logout.php" class="btn-logout">Sair</a>
            <a href="agendamentos.php" class="btn-primary">Painel de Agendamentos</a>
            
        </div>
        <br>
        <a href="cadastro.php" class="btn-primary" style="display: inline-block; margin-bottom: 5px;">Novo cadastro</a>
        <a href="index.html" class="btn-primary">Voltar</button></a>


        <div id="loading" style="display: none;">Carregando usuários...</div>


        <div id="mensagem" style="margin-bottom: 15px; font-weight: bold;"></div>

        <table class="tg" style="width: 100%;">
            <thead>
                <tr>
                    <th class="tg-f6p5">ID</th>
                    <th class="tg-f6p5">Nome</th>
                    <th class="tg-f6p5">Login</th>
                    <th class="tg-f6p5">E-mail</th>
                    <th class="tg-f6p5">Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-usuarios">
                <!-- Preenchido via JavaScript -->
            </tbody>
        </table>
    </main>

    <script src="usuarios.js"></script>

    <footer class="foot">
        <div class="foot-info">
            <h3>Nosso contato:</h3>
            <address>
                <a href="mailto:luismicaelgalli58@gmail.com">recepcao.calvier@med.com</a>
                <p>Av. Osvaldo Aranha, 12345 - Centro. Veranópolis - RS</p>
            </address>
        </div>
        <img class="logofoot" src="img/logoo.png" alt="logo da empresa">
    </footer>
</body>

</html>