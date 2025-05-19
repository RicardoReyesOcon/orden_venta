-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2025 a las 08:23:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ordenes_venta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `CLIENTE_ID` int(11) NOT NULL,
  `NOMBRE_CLIENTE` varchar(20) NOT NULL,
  `APELLIDO_CLIENTE` varchar(20) DEFAULT NULL,
  `CORREO` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`CLIENTE_ID`, `NOMBRE_CLIENTE`, `APELLIDO_CLIENTE`, `CORREO`) VALUES
(1, 'Estevan', 'Rivera Santiago', 'estevan@gmail.com'),
(2, 'Karen', 'Marin Martinez', 'karen@gmail.com'),
(3, 'Armando', 'Ramirez Ochoa', 'armando@gmail.com'),
(4, 'Diana', 'Lopez Perez', 'diana@gamil.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `PEDIDO_ID` int(11) NOT NULL,
  `FECHA` date DEFAULT NULL,
  `NOMBRE_CLIENTE` varchar(15) DEFAULT NULL,
  `TOTAL` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`PEDIDO_ID`, `FECHA`, `NOMBRE_CLIENTE`, `TOTAL`) VALUES
(50, '2025-05-18', 'Estevan', 220),
(52, '2025-05-19', 'Diana', 40),
(54, '2025-05-19', 'Armando', 175),
(56, '2025-05-19', 'Armando', 275),
(58, '2025-05-19', 'Diana', 45),
(59, '2025-05-19', 'Armando', 55),
(60, '2025-05-19', 'Armando', 30),
(62, '2025-05-19', 'Armando', 75),
(63, '2025-05-19', 'Armando', 75),
(65, '2025-05-18', 'Estevan', 15),
(66, '2025-05-18', 'Estevan', 25),
(70, '2025-05-18', 'Karen', 170),
(71, '2025-05-18', 'Karen', 235),
(72, '2025-05-20', 'Karen', 255);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `DETALLE_ID` int(11) NOT NULL,
  `PEDIDO_ID` int(11) DEFAULT NULL,
  `PRODUCTO_ID` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `SUBTOTAL` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`DETALLE_ID`, `PEDIDO_ID`, `PRODUCTO_ID`, `CANTIDAD`, `SUBTOTAL`) VALUES
(28, 50, 2, 3, 75.00),
(29, 50, 3, 1, 40.00),
(30, 50, 1, 3, 45.00),
(31, 50, 4, 1, 60.00),
(33, 52, 3, 1, 40.00),
(35, 54, 1, 3, 45.00),
(36, 54, 2, 2, 50.00),
(37, 54, 3, 2, 80.00),
(39, 56, 2, 3, 75.00),
(40, 56, 3, 5, 200.00),
(43, 58, 1, 3, 45.00),
(44, 59, 1, 2, 30.00),
(45, 59, 2, 1, 25.00),
(46, 60, 1, 2, 30.00),
(48, 62, 2, 3, 75.00),
(49, 63, 2, 3, 75.00),
(51, 65, 1, 1, 15.00),
(52, 66, 2, 1, 25.00),
(57, 70, 3, 3, 120.00),
(58, 70, 2, 2, 50.00),
(59, 71, 2, 3, 75.00),
(60, 71, 3, 1, 40.00),
(61, 71, 4, 2, 120.00),
(62, 72, 1, 3, 45.00),
(63, 72, 2, 2, 50.00),
(64, 72, 3, 1, 40.00),
(65, 72, 4, 2, 120.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `PRODUCTO_ID` int(11) NOT NULL,
  `NOMBRE_PRODUCTO` varchar(25) DEFAULT NULL,
  `DESCRIPCION_PRODUCTO` varchar(100) DEFAULT NULL,
  `PRECIO_PRODUCTO` decimal(2,0) DEFAULT NULL,
  `STOCK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`PRODUCTO_ID`, `NOMBRE_PRODUCTO`, `DESCRIPCION_PRODUCTO`, `PRECIO_PRODUCTO`, `STOCK`) VALUES
(1, 'Sombrero', 'Sombrero caballero color cafe', 15, NULL),
(2, 'Camisa', 'Camisa para dama color rosa', 25, NULL),
(3, 'Pantalón', 'Pantalon para niño color negro', 40, NULL),
(4, 'Zapatos', 'Zapato suela antiderrapante color negro', 60, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CLIENTE_ID`),
  ADD KEY `NOMBRE_CLIENTE` (`NOMBRE_CLIENTE`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`PEDIDO_ID`),
  ADD KEY `NOMBRE_CLIENTE` (`NOMBRE_CLIENTE`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`DETALLE_ID`),
  ADD KEY `PEDIDO_ID` (`PEDIDO_ID`),
  ADD KEY `PRODUCTO_ID` (`PRODUCTO_ID`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`PRODUCTO_ID`),
  ADD KEY `PRODUCTO_ID` (`PRODUCTO_ID`),
  ADD KEY `PRODUCTO_ID_2` (`PRODUCTO_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `CLIENTE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `PEDIDO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `DETALLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `PRODUCTO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`NOMBRE_CLIENTE`) REFERENCES `cliente` (`NOMBRE_CLIENTE`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `pedido_detalle_ibfk_1` FOREIGN KEY (`PEDIDO_ID`) REFERENCES `pedido` (`PEDIDO_ID`),
  ADD CONSTRAINT `pedido_detalle_ibfk_2` FOREIGN KEY (`PRODUCTO_ID`) REFERENCES `producto` (`PRODUCTO_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
