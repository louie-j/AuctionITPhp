<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn		= Connect();
$conn->query("SET sql_mode=''");
$items	= $conn->query("SELECT * FROM view_auction_items_sheet");
$pdf		= new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionNumSheet.txt', array( "items" => GetNumSheetItems($items) ));

$pdf->Output();

?>
