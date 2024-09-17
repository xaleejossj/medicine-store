<?php
include_once "includes/header.php";
include "../conexion.php";


if (empty($_POST['nombre_proveedor']) || empty($_POST['nit']) || empty($_POST['telefono']) || empty($_POST['email'])) {
    $alert = '<div class="alert alert-danger" role="alert">
                    Todos los campos son obligatorios
                </div>';
} else {       
    $nombre = $_POST['nombre_proveedor'];
    $nit = $_POST['nit'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    
    // Verificar si el NIT ya está registrado
    $query = mysqli_query($conexion, "SELECT * FROM proveedor WHERE nit = '$nit'");
    $result = mysqli_fetch_array($query);

    if ($result > 0) {
        $alert = '<div class="alert alert-danger" role="alert">
                    El NIT ya está registrado
                </div>';
    } else {
        // Insertar proveedor en la base de datos
        $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(NOMBRE_PROVEEDOR, NIT, TELEFONO, EMAIL) VALUES ('$nombre', '$nit', '$telefono', '$email')");

        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                        Proveedor registrado exitosamente
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar proveedor: ' . mysqli_error($conexion) . '
                    </div>';
        }
    }
}

mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de Proveedor
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre_proveedor">Nombre de la empresa</label>
                        <input type="text" placeholder="Ingrese nombre" name="nombre_proveedor" id="nombre_proveedor" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nit">NIT</label>
                        <input type="text" placeholder="Ingrese NIT de la empresa" name="nit" id="nit" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" placeholder="Ingrese teléfono" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Ingrese email de la empresa" name="email" id="email" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Proveedor" class="btn btn-primary">
                    <a href="lista_proveedor.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
