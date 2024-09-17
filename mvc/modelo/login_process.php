<?php
include("con_db.php");
session_start();

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['pswd'];

    // Consulta segura utilizando prepared statements
    $query = "SELECT * FROM usuario WHERE EMAIL = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $row['CONTRASEÑA'])) {
            // Asignar las variables de sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['ID_USUARIO'];
            $_SESSION['user_name'] = $row['NOMBRE'];
            $_SESSION['user_role'] = $row['ID_ROL'];

            // Obtener el rol del usuario correctamente
            $rol = $row['ID_ROL'];

            // Redirigir según el rol
            switch ($rol) {
                case '1':
                    header("Location: ../vista/dashboard/sistema/");
                    break;
                case '2':
                    header("Location: ../vista/dashboard/sistema/");
                    break;
                case '3':
                    header("Location: ../vista/inicio_c.php");
                    break;
                default:
                    // Rol no reconocido
                    echo "Rol no reconocido";
                    break;
            }

            exit();
        } else {
            // Contraseña incorrecta
            echo '<script>alert("Correo o contraseña incorrectos");</script>';
            header("Location: ../vista/login.php");
        }
    } else {
        // Correo no encontrado
        echo '<script>alert("Correo o contraseña incorrectos");</script>';
        header("Location: ../vista/login.php");
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
