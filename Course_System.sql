-- MariaDB dump 10.19  Distrib 10.10.2-MariaDB, for osx10.18 (x86_64)
--
-- Host: localhost    Database: Course_System
-- ------------------------------------------------------
-- Server version	10.10.2-MariaDB

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
-- Table structure for table `Course`
--

DROP TABLE IF EXISTS `Course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Course` (
  `CS_num` char(10) NOT NULL,
  `CS` char(10) NOT NULL,
  `Credit` int(11) NOT NULL,
  PRIMARY KEY (`CS_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Course`
--

LOCK TABLES `Course` WRITE;
/*!40000 ALTER TABLE `Course` DISABLE KEYS */;
INSERT INTO `Course` VALUES
('000030','數位邏輯電路',3),
('000031','計算機網路',3),
('000032','機器學習與神經網路',2),
('000033','演算法分析與設計',2),
('000034','高級程式語言設計',3),
('000035','計算機結構',3),
('000036','微積分',5),
('000037','線性代數',3),
('000038','數據庫原理',4);
/*!40000 ALTER TABLE `Course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `DP_num` char(10) NOT NULL,
  `DP` char(10) NOT NULL,
  `Dean` char(5) DEFAULT NULL,
  PRIMARY KEY (`DP_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Department`
--

LOCK TABLES `Department` WRITE;
/*!40000 ALTER TABLE `Department` DISABLE KEYS */;
INSERT INTO `Department` VALUES
('001','計算機科學系','余芳'),
('002','網路工程學系','張慶豐'),
('003','軟件工程學系','盧建朱');
/*!40000 ALTER TABLE `Department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Record`
--

DROP TABLE IF EXISTS `Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Record` (
  `STU_num` char(10) NOT NULL,
  `CS_num` char(10) NOT NULL,
  `Grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`STU_num`,`CS_num`),
  KEY `record_ibfk_2` (`CS_num`),
  CONSTRAINT `record_ibfk_1` FOREIGN KEY (`STU_num`) REFERENCES `student` (`STU_num`) ON UPDATE CASCADE,
  CONSTRAINT `record_ibfk_2` FOREIGN KEY (`CS_num`) REFERENCES `Course` (`CS_num`) ON UPDATE CASCADE,
  CONSTRAINT `CONSTRAINT_1` CHECK (`Grade` >= 0 and `Grade` <= 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Record`
--

LOCK TABLES `Record` WRITE;
/*!40000 ALTER TABLE `Record` DISABLE KEYS */;
INSERT INTO `Record` VALUES
('2020056037','000030',NULL),
('2020056037','000033',NULL),
('2020056613','000030',NULL),
('2020056613','000031',NULL),
('2020056613','000032',NULL),
('2020056613','000033',NULL),
('2020056613','000034',NULL),
('2020056613','000035',NULL),
('2020056613','000036',NULL),
('2020056613','000037',NULL),
('2020056613','000038',NULL);
/*!40000 ALTER TABLE `Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student`
--

DROP TABLE IF EXISTS `Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student` (
  `STU_num` char(10) NOT NULL,
  `Name` char(5) NOT NULL,
  `DP_num` char(10) DEFAULT NULL,
  PRIMARY KEY (`STU_num`),
  KEY `student_ibfk_1` (`DP_num`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`DP_num`) REFERENCES `Department` (`DP_num`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student`
--

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;
INSERT INTO `Student` VALUES
('2020056037','黃鈺庭','001'),
('2020056613','陳餃子','001'),
('2020056619','黎翠子','002'),
('2020058868','曹皮卡','003');
/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-12 16:17:43
