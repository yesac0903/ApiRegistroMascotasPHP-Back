-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2021 a las 04:55:30
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registromascotas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `idCategory` int(64) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`idCategory`, `name`) VALUES
(1, 'Gato'),
(2, 'Perro'),


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pet`
--

CREATE TABLE `pet` (
  `idPet` int(64) NOT NULL,
  `namePet` varchar(30) NOT NULL,
  `photoUrls` varchar(50) NOT NULL,
  `tags` int(64) NOT NULL,
  `categoryPet` int(64) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pet`
--

INSERT INTO `pet` (`idPet`, `namePet`, `photoUrls`, `tags`, `categoryPet`, `status`) VALUES
(1, 'susy', '', 1, 2, 'available'),
(2, 'pandora', '', 2, 2, 'pending'),
(5, 'Bernarda', '', 1, 1, 'pending'),
(8, 'Caro', '', 2, 1, 'pending');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE `tag` (
  `idTag` int(64) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tag`
--

INSERT INTO `tag` (`idTag`, `name`) VALUES
(1, 'cesarea'),
(2, 'fractura'),
(3, 'cesarea'),
(4, 'fractura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioId` int(11) NOT NULL,
  `Usuario` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioId`, `Usuario`, `Password`, `Estado`) VALUES
(1, 'usuario1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Activo'),
(2, 'usuario2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_token`
--

CREATE TABLE `usuarios_token` (
  `TokenId` int(11) NOT NULL,
  `UsuarioId` varchar(45) NOT NULL,
  `Token` varchar(45) NOT NULL,
  `Estado` varchar(45) CHARACTER SET armscii8 NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios_token`
--

INSERT INTO `usuarios_token` (`TokenId`, `UsuarioId`, `Token`, `Estado`, `Fecha`) VALUES
(1, '1', '05d8bcdf899718c16ff4bd64371de323', 'Activo', '2021-01-25 17:55:00'),
(2, '1', 'cf9c9c6c9429211f35d5fa3e40bbff07', 'Activo', '2021-01-26 09:10:00'),
(3, '1', 'a2983cbdf4984c59173ef093723a8910', 'Activo', '2021-01-26 17:29:00'),
(4, '1', 'b1ac2acddae9f357997f6e8338872668', 'Activo', '2021-01-27 02:42:00'),
(5, '1', 'c099def10d7976dbe9813500ac0f18b9', 'Activo', '2021-01-27 03:12:00'),
(6, '1', 'e9ace98e5044191c5a4eb62615c40fd3', 'Activo', '2021-01-27 03:14:00'),
(7, '1', '717774fd374396b0850726927b325c69', 'Activo', '2021-01-27 03:18:00'),
(8, '1', 'b5f4ce857569992a4fb3f22ae83834b2', 'Activo', '2021-01-27 03:48:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`idPet`),
  ADD KEY `fk_pet_category` (`categoryPet`),
  ADD KEY `fk_pet_tag` (`tags`);

--
-- Indices de la tabla `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`idTag`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioId`);

--
-- Indices de la tabla `usuarios_token`
--
ALTER TABLE `usuarios_token`
  ADD PRIMARY KEY (`TokenId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pet`
--
ALTER TABLE `pet`
  MODIFY `idPet` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
  MODIFY `idTag` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios_token`
--
ALTER TABLE `usuarios_token`
  MODIFY `TokenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_category` FOREIGN KEY (`categoryPet`) REFERENCES `category` (`idCategory`),
  ADD CONSTRAINT `fk_pet_tag` FOREIGN KEY (`tags`) REFERENCES `tag` (`idTag`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
