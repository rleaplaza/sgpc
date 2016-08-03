-- MySQL dump 10.13  Distrib 5.6.12, for Win32 (x86)
--
-- Host: localhost    Database: dbserco
-- ------------------------------------------------------
-- Server version	5.6.12-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accidente_trabajador`
--

DROP TABLE IF EXISTS `accidente_trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accidente_trabajador` (
  `IDaccidente` varchar(40) NOT NULL,
  `IDpersonalTecnico` varchar(40) NOT NULL,
  `CI_trabajador` varchar(40) NOT NULL,
  `causa` varchar(110) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDaccidente`),
  KEY `IDpersonalTecnico` (`IDpersonalTecnico`),
  KEY `IDtrabajador` (`CI_trabajador`),
  CONSTRAINT `accidente_trabajador_ibfk_1` FOREIGN KEY (`IDpersonalTecnico`) REFERENCES `personaltecnico` (`IDpersonalTecnico`),
  CONSTRAINT `accidente_trabajador_ibfk_2` FOREIGN KEY (`CI_trabajador`) REFERENCES `personalmanoobra` (`CI_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accidente_trabajador`
--

LOCK TABLES `accidente_trabajador` WRITE;
/*!40000 ALTER TABLE `accidente_trabajador` DISABLE KEYS */;
/*!40000 ALTER TABLE `accidente_trabajador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad` (
  `IDactividad` varchar(40) NOT NULL COMMENT 'identificador de la actividad',
  `IDsubfase` varchar(40) NOT NULL,
  `IDpersonalTecnico` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `nombreActividad` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `t_actmaterial` decimal(10,2) DEFAULT NULL,
  `t_acmanoobra` decimal(10,2) DEFAULT NULL,
  `t_acmaquinaria` decimal(10,2) DEFAULT NULL,
  `t_gastoadm` decimal(10,2) DEFAULT NULL,
  `t_utilidad` decimal(10,2) DEFAULT NULL,
  `t_impuesto` decimal(10,2) DEFAULT NULL,
  `unidades` varchar(20) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `total_avance` decimal(10,2) NOT NULL,
  `precioUnitarioBS` decimal(10,2) DEFAULT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL,
  `costo_programado` decimal(10,2) NOT NULL,
  `costo_prorrateado` decimal(10,2) NOT NULL,
  `fechaRealizacion` date NOT NULL,
  `fechaFin` date NOT NULL,
  `duracion_dias` decimal(10,2) NOT NULL,
  `finalizado` varchar(25) DEFAULT NULL,
  `aprobado` varchar(15) DEFAULT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDactividad`),
  KEY `IDtramo` (`IDsubfase`),
  KEY `IDmiembroPlan` (`IDpersonalTecnico`),
  KEY `IDmiembroPlan_2` (`IDpersonalTecnico`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `actividad_ibfk_3` FOREIGN KEY (`IDpersonalTecnico`) REFERENCES `personaltecnico` (`IDpersonalTecnico`),
  CONSTRAINT `actividad_ibfk_4` FOREIGN KEY (`IDsubfase`) REFERENCES `subfase` (`IDsubfase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
INSERT INTO `actividad` VALUES ('00773721081685130125323988955754045','51096879311124785682013508959054978','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Excavacion comun para caminos',0.00,0.00,0.00,0.00,0.00,0.00,'m3',23.40,0.00,0.00,0.00,427536.45,52.17,'2014-04-06','2014-04-29',23.00,'sin comenzar','Por definir','2014-06-15','19:32:42'),('10946039873155419607346270100892942','35318126010804016296094586354787714','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Despejar via obstruida',0.00,0.00,0.00,0.00,0.00,0.00,'m3',16.00,0.00,0.00,0.00,225536.45,120.00,'2014-05-05','2014-05-15',10.00,'sin comenzar','Por definir','2014-06-15','19:36:21'),('16312694610626839903110083018845809','54526773605222682293183326023175897','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','nivelacion a maquina',0.00,240.50,1249.50,149.00,163.90,557.10,'km',8.50,8.50,2360.00,20059.97,123240.03,66.67,'2014-05-26','2014-06-10',15.00,'finalizada','Por definir','2014-05-25','17:42:48'),('19497109988512141048033380556426065','54526773605222682293183326023175897','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Reconformacion de canales y rios',0.00,0.00,0.00,0.00,0.00,0.00,'m3',210.34,8.90,0.00,0.00,244322.12,47.62,'2014-07-02','2014-07-23',21.00,'En ejecucion','Por definir','2014-05-25','17:45:40'),('26843225947751213852462512152296753','46907738842774819455472749501318228','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Reponer terraplen',0.00,0.00,0.00,0.00,0.00,0.00,'m3',455.45,0.00,0.00,0.00,112322.12,71.43,'2014-07-22','2014-08-05',14.00,'Por realizarse','Por definir','2014-05-25','17:47:41'),('48047500748650619988398571843021399','51446877914295047849582357841480386','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Escorellado de piedra en seco',0.00,0.00,0.00,0.00,0.00,0.00,'m3',531.34,0.00,0.00,0.00,130560.45,100.00,'2014-08-04','2014-08-14',10.00,'Por realizarse','Por definir','2014-05-25','17:50:43'),('48374589599741517445939018462812793','51446877914295047849582357841480386','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Excavacion comun',0.00,0.00,0.00,0.00,0.00,0.00,'m3',633.23,0.00,0.00,0.00,142322.12,76.92,'2014-07-28','2014-08-10',13.00,'En ejecucion','Por definir','2014-05-25','17:48:29'),('48627935088259117807681975066601224','51446877914295047849582357841480386','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Excavacion en roca',0.00,0.00,0.00,0.00,0.00,0.00,'m3',431.34,0.00,0.00,0.00,232322.12,76.92,'2014-07-30','2014-08-12',13.00,'En ejecucion','Por definir','2014-05-25','17:49:44'),('49564628690744821068807232619609093','51096879311124785682013508959054978','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Excavacion en roca',0.00,114.00,821.10,93.51,102.86,349.62,'m3',12.50,12.50,1481.10,18513.69,627556.45,100.00,'2014-03-26','2014-04-07',12.00,'finalizada','Por definir','2014-06-15','19:31:57'),('56179918605142495245289387777697125','51446877914295047849582357841480386','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','hormigon en recalces',0.00,0.00,0.00,0.00,0.00,0.00,'m3',80.00,0.00,0.00,0.00,150350.32,76.92,'2014-08-13','2014-08-26',13.00,'Por realizarse','Por definir','2014-05-25','17:52:39'),('60042756061364415726085050060314711','49456360697942175122604462497915779','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Hormigon en recalces y soleras',0.00,0.00,0.00,0.00,0.00,0.00,'m3',80.00,0.00,0.00,0.00,140335.12,51.72,'2014-08-31','2014-09-29',29.00,'Por realizarse','Por definir','2014-06-04','14:38:05'),('80637570287540662115149124358043987','46907738842774819455472749501318228','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Despejar via obstruida',0.00,0.00,0.00,0.00,0.00,0.00,'m3',319.34,0.00,0.00,0.00,212322.12,52.63,'2014-07-08','2014-07-27',19.00,'En ejecucion','Por definir','2014-05-25','17:46:46'),('83768827861528160102769565446850566','16515509510892627500725540956801401','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Transporte de aridos',0.00,0.00,0.00,0.00,0.00,0.00,'m3-km',2300.21,0.00,0.00,0.00,155300.50,34.48,'2014-08-26','2014-09-24',29.00,'Por realizarse','Por definir','2014-05-25','17:54:23'),('89870740458545731688124221354631726','26820041065284541967698667730197297','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Recubrimiento localizado',183.95,107.00,1086.75,137.77,151.55,515.11,'m3',10.30,10.30,2182.13,22475.89,323556.45,57.14,'2014-03-10','2014-03-31',21.00,'finalizada','Por definir','2014-06-15','19:31:14'),('93864140337925124407878400125898594','87887960995443068105148111410707178','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Excavacion en roca',0.00,0.00,0.00,0.00,0.00,0.00,'m3',1000.00,0.00,0.00,0.00,156123.43,53.57,'2014-09-01','2014-09-29',28.00,'Por realizarse','Por definir','2014-06-04','14:42:48'),('96367782363307395876037507801498575','54526773605222682293183326023175897','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Recubrimiento localizado a ripio',0.00,0.00,0.00,0.00,0.00,0.00,'m3',234.45,48.80,0.00,0.00,115240.03,23.26,'2014-06-02','2014-07-15',43.00,'En ejecucion','Por definir','2014-05-25','17:43:47'),('96711503938685541007417821736235783','26820041065284541967698667730197297','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Nivelacion a maquina',0.00,122.50,5049.45,517.20,568.91,1933.74,'km',6.70,6.70,8191.80,54885.06,523556.45,54.55,'2014-04-08','2014-04-22',22.00,'finalizada','Por definir','2014-06-15','19:30:34'),('98285187273689435840295847323218377','51446877914295047849582357841480386','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','67883700838770497309348435286443033','Colocacion de gaviones',0.00,0.00,0.00,0.00,0.00,0.00,'m3',460.20,0.00,0.00,0.00,231302.12,66.67,'2014-08-10','2014-08-25',15.00,'Por realizarse','Por definir','2014-05-25','17:51:51'),('99086860107332907037490894290586511','35318126010804016296094586354787714','5r72n047v2zohyecxh6p4eipmuhkfadblb6','12304037302566169242662068258533998','Estabilizacion de caminos con ripio',0.00,0.00,0.00,0.00,0.00,0.00,'m3',15.00,0.00,0.00,0.00,325536.45,92.31,'2014-04-29','2014-05-12',13.00,'sin comenzar','Por definir','2014-06-15','19:35:27');
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actividad_maquinaria`
--

DROP TABLE IF EXISTS `actividad_maquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad_maquinaria` (
  `IDactividad` varchar(40) NOT NULL,
  `IDmaquinaria` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `cant_asignada` int(11) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `precio_productivo` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL,
  `fechaAvance` date DEFAULT NULL,
  `fecAsignacion` date NOT NULL,
  `hraAsignacion` time NOT NULL,
  KEY `nro_itemMaq` (`IDmaquinaria`),
  KEY `nro_itemMaq_2` (`IDmaquinaria`),
  KEY `IDacitividad` (`IDactividad`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `actividad_maquinaria_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`),
  CONSTRAINT `actividad_maquinaria_ibfk_2` FOREIGN KEY (`IDmaquinaria`) REFERENCES `maquinaria` (`IDmaquinaria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad_maquinaria`
--

LOCK TABLES `actividad_maquinaria` WRITE;
/*!40000 ALTER TABLE `actividad_maquinaria` DISABLE KEYS */;
INSERT INTO `actividad_maquinaria` VALUES ('16312694610626839903110083018845809','daxusj4txhyre2ga29p6qhk2noco437hm8c','67883700838770497309348435286443033',1,'HM',3.40,350.00,1190.00,'2014-05-25','2014-05-25','18:15:13'),('96367782363307395876037507801498575','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','67883700838770497309348435286443033',2,'HM',0.00,280.00,NULL,NULL,'2014-05-25','18:16:47'),('96367782363307395876037507801498575','daxusj4txhyre2ga29p6qhk2noco437hm8c','67883700838770497309348435286443033',1,'HM',0.00,350.00,NULL,NULL,'2014-05-25','18:17:00'),('96367782363307395876037507801498575','tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','67883700838770497309348435286443033',1,'HM',0.00,250.00,NULL,NULL,'2014-05-25','18:17:05'),('19497109988512141048033380556426065','daxusj4txhyre2ga29p6qhk2noco437hm8c','67883700838770497309348435286443033',1,'HM',0.00,350.00,NULL,NULL,'2014-05-25','18:17:45'),('80637570287540662115149124358043987','tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','67883700838770497309348435286443033',1,'HM',0.00,250.00,NULL,NULL,'2014-05-25','18:18:45'),('48627935088259117807681975066601224','tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','67883700838770497309348435286443033',1,'HM',0.00,250.00,NULL,NULL,'2014-05-25','18:21:21'),('96711503938685541007417821736235783','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','12304037302566169242662068258533998',2,'HM',4.40,280.00,896.00,'2014-06-17','2014-06-17','19:51:05'),('96711503938685541007417821736235783','daxusj4txhyre2ga29p6qhk2noco437hm8c','12304037302566169242662068258533998',1,'HM',4.30,350.00,1505.00,'2014-06-17','2014-06-17','19:51:11'),('96711503938685541007417821736235783','dg07ngp1xhjp5qke9e9yds20845sdlz54rj','12304037302566169242662068258533998',1,'HM',4.30,560.00,2408.00,'2014-06-17','2014-06-17','19:51:54'),('89870740458545731688124221354631726','duikwxjjzz96yzj8y1eegfam6gruvo4usw3','35176173591856987518068845879129167',3,'HM',4.50,230.00,1035.00,'2014-06-17','2014-06-17','21:40:07'),('49564628690744821068807232619609093','duikwxjjzz96yzj8y1eegfam6gruvo4usw3','74385053879959950951589154416276897',2,'HM',3.40,230.00,782.00,'2014-06-21','2014-06-17','22:06:14');
/*!40000 ALTER TABLE `actividad_maquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actividad_material`
--

DROP TABLE IF EXISTS `actividad_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad_material` (
  `IDactividad` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `unidad` varchar(10) NOT NULL,
  `cantidad_programada` decimal(10,2) DEFAULT NULL,
  `cant_solicitada` decimal(10,2) DEFAULT NULL,
  `cantidad_utilizada` decimal(10,2) DEFAULT NULL,
  `precio_productivo` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL,
  `fecAvance` date DEFAULT NULL,
  `fecAsignacion` date NOT NULL,
  `hraAsignacion` time NOT NULL,
  KEY `IDacitividad` (`IDactividad`),
  KEY `nro_itemMaterial` (`IDmaterial`),
  CONSTRAINT `actividad_material_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`),
  CONSTRAINT `actividad_material_ibfk_2` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad_material`
--

LOCK TABLES `actividad_material` WRITE;
/*!40000 ALTER TABLE `actividad_material` DISABLE KEYS */;
INSERT INTO `actividad_material` VALUES ('96367782363307395876037507801498575','nw28w541ja2pix442xhtb4kk96rqeo99zy4','67883700838770497309348435286443033','M3',17.00,18.00,4.50,25.62,115.29,'2014-06-08','2014-06-08','19:18:59'),('89870740458545731688124221354631726','nw28w541ja2pix442xhtb4kk96rqeo99zy4','12304037302566169242662068258533998','M3',18.00,21.00,7.18,25.62,183.95,'2014-06-17','2014-06-17','19:42:23');
/*!40000 ALTER TABLE `actividad_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actividad_trabajador`
--

DROP TABLE IF EXISTS `actividad_trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad_trabajador` (
  `IDactividad` varchar(40) NOT NULL,
  `CI_trabajador` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `porcent_participacion` decimal(10,2) NOT NULL,
  `unidad_trabajo` varchar(20) NOT NULL,
  `total_trabajo` decimal(10,2) DEFAULT NULL,
  `unidad_avance` varchar(10) DEFAULT NULL,
  `total_unidad_avance` decimal(10,2) DEFAULT NULL,
  `precio_productivo` decimal(10,2) NOT NULL,
  `subtotal_manoObra` decimal(10,2) DEFAULT NULL,
  `fecha_avance` date DEFAULT NULL,
  `fecAsignacion` date NOT NULL,
  `hraAsignacion` time NOT NULL,
  KEY `IDcargoM` (`CI_trabajador`),
  KEY `IDacitividad` (`IDactividad`),
  KEY `IDcargoM_2` (`CI_trabajador`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `actividad_trabajador_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`),
  CONSTRAINT `actividad_trabajador_ibfk_2` FOREIGN KEY (`CI_trabajador`) REFERENCES `personalmanoobra` (`CI_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad_trabajador`
--

LOCK TABLES `actividad_trabajador` WRITE;
/*!40000 ALTER TABLE `actividad_trabajador` DISABLE KEYS */;
INSERT INTO `actividad_trabajador` VALUES ('16312694610626839903110083018845809','2898554 Exp La Paz','67883700838770497309348435286443033',100.00,'HH',8.00,'km',4.50,13.00,104.00,'2014-05-25','2014-05-25','18:13:04'),('16312694610626839903110083018845809','3900445 Exp La Paz','67883700838770497309348435286443033',87.50,'HH',7.00,'km',2.80,12.00,84.00,'2014-05-25','2014-05-25','18:13:18'),('16312694610626839903110083018845809','3389449 Exp La Paz','67883700838770497309348435286443033',93.75,'HH',7.50,'km',3.10,7.00,52.50,'2014-05-25','2014-05-25','18:13:24'),('96367782363307395876037507801498575','2904348 Exp La Paz','67883700838770497309348435286443033',100.00,'HH',8.00,'m3',13.80,13.00,104.00,'2014-06-21','2014-05-25','18:16:11'),('96367782363307395876037507801498575','4895544 Exp La Paz','67883700838770497309348435286443033',100.00,'HH',8.00,'m3',14.40,12.00,96.00,'2014-06-21','2014-05-25','18:16:21'),('96367782363307395876037507801498575','7844903 Exp La Paz','67883700838770497309348435286443033',87.50,'HH',7.00,'m3',8.70,7.00,49.00,'2014-06-10','2014-05-25','18:16:28'),('96367782363307395876037507801498575','3490554 Exp La Paz','67883700838770497309348435286443033',87.50,'HH',7.00,'m3',11.90,9.56,66.92,'2014-06-21','2014-05-25','18:16:35'),('19497109988512141048033380556426065','4893344 Exp La Paz','67883700838770497309348435286443033',87.50,'HH',6.00,'m3',8.90,13.00,78.00,'2014-06-16','2014-05-25','18:17:25'),('19497109988512141048033380556426065','5099330 Exp La Paz','67883700838770497309348435286443033',93.75,'HH',0.00,NULL,0.00,12.00,0.00,NULL,'2014-05-25','18:17:33'),('80637570287540662115149124358043987','7844389 Exp La Paz','67883700838770497309348435286443033',100.00,'HH',0.00,NULL,0.00,13.00,0.00,NULL,'2014-05-25','18:18:31'),('48374589599741517445939018462812793','4900229 Exp La Paz','67883700838770497309348435286443033',93.75,'HH',0.00,NULL,0.00,7.00,0.00,NULL,'2014-05-25','18:21:07'),('48627935088259117807681975066601224','5489448 Exp La Paz','67883700838770497309348435286443033',100.00,'HH',0.00,NULL,0.00,6.75,0.00,NULL,'2014-05-25','18:21:36'),('48627935088259117807681975066601224','8933449 Exp La Paz','67883700838770497309348435286443033',87.50,'HH',0.00,NULL,0.00,7.00,0.00,NULL,'2014-05-25','18:21:40'),('96711503938685541007417821736235783','5099330 Exp La Paz','12304037302566169242662068258533998',93.75,'HH',7.50,'km',3.50,12.00,90.00,'2014-06-17','2014-06-17','19:31:08'),('96711503938685541007417821736235783','2088344 Exp La Paz','12304037302566169242662068258533998',87.50,'HH',6.50,'km',3.20,5.00,32.50,'2014-06-17','2014-06-17','19:31:42'),('89870740458545731688124221354631726','4789554 Exp La Paz','12304037302566169242662068258533998',87.50,'HH',7.00,'m3',5.31,5.00,35.00,'2014-06-17','2014-06-17','19:42:59'),('89870740458545731688124221354631726','7844559 Exp La Paz','12304037302566169242662068258533998',87.50,'HH',6.00,'m3',4.99,12.00,72.00,'2014-06-17','2014-06-17','19:49:39'),('49564628690744821068807232619609093','3900445 Exp La Paz','74385053879959950951589154416276897',87.50,'HH',7.00,'m3',8.00,12.00,84.00,'2014-06-21','2014-06-17','22:05:47'),('49564628690744821068807232619609093','3988447 Exp La Paz','74385053879959950951589154416276897',87.50,'HH',6.00,'m3',4.50,5.00,30.00,'2014-06-21','2014-06-17','22:05:57');
/*!40000 ALTER TABLE `actividad_trabajador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actividadlaboral`
--

DROP TABLE IF EXISTS `actividadlaboral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividadlaboral` (
  `IDactividadLab` varchar(40) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `nombreActividad` varchar(40) NOT NULL,
  `hrasTrabajadas` int(11) NOT NULL,
  PRIMARY KEY (`IDactividadLab`),
  KEY `IDcargo` (`IDempleado`),
  CONSTRAINT `actividadlaboral_ibfk_1` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividadlaboral`
--

LOCK TABLES `actividadlaboral` WRITE;
/*!40000 ALTER TABLE `actividadlaboral` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividadlaboral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencia` (
  `IDasistencia` varchar(30) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `hraEntrada` time NOT NULL,
  `hraSalida` time DEFAULT NULL,
  `tiempo_trabajado_hras` decimal(10,0) NOT NULL,
  `leyenda` varchar(20) NOT NULL,
  `turno` varchar(20) NOT NULL,
  PRIMARY KEY (`IDasistencia`),
  KEY `IDempelado` (`IDempleado`),
  CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditoria` (
  `Identificador` varchar(33) NOT NULL DEFAULT '',
  `USR_UID` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `rol_usuario` varchar(60) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `hra_ingreso` time NOT NULL,
  `IPterminal` varchar(30) NOT NULL,
  `Menu` varchar(40) NOT NULL,
  `Submenu` varchar(40) NOT NULL,
  `Opcion` varchar(40) NOT NULL,
  `navegador_web` varchar(40) NOT NULL,
  PRIMARY KEY (`Identificador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES ('007wl0mzhmr0j5unjvqc1a0c21pviodsj','MPV2013907','mperez','empleado','2014-06-15','13:32:35','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('00xj0dp73xf0dta4v2vjrmepylbwjdfbv','MPV2013907','mperez','empleado','2014-06-15','13:44:42','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('07590vpmgtm6hrs0jk6odomnp0o15loqm','carlos2013472','carlos','encargado de almacen','2014-06-17','15:56:49','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('078502nky45ozstm7pcjuae7n1ghmyzku','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:11:02','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('08cai0vm9fuio5opy6ct6gkvemwduwpuk','carlos2013472','carlos','encargado de almacen','2014-06-17','19:59:27','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('09p4qzm9k9r80gykt7jt06rrjjmym4wsv','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:53:58','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0c7dbu2b2794rjes8mwi8zqoarusqvf6c','giovani2013290','giovani','contratista de proyectos','2014-06-16','17:40:42','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0chqpp4g8ecxpy9bg09teb9oypqsue81s','hector2013852','hector','convocante','2014-06-15','18:13:52','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0cm4qe0r4xlsjl5esv34ixigu9z3riys5','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:22:23','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0evkhxwu8zpld3flwt3676ke9do6mylgg','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:24','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0f6pen6hxbs38deits535piesv16y9e3x','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:22:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0fxbdh0mw4un08pb97rsxforxxd1uzjls','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:19:52','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0hgplfwe3z1qst3nzgr9slhe7pwl3oy04','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:25:06','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0orjvve31xvkoekq5c8fsctyamw8chtxh','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:23','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0p75sduvfvurzlg9g4p2wwgwc5uvk8mub','giovani2013290','giovani','contratista de proyectos','2014-06-17','11:19:13','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0qbjw9sw1ffej6uon9unqahlvboanu3vp','giovani2013290','giovani','contratista de proyectos','2014-06-16','17:39:07','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0ts4tej3zch7db6mvgplmdakihxkrucem','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:55:04','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0ttth0ddkeco60bijelds45f62iz0wni7','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:08','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0u8rhfqiarbaqmsrhwk14co751c1ye95j','carlos2013472','carlos','encargado de almacen','2014-06-17','10:24:38','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0v9n0699nplux1lb2utupaval5ecgymic','MPV2013907','mperez','empleado','2014-06-14','23:37:46','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0vblt5mraroqjkbtbjfh2ca269tl26st0','giovani2013290','giovani','contratista de proyectos','2014-06-21','22:14:57','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('0vfk9xa6p4uwrr2sw1ldj1eldxi5v1d2d','MPV2013907','mperez','empleado','2014-06-14','23:31:29','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0vur70j6un8zlgc6xvex51wn944ixvqsp','MPV2013907','mperez','empleado','2014-06-14','18:02:06','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0wm8yvcpa11ikxt0tf6u1kn3au9crg4h6','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:09','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0x40a4tx3y88612i4i8ldhztrp6rft1uc','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:14:06','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('0y9egdq106jxgqwu3mrzt3r5oblu2ok7r','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:04','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('106x5t4cqqqnc5fkce4ff6zay6exmxtzb','giovani2013290','giovani','contratista de proyectos','2014-06-15','20:00:58','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('13oqi18gd4e1ajo01qlu4a3r1ncwlwte4','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:40:42','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('14nkhc3gqg3x0zvbgkpe11knxyfhdjins','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:10:09','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('15zzucap4dnp7snqh9vvtjbil0to8tfzy','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:40:00','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('17l7xqrcdxzlqjwrh99ynnleaw07zz4wl','alexis2013881','alexis','proveedor de mano de obra','2014-06-21','20:07:53','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('1btw6dsouyofxl722tpk9ztq95svrl7g7','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:09:03','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('1g1rsvdny1o633oecg7z45sv1tmhzprn5','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','10:41:41','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1g6d7imoy0x15740yy5ro0p6m2lykrrlz','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:24:07','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('1g82nhe580sduwnhylg8lsemv9l98leur','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:49:28','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('1grml1atcm6hsn8e62sfg1sulgn392hvb','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-21','11:05:05','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('1hfk0gcob1k8uwe9qysfnse8j4ycgkvdw','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','10:31:01','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1kiv4qz4jb024at9nglf4tz244918jhik','MPV2013907','mperez','empleado','2014-06-14','23:51:05','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1kuozmgo2pd9dzv5y2cwoasmmgnwl4vvb','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:45','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1mfct0ot9vfmxqcdo683eohdmrqqy6aa8','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:51:54','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1nj661okrx5km4ihisheqsvdoe0cxtppj','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','00:15:44','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1qas52s9v4uegsa0t5lnja76kvzbpvjtm','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:32:03','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1qdpqsqpg9cbck70q8cdieso02nbr4gma','carlos2013472','carlos','encargado de almacen','2014-06-17','10:50:02','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1r6j2klna6uyiu7622d3pri3k1pyacpvu','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:06:21','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1udlq3o5m4rgg2js165u29j63j056xv8d','adolfo2013947','adolfo','gerente tecnico','2014-06-17','17:39:47','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1vye7yz8edfrh46dw7vi1cls942321zn5','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:07','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1wbh03z963t6wt8lh1gisevsynmi4ycs9','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:10:41','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('1zr37cxoo3vqs3vjb4r1mnsa4ice5y9k8','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:09:37','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('218o6401b52mnrznl0860sb5034660p78','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:34:21','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('22fy0fd928kvkkntv5js1rlo8lj6r5ekj','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:54:39','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('26c88b8j1xmty2xkyhoiludi90jze49cs','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:10:59','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2blfowh4vgx5u42vjuxj2me4bl8jk9dg4','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:53:30','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('2c8hmne2rdnh1l2e03cg0kll8jjobol99','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','19:07:36','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2d6d4f3swqdbmv8r1budo0vviogjcargo','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:03:33','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2dl8gw3saedaxvrh6zq31axc6d0lpxfrc','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:25:08','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2ejn10wpsk0wwf258su8wit5ctouytrro','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:17:08','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2gni3ljoq87idxjykajzvvj8ifbck02z5','adolfo2013947','adolfo','gerente tecnico','2014-06-17','19:05:37','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2hko5m5uhu1wperuj092w5yqdo6uw4fpb','carlos2013472','carlos','encargado de almacen','2014-06-17','20:06:00','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2hw7b1frpohvails9ijrrye34kxd4axdc','carlos2013472','carlos','encargado de almacen','2014-06-17','15:45:58','127.0.0.1','COMPRA DE RECURSOS','MATERIALES','REGISTRO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2joql8x5zc954vw5trsaz9ml4klxlfmlt','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:44:26','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2jyohujuitmv35g6g0t6zz79thujt7pbv','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:05','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2k55wz0ere46xg815fd8qt6szkgbfioyk','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:14:38','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2ni69r96lq9i65haxr1wq3hllrp8vh71o','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:14:06','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2nwh3niys7ydilefo1hkrz7tb04j7kung','MPV2013907','mperez','empleado','2014-06-14','17:59:34','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2t8xjy3qy2exk9noubjzj66wlulwydxp1','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:32:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2ttvio1fdkemrh7r7gsb65nmnn91ld0ft','adolfo2013947','adolfo','gerente tecnico','2014-06-15','17:29:57','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2wx9ij919x1ej0agvru2ahnugdskgdwy1','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:06:22','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2xlamehtpfkjav1pkqufxpm9ij1k70i1t','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:25:41','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('2xoyxf3h2rqlb7syhy3c1mlnhtw98oofj','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:02:27','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('31ee8a6qeea7lwcll1yltjkwu21zpwwqa','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:06:44','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('33rd7st54q2utgcg70031c8ewtdpng0f1','carlos2013472','carlos','encargado de almacen','2014-06-16','09:41:54','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('35jxfc033ctgiwmdtc2l217fedfubsf23','MPV2013907','mperez','empleado','2014-06-14','23:39:28','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('392c07za3fs2thqgmmlftf67ho0dtzi86','carlos2013472','carlos','encargado de almacen','2014-06-17','20:26:00','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('39vkq51ucjby7o21v1ga301w1m7ekektj','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:58:19','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3a1one8v1ihzwrq9bw2fq5qy41q3c99br','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','10:31:00','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3bojfh4n14mzcufqqx1cblrz3spcxf3fm','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:15:31','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3brv2xsw84glh50in15aneh0n124by6hk','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:49:18','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3dnjnh81zt1ks45sj50cuuzbxvzpvrr65','adolfo2013947','adolfo','gerente tecnico','2014-06-17','19:04:53','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3dzi7lcyo1d5fzovs56ikq7n95yorl8gl','carlos2013472','carlos','encargado de almacen','2014-06-17','20:26:02','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3had3xt9c8gxq6lotfa6v6ffk0f1yqkxk','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:15:30','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3hj437halxt8kkw77lgwd03odgjb9odr2','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:17:38','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3ihm8tcw3d4gk8f4nhyczzrn02gmckj7w','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:24:59','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3jqt52ax5a8cqje3y4y0nucphf6wfini9','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:27','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3pihkpjhzwr1bqtpaa167kie27sadwprn','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:46:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('3y8hhikokqtf32y1eum1wj78alvwyz6ui','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:39:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('3zde9c2fh2t8gpqqeuj7i3wtph44gzhks','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:15','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('412wxgpr5nclwplcj1qgi0148xflx2br2','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:16:45','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('41j7e7wbfn87uadaag1dzoea7tn8i4bq8','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:15:08','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('41rkmxhmopcew9f3ctgnegisssmv2qpnw','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:49:51','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('425dq3xxgq54xks5sy9s290n6aumlgtii','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:41:06','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('42me8yvwiwh5dfoetmk8y7xqgr9uqz710','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:45:52','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('45n2q0y6r1hh89ejco29yrbu53o7br1e6','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:58:19','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('46u75w9vmmsrlf7bocjni3zaqd3poxojh','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','17:57:50','127.0.0.1','ADMIN','ROLES ','REGISTRO DE ROLES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('48rlpm0h1nc1wephfrgxbvusizwna4aiq','MPV2013907','mperez','empleado','2014-06-15','14:14:53','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4blv8jff4rv9y5vfbu5n9qopcn0jff79m','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:29:45','127.0.0.1','COMPRA Y ALQUILER','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4ckzcvd41vby05dembfrj6dbnbwnmf0e9','hector2013852','hector','convocante','2014-06-21','21:59:50','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('4epxcxt93kdfp34dguv6n4vybbiyl3uue','giovani2013290','giovani','contratista de proyectos','2014-06-17','15:14:38','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4h32ce1v6hhmlu1icil4qgkiq70fd6wwk','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:17:46','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4ibf3u613fhqox3fsqe9u3isnqr0w82pn','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:54:39','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4is3u1elzwd0u18f1tkuelu6q1xqzeb2l','carlos2013472','carlos','encargado de almacen','2014-06-17','15:49:42','127.0.0.1','COMPRA DE RECURSOS','MATERIALES','REGISTRO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4j7cpdt3j4zr0b8hnrm2j5qwa9jhcm1gf','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','10:42:14','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4jlxlj0vewuhiivtipe45e842yzgh8g52','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:15:13','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('4jo2rnculzogt5n9qtzdanaw7i3qwf8vs','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:30:46','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4m4d5pzzuixt26e0r06l8ndigkebizqmx','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:27:39','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('4qpiah979ysf6wqsetm7qxg8e8eynct8f','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:20:00','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('4veg1bmyoslqxolkqsmuqdnqzyor0nbzw','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:53:46','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('537ki6fcqqdzlgy3gb6k2s660m3rd164z','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:15','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('58ue0byvynokhv1a8dus8ozzscaxuvvvb','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:00:31','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5989vtnjekq8lwh59dylpk5tyvjok78kx','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:45:48','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5ale0blw40kv6ib970ru2ysmgtm941ljp','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:58:55','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('5bman1zsbxuzvv65kyq28f13qadp42o6c','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:23','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5gfhp4hvmdi4jsg15p2eisbtfey8tel1f','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:31:04','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5gre2gg9vhbp6nmk4mdzr1xepbianyh31','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:43:04','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5h2rek5luahyldfps4wyn5g6k9l30mxos','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:24:25','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5m7eovb4kbnjmnpxsuwm1gzxak9rz9pm0','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:33','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5n4zwugmjlp2hnorz9fonyv1eyp2a54pm','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:46:43','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5oua68gpu2yiyotn8c67luwb685jjmglo','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:46:50','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5oxc3x4izmoidzlal0chlwhqei63dwyxg','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:12:16','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5t135zvucsf8hxnq6kdckgjp8lt05xofh','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:18:29','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5uc660bw1t0fq5ako0e708cyc9l8rhieg','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:11:07','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('5zkg8jndbkwa8zae0d5mibcdeq9kzr92z','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:31:35','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('604rpbpywv8iiulann2z246pfmv9yovt5','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:03:26','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('60dmkzlgs4gagi8skl6d0plzjnrq37z75','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:03:27','127.0.0.1','PLANIFICACION ','FASES','REGISTRO DE FASES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('61jl77k2nt95t6xxxsrxo4mg7fcg17no3','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','19:07:36','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('62aru0ngch5ep8hc1a8blmspd5xq9xp77','MPV2013907','mperez','empleado','2014-06-14','23:57:36','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('64kxodfkz31oct0l5pxl2nv9pijlqydxa','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:38:59','127.0.0.1','COMPRA Y ALQUILER','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('66zxx72fs1dpseuu9ntie2sfcok8ga6vf','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:56:45','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6a2a41mjblf407b2qg5o9p36d1el5ud0q','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:11:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('6bq2nfanxlkkdy96oni8n1firtwp4mfug','MPV2013907','mperez','empleado','2014-06-14','23:34:02','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6c5llt2zgb065hhrr693ihdwz7kvnoycq','MPV2013907','mperez','empleado','2014-06-15','17:17:49','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6c6bvjtj5o6l37la0wmhsm0ni5jsz4mrr','MPV2013907','mperez','empleado','2014-06-14','18:02:08','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6dowu6hf8yvtg85jt468s1yll7c0b9431','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:25:06','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6f0mc3wbi3jdnnw642t9rj43wwt7pbjj9','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:06:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6hfrp1gmvf1nsacq5fftojg9gzo8yfmrc','MPV2013907','mperez','empleado','2014-06-14','23:37:52','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6iogwz6c2k6kl94vvlnmx0a6m6zzzro46','user12014770','user1','operador','2014-06-14','18:50:37','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6lg426rrrhkveb1o9b7l2ohcv8v4mk4wv','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:26:20','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6r9cye4ed51ops567j8wsrt3xbawlzhjd','MPV2013907','mperez','empleado','2014-06-14','23:33:46','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6rk3mbpakp2mxbmnaeno7u3r5avn9j87l','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:49:44','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6tshwks7qg8fdx5d6e3v7z2fokqdshch0','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:39:29','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6unj54bvkmkpz323anpv63f3x4cdoqxap','MPV2013907','mperez','empleado','2014-06-14','23:17:31','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6vvc240g0hrc54p53c3t204bja8tqhwys','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:08:05','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('6vvzk5qqqvo272n9p02tz4563hx1vjtcq','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:02:27','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('6w02mie7iaizqt4wl7ks4wbqfuzy7s64b','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:24:52','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6w710nc5btf4d41n9ml03lhhpf0051g2n','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:33:26','127.0.0.1','COMPRA Y ALQUILER','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('6zgyr8feiblt9edchd0t0zstgmfxonyp6','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:05:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('73rbtm99ohl5mwqjjblfwjue82wh4o4n4','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:49:04','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('74adcxxhnmhekul7x5sjg7rd93crzee4j','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:04:48','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('75467cxxg5rgl85gjcx09mnjkud9vetss','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:34:59','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('77ctcd138i3xb93ix25jbipkqzeshp0r4','user12014770','user1','operador','2014-06-14','18:50:37','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7873q55igiwppguoxc27c1gt4ledsozr6','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:55:03','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7eg9kwgyikgyy8l6zy30xrld2lsd99n3x','giovani2013290','giovani','contratista de proyectos','2014-06-18','08:47:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('7frqnzltsbnkkk1fj8fprxdyprnrotkuc','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:50:09','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('7gceh661gfo6d9k5f3arljae7ww51lgsf','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:48:56','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('7h3kfgov98q7l69qy5x3d475obq07vy65','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:49:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7l12bbw7vomthg3j4u8qmmndiugeup9vb','carlos2013472','carlos','encargado de almacen','2014-06-17','15:46:42','127.0.0.1','COMPRA DE RECURSOS','MATERIALES','REGISTRO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7o7d34ytaukm26jelmd5e4xs1f61nujwz','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:58','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7ocuyqf2a15dw6uq0n84oql176kmxtqh4','MPV2013907','mperez','empleado','2014-06-14','23:46:08','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7ov7gtrnj7wrehjesg8y4ukb8l8i906zl','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:45','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7pdm55h68arkfm81bq0cqszzkhrxtxg67','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:01:38','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('7pnzbzj5pboo77w1z28ytjutpbg7l6mql','adolfo2013947','adolfo','gerente tecnico','2014-06-15','19:00:01','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7qdqhp5muyipifb2nezdy1lqrywz6q9d4','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:45','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7qtdvhzc0hei3z7upjgxenyxh3arsrs61','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:47:12','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7u1z3ihxkbjsft34hf4m2zxj6q9x1g4pq','adolfo2013947','adolfo','gerente tecnico','2014-06-17','19:05:37','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7v18wjf21i4te5js467v3fa6qswnpb9n3','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:09:45','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7v2v5s8lcyvriukv8bcaujly1mput04ty','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:29:36','127.0.0.1','COMPRA Y ALQUILER','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('7w8sqazyu39ijdb8fe6y6usuewp4ufd04','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:29:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('81g7346wj1pr6fz5vb60lj9dj76o2hat8','MPV2013907','mperez','empleado','2014-06-15','14:09:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('836pyr8yeomfqn1r8c6unieka8rn5ee0d','hector2013852','hector','convocante','2014-06-21','22:10:32','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('83juz2hpk8gfel6mslsiu8funl5ddlkt0','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:27:41','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('846h46e8xo8uv1gr0iyfp9lluf88dmnil','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:33:37','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('8b5mplx9roq3rtwl913uw2lbh8zfb8380','hector2013852','hector','convocante','2014-06-21','22:13:47','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('8es0b3tvs7z64cpjz7ovwyqz5d19j7zv6','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:04:07','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8f828x69vmkacemk77977zkd2cq8rpcs0','giovani2013290','giovani','contratista de proyectos','2014-06-15','14:34:14','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8gf5hs222x1nk23i4mctoxahqgzgxm7n1','giovani2013290','giovani','contratista de proyectos','2014-06-21','10:51:27','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('8llikj8eeradp2dv2duo6t7yozgmkwyfm','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:49:04','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('8melqma292y50qtu359ynw5f9nfmuyyg5','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:14:38','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8onwsj3kqy40d7cnfr7uh20cz8fowz6zo','giovani2013290','giovani','contratista de proyectos','2014-06-16','17:47:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8oy3ranrp3176tqq4lupr2vuiuyjlrlmy','carlos2013472','carlos','encargado de almacen','2014-06-17','15:56:50','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8q07hgef9qchglq5g7vevqsm6v795anek','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:25:41','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8qds9s6h45p1uf4j6gskqdwwmlxz64spq','MPV2013907','mperez','empleado','2014-06-15','13:35:52','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8ubhsck7qsb91b2uz3ffaarwovh5y91lm','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:54:25','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8uzvjhfjib94g2pg9247fi9lghv2quhq0','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:15:16','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('8xpdyz89e3f4l4h94bzh1gjn78q0g5q9c','carlos2013472','carlos','encargado de almacen','2014-06-17','15:57:40','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8zfxlqso7ivb2ak9h0nih1dev76n6zop6','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','18:11:40','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('8zjxc0wlq4o7yjimyslzmmmvyv7bn1d34','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:12:29','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('902lf95l9nyau50fsefpgy1w20a1zk88k','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','16:08:49','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('90cniiegyk0keallwwnnk165zdcj1fcqh','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:26:34','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('90ebc3232qh4y4x9sin21c4ug2i89zojl','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:09:37','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('94fz4pkq9yn3w82xy1lbb154qkmzgf22d','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:13:48','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('94yrt74oq4ky4a2nnntp5e9ls6lgwf87x','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:05:20','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('963zs2ki4pjxd8n6mmz9qf9w2otnw780f','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:02:20','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('976p9n38k0d5zr2y8bpl18enz650uh45j','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:24:26','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('9a08c1i81cyg1lxb0bi12yx9i0jnp2h0o','carlos2013472','carlos','encargado de almacen','2014-06-16','09:46:19','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9af51j0eld6ltbgubf0orj9vxou9312h6','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','09:55:21','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9bnz3rl9vjeenuey1igc67xp6dlyemri7','carlos2013472','carlos','encargado de almacen','2014-06-17','15:42:09','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9dhbrmvtlg1to5jj7cxrolzzzt82cbjwa','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:27:31','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('9ex6zscy99rd7cgc9jb4klhbb6bln08e0','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:30','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9igiugijbiprrz9aond96gcnmg3g3j9ne','MPV2013907','mperez','empleado','2014-06-14','23:42:26','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9jzavnmmlh4zqdmzvsr5mx7sht05ec5tv','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:56:24','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9k2ocsqipklirz7dhftvb3qp55zu0qnil','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:08','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('9knp859d5lg5vdo1elpw6mobhue9a4pej','carlos2013472','carlos','encargado de almacen','2014-06-17','20:06:00','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9m229qnmr494s889p4x8nfy7ayfg16o4d','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:47:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9mip56xwttx94d528o8xzareb6nfzy5po','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:45:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9nso7oa2xikrkylcorzg7hxzmhnjf6qgz','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:08:40','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9qkta6aerrbc4yv3srad6e9fjgeien0ls','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:07:24','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9qw75huy2hs2x5oqn7tqvxbz4za2b9fio','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:50:09','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('9r8bjp233omqhdz8g8c3mfuhczmnsv2cf','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:17','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9tev5hn96l3zkpam50gkxxueww6sypbd2','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:28:10','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9u6rltxvpxgflbw85burxbci6t9rwgg9f','adolfo2013947','adolfo','gerente tecnico','2014-06-17','17:39:57','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9ufcskmvnl817unzdcgjwnhk1i4491qkd','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:19:01','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('9vbk37meitxmajkt30na0ffqmqkupnip7','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:21:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('a4io4p4sal73t0ww56efnvsyka9q6z8v3','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:27:41','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('aatsl4szfsgqiqvlywxm1ff0o05zdunkk','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:06:44','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ab6dy5vknkob1nndyuhx1tffixripfqx2','hector2013852','hector','convocante','2014-06-15','18:08:49','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('abr59kqkd0j68wkmi9ffi9vxyy1erfn87','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:16','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('acprya5xdbzfia9r34psvu8llb8lw8gsx','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:19:12','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('af7z2nthgrff9mjvfy02lzeudoxlss0zs','carlos2013472','carlos','encargado de almacen','2014-06-16','09:46:15','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('agp68t9ccv1ic0eklesczm908q0db6hi3','carlos2013472','carlos','encargado de almacen','2014-06-16','09:41:54','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ai5tsuw4qes2q6uv52nx7igs9fmpiud0v','MPV2013907','mperez','empleado','2014-06-14','23:35:08','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ajomp6947189rz55hy4lc4kqm9h699yg1','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:19:51','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('alnxclsn8th9c1m28jloyzajvoyl05aco','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:24:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('amcsum6ekqfhxuhw47vwd86zh0ba05dzc','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:39:47','127.0.0.1','COMPRA Y ALQUILER','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('an5hebmb1iffc9p4vyuf74amu1vjpvhno','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:08:29','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('anav870zm9vxeqgf9n67wf1q19ekwaar6','alexis2013881','alexis','proveedor de mano de obra','2014-06-21','20:07:54','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('apigsovwctbrpv2jkneznk64p3boo7yqo','hector2013852','hector','convocante','2014-06-21','22:09:47','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('aqw1d9ln4jf24wpott374i767n9ep68xw','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:57:28','127.0.0.1','PLANIFICACION ','CARGO MANO DE OBRA','REGISTRO DE CARGOS DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('arot96kf30fbvk6y6wqlfy6y7fatvtyhr','MPV2013907','mperez','empleado','2014-06-14','23:39:28','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('atrnug3ew1ohy7d4yi8h893py6f9jsqwa','adolfo2013947','adolfo','gerente tecnico','2014-06-17','10:21:58','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ay82idxg47nltuf30fj7kia2inc79gnc8','giovani2013290','giovani','contratista de proyectos','2014-06-15','14:34:14','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('b2stoqxrkjfgqtvwzrx6ppu7x5cb6dobt','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:27:41','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('b3q7x6fevqwsmcjhczfxuoge20cfu2ecb','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-21','11:05:05','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('b4p2xhcir411njis7z0ri395rnvq72s0z','MPV2013907','mperez','empleado','2014-06-14','23:46:11','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('b822gy0uknzgcn9d4oldidnxss6z56i53','adolfo2013947','adolfo','gerente tecnico','2014-06-17','15:21:48','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ba54qflykumddg453zbvdhc1x7phgtru8','adolfo2013947','adolfo','gerente tecnico','2014-06-17','17:40:29','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bbheexikqb2gj50dricxkfegvab53bk6b','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:56:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('bcs591s1jcx7zgkymiubvvj0c30t34mzt','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:11:48','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bh58529l6axjzmo90ebs0r1oyg59hgj2g','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:03:38','127.0.0.1','PLANIFICACION ','FASES','REGISTRO DE FASES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bj0pobxqxxh0zgkj751bvv7iqpjo2l2vk','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:00:31','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bjgqgn1ugz40xse7vndfp8vrw69pd1hhe','carlos2013472','carlos','encargado de almacen','2014-06-17','15:57:40','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bkymn4os2cx4m9pw3taely0o81gubefg2','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:23','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('blho62zwt10kr2v2g00tblwbfmmyig8om','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:48:52','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bqi5oisn9oqa0bmxce2nhc1su0unto6so','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:24:25','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('btso22x933otg860ibn4zt4ywcrrulay2','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:30','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('buuy8v9m9nvtzmg9jyac0j42lz38zxyq9','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:11:44','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('bvagyilnx8k2hy9yr4f8ic0tho4m98n0t','adolfo2013947','adolfo','gerente tecnico','2014-06-21','21:18:01','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('bvl7gz7ha5104pd3ay1ebfstpcv5wqa1i','MPV2013907','mperez','empleado','2014-06-14','23:37:59','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('byxw5n4lspdujh2f0ffki6msnlmherghp','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('c0zso750n7b50w0yi6h5xldnkasv0otj7','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:09','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('c347yj735pwvkvqd27vlkznmlsfrmuxrt','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','09:55:21','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('c44tqf6r127gxzm2w3wch0wglj70s8l8q','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:15:04','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('c5qm22p2tdwd6zapnacsrhq3s7jbypiqy','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:09','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ce7kda9hsdh3e2e12tnv9m7ou6gapn6tl','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:44:28','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('chfgem9dxmi72grqdcwkbb77llet9ozd5','MPV2013907','mperez','empleado','2014-06-15','14:14:53','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('cjodc9v8plh18qznbn11a7zjefgajbve5','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:53','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('clw4ni1fdnm44rncjlffvtx3n4fk9bh1v','hector2013852','hector','convocante','2014-06-21','22:10:32','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('cmjmvvomctr6dj799xjr8ox9voo2e5drp','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:03:20','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('cnp96b4gd6f8ij824aex6yzljx8o4gte7','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:12:49','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('cpvn11l5pcekqlytecilio5y7ep5en6vp','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:29:27','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ctawjjpwmdycjv6tca8umxphcd3eg54v1','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ctd7q4h0zaucnrle1w3gp7w35usafcekr','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','17:57:50','127.0.0.1','ADMIN','ROLES ','REGISTRO DE ROLES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('cw8wtctxqrvp8bj7vduq1mz27rngnf7fn','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-17','15:42:30','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('cyui1v5a3d6fwwdh8hrw4l0mgrmy1oga7','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:32:47','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('cyxlmexglmla6bemtxdjngohlwwz31yxg','carlos2013472','carlos','encargado de almacen','2014-06-17','19:34:12','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('db96mbmfcafe58z8ksuy07h59s25ud13p','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:56','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('dd4b83l3vx5zl7mx8yyqg1knoain1n9if','hector2013852','hector','convocante','2014-06-21','22:14:18','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('dd59x9i08kzqkd3j396g7bobzwr0g67r2','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:10:01','127.0.0.1','PLANIFICACION ','SUBFASE','REGISTRO DE SUBFASES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ddhipby3h47098bq3ehamrhoql34gohap','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:11:47','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dhqkbub85q06u5nfsflcmxfjhyh6pppu6','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:21:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('di7aimk8xg6ydkp8v9ojwtei01cv5jc80','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:22:43','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('djl7jsj9ucy3cwm0suvxc4bh89300r6by','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:14:11','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dn9ep6si8eug5n9di626nnn300vacnn8a','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:20:15','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dofbnmh2n40kjou90ikhojt7w7r9otoqr','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:32:35','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dqivds1222070k1llob94vibtyl44z0d5','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:18:49','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dr802bmp22pa8jwbwt4q25o7ftm14m7is','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:36:16','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dt8ltjnokczdfws2x04wankyc08rutwwr','carlos2013472','carlos','encargado de almacen','2014-06-17','10:24:38','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dw0h29c4qa41lxfe608hffyns2j0fw6x5','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:36','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dyljx5q2fr9pfp4zezobjon9kj9hkt9il','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:01:23','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('dzq2m3jj7ryjuv6z8aqbz9o1zwwgx9ym1','adolfo2013947','adolfo','gerente tecnico','2014-06-17','17:39:47','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e046mxqpsrh32bs5yzrrhwl7bp2pqufys','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:01:05','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('e0s5bas09pjat3cknu1elx399552o50mm','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:25:14','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e1us0bum9c1tt4i8pnhu32iz8oq1swc26','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:44:28','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e36k8hqo05h9tef1znn3qu7k4ijdyxohd','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:10:37','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e4201rr6zh1rbx5aes0g2jby50tgz69d9','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:28:49','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e6qbz7cj6vgnqxtvzpno3rfkioj2d5q3h','giovani2013290','giovani','contratista de proyectos','2014-06-15','14:53:20','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e70zivgumr5619zspk8qqpf217umv3xzz','carlos2013472','carlos','encargado de almacen','2014-06-17','20:26:00','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e7wz9q0tgn4sf2xtd9vx2ztg7cvc9b1qn','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:09','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e8mc9f9pzlf8c34t4s7jmhpvibqjs2l2q','MPV2013907','mperez','empleado','2014-06-14','18:03:09','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('e9s222f8iqw7edmas5ilkv0royyct0dt1','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:26:53','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('eacqe92fijl1i1e5gbrapgcyfpinzs835','carlos2013472','carlos','encargado de almacen','2014-06-17','10:50:02','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ead8qfpqx55ssqq4ygtnp9x9stduqud6d','carlos2013472','carlos','encargado de almacen','2014-06-16','09:45:25','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('eawd327ckw687uaq9xtbypj7zo1hq06cq','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:11','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ebz6h6wdje7q24rp2yr4tpf11gnhdrnw4','carlos2013472','carlos','encargado de almacen','2014-06-17','10:47:11','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ed239190zu5b98cjvvl32aeaoithmzt0m','adolfo2013947','adolfo','gerente tecnico','2014-06-15','17:29:57','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('efd211y9q2qca3ghcelo2x5rrjxoyaxmz','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:19','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ejzbhpppvt9gez3ymh3wtsh9m514zvp81','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:53:46','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('el24pthefpqbv5s4crpp6dfnc2j02783q','giovani2013290','giovani','contratista de proyectos','2014-06-15','14:53:20','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ep2x6mkkk1rx6g0m4qnizvzm5zdzam3z3','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:42:15','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('er36lyietq3pkiy8hfprxq5ycu40efhrl','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:04:57','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('etvaebiaidqe0ne948k1u4jqhv1owia4e','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:33:26','127.0.0.1','COMPRA Y ALQUILER','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('eusb7oo3osikedu8omds6on7jg0d357w8','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:05','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ev58dzvueo9sr5b3fycojflqd5v0tsnka','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:56:24','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ewfxdi1eugx7evkgo7nfneaht4qcupk96','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:28:23','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('exazd7can2gd03vf3zx9mu49xpl7ucuo1','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:25:12','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('f1qsf1gqzbv84b24j5qsji1w6ta9or4ji','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:12:02','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('f29fxijy993jtfgmbuy6xp5h30wayx18a','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:28:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('f615htno53bd63x13ii2kojmbixirvxt4','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:43:33','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('f9fb079y4unsputkhrfs59itgt8f8ibpq','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:26:34','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fc0tndbowvnysyhaym3jol701ii1vi91q','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:59:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('fhxbks24mnaqs16eeoqw0ns5jj5e9o0c0','giovani2013290','giovani','contratista de proyectos','2014-06-17','15:14:38','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fjntkaf276bbvpt0iiybruexmm6lqr07v','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:07:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('flbtm854qf9ur1goslp7s2gc1v5xooeuo','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:51:13','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('fmvk6bod2mt3485oix7lkxyp2tuectwou','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:45:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fomykdmax5mowrdt18b9035o2jm179ht7','MPV2013907','mperez','empleado','2014-06-14','23:40:01','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fpxd91ahmrhyvet285oncd23o9qd6yq0a','MPV2013907','mperez','empleado','2014-06-14','18:02:11','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fs8ms95gzc4w3njlq9ds6gh7zg61sbw9k','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:05:03','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fvstozp1w54b9qtk0y6jmt3iszfh2d4su','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:22:43','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fz1a2dw2zn87ag661kg4d9ot7gz6g4vlx','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:49:36','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('fzn88p4ueg0m694eqcvnrtjm8xfy3uxq2','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:30','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('g48x5wiaeq3poev5qgcxpdcm1yaalu12x','adolfo2013947','adolfo','gerente tecnico','2014-06-17','19:04:53','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('g4b57lrxzrflzzs519nt4u5wx7p6hu0sk','giovani2013290','giovani','contratista de proyectos','2014-06-16','15:30:52','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('gatzjn1ygdke86d3pr4zh6h6vmqksc3o0','MPV2013907','mperez','empleado','2014-06-14','18:00:32','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('gdp56k3rbxic79zwqzyvvfgtsusopaiys','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:53:05','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ggrrmqykehy5zvk1kso6163ku4y3kthnh','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:15:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('gh07rq1d0sxto60vcwsbj7lpq5ec47f0y','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:26:53','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ghxny3tcxfafkuf6ccpetogvj0r50ojg3','MPV2013907','mperez','empleado','2014-06-14','18:02:08','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('gkmkj9x33xvs4qx3whpy7ik6ka7z7grm4','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:42:08','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('gqq3mpovcse73ap2bz4iov1yxwocb3ll1','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:11','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('gwzkbbjew87io3m9p5zqvrv45ivmeev49','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:41:59','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('h393jasz16capri11oi87mg1rxgr7l88n','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:37:35','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('h3e1ll5ofhk0vnalpo7ko0pqf99zdz974','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:22:11','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('h3rutl4hpuvv4nq35r9htftsopmmc0h7i','MPV2013907','mperez','empleado','2014-06-15','13:26:53','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('h3wc371j2jhdoxbd85daiglz1z96049uv','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:53:05','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('h4hulbro3xyhgep8dkw8i7kbaydgm4f3v','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('h4l3mtdgipzlh3p3ri5n2x96jn1y5yw2v','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:33:34','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('h5t2uul14le0xu4raq6emovbhaxo755ex','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:03:09','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('h7hsooqd474i6bnpfch13m40ap8frnm2k','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:23','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('h8jhb0cfoxsesd3etsfitt7999ubfgiq6','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:45:57','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hb22w7jndg7q86devbt8knmtuza9ihrdj','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:13:10','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hbkg1s3i2ff064z3439stonpeolwyxab9','hector2013852','hector','convocante','2014-06-21','22:05:07','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hd5xf1370l6a8d8o63mmeiruu1v5joytc','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:05','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hdcfgdor6p6lahf5vaaflnzefyq2wnmbl','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:01:37','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hdkq774wd99dkn0f754q693uywvrzuu3o','MPV2013907','mperez','empleado','2014-06-14','18:03:06','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hg8fppq7urnl2gi23q0tpdoyjr4mfpgv8','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:32:38','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hhlcyvnnt1kgy5hw5mnkpqfkuscppinvk','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:14:11','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hkaeorqwqibqcfzsfjcrdaoz8hslulfm1','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:04:10','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hlx4wr8d5rbfgzhtx9lmr8uc6sg5cftvi','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:41:44','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hphbkaao07tkap9q6fy50bdgjbzxbq24n','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:17:38','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hq19xf5wg4ee7m6gak1holgulbure0dvm','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:13','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hte6ohe71qu08d34x5zclp9uj9guv8m6e','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:54:29','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hvbq8tsce9pit0da4k4288z3axaghbkmb','carlos2013472','carlos','encargado de almacen','2014-06-17','15:50:20','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('hwp7bl04sr26fu3ab3wa5lt0nolpf4uxw','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:23:16','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('hy6vhcv6a34j6d8u9g4q8dc84cvbey45o','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:07','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('i0292l1r4xplayyz2d0sfnrypc9syqc5w','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:28:32','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('i1lsasvez7zh00esmuxw5pp0lg1h991jv','MPV2013907','mperez','empleado','2014-06-14','23:51:57','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('i2dn8rgsfcclf1uv8b3erhmnjmw572edx','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:15','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('i668xc2l7qzayt2utidicr4um8fpe8qeq','MPV2013907','mperez','empleado','2014-06-14','18:00:32','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('i7ldz14bzjpestabyii8nuqxuwpbxk35s','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:51:10','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('iahngmb0nmvtg1rs55pbj735hva7hiszw','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:33:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ibd1cagh424ges83vfdtkggwmj6buuqp8','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:46:55','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('if43jn10n7aj9i95abykeg5p76l35idb3','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:18:15','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ifxiaiy34hb107yg13w0cb1pfjr9aq218','adolfo2013947','adolfo','gerente tecnico','2014-06-15','17:29:47','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ihydiky0y6e88zme02sgts2bybyxkyea8','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:39:18','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ipbyefceb07k558z4ulq4sw0oiz5a3xup','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:46:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('is77zh5uzrit0bvpsbf8puc5v6s07ul1v','adolfo2013947','adolfo','gerente tecnico','2014-06-17','10:22:31','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('isoru38zent626qi5tu535qxlhgh4p4mv','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:33:44','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('iv2vtmw5tu7vzahiivr4kyvwwkqec7t57','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:03:27','127.0.0.1','PLANIFICACION ','FASES','REGISTRO DE FASES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('iw1spqmwecrjdk5m75012bdfkt1a0v5uj','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:53:46','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('iwr3xim4cjxk7jpc1bimtc0wggs5uilr3','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:10:03','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('iy6mj3c65rnej1m06tul5qmtmdblugiz5','MPV2013907','mperez','empleado','2014-06-15','17:17:48','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('j1nhbifua5ky0x1lrjc4ksbezraqth3r6','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:43:04','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('j1rn3crt9g75m12xa0y9429z2aif41i1i','carlos2013472','carlos','encargado de almacen','2014-06-16','09:45:25','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('j1x9idx0bgyjqt033thvti54ketrpjzub','MPV2013907','mperez','empleado','2014-06-14','23:46:11','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('j5kq2pwr9hk666gb97ki1ig066vihwvcj','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:48:14','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('j9n5i2v6qf9x1k2qvadt5oylxovse260a','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:49:28','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ja7xiybvnb8drwwv96bv6plgxbtx1r6re','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:15','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jb61mvsbsqnmd5y6ob2sel0s9u9dxer0d','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:03:54','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('jgb5rzbc6tbzap3vnkdr3guxdbqa6nvrv','MPV2013907','mperez','empleado','2014-06-14','23:26:54','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jghaxil8fg129kzqz5qbtals8zn4zscav','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:11','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ji6ugja1t67kycmrof5fyn74ph0rxi8k8','MPV2013907','mperez','empleado','2014-06-14','23:31:29','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jil1rhg0wi097c6z48f8ihuzux1hu60u7','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:01:05','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('jis3n5znmjzbv66fu1iw8w61w8nkrrr2k','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:55:44','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('jj3iiyxenj5eft4wcto7ajkqa7y39tpud','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:25:12','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jjk7tgkvhbhmz57utsc7y8rfp9gwaqj8u','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:46:55','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jm7ixs8ncnx01hp083q3dgxgk14vyikfg','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:10:41','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jse939f290p3m14utgtzn7t2o279z2t32','carlos2013472','carlos','encargado de almacen','2014-06-17','19:34:12','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jums3h9s1ty6hlmsq1gkuvbza2ae0jp1e','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:13','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jv1ednuzujvaaqxi368xd7lwobh97pcnq','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:41:36','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('jx5i2ghk3nf2a1oy951tf37kl15z16r4v','carlos2013472','carlos','encargado de almacen','2014-06-16','09:41:40','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jygjoz52b5m3ac14dy8kka4q6y6894ktb','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:22','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('jz1ebwe98ydflhqa7hxzt26tqfjkal061','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:48:18','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('jzpajt9egckfkvqd6ufnzig0kub1xftvo','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:45:35','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k0w0b7mffq2t4g4aqbpmbineaxvx7f323','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:00:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k1va8qd1z8mtt03i1oh396vjtz42zy8xk','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:50:16','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k3f2ww4sd4pqkhp69ycrci2uk6iklxmnh','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:18:49','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k4uvv8debjk21gnexus9lkuahizl4kgmk','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:47:12','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k85apvc3xvqqnpfqernfp4t4y7lhgonh2','giovani2013290','giovani','contratista de proyectos','2014-06-21','10:51:27','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('k8tkgwtiehfoevfzba60w7etp6f3e31fd','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:31:50','127.0.0.1','COMPRA Y ALQUILER','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k97mjvvscr0her8r2au9gzwuqymglf4th','MPV2013907','mperez','empleado','2014-06-15','13:35:57','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('k9g17hheppd4rs0bwhovtreg37ndztheg','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:15:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kcneycpybn341qx3dp0snoa44srwjgzov','carlos2013472','carlos','encargado de almacen','2014-06-16','09:45:30','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kddrt6ft39dlz9bsgoskcnopzw060bynw','carlos2013472','carlos','encargado de almacen','2014-06-17','20:26:02','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kdhq7dew2p4e4y3w11n0iimzh3x5qgdzy','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','00:15:56','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('khbzqmcblddix2wkpbci7z2xnkz092pp4','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:11','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('khwr87zxaig16nlvwnv55nz15cmzld6ni','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:25:21','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('khxysetr4y73e7nt2qxhkv7r8huchha2q','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:39:31','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kldqqladbevgywpi4gyqrty28yjmqvxda','alexis2013881','alexis','proveedor de mano de obra','2014-06-21','20:07:44','127.0.0.1','REPORTES','REPORTE DE MANO DE OBRA','REPORTE DE SOLICITUD DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('konrju8ngxnjz3o16gcpnenjxpuxmu09j','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:15:08','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('kqowiomhqa3jms5cusd7rp9d45pms3ezq','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:56:27','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('krxp5ga2nb4ed8ewrr3j6xrfcjzyifj6n','carlos2013472','carlos','encargado de almacen','2014-06-17','15:51:40','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kv63xs6sg6gkgeeh4smxmdmk4vtj8sipd','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:41:36','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('kv8k5va72dp7q8z2qlktv5o128sb7tw1r','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:04:52','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kw0g37wasrhgaayzk7d2wdfej5x9v8k1x','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:05:20','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kxnnyjgpkjzn4aymo2azgc72zfyxb6xdp','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:55:52','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('kynjuh3ykroc3l5sykkwzsmd7x9txp1nq','carlos2013472','carlos','encargado de almacen','2014-06-17','20:06:05','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('l1ivfas32ii7lgf8z8zz37n0l92lofwph','MPV2013907','mperez','empleado','2014-06-15','14:07:57','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('l20r37hrkc24o6kmiswp690u9dd6gtj5f','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:12:37','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('l4eqjoreej2330o8awu86dobvw4x6q5g5','MPV2013907','mperez','empleado','2014-06-14','23:37:46','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('l5xrmi6shleyytb1fufjuyhhijz4mgn7t','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:23:11','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('l8kcat69s3aj1dlihmmpagwir9ljji21o','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','00:16:01','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('l8t3h5cqtgvwcv8p4egeekxbwp5qsam1j','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:39:48','127.0.0.1','COMPRA Y ALQUILER','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('l8wahk3szd1mr9xhly2gwyj84todyvn05','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:35','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('l9pocrgmesdrdxa92x1vyndx1acq10kl9','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:53:33','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lb2jqi56mdyjx4hvn2g7z58hva9s8m2jz','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:04:48','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lfbwkiz3otmw2hhleoxfwh9vfgojl721f','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:25:40','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lffj65nyyvip1ah7c3gyhg5nek3bunmrz','hector2013852','hector','convocante','2014-06-21','21:59:50','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('lhpaqshw7pngpk8ag9oq64sv7l8avlnql','MPV2013907','mperez','empleado','2014-06-14','23:33:42','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('liw51qyjlyfz4u7tuje0pm22zld3jsoou','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:10:52','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ljcqb9lgb1ublwhgtqbp88ujkk8lm16d7','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:45:19','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lm4l4kaylhl5ooeoaduj8wfqlrrvgs9o9','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:13:10','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('loa4bzwc8j55l6aq7wqxqrnyjpzybo5dw','carlos2013472','carlos','encargado de almacen','2014-06-17','19:59:27','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lpb6epk61vsd7zfl7bu2qtrq1ae6al4it','giovani2013290','giovani','contratista de proyectos','2014-06-16','17:39:07','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lpp5djjlzel1ond1t3wzf366gberchevy','carlos2013472','carlos','encargado de almacen','2014-06-17','15:46:43','127.0.0.1','COMPRA DE RECURSOS','MATERIALES','REGISTRO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lqohbx3h7lz4q31ds9iwheiohoxz6ruyd','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:07:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lryb4m4ygf5punf6724fz32pdsckbospi','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:28:04','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ltgmhgzr8szwqbhpta1ss87ddocms89fj','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:42:15','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lvkhly12erd4q8cjgeowo4bzi6knv9jc8','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:24:13','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lw60oll7x7wmun90qiatghfbfpizxzdao','carlos2013472','carlos','encargado de almacen','2014-06-16','09:46:19','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lx1ll0ukko5zgaje2z72lc967zn2d4w5c','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:26:16','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ly84rt3ezdiwmfeu8nz2y6d76ev6r4df9','carlos2013472','carlos','encargado de almacen','2014-06-16','09:46:15','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lzirb0xcho9ehfff3mdjjm5p0oz2ygqp4','giovani2013290','giovani','contratista de proyectos','2014-06-17','11:19:13','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('lzxuxt8qpcioc1af50fvgoxa7t4x5ybrr','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:54:24','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('m1rwbqhg943wg9le8gfa6djnlgjk1zruh','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:32:49','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('m40ae8bd1lmzv4ktx8a3b6k3euhs8fplo','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:28:39','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('m4mx8ooiz32jthafgjc49qarytq4sfyqe','MPV2013907','mperez','empleado','2014-06-14','23:40:01','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('m5pd82iaik02c3d6bph6mr37i6rbpcev9','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:28','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('m6zm6kpsw3zgje84enh45suaw74z4ni0p','MPV2013907','mperez','empleado','2014-06-15','13:34:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ma0c32aypj3gmab3bjf01t84toqp1dqqj','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:26:36','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('map5l2b8qlp2j8fjnaksrzar5zu61kkno','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:37:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('mf8ztq7qrics1yqkta51ir6j32dhorl6j','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:21:42','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mgovrlxjnfzhbj5vwx308ara2u8dkech5','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-17','11:19:04','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mh4ysc312cdfvsy7lpsxnkocm89lg79dk','MPV2013907','mperez','empleado','2014-06-14','23:17:31','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mhixyo7du0vag9yljvp8x6c5cov9ebh73','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:03:09','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('mirktpt0czbhq2b7xguqhv1br11htsff0','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:55:16','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mk2q5mz0k66haegtt7u4prnv91riunigm','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:00:23','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mnt8dwb934tn8zn6nk6s9abnd7uq8tu7y','MPV2013907','mperez','empleado','2014-06-14','23:37:59','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mriki6ladzigsuipxwfpn2skze6lyi95r','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','10:41:41','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mshhnvpz9pbqhhfjuivuu7604761gr770','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:15:31','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mtggkgho5upkle2dkqn3y51mlfmuj78hb','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:47:00','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mwmta0r9w0zq29road8bo5dxnldc88orz','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:25:52','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('mzbztl3nprskem2tsm5hgtq18antzhbac','giovani2013290','giovani','contratista de proyectos','2014-06-21','10:51:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('mzen5qeos5mu1c22687u0zh1kutfoy6z9','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:07:32','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('n1nxyq5cub87lme7o8tte3ial3vihuhcq','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:59:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('n28hhjz1tz72f1cxhphjvs8zhwlqi5682','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:11:47','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','LISTADO DE SOLICITUDES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('n37d8jp6lgndaqn6x51an7ld9ghisrxys','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:31:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('n3aq55x7q1dxt439wfn16cfqihhwtel1x','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:46:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('navfrosqwjq9s5dolgplq6cjtso8pq7q1','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:17:08','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nbmd6qpecwz6esh3ayo18pndk5x9algdt','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:49','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ncit85bk5z6ts6u3ok9l1y2bzpjkd2qf3','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:24:59','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nh1d44vkd01fcvzou3rqhlcawlq4shg63','giovani2013290','giovani','contratista de proyectos','2014-06-17','11:19:15','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nkc52gqahm80moyx4xx7drfvb1f73zxa9','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:20:31','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('no7zoiig3qtpkcy315tq31ct23k4w2yey','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:49:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('np03oj4avxj0xs4myewkw2szgm7ae8x0g','MPV2013907','mperez','empleado','2014-06-14','23:56:45','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('np9pb1vep2oag1j9kt7wfmngisdjktw44','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:40:44','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ntogg2qngvhx7aobfk0iu4tgicg2lvf1j','MPV2013907','mperez','empleado','2014-06-14','23:29:49','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nu273zb83w4ih79jxahhd0e25odstv375','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:46','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nxswq9amjau4zryul4x7ic4ywkbxshfao','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:24:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('nzfyzb26v323tkkj2hk7zwy40vu3iczs9','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:46:44','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('nzl64gvoj7pkm1enn9tkikw9e9l7oba2k','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:15:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('o0t8lqgdnsm8b1voag5r1gnjnix0g29s5','MPV2013907','mperez','empleado','2014-06-14','18:03:39','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('o3m1uc2uaek7o57so58q71rcveakd4j6g','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:41:58','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('o4ptfst56vl08wdgh6tubxbx1mvj97g40','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:49:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('o7tpibm30gkagg8o8udor2pyggxenf60m','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:25:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('o8nkede1f879ypay8n5n4do1e59o261pi','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:56:35','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ob3b4zmhr37kn7yd6g0ujqe6g6qrqpqpb','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:14:15','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('oe4qck7rsmgjttk1l8rr3h6cb67rc6fqh','MPV2013907','mperez','empleado','2014-06-14','23:33:23','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('oivn5cegilw13jk7s4df5qdlwwg8o43bn','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:25','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('oj7zv1v7cfq3zjlgdfa1q4djneza4y0eg','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:51:54','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('olgcwqqrhk1on7545kf9dofx0r76yv5zi','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:12:33','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('om4fefqn5lq71q6fne5uxo9cmwnyv5oxm','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:26:19','127.0.0.1','ADMIN','FORMULARIO DE PARAMETROS','NUEVO PARAMETRO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('on3wab3d9oer6wwsmgvh4rv7mkmnsrwi0','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:57:28','127.0.0.1','PLANIFICACION ','CARGO MANO DE OBRA','REGISTRO DE CARGOS DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('onlwruq35cbqy0v3tm8amqj83q6kzsgud','carlos2013472','carlos','encargado de almacen','2014-06-17','19:36:09','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('oo38s9eq0twxovyyl7hyfrpxyh8hvanjq','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:46:43','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ooi54gdpmx1h7afggjfm7lo2zino0rf41','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:53:37','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('os8efraff41wl0h9cgzvbe7213x86ebid','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:50','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('osj6xc57kects26hce3e7a9jazhswr4rv','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:42:12','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('otk3o9yhwakxbxcj1lvsbogv7w6kydhmq','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:12:29','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('oupprru1u12qwrq7ohx0mapb9c60xjluj','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:41:06','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ov5p1w2p0qbsw0d59q64n8boqh9rdxn9y','MPV2013907','mperez','empleado','2014-06-14','23:46:08','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('owbmk2h6qcmzl2i7zgkq9ynpmulfjd4yl','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:37:00','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ox2xu246q35k7kqud45093ttopl2zt3zl','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:33:58','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ox87grnxhko8r0iojpia8pi947wsn2v1x','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:21:59','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('oy58ofeqwaz5ahphbyxyam200nw9f3bs4','giovani2013290','giovani','contratista de proyectos','2014-06-21','22:14:57','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('p2hov308p01df5dhle4r8f51xquvfsw70','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:21:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('p2uf03xeibh9u0mcnxovjengwibt5vel3','carlos2013472','carlos','encargado de almacen','2014-06-17','19:34:15','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('p2zhwhr4dkrgn6mzqsi02f7r4k9w21rjv','giovani2013290','giovani','contratista de proyectos','2014-06-15','14:34:15','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('p33jnep1gwctyin1mnsidfwq9sj514sw1','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:33','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('p4w6gumfcuowuzkx578l2pu203u3934wb','carlos2013472','carlos','encargado de almacen','2014-06-17','10:47:11','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('p9z752mfspubt0hoiim03137hzdhjeafz','MPV2013907','mperez','empleado','2014-06-14','23:37:52','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('pafv3yliaoio121xcpi8x1ij3gjqdhsel','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:56:53','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('paxk07hli5jmn35u1rui2riqc8qhnk1j4','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:45:12','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('pdlvptqx6utsu4ki6y43h9bh7xiw062qj','giovani2013290','giovani','contratista de proyectos','2014-06-16','15:30:52','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('pksvqvd6wnm0f32uns29yf1xfuhx5rgzm','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:13:55','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('plmtewjlvuvc1ugdzdau16lbke2y7qylz','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:08:05','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('pnkq58w4bc1462oqd1l0ly56npk6hcxfu','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:13:05','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ppitxcbfb7at3xt9e2cu98jfsib8gtpgg','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:33:44','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('pq6qe1y3jq0jvwv38b9y4cug06t4tjvl5','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:32:00','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('pshmn2xftznzeev6xy9u9mlo06twkluld','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:03:54','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('pukk6ojqs4pgfud2a48q5unb05p8lgjay','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:51:13','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('pvcxgcu62yfxdb8r9vb592f2me9j3o7hz','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:39:31','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('pvmss76wevcp7i8t7pplfe00iyb4sanob','MPV2013907','mperez','empleado','2014-06-15','13:32:35','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('q2kwvjebnjfywrwwy85re9ymvc49bifpq','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:42:55','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('q3qwl3nc6nwt9e6z7ymy0m6yovbt1leq9','giovani2013290','giovani','contratista de proyectos','2014-06-18','08:47:40','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('q43uaxhng8ghu0d420km1vfa2lp5xgcxq','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-17','11:19:04','127.0.0.1','ADMIN','PARAMETROS','CONTROL DE PARAMETROS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('q50vchivr5k36k8o4f6e6rug506bf12zd','MPV2013907','mperez','empleado','2014-06-15','14:08:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('q61gynyhj3yt8rbj1pkmzvsljheuje14y','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:17:46','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qac8t2re4qvejlai52x9fh6e13mfidtzb','MPV2013907','mperez','empleado','2014-06-14','17:59:34','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qaysj9dh09x9phkw79zg0vrgqjvxtw1lj','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:25:08','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qcudwcos9ufm2zk8ti36a56kp1mjbd1v8','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:21:49','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qhf9d3160yv7p919opdb6krhjd4oa6w8g','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:47:12','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qlb9deqc7dfxs1vtsdvaegqxihklgls3k','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:10','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qobfwul37avuoc9ns7u3lw61k875uwtq2','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:31:42','127.0.0.1','COMPRA Y ALQUILER','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qop6l1lvas6mr7731bqbqhp3u32f9gvk3','MPV2013907','mperez','empleado','2014-06-14','18:03:06','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qp58wjj4c9do0fzl4ftm0w8ugtotbg1s1','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:10:56','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qu5d2t8o0v2zalmiib9md8ly7hjgpjb6b','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:29:45','127.0.0.1','COMPRA Y ALQUILER','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qw74iv5mbylnvbsx1wvd2gktygouprzdb','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:49:44','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('qz6pbtxevrhvkqlmkh92b6v5dfna98ghb','adolfo2013947','adolfo','gerente tecnico','2014-06-17','10:21:58','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('r0ztj3h9ckfj2qnfj4owexiveftwinwfg','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:09:03','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('r161vwnbl78r98unqdu5hwqbgsaiojdb3','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:28:04','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('r6k84js6bpjfhzrbvm6yce600j3k08hvw','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:38:59','127.0.0.1','COMPRA Y ALQUILER','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('r89ckmt9daxmgtrz8syhvc0dcpodkftnr','giovani2013290','giovani','contratista de proyectos','2014-06-15','17:45:48','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('r8e7l79b750crc8w2o0mds49ifjym8yej','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:39:29','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('r9xswsz4gtm80d0wm7sjtt6o5hsgj8bkf','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:00:37','127.0.0.1','REPORTES','REPORTE DE MANO DE OBRA','REPORTE DE SOLICITUD DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ravo8e575f2tl8nrt6drs16mtmco4o7b2','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:30','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rdf5xvbs6ftl7sijndaazul0u36tvuz5i','MPV2013907','mperez','empleado','2014-06-14','18:02:06','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rdfrdrycs08aqhagu9wt06px6kat48www','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:15:37','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rj6bfso58y0b6yz6rtf6j396f3yjnqie8','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:25:40','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rld9evq6qos1cfn3limu4ucdda3ji476c','giovani2013290','giovani','contratista de proyectos','2014-06-21','15:17:14','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('rlt6wvvk44gk6dmysxcymuibvd4f3h6ir','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:33','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rmf9825wqh14s2ag2xmd1vu9vuqjzxe25','MPV2013907','mperez','empleado','2014-06-15','13:26:53','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rqpxc1x5cpnlxu618pab6opev0jghckkw','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:18:42','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rrpwdmkkik57kcijf7k5nfuixbj7d5f5k','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:31:35','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rsnmjoqta2f6q1fcuifla6t1b64w1zqdd','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:24:28','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rz0doxks86pr2syu0l3rt0ot8tnoxgu1e','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:56:39','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('rznvinpfghsqoio3dnsh36xk8pjdx8smn','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:00:37','127.0.0.1','REPORTES','REPORTE DE MANO DE OBRA','REPORTE DE SOLICITUD DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('s0aigixr5si8zfc3sihdyeps03zn5cyx2','adolfo2013947','adolfo','gerente tecnico','2014-06-17','15:21:48','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('s0x8i9bm5tck81oun5797fqreb6jynv66','MPV2013907','mperez','empleado','2014-06-14','18:03:39','127.0.0.1','PERSONAL','FORMULARIO DE EMPLEADOS','NUEVO EMPLEADO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('s5hu82rd6oci4lwm0duzqdyiciq95oao3','hector2013852','hector','convocante','2014-06-15','18:08:49','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('s67i3fbdnvwd2cjfk8zn9qe7zrnciz35k','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:28','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('s7qsou9og1a84yldhe5sie8ixr0ljksku','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:22:20','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('s7yvpu76fcwx6733u8zaif6gr6ojiwl2s','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:31:04','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sddx9ko40po0uqaoktc12o4ct8yfizlzm','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:27','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sel7g03je4bz8n7kpyerwqn8cad3b9b10','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:20:25','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('seuz9zp3q66utcduk9k6mq40h7v463zq4','giovani2013290','giovani','contratista de proyectos','2014-06-21','22:20:10','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('sgbcflh9fik62fxc7qy25uaugtupxwyha','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:54','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sgc5m46bbu5culbyom6m2cuapuepxtx6q','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:09:34','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sjrshvrnlu11z4eh7tmfx41ajmvrlg2jx','adolfo2013947','adolfo','gerente tecnico','2014-06-16','09:57:05','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('smj8puy7l0c7ndsw0blv8o1nqz0zda290','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:37:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('smrwe96mzssai0dsdkp8o8apd4dxn4umb','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:15:42','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('sna9hvtdrghu39rfw0r2eqcieo23qpcag','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:05:59','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sothau1xa9mdoqeepkual3ei58n41ivd1','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:03:33','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('soui6v2z35pm87ko4h8qb68ukhvbnaumq','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:49:34','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('suay3g5hqkfnx0qxsju9cfnrpnvqm0ho1','carlos2013472','carlos','encargado de almacen','2014-06-17','15:45:59','127.0.0.1','COMPRA DE RECURSOS','MATERIALES','REGISTRO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('sulftza0s4v86s85v54v8ofsp3r6v68mi','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:21:59','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t1eptzpmqcab4q7fmo8umqq9nunya38se','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:27:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('t28qc85oz5rm86ucv48k62elmt8yyat74','giovani2013290','giovani','contratista de proyectos','2014-06-16','15:30:57','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t3lddvz2wqybunecfhh7a9ztode9nf8qv','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:07:32','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t622z2vzgtpcyyzzbv7xom0jrosbsr1oy','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:47:21','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t7susksp87jprmxrx2dolj7esd89fggom','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:29:36','127.0.0.1','COMPRA Y ALQUILER','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t8reh8xuhqchobcaklq6k55iph2ncpodh','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:03:20','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t8y1b6pm7y8zzmen298bkpt64ab2m07do','MPV2013907','mperez','empleado','2014-06-14','23:33:23','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('t8zazmkg2kev4mq2l3kp2hvghwnazxfqi','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:05:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tchrzt1fv4hpkoqpkbpn0dksqd4y6vzih','adolfo2013947','adolfo','gerente tecnico','2014-06-21','21:18:01','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('tf2wjbssgr3fl83t5ernvayphttp2kl78','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:39:53','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tig03qqg7fh93ojo94vx0p79jgj7k134m','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:05:07','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tj77im854jt0k3hh7lt1qrri7qkhb2ggy','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:31:42','127.0.0.1','COMPRA Y ALQUILER','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tkzfdp467vabz1wzs95l3i41w5q3yihtr','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:07:49','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tl08v98h8gkh9htntya6obrw6hkmmhrow','giovani2013290','giovani','contratista de proyectos','2014-06-17','11:19:15','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tlg8xnjxsfkyei3kfhgfr4qc34q1zkz5c','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:46:01','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tlina5nnt03khezk0ej6aq2s71ttu0x8e','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:20:00','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tnfjfxgs5viwfjay8efi50guqdj3vc0a4','carlos2013472','carlos','encargado de almacen','2014-06-17','15:50:20','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tnh5o9v32meforrsna1nnku3ga2qpx9qx','carlos2013472','carlos','encargado de almacen','2014-06-17','19:36:09','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('tro0kz1838422c0v26o3ln7hg45t8n9ac','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:10:01','127.0.0.1','PLANIFICACION ','SUBFASE','REGISTRO DE SUBFASES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u0eqb26z4bldfjf9vg2p19ewubzbd7nrv','alexis2013881','alexis','proveedor de mano de obra','2014-06-21','20:07:44','127.0.0.1','REPORTES','REPORTE DE MANO DE OBRA','REPORTE DE SOLICITUD DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('u2ufc5ajlgedxei9rh506p45n511w9u8x','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:05:41','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u4isokhreth8207l2x9sobwqz6sq57dlc','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:16:27','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u5ieg7h93ewyhlmcvzk0v8woo1x8dtdna','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','17:58:53','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u7bco1jxl3ui2u583d15kosa6sr90fz0r','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:41:37','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u7qc95v7stf4n1b3hx0c2qtg9369ibhzg','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','16:08:49','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('u7sbcmvn5nr0w97hdfblegkxbybks7phs','giovani2013290','giovani','contratista de proyectos','2014-06-21','19:03:30','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('uah0mwoflr6qw813ve5pne70l0tmgoo2k','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:10:56','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ubmvxrwso0isytl9otytlpymmcwk8j5ap','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:43:34','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uc6suvkonrncj558s5wjlfodjo4dbqwhn','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:52:54','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uce0aiy1o8nxzht6ejvsg6m3u8g3eejky','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:22:20','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('uf98v834yfbkvsbxzbh7pe45fl7rf6hu4','MPV2013907','mperez','empleado','2014-06-14','23:27:09','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uiamk3lwu7dgce5jeusbjs816rdvkwz9t','MPV2013907','mperez','empleado','2014-06-14','23:39:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uj8rpikaec8nssnujq61jf0yarptuajuj','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:17:42','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uljc97k02c8xeqq1u0mk8t8k0wgcmu8eu','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:09:50','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('up6gdb7vzks37zg86bwjlykuwko7d804o','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:24:13','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('us3rd9rzo2uu4c4lfa7d0u4rcc7fmcc62','giovani2013290','giovani','contratista de proyectos','2014-06-15','20:00:58','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uthv1xt8kced6i5dk3r0rfe0ttn4vpbmz','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:32:03','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uvlw91sf6bh5zrtwsh4oxw7hbsy9utwp9','carlos2013472','carlos','encargado de almacen','2014-06-17','20:06:05','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uwirdmx0d7hglvxxebo1ugaepsse7wj49','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:48:56','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('uwrpfm9avo9r2wz04clhwe2515xgw0vwx','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:11:07','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('uxrkvp2kmiqbz2noku7qp77jr1t6v6g4z','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','10:42:14','127.0.0.1','COMPRA DE RECURSOS','PEDIDOS','PEDIDO DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v1cbkwmv1eu8igoref2uj0lm294mxdds1','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:48:52','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v2p6bdavub7svuxl4x2xmx0m6hvms1i9y','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:10:55','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v56g1fveqx44a28aobel0kgbdlzvtb810','MPV2013907','mperez','empleado','2014-06-14','23:51:57','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v5weutl8dlrnb2x9614qbkvi95u3f75du','giovani2013290','giovani','contratista de proyectos','2014-06-21','15:17:09','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('v5wzhbczsipkrogimoat8092he0yihjm8','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:28:36','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v81ta7ktidsxpxd3ct3f0fojx03uiqigz','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:24:24','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('v97g0defao8k3ahypy3f01amzd561cwd5','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','19:56:36','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vbl7mzcc4cgpbw0jrpkdzeo1gdyn5kfdg','adolfo2013947','adolfo','gerente tecnico','2014-06-17','10:25:46','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vbvqiheou2k3xkpbhofhealr80aabzlcg','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:32:46','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vccjm02dwanyg30us5h4x7vg25gzh301j','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:33:56','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vdkfuqb53pmealox3va1d2905mz3xgwd8','MPV2013907','mperez','empleado','2014-06-14','23:23:36','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ve5uei6k3ijpmu3he3210862jga14cd8a','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:58:55','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('vhdpcc9bo0snycxs1yxv5wikbd7hnxkob','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:15:04','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vkqj7cen5zyqjya1omkfzvaycaekorh4b','giovani2013290','giovani','contratista de proyectos','2014-06-21','15:17:09','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('vky5lho8ukpu1vm71674adawtddi6aqfx','MPV2013907','mperez','empleado','2014-06-14','23:33:58','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vlhvzeuff87t8wm7u9qdc1wstdbieo1b5','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','00:08:53','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vorr8nkc09mq0exi5f6fwgbynxith8xdp','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:37:18','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vqr28z0o3io1iel8d2o4bous2ure10106','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:56:31','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('vvycv5ehihbjnpf1ijzo1csyszep5zptc','adolfo2013947','adolfo','gerente tecnico','2014-06-17','10:25:46','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w04liiqy5224i949jooyocgy4fsacxpv2','giovani2013290','giovani','contratista de proyectos','2014-06-17','23:53:46','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w291csc3xojchlfqs8u8d77vn27vb1rjk','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:32:16','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w3s85xdygmed62yx7dyyhvvlmhmlx4ymb','giovani2013290','giovani','contratista de proyectos','2014-06-18','00:14:40','127.0.0.1','CONTROL Y SEGUIMIENTO','ANALISIS DE PRECIOS UNITARIOS','PRECIOS UNITARIOS ','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w4hjg9w9ypn59tka02sy77ervoftbep9v','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:33:58','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MAQUINARIA','CONTROL DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w4hu5yypp6f3zp3410yxv1ksbmzi9dxnc','giovani2013290','giovani','contratista de proyectos','2014-06-17','20:28:10','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','PEDIDO A ALMACEN','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('w6ojo1dkkzxzxzy6aws7izx383fql0oml','hector2013852','hector','convocante','2014-06-21','22:05:06','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('wcvmsxaqcehs6eh4jyq912lo3u4bsvt8n','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:26:58','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('whe3pxik49fg653s8s3z36r36nl8e9q30','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:08:30','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wk2thgqemgiuetscyifmjp3ke2wdj6ql7','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-16','21:21:04','127.0.0.1','ADMIN','SESIONES','LOG DE SESIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wllk7dbpx8cb6e53v7qx4sft4etfs9uel','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:13:48','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wqvdu05ky481317f9mkk5bxgydj98fmj2','victor2013704','victor','Encargado de compra y alquiler','2014-06-15','20:40:42','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wru4kjbgakbdexs2jhj1ilpkaklkjgghr','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:55:48','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ws2mfff5duduc5hhg2415eh22fqkvxjdv','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:07','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ws3k3t8x6neb6f2jfzfvcs3001qboasuv','giovani2013290','giovani','contratista de proyectos','2014-06-17','22:04:58','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wxfnn5ovxukd65t9fevosblc1ko4re7js','carlos2013472','carlos','encargado de almacen','2014-06-16','09:44:07','127.0.0.1','ALMACEN','PEDIDO DE ITEMS','SOLICITUDES DE PEDIDOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('wxg0avu80opmdhhs2rpl5scwxlnnz88kl','MPV2013907','mperez','empleado','2014-06-15','14:08:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('x0l285qa66p5lqcmvg5s710yd6ff7zx6i','carlos2013472','carlos','encargado de almacen','2014-06-17','15:51:40','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('x700esjdr1jefg8pxbmm6c58pj7gy6eq2','giovani2013290','giovani','contratista de proyectos','2014-06-15','16:15:51','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('x9lfw0lk3s77pwj3tcq2a8muxqkftoqxm','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:54','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('x9nsmx8ft09eu97dgtv6tdk7rpc5b0krl','giovani2013290','giovani','contratista de proyectos','2014-06-21','20:12:33','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('x9yo0fcisvskjo6yy71tz0obel7tb9eji','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:18:20','127.0.0.1','ADMIN','ACCESOS','CONTADOR DE ACCESOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xdpcwyqgy67n36vjq5vun6ubxa78owgg7','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:09:42','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xg03m82fj0xidcdy6g9sm0hskk2901otl','MPV2013907','mperez','empleado','2014-06-14','23:34:02','127.0.0.1','PERSONAL','DEPARTAMENTOS','REGISTRO DE DEPARTAMENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xjtgt49yi46wmfux03zojafn1xwdf2yp7','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:07','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xl5tjkxzviq9hgd3854e0esq782g0afhd','hector2013852','hector','convocante','2014-06-21','22:13:47','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('xl9ie9264n3j8l7yvh9pnga0ssrejqpl6','carlos2013472','carlos','encargado de almacen','2014-06-16','09:41:40','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xmn6y57kplml0rrltrv6yw8w2k8ep881s','giovani2013290','giovani','contratista de proyectos','2014-06-21','18:23:57','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('xnocvehjj44tye37rza9unvazfktb1cfv','giovani2013290','giovani','contratista de proyectos','2014-06-16','15:30:57','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xo9m91getsyqemsi457eqcyg8esp0ycxw','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:39:53','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xpljdksoltzamviij15httq8tsia2r3ky','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:56:12','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xscna69462c2qnbl2qyzv982u3dbg2h32','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:10','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xvdp927q3rp0wfk5qkgvv2u9onrfedkoo','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:41:05','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xxwbs3mevtbscxyoly5hsji3ox8o19fbf','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:40:33','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('xyagawr21ukrr4qi20zi4zh3z79yphg59','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:37:52','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('y1lbv6kfmi4g0w42wszz1j9lxo62m0lsz','giovani2013290','giovani','contratista de proyectos','2014-06-21','17:21:35','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('y2e8f7bfeuqqi2srixl39ju3as3wmrwao','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:15:46','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('y5c8zfy2482utdpldlpb4d1pm1zsh2foe','giovani2013290','giovani','contratista de proyectos','2014-06-15','19:44:11','127.0.0.1','PLANIFICACION ','ACTIVIDADES','REGISTRO DE ACTIVIDADES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('y6e71mr0aovzr43zy8wsyli2pkzadkc4u','giovani2013290','giovani','contratista de proyectos','2014-06-16','21:18:15','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('y73fdsfa8oush2snuszv23oqah4cgcyd7','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:49:28','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yae7cyr5s2lc9075n4djlh5dn068kxsbn','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:44:30','127.0.0.1','PLANIFICACION ','SOLICITUD MANO DE OBRA','FORMULARIO DE SOLICITUD','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yb44sumirv4u4vq8fg475xjhev8yco2rk','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:25:21','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ybfjtg5z20mq4ehw54uvqfcqjaufipe5j','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:15:46','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yboteqwgppqa532698udtn74j96oaxil2','giovani2013290','giovani','contratista de proyectos','2014-06-15','18:36:45','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ycoc53w8ki6uvy6z0i55bke43388hrio6','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:29:26','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yel3qhzoron15m4caic0ibctudnaa3chi','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:13:16','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yf10bmjditaqcau2edo7ojz1tc8ys1732','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:56:12','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yg2v0n9bpoaujj2cyjhjpqfac3zi8ej0q','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:31:01','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ygljsbvysjmcwvbrhconh0xb9ziqc1v0j','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:05:59','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yh3akfamh0t45ywp2ppnq55rmd9zm7332','giovani2013290','giovani','contratista de proyectos','2014-06-16','18:03:26','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yjrilqut2rhrnvfwmuuzacptkg4kr0353','carlos2013472','carlos','encargado de almacen','2014-06-17','15:42:09','127.0.0.1','COMPRA DE RECURSOS','MAQUINARIA ','REGISTRO DE MAQUINARIA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yk5ko3qulbhmysdfymveh42dueb9rh8fo','giovani2013290','giovani','contratista de proyectos','2014-06-16','20:30:42','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yl0hj670jxjipv052vuw4iezixoornmkc','MPV2013907','mperez','empleado','2014-06-14','18:03:09','127.0.0.1','PERSONAL','CARGOS','REGISTRO DE CARGOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ym06fpjlaqzrpo4sz5guojp2svcrqt3lu','MPV2013907','mperez','empleado','2014-06-15','14:07:57','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ytxixr47hoglm8r0rhlhje276ewmb2etu','carlos2013472','carlos','encargado de almacen','2014-06-16','09:45:30','127.0.0.1','COMPRA DE RECURSOS','LISTADO DE MATERIALES','CONTROL DE MATERIALES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ywdzyvo6i9id09c45f801mixx2m4wndfr','MPV2013907','mperez','empleado','2014-06-14','18:02:11','127.0.0.1','PERSONAL','CONTROL DE PERMISOS','REGISTRO DE PERMISOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yxqezxme733g7zdfdik3ttgq7k850ji6v','carlos2013472','carlos','encargado de almacen','2014-06-17','19:34:18','127.0.0.1','ALMACEN','INCORPORACION DE ITEMS','REGISTRO DE INCORPORACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('yztwqjm4s3e9t8ej54a4vtt539poflk1n','victor2013704','victor','Encargado de compra y alquiler','2014-06-21','18:49:28','127.0.0.1','COMPRA DE RECURSOS','PLANIFICACION DE COMPRAS','LISTADO DE COMPRA','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('z2bbm8hdji4nr7qxh7i1copk64nfjeyf9','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:18:20','127.0.0.1','ADMIN','ACCESOS','CONTADOR DE ACCESOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('z51500od59ksbmkfv3v381ig3nu9ni732','alexis2013881','alexis','proveedor de mano de obra','2014-06-15','20:10:03','127.0.0.1','PLANIFICACION ','MANO DE OBRA','REGISTRO DE MANO DE OBRA','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('z5bwe1h9m7izu23kwyo1xzj0ophegrc0o','alejandro2013727','alejandro','proveedor de items','2014-06-17','19:15:30','127.0.0.1','COMPRA DE RECURSOS','SOLICITUD DE ITEMS','REGISTRO DE PEDIDO DE ITEMS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('z70wp919edglm1wosu1zvf90ujdeyhrxu','hector2013852','hector','convocante','2014-06-21','22:14:18','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('zc6d6rdj6xpq43mwqg47t1rqab121t3wn','MPV2013907','mperez','empleado','2014-06-14','23:39:38','127.0.0.1','PERSONAL','EMPLEADOS','REGISTRO DE EMPLEADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('ze4frtuehdlp7m0cnsthscuuvo28wqv1p','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-17','15:42:30','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zg7o0ze8z86rvn3th4l19m8j8uc0y783z','giovani2013290','giovani','contratista de proyectos','2014-06-17','19:41:04','127.0.0.1','PLANIFICACION ','ASIGNACION DE ACTIVIDADES','CONTROL DE ASIGNACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zh6pnobk2n4vl20kw3fy68ggvukrl2tcm','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-15','00:08:53','127.0.0.1','ADMIN','CALENDARIO','DEFINICION DE CALENDARIO DE FERIADOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zkqd6dw1fct6gm1zhm11v6n25r91mctyi','adolfo2013947','adolfo','gerente tecnico','2014-06-17','19:05:03','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','SOLICITUD DE COTIZACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zns8a8xl38xl3qui9kr3ngq5eu2fdjy3d','00000000000000000000000000000001','admin','administrador general del sistema','2014-06-14','18:19:12','127.0.0.1','ADMIN','MODULOS','GESTION DE MODULOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zofhumy6y9thi707p3sloyls6ucznojrs','giovani2013290','giovani','contratista de proyectos','2014-06-17','21:10:10','127.0.0.1','EJECUCION','EJECUCION DE ACTIVIDADES','REGISTRO DE AVANCES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zp21h28e27m81dx62yvd3an0501gfwoi6','giovani2013290','giovani','contratista de proyectos','2014-06-15','15:23:26','127.0.0.1','CONTROL Y SEGUIMIENTO','SEGUIMIENTO GENERAL DEL PROYECTO','REGISTRO DE SEGUIMIENTOS','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zqjrfg2w5bcl07qpzygqmyywuiiqa05vx','adolfo2013947','adolfo','gerente tecnico','2014-06-15','18:46:04','127.0.0.1','PLANIFICACION ','PERSONAL TECNICO CLAVE','DESIGNACION DE PERSONAL TECNICO','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zs0u735o4buzwb4dkchijoaeer9rm9i10','hector2013852','hector','convocante','2014-06-21','22:09:47','127.0.0.1','PLANIFICACION ','PROYECTOS','REGISTRO DE PROYECTOS','Mozilla/5.0 (Windows NT 6.1; rv:30.0) Ge'),('ztdnghyixh6b9kdrj3omdl2dfb782l8xk','adolfo2013947','adolfo','gerente tecnico','2014-06-15','17:29:48','127.0.0.1','PLANIFICACION ','PLANIFICACION','REGISTRO DE PLANIFICACIONES','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge'),('zyw7kmq6tomo3g8uqixoen2lb4gctdsoz','victor2013704','victor','Encargado de compra y alquiler','2014-06-17','16:11:41','127.0.0.1','COMPRA DE RECURSOS','COTIZACION','REGISTRO DE COTIZACION','Mozilla/5.0 (Windows NT 6.1; rv:29.0) Ge');
/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ayuda_opcion`
--

DROP TABLE IF EXISTS `ayuda_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ayuda_opcion` (
  `IDmensaje` varchar(40) NOT NULL,
  `IDopcion` int(11) NOT NULL,
  `Descripcion` varchar(600) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDmensaje`),
  KEY `IDopcion` (`IDopcion`),
  CONSTRAINT `ayuda_opcion_ibfk_1` FOREIGN KEY (`IDopcion`) REFERENCES `opcion` (`IDopcion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ayuda_opcion`
--

LOCK TABLES `ayuda_opcion` WRITE;
/*!40000 ALTER TABLE `ayuda_opcion` DISABLE KEYS */;
INSERT INTO `ayuda_opcion` VALUES ('4zpanfrmcd751krl57sdk1ox04q6anwbdzk',25,'Llenar el formulario con el nombre del equipamiento y el precio unitario','2014-06-17','15:43:49'),('5jbronxjvatn6qvj19bbkcyd175vgbeius0',73,'Para definir el calendario debe ingresar la fecha de inicio y de finalizacion, en ningun caso esta ultima fecha puede ser mayor que la primera fecha. Para consultar los feriados, presione el boton correspondiente de consultas','2014-03-30','16:05:02'),('7xvcl86t5dwfkkseyw38i52hfuxz8btnn9c',24,'Llenar el formulario con el materiale correspondiente y el precio unitario, valor decimal','2014-06-17','15:43:11'),('8g3syz23k9bhp88q8zwqmrggxeyfdv7mt31',2,'Para realizar la busqueda de roles, escribir en al caja de texto search la palabra para encontrar el registro exacto de roles, presionar los enlaces, asignar permisos, ver permisos asignados.','2014-03-22','20:20:41'),('8vy1oqdszilekac84l3psd6s8aod9cwittv',52,'Para realizar la busqueda, ir a la caja de texto search y escribir la palabra para encontrar coincidencias del registro exacto, para paginar los resultados presionar Next y para volver presionar el enlace previous, cuyos enlaces se encuentran en la parte inferior derecha del listado.\nPara imprimir el listado, presionar las imagenes PDF Y EXCEL respectivas.','2014-03-21','18:41:55'),('be9z25h3mfnky0ilhdzbk9eze367uq6kk0v',86,'Para enviar un mensaje de correo electronico llene el formulario y los campos correspondiente el password representa a su password de correo electronico.\r\nPresione el boton examinar para adjuntar un archivo\r\nNota. Utilice su cuenta gmail de la misma forma que la cuenta de destino del mensaje.\r\n','2014-04-04','18:25:14'),('dc37909uf3jsjbj9hqn8ma32vxglx1mjekt',105,'Esta opcion se encarga de mostrar la informaciÃ³n del proyecto y se puede realizar el correspondiente seguimiento mediante los botones como la informaciÃ³n detallada, seguimiento a las actividades, costos y financiamiento, y curvas de costos y avance','2014-06-12','19:10:09'),('fb3lmhtcm5n4moibj3i23rnkgw4f9aiuqw2',76,'Para el registro de parametros llene el formulario correspondiente, el campo valor debera ser numerico y con dos decimales','2014-03-29','18:44:21'),('fegiva2e4lzfadnqrk0vs7n3qyk8cpk7yyf',4,'El registro de sesiones se encarga de listar las sesiones al sistema por parte de los usuarios, para imprimir el registro presionar las imagenes PDF y EXCEL respectivos','2014-06-14','17:49:01'),('gyklh9wgzd9irzd2nekdk6619l4ug8hc7u6',78,'Para realizar solicitudes de maquinaria o materiales seleccione el proyecto y presione cada boton correspondiente el cual lo dirigira al formulario de solicitud correspondiente','2014-03-31','11:48:02'),('l9lietdjxn9mz8lldfrxml5c5bzb0p370ap',71,'Para imprimir reportes de solicitudes, en el primer formulario seleccione las fechas determinadas para imprimir el reporte. \nPresione los botones imprimir PDF y EXCEL para desplegarlos respectivamente.\nOtro modo es seleccionando estados como pendientes y atendidos. Realice el mismo procedimiento para imprimir','2014-05-05','12:07:59'),('mv2elc15rf5fqc3n7srtrft4vw78jy095uc',29,'Para realizar la impresion de reportes ingresar rangos de fechas, seguidamente debera presionar los botones de impresion en PDF y EXCEL respectivos','2014-04-01','14:10:05'),('v3734rsd2dk1dtiq51ai789zx36nmte2c8l',68,'Para realizar el registro de solicitud de mano de obra, llenar el formulario correspondiente, todos los campos son requeridos, desplegar los dropdowns correspodientes para cambiar de registro.\nEl campo cantidad debe ser llenado con un valolr numerico.','2014-03-22','22:10:36'),('xmijlbvcpg3s3sezrfa7ph7rcchqkmgsalq',83,'Para solicitar cotizacion de items, seleccioanr el proveedor, a continuacion presione el boton solicitar cotizacion','2014-06-16','09:56:14');
/*!40000 ALTER TABLE `ayuda_opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ayuda_subpermiso`
--

DROP TABLE IF EXISTS `ayuda_subpermiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ayuda_subpermiso` (
  `IDmensaje` varchar(40) NOT NULL,
  `IDpagina` int(11) NOT NULL,
  `descripcion` varchar(600) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDmensaje`),
  KEY `IDpagina` (`IDpagina`),
  CONSTRAINT `ayuda_subpermiso_ibfk_1` FOREIGN KEY (`IDpagina`) REFERENCES `pagina_opcion` (`IDpagina`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ayuda_subpermiso`
--

LOCK TABLES `ayuda_subpermiso` WRITE;
/*!40000 ALTER TABLE `ayuda_subpermiso` DISABLE KEYS */;
INSERT INTO `ayuda_subpermiso` VALUES ('mng30b72ss8i9ef6ow3aah5dsh01tysohw9',8,'Para registrar un nuevo rol escriba el prefijo, sc_ seguido del nombre del rol sin espacios, agregue el nombre y la descripcion del rol en los campos respectivos, ambos campos son requeridos, si no llena todos los campos se muestran mensajes de alerta.','2014-03-22','20:39:01');
/*!40000 ALTER TABLE `ayuda_subpermiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendario_feriado`
--

DROP TABLE IF EXISTS `calendario_feriado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendario_feriado` (
  `IDferiado` varchar(40) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `Inicio_feriado` date NOT NULL,
  `Fin_feriado` date NOT NULL,
  PRIMARY KEY (`IDferiado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendario_feriado`
--

LOCK TABLES `calendario_feriado` WRITE;
/*!40000 ALTER TABLE `calendario_feriado` DISABLE KEYS */;
INSERT INTO `calendario_feriado` VALUES ('03y7wkis7qvfx3n4e1fkwjbszf3cx7840je','corpus cristi','feriado de juevevs santo','2014-06-19','2014-06-19'),('2v8s1gsgnfjbstdk0nle3znwn7j6xlue4nm','dia del trabajo','feriado correspondiente al dia de los trabajadores','2014-05-01','2014-05-01'),('ee02wld13xee916sniziq1n44dq50edfx28','viernes santo','Feriado de semana santa','2014-04-18','2014-04-18'),('f2foxkmfwgyenk8t36a10kdw0x231fh6wbe','6 de agosto','feriado nacional de bolivia','2014-08-06','2014-08-06'),('okihxne68qvaxxzi99xcy7henj5rp56oz5j','16 de julio  ','Aniversario del departamento de La Paz','2014-07-16','2014-07-16'),('vsaxa8v9uarkuiz5z783smmaxz90866407b','Todos santos','Feriado de todos santos, 2 de noviembre','2014-11-02','2014-11-02');
/*!40000 ALTER TABLE `calendario_feriado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendario_trabajador`
--

DROP TABLE IF EXISTS `calendario_trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendario_trabajador` (
  `IDcalendarioTrabajor` varchar(40) NOT NULL,
  `CI_trabajador` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `hraInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `duracion` time NOT NULL,
  PRIMARY KEY (`IDcalendarioTrabajor`),
  KEY `CI_trabajador` (`CI_trabajador`),
  CONSTRAINT `calendario_trabajador_ibfk_1` FOREIGN KEY (`CI_trabajador`) REFERENCES `personalmanoobra` (`CI_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendario_trabajador`
--

LOCK TABLES `calendario_trabajador` WRITE;
/*!40000 ALTER TABLE `calendario_trabajador` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendario_trabajador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo` (
  `IDcargo` varchar(40) NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDcargo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES ('1h9xry3b261uo9bamlescyarni9qw51zf16','asistente de recursos humanos','Auxiliar en el control de personal','2014-03-11','20:45:27'),('23u2z3ko3r049i4dzj0pkeo7b35vqoobvw4','asesor informatico','encargado de sistemas','2014-03-10','17:44:31'),('2gjagq865a29h305kd15o71j9psdsuw92mc','supervisor','encargado de realizar el control de avances de proyectos y personal designado','2014-03-18','09:43:34'),('95ay8x76ul3ocifp20sb1o5bdkapa8twl2z','encargado de almacenes','controlador de almacenes','2014-03-13','12:21:13'),('9qtk5cq2tdxcd3fa2r0jw25wgd6t51chl3f','jefe de area','Encargado de controlar empleados del departamento','2014-03-10','17:44:31'),('b8dtncdvo2wn41h11cmvgfyhwvyite9h4of','encargado de almacen','Encargado del control de ingreso de items a la empresa','2014-03-31','19:54:31'),('bt26493p9s4amydy6bo5qef47badb2eii0z','administrador/a general','encargado de la administracion general de la empresa','2014-03-10','17:44:31'),('bvug8b5ty98muzgzpjapyonezjomu38p9kk','Encargado de urbanismo','Reponsable de control de planos arquitectonicos','2014-03-17','16:02:38'),('gcnn4to816ig0a8lheeo141r3kvt9oqvnjy','gerente de equipos','gerente encargado de supervision y control de maquinaria pesada y materiales','2014-03-10','17:44:31'),('irdru3qkv2qsqk2hah7ixegkdswjgnpcdsh','gerente general','gerente encargado del control de funciones de la empresa','2014-03-10','17:44:31'),('jvn2j7uixbbzhhpheyk7xrlzhksu6ix8npb','encargado de compras','encargado del control de compras y alquileres','2014-03-10','17:44:31'),('l5mkpjx3gwgcpqsayi060h2eolwegxdwgbs','encargado de mantencion','responsable del mantenimiento de maquinaria','2014-03-10','17:44:31'),('n8il553r8nagr5g0vkj8ov74redv1shsp6s','jefe de personal','responsable de controlar a los empleados','2014-03-10','17:44:31'),('ne1c06r1n80xkjwny5987i6js3lrk1yqmpi','encargado de adquisiciones','cargo encargado de realizar compra y alquiler de items de trabajo','2014-03-10','17:44:31'),('npx3lv3lxdot10tsawuycm8t4yvgb09mey7','secretaria','cargo de la empresa, control de personal','2014-03-10','17:44:31'),('nyjlqqygd6jzi1hkdlijpz9gkyihrpd7ge3','gerente tecnico','gerente encargado de supervision tecnica de obras civiles','2014-03-10','17:44:31'),('v35ozkm0xl7iok79c2kyduo5kmzwbosk7sk','superintendente de obras','responsable de la conduccion de la obra civil','2014-03-10','17:44:31'),('wsi1o0c4qpv0q17rhrzjxop81vwf9pip12f','encargado de soporte tecnico','Este cargo realiza el soporte de software, hardware y servicios de comunicacion','2014-06-14','23:22:42'),('zo3ogohceg17o4oc3ofmsvn93r3uu6dhhfs','contratista','responsable de dirigir la ejecucion de obras civiles','2014-03-10','17:44:31');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargomanodeobra`
--

DROP TABLE IF EXISTS `cargomanodeobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargomanodeobra` (
  `IDcargoM` varchar(40) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(110) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `unidadTrabajo` varchar(20) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precioUnitario` decimal(10,2) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDcargoM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargomanodeobra`
--

LOCK TABLES `cargomanodeobra` WRITE;
/*!40000 ALTER TABLE `cargomanodeobra` DISABLE KEYS */;
INSERT INTO `cargomanodeobra` VALUES ('0kje4f9975yaswwy3b9xlsuiy85n97tcrk2','Perforista','Encargado de realizar perforaciones a suelos','HH',2,6.75,'2014-03-15','20:56:03'),('5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Operador','Encargado de operar maquinaria en obras civiles','HH',5,12.00,'2014-04-19','22:10:40'),('74phbgtp8nikjujtclpzq9kt6n61a7rublg','Tecnico de suelos','Especialista en control de estado de los suelos','HH',2,18.00,'2014-03-15','20:54:57'),('7hlcvhwqsrunc5scqyv6hboshwqq9bukb61','Topografo','Encargado de la nivelacion de todo terreno','HH',3,20.00,'2014-03-15','20:51:53'),('96e1bjs8dqx25v51keashype5e91gnlxkhv','peon','encargado de cargas, despejes, desmontar, ayuda tecnica','HH',10,5.00,'2014-04-19','20:42:14'),('ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','albanil','Encargado de albanileria','HH',6,9.00,'2014-03-15','20:56:33'),('bajk7f9tv0zlhuend8n77b4ldfe8go8j4aq','compresorista','Encargado de mantencion de equipos pesados','HH',0,10.00,'2014-04-19','20:43:31'),('hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Ayudante operador','Encargado de ayuda en maniobra de maquinaria','HH',8,7.00,'2014-04-19','20:48:07'),('ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2','Capataz','Encargado de control de trabajadores y de informar progreso de trabajos','HH',4,13.00,'2014-03-15','20:57:11'),('iw0qxxs3g1d4k5vynlc3lf88q8j5ow2am4z','Ayudante Mecanico','Encargado de ayuda en reparaciones','HH',3,8.00,'2014-03-16','20:57:38'),('x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Chofer','Encargado de transportes y conduccion','HH',5,9.56,'2014-03-15','20:55:31');
/*!40000 ALTER TABLE `cargomanodeobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contadoraccesos`
--

DROP TABLE IF EXISTS `contadoraccesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contadoraccesos` (
  `IDvisita` varchar(100) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `fecha` date NOT NULL,
  `num` int(11) NOT NULL,
  `USR_UID` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`IDvisita`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contadoraccesos`
--

LOCK TABLES `contadoraccesos` WRITE;
/*!40000 ALTER TABLE `contadoraccesos` DISABLE KEYS */;
INSERT INTO `contadoraccesos` VALUES ('04qezalzrlfv3jl1cjoo8n0r0ppw3rt5177','127.0.0.1','2014-03-25',5,'giovani2013290','giovani'),('052n246g3300frmnn2pjxckn66lc9l86rw9','127.0.0.1','2014-06-07',4,'00000000000000000000000000000001','admin'),('0alxosgtgyq5i4uhyrc4uvt7fqthwyfwljk','127.0.0.1','2014-03-13',10,'00000000000000000000000000000001','admin'),('0h2b0fxlh6l8tw711c37gwmm83zgfq1a5sf','127.0.0.1','2014-03-25',1,'MPV2013907','mperez'),('0is6daeplh9zqenjm21b2bya5pezall95dp','127.0.0.1','2014-03-17',4,'adolfo2013947','adolfo'),('0s1sk42m81vae01ayeqoss3x3113zcy3w94','127.0.0.1','2014-06-16',4,'00000000000000000000000000000001','admin'),('0zps9llainh11vts7cny87yy1cdkhsce9yp','127.0.0.1','2014-05-22',1,'giovani2013290','giovani'),('10xfl5eg4vh45137xf2fvh23oj79p2juc01','127.0.0.1','2014-05-25',2,'alejandro2013727','alejandro'),('1156atrnj52l6me2hrq0g42mbknzydaofmk','127.0.0.1','2014-03-14',10,'00000000000000000000000000000001','admin'),('11aklkan2yhdejkwtmqles8mlw99sou3r1h','127.0.0.1','2014-06-09',9,'00000000000000000000000000000001','admin'),('11yhve72tf5f42r0ra8frydffe5zi2voque','127.0.0.1','2014-04-24',12,'giovani2013290','giovani'),('12mnayd9vupy02vhfork4t3c1k909lzwaor','127.0.0.1','2014-04-09',1,'adolfo2013947','adolfo'),('1fh78rk04be0g0f4tf6q3rb6uyu2d6sgu3p','127.0.0.1','2014-06-10',2,'MPV2013907','mperez'),('1iectl45wmcs1bj8zm4jkynnotecaw8ok3e','127.0.0.1','2014-04-25',4,'giovani2013290','giovani'),('1k8xljg55ap4rvjbosfgffqp0yhav5w2f9i','127.0.0.1','2014-06-06',12,'victor2013704','victor'),('1x7dw0cdewqkkmvha4qc73oalop1lifg72c','127.0.0.1','2014-04-16',1,'carlos2013472','carlos'),('217vckgvtea1jdz574ckpencyhz8o1vzg2n','127.0.0.1','2014-05-10',4,'giovani2013290','giovani'),('26upocud2pfll24ojdh7rfjek1jljae6xy9','127.0.0.1','2014-06-13',3,'giovani2013290','giovani'),('27xrylp4xp53nabwxtt6neng8irdxohv0si','127.0.0.1','2014-03-29',4,'alejandro2013727','alejandro'),('27xs0qi16zjrije683kezk9ezpd6ukoyzi0','127.0.0.1','2014-04-16',1,'raul2013614','raul'),('2c8oyyy8xjlk9rxkdy80ztc7vxok0ttqwob','127.0.0.1','2014-04-28',1,'00000000000000000000000000000001','admin'),('2ctoacbcj6ge7wpdj5fjqz55pmvzl1lezgb','127.0.0.1','2014-03-31',3,'alexis2013881','alexis'),('2gwgwyedh2kjn4rocun1qo3pzkwybeo7a2u','127.0.0.1','2014-03-13',1,'user test2013931','user test'),('2gyjyypnyxssx6dvpbi2nfhqfj9qsg73h8c','127.0.0.1','2014-06-16',3,'giovani2013290','giovani'),('2i2msw1w082q2vyrl0txyv1oxmj6bwno687','127.0.0.1','2014-04-21',5,'00000000000000000000000000000001','admin'),('2vgqkyy6mfit6yb3k26sjhr4rs1l2ogu6re','127.0.0.1','2014-05-10',1,'adolfo2013947','adolfo'),('322d0tbwysyhhvjrokpd7ek69dtcgwq1jjc','127.0.0.1','2014-05-14',4,'carlos2013472','carlos'),('35io3k6zsud0r0gjh5gpb4qamavrvinbvi6','127.0.0.1','2014-03-19',7,'hector2013852','hector'),('35x4a149opc6yfnu3kfgo448qt3zqyjerfw','127.0.0.1','2014-05-26',2,'hreyes2014107','hreyes'),('38op8l8as0si0p61oeznp2rv9czy5vwskjr','127.0.0.1','2014-04-22',2,'00000000000000000000000000000001','admin'),('3bxtm7bi99a08b6qymqgqce5geyu7t0nwww','127.0.0.1','2014-06-15',5,'adolfo2013947','adolfo'),('3cfu18dlhvpzw8uamsbdkh59s9d8tvplpuu','127.0.0.1','2014-04-29',1,'victor2013704','victor'),('3ir8qawjds7xht4jerhot1ful3nfnkv2bv5','127.0.0.1','2014-05-21',9,'giovani2013290','giovani'),('3weoormh9pd7a06g7i80264czu7015yvdfx','127.0.0.1','2014-04-24',3,'00000000000000000000000000000001','admin'),('459pby0wna8b4lysxo707zbenc5gz7z2u4d','127.0.0.1','2014-05-12',1,'00000000000000000000000000000001','admin'),('45o3ski8x9ceuzjaxolavz0m1ayi3v8sf28','127.0.0.1','2014-03-12',13,'00000000000000000000000000000001','admin'),('4ifadgt2178c2odfc00dio5migr3fdsvwf5','127.0.0.1','2014-03-18',1,'hector2013852','hector'),('4k4tytyu2u02j4ijk3y62jrsl5mhg8x16ys','127.0.0.1','2014-05-12',4,'giovani2013290','giovani'),('4yedjyusuptathw5gu7h9d6vqb6g23sx2ul','127.0.0.1','2014-05-05',1,'ronald2013986','ronald'),('5cp9tgljc2eutcn9aal4bin64t3sv6onrpm','127.0.0.1','2014-05-19',3,'giovani2013290','giovani'),('5jp0g4f39x4de4f2jum6xnc3uvrmo3um3xx','127.0.0.1','2014-03-13',5,'MPV2013907','mperez'),('5ns6ktkebekq7mb664j2e24nz88rkkmtytv','127.0.0.1','2014-06-02',3,'00000000000000000000000000000001','admin'),('5rzhaj1m4upn91szejmtm35pvbbww9a6unf','127.0.0.1','2014-04-29',8,'giovani2013290','giovani'),('5to70m18tsze16tkpeeugy479v412mnec8p','127.0.0.1','2014-04-11',5,'adolfo2013947','adolfo'),('5tt7zork8dhgniiydd0uw73t8r2n5l2zp0k','127.0.0.1','2014-06-03',3,'giovani2013290','giovani'),('5yzl2krregzf0dc6fh2702m3xyku15syksx','127.0.0.1','2014-04-15',9,'giovani2013290','giovani'),('673btco829od2nx1mppt73194id1idn0ry2','127.0.0.1','2014-06-15',1,'carlos2013472','carlos'),('67cr4q1yfbgmyqz50itb6r6kq6p4s83sj05','127.0.0.1','2014-06-06',3,'carlos2013472','carlos'),('6ebgm8b5z8kmkilsm17rwqf94hvm7bcrk5f','127.0.0.1','2014-04-13',1,'alejandro2013727','alejandro'),('6lb9arkxswq5comxdyw3yuezi663i94ijgs','127.0.0.1','2014-03-26',10,'giovani2013290','giovani'),('6nxxxklfdyf3a9370raod9bc4b68x7d7iaw','127.0.0.1','2014-04-04',6,'00000000000000000000000000000001','admin'),('6rp251lqrboa4bzrsutlu32ei2g2rs03av9','127.0.0.1','2014-03-26',3,'alexis2013881','alexis'),('6tbxm75acrb7lrobzx2sb2s0o2nodrcsb9d','127.0.0.1','2014-06-04',1,'hreyes2014107','hreyes'),('70aufowxzwfqc0gg1x4xxwd4y9qef031el6','127.0.0.1','2014-03-15',5,'00000000000000000000000000000001','admin'),('70eup4ug5543rc9y3h5agyngnldi0jrh0m1','127.0.0.1','2014-04-15',2,'alejandro2013727','alejandro'),('74q7nanwwix7e94mbcxcb5i0bndyy0bed52','127.0.0.1','2014-06-15',2,'victor2013704','victor'),('751o4jte20t8jmblj46bux1oaf1g0k4or7u','127.0.0.1','2014-04-29',3,'00000000000000000000000000000001','admin'),('76c9kjmcfaga2l1drjjv60vjdeumd5zsn1i','127.0.0.1','2014-04-16',1,'hector2013852','hector'),('772ra9bwetx8gp4x0tctsjs3r8zrbuxkaxo','127.0.0.1','2014-05-17',2,'carlos2013472','carlos'),('78yddllgawsim7lcbph74s8cbrpsbu5n9gb','127.0.0.1','2014-03-24',12,'giovani2013290','giovani'),('7h8a1y9aep3y9q1fws85npb7vijy0pp9s7f','127.0.0.1','2014-03-30',10,'00000000000000000000000000000001','admin'),('7mat5qdfe2ry7tqeht0nlgtjicqmvdy17vm','127.0.0.1','2014-06-11',1,'MPV2013907','mperez'),('7yt6v17ce3k3llr4v1m5vkomcvup1spq47u','127.0.0.1','2014-06-08',1,'victor2013704','victor'),('7zgton4pbu31dr25gdvpf9c7yt2kj94i19x','127.0.0.1','2014-04-07',6,'adolfo2013947','adolfo'),('847k36xitw9hg0i7k3n1pi9cmx1w9gtt9t2','127.0.0.1','2014-04-04',3,'adolfo2013947','adolfo'),('8571qsbv75m435vgo584bqm9bd0kthahwb0','127.0.0.1','2014-04-07',1,'alexis2013881','alexis'),('89bf208kzywwk8dom7zxdiy6lqzd8f2de1n','127.0.0.1','2014-03-27',9,'giovani2013290','giovani'),('89uzkoco69x3uxey9omxlenhv7x6qeuam76','127.0.0.1','2014-06-18',2,'giovani2013290','giovani'),('8ai47pkrh0zolczoajnz6zoy6vl1ixkiqk6','127.0.0.1','2014-05-16',3,'giovani2013290','giovani'),('8b9s4vogqsm0imm2f2kv5623ruwprceb3xx','127.0.0.1','2014-04-11',8,'victor2013704','victor'),('8bbykbvlh14jak32vhl98pinbrtlbonhl8p','127.0.0.1','2014-04-20',3,'00000000000000000000000000000001','admin'),('8bgtti4f6nf250n6y2ul4wks0gy5gfwfzdd','127.0.0.1','2014-06-12',1,'00000000000000000000000000000001','admin'),('8gi4h8k4vxn83t676fpaz2z1nc4hwjpof6t','127.0.0.1','2014-05-07',6,'00000000000000000000000000000001','admin'),('8giyn4gf9b1v5udorwubfdxp433t008ft51','127.0.0.1','2014-03-22',2,'hector2013852','hector'),('8lmjdz3grkkxip2077qae781bw9m5582z88','127.0.0.1','2014-06-16',2,'adolfo2013947','adolfo'),('8mxphu6kkoiomkh0wmvjgewscvnmh95wgwt','127.0.0.1','2014-06-15',3,'alexis2013881','alexis'),('8oj0lmi7w88ws8leqpfmx136qrhbzhkdey9','127.0.0.1','2014-03-21',5,'00000000000000000000000000000001','admin'),('8qv12o39g86knvv8q55dryeutwm4kntuil8','127.0.0.1','2014-05-08',1,'giovani2013290','giovani'),('8tqvb85yn13qi9u2xcymztwopzhss8vzycp','127.0.0.1','2014-04-19',11,'00000000000000000000000000000001','admin'),('8vybb0c3ypaxx8smcqpfry4hzklknrgunh4','127.0.0.1','2014-03-17',1,'hector2013852','hector'),('91vgecya9b5e4ipu5ipovxyxfsbva2hkhjt','127.0.0.1','2014-05-24',1,'hector2013852','hector'),('923erkvcixl27c9u1ikn5yohlrxo51ytiq2','127.0.0.1','2014-04-08',5,'00000000000000000000000000000001','admin'),('93nb7hmgaxeorvmfr3xizxj3ls0oe7bof4x','127.0.0.1','2014-03-14',5,'MPV2013907','mperez'),('9aeolqtfq52dj482lbhmhmqdzghv1sli9rl','127.0.0.1','2014-05-05',4,'alexis2013881','alexis'),('9bgyzbzzy9e2jinevd86q54h9anszb97mbl','127.0.0.1','2014-05-10',1,'alejandro2013727','alejandro'),('9bhwtrpcyitibcdvnzfp4p0i8n5fdcq84l3','127.0.0.1','2014-06-06',1,'adolfo2013947','adolfo'),('9hug6z75x0fs1uh5i1mefnb82fh3s7mzocg','127.0.0.1','2014-04-19',7,'giovani2013290','giovani'),('9o2gmbu06pwzpdo6hallwni1qmc0vlmyhig','127.0.0.1','2014-03-31',2,'adolfo2013947','adolfo'),('9pgu5ma7ql1atfn0affjb59o47aysniohog','127.0.0.1','2014-04-16',3,'adolfo2013947','adolfo'),('9spssuk8pu1l33d3e92bq3c3gqsv3f7nlow','127.0.0.1','2014-05-06',1,'00000000000000000000000000000001','admin'),('9vbxbk010dsqvkvjmxhw5lcsi55on6iuqse','127.0.0.1','2014-03-14',11,'mescobar2013649','mescobar'),('9xiyv6ercv9g5y1p4bn9puz3iczyqkp707m','127.0.0.1','2014-04-30',3,'00000000000000000000000000000001','admin'),('abceeads62tvh7x7ginp15atr7n7rt5zu5h','127.0.0.1','2014-03-14',1,'alexis2013881','alexis'),('ac8mvozo0xxewi1kcm98vjku9i0mbgwmz3u','127.0.0.1','2014-06-18',2,'00000000000000000000000000000001','admin'),('ad0ks3fgytlp7yuki9zd8jdfgnpf6uow69t','127.0.0.1','2014-05-09',4,'00000000000000000000000000000001','admin'),('aeao75ixhildetd6hwehxingjsw8qk7jv4q','127.0.0.1','2014-03-12',3,'ronald2013986','ronald'),('ahwo9umvzqxqjmq95r99thu52tfvqw38rqm','127.0.0.1','2014-04-16',4,'victor2013704','victor'),('amr1bwd09adyb3d9ue18dfgtyq21slxv0lh','127.0.0.1','2014-05-04',3,'00000000000000000000000000000001','admin'),('anxnhf3xy7g2sun0209edl5jmm7d93fv55v','127.0.0.1','2014-03-29',2,'mescobar2013649','mescobar'),('aolhqqibfyqmabbrz2rudexv93lt9st93w6','127.0.0.1','2014-03-29',1,'giovani2013290','giovani'),('aqbtj7dwrqi6slyr4ws39xmbxglp6gb2kn7','127.0.0.1','2014-05-09',1,'adolfo2013947','adolfo'),('aw7tl7r071okqzz5uiu2fe37m7tqwaqx1q4','127.0.0.1','2014-06-15',2,'alejandro2013727','alejandro'),('b5lhaamhqfb1e4q1yt23q9owozx0rrd8u80','127.0.0.1','2014-04-11',8,'00000000000000000000000000000001','admin'),('b845x40tx2cg7tttv694rb3wzaiyv0cfxcc','127.0.0.1','2014-04-09',1,'00000000000000000000000000000001','admin'),('b97b9vi228socfcuwwschzsymgidc4iyo4g','127.0.0.1','2014-04-06',4,'victor2013704','victor'),('b9giwz1lzckmep1n64bnl84te203vhpjj89','127.0.0.1','2014-03-18',4,'00000000000000000000000000000001','admin'),('bal428bv247eairaewvsd2la2p0shyd2gaj','127.0.0.1','2014-03-29',2,'00000000000000000000000000000001','admin'),('bc0kkp8w1i6uaterc8c3p0jruyhwx5258k6','127.0.0.1','2014-03-17',3,'mescobar2013649','mescobar'),('bmfu71vs4g39qm8hn951zv9q6she39zvx30','127.0.0.1','2014-03-18',10,'adolfo2013947','adolfo'),('bpbe8esohitukzdijbd1o22rwhek8ck2wzj','127.0.0.1','2014-03-31',4,'MPV2013907','mperez'),('bpexh4kg2gc53q7dbqzjt2f94zcyk0k3w0h','127.0.0.1','2014-06-02',7,'giovani2013290','giovani'),('bv5hfaej5t06uhbomjm8nbp3t2qgmv50zqa','127.0.0.1','2014-04-25',4,'victor2013704','victor'),('bvkqiwkgxn673c9noqnaepe7r4so0pkxxsd','127.0.0.1','2014-06-08',6,'carlos2013472','carlos'),('c49cmg1gzirojefq5zvozr9hr2nkqeo2vh7','127.0.0.1','2014-06-06',4,'giovani2013290','giovani'),('c4ap5noux9jxa48lvc2yqja36tbo3xx6tza','127.0.0.1','2014-06-15',1,'hector2013852','hector'),('cbwdnvvdj5se5anyih6qyp8i4a2qj23ndfd','127.0.0.1','2014-04-26',5,'alexis2013881','alexis'),('cl9dmznca20u1ofy65dxamoyts15tjol2pl','127.0.0.1','2014-06-18',1,'mescobar2013649','m_escobar'),('cr1gl0zkudbip84l8ty7cq3lxk4k6selmfl','127.0.0.1','2014-04-26',1,'victor2013704','victor'),('csx8teoylkza77urautprcf9uiy58k4ftmz','127.0.0.1','2014-03-31',9,'giovani2013290','giovani'),('cvhlybcx2wstqm2azjaezloz3cj6vbt97v9','127.0.0.1','2014-04-01',1,'alejandro2013727','alejandro'),('cze8pbf1u0ftapw8uz0o0zuoovf6hgjzzyh','127.0.0.1','2014-03-18',1,'alexis2013881','alexis'),('d5gko0f3tcwhwxp4qg6q19cby8xqw29pepe','127.0.0.1','2014-03-25',6,'00000000000000000000000000000001','admin'),('dajk2jnzbh2rwor0s5wsiiitwlad8bwxv14','127.0.0.1','2014-06-02',1,'adolfo2013947','adolfo'),('dcrfbpbjntj48dha8mxjrokbd5m0ot24a8f','127.0.0.1','2014-06-11',4,'00000000000000000000000000000001','admin'),('dlpk19fxbjekbyg5i66yau0hziv0j52rza9','127.0.0.1','2014-04-08',3,'alejandro2013727','alejandro'),('dmzf7asjpls7cagnciz2xbiy4ux3kzirns0','127.0.0.1','2014-04-19',1,'marcelo2013432','marcelo'),('dq7a7lev9gc580us5f5wgfv853l0swidl99','127.0.0.1','2014-05-24',1,'giovani2013290','giovani'),('drvmteu7ats8dm97hr23wc1jd2f23oxd4x1','127.0.0.1','2014-04-25',3,'adolfo2013947','adolfo'),('dtm8qr874h8ysf7pfddmpmw5uh27e138y7n','127.0.0.1','2014-05-31',6,'giovani2013290','giovani'),('dvfjq45c3k8xbfe141wwid748m3082xdrmn','127.0.0.1','2014-05-17',1,'00000000000000000000000000000001','admin'),('dz6kre9xt6l7upojlzkcddqn5k8ckususvj','127.0.0.1','2014-03-24',12,'alexis2013881','alexis'),('e25ucsehhrzjdy3gfp245dbmlr66v717xo3','127.0.0.1','2014-05-06',5,'giovani2013290','giovani'),('e4ps68mf0yv4ofy1thvuqf9cs1adyujwrbo','127.0.0.1','2014-06-21',19,'00000000000000000000000000000001','admin'),('e9isens7d8vqf1tg9w95mmqk67qnneazuih','127.0.0.1','2014-05-10',2,'victor2013704','victor'),('eavw3admjafea22wxous76ewv3c5phv7cd2','127.0.0.1','2014-03-17',1,'ronald2013986','ronald'),('ebuyi7tko89eo8i4l59f9ebnjocc121a8e7','127.0.0.1','2014-06-17',1,'MPV2013907','mperez'),('ec19002c3aksdgrdjs7hz1rilriir4x4fyg','127.0.0.1','2014-05-09',3,'carlos2013472','carlos'),('ehqfrvczi2rn2nfrk5izvskcsgq68b4xya1','127.0.0.1','2014-03-15',3,'mescobar2013649','mescobar'),('eicaupazsdlndtqd4rua415ug555tj01o69','127.0.0.1','2014-04-03',6,'adolfo2013947','adolfo'),('enr5z6hb0prglsrk1v1argu8z18xyr393ky','127.0.0.1','2014-04-05',4,'victor2013704','victor'),('eonjsuj5oqx7025yuvlahrgw0yu40gcmehq','127.0.0.1','2014-03-22',2,'giovani2013290','giovani'),('esta0g58nihf5193466l2hojgir2xyjl98i','127.0.0.1','2014-04-19',2,'alberto2013824','alberto'),('eu42wy7v6zhlkl393x9xv20c0rysd54juau','127.0.0.1','2014-03-17',12,'00000000000000000000000000000001','admin'),('euicffuarogc02vemu6p0mscnvh4kjt2h98','127.0.0.1','2014-06-02',1,'MPV2013907','mperez'),('ewdy580vg6pevtjmh7rfxeaiuda4bkg0cf4','127.0.0.1','2014-05-17',1,'hector2013852','hector'),('eynbf1u48qfttpaj4yn0q7ac9iqfm3samf6','127.0.0.1','2014-04-11',1,'mescobar2013649','mescobar'),('ezehgxonypo12i60o1mgote9bm7728vijdz','127.0.0.1','2014-03-31',13,'00000000000000000000000000000001','admin'),('f2erp8uwwz7e0g1hvvrhu7eyh8kusivogk0','127.0.0.1','2014-04-16',5,'alejandro2013727','alejandro'),('f4qmlhwr2tirxlmlhdc0trds3p2y9vkvbmw','127.0.0.1','2014-06-04',9,'giovani2013290','giovani'),('f55qa9kujkju7krh1662zap3g52up6eta7c','127.0.0.1','2014-04-26',13,'giovani2013290','giovani'),('flzirqvfb6i26sljx0y4v9cssfz8qt5wvt0','127.0.0.1','2014-03-28',4,'alejandro2013727','alejandro'),('fmbexftct6lh5zmhtj8u4uxtb1ljnbvxnkl','127.0.0.1','2014-04-01',7,'00000000000000000000000000000001','admin'),('fpq8lxfl571x91zvu0j2zw919wtwd6dn87o','127.0.0.1','2014-06-05',2,'00000000000000000000000000000001','admin'),('fu9d7m2g8rm18awx5rg9emp7iwpuy65njey','127.0.0.1','2014-04-05',1,'adolfo2013947','adolfo'),('fxnv5py7gbzkdehj6qyjxfu8urj6guemar9','127.0.0.1','2014-05-23',3,'giovani2013290','giovani'),('g1d76tetwh25oga43wawhd6fhfb42mkv7x3','127.0.0.1','2014-06-04',15,'00000000000000000000000000000001','admin'),('g4vgr25uo17zovbuswvf668orf845ztmcoi','127.0.0.1','2014-05-20',2,'marcelo2013432','marcelo'),('gba9uc5lrrkyu4ljgjro330xfx55y66o3in','127.0.0.1','2014-05-14',6,'giovani2013290','giovani'),('ged5htx85vx7evrcm9wikl8dacmaivcypq9','127.0.0.1','2014-04-07',2,'carlos2013472','carlos'),('gi088wylaw8gpd7ct6be7ys1psahorqg2i7','127.0.0.1','2014-05-09',1,'victor2013704','victor'),('golrk4kgg99sq25anp92wi2p0rvorkyayoo','127.0.0.1','2014-06-05',1,'alejandro2013727','alejandro'),('gsp1bmj0k61vtf6bjxguguii459n7l8wl8x','127.0.0.1','2014-03-30',6,'giovani2013290','giovani'),('gx9fk8b1flqk87batenwd6z3z57lqk3p2lq','127.0.0.1','2014-06-15',3,'MPV2013907','mperez'),('h0tf9kgk2rfzvmry5c45zjr7889d4c7xn09','127.0.0.1','2014-06-14',4,'giovani2013290','giovani'),('h2hjd11v6embgf61x9z39ku85i7ticbqdum','127.0.0.1','2014-03-23',4,'alexis2013881','alexis'),('h3winnyzudseoz6b20g7sjwutb3vl4ltyj6','127.0.0.1','2014-05-27',1,'giovani2013290','giovani'),('ha027g5z5qvo026j6vy6enq9vrq8x7eh2ja','127.0.0.1','2014-03-29',1,'MPV2013907','mperez'),('hhnwffqugcxgjtkcww46pwa3xgp4ipa5q03','127.0.0.1','2014-03-24',3,'hector2013852','hector'),('hll9v34vni3vmmlbw3br7algmlgggktxh9b','127.0.0.1','2014-06-06',27,'00000000000000000000000000000001','admin'),('hr2mmpk4r6byv7soqw6nh1t4ajy298xfgr2','127.0.0.1','2014-05-04',1,'alexis2013881','alexis'),('ht81vw5dia8643kbos3ubrg561yv2c0pbz9','127.0.0.1','2014-04-18',1,'giovani2013290','giovani'),('htcbyfbpxdk6cgkd3qlpbl0hd7sokp9do1u','127.0.0.1','2014-06-10',5,'user12014770','user1'),('htsjccnznrt8jmdfbi2kbw78ya26p1ht805','127.0.0.1','2014-04-16',1,'alexis2013881','alexis'),('hup07bxq2hy16gbu0srarkhdi05343ha3fg','127.0.0.1','2014-06-21',1,'adolfo2013947','adolfo'),('hveger5vcpz9ojvhbhv2ns3jkmt2sbcbz49','127.0.0.1','2014-06-05',1,'adolfo2013947','adolfo'),('hwf7dntiqsplg8nhv34an64ctp6j7esmpq7','127.0.0.1','2014-06-09',3,'giovani2013290','giovani'),('hxo7swmlg1g4zzrrdu717myesl9e0618d48','127.0.0.1','2014-04-14',7,'victor2013704','victor'),('i2x8lyzoc2g03wi34jid1t4gmci7j8oaf0d','127.0.0.1','2014-06-15',12,'giovani2013290','giovani'),('i3srmz1y1vfltsvyxtp7d0j0w4broheolah','127.0.0.1','2014-05-18',1,'00000000000000000000000000000001','admin'),('i42f6vxgh7paevfm9idugxrkr3v126m48kk','127.0.0.1','2014-04-26',1,'adolfo2013947','adolfo'),('icqtyhdnfgzwpuarjfcafwabonnpdzxcbku','127.0.0.1','2014-05-28',3,'giovani2013290','giovani'),('idqshy2mxqbj6hd9c5hcu05rbx0c4vkvqce','127.0.0.1','2014-06-10',1,'adolfo2013947','adolfo'),('ikxshn7zgh8b2jrieaahnk3e8knh1ogtkld','127.0.0.1','2014-04-23',2,'victor2013704','victor'),('io36f4oda02aqfnjutxrlzfy97i8h99rod6','127.0.0.1','2014-05-09',7,'giovani2013290','giovani'),('isqvcj2hhgtcqo3q32jxj3mv1fa0nhnek1b','127.0.0.1','2014-04-08',10,'adolfo2013947','adolfo'),('iu71pie88x1bw34vninainaplk531x76vn0','127.0.0.1','2014-04-21',7,'giovani2013290','giovani'),('iw05qszuarfo62t9blkl4yvrrd7duq6ao6f','127.0.0.1','2014-06-10',3,'hreyes2014107','hreyes'),('ixawa6f07e1cyi48xg9kotma3ehfqddimdt','127.0.0.1','2014-04-02',1,'00000000000000000000000000000001','admin'),('iz1a7vkmdv3z9fn4gear8fjj68o0fwys8em','127.0.0.1','2014-06-15',2,'mescobar2013649','mescobar'),('j0rwfr30x5fw7bc4t4cdqfg9pd8le9ys2f1','127.0.0.1','2014-04-14',1,'adolfo2013947','adolfo'),('jaaf5v39xpqzahzhgcd5kwy1af9ohxmb6zt','127.0.0.1','2014-05-19',2,'00000000000000000000000000000001','admin'),('jbvlzy253uw6tejfbvgllohqx6glb9vbgnp','127.0.0.1','2014-05-10',5,'carlos2013472','carlos'),('jcnnis1x0hrqdttvts57t2eq7pfj5fob7za','127.0.0.1','2014-06-10',1,'brayan2013447','brayan'),('jdi9sm5me8kpf79e0r4xqrwsnw1hftglq6t','127.0.0.1','2014-03-25',1,'hector2013852','hector'),('jfcodn5280lifbau3p4xgam2bbqhn6tb49u','127.0.0.1','2014-06-14',6,'00000000000000000000000000000001','admin'),('jmpulbp000aa9mictrn5ndtouamxun1vy4d','127.0.0.1','2014-04-28',1,'alexis2013881','alexis'),('jwxkvllvqxz6em70v6rlrw3d1zp1tm6wb5d','127.0.0.1','2014-04-15',1,'hector2013852','hector'),('k7odhrmkfdag2epo3lctdu8524uitpg8xoy','127.0.0.1','2014-06-17',9,'carlos2013472','carlos'),('k7vqsvp01ns2g105ml74h7ywg3fztrhko9s','127.0.0.1','2014-06-03',2,'00000000000000000000000000000001','admin'),('kd0u9ygbgt5o5pf657388f55pr67ao0zl1o','127.0.0.1','2014-04-14',2,'alejandro2013727','alejandro'),('ki0aac9q8lfcz7uanu96jxmnqfdiptrpmpg','127.0.0.1','2014-05-10',1,'00000000000000000000000000000001','admin'),('kiyodjhgmxlwjpqry0smoonjlh5i71pahte','127.0.0.1','2014-03-12',2,'brayan2013447','brayan'),('kjutychpb5ik95u3cainxpo9fqq3mi29ytv','127.0.0.1','2014-06-07',4,'carlos2013472','carlos'),('kn3gqvt1tztof4cmphs8r7zw05i66o6596x','127.0.0.1','2014-04-21',1,'hector2013852','hector'),('kodeuliwlbflvqvj6mp2wj7gdtnl22g1rna','127.0.0.1','2014-05-05',8,'00000000000000000000000000000001','admin'),('kpnb4gl7gjwr4k6useept1cat68jede64yo','127.0.0.1','2014-05-05',1,'rodrigo2013758','rodrigo'),('kqltlmv7irs7yq7tagusyj6c6heowunvxz6','127.0.0.1','2014-04-19',2,'alejandro2013727','alejandro'),('kqugd2per37z4felxkzjf2tkp4cvcjrrtxd','127.0.0.1','2014-03-31',6,'alejandro2013727','alejandro'),('kzcklwll0oyzeu2ztpg2o5xijtuseonw59c','127.0.0.1','2014-03-26',2,'00000000000000000000000000000001','admin'),('kzdxviu886lvaj76obtbvax2zonut7gckqj','127.0.0.1','2014-04-01',10,'adolfo2013947','adolfo'),('l27bh8u3b25ecgt01zi3h6m5zg7o25j3l79','127.0.0.1','2014-03-23',1,'giovani2013290','giovani'),('l315bm4i0xag5ahtpioimajn8o1j6nn2vfp','127.0.0.1','2014-04-19',2,'victor2013704','victor'),('l32s9mz8tm368im1p6paf2fib4odkb74061','127.0.0.1','2014-06-13',2,'00000000000000000000000000000001','admin'),('l8u4ymfv38ykdlpi4ss3fxjc5nrf6rn3gdx','127.0.0.1','2014-03-21',1,'hector2013852','hector'),('l93ibhjm3iu3psay76z231bajcegywluixy','127.0.0.1','2014-05-31',1,'hector2013852','hector'),('lf3w1rt4mkcfqegjyhjpfeg8rrpxefjap2u','127.0.0.1','2014-06-16',1,'victor2013704','victor'),('llcr5jkea9ujphvyfi4h4bbpgn30b6jhnev','127.0.0.1','2014-04-13',4,'victor2013704','victor'),('ln4epjt0y99l2vro0yfpedcizulihsc9q6i','127.0.0.1','2014-04-14',1,'hector2013852','hector'),('lxncan1tfund1qpspxuxc2bf76evo43j0jm','127.0.0.1','2014-06-17',3,'00000000000000000000000000000001','admin'),('lywk27wlm0fgjgq8olqhw4v7m2oangjc717','127.0.0.1','2014-04-15',3,'00000000000000000000000000000001','admin'),('m7shst9titaed956nngtg85fkpf319odf7f','127.0.0.1','2014-04-30',8,'giovani2013290','giovani'),('mjrvuj8evaql3fu5l8narv6q042evbjcox1','127.0.0.1','2014-04-21',2,'adolfo2013947','adolfo'),('mluz1oxz7ddchvzb4keisocuc17nn42yi0u','127.0.0.1','2014-04-26',2,'00000000000000000000000000000001','admin'),('mpvcnq0sdsc9jji5trdwfzfaz4um6qjswx9','127.0.0.1','2014-05-05',6,'giovani2013290','giovani'),('mqg8k0n8vff1tejmjy3by218cr6f0na2f4s','127.0.0.1','2014-03-23',2,'00000000000000000000000000000001','admin'),('mr1ydx8hlnk54jh8uzbb61k2t02lg3a4cx8','127.0.0.1','2014-06-22',1,'00000000000000000000000000000001','admin'),('mt6t172c1dueh61eenscqrshn3ninhl2s6e','127.0.0.1','2014-06-17',1,'alexis2013881','alexis'),('mxfz4kke52oaqb6n2nkz1mhzv4o2z3byxt3','127.0.0.1','2014-03-17',5,'alexis2013881','alexis'),('mzqhgwijfmyc73rwtvutwl2n0csyfjg8zxn','127.0.0.1','2014-03-19',5,'00000000000000000000000000000001','admin'),('n4ks0tec15frcwnrse657i3kxwnfpn7abbc','127.0.0.1','2014-06-01',4,'giovani2013290','giovani'),('n732t3jh2ekvvzj2x2dkzvaq6by1peytrhh','127.0.0.1','2014-06-14',2,'hreyes2014107','hreyes'),('n7n4itvv4iqdb1xy8b1luozo5vhmqvptd9m','127.0.0.1','2014-05-25',3,'victor2013704','victor'),('na51ahm6z3g7st96f0avv93k8p8x1mhqm16','127.0.0.1','2014-04-28',3,'giovani2013290','giovani'),('nasiqymzk4fwmr6zi9lua922w7xty8dl7aq','127.0.0.1','2014-05-26',7,'00000000000000000000000000000001','admin'),('neksc4y4a12bc519xr1pj3xu6dgu8rq4y8g','127.0.0.1','2014-04-13',1,'00000000000000000000000000000001','admin'),('nkszck4nfct37x4twdtvktgflqxv46pbzp0','127.0.0.1','2014-06-17',5,'adolfo2013947','adolfo'),('nm3qtqqfh9h60oaqpks0ur8npa2fv3rzwy7','127.0.0.1','2014-04-19',7,'alexis2013881','alexis'),('nn2y3aeo14aijn997hho4vts2367gyg5n9j','127.0.0.1','2014-05-11',7,'giovani2013290','giovani'),('npgj9ocfs7qk9g0u7x509xmxza3paeq4syj','127.0.0.1','2014-06-17',7,'victor2013704','victor'),('nrkpyv93uqot5y3brq954h79poy1qk8jyyt','127.0.0.1','2014-05-25',2,'carlos2013472','carlos'),('nsxc283i6f0q8ti2m2aly61rpiduxhrd74p','127.0.0.1','2014-05-25',2,'alexis2013881','alexis'),('nul9tx85zuvnezgrbmet2yh1nsevd8vhwa9','127.0.0.1','2014-05-12',1,'hector2013852','hector'),('nwmhl0dy4tek2g3qjg4sgb1yct62jd7df8d','127.0.0.1','2014-05-20',8,'giovani2013290','giovani'),('nxxys8ltiuuizsjt8m49kd4y5watg85giiz','127.0.0.1','2014-04-20',4,'giovani2013290','giovani'),('o7mkqgrr6eptd35i24dcobm3qnd31czsqbo','127.0.0.1','2014-04-16',2,'mescobar2013649','mescobar'),('o8p3vb45md42dcil85wqal9eyn1dm00g6xu','127.0.0.1','2014-04-12',1,'victor2013704','victor'),('obc975ks3b4imo6e5c61koralhrxtj0pryk','127.0.0.1','2014-06-21',1,'alexis2013881','alexis'),('ofr65ddrh6stdolk2tnokwda2vfnndbfv7z','127.0.0.1','2014-05-25',9,'giovani2013290','giovani'),('ol1qno2ro4wrh59s6eqgmyt39gj2e34i4ws','127.0.0.1','2014-06-06',1,'hector2013852','hector'),('omyxdhke6ni2dg33rxy7e1qqpwix4xnxare','127.0.0.1','2014-05-13',6,'carlos2013472','carlos'),('opnrpfr77c8045hc8bytm1xcwn2snpt8wok','127.0.0.1','2014-03-13',1,'ronald2013986','ronald'),('oq3kky4aqtqlpc1owx565t3urmcb72o3hu9','127.0.0.1','2014-05-09',1,'MPV2013907','mperez'),('oqx05v5xxy3pwkoymggqhxgyyge6lfkruhs','127.0.0.1','2014-04-16',4,'00000000000000000000000000000001','admin'),('orshfakxsx6x010whuhvjbhrzgnqrgnk7lk','127.0.0.1','2014-03-29',1,'adolfo2013947','adolfo'),('oua603u2tvnjdv90wja66egtpywz2wa72dj','127.0.0.1','2014-04-19',11,'adolfo2013947','adolfo'),('p0dm39og0a431jw4vvoa91q0p9qw1on0fpq','127.0.0.1','2014-04-01',6,'victor2013704','victor'),('p6hl1htu77kmtopq8r6byjaqzb59pcumftc','127.0.0.1','2014-04-06',2,'adolfo2013947','adolfo'),('pa77pdyzqjpv7g1x3kzfpp4l1xkt2g13yo4','127.0.0.1','2014-05-26',6,'giovani2013290','giovani'),('paagh5b4a2uth26lc1pt9t85cy8b2olhu9i','127.0.0.1','2014-06-11',8,'giovani2013290','giovani'),('pbdez42any8ee0stqj3fh58eqbcgvadi7er','127.0.0.1','2014-04-06',4,'alejandro2013727','alejandro'),('pl17r7b674tawk3xovjk13o18mu4huutbty','127.0.0.1','2014-05-11',2,'carlos2013472','carlos'),('po8fk9tebwdeegrl3mopn884xq1a225m4ll','127.0.0.1','2014-04-19',1,'hector2013852','hector'),('poogqxqfrcn6c6pkkfn26h7vvbrqfgkw8bi','127.0.0.1','2014-04-25',2,'00000000000000000000000000000001','admin'),('ptcvibl1rlnd2gaywqjv8iq76mzrh53wmpd','127.0.0.1','2014-06-05',1,'carlos2013472','carlos'),('pzeddxpbs09mbr3si66v9jacnm2bjzd92qg','127.0.0.1','2014-06-21',15,'giovani2013290','giovani'),('q020s88xqlwy3pprk4ec9i2uyqvoj9ql8tv','127.0.0.1','2014-05-31',2,'00000000000000000000000000000001','admin'),('q2iwrjiva80hmm3hdlybct2j79n95af73rh','127.0.0.1','2014-03-27',1,'00000000000000000000000000000001','admin'),('q2j5chds8611nl7xmyjc43kvgwy89xm5ctp','127.0.0.1','2014-03-15',2,'alejandro2013727','alejandro'),('q654r7ilyta7k3xhs9ekq1gl2soz2ga66dk','127.0.0.1','2014-04-16',4,'giovani2013290','giovani'),('q7edfa71xhyoiis2hf1goxs0r1v6hcq4bb3','127.0.0.1','2014-06-21',1,'hector2013852','hector'),('q9ju09g75csqxl4kmenl45s8w7r91rr28ca','127.0.0.1','2014-06-08',9,'giovani2013290','giovani'),('qarxuygrd4w4fv53jgw8kug5k6j28rsv3hm','127.0.0.1','2014-04-04',1,'alexis2013881','alexis'),('qb1lpl0mbxrhe3z4udikvtw8g2fbypurjpn','127.0.0.1','2014-03-19',1,'adolfo2013947','adolfo'),('qecoww8lodukuqxfczpmy1jl2zluhzq78l6','127.0.0.1','2014-05-30',3,'giovani2013290','giovani'),('qf1pl9yp86apx9nj0ar8bh9mjx86i93yvqc','127.0.0.1','2014-06-07',3,'MPV2013907','mperez'),('qghcncdd4m8nvww9xe1lcywh7ztdwbw333g','127.0.0.1','2014-05-30',1,'MPV2013907','mperez'),('qh4lw9lpa3n5ivwfwvnr2jxj2ywnlj8l63g','127.0.0.1','2014-03-15',5,'alexis2013881','alexis'),('qhqv3riipd3oop2yikaz2vcmuofcghqgb3q','127.0.0.1','2014-06-14',1,'user12014770','user1'),('qj0eptnanf9jtonc8ajy5m8r9fcgorm6q68','127.0.0.1','2014-03-24',1,'alejandro2013727','alejandro'),('qjpxpy554glq5kc2cv0v7y0l4eyyl1t0cgu','127.0.0.1','2014-05-04',1,'MPV2013907','mperez'),('qkof1foag59bks9bet3z7e16x35yfeesdaa','127.0.0.1','2014-04-29',1,'alexis2013881','alexis'),('qolyh3pv9wbbnnblnbs6u4hd2o5xbft2rv6','127.0.0.1','2014-03-30',1,'alexis2013881','alexis'),('qrsij4nbaw3ck9qw3aokeiv2jwxby0hxmhj','127.0.0.1','2014-03-22',5,'00000000000000000000000000000001','admin'),('qtojuijottmwgml0sud3lt6zc8d3druvu6r','127.0.0.1','2014-04-07',5,'victor2013704','victor'),('qtpvaxf4ivp21erywb8jg08un4xmr52ngtr','127.0.0.1','2014-03-28',3,'00000000000000000000000000000001','admin'),('rdtjyf8s4z0zmcik5doit96gdj4w9r6vx2z','127.0.0.1','2014-04-15',1,'victor2013704','victor'),('rfnf4epxekvkndrdgdr4pb38d44yej1qety','127.0.0.1','2014-05-02',1,'00000000000000000000000000000001','admin'),('rg32n3q7yqwbsyjs6k8rtj5729yvoek9hgn','127.0.0.1','2014-06-07',7,'giovani2013290','giovani'),('rjhya4q476fuxxmyzo4wmouldqlit1vvb8m','127.0.0.1','2014-04-19',4,'MPV2013907','mperez'),('rowwk13geh9af0shos7fpzg4ew98ers9urf','127.0.0.1','2014-05-03',6,'giovani2013290','giovani'),('rr5gns74vn3mcbn0686nun58liyks2pa8cn','127.0.0.1','2014-05-04',4,'giovani2013290','giovani'),('rw6z3fnk1sxb6wgywq22w6t034l0i2bn8ee','127.0.0.1','2014-03-18',3,'MPV2013907','mperez'),('rypbuf7b42c825swn85pb4mc582qswemtp8','127.0.0.1','2014-04-08',3,'carlos2013472','carlos'),('s2i2ag7w78d500c8wf6fxr75bu6wgdcltt5','127.0.0.1','2014-06-04',1,'MPV2013907','mperez'),('sfn7nsm2x83vg0y3e6rgs3vivxrdjgulb51','127.0.0.1','2014-04-29',2,'alejandro2013727','alejandro'),('sfzuwpa4nop61a0r16ramw9dd30qeasfmbs','127.0.0.1','2014-03-31',1,'victor2013704','victor'),('spqi48ewfe1843453lngv11p72s7qx14xis','127.0.0.1','2014-03-25',4,'alexis2013881','alexis'),('sqraadpdi4m2a6tjmumzsrjdf6gumjlg2n6','127.0.0.1','2014-03-17',5,'MPV2013907','mperez'),('ss96p18uocn2g8d8dmtha6gaadeq3af3vnn','127.0.0.1','2014-06-17',2,'alejandro2013727','alejandro'),('syvx3jszzbfq6wb0dfjw26dey08pezdnt4m','127.0.0.1','2014-06-06',2,'alejandro2013727','alejandro'),('szdj16puqmidu863i93opkdtcp0lremkj6y','127.0.0.1','2014-04-23',4,'giovani2013290','giovani'),('t0xyjin3psyh7zncrfaa99jr04ygh6h0zv2','127.0.0.1','2014-04-21',3,'victor2013704','victor'),('t1de4cqer2uu6yt8mhn6x2tu92rvear96at','127.0.0.1','2014-03-30',3,'alejandro2013727','alejandro'),('t7m59pgpbvvakrx71bcud0yqhdg95qub4uy','127.0.0.1','2014-06-21',4,'victor2013704','victor'),('t9opn1irqpa04rh39c5ratcsy6ghc4hlwm6','127.0.0.1','2014-05-20',1,'carlos2013472','carlos'),('tbzkvm93dg8mxtsk90emdp1zjjju5202xe7','127.0.0.1','2014-06-16',1,'user12014770','user1'),('tdorfmozmbh3i3o071d0r5a11pz9bcwcqjs','127.0.0.1','2014-05-30',1,'victor2013704','victor'),('tg9rcgk4bdj01lfkt1e94jd3edb48pcwdnm','127.0.0.1','2014-04-13',4,'carlos2013472','carlos'),('tv9db39l3pv37x03wf1rzmnxyy4v8xxbydj','127.0.0.1','2014-06-17',2,'mescobar2013649','mescobar'),('tyigmhrstqw9kae14pnleux5w47obrnr7ct','127.0.0.1','2014-04-23',1,'adolfo2013947','adolfo'),('u2n3c50woj6zvv60cjrpapfifxug6i2lbu9','127.0.0.1','2014-04-14',4,'giovani2013290','giovani'),('uiyasi3h72ausfh7l38nnph9gbx2997uz9i','127.0.0.1','2014-04-27',1,'giovani2013290','giovani'),('ukvfab7mb1dpjb9vusmgn4dbai8i71fzwv1','127.0.0.1','2014-06-16',1,'carlos2013472','carlos'),('up9qxkvkqcpbna5ri504rpmpozp5fyl6f26','127.0.0.1','2014-05-17',2,'giovani2013290','giovani'),('utsqeiqxnjs5daicsrzuhhkcxqhzkys55aq','127.0.0.1','2014-06-09',1,'MPV2013907','mperez'),('uwvquloezcoyl18k3av3906qcknm6mhp1bj','127.0.0.1','2014-05-16',6,'carlos2013472','carlos'),('v1avtug20pacszbh8mjp6rbeca1k3c7y1g8','127.0.0.1','2014-06-12',3,'giovani2013290','giovani'),('v1ef5psmlavvqz5p0ecxn8cftxu7wujiao3','127.0.0.1','2014-03-16',1,'alexis2013881','alexis'),('v47jxngrucg5oza4bo7b32aypwxlk568zcv','127.0.0.1','2014-06-10',15,'00000000000000000000000000000001','admin'),('v9ysw94yp634luw1bnh7quteqh02lx158bq','127.0.0.1','2014-06-06',1,'MPV2013907','mperez'),('vkx29qmxmnutgb5t5nok831iave6dsogfsm','127.0.0.1','2014-04-22',14,'victor2013704','victor'),('vuxh1waftookgfivutjsh08tbhwm6l70pui','127.0.0.1','2014-06-06',3,'alexis2013881','alexis'),('vx076yza8aw8t9w0cfsahjuvuwz0e9rx72g','127.0.0.1','2014-05-13',1,'victor2013704','victor'),('vzjwn98oinwemf2kzbj9ua2asdzlokcq547','127.0.0.1','2014-06-01',1,'00000000000000000000000000000001','admin'),('w4oflh1ej5fix9reoybhjlrohb4a2m91ziy','127.0.0.1','2014-05-23',1,'00000000000000000000000000000001','admin'),('whvpbo2ukpa8jnp1q2qij28o0r23e5erosn','127.0.0.1','2014-04-05',3,'00000000000000000000000000000001','admin'),('wl7cmkxaduj805ofcts4z7hdrh83eimr6eb','127.0.0.1','2014-06-17',8,'giovani2013290','giovani'),('wo0tydmotaq8rwlttg3gb5uegxzh3zgvl65','127.0.0.1','2014-05-20',1,'hector2013852','hector'),('wo7ag2t5ewumuomkz1wnrczdqk14ak1yasa','127.0.0.1','2014-05-07',9,'giovani2013290','giovani'),('wx7ye20o1gtk4nf1glgzthtds23zfrm7vbn','127.0.0.1','2014-05-13',11,'giovani2013290','giovani'),('x0dev2hxf34frwf4utzi9y97ig7oh86uqcx','127.0.0.1','2014-04-03',5,'00000000000000000000000000000001','admin'),('x1x4b8ujq3h0b2o7ja3yacym2ub6wyeu6lc','127.0.0.1','2014-06-14',6,'MPV2013907','mperez'),('xb23ihjj13ze0v1ejwu46fw7jv2h4aeon2h','127.0.0.1','2014-05-20',3,'00000000000000000000000000000001','admin'),('xwdgh9skajjfo0ky2gsgyctbhfzm0vtwvua','127.0.0.1','2014-05-02',2,'giovani2013290','giovani'),('xx2vmhfnrk1fmnicsnjr6fzxquqh89pcrro','127.0.0.1','2014-05-25',1,'00000000000000000000000000000001','admin'),('y25v1yuuut533csl1w10n7lfym8agi2yp70','127.0.0.1','2014-03-24',10,'00000000000000000000000000000001','admin'),('y37oypgodbn2vmj2e5xlr2d4gjoacvjabxw','127.0.0.1','2014-04-14',5,'00000000000000000000000000000001','admin'),('y38k6oirwrym10g26n7v6nhjo902j7ezznh','127.0.0.1','2014-06-05',3,'victor2013704','victor'),('yh4shb99zciqtikpi9fa414k4ov3dm6xqu6','127.0.0.1','2014-06-04',2,'user12014770','user1'),('ymrvgvte89g9vcg8pgkdnnydkygon4slw8n','127.0.0.1','2014-06-10',5,'giovani2013290','giovani'),('yt3mj8gfkufsiyyrw5p8dqi3f7olpf1qc6a','127.0.0.1','2014-05-15',1,'giovani2013290','giovani'),('z8nimrvtyrhd71yepawh16wgjhllcj1s8u9','127.0.0.1','2014-04-14',10,'carlos2013472','carlos'),('zd020sz6do0fe25tz4e6jnap60cmvi6flfi','127.0.0.1','2014-04-07',11,'alejandro2013727','alejandro'),('zf1yimucpgip8f430hqh3o7askty7ij5vmr','127.0.0.1','2014-04-03',2,'alejandro2013727','alejandro'),('zf96zhbkxc7ry22x0w1a1vccpgnwt6ieher','127.0.0.1','2014-06-15',4,'00000000000000000000000000000001','admin'),('zh19iu544jnoelkmj1tnsul16s3tngowm2n','127.0.0.1','2014-03-29',1,'alexis2013881','alexis'),('zkad81ywy88etqb0x589gnlrkf8zgjzbwz6','127.0.0.1','2014-03-17',1,'alejandro2013727','alejandro'),('zkdoftdfwq52j11weolninhlx29rzra5jwt','127.0.0.1','2014-04-06',2,'00000000000000000000000000000001','admin'),('zkrkmw5ngtc9pk2l4luhjvxai8ur3pb4i2e','127.0.0.1','2014-05-30',3,'00000000000000000000000000000001','admin'),('znxwcp29pylq8lslkwg2wmyod655wt1hn6z','127.0.0.1','2014-03-26',1,'MPV2013907','mperez'),('ztyjuv658nkki2tzllzmdix4sntwkso8ur9','127.0.0.1','2014-04-08',3,'victor2013704','victor'),('zx0jdhnm8twgomprpcw2ozs8s8maqnixg9o','127.0.0.1','2014-04-07',5,'00000000000000000000000000000001','admin'),('zxmmdibq7u5214r1xq4xboix1ij779jbj63','127.0.0.1','2014-04-22',3,'giovani2013290','giovani');
/*!40000 ALTER TABLE `contadoraccesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controlpermiso`
--

DROP TABLE IF EXISTS `controlpermiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controlpermiso` (
  `IDcontrol` varchar(40) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `fechaPermiso` date NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`IDcontrol`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDempleado_2` (`IDempleado`),
  CONSTRAINT `controlpermiso_ibfk_1` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controlpermiso`
--

LOCK TABLES `controlpermiso` WRITE;
/*!40000 ALTER TABLE `controlpermiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `controlpermiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `costofijo`
--

DROP TABLE IF EXISTS `costofijo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `costofijo` (
  `IDcosto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(110) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`IDcosto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costofijo`
--

LOCK TABLES `costofijo` WRITE;
/*!40000 ALTER TABLE `costofijo` DISABLE KEYS */;
INSERT INTO `costofijo` VALUES (1,'Costo por uso de luz electrica',1200.00),(2,'Costo por uso agua',1000.00),(3,'costo de internet',1500.00),(4,'costo por uso de telefono',1200.00);
/*!40000 ALTER TABLE `costofijo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion`
--

DROP TABLE IF EXISTS `cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cotizacion` (
  `nro_cotizacion` varchar(40) NOT NULL,
  `nro_solicitud` varchar(40) NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`nro_cotizacion`),
  KEY `IDproveedor` (`IDproveedor`),
  KEY `nro_solicitud` (`nro_solicitud`),
  CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`),
  CONSTRAINT `cotizacion_ibfk_2` FOREIGN KEY (`nro_solicitud`) REFERENCES `solicitud_cotizacion` (`nro_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion`
--

LOCK TABLES `cotizacion` WRITE;
/*!40000 ALTER TABLE `cotizacion` DISABLE KEYS */;
INSERT INTO `cotizacion` VALUES ('18350099973036373954074030690153300','98765503189127674990082727218186220','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-25','19:25:13'),('25374980589390317040091261569362301','29758215232568503266504249723688116','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-26','18:57:16'),('33270427482574537664254001939424650','48183113048723711148596959053569388','adzkshnx71smkfrxyygkz21s5iy11w','2014-06-17','10:41:46'),('34513775937135541029555831969358794','85945014266938469407496789883946134','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-11','18:31:46'),('38754986758311107911670265173274339','65665464579773525223056684574885281','adzkshnx71smkfrxyygkz21s5iy11w','2014-06-17','16:09:05'),('53168386723474388291822625472331013','71637251109789665793994128573039479','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-16','15:59:56'),('91164186204109552653360863611915801','09606900308104048528541661768901796','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-21','20:46:22');
/*!40000 ALTER TABLE `cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `IDdepto` varchar(40) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDdepto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES ('00000000000000000000000000000001','GERENCIA GENERAL','departamento de administracion de la empresa','2014-03-10','17:42:50'),('00000000000000000000000000000002','SECRETARIA','departamento de secretaria de la empresa','2014-03-10','17:42:50'),('00000000000000000000000000000003','GERENCIA ADMINISTRATIVA','gerencia de administracion','2014-03-10','17:42:50'),('00000000000000000000000000000004','GERENCIA TECNICA','gerencia de planificacion','2014-03-10','17:42:50'),('00000000000000000000000000000005','GERENCIA DE EQUIPOS','gerencia de equipos pesados ','2014-03-10','17:42:50'),('00000000000000000000000000000006','COTIZACIONES','departamento de cotizaciones de precios unitarios de items','2014-03-10','17:42:50'),('00000000000000000000000000000007','COMPRA Y ALQUILER','departamento de compra y alquiler de items','2014-03-10','17:42:50'),('00000000000000000000000000000008','PROYECTOS','departamento de planificacion de proyectos','2014-03-10','17:42:50'),('00000000000000000000000000000009','SUPERINTENDENCIA DE OBRAS','departamento de superintendencia de obras civiles','2014-03-10','17:42:50'),('00000000000000000000000000000010','MECANICOS','departamento de mecanicos','2014-03-10','17:42:50'),('00000000000000000000000000000011','OPERARIOS','departamento de operarios','2014-03-10','17:42:50'),('00000000000000000000000000000012','SISTEMAS','departamento de control de sistemas','2014-03-10','17:42:50'),('00000000000000000000000000000013','RECURSOS HUMANOS','departamento de gestion de personal','2014-03-10','17:42:50'),('00000000000000000000000000000014','ADMINISTRACION','departamento de administracion de la empresa','2014-03-11','10:14:00'),('9own0pco19ed8cly7oyj8hyyqxuwakqg33u','GERENCIA DE SISTEMAS','departamento de sistemas informaticos','2014-06-14','23:34:45'),('uvj1b5thj96lvt9vejvnpbgo744mbk97zpb','ALMACENES','control de logistica e ingreso de items','2014-03-31','20:53:33');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_cotizacion`
--

DROP TABLE IF EXISTS `det_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_cotizacion` (
  `nro_cotizacion` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `cantidad_sol` decimal(10,2) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  KEY `nro_cotizacion` (`nro_cotizacion`),
  KEY `IDmaterial` (`IDmaterial`),
  CONSTRAINT `det_cotizacion_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`),
  CONSTRAINT `det_cotizacion_ibfk_2` FOREIGN KEY (`nro_cotizacion`) REFERENCES `cotizacion` (`nro_cotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_cotizacion`
--

LOCK TABLES `det_cotizacion` WRITE;
/*!40000 ALTER TABLE `det_cotizacion` DISABLE KEYS */;
INSERT INTO `det_cotizacion` VALUES ('34513775937135541029555831969358794','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7',2.00,'BLS',61.86,123.72),('34513775937135541029555831969358794','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb',3.00,'LT',10.73,32.19),('53168386723474388291822625472331013','7bfpke0vc3tdxu09psw6samitn32aidxez7',2.00,'MI',5.21,10.42),('53168386723474388291822625472331013','rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw',10.00,'PZA',1320.00,13200.00),('53168386723474388291822625472331013','xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6',5.00,'PZA',247.00,1235.00),('91164186204109552653360863611915801','4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx',3.00,'PZA',40.28,120.84),('91164186204109552653360863611915801','ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla',2.00,'PZA',1320.00,2640.00),('91164186204109552653360863611915801','1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q',4.50,'HM',1250.00,5625.00),('18350099973036373954074030690153300','nw28w541ja2pix442xhtb4kk96rqeo99zy4',1.30,'M3',25.62,33.31),('25374980589390317040091261569362301','o2zznd6leyij7r9rbuopr50fbt38qgbpyv4',10.00,'M3',20.00,200.00),('33270427482574537664254001939424650','vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi',4.00,'M3',1250.00,5000.00),('33270427482574537664254001939424650','oubwb8s3nts4xep8v14kn87e3butwngchx4',12.00,'PZA',4.50,54.00),('38754986758311107911670265173274339','snmevq7djfybgg4lpl2vag2agjof7wdozf8',10.00,'PZA',8.00,80.00),('38754986758311107911670265173274339','pqhegpg1cpgkasr80x01edvu2itr8a0jvsn',8.00,'M3',75.00,600.00);
/*!40000 ALTER TABLE `det_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_entrada`
--

DROP TABLE IF EXISTS `det_entrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_entrada` (
  `IDentrada` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  KEY `IDentrada` (`IDentrada`),
  KEY `IDmaterial` (`IDmaterial`),
  CONSTRAINT `det_entrada_ibfk_1` FOREIGN KEY (`IDentrada`) REFERENCES `entrada` (`IDentrada`),
  CONSTRAINT `det_entrada_ibfk_2` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_entrada`
--

LOCK TABLES `det_entrada` WRITE;
/*!40000 ALTER TABLE `det_entrada` DISABLE KEYS */;
INSERT INTO `det_entrada` VALUES ('24782080096076486042140060116494122','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','BLS',2.00,61.86),('24782080096076486042140060116494122','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','LT',3.00,10.73);
/*!40000 ALTER TABLE `det_entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_entrega`
--

DROP TABLE IF EXISTS `det_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_entrega` (
  `Nro_entrega` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  KEY `Nro_entrega` (`Nro_entrega`),
  KEY `IDmaterial` (`IDmaterial`),
  CONSTRAINT `det_entrega_ibfk_1` FOREIGN KEY (`Nro_entrega`) REFERENCES `entrega` (`Nro_entrega`),
  CONSTRAINT `det_entrega_ibfk_2` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_entrega`
--

LOCK TABLES `det_entrega` WRITE;
/*!40000 ALTER TABLE `det_entrega` DISABLE KEYS */;
INSERT INTO `det_entrega` VALUES ('85525642258952541475231794817290340','nw28w541ja2pix442xhtb4kk96rqeo99zy4',18.00,'M3'),('29102001418273999801488903706858102','nw28w541ja2pix442xhtb4kk96rqeo99zy4',21.00,'M3');
/*!40000 ALTER TABLE `det_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_notaremision`
--

DROP TABLE IF EXISTS `det_notaremision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_notaremision` (
  `nro_nota` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  KEY `IDmaterial` (`IDmaterial`),
  KEY `nro_nota` (`nro_nota`),
  CONSTRAINT `det_notaremision_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`),
  CONSTRAINT `det_notaremision_ibfk_2` FOREIGN KEY (`nro_nota`) REFERENCES `nota_remision` (`nro_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_notaremision`
--

LOCK TABLES `det_notaremision` WRITE;
/*!40000 ALTER TABLE `det_notaremision` DISABLE KEYS */;
INSERT INTO `det_notaremision` VALUES ('41733862830238765600981985906183904','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','BLS',2.00,61.86),('41733862830238765600981985906183904','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','LT',3.00,10.73),('77964605968543614235469294118061933','7bfpke0vc3tdxu09psw6samitn32aidxez7','MI',2.00,5.21),('77964605968543614235469294118061933','rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','PZA',10.00,1320.00),('77964605968543614235469294118061933','xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','PZA',5.00,247.00),('48722279977794650448100846325873008','4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','PZA',3.00,40.28),('48722279977794650448100846325873008','ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla','PZA',2.00,1320.00),('48722279977794650448100846325873008','1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','HM',4.50,1250.00),('33977363365430869628560971923087278','nw28w541ja2pix442xhtb4kk96rqeo99zy4','M3',1.30,25.62),('61154084666090303624914761065355838','o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','M3',10.00,20.00),('76635712627903257095446220638001059','vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi','M3',4.00,1250.00),('76635712627903257095446220638001059','oubwb8s3nts4xep8v14kn87e3butwngchx4','PZA',12.00,4.50),('88607542037414947970227710801281062','snmevq7djfybgg4lpl2vag2agjof7wdozf8','PZA',10.00,8.00),('88607542037414947970227710801281062','pqhegpg1cpgkasr80x01edvu2itr8a0jvsn','M3',8.00,75.00);
/*!40000 ALTER TABLE `det_notaremision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_pedido`
--

DROP TABLE IF EXISTS `det_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_pedido` (
  `nro_pedido` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  KEY `IDmaterial` (`IDmaterial`),
  KEY `IDpedido` (`nro_pedido`),
  CONSTRAINT `det_pedido_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`),
  CONSTRAINT `det_pedido_ibfk_2` FOREIGN KEY (`nro_pedido`) REFERENCES `pedido_material` (`nro_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_pedido`
--

LOCK TABLES `det_pedido` WRITE;
/*!40000 ALTER TABLE `det_pedido` DISABLE KEYS */;
INSERT INTO `det_pedido` VALUES ('25818581517554202819675204711280562','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','BLS',2.00,61.86,123.72),('25818581517554202819675204711280562','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','LT',3.00,10.73,32.19),('30877429526189633009838089440086877','7bfpke0vc3tdxu09psw6samitn32aidxez7','MI',2.00,5.21,10.42),('30877429526189633009838089440086877','rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','PZA',10.00,1320.00,13200.00),('30877429526189633009838089440086877','xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','PZA',5.00,247.00,1235.00),('65032236537741835733376758629634700','4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','PZA',3.00,40.28,120.84),('65032236537741835733376758629634700','ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla','PZA',2.00,1320.00,2640.00),('65032236537741835733376758629634700','1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','HM',4.50,1250.00,5625.00),('37960840319462444728829944819044178','nw28w541ja2pix442xhtb4kk96rqeo99zy4','M3',1.30,25.62,33.31),('77013133346094360660772096884009274','o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','M3',10.00,20.00,200.00),('09939918128376401038510998193170808','vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi','M3',4.00,1250.00,5000.00),('09939918128376401038510998193170808','oubwb8s3nts4xep8v14kn87e3butwngchx4','PZA',12.00,4.50,54.00),('93468358483733567751492971021847415','snmevq7djfybgg4lpl2vag2agjof7wdozf8','PZA',10.00,8.00,80.00),('93468358483733567751492971021847415','pqhegpg1cpgkasr80x01edvu2itr8a0jvsn','M3',8.00,75.00,600.00);
/*!40000 ALTER TABLE `det_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_pedido_almacen`
--

DROP TABLE IF EXISTS `det_pedido_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_pedido_almacen` (
  `Nro_pedido` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `cantidad_sol` decimal(10,2) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  KEY `IDmaterial` (`IDmaterial`),
  KEY `IDmaterial_2` (`IDmaterial`),
  KEY `Nro_pedido` (`Nro_pedido`),
  CONSTRAINT `det_pedido_almacen_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`),
  CONSTRAINT `det_pedido_almacen_ibfk_2` FOREIGN KEY (`Nro_pedido`) REFERENCES `pedido_almacen` (`Nro_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_pedido_almacen`
--

LOCK TABLES `det_pedido_almacen` WRITE;
/*!40000 ALTER TABLE `det_pedido_almacen` DISABLE KEYS */;
INSERT INTO `det_pedido_almacen` VALUES ('35865225714967609217859972732566850','nw28w541ja2pix442xhtb4kk96rqeo99zy4',18.00,'M3'),('75731113116713105997340907126467180','nw28w541ja2pix442xhtb4kk96rqeo99zy4',21.00,'M3');
/*!40000 ALTER TABLE `det_pedido_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_solicitud_cotizacion`
--

DROP TABLE IF EXISTS `det_solicitud_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_solicitud_cotizacion` (
  `nro_solicitud` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `cantidad_sol` decimal(10,2) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  KEY `nro_solicitud` (`nro_solicitud`),
  KEY `nro_solicitud_2` (`nro_solicitud`),
  KEY `IDmaterial` (`IDmaterial`),
  CONSTRAINT `det_solicitud_cotizacion_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`),
  CONSTRAINT `det_solicitud_cotizacion_ibfk_2` FOREIGN KEY (`nro_solicitud`) REFERENCES `solicitud_cotizacion` (`nro_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_solicitud_cotizacion`
--

LOCK TABLES `det_solicitud_cotizacion` WRITE;
/*!40000 ALTER TABLE `det_solicitud_cotizacion` DISABLE KEYS */;
INSERT INTO `det_solicitud_cotizacion` VALUES ('85945014266938469407496789883946134','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7',2.00,'BLS'),('85945014266938469407496789883946134','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb',3.00,'LT'),('71637251109789665793994128573039479','7bfpke0vc3tdxu09psw6samitn32aidxez7',2.00,'MI'),('71637251109789665793994128573039479','rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw',10.00,'PZA'),('71637251109789665793994128573039479','xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6',5.00,'PZA'),('09606900308104048528541661768901796','4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx',3.00,'PZA'),('09606900308104048528541661768901796','ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla',2.00,'PZA'),('09606900308104048528541661768901796','1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q',4.50,'HM'),('98765503189127674990082727218186220','nw28w541ja2pix442xhtb4kk96rqeo99zy4',1.30,'M3'),('29758215232568503266504249723688116','o2zznd6leyij7r9rbuopr50fbt38qgbpyv4',10.00,'M3'),('48183113048723711148596959053569388','vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi',4.00,'M3'),('48183113048723711148596959053569388','oubwb8s3nts4xep8v14kn87e3butwngchx4',12.00,'PZA'),('65665464579773525223056684574885281','snmevq7djfybgg4lpl2vag2agjof7wdozf8',10.00,'PZA'),('65665464579773525223056684574885281','pqhegpg1cpgkasr80x01edvu2itr8a0jvsn',8.00,'M3');
/*!40000 ALTER TABLE `det_solicitud_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleado` (
  `IDempleado` varchar(40) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `app` varchar(40) DEFAULT NULL,
  `apm` varchar(40) DEFAULT NULL,
  `CI` varchar(30) NOT NULL,
  `telefonos` varchar(30) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `fecNacimiento` date NOT NULL,
  `estadoCivil` varchar(40) NOT NULL,
  `fecIngreso` date NOT NULL,
  `IDcargo` varchar(40) NOT NULL,
  `IDdepto` varchar(40) NOT NULL,
  `IDprofesion` varchar(40) NOT NULL,
  `haberBasico` decimal(10,2) NOT NULL,
  `aniosTrabajo` decimal(10,2) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDempleado`),
  UNIQUE KEY `CI` (`CI`),
  KEY `IDcargo` (`IDcargo`),
  KEY `IDdepto` (`IDdepto`),
  KEY `cedula` (`CI`),
  KEY `cedula_2` (`CI`),
  KEY `CI_2` (`CI`),
  KEY `IDdepto_2` (`IDdepto`),
  KEY `IDprofesion` (`IDprofesion`),
  CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`IDdepto`) REFERENCES `departamento` (`IDdepto`),
  CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`IDcargo`) REFERENCES `cargo` (`IDcargo`),
  CONSTRAINT `empleado_ibfk_3` FOREIGN KEY (`IDprofesion`) REFERENCES `profesion` (`IDprofesion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES ('15qd3xtq54ty5n3eqzp2stgj0qxems6meow','Iver','Mejia','Castillo','87644334 Ex La Paz','24149042','bajo llojera','1989-05-18','soltero/a','2012-09-09','bt26493p9s4amydy6bo5qef47badb2eii0z','00000000000000000000000000000014','br7ozar04owlcnon47nbnnoeagzavaqlbvm',2500.00,1.50,'2014-03-11','12:41:36'),('2z6017tphhycg0iitxmg9j2y6po7e1va4jm','Franz','Lea Plaza','Vargas','2335504','72569647','San pedro','1956-12-26','casado/a','2000-10-12','irdru3qkv2qsqk2hah7ixegkdswjgnpcdsh','00000000000000000000000000000014','br7ozar04owlcnon47nbnnoeagzavaqlbvm',5000.00,13.68,'2014-06-14','23:50:38'),('cdrbqohjwybww9v19swnc44gvi9q3ud9xqf','Luis Alberto','Saavedra','Sanchez','8944334 Ex La Paz','23244589','sopocachi','1980-09-12','soltero/a','2010-08-15','v35ozkm0xl7iok79c2kyduo5kmzwbosk7sk','00000000000000000000000000000008','kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz',4000.00,3.58,'2014-03-14','19:14:39'),('hokox51uwqjzc3ebcjlulnxg0ppcqt4oj5b','Adolfo','Perez','Soza','5890334 Exp La Paz','27890775 - 7259083','av ballivian #449 z calacoto','1957-09-13','casado/a','2008-09-11','nyjlqqygd6jzi1hkdlijpz9gkyihrpd7ge3','00000000000000000000000000000004','kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz',5600.00,5.52,'2014-03-17','15:36:39'),('j5foiy91wzz9cqy98hg5xxe8h8bytm1rrfn','Carlos','Renjel','Barrenechea','4855994','25544893','san pedro','1979-07-19','casado/a','2012-11-04','b8dtncdvo2wn41h11cmvgfyhwvyite9h4of','uvj1b5thj96lvt9vejvnpbgo744mbk97zpb','wyeq1p0v8hb7pzrva78eebdet4ustam9u6s',2000.00,1.41,'2014-03-31','20:55:14'),('k6voh4c1xq2kchj9g8l2na7vut0i1pz4v2u','Lorena Andrea','aranibar','romero','58904432 exp La Paz','72590443','sopocachi','1990-01-24','soltero/a','2013-03-03','npx3lv3lxdot10tsawuycm8t4yvgb09mey7','00000000000000000000000000000002','bj8jwl9k4e24qskllfnrat4sms7imhsrjwo',1500.00,1.02,'2014-03-11','13:47:22'),('k9g9pmrjbhmw3uby81j7o9zw80yrz41nkit','Roberto Carlos','Justo','Villarroel','25344558 exp La Paz','73044559','Alto san pedro #456','1980-09-13','soltero/a','2013-09-15','v35ozkm0xl7iok79c2kyduo5kmzwbosk7sk','00000000000000000000000000000008','kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz',2400.00,0.59,'2014-04-19','19:47:33'),('pee1g7uvmjhq1jj3ilzmv7nle4elojbdmbe','Omar','Suca','Perez','2345890 Exp. La Paz','73049093 -24988933','calle landaeta #456 San Pedro','1987-09-17','soltero/a','2013-04-08','23u2z3ko3r049i4dzj0pkeo7b35vqoobvw4','00000000000000000000000000000012','c0amlpu0wkqdwwh9bdm91qrhh8b5f8rh0dt',3500.00,0.93,'2014-03-14','09:10:01'),('pqp9fgqqhkc410cfkn0e1cyj9qkbbl60bqt','Marcelo Rodrigo','Mendoza','Ramos','5890440 Exp La Paz','2419044','calle Harrington #4489 z/sopocachi','1979-02-04','soltero/a','2010-03-18','2gjagq865a29h305kd15o71j9psdsuw92mc','00000000000000000000000000000008','kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz',3100.00,4.00,'2014-03-18','09:45:08'),('qt1w7wkalr7lo0edkz2jaf78fma8d7x8lmw','Maria','Perez','Vargas','449984 L.P','75044334','san pedro','1976-09-15','soltero/a','2009-08-15','bt26493p9s4amydy6bo5qef47badb2eii0z','00000000000000000000000000000014','br7ozar04owlcnon47nbnnoeagzavaqlbvm',2500.00,4.50,'2014-03-10','21:12:35'),('t8n4ajqr7vjrna96z2bu9qsqlqjtslx3uzi','Giovani','Lopez','Velasco','25448909 Exp La Paz','24244890 - 72590234','av Abdon Saavedra #4490 z/sopocachi','1980-02-18','casado/a','2012-09-03','zo3ogohceg17o4oc3ofmsvn93r3uu6dhhfs','00000000000000000000000000000008','kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz',3200.00,1.54,'2014-03-18','09:37:22'),('vn9tikh0foq84685j7ksntqm3clze0dx2y9','Ivan','Escobar','Portillo','8944330 Exp La Paz','2759034','la florida','1972-04-14','casado/a','2011-04-04','bvug8b5ty98muzgzpjapyonezjomu38p9kk','00000000000000000000000000000004','uy5anog3jkrtld5dgpy5dgkjzny03wd1yyd',4200.00,2.95,'2014-03-17','16:04:52'),('xx896pjeah20odas37yq1nj5kovp1vp4qyz','Victor','Saisa','Lopez','8944559','2828955','ciudad satelite, el alto','1980-04-15','soltero/a','2012-03-12','jvn2j7uixbbzhhpheyk7xrlzhksu6ix8npb','00000000000000000000000000000007','o86n8hu06hbkzk7bklmxr0bozac6q5t4ttf',2100.00,2.05,'2014-03-31','20:51:43');
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encargadomanoobra`
--

DROP TABLE IF EXISTS `encargadomanoobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encargadomanoobra` (
  `USR_UID` varchar(30) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `app` varchar(40) NOT NULL,
  `apm` varchar(40) NOT NULL,
  `CI` varchar(20) NOT NULL,
  `empresaProv` varchar(50) NOT NULL,
  `direccionEmpresa` varchar(110) NOT NULL,
  `telefonos` varchar(20) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`USR_UID`),
  UNIQUE KEY `CI` (`CI`),
  CONSTRAINT `encargadomanoobra_ibfk_1` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encargadomanoobra`
--

LOCK TABLES `encargadomanoobra` WRITE;
/*!40000 ALTER TABLE `encargadomanoobra` DISABLE KEYS */;
INSERT INTO `encargadomanoobra` VALUES ('alexis2013881','Alexis','Corleone','Lazo','4554432 Ex La Paz','Mano de obra SRL','av 6 de Marzo #4455','28233944 - 72044339','2014-03-14','19:18:39');
/*!40000 ALTER TABLE `encargadomanoobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrada`
--

DROP TABLE IF EXISTS `entrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrada` (
  `IDentrada` varchar(40) NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  `fecRegistro` date NOT NULL,
  `nro_nota` varchar(40) NOT NULL,
  PRIMARY KEY (`IDentrada`),
  KEY `IDproveedor` (`IDproveedor`),
  KEY `nro_pedido` (`nro_nota`),
  CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`),
  CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`nro_nota`) REFERENCES `nota_remision` (`nro_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada`
--

LOCK TABLES `entrada` WRITE;
/*!40000 ALTER TABLE `entrada` DISABLE KEYS */;
INSERT INTO `entrada` VALUES ('24782080096076486042140060116494122','adzkshnx71smkfrxyygkz21s5iy11w','2014-04-14','41733862830238765600981985906183904');
/*!40000 ALTER TABLE `entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrega`
--

DROP TABLE IF EXISTS `entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrega` (
  `Nro_entrega` varchar(40) NOT NULL,
  `Nro_pedido` varchar(40) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `IDactividad` varchar(40) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`Nro_entrega`),
  KEY `Nro_pedido` (`Nro_pedido`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDactividad` (`IDactividad`),
  CONSTRAINT `entrega_ibfk_1` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`),
  CONSTRAINT `entrega_ibfk_2` FOREIGN KEY (`Nro_pedido`) REFERENCES `pedido_almacen` (`Nro_pedido`),
  CONSTRAINT `entrega_ibfk_3` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrega`
--

LOCK TABLES `entrega` WRITE;
/*!40000 ALTER TABLE `entrega` DISABLE KEYS */;
INSERT INTO `entrega` VALUES ('29102001418273999801488903706858102','75731113116713105997340907126467180','j5foiy91wzz9cqy98hg5xxe8h8bytm1rrfn','89870740458545731688124221354631726','Atendido','2014-06-17'),('85525642258952541475231794817290340','35865225714967609217859972732566850','j5foiy91wzz9cqy98hg5xxe8h8bytm1rrfn','96367782363307395876037507801498575','Atendido','2014-06-08');
/*!40000 ALTER TABLE `entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fase`
--

DROP TABLE IF EXISTS `fase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fase` (
  `IDfase` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `nombre` varchar(110) NOT NULL,
  `longitudKM` decimal(10,2) DEFAULT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDfase`),
  KEY `IDproyecto` (`IDproyecto`),
  CONSTRAINT `fase_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fase`
--

LOCK TABLES `fase` WRITE;
/*!40000 ALTER TABLE `fase` DISABLE KEYS */;
INSERT INTO `fase` VALUES ('46083664575463632886339715147520197','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','Tramo LP03 Escoma - San jose',0.00,'2014-04-20','19:20:59'),('47851426447886104928510055641702931','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','Tramo LP01 Australia a Rurrenabaque',454.00,'2014-04-20','19:14:00'),('59419696023784598647910745603239331','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','Tramo LP02 Quiquibey-Yucumo-Rurrenabaque-Ixiamas',0.00,'2014-04-20','19:17:00'),('76412120815326159112589680874099940','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','Tramo II: Mantecani-Lekepampa',80.00,'2014-06-15','19:07:35'),('92297026485391162739109795474413961','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','Tramo I: Senkata-Mantecani',120.00,'2014-06-15','19:06:59');
/*!40000 ALTER TABLE `fase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informemaquinaria`
--

DROP TABLE IF EXISTS `informemaquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informemaquinaria` (
  `identificador` varchar(40) NOT NULL,
  `IDmaquinaria` varchar(40) NOT NULL,
  `IDactividad` varchar(40) NOT NULL,
  `unidad_avance` varchar(20) NOT NULL,
  `avance_informado` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`identificador`),
  KEY `IDactividad` (`IDactividad`),
  KEY `IDmaquinaria` (`IDmaquinaria`),
  CONSTRAINT `informemaquinaria_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`),
  CONSTRAINT `informemaquinaria_ibfk_2` FOREIGN KEY (`IDmaquinaria`) REFERENCES `maquinaria` (`IDmaquinaria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informemaquinaria`
--

LOCK TABLES `informemaquinaria` WRITE;
/*!40000 ALTER TABLE `informemaquinaria` DISABLE KEYS */;
INSERT INTO `informemaquinaria` VALUES ('05031349788199613963717749853892244','daxusj4txhyre2ga29p6qhk2noco437hm8c','16312694610626839903110083018845809','HM',3.40,'2014-05-25'),('10963731067262534246594882641743987','duikwxjjzz96yzj8y1eegfam6gruvo4usw3','89870740458545731688124221354631726','HM',4.50,'2014-06-17'),('23386458069498670324110084453806232','duikwxjjzz96yzj8y1eegfam6gruvo4usw3','49564628690744821068807232619609093','HM',3.40,'2014-06-21'),('27538582395085494981800101828318245','daxusj4txhyre2ga29p6qhk2noco437hm8c','96711503938685541007417821736235783','HM',4.30,'2014-06-17'),('33496522592371132025064575843082341','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','96711503938685541007417821736235783','HM',3.20,'2014-06-17'),('54580203850420306257343258180151622','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','96711503938685541007417821736235783','HM',1.20,'2014-06-17'),('78458564368689887073348989996652198','dg07ngp1xhjp5qke9e9yds20845sdlz54rj','96711503938685541007417821736235783','HM',4.30,'2014-06-17');
/*!40000 ALTER TABLE `informemaquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informematerial`
--

DROP TABLE IF EXISTS `informematerial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informematerial` (
  `identificador` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `IDactividad` varchar(40) NOT NULL,
  `cantidad_usada` decimal(10,2) NOT NULL,
  `fechaRegistro` date NOT NULL,
  PRIMARY KEY (`identificador`),
  KEY `IDactividad` (`IDactividad`),
  KEY `IDmaterial` (`IDmaterial`),
  CONSTRAINT `informematerial_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`),
  CONSTRAINT `informematerial_ibfk_2` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informematerial`
--

LOCK TABLES `informematerial` WRITE;
/*!40000 ALTER TABLE `informematerial` DISABLE KEYS */;
INSERT INTO `informematerial` VALUES ('13238576210401551492021324709520324','nw28w541ja2pix442xhtb4kk96rqeo99zy4','89870740458545731688124221354631726',2.68,'2014-06-17'),('61999436312101353002231706183371811','nw28w541ja2pix442xhtb4kk96rqeo99zy4','89870740458545731688124221354631726',4.50,'2014-06-17'),('67918716870782342101092631381567502','nw28w541ja2pix442xhtb4kk96rqeo99zy4','96367782363307395876037507801498575',4.50,'2014-06-08');
/*!40000 ALTER TABLE `informematerial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informetrabajador`
--

DROP TABLE IF EXISTS `informetrabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informetrabajador` (
  `Identificador` varchar(40) NOT NULL,
  `CI_trabajador` varchar(40) NOT NULL,
  `IDactividad` varchar(40) NOT NULL,
  `unidad_trabajo` varchar(20) NOT NULL,
  `total_horas` decimal(10,2) NOT NULL,
  `unidad_avance` varchar(20) NOT NULL,
  `avance_informado` decimal(10,2) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `fechaAvance` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`Identificador`),
  KEY `IDactividad` (`IDactividad`),
  KEY `CI_trabajador` (`CI_trabajador`),
  CONSTRAINT `informetrabajador_ibfk_1` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informetrabajador`
--

LOCK TABLES `informetrabajador` WRITE;
/*!40000 ALTER TABLE `informetrabajador` DISABLE KEYS */;
INSERT INTO `informetrabajador` VALUES ('04366286636998525951316439529093939','7844903 Exp La Paz','96367782363307395876037507801498575','HH',7.00,'m3',3.40,'levantamiento de escombros','2014-06-10','10:36:47'),('04931109455830503667669396500970418','2898554 Exp La Paz','16312694610626839903110083018845809','HH',8.00,'km',1.20,'control de nivelacion del terrreno','2014-05-25','19:02:37'),('07372632292869329470713871939925564','3900445 Exp La Paz','16312694610626839903110083018845809','HH',7.00,'km',1.50,'nivelacion usando equipo pesado','2014-05-25','19:12:23'),('10594425721245600763478914066015052','3988447 Exp La Paz','49564628690744821068807232619609093','HH',6.00,'m3',1.30,'DescripciÃ³n no almacenada','2014-06-21','17:52:52'),('15974767473523022258338219330542278','4895544 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',4.30,'DescripciÃ³n no almacenada','2014-06-21','17:49:23'),('16184246375337358860404900301932643','4789554 Exp La Paz','89870740458545731688124221354631726','HH',7.00,'m3',0.14,'DescripciÃ³n no almacenada','2014-06-17','21:38:54'),('23966949268672530526940745881648434','3490554 Exp La Paz','96367782363307395876037507801498575','HH',7.00,'m3',3.10,'transporte de ripio para bacher','2014-06-01','15:59:24'),('24243132952421501468241493868210339','3900445 Exp La Paz','16312694610626839903110083018845809','HH',7.00,'km',1.30,'preparacion del terreno','2014-05-25','19:51:51'),('26423637904369178808237848358711464','3900445 Exp La Paz','49564628690744821068807232619609093','HH',7.00,'m3',1.20,'despeje de la via para excavacion','2014-06-17','22:06:47'),('35082525892909311679195211168530169','4895544 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',5.60,'colocado de letreros de la actividad','2014-06-10','10:36:21'),('39906777685342888893691509056180791','2904348 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',5.60,'DescripciÃ³n no almacenada','2014-06-21','17:49:13'),('40247891358493031401192633766275849','3389449 Exp La Paz','16312694610626839903110083018845809','HH',7.50,'km',2.10,'control de operacion durante el trabajo','2014-05-25','19:12:47'),('48784695575486011801049280680697702','3490554 Exp La Paz','96367782363307395876037507801498575','HH',7.00,'m3',5.60,'transporte de escombros','2014-06-10','10:36:59'),('49954363655661802825512437829093128','3900445 Exp La Paz','49564628690744821068807232619609093','HH',7.00,'m3',3.40,'excavacion de suelos','2014-06-21','17:51:55'),('50040992783795345460093727903218009','2088344 Exp La Paz','96711503938685541007417821736235783','HH',6.50,'km',3.20,'levantado de escombros a maquina','2014-06-17','21:03:59'),('54709806800756067189212683576191607','4895544 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',4.50,'recubrimiento de baches con cemento','2014-06-01','15:53:26'),('55803344938386105119293230875391450','7844559 Exp La Paz','89870740458545731688124221354631726','HH',6.00,'m3',3.10,'despeje de la via para el recubrimiento','2014-06-17','21:37:28'),('57955382165410815230874254542880739','4789554 Exp La Paz','89870740458545731688124221354631726','HH',7.00,'m3',2.87,'DescripciÃ³n no almacenada','2014-06-17','21:38:22'),('62477816682354071496175007672843300','7844903 Exp La Paz','96367782363307395876037507801498575','HH',7.00,'m3',5.30,'cubrimiento de baches a maquina','2014-06-01','15:59:08'),('67992263077242658841298877140281706','7844559 Exp La Paz','89870740458545731688124221354631726','HH',6.00,'m3',1.89,'DescripciÃ³n no almacenada','2014-06-17','21:38:43'),('69704841654046231533545554209066642','3490554 Exp La Paz','96367782363307395876037507801498575','HH',7.00,'m3',3.20,'preparacion de ripiado','2014-06-21','17:49:52'),('70748595858117064285347578353581302','2898554 Exp La Paz','16312694610626839903110083018845809','HH',8.00,'km',2.30,'mantencion de la planicie del suelo','2014-05-25','19:13:28'),('70889899950833611625199306042843295','5099330 Exp La Paz','96711503938685541007417821736235783','HH',7.50,'km',1.20,'preparacion del suelo','2014-06-17','21:04:34'),('78776626251225612390351635099571104','5099330 Exp La Paz','96711503938685541007417821736235783','HH',7.50,'km',2.30,'nivelacion del suelo mediante despeje de la via','2014-06-17','21:03:19'),('81283447675677317914258486309067792','2904348 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',4.60,'cobertura de los suelos medante ripio','2014-06-10','10:36:02'),('82393058132294530354384598079366219','4789554 Exp La Paz','89870740458545731688124221354631726','HH',7.00,'m3',2.30,'recubrimiento del suelo','2014-06-17','21:37:07'),('82898247492796003375376568551070353','3900445 Exp La Paz','49564628690744821068807232619609093','HH',7.00,'m3',3.40,'aplanamiento del suelo','2014-06-17','22:07:18'),('85797240907484820747299395397455255','2898554 Exp La Paz','16312694610626839903110083018845809','HH',8.00,'km',1.00,'preparar el terreno en su totalidad','2014-05-25','19:52:23'),('88819781715956470940546639254145041','3988447 Exp La Paz','49564628690744821068807232619609093','HH',6.00,'m3',3.20,'excavacion del suelo','2014-06-17','22:07:05'),('90562974333282254987074690018745448','4893344 Exp La Paz','19497109988512141048033380556426065','HH',6.00,'m3',8.90,'nivelacion de canal','2014-06-16','18:01:52'),('93332749531614270389321261946274701','3389449 Exp La Paz','16312694610626839903110083018845809','HH',7.50,'km',1.00,'finalizacion de la preparacion','2014-05-25','19:56:02'),('97272609023091240525993093856248740','2904348 Exp La Paz','96367782363307395876037507801498575','HH',8.00,'m3',3.60,'rellenado de baches ','2014-06-01','15:52:55');
/*!40000 ALTER TABLE `informetrabajador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_maquinaria`
--

DROP TABLE IF EXISTS `item_maquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_maquinaria` (
  `nro` int(11) NOT NULL AUTO_INCREMENT,
  `IDmaquinaria` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`nro`),
  KEY `IDmaquinaria` (`IDmaquinaria`),
  CONSTRAINT `item_maquinaria_ibfk_1` FOREIGN KEY (`IDmaquinaria`) REFERENCES `maquinaria` (`IDmaquinaria`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_maquinaria`
--

LOCK TABLES `item_maquinaria` WRITE;
/*!40000 ALTER TABLE `item_maquinaria` DISABLE KEYS */;
INSERT INTO `item_maquinaria` VALUES (1,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-04-16','12:35:24'),(2,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-04-16','12:35:24'),(3,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-04-16','12:35:24'),(4,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-04-16','16:18:29'),(5,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-04-16','16:18:32'),(6,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-04-16','16:18:32'),(7,'olxp8omnybo7kyfsd4swnlsab7uhe74oqyn','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:43'),(8,'duikwxjjzz96yzj8y1eegfam6gruvo4usw3','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:47'),(9,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:50'),(10,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:50'),(11,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:50'),(12,'8dmifsp1brvr6wdydas141sv3coxk1efkj7','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:52'),(13,'hb1dn08omho6krtlvu30g261wnjxeb7npp4','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:37:57'),(14,'svv38vuj2v7jj2sb1nngi6bo4322cv3ijp4','Item correspondiente a la maquinaria','Alquilado','2014-04-19','16:38:00'),(15,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:35'),(16,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:35'),(17,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:35'),(18,'tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:37'),(19,'tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:37'),(20,'euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:40'),(21,'euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:40'),(22,'euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:40'),(23,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:42'),(24,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:42'),(25,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:42'),(26,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:42'),(27,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:44'),(28,'daxusj4txhyre2ga29p6qhk2noco437hm8c','Item correspondiente a la maquinaria','Alquilado','2014-05-10','21:17:44');
/*!40000 ALTER TABLE `item_maquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_material`
--

DROP TABLE IF EXISTS `item_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_material` (
  `nro` int(11) NOT NULL AUTO_INCREMENT,
  `IDmaterial` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`nro`),
  KEY `IDmaquinaria` (`IDmaterial`),
  CONSTRAINT `item_material_ibfk_1` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_material`
--

LOCK TABLES `item_material` WRITE;
/*!40000 ALTER TABLE `item_material` DISABLE KEYS */;
INSERT INTO `item_material` VALUES (1,'ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','Item correspondiente al material','Almacenado','2014-04-14','21:27:44'),(2,'ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','Item correspondiente al material','Almacenado','2014-04-14','21:27:44'),(3,'fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','Item correspondiente al material','Almacenado','2014-04-14','21:27:44'),(4,'fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','Item correspondiente al material','Almacenado','2014-04-14','21:27:44'),(5,'fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','Item correspondiente al material','Almacenado','2014-04-14','21:27:44'),(6,'7bfpke0vc3tdxu09psw6samitn32aidxez7','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(7,'7bfpke0vc3tdxu09psw6samitn32aidxez7','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(8,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(9,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(10,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(11,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(12,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(13,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(14,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(15,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(16,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(17,'rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(18,'xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(19,'xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(20,'xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(21,'xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(22,'xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','Item correspondiente al material','Almacenado','2014-04-16','16:06:59'),(23,'4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','Item correspondiente al material','Almacenado','2014-04-22','21:06:52'),(24,'4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','Item correspondiente al material','Almacenado','2014-04-22','21:06:52'),(25,'4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','Item correspondiente al material','Almacenado','2014-04-22','21:06:52'),(26,'ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla','Item correspondiente al material','Almacenado','2014-04-22','21:06:52'),(27,'ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla','Item correspondiente al material','Almacenado','2014-04-22','21:06:52'),(28,'1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','Item correspondiente al material','Almacenado','2014-04-22','21:06:53'),(29,'1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','Item correspondiente al material','Almacenado','2014-04-22','21:06:53'),(30,'1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','Item correspondiente al material','Almacenado','2014-04-22','21:06:53'),(31,'1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','Item correspondiente al material','Almacenado','2014-04-22','21:06:53'),(32,'1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','Item correspondiente al material','Almacenado','2014-04-22','21:06:53'),(33,'nw28w541ja2pix442xhtb4kk96rqeo99zy4','Item correspondiente al material','Almacenado','2014-04-25','19:31:22'),(34,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(35,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(36,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(37,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(38,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(39,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(40,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(41,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(42,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21'),(43,'o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','Item correspondiente al material','Almacenado','2014-04-26','18:58:21');
/*!40000 ALTER TABLE `item_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licitacion`
--

DROP TABLE IF EXISTS `licitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licitacion` (
  `IDlicitacion` varchar(40) NOT NULL,
  `descripcion` varchar(110) NOT NULL,
  PRIMARY KEY (`IDlicitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licitacion`
--

LOCK TABLES `licitacion` WRITE;
/*!40000 ALTER TABLE `licitacion` DISABLE KEYS */;
INSERT INTO `licitacion` VALUES ('L0000000000001','Licitacion publica nacional'),('L0000000000002','Licitacion local');
/*!40000 ALTER TABLE `licitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maquinaria`
--

DROP TABLE IF EXISTS `maquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maquinaria` (
  `IDmaquinaria` varchar(40) NOT NULL,
  `IDproveedor` varchar(30) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `marca` varchar(40) NOT NULL,
  `modelo` varchar(20) DEFAULT NULL,
  `nroplaca` varchar(20) DEFAULT NULL,
  `potencia` varchar(20) NOT NULL,
  `precio_elemental` decimal(10,2) NOT NULL,
  `cantidad_disponible` int(11) DEFAULT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDmaquinaria`),
  UNIQUE KEY `descripcion` (`descripcion`),
  UNIQUE KEY `nroplaca` (`nroplaca`),
  KEY `IDproveedor` (`IDproveedor`),
  KEY `IDproveedor_2` (`IDproveedor`),
  CONSTRAINT `maquinaria_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maquinaria`
--

LOCK TABLES `maquinaria` WRITE;
/*!40000 ALTER TABLE `maquinaria` DISABLE KEYS */;
INSERT INTO `maquinaria` VALUES ('6fwfdr5uikjuwoqm2dey8ji75los08mo1lw','adzkshnx71smkfrxyygkz21s5iy11w','Camion volquete a gasolina <= 5m3','HM','caterpillar','G12','6788EFD','250 HP',80.00,0,'2014-06-17','15:55:15'),('8dmifsp1brvr6wdydas141sv3coxk1efkj7','adzkshnx71smkfrxyygkz21s5iy11w','tractor oruga con cuchilla','HM','caterpillar','DF4','FR90422','200 HP',565.00,0,'2014-04-19','16:27:44'),('daxusj4txhyre2ga29p6qhk2noco437hm8c','adzkshnx71smkfrxyygkz21s5iy11w','motonivaledora >=125 HP','HM','HUBER','F11500M','FG252572','125 HP',350.00,0,'2014-03-29','17:47:36'),('dg07ngp1xhjp5qke9e9yds20845sdlz54rj','adzkshnx71smkfrxyygkz21s5iy11w','tractor oruga tipo D-8','HM','caterpillar','D8F','3M18934','200 HP',560.00,0,'2014-04-16','15:15:36'),('duikwxjjzz96yzj8y1eegfam6gruvo4usw3','adzkshnx71smkfrxyygkz21s5iy11w','excavadora','HM','caterpillar','1994','4567GH','100 HP',230.00,0,'2014-04-19','16:22:30'),('euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc','adzkshnx71smkfrxyygkz21s5iy11w','Camion volquete a diesel <=8m3','HM','volvo','F12','2325 DBR','130 HP',118.00,0,'2014-05-09','11:53:54'),('hb1dn08omho6krtlvu30g261wnjxeb7npp4','adzkshnx71smkfrxyygkz21s5iy11w','cargador frontal 3 m3','HM','caterpillar','950 60','75A51354','123 HP',290.00,0,'2014-04-19','16:13:14'),('jix120pvz3l8zn6qdq0frvwl9k83d439w3p','adzkshnx71smkfrxyygkz21s5iy11w','Rodillo compactador','HM','john deere','1995','RD345','123 HP',230.15,0,'2014-04-19','16:25:17'),('lipw46tvcfj1vk619kg9qf204ykj3am4t6i','adzkshnx71smkfrxyygkz21s5iy11w','compresora de campo ','HM','case','602BD','84403484','sin potencia',224.00,0,'2014-04-16','15:21:27'),('olxp8omnybo7kyfsd4swnlsab7uhe74oqyn','adzkshnx71smkfrxyygkz21s5iy11w','Bomba de agua de 2 a 6 plg','HM','Honda','','','5.5. HP',15.00,0,'2014-04-19','16:10:49'),('svv38vuj2v7jj2sb1nngi6bo4322cv3ijp4','adzkshnx71smkfrxyygkz21s5iy11w','camioneta 4X4','HM','chevrolet','LUV','1472ULX','sin potencia de trab',70.00,0,'2014-04-16','15:48:53'),('tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','adzkshnx71smkfrxyygkz21s5iy11w','tractor tipo D-4 <=125HP','HM','caterpillar','D6D','94N7204','120 HP',250.00,0,'2014-03-30','19:37:13'),('vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','adzkshnx71smkfrxyygkz21s5iy11w','retroexcavadora>95 HP','HM','jhon deere','1994','58FGH90','140 HP',225.00,0,'2014-04-08','10:24:47'),('wtnshv5x39e6ssc65np5pxfddfjqiaqhcit','adzkshnx71smkfrxyygkz21s5iy11w','camion tractor','HM','caterpillar','2000','45FG67','200 HP',180.00,0,'2014-04-16','15:30:32'),('x4pjty363awicp5gxjy8cm6czxepw96emqi','adzkshnx71smkfrxyygkz21s5iy11w','calentador de asfaltos','HM','john deere','D5G','SIN NRO DE PLACA','130 HP',55.00,0,'2014-04-16','15:14:05'),('yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','adzkshnx71smkfrxyygkz21s5iy11w','cargador frontal PQ <= 100HP','HM','Caterpillar','950 C','381B28901B46','180 HP',280.00,0,'2014-03-28','20:49:41'),('yiet3tms7sl4oxq92o7frvo1ah5lmu04cb3','adzkshnx71smkfrxyygkz21s5iy11w','mezcladora de hormigon','HM','john deere','7RB','SIN PLACA','140 HP',37.00,0,'2014-04-16','15:24:28');
/*!40000 ALTER TABLE `maquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material` (
  `IDmaterial` varchar(40) NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `precio_bs` decimal(10,2) NOT NULL,
  `cant_disponible` decimal(10,2) DEFAULT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDmaterial`),
  KEY `IDproveedor` (`IDproveedor`),
  CONSTRAINT `material_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES ('1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q','adzkshnx71smkfrxyygkz21s5iy11w','mezcla asfaltica para bacheo en caliente','M3',1250.00,12.00,'2014-03-28','21:23:27'),('361m8280lw5ls15bwimv6bktkkjdj6zk2xc','adzkshnx71smkfrxyygkz21s5iy11w','dinamita','PZA',3.94,8.00,'2014-03-30','19:34:02'),('4zg2g185hgr1zpxjb9uj94gtkqg6r3sx0hx','adzkshnx71smkfrxyygkz21s5iy11w','gabion para proteccion contra derrumbes','PZA',40.28,0.00,'2014-03-30','19:35:20'),('5531k9wflwuowfjyobb2exgjiwzb6xvh805','adzkshnx71smkfrxyygkz21s5iy11w','arena zarandeada','M3',120.00,100.00,'2014-04-14','16:21:52'),('7bfpke0vc3tdxu09psw6samitn32aidxez7','adzkshnx71smkfrxyygkz21s5iy11w','cordon detonante','MI',5.21,0.00,'2014-04-14','16:20:03'),('9cvvffh2tpv2fwwb3c83r2f1wgpyfgm85zg','adzkshnx71smkfrxyygkz21s5iy11w','asfalto diluido RC-800','LT',15.50,0.00,'2014-03-30','19:30:44'),('d06l6p3qe58mn2549q88i9aa3mvhi0hmmkr','adzkshnx71smkfrxyygkz21s5iy11w','clavos','KG',11.00,0.00,'2014-04-16','15:10:40'),('fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb','adzkshnx71smkfrxyygkz21s5iy11w','cemento asfaltico calentado','LT',10.73,10.00,'2014-03-30','19:31:16'),('g8p7eirobi9lcw0ej9597ck6nbh4xram0e9','adzkshnx71smkfrxyygkz21s5iy11w','gasolina para vehiculos','LT',4.46,0.00,'2014-04-08','10:11:26'),('j4yso9za1t2bxck07gkpfob0243en6vrno2','adzkshnx71smkfrxyygkz21s5iy11w','cemento alta resistencia 50 kg','BLS`',60.00,0.00,'2014-06-17','15:49:22'),('k74kl6913j2holqhjd5wph1hyzs4e6t6v8m','adzkshnx71smkfrxyygkz21s5iy11w','alambra de amarre','KG',11.00,0.00,'2014-03-30','19:34:20'),('lg4k7f9e01ybomelbshd5lb1r9kvht5rh56','adzkshnx71smkfrxyygkz21s5iy11w','Alambra galbanizado','KG',22.00,80.00,'2014-05-13','10:49:54'),('ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7','adzkshnx71smkfrxyygkz21s5iy11w','cemento 50 kg','BLS',10.73,25.00,'2014-03-30','19:31:54'),('nw28w541ja2pix442xhtb4kk96rqeo99zy4','adzkshnx71smkfrxyygkz21s5iy11w','Ripio acopioado','M3',25.62,23.00,'2014-04-25','19:16:08'),('o2zznd6leyij7r9rbuopr50fbt38qgbpyv4','adzkshnx71smkfrxyygkz21s5iy11w','agua','M3',20.00,50.00,'2014-03-30','19:31:32'),('oubwb8s3nts4xep8v14kn87e3butwngchx4','adzkshnx71smkfrxyygkz21s5iy11w','madera de construccion','PZA',4.50,132.00,'2014-04-16','15:09:34'),('pqhegpg1cpgkasr80x01edvu2itr8a0jvsn','adzkshnx71smkfrxyygkz21s5iy11w','grava sin sobre tamanio procesada','M3',75.00,8.00,'2014-04-14','16:21:12'),('ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla','adzkshnx71smkfrxyygkz21s5iy11w','piedra en bruto grande para bateones','PZA',1320.00,300.00,'2014-04-16','15:10:15'),('rgtc83e2kfpfbj9y4wxr0ts7i24j5m6fgpw','adzkshnx71smkfrxyygkz21s5iy11w','postes metalicos para barandados','PZA',1320.00,0.00,'2014-04-16','15:08:44'),('snmevq7djfybgg4lpl2vag2agjof7wdozf8','oi3v9ze13s94pja6l0fd719zubin69y1j0n','ladrillos','PZA',8.00,10.00,'2014-04-16','15:45:05'),('vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi','adzkshnx71smkfrxyygkz21s5iy11w','mezcla asfaltica para bacheo en frio','M3',1250.00,84.00,'2014-04-14','16:20:32'),('xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6','adzkshnx71smkfrxyygkz21s5iy11w','mallas para gaviones','PZA',247.00,400.00,'2014-04-16','15:08:22'),('zflgqa3ovhs8d8ns9x6990fcrft4ud4mibr','adzkshnx71smkfrxyygkz21s5iy11w','diesel','LT',4.46,0.00,'2014-04-14','16:22:15');
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `IDmenu` int(11) NOT NULL AUTO_INCREMENT,
  `nombreMenu` varchar(40) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDmenu`),
  UNIQUE KEY `nombreMenu` (`nombreMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'ADMIN','modulo general de seguridad y accesos del sistema ','2014-11-14','20:00:00'),(2,'PLANIFICACION ','modulo de planificacion de acciones para ejecutar proyectos','2014-11-14','20:00:00'),(3,'PERSONAL','modulo de control de recursos humanos','2014-11-14','20:00:00'),(4,'COMPRA DE RECURSOS','modulo de control de compra y alquiler de items para obras civiles','2014-11-14','20:00:00'),(5,'MANTENIMIENTO DE MAQUINARIA','modulo de control y reparacion de maquinaria','2014-11-14','20:00:00'),(6,'REPORTES','modulo de informes, graficos','2014-11-14','20:00:00'),(7,'CUSTOM MODULE','modulo de pruebas','2014-03-01','22:35:21'),(8,'ARCHIVOS','Modulo de gestion de archivos','2014-04-02','10:46:48'),(9,'EJECUCION','Modulo de ejecucion de obras civiles','2014-04-19','20:01:22'),(10,'SEGUIMIENTO','Modulo de control y seguimiento de proyectos','2014-04-19','20:02:56'),(12,'ALMACEN','Control de logistica de ingresos de items y salidas','2014-04-29','21:17:07'),(13,'CONTROL Y SEGUIMIENTO','modulo de control y seguimiento de proyectos carreteros','2014-04-30','09:47:48');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nota_remision`
--

DROP TABLE IF EXISTS `nota_remision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota_remision` (
  `nro_nota` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  `nro_pedido` varchar(40) NOT NULL,
  PRIMARY KEY (`nro_nota`),
  KEY `IDproveedor` (`IDproveedor`),
  KEY `nro_pedido` (`nro_pedido`),
  CONSTRAINT `nota_remision_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`),
  CONSTRAINT `nota_remision_ibfk_2` FOREIGN KEY (`nro_pedido`) REFERENCES `pedido_material` (`nro_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nota_remision`
--

LOCK TABLES `nota_remision` WRITE;
/*!40000 ALTER TABLE `nota_remision` DISABLE KEYS */;
INSERT INTO `nota_remision` VALUES ('33977363365430869628560971923087278','2014-04-25','adzkshnx71smkfrxyygkz21s5iy11w','37960840319462444728829944819044178'),('41733862830238765600981985906183904','2014-04-12','adzkshnx71smkfrxyygkz21s5iy11w','25818581517554202819675204711280562'),('48722279977794650448100846325873008','2014-04-22','adzkshnx71smkfrxyygkz21s5iy11w','65032236537741835733376758629634700'),('61154084666090303624914761065355838','2014-04-26','adzkshnx71smkfrxyygkz21s5iy11w','77013133346094360660772096884009274'),('76635712627903257095446220638001059','2014-06-17','adzkshnx71smkfrxyygkz21s5iy11w','09939918128376401038510998193170808'),('77964605968543614235469294118061933','2014-04-16','adzkshnx71smkfrxyygkz21s5iy11w','30877429526189633009838089440086877'),('88607542037414947970227710801281062','2014-06-17','adzkshnx71smkfrxyygkz21s5iy11w','93468358483733567751492971021847415');
/*!40000 ALTER TABLE `nota_remision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcion`
--

DROP TABLE IF EXISTS `opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcion` (
  `IDopcion` int(11) NOT NULL AUTO_INCREMENT,
  `IDsubMenu` int(11) NOT NULL,
  `nombreOpcion` varchar(60) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `url` varchar(60) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDopcion`),
  KEY `IDsubMenu` (`IDsubMenu`),
  CONSTRAINT `opcion_ibfk_1` FOREIGN KEY (`IDsubMenu`) REFERENCES `submenu` (`IDsubMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcion`
--

LOCK TABLES `opcion` WRITE;
/*!40000 ALTER TABLE `opcion` DISABLE KEYS */;
INSERT INTO `opcion` VALUES (1,1,'REGISTRO DE USUARIOS','control de registro de usuarios en el sistema','userlist.php','activo','2014-11-18','19:20:10'),(2,2,'REGISTRO DE ROLES','control de registro de roles','rolelist.php','activo','2014-11-18','19:20:10'),(3,3,'REGISTRO DE PUBLICACIONES','opcion de registro de publicaciones de proyectos','pubproyectos.php','activo','2014-11-18','19:20:10'),(4,4,'LOG DE SESIONES','registro de sesiones de los usuarios','sessionlog.php','activo','2014-11-18','19:20:10'),(6,6,'REGISTRO DE PROYECTOS','control de registro de proyectos de carreteras','logproyectos.php','activo','2014-11-18','19:20:10'),(7,7,'REGISTRO DE MANO DE OBRA','opcion de registro de empleados de obras civiles','manoobra.php','activo','2014-11-18','19:20:10'),(8,8,'REGISTRO DE REQUERIMIENTOS','registro de cheque de requerimientos para proyectos','req.php','activo','2014-11-18','19:20:10'),(9,9,'REGISTRO DE ACTIVIDADES','opcion de control de actividades por tramo de un proyecto','formActividad.php','activo','2014-11-18','19:20:10'),(10,10,'REGISTRO DE TRAMOS','opcion de registro de tramos carreteros para proyectos','listatramos.php','activo','2014-11-18','19:20:10'),(11,11,'REGISTRO DE CARGOS DE MANO DE OBRA','control de cargos de mano de obra','cmanoobra.php','activo','2014-11-18','19:20:10'),(12,12,'REGISTRO DE ENCARGADOS DE MANO DE OBRA','control de encargados que ofrecen mano de obra civil','encmanoobra.php','activo','2014-11-18','19:20:10'),(13,13,'DESIGNACION DE PERSONAL TECNICO','control de designacion de empleados para proyectos de carreteras','proyectos.php','activo','2014-11-18','19:20:10'),(14,14,'REGISTRO DE ROLES DE PARTICIPACION','','rolepartlist.php','inactivo','2014-11-18','19:20:10'),(15,15,'REGISTRO DE RECEPCIONES','control de recepciones de empleados de mano de obra','recepcionlist.php','activo','2014-11-18','19:20:10'),(16,16,'PRECIOS UNITARIOS ','control de precios unitarios por item de trabajo de obras civiles','precunitarios.php','activo','2014-11-18','19:20:10'),(18,17,'REGISTRO DE EMPLEADOS','control de los empleados que trabajan en la empresa','userEmpleado.php','activo','2014-11-18','19:20:10'),(19,18,'REGISTRO DE DEPARTAMENTOS','registro de los departamentos de la empresa','listdept.php','activo','2014-11-18','19:20:10'),(20,19,'REGISTRO DE CARGOS','registro de los cargos correspondientes a la empresa','listcargos.php','activo','2014-11-18','19:20:10'),(21,20,'REGISTRO DE ACTIVIDADES LABORALES','control de actividades laborales de cada empleado','listactividades.php','activo','2014-11-18','19:20:10'),(22,21,'REGISTRO DE PEDIDO DE ITEMS','control de solicitud de items para obras civiles','solicituditems.php','activo','2014-11-18','19:20:10'),(23,22,'REGISTRO DE PROVEEDORES','','listprov.php','activo','2014-11-18','19:20:10'),(24,23,'REGISTRO DE MATERIALES','','formMateriales.php','activo','2014-11-18','19:20:10'),(25,24,'REGISTRO DE MAQUINARIA','','FormEquipos.php','activo','2014-11-18','19:20:10'),(26,25,'REGISTRO DE SUMINISTROS','','listsuministro.php','activo','2014-11-18','19:20:10'),(27,26,'REGISTRO DE MAQUINARIA EN REPARACION','','maqreparacion.php','activo','2014-11-18','19:20:10'),(28,27,'REGISTRO DE REPARACIONES','','listreparacion.php','activo','2014-11-18','19:20:10'),(29,28,'REPORTE POR FECHA DE SESION','reporte de sesiones de usuarios por fecha','enviaRepSesion.php','activo','2014-11-18','19:20:10'),(30,29,'REPORTE POR PROYECTO','Informe correspondiente a los trabajos realizados por proyecto','repproyecto.php','activo','2014-11-18','19:20:10'),(51,34,'LOG DE AUDITORIA','control detallado de las acciones de los usuarios dentro del sistema','auditoria.php','activo','2014-11-18','19:20:10'),(52,32,'CONTADOR DE ACCESOS','control de cantidad de accesos por sesion de usuario','contAccesos.php','activo','2014-11-18','19:20:10'),(53,31,'REPORTE POR EMPLEADO','','repempleado.php','activo','2014-11-18','19:20:10'),(54,33,'GRAFICO DE PROYECTO','','graphproyecto.php','activo','2014-11-18','19:20:10'),(55,35,'GESTION DE MODULOS','control de modulos del sistema','menuList.php','activo','2014-11-18','19:20:10'),(56,36,'REPORTE DE COMPRA Y ALQUILER','','repComAlq.php','activo','2014-11-18','19:20:10'),(57,37,'REPORTE DE CANTIDAD DE ACCESOS POR MES','reporte grafico de la cantidad de accesos por sesion de usuario','enviaGrafico.php','activo','2014-11-18','19:20:10'),(58,38,'CONTROL DE ASISTENCIA','','asistencia.php','activo','2014-11-18','19:20:10'),(59,39,'REGISTRO DE PERMISOS','','permEmpleado.php','activo','2014-11-18','19:20:10'),(60,32,'REGISTRO DE DATOS PERSONALIZADOS','control de datos personalizados','example.php','inactivo','2014-03-03','21:11:21'),(61,32,'CUSTOM OPTION','opcion personalizada','example1.gif','inactivo','2014-03-03','21:48:48'),(62,43,'REGISTRO DE DATOS ARCHIVADOS','control de datos eliminados','example1.php','activo','2014-03-09','15:00:51'),(63,44,'PLANILLA SALARIAL','Control y registro de planillas salariales','planilla.php','activo','2014-03-11','10:20:53'),(64,45,'NUEVO EMPLEADO','Formulario de registro de nuevos empleados','nuevoempleado.php','activo','2014-03-11','11:36:50'),(65,46,'REGISTRO DE PROFESIONES','Listado de profesiones de la empresa','listProfesion.php','activo','2014-03-13','12:18:07'),(66,48,'REGISTRO DE FASES','Formulario de registro de fases para un proyecto','formFase.php','activo','2014-03-21','16:55:18'),(67,49,'REGISTRO DE SUBFASES','Formulario para el registro de subfases de un proyecto','formSubfase.php','activo','2014-03-21','16:56:59'),(68,50,'FORMULARIO DE SOLICITUD','Formulario de solicitud de mano de obra','formSolicitud.php','activo','2014-03-21','17:05:43'),(69,51,'REGISTRO DE MENSAJES DE AYUDA','Listado de mensajes de ayuda por opcion y por subpermiso','listAyuda.php','activo','2014-03-21','17:22:04'),(70,50,'LISTADO DE SOLICITUDES','Listado de solicitudes de cargos de mano de obra','listSolicitud.php','activo','2014-03-22','21:07:32'),(71,52,'REPORTE DE SOLICITUD DE MANO DE OBRA','Informa de solicitudes de mano de obra para proyectos','envRepSolManoobra.php','inactivo','2014-03-23','21:28:22'),(72,53,'CONTRATACION EN PROYECTO','Registrar asignacion de trabajadores a proyecto','procContrato.php','activo','2014-03-24','09:55:25'),(73,54,'DEFINICION DE CALENDARIO DE FERIADOS','Definicion de calendario de trabajos','calendarioFeriado.php','activo','2014-03-25','20:29:10'),(74,55,'CONTROL DE MAQUINARIA','Registro de toda la informacion correspondiente a maquinaria y equipo pesado','listMaquinaria.php','activo','2014-03-28','18:38:06'),(75,56,'CONTROL DE MATERIALES','Registro de toda la informacion correspondiente a materiales de obras y construcciones civiles','listMaterial.php','activo','2014-03-28','18:38:47'),(76,57,'CONTROL DE PARAMETROS','Registro de parametros con sus respectivos valores','listParametros.php','activo','2014-03-29','18:43:32'),(77,58,'NUEVO PARAMETRO','Formulario para el registro de parametros de calculo','formParametro.php','activo','2014-03-29','20:26:38'),(78,21,'FORMULARIO DE SOLICITUD DE MAQUINARIA','Formuliario para realizar el registro de solicitud de items para incorportar a proyectos civiles','formSolicitudItem.php','activo','2014-03-30','19:49:20'),(79,29,'REPORTE DE ACTIVIDADES','Reporte de actividades','envRepSolM.php','activo','2014-03-31','10:48:50'),(80,59,'SOLICITUDES DE ITEMS','Reporte de solicitudes atenditas de items','envRepSolItems.php','inactivo','2014-03-31','11:05:54'),(81,60,'REPORTE SOLICITUD MANO DE OBRA','Reporte de solicitudes procesadas de mano de obra','envRepSolMPr.php','activo','2014-03-31','11:07:14'),(82,61,'REGISTRO DE ENTRADAS','Control de ingreso de items solicitados por la empresa','entalmacen.php','activo','2014-03-31','21:00:19'),(83,62,'SOLICITUD DE COTIZACIONES','Control de cotizacion de materiales ofertados','cotizacionMat.php','activo','2014-03-31','21:05:36'),(84,62,'COTIZACIONES APROBADAS','Listado de cotizaciones aprobadas de items para pedido','cotizacionAprobada.php','activo','2014-04-01','13:09:49'),(85,63,'LISTADO DE ARCHIVOS','Listado de archivos segun los permisos de acceso','listArchivos.php','activo','2014-04-02','10:47:55'),(86,64,'NUEVO MENSAJE DE CORREO','Esta opcion se encarga de realizar envio y recepcion de mensajes de correo electronico usando gmail.com','formMessage.php','activo','2014-04-04','11:19:17'),(87,65,'PEDIDO DE MATERIALES','Control de solicitud de pedidos para materiales aprobados por gerencia tecnica','pedido.php','activo','2014-04-05','17:03:12'),(88,66,'CONSULTAR SOLICITUD','Listado de solicitudes de maquinaria y equipos','solicitudMaq.php','activo','2014-04-07','09:38:36'),(89,62,'REGISTRO DE COTIZACION','Control de registro de cotizaciones','formCotizacion.php','activo','2014-04-11','14:55:17'),(90,67,'FORMULARIO DE NOTAS DE REMISIÃ“N','Formulario de registro de notas de remision de pedido de materiales','NotaRemision.php','activo','2014-04-11','14:56:52'),(91,68,'REPORTE DE COTIZACIONES DE MATERIALES','Reportes que describen los registro de cotizaciones de materiales','envRepCot.php','activo','2014-04-11','18:07:04'),(92,69,'CANTIDAD DE MATERIALES ALMACENADOS','Reporte que describe la cantidad de items adquiridos por la empresa','envRitems.php','activo','2014-04-14','16:08:49'),(93,70,'REGISTRO DE PLANIFICACIONES','Control y registro de etapas de planificacion para proyectos','Planificacion.php','activo','2014-04-15','14:58:15'),(94,71,'CONTROL DE ASIGNACION','registro de asignaciones de actividades para un determinado proyecto','formAsignacion.php','activo','2014-04-16','15:04:44'),(95,72,'LISTADO DE PLANIFICACIONES','Control de planificaciones para la finalizacion','finPlan.php','activo','2014-04-19','16:53:42'),(96,73,'CONTROL DE AVANCES','Opcion de control de avances','avance.php','activo','2014-04-19','20:04:39'),(97,74,'REGISTRO DE SEGUIMIENTO','Opcion encargada de controlar el progreso de avance de las obras segun duraciones','seguimiento.php','activo','2014-04-19','20:05:50'),(98,29,'REPORTE DE AVANCE DE ACTIVIDADES','Reporte grafico del progreso de avance de actividades','Avance.php','activo','2014-04-19','20:08:31'),(99,75,'REGISTRO DE INCORPORACION','Control de incorporacion de items materiales y maquinaria al proyecto civil','incorporacion.php','activo','2014-04-19','20:20:26'),(100,76,'LISTADO DE COMPRA','Control de detalle de cotizaciÃ³n para planificar compras','listCompra.php','activo','2014-04-21','20:30:22'),(101,77,'REPORTE DE COMPRAS POR FECHA','Reporte de compras planificadas por mes','envRepcompra.php','activo','2014-04-21','22:08:33'),(102,78,'REGISTRO DE CALENDARIO','Control de calendario de trabajo de los trabajadores participantes en proyecto','calendariotrabajador.php','activo','2014-04-24','15:40:09'),(103,73,'REGISTRO DE AVANCES','Registro de avance de ejecuciones de actividades','regejecucion.php','activo','2014-04-26','21:53:33'),(104,80,'REPORTE DE PRECIOS UNITARIOS','Reporte de precios unitarios por actividad de fase','envgrprecio.php','activo','2014-04-29','16:05:53'),(105,81,'REGISTRO DE SEGUIMIENTOS','Control de registro de avances por fase, actividad de proyectos','listseguimiento.php','activo','2014-04-30','09:50:15'),(106,82,'PEDIDO A ALMACEN','Pedido de items registrados en almacen para las actividades del proyecto','pedidoalmacen.php','activo','2014-05-09','12:00:19'),(107,82,'SOLICITUDES DE PEDIDOS','Solicitud de pedido para proyectos','solPedidoAlmacen.php','activo','2014-05-09','19:24:44');
/*!40000 ALTER TABLE `opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagina_opcion`
--

DROP TABLE IF EXISTS `pagina_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagina_opcion` (
  `IDpagina` int(11) NOT NULL AUTO_INCREMENT,
  `IDopcion` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `url` varchar(60) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDpagina`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `IDopcion` (`IDopcion`),
  CONSTRAINT `pagina_opcion_ibfk_1` FOREIGN KEY (`IDopcion`) REFERENCES `opcion` (`IDopcion`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagina_opcion`
--

LOCK TABLES `pagina_opcion` WRITE;
/*!40000 ALTER TABLE `pagina_opcion` DISABLE KEYS */;
INSERT INTO `pagina_opcion` VALUES (1,1,'NUEVO USUARIO','formulario de registro de nuevos usuarios','nuevousuario.php','2013-11-12','15:09:10'),(2,1,'EDITAR SU CUENTA DE USUARIO','','vercuenta.php','2014-03-11','09:10:31'),(3,18,'INFORMACION LABORAL DE EMPLEADOS','','listEmpleados.php','2014-03-11','09:10:31'),(4,18,'NUEVO EMPLEADO','Registro de nuevos empleados','nuevoempleado.php','2014-03-11','09:10:31'),(5,59,'VER REGISTRO DE CONTROL DE PERMISOS','','controlPermiso.php','2014-03-11','09:10:31'),(6,58,'FORMULARIO DE CONTROL DE ASISTENCIA','','formAsistencia.php','2014-03-11','09:10:31'),(7,55,'CREAR NUEVO MODULO','','nuevoModulo.php','2014-03-11','09:10:31'),(8,2,'NUEVO ROL','fornulario de creacion de nuevos roles del sistema','nuevoRol.php','2013-11-21','20:20:16'),(9,3,'FORMULARIO DE PUBLICACION','formulario que permite realizar la publicación de proyectos','formPublicacion.php','2014-03-04','20:05:39'),(10,6,'FORMULARIO DE REGISTRO DE PROYECTOS','formulario que permite realizar el registro de proyectos de carreteras','formProyecto.php','2014-03-04','20:09:09'),(11,6,'REGISTRO DE CONTRATOS','registro del contrato de proyectos','contrato.php','2014-03-04','20:13:13'),(12,20,'NUEVO CARGO','Formulario de creacion de nuevos cargos','nuevoCargo.php','2014-03-11','17:35:40'),(13,19,'NUEVO DEPARTAMENTO','Formulario de creaciÃ³n de nuevos departamentos','nuevodepto.php','2014-03-11','17:36:19'),(14,65,'NUEVA PROFESION','Formulario de registro de profesiones','nuevaProfesion.php','2014-03-13','12:20:15'),(15,11,'NUEVO CARGO DE MANO DE OBRA','Formulario de registro de cargos de mano de obra para proyectos civiles','nuevoCargoM.php','2014-03-15','12:10:11'),(16,7,'NUEVOS TRABAJADORES','Formulario de regsitro de trabajadores de mano de obra','nuevoTrabajador.php','2014-03-15','21:02:34'),(17,12,'INFORMACION DE ENCARGADO','Listado con la informacion detallada de encargados de mano de obra','verInfoEnc.php','2014-03-17','14:45:15'),(18,23,'INFORMACION DE PROVEEDOR','Listado con la informacion especifica de proveedores','verInfoProv.php','2014-03-17','14:46:49'),(19,13,'REGISTRO DE PERSONAL TECNICO CLAVE','Listado de personal de recursos humanos participante en proyectos','viewPersonalTecnico.php','2014-03-18','11:12:26'),(20,71,'REPORTE DE SOLICITUDES POR FECHA','Reporte de solicitudes de mano de obra por fecha','envRepSolFecha.php','2014-03-23','21:29:01'),(21,30,'INFORME DE ACTIVIDADES','Informe de progreso de actividades','envInfoActividad.php','2014-03-31','11:08:56');
/*!40000 ALTER TABLE `pagina_opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago` (
  `IDpago` varchar(25) NOT NULL,
  `descripcion` varchar(35) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `montoTotal` decimal(10,2) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `fechaPago` date NOT NULL,
  PRIMARY KEY (`IDpago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametro`
--

DROP TABLE IF EXISTS `parametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametro` (
  `IDparametro` varchar(40) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDparametro`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametro`
--

LOCK TABLES `parametro` WRITE;
/*!40000 ALTER TABLE `parametro` DISABLE KEYS */;
INSERT INTO `parametro` VALUES ('35t0fjgngnxfhsewsljxhqmn0w0vo42boad','Impuesto iva por uso de mano de obra',14.94,'2014-03-30','16:53:28'),('4da1heyldwuwk8mf0k4xm9iyz8lyomvgwgc','Impuesto del total de mano de obra para uso de herramientas',5.00,'2014-03-30','15:09:20'),('5l97d5pwm6j9qa99ywasnrtz3c2q4xhqt4e','carga social de subtotal mano de obra',60.00,'2014-03-29','20:19:50'),('8fqkpd10jlkiq0d92ewqimg1t5xv5c1j5k9','Impuesto de actividad',3.09,'2014-04-15','21:31:24'),('my9hnew01c07chn2w3i1u94jcid8jmayc93','AFP',12.74,'2014-06-14','18:26:51');
/*!40000 ALTER TABLE `parametro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participa`
--

DROP TABLE IF EXISTS `participa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participa` (
  `IDcontrato` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `CI_trabajador` varchar(30) NOT NULL,
  `estado_contratacion` varchar(30) NOT NULL,
  `asignado_actividad` varchar(10) NOT NULL,
  `fechaContratacion` date NOT NULL,
  `hraContratacion` time NOT NULL,
  PRIMARY KEY (`IDcontrato`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `CI_trabajador` (`CI_trabajador`),
  KEY `IDplanificacion` (`IDplanificacion`),
  KEY `IDplanificacion_2` (`IDplanificacion`),
  CONSTRAINT `participa_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`),
  CONSTRAINT `participa_ibfk_2` FOREIGN KEY (`CI_trabajador`) REFERENCES `personalmanoobra` (`CI_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participa`
--

LOCK TABLES `participa` WRITE;
/*!40000 ALTER TABLE `participa` DISABLE KEYS */;
INSERT INTO `participa` VALUES ('17qkw9iv320k6at44gz4nk92xml3og46gz4','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5788445 Exp La Paz','Contratado','no','2014-04-26','21:01:07'),('18ed2kq45brdnk7uhcerylhmmf9rpe6g1xh','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4895544 Exp La Paz','Contratado','si','2014-04-19','23:15:58'),('1ai350bsu1ygtu9gpsvogul4vhbj4wro9c8','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2904348 Exp La Paz','Contratado','si','2014-04-28','15:36:43'),('22szav9cse0dlw824oeksrvbvbvnfjw0a6s','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','6909334 Ex La Paz','Contratado','no','2014-04-26','17:11:31'),('24g208k1rpow9t6quamcav4ydctl1c8q7bn','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','8944983 Exp La Paz','Contratado','no','2014-05-25','17:09:48'),('4t5thhek02xhexfb50hiuj46alpl2gegacl','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4995580 Exp La Paz','Contratado','no','2014-04-19','23:16:21'),('53j68t12qanewpveoxaghfv6gyhwavjpbex','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3389449 Exp La Paz','Contratado','no','2014-05-25','17:09:33'),('5cmcyzb8lmkttbemyydza1hj0j6x4dq6r06','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5333945 Exp La Paz','Contratado','no','2014-05-25','17:08:51'),('60vx1tr079tlgg843uwtmkhti8xnvn30hmy','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','59333403 Exp La Paz','Contratado','no','2014-04-19','23:03:09'),('7eis0r1ygftsh8cr37lgdk56ha6uebigjz8','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2344339 Exp La Paz','Contratado','no','2014-05-25','17:09:19'),('87iys1e9ogzwhqp6crtyk5r30s6njewnjt1','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3988447 Exp La Paz','Contratado','si','2014-05-25','17:08:47'),('8iuy43vhw26ch24bc2airr33seppma4g1di','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','6899448 Exp La Paz','Contratado','no','2014-05-25','17:09:04'),('9qmb71j31y7o400iss6vfkkg1rbqwqax0bs','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','7844389 Exp La Paz','Contratado','no','2014-06-15','20:12:12'),('9sh0zlv5cl03iwyysx8ip5dl19ewcwn06dv','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','7844903 Exp La Paz','Contratado','si','2014-04-19','23:02:54'),('aqerw5z6scwck9ai2a0jivk4526myy47yss','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4893344 Exp La Paz','Contratado','si','2014-04-28','15:34:53'),('awfdb1ixnsdse81gv1k965thi0vfldsz07z','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','6899334 Exp La Paz','Contratado','no','2014-05-25','17:09:02'),('bmts5m637om3cyjsufgfnlyx8j9senww3hl','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2898554 Exp La Paz','Contratado','no','2014-04-28','15:34:49'),('c0v34r8dicb7ouocqb5gi79pkmd4qz55wpl','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4789554 Exp La Paz','Contratado','si','2014-05-25','17:08:50'),('d3ctivpbeqj253zbcpf3dyhqvr71mmv01ac','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5789338 Exp La Paz','Contratado','no','2014-05-25','17:09:37'),('ee46kdlp0n5dlccr6hursf5m0z3kic1ofby','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3490554 Exp La Paz','Contratado','si','2014-04-26','21:01:10'),('f38t0ewfny0n9q9zyie1t4ryvn7aengvba4','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5733894 Exp La Paz','Contratado','no','2014-05-25','17:08:53'),('fbh6r3qrgyrlolqmz0b02cadt19z17jrwa7','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','8559049 Exp La Paz','Contratado','no','2014-05-25','17:09:06'),('g032u3jd4gv91il7ii0ytrakbqw7ikkpd4f','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2088344 Exp La Paz','Contratado','si','2014-05-25','17:08:45'),('gr03te830ils1ufdbymnnsdd0najhrral9g','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5894448 Exp La Paz','Contratado','no','2014-05-25','17:09:38'),('h3vat71ilb6aseul3wrdzfe3ijqlsqoz1v7','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','8933449 Exp La Paz','Contratado','si','2014-05-25','17:09:45'),('i6jbt592aq2qs4s7uobim7jlick5axa0ehb','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','7803223 Exp La Paz','Contratado','no','2014-04-19','23:16:11'),('kemhuc9hzvmy7kbcr4lakzm88s1rx3nlqiq','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2909338 Exp La Paz','Contratado','no','2014-05-25','17:09:21'),('khynergwwyo2wlxi5ej8km4gbhhi9nnfqgm','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3455994 Exp La Paz','Contratado','no','2014-05-25','17:09:23'),('lxa4spn62ki6d1n07dnh2mti342mtyhc8ug','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4900229 Exp La Paz','Contratado','si','2014-05-25','17:09:35'),('lyucmsm816dzq759yh0510uc63qzitmmbzf','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','5099330 Exp La Paz','Contratado','no','2014-06-15','20:09:55'),('nvel5d0bkloef6m7657ak11wi38qw4btzpp','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5894458 Exp La Paz','Contratado','no','2014-05-25','17:09:40'),('o5l8ayyxg8a7wp0glafv07ft3r0e719jocm','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','2088344 Exp La Paz','Contratado','no','2014-06-15','20:08:08'),('pqdrljiqp98s258hrqlp9w2fze7c5k2yxer','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','7844389 Exp La Paz','Contratado','si','2014-04-28','15:34:56'),('pxflixh0dsfy8cnohej8g91x2c8ovg43rz0','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','6733893 Exp La Paz','Contratado','no','2014-05-25','17:08:58'),('sdez1ei6aks1pwqgsyr0a40f3u4rkc0wm55','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','4789554 Exp La Paz','Contratado','no','2014-06-15','20:08:15'),('t1g44kknof0tzgs3q1vsksjy5bd85an6es5','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','6844559 Exp La Paz','Contratado','no','2014-05-25','17:09:00'),('t5pclc8vodifoe0j5vzmnojqu1s9dk4n789','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','7844559 Exp La Paz','Contratado','no','2014-06-15','20:11:59'),('teugikk9mxq4rnbnn8b6nfzij7wtcfpuyw0','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3900445 Exp La Paz','Contratado','si','2014-04-19','23:15:56'),('th22o748czq7kuhek0b6l7k0g0xqv5rpf4a','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','4673484 Exp La Paz','Contratado','no','2014-05-25','17:09:24'),('uqq14ab5evwm6vc2q2h0773kn99k6lzyakb','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','4933448 Exp La Paz','Contratado','no','2014-06-15','20:11:57'),('ux3bmz4gz8ssmbbq7xrumhthgb07at6ruxa','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','4895544 Exp La Paz','Contratado','no','2014-06-15','20:09:57'),('vgkq94ioleb7bfnx2brs3puqervcyp2e3e1','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5489448 Exp La Paz','Contratado','si','2014-04-26','17:11:28'),('vpqx0w0z5yaimalzrpdoy9mpquv9xkiyi7k','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','2033449  Exp La Paz','Contratado','no','2014-05-25','17:09:17'),('x8l17fq4lh3w32bnumi4ym4gwohtz771ooq','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5099330 Exp La Paz','Contratado','si','2014-04-19','23:03:03'),('xqiz7qnh4ogk9do310jd7h9aas4di5qlg94','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','4893344 Exp La Paz','Contratado','no','2014-06-15','20:12:10'),('xvc5udeqm9dwaf7i68c57535nlib29k982e','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','3988447 Exp La Paz','Contratado','no','2014-06-15','20:08:13'),('yi09gzi44i7u8d6ys6n2pdl2drhd383lvkn','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','7655489 Exp La Paz','Contratado','no','2014-04-19','23:03:16'),('yjkxm8fmg470u882l9gxmun4xx5swbjm28d','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','3900445 Exp La Paz','Contratado','no','2014-06-15','20:09:59'),('yw4oa43nij8h2jn5ugaz7ljps6qh5w9wzom','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','3455884 Exp La Paz','Contratado','no','2014-04-19','23:03:14');
/*!40000 ALTER TABLE `participa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_almacen`
--

DROP TABLE IF EXISTS `pedido_almacen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_almacen` (
  `Nro_pedido` varchar(40) NOT NULL,
  `IDempleado` varchar(40) DEFAULT NULL,
  `IDpersonalTecnico` varchar(40) DEFAULT NULL,
  `IDactividad` varchar(40) NOT NULL,
  `IDplan` varchar(40) DEFAULT NULL,
  `descripcion` varchar(120) DEFAULT NULL,
  `fechas_actividad` varchar(30) DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`Nro_pedido`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDpersonalTecnico` (`IDpersonalTecnico`),
  KEY `IDactividad` (`IDactividad`),
  CONSTRAINT `pedido_almacen_ibfk_1` FOREIGN KEY (`IDpersonalTecnico`) REFERENCES `personaltecnico` (`IDpersonalTecnico`),
  CONSTRAINT `pedido_almacen_ibfk_2` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`),
  CONSTRAINT `pedido_almacen_ibfk_3` FOREIGN KEY (`IDactividad`) REFERENCES `actividad` (`IDactividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_almacen`
--

LOCK TABLES `pedido_almacen` WRITE;
/*!40000 ALTER TABLE `pedido_almacen` DISABLE KEYS */;
INSERT INTO `pedido_almacen` VALUES ('35865225714967609217859972732566850','j5foiy91wzz9cqy98hg5xxe8h8bytm1rrfn','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','96367782363307395876037507801498575','67883700838770497309348435286443033','pedido de material para la incorporacion en la actividad descrita en formulario','2014-06-02-2014-07-15','Atendido','2014-06-08'),('75731113116713105997340907126467180','j5foiy91wzz9cqy98hg5xxe8h8bytm1rrfn','5r72n047v2zohyecxh6p4eipmuhkfadblb6','89870740458545731688124221354631726','12304037302566169242662068258533998','Solicitud de envÃ­o del material descrito en formulario','2014-03-10-2014-03-31','Atendido','2014-06-17');
/*!40000 ALTER TABLE `pedido_almacen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_material`
--

DROP TABLE IF EXISTS `pedido_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_material` (
  `nro_pedido` varchar(40) NOT NULL,
  `nro_cotizacion` varchar(40) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(25) NOT NULL,
  `fecRegistro` date NOT NULL,
  PRIMARY KEY (`nro_pedido`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDproveedor` (`IDproveedor`),
  KEY `IDproveedor_2` (`IDproveedor`),
  KEY `nro_cotizacion` (`nro_cotizacion`),
  CONSTRAINT `pedido_material_ibfk_1` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`),
  CONSTRAINT `pedido_material_ibfk_2` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`),
  CONSTRAINT `pedido_material_ibfk_3` FOREIGN KEY (`nro_cotizacion`) REFERENCES `cotizacion` (`nro_cotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_material`
--

LOCK TABLES `pedido_material` WRITE;
/*!40000 ALTER TABLE `pedido_material` DISABLE KEYS */;
INSERT INTO `pedido_material` VALUES ('09939918128376401038510998193170808','33270427482574537664254001939424650','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',5054.00,657.02,4396.98,'Atendido','2014-06-17'),('25818581517554202819675204711280562','34513775937135541029555831969358794','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',155.91,20.27,135.64,'Atendido','2014-04-11'),('30877429526189633009838089440086877','53168386723474388291822625472331013','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',14445.42,1877.90,12567.52,'Atendido','2014-04-16'),('37960840319462444728829944819044178','18350099973036373954074030690153300','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',33.31,4.33,28.98,'Atendido','2014-04-25'),('65032236537741835733376758629634700','91164186204109552653360863611915801','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',8385.84,1090.16,7295.68,'Atendido','2014-04-22'),('77013133346094360660772096884009274','25374980589390317040091261569362301','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',200.00,26.00,174.00,'Atendido','2014-04-26'),('93468358483733567751492971021847415','38754986758311107911670265173274339','xx896pjeah20odas37yq1nj5kovp1vp4qyz','adzkshnx71smkfrxyygkz21s5iy11w',680.00,88.40,591.60,'Atendido','2014-06-17');
/*!40000 ALTER TABLE `pedido_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `UID_PERM` varchar(40) NOT NULL,
  `USR_UID` varchar(40) NOT NULL,
  `IDopcion` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `hraAsignacion` time DEFAULT NULL,
  PRIMARY KEY (`UID_PERM`),
  KEY `IDopcion` (`IDopcion`),
  KEY `IDrol` (`USR_UID`),
  CONSTRAINT `permiso_ibfk_3` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`),
  CONSTRAINT `permiso_ibfk_4` FOREIGN KEY (`IDopcion`) REFERENCES `opcion` (`IDopcion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (' wc5taga7mfpz6469h7wl1bxrh531an1vu8y','00000000000000000000000000000001',4,'activo','2014-03-10','21:17:59'),('07xt6hytoxyjvzt8atj60d2bu6zgflu1etu','alejandro2013727',24,'activo','2014-03-15','10:54:23'),('0hi2k2q8p110uibuwl8tvllnffgkknkrrv8','00000000000000000000000000000001',52,'activo','2014-03-10','21:19:45'),('0iyas4p0dke300k3i189nct7do817oj2i9n','alejandro2013727',80,'activo','2014-03-31','11:56:00'),('0sfilnneeq1v36h2a1xsfy3lf2bakhldejl','giovani2013290',94,'activo','2014-04-16','15:05:32'),('0zvq57sj9aj6omhugvpxy2t290burgcbzea','giovani2013290',16,'activo','2014-04-21','15:12:19'),('11yr0q7d17ogwqs8vk957gk50adrasf1asb','iver2013705',18,'activo','2014-03-11','15:14:59'),('1avtwchdpm5qudlpf38ytqpc7ehvkldcng2','hreyes2014107',2,'activo','2014-05-26','18:06:41'),('1fv3v7ynopjg9tys2w73hbekpgvnxup1smo','MPV2013907',18,'activo','2014-03-10','22:10:53'),('1gm4w36tvitanjrcenufof23zc7j5flinup','hector2013852',6,'activo','2014-03-24','15:15:59'),('1roav53uy0yw3acxsgcn1ohjr536w9469yj','alejandro2013727',74,'activo','2014-03-28','18:39:20'),('1sh3tu0m20slksw1u9lwcvuq2e4r17lvokz','00000000000000000000000000000001',51,'activo','2014-03-10','21:18:43'),('2jv5cklttspxneqoe3h6r6r2q7aam32zjcs','MPV2013907',64,'activo','2014-03-11','11:37:13'),('2s1jypokk1l2heggd27cy44p5dq1xx743g2','marcelo2013432',16,'activo','2014-05-20','18:09:16'),('4tmvjxwm5bmw068awibjx1ay8zk0u9i6lo2','alberto2013824',97,'activo','2014-04-19','20:06:35'),('56fqrp0r2e6yhpvv6av0byljtk2nlqr5dfs','carlos2013472',24,'activo','2014-04-08','10:03:16'),('5a7vg5g062moie0npn347ph6pbvz3rwkr9w','ronald2013986',9,'activo','2014-03-13','11:33:49'),('5akldcc6xol3ar5757d3kfsouu9j4khvk1z','adolfo2013947',13,'activo','2014-03-24','15:00:26'),('75cxrrzr8mwjf5wyh3eawi1shrfgpzfhbw4','iver2013705',19,'activo','2014-03-11','15:14:59'),('7k5v9a3hphha9rro9xins4elfpy0v8fgbi3','alexis2013881',7,'activo','2014-03-14','16:35:58'),('7s5egtr3pkq5pefr40i8z2w61i9hbtxwv8y','giovani2013290',103,'activo','2014-04-26','21:54:04'),('8l5k8rm7wgdt5b0yrvk49xcy4nkzc69giud','adolfo2013947',93,'activo','2014-04-19','15:36:33'),('8ten47uw56tonmelmlfiz1gxt6ckgmdupp3','giovani2013290',67,'activo','2014-04-20','20:24:21'),('8y80uu6ti0xrkqzqmqjgg18fhyepbxxtyl7','mescobar2013649',23,'activo','2014-03-15','10:45:42'),('9dggd5c7n0m86r59d6kqx80juertikx3xog','adolfo2013947',79,'activo','2014-04-01','17:57:46'),('akslxe2lvjte9ncgov0fwuviyoa95cz3by7','alejandro2013727',88,'activo','2014-04-07','09:43:06'),('b180zq83qdn5klgiclajikad8qfqive5p8i','giovani2013290',105,'activo','2014-04-30','09:50:35'),('b7mcw0gv7edik35csxlb5z7n4y4dvjfq97h','victor2013704',78,'activo','2014-03-31','21:01:24'),('bhwedqcpv1ko0ifot5my8pgu2tjrfotop03','alexis2013881',86,'activo','2014-04-07','10:02:49'),('bxjexl8wxi6p8p7t0vlcnf8dy93g8cz1x8a','alberto2013824',16,'activo','2014-04-19','20:06:35'),('c1phkey2rlu6y9cxjee6jd2bpz9gajcxxuj','00000000000000000000000000000001',76,'activo','2014-03-29','18:47:10'),('c5dxqyh4qvopq41z6grfj6fqvm6d6mjn5yp','00000000000000000000000000000001',77,'activo','2014-03-29','20:27:45'),('cfv76uz106p7aw5qsyg9764zcb0zn2sz6kp','alberto2013824',98,'activo','2014-04-19','20:08:55'),('cqld10dz2mz4vzd19h6wlooqsiti7udomui','adolfo2013947',95,'activo','2014-04-19','16:54:02'),('d8qfi61v7gw18moclf94y4y0zocjoqabjby','00000000000000000000000000000001',73,'activo','2014-03-25','20:30:25'),('dcrdjo2ev9yf40s94lcftfwn0hkpyl8svki','carlos2013472',107,'activo','2014-05-09','19:25:04'),('dnnjrvaz5wjeeg1m061hkw6gs89cm82t9sh','MPV2013907',20,'activo','2014-03-10','22:10:53'),('ecuym0gdzjq2woqyhnee7qok7398zahs0zo','victor2013704',24,'activo','2014-04-14','16:19:13'),('el5sstkp0l0jso46uxs5134fwynetewdogu','alberto2013824',96,'activo','2014-04-19','20:06:35'),('f257ljsd2ecsbyfu5hfda4ggwdzl3xw05qu','carlos2013472',25,'activo','2014-04-08','10:03:12'),('fdpm6wl9ffuelyya31rwts4gn50q68x38e6','victor2013704',89,'activo','2014-04-11','14:57:23'),('fibvxckmvrtutq1izndx3hv2lasx5lv7bgc','MPV2013907',59,'activo','2014-03-11','08:54:06'),('gbwo2s3vo2s03oc1yw0hicf9qzqb8n5swc8','user12014770',2,'activo','2014-06-04','18:43:31'),('h7308ebif8undiwwzwt5opsxh4xq1k0dnsl','brayan2013447',2,'activo','2014-03-11','00:21:51'),('i2uidf43jhiwor00hzay5t0ingafhms5uwi','00000000000000000000000000000001',57,'activo','2014-03-10','21:21:16'),('j5v202zqcttislk50vec8xe6e2dexgp401w','alexis2013881',71,'activo','2014-03-23','21:29:29'),('j8owu1gh16w1z7nwv6rzp0sfcgzg28qpasl','00000000000000000000000000000001',2,'activo','2014-03-10','21:17:26'),('jtiutvej8lbdq13elltch1g2fqhg1hi4p2u','victor2013704',100,'activo','2014-04-21','20:30:39'),('jwt1r8dvyj24t3mgqzaoipban77lu4ugez6','hreyes2014107',73,'activo','2014-05-26','18:11:57'),('jx23zpfpl7n8eaol7fn155fl2g6i2z0gmig','user12014770',4,'activo','2014-06-04','18:43:31'),('k0ifsglrpnd5s6nlgnjptfo8k2wxak9c0qf','giovani2013290',93,'activo','2014-04-15','15:03:18'),('k1z15ulwbg1pfzh28kbo7wgayhx32vl7t9c','MPV2013907',19,'activo','2014-03-10','22:10:53'),('kvthynaxlip6dw8p2v6k8i0hr5ep3skn0al','giovani2013290',106,'activo','2014-05-09','12:00:37'),('lpno1ulzl4yg8kni7kb8lv3o2lyf13kvipx','mescobar2013649',12,'activo','2014-03-14','10:46:16'),('m9cze8vymdi7wqjy0mkm1j5h2epl0kbz4wx','giovani2013290',9,'activo','2014-04-20','22:02:39'),('n0fg25gi7stmqrykwo6n6q6ryz8whgqbb9a','alberto2013824',9,'activo','2014-04-19','20:06:35'),('nax6hndmvwh01j5jphby1p59jc7kb5p4gtg','ronald2013986',7,'activo','2014-05-05','18:58:46'),('nfuweq0noqubws03naols9hom74ueo11goz','alexis2013881',70,'activo','2014-03-22','21:08:07'),('nx8ljbeutgqkf4kx1izuga84hynpzc46l6v','alejandro2013727',75,'activo','2014-03-28','18:39:24'),('ohuu23d10jz6tblbt9hm59pn8t1ei9j4h7s','alejandro2013727',22,'activo','2014-03-28','18:39:38'),('oitvuhndtu73805qjln5jonhbrty1pwgw4o','giovani2013290',72,'activo','2014-03-24','09:55:45'),('op9yfm6oisaca8kyglwap7ba0kocsjolz8z','adolfo2013947',83,'activo','2014-03-31','21:05:59'),('pjg67u5r57mfgt5u03zqdvljkolso0eibzd','alejandro2013727',86,'activo','2014-04-07','10:03:30'),('qjqxtrd1edw1t06e4541vvli0hgxipnf5xg','victor2013704',87,'activo','2014-04-11','18:22:52'),('qt1w7wkalr7lo0edkz2jaf78fma8d7x8lmw','00000000000000000000000000000001',1,'activo','2014-03-10','21:16:59'),('r0aujr0p2113afjkw4nvgh2g1hmblwufwy5','carlos2013472',74,'activo','2014-04-14','09:54:39'),('r7al01pusos766vax6b1qmxbl2ynuwu7yjs','00000000000000000000000000000001',29,'activo','2014-03-13','16:08:08'),('rcqq2ddg7otqsdbushc20qcl5la68zb9gbv','brayan2013447',4,'activo','2014-03-11','00:21:51'),('rd75ms6cbuwca7m2ets3ihjj6t6mtrk6dju','giovani2013290',66,'activo','2014-03-22','21:08:41'),('rnddobbfhi4hrbc8hay0pdxpnkwxflhevna','00000000000000000000000000000001',55,'activo','2014-03-10','21:20:30'),('rwjsfoane7g5a4pf095i835nnmk0wfbclx1','victor2013704',101,'activo','2014-04-21','22:08:56'),('scwzt57cas7mrxb5q5wubxqv52eqbkkd2s3','iver2013705',20,'activo','2014-03-11','15:14:59'),('t0z3uwefwfnc0esnnriyx8vkna8nohfvdrn','carlos2013472',99,'activo','2014-05-10','19:18:39'),('tgqawl4d0x1tohk42htwolonxhczi67jb3q','ronald2013986',11,'activo','2014-05-05','18:58:07'),('tjs669nmz1w5w6rd14dt5wqzertiec5xyfh','victor2013704',90,'activo','2014-04-11','14:57:37'),('trfgreoq8jzlqpsk0f5xt42bdowx0uwtfyf','adolfo2013947',81,'activo','2014-04-01','17:57:34'),('u05yl9skyrag3vkwj4ji023808pmiy346l8','raul2013614',24,'activo','2014-04-16','15:33:22'),('udo69cdl7rcinxrvdpjwzvvuqf7947ngcqe','victor2013704',25,'activo','2014-04-14','16:19:17'),('ufq6t1uys5wuga6b1tjbx743mkfow4v0ihc','rodrigo2013758',2,'activo','2014-03-11','00:36:48'),('ujt12sz9ucdo95aymil1c0qlwxqy12o81c3','ronald2013986',16,'activo','2014-03-13','11:33:49'),('uqpjcp6bst2rlkikzij4xszg6zy7l4geuve','MPV2013907',65,'activo','2014-03-13','12:23:23'),('v1po2gzll6y9fibwxla559ajglxxmqskgpp','hreyes2014107',4,'activo','2014-05-26','18:06:41'),('wfmk60k02vwopj8npzvnw1xvcwh41nu91wp','alexis2013881',11,'activo','2014-03-14','16:35:58'),('wmjpbtj64dw8bbewmnhmlaviepy61sgo6cm','marcelo2013432',105,'activo','2014-05-20','18:09:20'),('xl9en2tj1vq05zcvwmljphevv347zifr671','victor2013704',86,'activo','2014-04-05','19:08:57'),('xp3wy28tmhkgdkxrrwm8or9zz172rj2ptk6','alejandro2013727',25,'activo','2014-03-15','10:54:23'),('xtu7myjq8drfmx0vbzgka8ks5z9m5urkbcn','carlos2013472',75,'activo','2014-04-14','09:54:36'),('xw4g8jj3ty9lmgnl99a2l43bx6p8w3bqpoq','00000000000000000000000000000001',86,'activo','2014-04-04','11:23:45'),('ydgzndme9b1xh4xj2j21czyyqib4sbbuxci','adolfo2013947',86,'activo','2014-04-04','18:37:01'),('yifmal24aao81gzufxqka64yem6xk4000rh','giovani2013290',102,'activo','2014-04-24','15:40:48'),('yj2p8cas9wpj13ur6e7w8kkzzrgpwuo3hmu','giovani2013290',68,'activo','2014-03-22','21:08:41'),('yluypigh653p59qe9skdexradwrm1c5h7ff','raul2013614',25,'activo','2014-04-16','15:33:22');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso_pagina`
--

DROP TABLE IF EXISTS `permiso_pagina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso_pagina` (
  `IDpermpag` varchar(40) NOT NULL,
  `USR_UID` varchar(40) NOT NULL,
  `IDpagina` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecAssignacion` date NOT NULL,
  `hra_asignacion` time NOT NULL,
  PRIMARY KEY (`IDpermpag`),
  KEY `USR_UID` (`USR_UID`),
  KEY `IDpagina` (`IDpagina`),
  CONSTRAINT `permiso_pagina_ibfk_1` FOREIGN KEY (`IDpagina`) REFERENCES `pagina_opcion` (`IDpagina`),
  CONSTRAINT `permiso_pagina_ibfk_2` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso_pagina`
--

LOCK TABLES `permiso_pagina` WRITE;
/*!40000 ALTER TABLE `permiso_pagina` DISABLE KEYS */;
INSERT INTO `permiso_pagina` VALUES ('1rhutcytdrvsgmpdtlui5cqyxybsct91ife','alexis2013881',15,'activo','2014-03-15','12:10:37'),('6l60hw8iv728rmgl1bsxwnf3wh68blu5f66','adolfo2013947',19,'activo','2014-04-19','16:46:16'),('6nzpoh6z9vvghxcxyf2k4umcnaro2y8pdf9','MPV2013907',3,'activo','2014-03-11','09:02:06'),('7p9glu4oltyhs1rfxzqevlqeeslhg5zpeoj','mescobar2013649',17,'activo','2014-03-17','14:47:08'),('b3ihzrecddwq64vrawh3ragncrjo97oy3ry','mescobar2013649',18,'activo','2014-03-17','14:47:21'),('b5dwpns92kwptw1ff5588u2g6o4israri2l','alexis2013881',20,'activo','2014-03-23','21:29:51'),('j9zqgrbffl7mljm65pq2tbmybj0b6pal0lb','MPV2013907',13,'activo','2014-03-11','17:43:35'),('kv9uv5fsmjc8amx75klyz73zscm8dvqf885','00000000000000000000000000000001',7,'activo','2014-03-10','21:27:45'),('m8nhqd0pvkkhb553wesq0iy6vb4ye3fcsyh','MPV2013907',12,'activo','2014-03-11','17:43:26'),('p1jdxsglzugu1g57ttvtpg4ascoog5c7lhe','00000000000000000000000000000001',8,'activo','2014-03-10','21:28:53'),('px91ni6nobgze5b0k4418wcdj708b2hk680','00000000000000000000000000000001',1,'activo','2014-03-10','21:26:45'),('sdb4ygs6syx7kugdy73rsnj9cflss3x06m7','MPV2013907',14,'activo','2014-03-13','19:28:55'),('tjjkdhhbsrczr4gym10da1142t6e8zkuayu','alexis2013881',16,'activo','2014-03-15','21:05:54'),('ur9ho8vuktlenrb8422ie6u0blkcj0swmw8','MPV2013907',6,'activo','2014-06-07','22:00:42'),('vw279bpndin4n07l54uhbxu1b8nknbpxd1m','MPV2013907',5,'activo','2014-06-07','22:13:31'),('yet5y8rdrou28olmkxzvgqw9nbzajmdhb3x','hector2013852',10,'activo','2014-03-24','15:16:39');
/*!40000 ALTER TABLE `permiso_pagina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personalmanoobra`
--

DROP TABLE IF EXISTS `personalmanoobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personalmanoobra` (
  `CI_trabajador` varchar(40) NOT NULL,
  `CI_encargado` varchar(20) NOT NULL,
  `IDcargoM` varchar(40) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `ap_p` varchar(25) NOT NULL,
  `ap_m` varchar(25) NOT NULL,
  `experiencia` varchar(90) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `fecNacimiento` date NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`CI_trabajador`),
  KEY `IDcargoM` (`IDcargoM`),
  KEY `IDcargoM_2` (`IDcargoM`),
  KEY `CI_encargado` (`CI_encargado`),
  CONSTRAINT `personalmanoobra_ibfk_1` FOREIGN KEY (`IDcargoM`) REFERENCES `cargomanodeobra` (`IDcargoM`),
  CONSTRAINT `personalmanoobra_ibfk_2` FOREIGN KEY (`CI_encargado`) REFERENCES `encargadomanoobra` (`CI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personalmanoobra`
--

LOCK TABLES `personalmanoobra` WRITE;
/*!40000 ALTER TABLE `personalmanoobra` DISABLE KEYS */;
INSERT INTO `personalmanoobra` VALUES ('2033449  Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Agustin','Pedroza','Torrez','ayudante operador','2334489 - 72033449','av Heroes del acre #443','1983-09-19','2014-05-25','16:19:12'),('2088344 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','David Gaston','Vargas','Suarez','control de mantenimiento de vias','248093 - 7200148','pza avaroa #449','1986-09-14','2014-05-25','16:48:49'),('2344339 Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Orlando','Salazar','Calderon','albanileria','2304490-73090233','av argentina #908 z miraflores','1989-02-12','2014-05-25','15:53:51'),('2898554 Exp La Paz','4554432 Ex La Paz','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2','Diego Victor','Salas','Mena','supervision de obresos','73044589','c/ harrington #449','1981-02-14','2014-04-28','15:34:39'),('2904348 Exp La Paz','4554432 Ex La Paz','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2','Marcelo','Avalos','Del Carpio','control de trabajadores','2904478','av busch #1039','1980-09-10','2014-04-28','15:36:34'),('2909338 Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Christian','Vega','Mamani','albanileria','24895589','plaza sucre #930 san pedro','1989-03-12','2014-05-25','15:47:12'),('338944 Exp La Paz','4554432 Ex La Paz','iw0qxxs3g1d4k5vynlc3lf88q8j5ow2am4z','Marcelo','Quiroga','Flores','operador en equipos','2480837','av landaeta #490 san pedro','1990-03-12','2014-05-25','16:05:41'),('3389449 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Heber Junior','Tarqui','Flores','ayudante en operaciones de equipos','2230531 - 73213449','villa copacabana','1988-11-19','2014-05-25','16:02:54'),('3455884 Exp La Paz','4554432 Ex La Paz','7hlcvhwqsrunc5scqyv6hboshwqq9bukb61','Mario','Gomez','Sanchez','control de estado de suelos y terrenos','2823490','ciudad satelite #544 El Alto','1974-11-28','2014-04-19','22:32:24'),('3455994 Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Gustavo Adolfo','Cruz','Laura','albanileria','72009212 - 24899230','c/ harrington #901','1982-05-04','2014-05-25','15:39:12'),('3490554 Exp La Paz','4554432 Ex La Paz','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Arturo','Torrez','Lara','conduccion','24455909','av 16 de julio 456 el prado','1984-09-12','2014-03-25','11:38:34'),('3900445 Exp La Paz','4554432 Ex La Paz','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Ramiro','Cardona','Torrez','Especialista en manejo de maquinaria','24807336 - 72033490','plaza cristo rey #890','1983-11-12','2014-04-19','23:11:16'),('3988447 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Jaime','Morales','Arias','control de excavaciones','27234490','sector A #449 la florida','1987-03-12','2014-05-25','16:41:28'),('4673484 Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Israel','Espejo','Laura','encargado de albanileria','24890339','av landaeta #449 san pedro','1979-09-12','2014-05-25','15:43:56'),('4789554 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Richard','Gonzales','Peredo','control y excavaciones','2489955','av del maestro #554 alto obrajes','1985-03-16','2014-05-25','17:08:21'),('4893344 Exp La Paz','4554432 Ex La Paz','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2','Ervin','Romero','Gonzales','control de obresos','79033448','av 6 de marxo #449 El Alto','1983-09-23','2014-04-28','15:33:42'),('4895544 Exp La Paz','4554432 Ex La Paz','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Luis Alberto','Sanchez','Mendoza','manejo de equipo pesado','70567549 - 2224955','c/ guatemala #1080 miraflores','1973-09-14','2014-04-19','23:05:25'),('4900229 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Franz','Quiroga','Choque','ayudante de equipos','2338944-72033449','san pedro','1990-09-12','2014-05-25','16:04:27'),('4933448 Exp La Paz','4554432 Ex La Paz','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Oscar','Saucedo','Ramirez','operador de equipamiento pesado','73044558','alto obrajes','1970-09-12','2014-06-15','20:11:42'),('4995580 Exp La Paz','4554432 Ex La Paz','7hlcvhwqsrunc5scqyv6hboshwqq9bukb61','Rodrigo','Reyes','Carrasco','especialista en control de estado de terrenos','70589442','av iturralde #908','1985-08-14','2014-04-19','23:09:32'),('5099330 Exp La Paz','4554432 Ex La Paz','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Marco Antonio','Fernandez','Fernandez','maniobra de tractores','22244550','c/ belisario salinas #4490','1987-07-10','2014-04-19','22:13:27'),('5333945 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Sergio Mario','Loayza','Perez','control de caminos','72590338','c/ haiti #903','1984-08-14','2014-05-25','17:06:39'),('5489448 Exp La Paz','4554432 Ex La Paz','0kje4f9975yaswwy3b9xlsuiy85n97tcrk2','Erick','Amaru','Ortiz','manejo de perforaciones de suelos','2405549 - 7302444','av 6 de agosto','1984-07-31','2014-03-15','22:46:15'),('5733894 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Rolando','Olmos','Reyes','control de excavaciones','2334484 - 70578339','sopocachi','1981-05-12','2014-05-25','16:56:46'),('5788445 Exp La Paz','4554432 Ex La Paz','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Cristian','Flores','Paucara','conduccion de movilidad de transporte','2445589 - 73044558','villa adela','1989-09-19','2014-03-25','12:02:43'),('5789338 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Luis','Condori','Ramirez','ayudante de operador de equipos','79523894','ciudad satelite #348 El alto','1989-03-01','2014-05-25','16:11:47'),('5894448 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Aldo','Velasquez','Perez','ayudante en equipos pesados','2894489 - 7250934','av 16 de julio #898 El Prado','1982-02-15','2014-05-25','16:21:59'),('5894458 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Marcial','Quispe','Ramos','ayudante de operaciones en maquinaria','24590339','av 6 de agosto #903','1983-02-08','2014-05-25','16:26:44'),('5899449 Exp La Paz','4554432 Ex La Paz','iw0qxxs3g1d4k5vynlc3lf88q8j5ow2am4z','Hector','Torrez','Ramirez','control de mantenimiento y reparacion','72590459','av argentina #5589 miraflores','1980-10-14','2014-04-19','22:35:43'),('5905955 Exp La Paz','4554432 Ex La Paz','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Carlos','Bonadona','Robles','transporte interdepartamantal','24905549','av saavedra #904','1981-09-18','2014-03-17','18:09:42'),('59333403 Exp La Paz','4554432 Ex La Paz','74phbgtp8nikjujtclpzq9kt6n61a7rublg','Herbert','Lazarte','Perez','controlador de estado de suelos','72090339','av 6 de agosto #890','1977-04-05','2014-04-19','22:25:09'),('6733893 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Mauricio','Gomez','Morales','peon','2823390','el alto','1979-01-21','2014-05-25','16:32:34'),('6844559 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Omar','Jaimes','Loza','control de despejes de vias','24033894 - 72509338','av landaeta #903','1979-10-12','2014-05-25','16:36:28'),('6899334 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Juan Eduardo','Castro','Ortega','control de seniales ','2490844 - 7207192','plaza sucre #9230 san pedro','1988-09-12','2014-05-25','16:51:20'),('6899448 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Carlos','Aguilar','Sanchez','control de vias','2412283','sopocachi','1980-06-12','2014-05-25','17:03:59'),('6909334 Ex La Paz','4554432 Ex La Paz','0kje4f9975yaswwy3b9xlsuiy85n97tcrk2','Jorge Hugo','Loza','Torrez','control de perforaciones de suelos','2402339','av 6 de agosto, c/guachalla','1978-04-11','2014-03-16','20:49:49'),('7655489 Exp La Paz','4554432 Ex La Paz','7hlcvhwqsrunc5scqyv6hboshwqq9bukb61','Rodrigo','Humerez','Loza','especialista en estudio de suelos','2489055','calle santivanes, san pedro','1978-10-16','2014-04-19','22:27:40'),('7803223 Exp La Paz','4554432 Ex La Paz','74phbgtp8nikjujtclpzq9kt6n61a7rublg','Daniel','Rojas','Valda','control en resistencia suelos','2754457 - 7254894','c/ 21 de calacoto #908','1982-09-12','2014-04-19','23:15:17'),('7844339 Ex La Paz','4554432 Ex La Paz','iw0qxxs3g1d4k5vynlc3lf88q8j5ow2am4z','Luis Fernando','Saisa','Lopez','especializado en reparaciones de equipos pesados','2822019','z/ ciudad satelite, El Alto','1980-09-16','2014-03-16','20:58:25'),('7844389 Exp La Paz','4554432 Ex La Paz','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2','Juan','Lazo De La Vega','Aliaga','Experiencia en control de personal de trabajos','2458967','av iturralde #5589','1976-12-27','2014-04-19','22:44:32'),('7844559 Exp La Paz','4554432 Ex La Paz','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg','Hector','Larrea','Gomez','operadoe de maquinaria','72033449','san pedro','1984-02-03','2014-06-15','20:10:51'),('7844903 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Jose Manuel','Merida','Cortez','manejo de equipo pesado','73098334','villa adela #5669','1986-03-03','2014-04-19','22:21:12'),('7890448 Exp La Paz','4554432 Ex La Paz','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Reynaldo Felix','Mamani','Ticona','control de avance de trabajadores','79034883','av buenos aires #4490','1986-09-11','2014-04-28','15:32:26'),('78933447 Exp La Paz','4554432 Ex La Paz','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn','Ronal Silver','Quino','Torrez','encargado de trabajos de albanineria','73023940','av 6 de marzo #44 El alto','1988-08-12','2014-05-25','15:36:40'),('8559049 Exp La Paz','4554432 Ex La Paz','96e1bjs8dqx25v51keashype5e91gnlxkhv','Jose Luis','Gomez','Hurtado','mantenimiento de terrenos','73048210','san pedro','1980-01-14','2014-04-19','22:19:12'),('8933449 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Luis Sergio','Pradel','Ramirez','ayudante de maquinaria','2483394','c/ haiti 233','1988-07-26','2014-05-25','16:01:34'),('8944559 Exp La Paz','4554432 Ex La Paz','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc','Marco Aurelio','Avalos','Nina','conduccion de vehiculos de transporte','2904554 - 73044558','villa copacabana','1986-09-14','2014-03-25','11:39:45'),('8944983 Exp La Paz','4554432 Ex La Paz','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx','Jorge','Jordan','Lopez','ayudante en maquinaria pesada','2449048 - 72509129','la florida','1987-09-12','2014-05-25','16:07:59');
/*!40000 ALTER TABLE `personalmanoobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personaltecnico`
--

DROP TABLE IF EXISTS `personaltecnico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personaltecnico` (
  `IDpersonalTecnico` varchar(40) NOT NULL,
  `IDempleado` varchar(80) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `CI` varchar(40) NOT NULL,
  `descParticipacion` varchar(110) NOT NULL,
  `IDpago` varchar(25) DEFAULT NULL,
  `fechaDesignacion` date NOT NULL,
  `hraDesignacion` time NOT NULL,
  PRIMARY KEY (`IDpersonalTecnico`),
  KEY `IDpago` (`IDpago`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDempleado_2` (`IDempleado`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `personaltecnico_ibfk_3` FOREIGN KEY (`IDpago`) REFERENCES `pago` (`IDpago`),
  CONSTRAINT `personaltecnico_ibfk_4` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`),
  CONSTRAINT `personaltecnico_ibfk_5` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personaltecnico`
--

LOCK TABLES `personaltecnico` WRITE;
/*!40000 ALTER TABLE `personaltecnico` DISABLE KEYS */;
INSERT INTO `personaltecnico` VALUES ('2rmsgup9j3e8uvhige0e0fsozyc4eodyhg1','k9g9pmrjbhmw3uby81j7o9zw80yrz41nkit','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','25344558 exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-06-06','19:30:06'),('40mt25ywlgb22vapuhdvb001j1j4k2415yg','cdrbqohjwybww9v19swnc44gvi9q3ud9xqf','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','8944334 Ex La Paz','Personal tecnico participante en el proyecto',NULL,'2014-04-19','19:44:36'),('43yb74scin6379wj1snjn1zpkdxkmtp33vt','pqp9fgqqhkc410cfkn0e1cyj9qkbbl60bqt','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5890440 Exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-04-19','19:44:33'),('5r72n047v2zohyecxh6p4eipmuhkfadblb6','t8n4ajqr7vjrna96z2bu9qsqlqjtslx3uzi','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','25448909 Exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-06-15','19:00:44'),('8sugnl1p6afe6kegk399t3m4wzaa90fyny2','t8n4ajqr7vjrna96z2bu9qsqlqjtslx3uzi','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','25448909 Exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-04-19','19:44:27'),('9foenuhf5c72vb9v048ava0x8jvlp1g9fcx','pqp9fgqqhkc410cfkn0e1cyj9qkbbl60bqt','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','5890440 Exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-06-15','19:01:54'),('vc4b7eu52ax96fdwl8j4omsjixq28fei6k1','k9g9pmrjbhmw3uby81j7o9zw80yrz41nkit','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','25344558 exp La Paz','Personal tecnico participante en el proyecto',NULL,'2014-06-15','19:00:06');
/*!40000 ALTER TABLE `personaltecnico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planificacion`
--

DROP TABLE IF EXISTS `planificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planificacion` (
  `IDplanificacion` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `descripcion` varchar(110) NOT NULL,
  `fecInicio` date NOT NULL,
  `fecFin` date DEFAULT NULL,
  PRIMARY KEY (`IDplanificacion`),
  KEY `IDproyecto` (`IDproyecto`),
  CONSTRAINT `planificacion_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planificacion`
--

LOCK TABLES `planificacion` WRITE;
/*!40000 ALTER TABLE `planificacion` DISABLE KEYS */;
INSERT INTO `planificacion` VALUES ('12304037302566169242662068258533998','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','Plan de control de asignaciones y preparacion de ejecuciones','2014-02-25','2014-06-17'),('35176173591856987518068845879129167','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','Plan de continuacion de actividades','2014-06-18','2014-06-17'),('67883700838770497309348435286443033','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','Plan de control de actividades para el proyecto','2014-04-20',NULL),('74385053879959950951589154416276897','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','Plan de asignacion de nuevas actividades','2014-06-18',NULL);
/*!40000 ALTER TABLE `planificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planificacion_compra`
--

DROP TABLE IF EXISTS `planificacion_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planificacion_compra` (
  `IDplan` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `descripcion` varchar(110) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `item` varchar(110) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinalizacion` date DEFAULT NULL,
  PRIMARY KEY (`IDplan`),
  KEY `IDproyecto` (`IDproyecto`),
  CONSTRAINT `planificacion_compra_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planificacion_compra`
--

LOCK TABLES `planificacion_compra` WRITE;
/*!40000 ALTER TABLE `planificacion_compra` DISABLE KEYS */;
INSERT INTO `planificacion_compra` VALUES ('19668347340147910637235097416819051','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','Comprar el item descrito en base a la cantidad','piedra en bruto grande para bateones',2.00,'2014-04-25','2014-06-05'),('45893382046465438942935235598696255','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','realizar la compra para el item descrito','gabion para proteccion contra derrumbes',3.00,'2014-04-22','2014-04-22'),('46177334994660884908054351214210819','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','Realizar la compra para el material descrito en formulario','Ripio acopioado',1.30,'2014-04-26','2014-04-25'),('58014036471681760169626291844457347','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','compra del item descrito en formulario','agua',10.00,'2014-04-28','2014-06-05'),('60422652150184298908091852566737515','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','Realizar la compra del item descrito en el formulario ','mezcla asfaltica para bacheo en caliente',4.50,'2014-04-24','2014-04-22');
/*!40000 ALTER TABLE `planificacion_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesion`
--

DROP TABLE IF EXISTS `profesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesion` (
  `IDprofesion` varchar(40) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDprofesion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesion`
--

LOCK TABLES `profesion` WRITE;
/*!40000 ALTER TABLE `profesion` DISABLE KEYS */;
INSERT INTO `profesion` VALUES ('2u5vh445h4bp9wrqjevcmyrug2m86ysqy1s','operador de sistemas','encargado de administrar y mantener el sistema de la empresa','2014-06-14','23:44:40'),('bj8jwl9k4e24qskllfnrat4sms7imhsrjwo','secretaria auxiliar','profesion tecnica en manejo de archivos, files','2014-03-13','19:43:48'),('br7ozar04owlcnon47nbnnoeagzavaqlbvm','administrador de empresas','licenciatura en ciencias empresariales','2014-03-13','19:42:36'),('c0amlpu0wkqdwwh9bdm91qrhh8b5f8rh0dt','ingeniero de sistemas','especialista en informÃ¡tica y ciencias de la computaciÃ³n','2014-03-14','09:00:42'),('kjfmkplidwq0cc5pn065pzv6nkuk6rugcxz','ingeniero civil','profesional en el Ã¡rea de proyectos de obras civiles','2014-03-14','09:02:14'),('o86n8hu06hbkzk7bklmxr0bozac6q5t4ttf','tecnico en compras','profesion tecnica en control de compra y alquiler','2014-03-31','20:50:45'),('uy5anog3jkrtld5dgpy5dgkjzny03wd1yyd','arquitecto','licenciatura en arquitectura y urbanismo','2014-03-17','15:50:35'),('wyeq1p0v8hb7pzrva78eebdet4ustam9u6s','tecnico en almacenes','profesion tecnica en almacenamiento de items','2014-03-31','19:54:07');
/*!40000 ALTER TABLE `profesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propiedadesusuario`
--

DROP TABLE IF EXISTS `propiedadesusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propiedadesusuario` (
  `USR_UID` varchar(40) NOT NULL,
  `fecActualizacion` date NOT NULL,
  `histPassword` varchar(80) NOT NULL,
  KEY `USR_UID` (`USR_UID`),
  CONSTRAINT `propiedadesusuario_ibfk_1` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propiedadesusuario`
--

LOCK TABLES `propiedadesusuario` WRITE;
/*!40000 ALTER TABLE `propiedadesusuario` DISABLE KEYS */;
INSERT INTO `propiedadesusuario` VALUES ('brayan2013447','2014-03-11','fe0e4e8a4bb0a50b857b7f91491e81abc9f9dabb'),('brayan2013447','2014-03-11','fe0e4e8a4bb0a50b857b7f91491e81abc9f9dabb'),('adolfo2013947','2014-04-01','0aed51bec204a154968720b4454461dc9dc3ac32'),('adolfo2013947','2014-04-01','0aed51bec204a154968720b4454461dc9dc3ac32'),('adolfo2013947','2014-04-01','0aed51bec204a154968720b4454461dc9dc3ac32'),('adolfo2013947','2014-04-01','fa80ebb5fcba7fb64e9c67573d903168264a2991'),('adolfo2013947','2014-04-07','fa80ebb5fcba7fb64e9c67573d903168264a2991'),('raul2013614','2014-04-16','fa80ebb5fcba7fb64e9c67573d903168264a2991'),('giovani2013290','2014-04-30','fa80ebb5fcba7fb64e9c67573d903168264a2991');
/*!40000 ALTER TABLE `propiedadesusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `IDproveedor` varchar(40) NOT NULL,
  `USR_UID` varchar(40) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `app` varchar(40) NOT NULL,
  `apm` varchar(40) NOT NULL,
  `CI` varchar(30) NOT NULL,
  `empProveedora` varchar(40) NOT NULL,
  `dirEmpresa` varchar(110) NOT NULL,
  `telefonos` varchar(20) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDproveedor`,`USR_UID`),
  UNIQUE KEY `CI` (`CI`),
  KEY `USR_UID` (`USR_UID`),
  CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES ('adzkshnx71smkfrxyygkz21s5iy11w','alejandro2013727','Alejandro','Aguilar','Sanchez','4789430 exp La Paz','Obras Bolivia','av 6 de marzo zona 12 de octubre, El Alto','2829087 - 70166166','2014-03-15','11:47:31'),('oi3v9ze13s94pja6l0fd719zubin69y1j0n','raul2013614','Raul','Perez','Ramos','4589244 exp La Paz','Campero S.A','av 6 de Marzo #890 El alto','28455834 72044558','2014-04-16','15:43:35');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `IDproyecto` varchar(40) NOT NULL,
  `IDlicitacion` varchar(40) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `responsable` varchar(40) NOT NULL,
  `fecInicio` date NOT NULL,
  `fecFinal` date NOT NULL,
  `duracion_programada` decimal(10,2) DEFAULT NULL,
  `duracion_real` decimal(10,2) DEFAULT NULL,
  `estado` varchar(40) NOT NULL,
  `totalProyecto` decimal(10,2) DEFAULT NULL,
  `costo_real` decimal(10,2) DEFAULT NULL,
  `porcentaje_progreso` decimal(10,2) DEFAULT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDproyecto`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `IDlicitacion` (`IDlicitacion`),
  CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`IDlicitacion`) REFERENCES `licitacion` (`IDlicitacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES ('hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','L0000000000002','Ejecucion de Obras para el Servicio de Conservacion Vial del tramo Australia-Cruce Rurrenabaque ','25448909 Exp La Paz','2014-05-25','2015-09-30',472.00,262.00,'En ejecucion',25332814.22,20059.97,7.69,'2014-04-19','15:52:48'),('jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','L0000000000001','Ejecucion de obras de conservacion vial de los tramos La Paz Oruro','25448909 Exp La Paz','2014-02-02','2014-06-12',130.00,191.00,'En ejecucion',25908347.34,115934.61,50.00,'2014-06-15','18:13:26');
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto_maquinaria`
--

DROP TABLE IF EXISTS `proyecto_maquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto_maquinaria` (
  `IDincor` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `IDmaquinaria` varchar(40) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDincor`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `nro_itemmaquinaria` (`IDmaquinaria`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `proyecto_maquinaria_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`),
  CONSTRAINT `proyecto_maquinaria_ibfk_2` FOREIGN KEY (`IDmaquinaria`) REFERENCES `maquinaria` (`IDmaquinaria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto_maquinaria`
--

LOCK TABLES `proyecto_maquinaria` WRITE;
/*!40000 ALTER TABLE `proyecto_maquinaria` DISABLE KEYS */;
INSERT INTO `proyecto_maquinaria` VALUES ('24647267830522125492249659720540002','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4',10.00,'2014-05-10','21:19:47'),('27554874705105081545516079275845124','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema',3.00,'2014-06-17','19:38:05'),('51484322232517791858393158079499705','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','dg07ngp1xhjp5qke9e9yds20845sdlz54rj',2.00,'2014-06-17','19:38:05'),('57021257910973969283831592319456672','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','daxusj4txhyre2ga29p6qhk2noco437hm8c',3.00,'2014-06-17','19:38:05'),('58335320325510222683536813836387812','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','duikwxjjzz96yzj8y1eegfam6gruvo4usw3',5.00,'2014-06-17','19:38:05'),('73725705377239592572058779012904130','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc',8.00,'2014-05-10','21:19:46'),('94165666682880532537416836594695702','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','yaj3rvce9iovgsyo8bth7gtjfr67shm2ema',6.00,'2014-05-10','21:19:47'),('96112295417364872690492328733832760','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','daxusj4txhyre2ga29p6qhk2noco437hm8c',11.00,'2014-05-10','21:19:46'),('97633562889931021132638457969178231','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','tqga5r93jyomah19w1thdfgv6hiuqhfzkp1',3.00,'2014-05-10','21:19:46');
/*!40000 ALTER TABLE `proyecto_maquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto_material`
--

DROP TABLE IF EXISTS `proyecto_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto_material` (
  `IDincor` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `IDmaterial` varchar(40) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecRegistro` date NOT NULL,
  `hraRegistro` time NOT NULL,
  PRIMARY KEY (`IDincor`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `nro_itemmaterial` (`IDmaterial`),
  KEY `IDplanificacion` (`IDplanificacion`),
  CONSTRAINT `proyecto_material_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`),
  CONSTRAINT `proyecto_material_ibfk_2` FOREIGN KEY (`IDmaterial`) REFERENCES `material` (`IDmaterial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto_material`
--

LOCK TABLES `proyecto_material` WRITE;
/*!40000 ALTER TABLE `proyecto_material` DISABLE KEYS */;
INSERT INTO `proyecto_material` VALUES ('00814440601069019758705591275703565','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','xi1vfy93yjitx7hvfop2zsk0zpprp2y6xi6',400.00,'2014-06-08','16:10:55'),('06880393609932342797443276585008216','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','lg4k7f9e01ybomelbshd5lb1r9kvht5rh56',80.00,'2014-06-08','16:10:54'),('21629276348127555809963178262432623','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','nw28w541ja2pix442xhtb4kk96rqeo99zy4',0.00,'2014-06-08','19:39:02'),('28043697772587672792965938723504194','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','fs6lwncn5y4bjobnr9szzmojifj6o6ltkyb',10.00,'2014-06-08','16:10:54'),('29714175084211079252512914381618623','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','ma7819snt0jvfnl6i2al7cwpcpamgbjv8u7',25.00,'2014-06-08','16:10:54'),('35826148880401044647027459665066658','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','nw28w541ja2pix442xhtb4kk96rqeo99zy4',35.00,'2014-06-08','16:10:54'),('40870494825281165383148809262692576','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','12304037302566169242662068258533998','nw28w541ja2pix442xhtb4kk96rqeo99zy4',21.00,'2014-06-17','20:25:11'),('47761824874357861784417496042264117','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','5531k9wflwuowfjyobb2exgjiwzb6xvh805',100.00,'2014-06-08','16:10:54'),('50463257133257270307624808064224199','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','oubwb8s3nts4xep8v14kn87e3butwngchx4',120.00,'2014-06-08','16:10:55'),('56825161642180373876121717276550316','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','ql2ngtf59eb4d0v0f2gxxxt7iusa7xh0pla',300.00,'2014-06-08','16:10:55'),('67764682689392641935247163236201225','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','nw28w541ja2pix442xhtb4kk96rqeo99zy4',0.00,'2014-06-08','19:33:42'),('72504619024974807569319146715241198','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','nw28w541ja2pix442xhtb4kk96rqeo99zy4',0.00,'2014-06-08','19:43:19'),('82853413137036187462642708067837035','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','1dackb8zxgmj7jgmq6nl8zm8qsxlzjr1y4q',12.00,'2014-06-08','16:10:54'),('91097864667004591694981915204441056','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','o2zznd6leyij7r9rbuopr50fbt38qgbpyv4',50.00,'2014-06-08','16:10:55'),('92289721246035748433546714074438464','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','361m8280lw5ls15bwimv6bktkkjdj6zk2xc',29.00,'2014-06-08','16:10:54'),('94109337421912244335652261741650726','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','67883700838770497309348435286443033','vbjlyfxbvlcrzu1kw95fii29g4t82r1jsmi',80.00,'2014-06-08','16:10:55');
/*!40000 ALTER TABLE `proyecto_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `IDrol` varchar(40) NOT NULL,
  `nombreRol` varchar(40) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDrol`),
  UNIQUE KEY `nombreRol` (`nombreRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES ('SC_ADMINISTRADOR','administrador general del sistema','encargado de la administracion de la seguridad del sistema','2014-02-27','20:23:55'),('SC_ADMIN_APP','administrador de la aplicacion','Encargado de la gestion de registros de parametros','2014-03-14','10:45:28'),('SC_CONTRATISTA','contratista de proyectos','encargado de la contratacion, ejecucion de obras civiles','2014-02-27','20:23:55'),('SC_CONVOCANTE','convocante','encargado de registrar proyectos de carreteras','2014-02-27','20:23:55'),('SC_EMPLEADO','empleado','empleado de la empresa','2014-03-04','19:00:56'),('SC_ENCARGADO_ALMACEN','encargado de almacen','Encargado del control logistico y de ingresos de items','2014-03-31','20:56:55'),('SC_ENCARGADO_COMPRA','Encargado de compra y alquiler','Responsable','2014-03-07','12:16:37'),('SC_GERENTE_TECNICO','gerente tecnico','Encargado de planificacion de proyectos civiles','2014-03-17','15:38:39'),('SC_OPERADOR','operador','operador con accesos restringidos a la parte de seguridad','2014-02-27','20:23:55'),('SC_PROVEEDOR','proveedor de items','encargado del suministro de la maquinaria y materiales de obra civil','2014-02-27','20:23:55'),('SC_PROVEEDOR_MANO_OBRA','proveedor de mano de obra','encargado de publicar y ofrecer mano de obra a empresas de construccion','2014-02-27','20:23:55'),('SC_ROL','rol de prueba','rol personalizado para la empresa','2014-03-02','18:56:05'),('SC_SUPERINTENDENTE','superintendente de obras','encargado del control tecnico de obras civiles','2014-03-05','11:09:14'),('SC_SUPERVISOR','supervisor','Encargado de la supervision de obras carreteras','2014-02-27','20:35:55');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_opcion`
--

DROP TABLE IF EXISTS `rol_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_opcion` (
  `IDperm_rol` varchar(40) NOT NULL,
  `IDrol` varchar(40) NOT NULL,
  `IDopcion` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecAsignacion` date NOT NULL,
  `hraAsignacion` time NOT NULL,
  PRIMARY KEY (`IDperm_rol`),
  KEY `IDrol` (`IDrol`),
  KEY `IDopcion` (`IDopcion`),
  CONSTRAINT `rol_opcion_ibfk_2` FOREIGN KEY (`IDopcion`) REFERENCES `opcion` (`IDopcion`),
  CONSTRAINT `rol_opcion_ibfk_3` FOREIGN KEY (`IDrol`) REFERENCES `rol` (`IDrol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_opcion`
--

LOCK TABLES `rol_opcion` WRITE;
/*!40000 ALTER TABLE `rol_opcion` DISABLE KEYS */;
INSERT INTO `rol_opcion` VALUES ('11wd90ipmei1xnnys2pft9hlvw6m87gj7gl','SC_EMPLEADO',19,'activo','2014-03-10','22:10:06'),('12lvu8myij31tbwhqezucihjl65ei7hluy4','SC_ADMIN_APP',23,'activo','2014-03-15','10:44:59'),('21fqwuwoedmxx5fzsb49sspk6088d4bgd4q','SC_PROVEEDOR_MANO_OBRA',11,'activo','2014-03-14','10:31:06'),('37trsgdkblb705wf3pxoiwd2763ae253gkt','SC_ENCARGADO_COMPRA',78,'activo','2014-03-31','20:57:56'),('53oq4g4vxlri448jo12m0cgc5qjhof2anp3','SC_OPERADOR',4,'activo','2014-03-11','00:21:19'),('5a920c3ynszze8wdbq759egp2q478pm1wcj','SC_CONVOCANTE',6,'activo','2014-03-17','15:27:10'),('5iv1fqotb6th57fzj0bf2tfmchduz1y4ah5','SC_ADMINISTRADOR',51,'activo','2014-03-10','21:23:27'),('6tsc9y8t9lfdz6762arkyvyzjnwod3i1i9z','SC_CONTRATISTA',6,'activo','2014-03-13','11:00:09'),('7rfqi2zrlznb3q2zjtpmfeqhvx9i6pztrr3','SC_ENCARGADO_ALMACEN',82,'activo','2014-03-31','21:00:37'),('7vgbicg3ruiv90ros72fk2xzmiv2g49iifj','SC_PROVEEDOR_MANO_OBRA',7,'activo','2014-03-14','10:31:10'),('7xluho528qnap1t6o0sbfwe0ddvc59u1f6q','SC_SUPERINTENDENTE',96,'activo','2014-04-19','20:06:05'),('7z58jwpb1d1o2v2lu4d3l5omdp4g92o57f5','SC_EMPLEADO',20,'activo','2014-03-10','22:10:02'),('8do2vmh4peu2x61vbzqbrarh2ty58oefla6','SC_SUPERVISOR',93,'activo','2014-04-19','19:52:10'),('8e6ruk84ykv4x8nsmv80r160j4znbyljgqs','SC_ADMINISTRADOR',2,'activo','2014-03-10','21:21:59'),('8h75g1qk4ne32h6l6gdogiqx23ov3dz9zv0','SC_ADMINISTRADOR',52,'activo','2014-03-10','21:24:56'),('8p4u9gm5lzdv5usbvz2xteabdmvnhs1p5mh','SC_ADMINISTRADOR',55,'activo','2014-03-10','21:25:25'),('d92o40beih6ko8zo00izbxqvcrejehggt62','SC_CONTRATISTA',9,'activo','2014-03-13','11:00:23'),('djz02unmlqbkhb1dz19uy84eddp4j1pwvlq','SC_CONTRATISTA',68,'activo','2014-03-22','21:06:36'),('dx20gq0d7do94xxoexgdpx7pcow733eiffn','SC_CONTRATISTA',66,'activo','2014-03-21','17:00:20'),('er9nxcxll6hb0ydjmaz37vw3rquwfsi9ncf','SC_CONTRATISTA',67,'activo','2014-03-21','17:00:36'),('k1v1mzlhromznrx4mebrr29iegj9iw4lg1d','SC_PROVEEDOR',24,'activo','2014-03-15','10:53:54'),('kbw4svxedc7y9oem82yd448wlbkekt067st','SC_ADMIN_APP',52,'activo','2014-03-24','15:15:00'),('n9tzibluj93vdr3cn68zu6ktra1k8zimenx','SC_ADMIN_APP',12,'activo','2014-03-14','10:45:53'),('ou3ai0igc1sjpdgtp6837tmq9tmvf83a980','SC_PROVEEDOR',25,'activo','2014-03-15','10:53:59'),('prsq9fx6iyv0zdmp5idc5v0ff5ny1a7f2lf','SC_GERENTE_TECNICO',13,'activo','2014-03-17','15:39:11'),('pu6ptovmdpt46m4ba7t7j4ja7mrcj5zpw7q','SC_SUPERVISOR',94,'activo','2014-04-19','19:51:55'),('q7u6kttgzdo9iwwohueqp0j2jqbqaa41w30','SC_SUPERINTENDENTE',9,'activo','2014-04-19','19:56:23'),('qfj3wc4j1xjo2k39qvqzbf8qgomrp7qb8hl','SC_SUPERINTENDENTE',97,'activo','2014-04-19','20:06:14'),('qg6nbou1e5668dwmtu37820c9a80g9hgdca','SC_OPERADOR',2,'activo','2014-03-11','00:21:14'),('qtyfjkwxvtbdzul6jugkx1gd6k4wgf3b82w','SC_EMPLEADO',18,'activo','2014-03-10','22:09:57'),('r8015ru2spwe13ppn32gqsc21piaofmd62u','SC_ADMINISTRADOR',57,'activo','2014-03-10','21:25:16'),('trqwho49lvtnvyrwyqlm0hfi7d48tn8q5z9','SC_CONTRATISTA',16,'activo','2014-03-13','11:00:19'),('tsm82vrjqk1xjjdd6glwuhuujs391rqp3dp','SC_ADMINISTRADOR',1,'activo','2014-03-10','21:21:47'),('x3ttob28g6k02ygqzwl4xzmha24ylimbe44','SC_SUPERINTENDENTE',16,'activo','2014-04-19','19:56:00'),('zfkt65paeqwzqhktxs81xrbx5sf2d3badfh','SC_ADMINISTRADOR',4,'activo','2014-03-10','21:22:17');
/*!40000 ALTER TABLE `rol_opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sesion`
--

DROP TABLE IF EXISTS `sesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesion` (
  `IDsession` varchar(30) NOT NULL,
  `USR_UID` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `fecInicio` date NOT NULL,
  `fecFin` date DEFAULT NULL,
  `hraInicio` time NOT NULL,
  `hraFin` time DEFAULT NULL,
  `dirIp` varchar(40) NOT NULL,
  PRIMARY KEY (`IDsession`),
  KEY `USR_UID` (`USR_UID`),
  KEY `USR_UID_2` (`USR_UID`),
  CONSTRAINT `sesion_ibfk_1` FOREIGN KEY (`USR_UID`) REFERENCES `usuario` (`USR_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesion`
--

LOCK TABLES `sesion` WRITE;
/*!40000 ALTER TABLE `sesion` DISABLE KEYS */;
INSERT INTO `sesion` VALUES ('01tju01m3lnilifl3td3234ff4','adolfo2013947','adolfo','2014-04-08','2014-04-08','17:42:00','17:56:17','127.0.0.1'),('07cnu3phin5b5i5e9tf3dltqe2','giovani2013290','giovani','2014-06-02','2014-06-02','10:18:01','11:03:16','127.0.0.1'),('08a59u1dlbm7ppfob16ior11b5','giovani2013290','giovani','2014-05-04','2014-05-04','20:53:25','21:56:52','127.0.0.1'),('0begsntd5oqdjhg82igc2i58f7','00000000000000000000000000000001','admin','2014-04-21','2014-04-21','20:22:52','22:24:24','127.0.0.1'),('0e5cogmjl10u3lm788qbpajgj4','00000000000000000000000000000001','admin','2014-03-17','2014-03-17','19:12:04','19:15:57','127.0.0.1'),('0ehbtcrf8krq158aok06eavb14','giovani2013290','giovani','2014-05-12','2014-05-12','10:35:31','14:54:12','127.0.0.1'),('0kcc2be7j7okk7g7b9pa238vd2','00000000000000000000000000000001','admin','2014-03-17','2014-03-17','17:23:19','18:14:20','127.0.0.1'),('0ruqbufvms2nmu8bksl5b60cr6','00000000000000000000000000000001','admin','2014-04-04','2014-04-04','17:04:24','18:29:30','127.0.0.1'),('10un4ssgs3keti0lmbau5i2h02','00000000000000000000000000000001','admin','2014-05-18','2014-05-18','21:46:00','21:46:42','127.0.0.1'),('11qcg1q34tmuc4bns3qsmr54m2','victor2013704','victor','2014-04-22','2014-04-22','20:08:04','20:40:26','127.0.0.1'),('12v0n7n58jibb8i1f9k5u7d9a1','00000000000000000000000000000001','admin','2014-06-10','2014-06-10','20:05:03','21:42:40','127.0.0.1'),('1342jo5hoe2fa3t37neiptipc6','00000000000000000000000000000001','admin','2014-05-30','2014-05-30','18:06:42','21:57:14','127.0.0.1'),('151ao91bm9v7508gno84pf53i1','giovani2013290','giovani','2014-04-29','2014-04-29','17:34:50','18:07:32','127.0.0.1'),('16p01qh4b2fovqscht435af9c4','adolfo2013947','adolfo','2014-04-19','2014-04-19','18:32:08','23:43:55','127.0.0.1'),('17vu6mor9hgu9encjrbmftp9t3','giovani2013290','giovani','2014-05-22','2014-05-22','09:42:59','09:49:14','127.0.0.1'),('19cgn4dat2j25d80gf8s4ih1f4','giovani2013290','giovani','2014-05-05','2014-05-05','18:03:17','19:18:32','127.0.0.1'),('1epnpntdsorjigu8aim3h87721','victor2013704','victor','2014-04-22','2014-04-22','10:54:18','11:37:50','127.0.0.1'),('1fu5cnikguhkf3hdf9t3stcdj0','victor2013704','victor','2014-04-22','2014-04-22','20:40:34','22:35:37','127.0.0.1'),('232ntd8fcsc5fnd21b2njgd1f5','00000000000000000000000000000001','admin','2014-06-18','2014-06-18','08:47:11','08:47:56','127.0.0.1'),('24co5852icdkl34jdt251jhm07','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','16:01:27','16:01:34','127.0.0.1'),('25bspjs9as3msejsm7vki189g6','alexis2013881','alexis','2014-03-25','2014-03-25','17:35:42','17:59:45','127.0.0.1'),('2b5spadb5h70qkj88c4s1hnnh4','00000000000000000000000000000001','admin','2014-03-13','2014-03-13','15:56:36','19:57:20','127.0.0.1'),('2devviva0nprquk1ejr89408l3','giovani2013290','giovani','2014-05-31','2014-06-01','22:51:53','00:56:52','127.0.0.1'),('2fnjmk0vcm8vn4eakjpqfua522','giovani2013290','giovani','2014-06-15','2014-06-15','15:45:36','16:08:52','127.0.0.1'),('2h3fkr79g2gacevm0eeodlekb4','adolfo2013947','adolfo','2014-03-18','2014-03-18','09:30:17','11:37:16','127.0.0.1'),('2heih5hl6pp1labc2ec9ghgbm6','adolfo2013947','adolfo','2014-04-03','2014-04-03','11:47:06','12:55:47','127.0.0.1'),('2iiuis2uofguadrt29dms1lfk6','giovani2013290','giovani','2014-06-07','2014-06-08','19:32:44','14:50:09','127.0.0.1'),('2jrrfil3vvc1qb6sv94m96j460','adolfo2013947','adolfo','2014-04-08','2014-04-08','17:40:38','17:41:51','127.0.0.1'),('2lmuf6ucjnvc1v5i4k5i8f5k54','giovani2013290','giovani','2014-04-18','2014-04-18','11:25:49','11:37:22','127.0.0.1'),('2mprpks9jrqhvp049flc9u8961','giovani2013290','giovani','2014-04-23',NULL,'14:54:51',NULL,'127.0.0.1'),('2oq6uo44fmts5jf771g4s54ou6','victor2013704','victor','2014-04-22','2014-04-22','10:36:59','10:50:23','127.0.0.1'),('2pg9gnnd15abutikt9a7u5cks6','00000000000000000000000000000001','admin','2014-05-07','2014-05-07','18:28:18','19:03:40','127.0.0.1'),('392aqrp09iamal33qv6316vmf7','giovani2013290','giovani','2014-05-10','2014-05-10','22:48:03','23:40:07','127.0.0.1'),('3gk1pkmsjjlfib8tgp0ambsuh7','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','21:30:43','21:31:20','127.0.0.1'),('3h9cnacjshoifvhbapn23736j6','giovani2013290','giovani','2014-05-09','2014-05-09','16:20:48','16:21:23','127.0.0.1'),('3l9qilfp6r3545q3lemik07a03','giovani2013290','giovani','2014-04-27','2014-04-27','17:26:03','22:31:04','127.0.0.1'),('3lfee4tl7953tgtplpjtj5np10','00000000000000000000000000000001','admin','2014-06-10','2014-06-10','10:23:31','11:12:10','127.0.0.1'),('3m43sl7qsv971vjfr1uv5ipra6','00000000000000000000000000000001','admin','2014-06-03','2014-06-03','20:14:39','20:22:33','127.0.0.1'),('40rti4dqmq1fupqvekqsdffg55','00000000000000000000000000000001','admin','2014-06-13','2014-06-13','16:57:04','17:26:58','127.0.0.1'),('43d55j6itv094n4m66f9a8oh54','MPV2013907','mperez','2014-03-31','2014-03-31','19:49:48','21:44:35','127.0.0.1'),('4581ec6vrngv9tgd0st229t3g0','giovani2013290','giovani','2014-04-29','2014-04-29','21:14:16','22:05:37','127.0.0.1'),('490m0npt5kqcu2imaui0mn10r1','giovani2013290','giovani','2014-05-10','2014-05-11','23:47:57','00:57:16','127.0.0.1'),('4973bbqjbl29q3fa8nvmeq2go7','00000000000000000000000000000001','admin','2014-04-02','2014-04-02','10:41:36','11:01:19','127.0.0.1'),('4bdavm2rj3jeig132p8rhrlt85','adolfo2013947','adolfo','2014-04-07','2014-04-07','17:31:14','18:08:40','127.0.0.1'),('4dgq2qbcc59la03vm9dpeg95f2','giovani2013290','giovani','2014-03-27','2014-03-27','21:13:06','21:33:00','127.0.0.1'),('4dijraiith2ctji18baol3pma0','giovani2013290','giovani','2014-04-21','2014-04-21','09:43:54','11:59:34','127.0.0.1'),('4fetr2v63l286nrr2t8kljqee0','giovani2013290','giovani','2014-04-30','2014-04-30','14:38:30','16:11:09','127.0.0.1'),('4hhtuc8350sadjq8s2sj1sb4v1','giovani2013290','giovani','2014-05-16','2014-05-16','17:21:19','18:01:57','127.0.0.1'),('4ifl2deibio4pascohhq706qk3','giovani2013290','giovani','2014-05-27','2014-05-27','17:53:13','18:08:19','127.0.0.1'),('4jg05alj6fck6implcffqolid4','00000000000000000000000000000001','admin','2014-04-01','2014-04-01','11:38:13','14:10:45','127.0.0.1'),('4uacgira14vicbqs3565q69ki5','giovani2013290','giovani','2014-04-29','2014-04-29','15:18:50','16:48:55','127.0.0.1'),('50c1i6daehm9g1i7dmotl61c84','giovani2013290','giovani','2014-03-26','2014-03-26','20:36:46','21:43:38','127.0.0.1'),('510lc4uqp5ottn9isld5c41ef0','giovani2013290','giovani','2014-05-12','2014-05-12','17:47:29','18:54:18','127.0.0.1'),('52uuvedcj8cmq650o4lkskpiu4','alejandro2013727','alejandro','2014-04-16','2014-04-16','10:08:26','13:11:56','127.0.0.1'),('53p822vh1df6rc2jqrs3ot84d4','giovani2013290','giovani','2014-06-04','2014-06-04','17:41:56','18:49:57','127.0.0.1'),('563fjtnl7vcs6ibkj0vq16ae51','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:44:00','16:44:39','127.0.0.1'),('5802oo4msvhr9efhqne36hssd1','00000000000000000000000000000001','admin','2014-04-14','2014-04-14','21:16:41','21:46:14','127.0.0.1'),('5jdq904g4d5f755jvf0707v105','giovani2013290','giovani','2014-05-13','2014-05-13','17:43:04','18:43:17','127.0.0.1'),('5k7a9f46mqhgaeg5c4vv893fe5','giovani2013290','giovani','2014-06-04','2014-06-04','21:14:26','21:35:26','127.0.0.1'),('5o5asvhfsiq1k3eik0lrbq9kb3','00000000000000000000000000000001','admin','2014-03-19','2014-03-19','18:38:29','19:03:18','127.0.0.1'),('5peeq0s87bq536ggin8sce2r35','00000000000000000000000000000001','admin','2014-06-01','2014-06-01','16:08:01','20:39:32','127.0.0.1'),('5tktaltl0el37cbmj2ippvlu40','giovani2013290','giovani','2014-05-03','2014-05-03','21:06:32','22:29:17','127.0.0.1'),('627vh3dl1v23ibt71kmk8hhs51','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:46:38','22:00:36','127.0.0.1'),('6e8b5ljf338pls6t58rhdnbtc7','giovani2013290','giovani','2014-05-06','2014-05-06','17:42:44','18:29:42','127.0.0.1'),('6ip406tkpgnjlt1vd1oa305hr1','giovani2013290','giovani','2014-03-26','2014-03-26','17:47:46','18:19:14','127.0.0.1'),('6mtradu8kk73kndad0275ego13','00000000000000000000000000000001','admin','2014-06-09','2014-06-09','11:49:30','11:50:17','127.0.0.1'),('6ngrhb2sn9omflh68rlus8lpg2','giovani2013290','giovani','2014-06-17','2014-06-18','21:43:26','00:01:18','127.0.0.1'),('6nk4sepkjvngqbvhfv83kvbdc6','00000000000000000000000000000001','admin','2014-06-10',NULL,'18:35:03',NULL,'127.0.0.1'),('6o93lupaledvabhknbbuj1ta56','victor2013704','victor','2014-06-06','2014-06-06','14:51:20','15:59:35','127.0.0.1'),('6pt893ajn4atb8m3qeeld2dcp5','giovani2013290','giovani','2014-03-27','2014-03-27','22:32:00','22:32:33','127.0.0.1'),('743so6vi9flogqav50mqsudcb1','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:36:18','16:37:21','127.0.0.1'),('74uc1j6c0af77flkqvp21qq6p3','giovani2013290','giovani','2014-06-11','2014-06-11','17:38:12','17:54:44','127.0.0.1'),('74vpu4i5i6tb64dmerr8jl8gn2','giovani2013290','giovani','2014-04-25','2014-04-25','15:51:23','22:22:20','127.0.0.1'),('7b1r16gkel3idl8sogfqicnkr0','giovani2013290','giovani','2014-04-23','2014-04-23','17:44:44','17:56:27','127.0.0.1'),('7kjhdcllghqd1m7pf8s3ipjfg3','giovani2013290','giovani','2014-04-30','2014-04-30','17:46:03','18:16:39','127.0.0.1'),('7rckflfh8di4csurpdqdsq58o2','giovani2013290','giovani','2014-05-13','2014-05-13','14:45:16','15:21:47','127.0.0.1'),('7ugh4pmfn3or3cg3hmjl0mu1g6','giovani2013290','giovani','2014-06-01','2014-06-01','15:13:28','16:06:18','127.0.0.1'),('7vpmn5fg4mglagdihje3unqof4','giovani2013290','giovani','2014-06-15','2014-06-15','14:34:05','15:29:44','127.0.0.1'),('812j830obtjm3m06s53udn4lt4','giovani2013290','giovani','2014-06-17','2014-06-17','15:14:34','16:54:30','127.0.0.1'),('824orbpmej5hu5veckboc3ho47','giovani2013290','giovani','2014-04-22','2014-04-22','11:37:54','11:59:49','127.0.0.1'),('865ipsvm9g3psm8reu0cpmke17','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:00:16','16:06:05','127.0.0.1'),('8ape6uoj50t65qvstl2g0c2mh6','giovani2013290','giovani','2014-04-24','2014-04-24','20:25:15','20:28:50','127.0.0.1'),('8cm7nkgt10ad3uhuja96jtlc27','00000000000000000000000000000001','admin','2014-05-02','2014-05-02','11:33:55','11:57:33','127.0.0.1'),('8etb3av9r79186jag5e9060ut0','victor2013704','victor','2014-04-13','2014-04-13','19:06:57','22:28:47','127.0.0.1'),('8h4dfltjq0t8hekf71k55vnb15','victor2013704','victor','2014-04-12','2014-04-12','18:39:10','22:36:54','127.0.0.1'),('8hdev3avmh2b7c6n4vjp20mg80','00000000000000000000000000000001','admin','2014-04-04','2014-04-04','18:29:33','19:12:09','127.0.0.1'),('8q8lbnbjc5hi7fhrhvsnr6btv2','giovani2013290','giovani','2014-06-13','2014-06-13','10:19:09','12:04:06','127.0.0.1'),('8rd75muvlvjhme3q9tv8e49or7','carlos2013472','carlos','2014-04-13','2014-04-13','23:29:55','23:35:07','127.0.0.1'),('92bku2f1lq5jo50doq0mepduc3','giovani2013290','giovani','2014-05-09','2014-05-09','11:57:30','12:01:12','127.0.0.1'),('92qa2pai5ojh68gnat9lfbhli2','hector2013852','hector','2014-03-19','2014-03-19','17:49:24','18:14:46','127.0.0.1'),('936i84k87656qn4jhb57p11ef3','giovani2013290','giovani','2014-03-25','2014-03-25','14:41:58','16:16:53','127.0.0.1'),('9c8ofo2u76oemt3ta80tmn88o3','giovani2013290','giovani','2014-05-03','2014-05-03','21:01:39','21:05:41','127.0.0.1'),('9cdb9f293p5pchenenanr9s3n6','giovani2013290','giovani','2014-03-27','2014-03-27','17:25:40','21:12:47','127.0.0.1'),('9cf4qp7ol6r882t998bmjtb742','00000000000000000000000000000001','admin','2014-03-26','2014-03-26','18:21:01','18:28:46','127.0.0.1'),('9dg9o2k0jpt0guso4j48r9cds0','victor2013704','victor','2014-04-07','2014-04-07','09:35:10','11:27:38','127.0.0.1'),('9e6sbenhbrk4ebkmn6rgirkf01','adolfo2013947','adolfo','2014-04-11','2014-04-11','10:26:31','22:02:50','127.0.0.1'),('9jpu9h3ghdsvds55oob11ajfe4','alexis2013881','alexis','2014-03-24','2014-03-24','20:47:08','22:10:09','127.0.0.1'),('9k77s14l0cae8sbl1iep7hp6s2','MPV2013907','mperez','2014-06-14','2014-06-15','23:03:39','00:16:03','127.0.0.1'),('9lgq7v292saguelshqi4l1vah5','giovani2013290','giovani','2014-05-23','2014-05-23','15:29:08','16:25:40','127.0.0.1'),('9lsq2m96hsj2o8inpviqt4i5f5','00000000000000000000000000000001','admin','2014-06-21',NULL,'11:16:39',NULL,'127.0.0.1'),('a0a6r9dh1ds58a85kouh6okrv0','carlos2013472','carlos','2014-05-16','2014-05-16','20:10:59','21:57:48','127.0.0.1'),('a5bq5sb4bgqv3bm7v72ldsdnt1','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:06:20','16:34:23','127.0.0.1'),('a76tp8ffpkf1011hrr7ec22c37','00000000000000000000000000000001','admin','2014-06-10','2014-06-10','15:53:33','16:42:13','127.0.0.1'),('a7mknholac6ak8lp1u75o880j4','giovani2013290','giovani','2014-05-14','2014-05-14','15:03:13','16:45:42','127.0.0.1'),('a82d9tofefjjslmqumf3ccs4a4','giovani2013290','giovani','2014-05-07','2014-05-07','18:04:10','18:28:16','127.0.0.1'),('a98ptr1956cb8sqjrnj9u6q437','giovani2013290','giovani','2014-05-11','2014-05-11','22:29:29','22:39:56','127.0.0.1'),('aari0n8o88ki2di0rka91edhp3','hector2013852','hector','2014-03-22','2014-03-22','11:46:15','11:46:30','127.0.0.1'),('ah1m7s1jt839qv6135ale20rg5','00000000000000000000000000000001','admin','2014-03-30','2014-03-30','15:03:24','22:39:36','127.0.0.1'),('akslkh329qk7b8n85qfe27ncs0','giovani2013290','giovani','2014-05-03','2014-05-03','20:32:02','21:01:33','127.0.0.1'),('alaci519o1lk1ni7qu0toqgl52','adolfo2013947','adolfo','2014-04-07','2014-04-07','18:08:45','18:44:32','127.0.0.1'),('all06j6a35u866bqrqae0cm1s5','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','15:58:20','15:59:47','127.0.0.1'),('b1fhhsjhfigjbvn5jd35ipvmi3','00000000000000000000000000000001','admin','2014-06-09','2014-06-09','17:47:56','18:20:26','127.0.0.1'),('b262eh8uq00b36b9cc459kvgv6','MPV2013907','mperez','2014-03-29','2014-03-29','18:02:39','18:04:52','127.0.0.1'),('b4up56u87ql1p6u2mgbdshl0k1','00000000000000000000000000000001','admin','2014-03-25',NULL,'20:46:44',NULL,'127.0.0.1'),('b5oqbu2onjrmjg4gadkd7i5av6','alejandro2013727','alejandro','2014-03-29','2014-03-29','16:32:41','21:27:46','127.0.0.1'),('b5v0lfhces0liluv7tj2rfip03','giovani2013290','giovani','2014-04-30','2014-04-30','16:11:14','16:18:08','127.0.0.1'),('bakirumun2h547viqlk1ah3pd0','00000000000000000000000000000001','admin','2014-04-22','2014-04-22','09:49:08','10:36:53','127.0.0.1'),('bdsb5q797on14pskloe571mv02','giovani2013290','giovani','2014-05-21','2014-05-21','19:03:34','19:04:26','127.0.0.1'),('bl729sbs9u2ecttl2fa3eskdq7','victor2013704','victor','2014-04-06','2014-04-06','17:22:32','20:11:20','127.0.0.1'),('bpsigv86n0eb3tdes4khlsc122','giovani2013290','giovani','2014-05-05','2014-05-05','17:41:16','18:02:21','127.0.0.1'),('bs2afi8f140f73igcqi1onlp14','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','16:12:35','16:18:43','127.0.0.1'),('bsnaq937f7pa8oamio5rvs5oq6','giovani2013290','giovani','2014-03-26','2014-03-26','19:30:46','20:35:27','127.0.0.1'),('bvjho3voml019b8ddl6d0980t6','giovani2013290','giovani','2014-05-31','2014-05-31','16:32:33','22:50:02','127.0.0.1'),('c43gjnd91qgetsdcqctl7p5pv7','giovani2013290','giovani','2014-03-23','2014-03-23','18:25:11','21:33:14','127.0.0.1'),('c4m4ghd953re8e400ekjtc9h35','giovani2013290','giovani','2014-04-21','2014-04-21','14:39:16','16:43:26','127.0.0.1'),('c9lck5opugtmhe5plauvm293u2','giovani2013290','giovani','2014-06-04','2014-06-04','14:35:52','16:37:02','127.0.0.1'),('calqrm4g3g8bnglrmd3i8tvla0','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','15:15:36','15:17:58','127.0.0.1'),('caoi9t3gdei71hl4567n18pv06','giovani2013290','giovani','2014-05-14','2014-05-14','17:45:43','18:20:59','127.0.0.1'),('cillvkus1k7278ic8245vh5m55','giovani2013290','giovani','2014-05-19','2014-05-19','17:40:37','18:53:34','127.0.0.1'),('ck6simdjgmoomb8cro8cpa0jr3','adolfo2013947','adolfo','2014-06-17','2014-06-17','19:04:48','21:41:22','127.0.0.1'),('cmi2ljg05rtcjlilrgf6rle2n5','00000000000000000000000000000001','admin','2014-03-28','2014-03-28','01:03:58','01:04:28','127.0.0.1'),('cpdekav9ba8t39g4p6lds757r0','giovani2013290','giovani','2014-05-21','2014-05-21','15:21:42','16:53:41','127.0.0.1'),('cppf3f6ckhs2bbs21fupm7fgc6','giovani2013290','giovani','2014-05-25','2014-05-25','19:26:46','21:30:32','127.0.0.1'),('cqolk4dac2gb50vcapic2f8gl4','00000000000000000000000000000001','admin','2014-03-12','2014-03-12','18:34:17','19:01:45','127.0.0.1'),('cqq46si3jgfb7j3894q22mgl97','00000000000000000000000000000001','admin','2014-04-25','2014-04-25','22:48:41','22:49:36','127.0.0.1'),('d4v3b44bo7bfa503iqcl85ub67','giovani2013290','giovani','2014-05-14','2014-05-14','09:26:34','11:58:33','127.0.0.1'),('d539mo5npb7bbrktvc95dmvfn4','giovani2013290','giovani','2014-05-04','2014-05-04','18:00:52','20:52:23','127.0.0.1'),('d73cg6bkcgs77i2f5ikj5irjs5','MPV2013907','mperez','2014-03-17','2014-03-17','14:28:35','15:55:30','127.0.0.1'),('dcmtu66ci3rvn30jqbvqku2n47','MPV2013907','mperez','2014-06-14','2014-06-14','17:10:31','18:50:41','127.0.0.1'),('ddq9bgvf50o03tdp30jfvd7652','victor2013704','victor','2014-06-16','2014-06-16','09:38:20','11:32:09','127.0.0.1'),('df5jfj6eotbjfmne38t1nsk0r0','giovani2013290','giovani','2014-06-11','2014-06-11','15:24:48','16:29:20','127.0.0.1'),('dhe99pn72r08rc9kfbu65l11v6','00000000000000000000000000000001','admin','2014-03-21',NULL,'12:47:57',NULL,'127.0.0.1'),('dituqvvunar0qh6vptr5u5lpa2','adolfo2013947','adolfo','2014-04-08','2014-04-08','12:56:56','15:59:27','127.0.0.1'),('dk2j2713p5stscgavek0oijsb2','giovani2013290','giovani','2014-04-30','2014-04-30','16:33:04','16:35:25','127.0.0.1'),('dkcp4nc57o26jk2or3fgtga0a3','carlos2013472','carlos','2014-05-16','2014-05-16','09:47:20','11:24:55','127.0.0.1'),('dniipvelfjeh53bf89kr1c4pf0','giovani2013290','giovani','2014-05-06','2014-05-06','11:18:41','12:11:58','127.0.0.1'),('dpb82mlahq5c0vaoqfneqvjc43','giovani2013290','giovani','2014-06-02','2014-06-02','17:32:30','19:24:57','127.0.0.1'),('drk0d69fvqb0ipf6jmk27q5s61','alejandro2013727','alejandro','2014-03-31','2014-03-31','10:12:58','12:10:54','127.0.0.1'),('dsvp2ccuiqf22ns2jasgclorr6','giovani2013290','giovani','2014-05-08','2014-05-08','22:03:33','22:04:58','127.0.0.1'),('e2bpfgd9ti0060j7im909t14d3','giovani2013290','giovani','2014-04-21','2014-04-21','17:36:46','18:04:11','127.0.0.1'),('e67pfhc82c6sggs12jqv3his44','adolfo2013947','adolfo','2014-04-07','2014-04-07','16:28:51','16:32:14','127.0.0.1'),('e8gg5sqlhqfjptqqtlrdcr1a75','hreyes2014107','hreyes','2014-06-10','2014-06-10','12:40:26','13:06:56','127.0.0.1'),('e9j8gddj4c9rcbu30jb75e83e2','giovani2013290','giovani','2014-06-11','2014-06-11','18:20:00','18:33:47','127.0.0.1'),('eeihs2vbv9ask6e4a1tgnavjg2','giovani2013290','giovani','2014-05-28','2014-05-28','17:40:43','18:26:27','127.0.0.1'),('eht6cgs0lmcckuon0e3cfrvkp3','hector2013852','hector','2014-05-20','2014-05-20','09:33:03','10:58:36','127.0.0.1'),('ejpd8vggb6lma57dhsmie61tk1','00000000000000000000000000000001','admin','2014-03-28',NULL,'00:58:26',NULL,'127.0.0.1'),('ep1asmgecamdbarsgirjg4rij6','giovani2013290','giovani','2014-05-09','2014-05-09','16:22:09','20:40:14','127.0.0.1'),('ernh8r754shiep2s4jsmtrjcr7','giovani2013290','giovani','2014-04-26','2014-04-26','16:36:10','20:51:13','127.0.0.1'),('eroej79d9247o7i25igkst54m5','alexis2013881','alexis','2014-05-05','2014-05-05','11:14:44','12:17:33','127.0.0.1'),('eu57mt9r7o6po44qleg2hloja0','giovani2013290','giovani','2014-04-24','2014-04-24','17:59:33','20:19:58','127.0.0.1'),('f0750qjhntj1hb59tgfikuq577','giovani2013290','giovani','2014-05-21','2014-05-21','18:46:17','19:02:54','127.0.0.1'),('f45ir71b8gikuqteg4d35jp7c4','alejandro2013727','alejandro','2014-03-15','2014-03-15','20:31:10','22:47:33','127.0.0.1'),('f58bqh9qo6irpqc3n7s9jk4gs7','giovani2013290','giovani','2014-05-21','2014-05-21','10:07:45','11:11:31','127.0.0.1'),('f7co84n9di04f774lac2u3dch6','giovani2013290','giovani','2014-05-13','2014-05-13','10:11:11','13:16:17','127.0.0.1'),('fagr38boj026slgri1klia7m26','giovani2013290','giovani','2014-05-28','2014-05-28','15:26:52','16:53:15','127.0.0.1'),('fjc1fg7ft69u36sku7c9vq9la0','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','17:14:11','17:19:17','127.0.0.1'),('flq8ebjqg7sgc4ehl0innkbdd7','adolfo2013947','adolfo','2014-04-09','2014-04-09','11:25:38','11:53:48','127.0.0.1'),('fqabriqqr3jmputa05g854d4q4','giovani2013290','giovani','2014-06-16','2014-06-16','17:38:57','18:03:57','127.0.0.1'),('fr4skruic6d8jpl77en37h92o6','giovani2013290','giovani','2014-05-25','2014-05-25','22:40:52','22:42:58','127.0.0.1'),('fsijn9ojr9habf467mbacljgk3','giovani2013290','giovani','2014-04-25','2014-04-25','10:57:44','11:40:24','127.0.0.1'),('fu6h88m84ioht1393o70ueg9p6','00000000000000000000000000000001','admin','2014-03-13','2014-03-13','10:41:37','12:23:52','127.0.0.1'),('g1l9r25rhnatai0g9ld7fi8au2','giovani2013290','giovani','2014-06-16','2014-06-16','14:37:01','15:30:59','127.0.0.1'),('g3gm15c6m2kmiojg7ntijf3244','MPV2013907','mperez','2014-06-15','2014-06-15','13:24:39','14:15:21','127.0.0.1'),('g3luob876bsu8c9f8dvvplog22','carlos2013472','carlos','2014-04-14','2014-04-14','09:38:04','11:28:47','127.0.0.1'),('g4o26enstmmsff1o1u3ge8dtu4','giovani2013290','giovani','2014-04-15','2014-04-15','17:42:19','18:05:15','127.0.0.1'),('g61q6heepidboo0r2qilo44l20','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:36:39','16:36:49','127.0.0.1'),('gbquea2rc6r5q540b4ur85erl5','giovani2013290','giovani','2014-05-25','2014-05-25','17:34:14','19:25:55','127.0.0.1'),('gdcstel1ul3cgnkhddctg7ffi0','giovani2013290','giovani','2014-05-21','2014-05-21','11:35:42','12:09:58','127.0.0.1'),('ghuaatgmviu56s2qesgrgi1qv3','giovani2013290','giovani','2014-05-20','2014-05-20','14:56:15','16:38:27','127.0.0.1'),('gkip1qs3col645knqtr2avs624','giovani2013290','giovani','2014-06-15','2014-06-15','16:17:30','20:45:55','127.0.0.1'),('gkkskp94nciiv9h26csgh2dc33','00000000000000000000000000000001','admin','2014-03-12','2014-03-12','10:18:49','15:08:16','127.0.0.1'),('gup4ej01q371d972ilnfk4c3c7','giovani2013290','giovani','2014-04-30',NULL,'16:21:27',NULL,'127.0.0.1'),('h5okqf12od6npl07t9q8u96dc3','giovani2013290','giovani','2014-06-21','2014-06-21','17:20:15','17:31:12','127.0.0.1'),('h7eaiqdsdk49dmejk69a5inga6','mescobar2013649','mescobar','2014-03-14','2014-03-14','14:51:09','19:19:59','127.0.0.1'),('hout4ljif9t3euoi8ph3m9a7l2','giovani2013290','giovani','2014-06-16','2014-06-16','20:13:02','21:23:45','127.0.0.1'),('i2ucgckgnq5tt4kjci0iqgp2t1','giovani2013290','giovani','2014-06-07','2014-06-07','16:11:42','19:31:21','127.0.0.1'),('i4p578irvqulhtth6g5kkecbc7','giovani2013290','giovani','2014-03-31','2014-03-31','17:25:33','18:24:06','127.0.0.1'),('i74l9pdpr071ogbvl3k1hgole6','giovani2013290','giovani','2014-06-02','2014-06-02','11:42:06','12:12:23','127.0.0.1'),('i85f93ufkmhs5p2n1d2ne24rb2','00000000000000000000000000000001','admin','2014-04-04','2014-04-04','19:12:13','19:20:31','127.0.0.1'),('i8ngnmvsfgep7b7mefapfilki4','00000000000000000000000000000001','admin','2014-03-24','2014-03-24','17:29:44','18:59:24','127.0.0.1'),('il7fggkj188qpds2dhg08s09f7','giovani2013290','giovani','2014-04-15','2014-04-15','20:28:14','21:56:30','127.0.0.1'),('im0g2kdfnt9241o096v9q6lm65','victor2013704','victor','2014-04-22','2014-04-22','20:04:43','20:04:46','127.0.0.1'),('imtb7h98ak9tfkhjqn6vdhs2a3','giovani2013290','giovani','2014-06-02','2014-06-02','11:03:23','11:41:58','127.0.0.1'),('imtcjjalb5s3gomrdmcm9gtg37','giovani2013290','giovani','2014-06-14','2014-06-14','11:23:26','12:21:55','127.0.0.1'),('iql34bilcrrnv298tv0jbjc7q7','00000000000000000000000000000001','admin','2014-06-15','2014-06-15','16:08:44','16:17:26','127.0.0.1'),('itgkurftdvm38i54ctsc4lmvr3','giovani2013290','giovani','2014-05-11','2014-05-11','14:31:27','16:29:46','127.0.0.1'),('iu68nnih2cjv6q7isv8ueb3s73','adolfo2013947','adolfo','2014-03-19','2014-03-19','15:08:22','16:58:08','127.0.0.1'),('iuc52lqh77rf2uu4tnh7irpm33','00000000000000000000000000000001','admin','2014-06-22',NULL,'16:16:01',NULL,'127.0.0.1'),('j3neb9egjais8n04d6nuhref57','giovani2013290','giovani','2014-04-29','2014-04-29','10:29:49','11:54:52','127.0.0.1'),('jbepamfemm0tcfiprv2u011vb5','giovani2013290','giovani','2014-05-07','2014-05-07','17:49:31','18:01:00','127.0.0.1'),('jcvl0a4e3vkvd4fud3lkmjrrb5','00000000000000000000000000000001','admin','2014-05-19','2014-05-19','21:50:41','21:58:22','127.0.0.1'),('jd25b9t5mocerf0bn4vb85js12','MPV2013907','mperez','2014-03-26','2014-03-26','10:08:26','10:10:14','127.0.0.1'),('jg6tobhcalcgqdniabka41jv36','carlos2013472','carlos','2014-05-17','2014-05-17','09:44:02','12:14:30','127.0.0.1'),('jhkrr6bucu8u21rjbp9m3v3047','giovani2013290','giovani','2014-06-01','2014-06-01','20:40:09','21:59:34','127.0.0.1'),('jipu13ll5artgfbs6hc5qq4ik5','adolfo2013947','adolfo','2014-03-18','2014-03-18','13:59:25','16:26:42','127.0.0.1'),('jpr7iant9egqr6v3hvr8ujl8d2','giovani2013290','giovani','2014-03-27','2014-03-27','16:24:05','16:37:47','127.0.0.1'),('jqv2ud84j48fa3u39v94dq58q4','adolfo2013947','adolfo','2014-04-03','2014-04-03','15:06:53','22:01:48','127.0.0.1'),('js06qrspesgrfsii4ccrrov1t7','giovani2013290','giovani','2014-05-13','2014-05-13','13:17:12','13:30:04','127.0.0.1'),('jsrr1vns0c24p27uunujhv5524','hector2013852','hector','2014-03-22','2014-03-22','11:44:04','11:44:11','127.0.0.1'),('k6b34ffet8vh5if0r6m6igd046','giovani2013290','giovani','2014-06-11','2014-06-11','10:58:35','12:00:46','127.0.0.1'),('kckldmt4btt0o64g4h7874djk6','victor2013704','victor','2014-04-22','2014-04-22','12:01:34','13:04:42','127.0.0.1'),('kh970nghhn4ubk7m4qo8g9j2p0','hector2013852','hector','2014-05-24','2014-05-24','22:10:58','23:20:59','127.0.0.1'),('kpd18rad33clrmlagrhf670ei2','00000000000000000000000000000001','admin','2014-06-09','2014-06-09','20:43:57','21:05:27','127.0.0.1'),('l3156h77g2o5io2k0ske0rsf30','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','15:55:59','15:57:04','127.0.0.1'),('l4bt6a18vrtat5qfuhtt7qknu0','giovani2013290','giovani','2014-06-03','2014-06-03','15:15:32','16:26:18','127.0.0.1'),('l5lt3f411u2jd5stpr0lhrh833','adolfo2013947','adolfo','2014-04-04','2014-04-04','20:12:22','20:47:45','127.0.0.1'),('l6vvoql3fp310m2gphvu8chft6','00000000000000000000000000000001','admin','2014-06-04','2014-06-04','10:40:31','11:40:15','127.0.0.1'),('l7ajnmuf0qfjke6td451ocm5v4','adolfo2013947','adolfo','2014-04-05','2014-04-05','16:37:56','21:19:09','127.0.0.1'),('l7iph3kq6mvv5amg85egcqluq1','giovani2013290','giovani','2014-05-21','2014-05-21','17:39:34','18:44:18','127.0.0.1'),('lgpdckj075qqgga88ec072c4v7','giovani2013290','giovani','2014-06-08','2014-06-08','14:35:32','20:58:16','127.0.0.1'),('liv69isus6c0s6uhvnn6ddlta3','adolfo2013947','adolfo','2014-03-18','2014-03-18','12:33:55','12:53:03','127.0.0.1'),('lk7g16441th4mmqs42d7kjij32','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','16:11:48','16:12:14','127.0.0.1'),('llvicb408pcdfra6h6kgq4ed07','alexis2013881','alexis','2014-03-24','2014-03-24','09:20:36','16:16:48','127.0.0.1'),('lmgc3ol63lss213eilsovagnt4','carlos2013472','carlos','2014-05-10','2014-05-10','20:32:44','21:26:00','127.0.0.1'),('loii2nmi9b0j5id4p2udgs3l47','00000000000000000000000000000001','admin','2014-03-19','2014-03-19','18:14:50','18:17:31','127.0.0.1'),('m3hn2jsrcof22biko77gqlgsi0','giovani2013290','giovani','2014-04-24','2014-04-24','14:55:06','17:13:05','127.0.0.1'),('mclbolj19dsv02i2s1080qflt2','giovani2013290','giovani','2014-03-26','2014-03-26','16:55:32','17:15:46','127.0.0.1'),('mcupqicj4oi9ms2onj861hofn1','00000000000000000000000000000001','admin','2014-04-30',NULL,'16:31:51',NULL,'127.0.0.1'),('meq7g4svnuq9msvl6sagk1qc84','giovani2013290','giovani','2014-06-03','2014-06-03','10:28:00','12:42:01','127.0.0.1'),('mg9s9v233i9dpmdodn4vcm2bs2','hector2013852','hector','2014-03-19','2014-03-19','18:17:37','18:38:25','127.0.0.1'),('mhupoumbeug3d2a2b09fqh7hk7','00000000000000000000000000000001','admin','2014-06-05','2014-06-05','18:42:27','21:59:57','127.0.0.1'),('mmjq9ou3ds2mhu5g7tfshugdh7','adolfo2013947','adolfo','2014-04-01','2014-04-01','17:46:43','18:32:02','127.0.0.1'),('mr95qd6h1mjm26skg60aa6n9j1','giovani2013290','giovani','2014-04-16','2014-04-16','15:02:11','16:28:52','127.0.0.1'),('mubdi6dgh92lbqjtno3mcmq4h4','victor2013704','victor','2014-04-22','2014-04-22','10:50:29','10:54:13','127.0.0.1'),('nab5g0n7iok3bo251unlv9m304','giovani2013290','giovani','2014-06-13','2014-06-13','20:02:23','21:46:07','127.0.0.1'),('nc0iv0vgkd9ja55gc4759mq460','giovani2013290','giovani','2014-05-13','2014-05-13','19:58:06','22:00:11','127.0.0.1'),('nc2hltcs27oc0a9c2s3eu678g2','giovani2013290','giovani','2014-05-02','2014-05-02','15:58:30','17:52:10','127.0.0.1'),('nde1d6dgmhdvnni1jhorgmtgg1','giovani2013290','giovani','2014-06-11','2014-06-11','18:35:33','18:36:49','127.0.0.1'),('nib17u4c57sn5ca761vcges6g5','giovani2013290','giovani','2014-05-06','2014-05-06','09:42:35','11:17:31','127.0.0.1'),('njm70j244tladej7bbjjfv9635','MPV2013907','mperez','2014-03-14','2014-03-14','08:45:34','11:24:38','127.0.0.1'),('nl4fmprg5m0chv81l3f2lmlmh5','giovani2013290','giovani','2014-04-24','2014-04-24','17:15:01','17:47:00','127.0.0.1'),('no700igdj5dhlifh4rglvd8eq4','giovani2013290','giovani','2014-05-26','2014-05-26','10:39:50','13:03:14','127.0.0.1'),('o23ho4jlbtf2gbuja53aa2gca1','00000000000000000000000000000001','admin','2014-06-05','2014-06-05','10:46:24','12:32:08','127.0.0.1'),('o27d5m4oc2b1hc661ip30utb05','alejandro2013727','alejandro','2014-04-06','2014-04-06','20:26:56','21:36:11','127.0.0.1'),('o2l7c3vpevd0f8np53le46aud4','alexis2013881','alexis','2014-03-25','2014-03-25','10:37:42','12:26:08','127.0.0.1'),('o3kgk3g32rp6af5et1sqm5i683','giovani2013290','giovani','2014-05-11','2014-05-11','16:31:49','22:28:18','127.0.0.1'),('o3khtf0q88ddvqhu8uvueqb6h1','giovani2013290','giovani','2014-06-21','2014-06-21','17:33:42','23:03:44','127.0.0.1'),('o932pa7o35e089kocf1e8bjh51','giovani2013290','giovani','2014-04-15','2014-04-15','14:41:25','16:36:24','127.0.0.1'),('o9h8j9ij5tf4fjg31eq6vroll5','00000000000000000000000000000001','admin','2014-03-25','2014-03-25','20:48:34','22:02:23','127.0.0.1'),('ocsuhu6pq51r4ve64dcog3t7u6','giovani2013290','giovani','2014-05-28','2014-05-28','10:21:01','12:41:58','127.0.0.1'),('odspnv5djdke7voluduvknua51','giovani2013290','giovani','2014-04-20','2014-04-21','15:28:28','00:06:16','127.0.0.1'),('oepjg7gab0q87v0jg306rfhe33','00000000000000000000000000000001','admin','2014-05-30','2014-05-30','11:49:31','11:50:11','127.0.0.1'),('oj7009lbjebltt1dukag8s3ee0','giovani2013290','giovani','2014-05-07','2014-05-07','09:46:35','12:38:09','127.0.0.1'),('okmaj9j1ogqfel5aqrq827ll36','giovani2013290','giovani','2014-05-06','2014-05-06','15:44:58','16:56:50','127.0.0.1'),('omd9sf2o4sgm5gksala066ao07','00000000000000000000000000000001','admin','2014-06-10',NULL,'18:10:22',NULL,'127.0.0.1'),('on2m6gqpuo32g1d6heqqbgenr6','00000000000000000000000000000001','admin','2014-03-22','2014-03-23','20:17:56','00:27:31','127.0.0.1'),('oov6uscvveaahd5ggqt626b0s1','giovani2013290','giovani','2014-05-10','2014-05-10','18:53:46','20:32:38','127.0.0.1'),('osodm96nibt7civg1vcs6q3t24','giovani2013290','giovani','2014-05-03','2014-05-03','17:21:30','18:02:08','127.0.0.1'),('p1ob21ictjrfrf8rabrcnbpd95','00000000000000000000000000000001','admin','2014-05-26','2014-05-26','15:39:32','16:43:21','127.0.0.1'),('p86vsp7nc2fkafh2i0hqo57e94','00000000000000000000000000000001','admin','2014-06-09','2014-06-09','10:48:14','10:48:17','127.0.0.1'),('phov3hapoa29cancvl23rvun72','victor2013704','victor','2014-04-14','2014-04-14','17:44:56','18:37:34','127.0.0.1'),('pqo2ca4rbc01smgncgs54sp4t3','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','16:37:46','16:43:39','127.0.0.1'),('ps2s8kklddpmn2kubjfjim8iu2','carlos2013472','carlos','2014-05-16','2014-05-16','18:03:48','19:12:30','127.0.0.1'),('ps4qm3d6i0sm5fk2hgjner19r7','00000000000000000000000000000001','admin','2014-03-24','2014-03-24','16:33:06','16:34:16','127.0.0.1'),('pufr252166du6lni160blqi9d7','giovani2013290','giovani','2014-05-23','2014-05-23','16:37:33','18:06:13','127.0.0.1'),('pum0hro3c2ehefefeis6bvjfs2','00000000000000000000000000000001','admin','2014-06-03','2014-06-03','23:17:34','23:17:51','127.0.0.1'),('q3iq937mr0p55d5khvb950h8d1','giovani2013290','giovani','2014-04-30','2014-04-30','08:51:19','12:40:01','127.0.0.1'),('q5oab9o4rkgr38pf7q2bbitsm5','00000000000000000000000000000001','admin','2014-03-25','2014-03-25','20:06:42','20:14:29','127.0.0.1'),('qapqsoliql6jgerg3vjriq31d7','alejandro2013727','alejandro','2014-03-28','2014-03-28','18:32:22','21:41:27','127.0.0.1'),('qd8o0v0sa0hj8ub5qjvm25u9k1','carlos2013472','carlos','2014-05-13','2014-05-13','15:22:36','17:01:42','127.0.0.1'),('qelof66e8nqp0g2fodk3alvkv0','giovani2013290','giovani','2014-04-19','2014-04-19','15:35:54','17:10:55','127.0.0.1'),('qi0ghos0mrdsrjqobm4t7lene0','giovani2013290','giovani','2014-03-30','2014-03-30','22:42:21','22:42:32','127.0.0.1'),('qj6tagm1d0t8kmtcckr1h5hqq7','mescobar2013649','mescobar','2014-03-15','2014-03-15','11:19:45','13:57:14','127.0.0.1'),('qn0laq9nutstt2v0ou54dhvqg7','00000000000000000000000000000001','admin','2014-04-08','2014-04-08','09:19:25','12:55:47','127.0.0.1'),('qtn71fmg3o06aigpt6m316efk1','giovani2013290','giovani','2014-06-21','2014-06-21','10:51:24','11:11:30','127.0.0.1'),('qvjir0bs5nbaqn8ie8qtjeejd7','adolfo2013947','adolfo','2014-06-17','2014-06-17','10:21:54','11:20:25','127.0.0.1'),('r4v31q9g6d1m217nj5q8d993c5','giovani2013290','giovani','2014-04-23','2014-04-23','15:56:56','16:51:46','127.0.0.1'),('rbmav38b57jl1i9cj9pbnt6oe1','giovani2013290','giovani','2014-05-07','2014-05-07','14:58:05','16:40:26','127.0.0.1'),('re125sa1k1i1iuuue49jcekpk4','00000000000000000000000000000001','admin','2014-03-25','2014-03-25','20:28:00','20:41:26','127.0.0.1'),('rmltis3se9fqiukriq2d2hfab1','alexis2013881','alexis','2014-03-16','2014-03-16','20:25:52','21:22:04','127.0.0.1'),('rng3nbhruhn98bohvdlttveqd2','00000000000000000000000000000001','admin','2014-06-09','2014-06-09','16:04:24','16:22:47','127.0.0.1'),('rnogti7pqomktjmnfph97tt795','carlos2013472','carlos','2014-04-14','2014-04-14','15:38:09','16:26:44','127.0.0.1'),('rr0faqco1apr5hh24kjjbl04r5','MPV2013907','mperez','2014-03-17','2014-03-17','15:59:30','16:08:59','127.0.0.1'),('rsvqrecqmcld1gkl8kqt2nqq40','giovani2013290','giovani','2014-06-12','2014-06-12','18:11:27','21:40:21','127.0.0.1'),('rtvqopdsdnqgr0foaging6et21','victor2013704','victor','2014-04-22','2014-04-22','19:13:07','19:45:03','127.0.0.1'),('s2p5kam650ij2n3osec8f2u5q0','giovani2013290','giovani','2014-04-28','2014-04-28','14:58:03','18:11:53','127.0.0.1'),('s7vhpf29np8tfdvj0psntrklq4','giovani2013290','giovani','2014-06-03','2014-06-03','17:41:58','18:07:22','127.0.0.1'),('s87dlrgb6mo6d45gj72u8rqh23','adolfo2013947','adolfo','2014-04-08','2014-04-08','18:20:14','18:42:07','127.0.0.1'),('sl28if9qea4k1g9egi2c1jcre2','victor2013704','victor','2014-04-23','2014-04-23','09:57:14','12:27:38','127.0.0.1'),('sm85mrcatj05c1h5r3qmautsq3','giovani2013290','giovani','2014-06-18','2014-06-18','00:02:49','01:46:47','127.0.0.1'),('sn2nh3rtqangtufj0tlvbveq83','giovani2013290','giovani','2014-04-28','2014-04-28','11:41:41','12:56:52','127.0.0.1'),('snobe9inknkfl0oedv9s89nia1','victor2013704','victor','2014-06-17','2014-06-17','17:39:23','18:18:07','127.0.0.1'),('sq48isrrnhbcf2hkr39omff996','adolfo2013947','adolfo','2014-04-08','2014-04-08','21:51:56','22:19:43','127.0.0.1'),('sq61gigflud3t42vgjdnm7oaq0','giovani2013290','giovani','2014-05-09','2014-05-09','11:20:05','11:55:03','127.0.0.1'),('ss3of1cpplsv31tg2592fs0m76','00000000000000000000000000000001','admin','2014-03-22','2014-03-22','11:49:41','11:52:33','127.0.0.1'),('su2isve3pacll11hs60c5fhtu2','00000000000000000000000000000001','admin','2014-04-07','2014-04-07','14:53:42','16:22:55','127.0.0.1'),('t2spobdgor7jd2rq40tlfi1sq1','00000000000000000000000000000001','admin','2014-06-16','2014-06-16','21:34:50','21:34:57','127.0.0.1'),('t61htqpfucdp7flva4i4f6htq7','00000000000000000000000000000001','admin','2014-03-21','2014-03-21','16:46:29','18:57:51','127.0.0.1'),('t6s8qplsraubmj8f1qqko9o8f2','00000000000000000000000000000001','admin','2014-06-10','2014-06-10','19:16:24','19:19:25','127.0.0.1'),('t95f1vk3dt7goj20p43go8kjd7','giovani2013290','giovani','2014-05-03','2014-05-03','18:03:32','20:29:08','127.0.0.1'),('timoco859b23hcpunhhoc9g186','giovani2013290','giovani','2014-06-14','2014-06-14','13:09:03','13:27:20','127.0.0.1'),('tqq1p6b0d8v09rcaq927dm8u03','00000000000000000000000000000001','admin','2014-03-15','2014-03-15','10:43:35','11:08:54','127.0.0.1'),('tuu6u7kr2n6ulheoltgvgu3n62','giovani2013290','giovani','2014-04-26','2014-04-26','20:52:04','22:41:33','127.0.0.1'),('u2n1m5sn5f1n26c0l6o33a27g2','giovani2013290','giovani','2014-05-25','2014-05-25','14:55:21','17:33:02','127.0.0.1'),('u3a41dckn009jfn7e057mok335','giovani2013290','giovani','2014-05-20','2014-05-20','17:48:29','18:52:53','127.0.0.1'),('u3kgg2epccsj3d0e0pr4b09m37','adolfo2013947','adolfo','2014-03-18','2014-03-18','17:31:28','18:33:28','127.0.0.1'),('u76s527ka7fj3i1o7o604dj3h7','giovani2013290','giovani','2014-05-20','2014-05-20','11:52:44','13:38:03','127.0.0.1'),('udo4drpn8o5f3c6a3i7vjmpmv3','giovani2013290','giovani','2014-03-27','2014-03-27','16:43:31','17:14:26','127.0.0.1'),('uf9uf9cd37c9c3kfb9qsb4bh71','giovani2013290','giovani','2014-05-26','2014-05-26','17:24:00','18:26:40','127.0.0.1'),('ugee12pl9bh28uvoheefr1on23','MPV2013907','mperez','2014-06-11','2014-06-11','17:55:14','18:13:41','127.0.0.1'),('ul2kcm285vpfj195bopnvuech5','adolfo2013947','adolfo','2014-04-08','2014-04-08','17:34:30','17:39:46','127.0.0.1'),('uoep972ci8pvs7i7rqt52sob62','00000000000000000000000000000001','admin','2014-06-21','2014-06-21','15:28:30','15:33:12','127.0.0.1'),('up1co6ksms1tjkuppten2ca853','00000000000000000000000000000001','admin','2014-06-06','2014-06-06','15:51:56','16:31:23','127.0.0.1'),('v4gjrci0dnud63gt4p54o8d037','alexis2013881','alexis','2014-03-31','2014-03-31','14:53:15','16:16:11','127.0.0.1'),('v5sej8ipahc6g14vft34olg9f3','giovani2013290','giovani','2014-05-15','2014-05-15','21:08:21','21:08:48','127.0.0.1'),('v621955meq8jkhph268no9fci2','victor2013704','victor','2014-06-06','2014-06-06','16:35:10','16:35:55','127.0.0.1'),('vcshrpqd9ostb9366mhsss4c66','MPV2013907','mperez','2014-03-18',NULL,'16:32:06',NULL,'127.0.0.1'),('ver80ed93qvldscqho5nkf79h2','user12014770','user1','2014-06-10','2014-06-10','12:18:21','12:40:22','127.0.0.1'),('vg6417o5cg1cv8e7cq5rm9als2','giovani2013290','giovani','2014-03-27','2014-03-27','21:33:05','21:56:38','127.0.0.1'),('vh5lb1r7s7rqn7thrd25h6il66','giovani2013290','giovani','2014-05-19','2014-05-19','10:22:07','11:52:17','127.0.0.1'),('voohhrmmg88n8fnq4c1ode1mq6','00000000000000000000000000000001','admin','2014-04-04','2014-04-04','11:18:04','12:03:25','127.0.0.1'),('vp85d0nag3pbko3cnvmuetlr10','giovani2013290','giovani','2014-05-20','2014-05-20','10:59:22','11:44:12','127.0.0.1'),('vuavcnaic700erfehsaqh315j7','giovani2013290','giovani','2014-06-10','2014-06-10','17:44:31','18:00:09','127.0.0.1'),('vumtabf1i8tjv12g1cd2gr2881','adolfo2013947','adolfo','2014-04-08','2014-04-08','17:56:26','18:20:07','127.0.0.1'),('vvavvi489d3d6cndbsp1kuikm1','MPV2013907','mperez','2014-06-02','2014-06-02','15:47:22','16:11:06','127.0.0.1'),('vvets0je2ket2ui5qfmg2id784','giovani2013290','giovani','2014-03-27','2014-03-27','17:14:35','17:25:35','127.0.0.1');
/*!40000 ALTER TABLE `sesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicita`
--

DROP TABLE IF EXISTS `solicita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicita` (
  `IDsolicitud` varchar(40) NOT NULL,
  `nro` int(11) NOT NULL AUTO_INCREMENT,
  `IDproyecto` varchar(40) NOT NULL,
  `IDpersonalTecnico` varchar(40) NOT NULL,
  `IDcargo_M` varchar(40) NOT NULL,
  `cantidad_solicitada` int(11) NOT NULL,
  `cantidad_contratada` int(11) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `hraSolicitud` time NOT NULL,
  PRIMARY KEY (`IDsolicitud`),
  UNIQUE KEY `nro` (`nro`),
  KEY `CI_trabajador` (`IDproyecto`),
  KEY `IDpersonalTecnico` (`IDpersonalTecnico`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `IDpersonalTecnico_2` (`IDpersonalTecnico`),
  KEY `IDcargo_M` (`IDcargo_M`),
  CONSTRAINT `solicita_ibfk_1` FOREIGN KEY (`IDpersonalTecnico`) REFERENCES `personaltecnico` (`IDpersonalTecnico`),
  CONSTRAINT `solicita_ibfk_2` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`),
  CONSTRAINT `solicita_ibfk_3` FOREIGN KEY (`IDcargo_M`) REFERENCES `cargomanodeobra` (`IDcargoM`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicita`
--

LOCK TABLES `solicita` WRITE;
/*!40000 ALTER TABLE `solicita` DISABLE KEYS */;
INSERT INTO `solicita` VALUES ('0c9vdpesww8mzikhjybmjvl2e3hpswxpabt',6,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','0kje4f9975yaswwy3b9xlsuiy85n97tcrk2',2,2,'Atendido','2014-04-26','16:50:57'),('1c6vx1hxwycbkrmag2riganfcxluky4jyfp',11,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx',8,7,'Pendiente','2014-05-25','15:58:14'),('3toq368qzgwazsmxacgyzxk0vi2vu4ada2b',4,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','74phbgtp8nikjujtclpzq9kt6n61a7rublg',2,2,'Atendido','2014-04-19','22:47:13'),('5bnqsrnzrieam2rnozefcd31mrfxrit9oym',5,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','7hlcvhwqsrunc5scqyv6hboshwqq9bukb61',3,3,'Atendido','2014-04-19','22:47:19'),('9apobd9n8gut23t6yqfh41trt4hq83nz5rg',14,'jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','5r72n047v2zohyecxh6p4eipmuhkfadblb6','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2',2,2,'Atendido','2014-06-15','20:03:22'),('c5obyylbgog6717544k7d5yof97cumsaufj',2,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','hqj1ieanu3aakxjkn38hfv4g5ymmkzspskx',1,1,'Atendido','2014-04-19','22:46:59'),('fmsj70duhtqtpjh1q530mxuea31gmel469j',7,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','x03jwy6uufm3xhlbvixor3a7nj5dnbpd0zc',2,2,'Atendido','2014-04-26','21:00:36'),('gfsi715dp4g5s8378ztnbh1xo3lgiaau4z5',3,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg',3,3,'Atendido','2014-04-19','22:47:07'),('kvmbawzz8atdkqddiuhs8i3h0ukum9x5jvo',12,'jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','5r72n047v2zohyecxh6p4eipmuhkfadblb6','96e1bjs8dqx25v51keashype5e91gnlxkhv',3,3,'Atendido','2014-06-15','20:02:55'),('mtybg2u923osjby2b7mu459alfyubdva8qw',13,'jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g','5r72n047v2zohyecxh6p4eipmuhkfadblb6','5uiq5c9lp6k29ljfa3v1z5973uao0uz56hg',5,5,'Atendido','2014-06-15','20:03:12'),('uvlmvb4o8yvjdftbksr6bcl611allu07avr',10,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','ar0gjfnye59lwyj512bhmeln54q9vf6g0jn',5,5,'Atendido','2014-05-25','15:29:25'),('vq2198b0068fyovc9z734brr4rt3shg2fl4',9,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','96e1bjs8dqx25v51keashype5e91gnlxkhv',10,10,'Atendido','2014-05-25','15:28:26'),('vxbkvns1m84v11ge7a7s1j7yc87qhw5x9an',8,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc','8sugnl1p6afe6kegk399t3m4wzaa90fyny2','ikbhu84zh7mayh5jq6rbfgb9zt6lw77jab2',4,4,'Atendido','2014-04-28','15:30:50');
/*!40000 ALTER TABLE `solicita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud_cotizacion`
--

DROP TABLE IF EXISTS `solicitud_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud_cotizacion` (
  `nro_solicitud` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `IDproveedor` varchar(40) NOT NULL,
  PRIMARY KEY (`nro_solicitud`),
  KEY `IDproveedor` (`IDproveedor`),
  CONSTRAINT `solicitud_cotizacion_ibfk_1` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedor` (`IDproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_cotizacion`
--

LOCK TABLES `solicitud_cotizacion` WRITE;
/*!40000 ALTER TABLE `solicitud_cotizacion` DISABLE KEYS */;
INSERT INTO `solicitud_cotizacion` VALUES ('09606900308104048528541661768901796','2014-04-21','adzkshnx71smkfrxyygkz21s5iy11w'),('29758215232568503266504249723688116','2014-04-26','adzkshnx71smkfrxyygkz21s5iy11w'),('48183113048723711148596959053569388','2014-06-17','adzkshnx71smkfrxyygkz21s5iy11w'),('65665464579773525223056684574885281','2014-06-17','adzkshnx71smkfrxyygkz21s5iy11w'),('71637251109789665793994128573039479','2014-04-16','adzkshnx71smkfrxyygkz21s5iy11w'),('85945014266938469407496789883946134','2014-04-11','adzkshnx71smkfrxyygkz21s5iy11w'),('98765503189127674990082727218186220','2014-04-25','adzkshnx71smkfrxyygkz21s5iy11w');
/*!40000 ALTER TABLE `solicitud_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud_maquinaria`
--

DROP TABLE IF EXISTS `solicitud_maquinaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud_maquinaria` (
  `IDsolicitud` varchar(40) NOT NULL,
  `IDproyecto` varchar(40) NOT NULL,
  `nro_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `IDmaquinaria` varchar(40) NOT NULL,
  `IDempleado` varchar(40) NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `cantidad_sol` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` varchar(25) NOT NULL,
  `compromiso_alquiler` varchar(30) DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  PRIMARY KEY (`IDsolicitud`),
  KEY `IDcheque` (`nro_solicitud`),
  KEY `IDempleado` (`IDempleado`),
  KEY `IDsubitem` (`IDmaquinaria`),
  KEY `IDproyecto` (`IDproyecto`),
  KEY `IDmaquinaria` (`IDmaquinaria`),
  CONSTRAINT `solicitud_maquinaria_ibfk_7` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`),
  CONSTRAINT `solicitud_maquinaria_ibfk_8` FOREIGN KEY (`IDmaquinaria`) REFERENCES `maquinaria` (`IDmaquinaria`),
  CONSTRAINT `solicitud_maquinaria_ibfk_9` FOREIGN KEY (`IDempleado`) REFERENCES `empleado` (`IDempleado`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_maquinaria`
--

LOCK TABLES `solicitud_maquinaria` WRITE;
/*!40000 ALTER TABLE `solicitud_maquinaria` DISABLE KEYS */;
INSERT INTO `solicitud_maquinaria` VALUES ('2126ce6vaee3lyrtmj1urm0uvniwa74w55a','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',9,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-05-10',3.00,840.00,109.20,730.80,'Atendido','si','2015-05-31'),('3ll6rmgs8ixidjee9b6g1f4g8e4k9scpgul','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',11,'daxusj4txhyre2ga29p6qhk2noco437hm8c','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-06-17',4.00,1400.00,182.00,1218.00,'Atendido','si','2014-06-22'),('4swal7ggo5vvxw2klrekbhzntgzvmcnja6a','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',14,'dg07ngp1xhjp5qke9e9yds20845sdlz54rj','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-06-17',3.00,1680.00,218.40,1461.60,'Atendido','si','2014-06-22'),('5fjiwsey02230wv9qqdjfhedh9mvtn6eo9c','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',1,'olxp8omnybo7kyfsd4swnlsab7uhe74oqyn','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-04-19',1.00,15.00,1.95,13.05,'Atendido','si','2015-05-31'),('7hhvy01mi3dwg60u9qkqnbkjxju0swmkebh','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',13,'duikwxjjzz96yzj8y1eegfam6gruvo4usw3','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-06-17',5.00,1150.00,149.50,1000.50,'Atendido','si','2014-06-22'),('8jgivivpst1ceyed10yaunnlcwwzyb1664n','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',10,'tqga5r93jyomah19w1thdfgv6hiuqhfzkp1','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-05-10',2.00,500.00,65.00,435.00,'Atendido','si','2015-05-31'),('cngyg3wjjo7gk2t45auzelwda4xqq7rb9h9','jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',12,'yaj3rvce9iovgsyo8bth7gtjfr67shm2ema','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-06-17',3.00,840.00,109.20,730.80,'Atendido','si','2014-06-22'),('eceu4agkeuw0lyq4uo5ilmnq0efxkhsbgrn','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',8,'euum36ssdsss4y8v8i0cr6ki2nzj2phzlsc','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-05-10',3.00,354.00,46.02,307.98,'Atendido','si','2015-05-31'),('fuvpstcy5c8y01vv6zgam86kz4zizl90f0c','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',5,'duikwxjjzz96yzj8y1eegfam6gruvo4usw3','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-04-19',1.00,230.00,29.90,200.10,'Atendido','si','2015-05-31'),('fy8o1bvfjhl15ulsmd5s8a9ae09xohkhsx5','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',6,'8dmifsp1brvr6wdydas141sv3coxk1efkj7','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-04-19',1.00,565.00,73.45,491.55,'Atendido','si','2015-05-31'),('gqy9hs7b7kif0zwyfeaxwr2jdg4wyps84x9','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',4,'daxusj4txhyre2ga29p6qhk2noco437hm8c','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-05-10',4.00,700.00,91.00,609.00,'Atendido','si','2015-05-31'),('lvcip0432ih0wc4ok9o4hbh5y514thm2bng','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',3,'hb1dn08omho6krtlvu30g261wnjxeb7npp4','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-04-19',1.00,290.00,37.70,252.30,'Atendido','si','2015-05-31'),('myqh7x07xx1q3u9tvkq72e619sgynb6lr4t','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',2,'svv38vuj2v7jj2sb1nngi6bo4322cv3ijp4','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-04-19',1.00,70.00,9.10,60.90,'Atendido','si','2015-05-31'),('uo5athc7plz6bjo7dmzseham9n806gpd3im','hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',7,'vneqbg3dyfxwjtxggnuj9b4tbisgwq19jq4','xx896pjeah20odas37yq1nj5kovp1vp4qyz','2014-05-10',4.00,900.00,117.00,783.00,'Atendido','si','2015-05-31');
/*!40000 ALTER TABLE `solicitud_maquinaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subfase`
--

DROP TABLE IF EXISTS `subfase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subfase` (
  `IDsubfase` varchar(40) NOT NULL,
  `IDfase` varchar(40) NOT NULL,
  `IDplanificacion` varchar(40) NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(110) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`IDsubfase`),
  KEY `IDfase` (`IDfase`),
  CONSTRAINT `subfase_ibfk_1` FOREIGN KEY (`IDfase`) REFERENCES `fase` (`IDfase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subfase`
--

LOCK TABLES `subfase` WRITE;
/*!40000 ALTER TABLE `subfase` DISABLE KEYS */;
INSERT INTO `subfase` VALUES ('08228887889930946813910713293147441','46083664575463632886339715147520197','67883700838770497309348435286443033','Recubrimiento para la via','Control de recubrimiento de suelos'),('12645722894775490627142678874406771','46083664575463632886339715147520197','67883700838770497309348435286443033','Excavaciones para el tramo','Excavaciones de la via en ejecucion'),('16515509510892627500725540956801401','47851426447886104928510055641702931','67883700838770497309348435286443033','Transporte','Control de transportes de elementos de trabajo'),('26820041065284541967698667730197297','92297026485391162739109795474413961','12304037302566169242662068258533998','Nivelacion y recubrimiento','subfase de nivelacion y recubrimiento'),('35318126010804016296094586354787714','76412120815326159112589680874099940','12304037302566169242662068258533998','Mantenimiento de la vÃ­a','subfase para el mantenimiento de la via del tramo'),('37611606050323492524080872929022918','76412120815326159112589680874099940','12304037302566169242662068258533998','Excavaciones del tramo','subfase para el control de excavaciones'),('46907738842774819455472749501318228','47851426447886104928510055641702931','67883700838770497309348435286443033','Mantenimiento de la via','Control de mantencion de la via'),('49456360697942175122604462497915779','59419696023784598647910745603239331','67883700838770497309348435286443033','Mantenimiento de emergencia','Mantencion de las vias en caso de emergencias'),('51096879311124785682013508959054978','92297026485391162739109795474413961','12304037302566169242662068258533998','Excavaciones para caminos','subfase para el control de excavaciones'),('51446877914295047849582357841480386','47851426447886104928510055641702931','67883700838770497309348435286443033','Excavaciones','Control de trabajos de excavaciones'),('54526773605222682293183326023175897','47851426447886104928510055641702931','67883700838770497309348435286443033','Control y nivelacion','Subfase correspondiente al control y nivelacion de suelos'),('54920753930360523022820370397702904','46083664575463632886339715147520197','67883700838770497309348435286443033','Mantenimiento de emergencia','Control y mantenimiento de emergencia para el tramo'),('73605459149830059896113237470533023','46083664575463632886339715147520197','67883700838770497309348435286443033','Colocacion de letreros de anuncio','Colocacion de anuncios de trabajo dentro de la vÃ­a'),('79341203299257424068038240077380360','59419696023784598647910745603239331','67883700838770497309348435286443033','Control de nivelaciones','Nivelaciones y recubrimiento de terrenos a maquina'),('87729465366218930963657719300164507','47851426447886104928510055641702931','67883700838770497309348435286443033','Nivelacion y recubrimiento','Control de terrenos mediante maquina'),('87887960995443068105148111410707178','59419696023784598647910745603239331','67883700838770497309348435286443033','Excavaciones a maquina','Control de excavaciones de terrenos a maquina');
/*!40000 ALTER TABLE `subfase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submenu`
--

DROP TABLE IF EXISTS `submenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submenu` (
  `IDsubMenu` int(11) NOT NULL AUTO_INCREMENT,
  `IDmenu` int(11) NOT NULL,
  `nombreSubmenu` varchar(40) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  PRIMARY KEY (`IDsubMenu`),
  UNIQUE KEY `nombreSubmenu` (`nombreSubmenu`),
  KEY `IDmenu` (`IDmenu`),
  CONSTRAINT `submenu_ibfk_1` FOREIGN KEY (`IDmenu`) REFERENCES `menu` (`IDmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submenu`
--

LOCK TABLES `submenu` WRITE;
/*!40000 ALTER TABLE `submenu` DISABLE KEYS */;
INSERT INTO `submenu` VALUES (1,1,'USUARIOS','2014-11-16','20:15:12'),(2,1,'ROLES ','2014-11-16','20:15:12'),(3,2,'PUBLICACION DE PROYECTOS','2014-11-16','20:15:12'),(4,1,'SESIONES','2014-11-16','20:15:12'),(6,2,'PROYECTOS','2014-11-16','20:15:12'),(7,2,'MANO DE OBRA','2014-11-16','20:15:12'),(8,2,'REQUERIMIENTOS','2014-11-16','20:15:12'),(9,2,'ACTIVIDADES','2014-11-16','20:15:12'),(10,2,'TRAMOS','2014-11-16','20:15:12'),(11,2,'CARGO MANO DE OBRA','2014-11-16','20:15:12'),(12,2,'ENCARGADOS DE MANO DE OBRA','2014-11-16','20:15:12'),(13,2,'PERSONAL TECNICO CLAVE','2014-11-16','20:15:12'),(14,2,'ROLES DE PARTICIPACION','2014-11-16','20:15:12'),(15,2,'RECEPCIONES POR PROYECTO','2014-11-16','20:15:12'),(16,13,'ANALISIS DE PRECIOS UNITARIOS','2014-11-16','20:15:12'),(17,3,'EMPLEADOS','2014-11-16','20:15:12'),(18,3,'DEPARTAMENTOS','2014-11-16','20:15:12'),(19,3,'CARGOS','2014-11-16','20:15:12'),(20,3,'ACTIVIDADES LABORALES','2014-11-16','20:15:12'),(21,4,'SOLICITUD DE ITEMS','2014-11-16','20:15:12'),(22,4,'PROVEEDORES','2014-11-16','20:15:12'),(23,4,'MATERIALES','2014-11-16','20:15:12'),(24,4,'MAQUINARIA ','2014-11-16','20:15:12'),(25,4,'SUMINISTROS','2014-11-16','20:15:12'),(26,5,'MAQUINARIA EN REPARACION','2014-11-16','20:15:12'),(27,5,'REPARACIONES','2014-11-16','20:15:12'),(28,6,'REPORTES PLANOS-USUARIOS','2014-11-16','20:15:12'),(29,6,'REPORTES PLANOS-PROYECTOS','2014-11-16','20:15:12'),(31,6,'REPORTES PLANOS-EMPLEADOS','2014-11-16','20:15:12'),(32,1,'ACCESOS','2014-11-16','20:15:12'),(33,6,'REPORTES GRAFICOS-PROYECTOS','2014-11-16','20:15:12'),(34,1,'AUDITORIA','2014-11-16','20:15:12'),(35,1,'MODULOS','2014-11-16','20:15:12'),(36,4,'REPORTE-COMPRA Y ALQUILER','2014-11-16','20:15:12'),(37,6,'REPORTE GRAFICO SESION','2014-11-16','20:15:12'),(38,3,'CONTROL DE ASISTENCIA','2014-11-16','20:15:12'),(39,3,'CONTROL DE PERMISOS','2014-11-16','20:15:12'),(40,1,'SUBMENU DE PRUEBA','2014-03-03','19:00:23'),(42,1,'SUBMENU PERZONALIZADO','2014-03-03','19:03:10'),(43,7,'CUSTOM SUBMENU','2014-03-09','14:58:49'),(44,3,'PLANILLAS','2014-03-11','10:20:19'),(45,3,'FORMULARIO DE EMPLEADOS','2014-03-11','11:36:14'),(46,3,'PROFESIONES','2014-03-13','12:14:40'),(47,6,'REPORTE POR SESION','2014-03-13','15:58:33'),(48,2,'FASES','2014-03-21','16:53:54'),(49,2,'SUBFASE','2014-03-21','16:56:26'),(50,2,'SOLICITUD MANO DE OBRA','2014-03-21','17:04:59'),(51,1,'MENSAJES DE AYUDA','2014-03-21','17:21:16'),(52,6,'REPORTE DE MANO DE OBRA','2014-03-23','21:27:32'),(53,3,'CONTRATACION DE TRABAJADORES','2014-03-24','09:54:42'),(54,1,'CALENDARIO','2014-03-25','20:28:20'),(55,4,'LISTADO DE MAQUINARIA','2014-03-28','18:36:32'),(56,4,'LISTADO DE MATERIALES','2014-03-28','18:36:47'),(57,1,'PARAMETROS','2014-03-29','18:42:26'),(58,1,'FORMULARIO DE PARAMETROS','2014-03-29','20:26:07'),(59,6,'REPORTE POR SOLICITUDES','2014-03-31','11:04:46'),(60,6,'REPORTE MANO DE OBRA','2014-03-31','11:06:26'),(61,4,'ALMACENES','2014-03-31','20:59:51'),(62,4,'COTIZACION','2014-03-31','21:04:53'),(63,8,'DOCUMENTOS DE ENTRADA','2014-04-02','10:47:13'),(64,1,'ENVIO DE MENSAJES','2014-04-04','11:18:25'),(65,4,'PEDIDOS','2014-04-05','17:02:10'),(66,4,'SOLICITUD DE MAQUINARIA','2014-04-07','09:37:49'),(67,4,'NOTAS DE REMISIÃ“N','2014-04-11','14:55:49'),(68,6,'COTIZACIONES','2014-04-11','18:06:22'),(69,6,'REPORTE GRAFICO DE MATERIALES','2014-04-14','16:06:27'),(70,2,'PLANIFICACION','2014-04-15','14:57:30'),(71,2,'ASIGNACION DE ACTIVIDADES','2014-04-16','15:03:36'),(72,2,'CONTROL DE PLANIFICACION','2014-04-19','16:52:50'),(73,9,'EJECUCION DE ACTIVIDADES','2014-04-19','20:03:57'),(74,10,'CONTROL DE SEGUIMIENTO','2014-04-19','20:05:02'),(75,12,'INCORPORACION DE ITEMS','2014-04-19','20:13:15'),(76,4,'PLANIFICACION DE COMPRAS','2014-04-21','20:29:21'),(77,6,'COMPRAS','2014-04-21','22:07:52'),(78,3,'CALENDARIO DE TRABAJADOR','2014-04-24','15:39:18'),(79,9,'CONTROL DE EJECUCIONES','2014-04-26','21:52:31'),(80,6,'PRECIOS UNITARIOS','2014-04-29','16:05:11'),(81,13,'SEGUIMIENTO GENERAL DEL PROYECTO','2014-04-30','09:49:09'),(82,12,'PEDIDO DE ITEMS','2014-05-09','11:59:26');
/*!40000 ALTER TABLE `submenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `USR_UID` varchar(40) NOT NULL,
  `username` varchar(80) NOT NULL,
  `CI` varchar(30) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `password` varbinary(80) NOT NULL,
  `confpwd` varbinary(80) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecCreacion` date NOT NULL,
  `hraCreacion` time NOT NULL,
  `IDrol` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`USR_UID`),
  UNIQUE KEY `username` (`username`),
  KEY `IDrol` (`IDrol`),
  KEY `CI` (`CI`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`IDrol`) REFERENCES `rol` (`IDrol`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`CI`) REFERENCES `empleado` (`CI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('00000000000000000000000000000001','admin',NULL,'admin@sercoamerica.com','d033e22ae348aeb5660fc2140aec35850c4da997','d033e22ae348aeb5660fc2140aec35850c4da997','activo','2014-03-10','21:10:41','SC_ADMINISTRADOR'),('adolfo2013947','adolfo','5890334 Exp La Paz','rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-17','15:37:25','SC_GERENTE_TECNICO'),('alberto2013824','alberto','8944334 Ex La Paz','rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-04-19','19:55:10','SC_SUPERINTENDENTE'),('alejandro2013727','alejandro',NULL,'rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-15','10:52:52','SC_PROVEEDOR'),('alexis2013881','alexis',NULL,'admin@sercoamerica.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-14','16:31:22','SC_PROVEEDOR_MANO_OBRA'),('brayan2013447','brayan',NULL,'rleaplazach@gmail.com','dd02e05a7bcef215d35a080937e75e0dc3c324c2','dd02e05a7bcef215d35a080937e75e0dc3c324c2','activo','2014-03-11','00:21:38','SC_OPERADOR'),('carlos2013472','carlos','4855994','rleaplazachavez@hotmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-31','20:55:42','SC_ENCARGADO_ALMACEN'),('franz2014359','franz','2335504','rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-06-15','13:32:07',NULL),('giovani2013290','giovani','25448909 Exp La Paz','rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-18','09:46:59','SC_CONTRATISTA'),('hector2013852','hector',NULL,'hecky@hotmail.com','9b18325361d4ac6516138adedc003769d3d6f0d7','9b18325361d4ac6516138adedc003769d3d6f0d7','activo','2014-03-11','00:33:22','SC_CONVOCANTE'),('herbertsg2013612','herbertsg',NULL,'herbert.saal@gmail.com','9b18325361d4ac6516138adedc003769d3d6f0d7','9b18325361d4ac6516138adedc003769d3d6f0d7','activo','2014-03-11','09:17:39',NULL),('hreyes2014107','hreyes',NULL,'rleaplazach@gmail.com','912672f307587816c5af6fd5c71223179a34deff','912672f307587816c5af6fd5c71223179a34deff','activo','2014-05-26','18:06:26','SC_OPERADOR'),('iver2013705','iver','87644334 Ex La Paz','xdiver@hotmail.com','9b18325361d4ac6516138adedc003769d3d6f0d7','9b18325361d4ac6516138adedc003769d3d6f0d7','activo','2014-03-11','15:13:05','SC_EMPLEADO'),('marcelo2013432','marcelo','5890440 Exp La Paz','mendoza@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-18','09:47:38','SC_SUPERVISOR'),('mescobar2013649','m_escobar',NULL,'m_Escobar@hotmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-14','10:29:19','SC_ADMIN_APP'),('MPV2013907','mperez','449984 L.P','mperez@gmaillcom','8151325dcdbae9e0ff95f9f9658432dbedfdb209','8151325dcdbae9e0ff95f9f9658432dbedfdb209','activo','2014-03-10','21:14:00','SC_EMPLEADO'),('qatest2013707','qatest',NULL,'qatest@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-14','10:22:57',NULL),('raul2013614','raul',NULL,'rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-04-16','15:32:59','SC_PROVEEDOR'),('roberto2013667','roberto','25344558 exp La Paz','rleaplazach@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-04-19','19:48:42',NULL),('rodrigo2013758','rodrigo',NULL,'rleaplazach@gmail.com','9b18325361d4ac6516138adedc003769d3d6f0d7','9b18325361d4ac6516138adedc003769d3d6f0d7','activo','2014-03-11','00:36:10',NULL),('ronald2013986','ronald',NULL,'ronald@gmail.com','9b18325361d4ac6516138adedc003769d3d6f0d7','9b18325361d4ac6516138adedc003769d3d6f0d7','activo','2014-03-12','18:49:38','SC_CONTRATISTA'),('user12014770','user1',NULL,'rleaplazach@gmail.com','fd30c72d2c992351adc6dbd8b0d457e245004b81','fd30c72d2c992351adc6dbd8b0d457e245004b81','activo','2014-06-04','18:36:24','SC_OPERADOR'),('victor2013704','victor','8944559','victor@gmail.com','e2845e9f33046f89edeaa646003dcbc19a39d923','e2845e9f33046f89edeaa646003dcbc19a39d923','activo','2014-03-31','20:56:10','SC_ENCARGADO_COMPRA');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valor_acumulado`
--

DROP TABLE IF EXISTS `valor_acumulado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valor_acumulado` (
  `IDvalor` int(11) NOT NULL AUTO_INCREMENT,
  `IDproyecto` varchar(40) NOT NULL,
  `progreso` decimal(10,2) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`IDvalor`),
  KEY `IDproyecto` (`IDproyecto`),
  CONSTRAINT `valor_acumulado_ibfk_1` FOREIGN KEY (`IDproyecto`) REFERENCES `proyecto` (`IDproyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valor_acumulado`
--

LOCK TABLES `valor_acumulado` WRITE;
/*!40000 ALTER TABLE `valor_acumulado` DISABLE KEYS */;
INSERT INTO `valor_acumulado` VALUES (1,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',9.09,2302752.81,'2014-06-01'),(2,'jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',33.33,8635252.17,'2014-06-17'),(3,'hqfvbwtiaxty6ezk4lm0b0og0yyw2niwtyc',7.69,1948093.41,'2014-06-21'),(4,'jg4hhtvse6hztnxn3fngjm1mf5bk6eqvc8g',50.00,12954173.67,'2014-06-21');
/*!40000 ALTER TABLE `valor_acumulado` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-22 17:03:48
