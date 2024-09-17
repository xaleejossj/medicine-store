<?php
include_once "includes/header.php";
require "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_facturar_venta'])) {
    // Capturar los datos del formulario
    $idProducto = isset($_POST['txt_producto_id']) ? $_POST['txt_producto_id'] : 0;    
    $idPedido = isset($_POST['txt_pedido_id']) ? $_POST['txt_pedido_id'] : 0;
    $idUsuario = isset($_POST['txt_usuario_id']) ? $_POST['txt_usuario_id'] : 0;

    // Llamar al procedimiento almacenado
    $query = "CALL GenerarVenta($idProducto, $idPedido, $idUsuario)";

    if (mysqli_query($conexion, $query)) {
        echo "Venta generada con éxito";
    } else {
        echo "Error al llamar al procedimiento almacenado: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <form method="post" action="">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <h4 class="text-center">REGISTRO DE VENTAS</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> </label>
                </div>
            </div>
            <div class="col-lg-6">
                <label>Acciones</label>
                <div id="acciones_venta" class="form-group">
                    <a href="#" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                    <button type="submit" class="btn btn-primary" name="btn_facturar_venta">
                        <i class="fas fa-save"></i> Generar Venta
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                            <th>Id_venta</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Medio de Pago</th>
                            <th>Valor</th>
                            <th>ID_Usuario</th>
                            <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Cambié el nombre del campo a txt_valor_venta -->
                        <td><input type="number" name="txt_venta_id" id="txt_venta_id" value="0" min="1" class="textright"></td>
                        <td><input type="number" name="txt_cantidad" id="txt_cantidad_id" value="0" min="1"></td>
                        <td><input type="date" name="txt_fecha" id="txt_fecha"></td>
                        <td><input type="text" name="txt_medio_pago" id="txt_medio_pago" value="0" min="1"></td>
                        <td><input type="number" name="txt_valor" id="txt_valor" value="0" min="1"></td>
                        <td><input type="number" name="txt_usuario_id" id="txt_usuario_id" value="0" min="1"></td>
                        <td><button type="submit" class="btn btn-dark" name="btn_facturar_venta">Agregar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
