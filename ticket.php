<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_espec.php";
include "clases/clase_medico.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unidad Medica Churchil</title>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table>
<tr>
<td rowspan="3"><img src="imagenes/Logo1.png" height="47" /></td>
  <?php 
 $ms=$_GET['ms'];
 $datos=explode(';',$ms);
 echo "<td>Cita registrada con Numero : <span class='Estilo2'>".$datos[0]."</span>";
 echo "Para el dia : <span class='Estilo2'>".$datos[1]." </span></td></tr>";
 $espe=$datos[2];
 $me=new medico('',$datos[3],'','','','','','','','','','','','','');
 $med=$me->buscar_med();
 $datos2=explode('**',$med);
 $especial=new especialidad($espe,'');
 $esp=$especial->busca_id_esp();
 echo "<tr><td>con : ".$esp[1]." --- ".$datos2[1]."</td></tr>";
 echo "<tr><td>Paciente :".$datos[4]." ".$datos[5];
 echo "</td></tr><script>window.print();window.close;</script>";
?> 

</table>
</body>
</html>
