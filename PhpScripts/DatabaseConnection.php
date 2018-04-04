<?php


function Connect()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "auctionit";

    /* Ellie
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "fbcmtown_auctionITdb"; */

    /* Master
    $dbhost = "auctionit.fbcmtown.org";
    $dbuser = "fbcmtown_auction";
    $dbpass = "";
    $dbname = "fbcmtown_auctionITdb"; */
    
    /* Tyler */
    //$dbhost = "localhost";
    //$dbuser = "root";
    //$dbpass = "";
    //$dbname = "AuctionIT";

    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

    return $conn;
}





