#use auctionit;

/* View Donators */
drop view if exists viewDonators;
CREATE VIEW `viewDonators` AS
Select distinct `DonatedBy`
From auctionitems;


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
            SEPARATOR ', ') AS `donatedBy`
    FROM auctionitems
    GROUP BY `AuctionId`;


/* viewReceipts */
Drop view if exists viewReceipts;
create view `viewReceipts` as
select P.AuctionId, BidderId, Price, Quantity, ItemId, Description, DonatedBy, `Value`
from purchases as P, auctionitems as A
Where P.AuctionId = A.AuctionId;		


/*closeSilentAuction*/
drop procedure if exists closeSilentAuction;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `closeSilentAuction`(selectAuction INT)
BEGIN
	INSERT INTO Purchases (AuctionId, bidderId, Price, Quantity)
    SELECT AuctionId, bidderId, Amount AS Price, 1 AS Quantity
    FROM bids
	WHERE Winning = true
    AND AuctionId BETWEEN selectAuction AND (selectAuction + 99);
END $$


/* createBid */
Delimiter $$
drop procedure if exists createBid $$
create Procedure createBid (in AuctionId int(11), in BidderId int(11), in Amount decimal(10,2))

Begin 
	
	Insert INTO bids (AuctionID, BidderId, Amount, Winning) 
    Values (AuctionID, BidderId, Amount, false);
End $$


/* createBidder */
Delimiter $$
Drop procedure if exists createBidder $$
create Procedure createBidder (in Phone varchar(10), in Address varchar(100), in Name varchar(45))

Begin 
	
	Insert INTO bidders(Phone, Address, `Name`) 
    Values (Phone, Address, `Name`);
End $$


/*Bid after update trigger*/
DELIMITER #

DROP TRIGGER IF EXISTS after_bid_update#

CREATE TRIGGER after_bid_update
 AFTER UPDATE ON bids
 FOR EACH ROW
 BEGIN
	UPDATE bids
    SET Winning = false
    WHERE auctionId = NEW.auctionId
    AND Winning = true;
    
    UPDATE bids
    SET Winning = true
    WHERE auctionId = NEW.auctionId
    AND amount = (SELECT MAX(Amount) FROM bids);
 END#

/*Bid after insert trigger*/
DELIMITER #

DROP TRIGGER IF EXISTS after_bid_insert #

CREATE TRIGGER after_bid_insert
 AFTER INSERT ON bids
 FOR EACH ROW
 BEGIN
	UPDATE bids
    SET Winning = false
    WHERE auctionId = NEW.auctionId
    AND Winning = true;
    
    UPDATE bids
    SET Winning = true
    WHERE auctionId = NEW.auctionId
    AND amount = (SELECT MAX(Amount) FROM bids);
 END#


/* createAuctionItem */
Delimiter $$
Drop procedure if exists createAuctionItem $$
create Procedure createAuctionItem (in AuctionId int(11), Description varchar(500), DonatedBy varchar(500), `Value` decimal(10,2), AddedModifiedBy int(11))

Begin 
	
	Insert INTO auctionitems(AuctionId, Description, DonatedBy, `Value`, AddedModifiedDate, AddedModifiedBy)
    Values (AuctionId, Description, DonatedBy, `Value`, NOW(), AddedModifiedBy);
End $$




/*checkPassword*/
delimiter $$
Drop procedure if exists checkPassword $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkPassword`(user VARCHAR(100), pass VARCHAR(100))
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
create Procedure createAccount (in Username varchar(100), Password_hashed varchar(256), `type` varchar(20), Active tinyint(4))

Begin 
	
	Insert INTO accounts(Username, Password_hashed, `type`, Active)
    Values (Username, Password_hashed, `type`, Active);
End $$


/* updateAuctionItem */
Delimiter $$
Drop procedure if exists updateAuctionItem $$
create Procedure updateAuctionItem (in id int(11), AuctionId int(11), Description varchar(500), DonatedBy varchar(500), `Value` decimal(10,2), AddedModifiedDate datetime, AddedModifiedBy int(11))

Begin 
    UPDATE auctionitems
    SET    
           AuctionId = AuctionId,
           Description = Description,
           DonatedBy = DonatedBy,
           `Value` = `Value`,
           AddedModifiedDate = AddedModifiedDate,
           AddedModifiedBy = AddedModifiedBy
    WHERE  ItemId = id ;
End $$

/*updateAccount*/
Delimiter $$
Drop procedure if exists updateAccount $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAccount`(id INT, pass VARCHAR(100), type VARCHAR(5), active BOOL)
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
create Procedure deleteBid (in a int(11), b int(11))

Begin
	delete from bids
    where AuctionId = a and BidderId = b;
End $$

/* viewSpecificItem */
Delimiter $$
Drop procedure if exists viewSpecificItem $$
create Procedure viewSpecificItem(in aID int(11))

Begin
	select *
    from auctionitems
    where AuctionId = aID;
End $$

/*buyDuck*/
Delimiter $$
Drop procedure if exists buyDuck $$
CREATE PROCEDURE `buyDuck` (in bidder int(11))
BEGIN
	INSERT into purchases (AuctionId, BidderId, Price, Quantity)
	VALUES(600, bidder, 10, 1);
END $$



/*updateBidder*/
delimiter $$
drop procedure if exists updateBidder $$
CREATE PROCEDURE `updateBidder` (id INT, `name` VARCHAR(100), address VARCHAR(100), phoneNumber INT(10))
BEGIN
	UPDATE BIDDERS as B
	SET B.`name`     = IFNULL(`name`, A.`Name`),
		B.address    = IFNULL(address, A.address),
		B.Phone      = IFNULL(phoneNumber, A.Phone)
	WHERE B.BidderId = id;
END $$

