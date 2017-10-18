<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_solicitud.php"; 
include "clases/clase_formato.php"; 
include "clases/clase_visita.php";
include "clases/clase_referencia.php";

class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
		    $logo=$_GET['log'];
			if ($logo=='1')
			  {
			$this->Image('imagenes/Logotipo.jpg',4,4,38);}
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
			$this->Cell(0,0,'También somos Farmacia!! Edif. Don Vale planta baja local 04 "Farmacia El Santuario CA"',0,0,'C');
			$this->SetY(-7);
			//$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');

		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter'); //
$pdf->AliasNbPages();

$idvis=$_GET['vis'];
$critico=$_GET['crit'];
$reporte=new formato();//echo "visita ".$idvis;
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);
$visi= new visita($idvis,'','','','','','','','','','','','');

		$pdf->AddPage();
		$pdf->Ln();	$pdf->Ln();	
		if(file_exists('fotos/'.$rowdv[27].'.jpg'))
		{
			$pdf->Image('fotos/'.$rowdv[27].'.jpg',130,20,70,50);
		}
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'EMPRESA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,$rowdv[12],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'NOMBRE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(65,5,$rowdv[1],0,0,'L',false);
		//$pdf->Ln();		
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'CEDULA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(65,5,$rowdv[0],0,0,'L',false);
		//$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'TELÉFONOS: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(65,5,$rowdv[2].'  '.$rowdv[3],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'FECHA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(65,5,$rowdv[28],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(30,5,'EDAD: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(65,5,$rowdv[9],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(40,5,'TIPO DE CONSULTA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(40,5,$rowdv[15],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(40,5,'',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(120,5,'',0,0,'L',false);
		$pdf->Ln();
		//$pdf->Ln();$pdf->Ln();
		$pdf->SetFont('Arial','B',14); 	$pdf->Cell(0,5,'INFORME MÉDICO',0,0,'C',false);
		$pdf->Ln();$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'MOTIVO DE LA CONSULTA: ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,$rowdv[29],0,'L',false);
		$pdf->Ln(); $pdf->Ln();
		$peso=$reporte->signos_vitales($idvis,11);
		$ta=$reporte->signos_vitales($idvis,72);
		$tc=$reporte->signos_vitales($idvis,73);
		$fr=$reporte->signos_vitales($idvis,74);
		$talla=$reporte->signos_vitales($idvis,12);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(33,5,'EXAMEN FÍSICO: ',0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(13,5,'PESO: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(22,5,$peso,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'TALLA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(22,5,$talla,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(8,5,'TA: ',0,0,'',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(25,5,$ta,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(15,5,'PULSO: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(22,5,$tc,0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(8,5,'FR: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(22,5,$fr,0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,$rowdv[18].' '.$rowdv[30],0,'L',false);
		
		if ($critico=='1'){
		$pdf->Ln(); $pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'RESULTADOS LABORATORIO: ',0,0,'L',false);
		$pdf->Ln();
		$condHV=$visi->condicionesHVI("10",$idvis);
		$cont=0;
		if($condHV!=false)
		 {
			while($row5 = mysql_fetch_row($condHV))
			  { 			    
				if ($cont>3) {$pdf->Ln(); $cont=0;}
				if ($row5[5]!=""){
  			    $pdf->SetFont('Arial','',8); $pdf->Cell(50,5,$row5[1].':  '.$row5[5].'   ',0,0,'L',false);		  
				$cont+=1;}
			   }
		 }
		 $pdf->Ln(); $pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'RESULTADOS DE ESTUDIOS: ',0,0,'L',false);
		$pdf->Ln();
		$condHV=$visi->condicionesHVI("11",$idvis);
		$cont=0;
		if($condHV!=false)
		 {
			while($row5 = mysql_fetch_row($condHV))
			  { 			    
				if ($cont>3) {$pdf->Ln(); $cont=0;}
				if ($row5[5]!=""){
  			    $pdf->SetFont('Arial','',8); $pdf->Cell(50,5,$row5[1].':  '.$row5[5].'   ',0,0,'L',false);		  
				$cont+=1;}
			   }
		 }}	   
		$pdf->Ln(); $pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'IMPRESIÓN DIAGNÓSTICA: ',0,0,'L',false);
		$pdf->Ln();
		$dv=$reporte->diag_vis($idvis);
		while($rowdiag=mysql_fetch_row($dv))
		{
			$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,'  * '.$rowdiag[2].'. '.$rowdiag[3],0,'L',false);
		}
		
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'PLAN: ',0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,$rowdv[21],0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'REFERENCIAS: ',0,0,'L',false);
		$pdf->Ln();
		$ref= new referencia('','','','','','','','','','',''); 
					$lref=$ref->lista_esp_ref($idvis);
					if($lref!=false)
					{
						$contRef=0;
						while($row7 = mysql_fetch_row($lref))
						{
							$contRef++;
							$cqr='';
							$obr='';
							$espa='';
							if ($row7[5]>0)
							{ $cqr='checked';
							  if($row7[6]!=NULL) $obr=$row7[6];
							  $habil='';
								if($row7[0]=='R')
								{
								   $valor=$row7[2];
								}
								else
								{
								 $valor=$row7[1];
								} 	$pdf->Ln(1);
									$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,$row7[3].': '.$row7[6].'.',0,'L',false);
							}
						}
					}

		$pdf->Ln();
		if ($critico=='1'){
		}
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,5,$rowdv[23],0,'L',false);
		//$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,5,'Dr.(a): '.$rowdv[10],0,0,'R',false);
		/*if ($critico=='1'){
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(100,5,'RENOVAR INFORME MEDICO CADA 3 MESES',0,0,'R',false);
          }*/

	$sql="SELECT * FROM `servinet_sislabcli`.`slc_visita` where id_visita=$idvis";
	$resultado=mysql_query($sql);
	$DATOS=mysql_fetch_array($resultado);
	$sql2="SELECT * FROM `servinet_sislabcli`.`slc_medico` where ced_rif_medico='".$DATOS['ced_especialista']."'";
	$resultado2=mysql_query($sql2);
	$DATOS2=mysql_fetch_array($resultado2);
	$sql3="SELECT * FROM `servinet_sislabcli`.`slc_especialidad` where id_esp='".$DATOS2['id_esp']."'";
	$resultado3=mysql_query($sql3);
	$DATOS3=mysql_fetch_array($resultado3);
        $pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'EPECIALIDAD: '.$DATOS3['nomb_esp'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'MEDICO: '.$DATOS2['nomb_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'CEDULA: '.$DATOS['ced_especialista'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'MSDS: '.$DATOS2['mpps_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'TELEFONO: '.$DATOS2['telf1_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(50,5,'CORREO: '.$DATOS2['email_medico'],0,0,'L',false);
			if(file_exists('firm/'.$DATOS['ced_especialista'].'.jpg'))
		{
			$pdf->Image('firm/'.$DATOS['ced_especialista'].'.jpg',150,210,45,37);
		}

$pdf->Output();
?>
