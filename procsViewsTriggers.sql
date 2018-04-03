use auctionit;

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


/*View AuctionItemsSheet */
drop view if exists viewauctionitemssheet;
CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `viewauctionitemssheet` AS
    SELECT 
        `auctionitems`.`AuctionId` AS `auctionId`,
        SUM(`auctionitems`.`Value`) AS `value`,
        GROUP_CONCAT(DISTINCT `auctionitems`.`Description`
            SEPARATOR ', ') AS `description`,
        GROUP_CONCAT(DISTINCT `auctionitems`.`DonatedBy`
            SEPARATOR ', ') AS `donatedBy`,
		bidders.name as `winningbidder`,
        b.amount as `winningbid`
    FROM auctionitems
    left join viewWinningBids as b on b.auctionid = auctionitems.auctionid
    left join bidders on b.bidderid = bidders.bidderid
    GROUP BY `AuctionId`;
	

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
        `a`.`DonatedBy` AS `DonatedBy`,
        `a`.`Value` AS `Value`
    FROM
        (`purchases` `p`
        JOIN `auctionitems` `a`)
    WHERE
        (`p`.`AuctionId` = `a`.`AuctionId`);

		


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


/* createBid */
Delimiter $$
drop procedure if exists createBid $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createBid`(in auctionId int(11), in bidderId int(11), in bid decimal(10,2))
Begin 
	
	Insert INTO bids (AuctionID, BidderId, Amount, Winning) 
    Values (auctionID, bidderId, bid, false);
    
    SET @WinningAmount = (SELECT MAX(Amount) FROM bids WHERE bids.AuctionId = auctionId);
    
    UPDATE bids
    SET bids.Winning = false
    WHERE AuctionId = auctionID;
    
    UPDATE bids
    SET bids.Winning = true
    WHERE Amount = @WinningAmount;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAuctionItem`(in AuctionId int(11), in Description varchar(500), in DonatedBy varchar(500), in `Value` decimal(10,2), in AddedModifiedBy int(11))
Begin 
	Insert INTO auctionitems(AuctionId, Description, DonatedBy, `Value`, AddedModifiedDate, AddedModifiedBy)
    Values (AuctionId, Description, DonatedBy, `Value`, NOW(), AddedModifiedBy);
End $$




/*checkPassword*/
delimiter $$
Drop procedure if exists checkPassword $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkPassword`(in user VARCHAR(100), in pass VARCHAR(100))
BEGIN

SELECT Username, Password_hashed, Type
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `createAccount`(in Username varchar(100), in Password_hashed varchar(256), in `type` varchar(20), in Active tinyint(4))
Begin 
	
	Insert INTO accounts(Username, Password_hashed, `type`, Active)
    Values (Username, Password_hashed, `type`, Active);
End $$


/* updateAuctionItem */
Delimiter $$
Drop procedure if exists updateAuctionItem $$
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
End $$

/*updateAccount*/
Delimiter $$
drop procedure if exists updateAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAccount`(in id INT, in pass VARCHAR(100), in type VARCHAR(5), in active BOOL)
BEGIN
	UPDATE ACCOUNTS as A
	SET A.Password_hashed = IFNULL(pass, A.Password_hashed),
		A.`Type`          = IFNULL(`type`, A.`Type`),
		A.active          = IFNULL(active, A.Active)
	WHERE A.AutoId = id;
END $$


/* deleteBid */
Delimiter $$
Drop procedure if exists deleteBid $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBid`(in auctionid int(11), in bidderid int(11))
Begin
	delete from bids
    where AuctionId = auctionid and BidderId = bidderid;
End $$

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



/*updateBidder*/
delimiter $$
drop procedure if exists updateBidder $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBidder`(in id INT, `name` VARCHAR(100), in address VARCHAR(100), in phoneNumber INT(10))
BEGIN
	UPDATE BIDDERS as B
	SET B.`name`     = IFNULL(`name`, B.`Name`),
		B.address    = IFNULL(address, B.address),
		B.Phone      = IFNULL(phoneNumber, B.Phone)
	WHERE B.BidderId = id;
END $$