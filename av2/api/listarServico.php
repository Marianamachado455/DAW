<?php
    include "db.php";

    $sql = "SELECT * FROM servico";
    $result = $conn->query($sql);
    $servicos = [];

    while ($row = $result->fetch_assoc()) {
        //Evita que null se torne do tipo string. Para o funcionamento, faa mais sentido valor do tipo int
        if ($row["tipo"] === null) {
            $row["tipo"] = "";
        }

        $servicos[] = $row;
    }

    echo json_encode($servicos);
?>