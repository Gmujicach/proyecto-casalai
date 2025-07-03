-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2025 a las 02:37:06
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
  `fecha_hora` datetime NOT NULL,
  `accion` varchar(30) NOT NULL,
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
(15, '2025-07-02 01:49:31', 'Acceso al módulo de catálogo', 1, 3);

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
(14, 'Ordenes de despacho'),
(15, 'Cuentas bancarias'),
(18, 'Roles');

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
(31952, 'consultar', 1, 1, 'Permitido'),
(31953, 'incluir', 1, 1, 'Permitido'),
(31954, 'modificar', 1, 1, 'Permitido'),
(31955, 'eliminar', 1, 1, 'Permitido'),
(31956, 'consultar', 1, 2, 'Permitido'),
(31957, 'incluir', 1, 2, 'Permitido'),
(31958, 'modificar', 1, 2, 'Permitido'),
(31959, 'eliminar', 1, 2, 'No Permitido'),
(31960, 'consultar', 1, 3, 'Permitido'),
(31961, 'incluir', 1, 3, 'Permitido'),
(31962, 'modificar', 1, 3, 'Permitido'),
(31963, 'eliminar', 1, 3, 'No Permitido'),
(31964, 'consultar', 1, 4, 'Permitido'),
(31965, 'incluir', 1, 4, 'Permitido'),
(31966, 'modificar', 1, 4, 'Permitido'),
(31967, 'eliminar', 1, 4, 'Permitido'),
(31968, 'consultar', 1, 5, 'Permitido'),
(31969, 'incluir', 1, 5, 'Permitido'),
(31970, 'modificar', 1, 5, 'Permitido'),
(31971, 'eliminar', 1, 5, 'Permitido'),
(31972, 'consultar', 1, 6, 'Permitido'),
(31973, 'incluir', 1, 6, 'Permitido'),
(31974, 'modificar', 1, 6, 'Permitido'),
(31975, 'eliminar', 1, 6, 'Permitido'),
(31976, 'consultar', 1, 7, 'Permitido'),
(31977, 'incluir', 1, 7, 'Permitido'),
(31978, 'modificar', 1, 7, 'Permitido'),
(31979, 'eliminar', 1, 7, 'Permitido'),
(31980, 'consultar', 1, 8, 'Permitido'),
(31981, 'incluir', 1, 8, 'Permitido'),
(31982, 'modificar', 1, 8, 'Permitido'),
(31983, 'eliminar', 1, 8, 'Permitido'),
(31984, 'consultar', 1, 9, 'Permitido'),
(31985, 'incluir', 1, 9, 'Permitido'),
(31986, 'modificar', 1, 9, 'Permitido'),
(31987, 'eliminar', 1, 9, 'Permitido'),
(31988, 'consultar', 1, 10, 'No Permitido'),
(31989, 'incluir', 1, 10, 'No Permitido'),
(31990, 'modificar', 1, 10, 'No Permitido'),
(31991, 'eliminar', 1, 10, 'No Permitido'),
(31992, 'consultar', 1, 14, 'No Permitido'),
(31993, 'incluir', 1, 14, 'No Permitido'),
(31994, 'modificar', 1, 14, 'No Permitido'),
(31995, 'eliminar', 1, 14, 'No Permitido'),
(31996, 'consultar', 1, 15, 'Permitido'),
(31997, 'incluir', 1, 15, 'Permitido'),
(31998, 'modificar', 1, 15, 'Permitido'),
(31999, 'eliminar', 1, 15, 'Permitido'),
(32000, 'consultar', 1, 18, 'Permitido'),
(32001, 'incluir', 1, 18, 'Permitido'),
(32002, 'modificar', 1, 18, 'Permitido'),
(32003, 'eliminar', 1, 18, 'Permitido'),
(32004, 'consultar', 2, 1, 'No Permitido'),
(32005, 'incluir', 2, 1, 'No Permitido'),
(32006, 'modificar', 2, 1, 'No Permitido'),
(32007, 'eliminar', 2, 1, 'No Permitido'),
(32008, 'consultar', 2, 2, 'Permitido'),
(32009, 'incluir', 2, 2, 'Permitido'),
(32010, 'modificar', 2, 2, 'Permitido'),
(32011, 'eliminar', 2, 2, 'Permitido'),
(32012, 'consultar', 2, 3, 'Permitido'),
(32013, 'incluir', 2, 3, 'Permitido'),
(32014, 'modificar', 2, 3, 'Permitido'),
(32015, 'eliminar', 2, 3, 'Permitido'),
(32016, 'consultar', 2, 4, 'Permitido'),
(32017, 'incluir', 2, 4, 'Permitido'),
(32018, 'modificar', 2, 4, 'Permitido'),
(32019, 'eliminar', 2, 4, 'Permitido'),
(32020, 'consultar', 2, 5, 'Permitido'),
(32021, 'incluir', 2, 5, 'Permitido'),
(32022, 'modificar', 2, 5, 'Permitido'),
(32023, 'eliminar', 2, 5, 'Permitido'),
(32024, 'consultar', 2, 6, 'Permitido'),
(32025, 'incluir', 2, 6, 'Permitido'),
(32026, 'modificar', 2, 6, 'Permitido'),
(32027, 'eliminar', 2, 6, 'Permitido'),
(32028, 'consultar', 2, 7, 'Permitido'),
(32029, 'incluir', 2, 7, 'Permitido'),
(32030, 'modificar', 2, 7, 'Permitido'),
(32031, 'eliminar', 2, 7, 'Permitido'),
(32032, 'consultar', 2, 8, 'No Permitido'),
(32033, 'incluir', 2, 8, 'No Permitido'),
(32034, 'modificar', 2, 8, 'No Permitido'),
(32035, 'eliminar', 2, 8, 'No Permitido'),
(32036, 'consultar', 2, 9, 'Permitido'),
(32037, 'incluir', 2, 9, 'Permitido'),
(32038, 'modificar', 2, 9, 'Permitido'),
(32039, 'eliminar', 2, 9, 'Permitido'),
(32040, 'consultar', 2, 10, 'Permitido'),
(32041, 'incluir', 2, 10, 'Permitido'),
(32042, 'modificar', 2, 10, 'Permitido'),
(32043, 'eliminar', 2, 10, 'Permitido'),
(32044, 'consultar', 2, 14, 'Permitido'),
(32045, 'incluir', 2, 14, 'Permitido'),
(32046, 'modificar', 2, 14, 'Permitido'),
(32047, 'eliminar', 2, 14, 'Permitido'),
(32048, 'consultar', 2, 15, 'Permitido'),
(32049, 'incluir', 2, 15, 'No Permitido'),
(32050, 'modificar', 2, 15, 'No Permitido'),
(32051, 'eliminar', 2, 15, 'No Permitido'),
(32052, 'consultar', 2, 18, 'No Permitido'),
(32053, 'incluir', 2, 18, 'No Permitido'),
(32054, 'modificar', 2, 18, 'No Permitido'),
(32055, 'eliminar', 2, 18, 'No Permitido'),
(32056, 'consultar', 3, 1, 'No Permitido'),
(32057, 'incluir', 3, 1, 'No Permitido'),
(32058, 'modificar', 3, 1, 'No Permitido'),
(32059, 'eliminar', 3, 1, 'No Permitido'),
(32060, 'consultar', 3, 2, 'No Permitido'),
(32061, 'incluir', 3, 2, 'No Permitido'),
(32062, 'modificar', 3, 2, 'No Permitido'),
(32063, 'eliminar', 3, 2, 'No Permitido'),
(32064, 'consultar', 3, 3, 'No Permitido'),
(32065, 'incluir', 3, 3, 'No Permitido'),
(32066, 'modificar', 3, 3, 'No Permitido'),
(32067, 'eliminar', 3, 3, 'No Permitido'),
(32068, 'consultar', 3, 4, 'No Permitido'),
(32069, 'incluir', 3, 4, 'No Permitido'),
(32070, 'modificar', 3, 4, 'No Permitido'),
(32071, 'eliminar', 3, 4, 'No Permitido'),
(32072, 'consultar', 3, 5, 'No Permitido'),
(32073, 'incluir', 3, 5, 'No Permitido'),
(32074, 'modificar', 3, 5, 'No Permitido'),
(32075, 'eliminar', 3, 5, 'No Permitido'),
(32076, 'consultar', 3, 6, 'No Permitido'),
(32077, 'incluir', 3, 6, 'No Permitido'),
(32078, 'modificar', 3, 6, 'No Permitido'),
(32079, 'eliminar', 3, 6, 'No Permitido'),
(32080, 'consultar', 3, 7, 'No Permitido'),
(32081, 'incluir', 3, 7, 'No Permitido'),
(32082, 'modificar', 3, 7, 'No Permitido'),
(32083, 'eliminar', 3, 7, 'No Permitido'),
(32084, 'consultar', 3, 8, 'No Permitido'),
(32085, 'incluir', 3, 8, 'No Permitido'),
(32086, 'modificar', 3, 8, 'No Permitido'),
(32087, 'eliminar', 3, 8, 'No Permitido'),
(32088, 'consultar', 3, 9, 'No Permitido'),
(32089, 'incluir', 3, 9, 'No Permitido'),
(32090, 'modificar', 3, 9, 'No Permitido'),
(32091, 'eliminar', 3, 9, 'No Permitido'),
(32092, 'consultar', 3, 10, 'Permitido'),
(32093, 'incluir', 3, 10, 'No Permitido'),
(32094, 'modificar', 3, 10, 'No Permitido'),
(32095, 'eliminar', 3, 10, 'No Permitido'),
(32096, 'consultar', 3, 14, 'Permitido'),
(32097, 'incluir', 3, 14, 'Permitido'),
(32098, 'modificar', 3, 14, 'Permitido'),
(32099, 'eliminar', 3, 14, 'No Permitido'),
(32100, 'consultar', 3, 15, 'No Permitido'),
(32101, 'incluir', 3, 15, 'No Permitido'),
(32102, 'modificar', 3, 15, 'No Permitido'),
(32103, 'eliminar', 3, 15, 'No Permitido'),
(32104, 'consultar', 3, 18, 'No Permitido'),
(32105, 'incluir', 3, 18, 'No Permitido'),
(32106, 'modificar', 3, 18, 'No Permitido'),
(32107, 'eliminar', 3, 18, 'No Permitido'),
(32108, 'consultar', 4, 1, 'Permitido'),
(32109, 'incluir', 4, 1, 'Permitido'),
(32110, 'modificar', 4, 1, 'Permitido'),
(32111, 'eliminar', 4, 1, 'Permitido'),
(32112, 'consultar', 4, 2, 'Permitido'),
(32113, 'incluir', 4, 2, 'Permitido'),
(32114, 'modificar', 4, 2, 'Permitido'),
(32115, 'eliminar', 4, 2, 'Permitido'),
(32116, 'consultar', 4, 3, 'Permitido'),
(32117, 'incluir', 4, 3, 'Permitido'),
(32118, 'modificar', 4, 3, 'Permitido'),
(32119, 'eliminar', 4, 3, 'Permitido'),
(32120, 'consultar', 4, 4, 'Permitido'),
(32121, 'incluir', 4, 4, 'Permitido'),
(32122, 'modificar', 4, 4, 'Permitido'),
(32123, 'eliminar', 4, 4, 'Permitido'),
(32124, 'consultar', 4, 5, 'Permitido'),
(32125, 'incluir', 4, 5, 'Permitido'),
(32126, 'modificar', 4, 5, 'Permitido'),
(32127, 'eliminar', 4, 5, 'Permitido'),
(32128, 'consultar', 4, 6, 'Permitido'),
(32129, 'incluir', 4, 6, 'Permitido'),
(32130, 'modificar', 4, 6, 'Permitido'),
(32131, 'eliminar', 4, 6, 'Permitido'),
(32132, 'consultar', 4, 7, 'Permitido'),
(32133, 'incluir', 4, 7, 'Permitido'),
(32134, 'modificar', 4, 7, 'Permitido'),
(32135, 'eliminar', 4, 7, 'Permitido'),
(32136, 'consultar', 4, 8, 'Permitido'),
(32137, 'incluir', 4, 8, 'Permitido'),
(32138, 'modificar', 4, 8, 'Permitido'),
(32139, 'eliminar', 4, 8, 'Permitido'),
(32140, 'consultar', 4, 9, 'Permitido'),
(32141, 'incluir', 4, 9, 'Permitido'),
(32142, 'modificar', 4, 9, 'Permitido'),
(32143, 'eliminar', 4, 9, 'Permitido'),
(32144, 'consultar', 4, 10, 'Permitido'),
(32145, 'incluir', 4, 10, 'Permitido'),
(32146, 'modificar', 4, 10, 'Permitido'),
(32147, 'eliminar', 4, 10, 'Permitido'),
(32148, 'consultar', 4, 14, 'Permitido'),
(32149, 'incluir', 4, 14, 'Permitido'),
(32150, 'modificar', 4, 14, 'Permitido'),
(32151, 'eliminar', 4, 14, 'Permitido'),
(32152, 'consultar', 4, 15, 'Permitido'),
(32153, 'incluir', 4, 15, 'Permitido'),
(32154, 'modificar', 4, 15, 'Permitido'),
(32155, 'eliminar', 4, 15, 'Permitido'),
(32156, 'consultar', 4, 18, 'Permitido'),
(32157, 'incluir', 4, 18, 'Permitido'),
(32158, 'modificar', 4, 18, 'Permitido'),
(32159, 'eliminar', 4, 18, 'Permitido'),
(32160, 'consultar', 6, 1, 'No Permitido'),
(32161, 'incluir', 6, 1, 'No Permitido'),
(32162, 'modificar', 6, 1, 'No Permitido'),
(32163, 'eliminar', 6, 1, 'No Permitido'),
(32164, 'consultar', 6, 2, 'No Permitido'),
(32165, 'incluir', 6, 2, 'No Permitido'),
(32166, 'modificar', 6, 2, 'No Permitido'),
(32167, 'eliminar', 6, 2, 'No Permitido'),
(32168, 'consultar', 6, 3, 'No Permitido'),
(32169, 'incluir', 6, 3, 'No Permitido'),
(32170, 'modificar', 6, 3, 'No Permitido'),
(32171, 'eliminar', 6, 3, 'No Permitido'),
(32172, 'consultar', 6, 4, 'No Permitido'),
(32173, 'incluir', 6, 4, 'No Permitido'),
(32174, 'modificar', 6, 4, 'No Permitido'),
(32175, 'eliminar', 6, 4, 'No Permitido'),
(32176, 'consultar', 6, 5, 'No Permitido'),
(32177, 'incluir', 6, 5, 'No Permitido'),
(32178, 'modificar', 6, 5, 'No Permitido'),
(32179, 'eliminar', 6, 5, 'No Permitido'),
(32180, 'consultar', 6, 6, 'No Permitido'),
(32181, 'incluir', 6, 6, 'No Permitido'),
(32182, 'modificar', 6, 6, 'No Permitido'),
(32183, 'eliminar', 6, 6, 'No Permitido'),
(32184, 'consultar', 6, 7, 'No Permitido'),
(32185, 'incluir', 6, 7, 'No Permitido'),
(32186, 'modificar', 6, 7, 'No Permitido'),
(32187, 'eliminar', 6, 7, 'No Permitido'),
(32188, 'consultar', 6, 8, 'No Permitido'),
(32189, 'incluir', 6, 8, 'No Permitido'),
(32190, 'modificar', 6, 8, 'No Permitido'),
(32191, 'eliminar', 6, 8, 'No Permitido'),
(32192, 'consultar', 6, 9, 'No Permitido'),
(32193, 'incluir', 6, 9, 'No Permitido'),
(32194, 'modificar', 6, 9, 'No Permitido'),
(32195, 'eliminar', 6, 9, 'No Permitido'),
(32196, 'consultar', 6, 10, 'No Permitido'),
(32197, 'incluir', 6, 10, 'No Permitido'),
(32198, 'modificar', 6, 10, 'No Permitido'),
(32199, 'eliminar', 6, 10, 'No Permitido'),
(32200, 'consultar', 6, 14, 'No Permitido'),
(32201, 'incluir', 6, 14, 'No Permitido'),
(32202, 'modificar', 6, 14, 'No Permitido'),
(32203, 'eliminar', 6, 14, 'No Permitido'),
(32204, 'consultar', 6, 15, 'No Permitido'),
(32205, 'incluir', 6, 15, 'No Permitido'),
(32206, 'modificar', 6, 15, 'No Permitido'),
(32207, 'eliminar', 6, 15, 'No Permitido'),
(32208, 'consultar', 6, 18, 'No Permitido'),
(32209, 'incluir', 6, 18, 'No Permitido'),
(32210, 'modificar', 6, 18, 'No Permitido'),
(32211, 'eliminar', 6, 18, 'No Permitido');

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
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
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

INSERT INTO `tbl_usuarios` (`id_usuario`, `username`, `password`, `id_rol`, `correo`, `nombres`, `apellidos`, `telefono`, `estatus`) VALUES
(3, 'Diego', '$2y$10$aVnYPs5gz8QcihC.PT2eQeqg/2B0Vk4TQlPl2hVKz3vbnhoRQVdnW', 1, 'ejemplo@gmail.com', 'Diego', 'Compa', '0414-575-3363', 'habilitado'),
(4, 'Simon', '$2y$10$bJfY45blf5qV66WzNf5.OOTPFjgCEePpBz07GQUc3B0qlKMNzJd8W', 3, 'ejemplo@gmail.com', 'Simon Freitez', 'Cliente', '0414-000-0000', 'habilitado'),
(5, 'SuperUsu', 'CasaLai.CA', 6, 'ejemplo@gmail.com', 'Diego Andres', 'Lopez Vivas', '0414-575-3363', 'habilitado'),
(7, 'Ben10', '$2y$10$xYFm.SoVzcTO1Z8VNeoP.eVpI.s6YZ54sZqoN20ogR/n7uTHNf0yG', 2, 'ggy@gmail.com', 'Pa', 'nose', '0414-000-0000', 'habilitado'),
(8, 'DiegoS', '$2y$10$YNp4Po6bWqvBhXD2W4zm6OZk6i.l1QHVzzZLFrn8Y7gQ4.NFU89TW', 1, 'ggy@gmail.com', 'Diego', 'Compa Vendedor', '0414-575-3363', 'habilitado');

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32212;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
