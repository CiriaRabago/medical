<?php  
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_resultado.php";


class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			$this->Image('imagenes/LogoPDF2.jpg',1,1,19.5,0);
$this->SetXY(1,4.5); 
			$this->SetFont('Arial','B',12);
			//Título
			$this->Cell(0,0.5,'Listado de Exámenes Realizados desde el: '.$_POST["ocu_fi"].' Hasta el: '.$_POST["ocu_ff"],0,1,'C');   
			$this->SetMargins(2,1,1);	
			$this->SetXY(1,6); 
			$this->SetFont('Arial','B',11); $this->Cell(4,0.5,'NOMBRE DEL EXÁMEN ',0,0,'L'); 
			$this->SetFont('Arial','B',11); $this->Cell(0,0.5,'CANTIDAD',0,0,'R'); 
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
$pdf->SetFont('Arial','B',10);
$feci=$_POST["ocu_fi"];
$fecf=$_POST["ocu_ff"];
$feci=substr($feci,6,4).'-'.substr($feci,3,2).'-'.substr($feci,0,2).' 00:00:00';
$fecf=substr($fecf,6,4).'-'.substr($fecf,3,2).'-'.substr($fecf,0,2).' 23:59:59';
$res= new resultado('', '', '', '', '', '', '');
$ver=$res->ver_total_examenes($feci,$fecf);
$pdf->SetXY(1,7);
if ($ver!='false')
  { $cont=0;
    $totexa=0;
  	while($row = mysql_fetch_row($ver))
	{
		$cont++;		
		if ($cont=='19')
		{
			$cont=1;
			$alto=2;
		}
		else
			$alto=1;
		$totexa=$totexa+$row[0];
		$pdf->Ln();			
		$pdf->Cell(0,$alto,$row[1],0,0,'L',false); 
		$pdf->Cell(0,$alto,$row[0],0,0,'R',false); 

  	}
	$pdf->Ln();	
	$pdf->SetFont('Arial','B',11); $pdf->Cell(0,2,"TOTAL DE EXÁMENES: ".$totexa,0,0,'R',false); 
  }
$pdf->Output();
?>
