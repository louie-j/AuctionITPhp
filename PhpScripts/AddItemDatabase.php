<?php

require 'DatabaseConnection.php';
//$itemNumber = $description = $donatedBy = $value = $year = "";

$conn = Connect();
$auctionID    = $conn->real_escape_string($_POST['auctionid']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);
//$year = $conn->real_escape_string($_POST['year']);

session_start();
$modifiedby = $_SESSION['autoID'];
$sql = "CALL createAuctionItem('$auctionID','$description','$donatedBy','$value','$modifiedby')";
$result = $conn->query($sql);

        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
 
        }
        echo "Item Added <br>";
        $_SESSION['databaseSuccess'] = 1;
		header('Location: ../AddItem.php');

 
$conn->close();
