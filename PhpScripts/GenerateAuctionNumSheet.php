<?php

require 'DatabaseConnection.php';
require 'FPDFWrapper.php';

$conn		= Connect();
$items	= $conn->query("SELECT * FROM viewauctionitemssheet");
$pdf		= new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionNumSheet.txt', array( "items" => $items ));

$pdf->Output();

?>
