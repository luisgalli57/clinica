const API_URL = "/clinica/users";

async function carregarUsuarios() {
    const loadingDiv = document.getElementById("loading");
    const msgDiv = document.getElementById("mensagem");
    const tbody = document.getElementById("tabela-usuarios");

    loadingDiv.style.display = "block";
    msgDiv.textContent = "";

    try {
        const resposta = await fetch(API_URL);
        if (!resposta.ok) throw new Error("Erro ao carregar a lista de usuários.");

        const usuarios = await resposta.json();
        loadingDiv.style.display = "none";
        tbody.innerHTML = "";

        if (usuarios.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align: center;">Nenhum usuário cadastrado.</td></tr>`;
            return;
        }

        usuarios.forEach(user => {
            const tr = document.createElement("tr");

            const tdId = document.createElement("td");
            tdId.className = "tg-0lax";
            tdId.textContent = user.id;

            const tdNome = document.createElement("td");
            tdNome.className = "tg-0lax";
            tdNome.textContent = user.name;

            const tdLogin = document.createElement("td");
            tdLogin.className = "tg-0lax";
            tdLogin.textContent = user.login;

            const tdEmail = document.createElement("td");
            tdEmail.className = "tg-0lax";
            tdEmail.textContent = user.email;

            const tdAcoes = document.createElement("td");
            tdAcoes.className = "tg-0lax";

            const btnEditar = document.createElement("button");
            btnEditar.textContent = "✏️";
            btnEditar.addEventListener("click", () => editarUsuario(user.id));

            const btnDeletar = document.createElement("button");
            btnDeletar.textContent = "🗑️";
            btnDeletar.style.backgroundColor = "#ff4d4d";
            btnDeletar.style.color = "white";
            btnDeletar.addEventListener("click", () => deletarUsuario(user.id));

            tdAcoes.appendChild(btnEditar);
            tdAcoes.appendChild(btnDeletar);

            tr.appendChild(tdId);
            tr.appendChild(tdNome);
            tr.appendChild(tdLogin);
            tr.appendChild(tdEmail);
            tr.appendChild(tdAcoes);

            tbody.appendChild(tr);
        });

    } catch (error) {
        loadingDiv.style.display = "none";
        msgDiv.style.color = "red";
        msgDiv.textContent = "Falha ao conectar com a API. Verifique se o servidor está rodando.";
    }
}

// Confirmação antes da exclusão
async function deletarUsuario(id) {
    if (confirm("Tem certeza absoluta que deseja excluir este usuário?")) {
        const msgDiv = document.getElementById("mensagem");
        try {
            const resposta = await fetch(`${API_URL}/${id}`, {
                method: "DELETE"
            });

            if (resposta.ok) {
                msgDiv.style.color = "green";
                msgDiv.textContent = "Usuário excluído com sucesso!";
                carregarUsuarios(); // Atualiza a tabela
            } else {
                const erro = await resposta.json();
                throw new Error(erro.error || erro.message || "Erro ao excluir usuário.");
            }
        } catch (error) {
            msgDiv.style.color = "red";
            msgDiv.textContent = error.message;
        }
    }
}

function editarUsuario(id) {
    // Redireciona para o formulário informando o ID na URL
    window.location.href = `cadastro.php?id=${id}`;
}

// Executa ao carregar a página
document.addEventListener("DOMContentLoaded", carregarUsuarios);