<?php
include("con_db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['pswd'];

    // Consulta segura
    $query = "SELECT * FROM usuario WHERE EMAIL = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($contrasena, $row['CONTRASEÑA'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['ID_USUARIO'];
            $_SESSION['user_name'] = $row['NOMBRE'];
            $_SESSION['user_role'] = $row['ID_ROL'];

            $rol = $row['ID_ROL'];

            switch ($rol) {
                case '1':
                case '2':
                    header("Location: ../vista/dashboard/sistema/");
                    break;
                case '3':
                    header("Location: ../vista/inicio_c.php");
                    break;
                default:
                    $_SESSION['message'] = "Rol no reconocido.";
                    header("Location: ../vista/login.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['message'] = "Correo o contraseña incorrectos.";
            header("Location: ../vista/login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Correo o contraseña incorrectos.";
        header("Location: ../vista/login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
