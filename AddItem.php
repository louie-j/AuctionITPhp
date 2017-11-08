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
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <script type="text/javascript">
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 1)
                {
                    alert("Item Added");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else if(<?php echo $_SESSION['databaseSuccess'] ?> === 2)
                {
                    alert("Error adding Item to Database");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else
                {
                }
            });
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
                var year = document.getElementById( "year" );
                if( year.value === "" )
                {
                    error = "You have to enter an year.";
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
            <form class="form-group" action="PhpScripts/AddItemDatabase.php" onsubmit="return validate();"  method="post">
                <div class="form-group">
                    <label for="itemNumber">Item Number</label>
                    <input type="text" class="form-control" name="itemNumber" id="itemNumber" placeholder="Item Number">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="Description">
                </div>
                <div class="form-group">
                    <label for="donatedBy">Donated By</label>
                    <input type="text" class="form-control" name="donatedBy" id="donatedBy" placeholder="Donated By">
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="text" class="form-control" name="value" id="value" placeholder="Value">
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value=<?php echo date("Y") ?>>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p id="error_para" ></p>
        </div>
    </body>
</html>
