<?php

require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
    $year = date("Y");
    $conn = Connect();
    $query = "CALL viewAuctionItemsSheet(".$year.")";
    $result = $conn->query($query);

$pdf = new FPDF();
$count = 0;
$pdf->SetFont('Arial','B',10);
$rightX;
$rightY;
$newX;
$newY;
foreach($result as $row) {
    
    if($count == 0)
    {
        $pdf->AddPage();
        $pdf->Cell(0, 5,"Broadway on Main",0,0,'C');
        $pdf->Ln();
        $pdf->Cell(0, 5,"Festival Missions Auction",0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,5, $row["ItemId"] . " " . $row["Description"],0,0,'L');
        $rightX = $pdf->GetX();
        $rightY = $pdf->GetY();
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,5, "Donated by " . $row["DonatedBy"],0,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln();
        $pdf->Cell(0,5, "Retail Value: $" . $row["Value"],0,0,'L');
        $newX = $pdf->GetX();
        $newY = $pdf->GetY();
        $count++;
    }
    elseif($count%2 != 0)
    {
        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY($rightX, $rightY);
        $pdf->Cell(0,5, $row["ItemId"] . " " . $row["Description"],0,0,'R');
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,5, "Donated by " . $row["DonatedBy"],0,0,'R');
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln();
        $pdf->Cell(0,5, "Retail Value: $" . $row["Value"],0,0,'R');
        $count++;
        $pdf->SetXY($newX, $newY);
    }
    elseif($count%2 == 0)
    {
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,5, $row["ItemId"] . " " . $row["Description"],0,0,'L');
        $rightX = $pdf->GetX();
        $rightY = $pdf->GetY();
        $pdf->Ln();
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,5, "Donated by " . $row["DonatedBy"],0,0,'L');
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln();
        $pdf->Cell(0,5, "Retail Value: $" . $row["Value"],0,0,'L');
        $newX = $pdf->GetX();
        $newY = $pdf->GetY();
        $count++;
    }
}

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Special Thanks to those who donated.');
$pdf->Ln();

 /*   $query = "SELECT DISTINCT DonatedBy FROM auctionitems";
    $donated = $conn->query($query);
    foreach($donated as $row) {
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,8,$row["DonatedBy"]);
        $pdf->Ln();
    }*/
$pdf->Output();
?>
