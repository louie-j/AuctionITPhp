<?php
header('Location: AddItem.php');

require 'databaseConnection.php';
$itemNumber = $description = $donatedBy = $value = "";

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);
$query   = "INSERT into auctionitems (ItemId,Description,DonatedBy,Value) VALUES('" . $itemNumber . "','" . $description . "','" . $donatedBy . "','" . $value . "')";
$success = $conn->query($query);


if (!$success) {
    die("Couldn't enter data: ".$conn->error);
 
}
 
echo "Item Added <br>";
 
$conn->close();
?>
