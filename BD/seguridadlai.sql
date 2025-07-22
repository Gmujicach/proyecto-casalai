-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2025 a las 02:04:38
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
(4144, 'ingresar', 1, 1, 'Permitido'),
(4145, 'consultar', 1, 1, 'Permitido'),
(4146, 'incluir', 1, 1, 'Permitido'),
(4147, 'modificar', 1, 1, 'Permitido'),
(4148, 'eliminar', 1, 1, 'Permitido'),
(4149, 'ingresar', 1, 2, 'Permitido'),
(4150, 'consultar', 1, 2, 'Permitido'),
(4151, 'incluir', 1, 2, 'Permitido'),
(4152, 'modificar', 1, 2, 'Permitido'),
(4153, 'eliminar', 1, 2, 'Permitido'),
(4154, 'ingresar', 1, 3, 'Permitido'),
(4155, 'consultar', 1, 3, 'Permitido'),
(4156, 'incluir', 1, 3, 'Permitido'),
(4157, 'modificar', 1, 3, 'Permitido'),
(4158, 'eliminar', 1, 3, 'Permitido'),
(4159, 'ingresar', 1, 4, 'Permitido'),
(4160, 'consultar', 1, 4, 'Permitido'),
(4161, 'incluir', 1, 4, 'Permitido'),
(4162, 'modificar', 1, 4, 'Permitido'),
(4163, 'eliminar', 1, 4, 'Permitido'),
(4164, 'ingresar', 1, 5, 'Permitido'),
(4165, 'consultar', 1, 5, 'Permitido'),
(4166, 'incluir', 1, 5, 'Permitido'),
(4167, 'modificar', 1, 5, 'Permitido'),
(4168, 'eliminar', 1, 5, 'Permitido'),
(4169, 'ingresar', 1, 6, 'Permitido'),
(4170, 'consultar', 1, 6, 'Permitido'),
(4171, 'incluir', 1, 6, 'Permitido'),
(4172, 'modificar', 1, 6, 'Permitido'),
(4173, 'eliminar', 1, 6, 'Permitido'),
(4174, 'ingresar', 1, 7, 'Permitido'),
(4175, 'consultar', 1, 7, 'Permitido'),
(4176, 'incluir', 1, 7, 'Permitido'),
(4177, 'modificar', 1, 7, 'Permitido'),
(4178, 'eliminar', 1, 7, 'Permitido'),
(4179, 'ingresar', 1, 8, 'Permitido'),
(4180, 'consultar', 1, 8, 'Permitido'),
(4181, 'incluir', 1, 8, 'Permitido'),
(4182, 'modificar', 1, 8, 'Permitido'),
(4183, 'eliminar', 1, 8, 'Permitido'),
(4184, 'ingresar', 1, 9, 'Permitido'),
(4185, 'consultar', 1, 9, 'Permitido'),
(4186, 'incluir', 1, 9, 'Permitido'),
(4187, 'modificar', 1, 9, 'Permitido'),
(4188, 'eliminar', 1, 9, 'Permitido'),
(4189, 'ingresar', 1, 10, 'Permitido'),
(4190, 'consultar', 1, 10, 'Permitido'),
(4191, 'incluir', 1, 10, 'Permitido'),
(4192, 'modificar', 1, 10, 'Permitido'),
(4193, 'eliminar', 1, 10, 'Permitido'),
(4194, 'ingresar', 1, 11, 'Permitido'),
(4195, 'consultar', 1, 11, 'Permitido'),
(4196, 'incluir', 1, 11, 'Permitido'),
(4197, 'modificar', 1, 11, 'Permitido'),
(4198, 'eliminar', 1, 11, 'Permitido'),
(4199, 'ingresar', 1, 12, 'Permitido'),
(4200, 'consultar', 1, 12, 'Permitido'),
(4201, 'incluir', 1, 12, 'Permitido'),
(4202, 'modificar', 1, 12, 'Permitido'),
(4203, 'eliminar', 1, 12, 'Permitido'),
(4204, 'ingresar', 1, 13, 'Permitido'),
(4205, 'consultar', 1, 13, 'Permitido'),
(4206, 'incluir', 1, 13, 'Permitido'),
(4207, 'modificar', 1, 13, 'Permitido'),
(4208, 'eliminar', 1, 13, 'Permitido'),
(4209, 'ingresar', 1, 14, 'Permitido'),
(4210, 'consultar', 1, 14, 'Permitido'),
(4211, 'incluir', 1, 14, 'Permitido'),
(4212, 'modificar', 1, 14, 'Permitido'),
(4213, 'eliminar', 1, 14, 'Permitido'),
(4214, 'ingresar', 1, 15, 'Permitido'),
(4215, 'consultar', 1, 15, 'Permitido'),
(4216, 'incluir', 1, 15, 'Permitido'),
(4217, 'modificar', 1, 15, 'Permitido'),
(4218, 'eliminar', 1, 15, 'Permitido'),
(4219, 'ingresar', 1, 16, 'Permitido'),
(4220, 'consultar', 1, 16, 'Permitido'),
(4221, 'incluir', 1, 16, 'Permitido'),
(4222, 'modificar', 1, 16, 'Permitido'),
(4223, 'eliminar', 1, 16, 'Permitido'),
(4224, 'ingresar', 1, 17, 'Permitido'),
(4225, 'consultar', 1, 17, 'Permitido'),
(4226, 'incluir', 1, 17, 'Permitido'),
(4227, 'modificar', 1, 17, 'Permitido'),
(4228, 'eliminar', 1, 17, 'Permitido'),
(4229, 'ingresar', 1, 18, 'Permitido'),
(4230, 'consultar', 1, 18, 'Permitido'),
(4231, 'incluir', 1, 18, 'Permitido'),
(4232, 'modificar', 1, 18, 'Permitido'),
(4233, 'eliminar', 1, 18, 'Permitido'),
(4234, 'ingresar', 1, 19, 'Permitido'),
(4235, 'consultar', 1, 19, 'Permitido'),
(4236, 'incluir', 1, 19, 'Permitido'),
(4237, 'modificar', 1, 19, 'Permitido'),
(4238, 'eliminar', 1, 19, 'Permitido'),
(4239, 'ingresar', 1, 20, 'No Permitido'),
(4240, 'consultar', 1, 20, 'No Permitido'),
(4241, 'incluir', 1, 20, 'No Permitido'),
(4242, 'modificar', 1, 20, 'No Permitido'),
(4243, 'eliminar', 1, 20, 'No Permitido'),
(4244, 'ingresar', 2, 1, 'No Permitido'),
(4245, 'consultar', 2, 1, 'Permitido'),
(4246, 'incluir', 2, 1, 'Permitido'),
(4247, 'modificar', 2, 1, 'Permitido'),
(4248, 'eliminar', 2, 1, 'Permitido'),
(4249, 'ingresar', 2, 2, 'No Permitido'),
(4250, 'consultar', 2, 2, 'Permitido'),
(4251, 'incluir', 2, 2, 'Permitido'),
(4252, 'modificar', 2, 2, 'Permitido'),
(4253, 'eliminar', 2, 2, 'Permitido'),
(4254, 'ingresar', 2, 3, 'No Permitido'),
(4255, 'consultar', 2, 3, 'Permitido'),
(4256, 'incluir', 2, 3, 'Permitido'),
(4257, 'modificar', 2, 3, 'Permitido'),
(4258, 'eliminar', 2, 3, 'Permitido'),
(4259, 'ingresar', 2, 4, 'No Permitido'),
(4260, 'consultar', 2, 4, 'Permitido'),
(4261, 'incluir', 2, 4, 'Permitido'),
(4262, 'modificar', 2, 4, 'Permitido'),
(4263, 'eliminar', 2, 4, 'Permitido'),
(4264, 'ingresar', 2, 5, 'No Permitido'),
(4265, 'consultar', 2, 5, 'Permitido'),
(4266, 'incluir', 2, 5, 'Permitido'),
(4267, 'modificar', 2, 5, 'Permitido'),
(4268, 'eliminar', 2, 5, 'Permitido'),
(4269, 'ingresar', 2, 6, 'No Permitido'),
(4270, 'consultar', 2, 6, 'Permitido'),
(4271, 'incluir', 2, 6, 'Permitido'),
(4272, 'modificar', 2, 6, 'Permitido'),
(4273, 'eliminar', 2, 6, 'Permitido'),
(4274, 'ingresar', 2, 7, 'No Permitido'),
(4275, 'consultar', 2, 7, 'Permitido'),
(4276, 'incluir', 2, 7, 'Permitido'),
(4277, 'modificar', 2, 7, 'Permitido'),
(4278, 'eliminar', 2, 7, 'Permitido'),
(4279, 'ingresar', 2, 8, 'No Permitido'),
(4280, 'consultar', 2, 8, 'Permitido'),
(4281, 'incluir', 2, 8, 'Permitido'),
(4282, 'modificar', 2, 8, 'Permitido'),
(4283, 'eliminar', 2, 8, 'Permitido'),
(4284, 'ingresar', 2, 9, 'No Permitido'),
(4285, 'consultar', 2, 9, 'Permitido'),
(4286, 'incluir', 2, 9, 'Permitido'),
(4287, 'modificar', 2, 9, 'Permitido'),
(4288, 'eliminar', 2, 9, 'Permitido'),
(4289, 'ingresar', 2, 10, 'No Permitido'),
(4290, 'consultar', 2, 10, 'Permitido'),
(4291, 'incluir', 2, 10, 'Permitido'),
(4292, 'modificar', 2, 10, 'Permitido'),
(4293, 'eliminar', 2, 10, 'Permitido'),
(4294, 'ingresar', 2, 11, 'No Permitido'),
(4295, 'consultar', 2, 11, 'Permitido'),
(4296, 'incluir', 2, 11, 'Permitido'),
(4297, 'modificar', 2, 11, 'Permitido'),
(4298, 'eliminar', 2, 11, 'Permitido'),
(4299, 'ingresar', 2, 12, 'No Permitido'),
(4300, 'consultar', 2, 12, 'Permitido'),
(4301, 'incluir', 2, 12, 'Permitido'),
(4302, 'modificar', 2, 12, 'Permitido'),
(4303, 'eliminar', 2, 12, 'Permitido'),
(4304, 'ingresar', 2, 13, 'No Permitido'),
(4305, 'consultar', 2, 13, 'Permitido'),
(4306, 'incluir', 2, 13, 'Permitido'),
(4307, 'modificar', 2, 13, 'Permitido'),
(4308, 'eliminar', 2, 13, 'Permitido'),
(4309, 'ingresar', 2, 14, 'No Permitido'),
(4310, 'consultar', 2, 14, 'Permitido'),
(4311, 'incluir', 2, 14, 'Permitido'),
(4312, 'modificar', 2, 14, 'Permitido'),
(4313, 'eliminar', 2, 14, 'Permitido'),
(4314, 'ingresar', 2, 15, 'No Permitido'),
(4315, 'consultar', 2, 15, 'Permitido'),
(4316, 'incluir', 2, 15, 'Permitido'),
(4317, 'modificar', 2, 15, 'Permitido'),
(4318, 'eliminar', 2, 15, 'Permitido'),
(4319, 'ingresar', 2, 16, 'No Permitido'),
(4320, 'consultar', 2, 16, 'Permitido'),
(4321, 'incluir', 2, 16, 'Permitido'),
(4322, 'modificar', 2, 16, 'Permitido'),
(4323, 'eliminar', 2, 16, 'Permitido'),
(4324, 'ingresar', 2, 17, 'No Permitido'),
(4325, 'consultar', 2, 17, 'Permitido'),
(4326, 'incluir', 2, 17, 'Permitido'),
(4327, 'modificar', 2, 17, 'Permitido'),
(4328, 'eliminar', 2, 17, 'Permitido'),
(4329, 'ingresar', 2, 18, 'No Permitido'),
(4330, 'consultar', 2, 18, 'Permitido'),
(4331, 'incluir', 2, 18, 'Permitido'),
(4332, 'modificar', 2, 18, 'Permitido'),
(4333, 'eliminar', 2, 18, 'Permitido'),
(4334, 'ingresar', 2, 19, 'No Permitido'),
(4335, 'consultar', 2, 19, 'Permitido'),
(4336, 'incluir', 2, 19, 'Permitido'),
(4337, 'modificar', 2, 19, 'Permitido'),
(4338, 'eliminar', 2, 19, 'Permitido'),
(4339, 'ingresar', 2, 20, 'No Permitido'),
(4340, 'consultar', 2, 20, 'Permitido'),
(4341, 'incluir', 2, 20, 'Permitido'),
(4342, 'modificar', 2, 20, 'Permitido'),
(4343, 'eliminar', 2, 20, 'Permitido'),
(4344, 'ingresar', 3, 1, 'No Permitido'),
(4345, 'consultar', 3, 1, 'No Permitido'),
(4346, 'incluir', 3, 1, 'No Permitido'),
(4347, 'modificar', 3, 1, 'No Permitido'),
(4348, 'eliminar', 3, 1, 'No Permitido'),
(4349, 'ingresar', 3, 2, 'No Permitido'),
(4350, 'consultar', 3, 2, 'No Permitido'),
(4351, 'incluir', 3, 2, 'No Permitido'),
(4352, 'modificar', 3, 2, 'No Permitido'),
(4353, 'eliminar', 3, 2, 'No Permitido'),
(4354, 'ingresar', 3, 3, 'No Permitido'),
(4355, 'consultar', 3, 3, 'No Permitido'),
(4356, 'incluir', 3, 3, 'No Permitido'),
(4357, 'modificar', 3, 3, 'No Permitido'),
(4358, 'eliminar', 3, 3, 'No Permitido'),
(4359, 'ingresar', 3, 4, 'No Permitido'),
(4360, 'consultar', 3, 4, 'No Permitido'),
(4361, 'incluir', 3, 4, 'No Permitido'),
(4362, 'modificar', 3, 4, 'No Permitido'),
(4363, 'eliminar', 3, 4, 'No Permitido'),
(4364, 'ingresar', 3, 5, 'No Permitido'),
(4365, 'consultar', 3, 5, 'No Permitido'),
(4366, 'incluir', 3, 5, 'No Permitido'),
(4367, 'modificar', 3, 5, 'No Permitido'),
(4368, 'eliminar', 3, 5, 'No Permitido'),
(4369, 'ingresar', 3, 6, 'No Permitido'),
(4370, 'consultar', 3, 6, 'No Permitido'),
(4371, 'incluir', 3, 6, 'No Permitido'),
(4372, 'modificar', 3, 6, 'No Permitido'),
(4373, 'eliminar', 3, 6, 'No Permitido'),
(4374, 'ingresar', 3, 7, 'No Permitido'),
(4375, 'consultar', 3, 7, 'No Permitido'),
(4376, 'incluir', 3, 7, 'No Permitido'),
(4377, 'modificar', 3, 7, 'No Permitido'),
(4378, 'eliminar', 3, 7, 'No Permitido'),
(4379, 'ingresar', 3, 8, 'No Permitido'),
(4380, 'consultar', 3, 8, 'No Permitido'),
(4381, 'incluir', 3, 8, 'No Permitido'),
(4382, 'modificar', 3, 8, 'No Permitido'),
(4383, 'eliminar', 3, 8, 'No Permitido'),
(4384, 'ingresar', 3, 9, 'No Permitido'),
(4385, 'consultar', 3, 9, 'No Permitido'),
(4386, 'incluir', 3, 9, 'No Permitido'),
(4387, 'modificar', 3, 9, 'No Permitido'),
(4388, 'eliminar', 3, 9, 'No Permitido'),
(4389, 'ingresar', 3, 10, 'Permitido'),
(4390, 'consultar', 3, 10, 'Permitido'),
(4391, 'incluir', 3, 10, 'Permitido'),
(4392, 'modificar', 3, 10, 'Permitido'),
(4393, 'eliminar', 3, 10, 'Permitido'),
(4394, 'ingresar', 3, 11, 'Permitido'),
(4395, 'consultar', 3, 11, 'Permitido'),
(4396, 'incluir', 3, 11, 'Permitido'),
(4397, 'modificar', 3, 11, 'Permitido'),
(4398, 'eliminar', 3, 11, 'Permitido'),
(4399, 'ingresar', 3, 12, 'Permitido'),
(4400, 'consultar', 3, 12, 'Permitido'),
(4401, 'incluir', 3, 12, 'Permitido'),
(4402, 'modificar', 3, 12, 'Permitido'),
(4403, 'eliminar', 3, 12, 'Permitido'),
(4404, 'ingresar', 3, 13, 'Permitido'),
(4405, 'consultar', 3, 13, 'Permitido'),
(4406, 'incluir', 3, 13, 'Permitido'),
(4407, 'modificar', 3, 13, 'Permitido'),
(4408, 'eliminar', 3, 13, 'Permitido'),
(4409, 'ingresar', 3, 14, 'No Permitido'),
(4410, 'consultar', 3, 14, 'No Permitido'),
(4411, 'incluir', 3, 14, 'No Permitido'),
(4412, 'modificar', 3, 14, 'No Permitido'),
(4413, 'eliminar', 3, 14, 'No Permitido'),
(4414, 'ingresar', 3, 15, 'No Permitido'),
(4415, 'consultar', 3, 15, 'No Permitido'),
(4416, 'incluir', 3, 15, 'No Permitido'),
(4417, 'modificar', 3, 15, 'No Permitido'),
(4418, 'eliminar', 3, 15, 'No Permitido'),
(4419, 'ingresar', 3, 16, 'No Permitido'),
(4420, 'consultar', 3, 16, 'No Permitido'),
(4421, 'incluir', 3, 16, 'No Permitido'),
(4422, 'modificar', 3, 16, 'No Permitido'),
(4423, 'eliminar', 3, 16, 'No Permitido'),
(4424, 'ingresar', 3, 17, 'No Permitido'),
(4425, 'consultar', 3, 17, 'No Permitido'),
(4426, 'incluir', 3, 17, 'No Permitido'),
(4427, 'modificar', 3, 17, 'No Permitido'),
(4428, 'eliminar', 3, 17, 'No Permitido'),
(4429, 'ingresar', 3, 18, 'No Permitido'),
(4430, 'consultar', 3, 18, 'No Permitido'),
(4431, 'incluir', 3, 18, 'No Permitido'),
(4432, 'modificar', 3, 18, 'No Permitido'),
(4433, 'eliminar', 3, 18, 'No Permitido'),
(4434, 'ingresar', 3, 19, 'No Permitido'),
(4435, 'consultar', 3, 19, 'No Permitido'),
(4436, 'incluir', 3, 19, 'No Permitido'),
(4437, 'modificar', 3, 19, 'No Permitido'),
(4438, 'eliminar', 3, 19, 'No Permitido'),
(4439, 'ingresar', 3, 20, 'No Permitido'),
(4440, 'consultar', 3, 20, 'No Permitido'),
(4441, 'incluir', 3, 20, 'No Permitido'),
(4442, 'modificar', 3, 20, 'No Permitido'),
(4443, 'eliminar', 3, 20, 'No Permitido'),
(4444, 'ingresar', 4, 1, 'No Permitido'),
(4445, 'consultar', 4, 1, 'Permitido'),
(4446, 'incluir', 4, 1, 'Permitido'),
(4447, 'modificar', 4, 1, 'Permitido'),
(4448, 'eliminar', 4, 1, 'Permitido'),
(4449, 'ingresar', 4, 2, 'No Permitido'),
(4450, 'consultar', 4, 2, 'Permitido'),
(4451, 'incluir', 4, 2, 'Permitido'),
(4452, 'modificar', 4, 2, 'Permitido'),
(4453, 'eliminar', 4, 2, 'Permitido'),
(4454, 'ingresar', 4, 3, 'No Permitido'),
(4455, 'consultar', 4, 3, 'Permitido'),
(4456, 'incluir', 4, 3, 'Permitido'),
(4457, 'modificar', 4, 3, 'Permitido'),
(4458, 'eliminar', 4, 3, 'Permitido'),
(4459, 'ingresar', 4, 4, 'No Permitido'),
(4460, 'consultar', 4, 4, 'Permitido'),
(4461, 'incluir', 4, 4, 'Permitido'),
(4462, 'modificar', 4, 4, 'Permitido'),
(4463, 'eliminar', 4, 4, 'Permitido'),
(4464, 'ingresar', 4, 5, 'No Permitido'),
(4465, 'consultar', 4, 5, 'Permitido'),
(4466, 'incluir', 4, 5, 'Permitido'),
(4467, 'modificar', 4, 5, 'Permitido'),
(4468, 'eliminar', 4, 5, 'Permitido'),
(4469, 'ingresar', 4, 6, 'No Permitido'),
(4470, 'consultar', 4, 6, 'Permitido'),
(4471, 'incluir', 4, 6, 'Permitido'),
(4472, 'modificar', 4, 6, 'Permitido'),
(4473, 'eliminar', 4, 6, 'Permitido'),
(4474, 'ingresar', 4, 7, 'No Permitido'),
(4475, 'consultar', 4, 7, 'Permitido'),
(4476, 'incluir', 4, 7, 'Permitido'),
(4477, 'modificar', 4, 7, 'Permitido'),
(4478, 'eliminar', 4, 7, 'Permitido'),
(4479, 'ingresar', 4, 8, 'No Permitido'),
(4480, 'consultar', 4, 8, 'Permitido'),
(4481, 'incluir', 4, 8, 'Permitido'),
(4482, 'modificar', 4, 8, 'Permitido'),
(4483, 'eliminar', 4, 8, 'Permitido'),
(4484, 'ingresar', 4, 9, 'No Permitido'),
(4485, 'consultar', 4, 9, 'Permitido'),
(4486, 'incluir', 4, 9, 'Permitido'),
(4487, 'modificar', 4, 9, 'Permitido'),
(4488, 'eliminar', 4, 9, 'Permitido'),
(4489, 'ingresar', 4, 10, 'No Permitido'),
(4490, 'consultar', 4, 10, 'Permitido'),
(4491, 'incluir', 4, 10, 'Permitido'),
(4492, 'modificar', 4, 10, 'Permitido'),
(4493, 'eliminar', 4, 10, 'Permitido'),
(4494, 'ingresar', 4, 11, 'No Permitido'),
(4495, 'consultar', 4, 11, 'Permitido'),
(4496, 'incluir', 4, 11, 'Permitido'),
(4497, 'modificar', 4, 11, 'Permitido'),
(4498, 'eliminar', 4, 11, 'Permitido'),
(4499, 'ingresar', 4, 12, 'No Permitido'),
(4500, 'consultar', 4, 12, 'Permitido'),
(4501, 'incluir', 4, 12, 'Permitido'),
(4502, 'modificar', 4, 12, 'Permitido'),
(4503, 'eliminar', 4, 12, 'Permitido'),
(4504, 'ingresar', 4, 13, 'No Permitido'),
(4505, 'consultar', 4, 13, 'Permitido'),
(4506, 'incluir', 4, 13, 'Permitido'),
(4507, 'modificar', 4, 13, 'Permitido'),
(4508, 'eliminar', 4, 13, 'Permitido'),
(4509, 'ingresar', 4, 14, 'No Permitido'),
(4510, 'consultar', 4, 14, 'Permitido'),
(4511, 'incluir', 4, 14, 'Permitido'),
(4512, 'modificar', 4, 14, 'Permitido'),
(4513, 'eliminar', 4, 14, 'Permitido'),
(4514, 'ingresar', 4, 15, 'No Permitido'),
(4515, 'consultar', 4, 15, 'Permitido'),
(4516, 'incluir', 4, 15, 'Permitido'),
(4517, 'modificar', 4, 15, 'Permitido'),
(4518, 'eliminar', 4, 15, 'Permitido'),
(4519, 'ingresar', 4, 16, 'No Permitido'),
(4520, 'consultar', 4, 16, 'Permitido'),
(4521, 'incluir', 4, 16, 'Permitido'),
(4522, 'modificar', 4, 16, 'Permitido'),
(4523, 'eliminar', 4, 16, 'Permitido'),
(4524, 'ingresar', 4, 17, 'No Permitido'),
(4525, 'consultar', 4, 17, 'Permitido'),
(4526, 'incluir', 4, 17, 'Permitido'),
(4527, 'modificar', 4, 17, 'Permitido'),
(4528, 'eliminar', 4, 17, 'Permitido'),
(4529, 'ingresar', 4, 18, 'No Permitido'),
(4530, 'consultar', 4, 18, 'Permitido'),
(4531, 'incluir', 4, 18, 'Permitido'),
(4532, 'modificar', 4, 18, 'Permitido'),
(4533, 'eliminar', 4, 18, 'Permitido'),
(4534, 'ingresar', 4, 19, 'No Permitido'),
(4535, 'consultar', 4, 19, 'Permitido'),
(4536, 'incluir', 4, 19, 'Permitido'),
(4537, 'modificar', 4, 19, 'Permitido'),
(4538, 'eliminar', 4, 19, 'Permitido'),
(4539, 'ingresar', 4, 20, 'No Permitido'),
(4540, 'consultar', 4, 20, 'Permitido'),
(4541, 'incluir', 4, 20, 'Permitido'),
(4542, 'modificar', 4, 20, 'Permitido'),
(4543, 'eliminar', 4, 20, 'Permitido');

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
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cedula` varchar(8) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `nombres` varchar(20) DEFAULT NULL,
  `apellidos` varchar(20) DEFAULT NULL,
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
(15, 'Pato', '$2y$10$2OgFNgMxHcDgqjCvfCHsVOYLkc6Qq3QqSalImRPOaP51loMFpFHsa', '5322432', 1, 'diego0510lopez@gmail.com', 'Diego', 'Lopez', '0414-575-3363', 'habilitado');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4544;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
