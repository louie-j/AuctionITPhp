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
                switch(<?php echo $_SESSION['databaseSuccess'] ?>) {
                    case 1:
                        alert("Item Added to Database.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    case 2:
                        alert("Problem adding item to database.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    default:
                        break;
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
    <?php include "PhpScripts/Templates/Nav.php";?>

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
