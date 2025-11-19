DROP TABLE IF EXISTS `asientocontable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asientocontable` (
  `id_asiento` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `total_debito` decimal(15,2) DEFAULT NULL,
  `total_credito` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_asiento`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `asientocontable_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asientocontable`
--

LOCK TABLES `asientocontable` WRITE;
/*!40000 ALTER TABLE `asientocontable` DISABLE KEYS */;
INSERT INTO `asientocontable` VALUES (1,'2025-11-19','Venta según factura FV-000002',4,29600.00,29600.00),(2,'2025-11-19','Pago recibido de factura FV-000002',4,29600.00,29600.00),(3,'2025-11-19','Venta según factura FV-000003',4,51900.00,51900.00),(4,'2025-11-19','Pago recibido de factura FV-000003',4,51900.00,51900.00),(5,'2025-11-19','Venta según factura FV-000004',4,101550.00,101550.00);
/*!40000 ALTER TABLE `asientocontable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria` (
  `id_auditoria` int NOT NULL AUTO_INCREMENT,
  `entidad_afectada` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_registro` int DEFAULT NULL,
  `accion` enum('INSERT','UPDATE','DELETE') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `fecha_accion` datetime DEFAULT NULL,
  `ip_origen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `auditoria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('farmaprof-sistema-contable-cache-lotero@gmail.com|127.0.0.1','i:2;',1763512662),('farmaprof-sistema-contable-cache-lotero@gmail.com|127.0.0.1:timer','i:1763512662;',1763512662);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_identificacion` enum('CC','NIT') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_identificacion` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `codigo_municipio` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Lorenzo Lotero Gaitan','CC','1072673095','Autopista chia - cajica, sector \'\'El Cuarenta\'\'','3164680858','lorenzolotero@gmail.com','2025-11-19 04:42:49',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentacontable`
--

DROP TABLE IF EXISTS `cuentacontable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuentacontable` (
  `id_cuenta` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('ACTIVO','PASIVO','PATRIMONIO','INGRESO','GASTO') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_cuenta`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentacontable`
--

LOCK TABLES `cuentacontable` WRITE;
/*!40000 ALTER TABLE `cuentacontable` DISABLE KEYS */;
INSERT INTO `cuentacontable` VALUES (1,'1','ACTIVO','ACTIVO',1,1),(2,'11','DISPONIBLE','ACTIVO',2,1),(3,'13','DEUDORES','ACTIVO',2,1),(4,'14','INVENTARIOS','ACTIVO',2,1),(5,'15','PROPIEDAD PLANTA Y EQUIPO','ACTIVO',2,1),(6,'1105','CAJA','ACTIVO',3,1),(7,'1110','BANCOS','ACTIVO',3,1),(8,'1305','CLIENTES','ACTIVO',3,1),(9,'1355','ANTICIPO DE IMPUESTOS Y CONTRIBUCIONES','ACTIVO',3,1),(10,'1399','PROVISIONES','ACTIVO',3,1),(11,'1435','MERCANCIAS NO FABRICADAS POR LA EMPRESA','ACTIVO',3,1),(12,'1524','EQUIPO DE OFICINA','ACTIVO',3,1),(13,'2','PASIVO','PASIVO',1,1),(14,'22','PROVEEDORES','PASIVO',2,1),(15,'23','CUENTAS POR PAGAR','PASIVO',2,1),(16,'24','IMPUESTOS GRAVAMENES Y TASAS','PASIVO',2,1),(17,'25','OBLIGACIONES LABORALES','PASIVO',2,1),(18,'2205','PROVEEDORES NACIONALES','PASIVO',3,1),(19,'2365','RETENCION EN LA FUENTE','PASIVO',3,1),(20,'2368','RETENCION SALUD','PASIVO',3,1),(21,'2370','RETENCION PENSION','PASIVO',3,1),(22,'2380','APORTES PARAFISCALES','PASIVO',3,1),(23,'2408','IMPUESTO SOBRE LAS VENTAS POR PAGAR','PASIVO',3,1),(24,'2505','SALARIOS POR PAGAR','PASIVO',3,1),(25,'3','PATRIMONIO','PATRIMONIO',1,1),(26,'31','CAPITAL SOCIAL','PATRIMONIO',2,1),(27,'36','RESULTADOS DEL EJERCICIO','PATRIMONIO',2,1),(28,'37','RESULTADOS DE EJERCICIOS ANTERIORES','PATRIMONIO',2,1),(29,'3105','CAPITAL SUSCRITO Y PAGADO','PATRIMONIO',3,1),(30,'3605','UTILIDADES O EXCEDENTES DEL EJERCICIO','PATRIMONIO',3,1),(31,'3610','PERDIDAS DEL EJERCICIO','PATRIMONIO',3,1),(32,'4','INGRESOS','INGRESO',1,1),(33,'41','INGRESOS OPERACIONALES','INGRESO',2,1),(34,'42','INGRESOS NO OPERACIONALES','INGRESO',2,1),(35,'4135','COMERCIO AL POR MAYOR Y AL POR MENOR','INGRESO',3,1),(36,'4175','DEVOLUCIONES EN VENTAS','INGRESO',3,1),(37,'4210','FINANCIEROS','INGRESO',3,1),(38,'5','GASTOS','GASTO',1,1),(39,'51','GASTOS OPERACIONALES DE ADMINISTRACION','GASTO',2,1),(40,'52','GASTOS OPERACIONALES DE VENTAS','GASTO',2,1),(41,'53','GASTOS NO OPERACIONALES','GASTO',2,1),(42,'5105','GASTOS DE PERSONAL','GASTO',3,1),(43,'5110','HONORARIOS','GASTO',3,1),(44,'5115','IMPUESTOS','GASTO',3,1),(45,'5120','ARRENDAMIENTOS','GASTO',3,1),(46,'5135','SERVICIOS','GASTO',3,1),(47,'5140','GASTOS LEGALES','GASTO',3,1),(48,'5145','MANTENIMIENTO Y REPARACIONES','GASTO',3,1),(49,'5195','DIVERSOS','GASTO',3,1),(50,'6','COSTOS DE VENTAS Y DE PRESTACION DE SERVICIOS','GASTO',1,1),(51,'61','COSTO DE VENTAS Y DE PRESTACION DE SERVICIOS','GASTO',2,1),(52,'6135','COMERCIO AL POR MAYOR Y AL POR MENOR','GASTO',3,1);
/*!40000 ALTER TABLE `cuentacontable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalleasiento`
--

DROP TABLE IF EXISTS `detalleasiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalleasiento` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_asiento` int DEFAULT NULL,
  `id_cuenta` int DEFAULT NULL,
  `tipo_movimiento` enum('DEBITO','CREDITO') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_asiento` (`id_asiento`),
  KEY `id_cuenta` (`id_cuenta`),
  CONSTRAINT `detalleasiento_ibfk_1` FOREIGN KEY (`id_asiento`) REFERENCES `asientocontable` (`id_asiento`),
  CONSTRAINT `detalleasiento_ibfk_2` FOREIGN KEY (`id_cuenta`) REFERENCES `cuentacontable` (`id_cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleasiento`
--

LOCK TABLES `detalleasiento` WRITE;
/*!40000 ALTER TABLE `detalleasiento` DISABLE KEYS */;
INSERT INTO `detalleasiento` VALUES (1,1,8,'DEBITO',29600.00),(2,1,35,'CREDITO',25000.00),(3,1,23,'CREDITO',4600.00),(4,2,6,'DEBITO',29600.00),(5,2,8,'CREDITO',29600.00),(6,3,8,'DEBITO',51900.00),(7,3,35,'CREDITO',50000.00),(8,3,23,'CREDITO',1900.00),(9,4,6,'DEBITO',51900.00),(10,4,8,'CREDITO',51900.00),(11,5,8,'DEBITO',101550.00),(12,5,35,'CREDITO',93000.00),(13,5,23,'CREDITO',8550.00);
/*!40000 ALTER TABLE `detalleasiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallefacturaventa`
--

DROP TABLE IF EXISTS `detallefacturaventa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detallefacturaventa` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_factura` int DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `valor_unitario` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `iva` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_factura` (`id_factura`),
  CONSTRAINT `detallefacturaventa_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturaventa` (`id_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallefacturaventa`
--

LOCK TABLES `detallefacturaventa` WRITE;
/*!40000 ALTER TABLE `detallefacturaventa` DISABLE KEYS */;
INSERT INTO `detallefacturaventa` VALUES (1,1,'Cremas',3,20000.00,60000.00,3800.00,63800.00),(2,2,'Cremas',1,25000.00,25000.00,4600.00,29600.00),(3,3,'Cremas dentales',5,10000.00,50000.00,1900.00,51900.00),(4,4,'MED001 - Acetaminofén 500mg x 20 tabletas',3,8000.00,24000.00,0.00,24000.00),(5,4,'MED001 - Acetaminofén 500mg x 20 tabletas',3,8000.00,24000.00,0.00,24000.00),(6,4,'COSM002 - Protector Solar FPS 50+ 120ml',1,45000.00,45000.00,8550.00,53550.00);
/*!40000 ALTER TABLE `detallefacturaventa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallenomina`
--

DROP TABLE IF EXISTS `detallenomina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detallenomina` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_nomina` int DEFAULT NULL,
  `id_empleado` int DEFAULT NULL,
  `salario_base` decimal(15,2) DEFAULT NULL,
  `deducciones` decimal(15,2) DEFAULT NULL,
  `neto_pagado` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_nomina` (`id_nomina`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `detallenomina_ibfk_1` FOREIGN KEY (`id_nomina`) REFERENCES `nomina` (`id_nomina`),
  CONSTRAINT `detallenomina_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallenomina`
--

LOCK TABLES `detallenomina` WRITE;
/*!40000 ALTER TABLE `detallenomina` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallenomina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_identificacion` enum('CC','CE','NIT') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_identificacion` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salario_base` decimal(15,2) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Activo, 0=Inactivo',
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'Lorenzo Lotero Gaitan','CC','1072673095','Contador',1500000.00,'2025-11-19','3164680858','lorenzolotero@gmail.com','Autopista chia - cajica, sector \'\'El Cuarenta\'\'',NULL,1);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturacompra`
--

DROP TABLE IF EXISTS `facturacompra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturacompra` (
  `id_factura_compra` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_proveedor` int DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `iva` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `estado` enum('PENDIENTE','PAGADA','ANULADA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_factura_compra`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `facturacompra_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  CONSTRAINT `facturacompra_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturacompra`
--

LOCK TABLES `facturacompra` WRITE;
/*!40000 ALTER TABLE `facturacompra` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturacompra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturaventa`
--

DROP TABLE IF EXISTS `facturaventa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturaventa` (
  `id_factura` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_factura` enum('ELECTRONICA','NORMAL') COLLATE utf8mb4_unicode_ci DEFAULT 'ELECTRONICA',
  `fecha_emision` date DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `iva` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `estado` enum('PENDIENTE','PAGADA','ANULADA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `prefijo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_resolucion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cufe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medio_pago` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forma_pago` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'COP',
  PRIMARY KEY (`id_factura`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `facturaventa_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `facturaventa_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturaventa`
--

LOCK TABLES `facturaventa` WRITE;
/*!40000 ALTER TABLE `facturaventa` DISABLE KEYS */;
INSERT INTO `facturaventa` VALUES (1,'FV-000001','NORMAL','2025-11-19',NULL,60000.00,3800.00,63800.00,'ANULADA',4,'FV','18760000001',NULL,'Transferencia','Contado','COP'),(2,'FV-000002','NORMAL','2025-11-19',NULL,25000.00,4600.00,29600.00,'PAGADA',4,'FV','18760000001',NULL,'Transferencia','Contado','COP'),(3,'FV-000003','ELECTRONICA','2025-11-19',1,50000.00,1900.00,51900.00,'PAGADA',4,'FV','18760000001',NULL,'Transferencia','Contado','COP'),(4,'FV-000004','NORMAL','2025-11-19',NULL,93000.00,8550.00,101550.00,'PENDIENTE',4,'FV','18760000001',NULL,'Transferencia','Contado','COP');
/*!40000 ALTER TABLE `facturaventa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_11_18_173144_create_sessions_table',1),(2,'2025_11_18_223341_create_cache_table',2),(3,'2025_11_18_223403_create_jobs_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nomina`
--

DROP TABLE IF EXISTS `nomina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nomina` (
  `id_nomina` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `periodo` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `total_salarios` decimal(15,2) DEFAULT NULL,
  `total_deducciones` decimal(15,2) DEFAULT NULL,
  `total_neto` decimal(15,2) DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `salario_base` decimal(15,2) NOT NULL,
  `deduccion_salud` decimal(15,2) NOT NULL DEFAULT '0.00',
  `deduccion_pension` decimal(15,2) NOT NULL DEFAULT '0.00',
  `salario_neto` decimal(15,2) NOT NULL,
  `estado` enum('PENDIENTE','PAGADA') COLLATE utf8mb4_unicode_ci DEFAULT 'PENDIENTE',
  PRIMARY KEY (`id_nomina`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `nomina_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nomina`
--

LOCK TABLES `nomina` WRITE;
/*!40000 ALTER TABLE `nomina` DISABLE KEYS */;
/*!40000 ALTER TABLE `nomina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagocliente`
--

DROP TABLE IF EXISTS `pagocliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagocliente` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_factura` int DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto` decimal(15,2) DEFAULT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_factura` (`id_factura`),
  CONSTRAINT `pagocliente_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturaventa` (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagocliente`
--

LOCK TABLES `pagocliente` WRITE;
/*!40000 ALTER TABLE `pagocliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagocliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagoproveedor`
--

DROP TABLE IF EXISTS `pagoproveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagoproveedor` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_factura_compra` int DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto` decimal(15,2) DEFAULT NULL,
  `metodo_pago` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_factura_compra` (`id_factura_compra`),
  CONSTRAINT `pagoproveedor_ibfk_1` FOREIGN KEY (`id_factura_compra`) REFERENCES `facturacompra` (`id_factura_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagoproveedor`
--

LOCK TABLES `pagoproveedor` WRITE;
/*!40000 ALTER TABLE `pagoproveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagoproveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Código o referencia del producto',
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del producto',
  `descripcion` text COLLATE utf8mb4_unicode_ci COMMENT 'Descripción detallada',
  `precio` decimal(15,2) NOT NULL COMMENT 'Precio unitario sin IVA',
  `porcentaje_iva` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT 'Porcentaje de IVA (0, 5 o 19)',
  `stock` int NOT NULL DEFAULT '0' COMMENT 'Cantidad en inventario',
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Activo, 0=Inactivo',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `idx_codigo` (`codigo`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'MED001','Acetaminofén 500mg x 20 tabletas','Analgésico y antipirético',8000.00,0.00,100,1,'2025-11-19 16:41:25'),(2,'MED002','Ibuprofeno 400mg x 30 tabletas','Antiinflamatorio no esteroideo',12000.00,0.00,80,1,'2025-11-19 16:41:25'),(3,'MED003','Omeprazol 20mg x 14 cápsulas','Inhibidor de bomba de protones',15000.00,0.00,50,1,'2025-11-19 16:41:25'),(4,'MED004','Loratadina 10mg x 10 tabletas','Antihistamínico para alergias',6000.00,0.00,120,1,'2025-11-19 16:41:25'),(5,'VITA001','Vitamina C 1000mg x 30 cápsulas','Suplemento vitamínico',35000.00,5.00,60,1,'2025-11-19 16:41:25'),(6,'VITA002','Complejo B x 30 tabletas','Vitaminas del complejo B',28000.00,5.00,45,1,'2025-11-19 16:41:25'),(7,'COSM001','Crema Hidratante Nivea 200ml','Crema para piel seca',25000.00,19.00,30,1,'2025-11-19 16:41:25'),(8,'COSM002','Protector Solar FPS 50+ 120ml','Protección solar UVA/UVB',45000.00,19.00,25,1,'2025-11-19 16:41:25'),(9,'HIG001','Alcohol Antiséptico 70% 500ml','Desinfectante de uso externo',8500.00,19.00,100,1,'2025-11-19 16:41:25'),(10,'HIG002','Tapabocas Quirúrgico x 50 unidades','Tapabocas desechables triple capa',35000.00,19.00,200,1,'2025-11-19 16:41:25'),(11,'MED008','Aspirinas',NULL,15000.00,19.00,35,1,'2025-11-19 16:59:12');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6awcd3c4pW2ZWVY6QdXg16aPp84yVTiuuDRhGLf9',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQWN4Tkk2SVpGb2Rudko3U0dWVGpZQ29kS0VJUlZ1b1c3V0xtRDNZUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9',1763579669),('xsm4Zr6j2St6ntdpJnuXq0tsjhukaHtJ7eYCnBwE',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMW9WbkVEYWlVTnM1a0FvdmJoVlRnVHdqQVVTOTNXV0Jxb0I2Mlc4aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub21pbmEvbm9taW5hcy9wcm9jZXNhciI7czo1OiJyb3V0ZSI7czoyMzoibm9taW5hLm5vbWluYXMucHJvY2VzYXIiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1763527661);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareapendiente`
--

DROP TABLE IF EXISTS `tareapendiente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareapendiente` (
  `id_tarea` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridad` enum('alta','media','baja') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'media',
  `completada` tinyint(1) NOT NULL DEFAULT '0',
  `id_usuario` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_completada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tarea`),
  KEY `idx_usuario` (`id_usuario`),
  KEY `idx_completada` (`completada`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareapendiente`
--

LOCK TABLES `tareapendiente` WRITE;
/*!40000 ALTER TABLE `tareapendiente` DISABLE KEYS */;
INSERT INTO `tareapendiente` VALUES (1,'Revisar facturas pendientes de aprobación','alta',0,1,'2025-11-19 18:46:15',NULL),(2,'Conciliación bancaria mensual','alta',0,1,'2025-11-19 18:46:15',NULL),(3,'Actualizar datos de proveedores','baja',0,1,'2025-11-19 18:46:15',NULL),(4,'Revisar facturas','media',1,4,'2025-11-19 23:54:18','2025-11-19 23:54:20'),(5,'Revisar facturas','baja',0,4,'2025-11-19 23:54:32',NULL);
/*!40000 ALTER TABLE `tareapendiente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contraseña_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('SUPERADMIN','CLIENTE_SAAS') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Lorenzo Lotero Gaitan','lorenzolotero@gmail.com','$2y$12$3pklexV58I/08tSADo8LrO.qZw1HTPCJL3dqX92jqN/AlzOrkSlM.','SUPERADMIN','2025-11-18 21:23:42',1),(2,'Miguel','admin@farmaprof.com','$2y$12$XAzTcrcQ0vp11HrLSsOd2u/a7BM9FRvfrPTIOaXw0ItEEQie2qm1S','SUPERADMIN','2025-11-18 21:48:15',1),(3,'Maicol','maicol@gmail.com','$2y$12$JLuPXFtVet8vlsAJLPWaquzo4tdk562be2ADqO8wFJbFLpU08TQuK','CLIENTE_SAAS','2025-11-18 22:00:16',1),(4,'Maicol','maicol2@gmail.com','$2y$12$XaN.3GFvF3OOwT88b8bjUu4ye3QP/ULJWiYpnMW05xLyqkYsNjB42','CLIENTE_SAAS','2025-11-19 01:10:45',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-19 16:13:42
