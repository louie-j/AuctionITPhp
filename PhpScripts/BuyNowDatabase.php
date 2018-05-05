<?php
header('Location: ../BuyNow.php');

require 'DatabaseConnection.php';
$auctionID = $bidderID = $amount = "";

$conn = Connect();
$auctionID    = $conn->real_escape_string($_POST['auctionID']);
$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$amount = $conn->real_escape_string($_POST['amount']);

$sql = "CALL buy_now(" . $auctionID. "," . $bidderID . "," . $amount .")";
$result = $conn->query($sql);
session_start();

/*
if (!$result) {
    $_SESSION['bidSuccess'] = 2;
    die("Couldn't enter data: ".$conn->error);
}
else {
$_SESSION['bidSuccess'] = 1;
$_SESSION["result"] = $result;

} */

 
$conn->close();
?>
