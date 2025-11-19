-- Verificar y arreglar la tabla Nomina
-- Agrega todas las columnas necesarias si faltan

USE sandor;

-- Verificar si la tabla Nomina existe
SELECT 'Verificando tabla Nomina...' as mensaje;

-- Si la tabla no existe, crearla completa
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
    INDEX idx_empleado (id_empleado),
    INDEX idx_periodo (periodo),
    INDEX idx_estado (estado),
    UNIQUE KEY unique_empleado_periodo (id_empleado, periodo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Si la tabla ya existe pero le faltan columnas, agregarlas una por una

-- Agregar id_empleado si no existe
SET @dbname = DATABASE();
SET @tablename = 'Nomina';
SET @columnname = 'id_empleado';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' INT NOT NULL AFTER id_nomina')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar periodo si no existe
SET @columnname = 'periodo';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' VARCHAR(7) NOT NULL COMMENT "Formato: YYYY-MM"')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar fecha_pago si no existe
SET @columnname = 'fecha_pago';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DATE NOT NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar salario_base si no existe
SET @columnname = 'salario_base';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DECIMAL(15,2) NOT NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar deduccion_salud si no existe
SET @columnname = 'deduccion_salud';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DECIMAL(15,2) NOT NULL DEFAULT 0')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar deduccion_pension si no existe
SET @columnname = 'deduccion_pension';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DECIMAL(15,2) NOT NULL DEFAULT 0')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar total_deducciones si no existe
SET @columnname = 'total_deducciones';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DECIMAL(15,2) NOT NULL DEFAULT 0')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar salario_neto si no existe
SET @columnname = 'salario_neto';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' DECIMAL(15,2) NOT NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar estado si no existe
SET @columnname = 'estado';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  'ALTER TABLE Nomina ADD COLUMN estado ENUM("PENDIENTE", "PAGADA") DEFAULT "PENDIENTE"'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Agregar id_usuario si no existe
SET @columnname = 'id_usuario';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' INT NOT NULL')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Verificar estructura final
SELECT 'Estructura final de la tabla Nomina:' as mensaje;
DESCRIBE Nomina;
