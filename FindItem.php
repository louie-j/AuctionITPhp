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
            if($_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
                <script type="text/javascript">
                switch(<?php echo $_SESSION['databaseSuccess'] ?>) {
                    case 1:
                        alert("Item Updated.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    case 2:
                        alert("Item not in database.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    case 3:
                        alert("Item Number not valid")
                        <?php $_SESSION['databaseSuccess'] = 0; ?>;
                        break;
                    case 4:
                        alert("You didn't make any changes to the item.");
                        <?php $_SESSION['databaseSuccess'] = 0; ?>
                        break;
                    default:
                        break;
                    }
        </script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container body-content">
                        <form class="form-group" action="EditItem.php" method="post">
                <div class="form-group">
                    <label for="itemNumber">Item Number</label>
                    <input type="text" class="form-control" name="itemNumber" id="itemNumber" placeholder="Item Number">
                </div>
                <button type="submit" class="btn btn-primary">Find</button>
            </form>
        </div>
    </body>
</html>
