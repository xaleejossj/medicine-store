<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
        <a href="registro_producto.php" class="btn btn-primary">Nuevo</a>
    </div>

    <!-- Page Heading 
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<input type="text" placeholder="ID" class="form-control search-input" data-column="0">
		<input type="text" placeholder="Tipo Doc" class="form-control search-input" data-column="1">
		<input type="text" placeholder="Documento" class="form-control search-input" data-column="2">
		<input type="text" placeholder="Nombre" class="form-control search-input" data-column="3">
		<input type="text" placeholder="Teléfono" class="form-control search-input" data-column="4">
		<input type="text" placeholder="Dirección" class="form-control search-input" data-column="5">
		<input type="text" placeholder="Email" class="form-control search-input" data-column="6">
		<input type="text" placeholder="Contraseña" class="form-control search-input" data-column="7">
		<input type="text" placeholder="Rol" class="form-control search-input" data-column="8">
	</div>-->

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>PRODUCTO</th>
                            <th>SERIAL</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO</th>
                            <th>FECHA_CADUCIDAD</th>
                            <th>ESTADO</th>
                            <th>ID_CATEGORIA</th>
                            <th>IMAGEN</th> <!-- Nueva columna -->
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";
                        
                        $query = mysqli_query($conexion, "SELECT p.ID_PRODUCTO, p.NOMBRE_PRODUCTO, p.SERIAL, p.CANTIDAD, p.PRECIO, p.FECHA_CADUCIDAD, p.ESTADO, p.ID_CATEGORIA, p.IMAGEN
                        FROM producto p");
                        $result = mysqli_num_rows($query);

                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                                // Convertir los datos binarios de la imagen a base64
                                $imagen_base64 = !empty($data['IMAGEN']) ? base64_encode($data['IMAGEN']) : null;
                                $imagen_src = !empty($imagen_base64) ? 'data:image/jpeg;base64,' . $imagen_base64 : 'No disponible';
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['ID_PRODUCTO']); ?></td>
                                    <td><?php echo htmlspecialchars($data['NOMBRE_PRODUCTO']); ?></td>
                                    <td><?php echo htmlspecialchars($data['SERIAL']); ?></td>
                                    <td><?php echo htmlspecialchars($data['CANTIDAD']); ?></td>
                                    <td><?php echo htmlspecialchars($data['PRECIO']); ?></td>
                                    <td><?php echo htmlspecialchars($data['FECHA_CADUCIDAD']); ?></td>
                                    <td><?php echo htmlspecialchars($data['ESTADO']); ?></td>
                                    <td><?php echo htmlspecialchars($data['ID_CATEGORIA']); ?></td>
                                    <td>
                                        <?php if ($imagen_src !== 'No disponible'): ?>
                                            <img src="<?php echo $imagen_src; ?>" alt="Imagen del Producto" style="max-width: 100px; max-height: 100px;">
                                        <?php else: ?>
                                            No disponible
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="editar_producto.php?id=<?php echo $data['ID_PRODUCTO']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                        <form action="eliminar_producto.php?id=<?php echo $data['ID_PRODUCTO']; ?>" method="post" class="confirmar d-inline">
                                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='10'>No hay productos registrados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<script>
    $(document).ready(function () {
        var table = $('#table').DataTable();

        $('.search-input').on('keyup change', function () {
            var index = $(this).data('column');
            table.columns(index).search(this.value).draw();
        });
    });
</script>

<?php include_once "includes/footer.php"; ?>
