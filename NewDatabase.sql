-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: auctionit
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.30-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `AutoId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `Password_hashed` varchar(256) DEFAULT NULL,
  `Type` varchar(20) NOT NULL,
  `Active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`AutoId`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Alex','e10adc3949ba59abbe56e057f20f883e','1',1),(2,'Dr. Lewis','20318004908c6bb3addc919808e55b77','1',1),(3,'Ellie','35ac2332b603b8f6c24ac293e1d057fd','1',0),(4,'Tyler','5de7bb3c232741f461f3ccd13c1ba7a0','1',1),(5,'Ewen','05a671c66aefea124cc08b76ea6d30bb','1',1);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auctionitem_history`
--

DROP TABLE IF EXISTS `auctionitem_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auctionitem_history` (
  `ItemId` int(11) NOT NULL,
  `AuctionId` int(11) DEFAULT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DonatedBy` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Value` decimal(10,2) DEFAULT NULL,
  `AddedModifiedDate` datetime DEFAULT NULL,
  `AddedModifiedBy` int(11) DEFAULT NULL,
  `Year` year(4) NOT NULL,
  PRIMARY KEY (`ItemId`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctionitem_history`
--

LOCK TABLES `auctionitem_history` WRITE;
/*!40000 ALTER TABLE `auctionitem_history` DISABLE KEYS */;
INSERT INTO `auctionitem_history` VALUES (1,101,'Used Rubiks cube','Alex Helm',4.99,'2018-03-13 00:00:00',1,2018),(1,101,'Time Machine','Man from the future',249.99,'2018-03-13 00:00:00',2,2020),(2,102,'Ts GameCube Controller','Daniel Karem',399.99,'2018-03-13 00:00:00',2,2018),(3,103,'Freshman Tears','Larry Tyler',11.99,'2018-03-13 00:00:00',4,2018),(4,104,'Five Dollars','Mr. Rogers',0.99,'2018-03-13 00:00:00',2,2018),(5,105,'Skynet','Roman Yampolskiy',19.99,'2018-03-13 00:00:00',4,2018),(6,106,'Raspberry Pi','Adrian Lauf',24.99,'2018-03-13 00:00:00',1,2018),(7,107,'CECS Degree','Dr. Elmaghraby',40000.00,'2018-03-13 00:00:00',4,2018),(8,108,'Presidential Pardon','Donald Trump',19.99,'2018-03-13 00:00:00',2,2018),(9,109,'FTL Drive','NASA',99.99,'2018-03-13 00:00:00',4,2018),(10,110,'Pack of Gum','Anonymous',1.99,'2018-03-13 00:00:00',2,2018);
/*!40000 ALTER TABLE `auctionitem_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auctionitems`
--

DROP TABLE IF EXISTS `auctionitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

/* !!!!!!!!! Need to add optional description !!!!!!! */

CREATE TABLE `auctionitems` (
  `ItemId` int(11) NOT NULL AUTO_INCREMENT,
  `AuctionId` int(11) DEFAULT NULL,
  `Description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DonatedBy` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Value` decimal(10,2) DEFAULT NULL,
  `AddedModifiedDate` datetime NOT NULL,
  `AddedModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`ItemId`)
) ENGINE=MyISAM AUTO_INCREMENT=220 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctionitems`
--

LOCK TABLES `auctionitems` WRITE;
/*!40000 ALTER TABLE `auctionitems` DISABLE KEYS */;
INSERT INTO `auctionitems` VALUES (1,101,'Rubiks Cube','Alex',5.00,'2018-03-15 16:17:29',1),(2,102,'Ts GameCube Controller','Daniel Karem',399.99,'2018-03-13 00:00:00',2),(3,103,'Freshman Tears','Larry Tyler',11.99,'2018-03-13 00:00:00',4),(4,104,'Five Dollars','Mr. Rogers',0.99,'2018-03-13 00:00:00',2),(5,105,'Skynet','Roman Yampolskiy',19.99,'2018-03-13 00:00:00',4),(6,106,'Raspberry Pi','Adrian Lauf',24.99,'2018-03-13 00:00:00',1),(7,107,'CECS Degree','Dr. Elmaghraby',40000.00,'2018-03-13 00:00:00',4),(8,108,'Presidential Pardon','Donald Trump',19.99,'2018-03-13 00:00:00',2),(9,109,'FTL Drive','NASA',99.99,'2018-03-13 00:00:00',4),(10,110,'Pack of Gum','Anonymous',1.99,'2018-03-13 00:00:00',2),(219,322,'Ownership of Facebook','Mark Zuckerberg',5.00,'2018-04-15 16:05:36',1),(220,223,'Test Item','Me',-1.00,'2018-04-15 16:05:36',1);
/*!40000 ALTER TABLE `auctionitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bidder_history`
--

DROP TABLE IF EXISTS `bidder_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bidder_history` (
  `Year` year(4) NOT NULL,
  `BidderId` int(11) NOT NULL,
  `Name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Year`,`BidderId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bidder_history`
--

LOCK TABLES `bidder_history` WRITE;
/*!40000 ALTER TABLE `bidder_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `bidder_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bidders`
--

DROP TABLE IF EXISTS `bidders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bidders` (
  `BidderId` int(11) NOT NULL AUTO_INCREMENT,
  `Phone` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`BidderId`)
) ENGINE=MyISAM AUTO_INCREMENT=168473281 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bidders`
--

LOCK TABLES `bidders` WRITE;
/*!40000 ALTER TABLE `bidders` DISABLE KEYS */;
INSERT INTO `bidders` VALUES (168473280,'5026129705','6728 Cassidy Circle','Gummy'),(168473279,'5551112222','1234 DC Comics Road','Bruce Wayne'),(168473276,'8001234567','10 Cloverfield Lane','JJ Abrams'),(168473275,'1234567890','123 Alphabet Lane','Larry Page'),(168473274,'8005557887','555 Generic Road','Jane Doe'),(168473273,'1235551234','0 Nowhere Road','Mystery Man'),(168473272,'5555559090','714 Violet Way','Stephen Hawking');
/*!40000 ALTER TABLE `bidders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bids` (
  `AuctionId` int(11) NOT NULL,
  `BidderId` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Winning` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`AuctionId`,`BidderId`,`Amount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bids`
--

LOCK TABLES `bids` WRITE;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` VALUES (101,168473271,11.00,0),(101,168473272,10.00,0),(101,168473272,45.00,1),(101,168473273,9.00,0),(101,168473275,8.00,0),(101,168473275,12.00,0),(101,168473276,7.00,0),(102,168473273,450.00,1),(102,168473275,401.00,0),(103,168473279,40.00,1);
/*!40000 ALTER TABLE `bids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_history`
--

DROP TABLE IF EXISTS `purchase_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_history` (
  `AuctionId` int(11) NOT NULL,
  `BidderId` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Year` year(4) NOT NULL,
  PRIMARY KEY (`AuctionId`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_history`
--

LOCK TABLES `purchase_history` WRITE;
/*!40000 ALTER TABLE `purchase_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `AuctionId` int(11) NOT NULL,
  `BidderId` int(11) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`AuctionId`,`BidderId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (101,168473272,45.00,1),(102,168473273,450.00,1),(600,168473272,20.00,2),(223,168473275,20.00,1),(103,168473275,20.00,1);
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `viewauctionitemssheet`
--

DROP TABLE IF EXISTS `viewauctionitemssheet`;
/*!50001 DROP VIEW IF EXISTS `viewauctionitemssheet`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewauctionitemssheet` AS SELECT 
 1 AS `auctionId`,
 1 AS `value`,
 1 AS `description`,
 1 AS `donatedBy`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewdonators`
--

DROP TABLE IF EXISTS `viewdonators`;
/*!50001 DROP VIEW IF EXISTS `viewdonators`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewdonators` AS SELECT 
 1 AS `DonatedBy`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewreceipts`
--

DROP TABLE IF EXISTS `viewreceipts`;
/*!50001 DROP VIEW IF EXISTS `viewreceipts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewreceipts` AS SELECT 
 1 AS `AuctionId`,
 1 AS `BidderId`,
 1 AS `Price`,
 1 AS `Quantity`,
 1 AS `ItemId`,
 1 AS `Description`,
 1 AS `DonatedBy`,
 1 AS `Value`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `viewauctionitemssheet`
--

/*!50001 DROP VIEW IF EXISTS `viewauctionitemssheet`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewauctionitemssheet` AS select `auctionitems`.`AuctionId` AS `auctionId`,sum(`auctionitems`.`Value`) AS `value`,group_concat(distinct `auctionitems`.`Description` separator ', ') AS `description`,group_concat(distinct `auctionitems`.`DonatedBy` separator ', ') AS `donatedBy` from `auctionitems` group by `auctionitems`.`AuctionId` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewdonators`
--

/*!50001 DROP VIEW IF EXISTS `viewdonators`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewdonators` AS select distinct `auctionitems`.`DonatedBy` AS `DonatedBy` from `auctionitems` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewreceipts`
--

/*!50001 DROP VIEW IF EXISTS `viewreceipts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewreceipts` AS select `p`.`AuctionId` AS `AuctionId`,`p`.`BidderId` AS `BidderId`,`p`.`Price` AS `Price`,`p`.`Quantity` AS `Quantity`,`a`.`ItemId` AS `ItemId`,`a`.`Description` AS `Description`,`a`.`DonatedBy` AS `DonatedBy`,`a`.`Value` AS `Value` from (`purchases` `p` join `auctionitems` `a`) where (`p`.`AuctionId` = `a`.`AuctionId`) */;
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

-- Dump completed on 2018-04-16 20:01:31
