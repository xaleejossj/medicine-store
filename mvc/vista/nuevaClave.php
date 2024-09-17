<?php
// Verificar si el token y el ID están presentes en la URL
if (isset($_REQUEST['token']) && isset($_REQUEST['id'])) {
    $token = $_REQUEST['token'];
    $id = $_REQUEST['id'];
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/recover_pass.css">
	<title>Recuperar Contraseña</title>
</head>
<body>
	<div id="img-container">
		<img src="img/logo.png" width="125" height="120">
	</div>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">
		<div class="signup">
			<form action="updateClave.php" method="POST"> <!-- Corrección del método de envío -->
				<label for="chk" aria-hidden="true">Restablecer Contraseña</label>
				<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Campo oculto para ID -->
				<input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"> <!-- Campo oculto para token -->
                <label for="chk" aria-hidden="true" id="text">Ingrese su nueva Contraseña</label>
                <input type="password" name="password" class="form-control" required>
				<button type="submit"><a href="">Restablecer contraseña</a></button> 
				<div id="rc">
                            <a href="login.php">Iniciar sesion</a>
                        </div>
				<!-- Corregido: quitar el enlace -->

                <?php if (isset($_REQUEST['success'])): ?>
					<div class="alert alert-primary" role="alert">
                        <strong>¡Felicidades</strong>
						 Su contraseña se actualizo.
                    </div>
                <?php endif; ?>
				<?php if (isset($_REQUEST['error'])): ?>
					<div class="alert alert-danger" role="alert">
                        <strong>¡Error!</strong>
						Para restablecer es necesario que revise su correo.
                    </div>
                <?php endif; ?>
			</form>
		</div>
	</div>
	<style>
body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: 'Nunito Sans', sans-serif;
    background: linear-gradient(to bottom, #f0f8ff, #003053);
}

#img-container img {
    object-fit: cover; 
    width: 10%;
    height: 10%;
    background-color: white;
    border-radius: 8px;
    margin-left: 2%;
    margin-top: 2%;
}

.main {
    width: 380px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
}

label {
    color: #003053;
    font-size: 1.8em;
    margin-bottom: 10px;
    font-weight: 700;
}

#text {
    color: #555;
    margin-top: 5px;
    font-size: 1em;
}

input {
    width: 80%;
    padding: 12px;
    margin: 10px auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: 0.3s;
}

input:focus {
    border-color: #003053;
    box-shadow: 0 0 8px rgba(0, 48, 83, 0.1);
}

button {
    background-color: #003053;
    width: 80%;
    padding: 12px;
    margin-top: 20px;
    border: none;
    border-radius: 8px;
    color: #ffffff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color: #005081;
}

#rc {
    margin-top: 20px;
}

#rc a {
    color: #0056b3;
    text-decoration: none;
    font-weight: 600;
}

.alert {
    margin: 15px 0;
    padding: 10px;
    border-radius: 6px;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

.alert-primary {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
}
</style>

</body>
</html>
