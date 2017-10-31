<?php

require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
    $year = date("Y");
    $conn = Connect();
    $query = "SELECT ItemId, Description, DonatedBy, Value FROM auctionitems ORDER BY ItemId asc";
    $result = $conn->query($query);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Auction Items');

foreach($result as $row) {
	$pdf->SetFont('Arial','B',12);	
	$pdf->Ln();
        $pdf->Cell(50, 8,$row["ItemId"] . ".   " . $row["Description"]);
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,8,"Donated By: " . $row["DonatedBy"]);
        $pdf->SetFont('Arial','B',12);	
        $pdf->Ln();
        $pdf->Cell(50,8,"Retail Value: $" . $row["Value"]);
}

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Special Thanks to those who donated.');
$pdf->Ln();

    $query = "SELECT DISTINCT DonatedBy FROM auctionitems";
    $result = $conn->query($query);
    foreach($result as $row) {
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,8,$row["DonatedBy"]);
        $pdf->Ln();
    }
$pdf->Output();
?>
