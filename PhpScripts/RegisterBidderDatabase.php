<?php
header('Location: ../RegisterBidder.php');

require 'DatabaseConnection.php';
$bidderID = $phone = $address = $year = $name = "";

$conn = Connect();
$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$phone = $conn->real_escape_string($_POST['phone']);
$year = $conn->real_escape_string($_POST['year']);
$address   = $conn->real_escape_string($_POST['address']);
$name = $conn->real_escape_string($_POST['name']);

$sql = "CALL createBidder('$phone','$address','$name')";
$result = $conn->query($sql);
session_start();
foreach($result as $row)
{
    if($row["Output"] == 1)
    {
        $_SESSION['databaseSuccess'] = 1;
    }   
    if($row["Output"] == 0)
    {
        $_SESSION['databaseSuccess'] = 3;
    }
}
$conn->close();

