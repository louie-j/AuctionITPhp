<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$conn   = Connect();
$conn->query("SET sql_mode=''");
$donors	= $conn->query("SELECT * FROM view_auction_items_sheet");
$pdf    = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/ThankYouNotes.txt', array( "donors" => GetDonorsAndTotals($donors) ));

$pdf->Output();

?>
