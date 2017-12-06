<?php
header('Location: ../FindItem.php');
session_start();
require 'DatabaseConnection.php';
$itemNumber = $description = $donatedBy = $value = "";
$year = date("Y");

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$description   = $conn->real_escape_string($_POST['description']);
$donatedBy    = $conn->real_escape_string($_POST['donatedBy']);
$value = $conn->real_escape_string($_POST['value']);
$year = $conn->real_escape_string($_POST['year']);
if($itemNumber == $_SESSION["itemNumber"] && $description == $_SESSION["description"] && $donatedBy == $_SESSION["donatedBy"] && $_SESSION["value"] == $value && $year = $_SESSION["year"])
{
    $_SESSION['databaseSuccess'] = 4;
}
elseif($itemNumber == "Not Found")
{
    $_SESSION['databaseSuccess'] = 3;
}
else
{
    $query   = "CALL updateAuctionItem(" . $_SESSION["itemNumber"] . "," .  $itemNumber . "," . "'" . $description . "'" . "," . "'" . $donatedBy . "'"  . "," . $value . "," . $year . "," . $_SESSION["year"] . ")";
    $success = $conn->query($query);


    if (!$success) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    echo "Item Added <br>";
    $_SESSION['databaseSuccess'] = 1;
}
?>