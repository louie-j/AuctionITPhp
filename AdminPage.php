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
		
		
    <!--        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <script type="text/javascript">
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 1)
                {
                    alert("Password Changed");
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
			
			
        </script>  -->
		
		
		
		
		
		
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        


		<div class="container body-content">
            <input id="clickMe" type="button" class="btn-info" value="Start/Stop Rotating Through Pages" onclick="changePagesAutomatically();" />
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td>Username</td>
                        <td>State</td>
                        <td>User Type</td>
                        <td>Edit</td>
                    </tr>
                </thead>
            </table>
        </div>
		
		
        
    </body>
</html>


   <!--          <div class="container body-content" >
            <form class="form-group" action="PhpScripts/AdminToolsDatabase.php" method="post">                
                <div class="form-group">

                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                </div>                                
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>                   -->
