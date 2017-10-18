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
			$this->Image('imagenes/Logotipo.jpg',4,4,70);
			$this->SetFont('Arial','B',18);
			$this->SetXY(10,30); 
			$this->Cell(0,30,' ',0,0,'L',false); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			//Arial italic 8
			$this->SetFont('Arial','BI',8);
			//Número de página
			$this->Cell(0,0,'Página '.$this->PageNo().'/{nb}',0,0,'C');
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
			$pdf->Ln(4);	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,5,'EMPRESA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[12],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(20,5,'FECHA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[28],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',12); 	$pdf->Cell(0,5,'HISTORIA - ANTECEDENTES',0,0,'C',false);
		$pdf->Ln();$pdf->Ln();
		$cargAct=$reporte->cargo_act($rowdv[27]);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(60,6,'Cédula: '.$rowdv[0],1); 		$pdf->Cell(120,6,'Nombre: '.$rowdv[1],1);
		$pdf->Ln();
		$pdf->Cell(60,6,'Edad: '.$rowdv[9],1); 			$pdf->Cell(120,6,'Fecha de Nacimiento: '.$rowdv[25],1);
		$pdf->Ln();
		$pdf->Cell(60,6,'Sexo: '.$rowdv[7],1); 			$pdf->Cell(120,6,'Dirección: '.$rowdv[26],1);
		$pdf->Ln();
		$pdf->Cell(60,6,'Estado Civil: '.$rowdv[5],1); 	$pdf->Cell(120,6,'Teléfonos: '.$rowdv[2].'  '.$rowdv[3],1);
		$pdf->Ln();
		$pdf->Cell(60,6,'',1); 							$pdf->Cell(120,6,'Ocupación: '.$cargAct[1],1);
		
		$pdf->Ln();
		$pdf->Ln();
		
		$tipcona=0; $conda='';
		$resulta=$reporte->hist_ant($rowdv[27]);
		
		while ($rowha = mysql_fetch_row($resulta))
		{
		   	$bandct=false;
			if($tipcona!=$rowha[0])
			{
				//$pdf->Ln();
				if ($condimp!='' && $valorimp!='')
				{
					
					if(strlen($condimp)>26 || strlen($valorimp)>64)
					{
					  if(strlen($condimp)>26 && strlen($valorimp)<=64)
					  {
					  	$cantalto=6*(ceil(strlen($condimp)/26));
					    $pdf->SetFont('Arial','BI',10);
						$posaux=$pdf->GetY();
						$pdf->MultiCell(60,6,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						//$pdf->SetX(100);$pdf->SetY($posaux);
						$pdf->SetY($posaux);
						$pdf->SetX(70.00125);
						$pdf->Cell(120,$cantalto,$valorimp,1);
					  }
					  if(strlen($condimp)<=26 && strlen($valorimp)>64)
					  {
						$cantalto=6*(ceil(strlen($valorimp)/64));
					    $pdf->SetFont('Arial','BI',10);
						$pdf->Cell(60,$cantalto,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						$pdf->MultiCell(120,6,$valorimp,1);		
						$pdf->Ln(-6);  
					  }
					  if(strlen($condimp)>26 && strlen($valorimp)>64)
					  {
						$alcod=(ceil(strlen($condimp)/26));
						$alval=(ceil(strlen($valorimp)/64));
						$cav='  ';$cac='  ';
						if($alcod>$alval)
						{
						    //$alcod;
							$cnalval=($alcod*64) - strlen($valorimp);
							for($x=0;$x<=$cnalval;$x++)
							   $cav.=' ';
						}
						else
						{	
							//$alcod=$alval;
							$cnalcod=($alval*26)-strlen($condimp);
							for($x=0;$x<=$cnalcod;$x++)
							   $cac.=' ';
						}
						$pdf->SetFont('Arial','BI',10);
						$posaux=$pdf->GetY();
						$pdf->MultiCell(60,6,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						$pdf->SetY($posaux);
						$pdf->SetX(70.00125);
						$pdf->MultiCell(120,6,$valorimp,1);		
						$pdf->Ln(-6);  			  
					  }
					}
					else 
					{
						$cantalto=6;
						$pdf->SetFont('Arial','BI',10); 
						$pdf->Cell(60,$cantalto,$condimp,1); 
						$pdf->SetFont('Arial','',10); 
						$pdf->Cell(120,$cantalto,$valorimp,1);
					}

					$pdf->Ln(); 
				}
				$pdf->SetFont('Arial','BI',12); $pdf->Cell(180,6,$rowha[1],1,'C');
				$pdf->Ln();
				$tipcona=$rowha[0];
				$condimp='';
				$valorimp='';
				//$conda='';
				$bandct=true;
			}	

			if($conda!=$rowha[2])
			{
				if($conda=='')
				{  
					$condimp.=$rowha[3];
					$valorimp.=$rowha[5];
				}
				else
				{
					/*if($bandct==false)
						$pdf->Ln();*/
				if ($condimp!='' && $valorimp!='')
				{
					if(strlen($condimp)>26 || strlen($valorimp)>64)
					{
					  if(strlen($condimp)>26 && strlen($valorimp)<=64)
					  {
					  	$cantalto=6*(ceil(strlen($condimp)/26));
					    $pdf->SetFont('Arial','BI',10);
						$posaux=$pdf->GetY();
						$pdf->MultiCell(60,6,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						//$pdf->SetX(100);$pdf->SetY($posaux);
						$pdf->SetY($posaux);
						$pdf->SetX(70.00125);
						$pdf->Cell(120,$cantalto,$valorimp,1);
					  }
					  if(strlen($condimp)<=26 && strlen($valorimp)>64)
					  {
						$cantalto=6*(ceil(strlen($valorimp)/64));
					    $pdf->SetFont('Arial','BI',10);
						$pdf->Cell(60,$cantalto,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						$pdf->MultiCell(120,6,$valorimp,1);
						$pdf->Ln(-6);  					  
					  }
					  if(strlen($condimp)>26 && strlen($valorimp)>64)
					  {
						$alcod=(ceil(strlen($condimp)/26));
						$alval=(ceil(strlen($valorimp)/64));
						$cav='  ';$cac='  ';
						if($alcod>$alval)
						{
						    //$alcod;
							$cnalval=($alcod*64)-strlen($valorimp);
							for($x=0;$x<=$cnalval;$x++)
							   $cav.=' ';
						}
						else
						{	
							//$alcod=$alval;
							$cnalcod=($alval*26)-strlen($condimp);
							for($x=0;$x<=$cnalcod;$x++)
							   $cac.=' ';
						}
						$pdf->SetFont('Arial','BI',10);
						$posaux=$pdf->GetY();
						$pdf->MultiCell(60,6,$condimp,1);  
						$pdf->SetFont('Arial','',10); 
						$pdf->SetY($posaux);
						$pdf->SetX(70.00125);
						$pdf->MultiCell(120,6,$valorimp,1);		
						$pdf->Ln(-6);    
					  }
					}
					else 
					{
						$cantalto=6;
						$pdf->SetFont('Arial','BI',10); 
						$pdf->Cell(60,$cantalto,$condimp,1); 
						$pdf->SetFont('Arial','',10); 
						$pdf->Cell(120,$cantalto,$valorimp,1);
					}
					$pdf->Ln();
					
					$condimp='';
					$valorimp='';
					}
					$condimp.=$rowha[3];
					$valorimp.=$rowha[5];
				}
				$conda=$rowha[2];
			}
			else
			{
				$valorimp.=', '.$rowha[5];
			}	
		} // Fin del while
		
		$pdf->Ln();	
		
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,5,'AUTORIZACIÓN DEL TRABAJADOR',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10); $pdf->MultiCell(0,5,'Se hace constar que esta de acuerdo con los datos suministrados en esta historia clínica.',0,'J',false);
		$pdf->SetFont('Arial','',10); $pdf->MultiCell(0,5,'Se hace constar que esta de acuerdo con los exámenes de laboratorio indicados por la empresa correspondiente:',0,'J',false);
		$pdf->Ln();
		$pdf->SetX(85);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,30,'                                           ',1);
		$pdf->Ln(20);
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		$pdf->SetFont('Arial','BIU',10); $pdf->Cell(60,6,'                                           ',0,0,'C',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Firma del Trabajador ',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'                                           ',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Dr.(a): '.$rowdv[10],0,0,'C',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'C.I.: '.$rowdv[0],0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'Huella Pulgar Derecho',0,0,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(60,5,'ESPECIALIDAD MÉDICO',0,0,'C',false);

$pdf->Output();
?>
