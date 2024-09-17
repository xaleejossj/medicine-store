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
</body>
</html>
