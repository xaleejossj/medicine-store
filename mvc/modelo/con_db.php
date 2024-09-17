<?php
// Archivo de conexión a la base de datos
$servername = "etdq12exrvdjisg6.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "utfhr8qz53o76ot3";
$password = "ko7id0fuhf1flqm4";
$database = "rocz3lolotn7fkkx";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
