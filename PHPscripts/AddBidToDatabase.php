<?php   
session_start();

include 'databaseInit.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$auctionid   = mysqli_real_escape_string($conn, $_POST['auctionid']);
$bidderid   = mysqli_real_escape_string($conn, $_POST['bidderid']);
$bid  = mysqli_real_escape_string($conn, $_POST['bid']);

$sql = "CALL createBid('$auctionid','$bidderid','$bid')";
$result = mysqli_query($conn, $sql);
header("Location: ../home.php?addbid=success");
exit();		

