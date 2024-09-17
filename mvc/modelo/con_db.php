<?php
// Archivo de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "admin";
$database = "medicine_store";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
