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
            if($_SESSION["accountType"] != admin)
            {
                header('Location: index.php'); 
            }
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <script type="text/javascript">
            function validate()
                {
                    var error="";
                    var number = document.getElementById( "itemNumber" );
                    if( number.value === "" )
                    {
                        error = "You have to enter an Item Number.";
                        document.getElementById( "error_para" ).innerHTML = error;
                        return false;
                    }
                    var description = document.getElementById( "description" );
                    if( description.value === "" )
                    {
                        error = "You have to enter an item description.";
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
        <div class="navbar navbar-inverse bg-inverse">
            <div clas="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="Index.php">AuctionIT</a>
                </div>
                <?php if ($_SESSION["accountType"] != 'guest'): ?>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
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
        </div>
        <div class="container body-content">
        <?php
            require 'PhpScripts/DatabaseConnection.php';
            $year = date("Y");
            $itemNumber = $description = $donatedBy = $value = "";
            $conn = Connect();
            $itemNumber = $conn->real_escape_string($_POST['itemNumber']);
            $query = "CALL viewSpecficItem(". $year . "," . $itemNumber . ")";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $itemNumber = $row["ItemId"];
                    $description = $row["Description"];
                    $donatedBy = $row["DonatedBy"];
                    $value = $row["Value"];                    
                }
            }
            else 
            {
                    $itemNumber = "Not Found";
                    $description = "Not Found";
                    $donatedBy = "Not Found";
                    $value = "Not Found";      
            }
        ?>
            <form class="form-group" action="PhpScripts/EditItemDatabase.php" onsubmit="return validate();" method="post">
                <div class="form-group">
                    <label for="itemNumber">Item Number</label>
                    <input type="text" class="form-control" name="itemNumber" id="itemNumber" value="<?php echo "" . $itemNumber . "" ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description" value="<?php echo $description ?>">
                </div>
                <div class="form-group">
                    <label for="donatedBy">Donated By</label>
                    <input type="text" class="form-control" name="donatedBy" id="donatedBy" value="<?php echo $donatedBy ?>">
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="text" class="form-control" name="value" id="value" value="<?php echo $value ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p id="error_para" ></p>
        </div>
    </body>
</html>
