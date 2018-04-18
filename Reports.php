<?php
    session_start();
    if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
    {
        header('Location: index.php'); 
    }
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
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

    <?php include "PhpScripts/Templates/Nav.php";?>

        <div class="container body-content">
            <form class="form-group" action="PhpScripts/GenerateAuctionProgram.php" method="post">
                <input class="btn btn-primary" type="submit" value="Auction Program">
            </form> 
            <form class="form-group" action="PhpScripts/GenerateAuctionNumSheet.php" method="post">
                <input class="btn btn-primary" type="submit" value="Auction Numbering Sheet">
            </form>
            <div class="separator"></div>
            <form class="form-group" action="PhpScripts/GenerateSpecificReceipt.php" method="post">
                <div class="form-group">
                    <label for="bidderID" style="margin-left: 12px;">Bidder ID</label>
                    <input type="text" class="form-control" name="bidderID" id="bidderID" placeholder="Bidder ID">
                </div>
                <input class="btn btn-primary" type="submit" value="Get Specific Receipt">
            </form>
            <form class="form-group" action="PhpScripts/GenerateReceipt.php" method="post">
                <input class="btn btn-primary" type="submit" value="All Receipts">
            </form>
            <div class="separator"></div>
            <form class="form-group" action="PhpScripts/GenerateThankYouNotes.php" method="post">
                <input class="btn btn-primary" type="submit" value="Thank You Notes">
            </form>
        </div>
    </body>
</html>
