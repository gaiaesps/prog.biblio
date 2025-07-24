CREATE DATABASE  IF NOT EXISTS `bibliodb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bibliodb`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: bibliodb
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
  `id_autori` int NOT NULL,
  `nome` varchar(45) NOT NULL,
  `nazionalita` varchar(45) NOT NULL,
  PRIMARY KEY (`id_autori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autori`
--

LOCK TABLES `autori` WRITE;
/*!40000 ALTER TABLE `autori` DISABLE KEYS */;
INSERT INTO `autori` VALUES (1,'Italo Calvino','Italiana'),(2,'George Orwell','Britannica'),(3,'Haruki Murakami','Giapponese'),(4,'Jane Austen','Britannica'),(5,'Gabriel Garcia Marquez','Colombiana'),(6,'Franz Kafka','Austriaca'),(7,'J.K. Rowling','Britannica'),(8,'Umberto Eco','Italiana'),(9,'Albert Camus','Francese'),(10,'Margaret Atwood','Canadese'),(11,'Kazuo Ishiguro','Britannica'),(12,'Annie Ernaux','Francese'),(13,'Jhumpa Lahiri','Indiana-Americana'),(14,'Orhan Pamuk','Turca'),(15,'Ian McEwan','Britannica'),(16,'Chimamanda Ngozi Adichie','Nigeriana'),(17,'Colson Whitehead','Americana'),(18,'Alice Munro','Canadese'),(19,'David Mitchell','Britannica'),(20,'Han Kang','Coreana'),(21,'Sally Rooney','Irlandese'),(22,'André Aciman','Egiziana-Americana'),(23,'Sayaka Murata','Giapponese'),(24,'Ocean Vuong','Vietnamita-Americana'),(25,'Nicole Krauss','Americana'),(26,'Teju Cole','Nigeriana'),(27,'NoViolet Bulawayo','Zimbabwese'),(28,'Olga Tokarczuk','Polacca'),(29,'Roberto Bolaño','Cilena'),(30,'Khaled Hosseini','Afghana'),(31,'Virginia Woolf','Britannica'),(32,'Isaac Asimov','Americana'),(33,'Aldous Huxley','Britannica'),(34,'Dante Alighieri','Italiana'),(35,'Stephen King','Americana'),(36,'Oscar Wilde','Irlandese'),(37,'Toni Morrison','Americana'),(38,'Charles Dickens','Britannica'),(39,'Leo Tolstoy','Russa'),(40,'Victor Hugo','Francese');
/*!40000 ALTER TABLE `autori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clienti`
--

DROP TABLE IF EXISTS `clienti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clienti` (
  `id_cliente` smallint NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `numero_tel` varchar(45) NOT NULL,
  `indirizzo` varchar(45) NOT NULL,
  `codice_fiscale` varchar(45) DEFAULT NULL,
  `partita_iva` varchar(45) DEFAULT NULL,
  `tipo_cliente` enum('Privato','Servizio Publico') NOT NULL,
  `password` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clienti`
--

LOCK TABLES `clienti` WRITE;
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
INSERT INTO `clienti` VALUES (1,'Federico D\'Angelo','federicodangelo27@gmail.com','3311119112','Via Battistello Caracciolo 16','DNGFRC05D23F839Q',NULL,'Privato','280822'),(2,'Mario Carillo','mario.carillo@alcampus.it','3281383842','Via Francesco Curia 16','CRLMRA03D2222F839I',NULL,'Privato','250125'),(3,'Gaia Esposito','gaia.esposito@alcampus.it','3664514508','Via dell\'elzeviro 29','SPSGAI04C56F839C',NULL,'Privato','000000'),(4,'Claudio Meconi','claudio23mec@gmail.com','3345063494','via Orazio 1','MCNCLD04T23A323P','','Privato','Lavinia123'),(5,'Manuel Molisso','molissomanuel@gmail.com','3914573413','via caffaro 43','MLSMNL04R25H931N','','Privato','Savve'),(6,'Lavinia Castori','lavinia.castori@gmail.com','3333933432','via Orazio 3','CSTLVN03D60H769R','','Privato','chialavi'),(7,'Ciruzzo Vasano','ciruzzo.vasano@yahoo.com','6667184259','via Orazio 7','CRZVSN92K26U901D','','Privato','ciruzzovasano1234');
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collocati`
--

DROP TABLE IF EXISTS `collocati`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collocati` (
  `posizione` varchar(45) DEFAULT NULL,
  `disponibilita` tinyint(1) NOT NULL,
  `settori_id_settore` int NOT NULL,
  `libri_codice_libro` int NOT NULL,
  PRIMARY KEY (`settori_id_settore`,`libri_codice_libro`),
  KEY `fk_Collocati_Settori1_idx` (`settori_id_settore`),
  KEY `fk_Collocati_Libri1_idx` (`libri_codice_libro`),
  CONSTRAINT `fk_Collocati_Libri1` FOREIGN KEY (`libri_codice_libro`) REFERENCES `libri` (`codice_libro`),
  CONSTRAINT `fk_Collocati_Settori1` FOREIGN KEY (`settori_id_settore`) REFERENCES `settori` (`id_settore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collocati`
--

LOCK TABLES `collocati` WRITE;
/*!40000 ALTER TABLE `collocati` DISABLE KEYS */;
INSERT INTO `collocati` VALUES ('ROM.01',1,1,1),('ROM.02',1,1,2),(NULL,0,1,10),(NULL,0,1,11),('ROM.03',1,1,12),(NULL,0,1,14),(NULL,0,1,16),('ROM.04',1,1,23),('ROM.05',1,1,24),('ROM.06',1,1,39),('ROM.07',1,1,40),('ROM.08',1,1,41),('ROM.09',1,1,45),('ROM.10',1,1,46),('ROM.11',1,1,47),('ROM.12',1,1,81),('ROM.13',1,1,82),('ROM.14',1,1,83),('FIL.01',1,2,3),('DIS.01',1,3,4),('DIS.02',1,3,5),('DIS.03',1,3,25),('DIS.04',1,3,27),('DIS.05',1,3,28),('DIS.06',1,3,29),('SAT.01',1,4,6),('FAN.01',1,5,7),('FAN.02',1,5,8),('FAN.03',1,5,17),('FAN.04',1,5,18),('FAN.05',1,5,19),('FAN.06',1,5,26),('NAR.01',1,6,9),('NAR.02',1,6,36),('NAR.03',1,6,37),('NAR.04',1,6,38),('NAR.05',1,6,42),('NAR.06',1,6,43),('NAR.07',1,6,44),('NAR.08',1,6,54),('NAR.09',1,6,55),('NAR.10',1,6,56),('NAR.11',1,6,57),('NAR.12',1,6,58),('NAR.13',1,6,59),('NAR.14',1,6,63),('NAR.15',1,6,64),('NAR.16',1,6,65),('NAR.17',1,6,72),('NAR.18',1,6,73),('NAR.19',1,6,74),('NAR.20',1,6,75),('NAR.21',1,6,76),('NAR.22',1,6,77),('NAR.23',1,6,84),('NAR.24',1,6,85),('NAR.25',1,6,86),('REA.01',1,7,13),(NULL,0,8,15),('GIA.01',1,10,20),('GIA.02',1,10,21),('STO.01',1,11,22),('AUT.01',1,12,30),('AUT.02',1,12,31),('AUT.03',1,12,32),('RAC.01',1,13,33),('RAC.02',1,13,34),('RAC.03',1,13,35),('RAC.04',1,13,48),('RAC.05',1,13,49),('RAC.06',1,13,50),('FAS.01',1,14,51),('FAS.02',1,14,52),('FAS.03',1,14,53),('ROA.01',1,15,60),('ROA.02',1,15,61),('ROA.03',1,15,62),('ROA.04',1,15,69),('ROA.05',1,15,70),('ROA.06',1,15,71),('POE.01',1,16,66),('POE.02',1,16,67),('POE.03',1,16,68),('NAC.01',1,17,78),('NAC.02',1,17,79),('NAC.03',1,17,80);
/*!40000 ALTER TABLE `collocati` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libri`
--

DROP TABLE IF EXISTS `libri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libri` (
  `codice_libro` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `edizione` varchar(45) NOT NULL,
  `anno` int DEFAULT NULL,
  `autori_id_autori` int NOT NULL,
  `costo_prestito` varchar(45) NOT NULL,
  `genere` varchar(45) NOT NULL,
  `copertina` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`codice_libro`,`autori_id_autori`),
  KEY `fk_Libri_Autori1_idx` (`autori_id_autori`),
  CONSTRAINT `fk_Libri_Autori1` FOREIGN KEY (`autori_id_autori`) REFERENCES `autori` (`id_autori`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libri`
--

LOCK TABLES `libri` WRITE;
/*!40000 ALTER TABLE `libri` DISABLE KEYS */;
INSERT INTO `libri` VALUES (1,'Il barone rampante','Prima',1957,1,'2.50','Romanzo','https://www.letsbook.org/wp-content/uploads/2020/03/Calvino-Barone-Rampante.jpg'),(2,'Il barone rampante','Seconda',1957,1,'2.50','Romanzo','https://www.letsbook.org/wp-content/uploads/2020/03/Calvino-Barone-Rampante.jpg'),(3,'Le città invisibili','Prima',1972,1,'2.70','Filosofia','https://www.ibs.it/images/9788804668022_0_0_536_0_75.jpg'),(4,'1984','Prima',1948,2,'2.00','Distopia','https://www.lafeltrinelli.it/images/9788807903816_0_0_536_0_75.jpg'),(5,'1984','Seconda',1948,2,'2.00','Distopia','https://www.lafeltrinelli.it/images/9788807903816_0_0_536_0_75.jpg'),(6,'La fattoria degli animali','Prima',1945,2,'2.10','Satira','https://www.lafeltrinelli.it/images/9788807903793_0_0_424_0_75.jpg'),(7,'Kafka sulla spiaggia','Prima',2002,3,'4.00','Fantastico','https://www.einaudi.it/content/uploads/2013/05/978880621694GRA.JPG'),(8,'Kafka sulla spiaggia','Seconda',2002,3,'4.00','Fantastico','https://www.einaudi.it/content/uploads/2013/05/978880621694GRA.JPG'),(9,'Norwegian Wood','Prima',1987,3,'3.80','Narrativa','https://img.illibraio.it/images/9788806216467_92_310_0_75.jpg'),(10,'Orgoglio e pregiudizio','Prima',1813,4,'2.00','Romanzo','https://m.media-amazon.com/images/I/41ndyj4a1YL.jpg'),(11,'Emma','Prima',1815,4,'2.10','Romanzo','https://m.media-amazon.com/images/I/41FkrRvWHJL.jpg'),(12,'Ragione e sentimento','Prima',1811,4,'2.10','Romanzo','https://www.einaudi.it/content/uploads/2015/07/978880622817GRA.JPG'),(13,'Cent’anni di solitudine','Prima',1967,5,'3.00','Realismo Magico','https://www.ibs.it/images/9788804314639_0_0_536_0_75.jpg'),(14,'L’amore ai tempi del colera','Prima',1985,5,'3.10','Romanzo','https://img.illibraio.it/images/9788804668244_92_310_0_75.jpg'),(15,'La metamorfosi','Prima',1915,6,'2.00','Romanzo breve','https://www.ibs.it/images/9788806220631_0_0_536_0_75.jpg'),(16,'Il processo','Prima',1925,6,'2.10','Romanzo','https://www.adelphi.it/spool/i__id296_mw1000__1x.jpg'),(17,'Harry Potter e la pietra filosofale','Prima',1997,7,'3.00','Fantasy','https://www.adazing.com/wp-content/uploads/2022/12/Harry-Potter-Book-Covers-Sorcerers-Stone-15.jpg'),(18,'Harry Potter e la pietra filosofale','Seconda',1997,7,'3.00','Fantasy','https://www.adazing.com/wp-content/uploads/2022/12/Harry-Potter-Book-Covers-Sorcerers-Stone-15.jpg'),(19,'Harry Potter e la camera dei segreti','Prima',1998,7,'3.10','Fantasy','https://www.harrypotterworth.com/wp-content/uploads/2021/01/Harry-Potter-e-la-Camera-dei-Segreti-Edizione-Castello-2013-681x1024.jpg'),(20,'Il nome della rosa','Prima',1980,8,'3.00','Giallo storico','https://maremagnum-distribution-point-prod.ams3.cdn.digitaloceanspaces.com/maremagnum/media/thumbnail/products/257600/BOOK-U-010619001-il-nome-della-rosa-1.jpg.1280x1280_q85.jpg'),(21,'Il nome della rosa','Seconda',1980,8,'3.00','Giallo storico','https://maremagnum-distribution-point-prod.ams3.cdn.digitaloceanspaces.com/maremagnum/media/thumbnail/products/257600/BOOK-U-010619001-il-nome-della-rosa-1.jpg.1280x1280_q85.jpg'),(22,'Baudolino','Prima',2000,8,'2.90','Storico','https://iltomo.it/wp-content/uploads/2018/01/baudolino.jpg'),(23,'Lo straniero','Prima',1942,9,'2.60','Romanzo','https://m.media-amazon.com/images/I/41fA9ePHC3L.jpg'),(24,'La peste','Prima',1947,9,'2.80','Romanzo','https://www.ibs.it/images/9788845283512_863491423_0_0_0_75.jpg'),(25,'Il racconto dell’ancella','Prima',1985,10,'3.10','Distopia','https://m.media-amazon.com/images/I/31X-vdiGzKL.jpg'),(26,'Oryx and Crake','Prima',2003,10,'3.20','Fantascienza','https://m.media-amazon.com/images/I/51g0Rgerc9L.jpg'),(27,'Non lasciarmi','Prima',2005,11,'3.00','Distopia','https://www.ibs.it/images/9788806231774_0_0_536_0_75.jpg'),(28,'Non lasciarmi','Seconda',2005,11,'3.00','Distopia','https://www.ibs.it/images/9788806231774_0_0_536_0_75.jpg'),(29,'Non lasciarmi','Terza',2005,11,'3.00','Distopia','https://www.ibs.it/images/9788806231774_0_0_536_0_75.jpg'),(30,'Gli anni','Prima',2008,12,'2.80','Autobiografia','https://www.ibs.it/images/9788898038169_0_0_536_0_75.jpg'),(31,'Gli anni','Seconda',2008,12,'2.80','Autobiografia','https://www.ibs.it/images/9788898038169_0_0_536_0_75.jpg'),(32,'Gli anni','Terza',2008,12,'2.80','Autobiografia','https://www.ibs.it/images/9788898038169_0_0_536_0_75.jpg'),(33,'Interpreter of Maladies','Prima',1999,13,'2.70','Racconti','https://cdn11.bigcommerce.com/s-jo8zgdp0jo/images/stencil/500x659/products/166863/21777/image_file__97042.1740366756.jpg?c=1'),(34,'Interpreter of Maladies','Seconda',1999,13,'2.70','Racconti','https://cdn11.bigcommerce.com/s-jo8zgdp0jo/images/stencil/500x659/products/166863/21777/image_file__97042.1740366756.jpg?c=1'),(35,'Interpreter of Maladies','Terza',1999,13,'2.70','Racconti','https://cdn11.bigcommerce.com/s-jo8zgdp0jo/images/stencil/500x659/products/166863/21777/image_file__97042.1740366756.jpg?c=1'),(36,'Neve','Prima',2002,14,'2.90','Narrativa','https://www.lafeltrinelli.it/images/9788806222703_0_0_424_0_75.jpg'),(37,'Neve','Seconda',2002,14,'2.90','Narrativa','https://www.lafeltrinelli.it/images/9788806222703_0_0_424_0_75.jpg'),(38,'Neve','Terza',2002,14,'2.90','Narrativa','https://www.lafeltrinelli.it/images/9788806222703_0_0_424_0_75.jpg'),(39,'Espiazione','Prima',2001,15,'3.00','Romanzo','https://www.ibs.it/images/9788806227340_0_0_536_0_75.jpg'),(40,'Espiazione','Seconda',2001,15,'3.00','Romanzo','https://www.ibs.it/images/9788806227340_0_0_536_0_75.jpg'),(41,'Espiazione','Terza',2001,15,'3.00','Romanzo','https://www.ibs.it/images/9788806227340_0_0_536_0_75.jpg'),(42,'Americanah','Prima',2013,16,'3.10','Narrativa','https://www.einaudi.it/content/uploads/2015/10/978880622727GRA.JPG'),(43,'Americanah','Seconda',2013,16,'3.10','Narrativa','https://www.einaudi.it/content/uploads/2015/10/978880622727GRA.JPG'),(44,'Americanah','Terza',2013,16,'3.10','Narrativa','https://www.einaudi.it/content/uploads/2015/10/978880622727GRA.JPG'),(45,'The Underground Railroad','Prima',2016,17,'3.20','Romanzo','https://images4.penguinrandomhouse.com/cover/9780385542364'),(46,'The Underground Railroad','Seconda',2016,17,'3.20','Romanzo','https://images4.penguinrandomhouse.com/cover/9780385542364'),(47,'The Underground Railroad','Terza',2016,17,'3.20','Romanzo','https://images4.penguinrandomhouse.com/cover/9780385542364'),(48,'Dear Life','Prima',2012,18,'2.90','Racconti','https://images2.penguinrandomhouse.com/cover/9780307961044'),(49,'Dear Life','Seconda',2012,18,'2.90','Racconti','https://images2.penguinrandomhouse.com/cover/9780307961044'),(50,'Dear Life','Terza',2012,18,'2.90','Racconti','https://images2.penguinrandomhouse.com/cover/9780307961044'),(51,'Cloud Atlas','Prima',2004,19,'3.20','Fantascienza','https://images-na.ssl-images-amazon.com/images/I/41nfFgkdWtL.jpg'),(52,'Cloud Atlas','Seconda',2004,19,'3.20','Fantascienza','https://images-na.ssl-images-amazon.com/images/I/41nfFgkdWtL.jpg'),(53,'Cloud Atlas','Terza',2004,19,'3.20','Fantascienza','https://images-na.ssl-images-amazon.com/images/I/41nfFgkdWtL.jpg'),(54,'La vegetariana','Prima',2007,20,'2.80','Narrativa','https://www.mentinfuga.com/wp-content/uploads/2024/11/Han-Kang-La-vegetariana.jpg'),(55,'La vegetariana','Seconda',2007,20,'2.80','Narrativa','https://www.mentinfuga.com/wp-content/uploads/2024/11/Han-Kang-La-vegetariana.jpg'),(56,'La vegetariana','Terza',2007,20,'2.80','Narrativa','https://www.mentinfuga.com/wp-content/uploads/2024/11/Han-Kang-La-vegetariana.jpg'),(57,'Persone normali','Prima',2018,21,'3.00','Narrativa','https://www.ibs.it/images/9788806241315_0_0_424_0_75.jpg'),(58,'Persone normali','Seconda',2018,21,'3.00','Narrativa','https://www.ibs.it/images/9788806241315_0_0_424_0_75.jpg'),(59,'Persone normali','Terza',2018,21,'3.00','Narrativa','https://www.ibs.it/images/9788806241315_0_0_424_0_75.jpg'),(60,'Chiamami col tuo nome','Prima',2007,22,'3.10','Romantico','https://m.media-amazon.com/images/I/617+2Kz0KrL.jpg'),(61,'Chiamami col tuo nome','Seconda',2007,22,'3.10','Romantico','https://m.media-amazon.com/images/I/617+2Kz0KrL.jpg'),(62,'Chiamami col tuo nome','Terza',2007,22,'3.10','Romantico','https://m.media-amazon.com/images/I/617+2Kz0KrL.jpg'),(63,'La ragazza del convenience store','Prima',2016,23,'2.90','Narrativa','https://www.ibs.it/images/9788833570020_0_0_536_0_75.jpg'),(64,'La ragazza del convenience store','Seconda',2016,23,'2.90','Narrativa','https://www.ibs.it/images/9788833570020_0_0_536_0_75.jpg'),(65,'La ragazza del convenience store','Terza',2016,23,'2.90','Narrativa','https://www.ibs.it/images/9788833570020_0_0_536_0_75.jpg'),(66,'On Earth We’re Briefly Gorgeous','Prima',2019,24,'3.30','Poetico','https://i5.walmartimages.com/seo/On-Earth-We-re-Briefly-Gorgeous-Paperback-9780525562047_da3266a5-df6e-4b0a-9eb1-5b160e851167.ae0d86eb39e318a3cda2fa7484ed0b77.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF'),(67,'On Earth We’re Briefly Gorgeous','Seconda',2019,24,'3.30','Poetico','https://i5.walmartimages.com/seo/On-Earth-We-re-Briefly-Gorgeous-Paperback-9780525562047_da3266a5-df6e-4b0a-9eb1-5b160e851167.ae0d86eb39e318a3cda2fa7484ed0b77.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF'),(68,'On Earth We’re Briefly Gorgeous','Terza',2019,24,'3.30','Poetico','https://i5.walmartimages.com/seo/On-Earth-We-re-Briefly-Gorgeous-Paperback-9780525562047_da3266a5-df6e-4b0a-9eb1-5b160e851167.ae0d86eb39e318a3cda2fa7484ed0b77.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF'),(69,'La storia dell’amore','Prima',2004,25,'2.95','Romantico','https://www.lafeltrinelli.it/images/2570161880035_0_424_0_75.jpg'),(70,'La storia dell’amore','Seconda',2004,25,'2.95','Romantico','https://www.lafeltrinelli.it/images/2570161880035_0_424_0_75.jpg'),(71,'La storia dell’amore','Terza',2004,25,'2.95','Romantico','https://www.lafeltrinelli.it/images/2570161880035_0_424_0_75.jpg'),(72,'Every Day is for the Thief','Prima',2007,26,'2.90','Narrativa','https://res.cloudinary.com/pim-red/image/upload/q_auto,f_auto,w_360/v1571922129/klett/cover/9783125799080.jpg'),(73,'Every Day is for the Thief','Seconda',2007,26,'2.90','Narrativa','https://res.cloudinary.com/pim-red/image/upload/q_auto,f_auto,w_360/v1571922129/klett/cover/9783125799080.jpg'),(74,'Every Day is for the Thief','Terza',2007,26,'2.90','Narrativa','https://res.cloudinary.com/pim-red/image/upload/q_auto,f_auto,w_360/v1571922129/klett/cover/9783125799080.jpg'),(75,'We Need New Names','Prima',2013,27,'3.10','Narrativa','https://thegreatbookwyrm.home.blog/wp-content/uploads/2021/03/91fu6ugo9el.jpg?w=675'),(76,'We Need New Names','Seconda',2013,27,'3.10','Narrativa','https://thegreatbookwyrm.home.blog/wp-content/uploads/2021/03/91fu6ugo9el.jpg?w=675'),(77,'We Need New Names','Terza',2013,27,'3.10','Narrativa','https://thegreatbookwyrm.home.blog/wp-content/uploads/2021/03/91fu6ugo9el.jpg?w=675'),(78,'I vagabondi','Prima',2018,28,'3.00','Narrativa contemporanea','https://www.ibs.it/images/9788845296925_0_0_536_0_75.jpg'),(79,'I vagabondi','Seconda',2018,28,'3.00','Narrativa contemporanea','https://www.ibs.it/images/9788845296925_0_0_536_0_75.jpg'),(80,'I vagabondi','Terza',2018,28,'3.00','Narrativa contemporanea','https://www.ibs.it/images/9788845296925_0_0_536_0_75.jpg'),(81,'2666','Prima',2004,29,'3.50','Romanzo','https://m.media-amazon.com/images/I/51mR+js5teL.jpg'),(82,'2666','Seconda',2004,29,'3.50','Romanzo','https://m.media-amazon.com/images/I/51mR+js5teL.jpg'),(83,'2666','Terza',2004,29,'3.50','Romanzo','https://m.media-amazon.com/images/I/51mR+js5teL.jpg'),(84,'Il cacciatore di aquiloni','Prima',2003,30,'3.10','Narrativa','https://www.lafeltrinelli.it/images/9788856660746_92571541_2_0_0_75.jpg'),(85,'Il cacciatore di aquiloni','Seconda',2003,30,'3.10','Narrativa','https://www.lafeltrinelli.it/images/9788856660746_92571541_2_0_0_75.jpg'),(86,'Il cacciatore di aquiloni','Terza',2003,30,'3.10','Narrativa','https://www.lafeltrinelli.it/images/9788856660746_92571541_2_0_0_75.jpg');
/*!40000 ALTER TABLE `libri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `libri_disponibili`
--

DROP TABLE IF EXISTS `libri_disponibili`;
/*!50001 DROP VIEW IF EXISTS `libri_disponibili`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `libri_disponibili` AS SELECT 
 1 AS `codice_libro`,
 1 AS `titolo`,
 1 AS `edizione`,
 1 AS `anno`,
 1 AS `costo_prestito`,
 1 AS `genere`,
 1 AS `autore`,
 1 AS `posizione`,
 1 AS `settore`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `prestiti`
--

DROP TABLE IF EXISTS `prestiti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestiti` (
  `id_prestito` int NOT NULL,
  `data_inizio` date NOT NULL,
  `clienti_id_cliente` smallint unsigned NOT NULL,
  `data_fine` date NOT NULL,
  `data_restituzione` date DEFAULT NULL,
  PRIMARY KEY (`id_prestito`,`clienti_id_cliente`),
  KEY `fk_prestiti_clienti1_idx` (`clienti_id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestiti`
--

LOCK TABLES `prestiti` WRITE;
/*!40000 ALTER TABLE `prestiti` DISABLE KEYS */;
INSERT INTO `prestiti` VALUES (1,'2025-06-01',1,'2025-06-15','2025-06-14'),(2,'2025-06-10',2,'2025-06-24','2025-06-24'),(3,'2025-06-12',3,'2025-06-26','2025-06-25'),(4,'2025-06-15',1,'2025-06-29','2025-07-01'),(5,'2025-06-20',2,'2025-07-04','2025-07-10'),(6,'2025-06-25',3,'2025-07-09','2025-07-12'),(7,'2025-07-10',1,'2025-07-24',NULL),(8,'2025-07-12',2,'2025-07-26',NULL),(9,'2025-06-30',3,'2025-07-10',NULL),(10,'2025-07-01',1,'2025-07-15',NULL);
/*!40000 ALTER TABLE `prestiti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestiti_libri`
--

DROP TABLE IF EXISTS `prestiti_libri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestiti_libri` (
  `id_prestito` int NOT NULL,
  `codice_libro` int NOT NULL,
  PRIMARY KEY (`id_prestito`,`codice_libro`),
  KEY `CodiceLibro` (`codice_libro`),
  CONSTRAINT `prestiti_libri_ibfk_1` FOREIGN KEY (`id_prestito`) REFERENCES `prestiti` (`id_prestito`),
  CONSTRAINT `prestiti_libri_ibfk_2` FOREIGN KEY (`codice_libro`) REFERENCES `libri` (`codice_libro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestiti_libri`
--

LOCK TABLES `prestiti_libri` WRITE;
/*!40000 ALTER TABLE `prestiti_libri` DISABLE KEYS */;
INSERT INTO `prestiti_libri` VALUES (3,3),(1,5),(5,6),(4,7),(3,8),(2,9),(9,10),(9,11),(1,12),(5,13),(8,14),(7,15),(10,16),(6,18),(3,21),(6,22);
/*!40000 ALTER TABLE `prestiti_libri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ritardi`
--

DROP TABLE IF EXISTS `ritardi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ritardi` (
  `id_ritardi` int NOT NULL,
  `prestiti_id_prestito` int NOT NULL,
  `prestiti_clienti_id_cliente` smallint unsigned NOT NULL,
  `penale` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_ritardi`,`prestiti_id_prestito`,`prestiti_clienti_id_cliente`),
  KEY `fk_ritardi_prestiti1_idx` (`prestiti_id_prestito`,`prestiti_clienti_id_cliente`),
  CONSTRAINT `fk_ritardi_prestiti1` FOREIGN KEY (`prestiti_id_prestito`, `prestiti_clienti_id_cliente`) REFERENCES `prestiti` (`id_prestito`, `clienti_id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ritardi`
--

LOCK TABLES `ritardi` WRITE;
/*!40000 ALTER TABLE `ritardi` DISABLE KEYS */;
INSERT INTO `ritardi` VALUES (1,5,2,NULL),(2,4,1,NULL),(3,6,3,NULL),(4,9,3,NULL),(5,10,1,NULL);
/*!40000 ALTER TABLE `ritardi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settori`
--

DROP TABLE IF EXISTS `settori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settori` (
  `id_settore` int NOT NULL,
  `genere` varchar(45) NOT NULL,
  PRIMARY KEY (`id_settore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settori`
--

LOCK TABLES `settori` WRITE;
/*!40000 ALTER TABLE `settori` DISABLE KEYS */;
INSERT INTO `settori` VALUES (1,'Romanzo'),(2,'Filosofia'),(3,'Distopia'),(4,'Satira'),(5,'Fantastico'),(6,'Narrativa'),(7,'Realismo Magico'),(8,'Romanzo breve'),(10,'Giallo storico'),(11,'Storico'),(12,'Autobiografia'),(13,'Racconti'),(14,'Fantascienza'),(15,'Romantico'),(16,'Poetico'),(17,'Narrativa contemporanea');
/*!40000 ALTER TABLE `settori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `libri_disponibili`
--

/*!50001 DROP VIEW IF EXISTS `libri_disponibili`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `libri_disponibili` AS select `l`.`codice_libro` AS `codice_libro`,`l`.`nome` AS `titolo`,`l`.`edizione` AS `edizione`,`l`.`anno` AS `anno`,`l`.`costo_prestito` AS `costo_prestito`,`l`.`genere` AS `genere`,`a`.`nome` AS `autore`,`c`.`posizione` AS `posizione`,`s`.`genere` AS `settore` from (((`libri` `l` join `collocati` `c` on((`l`.`codice_libro` = `c`.`libri_codice_libro`))) join `autori` `a` on((`l`.`autori_id_autori` = `a`.`id_autori`))) join `settori` `s` on((`c`.`settori_id_settore` = `s`.`id_settore`))) where (`c`.`disponibilita` = true) */;
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

-- Dump completed on 2025-07-24 12:05:28
