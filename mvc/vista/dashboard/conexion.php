<?php

    $host = "localhost";
    $user = "root";
    $clave = "admin";
    $bd = "medicine_store";

    $conexion = mysqli_connect($host,$user,$clave,$bd);
    if (mysqli_connect_errno()){
        echo "No se pudo conectar a la base de datos";
        exit();
    }

    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");

    mysqli_set_charset($conexion,"utf8");


    if (isset($_POST['action']) && $_POST['action'] == 'generar_venta') {
        // Aquí obtén los datos del POST
        $valorVenta = $_POST['valor_venta'];
        $fecha = $_POST['fecha'];
        $idPedido = $_POST['id_pedido'];
        $idUsuario = $_POST['id_usuario'];
    
        // Ahora, puedes ejecutar tu procedimiento almacenado
        $conexion = mysqli_connect("tu_servidor", "tu_usuario", "tu_contraseña", "tu_base_de_datos");
    
        if (!$conexion) {
            die("Error en la conexión a la base de datos: " . mysqli_connect_error());
        }
    
        $p_producto_id = 1;  // Reemplaza esto con el ID del producto que estás vendiendo
        $p_cantidad = 1;    // Reemplaza esto con la cantidad que estás vendiendo
        $p_usuario_id = 1;   // Reemplaza esto con el ID del usuario actual, tal vez obténgalo de la sesión
    
        $query = "CALL GenerarVenta($p_producto_id, $p_cantidad, $p_usuario_id)";
    
        if (mysqli_query($conexion, $query)) {
            echo "Venta generada exitosamente";
        } else {
            echo "Error al generar la venta: " . mysqli_error($conexion);
        }
    
        mysqli_close($conexion);
    }
    
?>