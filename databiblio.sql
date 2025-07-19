-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: sakila
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `autori`
--

DROP TABLE IF EXISTS `autori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autori` (
  `idAutori` int NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Nazionalità` varchar(45) NOT NULL,
  PRIMARY KEY (`idAutori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autori`
--

LOCK TABLES `autori` WRITE;
/*!40000 ALTER TABLE `autori` DISABLE KEYS */;
/*!40000 ALTER TABLE `autori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clienti`
--

DROP TABLE IF EXISTS `clienti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clienti` (
  `id_cliente` smallint unsigned NOT NULL,
  `nome` varchar(45) NOT NULL,
  `E-mail` varchar(45) NOT NULL,
  `numero_tel` varchar(45) NOT NULL,
  `indirizzo` varchar(45) NOT NULL,
  `codiceF` varchar(45) DEFAULT NULL,
  `PartitaIva` varchar(45) DEFAULT NULL,
  `tipocliente` enum('Privato','Servizio Publico') NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clienti`
--

LOCK TABLES `clienti` WRITE;
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collocati`
--

DROP TABLE IF EXISTS `collocati`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collocati` (
  `Posizione` varchar(45) NOT NULL,
  `Numero_copie` varchar(45) NOT NULL,
  `Disponibilità` tinyint(1) NOT NULL,
  `Settori_idSettore` int NOT NULL,
  `Libri_CodiceLibro` int NOT NULL,
  PRIMARY KEY (`Settori_idSettore`,`Libri_CodiceLibro`),
  KEY `fk_Collocati_Settori1_idx` (`Settori_idSettore`),
  KEY `fk_Collocati_Libri1_idx` (`Libri_CodiceLibro`),
  CONSTRAINT `fk_Collocati_Libri1` FOREIGN KEY (`Libri_CodiceLibro`) REFERENCES `libri` (`CodiceLibro`),
  CONSTRAINT `fk_Collocati_Settori1` FOREIGN KEY (`Settori_idSettore`) REFERENCES `settori` (`idSettore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collocati`
--

LOCK TABLES `collocati` WRITE;
/*!40000 ALTER TABLE `collocati` DISABLE KEYS */;
/*!40000 ALTER TABLE `collocati` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `disponibilità`
--

DROP TABLE IF EXISTS `disponibilità`;
/*!50001 DROP VIEW IF EXISTS `disponibilità`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `disponibilità` AS SELECT 
 1 AS `codicelibro`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `libri`
--

DROP TABLE IF EXISTS `libri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libri` (
  `CodiceLibro` int NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Edizione` varchar(45) NOT NULL,
  `Anno` year NOT NULL,
  `Autori_idAutori` int NOT NULL,
  `CostoPrestito` varchar(45) NOT NULL,
  `Genere` varchar(45) NOT NULL,
  PRIMARY KEY (`CodiceLibro`,`Autori_idAutori`),
  KEY `fk_Libri_Autori1_idx` (`Autori_idAutori`),
  CONSTRAINT `fk_Libri_Autori1` FOREIGN KEY (`Autori_idAutori`) REFERENCES `autori` (`idAutori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libri`
--

LOCK TABLES `libri` WRITE;
/*!40000 ALTER TABLE `libri` DISABLE KEYS */;
/*!40000 ALTER TABLE `libri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestiti`
--

DROP TABLE IF EXISTS `prestiti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestiti` (
  `idprestito` int NOT NULL,
  `DataInizio` date NOT NULL,
  `clienti_id_cliente` smallint unsigned NOT NULL,
  `DataFine` date NOT NULL,
  `DataRestituzione` varchar(45) NOT NULL,
  PRIMARY KEY (`idprestito`,`clienti_id_cliente`),
  KEY `fk_prestiti_clienti1_idx` (`clienti_id_cliente`),
  CONSTRAINT `fk_prestiti_clienti1` FOREIGN KEY (`clienti_id_cliente`) REFERENCES `clienti` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestiti`
--

LOCK TABLES `prestiti` WRITE;
/*!40000 ALTER TABLE `prestiti` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestiti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ritardi`
--

DROP TABLE IF EXISTS `ritardi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ritardi` (
  `idritardi` int NOT NULL,
  `prestiti_idprestito` int NOT NULL,
  `prestiti_clienti_id_cliente` smallint unsigned NOT NULL,
  `penale` varchar(45) NOT NULL,
  PRIMARY KEY (`idritardi`,`prestiti_idprestito`,`prestiti_clienti_id_cliente`),
  KEY `fk_ritardi_prestiti1_idx` (`prestiti_idprestito`,`prestiti_clienti_id_cliente`),
  CONSTRAINT `fk_ritardi_prestiti1` FOREIGN KEY (`prestiti_idprestito`, `prestiti_clienti_id_cliente`) REFERENCES `prestiti` (`idprestito`, `clienti_id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ritardi`
--

LOCK TABLES `ritardi` WRITE;
/*!40000 ALTER TABLE `ritardi` DISABLE KEYS */;
/*!40000 ALTER TABLE `ritardi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settori`
--

DROP TABLE IF EXISTS `settori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settori` (
  `idSettore` int NOT NULL,
  `Genere` varchar(45) NOT NULL,
  PRIMARY KEY (`idSettore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settori`
--

LOCK TABLES `settori` WRITE;
/*!40000 ALTER TABLE `settori` DISABLE KEYS */;
/*!40000 ALTER TABLE `settori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `disponibilità`
--

/*!50001 DROP VIEW IF EXISTS `disponibilità`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `disponibilità` AS select `libri`.`CodiceLibro` AS `codicelibro` from (`libri` join `collocati`) where (`collocati`.`Disponibilità` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-19 17:47:07
