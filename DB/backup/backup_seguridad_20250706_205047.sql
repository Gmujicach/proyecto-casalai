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
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bitacora`
--

LOCK TABLES `tbl_bitacora` WRITE;
/*!40000 ALTER TABLE `tbl_bitacora` DISABLE KEYS */;
INSERT INTO `tbl_bitacora` VALUES (1,'2025-07-02 00:44:15','Acceso al módulo de catálogo',1,3),(2,'2025-07-02 00:53:21','Acceso al módulo de catálogo',1,3),(3,'2025-07-02 00:58:03','Acceso al módulo de catálogo',1,3),(4,'2025-07-02 00:58:05','Acceso al módulo de catálogo',1,3),(5,'2025-07-02 01:00:03','Acceso al módulo de catálogo',1,3),(6,'2025-07-02 01:24:38','Acceso al módulo de catálogo',1,3),(7,'2025-07-02 01:24:45','Acceso al módulo de catálogo',1,3),(8,'2025-07-02 01:24:53','Acceso al módulo de catálogo',1,3),(9,'2025-07-02 01:25:02','Acceso al módulo de catálogo',1,3),(10,'2025-07-02 01:25:10','Acceso al módulo de catálogo',1,3),(11,'2025-07-02 01:48:58','Acceso al módulo de catálogo',1,3),(12,'2025-07-02 01:49:00','Acceso al módulo de catálogo',1,3),(13,'2025-07-02 01:49:21','Acceso al módulo de catálogo',1,3),(14,'2025-07-02 01:49:21','Agregó producto al carrito: Ca',1,3),(15,'2025-07-02 01:49:31','Acceso al módulo de catálogo',1,3),(16,'2025-07-02 22:28:32','Acceso al módulo de catálogo',1,9),(17,'2025-07-02 22:28:46','Acceso al módulo de catálogo',1,9),(18,'2025-07-02 22:28:46','Agregó producto al carrito: Ca',1,9),(19,'2025-07-03 00:47:55','Acceso al módulo de marcas',1,9),(20,'2025-07-03 00:47:57','Acceso al módulo de marcas',1,9),(21,'2025-07-03 00:47:58','Acceso al módulo de marcas',1,9),(22,'2025-07-03 00:47:59','Acceso al módulo de marcas',1,9),(23,'2025-07-03 00:48:00','Acceso al módulo de marcas',1,9),(24,'2025-07-03 00:48:01','Acceso al módulo de marcas',1,9),(25,'2025-07-03 00:48:02','Acceso al módulo de marcas',1,9),(26,'2025-07-03 00:48:03','Acceso al módulo de marcas',1,9),(27,'2025-07-03 00:48:04','Acceso al módulo de marcas',1,9),(28,'2025-07-03 00:48:05','Acceso al módulo de marcas',1,9),(29,'2025-07-03 00:48:06','Acceso al módulo de marcas',1,9),(30,'2025-07-03 00:48:06','Acceso al módulo de marcas',1,9),(31,'2025-07-03 00:48:07','Acceso al módulo de marcas',1,9),(32,'2025-07-03 00:48:07','Acceso al módulo de marcas',1,9),(33,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(34,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(35,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(36,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(37,'2025-07-03 00:48:08','Acceso al módulo de marcas',1,9),(38,'2025-07-03 00:48:09','Acceso al módulo de marcas',1,9),(39,'2025-07-03 00:48:10','Acceso al módulo de marcas',1,9),(40,'2025-07-03 00:48:11','Acceso al módulo de marcas',1,9),(41,'2025-07-03 00:48:11','Acceso al módulo de marcas',1,9),(42,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(43,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(44,'2025-07-03 00:48:12','Acceso al módulo de marcas',1,9),(45,'2025-07-03 00:48:13','Acceso al módulo de marcas',1,9),(46,'2025-07-03 00:48:14','Acceso al módulo de marcas',1,9),(47,'2025-07-03 00:48:15','Acceso al módulo de marcas',1,9),(48,'2025-07-03 00:48:15','Acceso al módulo de marcas',1,9),(49,'2025-07-03 00:48:16','Acceso al módulo de marcas',1,9),(50,'2025-07-03 00:48:17','Acceso al módulo de marcas',1,9),(51,'2025-07-03 00:48:18','Acceso al módulo de marcas',1,9),(52,'2025-07-03 00:48:19','Acceso al módulo de marcas',1,9),(53,'2025-07-03 00:48:20','Acceso al módulo de marcas',1,9),(54,'2025-07-03 00:48:21','Acceso al módulo de marcas',1,9),(55,'2025-07-03 00:48:22','Acceso al módulo de marcas',1,9),(56,'2025-07-03 00:48:23','Acceso al módulo de marcas',1,9),(57,'2025-07-03 00:48:24','Acceso al módulo de marcas',1,9),(58,'2025-07-03 00:48:24','Acceso al módulo de marcas',1,9),(59,'2025-07-03 00:48:25','Acceso al módulo de marcas',1,9),(60,'2025-07-03 00:48:26','Acceso al módulo de marcas',1,9),(61,'2025-07-03 00:48:27','Acceso al módulo de marcas',1,9),(62,'2025-07-03 00:48:28','Acceso al módulo de marcas',1,9),(63,'2025-07-03 00:48:29','Acceso al módulo de marcas',1,9),(64,'2025-07-03 00:48:30','Acceso al módulo de marcas',1,9),(65,'2025-07-03 00:48:31','Acceso al módulo de marcas',1,9),(66,'2025-07-03 00:48:31','Acceso al módulo de marcas',1,9),(67,'2025-07-03 00:48:32','Acceso al módulo de marcas',1,9),(68,'2025-07-03 00:48:33','Acceso al módulo de marcas',1,9),(69,'2025-07-03 00:48:34','Acceso al módulo de marcas',1,9),(70,'2025-07-03 00:48:35','Acceso al módulo de marcas',1,9),(71,'2025-07-03 00:48:35','Acceso al módulo de marcas',1,9),(72,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(73,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(74,'2025-07-03 00:48:36','Acceso al módulo de marcas',1,9),(75,'2025-07-03 00:48:37','Acceso al módulo de marcas',1,9),(76,'2025-07-03 00:48:37','Acceso al módulo de marcas',1,9),(77,'2025-07-03 00:48:38','Acceso al módulo de marcas',1,9),(78,'2025-07-03 00:48:39','Acceso al módulo de marcas',1,9),(79,'2025-07-03 00:48:40','Acceso al módulo de marcas',1,9),(80,'2025-07-03 00:48:41','Acceso al módulo de marcas',1,9),(81,'2025-07-03 00:48:42','Acceso al módulo de marcas',1,9),(82,'2025-07-03 00:48:43','Acceso al módulo de marcas',1,9),(83,'2025-07-03 00:48:44','Acceso al módulo de marcas',1,9),(84,'2025-07-03 00:48:44','Acceso al módulo de marcas',1,9),(85,'2025-07-03 00:48:45','Acceso al módulo de marcas',1,9),(86,'2025-07-03 00:48:46','Acceso al módulo de marcas',1,9),(87,'2025-07-03 00:48:47','Acceso al módulo de marcas',1,9),(88,'2025-07-03 00:48:48','Acceso al módulo de marcas',1,9),(89,'2025-07-03 00:48:49','Acceso al módulo de marcas',1,9),(90,'2025-07-03 00:48:50','Acceso al módulo de marcas',1,9),(91,'2025-07-03 00:48:51','Acceso al módulo de marcas',1,9),(92,'2025-07-03 00:48:52','Acceso al módulo de marcas',1,9),(93,'2025-07-03 00:48:53','Acceso al módulo de marcas',1,9),(94,'2025-07-03 00:48:54','Acceso al módulo de marcas',1,9),(95,'2025-07-03 00:48:54','Acceso al módulo de marcas',1,9),(96,'2025-07-03 00:48:55','Acceso al módulo de marcas',1,9),(97,'2025-07-03 00:48:56','Acceso al módulo de marcas',1,9),(98,'2025-07-03 00:48:57','Acceso al módulo de marcas',1,9),(99,'2025-07-03 00:48:57','Acceso al módulo de marcas',1,9),(100,'2025-07-03 00:48:58','Acceso al módulo de marcas',1,9),(101,'2025-07-03 00:48:59','Acceso al módulo de marcas',1,9),(102,'2025-07-03 00:49:00','Acceso al módulo de marcas',1,9),(103,'2025-07-03 00:49:01','Acceso al módulo de marcas',1,9),(104,'2025-07-03 00:49:01','Acceso al módulo de marcas',1,9),(105,'2025-07-03 00:49:02','Acceso al módulo de marcas',1,9),(106,'2025-07-03 00:49:03','Acceso al módulo de marcas',1,9),(107,'2025-07-03 00:49:04','Acceso al módulo de marcas',1,9),(108,'2025-07-03 00:49:05','Acceso al módulo de marcas',1,9),(109,'2025-07-03 00:49:06','Acceso al módulo de marcas',1,9),(110,'2025-07-03 00:49:07','Acceso al módulo de marcas',1,9),(111,'2025-07-03 00:49:08','Acceso al módulo de marcas',1,9),(112,'2025-07-03 00:49:09','Acceso al módulo de marcas',1,9),(113,'2025-07-03 00:49:10','Acceso al módulo de marcas',1,9),(114,'2025-07-03 00:49:11','Acceso al módulo de marcas',1,9),(115,'2025-07-03 00:49:12','Acceso al módulo de marcas',1,9),(116,'2025-07-03 00:49:13','Acceso al módulo de marcas',1,9),(117,'2025-07-03 00:49:14','Acceso al módulo de marcas',1,9),(118,'2025-07-03 00:49:15','Acceso al módulo de marcas',1,9),(119,'2025-07-03 00:49:16','Acceso al módulo de marcas',1,9),(120,'2025-07-03 00:49:17','Acceso al módulo de marcas',1,9),(121,'2025-07-03 00:49:18','Acceso al módulo de marcas',1,9),(122,'2025-07-03 00:49:19','Acceso al módulo de marcas',1,9),(123,'2025-07-03 00:49:20','Acceso al módulo de marcas',1,9),(124,'2025-07-03 00:49:21','Acceso al módulo de marcas',1,9),(125,'2025-07-03 00:49:22','Acceso al módulo de marcas',1,9),(126,'2025-07-03 00:49:23','Acceso al módulo de marcas',1,9),(127,'2025-07-03 00:49:24','Acceso al módulo de marcas',1,9),(128,'2025-07-03 00:49:25','Acceso al módulo de marcas',1,9),(129,'2025-07-03 00:49:26','Acceso al módulo de marcas',1,9),(130,'2025-07-03 00:49:27','Acceso al módulo de marcas',1,9),(131,'2025-07-03 00:49:28','Acceso al módulo de marcas',1,9),(132,'2025-07-03 00:49:29','Acceso al módulo de marcas',1,9),(133,'2025-07-03 00:49:30','Acceso al módulo de marcas',1,9),(134,'2025-07-03 00:49:30','Acceso al módulo de marcas',1,9),(135,'2025-07-03 00:49:31','Acceso al módulo de marcas',1,9),(136,'2025-07-03 00:49:32','Acceso al módulo de marcas',1,9),(137,'2025-07-03 00:49:33','Acceso al módulo de marcas',1,9),(138,'2025-07-03 00:49:34','Acceso al módulo de marcas',1,9),(139,'2025-07-03 00:49:35','Acceso al módulo de marcas',1,9),(140,'2025-07-03 00:49:36','Acceso al módulo de marcas',1,9),(141,'2025-07-03 00:49:36','Acceso al módulo de marcas',1,9),(142,'2025-07-03 00:49:37','Acceso al módulo de marcas',1,9),(143,'2025-07-03 00:49:38','Acceso al módulo de marcas',1,9),(144,'2025-07-03 00:49:39','Acceso al módulo de marcas',1,9),(145,'2025-07-03 00:49:40','Acceso al módulo de marcas',1,9),(146,'2025-07-03 00:49:41','Acceso al módulo de marcas',1,9),(147,'2025-07-03 00:49:42','Acceso al módulo de marcas',1,9),(148,'2025-07-03 00:49:43','Acceso al módulo de marcas',1,9),(149,'2025-07-03 00:49:44','Acceso al módulo de marcas',1,9),(150,'2025-07-03 00:49:45','Acceso al módulo de marcas',1,9),(151,'2025-07-03 00:49:46','Acceso al módulo de marcas',1,9),(152,'2025-07-03 00:49:47','Acceso al módulo de marcas',1,9),(153,'2025-07-03 00:49:48','Acceso al módulo de marcas',1,9),(154,'2025-07-03 00:49:49','Acceso al módulo de marcas',1,9),(155,'2025-07-03 00:49:50','Acceso al módulo de marcas',1,9),(156,'2025-07-03 00:49:51','Acceso al módulo de marcas',1,9),(157,'2025-07-03 00:49:52','Acceso al módulo de marcas',1,9),(158,'2025-07-03 00:49:53','Acceso al módulo de marcas',1,9),(159,'2025-07-03 00:49:54','Acceso al módulo de marcas',1,9),(160,'2025-07-03 00:49:55','Acceso al módulo de marcas',1,9),(161,'2025-07-03 00:49:56','Acceso al módulo de marcas',1,9),(162,'2025-07-03 00:49:57','Acceso al módulo de marcas',1,9),(163,'2025-07-03 00:49:58','Acceso al módulo de marcas',1,9),(164,'2025-07-03 00:49:59','Acceso al módulo de marcas',1,9),(165,'2025-07-03 00:50:00','Acceso al módulo de marcas',1,9),(166,'2025-07-03 00:50:01','Acceso al módulo de marcas',1,9),(167,'2025-07-03 00:50:02','Acceso al módulo de marcas',1,9),(168,'2025-07-03 00:50:03','Acceso al módulo de marcas',1,9),(169,'2025-07-03 00:50:04','Acceso al módulo de marcas',1,9),(170,'2025-07-03 00:50:05','Acceso al módulo de marcas',1,9),(171,'2025-07-03 00:50:06','Acceso al módulo de marcas',1,9),(172,'2025-07-03 00:50:07','Acceso al módulo de marcas',1,9),(173,'2025-07-03 00:50:08','Acceso al módulo de marcas',1,9),(174,'2025-07-03 00:50:09','Acceso al módulo de marcas',1,9),(175,'2025-07-03 00:50:10','Acceso al módulo de marcas',1,9),(176,'2025-07-03 00:50:11','Acceso al módulo de marcas',1,9),(177,'2025-07-03 00:50:12','Acceso al módulo de marcas',1,9),(178,'2025-07-03 00:50:13','Acceso al módulo de marcas',1,9),(179,'2025-07-03 00:50:14','Acceso al módulo de marcas',1,9),(180,'2025-07-03 00:50:15','Acceso al módulo de marcas',1,9),(181,'2025-07-03 00:50:16','Acceso al módulo de marcas',1,9),(182,'2025-07-03 00:50:17','Acceso al módulo de marcas',1,9),(183,'2025-07-03 00:50:18','Acceso al módulo de marcas',1,9),(184,'2025-07-03 00:50:19','Acceso al módulo de marcas',1,9),(185,'2025-07-03 00:50:20','Acceso al módulo de marcas',1,9),(186,'2025-07-03 00:50:21','Acceso al módulo de marcas',1,9),(187,'2025-07-03 00:50:22','Acceso al módulo de marcas',1,9),(188,'2025-07-03 00:50:23','Acceso al módulo de marcas',1,9),(189,'2025-07-03 00:50:24','Acceso al módulo de marcas',1,9),(190,'2025-07-03 00:50:25','Acceso al módulo de marcas',1,9),(191,'2025-07-03 00:50:26','Acceso al módulo de marcas',1,9),(192,'2025-07-03 00:50:27','Acceso al módulo de marcas',1,9),(193,'2025-07-03 00:50:28','Acceso al módulo de marcas',1,9),(194,'2025-07-03 00:50:29','Acceso al módulo de marcas',1,9),(195,'2025-07-03 00:50:30','Acceso al módulo de marcas',1,9),(196,'2025-07-03 00:50:31','Acceso al módulo de marcas',1,9),(197,'2025-07-03 00:50:32','Acceso al módulo de marcas',1,9),(198,'2025-07-03 00:50:33','Acceso al módulo de marcas',1,9),(199,'2025-07-03 00:50:34','Acceso al módulo de marcas',1,9),(200,'2025-07-03 00:50:35','Acceso al módulo de marcas',1,9),(201,'2025-07-03 00:50:36','Acceso al módulo de marcas',1,9),(202,'2025-07-03 00:50:37','Acceso al módulo de marcas',1,9),(203,'2025-07-03 00:50:38','Acceso al módulo de marcas',1,9),(204,'2025-07-03 00:50:39','Acceso al módulo de marcas',1,9),(205,'2025-07-03 00:50:40','Acceso al módulo de marcas',1,9),(206,'2025-07-03 08:50:49','Acceso al módulo de despacho',3,9),(207,'2025-07-03 08:55:48','Acceso al módulo de Usuarios',1,8),(208,'2025-07-03 09:20:49','Actualización de usuario: Dieg',1,8),(209,'2025-07-03 09:21:01','Eliminación de cuenta: (ID: 7)',1,8),(210,'2025-07-03 09:21:05','Acceso al módulo de Usuarios',1,8),(211,'2025-07-03 09:21:51','Creación de usuario: PedroSuar',1,8),(212,'2025-07-03 09:22:11','Acceso al módulo de Recepcion',2,8),(213,'2025-07-03 09:27:57','Acceso al módulo de Recepcion',2,8),(214,'2025-07-03 09:28:26','Creación de recepción: 0909',2,8),(215,'2025-07-03 09:28:47','Acceso al módulo de Recepcion',2,8),(216,'2025-07-03 09:30:34','Acceso al módulo de Recepcion',2,8),(217,'2025-07-03 09:37:02','Acceso al módulo de despacho',3,9),(218,'2025-07-03 09:37:23','Creación de despacho: 7777',3,9),(219,'2025-07-03 09:37:41','Actualización de despacho: 777',3,9),(220,'2025-07-03 09:37:46','Actualización de despacho: 777',3,9),(221,'2025-07-03 09:38:07','Acceso al módulo de Recepcion',2,9),(222,'2025-07-03 09:38:16','Modificación de Recepción: ',2,9),(223,'2025-07-03 09:40:15','Modificación de Recepción: ',2,9),(224,'2025-07-03 09:40:31','Modificación de Recepción: ',2,9),(225,'2025-07-03 09:42:54','Acceso al módulo de Recepcion',2,9),(226,'2025-07-03 09:43:06','Modificación de Recepción: ',2,9),(227,'2025-07-03 09:43:35','Acceso al módulo de Recepcion',2,8),(228,'2025-07-03 09:44:04','Acceso al módulo de Recepcion',2,8),(229,'2025-07-03 09:47:29','Acceso al módulo de Recepcion',2,8),(230,'2025-07-03 09:53:08','Acceso al módulo de Usuarios',1,8),(231,'2025-07-03 09:53:11','Acceso al módulo de Recepcion',2,8),(232,'2025-07-03 10:04:53','Acceso al módulo de Recepcion',2,8),(233,'2025-07-03 10:10:34','Acceso al módulo de Recepcion',2,8),(234,'2025-07-03 10:17:02','Acceso al módulo de Recepcion',2,8),(235,'2025-07-03 10:17:44','Acceso al módulo de Recepcion',2,8),(236,'2025-07-03 10:20:33','Acceso al módulo de Recepcion',2,8),(237,'2025-07-03 10:22:28','Acceso al módulo de Recepcion',2,8),(238,'2025-07-03 10:22:49','Acceso al módulo de despacho',3,8),(239,'2025-07-03 10:23:29','Acceso al módulo de despacho',3,8),(240,'2025-07-03 10:26:48','Acceso al módulo de Recepcion',2,8),(241,'2025-07-03 10:28:57','Acceso al módulo de Recepcion',2,8),(242,'2025-07-03 10:29:07','Acceso al módulo de despacho',3,8),(243,'2025-07-03 10:34:38','Acceso al módulo de Recepcion',2,8),(244,'2025-07-03 10:36:59','Acceso al módulo de Recepcion',2,8),(245,'2025-07-03 10:45:18','Acceso al módulo de Recepcion',2,8),(246,'2025-07-03 10:47:42','Acceso al módulo de Recepcion',2,8),(247,'2025-07-03 10:52:44','Acceso al módulo de Recepcion',2,8),(248,'2025-07-03 11:09:55','Acceso al módulo de Recepcion',2,8),(249,'2025-07-03 11:10:44','Acceso al módulo de Recepcion',2,8),(250,'2025-07-03 11:10:53','Acceso al módulo de despacho',3,8),(251,'2025-07-03 11:11:33','Actualización de despacho: 000',3,8),(252,'2025-07-03 11:11:36','Acceso al módulo de Recepcion',2,8),(253,'2025-07-03 11:12:04','Modificación de Recepción: ',2,8),(254,'2025-07-03 11:12:31','Modificación de Recepción: ',2,8),(255,'2025-07-03 11:18:08','Acceso al módulo de Recepcion',2,8),(256,'2025-07-03 11:18:25','Modificación de Recepción: ',2,8),(257,'2025-07-03 11:18:33','Modificación de Recepción: ',2,8),(258,'2025-07-03 11:19:24','Modificación de Recepción: ',2,8),(259,'2025-07-03 11:20:28','Acceso al módulo de Recepcion',2,8),(260,'2025-07-03 11:20:48','Acceso al módulo de Recepcion',2,8),(261,'2025-07-03 11:21:50','Acceso al módulo de Recepcion',2,8),(262,'2025-07-03 11:22:08','Creación de recepción: 820802',2,8),(263,'2025-07-03 11:22:25','Modificación de Recepción: ',2,8),(264,'2025-07-03 11:44:40','Acceso al módulo de Recepcion',2,8),(265,'2025-07-03 11:44:53','Modificación de Recepción: ',2,8),(266,'2025-07-03 11:44:57','Acceso al módulo de despacho',3,8),(267,'2025-07-03 11:45:05','Actualización de despacho: 000',3,8),(268,'2025-07-03 11:49:49','Acceso al módulo de despacho',3,8),(269,'2025-07-03 11:49:52','Acceso al módulo de Recepcion',2,8),(270,'2025-07-03 11:50:12','Acceso al módulo de Recepcion',2,8),(271,'2025-07-03 11:50:21','Modificación de Recepción: ',2,8),(272,'2025-07-03 11:50:24','Modificación de Recepción: ',2,8),(273,'2025-07-03 11:52:23','Acceso al módulo de Recepcion',2,8),(274,'2025-07-03 11:52:33','Modificación de Recepción: ',2,8),(275,'2025-07-03 11:52:38','Acceso al módulo de Recepcion',2,8),(276,'2025-07-03 11:52:50','Modificación de Recepción: ',2,8),(277,'2025-07-03 11:52:54','Acceso al módulo de Recepcion',2,8),(278,'2025-07-03 11:55:23','Acceso al módulo de Recepcion',2,8),(279,'2025-07-03 11:55:33','Modificación de Recepción: ',2,8),(280,'2025-07-03 11:57:57','Acceso al módulo de Recepcion',2,8),(281,'2025-07-03 12:02:03','Acceso al módulo de Recepcion',2,8),(282,'2025-07-03 12:04:58','Acceso al módulo de Recepcion',2,8),(283,'2025-07-03 12:05:08','Modificación de Recepción: 000',2,8),(284,'2025-07-03 12:05:10','Acceso al módulo de Recepcion',2,8),(285,'2025-07-03 12:07:45','Modificación de Recepción: 000',2,8),(286,'2025-07-03 12:07:47','Acceso al módulo de Recepcion',2,8),(287,'2025-07-03 12:14:10','Acceso al módulo de Recepcion',2,8),(288,'2025-07-03 12:25:37','Acceso al módulo de catálogo',10,4),(289,'2025-07-03 12:25:42','Acceso al módulo de catálogo',10,4),(290,'2025-07-03 12:37:21','Acceso al módulo de catálogo',10,4),(291,'2025-07-03 12:41:13','Acceso al módulo de Orden de D',14,9),(292,'2025-07-03 12:42:58','Acceso al módulo de catálogo',10,4),(293,'2025-07-03 12:43:20','Acceso al módulo de catálogo',10,4),(294,'2025-07-03 12:43:21','Acceso al módulo de catálogo',10,4),(295,'2025-07-03 12:43:27','Acceso al módulo de Orden de D',14,9),(296,'2025-07-03 12:52:59','Acceso al módulo de Orden de D',14,9),(297,'2025-07-03 12:54:26','Acceso al módulo de Orden de D',14,9),(298,'2025-07-03 12:54:34','Acceso al módulo de catálogo',10,4),(299,'2025-07-03 12:58:49','Acceso al módulo de catálogo',10,4),(316,'2025-07-03 13:07:04','Acceso al módulo de cliente',9,9),(317,'2025-07-03 13:07:21','Creación de cliente: Diego',9,9),(318,'2025-07-03 13:07:46','Creación de cliente: Brayan Me',9,9),(319,'2025-07-03 13:08:04','Creación de cliente: Paula Med',9,9),(320,'2025-07-03 13:08:14','Creación de cliente: Simon Fre',9,9),(321,'2025-07-03 13:09:36','Acceso al módulo de cliente',9,9),(323,'2025-07-03 13:09:47','Acceso al módulo de catálogo',10,4),(324,'2025-07-03 13:09:55','Agregó producto al carrito: Cl',10,4),(325,'2025-07-03 13:19:39','Acceso al módulo de catálogo',10,4),(326,'2025-07-03 13:43:28','Acceso al módulo de Usuarios',1,9),(327,'2025-07-03 13:43:42','Cambio de estatus a inhabilita',1,9),(328,'2025-07-03 13:43:45','Cambio de estatus a inhabilita',1,9),(329,'2025-07-03 13:45:14','Acceso al módulo de Usuarios',1,9),(330,'2025-07-03 13:45:58','Acceso al módulo de Usuarios',1,9),(331,'2025-07-03 13:47:10','Acceso al módulo de Usuarios',1,9),(332,'2025-07-03 14:03:12','Acceso al módulo de catálogo',10,9),(333,'2025-07-03 14:04:08','Acceso al módulo de catálogo',10,4),(334,'2025-07-03 14:04:35','Agregó producto al carrito: Ca',10,4),(335,'2025-07-03 14:04:59','Acceso al módulo de catálogo',10,4),(336,'2025-07-03 14:05:02','Agregó producto al carrito: Ca',10,4),(343,'2025-07-03 14:25:16','Acceso al módulo de Orden de D',14,9),(344,'2025-07-03 14:26:14','Registro de orden de despacho:',14,9),(345,'2025-07-03 14:26:16','Acceso al módulo de Orden de D',14,9),(346,'2025-07-03 14:31:28','Acceso al módulo de despacho',3,9),(347,'2025-07-03 14:32:28','Creación de despacho: 14343',3,9),(348,'2025-07-03 14:35:27','Acceso al módulo de Recepcion',2,9),(349,'2025-07-03 14:36:43','Acceso al módulo de Productos',6,9),(350,'2025-07-03 14:36:44','Acceso al módulo de Productos',6,9),(351,'2025-07-03 14:38:08','Acceso al módulo de marcas',4,9),(352,'2025-07-03 14:38:24','Acceso al módulo de Productos',6,9),(353,'2025-07-03 14:38:24','Acceso al módulo de Productos',6,9),(354,'2025-07-03 14:39:56','Acceso al módulo de categoria',7,9),(355,'2025-07-04 06:42:16','Acceso al módulo de marcas',4,9),(356,'2025-07-04 06:42:19','Acceso al módulo de Usuarios',1,9),(357,'2025-07-04 06:42:21','Acceso al módulo de Recepcion',2,9),(358,'2025-07-04 06:42:22','Acceso al módulo de despacho',3,9),(359,'2025-07-04 06:42:24','Acceso al módulo de marcas',4,9),(360,'2025-07-04 06:42:26','Acceso al módulo de despacho',3,9),(361,'2025-07-04 06:42:28','Acceso al módulo de Recepcion',2,9),(362,'2025-07-04 06:42:32','Acceso al módulo de despacho',3,9),(363,'2025-07-04 06:42:34','Acceso al módulo de marcas',4,9),(364,'2025-07-04 06:42:35','Acceso al módulo de Modelos',5,9),(365,'2025-07-04 06:42:39','Acceso al módulo de Productos',6,9),(366,'2025-07-04 06:42:39','Acceso al módulo de Productos',6,9),(367,'2025-07-04 06:42:43','Acceso al módulo de categoria',7,9),(368,'2025-07-04 06:42:47','Acceso al módulo de proveedore',8,9),(369,'2025-07-04 06:42:51','Acceso al módulo de cliente',9,9),(370,'2025-07-04 06:42:54','Acceso al módulo de cliente',9,9),(371,'2025-07-04 06:42:56','Acceso al módulo de catálogo',10,9),(373,'2025-07-04 06:43:52','Acceso al módulo de cuentas ba',15,9),(374,'2025-07-04 06:43:59','Acceso al módulo de cliente',9,9),(375,'2025-07-04 06:44:23','Acceso al módulo de Orden de D',14,9),(376,'2025-07-04 06:44:44','Acceso al módulo de Roles',18,9),(377,'2025-07-04 06:44:50','Acceso al módulo de bitacora',1,9),(378,'2025-07-04 06:46:01','Acceso al módulo de bitacora',1,9),(379,'2025-07-05 20:49:18','Acceso al módulo de catálogo',10,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=33200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisos`
--

LOCK TABLES `tbl_permisos` WRITE;
/*!40000 ALTER TABLE `tbl_permisos` DISABLE KEYS */;
INSERT INTO `tbl_permisos` VALUES (32420,'consultar',6,1,'Permitido'),(32421,'incluir',6,1,'Permitido'),(32422,'modificar',6,1,'Permitido'),(32423,'eliminar',6,1,'Permitido'),(32424,'consultar',6,2,'Permitido'),(32425,'incluir',6,2,'Permitido'),(32426,'modificar',6,2,'Permitido'),(32427,'eliminar',6,2,'Permitido'),(32428,'consultar',6,3,'Permitido'),(32429,'incluir',6,3,'Permitido'),(32430,'modificar',6,3,'Permitido'),(32431,'eliminar',6,3,'Permitido'),(32432,'consultar',6,4,'Permitido'),(32433,'incluir',6,4,'Permitido'),(32434,'modificar',6,4,'Permitido'),(32435,'eliminar',6,4,'Permitido'),(32436,'consultar',6,5,'Permitido'),(32437,'incluir',6,5,'Permitido'),(32438,'modificar',6,5,'Permitido'),(32439,'eliminar',6,5,'Permitido'),(32440,'consultar',6,6,'Permitido'),(32441,'incluir',6,6,'Permitido'),(32442,'modificar',6,6,'Permitido'),(32443,'eliminar',6,6,'Permitido'),(32444,'consultar',6,7,'Permitido'),(32445,'incluir',6,7,'Permitido'),(32446,'modificar',6,7,'Permitido'),(32447,'eliminar',6,7,'Permitido'),(32448,'consultar',6,8,'Permitido'),(32449,'incluir',6,8,'Permitido'),(32450,'modificar',6,8,'Permitido'),(32451,'eliminar',6,8,'Permitido'),(32452,'consultar',6,9,'Permitido'),(32453,'incluir',6,9,'Permitido'),(32454,'modificar',6,9,'Permitido'),(32455,'eliminar',6,9,'Permitido'),(32456,'consultar',6,10,'Permitido'),(32457,'incluir',6,10,'Permitido'),(32458,'modificar',6,10,'Permitido'),(32459,'eliminar',6,10,'Permitido'),(32460,'consultar',6,14,'Permitido'),(32461,'incluir',6,14,'Permitido'),(32462,'modificar',6,14,'Permitido'),(32463,'eliminar',6,14,'Permitido'),(32464,'consultar',6,15,'Permitido'),(32465,'incluir',6,15,'Permitido'),(32466,'modificar',6,15,'Permitido'),(32467,'eliminar',6,15,'Permitido'),(32468,'consultar',6,18,'Permitido'),(32469,'incluir',6,18,'Permitido'),(32470,'modificar',6,18,'Permitido'),(32471,'eliminar',6,18,'Permitido'),(32940,'consultar',1,1,'Permitido'),(32941,'incluir',1,1,'Permitido'),(32942,'modificar',1,1,'Permitido'),(32943,'eliminar',1,1,'Permitido'),(32944,'consultar',1,2,'Permitido'),(32945,'incluir',1,2,'Permitido'),(32946,'modificar',1,2,'Permitido'),(32947,'eliminar',1,2,'Permitido'),(32948,'consultar',1,3,'Permitido'),(32949,'incluir',1,3,'Permitido'),(32950,'modificar',1,3,'Permitido'),(32951,'eliminar',1,3,'Permitido'),(32952,'consultar',1,4,'Permitido'),(32953,'incluir',1,4,'Permitido'),(32954,'modificar',1,4,'Permitido'),(32955,'eliminar',1,4,'Permitido'),(32956,'consultar',1,5,'Permitido'),(32957,'incluir',1,5,'Permitido'),(32958,'modificar',1,5,'Permitido'),(32959,'eliminar',1,5,'Permitido'),(32960,'consultar',1,6,'Permitido'),(32961,'incluir',1,6,'Permitido'),(32962,'modificar',1,6,'Permitido'),(32963,'eliminar',1,6,'Permitido'),(32964,'consultar',1,7,'Permitido'),(32965,'incluir',1,7,'Permitido'),(32966,'modificar',1,7,'Permitido'),(32967,'eliminar',1,7,'Permitido'),(32968,'consultar',1,8,'Permitido'),(32969,'incluir',1,8,'Permitido'),(32970,'modificar',1,8,'Permitido'),(32971,'eliminar',1,8,'Permitido'),(32972,'consultar',1,9,'Permitido'),(32973,'incluir',1,9,'Permitido'),(32974,'modificar',1,9,'Permitido'),(32975,'eliminar',1,9,'Permitido'),(32976,'consultar',1,10,'No Permitido'),(32977,'incluir',1,10,'No Permitido'),(32978,'modificar',1,10,'No Permitido'),(32979,'eliminar',1,10,'No Permitido'),(32980,'consultar',1,14,'No Permitido'),(32981,'incluir',1,14,'No Permitido'),(32982,'modificar',1,14,'No Permitido'),(32983,'eliminar',1,14,'No Permitido'),(32984,'consultar',1,15,'Permitido'),(32985,'incluir',1,15,'Permitido'),(32986,'modificar',1,15,'Permitido'),(32987,'eliminar',1,15,'Permitido'),(32988,'consultar',1,18,'Permitido'),(32989,'incluir',1,18,'Permitido'),(32990,'modificar',1,18,'Permitido'),(32991,'eliminar',1,18,'Permitido'),(32992,'consultar',2,1,'No Permitido'),(32993,'incluir',2,1,'No Permitido'),(32994,'modificar',2,1,'No Permitido'),(32995,'eliminar',2,1,'No Permitido'),(32996,'consultar',2,2,'Permitido'),(32997,'incluir',2,2,'Permitido'),(32998,'modificar',2,2,'Permitido'),(32999,'eliminar',2,2,'Permitido'),(33000,'consultar',2,3,'Permitido'),(33001,'incluir',2,3,'Permitido'),(33002,'modificar',2,3,'Permitido'),(33003,'eliminar',2,3,'Permitido'),(33004,'consultar',2,4,'Permitido'),(33005,'incluir',2,4,'Permitido'),(33006,'modificar',2,4,'Permitido'),(33007,'eliminar',2,4,'Permitido'),(33008,'consultar',2,5,'Permitido'),(33009,'incluir',2,5,'Permitido'),(33010,'modificar',2,5,'Permitido'),(33011,'eliminar',2,5,'Permitido'),(33012,'consultar',2,6,'Permitido'),(33013,'incluir',2,6,'Permitido'),(33014,'modificar',2,6,'Permitido'),(33015,'eliminar',2,6,'Permitido'),(33016,'consultar',2,7,'Permitido'),(33017,'incluir',2,7,'Permitido'),(33018,'modificar',2,7,'Permitido'),(33019,'eliminar',2,7,'Permitido'),(33020,'consultar',2,8,'No Permitido'),(33021,'incluir',2,8,'No Permitido'),(33022,'modificar',2,8,'No Permitido'),(33023,'eliminar',2,8,'No Permitido'),(33024,'consultar',2,9,'Permitido'),(33025,'incluir',2,9,'Permitido'),(33026,'modificar',2,9,'Permitido'),(33027,'eliminar',2,9,'Permitido'),(33028,'consultar',2,10,'Permitido'),(33029,'incluir',2,10,'Permitido'),(33030,'modificar',2,10,'Permitido'),(33031,'eliminar',2,10,'Permitido'),(33032,'consultar',2,14,'Permitido'),(33033,'incluir',2,14,'Permitido'),(33034,'modificar',2,14,'Permitido'),(33035,'eliminar',2,14,'Permitido'),(33036,'consultar',2,15,'Permitido'),(33037,'incluir',2,15,'No Permitido'),(33038,'modificar',2,15,'No Permitido'),(33039,'eliminar',2,15,'No Permitido'),(33040,'consultar',2,18,'No Permitido'),(33041,'incluir',2,18,'No Permitido'),(33042,'modificar',2,18,'No Permitido'),(33043,'eliminar',2,18,'No Permitido'),(33044,'consultar',3,1,'No Permitido'),(33045,'incluir',3,1,'No Permitido'),(33046,'modificar',3,1,'No Permitido'),(33047,'eliminar',3,1,'No Permitido'),(33048,'consultar',3,2,'No Permitido'),(33049,'incluir',3,2,'No Permitido'),(33050,'modificar',3,2,'No Permitido'),(33051,'eliminar',3,2,'No Permitido'),(33052,'consultar',3,3,'No Permitido'),(33053,'incluir',3,3,'No Permitido'),(33054,'modificar',3,3,'No Permitido'),(33055,'eliminar',3,3,'No Permitido'),(33056,'consultar',3,4,'No Permitido'),(33057,'incluir',3,4,'No Permitido'),(33058,'modificar',3,4,'No Permitido'),(33059,'eliminar',3,4,'No Permitido'),(33060,'consultar',3,5,'No Permitido'),(33061,'incluir',3,5,'No Permitido'),(33062,'modificar',3,5,'No Permitido'),(33063,'eliminar',3,5,'No Permitido'),(33064,'consultar',3,6,'No Permitido'),(33065,'incluir',3,6,'No Permitido'),(33066,'modificar',3,6,'No Permitido'),(33067,'eliminar',3,6,'No Permitido'),(33068,'consultar',3,7,'No Permitido'),(33069,'incluir',3,7,'No Permitido'),(33070,'modificar',3,7,'No Permitido'),(33071,'eliminar',3,7,'No Permitido'),(33072,'consultar',3,8,'No Permitido'),(33073,'incluir',3,8,'No Permitido'),(33074,'modificar',3,8,'No Permitido'),(33075,'eliminar',3,8,'No Permitido'),(33076,'consultar',3,9,'No Permitido'),(33077,'incluir',3,9,'No Permitido'),(33078,'modificar',3,9,'No Permitido'),(33079,'eliminar',3,9,'No Permitido'),(33080,'consultar',3,10,'Permitido'),(33081,'incluir',3,10,'No Permitido'),(33082,'modificar',3,10,'No Permitido'),(33083,'eliminar',3,10,'No Permitido'),(33084,'consultar',3,14,'Permitido'),(33085,'incluir',3,14,'Permitido'),(33086,'modificar',3,14,'Permitido'),(33087,'eliminar',3,14,'No Permitido'),(33088,'consultar',3,15,'No Permitido'),(33089,'incluir',3,15,'No Permitido'),(33090,'modificar',3,15,'No Permitido'),(33091,'eliminar',3,15,'No Permitido'),(33092,'consultar',3,18,'No Permitido'),(33093,'incluir',3,18,'No Permitido'),(33094,'modificar',3,18,'No Permitido'),(33095,'eliminar',3,18,'No Permitido'),(33096,'consultar',4,1,'Permitido'),(33097,'incluir',4,1,'Permitido'),(33098,'modificar',4,1,'Permitido'),(33099,'eliminar',4,1,'Permitido'),(33100,'consultar',4,2,'Permitido'),(33101,'incluir',4,2,'Permitido'),(33102,'modificar',4,2,'Permitido'),(33103,'eliminar',4,2,'Permitido'),(33104,'consultar',4,3,'Permitido'),(33105,'incluir',4,3,'Permitido'),(33106,'modificar',4,3,'Permitido'),(33107,'eliminar',4,3,'Permitido'),(33108,'consultar',4,4,'Permitido'),(33109,'incluir',4,4,'Permitido'),(33110,'modificar',4,4,'Permitido'),(33111,'eliminar',4,4,'Permitido'),(33112,'consultar',4,5,'Permitido'),(33113,'incluir',4,5,'Permitido'),(33114,'modificar',4,5,'Permitido'),(33115,'eliminar',4,5,'Permitido'),(33116,'consultar',4,6,'Permitido'),(33117,'incluir',4,6,'Permitido'),(33118,'modificar',4,6,'Permitido'),(33119,'eliminar',4,6,'Permitido'),(33120,'consultar',4,7,'Permitido'),(33121,'incluir',4,7,'Permitido'),(33122,'modificar',4,7,'Permitido'),(33123,'eliminar',4,7,'Permitido'),(33124,'consultar',4,8,'Permitido'),(33125,'incluir',4,8,'Permitido'),(33126,'modificar',4,8,'Permitido'),(33127,'eliminar',4,8,'Permitido'),(33128,'consultar',4,9,'Permitido'),(33129,'incluir',4,9,'Permitido'),(33130,'modificar',4,9,'Permitido'),(33131,'eliminar',4,9,'Permitido'),(33132,'consultar',4,10,'Permitido'),(33133,'incluir',4,10,'Permitido'),(33134,'modificar',4,10,'Permitido'),(33135,'eliminar',4,10,'Permitido'),(33136,'consultar',4,14,'Permitido'),(33137,'incluir',4,14,'Permitido'),(33138,'modificar',4,14,'Permitido'),(33139,'eliminar',4,14,'Permitido'),(33140,'consultar',4,15,'Permitido'),(33141,'incluir',4,15,'Permitido'),(33142,'modificar',4,15,'Permitido'),(33143,'eliminar',4,15,'Permitido'),(33144,'consultar',4,18,'Permitido'),(33145,'incluir',4,18,'Permitido'),(33146,'modificar',4,18,'Permitido'),(33147,'eliminar',4,18,'Permitido'),(33148,'consultar',7,1,'Permitido'),(33149,'incluir',7,1,'Permitido'),(33150,'modificar',7,1,'Permitido'),(33151,'eliminar',7,1,'No Permitido'),(33152,'consultar',7,2,'No Permitido'),(33153,'incluir',7,2,'Permitido'),(33154,'modificar',7,2,'Permitido'),(33155,'eliminar',7,2,'Permitido'),(33156,'consultar',7,3,'No Permitido'),(33157,'incluir',7,3,'No Permitido'),(33158,'modificar',7,3,'No Permitido'),(33159,'eliminar',7,3,'No Permitido'),(33160,'consultar',7,4,'No Permitido'),(33161,'incluir',7,4,'Permitido'),(33162,'modificar',7,4,'No Permitido'),(33163,'eliminar',7,4,'No Permitido'),(33164,'consultar',7,5,'No Permitido'),(33165,'incluir',7,5,'No Permitido'),(33166,'modificar',7,5,'No Permitido'),(33167,'eliminar',7,5,'No Permitido'),(33168,'consultar',7,6,'No Permitido'),(33169,'incluir',7,6,'No Permitido'),(33170,'modificar',7,6,'No Permitido'),(33171,'eliminar',7,6,'No Permitido'),(33172,'consultar',7,7,'No Permitido'),(33173,'incluir',7,7,'No Permitido'),(33174,'modificar',7,7,'No Permitido'),(33175,'eliminar',7,7,'No Permitido'),(33176,'consultar',7,8,'No Permitido'),(33177,'incluir',7,8,'No Permitido'),(33178,'modificar',7,8,'No Permitido'),(33179,'eliminar',7,8,'No Permitido'),(33180,'consultar',7,9,'No Permitido'),(33181,'incluir',7,9,'No Permitido'),(33182,'modificar',7,9,'No Permitido'),(33183,'eliminar',7,9,'No Permitido'),(33184,'consultar',7,10,'No Permitido'),(33185,'incluir',7,10,'No Permitido'),(33186,'modificar',7,10,'No Permitido'),(33187,'eliminar',7,10,'No Permitido'),(33188,'consultar',7,14,'No Permitido'),(33189,'incluir',7,14,'No Permitido'),(33190,'modificar',7,14,'No Permitido'),(33191,'eliminar',7,14,'No Permitido'),(33192,'consultar',7,15,'No Permitido'),(33193,'incluir',7,15,'No Permitido'),(33194,'modificar',7,15,'No Permitido'),(33195,'eliminar',7,15,'No Permitido'),(33196,'consultar',7,18,'No Permitido'),(33197,'incluir',7,18,'No Permitido'),(33198,'modificar',7,18,'No Permitido'),(33199,'eliminar',7,18,'No Permitido');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuarios`
--

LOCK TABLES `tbl_usuarios` WRITE;
/*!40000 ALTER TABLE `tbl_usuarios` DISABLE KEYS */;
INSERT INTO `tbl_usuarios` VALUES (3,'Diego','$2y$10$aVnYPs5gz8QcihC.PT2eQeqg/2B0Vk4TQlPl2hVKz3vbnhoRQVdnW',1,'ejemplo@gmail.com','Diego','Compa','0414-575-3363','habilitado'),(4,'Simon','$2y$10$bJfY45blf5qV66WzNf5.OOTPFjgCEePpBz07GQUc3B0qlKMNzJd8W',3,'ejemplo@gmail.com','Simon Freitez','Cliente','0414-000-0000','habilitado'),(5,'SuperUsu','$2y$10$w7nQw5p6Qw6nQw5p6Qw6nOQw5p6Qw6nQw5p6Qw6nQw5p6Qw6nQw6n',6,'ejemplo@gmail.com','Diego Andres','Lopez Vivas','0414-575-3363','inhabilitado'),(8,'DiegoS','$2y$10$YNp4Po6bWqvBhXD2W4zm6OZk6i.l1QHVzzZLFrn8Y7gQ4.NFU89TW',1,'ggy@gmail.com','Diego','Compa Vendedor','0414-575-3363','habilitado'),(9,'CasaLai','$2y$10$KXRg/AUD.9Y7KubEvzy71e5dDR1GvGNy23XegAYwLjYWOBdcxzqx2',6,'diego0510lopez@gmail.com','Casa','Lai','0414-575-3363','inhabilitado'),(10,'PedroSuarez','$2y$10$PT00UyufNqI.GCexex5.tucnPWSlm1FHot5eBNOb3vBcYHJ9Wblz.',2,'EJEMPLO@GMAIL.COM','Pedro','Suarez','0414-575-3363','habilitado'),(12,'saymons2112','$2y$10$RAN5lVPMUPYfbIWrVVFmgOPinobfOJm0BqvqorKoGPUHkabCstXpu',1,'ejemplo@gmail.com','simon','Freitez','0909-090-9090','habilitado');
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

-- Dump completed on 2025-07-06 20:50:47
