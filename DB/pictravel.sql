-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-03-2020 a las 14:50:35
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id11799647_flixtagram`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `idCom` int(11) NOT NULL,
  `textCom` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `dateCom` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUsu` int(11) DEFAULT NULL,
  `idPub` int(11) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`idCom`, `textCom`, `dateCom`, `idUsu`, `idPub`, `update_at`) VALUES
(21, 'Ahí he estado yo!!!', '2020-02-26 16:58:42', 20, 21, NULL),
(22, 'Pues me alegro!', '2020-02-26 16:59:04', 22, 21, NULL),
(25, 'Era navidad', '2020-02-26 17:45:09', 22, 21, '2020-03-01 21:44:09'),
(30, 'Me encanta el molino!', '2020-02-26 18:31:57', 22, 20, NULL),
(32, 'Vaya tiempo más bueno que hace por allí Pablo!', '2020-02-27 22:31:46', 43, 28, NULL),
(33, 'Pues la verdad que sí Matías', '2020-02-27 22:33:06', 45, 28, NULL),
(34, 'A ver si me paso un diíta de estos por Madrid y nos echamos unos vinillos!', '2020-02-27 22:34:37', 43, 28, NULL),
(36, 'Como se nota que manejas money Matías!!!', '2020-02-27 22:41:22', 20, 29, NULL),
(37, 'Vaya vistas más bonitas de Barcelona!!!!', '2020-02-27 22:42:42', 22, 29, NULL),
(38, 'Invitada que estás rubia!!!', '2020-02-27 22:44:22', 43, 29, NULL),
(41, 'Esa playa me suena a mi!\r\nPor dónde queda??', '2020-02-29 01:33:09', 44, 31, NULL),
(52, 'Me gusta la playa, la compro!', '2020-02-29 20:16:36', 42, 31, NULL),
(58, 'bueno,pero me dejarás pisarla no trumpy??', '2020-02-29 21:20:07', 44, 31, NULL),
(59, 'La verdad que ya llega el buen tiempo!!', '2020-03-01 21:44:59', 20, 30, NULL),
(60, 'pues siii, ya se está genial en la playa!', '2020-03-01 21:45:34', 22, 30, NULL),
(61, 'oye,te apuntas mañana a la playita un ratito??\r\nyo pongo las birras!', '2020-03-01 21:47:03', 20, 30, '2020-03-01 21:49:22'),
(62, 'Mirando pa cuenca!!!', '2020-03-01 22:08:49', 20, 18, NULL),
(63, 'Lorem fistrum tiene musho peligro hasta luego Lucas a peich torpedo ese hombree quietooor fistro de la pradera quietooor. Amatomaa a peich ese pedazo ', '2020-03-02 14:45:36', 42, 40, NULL),
(64, 'No te digo trigo por no llamarte Rodrigor se calle ustée te voy a borrar el cerito te va a hasé pupitaa fistro mamaar fistro. Me cago en tus muelas te', '2020-03-02 14:48:23', 44, 40, NULL),
(65, 'Pero que estáis diciendo???\r\nno me entero', '2020-03-02 14:49:13', 20, 40, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE `foto` (
  `idFoto` int(11) NOT NULL,
  `shows` int(6) NOT NULL DEFAULT 0,
  `description` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'En algún lugar...',
  `nameFoto` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'images/publicaciones/' COMMENT 'ruta/nombre de la foto.',
  `dateFoto` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUsu` int(11) DEFAULT NULL,
  `idPub` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`idFoto`, `shows`, `description`, `place`, `nameFoto`, `dateFoto`, `idUsu`, `idPub`) VALUES
(15, 12, 'Cerquita de cuenca', 'Cuenca, alrededores', 'images/publicaciones/20_20191208_114538.jpg', '2020-02-26 03:43:39', 20, 18),
(17, 34, 'Tierras de don quijote.', 'Castilla la mancha', 'images/publicaciones/20_20191209_165542.jpg', '2020-02-26 16:36:19', 20, 20),
(18, 12, 'Vista del puente y del alzcázar de toledo en navidad', 'Toledo', 'images/publicaciones/22_20191209_145735.jpg', '2020-02-26 16:57:07', 22, 21),
(19, 7, 'Atardecer en Málaga,playa de la malagueta', 'Málaga', 'images/publicaciones/20_IMG_20200209_182933.jpg', '2020-02-26 20:25:14', 20, 22),
(22, 10, 'Vista del puerto desde el paseo marítimo', 'Málaga', 'images/publicaciones/20_20191104_125506.jpg', '2020-02-27 14:49:03', 20, 23),
(27, 44, 'Vista del monumento de la fuente de cibeles', 'Madrid', 'images/publicaciones/45_madrid-1-1024x702.jpg', '2020-02-27 22:27:26', 45, 28),
(28, 70, 'Vista de la ciudad de Barcelona desde el premium suite hotels', 'Barcelona', 'images/publicaciones/43_Par-Guell-1.jpg', '2020-02-27 22:30:09', 43, 29),
(29, 64, 'Buen tiempo ahora por Málaga,hace hasta día de playa!', 'Málaga, playa de la malagueta', 'images/publicaciones/22_IMG_20200209_171938.jpg', '2020-02-27 22:51:59', 22, 30),
(30, 33, 'Disfrutando de un fin de semana en la playita, para desconectar de la abadía', 'Algarve, Portugal', 'images/publicaciones/40_DSCF3021.JPG', '2020-02-28 23:44:32', 40, 31),
(31, 27, 'A la derecha, puede observarse la Abadía de westminster', 'Londres, UK', 'images/publicaciones/40_westminster.jpeg', '2020-02-28 23:53:41', 40, 32),
(32, 52, 'Las famosas casas colgadas de cuenca', 'Cuenca', 'images/publicaciones/20_20191207_155454.jpg', '2020-02-29 00:49:59', 20, 33),
(33, 55, 'Visitando el centro histórico y alrededores de Córdoba capital', 'Córdoba,centro histórico', 'images/publicaciones/20_20191206_135250.jpg', '2020-02-29 03:13:10', 20, 34),
(37, 127, 'Vista del cabo san vicente', 'Algarve, Portugal', 'images/publicaciones/20_DSCF3093.JPG', '2020-02-29 22:36:42', 20, 38),
(38, 1, 'La entrada de mi casa más apañá que ná', 'Whasinghton, EEUU', 'images/publicaciones/42_Casa-Blanca.jpg', '2020-03-01 23:24:39', 42, 39),
(39, 4, ' Por la gloria de mi madre llevame al sircoo condemor a gramenawer a peich ahorarr hasta luego Lucas. Te va a hasé pupitaa sexuarl torpedo me cago en tus muelas', 'Lorem chiquito', 'images/publicaciones/44_DSCF3209.JPG', '2020-03-02 14:44:12', 44, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idPub` int(11) NOT NULL,
  `datePub` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUsu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idPub`, `datePub`, `idUsu`) VALUES
(18, '2020-02-26 03:43:39', 20),
(20, '2020-02-26 16:36:19', 20),
(21, '2020-02-26 16:57:07', 22),
(22, '2020-02-26 20:25:14', 20),
(23, '2020-02-27 14:49:03', 20),
(28, '2020-02-27 22:27:26', 45),
(29, '2020-02-27 22:30:09', 43),
(30, '2020-02-27 22:51:59', 22),
(31, '2020-02-28 23:44:32', 40),
(32, '2020-02-28 23:53:41', 40),
(33, '2020-02-29 00:49:59', 20),
(34, '2020-02-29 03:13:09', 20),
(38, '2020-02-29 22:36:41', 20),
(39, '2020-03-01 23:24:39', 42),
(40, '2020-03-02 14:44:12', 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsu` int(11) NOT NULL,
  `nameUsu` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nick` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `imgUser` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'images/perfil/sin.jpg',
  `bioUser` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Sobre mí...',
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `passUsu` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `rol` tinyint(4) NOT NULL DEFAULT 0,
  `altaUsu` timestamp NOT NULL DEFAULT current_timestamp(),
  `apiKey` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsu`, `nameUsu`, `nick`, `imgUser`, `bioUser`, `email`, `passUsu`, `rol`, `altaUsu`, `apiKey`) VALUES
(20, 'David Pérez Pardo', 'ElCreadorDeEsto', 'images/perfil/20_IMG_20200209_173240.jpg', 'Estudiante de Ciclo superior de desarrollo de aplicaciones web - I.E.S Campanillas (Málaga)', 'david@gmail.com', '202cb962ac59075b964b07152d234b70', 0, '2020-02-15 20:20:06', NULL),
(22, 'marta', 'RubiaCañón', 'images/perfil/22_capturadepantalla20180531alas052300pm-81d66f54170a6c1a42ffc7475b14b641-900x600.jpg', 'Soy rubia natural!', 'marta@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-15 22:16:36', NULL),
(40, 'Fray Leopoldo', 'eldeAlpandeire', 'images/perfil/40_Monje-con-cerveza.jpg', 'Soy Fraile, aficionado al golf y a los carnavales.\r\nEstoy soltero!', 'fray@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-25 21:22:54', NULL),
(41, 'Admin', 'admin', 'images/perfil/sin.jpg', 'Sobre mí...', 'admin@gmail.com', '96e79218965eb72c92a549dd5a330112', 1, '2020-02-26 18:53:51', NULL),
(42, 'Donald', 'Super Trump', 'images/perfil/42_bad-donald-trump-tattoos-funny-face.jpg', 'Presidente de USA en mi tiempo libre', 'donald@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-26 20:29:32', NULL),
(43, 'Matías', 'Mati', 'images/perfil/43_matias-prats-kb9D-U213746149101COC-660x371@RC-U30620924448F8D--624x385@Hoy-Hoy.jpg', 'Apasionado de las noticias', 'matias@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-26 20:38:16', '3b4c944a9c6dea37d5b3c4e3e70336a4'),
(44, 'Rocky', 'Balboa', 'images/perfil/44_rocky3f53f8c2_65609be7.jpg', 'Dándole al saco todo el día', 'rocky@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-26 20:39:20', NULL),
(45, 'Pablo', 'Pablito', 'images/perfil/45_pablo-motos-2.jpeg', 'Salgo en la tele!', 'pablo@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, '2020-02-26 20:41:03', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`idCom`),
  ADD KEY `comentario_ibfk_1` (`idUsu`),
  ADD KEY `fk_idPub` (`idPub`);

--
-- Indices de la tabla `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`idFoto`),
  ADD KEY `idUsu` (`idUsu`),
  ADD KEY `fk_idPub2` (`idPub`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPub`),
  ADD KEY `idUsu` (`idUsu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `idCom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `foto`
--
ALTER TABLE `foto`
  MODIFY `idFoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`idUsu`) REFERENCES `usuario` (`idUsu`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPub` FOREIGN KEY (`idPub`) REFERENCES `publicacion` (`idPub`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `fk_idPub2` FOREIGN KEY (`idPub`) REFERENCES `publicacion` (`idPub`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`idUsu`) REFERENCES `usuario` (`idUsu`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`idUsu`) REFERENCES `usuario` (`idUsu`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
