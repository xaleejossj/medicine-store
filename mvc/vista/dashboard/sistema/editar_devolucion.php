<?php
include_once "includes/header.php";
include "../conexion.php";
$alert = '';

if (isset($_REQUEST['id'])) {
    $id_devolucion = $_REQUEST['id'];
    if (!is_numeric($id_devolucion)) {
        header("Location: lista_productos.php");
        exit();
    }

    $query_devolucion = mysqli_query($conexion, "SELECT d.ID_DEVOLUCION, d.CANTIDAD, d.FECHA, d.MOTIVO, d.ID_COMPRA
                                                  FROM devolucion d
                                                  WHERE d.ID_DEVOLUCION = $id_devolucion");

    $result_devolucion = mysqli_num_rows($query_devolucion);

    if ($result_devolucion > 0) {
        $data_devolucion = mysqli_fetch_assoc($query_devolucion);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($id_devolucion) && !empty($_POST['CANTIDAD']) && !empty($_POST['FECHA']) && !empty($_POST['MOTIVO']) && !empty($_POST['ID_COMPRA'])) {
        $cantidad = $_POST['CANTIDAD'];
        $fecha = $_POST['FECHA'];
        $motivo = $_POST['MOTIVO'];
        $id_compra = $_POST['ID_COMPRA'];

        // Obtener la cantidad comprada de la compra
        $query_compra = mysqli_query($conexion, "SELECT CANTIDAD FROM compra WHERE ID_COMPRA = '$id_compra'");
        $data_compra = mysqli_fetch_assoc($query_compra);
        $cantidad_comprada = $data_compra['CANTIDAD'];

        // Verificar si la cantidad a devolver es mayor que la cantidad comprada
        if ($cantidad > $cantidad_comprada) {
            $alert = '<div class="alert alert-danger" role="alert">La cantidad a devolver no puede ser mayor que la cantidad comprada</div>';
        } else {
            // Actualizar la devolución
            $query_update = mysqli_query($conexion, "UPDATE devolucion 
                                                     SET CANTIDAD = '$cantidad', FECHA = '$fecha', MOTIVO = '$motivo', ID_COMPRA = '$id_compra' 
                                                     WHERE ID_DEVOLUCION = $id_devolucion");
            if ($query_update) {
                // Actualizar la cantidad en la tabla de producto
                $query_update_product = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD - '$cantidad' WHERE ID_PRODUCTO = (SELECT ID_PRODUCTO FROM compra WHERE ID_COMPRA = '$id_compra')");
                if ($query_update_product) {
                    $alert = '<div class="alert alert-primary" role="alert">Devolución actualizada</div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el producto: ' . mysqli_error($conexion) . '</div>';
                }
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la devolución: ' . mysqli_error($conexion) . '</div>';
            }
        }
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Devolución
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" id="id" name="id" class="form-control" 
                                   value="<?php echo isset($data_devolucion['ID_DEVOLUCION']) ? $data_devolucion['ID_DEVOLUCION'] : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="CANTIDAD">Cantidad</label>
                            <input type="number" placeholder="Ingrese la cantidad" class="form-control" name="CANTIDAD"
                                id="CANTIDAD" value="<?php echo $data_devolucion['CANTIDAD']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha de devolución</label>
                            <input type="date" placeholder="Ingrese fecha" class="form-control" name="FECHA" id="FECHA"
                                value="<?php echo $data_devolucion['FECHA']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="ID_COMPRA">ID Compra</label>
                            <?php
                            $query_compra = mysqli_query($conexion, "SELECT * FROM compra ORDER BY ID_COMPRA ASC");
                            $resultado_compra = mysqli_num_rows($query_compra);
                            ?>
                            <select id="ID_COMPRA" name="ID_COMPRA" class="form-control">
                                <option value="">Seleccione una compra</option>
                                <?php
                                if ($resultado_compra > 0) {
                                    while ($compra = mysqli_fetch_array($query_compra)) {
                                        ?>
                                        <option value="<?php echo $compra["ID_COMPRA"]; ?>"
                                            <?php echo (isset($data_devolucion['ID_COMPRA']) && $data_devolucion['ID_COMPRA'] == $compra["ID_COMPRA"]) ? 'selected' : ''; ?>>
                                            <?php echo $compra["ID_COMPRA"]; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <input type="submit" value="Actualizar devolución" class="btn btn-primary">
                        <a href="lista_devoluciones.php" class="btn btn-danger">Regresar</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
