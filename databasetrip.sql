-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: databaseTrip
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB-0+deb9u1

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
-- Table structure for table `group_details`
--

DROP TABLE IF EXISTS `group_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_details` (
  `group_id` varchar(30) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_details`
--

LOCK TABLES `group_details` WRITE;
/*!40000 ALTER TABLE `group_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `query_replies`
--

DROP TABLE IF EXISTS `query_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `query_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query_id` int(11) NOT NULL,
  `replier_id` int(11) NOT NULL,
  `reply_text` text NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_query_replies_login_user_id` (`replier_id`),
  KEY `fk_query_reply_id` (`query_id`),
  CONSTRAINT `fk_query_replies_login_user_id` FOREIGN KEY (`replier_id`) REFERENCES `user_login` (`id`),
  CONSTRAINT `fk_query_reply_id` FOREIGN KEY (`query_id`) REFERENCES `user_query` (`query_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `query_replies`
--

LOCK TABLES `query_replies` WRITE;
/*!40000 ALTER TABLE `query_replies` DISABLE KEYS */;
INSERT INTO `query_replies` VALUES (1,1,16,'test reply','2019-03-06 23:51:40');
/*!40000 ALTER TABLE `query_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trip_details`
--

DROP TABLE IF EXISTS `trip_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trip_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `trip_name` varchar(50) NOT NULL,
  `place_name` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_trip_user_id` (`user_id`),
  CONSTRAINT `fk_trip_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trip_details`
--

LOCK TABLES `trip_details` WRITE;
/*!40000 ALTER TABLE `trip_details` DISABLE KEYS */;
INSERT INTO `trip_details` VALUES (1,1,'h','ahmedabaad','2019-02-24','2019-02-23'),(2,1,'Trip to Ahmedabad','Ahmedabad','2019-02-19','2019-02-27'),(3,1,'Trip to Amritsar','Amritsar','2019-02-28','2019-03-30'),(4,16,'Trip to Manali','Manali','2019-02-19','2019-02-28'),(5,16,'Manali Trip','Manali','2019-02-23','2019-02-25'),(8,16,'Mumbai trip','Mumbai','2019-03-03','2019-03-06'),(9,17,'Test Trip','Test','2019-03-03','2019-03-04'),(10,17,'Test trip 2','test','2019-03-03','2019-03-28');
/*!40000 ALTER TABLE `trip_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `image` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  KEY `fk_details_login_user_id` (`user_id`),
  CONSTRAINT `fk_details_login_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_documents`
--

DROP TABLE IF EXISTS `user_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `document_name` varchar(25) NOT NULL,
  `document_image` varchar(100) NOT NULL,
  PRIMARY KEY (`document_id`),
  KEY `fk_document_login_user_id` (`user_id`),
  CONSTRAINT `fk_document_login_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_documents`
--

LOCK TABLES `user_documents` WRITE;
/*!40000 ALTER TABLE `user_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `access_token` text,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login`
--

LOCK TABLES `user_login` WRITE;
/*!40000 ALTER TABLE `user_login` DISABLE KEYS */;
INSERT INTO `user_login` VALUES (1,'jaydevdesai15@gmail.com','8128908909',NULL,'2019-01-27 07:45:54'),(2,'jaydevdesai15@yahoo.com','1234',NULL,'2019-01-27 07:56:19'),(3,'jaydevdesai786@gmail.com','hgjgjh',NULL,'2019-01-26 15:32:46'),(4,'juned@example.com','81DC9BDB52D04DC20036DBD8313ED055','a07de6fc7260a09c4ddb2db4d05a944b','2019-02-23 04:28:29'),(16,'juned.khatri31@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','a09f055ec6eb0f4828adf8d6aa97b082','2019-03-02 16:59:09'),(17,'juned3247@gmail.com','4769ad580a03eae7501b5852ea17b82a','09b1d50a1efc6d05266b54f566aab97e','2019-03-03 13:28:24');
/*!40000 ALTER TABLE `user_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notes`
--

DROP TABLE IF EXISTS `user_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`),
  KEY `fk_trip_id_notes` (`trip_id`),
  CONSTRAINT `fk_trip_id_notes` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notes`
--

LOCK TABLES `user_notes` WRITE;
/*!40000 ALTER TABLE `user_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_query`
--

DROP TABLE IF EXISTS `user_query`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_query` (
  `query_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `query_text` text NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`query_id`),
  KEY `fk_query_login_user_id` (`user_id`),
  CONSTRAINT `fk_query_login_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_query`
--

LOCK TABLES `user_query` WRITE;
/*!40000 ALTER TABLE `user_query` DISABLE KEYS */;
INSERT INTO `user_query` VALUES (1,16,'test query','2019-03-06 23:37:40');
/*!40000 ALTER TABLE `user_query` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_reservations`
--

DROP TABLE IF EXISTS `user_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `reservation_name` varchar(25) NOT NULL,
  `reservation_image` varchar(100) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `fk_trip_id_reservation` (`trip_id`),
  CONSTRAINT `fk_trip_id_reservation` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_reservations`
--

LOCK TABLES `user_reservations` WRITE;
/*!40000 ALTER TABLE `user_reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_shopping`
--

DROP TABLE IF EXISTS `user_shopping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_shopping` (
  `trip_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `bought` tinyint(1) NOT NULL,
  KEY `fk_trip_id_shopping` (`trip_id`),
  CONSTRAINT `fk_trip_id_shopping` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_shopping`
--

LOCK TABLES `user_shopping` WRITE;
/*!40000 ALTER TABLE `user_shopping` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_shopping` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-06 23:53:01
