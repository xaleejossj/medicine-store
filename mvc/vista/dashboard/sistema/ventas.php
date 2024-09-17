<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID VENTA</th>
                            <th>CANTIDAD</th>
                            <th>FECHA</th>
                            <th>MEDIO PAGO</th>
                            <th>VALOR U.</th>
                            <th>TOTAL</th>
                            <th>ESTADO</th>
                            <th>ID USUARIO</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require "../conexion.php";

                        // Verificar la conexión
                        if (!$conexion) {
                            die("Conexión fallida: " . mysqli_connect_error());
                        }

                        // Prueba de consulta simplificada
                        $query = mysqli_query($conexion, "
                            SELECT v.ID_VENTA, v.CANTIDAD, v.VALOR_U, v.FECHA, v.MEDIO_PAGO, 
                                   (v.CANTIDAD * v.VALOR_U) AS TOTAL, v.ESTADO, v.ID_USUARIO
                            FROM venta v
                            LEFT JOIN usuario u ON v.ID_USUARIO = u.ID_USUARIO
                            ORDER BY v.ID_VENTA DESC
                            LIMIT 10;
                        ");

                        if (!$query) {
                            die("Error en la consulta: " . mysqli_error($conexion));
                        }

                        // Mostrar datos para depuración
                        while ($dato = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dato['ID_VENTA']); ?></td>
                                <td><?php echo htmlspecialchars($dato['CANTIDAD']); ?></td>
                                <td><?php echo htmlspecialchars($dato['FECHA']); ?></td>
                                <td><?php echo htmlspecialchars($dato['MEDIO_PAGO']); ?></td>
                                <td><?php echo htmlspecialchars($dato['VALOR_U']); ?></td>
                                <td><?php echo htmlspecialchars($dato['TOTAL']); ?></td>
                                <td><?php echo htmlspecialchars($dato['ESTADO']); ?></td>
                                <td><?php echo htmlspecialchars($dato['ID_USUARIO']); ?></td>
                                
                            </tr>
                        <?php
                        }

                        mysqli_close($conexion);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->

<script>
    $(document).ready(function () {
        var table = $('#table').DataTable();
    });
</script>

<?php include_once "includes/footer.php"; ?>
