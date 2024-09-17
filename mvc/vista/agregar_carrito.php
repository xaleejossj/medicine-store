<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $idProducto = $_POST['id'];

        // Agregar el ID del producto al carrito si no está ya presente
        if (!in_array($idProducto, $_SESSION['carrito'])) {
            $_SESSION['carrito'][] = $idProducto;
        }
    }
}

// Redireccionar de vuelta a la página principal o a donde sea necesario
header('Location: index.php');
exit();
?>
