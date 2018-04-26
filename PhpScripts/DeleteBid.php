<?php
   session_start();
   require 'DatabaseConnection.php';

   $bidderId =$_POST['bidderId'];
   $auctionId = $_POST['auctionId'];
  
   $conn = Connect();
   $sql = "CALL delete_bid (" . $bidderId . "," . $auctionId . ")";

  $result = $conn->query($sql);

   if (!$result) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    $_SESSION['databaseSuccess'] = 1;

   $conn->close();
?>

