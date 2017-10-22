<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
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
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="nav-link" href="AddItem.php"><h4>Add an Item</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="FindItem.php"><h4>Edit an Item</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="ViewAllItems.php"><h4>View Items</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="Reports.php"><h4>Reports</h4></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container body-content">
        <?php
            require 'DatabaseConnection.php';
            $itemNumber = $description = $donatedBy = $value = "";
            $conn = Connect();
            $itemNumber = $conn->real_escape_string($_POST['itemNumber']);
            $query = "SELECT ItemId, Description, Value, DonatedBy FROM auctionitems WHERE ItemId = " . $itemNumber;
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
            <form class="form-group" action="PhpScripts/EditItemDatabase.php" method="post">
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
        </div>
    </body>
</html>
