<?php

require 'DatabaseConnection.php';
//$itemNumber = $description = $donatedBy = $value = $year = "";

$conn = Connect();
$auctionId = strip_tags($_POST['auctionId']) == null ? 'null' : strip_tags($_POST['auctionId']);
$description = addslashes(strip_tags($_POST['description']));
$donatedBy = strip_tags($_POST['donatedBy']) == null ? 'null' : "'" . addslashes(strip_tags($_POST['donatedBy'])) . "'";
$value = strip_tags($_POST['value']) == null ? -1 : strip_tags($_POST['value']);

session_start();
$modifiedby = $_SESSION['autoID'];
$sql = "CALL createAuctionItem(" . $auctionId .",'" . $description . "'," . $donatedBy . "," . $value . ",'" . $modifiedby . "')";

// echo $sql;
$result = $conn->query($sql);

        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
 
        }
        echo "Item Added <br>";
        $_SESSION['databaseSuccess'] = 1;
		header('Location: ../AddItem.php');

 
$conn->close();
