<?php 

$server = "localhost";
$username = "simdigos_dev";
$password = "simdigosimdev";
$database = "simdigos_projeto";

// Criação da conexão
$conn = new mysqli($server, $username, $password, $database);

// Verificação da conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

?>