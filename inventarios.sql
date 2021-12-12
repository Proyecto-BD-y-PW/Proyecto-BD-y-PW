-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2021 a las 02:00:33
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

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
(8, 'ALMACEN PRINCIPAL', '5000.00', 'ALMACEN PRINCIPAL'),
(9, 'ALMACEN SECUNDARIO', '1200.00', 'ALMACEN SECUNDARIO');

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
(1, 'x64', 1),
(2, 'x86', 1);

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
('Procesador', 'amd', '10000.00'),
('Procesador', 'intel', '15000.00'),
('RAM', 'Kingston', '1200.00'),
('Tarjeta madre', 'Kingston', '5000.00');

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
('RIM50', 'Cristobal', '4961337305', 'krii.rifa11@gmail.com');

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
(1, '2021-12-07 23:31:00', 2, '2400.00', 1, 'ABC12'),
(2, '2021-12-01 11:31:00', 1, '5000.00', 1, 'ABC12'),
(3, '2021-11-01 16:32:00', 0, '0.00', 1, 'ABC12');

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
(1, 'Luis ', 1, '4495213584', 'luis_uaa@outlook.com');

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
('basico', 1, 1),
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
('00001', 0, '', 'MEMORIA RAM DDR4 KINGSTON 8 GB', 1, 8, 'RAM', 'Kingston'),
('00002', 1, '', 'MEMORIA RAM 6 GB DDR4', 1, 9, 'RAM', 'Kingston'),
('00003', 1, '', 'Tarjeta madre Kingston 3 puertos', 2, 8, 'Tarjeta madre', 'Kingston');

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

--
-- Volcado de datos para la tabla `pieza_modelo`
--

INSERT INTO `pieza_modelo` (`nombre_pieza`, `modelo_pieza`, `nombre_modelo`) VALUES
('Procesador', 'amd', 'basico'),
('Procesador', 'amd', 'super'),
('RAM', 'Kingston', 'super'),
('Tarjeta madre', 'Kingston', 'basico'),
('Tarjeta madre', 'Kingston', 'super');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_venta`
--

CREATE TABLE `pieza_venta` (
  `id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `precio_publico` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
('ABC12', 'Electro', 'Juan Macias', 'empresa dedicada a productos electricos', '4491234753', 'electro@outlook.com', 1),
('LKJHY', 'Beyons', 'Esmeralda Hugalde', 'proveedor frecuente', '4961337452', 'beyons12@hotmail.com', 1),
('POLKI', 'PC partes', 'Hector Buendia', 'proveedor especializado en partes de computadoras personales y laptops', '4495217861', 'PCparts@outlook.com', 1),
('YHBNJ', 'The best', 'Gerardo Maldonado', 'proveedor con experiencia en partes de computadoras', '4498751230', 'BestMexico@gmail.com', 1);

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
('carlos A', 'jucaalonsobravo@hotmail.com', '$2y$10$mdZiPtkXy0/qJ6usoI68veT6BVxEHdBoWJFQSACmDrKjf.l3sJPvS', 'usuario-cons'),
('cristobal', 'kris_todosinfin@outlook.com', '$2y$10$.t9m02A9bRenrQFiJyG6yOr3SuFBURXJGlBRTKsyYwiP42acMzpU2', 'administrador'),
('Cristobal1', 'correo@gmail.com', '$2y$10$OWBrySCQgbck3lXypjzmhuglkSLEkGpFmi3Gzyu2q7eNBeLiJSm/G', 'administrador'),
('ISC', 'isc@outlook.com', '$2y$10$upbGx5WHTo.BrT8Mg4vHJ.dykH/AObLj2i7Z6nRSkrKXxWkl.dik.', 'administrador'),
('ISC5B', 'isc@outlook.com', '$2y$10$d5QeTBEKLIjab6MqcTRGQe67pqbERMKA04we4PPlEGgw0PkfvQWUW', 'administrador'),
('Luis', 'Luis@outlook.com', '$2y$10$tZ7zIceVlIDk19K0VD2myeqgk6QyOZk/BX9yJ9zjOpyUTmSeGd54.', 'administrador'),
('LuisNa', 'pruebas@gmail.com', '$2y$10$n7VJ40fjW9.tlN9XWWqCTeo95Xp.P/H1TSSyhCPqvkl2B54KJYWsi', 'administrador'),
('LuisNa1', 'purebas@luis.com', '$2y$10$4JYJaupYV8dFiTOjwegYhO6FDJZeUOq59YcLQKpf8OSgDmhO2Q1Ny', 'administrador'),
('nuevo', 'nuevo@outlook.com', '$2y$10$LGzSwaC.SbH/z2w4E3NcEeE8Vz9aeHde3f6olFTg.riH6VpUMGqG6', 'administrador'),
('Samuel', 'samuel@gmail.com', '$2y$10$vz1Oo7SoXneXD6Bjyyg6zuXXhefYXWyB8eRf9YYVlHK0HA.y6FRIC', 'administrador');

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
(1, '2021-12-08 16:16:00', 2, '50000.00', 0, 1, 'RIM50');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `arquitectura`
--
ALTER TABLE `arquitectura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
