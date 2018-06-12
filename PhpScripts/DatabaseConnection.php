<?php

function Connect()
{
    /* Master */
    // $dbhost = "auctionit.fbcmtown.org";
    // $dbuser = "fbcmtown_auction";
    // $dbpass = "";
    // $dbname = "fbcmtown_auctionITdb";

    /* Dev */
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "testtest";
    $dbname = "fbcmtown_auctionITdb";

    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

    return $conn;
}
?>
