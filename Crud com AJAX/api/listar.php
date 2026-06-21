<?php
header("Content-Type: application/json");
include "db.php";

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

$dados = [];

while ($linha = $result->fetch_assoc()) {
    $dados[] = $linha;
}

echo json_encode($dados);
?>
