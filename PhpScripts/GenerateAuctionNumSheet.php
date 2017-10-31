<?php

//header('Location: Report.php');

require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
    $year = date("Y");
    $conn = Connect();
    $query = "CALL viewAuctionItemsSheet(".$year.")";
    $result = $conn->query($query);

$pdf = new FPDF();

foreach($result as $row) {
        $pdf->AddPage();
	$pdf->SetFont('Arial','B',20);	
	$pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["ItemId"],0,0,'C');
        $pdf->Ln();
        $pdf->Cell(0, 40,"$" . $row["Value"] . " ". $row["Description"],0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Donated By:",0,0,'C');
        $pdf->Ln();
        $pdf->Cell(0,10, $row["DonatedBy"],0,0,'C');
}

$pdf->Output();
?>

