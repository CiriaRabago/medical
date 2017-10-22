<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
include "clases/clase_orden.php";
include "clases/clase_empleado.php";
include "clases/clase_resultado.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
function soloNumerico(obj){ 
var tecla = window.event.keyCode;
	if ( tecla < 10 ) {
        return true;
    }
    if ( tecla != 46 && (tecla < 48 || tecla > 59) ) 
	{
	   window.event.keyCode=0;
    } else {
        return true;
    }
}

function Guardar(tipo)
{
  document.getElementById('guaocu').value=tipo;
  document.form1.submit();
}

function retorna()
{
	//document.getElementById('orden').value=ord;
	document.form1.action="ver_plantilla.php";
	document.form1.submit();
}



</script>


<body>
<form name="form1" id="form1" method="post" action="resultado_examen.php">

<?php  



		$examen=$_GET['exa'];
		$perfil=$_GET['per'];
		
	?>
	<input name="perfil" id="perfil" type="hidden" value="<?php  echo $perfil; ?>" />
	
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr bgcolor="#E3E3C6">
		<td height="55" colspan="2" bgcolor="#E3E3C6">
		  <div align="left"><img src="imagenes/Logo1.png" /></div>
		<td colspan="2" bgcolor="#E3E3C6"  class="texto">&nbsp;
		</td>
		</tr>
		  <tr>
		<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr class="textoN">
		<td colspan="2">Examen: </td>
		<td width="200">Muestra:</td>
		<td width="200">M&eacute;todo:</td>
	  </tr>
	<?php  
	
		$exa=new examen($examen,'','','','','','','','');
		$datosexa=$exa->consul_examen();
	   ?>
	  <tr class="texto">
		<td colspan="2"><?php  echo $datosexa[0]; ?><input name="examen" id="examen" type="hidden" value="<?php  echo $datosexa[3]; ?>" /></td>
		<td><?php  echo $datosexa[2]; ?><input name="muestra" id="muestra" type="hidden" value="<?php  echo $datosexa[2]; ?>" /></td>
		<td><?php  echo $datosexa[1]; ?><input name="metodo" id="metodo" type="hidden" value="<?php  echo $datosexa[1]; ?>" /></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	  </tr>
	<?php  
		$caractexa=$exa->consul_caract_examen($examen);
		$n=mysql_num_rows($caractexa);
	?>	<input name="canticar" id="canticar" type="hidden" value="<?php  echo $n; ?>" />
	<?php 
		//$n=15;
		if($n!=0)
		{
				if($n<=10)
				{
					$indi=0;
					while ($row=mysql_fetch_array($caractexa))
					{ 
					  $indi=$indi+1;
					  if ($indi==1)
					  {
						$tipoaux=$row[0];
					  }
					  else
					  {
						if($tipoaux!=$row[0])
						{
						  $band=1;
						  $tipoaux=$row[0];				
						}
						else 
						  $band=0;
					  }
					 if($band==1)
					 { ?>
					  <tr>
						<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
					  </tr> 
	<?php 				 } 
					?>
					  <tr class="texto">
						<td colspan="2"><?php   echo $row[2];  ?> <input name="nombcar<?php  echo $indi-1;?>" id="nombcar<?php  echo $indi-1;?>" type="hidden" value="<?php  echo $row[2];?>" /></td>
						<td colspan="2"><?php  
						
						if($row[5]==1)
						{ 
						?> <select name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" class="texto">
						  <option value="P">Positivo</option>
						  <option value="N">Negativo</option>
						</select> 
						<input name="ocucaract<?php  echo $indi-1;?>" id="ocucaract<?php  echo $indi-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
						<input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="" />

						<?php 
						}
						else
						{
							$valores=$exa->consul_valores_caract($row[1]);
							if($valores==FALSE)
							{ 			?>
							<input name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" type="text" class="texto"  value="" size="5" />
							<input name="ocucaract<?php  echo $indi-1;?>" id="ocucaract<?php  echo $indi-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
							<input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="" />
			<?php 				
							}
							else
							{
							?>
							  <select name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" class="texto" >
								<option value="">Seleccione</option>
								<?php  echo $valores; ?>
							  </select>	
							  <input name="ocucaract<?php  echo $indi-1;?>" id="ocucaract<?php  echo $indi-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
							  <input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="slc_lista_Valores" />
<?php 							}
						}
						$valoresref=$exa->consul_valores_ref($row[1],'A',30);
						$dato='';
						if($valoresref!=false)
						{
						  echo $valoresref[1].'-'.$valoresref[2];
						  $dato.=$valoresref[1].'-'.$valoresref[2];
						}
						if($row[4]!=' ') 
						{
						  echo ' ('.$row[4].')'; 
						  $dato.=' ('.$row[4].')';
						}				
						 ?>
						 <input name="unime<?php  echo $row[1];?>" id="unime<?php  echo $row[1];?>" type="hidden" value="<?php  echo $row[6];?>" />
						 <input name="datoscar<?php  echo $indi-1;?>" id="datoscar<?php  echo $indi-1;?>" type="hidden" value="<?php  echo $dato;?>" />
						 <input name="tipocar<?php  echo $indi-1;?>" id="tipocar<?php  echo $indi-1;?>" type="hidden" value="<?php  echo $row[0];?>" />
	
						</td>
					  </tr>
			<?php  	}
				}
				else //Si $n>10
				{
					$cont=0;
					while ($row=mysql_fetch_array($caractexa))
					{ 		   
					  $cont++;
					  if ($cont==1)
					  {
						$tipoaux=$row[0];
					  }
					  else
					  {
						if($tipoaux!=$row[0])
						{
						  $band=1;
						  $tipoaux=$row[0];				
						}
						else 
						  $band=0;
					  }
	
					  if($band==1)
					  {
						if($cont%2==0)
						{
						  echo '<td width="200">&nbsp;</td>
								<td width="200">&nbsp;</td>';
						  $cont++; 
								
						} ?>
					  <tr>
						<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
					  </tr> 
					 
	<?php 			 
					 }
	
					   if($cont%2==1) echo '<tr class="texto">';
	?>					<td width="200"><?php  echo $row[2];?> <input name="nombcar<?php  echo $cont-1;?>" id="nombcar<?php  echo $cont-1;?>" type="hidden" value="<?php  echo $row[2];?>" /></td>
						<td width="200"><?php  
						if($row[5]==1)
						{ 
						?> <select name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" class="texto">
						  <option value="Positivo">Positivo</option>
						  <option value="Negativo">Negativo</option>
						</select>
						<input name="ocucaract<?php  echo $indi-1;?>" id="ocucaract<?php  echo $indi-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
						<input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="" />
						 <?php 
						}
						else
						{
	
							$valores=$exa->consul_valores_caract($row[1]);
							if ($valores==false)
							{ 			?>
							<input name="caract<?php  echo $row[1];?>" type="text" class="texto" id="caract<?php  echo $row[1];?>" value="" size="5" />
							<input name="ocucaract<?php  echo $cont-1;?>" id="ocucaract<?php  echo $cont-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
							<input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="" />
			<?php 				}
							else
							{
							?>
							  <select name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" class="texto" >
								<option value="">Seleccione</option>
								<?php  echo $valores; ?>
							  </select>					
							  <input name="ocucaract<?php  echo $cont-1;?>" id="ocucaract<?php  echo $cont-1;?>" type="hidden" value="caract<?php  echo $row[1];?>" />
							  <input name="tabla<?php  echo $row[1];?>" id="tabla<?php  echo $row[1];?>" type="hidden" value="slc_lista_Valores" />
		<?php 	
							}
						}
						$valoresref=$exa->consul_valores_ref($row[1],$_POST['sexo'],$_POST['edad']);
						$dato='';
						if($valoresref!=false)
						{
						  echo $valoresref[1].'-'.$valoresref[2];
						  $dato.=$valoresref[1].'-'.$valoresref[2];
						}
						if($row[4]!=' ') 
						{
						  echo ' ('.$row[4].')'; 
						  $dato.=' ('.$row[4].')';
						}				 ?>			
						<input name="unime<?php  echo $row[1];?>" id="unime<?php  echo $row[1];?>" type="hidden" value="<?php  echo $row[6];?>" />
						<input name="datoscar<?php  echo $cont-1;?>" id="datoscar<?php  echo $cont-1;?>" type="hidden" value="<?php  echo $dato;?>" />
						<input name="tipocar<?php  echo $cont-1;?>" id="tipocar<?php  echo $cont-1;?>" type="hidden" value="<?php  echo $row[0];?>" />
	
						
						</td>
	<?php  			   if($cont%2==0) echo  '</tr>';
					}	
				}
		}
		else
		{ ?>
	
			<tr class="texto">
				<td colspan="4">No hay valores Asociados Transcriba el resultado</td>
			</tr>
	<?php 	}
			?>
	  <tr class="texto" align="center">
				<td height="82" colspan="4" align="center"><div style="background-position:center">Observación:</div><textarea name="obs" cols="70" rows="3" id="obs"></textarea></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr class="texto">
		<td colspan="4"><div align="center">
			<img src="imagenes/p_salir1.gif" alt="Salir de la Plantilla" width="130" height="50" style="cursor:hand" onclick="retorna();" 
			onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
			<input name="guaocu" id="guaocu" type="hidden" value="" /></div></td>
	  </tr>
	</table>

<?php  //} ?>
</form>
</body>
</html>
