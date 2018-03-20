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
	<a href="home.php">Home</a>
	<br/>
	<a href="AddItem.php">Add An Item</a>
	<br/>
	<a href="EditItem.php">Edit An Item</a>
	<br/>
	<a href="ViewItem.php">View Items</a>
	<br/>
	<a href="Report.php">Report</a>
	<br/>
	<a href="AddBid.php">Add Bid</a>
	<br/>
	<a href="AddBidder.php">Add Bidder</a>
	<br/>
	<a href="UserManagement.php">User Management</a>
	<br/>
	<form action="PHPscripts/AddItemToDatabase.php" method = "POST">
		Item Name:<br/>
		<input id = "itemname" type="text"  class = "up" name="itemname">
		<br/>
		Donated By: <br/>
		<input id = "donatedby" type="text"  class = "up" name="donatedby">
		<br/>
		Value: <br/>
		<input id = "value" type="text"  class = "up" name="value">
		<br/>
		<input type = "submit" value = "Enter">
  </body>
</html>