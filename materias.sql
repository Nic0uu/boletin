-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2026 a las 15:24:33
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
-- Base de datos: `boletin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(4) NOT NULL,
  `id_profesor` int(4) NOT NULL,
  `materia` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `id_curso` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `id_profesor`, `materia`, `id_curso`) VALUES
(1, 0, 'Ciencias Naturales', 1),
(2, 0, 'Ciencias Sociales', 1),
(3, 0, 'Ciudadanía', 1),
(4, 0, 'Artística', 1),
(5, 0, 'Educación Física', 1),
(6, 0, 'Ingles', 1),
(7, 0, 'Matemática', 1),
(8, 0, 'Prácticas del Lenguaje', 1),
(9, 0, 'Lenguajes Tecnológicos G1', 1),
(10, 0, 'Lenguajes Tecnológicos G2', 1),
(11, 0, 'Procedimientos Técnicos G1', 1),
(12, 0, 'Procedimientos Técnicos G2', 1),
(13, 0, 'Sistemas Tecnológicos G1', 1),
(14, 0, 'Sistemas Tecnológicos G2', 1),
(15, 0, 'Ciencias Naturales', 4),
(16, 0, 'Ciencias Sociales', 4),
(17, 0, 'Ciudadanía', 4),
(18, 0, 'Artística', 4),
(19, 0, 'Educación Física', 4),
(20, 0, 'Ingles', 4),
(21, 0, 'Matemática', 4),
(22, 0, 'Prácticas del Lenguaje', 4),
(23, 0, 'Lenguajes Tecnológicos G1', 4),
(24, 0, 'Lenguajes Tecnológicos G2', 4),
(25, 0, 'Procedimientos Técnicos G1', 4),
(26, 0, 'Procedimientos Técnicos G2', 4),
(27, 0, 'Sistemas Tecnológicos G1', 4),
(28, 0, 'Sistemas Tecnológicos G2', 4),
(29, 0, 'Ciencias Naturales', 7),
(30, 0, 'Ciencias Sociales', 7),
(31, 0, 'Ciudadanía', 7),
(32, 0, 'Artística', 7),
(33, 0, 'Educación Física', 7),
(34, 0, 'Ingles', 7),
(35, 0, 'Matemática', 7),
(36, 0, 'Prácticas del Lenguaje', 7),
(37, 0, 'Lenguajes Tecnológicos G1', 7),
(38, 0, 'Lenguajes Tecnológicos G2', 7),
(39, 0, 'Procedimientos Técnicos G1', 7),
(40, 0, 'Procedimientos Técnicos G2', 7),
(41, 0, 'Sistemas Tecnológicos G1', 7),
(42, 0, 'Sistemas Tecnológicos G2', 7),
(43, 0, 'Ciencias Naturales', 10),
(44, 0, 'Ciencias Sociales', 10),
(45, 0, 'Ciudadanía', 10),
(46, 0, 'Artística', 10),
(47, 0, 'Educación Física', 10),
(48, 0, 'Ingles', 10),
(49, 0, 'Matemática', 10),
(50, 0, 'Prácticas del Lenguaje', 10),
(51, 0, 'Lenguajes Tecnológicos G1', 10),
(52, 0, 'Lenguajes Tecnológicos G2', 10),
(53, 0, 'Procedimientos Técnicos G1', 10),
(54, 0, 'Procedimientos Técnicos G2', 10),
(55, 0, 'Sistemas Tecnológicos G1', 10),
(56, 0, 'Sistemas Tecnológicos G2', 10),
(57, 0, 'Ciencias Naturales', 13),
(58, 0, 'Ciencias Sociales', 13),
(59, 0, 'Ciudadanía', 13),
(60, 0, 'Artística', 13),
(61, 0, 'Educación Física', 13),
(62, 0, 'Ingles', 13),
(63, 0, 'Matemática', 13),
(64, 0, 'Prácticas del Lenguaje', 13),
(65, 0, 'Lenguajes Tecnológicos G1', 13),
(66, 0, 'Lenguajes Tecnológicos G2', 13),
(67, 0, 'Procedimientos Técnicos G1', 13),
(68, 0, 'Procedimientos Técnicos G2', 13),
(69, 0, 'Sistemas Tecnológicos G1', 13),
(70, 0, 'Sistemas Tecnológicos G2', 13),
(71, 0, 'Biología', 2),
(72, 0, 'Ciudadanía', 2),
(73, 0, 'Artística', 2),
(74, 0, 'Educacíon Física', 2),
(75, 0, 'Fisicoquímica', 2),
(76, 0, 'Geografía', 2),
(77, 0, 'Historia', 2),
(78, 0, 'Ingles', 2),
(79, 0, 'Matemática', 2),
(80, 0, 'Prácticas del Lenguaje', 2),
(81, 0, 'Lenguajes tecnológicos G1', 2),
(82, 0, 'Lenguajes tecnológicos G2', 2),
(83, 0, 'Procedimientos Técnicos G1', 2),
(84, 0, 'Procedimientos Técnicos G2', 2),
(85, 0, 'Sistemas Tecnológicos G1', 2),
(86, 0, 'Sistemas Tecnológicos G2', 2),
(87, 0, 'Biología', 5),
(88, 0, 'Ciudadanía', 5),
(89, 0, 'Artística', 5),
(90, 0, 'Educacíon Física', 5),
(91, 0, 'Fisicoquímica', 5),
(92, 0, 'Geografía', 5),
(93, 0, 'Historia', 5),
(94, 0, 'Ingles', 5),
(95, 0, 'Matemática', 5),
(96, 0, 'Prácticas del Lenguaje', 5),
(97, 0, 'Lenguajes tecnológicos G1', 5),
(98, 0, 'Lenguajes tecnológicos G2', 5),
(99, 0, 'Procedimientos Técnicos G1', 5),
(100, 0, 'Procedimientos Técnicos G2', 5),
(101, 0, 'Sistemas Tecnológicos G1', 5),
(102, 0, 'Sistemas Tecnológicos G2', 5),
(103, 0, 'Biología', 8),
(104, 0, 'Ciudadanía', 8),
(105, 0, 'Artística', 8),
(106, 0, 'Educacíon Física', 8),
(107, 0, 'Fisicoquímica', 8),
(108, 0, 'Geografía', 8),
(109, 0, 'Historia', 8),
(110, 0, 'Ingles', 8),
(111, 0, 'Matemática', 8),
(112, 0, 'Prácticas del Lenguaje', 8),
(113, 0, 'Lenguajes tecnológicos G1', 8),
(114, 0, 'Lenguajes tecnológicos G2', 8),
(115, 0, 'Procedimientos Técnicos G1', 8),
(116, 0, 'Procedimientos Técnicos G2', 8),
(117, 0, 'Sistemas Tecnológicos G1', 8),
(118, 0, 'Sistemas Tecnológicos G2', 8),
(119, 0, 'Biología', 11),
(120, 0, 'Ciudadanía', 11),
(121, 0, 'Artística', 11),
(122, 0, 'Educacíon Física', 11),
(123, 0, 'Fisicoquímica', 11),
(124, 0, 'Geografía', 11),
(125, 0, 'Historia', 11),
(126, 0, 'Ingles', 11),
(127, 0, 'Matemática', 11),
(128, 0, 'Prácticas del Lenguaje', 11),
(129, 0, 'Lenguajes tecnológicos G1', 11),
(130, 0, 'Lenguajes tecnológicos G2', 11),
(131, 0, 'Procedimientos Técnicos G1', 11),
(132, 0, 'Procedimientos Técnicos G2', 11),
(133, 0, 'Sistemas Tecnológicos G1', 11),
(134, 0, 'Sistemas Tecnológicos G2', 11),
(135, 0, 'Biología', 14),
(136, 0, 'Ciudadanía', 14),
(137, 0, 'Artística', 14),
(138, 0, 'Educacíon Física', 14),
(139, 0, 'Fisicoquímica', 14),
(140, 0, 'Geografía', 14),
(141, 0, 'Historia', 14),
(142, 0, 'Ingles', 14),
(143, 0, 'Matemática', 14),
(144, 0, 'Prácticas del Lenguaje', 14),
(145, 0, 'Lenguajes tecnológicos G1', 14),
(146, 0, 'Lenguajes tecnológicos G2', 14),
(147, 0, 'Procedimientos Técnicos G1', 14),
(148, 0, 'Procedimientos Técnicos G2', 14),
(149, 0, 'Sistemas Tecnológicos G1', 14),
(150, 0, 'Sistemas Tecnológicos G2', 14),
(151, 0, 'Biología', 3),
(152, 0, 'Ciudadanía', 3),
(153, 0, 'Artística', 3),
(154, 0, 'Educacíon Física', 3),
(155, 0, 'Fisicoquímica', 3),
(156, 0, 'Geografía', 3),
(157, 0, 'Historia', 3),
(158, 0, 'Ingles', 3),
(159, 0, 'Matemática', 3),
(160, 0, 'Prácticas del Lenguaje', 3),
(161, 0, 'Lenguajes tecnológicos G1', 3),
(162, 0, 'Lenguajes tecnológicos G2', 3),
(163, 0, 'Procedimientos Técnicos G1', 3),
(164, 0, 'Procedimientos Técnicos G2', 3),
(165, 0, 'Sistemas Tecnológicos G1', 3),
(166, 0, 'Sistemas Tecnológicos G2', 3),
(167, 0, 'Biología', 6),
(168, 0, 'Ciudadanía', 6),
(169, 0, 'Artística', 6),
(170, 0, 'Educacíon Física', 6),
(171, 0, 'Fisicoquímica', 6),
(172, 0, 'Geografía', 6),
(173, 0, 'Historia', 6),
(174, 0, 'Ingles', 6),
(175, 0, 'Matemática', 6),
(176, 0, 'Prácticas del Lenguaje', 6),
(177, 0, 'Lenguajes tecnológicos G1', 6),
(178, 0, 'Lenguajes tecnológicos G2', 6),
(179, 0, 'Procedimientos Técnicos G1', 6),
(180, 0, 'Procedimientos Técnicos G2', 6),
(181, 0, 'Sistemas Tecnológicos G1', 6),
(182, 0, 'Sistemas Tecnológicos G2', 6),
(183, 0, 'Biología', 9),
(184, 0, 'Ciudadanía', 9),
(185, 0, 'Artística', 9),
(186, 0, 'Educacíon Física', 9),
(187, 0, 'Fisicoquímica', 9),
(188, 0, 'Geografía', 9),
(189, 0, 'Historia', 9),
(190, 0, 'Ingles', 9),
(191, 0, 'Matemática', 9),
(192, 0, 'Prácticas del Lenguaje', 9),
(193, 0, 'Lenguajes tecnológicos G1', 9),
(194, 0, 'Lenguajes tecnológicos G2', 9),
(195, 0, 'Procedimientos Técnicos G1', 9),
(196, 0, 'Procedimientos Técnicos G2', 9),
(197, 0, 'Sistemas Tecnológicos G1', 9),
(198, 0, 'Sistemas Tecnológicos G2', 9),
(199, 0, 'Biología', 12),
(200, 0, 'Ciudadanía', 12),
(201, 0, 'Artística', 12),
(202, 0, 'Educacíon Física', 12),
(203, 0, 'Fisicoquímica', 12),
(204, 0, 'Geografía', 12),
(205, 0, 'Historia', 12),
(206, 0, 'Ingles', 12),
(207, 0, 'Matemática', 12),
(208, 0, 'Prácticas del Lenguaje', 12),
(209, 0, 'Lenguajes tecnológicos G1', 12),
(210, 0, 'Lenguajes tecnológicos G2', 12),
(211, 0, 'Procedimientos Técnicos G1', 12),
(212, 0, 'Procedimientos Técnicos G2', 12),
(213, 0, 'Sistemas Tecnológicos G1', 12),
(214, 0, 'Sistemas Tecnológicos G2', 12),
(215, 0, 'Biología', 15),
(216, 0, 'Ciudadanía', 15),
(217, 0, 'Artística', 15),
(218, 0, 'Educacíon Física', 15),
(219, 0, 'Fisicoquímica', 15),
(220, 0, 'Geografía', 15),
(221, 0, 'Historia', 15),
(222, 0, 'Ingles', 15),
(223, 0, 'Matemática', 15),
(224, 0, 'Prácticas del Lenguaje', 15),
(225, 0, 'Lenguajes tecnológicos G1', 15),
(226, 0, 'Lenguajes tecnológicos G2', 15),
(227, 0, 'Procedimientos Técnicos G1', 15),
(228, 0, 'Procedimientos Técnicos G2', 15),
(229, 0, 'Sistemas Tecnológicos G1', 15),
(230, 0, 'Sistemas Tecnológicos G2', 15),
(231, 0, 'Educaciòn Física', 24),
(232, 0, 'Física', 24),
(233, 0, 'Geografía', 24),
(234, 0, 'Historia', 24),
(235, 0, 'Ingles', 24),
(236, 0, 'Literatura', 24),
(237, 0, 'Matemática', 24),
(238, 0, 'Química', 24),
(239, 0, 'Salud y Adolescencia', 24),
(240, 0, 'Conocimientos de los materiales G1', 24),
(241, 0, 'Conocimientos de los materiales G2', 24),
(242, 0, 'Diseño y proc. Mecánico G1', 24),
(243, 0, 'Diseño y proc. Mecánico G2', 24),
(244, 0, 'Dibujo tecnológico G1', 24),
(245, 0, 'Dibujo tecnológico G2', 24),
(246, 0, 'Inst. y aplicación de la Energía G1', 24),
(247, 0, 'Inst. y aplicación de la Energía G2', 24),
(248, 0, 'Maquinas elect. y automatismos G1', 24),
(249, 0, 'Maquinas elect. y automatismos G2', 24),
(250, 0, 'Educacíon Física', 28),
(251, 0, 'Física', 28),
(252, 0, 'Geografía', 28),
(253, 0, 'Historia', 28),
(254, 0, 'Ingles', 28),
(255, 0, 'Literatura', 28),
(256, 0, 'Matemática', 28),
(257, 0, 'Química', 28),
(258, 0, 'Salud y Adolescencia', 28),
(259, 0, 'Dispositivos electrónicos G1', 28),
(260, 0, 'Dispositivos electrónicos G2', 28),
(261, 0, 'Electrónica Analógica I G1', 28),
(262, 0, 'Electrónica Analógica I G2', 28),
(263, 0, 'Electrónica Digital I G1', 28),
(264, 0, 'Electrónica Digital I G2', 28),
(265, 0, 'Fundamentos de los modelos circuitales G1', 28),
(266, 0, 'Fundamentos de los modelos circuitales G1', 28),
(267, 0, 'Producción Electrónica I G1', 28),
(268, 0, 'Producción Electrónica I G2', 28);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_profesor` (`id_profesor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `materias_ibfk_2` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
