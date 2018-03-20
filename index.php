<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AuctionIt</title>
    <link rel="stylesheet" href="indexcss.css">
    <script src="script.js"></script>
  </head>
  <body>
  
	<ul class = "top">
		<div class = "headtitle"><li><img src="logo.png" alt="AuctionIt" ></li></div>
	</ul>
  
	<h1 class = "intro">Please Log In</h1>
	
	<form action="PHPscripts/LoginDatabase.php" method = "POST">
		Username:<br/>
		<input id = "username" type="text"  class = "up" name="username">
		<br/>
		Password: <br/>
		<input id = "password" type="password"  class = "up" name="password">
		<br/>
		<input type = "submit" value = "Enter">
  </body>
</html>