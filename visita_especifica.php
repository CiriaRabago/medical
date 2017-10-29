<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_historia.php";
include "clases/clase_referencia.php";
include "clases/clase_solicitud.php";
include "clases/clase_diagnostico.php";
include "clases/clase_formato.php"; 
include "clases/clase_aprobacion.php";
include "clases/clase_res_estudio.php";
$visita=$_GET['visi'];	
$ipaci=$_GET['idpac'];
$status=$_GET['esta'];
$moti=$_GET['motivo'];
/*$npaci=$_GET['npac'];
$devi=$_GET['detvis'];*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>DETALLES DE LA VISITA</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<script>
function mostrarVentana()
{
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.marginTop = "100px"; // Definimos su posición vertical. La ponemos fija para simplificar el código
    ventana.style.marginLeft = ((document.body.clientWidth-350) / 2) +  "px"; // Definimos su posición horizontal
    ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.display = 'none'; // Y lo hacemos invisible
}
  var x,y;
function ver_visit(codi)
{
	if (document.getElementById('vis'+codi).style.display=="none")
	{	document.getElementById('vis'+codi).style.display='block'; }
	else
	{	document.getElementById('vis'+codi).style.display="none"; }
   /* window.parent.document.getElementById("forma4").height = document.getElementById("Contenido4").offsetHeight+10;*/
}

function ver_resvisit(codi)
{
	if (document.getElementById('resvis'+codi).style.display=="none")
	{	document.getElementById('resvis'+codi).style.display='block'; }
	else
	{	document.getElementById('resvis'+codi).style.display="none"; }
    /*window.parent.document.getElementById("forma4").height = document.getElementById("Contenido4").offsetHeight+10;*/
}

function ver_tipoc(codi)
{
	if (document.getElementById('tipcon'+codi).style.display=="none")
	{	document.getElementById('tipcon'+codi).style.display='block'; }
	else
	{	document.getElementById('tipcon'+codi).style.display="none"; }
    /*window.parent.document.getElementById("forma4").height = document.getElementById("Contenido4").offsetHeight+10;*/
}

function imprimir(ventana)
{
	window.open(ventana+x+'&crit='+y,'','width=700,height=450,resizable=yes,scrollbars=yes');
}
function imprimir_con_logo(logo)
{

    if (logo=='123' && x!=1)
	 {x=1;	 
	 document.form4.log.value='-'+x+'-';
	 return x;}
	if(logo=='123' && x==1)
	 {x=2;	  
	  document.form4.log.value='-'+x+'-';
	  return x;}
}
function imprimir_con_critico(critico)
{

    if (critico=='999' && y!=1)
	 {y=1;	 
	 document.form1.crit.value='-'+x+'-';
	 return y;}
	if(critico=='999' && y==1)
	 {y=2;	 
	  document.form1.crit.value='-'+x+'-';
	  return y;}
}
function resultados(ced)
{
   var pag="resultados.php?ced="+ced;
	window.open(pag,'','width=700,height=450,resizable=yes,scrollbars=yes');
}

</script>


<body>
<div class="header-page">
<div class="logo-header"> <img src="imagenes/Logo1.png" alt="churchil"  style="width:210px;height:70px"></div>
<div class="banner-header"><img src="imagenes/header1.jpg" alt="churchil" style="width:800px;height:80px"></div>
</div>
<form action="visita_especifica.php" method="post" name="form4">


<div id="Contenido4"> 
<input name="oidpac" id="oidpac" type="hidden" value="<?php  echo $ipaci; ?>" />
<input name="oidvis" id="oidvis" type="hidden" value="<?php  echo $visita; ?>" />
<input name="log" id="log" type="hidden" value="4" />
<!-- <input name="oiddevi" id="oiddevi" type="hidden" value="<?php  //echo $devi; ?>" /> -->

<table width="704" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td height="30" colspan="4" align="center" class="titulofor">VISITA  DEL PACIENTE<br>
	<?php  echo $_GET['cpaci'].' - '.$_GET['npaci'];
	?></td>
  </tr>
   <tr><td colspan="4"><img src="imagenes/blanco.gif" height="1" width="100%"></td></tr>
  <tr class="titulorep" height="20">
    <td  width="150">&nbsp;TIPO</td>
	<td  width="280">EMPRESA</td>
	<td  width="170">FECHA</td>
	<td  width="104">ESTADO</td>

<?php 	 
		$vis= new visita($visita,'','','','','','','','','','','','');
		$nev=$vis->datos_empres_vis();
		$rownev = mysql_fetch_row($nev);
		if($rownev[0]==0)
			$nomemp='PARTICULAR';
		else
			$nomemp=$rownev[1];
		if($rownev[0]=='226'){
		$apr=new aprobacion($visita,'','','','','','');
		$cla=$apr->busca_clave();
		?>
		
		<?php 
		}	
		?>
  <tr><td colspan="4"><img src="imagenes/blanco.gif" height="1" width="100%"></td></tr>
  <tr height="20" class="textoN" onClick="ver_visit(<?php  echo $visita; ?>)" style="cursor:hand" bgcolor="#cfe7f9">
    <td><?php  echo $_GET['motivo']; ?></td>
	<td><?php  echo $nomemp; ?></td>
	<td><?php  echo $_GET['fecha']; ?></td>
	<td><?php  echo $status; ?></td>
  </tr>
  <?php  if($rownev[0]=='226'){?>
  <tr>
    <td colspan="4" class="textoN" style="cursor:hand" bgcolor="#cfe7f9"><span class="textoN">DATOS APROBACION </span>: <?php  echo $cla; ?></td>
  </tr>
  <?php  }?>
  <TR><td colspan="4" >
    <div align="center" id="ImpriVis">

<input class="textoN" name="laboratorio" id="laboratorio" type="button" onclick="resultados('<?=$_GET['cpaci'];?>');" value="Resultados Examenes de Laboratorio" />
</div>	 
 </td>
  </TR>
  <tr>
    <td colspan="4">
	<table id="vis<?php  echo $visita; ?>" style="display:block"  width="702" border="0" cellspacing="1" cellpadding="0">
	 <tr>
      <td>
<!-- Historia de la visita -->
<?php 
	 	$tipHV=$vis->tipos_cond_H('2');
		if ($tipHV!=false)
		{  
			$contHV=0;
			echo '<table width="702" border="0" cellspacing="1" cellpadding="0">
			  <tr>
    <td  height="30" colspan="4" align="center" class="titulofor">HISTORIA DE LA VISITA </td>
  </tr>';

			while ($row4 = mysql_fetch_row($tipHV))
			{
				echo '<tr class="titulorep"><td height="20" style="cursor:hand" onclick="ver_tipoc('.$visita.$row4[0].');">'.$row4[1].'</td></tr>';
				$condHV=$vis->condicionesHVI($row4[0],$visita);
				if($condHV!=false)
				{
					  echo '<tr><td><table width="700" border="0" cellspacing="1" cellpadding="0" id="tipcon'.$visita.$row4[0].'" style="display:none">';
					  $cont2=0;
					  while($row5 = mysql_fetch_row($condHV))
					  {
							$contHV++;
							if ($cont2%2!=0) $color2='bgcolor="#E3E3E6"'; else $color2='';
							$cont2++;
							echo'<tr height="15"  class="texto" '.$color2.' >
								<td width="200" class="textoN">'.$row5[1].'</td>
								<td width="500"><table cellspacing="0" cellpadding="0"  border="0"><tr>';

								$valcond=$vis->valorescondVI($row5[0],$visita);
								if($row5[4]=='S')
								{
									if($row5[2]=='S')
									{
										echo '<td width="360" class="texto">';
										$cchhv=0;
										while($row6 = mysql_fetch_row($valcond))
										{
											$cchhv++;
											if($row6[2]==0) $ck=''; else $ck='checked';
											echo '<input name="cqHV*'.$contHV.'*'.$cchhv.'" id="cqHV*'.$contHV.'*'.$cchhv.'" type="checkbox" '.$ck.' value="'.$row6[0].'"  disabled  />'.$row6[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
									}
								}
								else
								{
									if($row5[2]=='S')
									{
										echo '<td width="360" class="texto">';
										while($row6 = mysql_fetch_row($valcond))
										{
											if($row6[2]==0) $ck=''; else $ck='checked';
											?> <input type="radio" <?php  echo $ck;?>  disabled  name="rbHV<?php  echo $contHV; ?>" id="rbHV<?php  echo $contHV; ?>" value="<?php  echo $row6[0]; ?>" />
											<?php  echo $row6[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
									}
								}
							
							 if($row5[5]!=NULL) $vcc=$row5[5]; else $vcc='';
							 if($row5[2]=='S') $posdiv='<td width="140" class="texto">'; else $posdiv='<td width="500" class="texto">';
							 echo $posdiv.$vcc.'</td>';
							echo '</tr></table></td></tr>';
					  }
					  echo '</table></td></tr>';
				}
			}
			echo '</table>'; 
		} // Fin si encuentra tipos ?>
	  
<!-- Fin de Historia de la visita -->

<!-- Resultados de la visita -->
<table  width="702" cellspacing="1">
 <tr>
    <td  height="30" colspan="4" onClick="ver_resvisit(<?php  echo $visita; ?>)" style="cursor:hand"  align="center" class="titulofor">RESULTADOS DE LA VISITA</td>
  </tr>
  <?php  $rv=$vis->ver_result_vis();
     if($rv!=false)
	   $rowr=mysql_fetch_array($rv);
   ?> 
  <tr>
    <td colspan="4">
	  <table width="702" id="resvis<?php  echo $visita; ?>" style="display:block"  border="0" cellspacing="1" cellpadding="0">
		  <tr>
			<td width="150" class="textoN">Motivo de la Visita</td>
			<td width="551" class="texto" colspan="3"><?php  echo $rowr[10]; ?></td>
		  </tr>
		  <tr bgcolor="#E3E3E6">
			<td width="150" class="textoN">Examen F&iacute;sico </td>
			<td width="551" class="texto" colspan="3"><?php  echo $rowr[0]; ?></td>
		  </tr>
		  <tr>
			<td width="150" class="textoN">Comentario Examen F&iacute;sico</td>
			<td width="551" class="texto" colspan="3"><?php  echo $rowr[11]; ?></td>
		  </tr>
		  <tr bgcolor="#E3E3E6">
			<td class="textoN">Examen de Laboratorio </td>
			<td class="texto" colspan="3"><?php  echo $rowr[1]; ?></td>
		  </tr>
		  <?php  $diag= new diagnostico($rowr[2],'',''); ?>
		  <tr>
			<td class="textoN">Diagn&oacute;stico y Comentarios</td>
			<td class="texto" colspan="3">
			<?php   
		  	$reporte=new formato();
			$dv=$reporte->diag_vis($visita);
			while($rowdiag=mysql_fetch_row($dv))
			{	echo '<span class="textoN"> * '.$rowdiag[2].'. </span><span class="texto">'.$rowdiag[3].'</span><br>'; }
			?>
			</td>
		  </tr>
		  <tr bgcolor="#E3E3E6">
			<td class="textoN">Tratamiento / Plan </td>
			<td class="texto" colspan="3"><?php  echo $rowr[3]; ?></td>
		  </tr>
		    <?php 
  $r_estu= new res_estudio('',$visita,'');
		$bus_r_e=$r_estu->cons_res_estudio2($visita);
  ?>
		  <tr >
			<td class="textoN">Informe de Estudio</td>
			<td class="texto" colspan="3"><a href="javascript:mostrarVentana();">aquí</a>
<div id="miVentana" style="position: fixed; width: 450px; height: 300px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; border: #000000 3px solid; background-color: #FAFAFA; color: #000000; display:none;">
 <div style="font-weight: bold; text-align: left; color: #FFFFFF; padding: 5px; background-color:#FF8C00" align="center"><img src="imagenes/inf_medico.png" width="60" height="60"> &nbsp;&nbsp;INFORME RESULTADO DE ESTUDIO</div>
 <p style="padding: 5px; text-align: justify; line-height:normal"><textarea id="resuL_infor" name="resuL_infor" cols="60" rows="13"><?php  if($bus_r_e!="") echo $bus_r_e; ?></textarea></p>
  <div style="padding: 5px; background-color: ; text-align: center; margin-top: 10px;"><input id="btnAceptar" onclick="ocultarVentana();" name="btnAceptar" size="20" type="button" value="Aceptar" />
 </div>
</div>
  	</td>
		  </tr>
			<tr >
			<td class="textoN">Indicaciones</td>
			<td class="texto" colspan="3"><?php  echo $rowr[4]; ?></td>
		  </tr>
		
		  <tr bgcolor="#E3E3E6">
			<td class="textoN">Conclusiones</td>
			<td class="texto" colspan="3"><?php  echo $rowr[7]; ?></td>
		  </tr>
		  <tr>
			<td class="textoN">Recomendaciones</td>
			<td class="texto" colspan="3"><?php  echo $rowr[5]; ?></td>
		  </tr>
		  <tr bgcolor="#E3E3E6">
			<td class="textoN">Reposo</td>
			<td class="texto" colspan="3" ><?php  echo $rowr[6]; ?></td>
		  </tr>
		  <tr>
			<td class="textoN">Observaci&oacute;n</td>
			<td colspan="3" class="texto"><?php  echo $rowr[9]; ?></td>
		  </tr>
		  <tr>
			<td colspan="4" ><hr size="0" width="100%"></td>
		  </tr>
		   <tr><td class="textoN">Referencias</td>
		   <td class="texto" colspan="3">
		   <table width="474" border="0" cellspacing="0" cellpadding="0">
		   <?php  $ref= new referencia('','','','','','','','','','',''); 
					$lref=$ref->lista_esp_ref($visita);
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
								  $espa='&nbsp;&nbsp;&nbsp;&nbsp;';
								  $color='bgcolor="#FFFFFF"';
								  $valor=$row7[2];
								}
								else
								{
								  $color='bgcolor="#E3E3E6"';
								  $valor=$row7[1];
								} //'.$color.'
								echo '<tr class="texto"  >
										<td width="251">'.ucwords(strtolower($row7[7])).$espa.ucwords(strtolower($row7[3])).'</td>
										<td width="223">'.$obr.'</td></tr>';
							}
						}
					}
					else
					   echo '<tr class="texto"><td><span class="mensaje">No hay referencias para listar</span></td></tr>';
					?>&nbsp;
			</table>
			</td>
		  </tr>
		  <tr>
			<td colspan="4" ><hr size="0" width="100%"></td>
		  </tr>
		
		   <tr>
			<td class="textoN">Solicitudes</td>
			<td class="texto" colspan="3" >
				<table width="474" border="0" cellspacing="0" cellpadding="0">
				<?php 	$sol= new solicitud('',''); 
					$lsol=$sol->lista_sol($visita);
					if($lsol!='false')
					{
						$contSol=0;
						while($row8 = mysql_fetch_row($lsol))
						{
							$contSol++;
							$cqs='';
							$obs='';
							if ($row8[3]>0)
							{ $cqs='checked';
							  $obs=$row8[4];
							  $habil='';
							
								echo '<tr class="texto"><td width="251">'.$row8[1].'</td>
								<td width="223">'.$obs.'</td></tr>';
							}
		
						}
						echo '<input name="ocsol" id="ocsol" type="hidden" value="'.$contSol.'" />';
					}
					else
					   echo '<tr class="texto"><td><span class="mensaje">No hay solicitudes para listar</span></td></tr>';
		
				 ?>
				</table>
			</td>
		  </tr>
		  <tr>
			<td colspan="4" ><hr size="0" width="100%"></td>
		  </tr>
		  <?php  $labv=$vis->ver_lab_visita();
			 if($labv!=false)
			 {   ?>
		  <tr>
			<td class="textoN">&Oacute;rdenes de Laboratorio Asociadas </td>
			<td colspan="3" >
			  <?php  while($rowlv=mysql_fetch_array($labv))
				 { echo '<span class="texto" onclick="imprimir('."'".'orden_pdf.php?orden='.$rowlv[0]."'".');" style="cursor:hand; text-decoration:underline ">Orden de Laboratorio No. '.$rowlv[0].'</span> - 
				         <span class="texto" onclick="imprimir('."'".'resultado_exa_imp.php?orden='.$rowlv[0]."'".');" style="cursor:hand; text-decoration:underline ">Resultado de Orden No. '.$rowlv[0].'</span><br>'; 
				 }?>
			</td>
		  </tr>
		  <?php  }?>

		  <tr>
			<td colspan="4" ><hr size="0" width="100%"></td>
		  </tr>
		  <tr>
			<td colspan="4" >
			 <div align="center" id="ImpriVis" class="textoN">
			   <p>
			     <label>
			     <input type="checkbox" name="logo" value="123" onclick="imprimir_con_logo(this.value)" >
			     Mostrar logo en documento 
				 <input type="checkbox" name="critico" value="999" onclick="imprimir_con_critico(this.value)" >
			     Mostrar resultados Estudios/Laboratorio 
			     </label>
				 
</p>
			   <p>
			     <input class="textoN" name="imprSol" id="imprSol" type="button" onclick="imprimir('referencia_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Referencia" />
			     <input class="textoN" name="imprRef" id="imprRef" type="button" onclick="imprimir('solicitud_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="solicitud" />
			     <input class="textoN" name="imprRecInd" id="imprRecInd" type="button" onclick="imprimir('recipe_indic_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Récipe/Indic" />
			     <input class="textoN" name="imprInforme" id="imprInforme" type="button" onclick="imprimir('informe_med_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Informe" />
			     <input class="textoN" name="imprConst" id="imprConst" type="button" onclick="imprimir('constancia_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Constancia" />
			     <!--
				 <input class="textoN" name="imprCrit" id="imprCrit" type="button" onclick="imprimir('informe_critico_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Paciente Cronico" />
				 -->
			     <br>
			     <br>
			     <input class="textoN" name="imp_res_estudio" id="imp_res_estudio" type="button" onclick="imprimir('res_estudio_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Resultado de Estudio" />
				<input class="textoN" name="imprInfMO" id="imprInfMO" type="button" onclick="imprimir('med_ocu_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Informe Medicina Ocupacional" />
				<!--
				<input class="textoN" name="imprInfMF" id="imprInfMF" type="button" onclick="imprimir('med_fam_pdf.php?vis=<?php  echo $visita; ?>&log=<?php  echo $log;?>');" value="Informe Medicina Familiar" />
				-->
				</p>
			 </div>
			 </td>
		  </tr>

		</table>
	</td>
  </tr>
</table>

<!-- Fin de Resultados de la visita -->	  
	  </td>
     </tr>
	</table>
	</td>
  </tr>
  


</table>
</form>
</div>
</body>
</html>
