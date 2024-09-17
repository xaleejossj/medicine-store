<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = '';

// Consulta para obtener datos del usuario por ID
if (isset($_REQUEST['id'])) {
    $id_usuario = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT u.ID_USUARIO, u.TIPO_DOC, u.DOCUMENTO, u.NOMBRE, u.TELEFONO, u.DIRECCION, u.EMAIL, u.CONTRASEÑA, u.ID_ROL
    FROM usuario u
    INNER JOIN rol r ON u.ID_ROL = r.ID_ROL
    WHERE u.ID_USUARIO = $id_usuario");

    if (mysqli_num_rows($query) > 0) {
        $data_usuario = mysqli_fetch_assoc($query);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Usuario no encontrado</div>';
    }
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($id_usuario) && !empty($_POST['tipo_doc']) && !empty($_POST['documento']) && !empty($_POST['nombre']) && !empty($_POST['telefono']) && !empty($_POST['direccion']) && !empty($_POST['email']) && !empty($_POST['contrasena'] || empty($_POST['direccion']) || empty($_POST['email']) || empty($_POST['contraseña']) || empty($_POST['ROL']))) {
        $tipo_doc = $_POST['tipo_doc'];
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];
        $contraseña = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
        $rol = $_POST['ROL'];

        // Consulta para actualizar el usuario con el ID especificado
        $query_update = mysqli_query($conexion, "UPDATE usuario SET TIPO_DOC = '$tipo_doc', DOCUMENTO = '$documento', NOMBRE = '$nombre', TELEFONO = '$telefono', DIRECCION = '$direccion', EMAIL = '$email', CONTRASEÑA = '$contraseña', ID_ROL ='$rol' WHERE ID_USUARIO = $id_usuario");
        if ($query_update) {
            $alert = '<div class="alert alert-primary" role="alert">Usuario actualizado</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar usuario: ' . mysqli_error($conexion) . '</div>';
        }
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Actualizar Usuario
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="nunber" name="id" id="id" class="form-control"
                            value="<?php echo isset($data_usuario['ID_USUARIO']) ? $data_usuario['ID_USUARIO'] : ''; ?>">
                    </div>
                    <div class="form-group">
                           <label for="tipo_doc">Tipo de documento</label>
                           <select name="tipo_doc" id="tipo_doc" class="form-control">
                           <option value="Pasaporte" <?php echo ($data_usuario['TIPO_DOC'] == 'Pasaporte') ? 'selected' : ''; ?>>Pasaporte</option>
                           <option value="Licencia" <?php echo ($data_usuario['TIPO_DOC'] == 'Licencia') ? 'selected' : ''; ?>>T.I</option>
                           <option value="Cedula" <?php echo ($data_usuario['TIPO_DOC'] == 'Cedula') ? 'selected' : ''; ?>>Cédula</option>
                           </select>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="nunber" placeholder="Ingrese Documento" name="documento" id="documento"
                            class="form-control"
                            value="<?php echo isset($data_usuario['DOCUMENTO']) ? $data_usuario['DOCUMENTO'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" placeholder="Ingrese nombre" name="nombre" id="nombre" class="form-control"
                            value="<?php echo isset($data_usuario['NOMBRE']) ? $data_usuario['NOMBRE'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" placeholder="Ingrese teléfono" name="telefono" id="telefono"
                            class="form-control"
                            value="<?php echo isset($data_usuario['TELEFONO']) ? $data_usuario['TELEFONO'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" placeholder="Ingrese dirección" name="direccion" id="direccion"
                            class="form-control"
                            value="<?php echo isset($data_usuario['DIRECCION']) ? $data_usuario['DIRECCION'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Ingrese email" name="email" id="email" class="form-control"
                            value="<?php echo isset($data_usuario['EMAIL']) ? $data_usuario['EMAIL'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" placeholder="Ingrese contraseña" name="contrasena" id="contrasena"
                            class="form-control"
                            value="<?php echo isset($data_usuario['CONTRASEÑA']) ? $data_usuario['CONTRASEÑA'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="ROL">Rol</label>
                        <?php
                        $query_rol = mysqli_query($conexion, "SELECT * FROM rol WHERE ID_ROL IN (1, 2) ORDER BY ID_ROL ASC");
                        $resultado_rol = mysqli_num_rows($query_rol);
                        ?>
                        <select id="ROL" name="ROL" class="form-control">
                            <option value="">Seleccione un rol</option>
                            <?php
                            if ($resultado_rol > 0) {
                                while ($rol = mysqli_fetch_array($query_rol)) {
                                    ?>
                                    <option value="<?php echo $rol["ID_ROL"]; ?>" <?php echo (isset($data_usuario['ID_ROL']) && $data_usuario['ID_ROL'] == $rol["ID_ROL"]) ? 'selected' : ''; ?>>
                                        <?php echo $rol["ROL"]; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" value="Actualizar Usuario" class="btn btn-primary">
                    <a href="lista_usuarios.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>