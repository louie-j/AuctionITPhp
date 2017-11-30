<?php

require 'DatabaseConnection.php';    
session_start();
$conn = Connect();
$password    = $conn->real_escape_string($_POST['password']);
$confirmPassword   = $conn->real_escape_string($_POST['confirmPassword']);

if($password != $confirmPassword)
{
    $_SESSION['databaseSuccess'] = 2;
    header('Location: ../SetPassword.php');
}
?>
