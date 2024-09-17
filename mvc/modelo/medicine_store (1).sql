-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2023 a las 20:27:19
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medicine_store`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_compras_proveedor` (IN `proveedor_id` INT)   BEGIN
    SELECT
        pr.nit, 
        c.fecha,
        p.id_categoria,
        c.cantidad
    FROM compra c
    INNER JOIN producto p ON c.id_producto = p.id_producto
    INNER JOIN proveedor pr ON c.id_proveedor = pr.id_proveedor
    WHERE c.id_proveedor = proveedor_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_compras_proveedor_if` (IN `proveedor_id` INT)   BEGIN	
    IF proveedor_id IS NOT NULL THEN
    	SELECT
            pr.nit,
            c.fecha,
            p.nombre_producto,
            c.cantidad,
            p.id_categoria
        FROM compra c
        INNER JOIN producto p ON c.id_producto = p.id_producto
        INNER JOIN proveedor pr ON c.id_proveedor = pr.id_proveedor
        WHERE c.id_proveedor = proveedor_id;
            
    ELSE
        SELECT 'No se proporcionó un ID de proveedor';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_compras_proveedor_multitablas` (IN `proveedor_id` INT)   BEGIN
    SELECT
        pr.nit,
        c.fecha,
        p.nombre_producto,
        c.cantidad,
        p.id_categoria
    FROM compra c
    INNER JOIN producto p
        ON c.id_producto = p.id_producto
    INNER JOIN proveedor pr
        ON c.id_proveedor = pr.id_proveedor
    WHERE pr.id_proveedor = proveedor_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reporte_compras_proveedor_while` ()   BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE proveedor_id INT;

    WHILE i <= 6 DO
        SET proveedor_id = i;

        SELECT
            pr.nit,
            c.fecha,
            p.nombre_producto,
            c.cantidad,
            p.id_categoria
        FROM compra c
        INNER JOIN producto p ON c.id_producto = p.id_producto
        INNER JOIN proveedor pr ON c.id_proveedor = pr.id_proveedor
        WHERE c.id_proveedor = proveedor_id;

        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(10) NOT NULL,
  `CATEGORIA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `CATEGORIA`) VALUES
(1, 'Medicamentos'),
(2, 'Dermocosmética'),
(3, 'Cuidado Personal'),
(4, 'Bebé Y Maternidad'),
(5, 'Bienestar y Nutrición'),
(6, 'Salud Sexual'),
(7, 'Belleza'),
(8, 'Alimentos y Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `ID_COMPRA` int(10) NOT NULL,
  `FECHA` date DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`ID_COMPRA`, `FECHA`, `CANTIDAD`, `ID_PRODUCTO`, `ID_PROVEEDOR`) VALUES
(1, '0000-00-00', 2026, 1, 1),
(2, '0000-00-00', 2026, 2, 1),
(3, '0000-00-00', 2023, 5, 3),
(4, '0000-00-00', 2026, 2, 2),
(6, '0000-00-00', 2026, 7, 1),
(7, '0000-00-00', 2025, 4, 1),
(8, '0000-00-00', 2024, 9, 4),
(9, '0000-00-00', 2024, 1, 6),
(10, '0000-00-00', 2025, 10, 5),
(11, '0000-00-00', 2026, 2, 2),
(12, '0000-00-00', 2023, 1, 3),
(13, '0000-00-00', 2025, 7, 1),
(14, '0000-00-00', 2025, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `ID_DEVOLUCION` int(10) NOT NULL,
  `DEVOLUCION` varchar(30) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devolucion`
--

INSERT INTO `devolucion` (`ID_DEVOLUCION`, `DEVOLUCION`, `CANTIDAD`, `FECHA`, `ID_PRODUCTO`) VALUES
(1, '4', 2026, '0000-00-00', 1),
(2, '3', 2023, '0000-00-00', 3),
(3, '2', 2023, '0000-00-00', 8),
(4, '4', 2023, '0000-00-00', 4),
(5, '6', 2023, '0000-00-00', 2),
(6, '1', 2023, '0000-00-00', 1),
(7, '3', 2023, '0000-00-00', 3),
(8, '7', 2023, '0000-00-00', 5),
(9, '2', 2023, '0000-00-00', 1),
(10, '4', 2023, '0000-00-00', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `ID_INVENTARIO` int(10) NOT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`ID_INVENTARIO`, `CANTIDAD`, `ID_PRODUCTO`) VALUES
(1, 120, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `ID_MARCA` int(10) NOT NULL,
  `MARCA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`ID_MARCA`, `MARCA`) VALUES
(1, 'Aboott'),
(2, 'Genfar'),
(3, 'Pfizer'),
(4, 'Johnson\'s'),
(5, 'Vick'),
(6, 'Lubriderm'),
(7, 'Advil'),
(8, 'Winny'),
(9, 'sanofi'),
(10, 'Rexona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mar_pro`
--

CREATE TABLE `mar_pro` (
  `ID_MAR_PRO` int(10) NOT NULL,
  `ID_MARCA` int(11) DEFAULT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mar_pro`
--

INSERT INTO `mar_pro` (`ID_MAR_PRO`, `ID_MARCA`, `ID_PRODUCTO`) VALUES
(1, 1, 7),
(2, 7, 6),
(3, 5, 10),
(4, 8, 1),
(5, 9, 8),
(6, 1, 4),
(7, 3, 5),
(8, 2, 6),
(9, 6, 9),
(10, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_PEDIDO` int(10) NOT NULL,
  `CANTIDAD_PRODUCTOS` int(10) DEFAULT NULL,
  `FECHA` time DEFAULT NULL,
  `MEDIO_PAGO` varchar(30) DEFAULT NULL,
  `TOTAL_COMPRA` int(10) DEFAULT NULL,
  `ESTADO` varchar(30) DEFAULT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID_PEDIDO`, `CANTIDAD_PRODUCTOS`, `FECHA`, `MEDIO_PAGO`, `TOTAL_COMPRA`, `ESTADO`, `ID_USUARIO`) VALUES
(1, 5, '00:20:23', 'Tarjeta de crédito', 25000, 'Completado', 1),
(2, 3, '00:20:23', 'PayPal', 12100, 'En proceso', 2),
(3, 6, '00:20:23', 'Transferencia bancaria', 35000, 'Completado', 3),
(4, 2, '00:20:23', 'Efectivo', 7500, 'En proceso', 4),
(5, 4, '00:20:23', 'Tarjeta de débito', 18100, 'Completado', 8),
(6, 1, '00:20:23', 'PayPal', 45000, 'En proceso', 6),
(7, 7, '00:20:23', 'Transferencia bancaria', 42000, 'Completado', 7),
(8, 3, '00:20:23', 'Efectivo', 11000, 'En proceso', 12),
(9, 5, '00:20:23', 'Tarjeta de crédito', 27600, 'Completado', 9),
(10, 2, '00:20:23', 'PayPal', 9000, 'En proceso', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedi_pro`
--

CREATE TABLE `pedi_pro` (
  `ID_PEDI_PRO` int(10) NOT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL,
  `ID_PEDIDO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedi_pro`
--

INSERT INTO `pedi_pro` (`ID_PEDI_PRO`, `ID_PRODUCTO`, `ID_PEDIDO`) VALUES
(1, 1, 4),
(3, 5, 1),
(4, 7, 1),
(5, 5, 1),
(6, 5, 1),
(8, 5, 1),
(9, 5, 1),
(10, 5, 1),
(11, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_PRODUCTO` int(10) NOT NULL,
  `NOMBRE_PRODUCTO` varchar(30) DEFAULT NULL,
  `SERIAL` int(10) DEFAULT NULL,
  `PRECIO` int(10) DEFAULT NULL,
  `FECHA_CADUCIDAD` time DEFAULT NULL,
  `ESTADO` varchar(30) DEFAULT NULL,
  `ID_CATEGORIA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_PRODUCTO`, `NOMBRE_PRODUCTO`, `SERIAL`, `PRECIO`, `FECHA_CADUCIDAD`, `ESTADO`, `ID_CATEGORIA`) VALUES
(1, 'Pañales', 2147483647, 28000, '00:20:23', 'disponible', 4),
(2, 'Papel higiénico', 48339932, 2000, NULL, 'disponible', 3),
(4, 'Condones', 83625373, 15000, '00:20:24', 'disponible', 6),
(5, 'Crema dental', 38278393, 4500, '00:20:25', 'Agotado', 3),
(6, 'Acetaminofen', 2147483647, 1000, '00:20:24', 'disponible', 1),
(7, 'Desodorante', 26678394, 3000, '00:20:23', 'Agotado', 3),
(8, 'Cocacola', 21991893, 5000, '00:20:24', 'disponible', 8),
(9, 'Advil', 7393980, 2800, '00:20:25', 'Agotado', 1),
(10, 'Calmidon', 8737839, 2800, '00:20:26', 'disponible', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_PROVEEDOR` int(10) NOT NULL,
  `NOMBRE_PROVEEDOR` varchar(30) DEFAULT NULL,
  `NIT` int(10) DEFAULT NULL,
  `TELEFONO` int(10) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_PROVEEDOR`, `NOMBRE_PROVEEDOR`, `NIT`, `TELEFONO`, `EMAIL`) VALUES
(1, 'Sanofi-Aventis de Colombia S.A', 2147483647, 6214400, 'Servicio.Cliente@sanofi.com'),
(2, 'ABBOTT LABORATORIES DE COLOMBI', 860002134, 6285600, 'habeasdata@abbott.com'),
(3, 'Pfizer S A S', 2147483647, 6002300, 'PrivacyColombia@pfizer.com'),
(4, 'Productos Roche S A', 892628663, 327644899, 'cac.comunicaciones@roche.com'),
(5, 'Tecnoquimicas S A', 2147483647, 2147483647, 'serviciosalconsumidor@tecnoqui'),
(6, 'BAYER S A', 2147483647, 2147483647, 'customercare@bayer.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_ROLES` int(10) NOT NULL,
  `ROLES` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_ROLES`, `ROLES`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'EMPLEADO'),
(3, 'CLIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `ID_UNIDAD` int(10) NOT NULL,
  `UNIDAD` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`ID_UNIDAD`, `UNIDAD`) VALUES
(1, 'g'),
(2, 'ml'),
(3, 'kg'),
(4, 'L'),
(5, 'ml'),
(7, 'cm3'),
(8, 'paquete'),
(9, 'cajas'),
(10, 'oz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uni_pro`
--

CREATE TABLE `uni_pro` (
  `ID_UNI_PRO` int(10) NOT NULL,
  `ID_UNIDAD` int(11) DEFAULT NULL,
  `ID_PRODUCTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `uni_pro`
--

INSERT INTO `uni_pro` (`ID_UNI_PRO`, `ID_UNIDAD`, `ID_PRODUCTO`) VALUES
(1, 3, 2),
(2, 9, 8),
(3, 5, 10),
(4, 8, 6),
(5, 4, 4),
(6, 1, 9),
(7, 3, 4),
(8, 4, 7),
(9, 5, 9),
(10, 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(10) NOT NULL,
  `USUARIO` varchar(30) DEFAULT NULL,
  `NOMBRE` varchar(30) DEFAULT NULL,
  `TELEFONO` int(10) DEFAULT NULL,
  `DIRECCION` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `CONTRASEÑA` varchar(30) DEFAULT NULL,
  `ID_ROLES` int(11) DEFAULT NULL
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `USUARIO`, `NOMBRE`, `TELEFONO`, `DIRECCION`, `EMAIL`, `CONTRASEÑA`, `ID_ROLES`) VALUES
(1, NULL, 'Juan', 310292828, 'diagonal 86 a #101-40', 'juan@gmail,com', 'Juan123', 1),
(2, NULL, 'Lorena', 337262729, 'calle 100 sur ', 'lorena123@gmail.com', 'Lorena123', 3),
(3, NULL, 'Ali', 31025638, 'Calle 13 #67_20', 'ali@gmail.co', 'Ali102552', 3),
(4, NULL, 'Alejandro', 329102929, 'Cr 86 #56_24', 'alejooo26@gmail.com', 'David123', 2),
(6, NULL, 'Caro', 376278393, 'Calle 78 #56-09', 'caro867@gmail.com', 'caroloca', 3),
(7, NULL, 'Andres Chacon', 319927773, 'calle 90 # 02-34', 'andres12@gmail.com', 'Andres2788', 3),
(8, NULL, 'Laura García', 2147483647, 'Avenida Oeste', 'laura@email.com', 'mipass123', 2),
(9, NULL, 'Manuel López', 2147483647, 'Calle Este', 'manuel@email.com', 'contraseña456', 3),
(10, NULL, 'Carlos López', 2147483647, 'Calle Principal', 'carlos@email.com', 'p@ssw0rd', 3),
(12, NULL, 'María Rodríguez', 2147483647, 'Avenida 456', 'maria@email.com', 'miclave456', 2),
(13, NULL, 'David Pérez', 1234567890, 'Calle 123', 'david@email.com', 'contrasena123', 1),
(14, NULL, 'Ana Sánchez', 2147483647, 'Avenida Central', 'ana@email.com', 'clave123', 1),
(15, NULL, 'Luis González', 2147483647, 'Calle Secundaria', 'luis@email.com', 'mi123clave', 2),
(16, NULL, 'Elena Martínez', 2147483647, 'Avenida Norte', 'elena@email.com', 'password123', 3),
(17, NULL, 'Pedro Rodríguez', 2147483647, 'Calle Sur', 'pedro@email.com', 'segura456', 1),
(18, NULL, 'Juan Pérez', 1234567890, 'Calle 123', 'juan@email.com', 'contrasena123', 1),
(19, NULL, 'María Rodríguez', 2147483647, 'Avenida 456', 'maria@email.com', 'miclave456', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID_VENTA` int(10) NOT NULL,
  `VALOR_VENTA` int(10) DEFAULT NULL,
  `FECHA` time DEFAULT NULL,
  `ID_PEDIDO` int(11) DEFAULT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`ID_VENTA`, `VALOR_VENTA`, `FECHA`, `ID_PEDIDO`, `ID_USUARIO`) VALUES
(1, 12500, '00:20:23', 1, 1),
(2, 4900, '00:20:23', 2, 2),
(3, 11500, '00:20:23', 3, 3),
(4, 80000, '00:20:23', 4, 4),
(6, 32000, '00:20:23', 6, 6),
(7, 4500, '00:20:23', 7, 7),
(8, 5000, '00:20:23', 8, 8),
(9, 20000, '00:20:23', 9, 9),
(10, 15000, '00:20:23', 10, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_CATEGORIA`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_COMPRA`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  ADD KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`ID_DEVOLUCION`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`ID_INVENTARIO`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID_MARCA`);

--
-- Indices de la tabla `mar_pro`
--
ALTER TABLE `mar_pro`
  ADD PRIMARY KEY (`ID_MAR_PRO`),
  ADD KEY `ID_MARCA` (`ID_MARCA`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_PEDIDO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `pedi_pro`
--
ALTER TABLE `pedi_pro`
  ADD PRIMARY KEY (`ID_PEDI_PRO`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  ADD KEY `ID_PEDIDO` (`ID_PEDIDO`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_PRODUCTO`),
  ADD KEY `ID_CATEGORIA` (`ID_CATEGORIA`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_PROVEEDOR`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_ROLES`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`ID_UNIDAD`);

--
-- Indices de la tabla `uni_pro`
--
ALTER TABLE `uni_pro`
  ADD PRIMARY KEY (`ID_UNI_PRO`),
  ADD KEY `ID_UNIDAD` (`ID_UNIDAD`),
  ADD KEY `ID_PRODUCTO` (`ID_PRODUCTO`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD KEY `ID_ROLES` (`ID_ROLES`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID_VENTA`),
  ADD KEY `ID_PEDIDO` (`ID_PEDIDO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedor` (`ID_PROVEEDOR`);

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `mar_pro`
--
ALTER TABLE `mar_pro`
  ADD CONSTRAINT `mar_pro_ibfk_1` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`),
  ADD CONSTRAINT `mar_pro_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Filtros para la tabla `pedi_pro`
--
ALTER TABLE `pedi_pro`
  ADD CONSTRAINT `pedi_pro_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`),
  ADD CONSTRAINT `pedi_pro_ibfk_2` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `pedido` (`ID_PEDIDO`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`);

--
-- Filtros para la tabla `uni_pro`
--
ALTER TABLE `uni_pro`
  ADD CONSTRAINT `uni_pro_ibfk_1` FOREIGN KEY (`ID_UNIDAD`) REFERENCES `unidad` (`ID_UNIDAD`),
  ADD CONSTRAINT `uni_pro_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_ROLES`) REFERENCES `roles` (`ID_ROLES`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `pedido` (`ID_PEDIDO`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
