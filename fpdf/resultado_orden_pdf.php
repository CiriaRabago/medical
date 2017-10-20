<?php  
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php"; 
include "clases/clase_examen.php";
include "clases/clase_resultado.php";
include "clases/clase_empleado.php";

class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			$this->SetFont('Arial','B',8);
			$ord= new orden($_POST['orden'],'','','','','','');
			$result= $ord->ver_orden();
			if ($result) 
			{ $row = mysql_fetch_row($result); }
			$pac=$ord->consul_pac_ID($row[4]);
			$datos=explode('/*',$pac); 
			if($datos[6]=='F')
			   $sexo='Femenino';
			 else
			   $sexo='Masculino';
			$this->Image('imagenes/LogoPDF2.jpg',1,1,19.5,0);
			if(file_exists('fotos/'.$row[4].'.jpg'))
			{
				$this->Image('fotos/'.$row[4].'.jpg',9,1.3,2.5,2);
			}
			$this->SetFont('Arial','B',8);
			if($datos[10]!='') $telf=$datos[10]; else $telf=$datos[9];
			$this->SetXY(12,0.8); $this->Cell(0,1,'ORDEN No.:  '.$_POST['orden'],0,0,'L',false); 
			$this->SetXY(12,1.1); $this->Cell(0,1,'FECHA:         '.$row[8],0,0,'L',false); 
			$this->SetXY(12,1.4); $this->Cell(0,1,'CEDULA:      '.$datos[11],0,0,'L',false); 
			$this->SetXY(12,1.7); $this->Cell(0,1,'NOMBRE:     '.$datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4],0,0,'L',false); 
			$this->SetXY(12,2.0); $this->Cell(0,1,'TELF:            '.$telf,0,0,'L',false); 
			$this->SetXY(12,2.3); $this->Cell(0,1,'EMPRESA: ',0,0,'L',false);
			$this->SetXY(13.7,2.7); $this->MultiCell(6.5,0.3,$datos[8],0,'J',false);
			//$this->Cell(7.5,1,'EMPRESA:    '.$datos[8],0,0,'L',false);
			$this->Ln(1); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-1);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Número de página
			//$this->Cell(0,0,'Página '.$this->PageNo().'/{nb}',0,0,'C');
		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','cm','Letter');
$pdf->AliasNbPages();

$canimpre=0;
if( $_POST['original'] && $_POST['copia']) $canimpre=2;
if( $_POST['original'] && !$_POST['copia']) $canimpre=1;
if( !$_POST['original'] && $_POST['copia']) $canimpre=1;
for($ci=0;$ci<$canimpre;$ci++)
{


$pdf->AddPage();
$pdf->SetY=$pdf->GetY()+0.5;

$ord= new orden($_POST['orden'],'','','','','','');
$result= $ord->ver_orden();
if ($result) 
{
	$num_exa=mysql_num_rows($result);
	if($num_exa>0)
	{
		$areaprov='';
		$area='';
		$canti_exa=0;
		$bioa='';
		$bioaux='';
		$exaact=0;
		$exaante=0;
		$cantexaimpre=0;
		while($row = mysql_fetch_row($result))
		{
			$exaact=$row[0];
			$canti_exa++;
			$pac=$ord->consul_pac_ID($row[4]);
			$datos=explode('/*',$pac); 
			
/*DESDE AQUI LO ANTERIOR*/			



/* ENCABEZADO DE EXAMEN */

			if( $canimpre==2 && (($ci==0 && $_POST['org'.$row[0]])  || ($ci==1 && $_POST['cop'.$row[0]]) )
			   || $canimpre==1 && ($_POST['org'.$row[0]] || $_POST['cop'.$row[0]])  )
			{ // abre el ciclo de que imprimir dependiendo de lo marcado
			
			$cantexaimpre++;
			$exa=new examen($row[0],'','','','','','','','');
			$datosexa=$exa->consul_examen();
			
			$caractexa=$exa->consul_caract_examen($row[0]);
			$n=mysql_num_rows($caractexa);
			
			$cuenta=0;
			if($n<=10)
			{ $cuenta=($n*0.4)+2.6; }
			else
			{$cuenta=($n*0.4)/2+2.6;}
			
			if($canti_exa==$num_exa)
			{
				$cuenta=$cuenta+1.6;
			}
			
			
			$cuentamax=0;
			if(($pdf->GetY()+$cuenta)>24.5)
			  $cuentamax=1;
			
			//if($cuentamax==1 || $bioa!=$bioaux) 
			
			$rr= new resultado('',$_POST['orden'],$row[0],'','','','');
			$inforesult=$rr->ver_resultado();
			if($inforesult!=false)
			  $idresulta=$inforesult[2];
			 
			if($cantexaimpre==2) 
				$bioaux=$cedbio;
			
			$cedbio=$inforesult[0];	
			if($cantexaimpre>=2)
				$bioa=$cedbio;
			
			if(($cuentamax==1 || $bioa!=$bioaux) &&  $exaante!=0)
			{ 
					$bio= new empleado('','','','','','','','','','','','','','','','','','','');
					$firma=$bio->datos_bioanalista($bioaux);
					$datfir=mysql_fetch_array($firma);
					$pdf->SetXY(15,$pdf->GetY());   
					$pdf->Cell(5,1,'__________________________________',0,0,'C',false);
					$pdf->SetFont('Arial','I',8);
					$pdf->SetXY(15,$pdf->GetY()+0.3); 
					//$pdf->Cell(5,1,'Lcda. '.$datfir[1].' '.$datfir[3].' ',0,0,'C',false);
					$pdf->SetXY(15,$pdf->GetY()+0.3);
					//$pdf->Cell(5,1,'Bioanalista',0,0,'C',false); 
					$pdf->SetXY(15,$pdf->GetY()+0.3); 
					//$pdf->Cell(5,1,'C.I.'.$datfir[0].' MPPS'.$datfir[5],0,0,'C',false); 
					$pdf->SetXY(15,$pdf->GetY()+0.3); 
					//$pdf->Cell(5,1,$datfir[6],0,0,'C',false);
					$pdf->Ln(1);
					$bioaux=$bioa;
			}
			
			if($cuentamax==1) 
			{
				$pdf->SetXY(1,25.5); 
				if($_POST['original'] && $ci==0) 
				   $pdf->Cell(19.5,0.4,'PACIENTE',0,0,'C',false);
				if( $canimpre==2 && ($_POST['copia'] && $ci==1) || $canimpre==1 && ($_POST['copia'] && $ci==0)) 
				   $pdf->Cell(19.5,0.4,'EMPRESA',0,0,'C',false);	
			   $pdf->AddPage();
			}
			/* ENCABEZADO DE AREA*/
			$area=$row[10];
			if($area!=$areaprov)
			{
			$yprov=$pdf->GetY()+0.1;
			$pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
			$pdf->SetFillColor(227,227,230);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetLineWidth(0.05);
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(1,$yprov);
			$pdf->MultiCell(19.5,0.5,'AREA: '.$row[10],'TB','L',true);
			if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
			
			$areaprov=$area;
			}
			/* FIN DEL ENCABEZADO DE AREA */
			
			
			if($n>1){
			//gris: 245,130,33
			//Gris claro: 227,227,230
			$yprov=$pdf->GetY();
			$pdf->SetDrawColor(255,255,255);//naranja (245,130,33)
			$pdf->SetFillColor(227,227,230);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetLineWidth(0.05);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->SetXY(1,$yprov);
			
			$ancho=9;
			if($_POST['muestra']=='') $ancho=$ancho+5;
			if($_POST['metodo']=='')  $ancho=$ancho+5.5;
			
			$pdf->MultiCell($ancho,0.5,$datosexa[0],'TB','L',true);
			$pdf->SetXY(10,$yprov); 
			if($_POST['muestra']!='') $muestra='MUESTRA: '.$datosexa[2]; else $muestra='';
			$pdf->MultiCell(5,0.5,$muestra,'TB','L',true);
			$pdf->SetXY(15,$yprov);
			if($_POST['metodo']!='')  $metodo='METODO: '.$datosexa[1]; else $metodo='';
			$pdf->MultiCell(5.5,0.5,$metodo,'TB','L',true);
			/* FIN DE ENCABEZADO DE EXAMEN */
			}
			
			/*CUERPO DEL EXAMEN*/
			if($n==1){ $pdf->SetY($pdf->GetY()-0.3); $pdf->SetFont('Arial','B',8.5); }
			else
			$pdf->SetFont('Arial','',8);
			
			$pdf->SetXY(1,$pdf->GetY()+1);
			
			
			
			if($canti_exa==$num_exa)
			{
				$bio= new empleado('','','','','','','','','','','','','','','','','','','');
				$firma=$bio->datos_bioanalista($cedbio);
				$datfir=mysql_fetch_array($firma);
			}
			
			$pdf->SetXY(1,$pdf->GetY()-0.6);

					$indi=0;
					$bandcol=1;
					while ($regi=mysql_fetch_array($caractexa))
					{ 
					  	
						$indi=$indi+1;
					 	if ($indi==1)
					  	{ $tipoaux=$regi[0];  }
					  	else
					  	{
							if($tipoaux!=$regi[0])
							{  	$band=1;
						  		$tipoaux=$regi[0];				
							}
							else 
						  		$band=0;
					  	}
					 	if($band==1)
					 	{ 		    
							if($n>10 && $bandcol==2) $pdf->SetXY(1,$pdf->GetY()+0.4);
							if($n>10 && $bandcol==2)
								$pdf->Image('imagenes/blanco.gif',1,$pdf->GetY()+0.4,19.5,0.05);
							else
							   $pdf->Image('imagenes/blanco.gif',1,$pdf->GetY(),19.5,0.05);
							$pdf->SetXY(1,$pdf->GetY()-0.3); // deberia ser normalmente +0.06
							//$pdf->SetFillColor(243,224,255);
							$pdf->MultiCell(19.5,0.4,'',0,'C',false);
							//$pdf->SetXY(1,$pdf->GetY()+0.4);
							if($bandcol==2) { $bandcol=1; $pdf->SetXY(1,$pdf->GetY()+0.4); }
							
					 	} 
						
						$resu= new resultado('',$_POST['orden'],'','','','','');
						
						$valo= $resu->consul_det_result($row[0],$regi[1]);
						if( ($valo[0]=='P') || ($valo[0]=='N') )
						{	if($valo[0]=='P') $valor='Positivo';
							if($valo[0]=='N') $valor='Negativo';	
						}
						else
						{
						   	$valores=$exa->consul_valores_caract3($regi[1],$valo[0]);
							if($valores=='')
							{
							   $valor=$valo[0];
							} // fin de si no consigue valores en una tabla
							else 
								$valor=$valores; 
						}//fin si no es un valor positivo o negativo
						
						$valoresref=$exa->consul_valores_ref($regi[1],$datos[6],calculaedad($datos[5]));
						$dato='';
						if($valoresref!=false)
						{
						  $dato.=$valoresref[1].'-'.$valoresref[2];
						}
						if($regi[4]!=' ') 
						{
						  $dato.=' ('.$regi[4].')';
						}				
						
						if($n<=10)
						{
							$pdf->SetY($pdf->GetY()-0.6);
							$pdf->SetXY(1,$pdf->GetY());
							$pdf->Cell(6,1,$regi[2],0,0,'L',false); 
							$pdf->SetXY(7,$pdf->GetY());
							$pdf->Cell(3,1,$valor,0,0,'L',false); 
							$pdf->SetXY(10,$pdf->GetY());
							$pdf->Cell(4,1,$dato,0,0,'L',false);
							$pdf->Ln(1);
						}
						else
						{
								if($bandcol==1)
								{
									$pdf->SetY($pdf->GetY()-0.6);
									$pdf->SetXY(1,$pdf->GetY());
									$pdf->Cell(0,1,$regi[2],0,0,'L',false); 
									$pdf->SetXY(6,$pdf->GetY());
									$pdf->Cell(0,1,$valor,0,0,'L',false); 
									$pdf->SetXY(7.5,$pdf->GetY());
									$pdf->Cell(0,1,$dato,0,0,'L',false);	
								}
								if($bandcol==2)
								{
									$pdf->SetXY(11,$pdf->GetY());
									$pdf->Cell(0,1,$regi[2],0,0,'L',false); 
									$pdf->SetXY(16,$pdf->GetY());
									$pdf->Cell(0,1,$valor,0,0,'L',false); 
									$pdf->SetXY(17.5,$pdf->GetY());
									$pdf->Cell(0,1,$dato,0,0,'L',false);
									$pdf->Ln(1);
									
								}
								if($bandcol==1) $bandcol=2; else $bandcol=1;
						}
						
					} // fin del while
					
					 if($bandcol==2) $pdf->SetXY(1,$pdf->GetY()+0.4);
					   else $pdf->SetXY(1,$pdf->GetY()); 
					   
					
					if($inforesult[1]!='')
					{
					$pdf->SetXY(1,$pdf->GetY()-0.3);
					if($bandcol==2 && $n>10)  $pdf->SetXY(1,$pdf->GetY()+0.7);
					$pdf->SetFont('Arial','B',8);
					$pdf->MultiCell(19.5,0.4,'    OBSERVACIÓN: '.$inforesult[1],0,'J');
					$pdf->SetXY(1,$pdf->GetY()+0.2); 
					}
					
					/* SI LA FIRMA ES POR CADA EXAMEN VA AQUI 

					$bioa=$inforesult[0];
					if($canti_exa==1) 
    					$bioaux=$inforesult[0];
		            if($bioa!=$bioaux)
					{
						$pdf->SetXY(15,$pdf->GetY());   
						$pdf->Cell(5,1,'__________________________________',0,0,'C',false);
						$pdf->SetFont('Arial','I',8);
						$pdf->SetXY(15,$pdf->GetY()+0.3); 
						$pdf->Cell(5,1,'Lcda. '.$datfir[1].' '.$datfir[3].' ',0,0,'C',false);
						$pdf->SetXY(15,$pdf->GetY()+0.3);
						$pdf->Cell(5,1,'Bioanalista',0,0,'C',false); 
						$pdf->SetXY(15,$pdf->GetY()+0.3); 
						$pdf->Cell(5,1,'C.I.'.$datfir[0].' MPPS'.$datfir[5],0,0,'C',false); 
						$pdf->SetXY(15,$pdf->GetY()+0.3); 
						$pdf->Cell(5,1,$datfir[6],0,0,'C',false); 
						$pdf->SetXY(15,$pdf->GetY()+0.4);
						$bioaux=$bioa;
					}
					// */

/*FIN DEL CUERPO DEL EXAMEN*/
           $exaante=$row[0];
		  } // Fin de si se imprime el examen
		  else
		  {
		    	$bio= new empleado('','','','','','','','','','','','','','','','','','','');
				$firma=$bio->datos_bioanalista($bioa);
				$datfir=mysql_fetch_array($firma);

		  }
/*HASTA AQUI LO ANTERIOR*/			
		} // Fin del while
		if($exaante!=0)
		{
			$pdf->SetXY(15,$pdf->GetY());   
			$pdf->Cell(5,1,'__________________________________',0,0,'C',false);
			$pdf->SetFont('Arial','I',8);
			$pdf->SetXY(15,$pdf->GetY()+0.3); 
			//$pdf->Cell(5,1,'Lcda. '.$datfir[1].' '.$datfir[3].' ',0,0,'C',false);
			$pdf->SetXY(15,$pdf->GetY()+0.3);
			//$pdf->Cell(5,1,'Bioanalista',0,0,'C',false); 
			$pdf->SetXY(15,$pdf->GetY()+0.3); 
			//$pdf->Cell(5,1,'C.I.'.$datfir[0].' MPPS'.$datfir[5],0,0,'C',false); 
			$pdf->SetXY(15,$pdf->GetY()+0.3); 
			//$pdf->Cell(5,1,$datfir[6],0,0,'C',false); 
		}
		//$pdf->SetXY(15,$pdf->GetY()+0.4); 
		$pdf->SetXY(1,25.5); 
		if($_POST['original'] && $ci==0) 
		   $pdf->Cell(19.5,0.4,'PACIENTE',0,0,'C',false);
		if( $canimpre==2 && ($_POST['copia'] && $ci==1) || $canimpre==1 && ($_POST['copia'] && $ci==0)) 
		   $pdf->Cell(19.5,0.4,'EMPRESA',0,0,'C',false);	  
	} //Fin si los resultados son mayor a 0
} // fin si hay resultados
} // Fin del for (2) Uno original para el cliente y copia para la empresa

$pdf->Output();
?>
