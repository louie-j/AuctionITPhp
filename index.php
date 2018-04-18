<?php
    session_start();
?>
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
        <?php
            $_SESSION['databaseSuccess'] = 0;
            if(isset($_SESSION['accountType']) == FALSE)
            {
                $_SESSION['accountType'] = "guest";
            }?>    
        <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container body-content">
        <?php if (isset($_SESSION['loginSuccess']) &&  !$_SESSION['loginSuccess']): ?>
                    <p class="text-center text-white bg-danger lead">Invalid Login Information</p>
                <?php endif;
                    unset($_SESSION['loginSuccess'])
                ?>  
            <form class="form-group" action="PhpScripts/LoginDatabase.php" method="post">
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input type="text" class="form-control" name="userName" id="userName">
                </div>
                <div class="form-group">
                    <label for="description">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div> 
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>