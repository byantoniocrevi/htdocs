-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2021 a las 19:31:54
-- Versión del servidor: 5.5.39
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
`id` int(5) unsigned NOT NULL,
  `comentario` varchar(300) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_rep` int(5) unsigned DEFAULT NULL,
  `id_usr` int(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparaciones`
--

CREATE TABLE IF NOT EXISTS `reparaciones` (
`id` int(5) unsigned NOT NULL,
  `id_usr` int(5) unsigned DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `nserie` varchar(100) DEFAULT NULL,
  `tipodispositivo` varchar(100) NOT NULL,
  `detalles` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('pendiente','en progreso','completado') NOT NULL,
  `precio` int(100) NOT NULL DEFAULT '0',
  `direccion` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id_usr` int(5) unsigned NOT NULL,
  `nombre` text NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `tipo` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1->Usuario 2-> Tecnico'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usr`, `nombre`, `email`, `pass`, `tipo`) VALUES
(26, 'usuario', 'usuario@usuario.com', 'usuario', '1'),
(27, 'tecnico', 'tecnico@tecnico.com', 'tecnico', '2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
 ADD PRIMARY KEY (`id`), ADD KEY `id_usr` (`id_rep`), ADD KEY `id_usr_2` (`id_usr`);

--
-- Indices de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
 ADD PRIMARY KEY (`id`), ADD KEY `id_usr` (`id_usr`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id_usr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
MODIFY `id` int(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
MODIFY `id` int(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id_usr` int(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usr`) REFERENCES `usuarios` (`id_usr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
ADD CONSTRAINT `reparaciones_ibfk_1` FOREIGN KEY (`id_usr`) REFERENCES `usuarios` (`id_usr`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
