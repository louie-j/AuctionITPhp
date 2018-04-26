<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn   = Connect();
$items  = $conn->query("SELECT * FROM view_auction_items_sheet");
$donors = $conn->query("SELECT * FROM view_donators");
$pdf    = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/AuctionProgram.txt', array(
  "sections"  => GetItemsBySection($items),
  "donors"    => $donors
));

$pdf->Output();

?>
