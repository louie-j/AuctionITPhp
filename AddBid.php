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
	<form action="PHPscripts/AddBidToDatabase.php" method = "POST">
		Auction Item ID:<br/>
		<input id = "auctionid" type="text"  class = "up" name="auctionid">
		<br/>
		Bidder ID: <br/>
		<input id = "bidderid" type="text"  class = "up" name="bidderid">
		<br/>
		Bid: <br/>
		<input id = "bid" type="text"  class = "up" name="bid">
		<br/>
		<input type = "submit" value = "Enter">
  </body>
</html>