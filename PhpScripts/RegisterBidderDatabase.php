<?php
require 'DatabaseConnection.php';

$conn = Connect();
$phone = strip_tags($_POST['phone']) == null ? 'null' : "'" . strip_tags($_POST['phone']) . "'";
$address = strip_tags($_POST['address']) == null ? 'null' : "'" . strip_tags($_POST['address']) . "'";
$name = strip_tags($_POST['name']) == null ? 'null' : "'" . strip_tags($_POST['name']) . "'";


$sql = "CALL createBidder($phone,$address,$name)";
$result = $conn->query($sql);

   if (!$result) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    $_SESSION['databaseSuccess'] = 1;

   $conn->close();

