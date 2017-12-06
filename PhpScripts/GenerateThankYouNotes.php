<?php

//header('Location: Report.php');

require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
    $year = date("Y");
    $conn = Connect();
    $query = "CALL viewDonors(".$year.")";
    $result = $conn->query($query);

$pdf = new FPDF();
$running_total = 0;
$current_ID = "";

foreach($result as $row) {
    if(strcmp($current_ID, "") == 0)
    {
        $pdf->AddPage();
        $running_total = 0;
        $current_ID = $row["Name"];
        $running_total = $row["Value"];
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(0,10,"",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Dear " . $row["Name"] . ",",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Thank you for donating to this year's auction. The generosity of you and",0,0,'L');
        $pdf->Ln();
<<<<<<< HEAD
        $pdf->Cell(0,10,"others allow for the event to be a success. Also, consider this a donation",0,0,'L');
=======
        $pdf->Cell(0,10,"others allows for the event to be a success. Also, consider this a donation",0,0,'L');
>>>>>>> origin/Thank-You-Note-format
        $pdf->Ln();
        $pdf->Cell(0,10,"receipt for tax purposes.",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }
    else if(strcmp($row["Name"], $current_ID) != 0)
    {
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Total Contribution: ",0,0,'C');
        $pdf->Cell(0,10,"$" . $running_total,0,0,'R');
<<<<<<< HEAD
=======
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Sincerely,",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"FBCM Auction Committee",0,0,'L');
>>>>>>> origin/Thank-You-Note-format
        $pdf->AddPage();
        $running_total = 0;
        $current_ID = $row["Name"];
        $running_total = $row["Value"];
        $pdf->SetFont('Arial','B',15);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Dear " . $row["Name"] . ",",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Thank you for donating to this year's auction. The generosity of you and",0,0,'L');
        $pdf->Ln();
<<<<<<< HEAD
        $pdf->Cell(0,10,"others allow for the event to be a success. Also, consider this a donation",0,0,'L');
=======
        $pdf->Cell(0,10,"others allows for the event to be a success. Also, consider this a donation",0,0,'L');
>>>>>>> origin/Thank-You-Note-format
        $pdf->Ln();
        $pdf->Cell(0,10,"receipt for tax purposes.",0,0,'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }
    else 
    {
        $running_total = $running_total + $row["Value"];
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }	
        //$pdf->Cell(0, 5,$row["ItemId"] . " " . $row["Description"] . "$" . $row["Value"],0,0,'C');
        //$pdf->Ln();
        //$pdf->Cell(0, 40,"$" . $row["Value"] . " ". $row["Description"],0,0,'C');
        //$pdf->Ln();
        //$pdf->Ln();
        //$pdf->Ln();
        //$pdf->Ln();
        //$pdf->Ln();
        //$pdf->Cell(0,10,"Purchased By:",0,0,'C');
        //$pdf->Ln();
        //$pdf->Cell(0,10, $row["BuyerId"],0,0,'C');
}
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,10,"Total Contribution: ",0,0,'C');
$pdf->Cell(0,10,"$" . $running_total,0,0,'R');
<<<<<<< HEAD
=======
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,10,"Sincerely,",0,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,10,"FBCM Auction Committee",0,0,'L');
>>>>>>> origin/Thank-You-Note-format
$pdf->Output();
?>
