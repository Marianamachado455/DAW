<?php
    include "db.php";

    $sql = "SELECT * FROM servico";
    $result = $conn->query($sql);
    $servicos = [];

    while($row = $result->fetch_assoc()){
        $servicos[] = $row;
    }

    echo json_encode($servicos);
?>