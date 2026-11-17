<?php

include("conexao.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $tipo = $conexao->real_escape_string($_POST['tipo']); // Consulta ou Procedimento
    $profissional_ou_procedimento = $conexao->real_escape_string($_POST['profissional_ou_procedimento']); 
    $horario = $conexao->real_escape_string($_POST['horario']);
    $data_agendamento = $conexao->real_escape_string($_POST['data_agendamento']);

    
    $sql = "INSERT INTO agendamentos (tipo, profissional_ou_procedimento, horario, data_agendamento) 
            VALUES ('$tipo', '$profissional_ou_procedimento', '$horario', '$data_agendamento')";

    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Agendamento realizado com sucesso!'); window.location.href='agendamentos.html';</script>";
    } else {
        echo "Erro ao agendar: " . $sql . "<br>" . $conexao->error;
    }
}


$conexao->close();
?>