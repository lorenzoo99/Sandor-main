-- Script completo para verificar y crear TODAS las tablas necesarias
-- FarmaProf - Sistema Contable Completo
-- Ejecutar este script creará TODAS las tablas si no existen

USE sandor;

-- ==========================================
-- TABLAS DE CONTABILIDAD
-- ==========================================

-- Tabla: CuentaContable
CREATE TABLE IF NOT EXISTS CuentaContable (
    id_cuenta INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    tipo ENUM('ACTIVO', 'PASIVO', 'PATRIMONIO', 'INGRESO', 'GASTO') NOT NULL,
    nivel TINYINT NOT NULL COMMENT '1=Clase, 2=Grupo, 3=Cuenta, 4=Subcuenta',
    estado TINYINT(1) DEFAULT 1,
    INDEX idx_codigo (codigo),
    INDEX idx_tipo (tipo),
    INDEX idx_nivel (nivel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: AsientoContable
CREATE TABLE IF NOT EXISTS AsientoContable (
    id_asiento INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    descripcion TEXT NOT NULL,
    id_usuario INT NOT NULL,
    total_debito DECIMAL(15,2) NOT NULL,
    total_credito DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES users(id_usuario) ON DELETE RESTRICT,
    INDEX idx_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: DetalleAsiento
CREATE TABLE IF NOT EXISTS DetalleAsiento (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_asiento INT NOT NULL,
    id_cuenta INT NOT NULL,
    tipo_movimiento ENUM('DEBITO', 'CREDITO') NOT NULL,
    valor DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_asiento) REFERENCES AsientoContable(id_asiento) ON DELETE CASCADE,
    FOREIGN KEY (id_cuenta) REFERENCES CuentaContable(id_cuenta) ON DELETE RESTRICT,
    INDEX idx_asiento (id_asiento),
    INDEX idx_cuenta (id_cuenta),
    INDEX idx_tipo_movimiento (tipo_movimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLAS DE NÓMINA
-- ==========================================

-- Tabla: Empleado
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

-- Tabla: Nomina
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

-- ==========================================
-- VERIFICACIÓN DE TABLAS
-- ==========================================

-- Mostrar un resumen de las tablas creadas
SELECT 'Verificación de tablas completada' as mensaje;

-- Para verificar las tablas creadas, ejecuta después:
-- SHOW TABLES;
