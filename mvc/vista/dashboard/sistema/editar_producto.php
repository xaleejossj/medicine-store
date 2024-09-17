<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = '';

// Verificar si se ha pasado un ID de producto
if (isset($_REQUEST['id'])) {
    $id_producto = $_REQUEST['id'];
    if (!is_numeric($id_producto)) {
        header("Location: lista_productos.php");
        exit(); // Agregado para detener la ejecución
    }

    // Consulta para obtener los datos del producto
    $query_producto = mysqli_query($conexion, "SELECT p.ID_PRODUCTO, p.NOMBRE_PRODUCTO, p.DESCRIPCION, p.SERIAL, p.CANTIDAD, p.PRECIO, p.FECHA_CADUCIDAD, p.ESTADO, p.IMAGEN, p.ID_CATEGORIA
        FROM producto p
        WHERE p.ID_PRODUCTO = $id_producto");

    if (!$query_producto) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    $result_producto = mysqli_num_rows($query_producto);

    if ($result_producto > 0) {
        $data_producto = mysqli_fetch_assoc($query_producto);
    } else {
        header("Location: lista_productos.php");
        exit(); // Agregado para detener la ejecución
    }
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($id_producto) && !empty($_POST['NOMBRE_PRODUCTO']) && !empty($_POST['SERIAL']) && !empty($_POST['CANTIDAD']) && !empty($_POST['PRECIO']) && !empty($_POST['FECHA_CADUCIDAD']) && !empty($_POST['ESTADO']) && !empty($_POST['CATEGORIA'])) {
        $nombre = $_POST['NOMBRE_PRODUCTO'];
        $descripcion = $_POST['DESCRIPCION'];
        $serial = $_POST['SERIAL'];
        $cantidad = $_POST['CANTIDAD'];
        $precio = $_POST['PRECIO'];
        $fecha_caducidad = $_POST['FECHA_CADUCIDAD'];
        $estado = $_POST['ESTADO'];
        $categoria = $_POST['CATEGORIA'];

        // Manejar imagen
        $imagen = null; // Valor predeterminado en caso de no recibir una nueva imagen
        if (isset($_FILES['IMAGEN']) && $_FILES['IMAGEN']['error'] === UPLOAD_ERR_OK) {
            $imagen = file_get_contents($_FILES['IMAGEN']['tmp_name']);
        } else {
            $imagen = $data_producto['IMAGEN']; // Mantener la imagen existente si no se sube una nueva
        }

        // Consulta para actualizar el producto con el ID especificado
        $query_update = mysqli_prepare($conexion, "UPDATE producto SET NOMBRE_PRODUCTO = ?, DESCRIPCION = ?, SERIAL = ?, CANTIDAD = ?, PRECIO = ?, FECHA_CADUCIDAD = ?, ESTADO = ?, ID_CATEGORIA = ?, IMAGEN = ? WHERE ID_PRODUCTO = ?");
        if ($query_update) {
            mysqli_stmt_bind_param($query_update, 'sssisssisi', $nombre, $descripcion, $serial, $cantidad, $precio, $fecha_caducidad, $estado, $categoria, $imagen, $id_producto);
            $result = mysqli_stmt_execute($query_update);

            if ($result) {
                $alert = '<div class="alert alert-primary" role="alert">Producto actualizado</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al actualizar producto: ' . mysqli_error($conexion) . '</div>';
            }
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error en la preparación de la consulta: ' . mysqli_error($conexion) . '</div>';
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
          Modificar producto
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-group">
              <label for="producto">Producto</label>
              <input type="text" class="form-control" placeholder="Ingrese nombre del producto" name="NOMBRE_PRODUCTO"
                id="NOMBRE_PRODUCTO" value="<?php echo htmlspecialchars($data_producto['NOMBRE_PRODUCTO']); ?>">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" placeholder="Ingrese una descripción del producto" name="DESCRIPCION" id="DESCRIPCION" rows="3"><?php echo htmlspecialchars($data_producto['DESCRIPCION']); ?></textarea>
            </div>
            <div class="form-group">
              <label for="SERIAL">Serial</label>
              <input type="number" placeholder="Ingrese serial" class="form-control" name="SERIAL" id="SERIAL"
                value="<?php echo htmlspecialchars($data_producto['SERIAL']); ?>">
            </div>
            <div class="form-group">
              <label for="CANTIDAD">Cantidad</label>
              <input type="number" placeholder="Ingrese cantidad" class="form-control" name="CANTIDAD" id="CANTIDAD"
                value="<?php echo htmlspecialchars($data_producto['CANTIDAD']); ?>">
            </div>
            <div class="form-group">
              <label for="PRECIO">Precio</label>
              <input type="number" placeholder="Ingrese precio" class="form-control" name="PRECIO" id="PRECIO"
                value="<?php echo htmlspecialchars($data_producto['PRECIO']); ?>">
            </div>
            <div class="form-group">
               <label for="FECHA_CADUCIDAD">Fecha de caducidad</label>
                <input type="date" placeholder="Ingrese fecha" class="form-control" name="FECHA_CADUCIDAD" id="FECHA_CADUCIDAD"
                 value="<?php echo htmlspecialchars($data_producto['FECHA_CADUCIDAD']); ?>">
            </div>
            <div class="form-group">
              <label for="ESTADO">Estado</label>
              <input type="text" placeholder="Ingrese estado del producto" class="form-control" name="ESTADO"
                id="ESTADO" value="<?php echo htmlspecialchars($data_producto['ESTADO']); ?>">
            </div>
            <div class="form-group">
              <label for="CATEGORIA">Categoría</label>
              <?php
              $query_categoria = mysqli_query($conexion, "SELECT * FROM categoria ORDER BY ID_CATEGORIA ASC");
              $resultado_categoria = mysqli_num_rows($query_categoria);
              ?>
              <select id="CATEGORIA" name="CATEGORIA" class="form-control">
                <option value="">Seleccione una categoría</option>
                <?php
                if ($resultado_categoria > 0) {
                    while ($categoria = mysqli_fetch_array($query_categoria)) {
                ?>
                    <option value="<?php echo htmlspecialchars($categoria["ID_CATEGORIA"]); ?>"
                        <?php echo (isset($data_producto['ID_CATEGORIA']) && $data_producto['ID_CATEGORIA'] == $categoria["ID_CATEGORIA"]) ? 'selected' : ''; ?> >
                        <?php echo htmlspecialchars($categoria["CATEGORIA"]); ?>
                    </option>
                <?php
                    }
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="IMAGEN">Imagen</label>
              <input type="file" class="form-control" name="IMAGEN" id="IMAGEN">
              <?php if (!empty($data_producto['IMAGEN'])): ?>
                  <br>
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($data_producto['IMAGEN']); ?>" alt="Imagen del Producto" style="max-width: 200px; max-height: 200px;">
              <?php endif; ?>
            </div>

            <input type="submit" value="Actualizar Producto" class="btn btn-primary">
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
