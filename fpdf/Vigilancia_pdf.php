<?php  
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_visita.php";
include "clases/clase_paciente.php";

require_once("fpdf/fpdf.php");
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_pie.php');
require_once ("jpgraph/jpgraph_pie3d.php");
require_once("jpgraph/jpgraph_line.php");

$val=$_GET['empre'];
$vala=$_GET['anio'];
$valm=$_GET['mes'];

$vis= new visita('','','','','','','','','','','','','');

$vige=$vis->inf_empresa_pdf($val,$vala,$valm);
$mes=$vige[1];
if($valm==$vala)
		     $fema='DEL MES DE '.$vis->nombre_mes(substr($vala,4,2)).' DEL AÑO '.substr($vala,0,4);
	else		    
		     $fema=' DE LOS MESES DESDE '.$vis->nombre_mes(substr($vala,4,2)).'-'.substr($vala,0,4).' HASTA '.$vis->nombre_mes(substr($valm,4,2)).'-'.substr($valm,0,4);
			
class Reporte extends FPDF
{
  	public function __construct($orientation='P', $unit='mm', $format='letter')
  	{
   	parent::__construct($orientation, $unit, $format);
 	} 

 		function Header()
		{
			$visi= new visita('','','','','','','','','','','','','');
			$vigei=$visi->inf_empresa_pdf($_GET['empre'],$_GET['anio'],$_GET['mes']);
			$this->Image('imagenes/Logotipo.jpg',4,4,70);
			$this->SetFont('Arial','B',12);
			$this->SetY(30);
			$this->Cell(0,5,$vigei[0],0,0,'R',false); 
			$this->Ln();
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

 
public function gaficoPDF($data = array(),$nombres = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL)
 { 
   $x = $ubicacionTamamo[0];
   $y = $ubicacionTamamo[1]; 
   $ancho = $ubicacionTamamo[2];  
   $altura = $ubicacionTamamo[3];  
   #Creamos un grafico vacio
   $graph = new PieGraph(600,400);
   
   #indicamos titulo del grafico si lo indicamos como parametro
$graph->img->SetMargin(40,20,20,40);
    $graph->title->Set($titulo);
	$graph->title->SetFont(FF_ARIAL,FS_BOLD,13);

   //Creamos el plot de tipo tarta
   $p1 = new PiePlot3D($data);
   $p1->SetSize(0.3); 
   $p1->SetCenter(0.5); 
   $p1->SetEdge('black',2);
   //$p1->SetSliceColors($color);
   #indicamos la leyenda para cada porcion de la tarta
   $p1->SetLegends($nombres);
   $p1->ExplodeAll(); ///SEPARA LOS TROZOS DE LA TORTA

   //Añadirmos el plot al grafico
   $graph->Add($p1);
   //mostramos el grafico en pantalla
   @unlink("$nombreGrafico.png");
   $graph->Stroke("$nombreGrafico.png"); 
   $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);  
   }
}



$pdf=new Reporte();//creamos el documento pdf
$pdf->SetMargins(20,40,20);
$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","",12);//establecemos propiedades del texto tipo de letra, negrita, tamaño
$pdf->Ln();
$hoy=getdate();
$pdf->Cell(0,5,'San Cristóbal, 1 de '.$vis->nombre_mes($hoy[mon]).' de '.substr($vala,0,4),0,1,'R');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5,'Señores:',0,1,'L');
$pdf->SetFont("Arial","B",12);
$pdf->Cell(0,5,$vige[0],0,1,'L');
$pdf->SetFont("Arial","",12);
$pdf->Cell(0,5,'Presente.- ',0,1,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial","B",12);
$pdf->Cell(0,5,'Atención',0,1,'R');
$pdf->Cell(0,5,'Comité de Seguridad y Salud Laboral',0,1,'R');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial","",12);
$pdf->MultiCell(0,5,'     Por medio de la presente doy entrega del informe de Vigilancia Epidemiológica de la empresa, correspondiente '.$fema.'.',0,'J');
$pdf->Ln();
$pdf->Ln();
$pdf->MultiCell(0,5,'     Sin otro particular, esperando contribuir con el mejor funcionamiento de su empresa.',0,'J');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->MultiCell(0,5,'     Atentamente,',0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->MultiCell(0,5,'Dra. Militza Ramírez S.',0,'C');
$pdf->MultiCell(0,5,'Gerente General',0,'C');

/*************************/
$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","B",12);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0,5,'EMPRESA:',0,1,'L');
$pdf->SetFont("Arial","",12);
$pdf->Cell(0,5,$vige[0],0,1,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial","B",12);
$pdf->Cell(0,5,'CONTENIDO:',0,1,'L');
$pdf->SetFont("Arial","",12);
$pdf->Cell(0,5,'VIGILANCIA EPIDEMIOLÓGICA',0,1,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial","B",12);
$pdf->Cell(0,5,'LAPSO:',0,1,'L');
$pdf->SetFont("Arial","",12);
$pdf->Cell(0,5,$vige[1],0,1,'L');
$pdf->Cell(0,5,$fema,0,1,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial","B",12);
$pdf->Cell(0,5,'REALIZADO POR:',0,1,'L');
$pdf->SetFont("Arial","",12);
$pdf->Cell(0,5,'DRA. MILITZA RAMIREZ S.',0,1,'L');
$pdf->Cell(0,5,'Médico de Familia - Medicina Ocupacional',0,1,'L');
$pdf->Cell(0,5,'CM 2573 MSDS 4612°',0,1,'L');
$pdf->Cell(0,5,'INPSASEL No. Temporal  TAC079230104',0,1,'L');

/****  ACCIDENTES Y ENFERMEDADES *****/

$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,10,'ACCIDENTES COMUNES, ACCIDENTES DE TRABAJO, ENFERMEDADES COMUNES Y ENFERMEDADES OCUPACIONALES',0,'C');
$pdf->Ln();
$vig_ae=$vis->enfermedades_accidentes_pdf($val,$vala,$valm);
$pdf->SetFont("Arial","B",10);
$pos=$pdf->GetY();
$pdf->MultiCell(35,10,'    PERIODO                       ',1,'C');
$pdf->SetY($pos);
$pdf->SetX(55);
$pdf->MultiCell(32,10,'ACCIDENTES COMUNES',1,'C');
$pdf->SetY($pos);
$pdf->SetX(87);
$pdf->MultiCell(32,10,'ACCIDENTES DE TRABAJO',1,'C');
$pdf->SetY($pos);
$pdf->SetX(119);
$pdf->MultiCell(32,10,'ENFERMEDADES COMUNES',1,'C');
$pdf->SetY($pos);
$pdf->SetX(151);
$pdf->MultiCell(45,10,'ENFERMEDADES OCUPACIONALES',1,'C');
$pdf->SetFont("Arial","",11);
if(substr($vala,0,4)!=substr($valm,0,4))
	  {$mini=substr($vala,4,2);
	   $m=12;}
	 else
	   {$mini=substr($vala,4,2);
	    $m=substr($valm,4,2);}
	$mes=substr($vala,4,2)-1;	   
	$ano=substr($vala,0,4);
for($i=$mini;$i<=$m;$i++)
{
$mes++;
		if($mes>12)
		  if(substr($vala,0,4)<=substr($valm,0,4))
		     {$mes=1;
			 $ano++;}
			 
		if(strlen($mes)==1) $mes='0'.$mes;
		
	   $cond=" and fecha_ing_visita>='".$ano."-".$mes."-01 00:00:00' and fecha_ing_visita<='".$ano."-".$mes."-31 24:00:00' ";	   
	$pdf->Cell(35,8,$vig_ae[$i][4],1,0,'C');
	$pdf->Cell(32,8,$vig_ae[$i][0],1,0,'C');
	$pdf->Cell(32,8,$vig_ae[$i][1],1,0,'C');
	$pdf->Cell(32,8,$vig_ae[$i][2],1,0,'C');
	$pdf->Cell(45,8,$vig_ae[$i][3],1,1,'C');
}

$i++;
$pdf->Ln();
//$pdf->MultiCell(0,5,'COMENTARIO: SE EVIDENCIA QUE EN EL MES DE DICIEMBRE ASISTIERON '.$vig_ae[$i][1].' PACIENTE(S) DE LOS CUAL(ES) '.$vig_ae[$i][0].' ESTÁN SANO(S) Y '.$vig_ae[$i][3].' ENFERMEDAD(ES) COMUN(ES) EN '.$vig_ae[$i][2].' TRABAJADORES, ES IMPORTANTE RESALTAR QUE LAS ENFERMEDADES COMUNES SE PUEDEN REPORTAR VARIAS EN UN MISMO PACIENTE.',0,'J');
$pdf->MultiCell(0,5,$_GET["c1"],0,'J');
$enfcom=$vig_ae[$i][3];
$totalp=$vig_ae[$i][1];
$totcom=$vig_ae[$i][2];
/****  RESULTADOS DE LOS EXÁMENES *****/
$pdf->AddPage();//agregamos la pagina
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'RESULTADO DE LOS ÉXAMEN DE SALUD PRACTICADOS ',0,'C');
$pdf->Ln();
$vig_rex=$vis->resultado_examenes_pdf($val,$vala,$valm);
$pdf->SetFont("Arial","B",10);
$pdf->Cell(8,8,'N°',1,0,'C');
$pdf->Cell(20,8,'FECHA',1,0,'C');
$pdf->Cell(65,8,'NOMBRE',1,0,'C');
$pdf->Cell(18,8,'C.I.',1,0,'C');
//$pdf->Cell(35,8,'CARGO',1,0,'C');
$pdf->Cell(30,8,'CONSULTA',1,0,'C');
$pdf->Cell(35,8,'RESULTADO',1,1,'C');

$pdf->SetFont("Arial","",10);
for($i=1;$i<=count($vig_rex);$i++)
{
	$pos=$pdf->GetY();
	if (strlen($vig_rex[$i][2])>30)
	{	
		$alto=10;
	}
	else
		$alto=5;
	
	$pdf->Cell(8,$alto,$vig_rex[$i][0],1,0,'C');
	$pdf->Cell(20,$alto,$vig_rex[$i][1],1,0,'C');
	
	if($alto==10 && strlen($vig_rex[$i][2])>30)
	{

		$pdf->MultiCell(65,5,$vig_rex[$i][2],1,'C');
		$pdf->SetY($pos);
		$pdf->SetX(113);
	}
	else
		$pdf->Cell(65,$alto,$vig_rex[$i][2],1,0,'C');
	$pdf->Cell(18,$alto,$vig_rex[$i][3],1,0,'C');
	/*if($alto==10 && strlen($vig_rex[$i][4])>15)
	{		
		$pdf->MultiCell(35,5,$vig_rex[$i][4],1,'C');
		$pdf->SetY($pos);
		$pdf->SetX(141);
	}
	else
		$pdf->Cell(35,$alto,$vig_rex[$i][4],1,0,'C');*/
	$pdf->Cell(30,$alto,$vig_rex[$i][5],1,0,'C');
	/*if($alto==10 && strlen($vig_rex[$i][6])>15)		
	{
		$pdf->MultiCell(25,5,$vig_rex[$i][6],1,'C');
	}
	else*/
	$pdf->Cell(35,$alto,$vig_rex[$i][6],1,1,'C');
	$pdf->SetY($pos+$alto);
if(($pdf->GetY()+(count($vig_r)*5)+20)>=250)
	$pdf->AddPage();//agregamos la pagina

}
$i++;
$pdf->Ln();
//$pdf->MultiCell(0,5,'EL COMITÉ DE HIGIENE Y SEGURIDAD DE LA EMPRESA DEBE REALIZAR SEGUIMIENTO DE LOS NO APTOS Y APTOS CON LIMITACIÓN, DE MANERA DE DISMINUIR LAS POSIBLES ENFERMEDADES COMUNES Y OCUPACIONALES.',0,'J');
$pdf->MultiCell(0,5,$_GET["c2"],0,'J');
/****  REFERENCIAS VISITAS *****/
$vig_r=$vis->referencias_visitas_pdf($val,$vala,$valm);
if(($pdf->GetY()+(count($vig_r)*5)+20)>=250)
	$pdf->AddPage();//agregamos la pagina
$pdf->Ln();
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'REFERENCIAS A OTROS MÉDICOS',0,'C');
$pdf->Ln();

$pdf->SetFont("Arial","B",10);
$pdf->Cell(8,8,'N°',1,0,'C');
$pdf->Cell(20,8,'FECHA',1,0,'C');
$pdf->Cell(65,8,'NOMBRE',1,0,'C');
$pdf->Cell(18,8,'C.I.',1,0,'C');
//$pdf->Cell(25,8,'CARGO',1,0,'C');
$pdf->Cell(30,8,'CONSULTA',1,0,'C');
$pdf->Cell(35,8,'REFERENCIA',1,1,'C');
$pdf->SetFont("Arial","",10);
for($i=1;$i<=count($vig_r);$i++)
{
		$pos=$pdf->GetY();
//	if (strlen($vig_r[$i][2])>30 || strlen($vig_r[$i][6])>15)
//	{	
//		$alto=10;
//	}
//	else
		$alto=5;
	$pdf->Cell(8,$alto,$vig_r[$i][0],1,0,'C');
	$pdf->Cell(20,$alto,$vig_r[$i][1],1,0,'C');
	/////

	if($alto==10 && strlen($vig_r[$i][2])>30)
	{

		$pdf->MultiCell(65,5,$vig_r[$i][2],1,'C');
		$pdf->SetY($pos);
		$pdf->SetX(113);
	}
	else
		$pdf->Cell(65,$alto,$vig_r[$i][2],1,0,'C');
	///////////	
	$pdf->Cell(18,$alto,$vig_r[$i][3],1,0,'C');
	$pdf->Cell(30,$alto,$vig_r[$i][5],1,0,'C');
$pdf->SetFont("Arial","",8);
	if($alto==10 && strlen($vig_r[$i][6])>15)
	{
		$pdf->MultiCell(35,5,$vig_r[$i][6],1,'C');
		$pdf->SetY($pos);
		$pdf->SetX(161);
	}
	else
	$pdf->Cell(35,$alto,substr($vig_r[$i][6],0,20),1,1,'C');
$pdf->SetFont("Arial","",10);
}
$i++;
$pdf->Ln();
$pdf->Ln();
//$pdf->MultiCell(0,5,'EL COMITÉ DE HIGIENE Y SEGURIDAD DE LA EMPRESA DEBE REALIZAR SEGUIMIENTO DE LAS REFERENCIAS MÉDICAS PARA ASEGURAR QUE SEAN CUMPLIDAS.',0,'J');
$pdf->MultiCell(0,5,$_GET["c3"],0,'J');

/****  REPOSOS VISITAS *****/
$vig_rp=$vis->reposos_visitas_pdf($val,$vala,$valm);
if(($pdf->GetY()+(count($vig_rp)*5)+10)>=250)
	$pdf->AddPage();//agregamos la pagina
$pdf->Ln();
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'REPOSOS',0,'C');
$pdf->Ln();

$pdf->SetFont("Arial","B",10);
$pdf->Cell(8,8,'N°',1,0,'C');
$pdf->Cell(20,8,'FECHA',1,0,'C');
$pdf->Cell(65,8,'NOMBRE',1,0,'C');
$pdf->Cell(18,8,'C.I.',1,0,'C');
//$pdf->Cell(25,8,'CARGO',1,0,'C');
$pdf->Cell(30,8,'CHEQUEO',1,0,'C');
$pdf->Cell(35,8,'REPOSO',1,1,'C');
$pdf->SetFont("Arial","",10);
for($i=1;$i<=count($vig_rp);$i++)
{
	$pdf->Cell(8,5,$vig_rp[$i][0],1,0,'C');
	$pdf->Cell(20,5,$vig_rp[$i][1],1,0,'C');
	$pdf->Cell(65,5,$vig_rp[$i][2],1,0,'C');
	$pdf->Cell(18,5,$vig_rp[$i][3],1,0,'C');
	//$pdf->Cell(25,5,$vig_rp[$i][4],1,0,'C');
	$pdf->Cell(30,5,$vig_rp[$i][5],1,0,'C');
	$pdf->SetFont("Arial","",8);
	$pdf->Cell(35,5,substr($vig_rp[$i][6],0,20),1,1,'C');
    $pdf->SetFont("Arial","",10);
}
/*___________________________________________*/

/****  GRUPO ETARIO *****/
$pdf->AddPage();//agregamos la pagina
$vig_ge=$vis->grupo_etario_pdf($val,$vala,$valm,$totalp);
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'TABLA: CARACTERÍSTICAS GENERALES '.$fema,0,'C');
$pdf->Ln();
for($i=0;$i<count($vig_ge);$i++)
{
	if($i==0)
	{	$pdf->SetFont("Arial","B",10); 
	 	//$totalp=$vig_ge[$i][1];
	} else $pdf->SetFont("Arial","",10);
	$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_ge[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_ge[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_ge[$i][2],1,1,'C',$color);
}
/****  GRUPO SEXO *****/
$vig_sx=$vis->grupo_sexo_pdf($val,$vala,$valm,$totalp);
for($i=0;$i<count($vig_sx);$i++)
{
	if($i==0) $pdf->SetFont("Arial","B",10); else $pdf->SetFont("Arial","",10);
	$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_sx[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_sx[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_sx[$i][2],1,1,'C',$color);
}

/****  GRUPO GRADO *****/
$vig_gi=$vis->grupo_grado_pdf($val,$vala,$valm,$totalp);
for($i=0;$i<count($vig_gi);$i++)
{
	if($i==0) $pdf->SetFont("Arial","B",10); else $pdf->SetFont("Arial","",10);
		$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_gi[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_gi[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_gi[$i][2],1,1,'C',$color);
}
/****  GRUPO ENFERMEDADES COMUNES *****/
$vig_ec=$vis->grupo_enfcomunes_pdf($val,$vala,$valm,$totcom);
for($i=0;$i<count($vig_ec);$i++)
{
	if($i==0) $pdf->SetFont("Arial","B",10); else $pdf->SetFont("Arial","",10);
			$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_ec[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_ec[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_ec[$i][2],1,1,'C',$color);
}

/****  GRUPO MOTIVO DE VISITA *****/

$vig_mot=$vis->grupo_motivo_pdf($val,$vala,$valm,$totalp);
if(($pdf->GetY()+(count($vig_mot)*5))>=250)
	$pdf->AddPage();//agregamos la pagina
for($i=0;$i<count($vig_mot);$i++)
{
	if($i==0) $pdf->SetFont("Arial","B",10); else $pdf->SetFont("Arial","",10);
			$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_mot[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_mot[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_mot[$i][2],1,1,'C',$color);
}
/****  GRUPO RESULTADO DE LA VISITA *****/
$vig_result=$vis->grupo_result_pdf($val,$vala,$valm,$totalp);
if(($pdf->GetY()+(count($vig_result)*5))>=250)
	$pdf->AddPage();//agregamos la pagina
for($i=0;$i<count($vig_result);$i++)
{
	if($i==0) $pdf->SetFont("Arial","B",10); else $pdf->SetFont("Arial","",10);
			$pdf->SetFillColor(221,221,221);
	if($i==0)
		$color='true'; else $color='';
	$pdf->Cell(88,5,$vig_result[$i][0],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_result[$i][1],1,0,'C',$color);
	$pdf->Cell(40,5,$vig_result[$i][2],1,1,'C',$color);
}

/****  PATOLOGÍAS *****/
$vig_patolog=$vis->patologias_pdf($val,$vala,$valm,$totalp,$enfcom);
if(($pdf->GetY()+30)>=250)
	$pdf->AddPage();//agregamos la pagina
$pdf->Ln();
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'PATOLOGÍAS SUSCEPTIBLES DE NOTIFICACIÓN EN INPSASEL',0,'C');
$pdf->Ln();
$pdf->MultiCell(0,5,'Posibles enfermedades ocupacionales en estudio',0,'L');
$pdf->Ln();
$pdf->SetFont("Arial","B",10);
$pdf->Cell(88,5,'ENFERMEDADES',1,0,'C');
$pdf->Cell(40,5,'CANTIDAD',1,0,'C');
$pdf->Cell(40,5,'%',1,1,'C');
$pdf->Cell(88,5,$vig_patolog[0],1,0,'C');
$pdf->Cell(40,5,$vig_patolog[1],1,0,'C');
$pdf->Cell(40,5,$vig_patolog[2],1,1,'C');

/*___________________________________________*/
/****  PATOLOGÍAS SUSCEPTIBLES DE CERTIFICACIÓN DE DISCAPACIDAD *****/
$vig_relenfdis=$vis->relacion_enf_dis_pdf($val,$vala,$valm,$totalp);
if(($pdf->GetY()+(count($vig_relenfdis)*5)+20)>=250)
	$pdf->AddPage();//agregamos la pagina
$pdf->Ln();
$pdf->SetFont("Arial","B",11);
$pdf->MultiCell(0,5,'PATOLOGÍAS SUSCEPTIBLES DE CERTIFICACIÓN DE LA CONDICIÓN DE LA PERSONA CON DISCAPACIDAD',0,'C');
$pdf->Ln();
$pdf->MultiCell(0,5,'Relación de la Enfermedad y la Discapacidad',0,'L');
$pdf->Ln();
$pdf->SetFont("Arial","B",10);
$pdf->Cell(40,8,'NOMBRE',1,0,'C');
$pdf->Cell(80,8,'C.I.',1,0,'C');
$pdf->Cell(40,8,'CARGO',1,1,'C');
$pdf->SetFont("Arial","",10);

for($i=1;$i<=count($vig_relenfdis);$i++)
{
	$pos=$pdf->GetY();
	if (strlen($vig_relenfdis[$i][0])>17)
	{	
		$alto=10;
	}
	else
		$alto=5;
	/////

	if($alto==10 && strlen($vig_relenfdis[$i][0])>17)
	{

		$pdf->MultiCell(40,5,$vig_relenfdis[$i][0],1,'C');
		$pdf->SetY($pos);
		$pdf->SetX(60);
	}
	else
		$pdf->Cell(40,$alto,$vig_relenfdis[$i][0],1,0,'C');
	$pax=new paciente($vig_relenfdis[$i][1],'','','','','','','','','','','','','','');	
	$cargo=$pax->buscar();
	$dat=explode('**',$cargo);
	$pdf->Cell(80,$alto,$vig_relenfdis[$i][1],1,0,'C');
	$pdf->Cell(40,$alto,$dat[14],1,1,'C');
}
$pdf->Ln();
//$pdf->MultiCell(0,5,'PATOLOGÍAS AMERITAN SER INVESTIGADAS Y NOTIFICADAS AL CONSEJO NACIONAL PARA PERSONAS CON DISCAPACIDAD.',0,'J');
$pdf->MultiCell(0,5,$_GET["c4"],0,'J');
$pdf->AddPage();//agregamos la pagina
///GRAFICAS////////////
$pdf->SetFont("Arial","B",14);
$pdf->Cell(0,6,'RESUMEN  '.$fema,1,1,'C');

$nomgra1='GRUPO ETARIO';
$nomgra2='GRUPO POR SEXO';
$nomgra3='GRUPO POR GRADO DE INSTRUCCIÓN';
$nomgra4='GRUPO POR ENFERMEDADES COMUNES';
$pdf->SetFont("Arial","B",8);
//********* aca tambiensuspendi carlos dugarte
/*if (count($vig_ec)>2)
{for($i=1;$i<count($vig_ec);$i++)
{
	$nom[$i]=$vig_ec[$i][0];
	$can[$i-1]=$vig_ec[$i][1];
}$pdf->gaficoPDF($can,$nom,'Grafico4',array(100,105,90,60),$nomgra4);}
else
{
	$pdf->SetXY(160,125);
	$pdf->Cell(10,8,'NO SE PRESENTARON ENFERMEDADES',0,1,'C');
	$pdf->SetXY(160,135);
	$pdf->Cell(10,8,'COMUNES EN ESTE MES',0,1,'C');
}*/
$nomgra5='MOTIVO DE CONSULTA';
$nomgra6='RESULTADO DE LA CONSULTA';
$sum=0;
for($i=1;$i<count($vig_ge);$i++)
	$sum=$sum+$vig_ge[$i][1];
if ($sum==0)
{
	$pdf->SetXY(60,75);
	$pdf->Cell(10,8,'NO SE REGISTRÓ LA EDAD',0,1,'C');
	$pdf->SetXY(60,80);
	$pdf->Cell(10,8,'DE LOS PACIENTES QUE VINIERON',0,1,'C');
	$pdf->SetXY(60,85);
	$pdf->Cell(10,8,'A CONSULTA ESTE MES',0,1,'C');
}	
else
	$pdf->gaficoPDF(array($vig_ge[1][1],$vig_ge[2][1],$vig_ge[3][1],$vig_ge[4][1],$vig_ge[5][1]),array($vig_ge[1][0],$vig_ge[2][0],$vig_ge[3][0],$vig_ge[4][0],$vig_ge[5][0]),'Grafico1',array(5,50,100,55),$nomgra1);
$sum=0;
for($i=1;$i<count($vig_sx);$i++)
	$sum=$sum+$vig_sx[$i][1];
if ($sum==0)
{
	$pdf->SetXY(160,75);
	$pdf->Cell(10,8,'NO SE REGISTRÓ EL SEXO',0,1,'C');
	$pdf->SetXY(160,80);
	$pdf->Cell(10,8,'DE LOS PACIENTES QUE VINIERON',0,1,'C');
	$pdf->SetXY(160,85);
	$pdf->Cell(10,8,'A CONSULTA ESTE MES',0,1,'C');
}	
else
	$pdf->gaficoPDF(array($vig_sx[1][1],$vig_sx[2][1]),array($vig_sx[1][0],$vig_sx[2][0]),'Grafico2',array(100,50,100,55),$nomgra2);
$sum=0;

//*******desde aca suspendido por carlos dugarte**************
/*
for($i=1;$i<count($vig_gi);$i++)
	$sum=$sum+$vig_gi[$i][1];
if ($sum==0)
{
	$pdf->SetXY(60,125);
	$pdf->Cell(10,8,'NO SE REGISTRARON LOS GRADOS',0,1,'C');
	$pdf->SetXY(60,130);
	$pdf->Cell(10,8,'DE INSTRUCCIÓN DE LOS PACIENTES',0,1,'C');
	$pdf->SetXY(60,135);
	$pdf->Cell(10,8,'QUE VINIERON A CONSULTA ESTE MES',0,1,'C');
}	
else
	$pdf->gaficoPDF(array($vig_gi[1][1],$vig_gi[2][1],$vig_gi[3][1],$vig_gi[4][1],$vig_gi[5][1],$vig_gi[6][1]),array($vig_gi[1][0],$vig_gi[2][0],$vig_gi[3][0],$vig_gi[4][0],$vig_gi[5][0],$vig_gi[6][0]),'Grafico3',array(5,105,90,55),$nomgra3);
$sum=0;
for($i=1;$i<count($vig_mot);$i++)
	$sum=$sum+$vig_mot[$i][1];
if ($sum==0)
{
	$pdf->SetXY(60,190);
	$pdf->Cell(10,8,'NO SE REGISTRARON MOTIVOS',0,1,'C');
	$pdf->SetXY(60,200);
	$pdf->Cell(10,8,'DE LAS CONSULTA EN ESTE MES',0,1,'C');
}	
else
	$pdf->gaficoPDF(array($vig_mot[1][1],$vig_mot[2][1],$vig_mot[3][1],$vig_mot[4][1],$vig_mot[5][1],$vig_mot[6][1]),array($vig_mot[1][0],$vig_mot[2][0],$vig_mot[3][0],$vig_mot[4][0],$vig_mot[5][0],$vig_mot[6][0]),'Grafico5',array(5,165,100,55),$nomgra5);

$sum=0;
for($i=1;$i<count($vig_result);$i++)
	$sum=$sum+$vig_result[$i][1];
if ($sum==0)
{
	$pdf->SetXY(160,190);
	$pdf->Cell(10,8,'NO SE REGISTRARON RESULTADOS',0,1,'C');
	$pdf->SetXY(160,200);
	$pdf->Cell(10,8,'DE LAS CONSULTA EN ESTE MES',0,1,'C');
}	
else
	$pdf->gaficoPDF(array($vig_result[1][1],$vig_result[2][1],$vig_result[3][1]),array($vig_result[1][0],$vig_result[2][0],$vig_result[3][0]),'Grafico6',array(100,165,100,55),$nomgra6);

//////////////////////ULTIMO GRAFICO////////////////////////////
//$pdf->AddPage();//agregamos la pagina
//$pdf->SetXY(120,220);
$vig_ae=$vis->enfermedades_accidentes_pdf($val,$vala,$valm);
//for($i=0;$i<$valm;$i++)
//{
$f1=substr($vala,0,4).'-'.substr($vala,4,2);
$f2=substr($valm,0,4).'-'.substr($valm,4,2);
if(substr($a,0,4)!=substr($m,0,4))
  {$mini=substr($vala,4,2);
	   $m=12;}
 else
   {$mini=substr($vala,4,2);
	    $m=substr($valm,4,2);}
$mes=substr($vala,4,2)-1;	   
$ano=substr($vala,0,4);	   
for($i=$mini;$i<=$m;$i++)
	{	//ENFERMEDADES COMUNES
		$mes++;
		if($mes>12)
		  if(substr($vala,0,4)<=substr($valm,0,4))
		     {$mes=1;
			 $ano++;}
			 
		if(strlen($mes)==1) $mes='0'.$mes;

	$datac[$i]=$vig_ae[$i+1][0];
	$datal[$i]=$vig_ae[$i+1][1];
	$datec[$i]=$vig_ae[$i+1][2];
	$datel[$i]=$vig_ae[$i+1][3];
}
for($i=1;$i<=12;$i++)
{
	$datac[$i]=0;
	$datal[$i]=0;
	$datec[$i]=0;
	$datel[$i]=0;
}
$nomgra7='RESUMEN ANUAL - '.$vige[0].' - '.$ano;
$grafico = new Graph(600, 200,"auto");  
$grafico->SetScale("textlin");  
$grafico->img->SetMargin(40,20,20,40);

// Titulo del gráfico  

$grafico->title->Set($nomgra7);  

// Etiqueta para el eje X  
$grafico->xaxis->ticks_label = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

//$grafico->xaxis->title->Set('Número del Mes');  

// Etiqueta para el eje Y  

$grafico->yaxis->title->Set("Cantidad");  

$lineplot1 = new LinePlot($datac); 
$lineplot1->SetLegend("Acc. Comunes");
//$lineplot1->SetColor("red");  
 

$lineplot2 = new LinePlot($datal);  
$lineplot2->SetLegend("Acc. Laborales");
//$lineplot2->SetColor("green"); 
 
$lineplot3 = new LinePlot($datec);  
$lineplot3->SetLegend("Enf. Comunes");
//$lineplot3->SetColor("blue");  

$lineplot4 = new LinePlot($datel);  
$lineplot4->SetLegend("Enf. Laborales");
//$lineplot4->SetColor("black"); 

$grafico->Add($lineplot1);  

$grafico->Add($lineplot2);
 
$grafico->Add($lineplot3);  

$grafico->Add($lineplot4);  
@unlink("grafico7.png");
   $grafico->Stroke("grafico7.png"); 
   $pdf->Image('grafico7.png',40,220,135);
/*___________________________________________*/
$pdf->Output(); 
?>
