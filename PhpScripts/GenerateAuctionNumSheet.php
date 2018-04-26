<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn		= Connect();
$items	= $conn->query("SELECT * FROM view_auction_items_sheet");
$pdf		= new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionNumSheet.txt', array( "items" => GetNumSheetItems($items) ));

$pdf->Output();

?>
