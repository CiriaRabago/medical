<?php  
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_examen.php";

class PDF extends FPDF
{
		function Header()
		{
			$this->SetFont('Arial','B',8);
		}
		function Footer()
		{
			$this->SetY(-1.5);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,1,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
}
$pdf=new PDF('P','cm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->SetFont('Arial','B',8);
if($pdf->GetY()<12)
  $pdf->SetXY(1,1);
else
  $pdf->AddPage();

	$pdf->Image('imagenes/LogoPDF2.jpg',1,$pdf->GetY(),19.5,0);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'FECHA:         '.date('d-m-Y'),0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'CEDULA:      '.$_POST['cedula'],0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'NOMBRE:     '.$_POST['nombre'],0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'TELEFONO: ',0,0,'L',false);
	$pdf->SetXY(13.7,$pdf->GetY()-0.2);$pdf->MultiCell(6.5,0.3,$_POST['telefono'],0,'J',false);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(1,$pdf->GetY()+1); $pdf->Cell(0,1,'PRESUPUESTO DE LABORATORIO',0,1,'C',false); 

    $pdf->SetFont('Arial','',10);
	$pdf->SetXY(4,$pdf->GetY()+1); $pdf->Cell(0,1,'EXAMEN',0,0,'L',false); 
	$pdf->SetXY(18,$pdf->GetY()); $pdf->Cell(0,1,'MONTO',0,1,'L',false); 

	$pdf->SetFont('Arial','',9);
    $acu=0;
    for($y=0;$y<=$_POST['x'];$y++)
	 {
	 $pdf->SetXY(4,$pdf->GetY()+0.4);  $pdf->Cell(0,0,$_POST['exa'.$y],0,0,'L',false);
	 $pdf->SetXY(17,$pdf->GetY()); $pdf->Cell(0,0,$_POST['mon'.$y],0,1,'L',false);
	 $acu+=$_POST['mon'.$y];
	 }
    $pdf->SetFont('Arial','B',10);
	$pdf->SetXY(4,$pdf->GetY()+1); $pdf->Cell(0,1,'TOTAL -----------',0,0,'L',false); 
	$pdf->SetXY(18,$pdf->GetY()); $pdf->Cell(0,1,$acu,0,1,'L',false); 

$pdf->Output();
?>
