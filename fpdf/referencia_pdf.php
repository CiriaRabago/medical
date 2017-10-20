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
			  {$this->Image('imagenes/Logotipo.jpg',1,0.4,6);}
			$this->SetFont('Arial','B',22);
			$this->SetY(2);
			$this->SetX(3);
			$this->Cell(10,7,'REFERENCIA ',0,0,'C',false); 
			$this->SetFont('Arial','BI',15); 
			$idvis=$_GET['vis'];
			$reporte=new formato();
			$dbv=$reporte->datos_bas_vis($idvis);
			$rowdv=mysql_fetch_row($dbv);
			$this->SetX(5);
			$this->SetY(3);			
			$this->Cell(5,7,'FECHA: '.$rowdv[28],0,0,'RB',false); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			//Arial italic 8
			$this->SetFont('Arial','BI',8);

		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('L','cm','mcarta');
$pdf->SetMargins(0,0,0);
$pdf->AliasNbPages();
$idvis=$_GET['vis'];
$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);
$ref= new referencia('','','','','','','','','','',''); 
$lref=$ref->lista_esp_ref($idvis);
$n=mysql_num_rows($lref);

if($n==0)
{
	$pdf->AddPage();
	$pdf->SetFont('Arial','I',10);
	$pdf->Ln();	
	$pdf->Cell(0,6,'EL PACIENTE NO POSEE REFERENCIAS ASIGNADAS',0,0,'L',false);
}
else
{
  while($row= mysql_fetch_row($lref))
  {
  	if($row[5]==1) // si la referencia existe
	{
	    
		$pdf->AddPage();
		$pdf->SetY(7);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(5,0.5,'NOMBRE DEL PACIENTE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(10,0.5,$rowdv[1],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1,0.5,'C.I: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(2.5,0.5,$rowdv[0],0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1.5,0.5,'EDAD: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(1.5,0.5,$rowdv[9],0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(3,0.5,'OCUPACIÓN: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(5.5,0.5,'',0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(3,0.5,'REFERENCIA A: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(12,0.5,$row[7].$row[3],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'SE TRATA DE PACIENTE QUE ACUDE POR PRESENTAR: ',0,0,'L',false);
		$pdf->Ln();	
		//$rowdv[29] -- Motivo de la visita
		$dv=$reporte->diag_vis($idvis);
		while($rowdiag=mysql_fetch_row($dv))
		{	
			$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'   '.$rowdiag[2],0,1,'L',false);
			if($rowdiag[3]!='')
			{
				$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,0.5,'      '.$rowdiag[3],0,'L',false); 
			}
		}
		$pdf->SetFont('Arial','BI',10); $pdf->MultiCell(0,0.5,'MOTIVO POR EL CUAL SE AGRADECE SU VALORACIÓN, CONDUCTA, RECOMENDACIONES E INFORME PARA GESTIÓN DE: ',0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,0.5,$row[6].'   ',0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(0,0.5,'                                           ',0,0,'C',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'MÉDICO EVALUADOR',0,0,'C',false);
	} // Fin si la referencia existe
  } //Fin del while
} //Fin del Else



$pdf->Output();
?>
