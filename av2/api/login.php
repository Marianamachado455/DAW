<?php
    header("Content-Type: application/json");
    session_start();

    include "db.php";

    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    $sql = "SELECT id, nome, senha FROM usuario WHERE email = '$email'";
    $result = $conn->query($sql);

    //Verifica email
    if ($result->num_rows == 0) {
        echo json_encode([
            "status" => "erro",
            "msg" => "E-mail ou senha inválidos."
        ]);
        exit;
    }

    $usuario = $result->fetch_assoc();

    //Verifica senha
    if ($senha != $usuario["senha"]) {
        echo json_encode([
            "status" => "erro",
            "msg" => "E-mail ou senha inválidos."
        ]);
        exit;
    }

    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["usuario_nome"] = $usuario["nome"];   
    echo json_encode([
        "status" => "ok",
        "nome" => $usuario["nome"]
    ]);
?>