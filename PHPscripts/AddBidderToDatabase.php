<?php   
session_start();

include 'databaseInit.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$phonenum   = mysqli_real_escape_string($conn, $_POST['phonenumber']);
$address   = mysqli_real_escape_string($conn, $_POST['address']);
$name  = mysqli_real_escape_string($conn, $_POST['name']);

$sql = "CALL createBidder('$phonenum','$address','$name')";
$result = mysqli_query($conn, $sql);
header("Location: ../home.php?addbidder=success");
exit();		

