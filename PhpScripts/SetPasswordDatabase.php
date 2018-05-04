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
$passwordhash = md5($password);
$userName    = $conn->real_escape_string($_SESSION['userName']);

$sql = "CALL create_password('" . $userName . "','" . $passwordhash . "')";
$result = $conn->query($sql);
$conn->close();

$conn2 = Connect();
$sql2 = "CALL check_password('" . $userName . "','" . $passwordhash . "')";
$result2 = $conn2->query($sql2);

foreach($result2 as $row)
{
    if($row["Type"] == 1)
    {
        $_SESSION['accountType'] = "admin";
        header('Location: ../index.php');    
    }   
    if($row["Type"] == 2)
    {
        $_SESSION['accountType'] = "user";
        header('Location: ../index.php'); 
    }
}    
$conn2->close();
?>
