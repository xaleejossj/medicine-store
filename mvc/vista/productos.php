<?php
include('../modelo/con_db.php');

// Consulta para obtener todos los productos
$query_products = "SELECT ID_PRODUCTO, NOMBRE_PRODUCTO, PRECIO, IMAGEN FROM producto";
$stmt_products = $conn->prepare($query_products);
$stmt_products->execute();
$result = $stmt_products->get_result();
?>

<?php include('template/header.php'); ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/producto.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Inicio | Medicine Store</title>
</head>

<section id="producto1" class="section-p1">
    <h2>Productos disponibles</h2>
    <div class="pro-container">
    <?php while ($row = $result->fetch_assoc()) { 
        // Convertir los datos binarios de la imagen a base64
        $imagen_base64 = !empty($row['IMAGEN']) ? base64_encode($row['IMAGEN']) : null;
        $imagen_src = !empty($imagen_base64) ? 'data:image/jpeg;base64,' . $imagen_base64 : 'No disponible';
    ?>
        <div class="pro">
             <div class="imagen-producto">
            <?php if ($imagen_src !== 'No disponible'): ?>
                <img src="<?php echo $imagen_src; ?>" alt="<?php echo htmlspecialchars($producto['NOMBRE_PRODUCTO']); ?>">
            <?php else: ?>
                <p>No disponible</p>
            <?php endif; ?>
        </div>
            <div class="des">
                <a href="producto.php?id=<?php echo $row['ID_PRODUCTO']; ?>"><h5><?php echo htmlspecialchars($row['NOMBRE_PRODUCTO']); ?></h5></a>
                <div class="star">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>                                                                                            
                </div>
                <h4>$<?php echo number_format($row['PRECIO'], 2); ?></h4>
            </div>
            <button class="i" onclick="agregarC('<?php echo $row['ID_PRODUCTO']?>','<?php echo htmlspecialchars($row['NOMBRE_PRODUCTO']); ?>', <?php echo $row['PRECIO']; ?>, '<?php echo $imagen_src; ?>')">
                <div class="car">
                    <h5>Agregar al carrito <i class='bx bxs-cart-add'></i></h5>
                </div>
            </button>
        </div>
    <?php } ?>
    </div>
</section>

<?php include('template/footer.php'); ?>
<br>
<script>
    function agregarC(id, nombre, precio, imagen) {
        let cantidad = prompt("Ingrese la cantidad:", 1);
        cantidad = parseInt(cantidad);
        
        if (isNaN(cantidad) || cantidad < 1) {
            alert("Cantidad no válida.");
            return;
        }

        let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];

        // Verificar si el producto ya está en el carrito
        let productoExistente = carrito.find(producto => producto.id === id);

        if (productoExistente) {
            productoExistente.cantidad += cantidad;
        } else {
            carrito.push({ id, nombre, precio, imagen, cantidad });
        }

        sessionStorage.setItem('carrito', JSON.stringify(carrito));
        alert("Producto agregado al carrito");
    }
</script>
