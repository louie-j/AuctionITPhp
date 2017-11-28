<?php
header('Location: ../RegisterBidder.php');

require 'DatabaseConnection.php';
$bidderID = $phone = $address = $year = "";

$conn = Connect();
$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$phone = $conn->real_escape_string($_POST['phone']);
$year = $conn->real_escape_string($_POST['year']);
$address   = $conn->real_escape_string($_POST['address']);

$sql = "CALL insertBidder(" . $bidderID . ",'" . $phone . "','" . $address . "'," . $year . ")";
$result = $conn->query($sql);
session_start();

        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
        }
        echo "Bidder Added <br>";
        $_SESSION['databaseSuccess'] = 1;
 
$conn->close();
?>

