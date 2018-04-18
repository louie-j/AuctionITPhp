<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn		= Connect();
$items	= $conn->query("SELECT * FROM viewauctionitemssheet");
$pdf		= new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionNumSheet.txt', array( "items" => GetNumSheetItems($items) ));

$pdf->Output();

?>
