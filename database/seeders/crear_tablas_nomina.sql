-- Tablas para el módulo de Nómina
-- FarmaProf - Sistema Contable

USE sandor;

-- ==========================================
-- Tabla: Empleado
-- ==========================================
CREATE TABLE IF NOT EXISTS Empleado (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    tipo_identificacion ENUM('CC', 'CE', 'NIT') NOT NULL,
    numero_identificacion VARCHAR(30) NOT NULL UNIQUE,
    cargo VARCHAR(100) NOT NULL,
    salario_base DECIMAL(15,2) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    telefono VARCHAR(30) NULL,
    correo VARCHAR(100) NULL,
    direccion VARCHAR(200) NULL,
    estado TINYINT(1) DEFAULT 1,
    INDEX idx_numero_identificacion (numero_identificacion),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Tabla: Nomina
-- ==========================================
CREATE TABLE IF NOT EXISTS Nomina (
    id_nomina INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT NOT NULL,
    periodo VARCHAR(7) NOT NULL COMMENT 'Formato: YYYY-MM',
    fecha_pago DATE NOT NULL,
    salario_base DECIMAL(15,2) NOT NULL,
    deduccion_salud DECIMAL(15,2) NOT NULL DEFAULT 0,
    deduccion_pension DECIMAL(15,2) NOT NULL DEFAULT 0,
    total_deducciones DECIMAL(15,2) NOT NULL DEFAULT 0,
    salario_neto DECIMAL(15,2) NOT NULL,
    estado ENUM('PENDIENTE', 'PAGADA') DEFAULT 'PENDIENTE',
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES users(id_usuario) ON DELETE RESTRICT,
    INDEX idx_empleado (id_empleado),
    INDEX idx_periodo (periodo),
    INDEX idx_estado (estado),
    UNIQUE KEY unique_empleado_periodo (id_empleado, periodo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
