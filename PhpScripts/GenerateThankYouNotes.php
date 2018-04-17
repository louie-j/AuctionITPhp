<?php

require 'DatabaseConnection.php';
require 'FPDFWrapperHelpers.php';

$year       = date("Y");
$conn       = Connect();
$donorQuery = "CALL viewDonors(".$year.")";
//$donors     = $conn->query($donorQuery);
$donors     = json_decode('[ { "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test but really long this time to see what happens on the receipt" }, { "Value": 100, "Name": "Name Name", "ItemId": 100, "Description": "Description test test" }, { "Value": 100, "Name": "Name Name 2", "ItemId": 100, "Description": "Description test test" } ]', true);
$pdf        = new FPDFWrapper;

$pdf->AppendFromFile('../Templates/ThankYouNotes.txt', array( "donors" => GetDonorsAndTotals($donors) ));

$pdf->Output();

?>
