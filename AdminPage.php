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
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 1)
                {
                    alert("User created");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else if(<?php echo $_SESSION['databaseSuccess'] ?> === 2)
                {
                    alert("Error occured when attempting to change password");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
                else
                {
                }
            });
        </script>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        
    <div class="row">
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
        <div class="column"></div>
    </div>
         <div class="container body-content" class = "column" >
            <form class="form-group" action="PhpScripts/AdminToolsDatabase.php" method="post">                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="radio" class="form-control" name="type" id="type" value="1">Admin
                    <input type="radio" class="form-control" name="type" id="type" value="2">Regular
                </div>                                 
                <button type="submit" class="btn btn-primary">Add user</button>
            </form>
        </div>
    </body>
</html>