<?php
// Archivo de conexión a la base de datos
$servername = "localhost";
$username = "u964289722_root";
$password = "Admin2024@";
$database = "u964289722_medicine_store";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
