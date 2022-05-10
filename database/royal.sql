-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2021 a las 16:40:28
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `royal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `userId` varchar(45) NOT NULL,
  `pago` int(11) NOT NULL,
  `fechapago` date NOT NULL,
  `fechafin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `userId`, `pago`, `fechapago`, `fechafin`) VALUES
(28, '14587534', 75000, '2021-11-10', '2022-01-17'),
(29, '159753', 25000, '2021-11-10', '2021-11-23'),
(35, '16457985', 35000, '2021-11-10', '2021-12-13'),
(37, '1100402604', 35000, '2021-11-10', '2021-12-13'),
(41, '2', 2000, '2021-11-11', '2021-11-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `TokenId` int(11) NOT NULL,
  `id` varchar(45) DEFAULT NULL,
  `Token` varchar(45) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tokens`
--

INSERT INTO `tokens` (`TokenId`, `id`, `Token`, `Fecha`) VALUES
(125, '123456789', 'f2a430a720612a8f3754be2fec0c8ffe', '2021-11-11 15:09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `rol` varchar(13) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombres`, `apellidos`, `rol`, `pass`) VALUES
(2, 'Usuario', 'Prueba2', 'user ', 'c81e728d9d4c2f636f067f89cc14862c'),
(159753, 'pepito', 'perez', 'user ', '5583413443164b56500def9a533c7c70'),
(14587534, 'Usuario', 'Prueba4', 'user ', '3c0dba8bcf537dadce3aeb4b757ec0c4'),
(16457985, 'Prueba', 'Edicion3', 'user ', 'b079906b4f3bf3edf2128939fb656ddc'),
(123456789, 'Admin', '1', 'admin', '781e5e245d69b566979b86e28d23f2c7'),
(1100402604, 'Diego', 'Aguas', 'user ', '0c19e9ddde4b5d01f203786edeb3187f');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`TokenId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `TokenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
