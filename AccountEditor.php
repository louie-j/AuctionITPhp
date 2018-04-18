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
       
        <script type="text/javascript">
            function validate()
                {
                    var error="";
                    var activeBtn     = document.getElementById( "statusARadioBtn" );
                    var inActiveBtn   = document.getElementById( "statusInARadioBtn" );
                    var adminBtn      = document.getElementById( "type1RadioBtn" );
                    var regUserBtn    = document.getElementById( "type2RadioBtn" );

                    if( activeBtn.value === false && inActiveBtn.value === false)
                    {
                        error = "You have not selected user activity.";
                        document.getElementById( "error_para" ).innerHTML = error;
                        return false;
                    }
                    var description = document.getElementById( "description" );
                    if( adminBtn.value === false && regUserBtn.value === false )
                    {
                        error = "You have not selected user type.";
                        document.getElementById( "error_para" ).innerHTML = error;
                        return false;
                    }

                    else
                    {
                        return true;
                    }
                }




            window.onload = function intialializeRadioBtns() 
            {
                var queryString = decodeURIComponent(window.location.search);
                queryString = queryString.substring(1);

                var queries = queryString.split("&");
                var autoId, accType, status;
                for (var i = 0; i < queries.length; i++)
                {
                    //There will be three cases
                    switch(i)
                    {
                        case 0:
                            autoId  = queries[i].substring(5);
                            break;
                        case 1:
                            accType = queries[i].substring(5);
                            break;
                        case 2:
                            status  = queries[i].substring(5);             
                            break;
                    }
                 }

                //Set account number 
                // document.getElementById("accountLabel").text = autoId;

                if (status == 1)
                    document.getElementById("statusARadioBtn").checked = true;
                else
                    document.getElementById("statusInARadioBtn").checked = true;
                if(accType == "Admin")
                    document.getElementById("typeAdminRadioBtn").checked = true;
                else   
                    document.getElementById("typeRegRadioBtn").checked = true;
            }

            //Radio button action buttons
            function clickActive() {document.getElementById("statusInARadioBtn").checked = false;}
            function clickInActive() {document.getElementById("statusARadioBtn").checked = false;}
            function clickAdmin(){document.getElementById("typeRegRadioBtn").checked = false;}
            function clickRegular(){document.getElementById("typeAdminRadioBtn").checked = false}

        </script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body  class="body-content" >
    <?php include "PhpScripts/Templates/Nav.php";?>
        <?php
            require 'PhpScripts/DatabaseConnection.php';
            $autoId = 4;
            $username = $password_hashed = $type = $active = "";  
            $conn = Connect();
            //$autoId = $conn->real_escape_string($_POST['autoId']);
            $query = "CALL viewAccount(". $autoId . ")";
            $result = $conn->query($query);
            if ($result->num_rows == 1) {
                while($row = mysqli_fetch_assoc($result)) {
                    $autoId             = $row["AutoId"];
                    
                    $username           = $row["Username"];
                    // echo $username;
                    $password_hashed    = $row["Password_hashed"];
                    //echo $password_hashed;
                    //$type               = $row["Type"];    
                    //echo $type;
                    //$active             = $row["Active"]; 
                    //echo $active; 
                } 
            }
            else 
            {
                $autoId = "Not Found";
                $username = "Not Found";
                $password_hashed = "Not Found";
                $type = "Not Found";
                $active = "Not Found";
            } 
            $_SESSION["autoId"] = $autoId;
            $_SESSION["username"] = $username;
            //$_SESSION["password_hashed"] = $password_hashed;
            //$_SESSION["type"] = $type;
            //$_SESSION["active"] = $active;


        ?>
        <div class="page">
                <form class="form-group" action="PhpScripts/EditUser.php" method="post">
                    <span class="name"><?php echo $username   ?></span>
                    <div id = "radioBtns" class="form-group">

                    <label for "accountLabel">Account Number</label>
                    <input type="text" class="form-control" name="autoId" id="accountLabel" value="<?php echo $autoId ?>" readonly>

                    <label>Status</label><br>
                        <input onclick="clickActive()"   id = "statusARadioBtn"      type="radio" name="active"> Active<br> 
                        <input onclick="clickInActive()" id = "statusInARadioBtn"    type="radio" name="inActive"> Inactive<br>
                    <label>Type of User</label><br>
                        <input onclick="clickAdmin()"    id = "typeAdminRadioBtn"    type="radio" name="typeAdmin"      value = false  > Admin <br>
                        <input onclick="clickRegular()"  id = "typeRegRadioBtn"      type="radio" name="typeRegular"> Regular <br>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label><br>
                        <input id="newPasswordText" class="form-control" type="text" name="newPassword">
                    </div>

                    <div class="form-group">
                            <button class="btn btn-primary" id = "updateButton" type="submit">Update</button>
                            <button onclick="location.href = 'AdminPage.php';" class="btn btn-primary" id = "cancelButton" type="button">Cancel</button>
                    </div>
                </form>
                <p id="error_para" ></p>
                
        </div>
    </body>
</html>