<?php
   session_start();
   require 'DatabaseConnection.php';
   $itemId = strip_tags($_POST['itemId']);
   $auctionId = strip_tags($_POST['auctionId']) == null ? 'null' : strip_tags($_POST['auctionId']);
   $description = addslashes(strip_tags($_POST['description']));
   $description2 = strip_tags($_POST['description2']) == null ? 'null' : "'" . addslashes(strip_tags($_POST['description2'])) . "'";
   $donatedBy = strip_tags($_POST['donatedBy']) == null ? 'null' : "'" . addslashes(strip_tags($_POST['donatedBy'])) . "'";
   $value = strip_tags($_POST['value']) == null ? -1 : strip_tags($_POST['value']);
   $userId = $_SESSION['autoID'];

   $conn = Connect();
   $sql = "CALL update_auction_item ('" . $itemId . "'," . $auctionId . ",'" . $description . "'," . $description2 . "," . $donatedBy . "," . $value . ",'" . $userId . "')";
   
//    echo $sql;
   $result = $conn->query($sql);

   if (!$result) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    $_SESSION['databaseSuccess'] = 1;

   $conn->close();
?>

