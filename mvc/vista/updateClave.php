<?php
include("../modelo/con_db.php");

// Verificar si los datos han sido enviados
if (isset($_POST['id']) && isset($_POST['token']) && isset($_POST['password'])) {
    $id = $_POST['id'];
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Encriptar la nueva contraseña usando password_hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar que el token y el ID existan en la base de datos
    $consulta = "SELECT * FROM usuario WHERE id_usuario = ? AND token = ?";
    $stmt = $conn->prepare($consulta);
    $stmt->bind_param("ss", $id, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Actualizar la contraseña en la base de datos
        $updateClave = "UPDATE usuario SET contraseña = ?, token = NULL WHERE id_usuario = ? AND token = ?";
        $stmt = $conn->prepare($updateClave);
        $stmt->bind_param("sss", $password_hash, $id, $token);

        if ($stmt->execute()) {
            // Redirigir con éxito después de actualizar la contraseña
            header("Location: nuevaClave.php?success=1"); // Cambio correcto
            exit();
        } else {
            // Error al actualizar la contraseña
            header("Location: nuevaClave.php?error=1"); // Si ocurre algún problema en la consulta de actualización
            exit();
        }
    } else {
        // Error: token o id no válidos
        header("Location: nuevaClave.php?error=1"); // Si el token o ID no coinciden
        exit();
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conn->close();
}
?>
