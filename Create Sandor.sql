use sandor;

CREATE TABLE `Usuario` (
  `id_usuario` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100),
  `correo` varchar(100) UNIQUE,
  `contraseña_hash` varchar(255),
  `rol` enum('SUPERADMIN','CLIENTE_SAAS'),
  `fecha_creacion` datetime,
  `activo` boolean
);

CREATE TABLE `Cliente` (
  `id_cliente` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(150),
  `tipo_identificacion` enum('CC','NIT'),
  `numero_identificacion` varchar(30),
  `direccion` varchar(200),
  `telefono` varchar(30),
  `correo` varchar(100),
  `fecha_registro` datetime
);

CREATE TABLE `Proveedor` (
  `id_proveedor` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(150),
  `nit` varchar(30),
  `direccion` varchar(200),
  `telefono` varchar(30),
  `correo` varchar(100),
  `fecha_registro` datetime
);

CREATE TABLE `CuentaContable` (
  `id_cuenta` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(20) UNIQUE,
  `nombre` varchar(150),
  `tipo` enum('ACTIVO','PASIVO','PATRIMONIO','INGRESO','GASTO'),
  `nivel` int,
  `estado` boolean
);

CREATE TABLE `AsientoContable` (
  `id_asiento` int PRIMARY KEY AUTO_INCREMENT,
  `fecha` date,
  `descripcion` varchar(255),
  `id_usuario` int,
  `total_debito` decimal(15,2),
  `total_credito` decimal(15,2)
);

CREATE TABLE `DetalleAsiento` (
  `id_detalle` int PRIMARY KEY AUTO_INCREMENT,
  `id_asiento` int,
  `id_cuenta` int,
  `tipo_movimiento` enum('DEBITO','CREDITO'),
  `valor` decimal(15,2)
);

CREATE TABLE `FacturaVenta` (
  `id_factura` int PRIMARY KEY AUTO_INCREMENT,
  `numero_factura` varchar(30),
  `fecha_emision` date,
  `id_cliente` int,
  `subtotal` decimal(15,2),
  `iva` decimal(15,2),
  `total` decimal(15,2),
  `estado` enum('PENDIENTE','PAGADA','ANULADA'),
  `id_usuario` int
);

CREATE TABLE `DetalleFacturaVenta` (
  `id_detalle` int PRIMARY KEY AUTO_INCREMENT,
  `id_factura` int,
  `descripcion` varchar(255),
  `cantidad` int,
  `valor_unitario` decimal(15,2),
  `subtotal` decimal(15,2),
  `iva` decimal(15,2),
  `total` decimal(15,2)
);

CREATE TABLE `PagoCliente` (
  `id_pago` int PRIMARY KEY AUTO_INCREMENT,
  `id_factura` int,
  `fecha_pago` date,
  `monto` decimal(15,2),
  `metodo_pago` varchar(50),
  `observacion` varchar(255)
);

CREATE TABLE `FacturaCompra` (
  `id_factura_compra` int PRIMARY KEY AUTO_INCREMENT,
  `numero_factura` varchar(30),
  `id_proveedor` int,
  `fecha_emision` date,
  `subtotal` decimal(15,2),
  `iva` decimal(15,2),
  `total` decimal(15,2),
  `estado` enum('PENDIENTE','PAGADA','ANULADA'),
  `id_usuario` int
);

CREATE TABLE `PagoProveedor` (
  `id_pago` int PRIMARY KEY AUTO_INCREMENT,
  `id_factura_compra` int,
  `fecha_pago` date,
  `monto` decimal(15,2),
  `metodo_pago` varchar(50),
  `observacion` varchar(255)
);

CREATE TABLE `Empleado` (
  `id_empleado` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(150),
  `tipo_identificacion` enum('CC','CE','NIT'),
  `numero_identificacion` varchar(30),
  `cargo` varchar(100),
  `salario_base` decimal(15,2),
  `fecha_ingreso` date,
  `activo` boolean
);

CREATE TABLE `Nomina` (
  `id_nomina` int PRIMARY KEY AUTO_INCREMENT,
  `periodo` varchar(6),
  `fecha_pago` date,
  `total_salarios` decimal(15,2),
  `total_deducciones` decimal(15,2),
  `total_neto` decimal(15,2),
  `id_usuario` int
);

CREATE TABLE `DetalleNomina` (
  `id_detalle` int PRIMARY KEY AUTO_INCREMENT,
  `id_nomina` int,
  `id_empleado` int,
  `salario_base` decimal(15,2),
  `deducciones` decimal(15,2),
  `neto_pagado` decimal(15,2)
);

CREATE TABLE `Auditoria` (
  `id_auditoria` int PRIMARY KEY AUTO_INCREMENT,
  `entidad_afectada` varchar(100),
  `id_registro` int,
  `accion` enum('INSERT','UPDATE','DELETE'),
  `id_usuario` int,
  `fecha_accion` datetime,
  `ip_origen` varchar(50)
);

ALTER TABLE `AsientoContable` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

ALTER TABLE `DetalleAsiento` ADD FOREIGN KEY (`id_asiento`) REFERENCES `AsientoContable` (`id_asiento`);

ALTER TABLE `DetalleAsiento` ADD FOREIGN KEY (`id_cuenta`) REFERENCES `CuentaContable` (`id_cuenta`);

ALTER TABLE `FacturaVenta` ADD FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_cliente`);

ALTER TABLE `FacturaVenta` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

ALTER TABLE `DetalleFacturaVenta` ADD FOREIGN KEY (`id_factura`) REFERENCES `FacturaVenta` (`id_factura`);

ALTER TABLE `PagoCliente` ADD FOREIGN KEY (`id_factura`) REFERENCES `FacturaVenta` (`id_factura`);

ALTER TABLE `FacturaCompra` ADD FOREIGN KEY (`id_proveedor`) REFERENCES `Proveedor` (`id_proveedor`);

ALTER TABLE `FacturaCompra` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

ALTER TABLE `PagoProveedor` ADD FOREIGN KEY (`id_factura_compra`) REFERENCES `FacturaCompra` (`id_factura_compra`);

ALTER TABLE `Nomina` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

ALTER TABLE `DetalleNomina` ADD FOREIGN KEY (`id_nomina`) REFERENCES `Nomina` (`id_nomina`);

ALTER TABLE `DetalleNomina` ADD FOREIGN KEY (`id_empleado`) REFERENCES `Empleado` (`id_empleado`);

ALTER TABLE `Auditoria` ADD FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

/*Cambios para que funcione bien con la dian*/
use sandor;

ALTER TABLE FacturaVenta
ADD COLUMN prefijo varchar(10),
ADD COLUMN numero_resolucion varchar(50),
ADD COLUMN cufe varchar(255),
ADD COLUMN medio_pago varchar(50),
ADD COLUMN forma_pago varchar(50),
ADD COLUMN moneda varchar(10) DEFAULT 'COP';

ALTER TABLE Cliente
ADD COLUMN codigo_municipio varchar(10) NULL;
