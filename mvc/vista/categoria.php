<?php
include('../modelo/con_db.php');

// Obtener el ID de la categoría desde la URL, por defecto es 1 si no está presente
$category_id = isset($_GET['id_categoria']) ? (int)$_GET['id_categoria'] : 1;
$category_id = $category_id > 0 ? $category_id : 1; // Asegurarse de que el ID de la categoría sea positivo

// Consultar detalles del producto sin paginación
$query_products = "SELECT ID_PRODUCTO, NOMBRE_PRODUCTO, PRECIO, IMAGEN FROM producto WHERE ID_CATEGORIA = ?";
$stmt_products = $conn->prepare($query_products);
$stmt_products->bind_param("i", $category_id); // Asociar el parámetro de la categoría
$stmt_products->execute();
$result = $stmt_products->get_result(); // Obtener el conjunto de resultados
$products = $result; // Asignar el conjunto de resultados a la variable $products

$query_categoria = "SELECT CATEGORIA FROM categoria WHERE ID_CATEGORIA = ?";
$stmt_categoria = $conn->prepare($query_categoria);
$stmt_categoria->bind_param("i", $category_id); // Asociar el parámetro de la categoría
$stmt_categoria->execute();
$result_categoria = $stmt_categoria->get_result(); // Obtener el conjunto de resultados
$row_categoria = $result_categoria->fetch_assoc(); // Obtener la fila de resultados
?>

<?php include('template/header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/producto.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Productos en Categoría | Medicine Store</title>
</head>
<body>
<section id="producto1" class="section-p1">
    <h2> <?php echo $row_categoria['CATEGORIA']?></h2>
    <div class="pro-container">
        <?php while ($row = $products->fetch_assoc()) { 
            // Convertir los datos binarios de la imagen a base64
            $imagen_base64 = !empty($row['IMAGEN']) ? base64_encode($row['IMAGEN']) : null;
            $imagen_src = !empty($imagen_base64) ? 'data:image/jpeg;base64,' . $imagen_base64 : 'path/to/default-image.jpg'; // Ruta a una imagen por defecto
        ?>
            <div class="pro">
                <img src="<?php echo $imagen_src; ?>" alt="<?php echo htmlspecialchars($row['NOMBRE_PRODUCTO']); ?>">
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
                <button class="i" onclick="agregarC('<?php echo $row['ID_PRODUCTO']?>', '<?php echo htmlspecialchars($row['NOMBRE_PRODUCTO']); ?>', <?php echo $row['PRECIO']; ?>, '<?php echo $imagen_src; ?>')">
                    <div class="car">
                        <h5>Agregar al carrito <i class='bx bxs-cart-add'></i></h5>
                    </div>
                </button>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('template/footer.php'); ?>
</body>
</html>
