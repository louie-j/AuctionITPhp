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
                        alert("Bidder added.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    case 3:
                        alert("Bidder already in database.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    default:
                        break;
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
    <?php include "PhpScripts/Templates/Nav.php";?>
         <div class="container body-content">
            <form class="form-group" action="PhpScripts/RegisterBidderDatabase.php" method="post">                
                <div class="form-group">
                    <label for="bidderID">Bidder ID</label>
                    <input type="text" class="form-control" name="bidderID" id="bidderID" placeholder="Bidder ID">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
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

