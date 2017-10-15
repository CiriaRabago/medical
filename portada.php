<?php 
require('fpdf/fpdf.php');

class PDF extends FPDF
{
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','cm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','I',6);


	$pdf->SetFillColor(51,153,51);	
	$pdf->SetXY(1,15);  
        $pdf->MultiCell(19.5,0.05,' ',0,'C',true);

	$pdf->SetFillColor(243,224,255);	
	$pdf->SetXY(1,15.1);  
        $pdf->MultiCell(19.5,0.2,' ',0,'C',true);

	$pdf->SetFillColor(51,153,51);	
	$pdf->SetXY(1,15.35);  
        $pdf->MultiCell(19.5,0.05,' ',0,'C',true);

	$pdf->Image('minilogo2.jpg',1,15.5,8,3.5);
	$pdf->SetFont('Arial','I',9);$pdf->SetXY(14,17); $pdf->Cell(0,1,' Lcda. Marvelis Sánchez de Sánchez',0,0,'C',false);
	$pdf->SetFont('Arial','I',9);$pdf->SetXY(14,17.4); $pdf->Cell(0,1,'      Bioanalista',0,0,'C',false);
	$pdf->SetFont('Arial','I',8);$pdf->SetXY(1,24);   $pdf->Cell(0,1,'Calle 4 No. 9-02, La Grita, Estado Táchira, Venezuela.',0,0,'C',false);
	$pdf->SetFont('Arial','I',8);$pdf->SetXY(1,24.4); $pdf->Cell(0,1,'Telf: 0277-9892669. E-mail: marve13sanchez@hotmail.com',0,0,'C',false);

	$pdf->SetFillColor(51,153,51);	
	$pdf->SetXY(1,25.1);  
        $pdf->MultiCell(19.5,0.05,' ',0,'C',true);

	$pdf->SetFillColor(243,224,255);
	$pdf->SetXY(1,25.21);
	$pdf->MultiCell(19.5,0.2,' ',0,'C',true);

	$pdf->SetFillColor(51,153,51);	
	$pdf->SetXY(1,25.45);  
        $pdf->MultiCell(19.5,0.05,' ',0,'C',true);


$pdf->Output();
?>
