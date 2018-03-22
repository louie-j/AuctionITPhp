<?php


function Connect()
{
 /*$dbhost = "auctionit.fbcmtown.org";
 $dbuser = "fbcmtown_auction";
 $dbpass = "";*/
 $dbname = "fbcmtown_auctionITdb";
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "testtest";

 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

 return $conn;
}
 
