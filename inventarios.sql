-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2021 a las 03:07:47
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `capital` decimal(10,2) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `descripcion`, `capital`, `nombre`) VALUES
(1, 'fabrica', '5000000.00', 'fdiaz'),
(2, 'fabrica', '6000000.00', 'tecparts');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arquitectura`
--

CREATE TABLE `arquitectura` (
  `id` int(11) NOT NULL,
  `tipo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `arquitectura`
--

INSERT INTO `arquitectura` (`id`, `tipo`, `estatus`) VALUES
(1, 'sparc', 1),
(2, 'x86', 1),
(3, 'x64', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_pieza`
--

CREATE TABLE `catalogo_pieza` (
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_pieza`
--

INSERT INTO `catalogo_pieza` (`nombre`, `modelo`, `precio`) VALUES
('procesador', 'amd', '1200.00'),
('procesador', 'intel', '1200.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `RFC` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`RFC`, `nombre`, `telefono`, `email`) VALUES
('RAM52', 'Heriberto', '4491245214', 'Heri@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `RFC` char(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha`, `cantidad`, `precio`, `estatus`, `RFC`) VALUES
(3, '2021-09-09 17:52:16', 1, '500.00', 1, 'CRMIS'),
(4, '2021-09-19 19:33:14', 1, '1000.00', 1, 'JCABI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `telefono` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `estatus`, `telefono`, `correo`) VALUES
(1, 'Hector', 1, '4963335541', 'hector11@outlook.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `id_arquitectura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`nombre`, `estatus`, `id_arquitectura`) VALUES
('hardcore', 1, 1),
('patito', 1, 3),
('standar', 1, 2),
('super', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza`
--

CREATE TABLE `pieza` (
  `id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `en_almacen` tinyint(1) NOT NULL,
  `tipo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `id_compras` int(11) NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pieza`
--

INSERT INTO `pieza` (`id`, `en_almacen`, `tipo`, `descripcion`, `id_compras`, `id_almacen`, `nombre`, `modelo`) VALUES
('proc0', 0, 'venta', 'hola', 3, 1, 'procesador', 'intel'),
('proc1', 1, 'venta', 'hola', 3, 1, 'procesador', 'amd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_armado`
--

CREATE TABLE `pieza_armado` (
  `id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_modelo`
--

CREATE TABLE `pieza_modelo` (
  `nombre_pieza` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `modelo_pieza` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_modelo` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_venta`
--

CREATE TABLE `pieza_venta` (
  `id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `precio_publico` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pieza_venta`
--

INSERT INTO `pieza_venta` (`id`, `precio_publico`) VALUES
('proc0', '1000.00'),
('proc1', '1000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `no_serie` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `en_almacen` tinyint(1) NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `nombre_modelo` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`no_serie`, `en_almacen`, `descripcion`, `fecha`, `costo`, `id_almacen`, `nombre_modelo`) VALUES
('diskt', 0, 'laptop', '2021-06-27 00:00:00', '700.00', 2, 'hardcore'),
('displ', 1, 'compu', '2021-08-27 00:00:00', '500.00', 1, 'hardcore');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `RFC` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_proveedor` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`RFC`, `empresa`, `nombre_proveedor`, `descripcion`, `telefono`, `email`, `estatus`) VALUES
('CRMIS', 'CompuTec', 'Luis Enrique', 'Empresa responsable', '2147483647', 'computec@gmail.com', 1),
('JCABI', 'Sitec', 'Juan Carlos', 'Empresa Comprometida', '2147483647', 'sitecprove@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `privilegios` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre`, `correo`, `contrasena`, `privilegios`) VALUES
('cris', 'krii.rifa11@gmail.com', '$2y$10$bPGC5gbOWjZN4lOWS56g1.NyDnCSia4aocJcMjt8Hl0cJH24UD.ly', 'administrador'),
('juca', 'krii.rifa11@gmail.com', '$2y$10$v64isCBLH3Wb2gZzgmEYoezJ5WO8yv.TJ4vKQIw/CD8lg3tf3fRqu', 'administrador'),
('luis', 'krii.rifa11@gmail.com', '$2y$10$yVtvIRSNuTEkvp3A3n.03uzGjdLfPPDOSWYslUr3cp4wACYxMS6tG', 'usuario-cons');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `RFC_cliente` char(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `cantidad`, `total`, `estatus`, `id_empleado`, `RFC_cliente`) VALUES
(1, '2021-12-12 19:24:00', 0, '0.00', 1, 1, 'RAM52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_pieza`
--

CREATE TABLE `venta_pieza` (
  `id_venta` int(11) NOT NULL,
  `id_pieza` char(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `no_serie` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`no_serie`, `id_venta`) VALUES
('diskt', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `arquitectura`
--
ALTER TABLE `arquitectura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_pieza`
--
ALTER TABLE `catalogo_pieza`
  ADD PRIMARY KEY (`nombre`,`modelo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`RFC`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_fk1` (`RFC`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`nombre`),
  ADD KEY `modelo_fk1` (`id_arquitectura`);

--
-- Indices de la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pieza_fk1` (`id_compras`),
  ADD KEY `pieza_fk2` (`id_almacen`),
  ADD KEY `pieza_fk3` (`nombre`,`modelo`);

--
-- Indices de la tabla `pieza_armado`
--
ALTER TABLE `pieza_armado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pieza_modelo`
--
ALTER TABLE `pieza_modelo`
  ADD PRIMARY KEY (`nombre_pieza`,`modelo_pieza`,`nombre_modelo`),
  ADD KEY `pieza_modelo_fk2` (`nombre_modelo`);

--
-- Indices de la tabla `pieza_venta`
--
ALTER TABLE `pieza_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`no_serie`),
  ADD KEY `producto_fk1` (`id_almacen`),
  ADD KEY `producto_fk2` (`nombre_modelo`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`RFC`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_fk1` (`id_empleado`),
  ADD KEY `venta_fk2` (`RFC_cliente`);

--
-- Indices de la tabla `venta_pieza`
--
ALTER TABLE `venta_pieza`
  ADD PRIMARY KEY (`id_venta`,`id_pieza`),
  ADD KEY `venta_pieza_fk2` (`id_pieza`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`no_serie`),
  ADD KEY `venta_producto_fk2` (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `arquitectura`
--
ALTER TABLE `arquitectura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_fk1` FOREIGN KEY (`RFC`) REFERENCES `proveedores` (`RFC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_fk1` FOREIGN KEY (`id_arquitectura`) REFERENCES `arquitectura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD CONSTRAINT `pieza_fk1` FOREIGN KEY (`id_compras`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pieza_fk2` FOREIGN KEY (`id_almacen`) REFERENCES `almacen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pieza_fk3` FOREIGN KEY (`nombre`,`modelo`) REFERENCES `catalogo_pieza` (`nombre`, `modelo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza_armado`
--
ALTER TABLE `pieza_armado`
  ADD CONSTRAINT `pieza_armado_fk` FOREIGN KEY (`id`) REFERENCES `pieza` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza_modelo`
--
ALTER TABLE `pieza_modelo`
  ADD CONSTRAINT `pieza_modelo_fk1` FOREIGN KEY (`nombre_pieza`,`modelo_pieza`) REFERENCES `catalogo_pieza` (`nombre`, `modelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pieza_modelo_fk2` FOREIGN KEY (`nombre_modelo`) REFERENCES `modelo` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza_venta`
--
ALTER TABLE `pieza_venta`
  ADD CONSTRAINT `pieza_venta_fk` FOREIGN KEY (`id`) REFERENCES `pieza` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_fk1` FOREIGN KEY (`id_almacen`) REFERENCES `almacen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_fk2` FOREIGN KEY (`nombre_modelo`) REFERENCES `modelo` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_fk1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_fk2` FOREIGN KEY (`RFC_cliente`) REFERENCES `cliente` (`RFC`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_pieza`
--
ALTER TABLE `venta_pieza`
  ADD CONSTRAINT `venta_pieza_fk1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_pieza_fk2` FOREIGN KEY (`id_pieza`) REFERENCES `pieza_venta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_fk1` FOREIGN KEY (`no_serie`) REFERENCES `producto` (`no_serie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_producto_fk2` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
