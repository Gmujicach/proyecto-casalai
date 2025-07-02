-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2025 a las 08:42:26
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
(30532, 'consultar', 1, 1, 'Permitido'),
(30533, 'incluir', 1, 1, 'Permitido'),
(30534, 'modificar', 1, 1, 'Permitido'),
(30535, 'eliminar', 1, 1, 'Permitido'),
(30536, 'consultar', 1, 2, 'Permitido'),
(30537, 'incluir', 1, 2, 'Permitido'),
(30538, 'modificar', 1, 2, 'Permitido'),
(30539, 'eliminar', 1, 2, 'Permitido'),
(30540, 'consultar', 1, 3, 'Permitido'),
(30541, 'incluir', 1, 3, 'Permitido'),
(30542, 'modificar', 1, 3, 'Permitido'),
(30543, 'eliminar', 1, 3, 'Permitido'),
(30544, 'consultar', 1, 4, 'Permitido'),
(30545, 'incluir', 1, 4, 'Permitido'),
(30546, 'modificar', 1, 4, 'Permitido'),
(30547, 'eliminar', 1, 4, 'Permitido'),
(30548, 'consultar', 1, 5, 'Permitido'),
(30549, 'incluir', 1, 5, 'Permitido'),
(30550, 'modificar', 1, 5, 'Permitido'),
(30551, 'eliminar', 1, 5, 'Permitido'),
(30552, 'consultar', 1, 6, 'Permitido'),
(30553, 'incluir', 1, 6, 'Permitido'),
(30554, 'modificar', 1, 6, 'Permitido'),
(30555, 'eliminar', 1, 6, 'Permitido'),
(30556, 'consultar', 1, 7, 'Permitido'),
(30557, 'incluir', 1, 7, 'Permitido'),
(30558, 'modificar', 1, 7, 'Permitido'),
(30559, 'eliminar', 1, 7, 'Permitido'),
(30560, 'consultar', 1, 8, 'Permitido'),
(30561, 'incluir', 1, 8, 'Permitido'),
(30562, 'modificar', 1, 8, 'Permitido'),
(30563, 'eliminar', 1, 8, 'Permitido'),
(30564, 'consultar', 1, 9, 'Permitido'),
(30565, 'incluir', 1, 9, 'Permitido'),
(30566, 'modificar', 1, 9, 'Permitido'),
(30567, 'eliminar', 1, 9, 'Permitido'),
(30568, 'consultar', 1, 10, 'Permitido'),
(30569, 'incluir', 1, 10, 'Permitido'),
(30570, 'modificar', 1, 10, 'Permitido'),
(30571, 'eliminar', 1, 10, 'Permitido'),
(30584, 'consultar', 1, 14, 'Permitido'),
(30585, 'incluir', 1, 14, 'Permitido'),
(30586, 'modificar', 1, 14, 'No Permitido'),
(30587, 'eliminar', 1, 14, 'Permitido'),
(30588, 'consultar', 1, 15, 'Permitido'),
(30589, 'incluir', 1, 15, 'Permitido'),
(30590, 'modificar', 1, 15, 'Permitido'),
(30591, 'eliminar', 1, 15, 'Permitido'),
(30600, 'consultar', 1, 18, 'Permitido'),
(30601, 'incluir', 1, 18, 'No Permitido'),
(30602, 'modificar', 1, 18, 'No Permitido'),
(30603, 'eliminar', 1, 18, 'Permitido'),
(30608, 'consultar', 2, 1, 'No Permitido'),
(30609, 'incluir', 2, 1, 'No Permitido'),
(30610, 'modificar', 2, 1, 'No Permitido'),
(30611, 'eliminar', 2, 1, 'No Permitido'),
(30612, 'consultar', 2, 2, 'Permitido'),
(30613, 'incluir', 2, 2, 'Permitido'),
(30614, 'modificar', 2, 2, 'Permitido'),
(30615, 'eliminar', 2, 2, 'Permitido'),
(30616, 'consultar', 2, 3, 'Permitido'),
(30617, 'incluir', 2, 3, 'Permitido'),
(30618, 'modificar', 2, 3, 'Permitido'),
(30619, 'eliminar', 2, 3, 'Permitido'),
(30620, 'consultar', 2, 4, 'Permitido'),
(30621, 'incluir', 2, 4, 'Permitido'),
(30622, 'modificar', 2, 4, 'Permitido'),
(30623, 'eliminar', 2, 4, 'Permitido'),
(30624, 'consultar', 2, 5, 'Permitido'),
(30625, 'incluir', 2, 5, 'Permitido'),
(30626, 'modificar', 2, 5, 'Permitido'),
(30627, 'eliminar', 2, 5, 'Permitido'),
(30628, 'consultar', 2, 6, 'Permitido'),
(30629, 'incluir', 2, 6, 'Permitido'),
(30630, 'modificar', 2, 6, 'Permitido'),
(30631, 'eliminar', 2, 6, 'Permitido'),
(30632, 'consultar', 2, 7, 'Permitido'),
(30633, 'incluir', 2, 7, 'Permitido'),
(30634, 'modificar', 2, 7, 'Permitido'),
(30635, 'eliminar', 2, 7, 'Permitido'),
(30636, 'consultar', 2, 8, 'No Permitido'),
(30637, 'incluir', 2, 8, 'No Permitido'),
(30638, 'modificar', 2, 8, 'No Permitido'),
(30639, 'eliminar', 2, 8, 'No Permitido'),
(30640, 'consultar', 2, 9, 'Permitido'),
(30641, 'incluir', 2, 9, 'Permitido'),
(30642, 'modificar', 2, 9, 'Permitido'),
(30643, 'eliminar', 2, 9, 'Permitido'),
(30644, 'consultar', 2, 10, 'Permitido'),
(30645, 'incluir', 2, 10, 'Permitido'),
(30646, 'modificar', 2, 10, 'Permitido'),
(30647, 'eliminar', 2, 10, 'Permitido'),
(30660, 'consultar', 2, 14, 'Permitido'),
(30661, 'incluir', 2, 14, 'Permitido'),
(30662, 'modificar', 2, 14, 'Permitido'),
(30663, 'eliminar', 2, 14, 'Permitido'),
(30664, 'consultar', 2, 15, 'Permitido'),
(30665, 'incluir', 2, 15, 'No Permitido'),
(30666, 'modificar', 2, 15, 'No Permitido'),
(30667, 'eliminar', 2, 15, 'No Permitido'),
(30676, 'consultar', 2, 18, 'No Permitido'),
(30677, 'incluir', 2, 18, 'No Permitido'),
(30678, 'modificar', 2, 18, 'No Permitido'),
(30679, 'eliminar', 2, 18, 'No Permitido'),
(30684, 'consultar', 3, 1, 'No Permitido'),
(30685, 'incluir', 3, 1, 'No Permitido'),
(30686, 'modificar', 3, 1, 'No Permitido'),
(30687, 'eliminar', 3, 1, 'No Permitido'),
(30688, 'consultar', 3, 2, 'No Permitido'),
(30689, 'incluir', 3, 2, 'No Permitido'),
(30690, 'modificar', 3, 2, 'No Permitido'),
(30691, 'eliminar', 3, 2, 'No Permitido'),
(30692, 'consultar', 3, 3, 'No Permitido'),
(30693, 'incluir', 3, 3, 'No Permitido'),
(30694, 'modificar', 3, 3, 'No Permitido'),
(30695, 'eliminar', 3, 3, 'No Permitido'),
(30696, 'consultar', 3, 4, 'No Permitido'),
(30697, 'incluir', 3, 4, 'No Permitido'),
(30698, 'modificar', 3, 4, 'No Permitido'),
(30699, 'eliminar', 3, 4, 'No Permitido'),
(30700, 'consultar', 3, 5, 'No Permitido'),
(30701, 'incluir', 3, 5, 'No Permitido'),
(30702, 'modificar', 3, 5, 'No Permitido'),
(30703, 'eliminar', 3, 5, 'No Permitido'),
(30704, 'consultar', 3, 6, 'No Permitido'),
(30705, 'incluir', 3, 6, 'No Permitido'),
(30706, 'modificar', 3, 6, 'No Permitido'),
(30707, 'eliminar', 3, 6, 'No Permitido'),
(30708, 'consultar', 3, 7, 'No Permitido'),
(30709, 'incluir', 3, 7, 'No Permitido'),
(30710, 'modificar', 3, 7, 'No Permitido'),
(30711, 'eliminar', 3, 7, 'No Permitido'),
(30712, 'consultar', 3, 8, 'No Permitido'),
(30713, 'incluir', 3, 8, 'No Permitido'),
(30714, 'modificar', 3, 8, 'No Permitido'),
(30715, 'eliminar', 3, 8, 'No Permitido'),
(30716, 'consultar', 3, 9, 'No Permitido'),
(30717, 'incluir', 3, 9, 'No Permitido'),
(30718, 'modificar', 3, 9, 'No Permitido'),
(30719, 'eliminar', 3, 9, 'No Permitido'),
(30720, 'consultar', 3, 10, 'Permitido'),
(30721, 'incluir', 3, 10, 'No Permitido'),
(30722, 'modificar', 3, 10, 'No Permitido'),
(30723, 'eliminar', 3, 10, 'No Permitido'),
(30736, 'consultar', 3, 14, 'Permitido'),
(30737, 'incluir', 3, 14, 'Permitido'),
(30738, 'modificar', 3, 14, 'Permitido'),
(30739, 'eliminar', 3, 14, 'No Permitido'),
(30740, 'consultar', 3, 15, 'No Permitido'),
(30741, 'incluir', 3, 15, 'No Permitido'),
(30742, 'modificar', 3, 15, 'No Permitido'),
(30743, 'eliminar', 3, 15, 'No Permitido'),
(30752, 'consultar', 3, 18, 'No Permitido'),
(30753, 'incluir', 3, 18, 'No Permitido'),
(30754, 'modificar', 3, 18, 'No Permitido'),
(30755, 'eliminar', 3, 18, 'No Permitido'),
(30760, 'consultar', 4, 1, 'Permitido'),
(30761, 'incluir', 4, 1, 'Permitido'),
(30762, 'modificar', 4, 1, 'Permitido'),
(30763, 'eliminar', 4, 1, 'Permitido'),
(30764, 'consultar', 4, 2, 'Permitido'),
(30765, 'incluir', 4, 2, 'Permitido'),
(30766, 'modificar', 4, 2, 'Permitido'),
(30767, 'eliminar', 4, 2, 'Permitido'),
(30768, 'consultar', 4, 3, 'Permitido'),
(30769, 'incluir', 4, 3, 'Permitido'),
(30770, 'modificar', 4, 3, 'Permitido'),
(30771, 'eliminar', 4, 3, 'Permitido'),
(30772, 'consultar', 4, 4, 'Permitido'),
(30773, 'incluir', 4, 4, 'Permitido'),
(30774, 'modificar', 4, 4, 'Permitido'),
(30775, 'eliminar', 4, 4, 'Permitido'),
(30776, 'consultar', 4, 5, 'Permitido'),
(30777, 'incluir', 4, 5, 'Permitido'),
(30778, 'modificar', 4, 5, 'Permitido'),
(30779, 'eliminar', 4, 5, 'Permitido'),
(30780, 'consultar', 4, 6, 'Permitido'),
(30781, 'incluir', 4, 6, 'Permitido'),
(30782, 'modificar', 4, 6, 'Permitido'),
(30783, 'eliminar', 4, 6, 'Permitido'),
(30784, 'consultar', 4, 7, 'Permitido'),
(30785, 'incluir', 4, 7, 'Permitido'),
(30786, 'modificar', 4, 7, 'Permitido'),
(30787, 'eliminar', 4, 7, 'Permitido'),
(30788, 'consultar', 4, 8, 'Permitido'),
(30789, 'incluir', 4, 8, 'Permitido'),
(30790, 'modificar', 4, 8, 'Permitido'),
(30791, 'eliminar', 4, 8, 'Permitido'),
(30792, 'consultar', 4, 9, 'Permitido'),
(30793, 'incluir', 4, 9, 'Permitido'),
(30794, 'modificar', 4, 9, 'Permitido'),
(30795, 'eliminar', 4, 9, 'Permitido'),
(30796, 'consultar', 4, 10, 'Permitido'),
(30797, 'incluir', 4, 10, 'Permitido'),
(30798, 'modificar', 4, 10, 'Permitido'),
(30799, 'eliminar', 4, 10, 'Permitido'),
(30812, 'consultar', 4, 14, 'Permitido'),
(30813, 'incluir', 4, 14, 'Permitido'),
(30814, 'modificar', 4, 14, 'Permitido'),
(30815, 'eliminar', 4, 14, 'Permitido'),
(30816, 'consultar', 4, 15, 'Permitido'),
(30817, 'incluir', 4, 15, 'Permitido'),
(30818, 'modificar', 4, 15, 'Permitido'),
(30819, 'eliminar', 4, 15, 'Permitido'),
(30828, 'consultar', 4, 18, 'Permitido'),
(30829, 'incluir', 4, 18, 'Permitido'),
(30830, 'modificar', 4, 18, 'Permitido'),
(30831, 'eliminar', 4, 18, 'Permitido'),
(30836, 'consultar', 6, 1, 'No Permitido'),
(30837, 'incluir', 6, 1, 'No Permitido'),
(30838, 'modificar', 6, 1, 'No Permitido'),
(30839, 'eliminar', 6, 1, 'No Permitido'),
(30840, 'consultar', 6, 2, 'No Permitido'),
(30841, 'incluir', 6, 2, 'No Permitido'),
(30842, 'modificar', 6, 2, 'No Permitido'),
(30843, 'eliminar', 6, 2, 'No Permitido'),
(30844, 'consultar', 6, 3, 'No Permitido'),
(30845, 'incluir', 6, 3, 'No Permitido'),
(30846, 'modificar', 6, 3, 'No Permitido'),
(30847, 'eliminar', 6, 3, 'No Permitido'),
(30848, 'consultar', 6, 4, 'No Permitido'),
(30849, 'incluir', 6, 4, 'No Permitido'),
(30850, 'modificar', 6, 4, 'No Permitido'),
(30851, 'eliminar', 6, 4, 'No Permitido'),
(30852, 'consultar', 6, 5, 'No Permitido'),
(30853, 'incluir', 6, 5, 'No Permitido'),
(30854, 'modificar', 6, 5, 'No Permitido'),
(30855, 'eliminar', 6, 5, 'No Permitido'),
(30856, 'consultar', 6, 6, 'No Permitido'),
(30857, 'incluir', 6, 6, 'No Permitido'),
(30858, 'modificar', 6, 6, 'No Permitido'),
(30859, 'eliminar', 6, 6, 'No Permitido'),
(30860, 'consultar', 6, 7, 'No Permitido'),
(30861, 'incluir', 6, 7, 'No Permitido'),
(30862, 'modificar', 6, 7, 'No Permitido'),
(30863, 'eliminar', 6, 7, 'No Permitido'),
(30864, 'consultar', 6, 8, 'No Permitido'),
(30865, 'incluir', 6, 8, 'No Permitido'),
(30866, 'modificar', 6, 8, 'No Permitido'),
(30867, 'eliminar', 6, 8, 'No Permitido'),
(30868, 'consultar', 6, 9, 'No Permitido'),
(30869, 'incluir', 6, 9, 'No Permitido'),
(30870, 'modificar', 6, 9, 'No Permitido'),
(30871, 'eliminar', 6, 9, 'No Permitido'),
(30872, 'consultar', 6, 10, 'No Permitido'),
(30873, 'incluir', 6, 10, 'No Permitido'),
(30874, 'modificar', 6, 10, 'No Permitido'),
(30875, 'eliminar', 6, 10, 'No Permitido'),
(30888, 'consultar', 6, 14, 'No Permitido'),
(30889, 'incluir', 6, 14, 'No Permitido'),
(30890, 'modificar', 6, 14, 'No Permitido'),
(30891, 'eliminar', 6, 14, 'No Permitido'),
(30892, 'consultar', 6, 15, 'No Permitido'),
(30893, 'incluir', 6, 15, 'No Permitido'),
(30894, 'modificar', 6, 15, 'No Permitido'),
(30895, 'eliminar', 6, 15, 'No Permitido'),
(30904, 'consultar', 6, 18, 'No Permitido'),
(30905, 'incluir', 6, 18, 'No Permitido'),
(30906, 'modificar', 6, 18, 'No Permitido'),
(30907, 'eliminar', 6, 18, 'No Permitido');

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
(5, 'SuperUsu', 'casa2023', 6, 'ejemplo@gmail.com', 'Diego Andres', 'Lopez Vivas', '0414-575-3363', 'habilitado'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30912;

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
