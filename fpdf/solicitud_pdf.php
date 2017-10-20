<?php  
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_solicitud.php"; 
include "clases/clase_formato.php"; 

class PDF extends FPDF
{
		//Cabecera de página
		function Header()
		{
		   $logo=$_GET['log'];
			if ($logo=='1')
			  {$this->Image('imagenes/Logotipo.jpg',1,0.4,6);}
			$this->SetFont('Arial','B',18);
			$this->SetY(2);
			$this->SetX(4);
			$this->Cell(5,7,'SOLICITUD',0,0,'C',false); 
			$this->SetFont('Arial','BI',10);
			$idvis=$_GET['vis'];
			$reporte=new formato();
			$dbv=$reporte->datos_bas_vis($idvis);
			$rowdv=mysql_fetch_row($dbv);
			//$this->SetX(5);
			$this->SetY(3);
			$this->Cell(5,7,'FECHA: '.$rowdv[28],0,0,'RB',false); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-2);
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
$ref= new solicitud('','','','','','','','','','',''); 
$lref=$ref->lista_sol($idvis);
$n=mysql_num_rows($lref);

if($n==0)
{
	$pdf->AddPage();
	$pdf->SetFont('Arial','I',10);
	$pdf->Ln();	
	$pdf->Cell(0,6,'EL PACIENTE NO POSEE SOLICITUDES ASIGNADAS',0,0,'L',false);
}
else
{
		$pdf->AddPage();
		$pdf->SetY(7);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(2,0.5,'NOMBRE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(9,0.5,$rowdv[1],0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1,0.5,'C.I: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(2.5,0.5,$rowdv[0],0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1.5,0.5,'EDAD: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(1,0.5,$rowdv[9],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'MOTIVO DE LA CONSULTA: ',0,1,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,0.5,$rowdv[29],0,'J',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(6,0.5,'ESTUDIO SOLICITADO: ',0,1,'L',false);
		
		while($row= mysql_fetch_row($lref))
		{
			if($row[3]==1) // si la referencia existe
			{
				$solic='';
				if($row[4]!='')
					$solic=$row[1].' - '.$row[4];
				else
					$solic=$row[1];
				$pdf->SetFont('Arial','',10); 	$pdf->Cell(0,0.4,'   * '.$solic,0,1,'L',false);
			} // Fin si la solicitud existe
		  } //Fin del while
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->MultiCell(0,0.5,'SE AGRADECE REALIZAR EL INFORME CORRESPONDIENTE. ',0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,0.5,'   ',0,'L',false);
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(0,0.6,'                                           ',0,1,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.4,'MÉDICO EVALUADOR',0,0,'C',false);
} //Fin del Else



$pdf->Output();
?>
