<?php include_once "includes/header.php";
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el número de teléfono enviado desde el formulario
    $telefono = $_POST['telefono'];

    // Función de validación del número de teléfono
    function validarTelefono($telefono) {
        // Patrón regex para validar números de teléfono en Colombia (fijo o celular)
        // Acepta números con o sin prefijo internacional (+57) y separadores (espacios, guiones)
        $patron = "/^\+?57(0|3|3[0-9]{1,2})([ .-]?)([0-9]{3})([ .-]?)([0-9]{4})$/";

        // Verificar si el número de teléfono coincide con el patrón regex
        if (preg_match($patron, $telefono)) {
            return true; // Válido
        } else {
            return false; // No válido
        }
    }
}
    if (empty($_POST['tipo_doc']) || empty($_POST['documento']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['email']) || empty($_POST['contraseña']) || empty($_POST['ROL'])) {
        $alert = '<div class="alert alert-primary" role="alert">
                    Todo los campos son obligatorios
                </div>';
    } else {

        $tipo_doc = $_POST['tipo_doc'];
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
        $rol = $_POST['ROL'];

        $query = mysqli_query($conexion, "SELECT * FROM usuario where email = '$email'");
        $result = mysqli_fetch_array($query);
        
        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO usuario(TIPO_DOC, DOCUMENTO, NOMBRE, TELEFONO, DIRECCION, EMAIL, CONTRASEÑA, ID_ROL) VALUES ('$tipo_doc','$documento','$nombre', '$telefono', '$direccion', '$email', '$contraseña', '$rol')");
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Usuario registrado
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
                    </div>';
            }
        }
    }
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
        <a href="lista_usuarios.php" class="btn btn-primary">Regresar</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
            
                <div class="form-group">
                    <label for="tipo_doc">Tipo de documento</label>
                    <select type="text" class="form-control" placeholder="Seleccione Documento" name="tipo_doc" id="tipo_doc">
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="Licencia">T.I</option>
                    <option value="Cedula">Cédula</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input type="nunber" class="form-control" placeholder="Ingrese Documento" name="documento" id="documento">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="nuMber" class="form-control" placeholder="Ingrese Telefono" name="telefono" id="telefono">
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="direccion" class="form-control" placeholder="Ingrese Direccion" name="direccion" id="direccion">
                </div>
                <div class="form-group">
                    <label for="email">Correo Electronico</label>
                    <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="contraseña" id="contraseña">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="ROL" id="ROL" class="form-control">
                        <?php
                        $query_rol = mysqli_query($conexion, " select * from rol");
                        mysqli_close($conexion);
                        $resultado_rol = mysqli_num_rows($query_rol);
                        if ($resultado_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                                <option value="<?php echo $rol["ID_ROL"]; ?>"><?php echo $rol["ROL"] ?></option>
                        <?php

                            }
                        }

                        ?>
                    </select>
                </div>
                <input type="submit" value="Guardar Usuario" class="btn btn-primary">
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>