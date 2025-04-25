-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2025 a las 00:07:53
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
-- Base de datos: `casalai_v2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cliente` int(11) NOT NULL,
  `estatus` varchar(20) NOT NULL DEFAULT 'Borrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `fecha`, `cliente`, `estatus`) VALUES
(2, '2025-03-10', 3, 'Borrador'),
(3, '2025-03-12', 3, 'Borrador'),
(4, '2025-03-12', 3, 'Borrador'),
(5, '2025-03-12', 3, 'Borrador'),
(6, '2025-03-12', 3, 'Borrador'),
(7, '2025-03-12', 3, 'Borrador'),
(8, '2025-03-12', 3, 'Borrador'),
(9, '2025-03-12', 3, 'Borrador'),
(10, '2025-03-12', 3, 'Borrador'),
(11, '2025-03-16', 3, 'Borrador'),
(12, '2025-03-17', 3, 'Borrador'),
(21, '2025-03-19', 3, 'Borrador'),
(22, '2025-03-19', 3, 'Borrador'),
(23, '2025-03-19', 3, 'Borrador'),
(25, '2025-03-19', 3, 'Borrador'),
(26, '2025-03-19', 3, 'Borrador'),
(27, '2025-03-19', 3, 'Borrador'),
(28, '2025-03-19', 3, 'Borrador'),
(29, '2025-03-19', 3, 'Borrador'),
(36, '2025-03-19', 3, 'Borrador'),
(37, '2025-03-19', 3, 'Borrador'),
(38, '2025-03-19', 3, 'Borrador'),
(39, '2025-03-19', 3, 'Borrador'),
(40, '2025-03-19', 3, 'Borrador'),
(41, '2025-03-19', 3, 'Borrador'),
(42, '2025-03-19', 3, 'Borrador'),
(43, '2025-03-19', 3, 'Borrador'),
(44, '2025-03-19', 3, 'Borrador'),
(45, '2025-03-19', 3, 'Borrador'),
(46, '2025-03-19', 3, 'Borrador'),
(47, '2025-03-19', 3, 'Borrador'),
(48, '2025-03-20', 3, 'Borrador'),
(49, '2025-03-20', 3, 'Borrador'),
(50, '2025-03-20', 3, 'Borrador'),
(51, '2025-03-20', 3, 'Borrador'),
(52, '2025-03-20', 3, 'Borrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_detalle`
--

INSERT INTO `factura_detalle` (`id`, `factura_id`, `producto_id`, `cantidad`, `subtotal`) VALUES
(2, 2, 6, 10, 250.00),
(3, 2, 7, 5, 250.00),
(4, 3, 6, 10, 250.00),
(5, 3, 7, 5, 250.00),
(6, 4, 6, 10, 250.00),
(7, 4, 7, 5, 250.00),
(8, 5, 6, 10, 250.00),
(9, 5, 7, 5, 250.00),
(10, 6, 6, 10, 250.00),
(11, 6, 7, 5, 250.00),
(12, 7, 6, 10, 250.00),
(13, 7, 7, 5, 250.00),
(14, 8, 6, 10, 250.00),
(15, 8, 7, 5, 250.00),
(16, 9, 6, 10, 250.00),
(17, 9, 7, 5, 250.00),
(18, 10, 6, 10, 250.00),
(19, 10, 7, 5, 250.00),
(20, 11, 7, 1, 80.00),
(21, 11, 8, 1, 80.00),
(22, 12, 8, 5, 410.00),
(23, 12, 6, 4, 410.00),
(24, 12, 7, 4, 410.00),
(34, 25, 6, 7, 160.00),
(35, 25, 7, 3, 160.00),
(36, 26, 6, 7, 160.00),
(37, 26, 7, 3, 160.00),
(38, 27, 6, 7, 160.00),
(39, 27, 7, 3, 160.00),
(40, 28, 6, 7, 160.00),
(41, 28, 7, 3, 160.00),
(42, 29, 6, 7, 160.00),
(43, 29, 7, 3, 160.00),
(49, 36, 6, 5, 50.00),
(50, 37, 6, 1, 10.00),
(51, 38, 6, 19, 190.00),
(52, 46, 6, 3, 30.00),
(53, 48, 7, 1, 50.00),
(54, 48, 6, 2, 50.00),
(55, 49, 7, 2, 110.00),
(56, 49, 8, 1, 110.00),
(57, 50, 8, 9, 450.00),
(58, 51, 7, 1, 80.00),
(59, 51, 8, 1, 80.00),
(60, 52, 8, 3, 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_clientes`
--

CREATE TABLE `tbl_clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `persona_contacto` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `telefono_secundario` varchar(20) DEFAULT NULL,
  `rif` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_clientes`
--

INSERT INTO `tbl_clientes` (`id_clientes`, `nombre`, `persona_contacto`, `direccion`, `telefono`, `telefono_secundario`, `rif`, `correo`, `observaciones`, `activo`) VALUES
(3, 'Cliente Ejemplo', 'ASDASD', '521DASDAS', '2123', '4124124', '123124124', 'cor22reo@gmail.com', '2312', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_despachos`
--

CREATE TABLE `tbl_despachos` (
  `id_despachos` int(11) NOT NULL,
  `fecha_despacho` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `correlativo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_despachos`
--

CREATE TABLE `tbl_detalle_despachos` (
  `id_documento_despachos` int(11) NOT NULL,
  `id_despacho` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_recepcion_productos`
--

CREATE TABLE `tbl_detalle_recepcion_productos` (
  `id_detalle_recepcion_productos` int(11) NOT NULL,
  `id_recepcion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_marcas`
--

CREATE TABLE `tbl_marcas` (
  `id_marca` int(11) NOT NULL,
  `descripcion_ma` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_marcas`
--

INSERT INTO `tbl_marcas` (`id_marca`, `descripcion_ma`) VALUES
(4, 'HP LENOVO'),
(5, 'HP'),
(6, 'LENOVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modelos`
--

CREATE TABLE `tbl_modelos` (
  `id_modelo` int(11) NOT NULL,
  `descripcion_mo` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_modelos`
--

INSERT INTO `tbl_modelos` (`id_modelo`, `descripcion_mo`, `id_marca`) VALUES
(3, 'MODELO EJEMPLO', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `nombre_p` varchar(255) NOT NULL,
  `descripcion_p` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_proveedor` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `largo` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `servicio` tinyint(4) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `lleva_lote` tinyint(4) DEFAULT NULL,
  `lleva_serial` tinyint(4) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  `clausula_de_garantia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `id_modelo`, `nombre_p`, `descripcion_p`, `precio`, `stock`, `id_proveedor`, `stock_min`, `stock_max`, `peso`, `largo`, `alto`, `ancho`, `servicio`, `codigo`, `lleva_lote`, `lleva_serial`, `categoria`, `activo`, `clausula_de_garantia`) VALUES
(6, 3, 'Impresiora', 'tumnadre', 10.00, 10, 4, 10, 100, 5.00, 16.00, 25.00, 45.00, 0, 124, 0, 0, 'CARTUCHO', 1, 'asdsa'),
(7, 3, 'Phasdsa', '12', 30.00, 14, 4, 21, 12, 5.00, 16.00, 0.00, 45.00, 0, 1233, 0, 0, '0', 1, '123231'),
(8, 3, 'Impresora Nieva', 'tumnadre', 50.00, 7, 4, 10, 100, 5.00, 16.00, 1.00, 22.00, 1, 12334, 0, 1, 'CARTUCHO', 1, 'asdasdw');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedores`
--

CREATE TABLE `tbl_proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `presona_contacto` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `rif_representante` varchar(20) DEFAULT NULL,
  `rif_proveedor` varchar(20) DEFAULT NULL,
  `telefono_secundario` varchar(20) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_proveedores`
--

INSERT INTO `tbl_proveedores` (`id_proveedor`, `nombre`, `presona_contacto`, `telefono`, `correo`, `direccion`, `rif_representante`, `rif_proveedor`, `telefono_secundario`, `observaciones`) VALUES
(4, 'Braynt de Jesus', 'Paula', '1230418', 'correo2@gmail.com', 'calle 20 carrea 2', '1249282', '124412', '12419022', 'prueba 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recepcion_productos`
--

CREATE TABLE `tbl_recepcion_productos` (
  `id_recepcion` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rango` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuario`, `username`, `password`, `rango`) VALUES
(1, 'admin', 'admin', 'admin'),
(13, 'Braynt', '061299', 'almacen');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente` (`cliente`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  ADD PRIMARY KEY (`id_clientes`);

--
-- Indices de la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  ADD PRIMARY KEY (`id_despachos`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  ADD PRIMARY KEY (`id_documento_despachos`),
  ADD KEY `id_despacho` (`id_despacho`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD PRIMARY KEY (`id_detalle_recepcion_productos`),
  ADD KEY `id_recepcion` (`id_recepcion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_marcas`
--
ALTER TABLE `tbl_marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  ADD PRIMARY KEY (`id_modelo`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- Indices de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  ADD PRIMARY KEY (`id_recepcion`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  MODIFY `id_despachos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  MODIFY `id_documento_despachos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  MODIFY `id_detalle_recepcion_productos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_marcas`
--
ALTER TABLE `tbl_marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `tbl_clientes` (`id_clientes`) ON DELETE CASCADE;

--
-- Filtros para la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD CONSTRAINT `factura_detalle_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  ADD CONSTRAINT `tbl_despachos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_clientes` (`id_clientes`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `tbl_despachos` (`id_despachos`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD CONSTRAINT `tbl_detalle_recepcion_productos_ibfk_1` FOREIGN KEY (`id_recepcion`) REFERENCES `tbl_recepcion_productos` (`id_recepcion`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_detalle_recepcion_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  ADD CONSTRAINT `tbl_modelos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `tbl_marcas` (`id_marca`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `fk_producto_modelo` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`) ON DELETE SET NULL,
  ADD CONSTRAINT `tbl_productos_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  ADD CONSTRAINT `tbl_recepcion_productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
