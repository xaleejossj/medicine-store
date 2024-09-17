<?php
include('../modelo/con_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $correo = $_POST['email'];
    $contrasena = $_POST['pswd'];
}
?>
