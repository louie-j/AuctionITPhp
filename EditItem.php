<?php
session_start();
if($_SESSION["accountType"] != admin)
{
    header('Location: index.php'); 
}
?>
<html>
    <head>

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
