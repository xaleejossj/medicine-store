<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/recover_pass.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <title>Recuperar Contraseña</title>
</head>
<body>

    <div id="img-container">
        <img src="img/logo.png" width="125" height="120">
    </div>
    <div class="main">  
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form action="recuperarClaveConLink.php" method="post">
                <label for="chk" aria-hidden="true">Recuperar Contraseña</label>
                <label for="chk" aria-hidden="true" id="text">Ingrese su correo electrónico</label>
                <input type="email" name="email" placeholder="correo" required autocomplete="off"/>
                <button type="submit">Enviar</button>
				<br>

                <?php if (isset($_REQUEST['errorEmail'])): ?>
                    <div class="alert alert-danger" role="alert">
                        El correo no existe, inente nuevamente.
                    </div>';
                <?php endif; ?>

                <?php if (isset($_REQUEST['success'])): ?>
					<div class="alert alert-primary" role="alert">
                        <strong>¡Felicidades</strong>
						 Revise su correo para continuar.
                    </div>
                <?php endif; ?>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
