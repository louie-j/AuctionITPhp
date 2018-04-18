<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn   = Connect();
$items  = $conn->query("SELECT * FROM viewauctionitemssheet");
$donors = $conn->query("SELECT * FROM viewdonators");
$pdf    = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionProgram.txt', array(
  "sections"  => GetItemsBySection($items),
  "donors"    => $donors
));

$pdf->Output();

?>
