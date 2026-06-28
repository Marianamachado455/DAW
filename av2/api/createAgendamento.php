<?php
    header("Content-Type: application/json");

    include "db.php";

    $usuario = $_POST['usuario'] ?? "";
    $servico = $_POST['servico'] ?? "";
    $tipo = $_POST['tipo'] ?? "";
    $profissional = $_POST['profissional'] ?? "";
    $data_horario = $_POST['data_horario'] ?? "";

    $sql = "INSERT INTO agendamento (usuario_nome, data_hora, servico, tipo, profissional)
    VALUES ('$usuario', '$data_horario', '$servico', '$tipo', '$profissional')";

    if ($conn->query($sql)) {
        echo json_encode([
            "status" => "ok",
            "msg" => "Agendamento criado"
        ]);
    } else {
        echo json_encode([
            "status" => "erro",
            "msg" => "Erro no banco"
        ]);
    }
?>