-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: c2740163_labyadb
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModif` datetime DEFAULT NULL,
  `etiqueta` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `usuarioId` int DEFAULT NULL,
  `trabajadorId` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favoritos`
--

LOCK TABLES `favoritos` WRITE;
/*!40000 ALTER TABLE `favoritos` DISABLE KEYS */;
/*!40000 ALTER TABLE `favoritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubros`
--

DROP TABLE IF EXISTS `rubros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubros`
--

LOCK TABLES `rubros` WRITE;
/*!40000 ALTER TABLE `rubros` DISABLE KEYS */;
INSERT INTO `rubros` VALUES (1,0,'2025-01-06 20:38:16','2025-01-06 20:38:16','Programacion'),(2,0,'2025-01-06 20:38:27','2025-01-06 20:38:27','Limpieza'),(3,0,'2025-01-06 20:38:37','2025-01-06 20:38:37','Construccion'),(4,0,'2025-01-06 20:38:52','2025-01-06 20:38:52','Peluqueria');
/*!40000 ALTER TABLE `rubros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sugerencias`
--

DROP TABLE IF EXISTS `sugerencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sugerencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `leido` tinyint NOT NULL,
  `usuarioId` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sugerencias`
--

LOCK TABLES `sugerencias` WRITE;
/*!40000 ALTER TABLE `sugerencias` DISABLE KEYS */;
INSERT INTO `sugerencias` VALUES (1,0,'asd',0,1,'2025-03-04 17:43:43','2025-03-04 17:43:43'),(2,0,'algo',0,1,'2025-03-04 17:46:40','2025-03-04 17:46:40'),(3,0,'algo',0,1,'2025-03-04 17:49:24','2025-03-04 17:49:24'),(4,0,'algo',0,1,'2025-03-04 17:49:59','2025-03-04 17:49:59'),(5,0,'qweasdzxc',0,1,'2025-03-04 17:51:56','2025-03-04 17:51:56'),(6,0,'asdzxc',0,1,'2025-03-04 17:57:25','2025-03-04 17:57:25'),(7,0,'zxcsadfgh',0,1,'2025-03-04 17:57:30','2025-03-04 17:57:30'),(8,0,'qweasdzxc',0,9,'2025-03-04 17:58:53','2025-03-04 17:58:53'),(9,0,'sdggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg',0,18,'2025-03-25 11:59:41','2025-03-25 11:59:41'),(10,0,'asa',0,1,'2025-08-21 13:06:35','2025-08-21 13:06:35');
/*!40000 ALTER TABLE `sugerencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocontacto`
--

DROP TABLE IF EXISTS `tipocontacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocontacto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocontacto`
--

LOCK TABLES `tipocontacto` WRITE;
/*!40000 ALTER TABLE `tipocontacto` DISABLE KEYS */;
INSERT INTO `tipocontacto` VALUES (1,0,'2025-01-14 18:38:21','2025-01-14 18:38:21','Telefono/Celular'),(2,0,'2025-01-14 18:38:27','2025-01-14 18:38:27','Email'),(3,0,'2025-01-14 18:38:35','2025-01-14 18:38:35','Facebook'),(4,0,'2025-01-14 18:38:41','2025-01-14 18:38:41','Instagram'),(5,0,'2025-01-14 18:38:55','2025-01-14 18:38:55','Pagina web');
/*!40000 ALTER TABLE `tipocontacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajadorcontacto`
--

DROP TABLE IF EXISTS `trabajadorcontacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajadorcontacto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `trabajadorId` int NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `tipoContactoId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajadorcontacto`
--

LOCK TABLES `trabajadorcontacto` WRITE;
/*!40000 ALTER TABLE `trabajadorcontacto` DISABLE KEYS */;
INSERT INTO `trabajadorcontacto` VALUES (1,0,'2025-01-13 11:54:45','2025-01-13 11:54:45',1,'algo@algo',1),(2,0,'2025-02-04 16:56:03','2025-02-04 16:56:03',1,'algo',1),(3,1,'2025-02-04 17:12:43','2025-02-25 07:31:50',1,'',1),(4,0,'2025-02-04 17:14:52','2025-02-04 17:14:52',1,'098098',1),(5,0,'2025-02-04 17:18:12','2025-02-04 17:18:12',1,'zxc',1),(6,0,'2025-02-04 17:18:27','2025-02-04 17:18:27',1,'zxc',5),(7,0,'2025-02-04 17:19:49','2025-02-04 17:19:49',1,'uikguik',1),(8,0,'2025-02-04 17:21:15','2025-02-04 17:21:15',1,'uikguik09809',5),(9,0,'2025-02-04 17:21:58','2025-02-04 17:21:58',1,'uikguik09809',5),(10,0,'2025-02-04 17:23:05','2025-02-04 17:23:05',1,'iuygiuyg',3),(11,0,'2025-02-04 17:26:33','2025-02-04 17:26:33',1,'iuygiuygzxc',3),(12,0,'2025-02-04 17:31:01','2025-02-04 17:31:01',1,'asdasdasd',1),(13,1,'2025-02-05 04:58:31','2025-02-06 18:31:49',1,'kjuukjh',4),(14,0,'2025-02-05 05:56:04','2025-02-05 05:56:04',1,'sdfsdf',1),(15,1,'2025-02-05 05:57:09','2025-02-25 07:31:57',1,'awaw',1),(16,0,'2025-02-05 05:58:30','2025-02-05 05:58:30',1,'ASZXC',1),(17,1,'2025-02-05 05:59:11','2025-02-06 18:32:05',1,'zxczxbvbn',1),(18,1,'2025-02-05 06:20:21','2025-02-06 16:58:07',1,'luciano',1),(19,1,'2025-02-05 06:23:12','2025-02-06 16:56:25',1,'asd',1),(20,1,'2025-02-05 06:23:19','2025-02-06 16:53:42',1,'vbn',1),(21,0,'2025-02-06 18:32:25','2025-02-06 18:32:25',1,'algo@mail',2),(22,0,'2025-02-13 16:54:38','2025-02-13 16:54:38',1,'https://www.linkedin.com/in/luciano-oris/',5),(23,0,'2025-02-13 16:56:06','2025-02-13 16:56:06',1,'https://ar.linkedin.com/in/luciano-oris',5),(24,0,'2025-02-25 07:32:07','2025-02-25 07:32:07',1,'refqtewthwsytsr',4),(25,0,'2025-03-05 20:31:58','2025-03-05 20:31:58',1,'asdasdasd',2),(26,0,'2025-03-05 20:32:07','2025-03-05 20:32:07',1,'zxczxczxc',5),(27,0,'2025-03-14 15:18:42','2025-03-14 15:18:42',41,'szdfzdsfzsdf',5),(28,0,'2025-03-14 15:18:56','2025-03-14 15:18:56',41,'12312312323',1),(29,0,'2025-03-25 11:57:27','2025-03-25 11:57:27',42,'qwe@gmail.com',2),(30,0,'2025-03-25 11:57:39','2025-03-25 11:57:39',42,'123456786',1);
/*!40000 ALTER TABLE `trabajadorcontacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajadores`
--

DROP TABLE IF EXISTS `trabajadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajadores`
--

LOCK TABLES `trabajadores` WRITE;
/*!40000 ALTER TABLE `trabajadores` DISABLE KEYS */;
INSERT INTO `trabajadores` VALUES (1,0,'Luciano Manuel','Oris','Hola soy programador','2024-12-29 20:37:17','2025-03-05 21:31:19'),(2,0,'Luciano','Oris','Algo','2024-12-31 21:44:56','2025-02-13 11:33:54'),(3,0,'Manuel','Oris','Algo','2024-12-31 21:45:02','2025-02-13 11:33:54'),(4,0,'Francisco','Oris','Algo','2024-12-31 21:45:08','2025-02-13 11:33:54'),(5,0,'modif','modif','Algo','2025-01-14 20:20:55','2025-02-13 11:33:54'),(6,0,'pruebamod','1234','Algo','2025-01-14 20:22:47','2025-02-13 11:33:54'),(7,1,'pruebamod','1234',NULL,'2025-01-15 00:07:19','2025-01-21 21:03:33'),(8,0,'prueba','1234','Algo','2025-01-15 08:14:13','2025-02-13 11:33:54'),(9,0,'prueba','1234','Algo','2025-01-15 08:37:22','2025-02-13 11:33:54'),(10,0,'prueba','1234','Algo','2025-01-15 08:37:36','2025-02-13 11:33:54'),(11,0,'prueba','1234','Algo','2025-01-15 08:39:09','2025-02-13 11:33:54'),(12,0,'prueba','1234','Algo','2025-01-15 08:47:13','2025-02-13 11:33:54'),(13,0,'prueba','1234','Algo','2025-01-15 08:47:15','2025-02-13 11:33:54'),(14,0,'prueba','1234','Algo','2025-01-15 08:48:44','2025-02-13 11:33:54'),(15,0,'prueba','1234','Algo','2025-01-15 08:49:51','2025-02-13 11:33:54'),(16,0,'prueba','1234','Algo','2025-01-15 11:53:37','2025-02-13 11:33:54'),(17,0,'aasdasd','asffcvbn','Algo','2025-01-15 11:59:03','2025-02-13 11:33:54'),(18,0,'prueba','1234','Algo','2025-01-15 12:01:36','2025-02-13 11:33:54'),(19,0,'prueba','1234','Algo','2025-01-15 12:02:16','2025-02-13 11:33:54'),(20,0,'prueba','1234','Algo','2025-01-15 12:02:56','2025-02-13 11:33:54'),(21,0,'prueba','1234','Algo','2025-01-15 17:40:56','2025-02-13 11:33:54'),(22,0,'prueba','1234','Algo','2025-01-15 17:41:37','2025-02-13 11:33:54'),(23,0,'prueba','1234','Algo','2025-01-15 17:45:54','2025-02-13 11:33:54'),(24,0,'prueba','1234','Algo','2025-01-20 07:38:49','2025-02-13 11:33:54'),(25,0,'asd','cxv','Algo','2025-01-20 17:58:52','2025-02-13 11:33:54'),(26,0,'prueba','1234','Algo','2025-01-20 18:31:38','2025-02-13 11:33:54'),(27,0,'prueba','1234','Algo','2025-01-20 18:54:50','2025-02-13 11:33:54'),(28,0,'prueba','1234','Algo','2025-01-20 18:56:10','2025-02-13 11:33:54'),(29,0,'prueba','1234','Algo','2025-01-20 18:56:31','2025-02-13 11:33:54'),(30,0,'prueba','1234','Algo','2025-01-20 19:01:54','2025-02-13 11:33:54'),(31,0,'prueba','1234','Algo','2025-01-20 19:02:40','2025-02-13 11:33:54'),(32,0,'prueba','1234','Algo','2025-01-20 19:02:58','2025-02-13 11:33:54'),(33,0,'prueba','1234','Algo','2025-01-20 19:04:14','2025-02-13 11:33:54'),(34,0,'prueba','1234','Algo','2025-01-20 19:05:06','2025-02-13 11:33:54'),(35,0,'prueba','1234','Algo','2025-01-20 19:05:34','2025-02-13 11:33:54'),(36,0,'prueba','1234','Algo','2025-01-20 19:05:46','2025-02-13 11:33:54'),(37,0,'prueba','1234','Algo','2025-01-20 19:06:05','2025-02-13 11:33:54'),(38,0,'qwe','zxc','Algo','2025-01-20 19:13:15','2025-02-13 11:33:54'),(39,0,'pruebamod','1234','Algo','2025-01-22 17:56:07','2025-02-13 11:33:54'),(40,0,'aasdasd','asffcvbn','Algo','2025-02-13 07:30:01','2025-02-13 11:33:54'),(41,0,'qweqwe','zxc123','aqwasfasfasf','2025-03-14 15:18:10','2025-03-14 15:18:10'),(42,0,'all','zxczxc','asasdasdasdasdasd','2025-03-25 11:55:11','2025-03-25 11:55:11');
/*!40000 ALTER TABLE `trabajadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajadoropinion`
--

DROP TABLE IF EXISTS `trabajadoropinion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajadoropinion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `trabajadorId` int NOT NULL,
  `opinion` varchar(150) NOT NULL,
  `calificacion` int NOT NULL,
  `usuarioId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajadoropinion`
--

LOCK TABLES `trabajadoropinion` WRITE;
/*!40000 ALTER TABLE `trabajadoropinion` DISABLE KEYS */;
INSERT INTO `trabajadoropinion` VALUES (1,0,'2025-01-14 18:40:35','2025-01-14 18:40:35',1,'Buen trabajador',0,2),(2,0,'2025-01-14 18:40:48','2025-01-14 18:40:48',1,'Buen profesional',0,2),(3,0,'2025-01-14 18:54:41','2025-01-14 18:54:41',2,'Buen profesional',0,3),(4,0,'2025-07-09 19:24:54','2025-07-09 19:24:54',1,'asdasd',5,2),(5,0,'2025-07-15 17:08:01','2025-07-15 17:08:01',1,'asdasdasdasd',5,1),(6,0,'2025-07-21 16:00:53','2025-07-21 16:00:53',1,'saasd',1,1),(7,0,'2025-07-25 07:10:15','2025-07-25 07:10:15',1,'asdasdasd',3,1),(8,0,'2025-07-29 22:55:14','2025-07-29 22:55:14',2,'aswasdasd',1,1),(9,0,'2025-07-30 14:35:35','2025-07-30 14:35:35',2,'fgfdgdg',1,1),(10,0,'2025-07-31 20:50:59','2025-07-31 20:50:59',2,'dfhdfhdfh',1,1),(11,0,'2025-07-31 20:51:34','2025-07-31 20:51:34',41,'sadasdasd',1,1),(12,0,'2025-07-31 20:52:09','2025-07-31 20:52:09',2,'asdasdzxc',3,1),(13,0,'2025-07-31 20:59:54','2025-07-31 20:59:54',2,'sdsdfsdf',1,1),(14,0,'2025-07-31 21:02:13','2025-07-31 21:02:13',3,'sdfsdfsdf',1,1),(15,0,'2025-07-31 21:02:19','2025-07-31 21:02:19',3,'sdfsdfsdf',1,1),(16,0,'2025-08-01 07:25:11','2025-08-01 07:25:11',6,'awawdawd',4,1),(17,0,'2025-09-11 13:49:09','2025-09-11 13:49:09',2,'ewrwerwer',3,1);
/*!40000 ALTER TABLE `trabajadoropinion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajadorrubro`
--

DROP TABLE IF EXISTS `trabajadorrubro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajadorrubro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `trabajadorId` int NOT NULL,
  `rubroId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajadorrubro`
--

LOCK TABLES `trabajadorrubro` WRITE;
/*!40000 ALTER TABLE `trabajadorrubro` DISABLE KEYS */;
INSERT INTO `trabajadorrubro` VALUES (1,1,'2025-01-07 07:51:01','2025-01-30 20:53:53',1,1),(2,1,'2025-01-07 12:37:57','2025-01-24 18:53:15',1,2),(3,1,'2025-01-07 12:38:09','2025-01-24 18:52:17',1,3),(4,0,'2025-01-07 12:48:14','2025-01-07 12:48:14',2,1),(5,1,'2025-01-27 19:58:38','2025-01-28 17:10:12',1,2),(6,1,'2025-01-27 19:58:58','2025-01-28 17:10:41',1,2),(7,1,'2025-01-27 20:12:33','2025-01-28 17:10:18',1,1),(8,1,'2025-01-27 20:13:11','2025-01-28 17:10:38',1,4),(9,1,'2025-01-27 20:13:26','2025-01-28 17:10:34',1,3),(10,1,'2025-01-27 22:46:25','2025-01-28 17:10:44',1,1),(11,1,'2025-01-28 07:45:57','2025-01-28 17:10:50',1,3),(12,1,'2025-01-28 07:47:20','2025-01-28 17:10:48',1,2),(13,1,'2025-01-28 08:03:35','2025-01-28 17:10:30',1,2),(14,1,'2025-01-28 16:49:09','2025-01-28 17:10:26',1,3),(15,1,'2025-01-28 16:53:15','2025-01-28 17:10:22',1,4),(16,0,'2025-01-28 17:09:37','2025-01-28 17:09:37',1,15),(17,0,'2025-01-28 17:09:47','2025-01-28 17:09:47',1,14),(18,1,'2025-01-28 17:18:07','2025-01-30 12:25:10',1,2),(19,1,'2025-01-28 17:18:18','2025-01-30 12:25:15',1,4),(20,1,'2025-01-30 12:25:01','2025-01-30 12:25:21',1,3),(21,1,'2025-01-30 17:56:38','2025-01-30 18:07:14',1,3),(22,1,'2025-01-30 17:56:43','2025-01-30 17:59:36',1,4),(23,1,'2025-01-30 17:56:47','2025-01-30 17:59:31',1,2),(24,0,'2025-01-30 20:54:36','2025-01-30 20:54:36',1,1),(25,1,'2025-01-30 20:54:42','2025-01-30 20:56:42',1,2),(26,0,'2025-01-30 20:54:56','2025-01-30 20:54:56',1,2),(27,0,'2025-02-04 17:20:44','2025-02-04 17:20:44',1,3),(28,1,'2025-02-05 04:58:56','2025-02-06 18:31:55',1,4),(29,1,'2025-02-10 13:17:30','2025-03-04 07:22:46',1,4),(30,0,'2025-03-14 15:18:24','2025-03-14 15:18:24',41,1),(31,0,'2025-03-14 15:18:33','2025-03-14 15:18:33',41,3),(32,0,'2025-03-25 11:56:55','2025-03-25 11:56:55',42,1),(33,1,'2025-03-28 07:36:57','2025-03-28 07:37:26',1,4),(34,0,'2025-03-28 07:38:54','2025-03-28 07:38:54',1,4);
/*!40000 ALTER TABLE `trabajadorrubro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trabajadorusuario`
--

DROP TABLE IF EXISTS `trabajadorusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trabajadorusuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  `usuarioId` int NOT NULL,
  `trabajadorId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trabajadorusuario`
--

LOCK TABLES `trabajadorusuario` WRITE;
/*!40000 ALTER TABLE `trabajadorusuario` DISABLE KEYS */;
INSERT INTO `trabajadorusuario` VALUES (1,0,'2025-01-15 19:59:30','2025-01-15 19:59:30',1,1),(2,1,'2025-01-20 18:56:10','2025-01-20 18:56:10',1,28),(3,1,'2025-01-20 18:56:31','2025-01-20 18:56:31',1,29),(4,1,'2025-01-20 19:05:46','2025-01-20 19:05:46',1,36),(5,1,'2025-01-20 19:06:05','2025-01-20 19:06:05',1,37),(6,0,'2025-01-20 19:13:15','2025-01-20 19:13:15',2,38),(7,1,'2025-01-22 17:56:07','2025-01-22 17:56:07',1,39),(8,0,'2025-03-14 15:18:10','2025-03-14 15:18:10',17,41),(9,0,'2025-03-25 11:55:11','2025-03-25 11:55:11',18,42);
/*!40000 ALTER TABLE `trabajadorusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `bloqueado` tinyint NOT NULL,
  `tipoUsuarioId` int NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,0,'loris','123','qwe@hotmail.com',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,0,'algo','1234','algo@algo',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,0,'prueba','asd','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,0,'algo','asd','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,'','','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,1,'','','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,0,'lori','asd','algo@algo',0,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,0,'qwe','qwe','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,0,'luciano','123','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,0,'qweqwe','qwe','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,0,'qweqweqwe','qwe','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,0,'asd','asd','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,0,'zxc','zxc','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,0,'wqe','wqeqweqwe','algo@algo',0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,0,'prueba000','asd','asdasdasd',0,2,'2025-03-06 17:07:58','2025-03-06 17:07:58'),(16,0,'qweqweqweqwe','qweqweqwe','qweqwe@gmail.com',0,2,'2025-03-06 17:12:38','2025-03-06 17:12:38'),(17,0,'qaz','12345678','asd@outlook.com',0,2,'2025-03-14 12:37:31','2025-03-14 12:37:31'),(18,0,'q111','12345678','qwere@hotmail.com',0,2,'2025-03-25 11:54:29','2025-03-25 11:54:29'),(19,0,'zxczxczxc','12345678','zxczxczxc@gmail.com',0,2,'2025-08-26 16:07:33','2025-08-26 16:07:33'),(20,0,'zxczxczxc1','12345678','zxczxczxc1@gmail.com',0,2,'2025-08-26 16:08:13','2025-08-26 16:08:13'),(21,0,'zxczxczxc2','12345678','zxczxczxc1@gmail.com',0,2,'2025-08-26 18:04:24','2025-08-26 18:04:24'),(22,0,'zxczxczxc3','12345678','zxczxczxc1@gmail.com',0,2,'2025-08-26 18:05:51','2025-08-26 18:05:51'),(23,0,'1qweqweqwe','qweqweqwe','qwesadzxc@algo',0,0,'2025-08-27 12:04:58','2025-08-27 12:04:58'),(24,0,'2qweqweqwe','qweqweqwe','qwesadzxc@algo',0,0,'2025-08-27 12:42:18','2025-08-27 12:42:18'),(25,0,'12345678','12345678','qwqe@gmail.com',0,2,'2025-08-27 12:42:57','2025-08-27 12:42:57'),(26,0,'3qweqweqwe','qweqweqwe','qwesadzxc@algo',0,0,'2025-08-29 22:41:40','2025-08-29 22:41:40'),(27,0,'asdasdasdasd','12345678','wqe@gmail.com',0,0,'2025-08-29 23:11:41','2025-08-29 23:11:41'),(28,0,'4qweqweqwe','qweqweqwe','qwesadzxc@algo',0,0,'2025-08-29 23:13:19','2025-08-29 23:13:19'),(29,0,'123456789','12345678','wweq@gmail.com',0,0,'2025-09-01 10:02:20','2025-09-01 10:02:20'),(30,0,'1234567890','12345678','wweq@gmail.com',0,0,'2025-09-01 10:03:34','2025-09-01 10:03:34'),(31,0,'12345678901','            $user = new UsuarioDTO();','qwe@gmail.com',0,2,'2025-09-01 10:07:17','2025-09-01 10:07:17'),(32,0,'123qwesad','12345678','asdasdasd@gmail.com',0,2,'2025-09-01 16:20:19','2025-09-01 16:20:19');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-15 20:50:05
