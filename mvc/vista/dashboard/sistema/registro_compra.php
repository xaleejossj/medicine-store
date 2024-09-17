<?php
include_once "includes/header.php";
include "../conexion.php";

$alert = ''; // Inicializar la variable de alerta

if (isset($_GET['ID_COMPRA'])) {
    $id_compra = $_GET['ID_COMPRA'];

    // Obtener información de la compra si está presente
    $query_compra = mysqli_query($conexion, "SELECT * FROM compra WHERE ID_COMPRA = '$id_compra'");
    $data_compra = mysqli_fetch_assoc($query_compra);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['CANTIDAD']) || empty($_POST['FECHA']) || empty($_POST['PRODUCTO']) || empty($_POST['PROVEEDOR'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = isset($data_compra['ID_COMPRA']) ? $data_compra['ID_COMPRA'] : '';
        $cantidad = $_POST['CANTIDAD'];
        $fecha = $_POST['FECHA'];
        $producto = $_POST['PRODUCTO'];
        $proveedor = $_POST['PROVEEDOR'];

        if (empty($id)) {
            // Si no hay ID, es un nuevo producto
            $query_insert = mysqli_query($conexion, "INSERT INTO compra (CANTIDAD, FECHA, ID_PRODUCTO, ID_PROVEEDOR) VALUES ('$cantidad', '$fecha', '$producto', '$proveedor')");
            if ($query_insert) {
                // Actualizar la cantidad en la tabla de producto
                $query_update_product = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD + '$cantidad' WHERE ID_PRODUCTO = '$producto'");
            }
        } 
        
        if (isset($query_insert) && $query_insert || isset($query_update) && $query_update) {
            $alert = '<div class="alert alert-primary" role="alert">Compra Registrada</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al registrar la compra</div>';
        }
    }
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
  <a href="lista_compra.php" class="btn btn-primary">Regresar</a>
</div>

<!-- Content Row -->
<div class="row">
  <div class="col-lg-6 m-auto">
    <form action="" method="post" autocomplete="off">
      <?php echo $alert; ?>
      <div class="card-body">
      <div class="form-group">
           <label for="nombre">Producto</label>
           <?php
           $query_producto = mysqli_query($conexion, "SELECT * FROM producto ORDER BY ID_PRODUCTO ASC");
           $resultado_producto = mysqli_num_rows($query_producto);
           ?>
           <select id="PRODUCTO" name="PRODUCTO" class="form-control">
             <option value="">Selecciona el producto</option>
             <?php
             if ($resultado_producto > 0) {
               while ($producto = mysqli_fetch_array($query_producto)) {
             ?>
                 <option value="<?php echo $producto['ID_PRODUCTO']; ?>" <?php echo (isset($data_compra['ID_PRODUCTO']) && $data_compra['ID_PRODUCTO'] == $producto['ID_PRODUCTO']) ? 'selected' : ''; ?>><?php echo $producto['NOMBRE_PRODUCTO']; ?></option>
             <?php
               }
             }
             ?>
           </select>
      </div>
      <div class="form-group">
           <label for="CANTIDAD">Cantidad</label>
           <input type="number" placeholder="Ingrese la cantidad"class="form-control" name="CANTIDAD" id="CANTIDAD" value="<?php echo isset($data_compra['CANTIDAD']) ? $data_compra['CANTIDAD'] : ''; ?>">
      </div>
      <div class="form-group">
           <label for="nombre">Proveedor</label>
           <?php
           $query_proveedor = mysqli_query($conexion, "SELECT * FROM proveedor ORDER BY ID_PROVEEDOR ASC");
           $resultado_proveedor = mysqli_num_rows($query_proveedor);
           mysqli_close($conexion);
           ?>
           <select id="PROVEEDOR" name="PROVEEDOR" class="form-control">
             <option value="">Seleccione un proveedor</option>
             <?php
             if ($resultado_proveedor > 0) {
               while ($proveedor = mysqli_fetch_array($query_proveedor)) {
             ?>
                 <option value="<?php echo $proveedor['ID_PROVEEDOR']; ?>" <?php echo (isset($data_compra['ID_PROVEEDOR']) && $data_compra['ID_PROVEEDOR'] == $proveedor['ID_PROVEEDOR']) ? 'selected' : ''; ?>><?php echo $proveedor['NOMBRE_PROVEEDOR']; ?></option>
             <?php
               }
             }
             ?>
           </select>
      </div>
      <div class="form-group">
           <label for="fecha">Fecha de Compra</label>
           <input type="date" placeholder="Ingrese fecha" class="form-control" name="FECHA" id="FECHA" value="<?php echo isset($data_compra['FECHA']) ? $data_compra['FECHA'] : ''; ?>">
      </div>


      <input type="submit" value="Registrar Compra" class="btn btn-primary">
    </form>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
