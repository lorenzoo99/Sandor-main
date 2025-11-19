-- Agregar columna estado a la tabla Empleado
-- Esta columna indica si el empleado está activo (1) o inactivo (0)

USE sandor;

-- Agregar columna estado si no existe
ALTER TABLE Empleado
ADD COLUMN IF NOT EXISTS estado TINYINT(1) NOT NULL DEFAULT 1
COMMENT '1=Activo, 0=Inactivo';

-- Crear índice para búsquedas más rápidas por estado
ALTER TABLE Empleado
ADD INDEX IF NOT EXISTS idx_estado (estado);

-- Verificar que la columna se agregó correctamente
SELECT 'Columna estado agregada exitosamente. Verificando estructura completa:' as mensaje;
DESCRIBE Empleado;

-- Mostrar el total de empleados por estado
SELECT
    CASE WHEN estado = 1 THEN 'Activos' ELSE 'Inactivos' END as Estado,
    COUNT(*) as Total
FROM Empleado
GROUP BY estado;
