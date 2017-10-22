<?php    
include "clases/clase_conexion.php";
include "clases/clase_orden.php"; 
include "clases/clase_examen.php";
include "clases/clase_resultado.php";
include "clases/clase_empleado.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<form action="" name="form1" method="get">
<input type="hidden" name="orden" id="orden" />
<input type="hidden" name="ced" id="ced" />
<?php 
if($_POST['orden'])
{
 	$idorden=$_POST['orden'];
}
else
{
 	$idorden=$_GET['orden'];
}

   $ord= new orden($idorden,'','','','','','');
   $result= $ord->ver_orden();
   if ($result) 
	 { 
	 $row = mysql_fetch_row($result);
	 }
	$pace=$ord->consul_pac_ID($row[4]);	
	$datose=explode('/*',$pace); 
	//$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'CEDULA:      '.$datose[11],0,0,'L',false); 
	//$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'NOMBRE:     '.$datose[1].' '.$datose[3],0,0,'L',false); 
	//$pdf->SetXY(12,$pdf->GetY()+0.4); $pdf->Cell(0,0,'EDAD:     '.calculaedad($datose[5]),0,0,'L',false); 
   $orden=$idorden;
   $ced=$datose[11];
   $nombre_archivo = 'tag.prn'; 
   $contenido ='I8,A,001


Q405,024
q448
rN
S4
D7
ZT
JF
O
R0,0
f100
N
A22,29,0,4,1,1,N,"ORDEN : "
B21,150,0,1,6,18,60,B,"'.$idorden.'"
A21,77,0,4,1,1,N,"CEDULA : '.$datose[11].'"
A20,115,0,4,1,1,N,"NOMBRE : '.$datose[1].' '.$datose[3].'"
A164,20,0,4,2,2,N,"'.$idorden.'"
P1
'; 
   fopen($nombre_archivo, 'w+'); 
   if (is_writable($nombre_archivo)) 
    { 
     if (!$gestor = fopen($nombre_archivo, 'w+')) 
	  { 
         echo "No se puede abrir el archivo ($nombre_archivo)"; 
         exit; 
      } 
     if (fwrite($gestor, $contenido) === FALSE) 
	  { 
       echo "No se puede escribir al archivo ($nombre_archivo)"; 
       exit; 
      }    
     // $x=shell_exec("print.bat");
     $x=copy("tag.prn",'\\poderozo\lp2824');
     fclose($gestor); 
	 $url="det_orden_pac.php?ord=".$idorden."&c=".$datose[11];
     echo "<script>document.form1.orden.value='".$idorden."';document.form1.ced.value='".$datose[11]."';document.form1.action='".$url."';document.form1.submit();</script>"; 
    } 
	else { 
   echo "No se puede escribir sobre el archivo $nombre_archivo"; 
     } 
   
   
  
?>

</form></body></html>
