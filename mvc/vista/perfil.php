<?php
include("../modelo/con_db.php");
include("template/header.php");

// Activar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Verificar la conexión a la base de datos
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos del usuario
$query = "SELECT * FROM usuario WHERE ID_USUARIO = '$user_id'";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener los datos del usuario
} else {
    die("Error al obtener los datos del usuario.");
}

// Verificar si se enviaron los datos del formulario para modificar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

    // Actualizar los datos del usuario
    $update_query = "UPDATE usuario SET TIPO_DOC = '$tipo_doc', DOCUMENTO = '$documento', NOMBRE = '$nombre', TELEFONO = '$telefono', DIRECCION = '$direccion', EMAIL = '$email' WHERE ID_USUARIO = '$user_id'";
    $stmt = $conn->prepare($update_query);

    if (!$stmt) {
        die("Error en la preparación de la consulta de actualización: " . $conn->error);
    }


    if ($stmt->execute()) {
        echo '<script>alert("Datos actualizados correctamente.");</script>';
    } else {
        die("Error al actualizar los datos: " . $stmt->error);
    }
}

// consulta para obtener las ventas del usuario
$sales_query = "SELECT v.cantidad, v.fecha, v.medio_pago, v.valor_u, v.total, v.estado, p.id_pedido, pr.nombre_producto  
                FROM venta v
                LEFT JOIN pedido p ON v.id_venta = p.id_venta
                LEFT JOIN producto pr ON p.id_producto = pr.id_producto
                WHERE v.ID_USUARIO = ?";
$sales_stmt = $conn->prepare($sales_query);
$sales_stmt->bind_param("i", $user_id);

if(!$sales_stmt){
    die("Error en la preparación de la consulta de ventas: ". $conn->error);
}

$sales_stmt->execute();
$sales_result = $sales_stmt->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Perfil</title>
    <link rel="stylesheet" href="css/users.css">
    <link rel="stylesheet" href="css/inicio.css"> 


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css">

    <style>
        /* Ocultar todas las secciones inicialmente */
        section {
            display: none;
        }
    </style>
</head>
<body>


    <div id="layoutSidenav">
        <!-- Nav lateral -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                <br><br>
                    <div class="nav"> 
                        <!-- Los enlaces ahora apuntan a funciones de JavaScript -->
                        <a class="nav-link" href="#" onclick="mostrarSeccion('seccionUsuario')">
                            Ver perfil                       
                        </a>
                        <a class="nav-link" href="#" onclick="mostrarSeccion('seccionHistorial')">
                            Historial de pedidos
                        </a>
                        <a href="recover_pass2.php">
                            Restablecer contraseña
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div id="layoutSidenav_content">
            <main>
                <!-- Sección Usuario -->
                <section id="seccionUsuario">
                    <h1>Bienvenid@ <?php echo "<pre>";
                    print_r($_SESSION['user_name']); // Esto imprimirá el array de forma legible.
                    echo "</pre>";
                    ?></h1>
                    <div class="card">
                    <h2>Modificar Datos del Usuario</h2>

                    <form action="perfil.php" method="POST">
                        <label for="tipo_doc">Tipo de documento:</label>
                        <select id="tipo_doc" name="tipo_doc" required>
                            <option value="CC" <?php if ($row['TIPO_DOC'] == 'CC') echo 'selected'; ?>>Cédula </option>
                            <option value="LIC" <?php if ($row['TIPO_DOC'] == 'LIC') echo 'selected'; ?>>Licencia </option>
                            <option value="CE" <?php if ($row['TIPO_DOC'] == 'CE') echo 'selected'; ?>>Cédula de Extranjería</option>
                            <option value="PAS" <?php if ($row['TIPO_DOC'] == 'PAS') echo 'selected'; ?>>Pasaporte</option>
                        </select><br><br>
                        <label for="documento">N° documento:</label>
                        <input type="text" id="documento" name="documento" value="<?php echo htmlspecialchars($row['DOCUMENTO']); ?>" required><br><br>
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['NOMBRE']); ?>" required><br><br>

                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['TELEFONO']); ?>" required><br><br>

                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($row['DIRECCION']); ?>" required><br><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['EMAIL']); ?>" required><br><br>

                        <input type="submit" value="Actualizar">
                    </form>      
                    </div>
                </section>

                <!-- Sección Historial de ventas -->
                <section id="seccionHistorial" style="margin-top: 50px;">
                    <h1>Historial de pedidos</h1>
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Producto</th> 
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Método de pago</th>
                                <th>Valor unitario</th>
                                <th>Total</th>
                                <Th>Estado</Th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($sales_result->num_rows > 0) {
                                while ($sale = $sales_result->fetch_assoc()) {
                                    echo "<tr>";
                                        echo "<td>" . $sale['nombre_producto'] . "</td>";
                                        echo "<td>" . $sale['cantidad'] . "</td>";
                                        echo "<td>" . $sale['fecha'] . "</td>";
                                        echo "<td>" . $sale['medio_pago'] . "</td>";
                                        echo "<td>$ " . $sale['valor_u'] . "</td>";
                                        echo "<td>$ " . $sale['total'] . "</td>";
                                        echo "<td>" . $sale['estado'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No se encontraron ventas.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </section>

                
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>
    <!-- JS de funcion de ocultar las secciones -->
    <script>
        function mostrarSeccion(idSeccion) {
            document.querySelectorAll('section').forEach(function(section) {
                section.style.display = 'none';
            });
            
            document.getElementById(idSeccion).style.display = 'block';
        }
    </script>
</body>
</html>
<?php
include("template/footer.php");
?>