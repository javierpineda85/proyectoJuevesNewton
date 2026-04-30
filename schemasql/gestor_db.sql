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

--Estructura de tipos de trámite por cada empresa
CREATE TABLE tipos_tramites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL, 
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    INDEX idx_empresa (empresa_id)
) ENGINE=InnoDB;

--  Tabla Trámites
CREATE TABLE tramites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    cliente_id INT NOT NULL,
    tipo_tramite_id INT NOT NULL,
    responsable_id INT DEFAULT NULL, -- Relación con tu tabla de usuarios/empleados
    
    -- Datos del responsable 
    responsable_nombre VARCHAR(150),
    responsable_cargo VARCHAR(100),
    
    estado ENUM('pendiente', 'en proceso', 'observado', 'aprobado', 'rechazado', 'vencido', 'finalizado') DEFAULT 'pendiente',
    prioridad ENUM('baja', 'media', 'alta', 'urgente') DEFAULT 'media',
    
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_vencimiento DATETIME,
    observaciones_generales TEXT,
    
    INDEX idx_busqueda_cliente (empresa_id, cliente_id),
    INDEX idx_busqueda_estado (empresa_id, estado),
    INDEX idx_busqueda_vencimiento (empresa_id, fecha_vencimiento),
    
    CONSTRAINT fk_tipo_tramite FOREIGN KEY (tipo_tramite_id) REFERENCES tipos_tramites(id)
) ENGINE=InnoDB;

-- Historial para seguimiento
CREATE TABLE tramites_historial (
id INT AUTO_INCREMENT PRIMARY KEY,
tramite_id INT NOT NULL,
usuario_id INT NOT NULL, -- Quién hizo el cambio

estado_anterior VARCHAR(50),
estado_nuevo VARCHAR(50),
 responsable_anterior_id INT,
 responsable_nuevo_id INT,

observacion_cambio TEXT,
fecha_cambio DATETIME DEFAULT CURRENT_TIMESTAMP,

 CONSTRAINT fk_historial_tramite FOREIGN KEY (tramite_id) REFERENCES tramites(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla Empresas

CREATE TABLE empresas (
  id INT AUTO_INCREMENT PRIMARY KEY,
nombre_comercial VARCHAR(150) NOT NULL,
cuit VARCHAR(20) UNIQUE NOT NULL,
fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

--Agregar empresa_id a las tablas existentes para relacionarlas con la tabla empresas

--  Tabla proyectos
ALTER TABLE proyectos ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE proyectos ADD INDEX idx_proyectos_empresa (empresa_id);
ALTER TABLE proyectos ADD CONSTRAINT fk_proyectos_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

-- Tabla proyectos_documentos
ALTER TABLE proyectos_documentos ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE proyectos_documentos ADD INDEX idx_docs_empresa (empresa_id);
ALTER TABLE proyectos_documentos ADD CONSTRAINT fk_docs_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

--  Tabla tickets
ALTER TABLE tickets ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE tickets ADD INDEX idx_tickets_empresa (empresa_id);
ALTER TABLE tickets ADD CONSTRAINT fk_tickets_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

--  Tabla tipos_tramites
ALTER TABLE tipos_tramites ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE tipos_tramites ADD INDEX idx_tipos_empresa (empresa_id);
ALTER TABLE tipos_tramites ADD CONSTRAINT fk_tipos_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

-- 5. Tabla tramites
ALTER TABLE tramites ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE tramites ADD INDEX idx_tramites_empresa (empresa_id);
ALTER TABLE tramites ADD CONSTRAINT fk_tramites_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

--  Tabla tramites_historial
ALTER TABLE tramites_historial ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE tramites_historial ADD INDEX idx_historial_empresa (empresa_id);
ALTER TABLE tramites_historial ADD CONSTRAINT fk_historial_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

--Tabla de motor InnoDB

ALTER TABLE empresas ENGINE=InnoDB;
ALTER TABLE notificaciones ENGINE=InnoDB;
ALTER TABLE proyectos ENGINE=InnoDB;
ALTER TABLE proyectos_documentos ENGINE=InnoDB;
ALTER TABLE tickets ENGINE=InnoDB;
ALTER TABLE tipos_tramites ENGINE=InnoDB;
ALTER TABLE tramites ENGINE=InnoDB;
ALTER TABLE tramites_historial ENGINE=InnoDB;
ALTER TABLE usuarios ENGINE=InnoDB;