<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <?php
            session_start();
            if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <script type="text/javascript">
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 1)
                {
                    alert("Bidder Added");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else if(<?php echo $_SESSION['databaseSuccess'] ?> === 2)
                {
                    alert("Error registering bidder to Database");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else if(<?php echo $_SESSION['databaseSuccess'] ?> === 3)
                {
                    alert("This is a test");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else
                {
                }
            });
            function validate()
            {
                var error="";
                var number = document.getElementById( "bidderID" );
                if( number.value === "" )
                {
                    error = "You have to enter an Bidder Number.";
                    document.getElementById( "error_para" ).innerHTML = error;
                    return false;
                }
                var year = document.getElementById( "year" );
                if( year.value === "" )
                {
                    error = "You have to enter a Year.";
                    document.getElementById( "error_para" ).innerHTML = error;
                    return false;
                }
                else
                {
                    return true;
                }
            }

        </script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse bg-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button style="background-color: #292b2c;"type="button" class="navbar-inverse-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <a class="navbar-brand" href="Index.php">AuctionIT</a>
                    </button>
                    <?php if ($_SESSION["accountType"] != 'guest'): ?>
                        <form style="float: right;"action="PhpScripts/Logout.php">
                            <input type="submit" class="btn btn-primary" value="Logout" />
                        </form>
                    <?php endif;?>
                </div>
                <?php if ($_SESSION["accountType"] != 'guest'): ?>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="nav-link" href="index.php"><h4>Home</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="AddItem.php"><h4>Add an Item</h4></a>
                        </li>
                    <?php if ($_SESSION["accountType"] == 'admin'): ?>
                        <li>
                            <a class="nav-link" href="FindItem.php"><h4>Edit an Item</h4></a>
                        </li>
                    <?php endif; ?>
                        <li>
                            <a class="nav-link" href="ViewAllItems.php"><h4>View Items</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="Reports.php"><h4>Reports</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="AddBid.php"><h4>Add Bid</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="RegisterBidder.php"><h4>Bidder Registration</h4></a>
                        </li>
                    <?php if ($_SESSION["accountType"] == 'admin'): ?>
                        <li>
                            <a class="nav-link" href="AdminPage.php"><h4>Administrator Tools</h4></a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </nav>
         <div class="container body-content">
            <form class="form-group" action="PhpScripts/RegisterBidderDatabase.php" method="post">                
                <div class="form-group">
                    <label for="bidderID">Bidder ID</label>
                    <input type="text" class="form-control" name="bidderID" id="bidderID" placeholder="Bidder ID">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="address">
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value=<?php echo date("Y") ?>>
                </div>                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>

