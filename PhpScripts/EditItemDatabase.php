<?php
header('Location: FindItem.php');

require 'DatabaseConnection.php';
$itemNumber = $description = $donatedBy = $value = "";

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);
$query   = "UPDATE auctionitems SET ItemId = " . $itemNumber . ", Description = '" . $description . "', DonatedBy = '" . $donatedBy . "',Value = '" . $value . "' WHERE ItemId = '" . $itemNumber . "'";
$success = $conn->query($query);

    if (!$success) {
    die("Couldn't enter data: ".$conn->error);
    }
    echo "Item Added <br>";

?>