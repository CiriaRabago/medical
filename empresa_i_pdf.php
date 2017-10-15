<?php 
session_start();
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			//$this->Image('imagenes/Logotipo.gif',4,4,70);
			if($xxx=='')
			  $xxx=1;
			else
			  $xxx++;  
			$this->SetFont('Arial','BI',10); 
			$this->SetXY(10,12); 
			$zone=(3600*-4.5); 
			$fecha=gmdate("d-m-Y", time() + $zone);
			$hora=gmdate("h:i:s A", time() + $zone);
			$this->Cell(0,4,'PAGINA: '.$this->PageNo(),0,1,'R',false);
			$this->Cell(0,4,'FECHA: '.$fecha,0,1,'R',false);
			$this->Cell(0,4,'HORA: '.$hora,0,0,'R',false); 
			
			$this->SetFont('Arial','B',18);
			$this->SetXY(10,25); 
			$this->MultiCell(0,10,'EMPRESAS ELIMINADAS',0,'C',false); 
			$this->SetFont('Arial','BI',10); 
			$this->Ln();  
			
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			$this->SetFont('Arial','BI',8);
			$this->Cell(0,0,'Avenida Principal Pirineos I lote A Vereda 1, Teléfonos: 0276 - 3568903 4167803 - San Cristóbal',0,0,'C');
			$this->SetY(-7);
			$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');
		}
} // fin de la clase

//Creación del objeto de la clase heredada
  $pdf=new PDF('P','mm','letter'); //
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetDrawColor(235,235,235);
  $pdf->SetFont('Arial','BI',10); 
  $pdf->SetXY(39,6);
  $pdf->Cell(50,5,$titulo,0,0,'C',false);
  $pdf->SetFont('Arial','BI',6);
  $emp=new empresa();
  $result=$emp->lista_emp_i();
  $x=1; 
  $y=1;
  $pos=36;
  $pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
  $pdf->SetFillColor(227,227,230);
  $pdf->SetTextColor(0,0,0);
  $pdf->SetLineWidth(0.05);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetXY(10,33);$pdf->MultiCell(0,6,'       RIF              NOMBRE                                       TELEFONO 1  TELEFONO 2','TB','L',true);
  $pdf->SetFont('Arial','B',6);
  while ($row = mysql_fetch_row($result))
    {
     //$pdf->Ln();
	 $pos+=6;	
	 $pdf->SetXY(10,$pos);$pdf->MultiCell(0,6,$x,1,'L',false);
	 $pdf->SetXY(20,$pos);$pdf->MultiCell(0,6,$row[1],1,'L',false);
	 $pdf->SetXY(39,$pos);$pdf->MultiCell(0,6,$row[2],1,'L',false);
	 $pdf->SetXY(120,$pos);$pdf->MultiCell(0,6,$row[5],1,'L',false);
	 $pdf->SetXY(140,$pos);$pdf->MultiCell(0,6,$row[6],1,'L',false);
	 $x++; 
	 $y++;
	 if($y==36)
	   { $y=1;
	     $pdf->AddPage();
	     $pos=36;}     
	   } 
		 
$pdf->Output();
?>
