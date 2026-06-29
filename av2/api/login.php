<?php
header("Content-Type: application/json");
error_reporting(0);

include "db.php";

$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";

$sql = "SELECT * FROM usuario WHERE email='$email' AND senha='$senha'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    echo json_encode([
        "status" => "ok",
        "nome" => $user["nome"]
    ]);
} else {
    echo json_encode([
        "status" => "erro",
        "msg" => "Login inválido"
    ]);
}
?>