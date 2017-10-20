<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_aprobacion.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1">
</head>
<script>
function resultados(ced)
{
   var pag="resultados.php?ced="+ced;
	window.open(pag,'','width=700,height=450,resizable=yes,scrollbars=yes');
}
</script>

<body>

<form name="form1" id="form1" method="post" action="">

<?php  $visita=$_GET['visi'];	
	$ipaci=$_GET['idpac'];
	$npaci=$_GET['npac'];
	$devi=$_GET['detvis'];
	$servi=$_GET['servis'];
 ?>

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <?php $vis= new visita($visita,'','','','','','','','','','','','');
     $dpac=$vis->datos_pac_vis($ipaci);
	 if($dpac!='false') {
	 	 $rowp=mysql_fetch_array($dpac);?>
    <tr bgcolor="#E3E3C6">
    <td  class="texto" align="center">
	<?php		if(file_exists('fotos/'.$rowp[0].'.jpg'))
			{
				echo '<img src="fotos/'.$rowp[0].'.jpg" width="100" height="100" align="center" />';
			}
			$demp=$vis->datos_empres_vis();
			if($demp!='false')
			{   
				$rowe=mysql_fetch_array($demp);
				if($rowe[1]==NULL) 
				  	$nomemp='Particular'; 
				else 
				  	$nomemp=$rowe[1];
			}
	?>
	</td>
	<td  class="texto" colspan="2">
	  <span class="textoN">CÉDULA: <?php echo $rowp[1]; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php echo $_POST['cedula']; ?>" /><br>
      <span class="textoN">NOMBRE</span>: <?php echo $rowp[2]; ?><input name="nombre" id="nombre" type="hidden" value="<?php echo $_POST['nombre']; ?>" /><br>
	  <span class="textoN">EDAD</span>: <?php echo $rowp[4]; ?><input name="edad" id="edad" type="hidden" value="<?php echo $_POST['edad']; ?>" /><br>
	  <span class="textoN">SEXO</span>: <?php echo $rowp[3]; ?><input name="sexo" id="sexo" type="hidden" value="<?php echo $_POST['sexo']; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php echo $_POST['sexonom']; ?>" /><br>
	  <span class="textoN">EMPRESA</span>: <?php echo $nomemp; ?><input name="empresa" id="empresa" type="hidden" value="<?php echo $rowe[0]; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php echo $_POST['empresanom']; ?>" /></br>
	  <?php
	    if($rowe[0]=='226'){
		$apr=new aprobacion($visita,'','','','','','');
		$cla=$apr->busca_clave();
		?>
		<span class="textoN">DATOS APROBACION :</span>: <?php echo $cla; ?></td>
		<?php
		}else echo "</td>";
	  ?>
    </tr>
<?php } ?>
</table>
<div align="center" id="ImpriVis">

<input class="textoN" name="laboratorio" id="laboratorio" type="button" onclick="resultados('<?=$rowp[1];?>');" value="Resultados Examenes de Laboratorio" />
</div>	 

<div align="center">
	<iframe src="historia_antec.php?visi=<?php echo $visita; ?>&idpac=<?php echo $ipaci; ?>&detvis=<?php echo $devi; ?>" name="forma1" id="forma1" width="704" frameborder="0" scrolling="no"></iframe>
</div>
<div align="center">
	<iframe src="historia_visit.php?visi=<?php echo $visita; ?>&idpac=<?php echo $ipaci; ?>&detvis=<?php echo $devi; ?>" name="forma2" id="forma2" width="704" frameborder="0" scrolling="no"></iframe>
</div>
<div align="center">
	<iframe src="visita_atenc.php?visi=<?php echo $visita; ?>&idpac=<?php echo $ipaci; ?>&detvis=<?php echo $devi; ?>&servis=<?php echo $servi; ?>" name="forma3" id="forma3" width="704" frameborder="0" scrolling="no"></iframe>
</div>
<div align="center">
	<iframe src="visitas_antes.php?visi=<?php echo $visita; ?>&idpac=<?php echo $ipaci; ?>&detvis=<?php echo $devi; ?>&servis=<?php echo $servi; ?>" name="forma4" id="forma4" width="704" frameborder="0" scrolling="no"></iframe>
</div>


</form>
</body>
</html>



