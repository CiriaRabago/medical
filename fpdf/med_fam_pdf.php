<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_formato.php"; 
include "clases/clase_referencia.php"; 


class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			
			$this->Image('imagenes/Logotipo.gif',4,4,70);
			$this->SetFont('Arial','B',18);
			$this->Cell(0,26,' ',0,1,'L',false); 
			$this->SetFont('Arial','B',14);
			$this->Cell(0,6,'INFORME DE MEDICINA',0,1,'C',false); 
			$this->Cell(0,6,'FAMILIAR',0,1,'C',false); 
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
			/*$this->Cell(0,0,'Avenida Principal Pirineos I lote A Vereda 1, Teléfonos: 0276 - 3568903 4167803 - San Cristóbal',0,0,'C');
			$this->SetY(-7);
			$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');*/

		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter'); //
$pdf->AliasNbPages();

$idvis=$_GET['vis'];
$idpac=$_GET['oidpac'];

$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);

		$pdf->AddPage();
		
		if(file_exists('fotos/'.$rowdv[27].'.jpg'))
		{
			$pdf->Image('fotos/'.$rowdv[27].'.jpg',160,30,32,24);
		}
		$cargAct=$reporte->cargo_act($rowdv[27]);
		$pdf->Ln();	$pdf->Ln();	
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(60,6,'Cédula: '.$rowdv[0],0); 		$pdf->Cell(120,6,'Nombre: '.$rowdv[1],0);
		$pdf->Ln();
		$pdf->Cell(60,6,'Edad: '.$rowdv[9],0); 			$pdf->Cell(120,6,'Fecha de Nacimiento: '.$rowdv[25],0);
		$pdf->Ln();
		$pdf->Cell(60,6,'Sexo: '.$rowdv[7],0); 			$pdf->Cell(120,6,'Dirección: '.$rowdv[26],0);
		$pdf->Ln();
		$pdf->Cell(60,6,'Estado Civil: '.$rowdv[5],0); 	$pdf->Cell(120,6,'Teléfonos: '.$rowdv[2].'  '.$rowdv[3],0);
		$pdf->Ln();
		$pdf->Cell(60,6,'',0); 							$pdf->Cell(120,6,'Ocupación: '.$cargAct[1],0);
		$pdf->Ln();$pdf->Ln();	

		$peso=$reporte->signos_vitales($idvis,11);
		$ta=$reporte->signos_vitales($idvis,72);
		$talla=$reporte->signos_vitales($idvis,12);
		$tc=$reporte->signos_vitales($idvis,73);
		$fr=$reporte->signos_vitales($idvis,74);
		$fur=$reporte->signos_vitales($idvis,75);
		$imc=$reporte->signos_vitales($idvis,77);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'Fecha: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$rowdv[28],0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'Peso: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$peso,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'Talla: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$talla,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'TA: ',0,0,'',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$ta,0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'PULSO: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$tc,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'FR: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$fr,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'FUR: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$fir,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'IMC: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(30,5,$imc,0,0,'L',false);
		$pdf->Ln();$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'MOTIVO DE LA CONSULTA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(140,5,$rowdv[29],0,'L',false);
		
		//$pdf->Cell(120,5,$rowdv[29],0,0,'L',false);
		$pdf->Ln();//	$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Examen Físico: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(140,5,$rowdv[18].' '.$rowdv[30],0,'L',false);
		$pdf->Ln(); //$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'DIAGNÓSTICO: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(140,5,$rowdv[14].' '.$rowdv[31],0,'L',false);
		$pdf->Ln();$pdf->Ln();

		$pdf->SetX(85);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,30,'                                           ',1);
		$pdf->Ln(20);
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		//$pdf->SetFont('Arial','BIU',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Firma del Paciente ',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'                                           ',0,0,'C',false);
		//$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Dr.(a): '.$rowdv[10],0,0,'C',false);
		//$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'MÉDICO TRATANTE',0,0,'C',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'C.I.: '.$rowdv[0],0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Huella Pulgar Derecho',0,0,'C',false);
		//$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'ESPECIALIDAD MÉDICO',0,0,'C',false);

$pdf->Output();
?>
