const API_URL = "/clinica/users";
const urlParams = new URLSearchParams(window.location.search);
const userId = urlParams.get("id");

document.addEventListener("DOMContentLoaded", async () => {
    const h2Element = document.querySelector("h2");
    
    if (h2Element) {
        
        if (userId) {
            h2Element.textContent = "Editar Usuário";
        } else {
            h2Element.textContent = "Insira os dados para se cadastrar:";
        }
    }

    if (userId) {
        try {
            const resposta = await fetch(${API_URL}/${userId});
            if (resposta.ok) {
                const user = await resposta.json();
                document.getElementById("usuarioId").value = user.id;
                document.getElementById("name").value = user.name;
                document.getElementById("login").value = user.login;
                document.getElementById("email").value = user.email;
                // Senha opcional na edição
                document.getElementById("password").required = false; 
                document.getElementById("password").placeholder = "Preencha apenas se desejar alterar";
            }
        } catch (e) {
            console.error("Erro ao buscar dados para edição", e);
        }
    }
});

document.getElementById("formUsuario").addEventListener("submit", async (event) => {
    event.preventDefault();

    const id = document.getElementById("usuarioId").value;
    const name = document.getElementById("name").value.trim();
    const login = document.getElementById("login").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    const feedback = document.getElementById("feedback-form");
    const botao = document.getElementById("botaoSalvar");



    // Carregamento
    botao.disabled = true;
    botao.textContent = "Salvando...";
    feedback.style.color = "blue";
    feedback.textContent = "Processando requisição...";

    const dados = { name, login, email };
    if (password) dados.password = password; // Só envia a senha se foi preenchida

    const metodo = id ? "PUT" : "POST";
    const urlFinal = id ? `${API_URL}/${id}` : API_URL;

    try {
        const resposta = await fetch(urlFinal, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(dados)
        });

        const resultado = await resposta.json();

        if (resposta.ok) {
            // Aviso de sucesso
            feedback.style.color = "green";
            feedback.textContent = id ? "Usuário atualizado com sucesso!" : "Usuário cadastrado com sucesso! (Status 201)";
            setTimeout(() => {
                window.location.href = "usuarios.php"; // Redireciona para a listagem
            }, 2000);
        } else {
            // Mensagem de erro (HTTP 400)
            feedback.style.color = "red";
            feedback.textContent = resultado.error || resultado.message || "Erro ao salvar os dados. Verifique as informações.";
            botao.disabled = false;
            botao.textContent = "Salvar";
        }
    } catch (error) {
        feedback.style.color = "red";
        feedback.textContent = "Erro de conexão com o servidor.";
        botao.disabled = false;
        botao.textContent = "Salvar";
    }
});