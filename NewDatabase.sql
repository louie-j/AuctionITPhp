DROP DATABASE IF EXISTS `fbcmtown_auctionITdb`;
CREATE DATABASE `fbcmtown_auctionITdb`;
USE `fbcmtown_auctionITdb`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: auctionit.fbcmtown.org    Database: fbcmtown_auctionITdb
-- ------------------------------------------------------
-- Server version	5.5.51-38.2

-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hashed` varchar(256) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`auto_id`),
  UNIQUE KEY `Username_UNIQUE` (`username`)
);

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Alex','e10adc3949ba59abbe56e057f20f883e',0,1),(6,'admin','21232f297a57a5a743894a0e4a801fc3',1,1),(3,'Ellie','35ac2332b603b8f6c24ac293e1d057fd',1,1),(4,'Tyler','5de7bb3c232741f461f3ccd13c1ba7a0',1,1),(5,'Ewen','05a671c66aefea124cc08b76ea6d30bb',1,1);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auction_item_history`
--

DROP TABLE IF EXISTS `auction_item_history`;
CREATE TABLE `auction_item_history` (
  `item_id` int(11) NOT NULL,
  `auction_id` int(11) ,
  `description` varchar(500) ,
  `description2` varchar(500) ,
  `donated_by` varchar(500) ,
  `value` decimal(10,2) ,
  `added_modified_date` datetime ,
  `added_modified_by` int(11) ,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`item_id`,`year`)
);

--
-- Table structure for table `auction_items`
--

DROP TABLE IF EXISTS `auction_items`;
CREATE TABLE `auction_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) ,
  `description` varchar(500) ,
  `description2` varchar(500) ,
  `donated_by` varchar(500) ,
  `value` decimal(10,2) ,
  `added_modified_date` datetime NOT NULL,
  `added_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ;

--
-- Dumping data for table `auction_items`
--

LOCK TABLES `auction_items` WRITE;
/*!40000 ALTER TABLE `auction_items` DISABLE KEYS */;
INSERT INTO `auction_items` VALUES (1,101,'Rubiks Cube',NULL,'Alex',5.00,'2018-03-15 16:17:29',1),(2,102,'Ts GameCube Controller',NULL,'Daniel Karem',399.99,'2018-03-13 00:00:00',2),(3,103,'Freshman Tears','In a mason jar','Larry Tyler',11.99,'2018-04-25 11:58:35',1),(4,104,'Five Dollars',NULL,'Mr. Rogers',0.99,'2018-03-13 00:00:00',2),(6,106,'Raspberry Pi',NULL,'Adrian Lauf',24.99,'2018-03-13 00:00:00',1),(7,107,'CECS Degree',NULL,'Dr. Elmaghraby',40000.00,'2018-03-13 00:00:00',4),(8,108,'Presidential Pardon',NULL,'Donald Trump',19.99,'2018-03-13 00:00:00',2),(9,109,'FTL Drive',NULL,'NASA',99.99,'2018-03-13 00:00:00',4),(10,110,'Pack of Gum',NULL,'Anonymous',1.99,'2018-03-13 00:00:00',2),(219,322,'Ownership of Facebook',NULL,'Mark Zuckerberg',5.00,'2018-04-15 16:05:36',1),(220,223,'Test Item',NULL,'Me',-1.00,'2018-04-15 16:05:36',1);
/*!40000 ALTER TABLE `auction_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bidder_history`
--

DROP TABLE IF EXISTS `bidder_history`;
CREATE TABLE `bidder_history` (
  `year` year(4) NOT NULL,
  `bidder_id` int(11) NOT NULL,
  `name` varchar(45) ,
  `address` varchar(100) ,
  `phone` varchar(10),
  PRIMARY KEY (`year`,`bidder_id`)
) ;


--
-- Table structure for table `bidders`
--

DROP TABLE IF EXISTS `bidders`;
CREATE TABLE `bidders` (
  `bidder_id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(10) ,
  `address` varchar(100) ,
  `name` varchar(45) ,
  PRIMARY KEY (`bidder_id`)
) ;

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
CREATE TABLE `bids` (
  `auction_id` int(11) NOT NULL,
  `bidder_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `winning` tinyint(1),
  PRIMARY KEY (`auction_id`,`bidder_id`)
) ;

--
-- Dumping data for table `bids`
--

LOCK TABLES `bids` WRITE;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` VALUES (101,168473271,11.00,0),(101,168473272,10.00,0),(101,168473273,9.00,0),(101,168473275,12.00,0),(101,168473276,7.00,0),(102,168473273,450.00,1),(102,168473275,401.00,0),(103,168473279,40.00,1);
/*!40000 ALTER TABLE `bids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_history`
--

DROP TABLE IF EXISTS `purchase_history`;
CREATE TABLE `purchase_history` (
  `auction_id` int(11) NOT NULL,
  `bidder_id` int(11) ,
  `price` decimal(10,2) ,
  `quantity` int(11) ,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`auction_id`, `bidder_id`, `year`)
) ;


--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `auction_id` int(11) NOT NULL,
  `bidder_id` int(11) NOT NULL,
  `price` decimal(10,2) ,
  `quantity` int(11) ,
  PRIMARY KEY (`auction_id`,`bidder_id`)
) ;

--
-- Temporary view structure for view `view_winning_bids`
--

DROP TABLE IF EXISTS `view_winning_bids`;
/*!50001 DROP VIEW IF EXISTS `view_winning_bids`*/;
CREATE 
VIEW `view_winning_bids` AS
    SELECT 
        `bids`.`auction_id` AS `auction_id`,
        `bids`.`bidder_id` AS `bidder_id`,
        `bids`.`amount` AS `amount`,
        `bids`.`winning` AS `winning`
    FROM
        `bids`
    WHERE
        (`bids`.`winning` = 1);
--
-- Temporary view structure for view `view_auction_items_sheet`
--
DROP VIEW IF EXISTS view_auction_items_sheet;
CREATE 
VIEW `view_auction_items_sheet` AS
    (SELECT 
        `auction_items`.`auction_id` AS `auction_id`,
        SUM(`auction_items`.`value`) AS `value`,
        GROUP_CONCAT(DISTINCT `auction_items`.`description`
            SEPARATOR ', ') AS `description`,
        GROUP_CONCAT(DISTINCT `auction_items`.`description2`
            SEPARATOR ', ') AS `description2`,
        GROUP_CONCAT(DISTINCT `auction_items`.`donated_by`
            SEPARATOR ', ') AS `donated_by`,
        `b`.`bidder_id` AS `winning_bidder_id`,
        `bidders`.`name` AS `winning_bidder`,
        `b`.`amount` AS `winning_bid`,
        (CASE
            WHEN
                EXISTS( SELECT 
                        1
                    FROM
                        `purchases`
                    WHERE
                        (`purchases`.`auction_id` = `auction_items`.`auction_id`))
            THEN
                1
            ELSE 0
        END) AS `sold`
    FROM
        ((`auction_items`
        LEFT JOIN `view_winning_bids` `b` ON ((`b`.`auction_id` = `auction_items`.`auction_id`)))
        LEFT JOIN `bidders` ON ((`bidders`.`bidder_id` = `b`.`bidder_id`)))
    WHERE
        (`auction_items`.`auction_id` IS NOT NULL)
    GROUP BY `auction_items`.`auction_id`) UNION (SELECT 
        `auction_items`.`auction_id` AS `auction_id`,
        `auction_items`.`value` AS `value`,
        `auction_items`.`description` AS `description`,
        `auction_items`.`description2` AS `description2`,
        `auction_items`.`donated_by` AS `donated_by`,
        `b`.`bidder_id` AS `winning_bidder_id`,
        `bidders`.`name` AS `winning_bidder`,
        `b`.`amount` AS `winning_bid`,
        0 AS `sold`
    FROM
        ((`auction_items`
        LEFT JOIN `view_winning_bids` `b` ON ((`b`.`auction_id` = `auction_items`.`auction_id`)))
        LEFT JOIN `bidders` ON ((`bidders`.`bidder_id` = `b`.`bidder_id`)))
    WHERE
        ISNULL(`auction_items`.`auction_id`));
--
-- Temporary view structure for view `view_bidders`
--

DROP TABLE IF EXISTS `view_bidders`;
/*!50001 DROP VIEW IF EXISTS `view_bidders`*/;
CREATE 
VIEW `view_bidders` AS
    SELECT 
        `bidders`.`bidder_id` AS `bidder_id`,
        `bidders`.`phone` AS `phone`,
        `bidders`.`address` AS `address`,
        `bidders`.`name` AS `name`
    FROM
        `bidders`;

--
-- Temporary view structure for view `view_donators`
--

DROP TABLE IF EXISTS `view_donators`;
/*!50001 DROP VIEW IF EXISTS `view_donators`*/;
CREATE 
VIEW `view_donators` AS
    SELECT DISTINCT
        `auction_items`.`donated_by` AS `donated_by`
    FROM
        `auction_items`;

--
-- Temporary view structure for view `view_items`
--

DROP TABLE IF EXISTS `view_items`;
/*!50001 DROP VIEW IF EXISTS `view_items`*/;
CREATE 
VIEW `view_items` AS
    (SELECT 
        (CASE
            WHEN (COUNT(0) > 1) THEN -(1)
            ELSE `ai`.`item_id`
        END) AS `item_id`,
        `ai`.`auction_id` AS `auction_id`,
        SUM(`ai`.`value`) AS `value`,
        GROUP_CONCAT(DISTINCT `ai`.`description`
            SEPARATOR ', ') AS `description`,
        GROUP_CONCAT(DISTINCT `ai`.`description2`
            SEPARATOR ', ') AS `description2`,
        GROUP_CONCAT(DISTINCT `ai`.`donated_by`
            SEPARATOR ', ') AS `donated_by`,
        MAX(`ai`.`added_modified_date`) AS `last_modified`,
        GROUP_CONCAT(DISTINCT `a`.`username`
            SEPARATOR ', ') AS `last_modified_by`
    FROM
        (`auction_items` `ai`
        LEFT JOIN `accounts` `a` ON ((`a`.`auto_id` = `ai`.`added_modified_by`)))
    WHERE
        (`ai`.`auction_id` IS NOT NULL)
    GROUP BY `ai`.`auction_id`) UNION (SELECT 
        `ai`.`item_id` AS `item_id`,
        `ai`.`auction_id` AS `auction_id`,
        `ai`.`value` AS `value`,
        `ai`.`description` AS `description`,
        `ai`.`description2` AS `description2`,
        `ai`.`donated_by` AS `donated_by`,
        `ai`.`added_modified_date` AS `last_modified`,
        `a`.`username` AS `last_modified_by`
    FROM
        (`auction_items` `ai`
        LEFT JOIN `accounts` `a` ON ((`a`.`auto_id` = `ai`.`added_modified_by`)))
    WHERE
        ISNULL(`ai`.`auction_id`));

--
-- Temporary view structure for view `view_receipts`
--

DROP TABLE IF EXISTS `view_receipts`;
/*!50001 DROP VIEW IF EXISTS `view_receipts`*/;
CREATE 
VIEW `view_receipts` AS
    SELECT 
        `p`.`auction_id` AS `auction_id`,
        `p`.`bidder_id` AS `bidder_id`,
        `p`.`price` AS `price`,
        `p`.`quantity` AS `quantity`,
        `a`.`item_id` AS `item_id`,
        `a`.`description` AS `description`,
        `a`.`description2` AS `description2`,
        `a`.`donated_by` AS `donated_by`,
        `a`.`value` AS `value`,
        `b`.`name` AS `name`
    FROM
        ((`purchases` `p`
        JOIN `auction_items` `a`)
        JOIN `bidders` `b`)
    WHERE
        ((`p`.`auction_id` = `a`.`auction_id`)
            AND (`p`.`bidder_id` = `b`.`bidder_id`));


--
-- Dumping routines for database 'fbcmtown_auctionITdb'
--
/*!50003 DROP PROCEDURE IF EXISTS `check_password` */;
DELIMITER ;;
CREATE PROCEDURE `check_password`(in user VARCHAR(100), in pass VARCHAR(100))
BEGIN

SELECT username, password_hashed, `type`, auto_id
 FROM accounts as A
	WHERE A.username = user
    AND   A.password_hashed = pass
    AND   A.active = true;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `clear_data` */;
DELIMITER ;;
CREATE PROCEDURE `clear_data`(in `date` INT)
BEGIN
	INSERT INTO auction_item_history (item_id, auction_id, description, description2, donated_by, `value`, added_modified_date, added_modified_by, `year`)
    SELECT item_id, auction_id, description, description2, donated_by, `value`, added_modified_date, added_modified_by, `date` AS `year`
    FROM auction_items;
    
    INSERT INTO bidder_history (`year`, bidder_id, `name`, address, phone)
    SELECT `date` AS `year`, bidder_id, `name`, address, phone
    FROM bidders;
    
    INSERT INTO purchase_history (auction_id, bidder_id, price, quantity, `year`)
    SELECT auction_id, bidder_id, price, quantity, `date` AS `year`
    FROM purchases;
    
    TRUNCATE auction_items;
    TRUNCATE bidders;
    TRUNCATE purchases;
    TRUNCATE bids;
    
    
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `close_silent_auction` */;
DELIMITER ;;
CREATE PROCEDURE `close_silent_auction`(in selectAuction INT)
BEGIN
	DELETE FROM purchases
    WHERE auction_id BETWEEN (selectAuction) AND (selectAuction + 99);

	INSERT INTO purchases (auction_id, bidder_id, price, quantity)
    SELECT auction_id, bidder_id, amount AS price, 1 AS quantity
    FROM bids
	WHERE winning = true
    AND auction_id BETWEEN (selectAuction) AND (selectAuction + 99);
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `create_account` */;
DELIMITER ;;
CREATE PROCEDURE `create_account`(in username varchar(100), in password_hashed varchar(256), in `type` tinyint(4), in active tinyint(4))
Begin 
	
	Insert INTO accounts(username, password_hashed, `type`, active)
    Values (username, password_hashed, `type`, active);
End ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `create_auction_item` */;
DELIMITER ;;
CREATE PROCEDURE `create_auction_item`(in AuctionId int(11), in Description varchar(500), in Description2 varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin 
	Insert INTO auction_items(auction_id, description, description2, donated_by, `value`, added_modified_date, added_modified_by)
    Values (AuctionId, Description, Description2, DonatedBy, `Value`, NOW(), AddedModifiedBy);
End ;;
DELIMITER ;



/*!50003 DROP PROCEDURE IF EXISTS `create_bid` */;
DELIMITER ;;
CREATE PROCEDURE `create_bid`(in auctionId int(11), in bidderId int(11), in bid decimal(10,2))
Begin 
	
	IF EXISTS (SELECT * FROM bids AS B WHERE B.auction_id = auctionId AND B.bidder_id = bidderId) THEN 
		UPDATE bids
        SET amount = bid
        WHERE bids.auction_id = auctionId
        AND bids.bidder_id = bidderId;
    ELSE
		Insert INTO bids (auction_id, bidder_id, amount, winning) 
		Values (auctionID, bidderId, bid, false);
    END IF;
    
    CALL set_winning(auctionId);
End ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `create_bidder` */;
DELIMITER ;;
CREATE PROCEDURE `create_bidder`(in Phone varchar(10), in Address varchar(100), in `Name` varchar(45))
Begin 
	
	Insert INTO bidders(phone, address, `name`) 
    Values (Phone, Address, `Name`);
End ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `delete_account` */;
DELIMITER ;;
CREATE PROCEDURE `delete_account`(in `acountId` int(11))
Begin
	delete from accounts
    where auto_id = `acountId`;
End ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `delete_auction_item` */;
DELIMITER ;;
CREATE PROCEDURE `delete_auction_item`(in Id INT, in UserId INT, in isAuctionId BOOL)
BEGIN
IF (!isAuctionId) THEN
	DELETE FROM auction_items
    WHERE item_id IN (Id);
ELSE 
	DELETE FROM auction_items
    WHERE auction_id IN (Id);
END IF;	
END ;;
DELIMITER ;



/*!50003 DROP PROCEDURE IF EXISTS `delete_bid` */;
DELIMITER ;;
CREATE PROCEDURE `delete_bid`(in bidderId INT, in auctionId INT)
BEGIN
	DELETE FROM bids 
    WHERE bidder_id = bidderId AND auction_id = auctionId;
    
    CALL set_winning(auctionId);
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `delete_bidder` */;
DELIMITER ;;
CREATE PROCEDURE `delete_bidder`(in id INT)
BEGIN
	DELETE FROM bidders
    WHERE bidder_id = id;
END ;;
DELIMITER ;



/*!50003 DROP PROCEDURE IF EXISTS `set_winning` */;
DELIMITER ;;
CREATE PROCEDURE `set_winning`(in id INT)
BEGIN
	SET @WinningAmount = (SELECT MAX(Amount) FROM bids WHERE bids.auction_id = id);
    
    UPDATE bids
    SET bids.winning = false
    WHERE bids.winning = true
    AND bids.auction_id = id;
    
    UPDATE bids
    SET bids.winning = true
    WHERE amount = @WinningAmount
    AND bids.auction_id = id;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `unassign_auction_items` */;
DELIMITER ;;
CREATE PROCEDURE `unassign_auction_items`(in Id INT, in UserId INT)
BEGIN
	UPDATE auction_items
	SET added_modified_by = UserId,
		added_modified_date = NOW(),
        auction_id = NULL
    WHERE auction_id IN (Id);
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `update_account` */;
DELIMITER ;;
CREATE PROCEDURE `update_account`(in Id INT(11), in Pass VARCHAR(256), in `Type` tinyint(4), in Active tinyint(4))
BEGIN
	UPDATE accounts as A
	SET A.password_hashed = IFNULL(Pass, A.password_hashed),
		A.`type`          = IFNULL(`Type`, A.`type`),
		A.active          = IFNULL(Active, A.active)
	WHERE A.auto_id = Id;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `update_account_status` */;
DELIMITER ;;
CREATE PROCEDURE `update_account_status`(in Id INT(11), in `Type` tinyint(4), in Active tinyint(4))
BEGIN
	UPDATE accounts as A
	SET A.`type`          = IFNULL(`Type`, A.`type`),
		A.active          = IFNULL(Active, A.active)
	WHERE A.auto_id = Id;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `update_auction_item` */;
DELIMITER ;;
CREATE PROCEDURE `update_auction_item`(in Id int(11), in AuctionId int(11), in Description varchar(500), in Description2 varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin
    UPDATE auction_items
    SET    
           auction_id = AuctionId,
           description = Description,
           description2 = Description2,
           donated_by = DonatedBy,
           `value` = `Value`,
           added_modified_date = NOW(),
           added_modified_by = AddedModifiedBy
    WHERE  item_id = Id;
End ;;
DELIMITER ;
/*!50003 DROP PROCEDURE IF EXISTS `update_bidder` */;
DELIMITER ;;
CREATE PROCEDURE `update_bidder`(in Id INT, `Name` VARCHAR(100), in Address VARCHAR(100), in PhoneNumber VARCHAR(10))
BEGIN
	UPDATE bidders as B
	SET B.`name`     = `Name`,
		B.address    = Address,
		B.phone      = PhoneNumber
	WHERE B.bidder_id = Id;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `view_account` */;
DELIMITER ;;
CREATE PROCEDURE `view_account`(in Id INT)
BEGIN
 	SELECT *
     FROM accounts
     WHERE auto_id = Id;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `view_accounts` */;
DELIMITER ;;
CREATE PROCEDURE `view_accounts`()
BEGIN
 	SELECT *
     FROM accounts;
END ;;
DELIMITER ;


/*!50003 DROP PROCEDURE IF EXISTS `view_specific_item` */;
DELIMITER ;;
CREATE PROCEDURE `view_specific_item`(in aID int(11))
Begin
	select *
    from auction_items
    where auction_id = aID;
End ;;
DELIMITER ;



-- Dump completed on 2018-04-25 18:08:26
