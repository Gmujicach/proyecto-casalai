-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 14:32:22
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `casalai`
--

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
  `cantidad` int(11) DEFAULT NULL,
  `id_clientes` int(11) DEFAULT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `correlativo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_despachos`
--

INSERT INTO `tbl_despachos` (`id_despachos`, `cantidad`, `id_clientes`, `fecha_despacho`, `correlativo`, `activo`) VALUES
(10, NULL, 3, '2024-11-14', '55448', NULL),
(11, NULL, 3, '2024-11-14', '123441', NULL),
(12, NULL, 3, '2024-11-21', '1547', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_despachos`
--

CREATE TABLE `tbl_detalle_despachos` (
  `id_documento_despachos` int(11) NOT NULL,
  `id_despachos` int(11) DEFAULT NULL,
  `id_lote` int(11) DEFAULT NULL,
  `id_serial` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_detalle_despachos`
--

INSERT INTO `tbl_detalle_despachos` (`id_documento_despachos`, `id_despachos`, `id_lote`, `id_serial`, `id_producto`, `cantidad`) VALUES
(1, 10, NULL, NULL, 7, 1),
(2, 10, NULL, NULL, 6, 1),
(3, 11, NULL, NULL, 8, 1),
(4, 11, NULL, NULL, 7, 1),
(5, 11, NULL, NULL, 6, 1),
(6, 12, NULL, NULL, 7, 1),
(7, 12, NULL, NULL, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_recepcion_productos`
--

CREATE TABLE `tbl_detalle_recepcion_productos` (
  `id_detalle_recepcion_productos` int(11) NOT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `descripcion_producto` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_detalle_recepcion_productos`
--

INSERT INTO `tbl_detalle_recepcion_productos` (`id_detalle_recepcion_productos`, `id_recepcion`, `id_producto`, `descripcion_producto`, `cantidad`) VALUES
(1, 9, 7, 'sadasda', 1),
(2, 9, 6, 'sadasda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_lotes`
--

CREATE TABLE `tbl_lotes` (
  `id_lote` int(11) NOT NULL,
  `id_detalle_recepcion_productos` int(11) DEFAULT NULL,
  `lote` varchar(255) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `cantidad_lote` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `despachado` tinyint(1) DEFAULT NULL
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
  `nombre_p` varchar(255) DEFAULT NULL,
  `descripcion_p` text DEFAULT NULL,
  `clausula_de_garantia` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `largo` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `servicio` tinyint(1) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `lleva_lote` tinyint(1) DEFAULT NULL,
  `lleva_serial` tinyint(1) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `id_modelo`, `nombre_p`, `descripcion_p`, `clausula_de_garantia`, `stock`, `stock_min`, `stock_max`, `peso`, `largo`, `alto`, `ancho`, `servicio`, `codigo`, `lleva_lote`, `lleva_serial`, `categoria`, `activo`) VALUES
(6, 3, 'Impresiora', 'tumnadre', 'asdsa', 27, 10, 100, 5.00, 16.00, 25.00, 45.00, 0, 124, 0, 0, 'CARTUCHO', 0),
(7, 3, 'Phasdsa', '12', '123231', 18, 21, 12, 5.00, 16.00, 0.00, 45.00, 0, 1233, 0, 0, '0', 0),
(8, 3, 'Impresora Nieva', 'tumnadre', 'asdasdw', 0, 10, 100, 5.00, 16.00, 1.00, 22.00, 1, 12334, 0, 1, 'CARTUCHO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedores`
--

CREATE TABLE `tbl_proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `presona_contacto` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `telefono_secundario` varchar(20) DEFAULT NULL,
  `rif_representante` varchar(20) DEFAULT NULL,
  `rif_proveedor` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_proveedores`
--

INSERT INTO `tbl_proveedores` (`id_proveedor`, `nombre`, `presona_contacto`, `direccion`, `telefono`, `telefono_secundario`, `rif_representante`, `rif_proveedor`, `correo`, `observaciones`) VALUES
(4, 'Braynt de Jesus', 'Paula', 'calle 20 carrea 2', '1230418', '12419022', '1249282', '124412', 'correo2@gmail.com', 'prueba 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recepcion_productos`
--

CREATE TABLE `tbl_recepcion_productos` (
  `id_recepcion` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `correlativo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_recepcion_productos`
--

INSERT INTO `tbl_recepcion_productos` (`id_recepcion`, `id_proveedor`, `fecha_recepcion`, `correlativo`) VALUES
(9, 4, '2024-11-14', '122564');

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
  


CREATE TABLE facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    estatus VARCHAR(20) NOT NULL,
    FOREIGN KEY (cliente) REFERENCES tbl_clientes(id_clientes) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE factura_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT,
    producto_id INT,
    cantidad INT NOT NULL DEFAULT 1,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (factura_id) REFERENCES facturas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES tbl_productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

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
  ADD KEY `id_clientes` (`id_clientes`);

--
-- Indices de la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  ADD PRIMARY KEY (`id_documento_despachos`),
  ADD KEY `id_despachos` (`id_despachos`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_serial` (`id_serial`);

--
-- Indices de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD PRIMARY KEY (`id_detalle_recepcion_productos`),
  ADD KEY `id_recepcion` (`id_recepcion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_lotes`
--
ALTER TABLE `tbl_lotes`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `id_detalle_recepcion_productos` (`id_detalle_recepcion_productos`);

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
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  MODIFY `id_despachos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  MODIFY `id_documento_despachos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  MODIFY `id_detalle_recepcion_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_lotes`
--
ALTER TABLE `tbl_lotes`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_marcas`
--
ALTER TABLE `tbl_marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  ADD CONSTRAINT `tbl_despachos_ibfk_1` FOREIGN KEY (`id_clientes`) REFERENCES `tbl_clientes` (`id_clientes`);

--
-- Filtros para la tabla `tbl_detalle_despachos`
--
ALTER TABLE `tbl_detalle_despachos`
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_1` FOREIGN KEY (`id_despachos`) REFERENCES `tbl_despachos` (`id_despachos`),
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `tbl_lotes` (`id_lote`),
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  ADD CONSTRAINT `tbl_detalle_despachos_ibfk_4` FOREIGN KEY (`id_serial`) REFERENCES `tbl_seriales` (`id_serial`);

--
-- Filtros para la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD CONSTRAINT `tbl_detalle_recepcion_productos_ibfk_1` FOREIGN KEY (`id_recepcion`) REFERENCES `tbl_recepcion_productos` (`id_recepcion`),
  ADD CONSTRAINT `tbl_detalle_recepcion_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_lotes`
--
ALTER TABLE `tbl_lotes`
  ADD CONSTRAINT `tbl_lotes_ibfk_1` FOREIGN KEY (`id_detalle_recepcion_productos`) REFERENCES `tbl_detalle_recepcion_productos` (`id_detalle_recepcion_productos`);

--
-- Filtros para la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  ADD CONSTRAINT `tbl_modelos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `tbl_marcas` (`id_marca`);

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `tbl_productos_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`);

--
-- Filtros para la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  ADD CONSTRAINT `tbl_recepcion_productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
