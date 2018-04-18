<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn       = Connect();
$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$purchases	= $conn->query("SELECT * FROM viewreceipts");
$pdf        = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionReceipt.txt', array( "receipts" => GetReceiptsFromPurchases($purchases, $bidderID) ));

$pdf->Output();

?>
