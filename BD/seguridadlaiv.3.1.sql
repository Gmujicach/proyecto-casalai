-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2025 a las 03:00:38
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
(11, 'Carrito de compras'),
(12, 'Pasarela de pagos'),
(13, 'Pre-factura'),
(14, 'Ordenes de despacho'),
(15, 'Cuentas bancarias'),
(16, 'Ingresos y egresos'),
(17, 'Permisos'),
(18, 'Roles'),
(19, 'Bitacora');

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
(3932, 'consultar', 1, 1, 'Permitido'),
(3933, 'incluir', 1, 1, 'Permitido'),
(3934, 'modificar', 1, 1, 'Permitido'),
(3935, 'eliminar', 1, 1, 'Permitido'),
(3936, 'consultar', 1, 2, 'Permitido'),
(3937, 'incluir', 1, 2, 'Permitido'),
(3938, 'modificar', 1, 2, 'Permitido'),
(3939, 'eliminar', 1, 2, 'No Permitido'),
(3940, 'consultar', 1, 3, 'Permitido'),
(3941, 'incluir', 1, 3, 'Permitido'),
(3942, 'modificar', 1, 3, 'Permitido'),
(3943, 'eliminar', 1, 3, 'No Permitido'),
(3944, 'consultar', 1, 4, 'Permitido'),
(3945, 'incluir', 1, 4, 'Permitido'),
(3946, 'modificar', 1, 4, 'Permitido'),
(3947, 'eliminar', 1, 4, 'Permitido'),
(3948, 'consultar', 1, 5, 'Permitido'),
(3949, 'incluir', 1, 5, 'Permitido'),
(3950, 'modificar', 1, 5, 'Permitido'),
(3951, 'eliminar', 1, 5, 'Permitido'),
(3952, 'consultar', 1, 6, 'Permitido'),
(3953, 'incluir', 1, 6, 'Permitido'),
(3954, 'modificar', 1, 6, 'Permitido'),
(3955, 'eliminar', 1, 6, 'Permitido'),
(3956, 'consultar', 1, 7, 'Permitido'),
(3957, 'incluir', 1, 7, 'Permitido'),
(3958, 'modificar', 1, 7, 'Permitido'),
(3959, 'eliminar', 1, 7, 'Permitido'),
(3960, 'consultar', 1, 8, 'Permitido'),
(3961, 'incluir', 1, 8, 'Permitido'),
(3962, 'modificar', 1, 8, 'Permitido'),
(3963, 'eliminar', 1, 8, 'Permitido'),
(3964, 'consultar', 1, 9, 'Permitido'),
(3965, 'incluir', 1, 9, 'Permitido'),
(3966, 'modificar', 1, 9, 'Permitido'),
(3967, 'eliminar', 1, 9, 'Permitido'),
(3968, 'consultar', 1, 10, 'No Permitido'),
(3969, 'incluir', 1, 10, 'No Permitido'),
(3970, 'modificar', 1, 10, 'No Permitido'),
(3971, 'eliminar', 1, 10, 'No Permitido'),
(3972, 'consultar', 1, 11, 'No Permitido'),
(3973, 'incluir', 1, 11, 'No Permitido'),
(3974, 'modificar', 1, 11, 'No Permitido'),
(3975, 'eliminar', 1, 11, 'No Permitido'),
(3976, 'consultar', 1, 12, 'No Permitido'),
(3977, 'incluir', 1, 12, 'No Permitido'),
(3978, 'modificar', 1, 12, 'No Permitido'),
(3979, 'eliminar', 1, 12, 'No Permitido'),
(3980, 'consultar', 1, 13, 'No Permitido'),
(3981, 'incluir', 1, 13, 'No Permitido'),
(3982, 'modificar', 1, 13, 'No Permitido'),
(3983, 'eliminar', 1, 13, 'No Permitido'),
(3984, 'consultar', 1, 14, 'Permitido'),
(3985, 'incluir', 1, 14, 'Permitido'),
(3986, 'modificar', 1, 14, 'Permitido'),
(3987, 'eliminar', 1, 14, 'Permitido'),
(3988, 'consultar', 1, 15, 'Permitido'),
(3989, 'incluir', 1, 15, 'Permitido'),
(3990, 'modificar', 1, 15, 'Permitido'),
(3991, 'eliminar', 1, 15, 'Permitido'),
(3992, 'consultar', 1, 16, 'Permitido'),
(3993, 'incluir', 1, 16, 'No Permitido'),
(3994, 'modificar', 1, 16, 'No Permitido'),
(3995, 'eliminar', 1, 16, 'No Permitido'),
(3996, 'consultar', 1, 17, 'No Permitido'),
(3997, 'incluir', 1, 17, 'No Permitido'),
(3998, 'modificar', 1, 17, 'No Permitido'),
(3999, 'eliminar', 1, 17, 'No Permitido'),
(4000, 'consultar', 1, 18, 'No Permitido'),
(4001, 'incluir', 1, 18, 'No Permitido'),
(4002, 'modificar', 1, 18, 'No Permitido'),
(4003, 'eliminar', 1, 18, 'No Permitido'),
(4004, 'consultar', 1, 19, 'Permitido'),
(4005, 'incluir', 1, 19, 'No Permitido'),
(4006, 'modificar', 1, 19, 'No Permitido'),
(4007, 'eliminar', 1, 19, 'No Permitido'),
(4008, 'consultar', 2, 1, 'No Permitido'),
(4009, 'incluir', 2, 1, 'No Permitido'),
(4010, 'modificar', 2, 1, 'No Permitido'),
(4011, 'eliminar', 2, 1, 'No Permitido'),
(4012, 'consultar', 2, 2, 'Permitido'),
(4013, 'incluir', 2, 2, 'Permitido'),
(4014, 'modificar', 2, 2, 'Permitido'),
(4015, 'eliminar', 2, 2, 'Permitido'),
(4016, 'consultar', 2, 3, 'Permitido'),
(4017, 'incluir', 2, 3, 'Permitido'),
(4018, 'modificar', 2, 3, 'Permitido'),
(4019, 'eliminar', 2, 3, 'Permitido'),
(4020, 'consultar', 2, 4, 'Permitido'),
(4021, 'incluir', 2, 4, 'Permitido'),
(4022, 'modificar', 2, 4, 'Permitido'),
(4023, 'eliminar', 2, 4, 'Permitido'),
(4024, 'consultar', 2, 5, 'Permitido'),
(4025, 'incluir', 2, 5, 'Permitido'),
(4026, 'modificar', 2, 5, 'Permitido'),
(4027, 'eliminar', 2, 5, 'Permitido'),
(4028, 'consultar', 2, 6, 'Permitido'),
(4029, 'incluir', 2, 6, 'Permitido'),
(4030, 'modificar', 2, 6, 'Permitido'),
(4031, 'eliminar', 2, 6, 'Permitido'),
(4032, 'consultar', 2, 7, 'Permitido'),
(4033, 'incluir', 2, 7, 'Permitido'),
(4034, 'modificar', 2, 7, 'Permitido'),
(4035, 'eliminar', 2, 7, 'Permitido'),
(4036, 'consultar', 2, 8, 'No Permitido'),
(4037, 'incluir', 2, 8, 'No Permitido'),
(4038, 'modificar', 2, 8, 'No Permitido'),
(4039, 'eliminar', 2, 8, 'No Permitido'),
(4040, 'consultar', 2, 9, 'Permitido'),
(4041, 'incluir', 2, 9, 'Permitido'),
(4042, 'modificar', 2, 9, 'Permitido'),
(4043, 'eliminar', 2, 9, 'Permitido'),
(4044, 'consultar', 2, 10, 'Permitido'),
(4045, 'incluir', 2, 10, 'Permitido'),
(4046, 'modificar', 2, 10, 'Permitido'),
(4047, 'eliminar', 2, 10, 'Permitido'),
(4048, 'consultar', 2, 11, 'No Permitido'),
(4049, 'incluir', 2, 11, 'No Permitido'),
(4050, 'modificar', 2, 11, 'No Permitido'),
(4051, 'eliminar', 2, 11, 'No Permitido'),
(4052, 'consultar', 2, 12, 'No Permitido'),
(4053, 'incluir', 2, 12, 'No Permitido'),
(4054, 'modificar', 2, 12, 'No Permitido'),
(4055, 'eliminar', 2, 12, 'No Permitido'),
(4056, 'consultar', 2, 13, 'No Permitido'),
(4057, 'incluir', 2, 13, 'No Permitido'),
(4058, 'modificar', 2, 13, 'No Permitido'),
(4059, 'eliminar', 2, 13, 'No Permitido'),
(4060, 'consultar', 2, 14, 'Permitido'),
(4061, 'incluir', 2, 14, 'Permitido'),
(4062, 'modificar', 2, 14, 'Permitido'),
(4063, 'eliminar', 2, 14, 'Permitido'),
(4064, 'consultar', 2, 15, 'Permitido'),
(4065, 'incluir', 2, 15, 'No Permitido'),
(4066, 'modificar', 2, 15, 'No Permitido'),
(4067, 'eliminar', 2, 15, 'No Permitido'),
(4068, 'consultar', 2, 16, 'No Permitido'),
(4069, 'incluir', 2, 16, 'No Permitido'),
(4070, 'modificar', 2, 16, 'No Permitido'),
(4071, 'eliminar', 2, 16, 'No Permitido'),
(4072, 'consultar', 2, 17, 'No Permitido'),
(4073, 'incluir', 2, 17, 'No Permitido'),
(4074, 'modificar', 2, 17, 'No Permitido'),
(4075, 'eliminar', 2, 17, 'No Permitido'),
(4076, 'consultar', 2, 18, 'No Permitido'),
(4077, 'incluir', 2, 18, 'No Permitido'),
(4078, 'modificar', 2, 18, 'No Permitido'),
(4079, 'eliminar', 2, 18, 'No Permitido'),
(4080, 'consultar', 2, 19, 'No Permitido'),
(4081, 'incluir', 2, 19, 'No Permitido'),
(4082, 'modificar', 2, 19, 'No Permitido'),
(4083, 'eliminar', 2, 19, 'No Permitido'),
(4084, 'consultar', 3, 1, 'No Permitido'),
(4085, 'incluir', 3, 1, 'No Permitido'),
(4086, 'modificar', 3, 1, 'No Permitido'),
(4087, 'eliminar', 3, 1, 'No Permitido'),
(4088, 'consultar', 3, 2, 'No Permitido'),
(4089, 'incluir', 3, 2, 'No Permitido'),
(4090, 'modificar', 3, 2, 'No Permitido'),
(4091, 'eliminar', 3, 2, 'No Permitido'),
(4092, 'consultar', 3, 3, 'No Permitido'),
(4093, 'incluir', 3, 3, 'No Permitido'),
(4094, 'modificar', 3, 3, 'No Permitido'),
(4095, 'eliminar', 3, 3, 'No Permitido'),
(4096, 'consultar', 3, 4, 'No Permitido'),
(4097, 'incluir', 3, 4, 'No Permitido'),
(4098, 'modificar', 3, 4, 'No Permitido'),
(4099, 'eliminar', 3, 4, 'No Permitido'),
(4100, 'consultar', 3, 5, 'No Permitido'),
(4101, 'incluir', 3, 5, 'No Permitido'),
(4102, 'modificar', 3, 5, 'No Permitido'),
(4103, 'eliminar', 3, 5, 'No Permitido'),
(4104, 'consultar', 3, 6, 'No Permitido'),
(4105, 'incluir', 3, 6, 'No Permitido'),
(4106, 'modificar', 3, 6, 'No Permitido'),
(4107, 'eliminar', 3, 6, 'No Permitido'),
(4108, 'consultar', 3, 7, 'No Permitido'),
(4109, 'incluir', 3, 7, 'No Permitido'),
(4110, 'modificar', 3, 7, 'No Permitido'),
(4111, 'eliminar', 3, 7, 'No Permitido'),
(4112, 'consultar', 3, 8, 'No Permitido'),
(4113, 'incluir', 3, 8, 'No Permitido'),
(4114, 'modificar', 3, 8, 'No Permitido'),
(4115, 'eliminar', 3, 8, 'No Permitido'),
(4116, 'consultar', 3, 9, 'No Permitido'),
(4117, 'incluir', 3, 9, 'No Permitido'),
(4118, 'modificar', 3, 9, 'No Permitido'),
(4119, 'eliminar', 3, 9, 'No Permitido'),
(4120, 'consultar', 3, 10, 'Permitido'),
(4121, 'incluir', 3, 10, 'No Permitido'),
(4122, 'modificar', 3, 10, 'No Permitido'),
(4123, 'eliminar', 3, 10, 'No Permitido'),
(4124, 'consultar', 3, 11, 'Permitido'),
(4125, 'incluir', 3, 11, 'Permitido'),
(4126, 'modificar', 3, 11, 'Permitido'),
(4127, 'eliminar', 3, 11, 'Permitido'),
(4128, 'consultar', 3, 12, 'Permitido'),
(4129, 'incluir', 3, 12, 'Permitido'),
(4130, 'modificar', 3, 12, 'Permitido'),
(4131, 'eliminar', 3, 12, 'No Permitido'),
(4132, 'consultar', 3, 13, 'Permitido'),
(4133, 'incluir', 3, 13, 'Permitido'),
(4134, 'modificar', 3, 13, 'Permitido'),
(4135, 'eliminar', 3, 13, 'Permitido'),
(4136, 'consultar', 3, 14, 'Permitido'),
(4137, 'incluir', 3, 14, 'Permitido'),
(4138, 'modificar', 3, 14, 'Permitido'),
(4139, 'eliminar', 3, 14, 'No Permitido'),
(4140, 'consultar', 3, 15, 'No Permitido'),
(4141, 'incluir', 3, 15, 'No Permitido'),
(4142, 'modificar', 3, 15, 'No Permitido'),
(4143, 'eliminar', 3, 15, 'No Permitido'),
(4144, 'consultar', 3, 16, 'No Permitido'),
(4145, 'incluir', 3, 16, 'No Permitido'),
(4146, 'modificar', 3, 16, 'No Permitido'),
(4147, 'eliminar', 3, 16, 'No Permitido'),
(4148, 'consultar', 3, 17, 'No Permitido'),
(4149, 'incluir', 3, 17, 'No Permitido'),
(4150, 'modificar', 3, 17, 'No Permitido'),
(4151, 'eliminar', 3, 17, 'No Permitido'),
(4152, 'consultar', 3, 18, 'No Permitido'),
(4153, 'incluir', 3, 18, 'No Permitido'),
(4154, 'modificar', 3, 18, 'No Permitido'),
(4155, 'eliminar', 3, 18, 'No Permitido'),
(4156, 'consultar', 3, 19, 'No Permitido'),
(4157, 'incluir', 3, 19, 'No Permitido'),
(4158, 'modificar', 3, 19, 'No Permitido'),
(4159, 'eliminar', 3, 19, 'No Permitido'),
(4160, 'consultar', 4, 1, 'Permitido'),
(4161, 'incluir', 4, 1, 'Permitido'),
(4162, 'modificar', 4, 1, 'Permitido'),
(4163, 'eliminar', 4, 1, 'Permitido'),
(4164, 'consultar', 4, 2, 'Permitido'),
(4165, 'incluir', 4, 2, 'Permitido'),
(4166, 'modificar', 4, 2, 'Permitido'),
(4167, 'eliminar', 4, 2, 'Permitido'),
(4168, 'consultar', 4, 3, 'Permitido'),
(4169, 'incluir', 4, 3, 'Permitido'),
(4170, 'modificar', 4, 3, 'Permitido'),
(4171, 'eliminar', 4, 3, 'Permitido'),
(4172, 'consultar', 4, 4, 'Permitido'),
(4173, 'incluir', 4, 4, 'Permitido'),
(4174, 'modificar', 4, 4, 'Permitido'),
(4175, 'eliminar', 4, 4, 'Permitido'),
(4176, 'consultar', 4, 5, 'Permitido'),
(4177, 'incluir', 4, 5, 'Permitido'),
(4178, 'modificar', 4, 5, 'Permitido'),
(4179, 'eliminar', 4, 5, 'Permitido'),
(4180, 'consultar', 4, 6, 'Permitido'),
(4181, 'incluir', 4, 6, 'Permitido'),
(4182, 'modificar', 4, 6, 'Permitido'),
(4183, 'eliminar', 4, 6, 'Permitido'),
(4184, 'consultar', 4, 7, 'Permitido'),
(4185, 'incluir', 4, 7, 'Permitido'),
(4186, 'modificar', 4, 7, 'Permitido'),
(4187, 'eliminar', 4, 7, 'Permitido'),
(4188, 'consultar', 4, 8, 'Permitido'),
(4189, 'incluir', 4, 8, 'Permitido'),
(4190, 'modificar', 4, 8, 'Permitido'),
(4191, 'eliminar', 4, 8, 'Permitido'),
(4192, 'consultar', 4, 9, 'Permitido'),
(4193, 'incluir', 4, 9, 'Permitido'),
(4194, 'modificar', 4, 9, 'Permitido'),
(4195, 'eliminar', 4, 9, 'Permitido'),
(4196, 'consultar', 4, 10, 'Permitido'),
(4197, 'incluir', 4, 10, 'Permitido'),
(4198, 'modificar', 4, 10, 'Permitido'),
(4199, 'eliminar', 4, 10, 'Permitido'),
(4200, 'consultar', 4, 11, 'Permitido'),
(4201, 'incluir', 4, 11, 'Permitido'),
(4202, 'modificar', 4, 11, 'Permitido'),
(4203, 'eliminar', 4, 11, 'Permitido'),
(4204, 'consultar', 4, 12, 'Permitido'),
(4205, 'incluir', 4, 12, 'Permitido'),
(4206, 'modificar', 4, 12, 'Permitido'),
(4207, 'eliminar', 4, 12, 'Permitido'),
(4208, 'consultar', 4, 13, 'Permitido'),
(4209, 'incluir', 4, 13, 'Permitido'),
(4210, 'modificar', 4, 13, 'Permitido'),
(4211, 'eliminar', 4, 13, 'Permitido'),
(4212, 'consultar', 4, 14, 'Permitido'),
(4213, 'incluir', 4, 14, 'Permitido'),
(4214, 'modificar', 4, 14, 'Permitido'),
(4215, 'eliminar', 4, 14, 'Permitido'),
(4216, 'consultar', 4, 15, 'Permitido'),
(4217, 'incluir', 4, 15, 'Permitido'),
(4218, 'modificar', 4, 15, 'Permitido'),
(4219, 'eliminar', 4, 15, 'Permitido'),
(4220, 'consultar', 4, 16, 'Permitido'),
(4221, 'incluir', 4, 16, 'Permitido'),
(4222, 'modificar', 4, 16, 'Permitido'),
(4223, 'eliminar', 4, 16, 'Permitido'),
(4224, 'consultar', 4, 17, 'Permitido'),
(4225, 'incluir', 4, 17, 'Permitido'),
(4226, 'modificar', 4, 17, 'Permitido'),
(4227, 'eliminar', 4, 17, 'Permitido'),
(4228, 'consultar', 4, 18, 'Permitido'),
(4229, 'incluir', 4, 18, 'Permitido'),
(4230, 'modificar', 4, 18, 'Permitido'),
(4231, 'eliminar', 4, 18, 'Permitido'),
(4232, 'consultar', 4, 19, 'Permitido'),
(4233, 'incluir', 4, 19, 'Permitido'),
(4234, 'modificar', 4, 19, 'Permitido'),
(4235, 'eliminar', 4, 19, 'Permitido'),
(4236, 'consultar', 6, 1, 'No Permitido'),
(4237, 'incluir', 6, 1, 'No Permitido'),
(4238, 'modificar', 6, 1, 'No Permitido'),
(4239, 'eliminar', 6, 1, 'No Permitido'),
(4240, 'consultar', 6, 2, 'No Permitido'),
(4241, 'incluir', 6, 2, 'No Permitido'),
(4242, 'modificar', 6, 2, 'No Permitido'),
(4243, 'eliminar', 6, 2, 'No Permitido'),
(4244, 'consultar', 6, 3, 'No Permitido'),
(4245, 'incluir', 6, 3, 'No Permitido'),
(4246, 'modificar', 6, 3, 'No Permitido'),
(4247, 'eliminar', 6, 3, 'No Permitido'),
(4248, 'consultar', 6, 4, 'No Permitido'),
(4249, 'incluir', 6, 4, 'No Permitido'),
(4250, 'modificar', 6, 4, 'No Permitido'),
(4251, 'eliminar', 6, 4, 'No Permitido'),
(4252, 'consultar', 6, 5, 'No Permitido'),
(4253, 'incluir', 6, 5, 'No Permitido'),
(4254, 'modificar', 6, 5, 'No Permitido'),
(4255, 'eliminar', 6, 5, 'No Permitido'),
(4256, 'consultar', 6, 6, 'No Permitido'),
(4257, 'incluir', 6, 6, 'No Permitido'),
(4258, 'modificar', 6, 6, 'No Permitido'),
(4259, 'eliminar', 6, 6, 'No Permitido'),
(4260, 'consultar', 6, 7, 'No Permitido'),
(4261, 'incluir', 6, 7, 'No Permitido'),
(4262, 'modificar', 6, 7, 'No Permitido'),
(4263, 'eliminar', 6, 7, 'No Permitido'),
(4264, 'consultar', 6, 8, 'No Permitido'),
(4265, 'incluir', 6, 8, 'No Permitido'),
(4266, 'modificar', 6, 8, 'No Permitido'),
(4267, 'eliminar', 6, 8, 'No Permitido'),
(4268, 'consultar', 6, 9, 'No Permitido'),
(4269, 'incluir', 6, 9, 'No Permitido'),
(4270, 'modificar', 6, 9, 'No Permitido'),
(4271, 'eliminar', 6, 9, 'No Permitido'),
(4272, 'consultar', 6, 10, 'No Permitido'),
(4273, 'incluir', 6, 10, 'No Permitido'),
(4274, 'modificar', 6, 10, 'No Permitido'),
(4275, 'eliminar', 6, 10, 'No Permitido'),
(4276, 'consultar', 6, 11, 'No Permitido'),
(4277, 'incluir', 6, 11, 'No Permitido'),
(4278, 'modificar', 6, 11, 'No Permitido'),
(4279, 'eliminar', 6, 11, 'No Permitido'),
(4280, 'consultar', 6, 12, 'No Permitido'),
(4281, 'incluir', 6, 12, 'No Permitido'),
(4282, 'modificar', 6, 12, 'No Permitido'),
(4283, 'eliminar', 6, 12, 'No Permitido'),
(4284, 'consultar', 6, 13, 'No Permitido'),
(4285, 'incluir', 6, 13, 'No Permitido'),
(4286, 'modificar', 6, 13, 'No Permitido'),
(4287, 'eliminar', 6, 13, 'No Permitido'),
(4288, 'consultar', 6, 14, 'No Permitido'),
(4289, 'incluir', 6, 14, 'No Permitido'),
(4290, 'modificar', 6, 14, 'No Permitido'),
(4291, 'eliminar', 6, 14, 'No Permitido'),
(4292, 'consultar', 6, 15, 'No Permitido'),
(4293, 'incluir', 6, 15, 'No Permitido'),
(4294, 'modificar', 6, 15, 'No Permitido'),
(4295, 'eliminar', 6, 15, 'No Permitido'),
(4296, 'consultar', 6, 16, 'No Permitido'),
(4297, 'incluir', 6, 16, 'No Permitido'),
(4298, 'modificar', 6, 16, 'No Permitido'),
(4299, 'eliminar', 6, 16, 'No Permitido'),
(4300, 'consultar', 6, 17, 'No Permitido'),
(4301, 'incluir', 6, 17, 'No Permitido'),
(4302, 'modificar', 6, 17, 'No Permitido'),
(4303, 'eliminar', 6, 17, 'No Permitido'),
(4304, 'consultar', 6, 18, 'No Permitido'),
(4305, 'incluir', 6, 18, 'No Permitido'),
(4306, 'modificar', 6, 18, 'No Permitido'),
(4307, 'eliminar', 6, 18, 'No Permitido'),
(4308, 'consultar', 6, 19, 'No Permitido'),
(4309, 'incluir', 6, 19, 'No Permitido'),
(4310, 'modificar', 6, 19, 'No Permitido'),
(4311, 'eliminar', 6, 19, 'No Permitido');

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4312;

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
