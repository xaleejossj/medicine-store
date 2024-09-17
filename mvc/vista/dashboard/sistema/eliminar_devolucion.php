<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id_devolucion = $_GET['id']; // ID de la devolución

    // Obtener la cantidad y el ID del producto de la devolución antes de eliminarla
    $query_devolucion = mysqli_query($conexion, "SELECT CANTIDAD, ID_COMPRA FROM devolucion WHERE ID_DEVOLUCION = $id_devolucion");
    if ($query_devolucion) {
        if (mysqli_num_rows($query_devolucion) > 0) {
            $row_devolucion = mysqli_fetch_assoc($query_devolucion);
            $cantidad_devolucion = $row_devolucion['CANTIDAD'];
            $id_compra = $row_devolucion['ID_COMPRA'];

            // Obtener el ID del producto a partir de la compra
            $query_compra = mysqli_query($conexion, "SELECT ID_PRODUCTO FROM compra WHERE ID_COMPRA = $id_compra");
            if ($query_compra) {
                if (mysqli_num_rows($query_compra) > 0) {
                    $row_compra = mysqli_fetch_assoc($query_compra);
                    $id_producto = $row_compra['ID_PRODUCTO'];

                    // Eliminar la devolución de la tabla 'devolucion'
                    $query_delete_devolucion = mysqli_query($conexion, "DELETE FROM devolucion WHERE ID_DEVOLUCION = $id_devolucion");

                    if ($query_delete_devolucion) {
                        // Sumar la cantidad devuelta al producto en la tabla 'producto'
                        $query_update_producto = mysqli_query($conexion, "UPDATE producto SET CANTIDAD = CANTIDAD + $cantidad_devolucion WHERE ID_PRODUCTO = $id_producto");

                        if ($query_update_producto) {
                            mysqli_close($conexion);
                            header("location: lista_devoluciones.php");
                            exit();
                        } else {
                            // Manejar error en la actualización del producto
                            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar cantidad del producto: ' . mysqli_error($conexion) . '</div>';
                        }
                    } else {
                        // Manejar error en la eliminación de la devolución
                        $alert = '<div class="alert alert-danger" role="alert">Error al eliminar la devolución: ' . mysqli_error($conexion) . '</div>';
                    }
                } else {
                    // No se encontró la compra con el ID proporcionado
                    $alert = '<div class="alert alert-warning" role="alert">La compra no existe o ya ha sido eliminada.</div>';
                }
            } else {
                // Manejar error en la consulta de la compra
                $alert = '<div class="alert alert-danger" role="alert">Error en la consulta de la compra: ' . mysqli_error($conexion) . '</div>';
            }
        } else {
            // No se encontró la devolución con el ID proporcionado
            $alert = '<div class="alert alert-warning" role="alert">La devolución no existe o ya ha sido eliminada.</div>';
        }
    } else {
        // Manejar error en la consulta de la devolución
        $alert = '<div class="alert alert-danger" role="alert">Error en la consulta de la devolución: ' . mysqli_error($conexion) . '</div>';
    }

    mysqli_close($conexion);
}
?>

