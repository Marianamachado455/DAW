<?php
    header("Content-Type: application/json");
    include "db.php";

    $nome = $_POST['nome'];
    $dta_horario = $_POST['data_horario'];
    $servico = $_POST['servico'];
    $profissional = $_POST['profissional'];
    $forma_pagamento = $_POST['forma_pagamento'];

    $sql = "INSERT INTO agendamento (usuario_nome, data_hora, servico, profissional, forma_pagamento) VALUES ('$nome', '$dta_horario', '$servico', '$profissional', '$forma_pagamento')";
    $conn->query($sql);

    echo json_encode(["msg" => "Agendamento criado"]);
?>