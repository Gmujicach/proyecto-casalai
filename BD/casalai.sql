-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2025 a las 13:01:39
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
-- Base de datos: `casalai`
--
CREATE DATABASE IF NOT EXISTS `casalai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `casalai`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_cartucho_de_tinta`
--

CREATE TABLE `cat_cartucho_de_tinta` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_cartucho_de_tinta`
--

INSERT INTO `cat_cartucho_de_tinta` (`id`, `id_producto`, `numero`, `color`, `capacidad`) VALUES
(1, 34, 1004, 'Multicolor', 1000),
(2, 35, 1005, 'Multicolor', 1000),
(3, 36, 1006, 'Multicolor', 1500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_impresoras`
--

CREATE TABLE `cat_impresoras` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `peso` float DEFAULT NULL,
  `alto` float DEFAULT NULL,
  `ancho` float DEFAULT NULL,
  `largo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_impresoras`
--

INSERT INTO `cat_impresoras` (`id`, `id_producto`, `peso`, `alto`, `ancho`, `largo`) VALUES
(1, 28, 10, 10, 10, 10),
(2, 29, 20, 20, 20, 20),
(3, 30, 30, 15, 15, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_otros`
--

CREATE TABLE `cat_otros` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_otros`
--

INSERT INTO `cat_otros` (`id`, `id_producto`, `descripcion`) VALUES
(1, 40, 'De Acero Inoxidable'),
(2, 41, 'Tamaño 4A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_protector_de_voltaje`
--

CREATE TABLE `cat_protector_de_voltaje` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `voltaje_de_entrada` varchar(50) DEFAULT NULL,
  `voltaje_de_salida` varchar(50) DEFAULT NULL,
  `tomas` int(11) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_protector_de_voltaje`
--

INSERT INTO `cat_protector_de_voltaje` (`id`, `id_producto`, `voltaje_de_entrada`, `voltaje_de_salida`, `tomas`, `capacidad`) VALUES
(1, 37, '1200W', '800W', 3, 3),
(2, 38, '1500W', '1000W', 1, 5),
(3, 39, '3200W', '1800W', 6, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tintas`
--

CREATE TABLE `cat_tintas` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `volumen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_tintas`
--

INSERT INTO `cat_tintas` (`id`, `id_producto`, `numero`, `color`, `tipo`, `volumen`) VALUES
(1, 31, 1001, 'Multicolor', 'Liquidas', 100),
(2, 32, 1002, 'Multicolor', 'Liquidas', 450),
(3, 33, 1003, 'Multicolor', 'Inyeccion', 750);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrito`
--

CREATE TABLE `tbl_carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id_categoria` int(2) NOT NULL,
  `nombre_categoria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`id_categoria`, `nombre_categoria`) VALUES
(11, 'Impresoras'),
(12, 'Tintas'),
(13, 'Cartucho de Tinta'),
(14, 'Protector de Voltaje'),
(15, 'Otros');

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
--

CREATE TABLE `tbl_despacho_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_despacho` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ingresos_egresos`
--

CREATE TABLE `tbl_ingresos_egresos` (
  `id_finanzas` int(11) NOT NULL,
  `id_despacho` int(11) DEFAULT NULL,
  `id_detalle_recepcion_productos` int(11) DEFAULT NULL,
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
(1, 'L32508', NULL),
(2, 'L32106', NULL),
(3, 'L8055', NULL),
(4, 'L18001', NULL),
(5, 'L13001', NULL),
(6, 'F170911', 2),
(7, 'F5709', 2),
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
(78, '520 Joulesj', 3),
(79, 'Ejemplo', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_orden_despachos`
--

CREATE TABLE `tbl_orden_despachos` (
  `id_orden_despachos` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `fecha_despacho` date NOT NULL,
  `correlativo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
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
  `estado` varchar(20) DEFAULT '1',
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Ruta de la imagen del producto en formato IMGProductosproducto_X.jpeg donde X es el id_producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `serial`, `nombre_producto`, `descripcion_producto`, `id_modelo`, `id_categoria`, `stock`, `stock_minimo`, `stock_maximo`, `clausula_garantia`, `precio`, `estado`, `imagen`) VALUES
(28, '0001', 'Impresora Super', 'Impresora multifuncional con función wifi', 6, 11, 50, 10, 100, 'Garantia Valida hasta los 3 meses ', 1000.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(29, '0002', 'Impresora Maxi', 'Impresora de Punta de fibra de vidrio para oficina', 37, 11, 50, 10, 100, 'Garantía para 1 mes', 1500.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(30, '0003', 'Impresora KING', 'Impresora de Escáner Laser de Ultima Generación', 34, 11, 50, 10, 100, 'Garantía valida en los primeros 365 días', 2000.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(31, '0004', 'Colormedia', 'Tintas multicolor para Impresoras Epson', 16, 12, 20, 10, 50, 'Sin Garantía', 10.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(32, '0005', 'Tinta Arcoiris', 'Tintas de multi color duraderas para impresoras', 23, 12, 20, 5, 50, 'Sin Garantía', 8.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(33, '0006', 'ImpriColor', 'Tintas Profesionales de 4 colores', 26, 12, 30, 10, 70, 'Sin Garantía', 12.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(34, '0007', 'Caja de Color', 'Cartuchos de Tintas para Impresion', 8, 13, 10, 5, 20, 'Garantía de 1 mes de duración', 120.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(35, '0008', 'ColorBox', 'Cartuchos de Tinta Profesional tamaño XL', 49, 13, 7, 5, 20, 'Garantía de 1 mes de duración', 100.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(36, '0009', 'Colors Pandora', 'Cartuchos de Tinta Para Impresoras HP', 9, 13, 10, 5, 25, 'Garantía de 1 mes de duración', 130.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(37, '0010', 'GigaVoltio', 'Protector de Voltaje para uso domestico', 50, 14, 12, 10, 40, 'Garantía de 1 mes de duración', 60.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(38, '0011', 'ProtecVoltorb', 'Protector de Voltaje para Neveras', 76, 14, 16, 5, 20, 'Garantía de 1 mes de duración', 25.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(39, '0012', 'ThunderBolt', 'Protector de Voltaje de uso Empresarial', 52, 14, 7, 3, 15, 'Garantía de 1 mes de duración', 250.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(40, '0013', 'Clips de papel', 'Clips para actividades académicas', 31, 15, 20, 10, 100, 'Garantía de 1 mes de duración', 5.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg'),
(41, '0014', 'Rema de Papel ', 'Rema de papel de oficina con 200 hojas blancas ', 38, 15, 15, 5, 50, 'Sin Garantia', 3.00, 'habilitado', 'IMG\\productos\\lucid_realism_create_an_image_of_a_sleek_silver_and_modern_3D__0.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedores`
--

CREATE TABLE `tbl_proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(50) NOT NULL,
  `rif_proveedor` varchar(15) DEFAULT NULL,
  `nombre_representante` varchar(50) DEFAULT NULL,
  `rif_representante` varchar(15) DEFAULT NULL,
  `correo_proveedor` varchar(50) DEFAULT NULL,
  `direccion_proveedor` text DEFAULT NULL,
  `telefono_1` varchar(15) DEFAULT NULL,
  `telefono_2` varchar(15) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `estado` enum('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_proveedores`
--

INSERT INTO `tbl_proveedores` (`id_proveedor`, `nombre_proveedor`, `rif_proveedor`, `nombre_representante`, `rif_representante`, `correo_proveedor`, `direccion_proveedor`, `telefono_1`, `telefono_2`, `observacion`, `estado`) VALUES
(1, 'Aliexpres', 'V-12332125-7', 'Brayan Mendoza', 'J-98778954-7', 'ejemplo@gmail.com', 'calle 32 con carrera 18 y 19', '0412-258-8989', '0424-654-4554', 'Buena calidad de productos, envio gratis', 'habilitado');

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
-- Indices de la tabla `cat_cartucho_de_tinta`
--
ALTER TABLE `cat_cartucho_de_tinta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `cat_impresoras`
--
ALTER TABLE `cat_impresoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `cat_otros`
--
ALTER TABLE `cat_otros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `cat_protector_de_voltaje`
--
ALTER TABLE `cat_protector_de_voltaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `cat_tintas`
--
ALTER TABLE `cat_tintas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

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
  ADD KEY `id_clientes` (`id_clientes`);

--
-- Indices de la tabla `tbl_despacho_detalle`
--
ALTER TABLE `tbl_despacho_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_despacho` (`id_despacho`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indices de la tabla `tbl_orden_despachos`
--
ALTER TABLE `tbl_orden_despachos`
  ADD PRIMARY KEY (`id_orden_despachos`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria` (`id_categoria`),
  ADD KEY `fk_producto_modelo` (`id_modelo`);

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
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_cartucho_de_tinta`
--
ALTER TABLE `cat_cartucho_de_tinta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_impresoras`
--
ALTER TABLE `cat_impresoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_otros`
--
ALTER TABLE `cat_otros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_protector_de_voltaje`
--
ALTER TABLE `cat_protector_de_voltaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_tintas`
--
ALTER TABLE `cat_tintas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_carritodetalle`
--
ALTER TABLE `tbl_carritodetalle`
  MODIFY `id_carrito_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id_categoria` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id_despachos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_despacho_detalle`
--
ALTER TABLE `tbl_despacho_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_detalles_pago`
--
ALTER TABLE `tbl_detalles_pago`
  MODIFY `id_detalles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_recepcion_productos`
--
ALTER TABLE `tbl_detalle_recepcion_productos`
  MODIFY `id_detalle_recepcion_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_facturas`
--
ALTER TABLE `tbl_facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_factura_detalle`
--
ALTER TABLE `tbl_factura_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_ingresos_egresos`
--
ALTER TABLE `tbl_ingresos_egresos`
  MODIFY `id_finanzas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT de la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cat_cartucho_de_tinta`
--
ALTER TABLE `cat_cartucho_de_tinta`
  ADD CONSTRAINT `cat_cartucho_de_tinta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cat_impresoras`
--
ALTER TABLE `cat_impresoras`
  ADD CONSTRAINT `cat_impresoras_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cat_otros`
--
ALTER TABLE `cat_otros`
  ADD CONSTRAINT `cat_otros_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cat_protector_de_voltaje`
--
ALTER TABLE `cat_protector_de_voltaje`
  ADD CONSTRAINT `cat_protector_de_voltaje_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cat_tintas`
--
ALTER TABLE `cat_tintas`
  ADD CONSTRAINT `cat_tintas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_carritodetalle`
--
ALTER TABLE `tbl_carritodetalle`
  ADD CONSTRAINT `tbl_carritodetalle_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `tbl_carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_carritodetalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `tbl_despachos_ibfk_1` FOREIGN KEY (`id_clientes`) REFERENCES `tbl_clientes` (`id_clientes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_despacho_detalle`
--
ALTER TABLE `tbl_despacho_detalle`
  ADD CONSTRAINT `tbl_despacho_detalle_ibfk_1` FOREIGN KEY (`id_despacho`) REFERENCES `tbl_despachos` (`id_despachos`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_despacho_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

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
-- Filtros para la tabla `tbl_orden_despachos`
--
ALTER TABLE `tbl_orden_despachos`
  ADD CONSTRAINT `tbl_orden_despachos_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `tbl_facturas` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`),
  ADD CONSTRAINT `fk_producto_modelo` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`),
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `tbl_modelos` (`id_modelo`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`);

--
-- Filtros para la tabla `tbl_recepcion_productos`
--
ALTER TABLE `tbl_recepcion_productos`
  ADD CONSTRAINT `fk_recepcion_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`),
  ADD CONSTRAINT `tbl_recepcion_productos` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
