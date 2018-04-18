<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn       = Connect();
$purchases	= $conn->query("SELECT * FROM viewreceipts");
$pdf        = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionReceipt.txt', array( "receipts" => GetReceiptsFromPurchases($purchases, null) ));

$pdf->Output();

?>