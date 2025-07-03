-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: seguridadlai
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `seguridadlai`
--

/*!40000 DROP DATABASE IF EXISTS `seguridadlai`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `seguridadlai` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `seguridadlai`;

--
-- Table structure for table `tbl_alertas`
--

DROP TABLE IF EXISTS `tbl_alertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_alertas` (
  `id_alerta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `mensaje` varchar(150) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_alerta`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tbl_alertas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_alertas`
--

LOCK TABLES `tbl_alertas` WRITE;
/*!40000 ALTER TABLE `tbl_alertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_alertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bitacora`
--

DROP TABLE IF EXISTS `tbl_bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bitacora` (
  `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `accion` varchar(30) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_bitacora`),
  KEY `id_modulo` (`id_modulo`,`id_usuario`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tbl_bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_bitacora_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `tbl_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bitacora`
--

LOCK TABLES `tbl_bitacora` WRITE;
/*!40000 ALTER TABLE `tbl_bitacora` DISABLE KEYS */;
INSERT INTO `tbl_bitacora` VALUES (1,'2025-07-02 00:44:15','Acceso al módulo de catálogo',1,3),(2,'2025-07-02 00:53:21','Acceso al módulo de catálogo',1,3),(3,'2025-07-02 00:58:03','Acceso al módulo de catálogo',1,3),(4,'2025-07-02 00:58:05','Acceso al módulo de catálogo',1,3),(5,'2025-07-02 01:00:03','Acceso al módulo de catálogo',1,3),(6,'2025-07-02 01:24:38','Acceso al módulo de catálogo',1,3),(7,'2025-07-02 01:24:45','Acceso al módulo de catálogo',1,3),(8,'2025-07-02 01:24:53','Acceso al módulo de catálogo',1,3),(9,'2025-07-02 01:25:02','Acceso al módulo de catálogo',1,3),(10,'2025-07-02 01:25:10','Acceso al módulo de catálogo',1,3),(11,'2025-07-02 01:48:58','Acceso al módulo de catálogo',1,3),(12,'2025-07-02 01:49:00','Acceso al módulo de catálogo',1,3),(13,'2025-07-02 01:49:21','Acceso al módulo de catálogo',1,3),(14,'2025-07-02 01:49:21','Agregó producto al carrito: Ca',1,3),(15,'2025-07-02 01:49:31','Acceso al módulo de catálogo',1,3),(16,'2025-07-02 22:28:32','Acceso al módulo de catálogo',1,9),(17,'2025-07-02 22:28:46','Acceso al módulo de catálogo',1,9),(18,'2025-07-02 22:28:46','Agregó producto al carrito: Ca',1,9),(19,'2025-07-03 00:47:55','Acceso al módulo de marcas',1,9),(20,'2025-07-03 00:47:57','Acceso al módulo de marcas',1,9),(21,'2025-07-03 00:47:58','Acceso al módulo de marcas',1,9),(22,'2025-07-03 00:47:59','Acceso al módulo de marcas',1,9),(23,'2025-07-03 00:48:00','Acceso al módulo de marcas',1,9),(24,'2025-07-03 00:48:01','Acceso al módulo de marcas',1,9),(25,'2025-07-03 00:48:02','Acceso al módulo de marcas',1,9),(26,'2025-07-03 00:48:03','Acceso al módulo de marcas',1,9),(27,'2025-07-03 00:48:04','Acceso al módulo de marcas',1,9),(28,'2025-07-03 00:48:05','Acceso al módulo de marcas',1,9),(29,'2025-07-03 00:48:06','Acceso al módulo de marcas',1,9),(30,'2025-07-03 00:48:06','Acceso al módulo de marcas',1,9),(31,'2025-07-03 00:48:07','Acceso al módulo de marcas',1,9),(32,'2025-07-03 00:48:07','Acceso al módulo de marcas',1,9),(33,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(34,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(35,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(36,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(37,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(38,'2025-07-03 00:48:09','Acceso al módulo de marcas',1,9),(39,'2025-07-03 00:48:10','Acceso al módulo de marcas',1,9),(40,'2025-07-03 00:48:11','Acceso al módulo de marcas',1,9),(41,'2025-07-03 00:48:11','Acceso al módulo de marcas',1,9),(42,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(43,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(44,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(45,'2025-07-03 00:48:13','Acceso al módulo de marcas',1,9),(46,'2025-07-03 00:48:14','Acceso al módulo de marcas',1,9),(47,'2025-07-03 00:48:15','Acceso al módulo de marcas',1,9),(48,'2025-07-03 00:48:15','Acceso al módulo de marcas',1,9),(49,'2025-07-03 00:48:16','Acceso al módulo de marcas',1,9),(50,'2025-07-03 00:48:17','Acceso al módulo de marcas',1,9),(51,'2025-07-03 00:48:18','Acceso al módulo de marcas',1,9),(52,'2025-07-03 00:48:19','Acceso al módulo de marcas',1,9),(53,'2025-07-03 00:48:20','Acceso al módulo de marcas',1,9),(54,'2025-07-03 00:48:21','Acceso al módulo de marcas',1,9),(55,'2025-07-03 00:48:22','Acceso al módulo de marcas',1,9),(56,'2025-07-03 00:48:23','Acceso al módulo de marcas',1,9),(57,'2025-07-03 00:48:24','Acceso al módulo de marcas',1,9),(58,'2025-07-03 00:48:24','Acceso al módulo de marcas',1,9),(59,'2025-07-03 00:48:25','Acceso al módulo de marcas',1,9),(60,'2025-07-03 00:48:26','Acceso al módulo de marcas',1,9),(61,'2025-07-03 00:48:27','Acceso al módulo de marcas',1,9),(62,'2025-07-03 00:48:28','Acceso al módulo de marcas',1,9),(63,'2025-07-03 00:48:29','Acceso al módulo de marcas',1,9),(64,'2025-07-03 00:48:30','Acceso al módulo de marcas',1,9),(65,'2025-07-03 00:48:31','Acceso al módulo de marcas',1,9),(66,'2025-07-03 00:48:31','Acceso al módulo de marcas',1,9),(67,'2025-07-03 00:48:32','Acceso al módulo de marcas',1,9),(68,'2025-07-03 00:48:33','Acceso al módulo de marcas',1,9),(69,'2025-07-03 00:48:34','Acceso al módulo de marcas',1,9),(70,'2025-07-03 00:48:35','Acceso al módulo de marcas',1,9),(71,'2025-07-03 00:48:35','Acceso al módulo de marcas',1,9),(72,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(73,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(74,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(75,'2025-07-03 00:48:37','Acceso al módulo de marcas',1,9),(76,'2025-07-03 00:48:37','Acceso al módulo de marcas',1,9),(77,'2025-07-03 00:48:38','Acceso al módulo de marcas',1,9),(78,'2025-07-03 00:48:39','Acceso al módulo de marcas',1,9),(79,'2025-07-03 00:48:40','Acceso al módulo de marcas',1,9),(80,'2025-07-03 00:48:41','Acceso al módulo de marcas',1,9),(81,'2025-07-03 00:48:42','Acceso al módulo de marcas',1,9),(82,'2025-07-03 00:48:43','Acceso al módulo de marcas',1,9),(83,'2025-07-03 00:48:44','Acceso al módulo de marcas',1,9),(84,'2025-07-03 00:48:44','Acceso al módulo de marcas',1,9),(85,'2025-07-03 00:48:45','Acceso al módulo de marcas',1,9),(86,'2025-07-03 00:48:46','Acceso al módulo de marcas',1,9),(87,'2025-07-03 00:48:47','Acceso al módulo de marcas',1,9),(88,'2025-07-03 00:48:48','Acceso al módulo de marcas',1,9),(89,'2025-07-03 00:48:49','Acceso al módulo de marcas',1,9),(90,'2025-07-03 00:48:50','Acceso al módulo de marcas',1,9),(91,'2025-07-03 00:48:51','Acceso al módulo de marcas',1,9),(92,'2025-07-03 00:48:52','Acceso al módulo de marcas',1,9),(93,'2025-07-03 00:48:53','Acceso al módulo de marcas',1,9),(94,'2025-07-03 00:48:54','Acceso al módulo de marcas',1,9),(95,'2025-07-03 00:48:54','Acceso al módulo de marcas',1,9),(96,'2025-07-03 00:48:55','Acceso al módulo de marcas',1,9),(97,'2025-07-03 00:48:56','Acceso al módulo de marcas',1,9),(98,'2025-07-03 00:48:57','Acceso al módulo de marcas',1,9),(99,'2025-07-03 00:48:57','Acceso al módulo de marcas',1,9),(100,'2025-07-03 00:48:58','Acceso al módulo de marcas',1,9),(101,'2025-07-03 00:48:59','Acceso al módulo de marcas',1,9),(102,'2025-07-03 00:49:00','Acceso al módulo de marcas',1,9),(103,'2025-07-03 00:49:01','Acceso al módulo de marcas',1,9),(104,'2025-07-03 00:49:01','Acceso al módulo de marcas',1,9),(105,'2025-07-03 00:49:02','Acceso al módulo de marcas',1,9),(106,'2025-07-03 00:49:03','Acceso al módulo de marcas',1,9),(107,'2025-07-03 00:49:04','Acceso al módulo de marcas',1,9),(108,'2025-07-03 00:49:05','Acceso al módulo de marcas',1,9),(109,'2025-07-03 00:49:06','Acceso al módulo de marcas',1,9),(110,'2025-07-03 00:49:07','Acceso al módulo de marcas',1,9),(111,'2025-07-03 00:49:08','Acceso al módulo de marcas',1,9),(112,'2025-07-03 00:49:09','Acceso al módulo de marcas',1,9),(113,'2025-07-03 00:49:10','Acceso al módulo de marcas',1,9),(114,'2025-07-03 00:49:11','Acceso al módulo de marcas',1,9),(115,'2025-07-03 00:49:12','Acceso al módulo de marcas',1,9),(116,'2025-07-03 00:49:13','Acceso al módulo de marcas',1,9),(117,'2025-07-03 00:49:14','Acceso al módulo de marcas',1,9),(118,'2025-07-03 00:49:15','Acceso al módulo de marcas',1,9),(119,'2025-07-03 00:49:16','Acceso al módulo de marcas',1,9),(120,'2025-07-03 00:49:17','Acceso al módulo de marcas',1,9),(121,'2025-07-03 00:49:18','Acceso al módulo de marcas',1,9),(122,'2025-07-03 00:49:19','Acceso al módulo de marcas',1,9),(123,'2025-07-03 00:49:20','Acceso al módulo de marcas',1,9),(124,'2025-07-03 00:49:21','Acceso al módulo de marcas',1,9),(125,'2025-07-03 00:49:22','Acceso al módulo de marcas',1,9),(126,'2025-07-03 00:49:23','Acceso al módulo de marcas',1,9),(127,'2025-07-03 00:49:24','Acceso al módulo de marcas',1,9),(128,'2025-07-03 00:49:25','Acceso al módulo de marcas',1,9),(129,'2025-07-03 00:49:26','Acceso al módulo de marcas',1,9),(130,'2025-07-03 00:49:27','Acceso al módulo de marcas',1,9),(131,'2025-07-03 00:49:28','Acceso al módulo de marcas',1,9),(132,'2025-07-03 00:49:29','Acceso al módulo de marcas',1,9),(133,'2025-07-03 00:49:30','Acceso al módulo de marcas',1,9),(134,'2025-07-03 00:49:30','Acceso al módulo de marcas',1,9),(135,'2025-07-03 00:49:31','Acceso al módulo de marcas',1,9),(136,'2025-07-03 00:49:32','Acceso al módulo de marcas',1,9),(137,'2025-07-03 00:49:33','Acceso al módulo de marcas',1,9),(138,'2025-07-03 00:49:34','Acceso al módulo de marcas',1,9),(139,'2025-07-03 00:49:35','Acceso al módulo de marcas',1,9),(140,'2025-07-03 00:49:36','Acceso al módulo de marcas',1,9),(141,'2025-07-03 00:49:36','Acceso al módulo de marcas',1,9),(142,'2025-07-03 00:49:37','Acceso al módulo de marcas',1,9),(143,'2025-07-03 00:49:38','Acceso al módulo de marcas',1,9),(144,'2025-07-03 00:49:39','Acceso al módulo de marcas',1,9),(145,'2025-07-03 00:49:40','Acceso al módulo de marcas',1,9),(146,'2025-07-03 00:49:41','Acceso al módulo de marcas',1,9),(147,'2025-07-03 00:49:42','Acceso al módulo de marcas',1,9),(148,'2025-07-03 00:49:43','Acceso al módulo de marcas',1,9),(149,'2025-07-03 00:49:44','Acceso al módulo de marcas',1,9),(150,'2025-07-03 00:49:45','Acceso al módulo de marcas',1,9),(151,'2025-07-03 00:49:46','Acceso al módulo de marcas',1,9),(152,'2025-07-03 00:49:47','Acceso al módulo de marcas',1,9),(153,'2025-07-03 00:49:48','Acceso al módulo de marcas',1,9),(154,'2025-07-03 00:49:49','Acceso al módulo de marcas',1,9),(155,'2025-07-03 00:49:50','Acceso al módulo de marcas',1,9),(156,'2025-07-03 00:49:51','Acceso al módulo de marcas',1,9),(157,'2025-07-03 00:49:52','Acceso al módulo de marcas',1,9),(158,'2025-07-03 00:49:53','Acceso al módulo de marcas',1,9),(159,'2025-07-03 00:49:54','Acceso al módulo de marcas',1,9),(160,'2025-07-03 00:49:55','Acceso al módulo de marcas',1,9),(161,'2025-07-03 00:49:56','Acceso al módulo de marcas',1,9),(162,'2025-07-03 00:49:57','Acceso al módulo de marcas',1,9),(163,'2025-07-03 00:49:58','Acceso al módulo de marcas',1,9),(164,'2025-07-03 00:49:59','Acceso al módulo de marcas',1,9),(165,'2025-07-03 00:50:00','Acceso al módulo de marcas',1,9),(166,'2025-07-03 00:50:01','Acceso al módulo de marcas',1,9),(167,'2025-07-03 00:50:02','Acceso al módulo de marcas',1,9),(168,'2025-07-03 00:50:03','Acceso al módulo de marcas',1,9),(169,'2025-07-03 00:50:04','Acceso al módulo de marcas',1,9),(170,'2025-07-03 00:50:05','Acceso al módulo de marcas',1,9),(171,'2025-07-03 00:50:06','Acceso al módulo de marcas',1,9),(172,'2025-07-03 00:50:07','Acceso al módulo de marcas',1,9),(173,'2025-07-03 00:50:08','Acceso al módulo de marcas',1,9),(174,'2025-07-03 00:50:09','Acceso al módulo de marcas',1,9),(175,'2025-07-03 00:50:10','Acceso al módulo de marcas',1,9),(176,'2025-07-03 00:50:11','Acceso al módulo de marcas',1,9),(177,'2025-07-03 00:50:12','Acceso al módulo de marcas',1,9),(178,'2025-07-03 00:50:13','Acceso al módulo de marcas',1,9),(179,'2025-07-03 00:50:14','Acceso al módulo de marcas',1,9),(180,'2025-07-03 00:50:15','Acceso al módulo de marcas',1,9),(181,'2025-07-03 00:50:16','Acceso al módulo de marcas',1,9),(182,'2025-07-03 00:50:17','Acceso al módulo de marcas',1,9),(183,'2025-07-03 00:50:18','Acceso al módulo de marcas',1,9),(184,'2025-07-03 00:50:19','Acceso al módulo de marcas',1,9),(185,'2025-07-03 00:50:20','Acceso al módulo de marcas',1,9),(186,'2025-07-03 00:50:21','Acceso al módulo de marcas',1,9),(187,'2025-07-03 00:50:22','Acceso al módulo de marcas',1,9),(188,'2025-07-03 00:50:23','Acceso al módulo de marcas',1,9),(189,'2025-07-03 00:50:24','Acceso al módulo de marcas',1,9),(190,'2025-07-03 00:50:25','Acceso al módulo de marcas',1,9),(191,'2025-07-03 00:50:26','Acceso al módulo de marcas',1,9),(192,'2025-07-03 00:50:27','Acceso al módulo de marcas',1,9),(193,'2025-07-03 00:50:28','Acceso al módulo de marcas',1,9),(194,'2025-07-03 00:50:29','Acceso al módulo de marcas',1,9),(195,'2025-07-03 00:50:30','Acceso al módulo de marcas',1,9),(196,'2025-07-03 00:50:31','Acceso al módulo de marcas',1,9),(197,'2025-07-03 00:50:32','Acceso al módulo de marcas',1,9),(198,'2025-07-03 00:50:33','Acceso al módulo de marcas',1,9),(199,'2025-07-03 00:50:34','Acceso al módulo de marcas',1,9),(200,'2025-07-03 00:50:35','Acceso al módulo de marcas',1,9),(201,'2025-07-03 00:50:36','Acceso al módulo de marcas',1,9),(202,'2025-07-03 00:50:37','Acceso al módulo de marcas',1,9),(203,'2025-07-03 00:50:38','Acceso al módulo de marcas',1,9),(204,'2025-07-03 00:50:39','Acceso al módulo de marcas',1,9),(205,'2025-07-03 00:50:40','Acceso al módulo de marcas',1,9);
/*!40000 ALTER TABLE `tbl_bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_modulos`
--

DROP TABLE IF EXISTS `tbl_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_modulo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_modulos`
--

LOCK TABLES `tbl_modulos` WRITE;
/*!40000 ALTER TABLE `tbl_modulos` DISABLE KEYS */;
INSERT INTO `tbl_modulos` VALUES (1,'Usuario'),(2,'Recepcion'),(3,'Despacho'),(4,'Marcas'),(5,'Modelos'),(6,'Productos'),(7,'Categorias'),(8,'Proveedores'),(9,'Clientes'),(10,'Catalogo'),(14,'Ordenes de despacho'),(15,'Cuentas bancarias'),(18,'Roles');
/*!40000 ALTER TABLE `tbl_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_permisos`
--

DROP TABLE IF EXISTS `tbl_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accion` varchar(10) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `estatus` enum('Permitido','No Permitido') NOT NULL DEFAULT 'Permitido',
  PRIMARY KEY (`id`),
  KEY `id_rol` (`id_rol`,`id_modulo`),
  KEY `id_modulo` (`id_modulo`),
  CONSTRAINT `tbl_permisos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_permisos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `tbl_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32680 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisos`
--

LOCK TABLES `tbl_permisos` WRITE;
/*!40000 ALTER TABLE `tbl_permisos` DISABLE KEYS */;
INSERT INTO `tbl_permisos` VALUES (32420,'consultar',6,1,'Permitido'),(32421,'incluir',6,1,'Permitido'),(32422,'modificar',6,1,'Permitido'),(32423,'eliminar',6,1,'Permitido'),(32424,'consultar',6,2,'Permitido'),(32425,'incluir',6,2,'Permitido'),(32426,'modificar',6,2,'Permitido'),(32427,'eliminar',6,2,'Permitido'),(32428,'consultar',6,3,'Permitido'),(32429,'incluir',6,3,'Permitido'),(32430,'modificar',6,3,'Permitido'),(32431,'eliminar',6,3,'Permitido'),(32432,'consultar',6,4,'Permitido'),(32433,'incluir',6,4,'Permitido'),(32434,'modificar',6,4,'Permitido'),(32435,'eliminar',6,4,'Permitido'),(32436,'consultar',6,5,'Permitido'),(32437,'incluir',6,5,'Permitido'),(32438,'modificar',6,5,'Permitido'),(32439,'eliminar',6,5,'Permitido'),(32440,'consultar',6,6,'Permitido'),(32441,'incluir',6,6,'Permitido'),(32442,'modificar',6,6,'Permitido'),(32443,'eliminar',6,6,'Permitido'),(32444,'consultar',6,7,'Permitido'),(32445,'incluir',6,7,'Permitido'),(32446,'modificar',6,7,'Permitido'),(32447,'eliminar',6,7,'Permitido'),(32448,'consultar',6,8,'Permitido'),(32449,'incluir',6,8,'Permitido'),(32450,'modificar',6,8,'Permitido'),(32451,'eliminar',6,8,'Permitido'),(32452,'consultar',6,9,'Permitido'),(32453,'incluir',6,9,'Permitido'),(32454,'modificar',6,9,'Permitido'),(32455,'eliminar',6,9,'Permitido'),(32456,'consultar',6,10,'Permitido'),(32457,'incluir',6,10,'Permitido'),(32458,'modificar',6,10,'Permitido'),(32459,'eliminar',6,10,'Permitido'),(32460,'consultar',6,14,'Permitido'),(32461,'incluir',6,14,'Permitido'),(32462,'modificar',6,14,'Permitido'),(32463,'eliminar',6,14,'Permitido'),(32464,'consultar',6,15,'Permitido'),(32465,'incluir',6,15,'Permitido'),(32466,'modificar',6,15,'Permitido'),(32467,'eliminar',6,15,'Permitido'),(32468,'consultar',6,18,'Permitido'),(32469,'incluir',6,18,'Permitido'),(32470,'modificar',6,18,'Permitido'),(32471,'eliminar',6,18,'Permitido'),(32472,'consultar',1,1,'Permitido'),(32473,'incluir',1,1,'Permitido'),(32474,'modificar',1,1,'Permitido'),(32475,'eliminar',1,1,'Permitido'),(32476,'consultar',1,2,'Permitido'),(32477,'incluir',1,2,'Permitido'),(32478,'modificar',1,2,'Permitido'),(32479,'eliminar',1,2,'No Permitido'),(32480,'consultar',1,3,'Permitido'),(32481,'incluir',1,3,'Permitido'),(32482,'modificar',1,3,'Permitido'),(32483,'eliminar',1,3,'No Permitido'),(32484,'consultar',1,4,'Permitido'),(32485,'incluir',1,4,'Permitido'),(32486,'modificar',1,4,'Permitido'),(32487,'eliminar',1,4,'Permitido'),(32488,'consultar',1,5,'Permitido'),(32489,'incluir',1,5,'Permitido'),(32490,'modificar',1,5,'Permitido'),(32491,'eliminar',1,5,'Permitido'),(32492,'consultar',1,6,'Permitido'),(32493,'incluir',1,6,'Permitido'),(32494,'modificar',1,6,'Permitido'),(32495,'eliminar',1,6,'Permitido'),(32496,'consultar',1,7,'Permitido'),(32497,'incluir',1,7,'Permitido'),(32498,'modificar',1,7,'Permitido'),(32499,'eliminar',1,7,'Permitido'),(32500,'consultar',1,8,'Permitido'),(32501,'incluir',1,8,'Permitido'),(32502,'modificar',1,8,'Permitido'),(32503,'eliminar',1,8,'Permitido'),(32504,'consultar',1,9,'Permitido'),(32505,'incluir',1,9,'Permitido'),(32506,'modificar',1,9,'Permitido'),(32507,'eliminar',1,9,'Permitido'),(32508,'consultar',1,10,'No Permitido'),(32509,'incluir',1,10,'No Permitido'),(32510,'modificar',1,10,'No Permitido'),(32511,'eliminar',1,10,'No Permitido'),(32512,'consultar',1,14,'No Permitido'),(32513,'incluir',1,14,'No Permitido'),(32514,'modificar',1,14,'No Permitido'),(32515,'eliminar',1,14,'No Permitido'),(32516,'consultar',1,15,'Permitido'),(32517,'incluir',1,15,'Permitido'),(32518,'modificar',1,15,'Permitido'),(32519,'eliminar',1,15,'Permitido'),(32520,'consultar',1,18,'Permitido'),(32521,'incluir',1,18,'Permitido'),(32522,'modificar',1,18,'Permitido'),(32523,'eliminar',1,18,'Permitido'),(32524,'consultar',2,1,'No Permitido'),(32525,'incluir',2,1,'No Permitido'),(32526,'modificar',2,1,'No Permitido'),(32527,'eliminar',2,1,'No Permitido'),(32528,'consultar',2,2,'Permitido'),(32529,'incluir',2,2,'Permitido'),(32530,'modificar',2,2,'Permitido'),(32531,'eliminar',2,2,'Permitido'),(32532,'consultar',2,3,'Permitido'),(32533,'incluir',2,3,'Permitido'),(32534,'modificar',2,3,'Permitido'),(32535,'eliminar',2,3,'Permitido'),(32536,'consultar',2,4,'Permitido'),(32537,'incluir',2,4,'Permitido'),(32538,'modificar',2,4,'Permitido'),(32539,'eliminar',2,4,'Permitido'),(32540,'consultar',2,5,'Permitido'),(32541,'incluir',2,5,'Permitido'),(32542,'modificar',2,5,'Permitido'),(32543,'eliminar',2,5,'Permitido'),(32544,'consultar',2,6,'Permitido'),(32545,'incluir',2,6,'Permitido'),(32546,'modificar',2,6,'Permitido'),(32547,'eliminar',2,6,'Permitido'),(32548,'consultar',2,7,'Permitido'),(32549,'incluir',2,7,'Permitido'),(32550,'modificar',2,7,'Permitido'),(32551,'eliminar',2,7,'Permitido'),(32552,'consultar',2,8,'No Permitido'),(32553,'incluir',2,8,'No Permitido'),(32554,'modificar',2,8,'No Permitido'),(32555,'eliminar',2,8,'No Permitido'),(32556,'consultar',2,9,'Permitido'),(32557,'incluir',2,9,'Permitido'),(32558,'modificar',2,9,'Permitido'),(32559,'eliminar',2,9,'Permitido'),(32560,'consultar',2,10,'Permitido'),(32561,'incluir',2,10,'Permitido'),(32562,'modificar',2,10,'Permitido'),(32563,'eliminar',2,10,'Permitido'),(32564,'consultar',2,14,'Permitido'),(32565,'incluir',2,14,'Permitido'),(32566,'modificar',2,14,'Permitido'),(32567,'eliminar',2,14,'Permitido'),(32568,'consultar',2,15,'Permitido'),(32569,'incluir',2,15,'No Permitido'),(32570,'modificar',2,15,'No Permitido'),(32571,'eliminar',2,15,'No Permitido'),(32572,'consultar',2,18,'No Permitido'),(32573,'incluir',2,18,'No Permitido'),(32574,'modificar',2,18,'No Permitido'),(32575,'eliminar',2,18,'No Permitido'),(32576,'consultar',3,1,'No Permitido'),(32577,'incluir',3,1,'No Permitido'),(32578,'modificar',3,1,'No Permitido'),(32579,'eliminar',3,1,'No Permitido'),(32580,'consultar',3,2,'No Permitido'),(32581,'incluir',3,2,'No Permitido'),(32582,'modificar',3,2,'No Permitido'),(32583,'eliminar',3,2,'No Permitido'),(32584,'consultar',3,3,'No Permitido'),(32585,'incluir',3,3,'No Permitido'),(32586,'modificar',3,3,'No Permitido'),(32587,'eliminar',3,3,'No Permitido'),(32588,'consultar',3,4,'No Permitido'),(32589,'incluir',3,4,'No Permitido'),(32590,'modificar',3,4,'No Permitido'),(32591,'eliminar',3,4,'No Permitido'),(32592,'consultar',3,5,'No Permitido'),(32593,'incluir',3,5,'No Permitido'),(32594,'modificar',3,5,'No Permitido'),(32595,'eliminar',3,5,'No Permitido'),(32596,'consultar',3,6,'No Permitido'),(32597,'incluir',3,6,'No Permitido'),(32598,'modificar',3,6,'No Permitido'),(32599,'eliminar',3,6,'No Permitido'),(32600,'consultar',3,7,'No Permitido'),(32601,'incluir',3,7,'No Permitido'),(32602,'modificar',3,7,'No Permitido'),(32603,'eliminar',3,7,'No Permitido'),(32604,'consultar',3,8,'No Permitido'),(32605,'incluir',3,8,'No Permitido'),(32606,'modificar',3,8,'No Permitido'),(32607,'eliminar',3,8,'No Permitido'),(32608,'consultar',3,9,'No Permitido'),(32609,'incluir',3,9,'No Permitido'),(32610,'modificar',3,9,'No Permitido'),(32611,'eliminar',3,9,'No Permitido'),(32612,'consultar',3,10,'Permitido'),(32613,'incluir',3,10,'No Permitido'),(32614,'modificar',3,10,'No Permitido'),(32615,'eliminar',3,10,'No Permitido'),(32616,'consultar',3,14,'Permitido'),(32617,'incluir',3,14,'Permitido'),(32618,'modificar',3,14,'Permitido'),(32619,'eliminar',3,14,'No Permitido'),(32620,'consultar',3,15,'No Permitido'),(32621,'incluir',3,15,'No Permitido'),(32622,'modificar',3,15,'No Permitido'),(32623,'eliminar',3,15,'No Permitido'),(32624,'consultar',3,18,'No Permitido'),(32625,'incluir',3,18,'No Permitido'),(32626,'modificar',3,18,'No Permitido'),(32627,'eliminar',3,18,'No Permitido'),(32628,'consultar',4,1,'Permitido'),(32629,'incluir',4,1,'Permitido'),(32630,'modificar',4,1,'Permitido'),(32631,'eliminar',4,1,'Permitido'),(32632,'consultar',4,2,'Permitido'),(32633,'incluir',4,2,'Permitido'),(32634,'modificar',4,2,'Permitido'),(32635,'eliminar',4,2,'Permitido'),(32636,'consultar',4,3,'Permitido'),(32637,'incluir',4,3,'Permitido'),(32638,'modificar',4,3,'Permitido'),(32639,'eliminar',4,3,'Permitido'),(32640,'consultar',4,4,'Permitido'),(32641,'incluir',4,4,'Permitido'),(32642,'modificar',4,4,'Permitido'),(32643,'eliminar',4,4,'Permitido'),(32644,'consultar',4,5,'Permitido'),(32645,'incluir',4,5,'Permitido'),(32646,'modificar',4,5,'Permitido'),(32647,'eliminar',4,5,'Permitido'),(32648,'consultar',4,6,'Permitido'),(32649,'incluir',4,6,'Permitido'),(32650,'modificar',4,6,'Permitido'),(32651,'eliminar',4,6,'Permitido'),(32652,'consultar',4,7,'Permitido'),(32653,'incluir',4,7,'Permitido'),(32654,'modificar',4,7,'Permitido'),(32655,'eliminar',4,7,'Permitido'),(32656,'consultar',4,8,'Permitido'),(32657,'incluir',4,8,'Permitido'),(32658,'modificar',4,8,'Permitido'),(32659,'eliminar',4,8,'Permitido'),(32660,'consultar',4,9,'Permitido'),(32661,'incluir',4,9,'Permitido'),(32662,'modificar',4,9,'Permitido'),(32663,'eliminar',4,9,'Permitido'),(32664,'consultar',4,10,'Permitido'),(32665,'incluir',4,10,'Permitido'),(32666,'modificar',4,10,'Permitido'),(32667,'eliminar',4,10,'Permitido'),(32668,'consultar',4,14,'Permitido'),(32669,'incluir',4,14,'Permitido'),(32670,'modificar',4,14,'Permitido'),(32671,'eliminar',4,14,'Permitido'),(32672,'consultar',4,15,'Permitido'),(32673,'incluir',4,15,'Permitido'),(32674,'modificar',4,15,'Permitido'),(32675,'eliminar',4,15,'Permitido'),(32676,'consultar',4,18,'Permitido'),(32677,'incluir',4,18,'Permitido'),(32678,'modificar',4,18,'Permitido'),(32679,'eliminar',4,18,'Permitido');
/*!40000 ALTER TABLE `tbl_permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_recuperar`
--

DROP TABLE IF EXISTS `tbl_recuperar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_recuperar` (
  `id_recuperar` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id_recuperar`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tbl_recuperar_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_recuperar`
--

LOCK TABLES `tbl_recuperar` WRITE;
/*!40000 ALTER TABLE `tbl_recuperar` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_recuperar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rol`
--

DROP TABLE IF EXISTS `tbl_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(15) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rol`
--

LOCK TABLES `tbl_rol` WRITE;
/*!40000 ALTER TABLE `tbl_rol` DISABLE KEYS */;
INSERT INTO `tbl_rol` VALUES (1,'Administrador'),(2,'Almacenista'),(3,'Cliente'),(4,'Desarrollador'),(6,'SuperUsuario'),(7,'Profesor');
/*!40000 ALTER TABLE `tbl_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuarios`
--

DROP TABLE IF EXISTS `tbl_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `nombres` varchar(20) DEFAULT NULL,
  `apellidos` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estatus` enum('habilitado','inhabilitado') NOT NULL DEFAULT 'habilitado',
  PRIMARY KEY (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuarios`
--

LOCK TABLES `tbl_usuarios` WRITE;
/*!40000 ALTER TABLE `tbl_usuarios` DISABLE KEYS */;
INSERT INTO `tbl_usuarios` VALUES (3,'Diego','$2y$10$aVnYPs5gz8QcihC.PT2eQeqg/2B0Vk4TQlPl2hVKz3vbnhoRQVdnW',1,'ejemplo@gmail.com','Diego','Compa','0414-575-3363','habilitado'),(4,'Simon','$2y$10$bJfY45blf5qV66WzNf5.OOTPFjgCEePpBz07GQUc3B0qlKMNzJd8W',3,'ejemplo@gmail.com','Simon Freitez','Cliente','0414-000-0000','habilitado'),(5,'SuperUsu','$2y$10$w7nQw5p6Qw6nQw5p6Qw6nOQw5p6Qw6nQw5p6Qw6nQw5p6Qw6nQw6n',6,'ejemplo@gmail.com','Diego Andres','Lopez Vivas','0414-575-3363','habilitado'),(7,'Ben10','$2y$10$xYFm.SoVzcTO1Z8VNeoP.eVpI.s6YZ54sZqoN20ogR/n7uTHNf0yG',1,'ggy@gmail.com','Pa','nose','0414-000-0000','habilitado'),(8,'DiegoS','$2y$10$YNp4Po6bWqvBhXD2W4zm6OZk6i.l1QHVzzZLFrn8Y7gQ4.NFU89TW',1,'ggy@gmail.com','Diego','Compa Vendedor','0414-575-3363','habilitado'),(9,'CasaLai','$2y$10$KXRg/AUD.9Y7KubEvzy71e5dDR1GvGNy23XegAYwLjYWOBdcxzqx2',6,'diego0510lopez@gmail.com','Casa','Lai','0414-575-3363','habilitado');
/*!40000 ALTER TABLE `tbl_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'seguridadlai'
--

--
-- Dumping routines for database 'seguridadlai'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-03  1:42:47
