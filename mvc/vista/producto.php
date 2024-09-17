<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../modelo/con_db.php');

// Verificar si se ha pasado el ID del producto en la URL
if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id']; // Convertir a entero para seguridad

    // Consulta para obtener los detalles del producto
    $query_producto = "SELECT ID_PRODUCTO, NOMBRE_PRODUCTO, DESCRIPCION, PRECIO, CANTIDAD, IMAGEN FROM producto WHERE ID_PRODUCTO = ?";
    $stmt_producto = $conn->prepare($query_producto);
    
    if (!$stmt_producto) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    
    $stmt_producto->bind_param("i", $id_producto); // Vincular el parámetro
    $stmt_producto->execute();
    $result = $stmt_producto->get_result();
    
    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        // Convertir los datos binarios de la imagen a base64
        $imagen_base64 = !empty($producto['IMAGEN']) ? base64_encode($producto['IMAGEN']) : null;
        $imagen_src = !empty($imagen_base64) ? 'data:image/jpeg;base64,' . $imagen_base64 : 'No disponible';
    } else {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "ID de producto no proporcionado.";
    exit();
}
?>

<?php include('template/header.php'); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/producto.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Detalle del Producto | Medicine Store</title>
</head>

<section id="producto-detalle" class="section-p1">
    <div class="producto-detalle-container">
        <div class="imagen-producto">
            <?php if ($imagen_src !== 'No disponible'): ?>
                <img src="<?php echo $imagen_src; ?>" alt="<?php echo htmlspecialchars($producto['NOMBRE_PRODUCTO']); ?>">
            <?php else: ?>
                <p>No disponible</p>
            <?php endif; ?>
        </div>
        <div class="detalles-producto">
            <h2><?php echo htmlspecialchars($producto['NOMBRE_PRODUCTO']); ?></h2>
            <p class="descripcion"><?php echo htmlspecialchars($producto['DESCRIPCION']); ?></p>
            <h4>Precio: $<?php echo number_format($producto['PRECIO'], 2); ?></h4>
            <p class="cantidad">Disponibles: <?php echo htmlspecialchars($producto['CANTIDAD']); ?></p>
            
            <!-- Campo para seleccionar la cantidad -->
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="<?php echo htmlspecialchars($producto['CANTIDAD']); ?>" value="1">
            
            <!-- Botón para agregar al carrito -->
            <button class="i" onclick="agregarC('<?php echo htmlspecialchars($producto['ID_PRODUCTO']); ?>', '<?php echo htmlspecialchars($producto['NOMBRE_PRODUCTO']); ?>', <?php echo $producto['PRECIO']; ?>, '<?php echo $imagen_src; ?>')">
                <div class="car">
                    <h5>Agregar al carrito <i class='bx bxs-cart-add'></i></h5>
                </div>
            </button>
        </div>
    </div>
</section>

<script>
    function agregarC(id, nombre, precio, imagen) {
        let cantidad = document.getElementById('cantidad').value;
        let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
        
        // Verificar que la cantidad sea un número válido
        cantidad = parseInt(cantidad);
        if (isNaN(cantidad) || cantidad < 1) {
            alert("Cantidad no válida.");
            return;
        }

        // Verificar la cantidad disponible en el carrito
        let productoExistente = carrito.find(producto => producto.id === id);
        
        if (productoExistente) {
            let nuevaCantidad = productoExistente.cantidad + cantidad;
            if (nuevaCantidad > productoExistente.cantidadEnStock) {
                alert("No hay suficiente stock disponible.");
                return;
            }
            productoExistente.cantidad = nuevaCantidad;
        } else {
            carrito.push({ id, nombre, precio, imagen, cantidad });
        }

        sessionStorage.setItem('carrito', JSON.stringify(carrito));
        alert("Producto agregado al carrito");
    }
</script>

<?php include('template/footer.php'); ?>
