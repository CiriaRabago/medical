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
			
			$this->Image('imagenes/Logotipo.jpg',4,4,70);
			$this->SetFont('Arial','B',18);
			$this->Cell(0,26,' ',0,1,'L',false); 
			$this->SetFont('Arial','B',14);
			$this->Cell(0,6,'INFORME DE MEDICINA',0,1,'C',false); 
			$this->Cell(0,6,'OCUPACIONAL',0,1,'C',false); 
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
$idpac=$_GET['oidpac'];

$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);

		$pdf->AddPage();
		
		if(file_exists('fotos/'.$rowdv[27].'.jpg'))
		{
			$pdf->Image('fotos/'.$rowdv[27].'.jpg',160,30,32,24);
		}
			
		$pdf->Ln();	$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(180,5,'Por medio de la presente informo sobre la evaluación médica solicitada por la empresa : ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',11); 	$pdf->Cell(0,5,$rowdv[12],0,0,'C',false);
		$pdf->Ln();$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Consulta Médica Ocupacional: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[15],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Nombre y Apellido: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[1],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Cédula de Identidad: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[0],0,0,'L',false);
		$pdf->Ln();
		$cargAct=$reporte->cargo_act($rowdv[27]);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Ocupación: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$cargAct[1],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Examen Físico: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[18],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Examen de Laboratorio: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[19],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'CONCLUSIÓN: ',0,0,'L',false);
		$pdf->SetFont('Arial','B',10); 	$pdf->Cell(120,5,$rowdv[17],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Se anexa informe de: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Ex. de Laboratorio',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Visiometría  ',0,0,'C',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);

		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,' ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Rayos X',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Espirometría',0,0,'C',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,' ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Ekg',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Audiometría ',0,0,'C',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,' ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,'Otros',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(20,5,'',1);
		$pdf->SetFont('Arial','U',10); 	$pdf->Cell(61,7,'                                                          ',0,0,'R',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Recomendaciones: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(120,5,$rowdv[23],0,'J',false);
		$pdf->Ln();
		
		$ref= new referencia('','','','','','','','','','',''); 
		$lref=$ref->lista_esp_ref($idvis);
		$lr=0; $nr='';
		while($row7 = mysql_fetch_row($lref))
		{  
			if($row7[5]==1)
			{
				if($lr==0) 
					$nr.=ucfirst(strtolower($row7[7].$row7[3]));
				else
					$nr.=', '.ucfirst(strtolower($row7[7].$row7[3]));
				$lr++;
			}
		}
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Referencias: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(120,5,$nr,0,'J',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'San Cristóbal, '.$rowdv[28],0,0,'L',false);
		$pdf->Ln();$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,5,'DECLARACIÓN DE CONOCIMIENTO DE RESULTADO DE LOS EXÁMENES DE SALUD',0,0,'C',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10); $pdf->MultiCell(0,5,'Dichos resultados me han sido explicados, teniendo oportunidad de formular preguntas, las cuales han sido respondidas y explicadas en forma satisfactoria.  En	consecuencia, quedo en pleno conocimiento sobre la informaci{on de mi salud, en conformidad con lo dispuesto en el artículo 27 del Reglamento Parcial de la Ley Orgánica de Prevención, Condiciones y Medio Ambiente de Trabajo.',0,'J',false);

		$pdf->Ln();

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
