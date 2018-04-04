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
        <?php
            require 'PhpScripts/DatabaseConnection.php';
            $year = date("Y");
            $itemNumber = $description = $donatedBy = $value = "";
            $conn = Connect();
            $itemNumber = $conn->real_escape_string($_POST['itemNumber']);
            $query = "CALL viewSpecficItem(". $year . "," . $itemNumber . ")";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $itemNumber = $row["ItemId"];
                    $description = $row["Description"];
                    $donatedBy = $row["DonatedBy"];
                    $value = $row["Value"];    
                    $year = $row["Year"];
                }
            }
            else 
            {
                $itemNumber = "Not Found";
                $description = "Not Found";
                $donatedBy = "Not Found";
                $value = "Not Found";     
                $year = "Not Found";
            } 
            $_SESSION["itemNumber"] = $itemNumber;
            $_SESSION["description"] = $description;
            $_SESSION["donatedBy"] = $donatedBy;
            $_SESSION["value"] = $value;
            $_SESSION["year"] = $year;
        ?>
            <form class="form-group" action="PhpScripts/EditItemDatabase.php" onsubmit="return validate();" method="post">
                <div class="form-group">
                    <label for="itemNumber">Item Number</label>
                    <input type="text" class="form-control" name="itemNumber" id="itemNumber" value="<?php echo "" . $itemNumber . "" ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description" value="<?php echo $description ?>">
                </div>
                <div class="form-group">
                    <label for="donatedBy">Donated By</label>
                    <input type="text" class="form-control" name="donatedBy" id="donatedBy" value="<?php echo $donatedBy ?>">
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="text" class="form-control" name="value" id="value" value="<?php echo $value ?>">
                </div>
                <div class="form-group">
                    <label for="value">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value="<?php echo $year ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p id="error_para" ></p>
        </div>
    </body>
</html>
