-- Script para VERIFICAR el estado de la base de datos
-- Ejecuta este script para ver qué tablas tienes y si les falta algo

USE sandor;

-- ==========================================
-- 1. VER TODAS LAS TABLAS
-- ==========================================
SELECT 'TABLAS EXISTENTES EN LA BASE DE DATOS:' as '';
SHOW TABLES;

-- ==========================================
-- 2. VERIFICAR TABLAS DE CONTABILIDAD
-- ==========================================
SELECT '\n\nVERIFICACIÓN DE TABLAS DE CONTABILIDAD:' as '';

-- Verificar CuentaContable
SELECT
    CASE
        WHEN COUNT(*) > 0 THEN CONCAT('✓ CuentaContable existe con ', COUNT(*), ' cuentas registradas')
        ELSE '✗ CuentaContable NO tiene cuentas (ejecuta puc_colombiano.sql)'
    END as 'Estado CuentaContable'
FROM CuentaContable;

-- Verificar AsientoContable
SELECT
    CASE
        WHEN EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'sandor' AND table_name = 'AsientoContable')
        THEN CONCAT('✓ AsientoContable existe con ', COUNT(*), ' asientos')
        ELSE '✗ AsientoContable NO existe'
    END as 'Estado AsientoContable'
FROM AsientoContable;

-- Verificar DetalleAsiento
SELECT
    CASE
        WHEN EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'sandor' AND table_name = 'DetalleAsiento')
        THEN CONCAT('✓ DetalleAsiento existe con ', COUNT(*), ' detalles')
        ELSE '✗ DetalleAsiento NO existe'
    END as 'Estado DetalleAsiento'
FROM DetalleAsiento;

-- ==========================================
-- 3. VERIFICAR TABLAS DE NÓMINA
-- ==========================================
SELECT '\n\nVERIFICACIÓN DE TABLAS DE NÓMINA:' as '';

-- Verificar Empleado
SELECT
    CASE
        WHEN EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'sandor' AND table_name = 'Empleado')
        THEN CONCAT('✓ Empleado existe con ', COUNT(*), ' empleados')
        ELSE '✗ Empleado NO existe'
    END as 'Estado Empleado'
FROM Empleado;

-- Verificar Nomina
SELECT
    CASE
        WHEN EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'sandor' AND table_name = 'Nomina')
        THEN CONCAT('✓ Nomina existe con ', COUNT(*), ' nóminas procesadas')
        ELSE '✗ Nomina NO existe'
    END as 'Estado Nomina'
FROM Nomina;

-- ==========================================
-- 4. VERIFICAR ESTRUCTURA DE LA TABLA NOMINA
-- ==========================================
SELECT '\n\nESTRUCTURA DE LA TABLA NOMINA:' as '';
DESCRIBE Nomina;

-- ==========================================
-- 5. VERIFICAR ESTRUCTURA DE LA TABLA EMPLEADO
-- ==========================================
SELECT '\n\nESTRUCTURA DE LA TABLA EMPLEADO:' as '';
DESCRIBE Empleado;

-- ==========================================
-- 6. RESUMEN FINAL
-- ==========================================
SELECT '\n\nRESUMEN:' as '';
SELECT
    (SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'sandor') as 'Total de Tablas',
    (SELECT COUNT(*) FROM CuentaContable) as 'Cuentas PUC',
    (SELECT COUNT(*) FROM AsientoContable) as 'Asientos Contables',
    (SELECT COUNT(*) FROM Empleado) as 'Empleados',
    (SELECT COUNT(*) FROM Nomina) as 'Nóminas';
