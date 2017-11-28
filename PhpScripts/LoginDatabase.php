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
$sql = "CALL checkPassword('" . $userName . "','" . $password . "')";
$result = $conn->query($sql);
foreach($result as $row)
{
    if($row["Type"] == 1)
    {
        $_SESSION['accountType'] = "admin";
        echo($_SESSION['accountType']);
        header('Location: ../index.php');    
    }   
    if($row["Type"] == 2)
    {
        $_SESSION['accountType'] = "user";
        header('Location: ../index.php'); 
    }
    if($row["Type"] == -1)
    {
       //header('Location: ../Login.php'); 
    }
    if($row["Type"] == 0)
    {
        //header('Location: ../Login.php'); 
    }
}