<?php include("template/header.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Compra | Medicine Store</title>
    <link rel="stylesheet" href="css/inicio.css">
    <script>
        // Función para calcular el subtotal dinámicamente
        function calcularSubtotal() {
            var cantidad = document.getElementById('cantidad').value;
            var precio = document.getElementById('precio').value;
            var subtotal = cantidad * precio;
            document.getElementById('subtotal').value = subtotal;
        }

        // Función para actualizar el precio unitario al cambiar el producto seleccionado
        function actualizarPrecioUnitario() {
            var select = document.getElementById('id_producto');
            var precio = select.options[select.selectedIndex].getAttribute('data-precio');
            document.getElementById('precio').value = precio;
            calcularSubtotal(); // Recalcular el subtotal al cambiar el precio unitario
        }
    </script>
</head>

<body>
    <div class="compra">
        <h2>Realizar Compra</h2>
        <form action="confirmar_compra.php" method="post" onsubmit="calcularSubtotal()">
            <label for="id_producto">Seleccione un producto:</label>
            <select id="id_producto" name="id_producto" required onchange="actualizarPrecioUnitario()">
                <?php
                // Conexión a la base de datos
                include("../modelo/con_db.php");

                // Consulta para obtener los productos disponibles
                $query = "SELECT ID_PRODUCTO, NOMBRE_PRODUCTO, PRECIO FROM producto WHERE ESTADO = 'Disponible'";
                $result = mysqli_query($conn, $query);

                // Mostrar opciones en el select
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['ID_PRODUCTO']}' data-precio='{$row['PRECIO']}'>{$row['NOMBRE_PRODUCTO']}</option>";
                    }
                } else {
                    echo "<option value=''>No hay productos disponibles</option>";
                }

                // Cerrar conexión
                mysqli_close($conn);
                ?>
            </select><br><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="15" required onchange="calcularSubtotal()"><br><br>
            
            <label for="precio">Precio Unitario:</label>
            <input type="text" id="precio" name="precio" value="8500" readonly><br><br>
            
            <label for="subtotal">Total:</label>
            <input type="text" id="subtotal" name="subtotal" value="8500" readonly><br><br>
            
            <label for="medio_pago">Medio de Pago:</label>
            <select id="medio_pago" name="medio_pago" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
            </select><br><br>
            
            <button type="submit">Confirmar Compra</button>
        </form>
    </div>
</body>

</html>

<?php include("template/footer.php"); ?>
