<?php
    ob_start();
session_start();
    $_SESSION['accountType'] = "guest";    
    header('Location: ../index.php'); 
?>

