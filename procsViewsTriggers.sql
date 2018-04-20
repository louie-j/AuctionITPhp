drop view if exists viewunmarked;
drop view if exists viewtwohundreds;
drop view if exists viewthreehundreds;
drop view if exists viewsixhundreds;
drop procedure if exists viewAuctionItemGroups;

/* View Donators */
drop view if exists viewDonators;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewdonators` AS
    SELECT DISTINCT
        `auctionitems`.`DonatedBy` AS `DonatedBy`
    FROM
        `auctionitems`;

/* view winning bids */
drop view if exists viewWinningBids;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewWinningBids` AS
    SELECT *
    FROM `bids`
    where winning = 1;


drop view if exists viewBidders;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewBidders` AS
    SELECT *
    FROM `bidders`;


/*View AuctionItemsSheet */
DROP VIEW IF EXISTS viewauctionitemssheet;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewauctionitemssheet` AS
    (SELECT 
        `auctionitems`.`AuctionId` AS `auctionId`,
        SUM(`auctionitems`.`Value`) AS `value`,
        GROUP_CONCAT(DISTINCT `auctionitems`.`Description`
            SEPARATOR ', ') AS `description`,
        GROUP_CONCAT(DISTINCT `auctionitems`.`Description2`
            SEPARATOR ', ') AS `description2`,
        GROUP_CONCAT(DISTINCT `auctionitems`.`DonatedBy`
            SEPARATOR ', ') AS `donatedBy`,
        `bidders`.`Name` AS `winningbidder`,
        `b`.`Amount` AS `winningbid`
    FROM
        ((`auctionitems`
        LEFT JOIN `viewwinningbids` `b` ON ((`b`.`AuctionId` = `auctionitems`.`AuctionId`)))
        LEFT JOIN `bidders` ON ((`bidders`.`BidderId` = `b`.`BidderId`)))
    WHERE
        (`auctionitems`.`AuctionId` IS NOT NULL)
    GROUP BY `auctionitems`.`AuctionId`) UNION (SELECT 
        `auctionitems`.`AuctionId` AS `auctionId`,
        `auctionitems`.`Value` AS `value`,
        `auctionitems`.`Description` AS `description`,
        `auctionitems`.`Description2` AS `description2`,
        `auctionitems`.`DonatedBy` AS `donatedBy`,
        `bidders`.`Name` AS `winningbidder`,
        `b`.`Amount` AS `winningbid`
    FROM
        ((`auctionitems`
        LEFT JOIN `viewwinningbids` `b` ON ((`b`.`AuctionId` = `auctionitems`.`AuctionId`)))
        LEFT JOIN `bidders` ON ((`bidders`.`BidderId` = `b`.`BidderId`)))
    WHERE
        ISNULL(`auctionitems`.`AuctionId`));	

/* viewReceipts */
Drop view if exists viewReceipts;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewreceipts` AS
    SELECT 
        `p`.`AuctionId` AS `AuctionId`,
        `p`.`BidderId` AS `BidderId`,
        `p`.`Price` AS `Price`,
        `p`.`Quantity` AS `Quantity`,
        `a`.`ItemId` AS `ItemId`,
        `a`.`Description` AS `Description`,
        `a`.`Description2` AS `Description2`,
        `a`.`DonatedBy` AS `DonatedBy`,
        `a`.`Value` AS `Value`,
        `b`.`Name` AS `Name`
    FROM
        (`purchases` `p`
        JOIN `auctionitems` `a`
        JOIN `bidders` `b`)
    WHERE
        (`p`.`AuctionId` = `a`.`AuctionId` AND `p`.`BidderId` = `b`.`BidderId`);

/*viewItems*/
CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewitems` AS
    (SELECT 
        (CASE
            WHEN (COUNT(0) > 1) THEN -(1)
            ELSE `ai`.`ItemId`
        END) AS `ItemId`,
        `ai`.`AuctionId` AS `AuctionId`,
        SUM(`ai`.`Value`) AS `Value`,
        GROUP_CONCAT(DISTINCT `ai`.`Description`
            SEPARATOR ', ') AS `Description`,
        GROUP_CONCAT(DISTINCT `ai`.`Description2`
            SEPARATOR ', ') AS `Description2`,
        GROUP_CONCAT(DISTINCT `ai`.`DonatedBy`
            SEPARATOR ', ') AS `DonatedBy`,
        MAX(`ai`.`AddedModifiedDate`) AS `LastModified`,
        GROUP_CONCAT(DISTINCT `a`.`Username`
            SEPARATOR ', ') AS `LastModifiedBy`
    FROM
        (`auctionitems` `ai`
        LEFT JOIN `accounts` `a` ON ((`a`.`AutoId` = `ai`.`AddedModifiedBy`)))
    WHERE
        (`ai`.`AuctionId` IS NOT NULL)
    GROUP BY `ai`.`AuctionId`) UNION 
    (SELECT 
        `ai`.`ItemId` AS `ItemId`,
        `ai`.`AuctionId` AS `auctionId`,
        `ai`.`Value` AS `Value`,
        `ai`.`Description` AS `Description`,
        `ai`.`Description2` AS `Description2`,
        `ai`.`DonatedBy` AS `DonatedBy`,
        `ai`.`AddedModifiedDate` AS `LastModified`,
        `a`.`Username` AS `LastModifiedBy`
    FROM
        (`auctionitems` `ai`
        LEFT JOIN `accounts` `a` ON ((`a`.`AutoId` = `ai`.`AddedModifiedBy`)))
    WHERE
        ISNULL(`ai`.`AuctionId`));
		


/*closeSilentAuction*/
drop procedure if exists closeSilentAuction;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `closeSilentAuction`(in selectAuction INT)
BEGIN
	INSERT INTO Purchases (AuctionId, bidderId, Price, Quantity)
    SELECT AuctionId, bidderId, Amount AS Price, 1 AS Quantity
    FROM bids
	WHERE Winning = true
    AND AuctionId BETWEEN (selectAuction+1) AND (selectAuction + 99);
END $$

/*updateAuctionItem*/
DELIMITER $$
DROP PROCEDURE IF EXISTS updateAuctionItem $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAuctionItem`(in id int(11), in AuctionId int(11), in Description varchar(500), in Description2 varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin
    UPDATE auctionitems
    SET    
           AuctionId = AuctionId,
           Description = Description,
           Description2 = Description2,
           DonatedBy = DonatedBy,
           `Value` = `Value`,
           AddedModifiedDate = NOW(),
           AddedModifiedBy = AddedModifiedBy
    WHERE  ItemId = id;
End$$
DELIMITER ;


/*deleteAuctionItem*/
DELIMITER $$
drop procedure if exists deleteAuctionItem $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAuctionItem`(in Id INT, in UserId INT, in isAuctionId BOOL)
BEGIN
IF (!isAuctionId) THEN
	DELETE FROM auctionItems
    WHERE itemId IN (Id);
ELSE 
	DELETE FROM auctionItems
    WHERE auctionId IN (Id);
END IF;	
END$$

/*unassignAuctionItems*/
DELIMITER $$
drop procedure if exists unassignAuctionItems $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `unassignAuctionItems`(in Id INT, in UserId INT)
BEGIN
	UPDATE AuctionItems
	SET AddedModifiedBy = UserId,
		AddedModifiedDate = NOW(),
        AuctionId = NULL
    WHERE AuctionId IN (Id);
END$$

/* createBid */
Delimiter $$
drop procedure if exists createBid $$
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
End $$


/* createBidder */
Delimiter $$
Drop procedure if exists createBidder $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createBidder`(in Phone varchar(10), in Address varchar(100), in Name varchar(45))
Begin 
	
	Insert INTO bidders(Phone, Address, `Name`) 
    Values (Phone, Address, `Name`);
End $$


/* createAuctionItem */
Delimiter $$
Drop procedure if exists createAuctionItem $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAuctionItem`(in AuctionId int(11), in Description varchar(500), in Description2 varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin 
	Insert INTO auctionitems(AuctionId, Description, Description2, DonatedBy, `Value`, AddedModifiedDate, AddedModifiedBy)
    Values (AuctionId, Description, Description2, DonatedBy, `Value`, NOW(), AddedModifiedBy);
End $$




/*checkPassword*/
delimiter $$
Drop procedure if exists checkPassword $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkPassword`(in user VARCHAR(100), in pass VARCHAR(100))
BEGIN

SELECT Username, Password_hashed, Type, AutoId
 FROM ACCOUNTS as A
	WHERE A.Username = user
    AND   A.Password_hashed = pass
    AND   A.Active = true;
END $$



#No one can bid same amount on same item
ALTER TABLE `bids` ADD UNIQUE `uniqueBidAmount`(AuctionId, Amount);


/* createAccount */
Delimiter $$
drop procedure if exists createAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAccount`(in Username varchar(100), in Password_hashed varchar(256), in `type` tinyint(4), in Active tinyint(4))
Begin 
	
	Insert INTO accounts(Username, Password_hashed, `type`, Active)
    Values (Username, Password_hashed, `type`, Active);
End $$


/*updateAccount*/
Delimiter $$
drop procedure if exists updateAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAccount`(in id INT(11), in pass VARCHAR(256), in type tinyint(4), in active tinyint(4))
BEGIN
	UPDATE ACCOUNTS as A
	SET A.Password_hashed = IFNULL(pass, A.Password_hashed),
		A.`Type`          = IFNULL(`type`, A.`Type`),
		A.active          = IFNULL(active, A.Active)
	WHERE A.AutoId = id;
END $$


/* deleteAccount */
Delimiter $$
Drop procedure if exists deleteAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAccount`(in `acountId` int(11))
Begin
	delete from Accounts
    where AutoId = `acountId`;
End $$


/* deleteBid */
Delimiter $$
Drop procedure if exists deleteBid $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBid`(in auctionid int(11), in bidderid int(11))
Begin
	delete from bids
    where AuctionId = auctionid and BidderId = bidderid;
End $$

/*deleteBidder*/
DELIMITER $$
DROP PROCEDURE IF EXISTS deleteBidder $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBidder`(in id INT)
BEGIN
	DELETE FROM bidders
    WHERE bidderId = id;
END$$
DELIMITER ;


/* viewSpecificItem */
Delimiter $$
Drop procedure if exists viewSpecificItem $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `viewSpecificItem`(in aID int(11))
Begin
	select *
    from auctionitems
    where AuctionId = aID;
End $$

/*buyDuck*/
Delimiter $$
drop procedure if exists buyDuck $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `buyDuck`(in bidder int(11), in amount int(2))
BEGIN
	INSERT into purchases (AuctionId, BidderId, Price, Quantity)
	VALUES(600, bidder, 10*amount, amount);
END $$

drop procedure if exists updateBidder $$

/*updateBidder*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBidder`(in id INT, `name` VARCHAR(100), in address VARCHAR(100), in phoneNumber VARCHAR(10))
BEGIN
	UPDATE BIDDERS as B
	SET B.`name`     = `name`,
		B.address    = address,
		B.Phone      = phoneNumber
	WHERE B.BidderId = id;
END$$
DELIMITER ;




/*viewAccounts*/
delimiter $$
drop procedure if exists viewAccounts $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `viewAccounts`()
 BEGIN
 	SELECT *
     FROM ACCOUNTS;
END $$

/*viewAccount*/
delimiter $$
drop procedure if exists viewAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `viewAccount`(in id INT)
 BEGIN
 	SELECT *
     FROM ACCOUNTS
     WHERE id = AutoId;
END $$

