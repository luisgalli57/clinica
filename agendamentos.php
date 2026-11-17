<?php
require_once 'verificar_sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/tabelas.css">
</head>

<body>


    <header class="dashboard-header">

        <div class="logo">
            <img class="logoimg" src="img/logoo.png" alt="logo da empresa">
        </div>  
        <div class="container">
            <h1>Painel de Agendamentos</h1>
            <br>
            <div class="user-info">
                <span>Bem-vindo (a), <strong><?php echo htmlspecialchars($_SESSION['usuario_login']); ?></strong>!</span>
                <a href="logout.php" class="btn-logout">Sair</a>
                <a href="index.html" class="btn-logout">Voltar</a>

            </div>
        </div>
    </header>

    <main class="container main-content">

        <h2>Novo Agendamento</h2>
        <form id="formAgendamento">
            <div class="form-row">
                <div class="form-group">
                    <label for="titulo">Título / Serviço:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="data_hora">Data e Hora:</label>
                    <input type="datetime-local" id="data_hora" name="data_hora" required>
                </div>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição / Observações:</label>
                <textarea id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Salvar Agendamento</button>
        </form>

    </main>


    <script src="agendamento.js"></script>

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