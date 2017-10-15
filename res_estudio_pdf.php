<?php 
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_solicitud.php"; 
include "clases/clase_formato.php"; 
include "clases/clase_res_estudio.php";

class PDF extends FPDF
{/*
		//Cabecera de página
		function Header()
		{
		   $logo=$_GET['log'];
			if ($logo=='1')
			  {$this->Image('imagenes/Logotipo.gif',1,0.4,6);}
			$this->SetFont('Arial','B',18);
			//$this->SetX(5);
			
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-2);
			//Arial italic 8
			$this->SetFont('Arial','BI',8);
		}
*/} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('L','cm','mcarta');
$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$idvis=$_GET['vis'];
$reporte=new formato();
$dbv=$reporte->datos_bas_vis($idvis);
$rowdv=mysql_fetch_row($dbv);
$ref= new solicitud('','','','','','','','','','',''); 
$lref=$ref->lista_sol($idvis);
$n=mysql_num_rows($lref);
$r_estu= new res_estudio('',$idvis,'');
$bus_r_e=$r_estu->cons_res_estudio2($idvis);


		$pdf->AddPage();
		$pdf->Image('imagenes/Logotipo.gif',1,0.4,3.5);
		$pdf->SetY(3);
		$pdf->SetFont('Arial','BI',14); $pdf->Cell(0,0.5,'RESULTADOS DE ESTUDIO ',0,1,'C',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(2,0.5,'FECHA: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(9,0.5,$rowdv[28],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(2,0.5,'NOMBRE: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(9,0.5,$rowdv[1],0,0,'L',false);
		$pdf->Ln();	
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1,0.5,'C.I: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(2.5,0.5,$rowdv[0],0,0,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(1.5,0.5,'EDAD: ',0,0,'L',false);
		$pdf->SetFont('Arial','',10); 	$pdf->Cell(1,0.5,$rowdv[9],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'EMPRESA: '.$rowdv[12],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'MOTIVO DE LA CONSULTA: '.$rowdv[29],0,1,'L',false);
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'RESULTADOS DE ESTUDIO ',0,1,'L',false);
		$pdf->SetX(1);
		$pdf->SetFont('Arial','',10); 	$pdf->MultiCell(0,0.5,$bus_r_e,0,'J',false);

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
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'EPECIALIDAD: '.$DATOS3['nomb_esp'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'MEDICO: '.$DATOS2['nomb_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'CEDULA: '.$DATOS['ced_especialista'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'MSDS: '.$DATOS2['mpps_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'TELEFONO: '.$DATOS2['telf1_medico'],0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'CORREO: '.$DATOS2['email_medico'],0,0,'L',false);
		$pdf->Ln();
		
$pdf->Output();
?>
