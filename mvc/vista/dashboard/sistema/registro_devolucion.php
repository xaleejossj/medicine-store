<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = ''; // Inicializar la variable de alerta

if (isset($_GET['ID_DEVOLUCION'])) {
    $id_devolucion = $_GET['ID_DEVOLUCION'];

    // Obtener información de la devolución si está presente
    $query_devolucion = mysqli_query($conexion, "SELECT * FROM devolucion WHERE ID_DEVOLUCION = '$id_devolucion'");
    $data_devolucion = mysqli_fetch_assoc($query_devolucion);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['CANTIDAD']) || empty($_POST['FECHA']) || empty($_POST['MOTIVO']) || empty($_POST['COMPRA'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id_compra = $_POST['COMPRA'];
        $cantidad = $_POST['CANTIDAD'];
        $fecha = $_POST['FECHA'];
        $motivo = $_POST['MOTIVO'];

        // Obtener el ID_PRODUCTO y la cantidad comprada de la compra
        $query_compra = mysqli_query($conexion, "SELECT ID_PRODUCTO, CANTIDAD FROM compra WHERE ID_COMPRA = '$id_compra'");
        $data_compra = mysqli_fetch_assoc($query_compra);
        $id_producto = $data_compra['ID_PRODUCTO'];
        $cantidad_comprada = $data_compra['CANTIDAD'];

        // Verificar si la cantidad a devolver es mayor que la cantidad comprada
        if ($cantidad > $cantidad_comprada) {
            $alert = '<div class="alert alert-danger" role="alert">La cantidad a devolver no puede ser mayor que la cantidad comprada</div>';
        } else {
            // Registrar la devolución
            $query_insert = mysqli_query($conexion, "INSERT INTO devolucion (CANTIDAD, FECHA, MOTIVO, ID_COMPRA) VALUES ('$cantidad', '$fecha', '$motivo', '$id_compra')");

            if ($query_insert) {
                // Actualizar la cantidad del producto
                $query_update_product = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD - '$cantidad' WHERE ID_PRODUCTO = '$id_producto'");

                if ($query_update_product) {
                    $alert = '<div class="alert alert-primary" role="alert">Devolución registrada y producto actualizado</div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el producto: ' . mysqli_error($conexion) . '</div>';
                }
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al registrar la devolución: ' . mysqli_error($conexion) . '</div>';
            }
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
  <a href="lista_devoluciones.php" class="btn btn-primary">Regresar</a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-6 m-auto">
    <form action="" method="post" autocomplete="off">
      <?php echo $alert; ?>
      <div class="card-body">
        <div class="form-group">
          <label for="COMPRA">ID Compra</label>
          <?php
          $query_compra = mysqli_query($conexion, "SELECT * FROM compra ORDER BY ID_COMPRA ASC");
          $resultado_compra = mysqli_num_rows($query_compra);
          ?>
          <select id="COMPRA" name="COMPRA" class="form-control">
            <option value="">Seleccione Id compra</option>
            <?php
            if ($resultado_compra > 0) {
              while ($compra = mysqli_fetch_array($query_compra)) {
                ?>
                <option value="<?php echo $compra['ID_COMPRA']; ?>" <?php echo (isset($data_devolucion['ID_COMPRA']) && $data_devolucion['ID_COMPRA'] == $compra['ID_COMPRA']) ? 'selected' : ''; ?>>
                  <?php echo $compra['ID_COMPRA']; ?>
                </option>
                <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="CANTIDAD">Cantidad</label>
          <input type="number" placeholder="Ingrese la cantidad" class="form-control" name="CANTIDAD" id="CANTIDAD" value="<?php echo isset($data_devolucion['CANTIDAD']) ? $data_devolucion['CANTIDAD'] : ''; ?>">
        </div>
        <div class="form-group">
          <label for="FECHA">Fecha de devolución</label>
          <input type="date" placeholder="Ingrese fecha de devolución" class="form-control" name="FECHA" id="FECHA" value="<?php echo isset($data_devolucion['FECHA']) ? $data_devolucion['FECHA'] : ''; ?>">
        </div>
        <div class="form-group">
          <label for="MOTIVO">Motivo de devolución</label>
          <select class="form-control" name="MOTIVO" id="MOTIVO">
            <option value="Vencimiento" <?php echo (isset($data_devolucion['MOTIVO']) && $data_devolucion['MOTIVO'] == 'Vencimiento') ? 'selected' : ''; ?>>Vencimiento</option>
            <option value="Mal estado" <?php echo (isset($data_devolucion['MOTIVO']) && $data_devolucion['MOTIVO'] == 'Mal estado') ? 'selected' : ''; ?>>Mal estado</option>
          </select>
        </div>
        <input type="submit" value="Generar devolución" class="btn btn-primary">
      </div>
    </form>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
