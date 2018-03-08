<?php
    session_start();
    session_unset();
    $_SESSION['accountType'] = "guest";    
    header('Location: ../index.php'); 
?>

