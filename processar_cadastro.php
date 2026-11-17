<?php

include("conexao.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $conexao->real_escape_string($_POST['nome']);
    $cpf = $conexao->real_escape_string($_POST['CPF']);
    $data_nascimento = $conexao->real_escape_string($_POST['data_de_nascimento']);
    $telefone = $conexao->real_escape_string($_POST['fone']);
    $email = $conexao->real_escape_string($_POST['e-mail']);
    $tipo_sanguineo = $conexao->real_escape_string($_POST['sangue']);
    $sexo = isset($_POST['sexo']) ? $conexao->real_escape_string($_POST['sexo']) : '';

   
    $sql = "INSERT INTO pacientes (nome, cpf, data_nascimento, telefone, email, tipo_sanguineo, sexo) 
            VALUES ('$nome', '$cpf', '$data_nascimento', '$telefone', '$email', '$tipo_sanguineo', '$sexo')";

    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='index.html';</script>";
    } else {
        echo "Erro ao cadastrar: " . $sql . "<br>" . $conexao->error;
    }
}


$conexao->close();
?>