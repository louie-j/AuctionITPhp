<?php
require 'DatabaseConnection.php';

$conn = Connect();
$select = $_POST['select'];

$sql = "CALL close_silent_auction(" . $select . ")";

$result = $conn->query($sql);

        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
 
        }
        echo "Auction Closed <br>";
        $_SESSION['databaseSuccess'] = 1;

 
$conn->close();

?>
