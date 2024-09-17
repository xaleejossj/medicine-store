<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/producto.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Inventario | Medicine Store</title> 
</head>
<body>
    <header> 
    <div class="container-hero">
            <img src="img/logo.jpg-removebg-preview.png">
            <h1 class="logo"><a href="/">Medicine Store</a></h1>
        </div>    
        <nav>
            <ul>
                <li id="home"><a href="admin.php"><i class='bx bxs-home'></i></a>
                    <!--<li><input type="text" name="txt" placeholder="Buscar" id="Buscar"></li>
                    <li><a href="#">Categorías</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="#">Quiénes somos</a></li>
                    <li><a href="#">Contáctanos</a></li>-->
            </ul>
        </nav>
    </header>
    <h2>Inventario de Productos</h2>
    <button class="addb" onclick="agregarP()">Agregar Producto<i class='bx bxs-plus-circle'></i></button>
    <section id="producto1" class="section-p1">                
        <div class="pro-container">
            <div class="pro">
                <img src="img/1.jpg" alt="">
                <div class="des">
                    <span>ABBOTT</span>
                    <h5>Pedialyte Active Manzana Abbott Frasco x 500 ml</h5>
                    <h4>$8.500</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/2.jpg" alt="">
                <div class="des">
                    <span>GENFAR</span>
                    <h5>Naproxeno Genfar 500 mg Caja x 10 Cápsulas</h5>
                    <h4>$43.200</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/3.jpg" alt="">
                <div class="des">
                    <span>BAYER</span>
                    <h5>Apronax 275 Mg Caja X 8 Tabletas Naproxeno 275 Mg</h5>
                    <h4>$15.000</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/4.jpg" alt="">
                <div class="des">
                    <span>PROCTER GAMBLE</span>
                    <h5>Vick Mentol Fracción Sobre x 5 Pastillas</h5>
                    <h4>$14.600</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/5.jpg" alt="">
                <div class="des">
                    <span>LAFRANCO</span>
                    <h5>Sevedol Extra Fuerte Caja X 8 Tabletas</h5>
                    <h4>$11.800</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/6.jpg" alt="">
                <div class="des">
                    <span>MEGALABS</span>
                    <h5>Aramax (5+50) Mg Capsulas Cajas X 30</h5>
                    <h4>$103.000</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/7.jpg" alt="">
                <div class="des">
                    <span>PFIZER</span>
                    <h5>Mareol Tabletas Caja X 12</h5>
                    <h4>$7.800</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/8.jpg" alt="">
                <div class="des">
                    <span>CLEARBLUE</span>
                    <h5>Prueba Embarazo Clearblue Plus Caja X 1</h5>
                    <h4>$20.000</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/9.jpg" alt="">
                <div class="des">
                    <span>PFIZER</span>
                    <h5>Advil Fem (65+400)Mg Caja X 10 Tabletas Recubiertas</h5>
                    <h4>$18.500</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/10.jpg" alt="">
                <div class="des">
                    <span>LABORATORIOS PISA</span>
                    <h5>Electrolit 30Meq(Na)/L Sol Oral Fco X 625 Ml Mora Azul</h5>
                    <h4>$8.600</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/11.jpg" alt="">
                <div class="des">
                    <span>GLAXOSMITHKLINE COLOMBIA SA</span>
                    <h5>Dolex Forte Nf Tabletas Recubiertas (500+65Mg)Blister X 8</h5>
                    <h4>$11.500</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/12.jpg" alt="">
                <div class="des">
                    <span>TODAY</span>
                    <h5>Preservativo Today Caja X 3</h5>
                    <h4>$12.600</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/13.jpg" alt="">
                <div class="des">
                    <span>COLGATE</span>
                    <h5>Crema Dental Colgate Tubo X 50 mL</h5>
                    <h4>$15.500</h4>
                </div>
                <button class="i"onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/14.jpg" alt="">
                <div class="des">
                    <span>ORAL-B</span>
                    <h5>Seda Satin Tape Sabor Menta Sobre X 25m</h5>
                    <h4>$12.200</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/15.jpg" alt="">
                <div class="des">
                    <span>BAYER</span>
                    <h5>Desodorante 3X Gel Power Rush Gillette Frasco X 113Gr</h5>
                    <h4>$25.000</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>
            <div class="pro">
                <img src="img/16.jpg" alt="">
                <div class="des">
                    <span>HANSAPLAST</span>
                    <h5>Reductor Cicatrices Caja X 21 Hansaplast</h5> 
                    <h4>$87.500</h4>
                </div>
                <button class="i" onclick="editarP()">
                    <div class="car">
                        <i class='bx bxs-edit'></i>
                    </div>
                </button>
                <button class="i" onclick="eliminarP()">
                    <div class="car">
                        <i class='bx bx-trash'></i></i>
                    </div>
                </button>
            </div>            
    </section>
    
    <script type="text/javascript">
        function agregarP() {
                    alert("Producto agregado al inventario correctamente");
                }
        function editarP() {
                    alert("Producto editado correctamente");
                } 
        function eliminarP() {
                    alert("Producto elminado correctamente");
                }                        
    </script>
</body>
</html>
<?php
include("template/footer.php");
?>