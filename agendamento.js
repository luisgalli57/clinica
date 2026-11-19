document.addEventListener("DOMContentLoaded", () => {
    // Data mínima como hoje e atualiza os horários
    const inputData = document.getElementById("data_agendamento");
    if (inputData) {
        const agora = new Date();
        const ano = agora.getFullYear();
        const mes = String(agora.getMonth() + 1).padStart(2, '0');
        const dia = String(agora.getDate()).padStart(2, '0');
        const hoje = `${ano}-${mes}-${dia}`;
        
        inputData.min = hoje;
        inputData.addEventListener("change", atualizarHorariosDisponiveis);
    }

    
    const form = document.getElementById("formAgendamento");
    if (form) {
        form.addEventListener("submit", cadastrarAgendamento);
    }
});

// Bloqueia horários passados
function atualizarHorariosDisponiveis() {
    const inputData = document.getElementById("data_agendamento");
    const selectHora = document.getElementById("hora_agendamento");
    if (!inputData || !selectHora) return;

    const agora = new Date();
    const ano = agora.getFullYear();
    const mes = String(agora.getMonth() + 1).padStart(2, '0');
    const dia = String(agora.getDate()).padStart(2, '0');
    const hoje = `${ano}-${mes}-${dia}`;

    const horaAtual = agora.getHours();
    const ehHoje = (inputData.value === hoje);

    // Reseta a seleção atual 
    selectHora.value = "";

    // Percorre as opções do select de horário
    Array.from(selectHora.options).forEach(option => {
        if (!option.value) return; // Ignora o placeholder

        const horaOpcao = parseInt(option.value.split(":")[0], 10);

        if (ehHoje && horaOpcao <= horaAtual) {
            option.disabled = true;
            option.textContent = `${option.value} (Indisponível)`;
        } else {
            option.disabled = false;
            option.textContent = option.value;
        }
    });
}

// cadastrar novo agendamento com feedback de carregamento
async function cadastrarAgendamento(event) {
    event.preventDefault();

    const btnSubmit = event.target.querySelector("button[type='submit']");
    const titulo = document.getElementById("titulo").value.trim();
    const dataInput = document.getElementById("data_agendamento").value; // "2026-11-25"
    const horaInput = document.getElementById("hora_agendamento").value; // "14:30"
    const descricao = document.getElementById("descricao").value.trim();


    // Junta a data e a hora (YYYY-MM-DD HH:MM:SS)
    const data_hora = `${dataInput} ${horaInput}:00`;


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