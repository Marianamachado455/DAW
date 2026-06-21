<?php
header("Content-Type: application/json");
include "db.php";

$nome = $_POST['nome'];
$preco = $_POST['preco'];

$sql = "INSERT INTO produtos (nome, preco) VALUES ('$nome', '$preco')";
$conn->query($sql);

echo json_encode(["msg" => "Produto criado"]);
?>
