<?php
include("con_db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $nombre = $_POST['names'];
    $telefono = $_POST['number'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];
    $pswdr = $_POST['pswdr'];
    $id_rol = 3;

    // Verificar si las contraseñas coinciden
    if ($pswd !== $pswdr) {
        $_SESSION['message'] = "Las contraseñas no coinciden.";
        header("Location: ../vista/login.php");
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
        $_SESSION['message'] = "El correo electrónico ya está registrado.";
        header("Location: ../vista/login.php");
        exit();
    }

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (TIPO_DOC, DOCUMENTO, NOMBRE, TELEFONO, DIRECCION, EMAIL, CONTRASEÑA, ID_ROL) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $tipo_doc, $documento, $nombre, $telefono, $direccion, $email, $pswd_hash, $id_rol);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registro exitoso. Ahora puede iniciar sesión.";
        header("Location: ../vista/login.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al registrar el usuario.";
        header("Location: ../vista/login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
