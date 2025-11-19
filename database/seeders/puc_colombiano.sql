-- Plan Único de Cuentas (PUC) - Colombia
-- Cuentas básicas para FarmaProf

USE sandor;

-- Insertar cuentas contables

-- ==========================================
-- 1. ACTIVOS
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('1', 'ACTIVO', 'ACTIVO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('11', 'DISPONIBLE', 'ACTIVO', 2, 1),
('13', 'DEUDORES', 'ACTIVO', 2, 1),
('14', 'INVENTARIOS', 'ACTIVO', 2, 1),
('15', 'PROPIEDAD PLANTA Y EQUIPO', 'ACTIVO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('1105', 'CAJA', 'ACTIVO', 3, 1),
('1110', 'BANCOS', 'ACTIVO', 3, 1),
('1305', 'CLIENTES', 'ACTIVO', 3, 1),
('1399', 'PROVISIONES', 'ACTIVO', 3, 1),
('1435', 'MERCANCIAS NO FABRICADAS POR LA EMPRESA', 'ACTIVO', 3, 1),
('1524', 'EQUIPO DE OFICINA', 'ACTIVO', 3, 1);

-- ==========================================
-- 2. PASIVOS
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('2', 'PASIVO', 'PASIVO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('22', 'PROVEEDORES', 'PASIVO', 2, 1),
('23', 'CUENTAS POR PAGAR', 'PASIVO', 2, 1),
('25', 'OBLIGACIONES LABORALES', 'PASIVO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('2205', 'PROVEEDORES NACIONALES', 'PASIVO', 3, 1),
('2365', 'RETENCION EN LA FUENTE', 'PASIVO', 3, 1),
('2368', 'RETENCION SALUD', 'PASIVO', 3, 1),
('2370', 'RETENCION PENSION', 'PASIVO', 3, 1),
('2380', 'APORTES PARAFISCALES', 'PASIVO', 3, 1),
('2505', 'SALARIOS POR PAGAR', 'PASIVO', 3, 1);

-- ==========================================
-- 3. PATRIMONIO
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('3', 'PATRIMONIO', 'PATRIMONIO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('31', 'CAPITAL SOCIAL', 'PATRIMONIO', 2, 1),
('36', 'RESULTADOS DEL EJERCICIO', 'PATRIMONIO', 2, 1),
('37', 'RESULTADOS DE EJERCICIOS ANTERIORES', 'PATRIMONIO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('3105', 'CAPITAL SUSCRITO Y PAGADO', 'PATRIMONIO', 3, 1),
('3605', 'UTILIDADES O EXCEDENTES DEL EJERCICIO', 'PATRIMONIO', 3, 1),
('3610', 'PERDIDAS DEL EJERCICIO', 'PATRIMONIO', 3, 1);

-- ==========================================
-- 4. INGRESOS
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('4', 'INGRESOS', 'INGRESO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('41', 'INGRESOS OPERACIONALES', 'INGRESO', 2, 1),
('42', 'INGRESOS NO OPERACIONALES', 'INGRESO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('4135', 'COMERCIO AL POR MAYOR Y AL POR MENOR', 'INGRESO', 3, 1),
('4175', 'DEVOLUCIONES EN VENTAS', 'INGRESO', 3, 1),
('4210', 'FINANCIEROS', 'INGRESO', 3, 1);

-- ==========================================
-- 5. GASTOS
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('5', 'GASTOS', 'GASTO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('51', 'GASTOS OPERACIONALES DE ADMINISTRACION', 'GASTO', 2, 1),
('52', 'GASTOS OPERACIONALES DE VENTAS', 'GASTO', 2, 1),
('53', 'GASTOS NO OPERACIONALES', 'GASTO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('5105', 'GASTOS DE PERSONAL', 'GASTO', 3, 1),
('5110', 'HONORARIOS', 'GASTO', 3, 1),
('5115', 'IMPUESTOS', 'GASTO', 3, 1),
('5120', 'ARRENDAMIENTOS', 'GASTO', 3, 1),
('5135', 'SERVICIOS', 'GASTO', 3, 1),
('5140', 'GASTOS LEGALES', 'GASTO', 3, 1),
('5145', 'MANTENIMIENTO Y REPARACIONES', 'GASTO', 3, 1),
('5195', 'DIVERSOS', 'GASTO', 3, 1);

-- ==========================================
-- 6. COSTO DE VENTAS
-- ==========================================

-- Nivel 1: Clase
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('6', 'COSTOS DE VENTAS Y DE PRESTACION DE SERVICIOS', 'GASTO', 1, 1);

-- Nivel 2: Grupo
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('61', 'COSTO DE VENTAS Y DE PRESTACION DE SERVICIOS', 'GASTO', 2, 1);

-- Nivel 3: Cuenta
INSERT INTO CuentaContable (codigo, nombre, tipo, nivel, estado) VALUES
('6135', 'COMERCIO AL POR MAYOR Y AL POR MENOR', 'GASTO', 3, 1);
