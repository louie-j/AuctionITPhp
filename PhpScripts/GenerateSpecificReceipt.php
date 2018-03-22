<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$year           = date("Y");
$conn           = Connect();
//$bidderID       = $conn->real_escape_string($_POST['bidderID']);
//$purchaseQuery  = "CALL viewSpecificReceipt(" . $bidderID . "," . $year . ")";
//$purchases      = $conn->query($purchaseQuery);
$purchases      = json_decode('[ { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "BuyerId": 1, "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test" } ]', true);
$pdf            = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionReceipt.txt', array( "receipts" => GetReceiptsFromPurchases($purchases) ));

$pdf->Output();

?>
