<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

ob_end_clean();
ob_start(); 

$year       = date("Y");
$conn       = Connect();
$itemQuery  = "SELECT * FROM viewauctionitemssheet";//"CALL viewAuctionItemsSheet(".$year.")";
$donorQuery = "CALL viewDonators(". $year . ")";
//$items      = $conn->query($itemQuery);
//$donors     = $conn->query($donorQuery);
$items      = json_decode('[ { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy test ", "Value": 100, "OtherDescription": "Italicized other description of the item, which may not be there for all items" }, { "ItemId": 101, "Description": "Test", "DonatedBy": "Guy 1", "Value": 100 }, { "ItemId": 102, "Description": "Test", "DonatedBy": "Guy", "Value": 10 }, { "ItemId": 103, "Description": "Test test", "DonatedBy": "Guy guy", "Value": 1 }, { "ItemId": 100, "Description": "Test but really long this time just to see what happens", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 104, "Description": "Test omg way too long for nothing, just really trying the boundaries of this thing", "DonatedBy": "012345678910111213141516171819", "Value": "012345678910111213141516171819" }, { "ItemId": 200, "Description": "Test", "DonatedBy": "Guy", "Value": 100, "OtherDescription": "Just trying this thing out again to make sure it works" }, { "ItemId": 300, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 301, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 }, { "ItemId": 100, "Description": "Test", "DonatedBy": "Guy", "Value": 100 } ]', true);
$donors     = array( array( "DonatedBy" => "Name 1" ), array( "DonatedBy" => "Name 2" ) );
$pdf        = new FPDFWrapper;
//echo json_encode(GetItemsBySection($items));
$pdf->AppendFromFile('../Templates/AuctionProgram.txt', array(
  "sections"  => GetItemsBySection($items),
  "donors"    => $donors
));

$pdf->Output();

ob_end_flush();

?>
