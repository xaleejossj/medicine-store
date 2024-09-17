<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id_compra = $_GET['id'];

    // Obtener la cantidad comprada y la cantidad devuelta
    $query_compra = mysqli_query($conexion, "SELECT CANTIDAD FROM compra WHERE ID_COMPRA = $id_compra");
    $data_compra = mysqli_fetch_assoc($query_compra);
    $cantidad_comprada = $data_compra['CANTIDAD'];

    $query_devoluciones = mysqli_query($conexion, "SELECT SUM(CANTIDAD) AS CANTIDAD_DEVUELTA FROM devolucion WHERE ID_COMPRA = $id_compra");
    $data_devoluciones = mysqli_fetch_assoc($query_devoluciones);
    $cantidad_devuelta = $data_devoluciones['CANTIDAD_DEVUELTA'];

    // Calcular la cantidad restante después de devoluciones
    $cantidad_no_devuelta = $cantidad_comprada - $cantidad_devuelta;

    // Actualizar la cantidad de productos en stock
    $query_producto = mysqli_query($conexion, "SELECT ID_PRODUCTO FROM compra WHERE ID_COMPRA = $id_compra");
    $data_producto = mysqli_fetch_assoc($query_producto);
    $id_producto = $data_producto['ID_PRODUCTO'];

    $query_update_producto = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD - $cantidad_no_devuelta WHERE ID_PRODUCTO = $id_producto");

    if ($query_update_producto) {
        // Eliminar las devoluciones relacionadas con la compra
        $query_delete_devoluciones = mysqli_query($conexion, "DELETE FROM devolucion WHERE ID_COMPRA = $id_compra");

        if ($query_delete_devoluciones) {
            // Ahora eliminar la compra
            $query_delete_compra = mysqli_query($conexion, "DELETE FROM compra WHERE ID_COMPRA = $id_compra");

            if ($query_delete_compra) {
                mysqli_close($conexion);
                header("location: lista_productos.php");
                exit();
            } else {
                // Manejar error en la eliminación de la compra
                $alert = '<div class="alert alert-danger" role="alert">Error al eliminar la compra: ' . mysqli_error($conexion) . '</div>';
            }
        } else {
            // Manejar error en la eliminación de las devoluciones
            $alert = '<div class="alert alert-danger" role="alert">Error al eliminar las devoluciones relacionadas: ' . mysqli_error($conexion) . '</div>';
        }
    } else {
        // Manejar error en la actualización de la cantidad de productos
        $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la cantidad de productos: ' . mysqli_error($conexion) . '</div>';
    }

    mysqli_close($conexion);
}
?>
