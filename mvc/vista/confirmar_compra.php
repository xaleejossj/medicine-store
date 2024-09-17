<?php
include("../modelo/con_db.php");

// Verificar si se está enviando una solicitud POST para realizar la compra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_producto'], $_POST['cantidad'], $_POST['subtotal'], $_POST['medio_pago'])) {
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio'];
    $total = $_POST['subtotal'];
    $medio_pago = $_POST['medio_pago'];

    // Otros datos fijos
    $fecha_venta = date('Y-m-d');
    $estado = "Realizado";
    $id_usuario = 2; // Id del usuario, asumiendo que es 2 según tus indicaciones

    // Iniciar una transacción para asegurar que todas las operaciones sean atómicas
    mysqli_autocommit($conn, false);
    $error = false;

    // Insertar en tabla venta y obtener el ID_VENTA generado
    $query_venta = "INSERT INTO venta (CANTIDAD, FECHA, MEDIO_PAGO, VALOR_U, TOTAL, ESTADO, ID_USUARIO) VALUES ($cantidad, '$fecha_venta', '$medio_pago', $precio_unitario, $total, '$estado', $id_usuario)";
    if (mysqli_query($conn, $query_venta)) {
        $id_venta = mysqli_insert_id($conn); // Obtener el ID_VENTA generado
    } else {
        echo "Error al insertar en tabla venta: " . mysqli_error($conn);
        $error = true;
    }

    // Insertar en tabla pedido si se obtuvo el ID_VENTA
    if (!$error && isset($id_venta)) {
        // Insertar en tabla pedido
        $query_pedido = "INSERT INTO pedido (ID_VENTA, ID_PRODUCTO) VALUES ($id_venta, $id_producto)";
        if (!mysqli_query($conn, $query_pedido)) {
            echo "Error al insertar en tabla pedido: " . mysqli_error($conn);
            $error = true;
        }
    } else {
        echo "Error general al realizar la compra";
        $error = true;
    }

    // Actualizar la cantidad del producto en la tabla producto
    if (!$error) {
        $query_update_producto = "UPDATE producto SET CANTIDAD = CANTIDAD - $cantidad WHERE ID_PRODUCTO = $id_producto";
        if (mysqli_query($conn, $query_update_producto)) {
            echo "Cantidad actualizada en tabla producto";
        } else {
            echo "Error al actualizar la cantidad en tabla producto: " . mysqli_error($conn);
            $error = true;
        }
    }

    // Finalizar la transacción
    if (!$error) {
        mysqli_commit($conn);
        echo "Compra realizada con éxito";

        // Redireccionar al usuario a inicio_c.php después de la compra
        header("Location: inicio_c.php");
        exit();
    } else {
        mysqli_rollback($conn); // Rollback en caso de error
        echo "Error al realizar la compra";
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    // Si no se enviaron los datos esperados, redireccionar a una página de error o manejarlo según tu flujo
    echo "Error: Datos del formulario no recibidos correctamente.";
}
?>
