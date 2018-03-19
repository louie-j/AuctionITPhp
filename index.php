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
        session_start();
        $_SESSION['databaseSuccess'] = 0;
        if(isset($_SESSION['accountType']) == FALSE)
        {
            $_SESSION['accountType'] = "guest";
        }?>
        <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container body-content">
            <br>
            <br>
        <?php if ($_SESSION["accountType"] == 'guest'): ?>
            <form action="Login.php">
                <input type="submit" class="btn btn-primary" value="Login" />
            </form>
        <?php endif;?>
        </div>
    </body>
</html>
