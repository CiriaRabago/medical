<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";

class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			$this->Image('imagenes/Logotipo.jpg',4,4,70);
			$this->SetFont('Arial','BI',10); 
			$this->SetXY(10,12); 
			$zone=(3600*-4.5); 
			$fecha=gmdate("d-m-Y", time() + $zone);
			$hora=gmdate("h:i:s A", time() + $zone);
			$this->Cell(0,4,'FECHA: '.$fecha,0,1,'R',false);
			$this->Cell(0,4,'HORA: '.$hora,0,0,'R',false); 
			
			$this->SetFont('Arial','B',18);
			$this->SetXY(10,30); 
			$titulo=str_replace('<br>',' ',$_POST['titu']);
			$this->MultiCell(0,10,$titulo,0,'C',false); 
			$this->SetFont('Arial','BI',10); 
			$this->Ln();  
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-16);
			$this->SetFont('Arial','BI',8);
			$this->Cell(0,0,utf8_decode('Carrera 6 barrio Lagunitas local 1-22, San antonio - edo. Táchira /  '),0,0,'C');
			$this->SetY(-12);
			$this->Cell(0,0,utf8_decode('Carrera 21 entre pasaje acueducto y calle 12, edificio Tiyity planta baja - San Cristóbal edo. Táchira '),0,0,'C');
			//$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');
		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','letter'); //
$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetDrawColor(235,235,235);
		$ser= new servicio('','','','','','','','','','','','');
    	$reg=$ser->listado_atenc_res($_GET['fi'],$_GET['ff'],$_GET['serv'],$_GET['ced'],$_GET['sta'],$_GET['empr'],$_GET['medi']);
   		$cont=0;
		if($reg!=false)
		{
		   $pdf->SetFont('Arial','BI',10);
		   $pdf->SetX(40);
		   $pdf->Cell(30,5,'N°',0,0,'L',false);
		   $pdf->Cell(80,5,'NOMBRE DEL SERVICIO',0,0,'L',false);
		   $pdf->Cell(60,5,'ESTADO',0,0,'L',false);
		   $pdf->Cell(30,5,'CANTIDAD',0,1,'L',false);
		   $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());

		   $acum = 0;
		   while ($row=mysql_fetch_array($reg))
		   { 
			  if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			  $cont++;
			  switch ($row[2]) 
			  {	case 'A': $sta='ATENDIDO'; break;
				case 'L': $sta='LISTA DE ESPERA'; break;
				case 'P': $sta='PENDIENTE'; break;
				case 'I': $sta='INCOMPLETO'; break;
				case 'E': $sta='ELIMINADO'; break; 
			   }
			   $acum = $acum + $row[0];
				if($cont==1)$posy=$pdf->GetY(); else $posy=$ymax;
				if($posy>=185)
				{
				   $pdf->AddPage();
				   $pdf->SetFont('Arial','BI',10);
				   $pdf->SetX(40);
				   $pdf->Cell(30,5,'N°',0,0,'L',false);
				   $pdf->Cell(80,5,'NOMBRE DEL SERVICIO',0,0,'L',false);
				   $pdf->Cell(60,5,'ESTADO',0,0,'L',false);
				   $pdf->Cell(30,5,'CANTIDAD',0,1,'L',false);
				   $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
				   $posy=$pdf->GetY();
				}
				$pdf->SetFont('Arial','',10);
				$pdf->SetXY(40,$posy);
			   	$pdf->Cell(0,5,$cont,0,0,'L',false);
				$ymax=$pdf->GetY();	$pdf->SetXY(70,$posy);
			   	$pdf->MultiCell(0,5,$row[1],0,'L',false);
				if($pdf->GetY()>$ymax) $ymax=$pdf->GetY();	$pdf->SetXY(150,$posy);
			   	$pdf->MultiCell(0,5,$sta,0,'L',false);
				if($pdf->GetY()>$ymax) $ymax=$pdf->GetY();	$pdf->SetXY(210,$posy);
			   	$pdf->MultiCell(0,5,$row[0],0,'L',false);
				if($pdf->GetY()>$ymax) $ymax=$pdf->GetY();	
				$pdf->Line(10,$ymax,272,$ymax);
		   }
		   $pdf->SetFont('Arial','BI',10);
		   $pdf->SetX(40);
		   $pdf->Cell(170,5,'TOTAL',0,0,'L',false);
		   $pdf->Cell(0,5,$acum,0,0,'L',false);
		 }
$pdf->Output();
?>