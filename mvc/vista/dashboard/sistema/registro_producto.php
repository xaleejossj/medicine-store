<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = ''; // Inicializar la variable de alerta

if (isset($_GET['ID_PRODUCTO'])) {
    $idProducto = $_GET['ID_PRODUCTO'];

    // Obtener información del producto si está presente
    $query_producto = mysqli_query($conexion, "SELECT * FROM producto WHERE ID_PRODUCTO = '$idProducto'");
    $data_producto = mysqli_fetch_assoc($query_producto);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar campos
    if (empty($_POST['NOMBRE']) || empty($_POST['SERIAL']) || empty($_POST['CANTIDAD']) || empty($_POST['PRECIO']) || empty($_POST['ESTADO']) || empty($_POST['CATEGORIA']) || empty($_POST['DESCRIPCION'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = isset($data_producto['ID_PRODUCTO']) ? $data_producto['ID_PRODUCTO'] : '';
        $nombre = $_POST['NOMBRE'];
        $descripcion = $_POST['DESCRIPCION'];
        $serial = $_POST['SERIAL'];
        $cantidad = $_POST['CANTIDAD'];
        $precio = $_POST['PRECIO'];
        $fecha = $_POST['FECHA_CADUCIDAD'];
        $estado = $_POST['ESTADO'];
        $categoria = $_POST['CATEGORIA'];
        
        // Manejar imagen
        $imagen = null;
        if (isset($_FILES['IMAGEN']) && $_FILES['IMAGEN']['error'] === UPLOAD_ERR_OK) {
            $imagen = file_get_contents($_FILES['IMAGEN']['tmp_name']);
        }

        if (empty($id)) {
            // Si no hay ID, es un nuevo producto
            $query_insert = mysqli_prepare($conexion, "INSERT INTO producto (NOMBRE_PRODUCTO, DESCRIPCION, SERIAL, CANTIDAD, PRECIO, FECHA_CADUCIDAD, ESTADO, ID_CATEGORIA, IMAGEN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($query_insert, 'ssissssis', $nombre, $descripcion, $serial, $cantidad, $precio, $fecha, $estado, $categoria, $imagen);
            $result = mysqli_stmt_execute($query_insert);
        } else {
            // Si hay ID, es una actualización
            $query_update = mysqli_prepare($conexion, "UPDATE producto SET NOMBRE_PRODUCTO = ?, DESCRIPCION = ?, SERIAL = ?, CANTIDAD = ?, PRECIO = ?, FECHA_CADUCIDAD = ?, ESTADO = ?, ID_CATEGORIA = ?, IMAGEN = ? WHERE ID_PRODUCTO = ?");
            mysqli_stmt_bind_param($query_update, 'ssisssissi', $nombre, $descripcion, $serial, $cantidad, $precio, $fecha, $estado, $categoria, $imagen, $id);
            $result = mysqli_stmt_execute($query_update);
        }

        if ($result) {
            $alert = '<div class="alert alert-primary" role="alert">Producto Registrado/Actualizado</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al registrar/actualizar el producto</div>';
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
  <a href="lista_productos.php" class="btn btn-primary">Regresar</a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-6 m-auto">
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
      <?php echo $alert; ?>
      <div class="card-body">
      <div class="form-group">
           <label for="producto">Producto</label>
           <input type="text" class="form-control" placeholder="Ingrese nombre del producto" name="NOMBRE" id="NOMBRE_PRODUCTO" value="<?php echo isset($data_producto['NOMBRE_PRODUCTO']) ? htmlspecialchars($data_producto['NOMBRE_PRODUCTO']) : ''; ?>">
      </div>
      <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea class="form-control" placeholder="Ingrese una descripción del producto" name="DESCRIPCION" id="DESCRIPCION" rows="3"><?php echo isset($data_producto['DESCRIPCION']) ? htmlspecialchars($data_producto['DESCRIPCION']) : ''; ?></textarea>
      </div>
      <div class="form-group">
           <label for="SERIAL">Serial</label>
           <input type="number" placeholder="Ingrese serial" class="form-control" name="SERIAL" id="SERIAL" value="<?php echo isset($data_producto['SERIAL']) ? htmlspecialchars($data_producto['SERIAL']) : ''; ?>">
      </div>
      <div class="form-group">
           <label for="CANTIDAD">Cantidad</label>
           <input type="number" placeholder="Ingrese la cantidad" class="form-control" name="CANTIDAD" id="CANTIDAD" value="<?php echo isset($data_producto['CANTIDAD']) ? htmlspecialchars($data_producto['CANTIDAD']) : ''; ?>">
      </div>
      <div class="form-group">
           <label for="PRECIO">Precio</label>
           <input type="number" class="form-control" placeholder="Ingrese precio" name="PRECIO" id="PRECIO" value="<?php echo isset($data_producto['PRECIO']) ? htmlspecialchars($data_producto['PRECIO']) : ''; ?>">
      </div>
      <div class="form-group">
           <label for="fecha">Fecha de caducidad</label>
           <input type="date" placeholder="Ingrese fecha de caducidad" class="form-control" name="FECHA_CADUCIDAD" id="FECHA_CADUCIDAD" value="<?php echo isset($data_producto['FECHA_CADUCIDAD']) ? htmlspecialchars($data_producto['FECHA_CADUCIDAD']) : ''; ?>">
      </div>
      <div class="form-group">
           <label for="estado">Estado</label>
           <input type="text" placeholder="Ingrese estado del producto" class="form-control" name="ESTADO" id="ESTADO" value="<?php echo isset($data_producto['ESTADO']) ? htmlspecialchars($data_producto['ESTADO']) : ''; ?>">
      </div>
      <div class="form-group">
           <label for="nombre">Categoría</label>
           <?php
           $query_categoria = mysqli_query($conexion, "SELECT * FROM CATEGORIA ORDER BY ID_CATEGORIA ASC");
           $resultado_categoria = mysqli_num_rows($query_categoria);
           ?>
           <select id="CATEGORIA" name="CATEGORIA" class="form-control">
             <option value="">Selecciona una categoría</option>
             <?php
             if ($resultado_categoria > 0) {
               while ($categoria = mysqli_fetch_array($query_categoria)) {
             ?>
                 <option value="<?php echo $categoria['ID_CATEGORIA']; ?>" <?php echo (isset($data_producto['ID_CATEGORIA']) && $data_producto['ID_CATEGORIA'] == $categoria['ID_CATEGORIA']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($categoria['CATEGORIA']); ?></option>
             <?php
               }
             }
             ?>
           </select>
      </div>
      
      <div class="form-group">
           <label for="imagen">Imagen</label>
           <input type="file" class="form-control" name="IMAGEN" id="IMAGEN">
           <?php if (!empty($data_producto['IMAGEN'])): ?>
               <br>
               <img src="data:image/jpeg;base64,<?php echo base64_encode($data_producto['IMAGEN']); ?>" alt="Imagen del Producto" style="max-width: 200px; max-height: 200px;">
           <?php endif; ?>
      </div>

      <input type="submit" value="Guardar Producto" class="btn btn-primary">
    </form>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
