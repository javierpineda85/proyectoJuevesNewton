/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
-- 1. TABLAS BASE (Estructura Multiempresa)
-- --------------------------------------------------------

-- Tabla de Empresas
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_comercial VARCHAR(150) NOT NULL,
    cuit VARCHAR(20) UNIQUE NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- 2. TABLAS DEPENDIENTES (Trámites y Configuración)
-- --------------------------------------------------------

-- Tipos de trámite configurables por cada empresa
CREATE TABLE tipos_tramites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    
    INDEX idx_tipos_empresa (empresa_id),
    CONSTRAINT fk_tipos_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla Principal de Trámites
CREATE TABLE tramites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    cliente_id INT NOT NULL,
    tipo_tramite_id INT NOT NULL,
    
    -- Relación con tabla de usuarios
    responsable_id INT DEFAULT NULL, 
    
    -- Datos del responsable (para cuando es externo o queremos registro rápido)
    responsable_nombre VARCHAR(150),
    responsable_cargo VARCHAR(100),
    
    estado VARCHAR(50) DEFAULT 'Pendiente',
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    vencimiento DATETIME,
    observaciones TEXT,
    
    -- Índices para optimizar búsquedas
    INDEX idx_busqueda_cliente (empresa_id, cliente_id),
    INDEX idx_busqueda_estado (empresa_id, estado),
    INDEX idx_busqueda_vencimiento (empresa_id, vencimiento),
    INDEX idx_tramites_empresa (empresa_id),
    
    -- Relaciones de integridad
    CONSTRAINT fk_tramites_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE,
    CONSTRAINT fk_tipo_tramite FOREIGN KEY (tipo_tramite_id) REFERENCES tipos_tramites(id)
) ENGINE=InnoDB;

-- Historial para seguimiento de cambios
CREATE TABLE tramites_historial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tramite_id INT NOT NULL,
    usuario_id INT NOT NULL, -- Quién hizo el cambio
    
    estado_anterior VARCHAR(50),
    estado_nuevo VARCHAR(50),
    responsable_anterior_id INT,
    responsable_nuevo_id INT,
    
    observacion_cambio TEXT,
    fecha_cambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Índices y relaciones
    INDEX idx_historial_empresa (empresa_id),
    CONSTRAINT fk_historial_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE,
    CONSTRAINT fk_historial_tramite FOREIGN KEY (tramite_id) REFERENCES tramites(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- 3. ACTUALIZACIONES A TABLAS EXISTENTES
-- --------------------------------------------------------

-- Agregado de empresa_id a tablas existentes para vincular con empresas

-- Tabla proyectos
ALTER TABLE proyectos ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE proyectos ADD INDEX idx_proyectos_empresa (empresa_id);
ALTER TABLE proyectos ADD CONSTRAINT fk_proyectos_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

-- Tabla proyectos_documentos
ALTER TABLE proyectos_documentos ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE proyectos_documentos ADD INDEX idx_docs_empresa (empresa_id);
ALTER TABLE proyectos_documentos ADD CONSTRAINT fk_docs_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

-- Tabla tickets
ALTER TABLE tickets ADD COLUMN empresa_id INT NOT NULL;
ALTER TABLE tickets ADD INDEX idx_tickets_empresa (empresa_id);
ALTER TABLE tickets ADD CONSTRAINT fk_tickets_empresa FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE;

-- --------------------------------------------------------
-- 4. CONFIGURACIÓN DE MOTOR (Garantizar soporte de Transacciones y FK)
-- --------------------------------------------------------

ALTER TABLE notificaciones ENGINE=InnoDB;
ALTER TABLE proyectos ENGINE=InnoDB;
ALTER TABLE proyectos_documentos ENGINE=InnoDB;
ALTER TABLE tickets ENGINE=InnoDB;
ALTER TABLE usuarios ENGINE=InnoDB;