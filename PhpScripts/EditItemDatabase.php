<?php
   session_start();
   require 'DatabaseConnection.php';
   $itemId = strip_tags($_POST['itemId']);
   $auctionId = strip_tags($_POST['auctionId']) == null ? 'null' : strip_tags($_POST['auctionId']);
   $description = strip_tags($_POST['description']) == null ? 'null' : strip_tags($_POST['description']);
   $donatedBy = strip_tags($_POST['donatedBy']) == null ? 'null' : strip_tags($_POST['donatedBy']);
   $value = strip_tags($_POST['value']) == null ? 'null' : strip_tags($_POST['value']);
   $userId = $_SESSION['autoID'];

   $conn = Connect();
   $sql = "CALL updateAuctionItem ('" . $itemId . "'," . $auctionId . ",'" . $description . "','" . $donatedBy . "','" . $value . "','" . $userId . "')";
   
   //echo $auctionId;
   $result = $conn->query($sql);

   if (!$result) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    $_SESSION['databaseSuccess'] = 1;

   $conn->close();
?>

