<?php
//ob_start();
require 'DatabaseConnection.php';
require '../FPDF/fpdf.php';
$year = date("Y");
$conn = Connect();

$bidderID   = $conn->real_escape_string($_POST['bidderID']);
$query = "CALL viewSpecificReceipt(" . $bidderID . "," . $year . ")";
$result = $conn->query($query);

$pdf = new FPDF();
$running_total = $current_ID = 0;

foreach($result as $row) {
    if($current_ID == 0)
    {
        $pdf->AddPage();
        $running_total = 0;
        $current_ID = $row["BuyerId"];
        $running_total = $row["Value"];
        $pdf->SetFont('Arial','B',15);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Purchased By: " . $row["Name"],0,0,'C');
        $pdf->Ln();
        $pdf->Cell(0,10,"Purchased By ID Number: " . $row["BuyerId"],0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["ItemId"] . " " . $row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }
    else if($row["BuyerId"] != $current_ID)
    {
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Total Due: ",0,0,'C');
        $pdf->Cell(0,10,"$" . $running_total,0,0,'R');
        $pdf->AddPage();
        $running_total = 0;
        $current_ID = $row["BuyerId"];
        $running_total = $row["Value"];
        $pdf->SetFont('Arial','B',15);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0,10,"Purchased By: " . $row["Name"],0,0,'C');
        $pdf->Ln();
        $pdf->Cell(0,10,"Purchased By ID Number: " . $row["BuyerId"],0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["ItemId"] . " " . $row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }
    else 
    {
        $running_total = $running_total + $row["Value"];
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(0, 5,$row["ItemId"] . " " . $row["Description"] . " ",0,0,'C');
        $pdf->Cell(0, 5,"$" . $row["Value"],0,0,'R');
    }	
}
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,10,"Total Due: ",0,0,'C');
$pdf->Cell(0,10,"$" . $running_total,0,0,'R');
$pdf->Output();
?>