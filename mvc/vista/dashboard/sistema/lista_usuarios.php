<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
		<a href="registro_usuario.php" class="btn btn-primary">Nuevo</a>
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
							<th>TIPO DOC</th>
							<th>DOCUMENTO</th>
							<th>NOMBRE</th>
							<th>TELEFONO</th>
							<th>DIRECCION</th>
							<th>EMAIL</th>
							<!--<th>CONTRASEÑA</th>-->
							<th>ROL</th>
							<th>MODIFICACIONES</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion, "SELECT u.id_usuario, u.tipo_doc, u.documento, u.nombre, u.telefono, u.direccion, u.email, u.contraseña, r.id_rol FROM usuario u INNER JOIN rol r ON u.id_rol = r.id_rol WHERE u.id_rol IN (1, 2)");
						$result = mysqli_num_rows($query);

						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) {
						?>
								<tr>
									<td><?php echo $data['id_usuario']; ?></td>
									<td><?php echo $data['tipo_doc']; ?></td>
									<td><?php echo $data['documento']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<td><?php echo $data['telefono']; ?></td>
									<td><?php echo $data['direccion']; ?></td>
									<td><?php echo $data['email']; ?></td>
									<!--<td><?php echo $data['contraseña']; ?></td>-->
									<td><?php echo $data['id_rol']; ?></td>
									<td>
										<a href="editar_usuario.php?id=<?php echo $data['id_usuario']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_usuario.php?id=<?php echo $data['id_usuario']; ?>" method="post" class="confirmar d-inline">
											<button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
										</form>
									</td>
								</tr>
						<?php
							}
						} ?>
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
