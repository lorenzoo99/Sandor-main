-- Tabla de Productos para FarmaProf
-- Catálogo de medicamentos y productos de la farmacia

USE sandor;

-- Crear tabla Producto
CREATE TABLE IF NOT EXISTS Producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE COMMENT 'Código o referencia del producto',
    nombre VARCHAR(200) NOT NULL COMMENT 'Nombre del producto',
    descripcion TEXT NULL COMMENT 'Descripción detallada',
    precio DECIMAL(15,2) NOT NULL COMMENT 'Precio unitario sin IVA',
    porcentaje_iva DECIMAL(5,2) NOT NULL DEFAULT 0 COMMENT 'Porcentaje de IVA (0, 5 o 19)',
    stock INT NOT NULL DEFAULT 0 COMMENT 'Cantidad en inventario',
    estado TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Activo, 0=Inactivo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_codigo (codigo),
    INDEX idx_nombre (nombre),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos productos de ejemplo
INSERT INTO Producto (codigo, nombre, descripcion, precio, porcentaje_iva, stock, estado) VALUES
('MED001', 'Acetaminofén 500mg x 20 tabletas', 'Analgésico y antipirético', 8000.00, 0, 100, 1),
('MED002', 'Ibuprofeno 400mg x 30 tabletas', 'Antiinflamatorio no esteroideo', 12000.00, 0, 80, 1),
('MED003', 'Omeprazol 20mg x 14 cápsulas', 'Inhibidor de bomba de protones', 15000.00, 0, 50, 1),
('MED004', 'Loratadina 10mg x 10 tabletas', 'Antihistamínico para alergias', 6000.00, 0, 120, 1),
('VITA001', 'Vitamina C 1000mg x 30 cápsulas', 'Suplemento vitamínico', 35000.00, 5, 60, 1),
('VITA002', 'Complejo B x 30 tabletas', 'Vitaminas del complejo B', 28000.00, 5, 45, 1),
('COSM001', 'Crema Hidratante Nivea 200ml', 'Crema para piel seca', 25000.00, 19, 30, 1),
('COSM002', 'Protector Solar FPS 50+ 120ml', 'Protección solar UVA/UVB', 45000.00, 19, 25, 1),
('HIG001', 'Alcohol Antiséptico 70% 500ml', 'Desinfectante de uso externo', 8500.00, 19, 100, 1),
('HIG002', 'Tapabocas Quirúrgico x 50 unidades', 'Tapabocas desechables triple capa', 35000.00, 19, 200, 1);

-- Verificar los productos insertados
SELECT 'Productos de ejemplo insertados exitosamente' as mensaje;
SELECT * FROM Producto ORDER BY codigo;
