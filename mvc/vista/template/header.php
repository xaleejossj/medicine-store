<?php
include(__DIR__ . "/../../modelo/con_db.php");

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Verificar el rol del usuario
$user_role = $_SESSION['user_role'];

switch ($user_role) {
    case '1': // Administrador
        header("Location: ../vista/dashboard/");
        exit();
    case '2': // Empleado
        header("Location: ../vista/dashboard/");
        exit();
    case '3': // Cliente
        // Si el rol es 3 (Cliente), no se redirige, puede acceder a esta vista
        break;
    default:
        // Si el rol no es válido
        echo "Rol no reconocido";
        exit();
}
?>

<html lang="es">
<header> 
    <div class="container-hero">
        <img src="img/logo.png">
        <h1 class="logo"><a href="/">Medicine Store</a></h1>
    </div>  
    <nav class="main-nav">
        <ul>
            <li id="home"><a href="inicio_c.php"><i class='bx bxs-home'></i></a></li>           
            <li class="dropdown">   
                    <a href="#Categorias">Categorias</a>
                    <ul class="dropdown-content">
                        <li><a href="categoria.php?id_categoria=1">Medicamentos</a></li>
                        <li><a href="categoria.php?id_categoria=2">Dermocosmetica</a></li>
                        <li><a href="categoria.php?id_categoria=3">Cuidado Personal</a></li>
                        <li><a href="categoria.php?id_categoria=4">Salud Sexual</a></li>
                        <li><a href="categoria.php?id_categoria=5">Bebe y maternidad</a></li>
                        <li><a href="categoria.php?id_categoria=6">Bienestar y nutrición</a></li>
                        <li><a href="categoria.php?id_categoria=7">Alimentos y bebidas</a></li>
                    </ul>
                </li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="nosotros.php">Quienes somos</a></li>
            <li><a href="#Contactanos">Contactanos</a></li>        
            <li id="carrito"><a href="ver_carrito.php"><i class='bx bxs-cart'></i> Carrito</a></li>    
            <li><a href="perfil.php">Perfil</a></li>         
            <li id="home"><a href="../vista/dashboard/sistema/includes/logout.php"><i class='bx bx-exit'></i></a></li>
        </ul>
    </nav>
</header> 
</html>
