<?php
include('../modelo/con_db.php'); // Conexión a la base de datos

session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Función para registrar la venta y el pedido
function registrarVenta($conn, $usuario_id, $productos, $medio_pago) {
    $conn->begin_transaction();
    try {
        // Calcular total
        $total = 0;
        foreach ($productos as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        $cantidad_total = count($productos);
        $valor_unitario = $productos[0]['precio']; // Usar el precio del primer producto como referencia

        // Insertar venta
        $query_venta = "INSERT INTO venta (CANTIDAD, FECHA, MEDIO_PAGO, VALOR_U, TOTAL, ESTADO, ID_USUARIO) 
                        VALUES (?, NOW(), ?, ?, ?, 'Realizado', ?)";
        $stmt_venta = $conn->prepare($query_venta);
        $stmt_venta->bind_param("issdi", $cantidad_total, $medio_pago, $valor_unitario, $total, $usuario_id);
        $stmt_venta->execute();
        $venta_id = $stmt_venta->insert_id;

        // Insertar detalles del pedido
        $query_pedido = "INSERT INTO pedido (ID_PRODUCTO, ID_VENTA) VALUES (?, ?)";
        $stmt_pedido = $conn->prepare($query_pedido);

        foreach ($productos as $producto) {
            $stmt_pedido->bind_param("ii", $producto['id'], $venta_id);
            $stmt_pedido->execute();
        }

        // Confirmar transacción
        $conn->commit();
        return "Compra realizada con éxito!";
    } catch (Exception $e) {
        $conn->rollback();
        return "Error al registrar la venta: " . $e->getMessage();
    }
}

// Manejo del formulario de compra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['user_id']; // Asegúrate de que 'usuario_id' esté en la sesión

    if (isset($_POST['productos']) && isset($_POST['medio_pago'])) {
        $productos = json_decode($_POST['productos'], true);
        $medio_pago = $_POST['medio_pago'];
        $message = registrarVenta($conn, $usuario_id, $productos, $medio_pago);
        echo $message;
    } else {
        echo "No se han proporcionado productos o medio de pago.";
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Ver Carrito | Medicine Store</title>
</head>
<body>
<header> 
        <div class="container-hero">
            <img src="img/logo.png">
            <h1 class="logo"><a href="/">Medicine Store</a></h1>
        </div>  
        <nav>
            <ul>
                <li id="home"><a href="inicio_c.php"><i class='bx bxs-home'></i></a>
                    <li><a href="#Categorias">Categorias</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="nosotros.php">Quienes somos</a></li>
                    <li><a href="#Contactanos">Contactanos</a></li>        
                    <li id="carrito"><a href="ver_carrito.php"><i class='bx bxs-cart'></i> Carrito</a></li>    
                    <li><a href="perfil.php">Perfil</a></li>         
                    <li id="home"><a href="../vista/dashboard/sistema/includes/logout.php"><i class='bx bx-exit'></i></a>              
            </ul>
        </nav>
        
    </header> 
    <div class="carrito">
        <h2>Carrito de Compras</h2>
        <button class="vaciar-carrito" onclick="vaciarCarrito()">Vaciar Carrito</button>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="carrito-body">
                <!-- El contenido se cargará con JavaScript -->
            </tbody>
        </table>

        <div class="formulario-compra">
            <label for="medio_pago">Método de Pago:</label>
            <select id="medio_pago">
                <option value="Tarjeta">Tarjeta</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia">Transferencia</option>
            </select>
            
            <button class="realizar-compra" onclick="realizarCompra()">Realizar Compra</button>
        </div>
    </div>

    <script>
        function cargarCarrito() {
            const carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
            const carritoBody = document.getElementById('carrito-body');
            carritoBody.innerHTML = '';

            carrito.forEach(producto => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${producto.nombre}</td>
                    <td><img src="${producto.imagen}" alt="${producto.nombre}"></td>
                    <td><input type="number" value="${producto.cantidad}" min="1" max="${producto.stock}" onchange="actualizarCantidad('${producto.id}', this.value)"></td>
                    <td>$${producto.precio.toFixed(2)}</td>
                    <td>$${(producto.precio * producto.cantidad).toFixed(2)}</td>
                    <td><button class="eliminar" onclick="eliminarProducto('${producto.id}')">Eliminar</button></td>
                `;
                carritoBody.appendChild(fila);
            });
        }

        function actualizarCantidad(id, cantidad) {
            let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
            carrito = carrito.map(producto => {
                if (producto.id === id) {
                    producto.cantidad = parseInt(cantidad);
                }
                return producto;
            });
            sessionStorage.setItem('carrito', JSON.stringify(carrito));
            cargarCarrito();
        }

        function eliminarProducto(id) {
            let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
            carrito = carrito.filter(producto => producto.id !== id);
            sessionStorage.setItem('carrito', JSON.stringify(carrito));
            cargarCarrito();
        }

        function vaciarCarrito() {
            sessionStorage.removeItem('carrito');
            cargarCarrito();
        }

        function realizarCompra() {
            const medio_pago = document.getElementById('medio_pago').value;
            const carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];

            if (carrito.length === 0) {
                alert("El carrito está vacío.");
                return;
            }

            fetch('ver_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'productos': JSON.stringify(carrito),
                    'medio_pago': medio_pago
                })
            }).then(response => response.text())
            .then(data => {
                alert(data);
                if (data.includes('éxito')) {
                    vaciarCarrito();
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        document.addEventListener('DOMContentLoaded', cargarCarrito);
    </script>
</body>
<?php include('template/footer.php'); ?>
</html>
