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
			  {
			   $this->Image('imagenes/Logotipo.jpg',10,4,60);}
//			$this->Image('imagenes/Logotipo.jpg',10,115,60);
//			$this->Image('imagenes/Logotipo.jpg',155,4,60);
			$this->SetFont('Arial','B',18);
			/*$this->SetXY(10,30); 
			$this->Cell(0,10,'SOLICITUD',0,0,'C',false); 
			$this->SetFont('Arial','BI',10);
			$this->Cell(-10,10,'FECHA: '.date('d-m-Y'),0,0,'R',false); 
			$this->Ln(); */
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
			//$this->Cell(0,0,'Página '.$this->PageNo().'/{nb}',0,0,'C');
			/*$this->Cell(0,0,'Carrera 6 barrio Lagunitas local 1-22, San antonio - edo. Táchira / Carrera 21 entre pasaje acueducto y calle 12, edificio Tiyity planta baja - San Cristóbal edo. Táchira ',0,0,'C');
			$this->SetY(-7);
			//$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');*/
		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter'); //
$pdf->AliasNbPages();

$idvis=$_GET['vis'];
$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);

		$pdf->AddPage();		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(40);	
		/*$pdf->Ln();	
		$pdf->Ln();	
		$pdf->Ln();	*/
		$pdf->SetX(80);
		$pdf->SetFont('Arial','BI',14); $pdf->Cell(14,16,'RÉCIPE ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'CÉDULA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(125,6,$rowdv[0],0,0,'L',false);
		/* nuevo */
//hoja vertical		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'CÉDULA: ',0,0,'L',false);
//hoja vertical		$pdf->SetFont('Arial','',10); 	$pdf->Cell(85,6,$rowdv[0],0,0,'L',false);
//		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'CÉDULA: ',0,0,'L',false);
//		$pdf->SetFont('Arial','',10); 	$pdf->Cell(125,6,$rowdv[0],0,0,'L',false);
		/* fin de nuevo */
		$pdf->Ln();	
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'NOMBRE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(125,6,$rowdv[1],0,0,'L',false);
		/* nuevo */
//hoja vertical		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'NOMBRE: ',0,0,'L',false);
//hoja vertical		$pdf->SetFont('Arial','',10); 	$pdf->Cell(85,6,$rowdv[1],0,0,'L',false);
//		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'NOMBRE: ',0,0,'L',false);
//		$pdf->SetFont('Arial','',10); 	$pdf->Cell(85,6,$rowdv[1],0,0,'L',false);
		/* fin de nuevo */
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'FECHA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(125,6,$rowdv[28],0,0,'L',false);
		/* nuevo */
//hoja vertical		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'FECHA: ',0,0,'L',false);
//hoja vertical		$pdf->SetFont('Arial','',10); 	$pdf->Cell(85,6,$rowdv[28],0,0,'L',false);
//		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'FECHA: ',0,0,'L',false);
//		$pdf->SetFont('Arial','',10); 	$pdf->Cell(85,6,$rowdv[28],0,0,'L',false);		
		/* fin de nuevo */
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',11); $pdf->Cell(145,6,'RÉCIPE: ',0,0,'L',false);
		/* nuevo */
//hoja vertical		$pdf->SetFont('Arial','BI',11); $pdf->Cell(180,6,'INDICACIONES: ',0,0,'L',false);
//		$pdf->SetFont('Arial','BI',11); $pdf->Cell(180,6,'INDICACIONES: ',0,0,'L',false);		
		/* fin de nuevo */
		//$pdf->Ln();
		//$yact=$pdf->GetY(); 		
		$pdf->Ln();
		$pdf->SetX(40);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(180,6,$rowdv[21],0,'J',false);	
		$pdf->Ln();
		$pdf->SetX(100);
		$pdf->SetFont('Arial','',15); 	$pdf->MultiCell(180,6,"*VALIDO POR 1 MES*",0,'L',false);			
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		
		//$pdf->Ln();
		//$pdf->SetY(140);		
		$pdf->SetX(80);		
		$pdf->SetFont('Arial','BI',14); $pdf->Cell(180,6,'INDICACIONES ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'CÉDULA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,6,$rowdv[0],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'NOMBRE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,6,$rowdv[1],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,6,'FECHA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,6,$rowdv[28],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);	
		$pdf->SetFont('Arial','BI',11); $pdf->Cell(180,6,'INDICACIONES: ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(40);	
		//$pdf->SetXY(150,$yact);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(180,6,$rowdv[22],0,'J',false);
		$pdf->Ln();
		$pdf->SetX(100);
		$pdf->SetFont('Arial','',15); 	$pdf->MultiCell(180,6,"*VALIDO POR 1 MES*",0,'L',false);			

$pdf->Output();
?>
