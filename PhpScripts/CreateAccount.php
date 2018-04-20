<?php
    session_start();
    header('Location: ../AdminPage.php');
    
    require 'DatabaseConnection.php';
    $conn   = Connect();

    $username = $password_hashed = $type = $active = "";  

    $username   = $conn->real_escape_string($_POST['username']);
    $password   = $conn->real_escape_string($_POST['newPassword']);
    $password_hashed = md5($password);

    //Convert radio button booleans to 0's or 1's for Type and Active Status
    $type              = $conn->real_escape_string($_POST['typeAdmin']);
    if($type == true)
        $type = 1;
    else    
        $type = 0;
    $active            = $conn->real_escape_string($_POST['active']);
    if($active == true)
        $active = 1;
    else    
        $active = 0;

    $query   = "CALL createAccount(" . "'" . $username . "'" . "," . "'" . $password_hashed . "'" . "," .  $type  . ","  . $active  . ")";
    $success = $conn->query($query);
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    if (!$success) {
        $_SESSION['databaseSuccess'] = 2;
        die("Couldn't enter data: ".$conn->error);
    }
    echo "Account Created <br>";
    $_SESSION['databaseSuccess'] = 1;


?>
