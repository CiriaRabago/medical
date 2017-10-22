<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
-->
</style>
</head>
<script>

function ver_ser(codi)
{
	if (document.getElementById('servi'+codi).style.display=="none")
	{	document.getElementById('servi'+codi).style.display='block'; }
	else
	{	document.getElementById('servi'+codi).style.display="none"; }
}

function verat(codi)
{

	if (document.getElementById('at'+codi).style.display=="none")
	{	document.getElementById('at'+codi).style.display='block'; }
	else
	{	document.getElementById('at'+codi).style.display="none"; }

}

function atendio(idv,dv,sv)
{
	/*alert(idv);
	alert(dv);
	alert(sv);
	alert(document.getElementById('cmat'+idv).value);*/
	
	if(sv=='E' && document.getElementById('cmat'+idv).value=='')
	{
		alert('Debe Indicar una observación para eliminar el registro');
		return false;
	}

	
	document.getElementById('ativ').value=idv;
	document.getElementById('atdv').value=dv;
	document.getElementById('atsv').value=sv;
	document.getElementById('cmv').value=document.getElementById('cmat'+idv).value;
    document.form1.submit();
}

</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="por_atender.php">

<?php  		
	$ser= new servicio(0,'','','','','','',0);
   	$ver=$ser->ver_serv_LE();
    if ($ver==false)
	{
		echo "<script>alert('No hay Pacientes en Espera de Ningún Servicio');</script>";
	} 
	else
	{  
		echo '<table width="700" border="0" cellspacing="0" cellpadding="0">
				<tr class="titulofor">
					<td height="30"><div align="center" class="titulofor">Servicios</div></td>
				</tr>
				<tr><td height="20" class="textoN" align="center"><br>
					<select class="texto" name="servi" onchange="submit();">
					  <option value="0" selected>Seleccione -----></option>';
		while ($row = mysql_fetch_row($ver))
		{
			if($_POST["servi"]==$row[0])
			{
			  $sel="selected";
			  $nombser=$row[1];
			 }
			 else
			  $sel="";
			echo '<option '.$sel.' value="'.$row[0].'">'.$row[1].'</option>';
		}
		echo '</select></table></td></tr>';
	}
	if($_POST["servi"]!=0)
	{

		$ser->cod=$_POST["servi"];

		if($_POST["ativ"]!=0)
		{
			//P=Pendiente, L=Lista Espera, A=Atendido, I=Incompleto, E=Eliminado
			$vis= new visita($_POST["ativ"],$ser->cod,$_POST["ocuced"],$num,$_POST["fac"],$_POST["mot"],'','',$stav,'',$_SESSION["cedu_usu"],$_POST["esp"],$_POST["codemp"]);
			$modifvis=false;
			if($_POST["atdv"]!=0)
			{
				$mdvis=$vis->mod_det_visita($_POST["ativ"],$_POST["atdv"],$_SESSION['cedu_usu'],$_POST["atsv"],$_POST["cmv"]);
				if($mdvis==true)
				{
					$modifvis=true;
					$modifvis=$vis->mod_sta_visita_mult();
				}
			}
			else
			{
				$modifvis=$vis->mod_sta_visita_uni($_POST["atsv"]);
			}
			if ($modifvis!=false)
			{
				$agregsta=$vis->ins_sta_det_visita($_POST["atdv"],$_POST["atsv"],$ser->cod,$_SESSION["cedu_usu"],$_POST["ativ"],$_POST["cmv"]);
				if($agregsta==false)
				{ 
				   echo '<script>alert("ocurrio un error al modificar el registro");</script>';
				}
			}
		}
		
		$pac=$ser->ver_pac_LE();
		if ($pac==false)
		{
			echo "<script>alert('No hay Pacientes en Espera de Servicio');</script>";
		} 
		else
		{
			echo '<tr><td><br><table width="700" border="0" cellspacing="0" cellpadding="0" id="servi'.$row[0].'">
					  <tr class="titulorep">
						<td width="80">Cedula</td>
						<td width="250">Nombre</td>
						<td width="40">Edad</td>
						<td width="60">Hora</td>
						<td width="200">Medico</td>
						<td width="70">Atender</td>
					  </tr>';
			$cont=0;
			while ($row2 = mysql_fetch_row($pac))
			{
				if($_POST["servi"]!=0 && ereg('LAB',$nombser))
				 $cor='&nbsp;<span style="cursor:hand; text-decoration:underline" onclick="
				 window.open('."'orden_pac.php?visi=".$row2[0]."&pac=".$row2[1]."','ORDEN','top=50,left=200,height=600,width=800,status=1,scrollbars=YES,resizable=YES'".')">Orden</span>';
				else
				 $cor='';
				 
				if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
				$cont++;
				echo '<tr class="textoN" '.$color.' >
						<td width="80" height="22">'.$row2[2].'</td>
						<td width="250"><a href="VisitaCompleta.php?visi='.$row2[0].'&idpac='.$row2[1].'&npac='.$row2[3].'&detvis='.$row2[6].'&servis='.$_POST["servi"].'">'.$row2[3].'</a></td>
						<td width="40">'.$row2[8].'</td>
						<td width="60">'.$row2[7].'</td>
						<td width="200">'.$row2[11].'</td>
						<td width="70"><span style="cursor:hand; text-decoration:underline" onclick="verat('.$row2[0].')">Atención</span>'.$cor.'</td>
					  </tr>
					  <tr class="textoN" '.$color.' style="display:none;" id="at'.$row2[0].'" >
						<td width="700" colspan="6" align="center" height="22">Observación: <input class="texto" name="cmat'.$row2[0].'" id="cmat'.$row2[0].'" value="" type="text" size="50" /> 
												   <input class="texto" name="aten'.$row2[0].'" id="aten'.$row2[0].'" value="Atendido" onclick="atendio('.$row2[0].','.$row2[6].','."'A'".')" type="button" />
												   <input class="texto" name="inco'.$row2[0].'" id="inco'.$row2[0].'" value="Incompleto" onclick="atendio('.$row2[0].','.$row2[6].','."'I'".')" type="button" />
												   <input class="texto" name="pend'.$row2[0].'" id="pend'.$row2[0].'" value="Pendiente" onclick="atendio('.$row2[0].','.$row2[6].','."'P'".')" type="button" />
												   <input class="texto" name="elim'.$row2[0].'" id="elim'.$row2[0].'" value="Eliminado" onclick="atendio('.$row2[0].','.$row2[6].','."'E'".')" type="button" /></td>
					  </tr>';
			}
			echo '</table></td></tr>';
		}  
	} // Fin sii hay un servicio seleccionado
	?>
	<input name="ativ" id="ativ" type="hidden" value="0" />
	<input name="atdv" id="atdv" type="hidden" value="0" />
	<input name="atsv" id="atsv" type="hidden" value="" />
	<input name="cmv" id="cmv" type="hidden" value="" />
	
</form>
</body>
</html>
