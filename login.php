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
<br>

<body class="login-page">
    <div class="login-container">
        <h2>Entrar no Sistema</h2>


        <?php if (isset($_GET['erro'])): ?>
            <div class="alert-error">
                <?php
                $erro = $_GET['erro'];
                if ($erro === 'credenciais_invalidas') echo "Usuário/E-mail ou senha incorretos.";
                elseif ($erro === 'campos_vazios') echo "Por favor, preencha todos os campos.";
                elseif ($erro === 'nao_autenticado') echo "Faça login para acessar o sistema.";
                else echo "Ocorreu um erro no sistema. Tente novamente.";
                ?>
            </div>
        <?php endif; ?>

        <form action="processar_login.php" method="POST">
            <div class="form-group">
                <label for="login">Usuário ou E-mail:</label>
                <input type="text" id="login" name="login" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
            <a href="index.html"><button type="button" class="btn-primary">Voltar</button></a>

        </form>
    </div>



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