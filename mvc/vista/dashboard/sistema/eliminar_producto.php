<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id_producto = $_GET['id'];

    // Obtener todas las compras relacionadas con el producto
    $query_compras = mysqli_query($conexion, "SELECT ID_COMPRA, CANTIDAD FROM compra WHERE ID_PRODUCTO = $id_producto");

    while ($data_compra = mysqli_fetch_assoc($query_compras)) {
        $id_compra = $data_compra['ID_COMPRA'];
        $cantidad_comprada = $data_compra['CANTIDAD'];

        // Obtener la cantidad devuelta para cada compra
        $query_devoluciones = mysqli_query($conexion, "SELECT SUM(CANTIDAD) AS CANTIDAD_DEVUELTA FROM devolucion WHERE ID_COMPRA = $id_compra");
        $data_devoluciones = mysqli_fetch_assoc($query_devoluciones);
        $cantidad_devuelta = $data_devoluciones['CANTIDAD_DEVUELTA'] ?? 0;

        // Calcular la cantidad no devuelta
        $cantidad_no_devuelta = $cantidad_comprada - $cantidad_devuelta;

        // Actualizar la cantidad de productos en stock si es necesario
        $query_update_producto = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD - $cantidad_no_devuelta WHERE ID_PRODUCTO = $id_producto");

        // Eliminar las devoluciones relacionadas con la compra
        $query_delete_devoluciones = mysqli_query($conexion, "DELETE FROM devolucion WHERE ID_COMPRA = $id_compra");

        // Eliminar la compra
        $query_delete_compra = mysqli_query($conexion, "DELETE FROM compra WHERE ID_COMPRA = $id_compra");
    }

    // Finalmente, eliminar el producto
    $query_delete_producto = mysqli_query($conexion, "DELETE FROM producto WHERE ID_PRODUCTO = $id_producto");

    if ($query_delete_producto) {
        mysqli_close($conexion);
        header("location: lista_productos.php");
        exit();
    } else {
        // Manejar error en la eliminación del producto
        $alert = '<div class="alert alert-danger" role="alert">Error al eliminar el producto: ' . mysqli_error($conexion) . '</div>';
    }

    mysqli_close($conexion);
}
?>
