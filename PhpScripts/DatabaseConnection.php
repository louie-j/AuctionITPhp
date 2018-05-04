<?php


function Connect()
{
    /* Ellie 
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "fbcmtown_auctionITdb"; */

    /* Master */
    // $dbhost = "auctionit.fbcmtown.org";
    // $dbuser = "fbcmtown_auction";
    // $dbpass = "";
    // $dbname = "fbcmtown_auctionITdb"; 
    
    // Tyler
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "AuctionIT"; 

    /* Ewen 
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "testtest";
    $dbname = "fbcmtown_auctionITdb"; */

    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

    return $conn;
}





