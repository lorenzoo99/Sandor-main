-- Agregar campo tipo_factura a la tabla FacturaVenta
-- Esto permite diferenciar entre factura electrónica (con datos de cliente completos)
-- y factura normal/POS (venta rápida sin datos de cliente)

USE sandor;

ALTER TABLE FacturaVenta
ADD COLUMN tipo_factura ENUM('ELECTRONICA', 'NORMAL') DEFAULT 'ELECTRONICA' AFTER numero_factura;

-- Hacer id_cliente nullable para permitir facturas normales sin cliente
ALTER TABLE FacturaVenta
MODIFY COLUMN id_cliente INT NULL;
