<?php
   session_start();
   require 'DatabaseConnection.php';

   $bidderId =$_POST['bidderId'];
  
   $conn = Connect();
   $sql = "CALL deleteBidder (" . $bidderId . ")";
   
  $result = $conn->query($sql);

   if (!$result) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    $_SESSION['databaseSuccess'] = 1;

   $conn->close();
?>

