<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn   = Connect();
$donors	= $conn->query("SELECT * FROM view_auction_items_sheet");
$pdf    = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/ThankYouNotes.txt', array( "donors" => GetDonorsAndTotals($donors) ));

$pdf->Output();

?>
