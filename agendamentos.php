<?php
require_once 'api/verificar_sessao.php';
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
                <a href="backend/logout.php" class="btn-logout">Sair</a>
                <a href="index.html" class="btn-primary" >Voltar</a>
                <a href="usuarios.php" class="btn-primary">Gerenciar Usuários</a>

            </div>
        </div>
    </header>

    <main class="container main-content">

        <h2>Novo Agendamento</h2>
        <form id="formAgendamento">
            <div class="form-row">
                <div class="form-group">
                    <label for="titulo">Título / Serviço:</label>
                    <select id="titulo" name="titulo" required>
                        <option value="">Selecione o serviço...</option>
                        <option value="Consulta">Consulta</option>
                        <option value="Reconsulta">Reconsulta</option>
                        <option value="Procedimento">Procedimento</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="data_agendamento">Data:</label>
                    <input type="date" id="data_agendamento" name="data_agendamento" required>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="hora_agendamento">Horário (07:00 - 18:00):</label>
                    <select id="hora_agendamento" name="hora_agendamento" required>
                        <option value="">Selecione o horário...</option>
                        <option value="07:00">07:00</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                    </select>
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