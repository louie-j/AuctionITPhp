<?php

require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
    $year = date("Y");
    $conn = Connect();
    $query = "CALL viewAuctionItemsSheet(".$year.")";
    $result = $conn->query($query);

    ob_end_clean();
    ob_start(); 
$pdf = new FPDF();
    $count = 0;
$rightX;
$rightY;
$newX;
$newY;
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);
$pdf->Cell(0,5, 'IMPORTANT BIDDING',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5, 'INFORMATION',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5, 'PLEASE READ BEFORE BIDDING!!!',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,10,'All bids must be in multiples of $5 (5-10-15-20 etc.). Any Bid that is not a multiple of $5 will be discarded. Bids will be accepted until the board closed. All bids in the recorders hands when the board closes will be considered and the highest bidder will win the item. In case of a tie, the first bid submitted will be the winning bid.' , '', 'J', 0);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'Buy it Now Items',0,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,'The "Buy It Now" items can be purchased immediately at the designated price.',0,0,'J');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5,'These Items are tagged with a blue "Buy It Now" bidder slip.',0,0,'J');
$pdf->Ln();
$pdf->Ln();
$pdf->MultiCell(0,5,'If you want to purchase an item at the "Buy It Now" price, pull the bidder sheet and give to attendant in that area. If attendant is occupied, you may take it to the nearest bidder board','','J',0);
$pdf->SetFont('Arial','B',12);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5,'Checkout Process',0,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,5,'NO EARLY CHECKOUTS. Cashiers are not set up until after the live auction is complete. Other than "Buy It Now" items, no early payment can be accepted.','','J',0);
$pdf->SetFont('Arial','B',12);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5,'Checkout Process',0,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,5,'All items must be picked up by Sunday at 5:00 PM. Special arrangements will need to be made on Saturday night to schedule a Sunday pick up time.','','J',0);
foreach($result as $row) {
    
    if($count == 0)
    {
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
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
    elseif($count == 19)
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
        $count = 0;
        $pdf->Ln();
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
$result->close();
$conn->close();

$pdf->AddPage();
$conn = Connect();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Special Thanks To:');
$pdf->Ln();
$query = "CALL viewDonators(". $year . ")";
$result = $conn->query($query);
$pdf->SetFont('Arial','',12);
foreach($result as $row) {
    $pdf->Cell(0,5,$row["DonatedBy"],0,0,'L');
    $pdf->Ln();
    $pdf->Ln(); 
}
    $pdf->Output();
    ob_end_flush();
?>
