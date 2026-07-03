<?php
    header("Content-Type: application/json");
    session_start();

    include "db.php";

    $usuario_id = $_SESSION["usuario_id"];
    $usuario_nome = $_SESSION["usuario_nome"];
    $servico = $_POST['servico'] ?? "";
    $tipo = $_POST['tipo'] ?? "";
    $profissional = $_POST['profissional'] ?? "";
    $data_horario = $_POST['data_horario'] ?? "";
    $preco = $_POST['preco'] ?? "";
    $pagamento = $_POST['pagamento'] ?? "";

   $sql = "INSERT INTO agendamento(usuario_id, usuario_nome, data_hora, servico, tipo, profissional, preco, pagamento)
    VALUES('$usuario_id', '$usuario_nome', '$data_horario', '$servico', '$tipo', '$profissional', '$preco', '$pagamento')";

    if ($conn->query($sql)) {
        echo json_encode([
            "status" => "ok",
            "msg" => "Agendamento criado"
        ]);
    } else {
        echo json_encode([
            "status" => "erro",
            "msg"=>$conn->error
        ]);
    }
?>