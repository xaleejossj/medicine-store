<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de que la ruta al archivo autoload es correcta
require '../../vendor/autoload.php';
include("../modelo/con_db.php");

// Eliminar espacios en blanco en el correo ingresado
$correo = trim($_REQUEST['email']); 

// Verificar si el correo existe en la base de datos
$consulta = "SELECT * FROM usuario WHERE email ='".$correo."'";
$queryconsulta = mysqli_query($conn, $consulta);
$cantidadConsulta = mysqli_num_rows($queryconsulta);
$dataConsulta = mysqli_fetch_array($queryconsulta);

if ($cantidadConsulta == 0) {
    header("Location:recover_pass2.php?errorEmail=1");
    exit();
} else {
    // Función para generar un token
    function generandoTokenClave($length = 10) {
        return substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', ceil($length/62))), 1, $length);
    }

    $miTokenClave = generandoTokenClave();

    // Actualizar el token en la base de datos
    $updateClave = "UPDATE usuario SET token='$miTokenClave' WHERE email='".$correo."'";
    $queryResult = mysqli_query($conn, $updateClave); 

    // Crear enlace de recuperación de contraseña
    $linkRecuperar = "https://medicinestore.store/mvc/vista/nuevaClave.php?id=".$dataConsulta['ID_USUARIO']."&token=".$miTokenClave;

    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        // Establecer el nivel de depuración solo si es necesario
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Depuración completa, desactívalo en producción
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alissondayanachaconarias01@gmail.com';  // Tu correo de Gmail
        $mail->Password = 'uzrkcimggouvbceb'; // Contraseña de aplicación sin espacios
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;  // Puerto SMTP de Gmail

        // Configuración del remitente y destinatario
        $mail->setFrom('alissondayanachaconarias01@gmail.com', 'Medicine Store');
        $mail->addAddress($correo, $dataConsulta['NOMBRE']);  // Añadir destinatario

        // Contenido del correo
        $mail->isHTML(true);  // Establecer formato HTML
        $mail->Subject = 'Restablecer clave';
        $mail->Body = "
        <html lang='es'>
        <head>
        <title>Recuperar Clave de Usuario</title>
        <style>
        .contenedor { text-align: center; padding: 20px; background-color: #f4f4f4; }
        .btnlink { padding: 15px; background-color: #007bff; color: white; text-decoration: none; }
        </style>
        </head>
        <body>
        <div class='contenedor'>
        <h2>Hola apreciad@ usuario@, ".$dataConsulta['NOMBRE']."</h2>
        <p>Tu token de recuperación es: <strong>' . $miTokenClave . '</strong></p>
        <br>
        <p>Haz clic en el siguiente enlace para recuperar tu contraseña:</p>
        <a href='$linkRecuperar' class='btnlink'>Recuperar mi clave</a>
        </div>
        </body>
        </html>";

        $mail->send();

        // Redirección después del envío exitoso
        header("Location: recover_pass2.php?success=1");
        exit();
    } catch (Exception $e) {
        // Mostrar error en el envío del correo
        echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
    }
}
?>