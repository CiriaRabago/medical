<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Unidad Medica Churchil C.A. --- Resultados Laboratorio</title>
<link rel="shortcut icon" href="favicon.ico" >
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<body>

<form name="form1" action="">
<?php
   $ced=$_GET['ced'];
   $ord= new orden('','','','','','','');
	$paci=$ord->consul_pac($ced);
	if($paci)
	{
	   $datos=explode('/*',$paci); 
	   if($datos[6]=='F')
		   $sexo='Femenino';
		 else
		   $sexo='Masculino';
		$reg=$ord->lista_orden_pac($datos[0]);
	   ?>
	   
	   		<table width="700" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="6"><div align="center" class="titulofor">Resultados por Paciente </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="6"><div align="left" class="texto"> 
	  			<span class="textoN">CÉDULA: <?php echo $datos[11]; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php echo $datos[11]; ?>" /><br>
      			<span class="textoN">NOMBRE</span>: <?php echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?><input name="nombre" id="nombre" type="hidden" value="<?php echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?>" /><br>
	  			<span class="textoN">EDAD</span>: <?php echo calculaedad($datos[5]); ?><input name="edad" id="edad" type="hidden" value="<?php echo calculaedad($datos[5]); ?>" /><br>
	  			<span class="textoN">SEXO</span>: <?php echo $sexo; ?><input name="sexo" id="sexo" type="hidden" value="<?php echo $datos[6]; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php echo $sexo; ?>" /><br>
	  			<span class="textoN">EMPRESA: </span><?php echo $datos[8]; ?><input name="empresa" id="empresa" type="hidden" value="<?php echo $datos[7]; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php echo $datos[8]; ?>" />
				</div><br></td>
			</tr>
			
			<tr class="titulorep">
			  <td width="20">ORDEN</td>
			  <td width="200">FECHA</td>
			  <td width="100">MONTO</td>			  
			</tr>	   
	   
<?php	   $cont=0;
       $sw=0; 
	   while ($row=mysql_fetch_array($reg))
	   { $sw++;
	      if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		  $cont++;
	   ?>
			<tr class="texto" <?php echo $color; ?>>
			  <td width="20"><a href="resu_exam_his.php?orden=<?=$row[0];?>" style="cursor:hand; text-decoration:underline"><?php echo $row[0]; ?></a></td>
			  <td width="100"><?php echo $row[1]; ?></td>
			  <td width="100"><?php echo $row[2]; ?></td>
			  
			</tr>	
           <?php }
		   if ($sw==0){?>  
			<tr class="titulofor">
			  <td height="30" colspan="6"><div align="center" class="titulofor">Este paciente no tiene solicitudes de Examen en Laboratorio </div></td>
			</tr>
			<?php }?>
		  </table>
		             <?php } ?> 
</form>
</body>
</html>
