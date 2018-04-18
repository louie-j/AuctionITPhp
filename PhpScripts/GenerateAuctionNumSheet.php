<?php

require 'DatabaseConnection.php';
require 'FPDFWrapper.php';

$year				= date("Y");
$conn				= Connect();
$itemQuery	= "CALL viewAuctionItemsSheet(".$year.")";
$items		  = $conn->query($itemQuery);
echo json_encode($items);
//$items			= json_decode('[ { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy test and all of his friends, family, neighborhood, city, county, state, country, continent, planet, solar system and etc", "Value": 100 }, { "ItemId": 101, "Description": "Test", "DonatedBy": "Guy 1", "Value": 100 }, { "ItemId": 102, "Description": "Test", "DonatedBy": "Guy", "Value": 10 }, { "ItemId": 103, "Description": "Test test", "DonatedBy": "Guy guy", "Value": 1 }, { "ItemId": 100, "Description": "Test but really long this time just to see what happens", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 104, "Description": "Test omg way too long for nothing, just really trying the boundaries of this thing", "DonatedBy": "012345678910111213141516171819", "Value": "012345678910111213141516171819" }, { "ItemId": 200, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 300, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 301, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 } ]', true);
$pdf				= new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionNumSheet.txt', array( "items" => $items ));

$pdf->Output();

?>
