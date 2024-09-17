<?php
include("con_db.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $nombre = $_POST['names'];
    $telefono = $_POST['number'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];
    $pswdr = $_POST['pswdr'];
    $id_rol = 3; // Rol por defecto para usuarios normales (cliente)

    // Verificar si las contraseñas coinciden
    if ($pswd !== $pswdr) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Encriptar la contraseña
    $pswd_hash = password_hash($pswd, PASSWORD_DEFAULT);

    // Verificar si el correo electrónico ya está registrado
    $check_sql = "SELECT * FROM usuario WHERE EMAIL = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
        exit();
    }

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (TIPO_DOC, DOCUMENTO, NOMBRE, TELEFONO, DIRECCION, EMAIL, CONTRASEÑA, ID_ROL) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param("sssssssi", $tipo_doc, $documento, $nombre, $telefono, $direccion, $email, $pswd_hash, $id_rol);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Registro exitoso.";
        header("Location: ../vista/login.php");
        exit();
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
