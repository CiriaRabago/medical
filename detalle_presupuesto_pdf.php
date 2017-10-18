<?php
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_empresa_pres.php";
include "clases/clase_presupuesto.php";
$id_presupuesto=$_GET['id_p'];

class PDF extends FPDF
{
//Cabecera de página
   function Header()
   {
    //Logo
 
      
   }
   
   //Pie de página
   function Footer()
   {
    //Posición: a 1,5 cm del final
    $this->SetY(-6);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }
    
   //Tabla coloreada
function TablaColores($header)
{
  $id_presupuesto=$_GET['id_p'];
//Colores, ancho de línea y fuente en negrita
  $this->SetX(2);
$this->SetFillColor(1000,1000,1000);
$this->SetTextColor(0);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(.03);
$this->SetFont('Arial','BI',10); 
//Cabecera

for($i=0;$i<count($header);$i++)
$this->Cell(2.5,0.5,$header[$i],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(220,245,255);
$this->SetTextColor(0);
$this->SetFont('');
$this->SetX(3);
//Datos
$max_h="select * from slc_abono_presu where id_presu=".$_GET['id_p']." and estatus='A'";
$OBJ_max_h = mysql_query($max_h);
while($datos_abono = mysql_fetch_row($OBJ_max_h)){
    
$this->SetX(2);
$this->Cell(2.5,0.5,number_format($datos_abono[2], 2, ',', '. '),'LR',0,'L',$fill);
$this->Cell(2.5,0.5,$datos_abono[3],'LR',0,'L',$fill);
$this->Cell(2.5,0.5,$datos_abono[6],'LR',0,'R',$fill);
$this->Cell(2.5,0.5,$datos_abono[4],'LR',0,'R',$fill);
$this->Ln();
$fill=!$fill;
$sum=$sum+$datos_abono[2];
 }
      

     $this->SetX(2);
    $this->Cell(10,0,'','T');
    $this->Ln();
    $this->SetX(2);
    $this->SetFillColor(1000,1000,1000);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.03);
    $this->SetFont('Arial','BI',10); 
    $this->Cell(10,0.5,'TOTALES','LR',0,'C',$fill);
    $this->Ln();
    $this->SetX(2);
    $this->Cell(10,0,'','T');
    $this->Ln();
    $this->SetX(2);
    $this->Cell(2.5,0.5,number_format($sum, 2, ',', '. '),'LR',0,'L',$fill);
    $this->Cell(7.5,0.5,'Total Abonado','LR',0,'C',$fill);
    $this->SetX(2);
    $this->Cell(10,0,'','T');
      $pres= new presup();
      $bus_pre=$pres->buscar_presup($id_presupuesto);
      if ($bus_pre){
      $datos=explode('**',$bus_pre);
      }
    $saldo=$datos[5]-$sum;
    $this->Ln(0.5);
    $this->SetX(2);
    $this->Cell(2.5,0.5,number_format($saldo, 2, ',', '. '),'LR',0,'L',$fill);
    $this->SetX(2);
    $this->Cell(10,0,'','T');
    $this->SetX(4.5);
    $this->Cell(7.5,0.5,'Saldo','LR',0,'C',$fill);
    $this->Ln();
    $this->SetX(2);
    $this->Cell(10,0,'','T');

}

   
   
}
$pdf=new PDF('L','cm','mcarta');
$pdf->SetMargins(1,1,1);
//Títulos de las columnas
$header=array('Monto','Fecha','Detalle','Usuario');
$pdf->AliasNbPages();
$pres= new presup();
      $bus_pre=$pres->buscar_presup($id_presupuesto);
      if ($bus_pre){
      $datos=explode('**',$bus_pre);
      }

    $pdf->AddPage();
    $pdf->Image('imagenes/Logotipo.jpg',1,0.4,3.5);
    $pdf->SetY(3);
    $pdf->SetFont('Arial','BI',14); $pdf->Cell(0,0.5,'COMPROBANTE DE PRESUPUESTO #'.$id_presupuesto,0,1,'C',false);
    $pdf->Ln();
    $pdf->SetFont('Arial','BI',10); $pdf->Cell(2,0.5,'Proveedor',0,0,'L',false);
    $pdf->SetFont('Arial','',10);   $pdf->Cell(9,0.5,$datos[1],0,0,'L',false);
    $pdf->Ln();
    $pdf->SetFont('Arial','BI',10); $pdf->Cell(2,0.5,'Fecha Inicio: '.$datos[3].' Fecha Fin: '.$datos[4],0,0,'L',false);
    $pdf->Ln(); 
    $pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'Monto: '.number_format($datos[8], 2, ',', '. '),0,1,'R',false);
    $pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'Base Imponible: '.number_format($datos[10], 2, ',', '. '),0,1,'R',false);
    $pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'Monto x Cancelar: '.number_format($datos[5], 2, ',', '. '),0,1,'R',false);
    $pdf->Ln(); 
    if ($datos[13]=='A') {
      $esta='Aceptado';
    }
    if ($datos[13]=='E') {
      $esta='Eliminado';
    }
    if ($datos[13]=='F') {
      $esta='Finalizado';
    }
    if ($datos[13]=='J') {
      $esta='Ejecutado';
    }
    if ($datos[13]=='X') {
      $esta='Por Ejecutar';
    }
    if ($datos[13]=='V') {
      $esta='Vencido';
    }

    $pdf->SetFont('Arial','BI',10); $pdf->Cell(0,0.5,'Estatus: '.$esta,0,1,'L',false);
    $pdf->SetX(1);
    $pdf->SetFont('Arial','',10);   $pdf->MultiCell(0,0.5,$bus_r_e,0,'J',false);
    $pdf->Ln();
$pdf->TablaColores($header);
$pdf->Output();
?>