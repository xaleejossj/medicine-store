<?php
    include("../modelo/con_db.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login | Medicine Store</title>
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
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="signup">
                <form method="post" action="../modelo/registro.php">
                    <label for="tipo_doc">Tipo de documento</label>
                    <select type="text" class="form-control" placeholder="Seleccione Documento" name="tipo_doc" id="tipo_doc">
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="Licencia">Licencia</option>
                    <option value="Cedula">Cédula</option>
                    </select>
                    <!-- Documento con validación para cédula colombiana -->
                    <input type="text" name="documento" placeholder="N° Documento" pattern="^[0-9]{7,10}$" title="Debe contener entre 7 y 10 dígitos numéricos." required>
                    <!-- Nombre completo -->
                    <input type="text" name="names" placeholder="Nombre Completo" pattern="[A-Za-zÁ-ú ]{3,30}" title="Solo letras, mínimo 3 y máximo 30 caracteres" required>
                    <!-- Teléfono con validación de formato colombiano -->
                    <input type="text" name="number" placeholder="Teléfono" pattern="^\d{7,10}$" title="Debe contener entre 7 y 10 dígitos numéricos." required>
                    <!-- Dirección -->
                    <input type="text" name="direccion" placeholder="Dirección" required>
                    <!-- Correo electrónico -->
                    <input type="email" name="email" placeholder="Correo" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Ingrese un correo válido" required>
                    <!-- Contraseña -->
                    <input type="password" name="pswd" placeholder="Contraseña" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,15}$" title="Mínimo 7 caracteres, al menos una mayúscula, una minúscula y un número" required>
                    <!-- Confirmar contraseña -->
                    <input type="password" name="pswdr" placeholder="Confirmar Contraseña" required>
                    <div id="r"><button>Registrarse</button></div>
                </form>
            </div>
            <div class="login">
                <form method="post" action="../modelo/login_process.php">
                    <label for="chk" aria-hidden="true">Iniciar Sesión</label>
                    <div id="l">
                        <input type="email" name="email" placeholder="Correo" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Ingrese un correo válido" required>
                        <input type="password" name="pswd" placeholder="Contraseña" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{7,15}$" title="Mínimo 7 caracteres, al menos una mayúscula, una minúscula y un número" required>
                        <div id="rc">
                            <a href="recover_pass2.php">¿Olvidó su Contraseña?</a>
                        </div>
                    </div>
                    <button id="loginButton" name="login">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
