-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2025 a las 02:52:17
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
-- Base de datos: `seguridadlai`
--
CREATE DATABASE IF NOT EXISTS `seguridadlai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `seguridadlai`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_alertas`
--

CREATE TABLE `tbl_alertas` (
  `id_alerta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `mensaje` varchar(150) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_bitacora`
--

CREATE TABLE `tbl_bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `fecha_hora` text NOT NULL,
  `accion` varchar(50) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_bitacora`
--

INSERT INTO `tbl_bitacora` (`id_bitacora`, `fecha_hora`, `accion`, `id_modulo`, `id_usuario`) VALUES
(1, '2025-07-02 00:44:15', 'Acceso al módulo de catálogo', 1, 3),
(2, '2025-07-02 00:53:21', 'Acceso al módulo de catálogo', 1, 3),
(3, '2025-07-02 00:58:03', 'Acceso al módulo de catálogo', 1, 3),
(4, '2025-07-02 00:58:05', 'Acceso al módulo de catálogo', 1, 3),
(5, '2025-07-02 01:00:03', 'Acceso al módulo de catálogo', 1, 3),
(6, '2025-07-02 01:24:38', 'Acceso al módulo de catálogo', 1, 3),
(7, '2025-07-02 01:24:45', 'Acceso al módulo de catálogo', 1, 3),
(8, '2025-07-02 01:24:53', 'Acceso al módulo de catálogo', 1, 3),
(9, '2025-07-02 01:25:02', 'Acceso al módulo de catálogo', 1, 3),
(10, '2025-07-02 01:25:10', 'Acceso al módulo de catálogo', 1, 3),
(11, '2025-07-02 01:48:58', 'Acceso al módulo de catálogo', 1, 3),
(12, '2025-07-02 01:49:00', 'Acceso al módulo de catálogo', 1, 3),
(13, '2025-07-02 01:49:21', 'Acceso al módulo de catálogo', 1, 3),
(14, '2025-07-02 01:49:21', 'Agregó producto al carrito: Ca', 1, 3),
(15, '2025-07-02 01:49:31', 'Acceso al módulo de catálogo', 1, 3),
(16, '2025-07-02 22:28:32', 'Acceso al módulo de catálogo', 1, 9),
(17, '2025-07-02 22:28:46', 'Acceso al módulo de catálogo', 1, 9),
(18, '2025-07-02 22:28:46', 'Agregó producto al carrito: Ca', 1, 9),
(19, '2025-07-11 12:06:04', 'Acceso al módulo de Usuarios', 1, 3),
(20, '2025-07-11 12:06:38', 'Acceso al módulo de Usuarios', 1, 3),
(21, '2025-07-11 12:48:27', 'Acceso al módulo de catálogo', 10, 11),
(22, '2025-07-11 12:49:01', 'Filtrado de productos por marca (Marca ID: 2)', 10, 11),
(23, '2025-07-11 12:49:37', 'Filtrado de productos por marca', 10, 11),
(24, '2025-07-11 12:49:48', 'Filtrado de productos por marca (Marca ID: 2)', 10, 11),
(25, '2025-07-11 12:50:50', 'Agregó producto al carrito: Impresora Super (Canti', 10, 11),
(26, '2025-07-11 12:53:57', 'Acceso al módulo de catálogo', 10, 11),
(27, '2025-07-11 12:59:14', 'Acceso al módulo de catálogo', 10, 11),
(28, '2025-07-11 13:04:39', 'Acceso al módulo de Pasarela de pagos', 16, 11),
(29, '2025-07-11 13:04:58', 'Acceso al módulo de Pasarela de pagos', 16, 11),
(30, '2025-07-11 19:16:08', 'Acceso al módulo de Usuarios', 1, 8),
(31, '2025-07-11 19:16:19', 'Acceso al módulo de Usuarios', 1, 8),
(32, '2025-07-11 19:18:25', 'Acceso al módulo de cliente', 9, 8),
(33, '2025-07-11 19:20:06', 'Acceso al módulo de Usuarios', 1, 8),
(34, '2025-07-11 19:21:33', 'Acceso al módulo de Usuarios', 1, 8),
(35, '2025-07-11 19:22:17', 'Acceso al módulo de Usuarios', 1, 8),
(36, '2025-07-11 19:29:25', 'Acceso al módulo de Usuarios', 1, 8),
(37, '2025-07-11 19:35:23', 'Acceso al módulo de Usuarios', 1, 8),
(38, '2025-07-11 19:46:14', 'Acceso al módulo de Usuarios', 1, 8),
(39, '2025-07-11 19:47:16', 'Acceso al módulo de cliente', 9, 8),
(40, '2025-07-11 19:47:35', 'Acceso al módulo de Usuarios', 1, 8),
(41, '2025-07-11 19:49:55', 'Acceso al módulo de Usuarios', 1, 8),
(42, '2025-07-11 19:50:50', 'Acceso al módulo de Usuarios', 1, 8),
(43, '2025-07-11 20:05:43', 'Acceso al módulo de Usuarios', 1, 8),
(44, '2025-07-11 20:11:07', 'Acceso al módulo de Usuarios', 1, 8),
(45, '2025-07-11 20:14:06', 'Acceso al módulo de Usuarios', 1, 8),
(46, '2025-07-11 20:14:31', 'Creación de usuario: Pato', 1, 8),
(47, '2025-07-11 20:14:52', 'Acceso al módulo de cliente', 9, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modulos`
--

CREATE TABLE `tbl_modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_modulos`
--

INSERT INTO `tbl_modulos` (`id_modulo`, `nombre_modulo`) VALUES
(1, 'Usuario'),
(2, 'Recepcion'),
(3, 'Despacho'),
(4, 'Marcas'),
(5, 'Modelos'),
(6, 'Productos'),
(7, 'Categorias'),
(8, 'Proveedores'),
(9, 'Clientes'),
(10, 'Catalogo'),
(11, 'Carrito'),
(12, 'Pasarela'),
(13, 'Prefactura'),
(14, 'Ordenes de despacho'),
(15, 'Cuentas bancarias'),
(16, 'Finanzas'),
(17, 'Permisos'),
(18, 'Roles'),
(19, 'Bitacora'),
(20, 'Respaldo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos`
--

CREATE TABLE `tbl_permisos` (
  `id` int(11) NOT NULL,
  `accion` varchar(10) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `estatus` enum('Permitido','No Permitido') NOT NULL DEFAULT 'Permitido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`id`, `accion`, `id_rol`, `id_modulo`, `estatus`) VALUES
(5, 'ingresar', 6, 1, 'Permitido'),
(10, 'consultar', 6, 1, 'Permitido'),
(15, 'modificar', 6, 1, 'Permitido'),
(20, 'incluir', 6, 1, 'Permitido'),
(25, 'eliminar', 6, 1, 'Permitido'),
(30, 'reportar', 6, 1, 'Permitido'),
(35, 'ingresar', 6, 2, 'Permitido'),
(40, 'consultar', 6, 2, 'Permitido'),
(45, 'modificar', 6, 2, 'Permitido'),
(50, 'incluir', 6, 2, 'Permitido'),
(55, 'eliminar', 6, 2, 'Permitido'),
(60, 'reportar', 6, 2, 'Permitido'),
(65, 'ingresar', 6, 3, 'Permitido'),
(70, 'consultar', 6, 3, 'Permitido'),
(75, 'modificar', 6, 3, 'Permitido'),
(80, 'incluir', 6, 3, 'Permitido'),
(85, 'eliminar', 6, 3, 'Permitido'),
(90, 'reportar', 6, 3, 'Permitido'),
(95, 'ingresar', 6, 4, 'Permitido'),
(100, 'consultar', 6, 4, 'Permitido'),
(105, 'modificar', 6, 4, 'Permitido'),
(110, 'incluir', 6, 4, 'Permitido'),
(115, 'eliminar', 6, 4, 'Permitido'),
(120, 'reportar', 6, 4, 'Permitido'),
(125, 'ingresar', 6, 5, 'Permitido'),
(130, 'consultar', 6, 5, 'Permitido'),
(135, 'modificar', 6, 5, 'Permitido'),
(140, 'incluir', 6, 5, 'Permitido'),
(145, 'eliminar', 6, 5, 'Permitido'),
(150, 'reportar', 6, 5, 'Permitido'),
(155, 'ingresar', 6, 6, 'Permitido'),
(160, 'consultar', 6, 6, 'Permitido'),
(165, 'modificar', 6, 6, 'Permitido'),
(170, 'incluir', 6, 6, 'Permitido'),
(175, 'eliminar', 6, 6, 'Permitido'),
(180, 'reportar', 6, 6, 'Permitido'),
(185, 'ingresar', 6, 7, 'Permitido'),
(190, 'consultar', 6, 7, 'Permitido'),
(195, 'modificar', 6, 7, 'Permitido'),
(200, 'incluir', 6, 7, 'Permitido'),
(205, 'eliminar', 6, 7, 'Permitido'),
(210, 'reportar', 6, 7, 'Permitido'),
(215, 'ingresar', 6, 8, 'Permitido'),
(220, 'consultar', 6, 8, 'Permitido'),
(225, 'modificar', 6, 8, 'Permitido'),
(230, 'incluir', 6, 8, 'Permitido'),
(235, 'eliminar', 6, 8, 'Permitido'),
(240, 'reportar', 6, 8, 'Permitido'),
(245, 'ingresar', 6, 9, 'Permitido'),
(250, 'consultar', 6, 9, 'Permitido'),
(255, 'modificar', 6, 9, 'Permitido'),
(260, 'incluir', 6, 9, 'Permitido'),
(265, 'eliminar', 6, 9, 'Permitido'),
(270, 'reportar', 6, 9, 'Permitido'),
(275, 'ingresar', 6, 10, 'Permitido'),
(280, 'consultar', 6, 10, 'Permitido'),
(285, 'modificar', 6, 10, 'Permitido'),
(290, 'incluir', 6, 10, 'Permitido'),
(295, 'eliminar', 6, 10, 'Permitido'),
(300, 'reportar', 6, 10, 'Permitido'),
(305, 'ingresar', 6, 11, 'Permitido'),
(310, 'consultar', 6, 11, 'Permitido'),
(315, 'modificar', 6, 11, 'Permitido'),
(320, 'incluir', 6, 11, 'Permitido'),
(325, 'eliminar', 6, 11, 'Permitido'),
(330, 'reportar', 6, 11, 'Permitido'),
(335, 'ingresar', 6, 12, 'Permitido'),
(340, 'consultar', 6, 12, 'Permitido'),
(345, 'modificar', 6, 12, 'Permitido'),
(350, 'incluir', 6, 12, 'Permitido'),
(355, 'eliminar', 6, 12, 'Permitido'),
(360, 'reportar', 6, 12, 'Permitido'),
(365, 'ingresar', 6, 13, 'Permitido'),
(370, 'consultar', 6, 13, 'Permitido'),
(375, 'modificar', 6, 13, 'Permitido'),
(380, 'incluir', 6, 13, 'Permitido'),
(385, 'eliminar', 6, 13, 'Permitido'),
(390, 'reportar', 6, 13, 'Permitido'),
(395, 'ingresar', 6, 14, 'Permitido'),
(400, 'consultar', 6, 14, 'Permitido'),
(405, 'modificar', 6, 14, 'Permitido'),
(410, 'incluir', 6, 14, 'Permitido'),
(415, 'eliminar', 6, 14, 'Permitido'),
(420, 'reportar', 6, 14, 'Permitido'),
(425, 'ingresar', 6, 15, 'Permitido'),
(430, 'consultar', 6, 15, 'Permitido'),
(435, 'modificar', 6, 15, 'Permitido'),
(440, 'incluir', 6, 15, 'Permitido'),
(445, 'eliminar', 6, 15, 'Permitido'),
(450, 'reportar', 6, 15, 'Permitido'),
(455, 'ingresar', 6, 16, 'Permitido'),
(460, 'consultar', 6, 16, 'Permitido'),
(465, 'modificar', 6, 16, 'Permitido'),
(470, 'incluir', 6, 16, 'Permitido'),
(475, 'eliminar', 6, 16, 'Permitido'),
(480, 'reportar', 6, 16, 'Permitido'),
(485, 'ingresar', 6, 17, 'Permitido'),
(490, 'consultar', 6, 17, 'Permitido'),
(495, 'modificar', 6, 17, 'Permitido'),
(500, 'incluir', 6, 17, 'Permitido'),
(505, 'eliminar', 6, 17, 'Permitido'),
(510, 'reportar', 6, 17, 'Permitido'),
(515, 'ingresar', 6, 18, 'Permitido'),
(520, 'consultar', 6, 18, 'Permitido'),
(525, 'modificar', 6, 18, 'Permitido'),
(530, 'incluir', 6, 18, 'Permitido'),
(535, 'eliminar', 6, 18, 'Permitido'),
(540, 'reportar', 6, 18, 'Permitido'),
(545, 'ingresar', 6, 19, 'Permitido'),
(550, 'consultar', 6, 19, 'Permitido'),
(555, 'modificar', 6, 19, 'Permitido'),
(560, 'incluir', 6, 19, 'Permitido'),
(565, 'eliminar', 6, 19, 'Permitido'),
(570, 'reportar', 6, 19, 'Permitido'),
(575, 'ingresar', 6, 20, 'Permitido'),
(580, 'consultar', 6, 20, 'Permitido'),
(585, 'modificar', 6, 20, 'Permitido'),
(590, 'incluir', 6, 20, 'Permitido'),
(595, 'eliminar', 6, 20, 'Permitido'),
(600, 'reportar', 6, 20, 'Permitido'),
(5344, 'ingresar', 1, 1, 'Permitido'),
(5345, 'consultar', 1, 1, 'Permitido'),
(5346, 'incluir', 1, 1, 'Permitido'),
(5347, 'modificar', 1, 1, 'Permitido'),
(5348, 'eliminar', 1, 1, 'Permitido'),
(5349, 'ingresar', 1, 2, 'Permitido'),
(5350, 'consultar', 1, 2, 'Permitido'),
(5351, 'incluir', 1, 2, 'Permitido'),
(5352, 'modificar', 1, 2, 'Permitido'),
(5353, 'eliminar', 1, 2, 'Permitido'),
(5354, 'ingresar', 1, 3, 'Permitido'),
(5355, 'consultar', 1, 3, 'Permitido'),
(5356, 'incluir', 1, 3, 'Permitido'),
(5357, 'modificar', 1, 3, 'Permitido'),
(5358, 'eliminar', 1, 3, 'Permitido'),
(5359, 'ingresar', 1, 4, 'Permitido'),
(5360, 'consultar', 1, 4, 'Permitido'),
(5361, 'incluir', 1, 4, 'Permitido'),
(5362, 'modificar', 1, 4, 'Permitido'),
(5363, 'eliminar', 1, 4, 'Permitido'),
(5364, 'ingresar', 1, 5, 'Permitido'),
(5365, 'consultar', 1, 5, 'Permitido'),
(5366, 'incluir', 1, 5, 'Permitido'),
(5367, 'modificar', 1, 5, 'Permitido'),
(5368, 'eliminar', 1, 5, 'Permitido'),
(5369, 'ingresar', 1, 6, 'Permitido'),
(5370, 'consultar', 1, 6, 'Permitido'),
(5371, 'incluir', 1, 6, 'Permitido'),
(5372, 'modificar', 1, 6, 'Permitido'),
(5373, 'eliminar', 1, 6, 'Permitido'),
(5374, 'ingresar', 1, 7, 'Permitido'),
(5375, 'consultar', 1, 7, 'Permitido'),
(5376, 'incluir', 1, 7, 'Permitido'),
(5377, 'modificar', 1, 7, 'Permitido'),
(5378, 'eliminar', 1, 7, 'Permitido'),
(5379, 'ingresar', 1, 8, 'Permitido'),
(5380, 'consultar', 1, 8, 'Permitido'),
(5381, 'incluir', 1, 8, 'Permitido'),
(5382, 'modificar', 1, 8, 'Permitido'),
(5383, 'eliminar', 1, 8, 'Permitido'),
(5384, 'ingresar', 1, 9, 'Permitido'),
(5385, 'consultar', 1, 9, 'Permitido'),
(5386, 'incluir', 1, 9, 'Permitido'),
(5387, 'modificar', 1, 9, 'Permitido'),
(5388, 'eliminar', 1, 9, 'Permitido'),
(5389, 'ingresar', 1, 10, 'Permitido'),
(5390, 'consultar', 1, 10, 'Permitido'),
(5391, 'incluir', 1, 10, 'Permitido'),
(5392, 'modificar', 1, 10, 'Permitido'),
(5393, 'eliminar', 1, 10, 'Permitido'),
(5394, 'ingresar', 1, 11, 'Permitido'),
(5395, 'consultar', 1, 11, 'Permitido'),
(5396, 'incluir', 1, 11, 'Permitido'),
(5397, 'modificar', 1, 11, 'Permitido'),
(5398, 'eliminar', 1, 11, 'Permitido'),
(5399, 'ingresar', 1, 12, 'Permitido'),
(5400, 'consultar', 1, 12, 'Permitido'),
(5401, 'incluir', 1, 12, 'Permitido'),
(5402, 'modificar', 1, 12, 'Permitido'),
(5403, 'eliminar', 1, 12, 'Permitido'),
(5404, 'ingresar', 1, 13, 'Permitido'),
(5405, 'consultar', 1, 13, 'Permitido'),
(5406, 'incluir', 1, 13, 'Permitido'),
(5407, 'modificar', 1, 13, 'Permitido'),
(5408, 'eliminar', 1, 13, 'Permitido'),
(5409, 'ingresar', 1, 14, 'Permitido'),
(5410, 'consultar', 1, 14, 'Permitido'),
(5411, 'incluir', 1, 14, 'Permitido'),
(5412, 'modificar', 1, 14, 'Permitido'),
(5413, 'eliminar', 1, 14, 'Permitido'),
(5414, 'ingresar', 1, 15, 'Permitido'),
(5415, 'consultar', 1, 15, 'Permitido'),
(5416, 'incluir', 1, 15, 'Permitido'),
(5417, 'modificar', 1, 15, 'Permitido'),
(5418, 'eliminar', 1, 15, 'Permitido'),
(5419, 'ingresar', 1, 16, 'Permitido'),
(5420, 'consultar', 1, 16, 'Permitido'),
(5421, 'incluir', 1, 16, 'Permitido'),
(5422, 'modificar', 1, 16, 'Permitido'),
(5423, 'eliminar', 1, 16, 'Permitido'),
(5424, 'ingresar', 1, 17, 'Permitido'),
(5425, 'consultar', 1, 17, 'Permitido'),
(5426, 'incluir', 1, 17, 'Permitido'),
(5427, 'modificar', 1, 17, 'Permitido'),
(5428, 'eliminar', 1, 17, 'Permitido'),
(5429, 'ingresar', 1, 18, 'Permitido'),
(5430, 'consultar', 1, 18, 'Permitido'),
(5431, 'incluir', 1, 18, 'Permitido'),
(5432, 'modificar', 1, 18, 'Permitido'),
(5433, 'eliminar', 1, 18, 'Permitido'),
(5434, 'ingresar', 1, 19, 'Permitido'),
(5435, 'consultar', 1, 19, 'Permitido'),
(5436, 'incluir', 1, 19, 'Permitido'),
(5437, 'modificar', 1, 19, 'Permitido'),
(5438, 'eliminar', 1, 19, 'Permitido'),
(5439, 'ingresar', 1, 20, 'No Permitido'),
(5440, 'consultar', 1, 20, 'No Permitido'),
(5441, 'incluir', 1, 20, 'No Permitido'),
(5442, 'modificar', 1, 20, 'No Permitido'),
(5443, 'eliminar', 1, 20, 'No Permitido'),
(5444, 'ingresar', 2, 1, 'No Permitido'),
(5445, 'consultar', 2, 1, 'Permitido'),
(5446, 'incluir', 2, 1, 'Permitido'),
(5447, 'modificar', 2, 1, 'Permitido'),
(5448, 'eliminar', 2, 1, 'Permitido'),
(5449, 'ingresar', 2, 2, 'No Permitido'),
(5450, 'consultar', 2, 2, 'Permitido'),
(5451, 'incluir', 2, 2, 'Permitido'),
(5452, 'modificar', 2, 2, 'Permitido'),
(5453, 'eliminar', 2, 2, 'Permitido'),
(5454, 'ingresar', 2, 3, 'No Permitido'),
(5455, 'consultar', 2, 3, 'Permitido'),
(5456, 'incluir', 2, 3, 'Permitido'),
(5457, 'modificar', 2, 3, 'Permitido'),
(5458, 'eliminar', 2, 3, 'Permitido'),
(5459, 'ingresar', 2, 4, 'No Permitido'),
(5460, 'consultar', 2, 4, 'Permitido'),
(5461, 'incluir', 2, 4, 'Permitido'),
(5462, 'modificar', 2, 4, 'Permitido'),
(5463, 'eliminar', 2, 4, 'Permitido'),
(5464, 'ingresar', 2, 5, 'No Permitido'),
(5465, 'consultar', 2, 5, 'Permitido'),
(5466, 'incluir', 2, 5, 'Permitido'),
(5467, 'modificar', 2, 5, 'Permitido'),
(5468, 'eliminar', 2, 5, 'Permitido'),
(5469, 'ingresar', 2, 6, 'No Permitido'),
(5470, 'consultar', 2, 6, 'Permitido'),
(5471, 'incluir', 2, 6, 'Permitido'),
(5472, 'modificar', 2, 6, 'Permitido'),
(5473, 'eliminar', 2, 6, 'Permitido'),
(5474, 'ingresar', 2, 7, 'No Permitido'),
(5475, 'consultar', 2, 7, 'Permitido'),
(5476, 'incluir', 2, 7, 'Permitido'),
(5477, 'modificar', 2, 7, 'Permitido'),
(5478, 'eliminar', 2, 7, 'Permitido'),
(5479, 'ingresar', 2, 8, 'No Permitido'),
(5480, 'consultar', 2, 8, 'Permitido'),
(5481, 'incluir', 2, 8, 'Permitido'),
(5482, 'modificar', 2, 8, 'Permitido'),
(5483, 'eliminar', 2, 8, 'Permitido'),
(5484, 'ingresar', 2, 9, 'No Permitido'),
(5485, 'consultar', 2, 9, 'Permitido'),
(5486, 'incluir', 2, 9, 'Permitido'),
(5487, 'modificar', 2, 9, 'Permitido'),
(5488, 'eliminar', 2, 9, 'Permitido'),
(5489, 'ingresar', 2, 10, 'No Permitido'),
(5490, 'consultar', 2, 10, 'Permitido'),
(5491, 'incluir', 2, 10, 'Permitido'),
(5492, 'modificar', 2, 10, 'Permitido'),
(5493, 'eliminar', 2, 10, 'Permitido'),
(5494, 'ingresar', 2, 11, 'No Permitido'),
(5495, 'consultar', 2, 11, 'Permitido'),
(5496, 'incluir', 2, 11, 'Permitido'),
(5497, 'modificar', 2, 11, 'Permitido'),
(5498, 'eliminar', 2, 11, 'Permitido'),
(5499, 'ingresar', 2, 12, 'No Permitido'),
(5500, 'consultar', 2, 12, 'Permitido'),
(5501, 'incluir', 2, 12, 'Permitido'),
(5502, 'modificar', 2, 12, 'Permitido'),
(5503, 'eliminar', 2, 12, 'Permitido'),
(5504, 'ingresar', 2, 13, 'No Permitido'),
(5505, 'consultar', 2, 13, 'Permitido'),
(5506, 'incluir', 2, 13, 'Permitido'),
(5507, 'modificar', 2, 13, 'Permitido'),
(5508, 'eliminar', 2, 13, 'Permitido'),
(5509, 'ingresar', 2, 14, 'No Permitido'),
(5510, 'consultar', 2, 14, 'Permitido'),
(5511, 'incluir', 2, 14, 'Permitido'),
(5512, 'modificar', 2, 14, 'Permitido'),
(5513, 'eliminar', 2, 14, 'Permitido'),
(5514, 'ingresar', 2, 15, 'No Permitido'),
(5515, 'consultar', 2, 15, 'Permitido'),
(5516, 'incluir', 2, 15, 'Permitido'),
(5517, 'modificar', 2, 15, 'Permitido'),
(5518, 'eliminar', 2, 15, 'Permitido'),
(5519, 'ingresar', 2, 16, 'No Permitido'),
(5520, 'consultar', 2, 16, 'Permitido'),
(5521, 'incluir', 2, 16, 'Permitido'),
(5522, 'modificar', 2, 16, 'Permitido'),
(5523, 'eliminar', 2, 16, 'Permitido'),
(5524, 'ingresar', 2, 17, 'No Permitido'),
(5525, 'consultar', 2, 17, 'Permitido'),
(5526, 'incluir', 2, 17, 'Permitido'),
(5527, 'modificar', 2, 17, 'Permitido'),
(5528, 'eliminar', 2, 17, 'Permitido'),
(5529, 'ingresar', 2, 18, 'No Permitido'),
(5530, 'consultar', 2, 18, 'Permitido'),
(5531, 'incluir', 2, 18, 'Permitido'),
(5532, 'modificar', 2, 18, 'Permitido'),
(5533, 'eliminar', 2, 18, 'Permitido'),
(5534, 'ingresar', 2, 19, 'No Permitido'),
(5535, 'consultar', 2, 19, 'Permitido'),
(5536, 'incluir', 2, 19, 'Permitido'),
(5537, 'modificar', 2, 19, 'Permitido'),
(5538, 'eliminar', 2, 19, 'Permitido'),
(5539, 'ingresar', 2, 20, 'No Permitido'),
(5540, 'consultar', 2, 20, 'Permitido'),
(5541, 'incluir', 2, 20, 'Permitido'),
(5542, 'modificar', 2, 20, 'Permitido'),
(5543, 'eliminar', 2, 20, 'Permitido'),
(5544, 'ingresar', 3, 1, 'No Permitido'),
(5545, 'consultar', 3, 1, 'No Permitido'),
(5546, 'incluir', 3, 1, 'No Permitido'),
(5547, 'modificar', 3, 1, 'No Permitido'),
(5548, 'eliminar', 3, 1, 'No Permitido'),
(5549, 'ingresar', 3, 2, 'No Permitido'),
(5550, 'consultar', 3, 2, 'No Permitido'),
(5551, 'incluir', 3, 2, 'No Permitido'),
(5552, 'modificar', 3, 2, 'No Permitido'),
(5553, 'eliminar', 3, 2, 'No Permitido'),
(5554, 'ingresar', 3, 3, 'No Permitido'),
(5555, 'consultar', 3, 3, 'No Permitido'),
(5556, 'incluir', 3, 3, 'No Permitido'),
(5557, 'modificar', 3, 3, 'No Permitido'),
(5558, 'eliminar', 3, 3, 'No Permitido'),
(5559, 'ingresar', 3, 4, 'No Permitido'),
(5560, 'consultar', 3, 4, 'No Permitido'),
(5561, 'incluir', 3, 4, 'No Permitido'),
(5562, 'modificar', 3, 4, 'No Permitido'),
(5563, 'eliminar', 3, 4, 'No Permitido'),
(5564, 'ingresar', 3, 5, 'No Permitido'),
(5565, 'consultar', 3, 5, 'No Permitido'),
(5566, 'incluir', 3, 5, 'No Permitido'),
(5567, 'modificar', 3, 5, 'No Permitido'),
(5568, 'eliminar', 3, 5, 'No Permitido'),
(5569, 'ingresar', 3, 6, 'No Permitido'),
(5570, 'consultar', 3, 6, 'No Permitido'),
(5571, 'incluir', 3, 6, 'No Permitido'),
(5572, 'modificar', 3, 6, 'No Permitido'),
(5573, 'eliminar', 3, 6, 'No Permitido'),
(5574, 'ingresar', 3, 7, 'No Permitido'),
(5575, 'consultar', 3, 7, 'No Permitido'),
(5576, 'incluir', 3, 7, 'No Permitido'),
(5577, 'modificar', 3, 7, 'No Permitido'),
(5578, 'eliminar', 3, 7, 'No Permitido'),
(5579, 'ingresar', 3, 8, 'No Permitido'),
(5580, 'consultar', 3, 8, 'No Permitido'),
(5581, 'incluir', 3, 8, 'No Permitido'),
(5582, 'modificar', 3, 8, 'No Permitido'),
(5583, 'eliminar', 3, 8, 'No Permitido'),
(5584, 'ingresar', 3, 9, 'No Permitido'),
(5585, 'consultar', 3, 9, 'No Permitido'),
(5586, 'incluir', 3, 9, 'No Permitido'),
(5587, 'modificar', 3, 9, 'No Permitido'),
(5588, 'eliminar', 3, 9, 'No Permitido'),
(5589, 'ingresar', 3, 10, 'Permitido'),
(5590, 'consultar', 3, 10, 'Permitido'),
(5591, 'incluir', 3, 10, 'Permitido'),
(5592, 'modificar', 3, 10, 'Permitido'),
(5593, 'eliminar', 3, 10, 'Permitido'),
(5594, 'ingresar', 3, 11, 'Permitido'),
(5595, 'consultar', 3, 11, 'Permitido'),
(5596, 'incluir', 3, 11, 'Permitido'),
(5597, 'modificar', 3, 11, 'Permitido'),
(5598, 'eliminar', 3, 11, 'Permitido'),
(5599, 'ingresar', 3, 12, 'Permitido'),
(5600, 'consultar', 3, 12, 'Permitido'),
(5601, 'incluir', 3, 12, 'Permitido'),
(5602, 'modificar', 3, 12, 'Permitido'),
(5603, 'eliminar', 3, 12, 'Permitido'),
(5604, 'ingresar', 3, 13, 'Permitido'),
(5605, 'consultar', 3, 13, 'Permitido'),
(5606, 'incluir', 3, 13, 'Permitido'),
(5607, 'modificar', 3, 13, 'Permitido'),
(5608, 'eliminar', 3, 13, 'Permitido'),
(5609, 'ingresar', 3, 14, 'No Permitido'),
(5610, 'consultar', 3, 14, 'No Permitido'),
(5611, 'incluir', 3, 14, 'No Permitido'),
(5612, 'modificar', 3, 14, 'No Permitido'),
(5613, 'eliminar', 3, 14, 'No Permitido'),
(5614, 'ingresar', 3, 15, 'No Permitido'),
(5615, 'consultar', 3, 15, 'No Permitido'),
(5616, 'incluir', 3, 15, 'No Permitido'),
(5617, 'modificar', 3, 15, 'No Permitido'),
(5618, 'eliminar', 3, 15, 'No Permitido'),
(5619, 'ingresar', 3, 16, 'No Permitido'),
(5620, 'consultar', 3, 16, 'No Permitido'),
(5621, 'incluir', 3, 16, 'No Permitido'),
(5622, 'modificar', 3, 16, 'No Permitido'),
(5623, 'eliminar', 3, 16, 'No Permitido'),
(5624, 'ingresar', 3, 17, 'No Permitido'),
(5625, 'consultar', 3, 17, 'No Permitido'),
(5626, 'incluir', 3, 17, 'No Permitido'),
(5627, 'modificar', 3, 17, 'No Permitido'),
(5628, 'eliminar', 3, 17, 'No Permitido'),
(5629, 'ingresar', 3, 18, 'No Permitido'),
(5630, 'consultar', 3, 18, 'No Permitido'),
(5631, 'incluir', 3, 18, 'No Permitido'),
(5632, 'modificar', 3, 18, 'No Permitido'),
(5633, 'eliminar', 3, 18, 'No Permitido'),
(5634, 'ingresar', 3, 19, 'No Permitido'),
(5635, 'consultar', 3, 19, 'No Permitido'),
(5636, 'incluir', 3, 19, 'No Permitido'),
(5637, 'modificar', 3, 19, 'No Permitido'),
(5638, 'eliminar', 3, 19, 'No Permitido'),
(5639, 'ingresar', 3, 20, 'No Permitido'),
(5640, 'consultar', 3, 20, 'No Permitido'),
(5641, 'incluir', 3, 20, 'No Permitido'),
(5642, 'modificar', 3, 20, 'No Permitido'),
(5643, 'eliminar', 3, 20, 'No Permitido'),
(5644, 'ingresar', 4, 1, 'No Permitido'),
(5645, 'consultar', 4, 1, 'Permitido'),
(5646, 'incluir', 4, 1, 'Permitido'),
(5647, 'modificar', 4, 1, 'Permitido'),
(5648, 'eliminar', 4, 1, 'Permitido'),
(5649, 'ingresar', 4, 2, 'No Permitido'),
(5650, 'consultar', 4, 2, 'Permitido'),
(5651, 'incluir', 4, 2, 'Permitido'),
(5652, 'modificar', 4, 2, 'Permitido'),
(5653, 'eliminar', 4, 2, 'Permitido'),
(5654, 'ingresar', 4, 3, 'No Permitido'),
(5655, 'consultar', 4, 3, 'Permitido'),
(5656, 'incluir', 4, 3, 'Permitido'),
(5657, 'modificar', 4, 3, 'Permitido'),
(5658, 'eliminar', 4, 3, 'Permitido'),
(5659, 'ingresar', 4, 4, 'No Permitido'),
(5660, 'consultar', 4, 4, 'Permitido'),
(5661, 'incluir', 4, 4, 'Permitido'),
(5662, 'modificar', 4, 4, 'Permitido'),
(5663, 'eliminar', 4, 4, 'Permitido'),
(5664, 'ingresar', 4, 5, 'No Permitido'),
(5665, 'consultar', 4, 5, 'Permitido'),
(5666, 'incluir', 4, 5, 'Permitido'),
(5667, 'modificar', 4, 5, 'Permitido'),
(5668, 'eliminar', 4, 5, 'Permitido'),
(5669, 'ingresar', 4, 6, 'No Permitido'),
(5670, 'consultar', 4, 6, 'Permitido'),
(5671, 'incluir', 4, 6, 'Permitido'),
(5672, 'modificar', 4, 6, 'Permitido'),
(5673, 'eliminar', 4, 6, 'Permitido'),
(5674, 'ingresar', 4, 7, 'No Permitido'),
(5675, 'consultar', 4, 7, 'Permitido'),
(5676, 'incluir', 4, 7, 'Permitido'),
(5677, 'modificar', 4, 7, 'Permitido'),
(5678, 'eliminar', 4, 7, 'Permitido'),
(5679, 'ingresar', 4, 8, 'No Permitido'),
(5680, 'consultar', 4, 8, 'Permitido'),
(5681, 'incluir', 4, 8, 'Permitido'),
(5682, 'modificar', 4, 8, 'Permitido'),
(5683, 'eliminar', 4, 8, 'Permitido'),
(5684, 'ingresar', 4, 9, 'No Permitido'),
(5685, 'consultar', 4, 9, 'Permitido'),
(5686, 'incluir', 4, 9, 'Permitido'),
(5687, 'modificar', 4, 9, 'Permitido'),
(5688, 'eliminar', 4, 9, 'Permitido'),
(5689, 'ingresar', 4, 10, 'No Permitido'),
(5690, 'consultar', 4, 10, 'Permitido'),
(5691, 'incluir', 4, 10, 'Permitido'),
(5692, 'modificar', 4, 10, 'Permitido'),
(5693, 'eliminar', 4, 10, 'Permitido'),
(5694, 'ingresar', 4, 11, 'No Permitido'),
(5695, 'consultar', 4, 11, 'Permitido'),
(5696, 'incluir', 4, 11, 'Permitido'),
(5697, 'modificar', 4, 11, 'Permitido'),
(5698, 'eliminar', 4, 11, 'Permitido'),
(5699, 'ingresar', 4, 12, 'No Permitido'),
(5700, 'consultar', 4, 12, 'Permitido'),
(5701, 'incluir', 4, 12, 'Permitido'),
(5702, 'modificar', 4, 12, 'Permitido'),
(5703, 'eliminar', 4, 12, 'Permitido'),
(5704, 'ingresar', 4, 13, 'No Permitido'),
(5705, 'consultar', 4, 13, 'Permitido'),
(5706, 'incluir', 4, 13, 'Permitido'),
(5707, 'modificar', 4, 13, 'Permitido'),
(5708, 'eliminar', 4, 13, 'Permitido'),
(5709, 'ingresar', 4, 14, 'No Permitido'),
(5710, 'consultar', 4, 14, 'Permitido'),
(5711, 'incluir', 4, 14, 'Permitido'),
(5712, 'modificar', 4, 14, 'Permitido'),
(5713, 'eliminar', 4, 14, 'Permitido'),
(5714, 'ingresar', 4, 15, 'No Permitido'),
(5715, 'consultar', 4, 15, 'Permitido'),
(5716, 'incluir', 4, 15, 'Permitido'),
(5717, 'modificar', 4, 15, 'Permitido'),
(5718, 'eliminar', 4, 15, 'Permitido'),
(5719, 'ingresar', 4, 16, 'No Permitido'),
(5720, 'consultar', 4, 16, 'Permitido'),
(5721, 'incluir', 4, 16, 'Permitido'),
(5722, 'modificar', 4, 16, 'Permitido'),
(5723, 'eliminar', 4, 16, 'Permitido'),
(5724, 'ingresar', 4, 17, 'No Permitido'),
(5725, 'consultar', 4, 17, 'Permitido'),
(5726, 'incluir', 4, 17, 'Permitido'),
(5727, 'modificar', 4, 17, 'Permitido'),
(5728, 'eliminar', 4, 17, 'Permitido'),
(5729, 'ingresar', 4, 18, 'No Permitido'),
(5730, 'consultar', 4, 18, 'Permitido'),
(5731, 'incluir', 4, 18, 'Permitido'),
(5732, 'modificar', 4, 18, 'Permitido'),
(5733, 'eliminar', 4, 18, 'Permitido'),
(5734, 'ingresar', 4, 19, 'No Permitido'),
(5735, 'consultar', 4, 19, 'Permitido'),
(5736, 'incluir', 4, 19, 'Permitido'),
(5737, 'modificar', 4, 19, 'Permitido'),
(5738, 'eliminar', 4, 19, 'Permitido'),
(5739, 'ingresar', 4, 20, 'No Permitido'),
(5740, 'consultar', 4, 20, 'Permitido'),
(5741, 'incluir', 4, 20, 'Permitido'),
(5742, 'modificar', 4, 20, 'Permitido'),
(5743, 'eliminar', 4, 20, 'Permitido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recuperar`
--

CREATE TABLE `tbl_recuperar` (
  `id_recuperar` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_rol`
--

CREATE TABLE `tbl_rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_rol`
--

INSERT INTO `tbl_rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Almacenista'),
(3, 'Cliente'),
(4, 'Desarrollador'),
(6, 'SuperUsuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cedula` varchar(8) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estatus` enum('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuario`, `username`, `password`, `cedula`, `id_rol`, `correo`, `nombres`, `apellidos`, `telefono`, `estatus`) VALUES
(3, 'Diego', '$2y$10$aVnYPs5gz8QcihC.PT2eQeqg/2B0Vk4TQlPl2hVKz3vbnhoRQVdnW', '30123123', 6, 'ejemplo@gmail.com', 'Diego', 'Compa', '0414-575-3363', 'habilitado'),
(4, 'Simon', '$2y$10$bJfY45blf5qV66WzNf5.OOTPFjgCEePpBz07GQUc3B0qlKMNzJd8W', '29123123', 3, 'ejemplo@gmail.com', 'Simon Freitez', 'Cliente', '0414-000-0000', 'habilitado'),
(5, 'SuperUsu', '$2y$10$w7nQw5p6Qw6nQw5p6Qw6nOQw5p6Qw6nQw5p6Qw6nQw5p6Qw6nQw6n', '30123456', 6, 'ejemplo@gmail.com', 'Diego Andres', 'Lopez Vivas', '0414-575-3363', 'habilitado'),
(7, 'Ben10', '$2y$10$xYFm.SoVzcTO1Z8VNeoP.eVpI.s6YZ54sZqoN20ogR/n7uTHNf0yG', '30123789', 1, 'ggy@gmail.com', 'Pa', 'nose', '0414-000-0000', 'habilitado'),
(8, 'DiegoS', '$2y$10$YNp4Po6bWqvBhXD2W4zm6OZk6i.l1QHVzzZLFrn8Y7gQ4.NFU89TW', '30456456', 1, 'ggy@gmail.com', 'Diego', 'Compa Vendedor', '0414-575-3363', 'habilitado'),
(9, 'CasaLai', '$2y$10$KXRg/AUD.9Y7KubEvzy71e5dDR1GvGNy23XegAYwLjYWOBdcxzqx2', '30456789', 6, 'diego0510lopez@gmail.com', 'Casa', 'Lai', '0414-575-3363', 'habilitado'),
(10, 'Gmujica', '$2y$10$iZNeKonr6qr.P109rwgEFOCc7Y.0E47sD/88YfB.Jyx6niGpf4CQi', '29958676', 3, 'fhhggjjkkkj@gmail.com', 'Gabriel', 'Mujica', '0424-678-8765', 'habilitado'),
(11, 'edithu', '$2y$10$YfEtJDHi9CNZR1Xpx7J9Ze8CMx3g99o1dJ3h.RRZPXqlJjxWbT5Fi', '10844463', 3, 'urdavedith.pnfi@gmail.com', 'Edith', 'Urdaneta', '0416-747-4336', 'habilitado'),
(15, 'Pato', '$2y$10$2OgFNgMxHcDgqjCvfCHsVOYLkc6Qq3QqSalImRPOaP51loMFpFHsa', '5322432', 1, 'diego0510lopez@gmail.com', 'Diego', 'Lopez', '0414-575-3363', 'habilitado'),
(16, 'Darckort', '$2y$10$1xavkBCftrr0QLclZTk77eduhFhvGa3uWiuCva2qHKMQ/otwoGYaa', '28406324', 6, 'darckortgame@gmail.com', 'Braynt', 'Medina', '0426-150-4714', 'habilitado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_alertas`
--
ALTER TABLE `tbl_alertas`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `id_modulo` (`id_modulo`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`,`id_modulo`),
  ADD KEY `id_modulo` (`id_modulo`);

--
-- Indices de la tabla `tbl_recuperar`
--
ALTER TABLE `tbl_recuperar`
  ADD PRIMARY KEY (`id_recuperar`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_rol`
--
ALTER TABLE `tbl_rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_alertas`
--
ALTER TABLE `tbl_alertas`
  MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5744;

--
-- AUTO_INCREMENT de la tabla `tbl_recuperar`
--
ALTER TABLE `tbl_recuperar`
  MODIFY `id_recuperar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_rol`
--
ALTER TABLE `tbl_rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_alertas`
--
ALTER TABLE `tbl_alertas`
  ADD CONSTRAINT `tbl_alertas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  ADD CONSTRAINT `tbl_bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_bitacora_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `tbl_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD CONSTRAINT `tbl_permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_permisos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `tbl_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_recuperar`
--
ALTER TABLE `tbl_recuperar`
  ADD CONSTRAINT `tbl_recuperar_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
