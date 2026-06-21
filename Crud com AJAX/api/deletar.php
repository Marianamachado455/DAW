<?php
header("Content-Type: application/json");
include "db.php";

$id = $_POST['id'];

$sql = "DELETE FROM produtos WHERE id=$id";
$conn->query($sql);

echo json_encode(["msg" => "Deletado"]);
?>
