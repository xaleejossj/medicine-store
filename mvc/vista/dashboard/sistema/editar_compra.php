<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = '';

if (isset($_REQUEST['id'])) {
    $id_compra = $_REQUEST['id'];
    if (!is_numeric($id_compra)) {
        header("Location: lista_productos.php");
        exit();
    }

    $query_compra = mysqli_query($conexion, "SELECT co.ID_COMPRA, co.CANTIDAD, co.FECHA, pr.ID_PROVEEDOR, p.ID_PRODUCTO
                                              FROM compra co
                                              INNER JOIN producto p ON co.ID_PRODUCTO = p.ID_PRODUCTO
                                              INNER JOIN proveedor pr ON co.ID_PROVEEDOR = pr.ID_PROVEEDOR
                                              WHERE co.ID_COMPRA = $id_compra");

    $result_compra = mysqli_num_rows($query_compra);

    if ($result_compra > 0) {
        $data_compra = mysqli_fetch_assoc($query_compra);
    }
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($id_compra) && !empty($_POST['CANTIDAD']) && !empty($_POST['FECHA']) && !empty($_POST['PRODUCTO']) && !empty($_POST['PROVEEDOR'])) {
        $cantidad = $_POST['CANTIDAD'];
        $fecha = $_POST['FECHA'];
        $producto = $_POST['PRODUCTO'];
        $proveedor = $_POST['PROVEEDOR'];

        // Obtener la cantidad anterior de la compra
        $query_old_quantity = mysqli_query($conexion, "SELECT CANTIDAD FROM compra WHERE ID_COMPRA = $id_compra");
        $data_old_quantity = mysqli_fetch_assoc($query_old_quantity);
        $cantidad_anterior = $data_old_quantity['CANTIDAD'];

        // Restar la cantidad anterior del inventario del producto
        $query_revert_product = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD - '$cantidad_anterior' WHERE ID_PRODUCTO = '$producto'");

        if ($query_revert_product) {
            // Actualizar la compra
            $query_update = mysqli_query($conexion, "UPDATE compra 
                                                     SET CANTIDAD = '$cantidad', FECHA = '$fecha', ID_PRODUCTO = '$producto', ID_PROVEEDOR = '$proveedor' 
                                                     WHERE ID_COMPRA = $id_compra");
            if ($query_update) {
                // Sumar la nueva cantidad al inventario del producto
                $query_update_product = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD + '$cantidad' WHERE ID_PRODUCTO = '$producto'");
                if ($query_update_product) {
                    $alert = '<div class="alert alert-primary" role="alert">Compra actualizada</div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el producto: ' . mysqli_error($conexion) . '</div>';
                }
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la compra: ' . mysqli_error($conexion) . '</div>';
            }
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al revertir el inventario del producto: ' . mysqli_error($conexion) . '</div>';
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
          Modificar Compra
        </div>
        <div class="card-body">
          <form action="" method="post">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="id">ID</label>
              <input type="text" id="id" name="id" class="form-control"
                value="<?php echo isset($data_compra['ID_COMPRA']) ? $data_compra['ID_COMPRA'] : ''; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="nombre">Producto</label>
              <?php
              $query_producto = mysqli_query($conexion, "SELECT * FROM PRODUCTO ORDER BY ID_PRODUCTO ASC");
              $resultado_producto = mysqli_num_rows($query_producto);
              ?>
              <select id="PRODUCTO" name="PRODUCTO" class="form-control">
                <option value="">Seleccione un producto</option>
                <?php
                if ($resultado_producto > 0) {
                  while ($producto = mysqli_fetch_array($query_producto)) {
                    ?>
                    <option value="<?php echo $producto["ID_PRODUCTO"]; ?>"
                      <?php echo (isset($data_compra['ID_PRODUCTO']) && $data_compra['ID_PRODUCTO'] == $producto["ID_PRODUCTO"]) ? 'selected' : ''; ?>>
                      <?php echo $producto["NOMBRE_PRODUCTO"]; ?>
                    </option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="CANTIDAD">Cantidad</label>
              <input type="number" placeholder="Ingrese la cantidad" class="form-control" name="CANTIDAD" id="CANTIDAD"
                value="<?php echo $data_compra['CANTIDAD']; ?>">
            </div>
            <div class="form-group">
              <label for="fecha">Fecha de Compra</label>
              <input type="date" placeholder="Ingrese fecha" class="form-control" name="FECHA" id="FECHA"
                value="<?php echo $data_compra['FECHA']; ?>">
            </div>
            <div class="form-group">
              <label for="nombre">Proveedor</label>
              <?php
              $query_proveedor = mysqli_query($conexion, "SELECT * FROM PROVEEDOR ORDER BY ID_PROVEEDOR ASC");
              $resultado_proveedor = mysqli_num_rows($query_proveedor);
              mysqli_close($conexion);
              ?>
              <select id="PROVEEDOR" name="PROVEEDOR" class="form-control">
                <option value="">Seleccione un proveedor</option>
                <?php
                if ($resultado_proveedor > 0) {
                  while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                    ?>
                    <option value="<?php echo $proveedor["ID_PROVEEDOR"]; ?>"
                      <?php echo (isset($data_compra['ID_PROVEEDOR']) && $data_compra['ID_PROVEEDOR'] == $proveedor["ID_PROVEEDOR"]) ? 'selected' : ''; ?>>
                      <?php echo $proveedor["NOMBRE_PROVEEDOR"]; ?>
                    </option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>
            <input type="submit" value="Actualizar Compra" class="btn btn-primary">
            <a href="lista_compra.php" class="btn btn-danger">Regresar</a>

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
