document.addEventListener("DOMContentLoaded", () => {
    
    const form = document.getElementById("formAgendamento");
    if (form) {
        form.addEventListener("submit", cadastrarAgendamento);
    }
});


// cadastrar novo agendamento com feedback de carregamento
async function cadastrarAgendamento(event) {
    event.preventDefault();

    const btnSubmit = event.target.querySelector("button[type='submit']");
    const titulo = document.getElementById("titulo").value.trim();
    const data_hora = document.getElementById("data_hora").value;
    const descricao = document.getElementById("descricao").value.trim();


    // Feedback visual de carregamento
    btnSubmit.disabled = true;
    btnSubmit.textContent = "Salvando...";

    try {
        const response = await fetch("api/agendamentos.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ titulo, data_hora, descricao })
        });

        const resultado = await response.json();

        if (response.ok) {
            alert(resultado.message || "Agendamento criado com sucesso!");
            document.getElementById("formAgendamento").reset();
            
        } else {
            alert("Atenção: " + (resultado.message || "Não foi possível realizar o agendamento."));
        }
    } finally {
        btnSubmit.disabled = false;
        btnSubmit.textContent = "Salvar Agendamento";
    }
}



function formatarData(dataStr) {
    if (!dataStr) return "";
    const data = new Date(dataStr);
    return isNaN(data.getTime()) ? dataStr : data.toLocaleString("pt-BR");
}