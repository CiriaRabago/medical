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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>

function Guardar(tipo)
{
  if(tipo=='F')
  {
     if(document.getElementById('empleado').value=="")
	 {
	    alert ('Debe Seleccionar a un Bionalista');
		return false;
	 }
  }
  document.getElementById('guaocu').value=tipo;
  document.form1.submit();
}

function retorna()
{
	//alert(document.getElementById('pagiocu').value);
	document.form1.action=document.getElementById('pagiocu').value;
	document.form1.submit();
}

</script>


<body>
<form name="form1" id="form1" method="post" action="resultado_examen.php">

<?php  
$pagina='';

if($_POST['guaocu']!='')
{
	$orden=$_POST['orden'];
	?>  <input name="orden" id="orden" type="hidden" value="<?php  echo $orden; ?>" /> <?php 
	$examen=$_POST['examen'];
	?>  <input name="examen" id="examen" type="hidden" value="<?php  echo $examen; ?>" /> <?php 
	$empleado=$_POST['empleado'];
	?>  <input name="empleado" id="empleado" type="hidden" value="<?php  echo $empleado; ?>" /> <?php 
	$empleado=explode("**",$empleado);
	$pagina=$_POST['pagiocu'];
	?> <input name="pagiocu" id="pagiocu" type="hidden" value="<?php  echo $pagina; ?>" /> <?php 
	$obs=$_POST['obs'];
	?>  <input name="obs" id="obs" type="hidden" value="<?php  echo $obs; ?>" /> <?php 
	$rr= new resultado('',$orden,$examen,$empleado[0],$obs,'','');
	$idresul=$rr->ins_result();
	if($idresul!=false)
	{ 
	    $rr->id=$idresul;
		$canticar=$_POST['canticar'];
		$bandgua=true;
		for($i=0;$i<$canticar;$i++)
		{
		   	$idcar=$_POST['ocucaract'.$i];
			$idcaract=str_replace("caract","",$_POST['ocucaract'.$i]);
		   	$idtabla=str_replace("caract","tabla",$idcar);
			$idunime=str_replace("caract","unime",$idcar);
			
			if($idcaract!="")
			{
				/*echo '<script>alert("idcar="+'.$idcaract.'+"nombocu="+'.$idcar.'+"valor"+'.$_POST[$idcar].')</script>';*/
				$guardet=$rr->ins_det_result($idcaract,$_POST[$idcar],$_POST[$idunime],$_POST[$idtabla]);
				if($guardet==false)
				{
				   $bandgua=false;
				}			
			}
			else $canticar++;
			   
		}
		if($bandgua==true)
		{
			$ord= new orden($orden,'','','','','','');
			if($_POST['guaocu']=='F')
			   $ord->modif_status_res($examen,'S');
			if($_POST['guaocu']=='G')
			   $ord->modif_status_res($examen,'M');
			echo '<script>alert("Los resultados fueron almacenados con exito");</script>';
		}
		else
			echo '<script>alert("Ocurrió un error al guardar los resultados");</script>';

	}
	//die();
	echo '<script>retorna();</script>';
}
else
{
	$orden=$_GET['ord'];
		?>  <input name="orden" id="orden" type="hidden" value="<?php  echo $orden; ?>" /> <?php 
		$examen=$_GET['exa'];
		$cedula=$_GET['ced'];
		$pagina=$_GET['pagi'];
		?> <input name="pagiocu" id="pagiocu" type="hidden" value="<?php  echo $pagina; ?>" /> <?php 

	$ord= new orden('','','','','','','');
	$paci=$ord->consul_pac_ID($cedula);
	$datos=explode('/*',$paci); 
	
	?>
	
	
	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr bgcolor="#E3E3C6">
		<td height="55" colspan="2" bgcolor="#E3E3C6">
		  <div align="left"><img src="imagenes/Logo1.png" /></div>
		<td colspan="2" bgcolor="#E3E3C6"  class="texto">
		  <span class="textoN">FECHA</span>:  <?php  echo date('d-m-Y'); ?><br>
		  <span class="textoN">ORDEN No. </span>: <?php  echo $orden; ?><br>
		  <span class="textoN">CÉDULA</span>: <?php  echo $datos[11]; ?><input name="cedula" id="cedula" type="hidden" value="<?php  echo $datos[11]; ?>" /><br>
		</td>
		</tr>
		  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr class="textoN">
		<td colspan="2">Examen Solicitado: </td>
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
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
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
						<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
					  </tr> 
	<?php 				 } 
					?>
					  <tr class="texto">
						<td colspan="2"><?php   echo $row[2];  ?> <input name="nombcar<?php  echo $indi-1;?>" id="nombcar<?php  echo $indi-1;?>" type="hidden" value="<?php  echo $row[2];?>" /></td>
						<td colspan="2"><?php  
						
						if($row[5]==1)
						{ 
						?> <select name="caract<?php  echo $row[1];?>" id="caract<?php  echo $row[1];?>" class="texto">
						  <option value="">Seleccione</option>
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
						$valoresref=$exa->consul_valores_ref($row[1],$datos[6],calculaedad($datos[5]));
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
						<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
					  </tr> 
					 
	<?php 			 
					 }
	
					   if($cont%2==1) echo '<tr class="texto">';
	?>					<td width="200"><?php  echo $row[2];?> <input name="nombcar<?php  echo $cont-1;?>" id="nombcar<?php  echo $cont-1;?>" type="hidden" value="<?php  echo $row[2];?>" /></td>
						<td width="200"><?php  
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
		<td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr class="texto">
		<td colspan="2">
	<?php 		$bio= new empleado('','','','','','','','','','','','','','','','','','','');
		$result= $bio->buscar_bioanalista(); ?>
		
		Bioanalista: <select name="empleado" id="empleado" class="texto">
		  <option value="">Seleccione</option>
		<?php 
	
		if($result)
			while ($row = mysql_fetch_row($result))
			{
			   echo '<option value="'.$row[0].'**'.$row[1].' '.$row[3].'**'.$row[5].'**'.$row[6].'">'.$row[0].'-'.$row[1].' '.$row[3].'</option>';
			}	
		
		 ?>
		
		
		</select><br />
		  </td>
		<td colspan="2"><div align="right"><img src="imagenes/p_guardar1.gif" alt="Guardar Resultado" width="130" height="50" style="cursor:hand" onclick="Guardar('G');" 
			onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
			<img src="imagenes/p_final1.gif" alt="Finalizar Resultado" width="130" height="50" style="cursor:hand" onclick="Guardar('F');" 
			onmouseover="this.src='imagenes/a_final1.gif'"  onmouseout="this.src='imagenes/p_final1.gif'"/>
			<img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="130" height="50" style="cursor:hand" onclick="retorna();" 
			onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
			<input name="guaocu" id="guaocu" type="hidden" value="" /></div></td>
	  </tr>
	</table>

<?php  } ?>
</form>
</body>
</html>
