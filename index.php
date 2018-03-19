<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
?>
<html>
    <head>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript">
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 2)
                {
                    alert("Invalid Username or Password");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
            });
        </script>
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