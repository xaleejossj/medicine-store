<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = '';

// Consulta para obtener datos del proveedor por ID
if (isset($_REQUEST['id'])) {
    $id_proveedor = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT pr.ID_PROVEEDOR, pr.NOMBRE_PROVEEDOR, pr.NIT, pr.TELEFONO, pr.EMAIL
                                      FROM proveedor pr
                                      WHERE pr.ID_PROVEEDOR = $id_proveedor");

    if (mysqli_num_rows($query) > 0) {
        $data_proveedor = mysqli_fetch_assoc($query);
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Proveedor no encontrado</div>';
    }
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($id_proveedor) && !empty($_POST['nombre_proveedor']) && !empty($_POST['nit']) && !empty($_POST['telefono']) && !empty($_POST['email'])) {
        $nombre = $_POST['nombre_proveedor'];
        $nit = $_POST['nit'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        // Consulta para actualizar el proveedor con el ID especificado
        $query_update = mysqli_query($conexion, "UPDATE proveedor SET NOMBRE_PROVEEDOR = '$nombre', NIT = '$nit',TELEFONO = '$telefono',  EMAIL = '$email' WHERE ID_PROVEEDOR = $id_proveedor");

        if ($query_update) {
            $alert = '<div class="alert alert-primary" role="alert">Proveedor actualizado</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar proveedor: ' . mysqli_error($conexion) . '</div>';
        }
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
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
                Actualizar Proveedor
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre_proveedor">Nombre de la empresa</label>
                        <input type="text" placeholder="Ingrese nombre" name="nombre_proveedor" id="nombre_proveedor" class="form-control" value="<?php echo isset($data_proveedor['NOMBRE_PROVEEDOR']) ? $data_proveedor['NOMBRE_PROVEEDOR'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nit">NIT</label>
                        <input type="text" placeholder="Ingrese NIT de la empresa" name="nit" id="nit" class="form-control" value="<?php echo isset($data_proveedor['NIT']) ? $data_proveedor['NIT'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" placeholder="Ingrese teléfono" name="telefono" id="telefono" class="form-control" value="<?php echo isset($data_proveedor['TELEFONO']) ? $data_proveedor['TELEFONO'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Ingrese email de la empresa" name="email" id="email" class="form-control" value="<?php echo isset($data_proveedor['EMAIL']) ? $data_proveedor['EMAIL'] : ''; ?>">
                    </div>
                    <input type="submit" value="Actualizar Proveedor" class="btn btn-primary">
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
