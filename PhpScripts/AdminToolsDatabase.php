<?php
header('Location: ../AdminPage.php');
require 'DatabaseConnection.php';
$user = $pass = "";
$conn = Connect();
$user   = $conn->real_escape_string($_POST['username']);
$pass = $conn->real_escape_string($_POST['password']);
$pass = md5($pass);
$sql = "CALL createPassword('" . $user . "','" . $pass . "')";
$result = $conn->query($sql);
session_start();
        if (!$result) {
            $_SESSION['databaseSuccess'] = 2;
            die("Couldn't enter data: ".$conn->error);
        }
        $_SESSION['databaseSuccess'] = 1;
 
$conn->close();
?>
