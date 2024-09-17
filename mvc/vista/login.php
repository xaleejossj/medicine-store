<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login | Medicine Store</title>
    <style>
        /* Estilo para los mensajes */
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        /* Estilo para los mensajes de éxito */
        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #3c763d;
        }

        /* Estilo para los mensajes de error */
        .message.error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #a94442;
        }

        /* Icono dentro del mensaje */
        .message i {
            margin-right: 8px;
        }

        /* Estilos de mensaje más centrado */
        .message {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<header>
    <div class="container-hero">
        <img src="img/logo.png">
        <h1 class="logo"><a href="/">Medicine Store</a></h1>
    </div>
    <nav>
        <div class="menu">
            <ul>
                <li id="home"><a href="../index.php"><i class='bx bxs-home'></i></a>
            </ul>
        </div>
    </nav>
</header>
<div id="logo">
    <div class="main">
        <!-- Mostrar mensajes de error o éxito -->
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            $messageType = (strpos($_SESSION['message'], 'exitoso') !== false) ? 'success' : 'error';
            echo "<div class='message $messageType'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form method="post" action="../modelo/registro.php">
                <label for="tipo_doc">Tipo de documento</label>
                <select name="tipo_doc" id="tipo_doc">
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="Licencia">Licencia</option>
                    <option value="Cedula">Cédula</option>
                </select>
                <input type="text" name="documento" placeholder="N° Documento" required>
                <input type="text" name="names" placeholder="Nombre Completo" required>
                <input type="text" name="number" placeholder="Teléfono" required>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="pswd" placeholder="Contraseña" required>
                <input type="password" name="pswdr" placeholder="Confirmar Contraseña" required>
                <button>Registrarse</button>
            </form>
        </div>
        <div class="login">
            <form method="post" action="../modelo/login_process.php">
                <label for="chk" aria-hidden="true">Iniciar Sesión</label>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="pswd" placeholder="Contraseña" required>
                <div id="rc">
                    <a href="recover_pass2.php">¿Olvidó su Contraseña?</a>
                </div>
                <button id="loginButton" name="login">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
