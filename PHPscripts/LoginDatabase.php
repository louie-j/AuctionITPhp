<?php   
session_start();

include 'databaseInit.php'; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$username   = mysqli_real_escape_string($conn, $_POST['username']);
$password   = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "CALL checkPassword('$username','$password')";
$passwordresult = mysqli_query($conn, $sql);
$passwordresultCheck = mysqli_num_rows($passwordresult);
if($passwordresultCheck == 1)
{
	//log in here
	$_SESSION['u_id'] = $row['username'];
	header("Location: ../home.php?login=success");
	exit();		
}
else
{
	header("Location: ../index.php?login=failed");
	exit();	
}
