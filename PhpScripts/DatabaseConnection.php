<?php


function Connect()
{
 $dbhost = "auctionit.fbcmtown.org";
 $dbuser = "fbcmtown_auction";
 $dbpass = "57xJyUkV5yk4c8wq77Fe";
 $dbname = "fbcmtown_auctionITdb";

 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

 return $conn;
}
 
