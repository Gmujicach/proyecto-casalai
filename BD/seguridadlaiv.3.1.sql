-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2025 a las 05:02:50
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
(15, '2025-07-02 01:49:31', 'Acceso al módulo de catálogo', 1, 3),
(16, '2025-07-02 22:28:32', 'Acceso al módulo de catálogo', 1, 9),
(17, '2025-07-02 22:28:46', 'Acceso al módulo de catálogo', 1, 9),
(18, '2025-07-02 22:28:46', 'Agregó producto al carrito: Ca', 1, 9);

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
(32420, 'consultar', 6, 1, 'Permitido'),
(32421, 'incluir', 6, 1, 'Permitido'),
(32422, 'modificar', 6, 1, 'Permitido'),
(32423, 'eliminar', 6, 1, 'Permitido'),
(32424, 'consultar', 6, 2, 'Permitido'),
(32425, 'incluir', 6, 2, 'Permitido'),
(32426, 'modificar', 6, 2, 'Permitido'),
(32427, 'eliminar', 6, 2, 'Permitido'),
(32428, 'consultar', 6, 3, 'Permitido'),
(32429, 'incluir', 6, 3, 'Permitido'),
(32430, 'modificar', 6, 3, 'Permitido'),
(32431, 'eliminar', 6, 3, 'Permitido'),
(32432, 'consultar', 6, 4, 'Permitido'),
(32433, 'incluir', 6, 4, 'Permitido'),
(32434, 'modificar', 6, 4, 'Permitido'),
(32435, 'eliminar', 6, 4, 'Permitido'),
(32436, 'consultar', 6, 5, 'Permitido'),
(32437, 'incluir', 6, 5, 'Permitido'),
(32438, 'modificar', 6, 5, 'Permitido'),
(32439, 'eliminar', 6, 5, 'Permitido'),
(32440, 'consultar', 6, 6, 'Permitido'),
(32441, 'incluir', 6, 6, 'Permitido'),
(32442, 'modificar', 6, 6, 'Permitido'),
(32443, 'eliminar', 6, 6, 'Permitido'),
(32444, 'consultar', 6, 7, 'Permitido'),
(32445, 'incluir', 6, 7, 'Permitido'),
(32446, 'modificar', 6, 7, 'Permitido'),
(32447, 'eliminar', 6, 7, 'Permitido'),
(32448, 'consultar', 6, 8, 'Permitido'),
(32449, 'incluir', 6, 8, 'Permitido'),
(32450, 'modificar', 6, 8, 'Permitido'),
(32451, 'eliminar', 6, 8, 'Permitido'),
(32452, 'consultar', 6, 9, 'Permitido'),
(32453, 'incluir', 6, 9, 'Permitido'),
(32454, 'modificar', 6, 9, 'Permitido'),
(32455, 'eliminar', 6, 9, 'Permitido'),
(32456, 'consultar', 6, 10, 'Permitido'),
(32457, 'incluir', 6, 10, 'Permitido'),
(32458, 'modificar', 6, 10, 'Permitido'),
(32459, 'eliminar', 6, 10, 'Permitido'),
(32460, 'consultar', 6, 14, 'Permitido'),
(32461, 'incluir', 6, 14, 'Permitido'),
(32462, 'modificar', 6, 14, 'Permitido'),
(32463, 'eliminar', 6, 14, 'Permitido'),
(32464, 'consultar', 6, 15, 'Permitido'),
(32465, 'incluir', 6, 15, 'Permitido'),
(32466, 'modificar', 6, 15, 'Permitido'),
(32467, 'eliminar', 6, 15, 'Permitido'),
(32468, 'consultar', 6, 18, 'Permitido'),
(32469, 'incluir', 6, 18, 'Permitido'),
(32470, 'modificar', 6, 18, 'Permitido'),
(32471, 'eliminar', 6, 18, 'Permitido'),
(32472, 'consultar', 1, 1, 'Permitido'),
(32473, 'incluir', 1, 1, 'Permitido'),
(32474, 'modificar', 1, 1, 'Permitido'),
(32475, 'eliminar', 1, 1, 'Permitido'),
(32476, 'consultar', 1, 2, 'Permitido'),
(32477, 'incluir', 1, 2, 'Permitido'),
(32478, 'modificar', 1, 2, 'Permitido'),
(32479, 'eliminar', 1, 2, 'No Permitido'),
(32480, 'consultar', 1, 3, 'Permitido'),
(32481, 'incluir', 1, 3, 'Permitido'),
(32482, 'modificar', 1, 3, 'Permitido'),
(32483, 'eliminar', 1, 3, 'No Permitido'),
(32484, 'consultar', 1, 4, 'Permitido'),
(32485, 'incluir', 1, 4, 'Permitido'),
(32486, 'modificar', 1, 4, 'Permitido'),
(32487, 'eliminar', 1, 4, 'Permitido'),
(32488, 'consultar', 1, 5, 'Permitido'),
(32489, 'incluir', 1, 5, 'Permitido'),
(32490, 'modificar', 1, 5, 'Permitido'),
(32491, 'eliminar', 1, 5, 'Permitido'),
(32492, 'consultar', 1, 6, 'Permitido'),
(32493, 'incluir', 1, 6, 'Permitido'),
(32494, 'modificar', 1, 6, 'Permitido'),
(32495, 'eliminar', 1, 6, 'Permitido'),
(32496, 'consultar', 1, 7, 'Permitido'),
(32497, 'incluir', 1, 7, 'Permitido'),
(32498, 'modificar', 1, 7, 'Permitido'),
(32499, 'eliminar', 1, 7, 'Permitido'),
(32500, 'consultar', 1, 8, 'Permitido'),
(32501, 'incluir', 1, 8, 'Permitido'),
(32502, 'modificar', 1, 8, 'Permitido'),
(32503, 'eliminar', 1, 8, 'Permitido'),
(32504, 'consultar', 1, 9, 'Permitido'),
(32505, 'incluir', 1, 9, 'Permitido'),
(32506, 'modificar', 1, 9, 'Permitido'),
(32507, 'eliminar', 1, 9, 'Permitido'),
(32508, 'consultar', 1, 10, 'No Permitido'),
(32509, 'incluir', 1, 10, 'No Permitido'),
(32510, 'modificar', 1, 10, 'No Permitido'),
(32511, 'eliminar', 1, 10, 'No Permitido'),
(32512, 'consultar', 1, 14, 'No Permitido'),
(32513, 'incluir', 1, 14, 'No Permitido'),
(32514, 'modificar', 1, 14, 'No Permitido'),
(32515, 'eliminar', 1, 14, 'No Permitido'),
(32516, 'consultar', 1, 15, 'Permitido'),
(32517, 'incluir', 1, 15, 'Permitido'),
(32518, 'modificar', 1, 15, 'Permitido'),
(32519, 'eliminar', 1, 15, 'Permitido'),
(32520, 'consultar', 1, 18, 'Permitido'),
(32521, 'incluir', 1, 18, 'Permitido'),
(32522, 'modificar', 1, 18, 'Permitido'),
(32523, 'eliminar', 1, 18, 'Permitido'),
(32524, 'consultar', 2, 1, 'No Permitido'),
(32525, 'incluir', 2, 1, 'No Permitido'),
(32526, 'modificar', 2, 1, 'No Permitido'),
(32527, 'eliminar', 2, 1, 'No Permitido'),
(32528, 'consultar', 2, 2, 'Permitido'),
(32529, 'incluir', 2, 2, 'Permitido'),
(32530, 'modificar', 2, 2, 'Permitido'),
(32531, 'eliminar', 2, 2, 'Permitido'),
(32532, 'consultar', 2, 3, 'Permitido'),
(32533, 'incluir', 2, 3, 'Permitido'),
(32534, 'modificar', 2, 3, 'Permitido'),
(32535, 'eliminar', 2, 3, 'Permitido'),
(32536, 'consultar', 2, 4, 'Permitido'),
(32537, 'incluir', 2, 4, 'Permitido'),
(32538, 'modificar', 2, 4, 'Permitido'),
(32539, 'eliminar', 2, 4, 'Permitido'),
(32540, 'consultar', 2, 5, 'Permitido'),
(32541, 'incluir', 2, 5, 'Permitido'),
(32542, 'modificar', 2, 5, 'Permitido'),
(32543, 'eliminar', 2, 5, 'Permitido'),
(32544, 'consultar', 2, 6, 'Permitido'),
(32545, 'incluir', 2, 6, 'Permitido'),
(32546, 'modificar', 2, 6, 'Permitido'),
(32547, 'eliminar', 2, 6, 'Permitido'),
(32548, 'consultar', 2, 7, 'Permitido'),
(32549, 'incluir', 2, 7, 'Permitido'),
(32550, 'modificar', 2, 7, 'Permitido'),
(32551, 'eliminar', 2, 7, 'Permitido'),
(32552, 'consultar', 2, 8, 'No Permitido'),
(32553, 'incluir', 2, 8, 'No Permitido'),
(32554, 'modificar', 2, 8, 'No Permitido'),
(32555, 'eliminar', 2, 8, 'No Permitido'),
(32556, 'consultar', 2, 9, 'Permitido'),
(32557, 'incluir', 2, 9, 'Permitido'),
(32558, 'modificar', 2, 9, 'Permitido'),
(32559, 'eliminar', 2, 9, 'Permitido'),
(32560, 'consultar', 2, 10, 'Permitido'),
(32561, 'incluir', 2, 10, 'Permitido'),
(32562, 'modificar', 2, 10, 'Permitido'),
(32563, 'eliminar', 2, 10, 'Permitido'),
(32564, 'consultar', 2, 14, 'Permitido'),
(32565, 'incluir', 2, 14, 'Permitido'),
(32566, 'modificar', 2, 14, 'Permitido'),
(32567, 'eliminar', 2, 14, 'Permitido'),
(32568, 'consultar', 2, 15, 'Permitido'),
(32569, 'incluir', 2, 15, 'No Permitido'),
(32570, 'modificar', 2, 15, 'No Permitido'),
(32571, 'eliminar', 2, 15, 'No Permitido'),
(32572, 'consultar', 2, 18, 'No Permitido'),
(32573, 'incluir', 2, 18, 'No Permitido'),
(32574, 'modificar', 2, 18, 'No Permitido'),
(32575, 'eliminar', 2, 18, 'No Permitido'),
(32576, 'consultar', 3, 1, 'No Permitido'),
(32577, 'incluir', 3, 1, 'No Permitido'),
(32578, 'modificar', 3, 1, 'No Permitido'),
(32579, 'eliminar', 3, 1, 'No Permitido'),
(32580, 'consultar', 3, 2, 'No Permitido'),
(32581, 'incluir', 3, 2, 'No Permitido'),
(32582, 'modificar', 3, 2, 'No Permitido'),
(32583, 'eliminar', 3, 2, 'No Permitido'),
(32584, 'consultar', 3, 3, 'No Permitido'),
(32585, 'incluir', 3, 3, 'No Permitido'),
(32586, 'modificar', 3, 3, 'No Permitido'),
(32587, 'eliminar', 3, 3, 'No Permitido'),
(32588, 'consultar', 3, 4, 'No Permitido'),
(32589, 'incluir', 3, 4, 'No Permitido'),
(32590, 'modificar', 3, 4, 'No Permitido'),
(32591, 'eliminar', 3, 4, 'No Permitido'),
(32592, 'consultar', 3, 5, 'No Permitido'),
(32593, 'incluir', 3, 5, 'No Permitido'),
(32594, 'modificar', 3, 5, 'No Permitido'),
(32595, 'eliminar', 3, 5, 'No Permitido'),
(32596, 'consultar', 3, 6, 'No Permitido'),
(32597, 'incluir', 3, 6, 'No Permitido'),
(32598, 'modificar', 3, 6, 'No Permitido'),
(32599, 'eliminar', 3, 6, 'No Permitido'),
(32600, 'consultar', 3, 7, 'No Permitido'),
(32601, 'incluir', 3, 7, 'No Permitido'),
(32602, 'modificar', 3, 7, 'No Permitido'),
(32603, 'eliminar', 3, 7, 'No Permitido'),
(32604, 'consultar', 3, 8, 'No Permitido'),
(32605, 'incluir', 3, 8, 'No Permitido'),
(32606, 'modificar', 3, 8, 'No Permitido'),
(32607, 'eliminar', 3, 8, 'No Permitido'),
(32608, 'consultar', 3, 9, 'No Permitido'),
(32609, 'incluir', 3, 9, 'No Permitido'),
(32610, 'modificar', 3, 9, 'No Permitido'),
(32611, 'eliminar', 3, 9, 'No Permitido'),
(32612, 'consultar', 3, 10, 'Permitido'),
(32613, 'incluir', 3, 10, 'No Permitido'),
(32614, 'modificar', 3, 10, 'No Permitido'),
(32615, 'eliminar', 3, 10, 'No Permitido'),
(32616, 'consultar', 3, 14, 'Permitido'),
(32617, 'incluir', 3, 14, 'Permitido'),
(32618, 'modificar', 3, 14, 'Permitido'),
(32619, 'eliminar', 3, 14, 'No Permitido'),
(32620, 'consultar', 3, 15, 'No Permitido'),
(32621, 'incluir', 3, 15, 'No Permitido'),
(32622, 'modificar', 3, 15, 'No Permitido'),
(32623, 'eliminar', 3, 15, 'No Permitido'),
(32624, 'consultar', 3, 18, 'No Permitido'),
(32625, 'incluir', 3, 18, 'No Permitido'),
(32626, 'modificar', 3, 18, 'No Permitido'),
(32627, 'eliminar', 3, 18, 'No Permitido'),
(32628, 'consultar', 4, 1, 'Permitido'),
(32629, 'incluir', 4, 1, 'Permitido'),
(32630, 'modificar', 4, 1, 'Permitido'),
(32631, 'eliminar', 4, 1, 'Permitido'),
(32632, 'consultar', 4, 2, 'Permitido'),
(32633, 'incluir', 4, 2, 'Permitido'),
(32634, 'modificar', 4, 2, 'Permitido'),
(32635, 'eliminar', 4, 2, 'Permitido'),
(32636, 'consultar', 4, 3, 'Permitido'),
(32637, 'incluir', 4, 3, 'Permitido'),
(32638, 'modificar', 4, 3, 'Permitido'),
(32639, 'eliminar', 4, 3, 'Permitido'),
(32640, 'consultar', 4, 4, 'Permitido'),
(32641, 'incluir', 4, 4, 'Permitido'),
(32642, 'modificar', 4, 4, 'Permitido'),
(32643, 'eliminar', 4, 4, 'Permitido'),
(32644, 'consultar', 4, 5, 'Permitido'),
(32645, 'incluir', 4, 5, 'Permitido'),
(32646, 'modificar', 4, 5, 'Permitido'),
(32647, 'eliminar', 4, 5, 'Permitido'),
(32648, 'consultar', 4, 6, 'Permitido'),
(32649, 'incluir', 4, 6, 'Permitido'),
(32650, 'modificar', 4, 6, 'Permitido'),
(32651, 'eliminar', 4, 6, 'Permitido'),
(32652, 'consultar', 4, 7, 'Permitido'),
(32653, 'incluir', 4, 7, 'Permitido'),
(32654, 'modificar', 4, 7, 'Permitido'),
(32655, 'eliminar', 4, 7, 'Permitido'),
(32656, 'consultar', 4, 8, 'Permitido'),
(32657, 'incluir', 4, 8, 'Permitido'),
(32658, 'modificar', 4, 8, 'Permitido'),
(32659, 'eliminar', 4, 8, 'Permitido'),
(32660, 'consultar', 4, 9, 'Permitido'),
(32661, 'incluir', 4, 9, 'Permitido'),
(32662, 'modificar', 4, 9, 'Permitido'),
(32663, 'eliminar', 4, 9, 'Permitido'),
(32664, 'consultar', 4, 10, 'Permitido'),
(32665, 'incluir', 4, 10, 'Permitido'),
(32666, 'modificar', 4, 10, 'Permitido'),
(32667, 'eliminar', 4, 10, 'Permitido'),
(32668, 'consultar', 4, 14, 'Permitido'),
(32669, 'incluir', 4, 14, 'Permitido'),
(32670, 'modificar', 4, 14, 'Permitido'),
(32671, 'eliminar', 4, 14, 'Permitido'),
(32672, 'consultar', 4, 15, 'Permitido'),
(32673, 'incluir', 4, 15, 'Permitido'),
(32674, 'modificar', 4, 15, 'Permitido'),
(32675, 'eliminar', 4, 15, 'Permitido'),
(32676, 'consultar', 4, 18, 'Permitido'),
(32677, 'incluir', 4, 18, 'Permitido'),
(32678, 'modificar', 4, 18, 'Permitido'),
(32679, 'eliminar', 4, 18, 'Permitido');

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
(5, 'SuperUsu', '$2y$10$w7nQw5p6Qw6nQw5p6Qw6nOQw5p6Qw6nQw5p6Qw6nQw5p6Qw6nQw6n', 6, 'ejemplo@gmail.com', 'Diego Andres', 'Lopez Vivas', '0414-575-3363', 'habilitado'),
(7, 'Ben10', '$2y$10$xYFm.SoVzcTO1Z8VNeoP.eVpI.s6YZ54sZqoN20ogR/n7uTHNf0yG', 1, 'ggy@gmail.com', 'Pa', 'nose', '0414-000-0000', 'habilitado'),
(8, 'DiegoS', '$2y$10$YNp4Po6bWqvBhXD2W4zm6OZk6i.l1QHVzzZLFrn8Y7gQ4.NFU89TW', 1, 'ggy@gmail.com', 'Diego', 'Compa Vendedor', '0414-575-3363', 'habilitado'),
(9, 'CasaLai', '$2y$10$KXRg/AUD.9Y7KubEvzy71e5dDR1GvGNy23XegAYwLjYWOBdcxzqx2', 6, 'diego0510lopez@gmail.com', 'Casa', 'Lai', '0414-575-3363', 'habilitado');

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32680;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
