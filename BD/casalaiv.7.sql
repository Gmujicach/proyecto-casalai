-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 07:09:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Creación de la base de datos: `casalai`

CREATE DATABASE IF NOT EXISTS `casalai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `casalai`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrito`
--

CREATE TABLE `tbl_carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_carrito`
--

INSERT INTO `tbl_carrito` (`id_carrito`, `id_cliente`, `fecha_creacion`) VALUES
(7, 1, '2025-05-25 21:40:06'),
(8, 3, '2025-05-26 00:36:56'),
(9, 7, '2025-05-26 00:46:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carritodetalle`
--

CREATE TABLE `tbl_carritodetalle` (
  `id_carrito_detalle` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cartucho_tinta`
--

CREATE TABLE `tbl_cartucho_tinta` (
  `id_cartucho` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `capacidad` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id_categoria` int(2) NOT NULL,
  `nombre_caracteristicas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`id_categoria`, `nombre_caracteristicas`) VALUES
(1, 'Impresora'),
(2, 'Protector de Voltaje'),
(3, 'Tinta'),
(4, 'Cartucho'),
(5, 'tbl_otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_clientes`
--

CREATE TABLE `tbl_clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_clientes`
--

INSERT INTO `tbl_clientes` (`id_clientes`, `nombre`, `cedula`, `direccion`, `telefono`, `correo`, `activo`) VALUES
(1, 'Simon Freitez', '30335417', 'Los Cardones', '04241587101', 'ejemplo@gmail.com', 1),
(1000, 'Simon Freitezww', '30335416', 'Los Cardones', '04241587101', 'ejemplo@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_combo`
--

CREATE TABLE `tbl_combo` (
  `id_combo` int(11) NOT NULL,
  `nombre_combo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_combo`
--

INSERT INTO `tbl_combo` (`id_combo`, `nombre_combo`, `descripcion`, `fecha_creacion`, `activo`) VALUES
(10, '123', '213', '2025-05-25 21:34:30', 0),
(11, 'Prueba 2', 'Muy bueno', '2025-05-25 22:51:42', 0),
(12, 'Prueba 3', 'Combo Oficinista', '2025-05-26 00:47:33', 1),
(13, 'Prueba 4', 'Combo de Computadora x 6 Cartuchos de Tinta', '2025-05-26 01:13:20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_combo_detalle`
--

CREATE TABLE `tbl_combo_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_combo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_combo_detalle`
--

INSERT INTO `tbl_combo_detalle` (`id_detalle`, `id_combo`, `id_producto`, `cantidad`) VALUES
(10, 13, 13, 3),
(12, 13, 3, 1),
(13, 12, 11, 3),
(14, 12, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cuentas`
--

CREATE TABLE `tbl_cuentas` (
  `id_cuenta` int(11) NOT NULL,
  `nombre_banco` varchar(20) NOT NULL,
  `numero_cuenta` varchar(25) DEFAULT NULL,
  `rif_cuenta` varchar(15) NOT NULL,
  `telefono_cuenta` varchar(15) DEFAULT NULL,
  `correo_cuenta` varchar(50) DEFAULT NULL,
  `estado` enum('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cuentas`
--

INSERT INTO `tbl_cuentas` (`id_cuenta`, `nombre_banco`, `numero_cuenta`, `rif_cuenta`, `telefono_cuenta`, `correo_cuenta`, `estado`) VALUES
(1, 'BNC', '1247862', '143123423442', '24141243241', 'EJEMPLO@GMAIL.COM', 'habilitado'),
(8, 'Banesco', '1234567890', '0123456789', '0990812808', 'ejemplo@gmail.com', 'habilitado'),
(9, 'Bancamiga', '1234567890', '0123456789', '0990812808', 'ejemplo@gmail.com68', 'habilitado'),
(10, 'Venezuela', '87654321', '0123456789', '04141580151', 'ejemplo@gmail.com', 'habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_despachos`
--

CREATE TABLE `tbl_despachos` (
  `id_despachos` int(11) NOT NULL,
  `id_clientes` int(11) NOT NULL,
  `fecha_despacho` date NOT NULL,
  `correlativo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_despacho_detalle`

CREATE TABLE IF NOT EXISTS `tbl_despacho_detalle` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_despacho` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_despacho` (`id_despacho`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_despacho_detalle`
  ADD CONSTRAINT `tbl_despacho_detalle_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `tbl_despachos` (`id_despachos`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_despacho_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);
--
-- Estructura de tabla para la tabla `tbl_detalles_pago`
--

CREATE TABLE `tbl_detalles_pago` (
  `id_detalles` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  `observaciones` varchar(200) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `referencia` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `estatus` varchar(20) NOT NULL DEFAULT 'En Proceso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_detalles_pago`
--

INSERT INTO `tbl_detalles_pago` (`id_detalles`, `id_factura`, `id_cuenta`, `observaciones`, `tipo`, `referencia`, `fecha`, `estatus`) VALUES
(10, 1, 1, '', 'Transferencia', '23543546543', '2025-05-15', 'habilitado'),
(11, 1, 1, '', 'Pago móvil', 'eer4345', '2025-05-15', 'En Proceso'),
(12, 1, 1, '', 'Transferencia', '111112', '2025-05-16', 'En Proceso'),
(13, 1, 8, '', 'Pago móvil', '1234567', '2025-05-08', 'En Proceso'),
(14, 1, 10, '', 'Transferencia', '1234567089', '2025-05-09', 'En Proceso'),
(15, 1, 8, '', 'Transferencia', '27288727', '2025-05-15', 'En Proceso'),
(16, 1, 1, '', 'Pago móvil', '12345678uy', '2025-05-09', 'En Proceso'),
(17, 1, 1, '', 'Transferencia', '6546464', '2025-05-09', 'En Proceso'),
(18, 1, 1, '', 'Transferencia', '1234561212', '2025-05-16', 'En Proceso'),
(19, 1, 1, '', 'Transferencia', '4444', '2025-05-09', 'En Proceso'),
(20, 1, 1, '', 'Transferencia', '12345671212', '2025-05-16', 'En Proceso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_recepcion_productos`
--

CREATE TABLE `tbl_detalle_recepcion_productos` (
  `id_detalle_recepcion_productos` int(11) NOT NULL,
  `id_recepcion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_detalle_recepcion_productos`
--

INSERT INTO `tbl_detalle_recepcion_productos` (`id_detalle_recepcion_productos`, `id_recepcion`, `id_producto`, `costo`, `cantidad`) VALUES
(1, 3, 3, 10, 10),
(2, 4, 3, 9, 34),
(3, 4, 10, 6, 11),
(4, 5, 3, 8, 1),
(5, 5, 10, 10, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_facturas`
--

CREATE TABLE `tbl_facturas` (
  `id_factura` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cliente` int(11) NOT NULL,
  `descuento` int(3) DEFAULT NULL,
  `estatus` varchar(20) NOT NULL DEFAULT 'Borrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_facturas`
--

INSERT INTO `tbl_facturas` (`id_factura`, `fecha`, `cliente`, `descuento`, `estatus`) VALUES
(1, '2024-07-18', 1, 1, 'Borrador'),
(18, '2025-05-26', 1, 0, 'Borrador'),
(22, '2025-05-26', 1, 0, 'Borrador'),
(23, '2025-05-26', 1, 0, 'Borrador'),
(24, '2025-05-26', 1, 0, 'Borrador'),
(26, '2025-05-26', 1, 0, 'Borrador'),
(27, '2025-05-26', 1, 0, 'Borrador'),
(28, '2025-05-26', 1, 0, 'Borrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_factura_detalle`
--

CREATE TABLE `tbl_factura_detalle` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_factura_detalle`
--

INSERT INTO `tbl_factura_detalle` (`id`, `factura_id`, `id_producto`, `cantidad`) VALUES
(1, 1, 3, 1),
(7, 24, 3, 3),
(8, 24, 11, 3),
(9, 26, 13, 3),
(11, 26, 3, 1),
(12, 27, 13, 3),
(14, 27, 3, 1),
(15, 28, 13, 3),
(17, 28, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_impresoras`
--

CREATE TABLE `tbl_impresoras` (
  `id_impresora` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `largo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_impresoras`
--

INSERT INTO `tbl_impresoras` (`id_impresora`, `id_producto`, `peso`, `alto`, `ancho`, `largo`) VALUES
(4, 3, 20.00, 20.00, 20.00, 20.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ingresos_egresos`
--

CREATE TABLE `tbl_ingresos_egresos` (
  `id_finanzas` int(11) NOT NULL,
  `id_despacho` int(11) NOT NULL,
  `id_detalle_recepcion_productos` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso') NOT NULL,
  `monto` float(6,2) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_marcas`
--

CREATE TABLE `tbl_marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_marcas`
--

INSERT INTO `tbl_marcas` (`id_marca`, `nombre_marca`) VALUES
(1, 'Epson'),
(2, 'HP'),
(3, 'Canon'),
(4, 'Inktec'),
(5, 'TexPrint'),
(6, 'Sawgrass'),
(7, 'Cosmos Ink'),
(8, 'Azon'),
(9, 'Sublimagic'),
(10, 'Brother'),
(11, 'Forza'),
(12, 'Tripp Lite'),
(13, 'CDP'),
(14, 'Koblenz'),
(15, 'Epson'),
(16, 'HP'),
(17, 'Canon'),
(18, 'Inktec'),
(19, 'TexPrint'),
(20, 'Sawgrass'),
(21, 'Cosmos Ink'),
(22, 'Azon'),
(23, 'Sublimagic'),
(24, 'Brother'),
(25, 'Forza'),
(26, 'Tripp Lite'),
(27, 'CDP'),
(28, 'Koblenz'),
(29, 'Pokemon'),
(30, 'Digimon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modelos`
--

CREATE TABLE `tbl_modelos` (
  `id_modelo` int(11) NOT NULL,
  `nombre_modelo` varchar(25) NOT NULL,
  `id_marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_modelos`
--

INSERT INTO `tbl_modelos` (`id_modelo`, `nombre_modelo`, `id_marca`) VALUES
(1, 'L3250', 1),
(2, 'L3210', 1),
(3, 'L805', 1),
(4, 'L1800', 1),
(5, 'L1300', 1),
(6, 'F170', 1),
(7, 'F570', 1),
(8, 'Smart Tank 515', 2),
(9, 'DeskJet 2775', 2),
(10, 'LaserJet Pro M404dn', 2),
(11, 'PIXMA G3110', 3),
(12, 'PIXMA G6010', 3),
(13, 'i-SENSYS MF445dw', 3),
(14, 'Sublinova', 4),
(15, 'SubliJet', 6),
(16, 'L3250', 1),
(17, 'L3210', 1),
(18, 'L805', 1),
(19, 'L1800', 1),
(20, 'L1300', 1),
(21, 'F170', 1),
(22, 'F570', 1),
(23, 'Smart Tank 515', 2),
(24, 'DeskJet 2775', 2),
(25, 'LaserJet Pro M404dn', 2),
(26, 'PIXMA G3110', 3),
(27, 'PIXMA G6010', 3),
(28, 'i-SENSYS MF445dw', 3),
(29, 'Sublinova', 4),
(30, 'SubliJet', 6),
(31, 'Sublime', 8),
(32, 'Durabrite', 15),
(33, 'Innobella', 10),
(34, 'ChromaLife 100+', 3),
(35, 'T664 ', 1),
(36, 'T673 ', 1),
(37, 'T774', 1),
(38, '664 ', 2),
(39, '662 ', 2),
(40, '680 ', 2),
(41, '955 ', 2),
(42, '950', 2),
(43, 'PG-145 ', 3),
(44, 'CL-146 ', 3),
(45, 'GI-190', 3),
(46, 'FVR-1211', 11),
(47, 'FVR-2202', 11),
(48, 'LR2000', 12),
(49, 'AVR750U', 12),
(50, 'R2-1200 ', 13),
(51, 'UPS 600VA', 13),
(52, '1000VA', 13),
(53, 'AVR-1000', 14),
(54, '520 Joules', 14),
(55, 'Sublime', 8),
(56, 'Durabrite', 15),
(57, 'Innobella', 10),
(58, 'ChromaLife 100+', 3),
(59, 'T664 ', 1),
(60, 'T673 ', 1),
(61, 'T774', 1),
(62, '664 ', 2),
(63, '662 ', 2),
(64, '680 ', 2),
(65, '955 ', 2),
(66, '950', 2),
(67, 'PG-145 ', 3),
(68, 'CL-146 ', 3),
(69, 'GI-190', 3),
(70, 'FVR-1211', 11),
(71, 'FVR-2202', 11),
(72, 'LR2000', 12),
(73, 'AVR750U', 12),
(74, 'R2-1200 ', 13),
(75, 'UPS 600VA', 13),
(76, '1000VA', 13),
(77, 'AVR-1000', 14),
(78, '520 Joules', 14),
(79, 'Ejemplo', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_otros`
--

CREATE TABLE `tbl_otros` (
  `id_otros` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL,
  `serial` varchar(20) NOT NULL,
  `nombre_producto` varchar(20) NOT NULL,
  `descripcion_producto` varchar(255) DEFAULT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `id_categoria` int(2) DEFAULT NULL,
  `stock` int(3) DEFAULT NULL,
  `stock_minimo` int(3) DEFAULT NULL,
  `stock_maximo` int(3) DEFAULT NULL,
  `clausula_garantia` varchar(150) NOT NULL,
  `precio` float(10,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `serial`, `nombre_producto`, `descripcion_producto`, `id_modelo`, `id_categoria`, `stock`, `stock_minimo`, `stock_maximo`, `clausula_garantia`, `precio`, `estado`) VALUES
(3, '12345678', 'Impresora SuperLuxe', 'Buena Bonita y Barata', 49, 1, 100, 5, 20, 'Devolución dentro de un plazo de 31 días', 200.00, 'inhabilitado'),
(10, '1231', 'Colormedia', 'Tinta Profesional', 8, 3, 100, 1000, 10000, 'Sin devoluciones', 10.00, 'inhabilitado'),
(11, '051004', 'Computadora 200', 'Potente y Practica', 79, 5, 10, 1000, 1000, '35 Dias', 1000.00, 'inhabilitado'),
(13, 'CRT010', 'Cartucho Canon CL-14', 'Cartucho original Canon color', 68, 4, 12, 5, 20, '31 dias', 28.00, 'habilitado'),
(14, 'OTH011', 'Cable USB Impresora', 'Cable USB 2.0 para impresora 1.8m', NULL, 5, 30, 10, 50, '', 8.00, '1'),
(15, 'OTH012', 'Papel Fotográfico', 'Papel fotográfico brillante A4 180gr', NULL, 5, 20, 5, 30, '', 12.00, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_protector_voltaje`
--

CREATE TABLE `tbl_protector_voltaje` (
  `id_protector` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `voltaje_entrada` varchar(50) DEFAULT NULL,
  `voltaje_salida` varchar(50) DEFAULT NULL,
  `tomas` int(2) DEFAULT NULL,
  `capacidad` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Servicios Técnicos', 'Brayan Mendoza', '04145555556', 'ejemplo@gmail', 'calle 32 con carrera 18 y 19', '112235432', '423555423', '04241587101', 'Buen Amigo'),
(1000, 'Thunder Net', 'Diego Lopez', '0424-5329515', NULL, 'Avenida Lara', 'V-317663160', 'J-406452157', '0414-5413366', 'El Mejor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recepcion_productos`
--

CREATE TABLE `tbl_recepcion_productos` (
  `id_recepcion` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `correlativo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_recepcion_productos`
--

INSERT INTO `tbl_recepcion_productos` (`id_recepcion`, `id_proveedor`, `fecha`, `correlativo`) VALUES
(1, 1, '2025-05-23', '0000'),
(2, 1, '2025-05-23', '0001'),
(3, 1, '2025-05-23', '0002'),
(4, 1, '2025-05-24', '0004'),
(5, 1, '2025-05-24', '0005');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tintas`
--

CREATE TABLE `tbl_tintas` (
  `id_tinta` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `volumen` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rango` varchar(20) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `nombres` varchar(20) DEFAULT NULL,
  `apellidos` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estatus` enum('habilitado','inhabilitado') DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuario`, `username`, `password`, `rango`, `correo`, `nombres`, `apellidos`, `telefono`, `estatus`) VALUES
(1, 'Admin', '$2y$10$j9dHxGq5aIkAqaZdE.NJg.zpV0HTTcER970QIVMUKjNLw/9R1N1Du', 'Administrador', 'ejemplo@gmail.com', 'Administrador', 'Administrador', '04145753363', 'habilitado'),
(2, 'Despachador', '$2y$10$dgqa0ji1of1FxPQAu3DvI.Y.3MANE2DlQHF8uVTVKEbCJEqNiw/Oe', 'Almacenista', 'ejemplo@gmail.com', 'Despachador', 'Despachador', '04145753363', 'habilitado'),
(3, 'Cliente', '$2y$10$n/ZpQkW4BaeFZiDzFDYLWuRbrBXvv8sokEeM9zQ7iK5DcjMEsFPly', 'Cliente', 'ejemplo@gmail.com', 'Cliente', 'Cliente', '04145753363', 'habilitado'),
(4, 'DALV', '$2y$10$vnkAofAen/wh4.GnHKkDkO63/s8kUmUfyI44/e5Y2DlEg.43xymMS', 'usuario', 'EJEMPLO@GMAIL.COM', 'Diego', 'Lopez', '04145753363', 'habilitado'),
(5, 'Test', '$2y$10$PshH1iu9D6LxHqT//KlmB.ciWfUN5MMkmSuWDIpb52f9/MW2qulFi', 'usuario', 'testcorreo@gmail.com', 'Pueba', 'Test', '04125248965', 'habilitado'),
(6, 'Darckort', '$2y$10$dyYy8O8xoZ.9vYP.vW.EluSRrhsAhsJ2c3Kcv88yI6ilkg4WJ73qi', 'usuario', 'darckortgame@gmail.com', 'Braynt', 'Medina', '04261504714', 'habilitado'),
(7, 'DDDD', '12345', 'Administrador', 'diego0510lopez@gmail.com', 'Diego', 'Lopez', '04241587101', 'habilitado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `tbl_carritodetalle`
--
ALTER TABLE `tbl_carritodetalle`
  ADD PRIMARY KEY (`id_carrito_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_cartucho_tinta`
--
ALTER TABLE `tbl_cartucho_tinta`
  ADD PRIMARY KEY (`id_cartucho`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  ADD PRIMARY KEY (`id_clientes`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `tbl_combo`
--
ALTER TABLE `tbl_combo`
  ADD PRIMARY KEY (`id_combo`);

--
-- Indices de la tabla `tbl_combo_detalle`
--
ALTER TABLE `tbl_combo_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_combo` (`id_combo`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_cuentas`
--
ALTER TABLE `tbl_cuentas`
  ADD PRIMARY KEY (`id_cuenta`);

--
-- Indices de la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  ADD PRIMARY KEY (`id_despachos`),
  ADD KEY `fk_despacho_cliente` (`id_factura`);

--
-- Indices de la tabla `tbl_detalles_pago`
--
ALTER TABLE `tbl_detalles_pago`
  ADD PRIMARY KEY (`id_detalles`),
  ADD KEY `tbl_detalles_pago` (`id_factura`),
  ADD KEY `tbl_detalles_pago1` (`id_cuenta`);

--
-- Indices de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD PRIMARY KEY (`id_detalle_recepcion_productos`),
  ADD KEY `fk_detalle_recepcion` (`id_recepcion`),
  ADD KEY `fk_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_facturas`
--
ALTER TABLE `tbl_facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `cliente` (`cliente`);

--
-- Indices de la tabla `tbl_factura_detalle`
--
ALTER TABLE `tbl_factura_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `tbl_factura_detalle` (`id_producto`);

--
-- Indices de la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  ADD PRIMARY KEY (`id_impresora`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_ingresos_egresos`
--
ALTER TABLE `tbl_ingresos_egresos`
  ADD PRIMARY KEY (`id_finanzas`),
  ADD KEY `id_despacho` (`id_despacho`,`id_detalle_recepcion_productos`),
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
  ADD KEY `fk_modelo_marca` (`id_marca`);

--
-- Indices de la tabla `tbl_otros`
--
ALTER TABLE `tbl_otros`
  ADD PRIMARY KEY (`id_otros`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria` (`id_categoria`),
  ADD KEY `fk_producto_modelo` (`id_modelo`);

--
-- Indices de la tabla `tbl_protector_voltaje`
--
ALTER TABLE `tbl_protector_voltaje`
  ADD PRIMARY KEY (`id_protector`),
  ADD KEY `id_producto` (`id_producto`);

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
  ADD KEY `fk_recepcion_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `tbl_tintas`
--
ALTER TABLE `tbl_tintas`
  ADD PRIMARY KEY (`id_tinta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_carritodetalle`
--
ALTER TABLE `tbl_carritodetalle`
  MODIFY `id_carrito_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tbl_cartucho_tinta`
--
ALTER TABLE `tbl_cartucho_tinta`
  MODIFY `id_cartucho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id_categoria` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de la tabla `tbl_combo`
--
ALTER TABLE `tbl_combo`
  MODIFY `id_combo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_combo_detalle`
--
ALTER TABLE `tbl_combo_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_cuentas`
--
ALTER TABLE `tbl_cuentas`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  MODIFY `id_despachos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_detalles_pago`
--
ALTER TABLE `tbl_detalles_pago`
  MODIFY `id_detalles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  MODIFY `id_detalle_recepcion_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_facturas`
--
ALTER TABLE `tbl_facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tbl_factura_detalle`
--
ALTER TABLE `tbl_factura_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  MODIFY `id_impresora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_ingresos_egresos`
--
ALTER TABLE `tbl_ingresos_egresos`
  MODIFY `id_finanzas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_marcas`
--
ALTER TABLE `tbl_marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `tbl_otros`
--
ALTER TABLE `tbl_otros`
  MODIFY `id_otros` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_protector_voltaje`
--
ALTER TABLE `tbl_protector_voltaje`
  MODIFY `id_protector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_tintas`
--
ALTER TABLE `tbl_tintas`
  MODIFY `id_tinta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_carritodetalle`
--
ALTER TABLE `tbl_carritodetalle`
  ADD CONSTRAINT `tbl_carritodetalle_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `tbl_carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_carritodetalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_cartucho_tinta`
--
ALTER TABLE `tbl_cartucho_tinta`
  ADD CONSTRAINT `tbl_cartucho_tinta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_combo_detalle`
--
ALTER TABLE `tbl_combo_detalle`
  ADD CONSTRAINT `tbl_combo_detalle_ibfk_1` FOREIGN KEY (`id_combo`) REFERENCES `tbl_combo` (`id_combo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_combo_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_despachos`
--
ALTER TABLE `tbl_despachos`
  ADD CONSTRAINT `fk_despacho_factura` FOREIGN KEY (`id_factura`) REFERENCES `tbl_facturas` (`id_factura`);

--
-- Filtros para la tabla `tbl_detalles_pago`
--
ALTER TABLE `tbl_detalles_pago`
  ADD CONSTRAINT `fk_id_cuenta` FOREIGN KEY (`id_cuenta`) REFERENCES `tbl_cuentas` (`id_cuenta`),
  ADD CONSTRAINT `fk_id_factura` FOREIGN KEY (`id_factura`) REFERENCES `tbl_facturas` (`id_factura`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  ADD CONSTRAINT `fk_detalle_recepcion` FOREIGN KEY (`id_recepcion`) REFERENCES `tbl_recepcion_productos` (`id_recepcion`),
  ADD CONSTRAINT `tbl_detalles_recepcion_productos` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_facturas`
--
ALTER TABLE `tbl_facturas`
  ADD CONSTRAINT `tbl_facturas_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `tbl_clientes` (`id_clientes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_factura_detalle`
--
ALTER TABLE `tbl_factura_detalle`
  ADD CONSTRAINT `factura_detalle_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `tbl_facturas` (`id_factura`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_factura_detalle` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_impresoras`
--
ALTER TABLE `tbl_impresoras`
  ADD CONSTRAINT `impresoras_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_ingresos_egresos`
--
ALTER TABLE `tbl_ingresos_egresos`
  ADD CONSTRAINT `tbl_ingresos_egresos_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `tbl_despachos` (`id_despachos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ingresos_egresos_ibfk_2` FOREIGN KEY (`id_detalle_recepcion_productos`) REFERENCES `tbl_detalle_recepcion_productos` (`id_detalle_recepcion_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_modelos`
--
ALTER TABLE `tbl_modelos`
  ADD CONSTRAINT `fk_modelo_marca` FOREIGN KEY (`id_marca`) REFERENCES `tbl_marcas` (`id_marca`),
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `tbl_marcas` (`id_marca`);

--
-- Filtros para la tabla `tbl_otros`
--
ALTER TABLE `tbl_otros`
  ADD CONSTRAINT `otros_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`),
  ADD CONSTRAINT `fk_producto_modelo` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`),
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`);

--
-- Filtros para la tabla `tbl_protector_voltaje`
--
ALTER TABLE `tbl_protector_voltaje`
  ADD CONSTRAINT `protector_voltaje_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  ADD CONSTRAINT `fk_recepcion_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`),
  ADD CONSTRAINT `tbl_recepcion_productos` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_tintas`
--
ALTER TABLE `tbl_tintas`
  ADD CONSTRAINT `tintas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
