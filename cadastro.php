<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/forms.css">
  <link rel="stylesheet" href="css/tabelas.css">
</head>

<body>

  <nav class="navcadastro">
    <div class="logocadastro">
      <img class="logoimg" src="img/logoo.png" alt="logo da empresa">
    </div>

    <ul>
      <li><a href="index.html">Voltar ao início</a></li>
      <li><a href="usuarios.php">Lista de cadastros</a></li>
      <li><a href="agendamentos.php">Agende sua consulta</a></li>
      
    </ul>

  </nav>


  <main>
    <div class="cadastbody">
      <h2>Insira os dados para se cadastrar:</h2>
      <br>

      <form id="formUsuario">
        <!-- Campo oculto para edição -->
        <input type="hidden" id="usuarioId">

        <label for="name">Nome (mínimo de 3 caracteres):</label>
        <input class="inputt" type="text" id="name" name="name" required minlength="3" placeholder="Ex: João da Silva">
        <br><br>

        <label for="login">Login (mínimo de 3 caracteres):</label>
        <input class="inputt" type="text" id="login" name="login" required minlength="3" placeholder="Ex: JoaoSilva">
        <br><br>

        <label for="email">E-mail válido:</label>
        <input class="inputt" type="email" id="email" name="email" required placeholder="usuario@dominio.com">
        <br><br>

        <label for="password">Senha (mínimo de 8 caracteres):</label>
        <input class="inputt" type="password" id="password" name="password" required minlength="8"
          placeholder="********">
        <br><br>

        <div id="feedback-form" style="margin-bottom: 10px; font-weight: bold;"></div>

        <div class="botoes">
          <button type="submit" id="botaoSalvar">Salvar</button>

        </div>
      </form>
    </div>
    <br>
    <br>

    <div class="imgsaude">

    </div>

  </main>

  <script src="cadastro.js"></script>

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