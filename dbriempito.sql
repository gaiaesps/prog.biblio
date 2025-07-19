CREATE DATABASE  IF NOT EXISTS `sakila` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sakila`;
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
INSERT INTO `libri` VALUES (1,'Il piccolo principe','Prima',2020,1,'2.50','Narrativa'),(2,'Il piccolo principe','Seconda',2022,1,'2.50','Narrativa'),(3,'1984','Terza',2003,2,'2.00','Distopico'),(4,'1984','Quinta',2012,2,'2.00','Distopico'),(5,'1984','Settima',2020,2,'2.00','Distopico'),(6,'Harry Potter e la pietra filosofale','Prima',1997,3,'2.80','Fantasy'),(7,'Harry Potter e la pietra filosofale','Seconda',1998,3,'2.80','Fantasy'),(8,'Harry Potter e la camera dei segreti','Prima',1998,3,'2.80','Fantasy'),(9,'Il signore degli anelli','Quarta',2001,4,'3.00','Fantasy'),(10,'Il signore degli anelli','Settima',2009,4,'3.00','Fantasy'),(11,'Orgoglio e pregiudizio','Prima',2000,5,'2.20','Classico'),(12,'Orgoglio e pregiudizio','Annotata',2015,5,'2.20','Classico'),(13,'Dune','Decima',2022,6,'3.50','Fantascienza'),(14,'Dune','Undicesima',2023,6,'3.50','Fantascienza'),(15,'Il gattopardo','Seconda',2003,7,'2.80','Storico'),(16,'Il gattopardo','Quarta',2010,7,'2.80','Storico'),(17,'Don Chisciotte','Quinta',2000,8,'2.90','Classico'),(18,'Dracula','Prima',1995,9,'2.60','Horror'),(19,'Dracula','Terza',2018,9,'2.60','Horror'),(20,'Frankenstein','Prima',1990,10,'2.70','Horror'),(21,'Frankenstein','Riveduta',2005,10,'2.70','Horror'),(22,'Il nome della rosa','Prima',1985,4,'3.00','Storico'),(23,'Il nome della rosa','Edizione critica',2010,4,'3.00','Storico'),(24,'Il ritratto di Dorian Gray','Prima',1991,5,'2.30','Classico'),(25,'Il ritratto di Dorian Gray','Terza',2019,5,'2.30','Classico'),(26,'Le notti bianche','Prima',1995,6,'1.90','Classico'),(27,'Le notti bianche','Seconda',2001,6,'1.90','Classico'),(28,'Anna Karenina','Prima',1988,6,'2.80','Classico'),(29,'Anna Karenina','Ristampa aggiornata',2015,6,'2.80','Classico'),(30,'La coscienza di Zeno','Terza',1996,7,'2.30','Letteratura'),(31,'La coscienza di Zeno','Scolastica',2007,7,'2.30','Letteratura'),(32,'Siddhartha','Quinta',2005,8,'2.00','Spiritualità'),(33,'Siddhartha','Settima',2015,8,'2.00','Spiritualità'),(34,'Il deserto dei tartari','Prima',2000,9,'2.10','Classico'),(35,'Il deserto dei tartari','Seconda',2008,9,'2.10','Classico'),(36,'La tregua','Prima',1992,10,'2.40','Storico'),(37,'La tregua','Seconda',2001,10,'2.40','Storico'),(38,'Se questo è un uomo','Prima',1991,10,'2.50','Storico'),(39,'Se questo è un uomo','Edizione integrale',2010,10,'2.50','Storico'),(40,'Cecità','Seconda',2003,2,'2.90','Narrativa'),(41,'Cecità','Edizione illustrata',2021,2,'2.90','Narrativa'),(42,'L’isola misteriosa','Terza',1994,1,'2.20','Avventura'),(43,'L’isola misteriosa','Settima',2010,1,'2.20','Avventura'),(44,'Ventimila leghe sotto i mari','Prima',1990,1,'2.60','Avventura'),(45,'Ventimila leghe sotto i mari','Edizione deluxe',2022,1,'2.60','Avventura'),(46,'Il codice Da Vinci','Prima',2004,3,'3.20','Thriller'),(47,'Il codice Da Vinci','Illustrata',2015,3,'3.20','Thriller'),(48,'Inferno','Prima',2013,3,'3.00','Thriller'),(49,'Inferno','Seconda',2015,3,'3.00','Thriller'),(50,'Angeli e demoni','Prima',2000,3,'3.00','Thriller'),(51,'Angeli e demoni','Seconda',2005,3,'3.00','Thriller'),(52,'Lo Hobbit','Prima',1982,4,'2.90','Fantasy'),(53,'Lo Hobbit','Illustrata',2010,4,'2.90','Fantasy'),(54,'Lo Hobbit','Ristampa 2020',2020,4,'2.90','Fantasy'),(55,'Il vecchio e il mare','Prima',1986,5,'2.10','Narrativa'),(56,'Il vecchio e il mare','Ristampa',2015,5,'2.10','Narrativa'),(57,'Il grande Gatsby','Prima',1994,5,'2.20','Narrativa'),(58,'Il grande Gatsby','Riveduta',2007,5,'2.20','Narrativa'),(59,'Delitto e castigo','Prima',1990,6,'2.40','Classico'),(60,'Delitto e castigo','Annotata',2012,6,'2.40','Classico'),(61,'Il maestro e Margherita','Prima',1989,6,'2.70','Classico'),(62,'Il maestro e Margherita','Edizione critica',2016,6,'2.70','Classico'),(63,'Il barone rampante','Prima',1993,7,'2.50','Narrativa'),(64,'Il barone rampante','Illustrata',2005,7,'2.50','Narrativa'),(65,'La luna e i falò','Prima',1984,7,'2.00','Narrativa'),(66,'La luna e i falò','Seconda',2004,7,'2.00','Narrativa'),(67,'Uno, nessuno e centomila','Prima',1992,8,'2.10','Filosofico'),(68,'Uno, nessuno e centomila','Seconda',2018,8,'2.10','Filosofico'),(69,'Il fu Mattia Pascal','Prima',1985,8,'2.30','Filosofico'),(70,'Il fu Mattia Pascal','Terza',2006,8,'2.30','Filosofico'),(71,'La fattoria degli animali','Prima',1990,2,'2.50','Satira'),(72,'La fattoria degli animali','Ristampa',2013,2,'2.50','Satira'),(73,'Il processo','Prima',1980,9,'2.60','Distopico'),(74,'Il processo','Terza',2002,9,'2.60','Distopico'),(75,'America','Prima',1983,9,'2.40','Narrativa'),(76,'America','Seconda',2001,9,'2.40','Narrativa'),(77,'La metamorfosi','Prima',1995,9,'2.10','Surreale'),(78,'La metamorfosi','Ristampa',2017,9,'2.10','Surreale'),(79,'Furore','Prima',1993,10,'2.70','Drammatico'),(80,'Furore','Illustrata',2011,10,'2.70','Drammatico'),(81,'Uomini e topi','Prima',1991,10,'2.50','Drammatico'),(82,'Uomini e topi','Edizione scolastica',2014,10,'2.50','Drammatico'),(83,'Il giardino dei Finzi-Contini','Prima',1987,4,'2.80','Storico'),(84,'Il giardino dei Finzi-Contini','Seconda',2003,4,'2.80','Storico'),(85,'La nausea','Prima',1996,5,'2.60','Filosofico'),(86,'La nausea','Ristampa',2019,5,'2.60','Filosofico'),(87,'La peste','Prima',1990,5,'2.50','Narrativa'),(88,'La peste','Terza',2007,5,'2.50','Narrativa'),(89,'Il diario di Anna Frank','Prima',1988,6,'2.20','Biografico'),(90,'Il diario di Anna Frank','Illustrata',2010,6,'2.20','Biografico'),(91,'Zanna Bianca','Prima',1990,7,'2.30','Avventura'),(92,'Zanna Bianca','Seconda',2001,7,'2.30','Avventura'),(93,'Il richiamo della foresta','Prima',1985,7,'2.20','Avventura'),(94,'Il richiamo della foresta','Edizione scolastica',2005,7,'2.20','Avventura'),(95,'Cuore','Prima',1992,8,'2.10','Narrativa'),(96,'Cuore','Ristampa',2011,8,'2.10','Narrativa'),(97,'Pinocchio','Prima',1980,8,'2.00','Narrativa'),(98,'Pinocchio','Illustrata',2020,8,'2.00','Narrativa'),(99,'I promessi sposi','Prima',1984,9,'2.50','Storico'),(100,'I promessi sposi','Commentata',2015,9,'2.50','Storico');
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
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
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

-- Dump completed on 2025-07-19 18:30:51
