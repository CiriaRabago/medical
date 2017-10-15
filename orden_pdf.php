<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php"; 
include "clases/clase_examen.php";
include "clases/clase_resultado.php";
include "clases/clase_empleado.php";

if($_POST['orden'])
{
 	$idorden=$_POST['orden'];
}
else
{
 	$idorden=$_GET['orden'];
}

class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			$this->SetFont('Arial','B',8);
			$ord= new orden($idorden,'','','','','','');
			$result= $ord->ver_orden();
			if ($result) 
			{ $row = mysql_fetch_row($result); }
			$pac=$ord->consul_pac($row[4]);
			$datos=explode('/*',$pac); 


		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-1.5);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Número de página
			$this->Cell(0,1,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','cm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

$ord= new orden($idorden,'','','','','','');

//for ($i=0;$i<2;$i++)
//{

// ENCABEZADO ***************************************
	$pdf->SetFont('Arial','B',8);
	$orde= new orden($idorden,'','','','','','');
	$resulte= $orde->ver_orden();
	if ($resulte) 
	{ $rowe = mysql_fetch_row($resulte); }
	$pace=$orde->consul_pac_ID($rowe[4]);
	$datose=explode('/*',$pace); 
	if($i==1) 
	{
		if($pdf->GetY()<12)
			$pdf->SetXY(1,12);
		else
		    $pdf->AddPage();
	}
	$pdf->Image('imagenes/LogoPDF2.jpg',1,$pdf->GetY(),19.5,0);
	/*if(file_exists('fotos/'.$rowe[4].'.jpg'))
	{
		$pdf->Image('fotos/'.$rowe[4].'.jpg',9,$pdf->GetY()+0.3,2.5,2);
	} */
	$pdf->SetFont('Arial','B',8);
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'ORDEN No.:  '.$idorden,0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'FECHA:         '.$rowe[8],0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'CEDULA:      '.$datose[11],0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'NOMBRE:     '.$datose[1].' '.$datose[2].' '.$datose[3].' '.$datose[4],0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'EDAD:     '.calculaedad($datose[5]),0,0,'L',false); 
	$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'EMPRESA: ',0,0,'L',false);
	$pdf->SetXY(13.7,$pdf->GetY()-0.2);$pdf->MultiCell(6.5,0.3,$datose[8],0,'J',false);
	//$this->SetXY(13.7,2.7); 
	//$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'EMPRESA:    '.$datose[8],0,0,'L',false); 

	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(1,$pdf->GetY()+1); $pdf->Cell(0,1,'ORDEN DE LABORATORIO',0,0,'C',false); 

	$pdf->SetFont('Arial','',9);
	$result= $ord->ver_orden();
	if ($result) 
	{
		$pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
		$pdf->SetFillColor(227,227,230);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetLineWidth(0.05);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetXY(1,$pdf->GetY()+1);
		if ($datose[8]!='Particular' && $i==0)
		{
			$pdf->MultiCell(19.5,0.5,'EXAMEN'.$datosexa[0],'TB','L',true);
		}
		else
		{
			$pdf->MultiCell(11,0.5,'EXAMEN'.$datosexa[0],'TB','L',true);
			$pdf->SetXY(12,$pdf->GetY()-0.5); 
			$pdf->MultiCell(8.5,0.5,'PRECIO','TB','R',true);
		}

		$monto=0;
		$monto2=0;
		while($row = mysql_fetch_row($result))
		{
			$pdf->SetFont('Arial','',9);
			$pac=$ord->consul_pac($row[4]);
			$datos=explode('/*',$pac); 
			$pdf->SetXY(1,$pdf->GetY());
			$pdf->Cell(0,1,$row[1],0,0,'L',false); 
			$monto=$monto+(float)$row[2];
			$monto2=$row[7];
			if (($datose[8]!='Particular' && $i==0)==false)
			{
				$pdf->SetXY(12,$pdf->GetY());
				$pdf->Cell(0,1,'',0,0,'R',false); // donde van las comillas va $row[2]
			}
			$pdf->Ln(0.5);
		} // Fin del while
/*		if (($datose[8]!='Particular' && $i==0)==false)
		{
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(1,$pdf->GetY()+1);
			$pdf->Cell(0,0,'TOTAL',0,0,'L',false); 
			$pdf->SetXY(12,$pdf->GetY());
			$pdf->Cell(0,0,$monto2,0,0,'R',false);
		}
		else
		{
			$pdf->SetFont('Arial','I',8);
			$pdf->SetXY(1,$pdf->GetY()+1);
			$pdf->Cell(0,0,'COPIA DEL PACIENTE',0,0,'C',false);
		}
	*/			
	} // fin si hay resultados
//} //Fin del for



/*$pdf->SetXY(1,$pdf->GetY()); 
$pdf->Image('imagenes/gris.gif',1,$pdf->GetY(),19.5,0.05);*/



$pdf->Output();
?>
