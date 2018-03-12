-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2018 a las 06:12:16
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `admin-codeigniter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(2) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT '0',
  `userlist` int(11) NOT NULL DEFAULT '0',
  `correo_electronico` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `contrasenia` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET latin1 DEFAULT 'default.jpg',
  `acerca_de` text CHARACTER SET latin1,
  `usuario_creacion` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `usuario_modificacion` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `activado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `nivel`, `userlist`, `correo_electronico`, `contrasenia`, `nombres`, `apellidos`, `imagen`, `acerca_de`, `usuario_creacion`, `usuario_modificacion`, `fecha_creacion`, `fecha_modificacion`, `estado`, `activado`) VALUES
(1, 0, 1, 'kluizsv@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Luis', 'Shepherd Vargas', 'default.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean porttitor vestibulum imperdiet. Ut auctor accumsan erat, a vulputate metus tristique non. Aliquam aliquam vel orci quis sagittis.', '1', '1', '2014-08-06 22:08:29', '2016-05-11 07:45:51', 1, 1),
(1415426074, 1, 1, 'admin@phsmedia.pe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Administrador', 'General', 'default.jpg', '', '0', '1415426074', '2014-11-07 23:54:34', '2016-05-11 08:03:41', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backend_menu`
--

CREATE TABLE `backend_menu` (
  `id` int(11) NOT NULL,
  `icono` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `metodo` varchar(255) NOT NULL DEFAULT 'abrir',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `grupo` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `usuario_creacion` int(11) NOT NULL,
  `usuario_modificacion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(1) NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `titulo` text CHARACTER SET latin1 NOT NULL,
  `keywords` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `email_contacto` varchar(100) CHARACTER SET latin1 NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `google_analytics` text,
  `usuario_creacion` int(11) NOT NULL,
  `usuario_modificacion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `logo`, `titulo`, `keywords`, `description`, `email_contacto`, `facebook`, `twitter`, `instagram`, `youtube`, `google_analytics`, `usuario_creacion`, `usuario_modificacion`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, '1520831492.png', 'Admin Codeigniter', '', '', 'lshepherd@phsperu.com', '', '', '', '', '', 0, 0, '2018-03-12 00:00:00', '2018-03-12 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_administrador`
--

CREATE TABLE `log_administrador` (
  `id` int(11) NOT NULL,
  `accion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `id_padre` int(11) NOT NULL,
  `acciones` text COLLATE utf8_unicode_ci NOT NULL,
  `controlador` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci,
  `estado` int(11) NOT NULL,
  `usuario_creacion` int(11) NOT NULL,
  `usuario_modificacion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_modificacion` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `backend_menu`
--
ALTER TABLE `backend_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log_administrador`
--
ALTER TABLE `log_administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1520639656;
--
-- AUTO_INCREMENT de la tabla `log_administrador`
--
ALTER TABLE `log_administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;
