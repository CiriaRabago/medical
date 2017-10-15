<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_referencia.php"; 
include "clases/clase_formato.php"; 

class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
		     $logo=$_GET['log'];
			if ($logo=='1')
			  {
			$this->Image('imagenes/Logotipo.gif',4,4,70);}
			$this->SetFont('Arial','B',18);
			$this->SetXY(10,50); 
			$this->Cell(0,10,'CONSTANCIA MÉDICA',0,0,'C',false); 
			$this->SetFont('Arial','BI',10); 
			/*$this->SetXY(165,30); 
			$this->Cell(20,10,'FECHA: '.date('d-m-Y'),0,0,'RB',false); */
			$this->Ln(); 
			$this->Cell(0,10,' ',0,0,'L',false); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			//Arial italic 8
			$this->SetFont('Arial','BI',8);
			//Número de página
			/*$this->Cell(0,0,'Avenida Principal Pirineos I lote A Vereda 1, Teléfonos: 0276 - 3568903 4167803 - San Cristóbal',0,0,'C');
			$this->SetY(-7);
			$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');*/

		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm',array(140,215)); //
$pdf->AliasNbPages();

$idvis=$_GET['vis'];
$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);
$ref= new referencia('','','','','','','','','','',''); 
$lref=$ref->lista_ref($idvis);
$row= mysql_fetch_row($lref);
$reporte=new formato();
$dv=$reporte->diag_vis($idvis);
while($rowdiag=mysql_fetch_row($dv))
{$diagnos=$rowdiag[2].' '.$rowdiag[3];}
		$pdf->AddPage();
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(58,6,'Se hace constar que el paciente: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(0,6,$rowdv[1],0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(58,6,'Titular de la Cédula de Identidad: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(22,6,$rowdv[0],0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,6,'Acude por presentar: ',0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,6,'   '.$diagnos,0,'L',false);
										//$pdf->MultiCell(0,6,'   '.$rowdv[14],0,'L',false);
		//$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,6,'Motivo por el Cual se indica Tratamiento Médico y Reposo Absoluto por: ',0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,6,'   '.$rowdv[24],0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,6,'Fecha de Consulta: '.$rowdv[28],0,0,'R',false);
		$pdf->Ln();	
		$pdf->SetXY(6,128);
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(0,6,'                                           ',0,0,'C',false);
		$pdf->SetXY(6,133);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,6,'MÉDICO EVALUADOR',0,0,'C',false);

$pdf->Output();
?>
