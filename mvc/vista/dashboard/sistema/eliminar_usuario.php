<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM usuario WHERE ID_USUARIO = $id");
    
    if ($query_delete) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar usuario: " . mysqli_error($conexion);
    }
    
    mysqli_close($conexion);
    header("location: lista_usuarios.php");
}

?>