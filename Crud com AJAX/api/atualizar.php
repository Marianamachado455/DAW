<?php
header("Content-Type: application/json");
include "db.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];

$sql = "UPDATE produtos SET nome='$nome', preco='$preco' WHERE id=$id";
$conn->query($sql);

echo json_encode(["msg" => "Atualizado"]);
?>
