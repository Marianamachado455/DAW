<?php
    header("Content-Type: application/json");
    include "db.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $dta_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO usuario (nome, email, cpf, dta_nascimento, telefone, senha) VALUES ('$nome', '$email', '$cpf', '$dta_nascimento', '$telefone', '$senha')";
    $conn->query($sql);

    echo json_encode(["msg" => "Usuário criado"]);
?>