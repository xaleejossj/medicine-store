<?php
include('../modelo/con_db.php');

// Query to get the total number of products
$query_total_products = "SELECT COUNT(*) AS total_products FROM producto";
$stmt_total_products = $conn->prepare($query_total_products);
$stmt_total_products->execute();
$stmt_total_products->bind_result($total_products);
$stmt_total_products->store_result();
$stmt_total_products->fetch();

// Query to get product details
$query_products = "SELECT ID_PRODUCTO, NOMBRE_PRODUCTO, PRECIO FROM producto";
$stmt_products = $conn->prepare($query_products);
$stmt_products->execute();
$result = $stmt_products->get_result(); // Get the result set
$products = $result; // Assign result set to $products variable

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Inicio | Medicine Store</title>
</head>

<body>
<?php
include("template/header.php");
?>
<section class="banner">
    <img src="img/capsula1.jpg">
</section>

<section id="Categorias" class="icons">
        <section class="container container-features">
            <div class="card-feature">
            <a href="categoria.php?id_categoria=1"><i class='bx bxs-capsule' ></i> </a>
                <div class="feature-content">
                    <span>Medicamentos</span>
                </div>
            </div>
            <div class="card-feature">
            <a href="categoria.php?id_categoria=2"><i class='bx bxs-camera-plus'></i></a>
                <div class="feature-content">
                    <span>Dermocosmetica</span>
                </div>
            </div>
            <div class="card-feature">
                <a href="categoria.php?id_categoria=3"><i class='bx bxs-home-heart'></i></a>
                <div class="feature-content">
                    <span>Cuidado Personal</span>
                </div>
            </div>
            <div class="card-feature">
                <a href="categoria.php?id_categoria=4"><i class='bx bx-male-female'></i></a>
                <div class="feature-content">
                    <span>Salud Sexual</span>
                </div>
            </div>
            <div class="card-feature">
                <a href="categoria.php?id_categoria=5"><i class='bx bxs-baby-carriage'></i></a>
                <div class="feature-content">
                    <span>Bebé y Maternidad</span>

                </div>
            </div>
            <div class="card-feature">
                <a href="categoria.php?id_categoria=6"><i class='bx bxs-heart'></i></a>
                <div class="feature-content">
                    <span>Bienestar y Nutrición</span>
                </div>
            </div>
            <div class="card-feature">
                <a href="categoria.php?id_categoria=7"><i class='bx bxs-bowl-hot'></i></a>
                <div class="feature-content">
                    <span>Alimentos y Bebidas</span>

                </div>
            </div>

        </section>
    </section>

<section id="producto1" class="section-p1">
    <h2>Productos del Mes</h2>
    <div class="pro-container">
    <?php 
    $contador = 0; // Inicializar un contador
    while ($row = $products->fetch_assoc()) { 
        if ($contador == 4) {
            break; // Si el contador llega a 4, se rompe el ciclo
        }
        ?>
        <div class="pro">
            <img src="img/<?php echo $row['ID_PRODUCTO']; ?>.jpg" alt="">
            <div class="des">
            <a href="producto.php?id=<?php echo $row['ID_PRODUCTO']; ?>"><h5><?php echo $row['NOMBRE_PRODUCTO']; ?></h5></a>
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
    <?php 
        $contador++; // Incrementar el contador en cada iteración
    } 
    ?>
    </div>
</section>


<section class="barra">
        <h1> Marcas Destacadas</h1>
    </section>
    <section class="marca">
        <section class="marcas">
            <div class="laboratorio">
                <img src="img/bayer.png">
            </div>
            <div class="laboratorio">
                <img src="img/tecnoquimicas.png">
            </div>
            <div class="laboratorio">
                <img src="img/aboot.jfif">
            </div>
            <div class="laboratorio">
                <img src="img/genfar.png">
            </div>
            <div class="laboratorio">
                <img src="img/sanofi.png">
            </div>
            <div class="laboratorio">
                <img src="img/ringer.png">
            </div>
            <div class="laboratorio">
                <img src="img/pfizer.png">
            </div>
        </section>
    </section>

<section id="producto1" class="section-p1">
    <h2>Nuestros productos</h2>
    <div class="pro-container">
    <?php 
    $contador = 5; // Inicializar un contador
    while ($row = $products->fetch_assoc()) { 
        if ($contador == 9) {
            break; // Si el contador llega a 4, se rompe el ciclo
        }
        ?>
        <div class="pro">
            <img src="img/<?php echo $row['ID_PRODUCTO']; ?>.jpg" alt="">
            <div class="des">
            <a href="producto.php?id=<?php echo $row['ID_PRODUCTO']; ?>"><h5><?php echo $row['NOMBRE_PRODUCTO']; ?></h5></a>
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
    <?php 
        $contador++; // Incrementar el contador en cada iteración
    } 
    ?>
    </div>
</section>

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

</body>

</html>
<?php
include("template/footer.php");
?>
