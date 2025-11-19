-- Agregar columnas faltantes a la tabla Empleado
-- Ejecuta este script si la tabla Empleado ya existe pero le faltan columnas

USE sandor;

-- Agregar columna telefono si no existe
ALTER TABLE Empleado
ADD COLUMN IF NOT EXISTS telefono VARCHAR(30) NULL AFTER fecha_ingreso;

-- Agregar columna correo si no existe
ALTER TABLE Empleado
ADD COLUMN IF NOT EXISTS correo VARCHAR(100) NULL AFTER telefono;

-- Agregar columna direccion si no existe
ALTER TABLE Empleado
ADD COLUMN IF NOT EXISTS direccion VARCHAR(200) NULL AFTER correo;

-- Verificar que las columnas se agregaron correctamente
SELECT 'Columnas agregadas exitosamente. Verificando estructura:' as mensaje;
DESCRIBE Empleado;
