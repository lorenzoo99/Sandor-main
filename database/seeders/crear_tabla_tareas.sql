-- Crear tabla de Tareas Pendientes
CREATE TABLE IF NOT EXISTS TareaPendiente (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    prioridad ENUM('alta', 'media', 'baja') NOT NULL DEFAULT 'media',
    completada TINYINT(1) NOT NULL DEFAULT 0,
    id_usuario INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_completada TIMESTAMP NULL,
    INDEX idx_usuario (id_usuario),
    INDEX idx_completada (completada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunas tareas de ejemplo
INSERT INTO TareaPendiente (descripcion, prioridad, id_usuario) VALUES
('Revisar facturas pendientes de aprobación', 'alta', 1),
('Conciliación bancaria mensual', 'alta', 1),
('Actualizar datos de proveedores', 'baja', 1);
