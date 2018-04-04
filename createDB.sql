CREATE DATABASE  IF NOT EXISTS `fbcmtown_auctionitdb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `fbcmtown_auctionitdb`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: fbcmtown_auctionitdb
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'admin','1a1dc91c907325c69271ddf0c944bc72','1',1),(2,'user','1a1dc91c907325c69271ddf0c944bc72','2',1),(3,'admin2','1a1dc91c907325c69271ddf0c944bc72','1',1);
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
/*!40000 ALTER TABLE `auctionitem_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auctionitems`
--

DROP TABLE IF EXISTS `auctionitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auctionitems` (
  `ItemId` int(11) NOT NULL AUTO_INCREMENT,
  `AuctionId` int(11) DEFAULT NULL,
  `Description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DonatedBy` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Value` decimal(10,2) DEFAULT NULL,
  `AddedModifiedDate` datetime NOT NULL,
  `AddedModifedBy` int(11) NOT NULL,
  PRIMARY KEY (`ItemId`)
) ENGINE=MyISAM AUTO_INCREMENT=206 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctionitems`
--

LOCK TABLES `auctionitems` WRITE;
/*!40000 ALTER TABLE `auctionitems` DISABLE KEYS */;
INSERT INTO `auctionitems` VALUES (151,150,'Htc 11','HTC',700.00,'0000-00-00 00:00:00',0),(150,150,'Iphone X','Apple',1000.00,'0000-00-00 00:00:00',0),(111,111,'Test Item','Betty and Ryan Wright',225.00,'0000-00-00 00:00:00',0),(201,201,'Dirt Bike','Sports Store',300.00,'0000-00-00 00:00:00',0),(109,109,'100 Macy\'s Girftcard','Melinda Bryant',100.00,'0000-00-00 00:00:00',0),(108,108,'iPhone X','Dr. and Mrs. Smith',850.00,'0000-00-00 00:00:00',0),(107,107,'60-inch Plasma TV','The Carter Foundation',1050.00,'0000-00-00 00:00:00',0),(106,106,'1 Week Cleaning Service','John and Linda Nelson',120.00,'0000-00-00 00:00:00',0),(105,105,'Deluxe Blender','Patrick Hernandez',50.00,'0000-00-00 00:00:00',0),(104,104,'Golf Trip','Palm Resort Golf Club',150.00,'0000-00-00 00:00:00',0),(103,103,'Bahamas Cruise','Betty and Ryan Wright',700.00,'0000-00-00 00:00:00',0),(102,102,'Video Game Console','Bryan Johnson',299.00,'0000-00-00 00:00:00',0),(101,101,'Motorized Dirtbike','Randy Holland',550.00,'0000-00-00 00:00:00',0),(100,100,'Spa Weekend','Sally Brown',298.00,'0000-00-00 00:00:00',0),(110,110,'Home Gym Equipment','Total Rip Fitness',225.00,'0000-00-00 00:00:00',0),(160,160,'Speakers','Logitech',150.00,'0000-00-00 00:00:00',0),(205,205,'Mini Fridge','Sears',700.00,'0000-00-00 00:00:00',0),(170,170,'Dryer','Sears',550.00,'0000-00-00 00:00:00',0),(180,180,'Test Item and Test Again','Test Donor and Someone Else',600.00,'0000-00-00 00:00:00',0);
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
) ENGINE=MyISAM AUTO_INCREMENT=168473259 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bidders`
--

LOCK TABLES `bidders` WRITE;
/*!40000 ALTER TABLE `bidders` DISABLE KEYS */;
INSERT INTO `bidders` VALUES (123,'5021345678','123 Test Street','Bill Smith'),(124,'5025551234','124 Test Street',NULL),(128,'5025551234','124 Test Street',NULL),(130,'5025551234','124 Test Street',NULL),(131,'5025551234','124 Test Street',NULL),(133,'1234567890','Test',NULL),(134,'1234567890','Test',NULL),(300,'1234567890','12 main st',NULL),(301,'2589631470','56 melwood ave',NULL),(1234,'','',NULL),(456,'8124568907','Test','John'),(1235,'Test','Test','Test'),(567,'Test','Test','Test'),(4862,'8125556789','123 Test St.','Bob Smith'),(2684,'123','123','John Doe'),(8526,'test','test','Test'),(15832,'test','test','test'),(1982,'test','test','test'),(1973,'test','test','test'),(1789,'test','test','test'),(1754,'test','test','test'),(1812,'test','test','test'),(1672,'te','te','te'),(1763,'t','t','t'),(1692,'t','t','t'),(15732,'t','t','t'),(1987456,'t','t','t'),(159357,'t','t','t'),(147852,'t','t','t'),(139746,'t','t','t'),(1478965,'t','t','t'),(123654,'t','t','t'),(168473258,'t','t','t'),(2121,'5025555555','7000 Sunny Lane','John'),(2129,'4035555555','6000 Sunny Lane','Chris'),(2929,'5005555555','600 Stary Lane','Bob Smith'),(4040,'','','Cody Becht');
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
  `Amount` decimal(10,2) DEFAULT NULL,
  `Winning` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`AuctionId`,`BidderId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bids`
--

LOCK TABLES `bids` WRITE;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` VALUES (100,133,750.00,1),(100,134,500.00,0),(110,123,1000.00,0),(110,133,1200.00,1),(110,134,600.00,0),(110,135,200.00,0);
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
 1 AS `donatedBy`,
 1 AS `winningbidder`,
 1 AS `winningbid`*/;
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
-- Temporary view structure for view `viewwinningbids`
--

DROP TABLE IF EXISTS `viewwinningbids`;
/*!50001 DROP VIEW IF EXISTS `viewwinningbids`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewwinningbids` AS SELECT 
 1 AS `AuctionId`,
 1 AS `BidderId`,
 1 AS `Amount`,
 1 AS `Winning`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'fbcmtown_auctionitdb'
--
/*!50003 DROP PROCEDURE IF EXISTS `buyDuck` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `buyDuck`(in bidder int(11), in amount int(2))
BEGIN
	INSERT into purchases (AuctionId, BidderId, Price, Quantity)
	VALUES(600, bidder, 10*amount, amount);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `checkPassword` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkPassword`(in user VARCHAR(100), in pass VARCHAR(100))
BEGIN

SELECT Username, Password_hashed, Type, AutoId
 FROM ACCOUNTS as A
	WHERE A.Username = user
    AND   A.Password_hashed = pass
    AND   A.Active = true;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `closeSilentAuction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `closeSilentAuction`(in selectAuction INT)
BEGIN
	INSERT INTO Purchases (AuctionId, bidderId, Price, Quantity)
    SELECT AuctionId, bidderId, Amount AS Price, 1 AS Quantity
    FROM bids
	WHERE Winning = true
    AND AuctionId BETWEEN (selectAuction+1) AND (selectAuction + 99);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `createAccount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAccount`(in Username varchar(100), in Password_hashed varchar(256), in `type` varchar(20), in Active tinyint(4))
Begin 
	
	Insert INTO accounts(Username, Password_hashed, `type`, Active)
    Values (Username, Password_hashed, `type`, Active);
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `createAuctionItem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAuctionItem`(in AuctionId int(11), in Description varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin 
	Insert INTO auctionitems(AuctionId, Description, DonatedBy, `Value`, AddedModifiedDate, AddedModifiedBy)
    Values (AuctionId, Description, DonatedBy, `Value`, NOW(), AddedModifiedBy);
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `createBid` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createBid`(in auctionId int(11), in bidderId int(11), in bid decimal(10,2))
Begin 
	
	IF EXISTS (SELECT * FROM bids AS B WHERE B.auctionId = auctionId AND B.bidderId = bidderId) THEN 
		UPDATE bids
        SET amount = bid
        WHERE bids.auctionId = auctionId
        AND bids.bidderId = bidderId;
    ELSE
		Insert INTO bids (AuctionID, BidderId, Amount, Winning) 
		Values (auctionID, bidderId, bid, false);
    END IF;
    SET @WinningAmount = (SELECT MAX(Amount) FROM bids WHERE bids.AuctionId = auctionId);
    
    UPDATE bids
    SET bids.Winning = false
    WHERE bids.Winning = true
    AND bids.auctionId = auctionId;
    
    UPDATE bids
    SET bids.Winning = true
    WHERE Amount = @WinningAmount
    AND bids.auctionId = auctionId;
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `createBidder` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createBidder`(in Phone varchar(10), in Address varchar(100), in Name varchar(45))
Begin 
	
	Insert INTO bidders(Phone, Address, `Name`) 
    Values (Phone, Address, `Name`);
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `createHistory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createHistory`()
BEGIN
	INSERT INTO auctionitem_history
    SELECT ItemId, AuctionId, Description, DonatedBy, `Value`, AddedModifiedDate, AddedModifiedBy, YEAR(CURDATE())
    FROM auctionitems;
    
    TRUNCATE auctionitems;
    
    INSERT INTO bidder_history
    SELECT Year(CURDATE()), bidderId, `Name`, Address, Phone
    FROM bidders;
    
    TRUNCATE bidders;
    
    INSERT INTO purchase_history
    SELECT AuctionId, BidderId, Price, Quantity, YEAR(CURDATE())
    FROM purchases;
    
    TRUNCATE purchases;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteBid` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBid`(in auctionid int(11), in bidderid int(11))
Begin
	delete from bids
    where AuctionId = auctionid and BidderId = bidderid;
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateAccount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAccount`(in id INT, in pass VARCHAR(100), in type VARCHAR(5), in active BOOL)
BEGIN
	UPDATE ACCOUNTS as A
	SET A.Password_hashed = IFNULL(pass, A.Password_hashed),
		A.`Type`          = IFNULL(`type`, A.`Type`),
		A.active          = IFNULL(active, A.Active)
	WHERE A.AutoId = id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateAuctionItem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAuctionItem`(in id int(11), in AuctionId int(11), in Description varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedDate datetime, in AddedModifiedBy int(11))
Begin
    UPDATE auctionitems
    SET    
           AuctionId = AuctionId,
           Description = Description,
           DonatedBy = DonatedBy,
           `Value` = `Value`,
           AddedModifiedDate = AddedModifiedDate,
           AddedModifiedBy = AddedModifiedBy
    WHERE  ItemId = id;
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateBidder` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBidder`(in id INT, `name` VARCHAR(100), in address VARCHAR(100), in phoneNumber INT(10))
BEGIN
	UPDATE BIDDERS as B
	SET B.`name`     = IFNULL(`name`, B.`Name`),
		B.address    = IFNULL(address, B.address),
		B.Phone      = IFNULL(phoneNumber, B.Phone)
	WHERE B.BidderId = id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `viewSpecificItem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `viewSpecificItem`(in aID int(11))
Begin
	select *
    from auctionitems
    where AuctionId = aID;
End ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
/*!50001 VIEW `viewauctionitemssheet` AS select `auctionitems`.`AuctionId` AS `auctionId`,sum(`auctionitems`.`Value`) AS `value`,group_concat(distinct `auctionitems`.`Description` separator ', ') AS `description`,group_concat(distinct `auctionitems`.`DonatedBy` separator ', ') AS `donatedBy`,`b`.`BidderId` AS `winningbidder`,`b`.`Amount` AS `winningbid` from (`auctionitems` left join `viewwinningbids` `b` on((`b`.`AuctionId` = `auctionitems`.`AuctionId`))) group by `auctionitems`.`AuctionId` */;
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

--
-- Final view structure for view `viewwinningbids`
--

/*!50001 DROP VIEW IF EXISTS `viewwinningbids`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewwinningbids` AS select `bids`.`AuctionId` AS `AuctionId`,`bids`.`BidderId` AS `BidderId`,`bids`.`Amount` AS `Amount`,`bids`.`Winning` AS `Winning` from `bids` where (`bids`.`Winning` = 1) */;
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

-- Dump completed on 2018-04-04 13:52:57
