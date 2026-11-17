const API_URL = "http://localhost/clinica/api/users.php";

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
            tr.innerHTML = `
                <td class="tg-0lax">${user.id}</td>
                <td class="tg-0lax">${user.name}</td>
                <td class="tg-0lax">${user.login}</td>
                <td class="tg-0lax">${user.email}</td>
                <td class="tg-0lax">
                    <button onclick="editarUsuario(${user.id})">Editar</button>
                    <button onclick="deletarUsuario(${user.id})" style="background-color: #ff4d4d; color: white;">Excluir</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

    } catch (error) {
        loadingDiv.style.display = "none";
        msgDiv.style.color = "red";
        msgDiv.textContent = "Falha ao conectar com a API. Verifique se o servidor está rodando.";
    }
}

// Requisito 11: Solicitar confirmação antes de executar a exclusão
async function deletarUsuario(id) {
    if (confirm("Tem certeza absoluta que deseja excluir este usuário?")) {
        const msgDiv = document.getElementById("mensagem");
        try {
            const resposta = await fetch(`${API_URL}?id=${id}`, {
                method: "DELETE"
            });

            if (resposta.ok) {
                msgDiv.style.color = "green";
                msgDiv.textContent = "Usuário excluído com sucesso!";
                carregarUsuarios(); // Atualiza a tabela
            } else {
                const erro = await resposta.json();
                throw new Error(erro.message || "Erro ao excluir usuário.");
            }
        } catch (error) {
            msgDiv.style.color = "red";
            msgDiv.textContent = error.message;
        }
    }
}

function editarUsuario(id) {
    // Redireciona para o formulário passando o ID via parâmetro na URL
    window.location.href = `cadastro.html?id=${id}`;
}

// Executa ao carregar a página
document.addEventListener("DOMContentLoaded", carregarUsuarios);