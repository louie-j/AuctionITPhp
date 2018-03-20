<?php   
session_start();

include 'databaseInit.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$itemname   = mysqli_real_escape_string($conn, $_POST['itemname']);
$donatedby   = mysqli_real_escape_string($conn, $_POST['donatedby']);
$value   = mysqli_real_escape_string($conn, $_POST['value']);

$sql = "CALL createAuctionItem(207,'$itemname','$donatedby','$value', 1)";
$result = mysqli_query($conn, $sql);
header("Location: ../home.php?additem=success");
exit();		

