-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-04-2026 a las 20:17:55
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id_notif` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci,
  `leido` tinyint(1) DEFAULT '0',
  `fecha_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notif`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `cliente_id` int DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `cliente_id` (`cliente_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_documentos`
--

DROP TABLE IF EXISTS `proyectos_documentos`;
CREATE TABLE IF NOT EXISTS `proyectos_documentos` (
  `id_doc` int NOT NULL AUTO_INCREMENT,
  `id_proyecto` int DEFAULT NULL,
  `ruta_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_original` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `id_proyecto` (`id_proyecto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id_ticket` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('abierto','en_proceso','resuelto','cerrado') COLLATE utf8mb4_unicode_ci DEFAULT 'abierto',
  `archivo_adjunto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `asignado_a` int DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_tramite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `observaciones_finales` text COLLATE utf8mb4_unicode_ci,
  `finalizado_por` int DEFAULT NULL,
  PRIMARY KEY (`id_ticket`),
  KEY `usuario_id` (`usuario_id`),
  KEY `asignado_a` (`asignado_a`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `titulo`, `descripcion`, `estado`, `archivo_adjunto`, `usuario_id`, `asignado_a`, `fecha_creacion`, `tipo_tramite`, `observaciones_finales`, `finalizado_por`) VALUES
(1, 'problema legal', 'denuncia por egresión ', 'abierto', NULL, 5, NULL, '2026-04-18 20:15:49', 'general', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('superadmin','administrativo','profesional','cliente','prospecto') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `telefono`) VALUES
(4, 'Cristian Rufiño', 'cristianrufi@gmail.com', '$2y$10$JSRImSdRLjdnjZyRLtNVGuAn/XNYyVTc6ZV2nTLxBoTcOJtoDkFEy', 'profesional', NULL),
(3, 'Super Administrador', 'admin@gestor.com', '$2y$12$/k7XfS8wf1SZ.E77Z.ohve.sUgYyu2Q8g6skvfMqNoVmcR5dg7TAm', 'superadmin', NULL),
(5, 'Josefino', 'josefino@josefino.com', '$2y$10$UbmUznLrCqfHAUveEoXjM.GtCJ9ROfw0i77Q0sXVpplx/JwMI/ORK', 'cliente', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
