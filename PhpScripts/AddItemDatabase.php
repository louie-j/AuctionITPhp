<?php
ob_start();
session_start();
header('Location: /AddItem.php');

require 'DatabaseConnection.php';
$itemNumber = $description = $donatedBy = $value = $year = "";

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);
$year = $conn->real_escape_string($_POST['year']);

$sql = "CALL insertAuctionItems(" . $itemNumber. ",'" . $description . "','" . $donatedBy . "'," . $value . "," . $year . ")";
$result = $conn->query($sql);


        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
 
        }
        echo "Item Added <br>";
        $_SESSION['databaseSuccess'] = 1;

 
$conn->close();
?>
