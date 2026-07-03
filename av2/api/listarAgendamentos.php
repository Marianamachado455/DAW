<?php
    header("Content-Type: application/json");
    session_start();

    include "db.php";

    if (!isset($_SESSION["usuario_id"])) {
        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Usuário não está logado."
        ]);
        exit;
    }

    $usuario_id = $_SESSION["usuario_id"];
    $sql = "SELECT * FROM agendamento
            WHERE usuario_id = ?
            ORDER BY data_hora";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $agendamentos = [];

    while ($linha = $resultado->fetch_assoc()) {

        if ($linha["tipo"] != NULL) {
            $linha["servico"] .= " - " . $linha["tipo"];
        }

        $agendamentos[] = $linha;
    }

    echo json_encode($agendamentos);

    $stmt->close();
    $conn->close();
?>