<?php
$servidor = "localhost";
$username = "root";
$password = "";
$database = "crud";

$conn = new mysqli($servidor, $username, $password, $database);

// checar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
