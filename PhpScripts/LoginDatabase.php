<?php
require 'DatabaseConnection.php';    
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$conn = Connect();
$userName    = $conn->real_escape_string($_POST['userName']);
$password   = $conn->real_escape_string($_POST['password']);

$password = md5($password);


$sql = "CALL check_password('" . $userName . "','" . $password . "')";

$result = $conn->query($sql);
$_SESSION['loginSuccess'] = false;
foreach($result as $row)
{
    if($row["type"] == 1)
    {
        $_SESSION['accountType'] = "admin";
        header('Location: ../ViewAllItems.php');
        $_SESSION['loginSuccess'] = true;
    }   
    if($row["type"] == 0)
    {
        $_SESSION['accountType'] = "user";
        header('Location: ../ViewAllItems.php');
        $_SESSION['loginSuccess'] = true;
    }
    $_SESSION['autoID'] = $row["auto_id"];
    $_SESSION['username'] = $row["username"];
}

if (!$_SESSION['loginSuccess']) {
    header('Location: ../index.php');
}
