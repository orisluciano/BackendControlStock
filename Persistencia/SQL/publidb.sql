-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: publidb
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `usuarioId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES (1,0,'Empresa de prueba 000',2),(2,0,'Empresa de prueba 001',3);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadopago`
--

DROP TABLE IF EXISTS `estadopago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estadopago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='				';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadopago`
--

LOCK TABLES `estadopago` WRITE;
/*!40000 ALTER TABLE `estadopago` DISABLE KEYS */;
INSERT INTO `estadopago` VALUES (1,0,'Pendiente'),(2,0,'Vencido'),(3,0,'Pagado');
/*!40000 ALTER TABLE `estadopago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrado` tinyint NOT NULL,
  `monto` decimal(7,2) NOT NULL,
  `estadopagoId` int NOT NULL,
  `fechaVencimientp` date NOT NULL,
  `fechaPago` date DEFAULT NULL,
  `usuarioId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,0,10.00,1,'2022-07-29',NULL,2),(2,0,10.00,1,'2022-08-29',NULL,2),(3,0,10.00,1,'2022-09-29',NULL,2),(4,1,10.00,3,'2022-07-29','2022-07-11',3),(5,0,10.00,1,'2022-08-29',NULL,3),(6,0,10.00,1,'2022-09-29',NULL,3),(7,1,10.00,1,'2022-09-29',NULL,3);
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipousuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `borrado` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (1,'administrador',0),(2,'usuario',0);
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
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
  `password` varchar(45) NOT NULL,
  `bloqueado` tinyint NOT NULL,
  `tipoUsuarioId` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,0,'loris','1234',0,1),(2,0,'cliente','1234',0,2),(3,0,'cliente000','1234',0,2),(4,1,'modificado desde prog','pass',0,2),(5,1,'modo postmabn','algo',0,2),(6,0,'Crear Prueba','algo',0,2),(7,0,'Crear Prueba000','algo',0,2),(8,0,'Crear Prueba000','algo',0,2),(9,1,'Modificado Prueba000','algo',0,2),(10,0,'Modificado Prueba001','algo',0,2),(11,0,'Modificado Prueba002','algo',0,2),(12,0,'modificado007','1234',0,2),(13,0,'modificado000','1234',0,2),(14,1,'creado','',0,2),(15,1,'creado','',0,2),(16,1,'creado','',0,2),(17,1,'creado','',0,2),(18,0,'creado','',0,2),(19,0,'creado','',0,2),(20,0,'creado','',0,2),(21,0,'creado','',0,2),(22,0,'creado','',0,2),(23,0,'creado','',0,2),(24,0,'creado','',0,2),(25,0,'creado','',0,2),(26,0,'creado','',0,2),(27,0,'creado','',0,2),(28,0,'creado','',0,2),(29,1,'creado','',0,2),(30,0,'desde form modi','1234',0,2),(31,0,'desde form','1234',0,2),(32,0,'desde form mod','1234',0,2),(33,0,'creado desde form','1234',0,2),(34,0,'desde form','1234',0,2),(35,0,'desde form','1234',0,2),(36,0,'desde form','1234',0,2),(37,0,'desde form','1234',0,2),(38,0,'desde form mod','1234',0,2),(39,0,'','1234',0,2),(40,0,'','1234',0,2),(41,0,'prueba000','1234',0,2),(42,0,'prueba009','1234',0,2),(43,0,'prueba010','1234',0,2),(44,0,'','1234',0,2),(45,0,'','1234',0,2),(46,0,'','1234',0,2),(47,0,'','1234',0,2),(48,0,'89uop','1234',0,2),(49,0,'nuevo01/07/2022','1234',0,2);
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

-- Dump completed on 2022-07-11 13:18:42
