<?php
    session_start();
    header('Location: ../AdminPage.php');
    
    require 'DatabaseConnection.php';
    $username = $password_hashed = $type = $active = "";  

    $conn   = Connect();

    $autoId            = $conn->real_escape_string($_POST['autoId']);
   // $username          = $conn->real_escape_string($_POST['username']);
    $password   = $conn->real_escape_string($_POST['newPassword']);
    $password_hashed = md5($password);
    //proc deals with null by not changing value as opposed to changing to empty string
    if($password == "")
        $password_hashed = NULL;
        




    //Convert from bool to 0 or 1 to match database schema
    $type              = $conn->real_escape_string($_POST['typeAdmin']);
    if($type == true)
        $type = "Admin";
    else    
        $type = "User";
    $active            = $conn->real_escape_string($_POST['active']);
    //Convert from bool to 0 or 1 to match database schema
    if($active == true)
        $active = 1;
    else    
        $active = 0;

        echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";

    //If no updates made then do nothing
    if($autoId == $_SESSION["autoId"] && $username == $_SESSION["username"] && $password_hashed == $_SESSION["password_hashed"] && $type == $_SESSION["type"] && $active = $_SESSION["active"])
    {
        $_SESSION['databaseSuccess'] = 4;
    }
    //If account doesn't exist
    elseif($autoId == "Not Found")
    {
        $_SESSION['databaseSuccess'] = 3;
    }
    else
    {
    $query   = "CALL updateAccount(" . $autoId . "," . "'" . $password_hashed . "'" . "," . "'" . $type . "'" . ","  . $active  . ")";
    $success = $conn->query($query);
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if (!$success) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    echo "Account Updated <br>";
    $_SESSION['databaseSuccess'] = 1;
    }
?>
