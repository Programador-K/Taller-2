-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2023 a las 21:45:03
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`) VALUES
(1, 'MONTERÍA'),
(2, 'CERETÉ'),
(3, 'SAHAGÚN'),
(4, 'LORICA'),
(5, 'CHIMÁ'),
(6, 'TIERRALTA'),
(7, 'PLANETA RICA'),
(8, 'MONTELÍBANO'),
(9, 'SAN BERNARDO DEL VIENTO'),
(10, 'PUERTO ESCONDIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexos`
--

CREATE TABLE `sexos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sexos`
--

INSERT INTO `sexos` (`id`, `nombre`) VALUES
(1, 'MASCULINO'),
(2, 'FEMENINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_persona`
--

CREATE TABLE `tipos_persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_persona`
--

INSERT INTO `tipos_persona` (`id`, `nombre`) VALUES
(1, 'ESTUDIANTE'),
(2, 'TRABAJADOR'),
(3, 'PROFESIONAL'),
(4, 'EMPRESARIO'),
(5, 'RETIRADO'),
(6, 'AMIGO'),
(7, 'FAMILIAR'),
(8, 'VISITANTE'),
(9, 'INQUILINO'),
(10, 'INVITADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `identificacion` varchar(255) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `hora_registro` time NOT NULL,
  `tiempo_evento` timestamp NOT NULL DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL,
  `sexo_id` int(11) NOT NULL,
  `ciudad_id` int(11) NOT NULL,
  `tipo_persona_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `identificacion`, `nombres`, `apellidos`, `fecha_nacimiento`, `email`, `hora_registro`, `tiempo_evento`, `observaciones`, `sexo_id`, `ciudad_id`, `tipo_persona_id`) VALUES
(38, '1000', 'juan juan', 'hernandez hernandez', '1990-01-20', 'juan3838@gmail.com', '20:30:00', '2023-10-01 19:35:00', 'no hay', 2, 2, 4),
(40, '1234563892', 'juan juan', 'hernandez hernandez', '1990-01-20', 'juan2@gmail.com', '20:30:00', '2023-10-01 19:35:00', '', 1, 5, 3),
(41, '1234563893', 'juan juan', 'hernandez hernandez', '1990-01-20', 'juan3@gmail.com', '20:30:00', '2023-10-01 19:35:00', '', 1, 5, 3),
(42, '1234563894', 'juan juan', 'hernandez hernandez', '1990-01-20', 'juan4@gmail.com', '20:30:00', '2023-10-01 19:35:00', '', 1, 5, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexos`
--
ALTER TABLE `sexos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_persona`
--
ALTER TABLE `tipos_persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD KEY `ciudad_id` (`ciudad_id`),
  ADD KEY `sexo_id` (`sexo_id`),
  ADD KEY `tipo_persona_id` (`tipo_persona_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `sexos`
--
ALTER TABLE `sexos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_persona`
--
ALTER TABLE `tipos_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudades` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`sexo_id`) REFERENCES `sexos` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`tipo_persona_id`) REFERENCES `tipos_persona` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
