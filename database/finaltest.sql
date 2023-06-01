-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: finaltest
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `adminID` varchar(10) NOT NULL,
  `adminName` varchar(50) NOT NULL,
  `adminEmail` varchar(50) NOT NULL,
  `adminpassword` varchar(50) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin01','Shiva','shiva@example.com','Shiva@123');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `attendanceID` int(11) NOT NULL,
  `studentID` varchar(50) NOT NULL,
  `subjectID` varchar(50) NOT NULL,
  `attendanceDate` date NOT NULL,
  `attendanceStatus` enum('Present','Absent') NOT NULL,
  PRIMARY KEY (`attendanceID`),
  KEY `studentID` (`studentID`),
  KEY `subjectID` (`subjectID`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'2021104001','MCA401','2023-05-21','Present'),(2,'2021104002','MCA401','2023-05-21','Absent'),(3,'2021104003','MCA401','2023-05-21','Present'),(4,'2021104004','MCA401','2023-05-21','Present'),(5,'2021104005','MCA401','2023-05-21','Present'),(6,'2021104006','MCA401','2023-05-21','Absent'),(7,'2021104007','MCA401','2023-05-21','Present'),(8,'2021104008','MCA401','2023-05-21','Present'),(9,'2021104009','MCA401','2023-05-21','Absent'),(10,'2021104010','MCA401','2023-05-21','Present'),(11,'2022104001','MCA201','2023-05-21','Present'),(12,'2022104002','MCA201','2023-05-21','Absent'),(13,'2022104003','MCA201','2023-05-21','Present'),(14,'2022104004','MCA201','2023-05-21','Present'),(15,'2022104005','MCA201','2023-05-21','Present'),(16,'2022104006','MCA201','2023-05-21','Absent'),(17,'2022104007','MCA201','2023-05-21','Present'),(18,'2022104008','MCA201','2023-05-21','Present'),(19,'2022104009','MCA201','2023-05-21','Absent'),(20,'2022104010','MCA201','2023-05-21','Present');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `courseID` varchar(50) NOT NULL,
  `courseName` varchar(50) NOT NULL,
  PRIMARY KEY (`courseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES ('MCA1042','MCA_(Second_Semester)'),('MCA1044','MCA_(Fourth_Semester)');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollment` (
  `enrollmentID` bigint(10) NOT NULL,
  `studentID` varchar(50) NOT NULL,
  `subjectID` varchar(50) NOT NULL,
  PRIMARY KEY (`enrollmentID`),
  KEY `studentID` (`studentID`),
  KEY `subjectID` (`subjectID`),
  CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollment`
--

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;
INSERT INTO `enrollment` VALUES (1,'2022104001','MCA201'),(2,'2022104002','MCA201'),(3,'2022104003','MCA201'),(4,'2022104004','MCA201'),(5,'2022104005','MCA201'),(6,'2022104006','MCA201'),(7,'2022104007','MCA201'),(8,'2022104008','MCA201'),(9,'2022104009','MCA201'),(10,'2022104010','MCA201'),(11,'2022104001','MCA202'),(12,'2022104002','MCA202'),(13,'2022104003','MCA202'),(14,'2022104004','MCA202'),(15,'2022104005','MCA202'),(16,'2022104006','MCA202'),(17,'2022104007','MCA202'),(18,'2022104008','MCA202'),(19,'2022104009','MCA202'),(20,'2022104010','MCA202'),(21,'2022104001','MCA203'),(22,'2022104002','MCA203'),(23,'2022104003','MCA203'),(24,'2022104004','MCA203'),(25,'2022104005','MCA203'),(26,'2022104006','MCA203'),(27,'2022104007','MCA203'),(28,'2022104008','MCA203'),(29,'2022104009','MCA203'),(30,'2022104010','MCA203'),(31,'2022104001','MCA205'),(32,'2022104002','MCA205'),(33,'2022104003','MCA205'),(34,'2022104004','MCA205'),(35,'2022104005','MCA205'),(36,'2022104006','MCA205'),(37,'2022104007','MCA205'),(38,'2022104008','MCA205'),(39,'2022104009','MCA205'),(40,'2022104010','MCA205'),(41,'2021104001','MCA401'),(42,'2021104002','MCA401'),(43,'2021104003','MCA401'),(44,'2021104004','MCA401'),(45,'2021104005','MCA401'),(46,'2021104006','MCA401'),(47,'2021104007','MCA401'),(48,'2021104008','MCA401'),(49,'2021104009','MCA401'),(50,'2021104010','MCA401'),(51,'2021104001','MCA456'),(52,'2021104002','MCA456'),(53,'2021104003','MCA456'),(54,'2021104004','MCA456'),(55,'2021104005','MCA456'),(56,'2021104006','MCA456'),(57,'2021104007','MCA456'),(58,'2021104008','MCA456'),(59,'2021104009','MCA456'),(60,'2021104010','MCA456');
/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `studentID` varchar(50) NOT NULL,
  `studentName` varchar(50) NOT NULL,
  `studentEmail` varchar(50) NOT NULL,
  `studentpassword` varchar(50) NOT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('2021104001','Abhishek','2021104001@mmmut.ac.in','abhi001'),('2021104002','Abhishek Sharma','2021104002@mmmut.ac.in','absh002'),('2021104003','Abhishek Singh','2021104003@mmmut.ac.in','absi003'),('2021104004','Abhishek Yadav','2021104004@mmmut.ac.in','abya004'),('2021104005','Aditya Verma','2021104005@mmmut.ac.in','adve005'),('2021104006','Ahmad Faraz','2021104006@mmmut.ac.in','ahfa006'),('2021104007','Akarsh Kumar Yadav','2021104007@mmmut.ac.in','akya007'),('2021104008','Akarshit Jaiswal','2021104008@mmmut.ac.in','akja008'),('2021104009','Amarjeet Kannaujiya','2021104009@mmmut.ac.in','amka009'),('2021104010','Anam Zahid','2021104010@mmmut.ac.in','anza010'),('2022104001','Abhishek Chauhan','2022104001@mmmut.ac.in','abch001'),('2022104002','Abhishek Kumar','2022104002@mmmut.ac.in','abku002'),('2022104003','Abhishek Kumar Maurya','2022104003@mmmut.ac.in','abma003'),('2022104004','Adarsh Mishra','2022104004@mmmut.ac.in','admi004'),('2022104005','Aditya Kumar','2022104005@mmmut.ac.in','adku005'),('2022104006','Aditya Dwivedi','2022104006@mmmut.ac.in','addw006'),('2022104007','Akash Paswan','2022104007@mmmut.ac.in','akpa007'),('2022104008','Akash Vishwakarma','2022104008@mmmut.ac.in','akvi008'),('2022104009','Alok Kannaujia','2022104009@mmmut.ac.in','alka009'),('2022104010','Aman Omer','2022104010@mmmut.ac.in','amom010');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `subjectID` varchar(50) NOT NULL,
  `subjectName` varchar(50) NOT NULL,
  `courseID` varchar(50) NOT NULL,
  PRIMARY KEY (`subjectID`),
  KEY `courseID` (`courseID`),
  CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES ('MCA201','Java Programming','MCA1042'),('MCA202','Data Structures and Applications','MCA1042'),('MCA203','Web Technologies','MCA1042'),('MCA205','SoftwareLab-2','MCA1042'),('MCA401','Internet of Things','MCA1044'),('MCA456','Data Science and Analysis','MCA1044');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher` (
  `teacherID` varchar(10) NOT NULL,
  `teacherName` varchar(50) NOT NULL,
  `teacherEmail` varchar(50) NOT NULL,
  `teacherpassword` varchar(50) NOT NULL,
  PRIMARY KEY (`teacherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES ('HF03','Henry Ford','henryford@example.com','Henry@123'),('JD01','John Doe','johndoe@example.com','John@123'),('KP02','Kevin Patel','kevinpatel@example.com','Kevin@123');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_subject`
--

DROP TABLE IF EXISTS `teacher_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher_subject` (
  `teacherID` varchar(10) NOT NULL,
  `subjectID` varchar(50) NOT NULL,
  PRIMARY KEY (`teacherID`,`subjectID`),
  KEY `subjectID` (`subjectID`),
  CONSTRAINT `teacher_subject_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teacher` (`teacherID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teacher_subject_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_subject`
--

LOCK TABLES `teacher_subject` WRITE;
/*!40000 ALTER TABLE `teacher_subject` DISABLE KEYS */;
INSERT INTO `teacher_subject` VALUES ('HF03','MCA201'),('JD01','MCA203'),('KP02','MCA401');
/*!40000 ALTER TABLE `teacher_subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-01  9:30:24
