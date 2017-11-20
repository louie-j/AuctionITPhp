<?php
header('Location: ../AddBid.php');

require 'DatabaseConnection.php';
$itemNumber = $bidderID = $value = "";

$conn = Connect();
$itemNumber    = $conn->real_escape_string($_POST['itemNumber']);
$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$value = $conn->real_escape_string($_POST['value']);

$sql = "CALL insertBid(" . $itemNumber. ",'" . $bidderID . "','" . $value . "," . ")";
$result = $conn->query($sql);
session_start();

        echo "Trying bid <br>";
        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
 
        }
        elseif ($result == 0) {
            echo "Bid was not high enough <br>";
            $_SESSION['databaseSuccess'] = 1;
        }
        else {
            echo "Bid Added <br>";
            $_SESSION['databaseSuccess'] = 1;
        }

 
$conn->close();
?>
