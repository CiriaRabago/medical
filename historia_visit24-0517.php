<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_historia.php";
$fecha_ac= @date("Y-m-d");
$visita=$_GET['visi'];	
$ipaci=$_GET['idpac'];
$devi=$_GET['detvis']; 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<script>
function ver_tipoc(codi)
{
	if (document.getElementById('tipcon'+codi).style.display=="none")
	{	document.getElementById('tipcon'+codi).style.display='block'; }
	else
	{	document.getElementById('tipcon'+codi).style.display="none"; }
    window.parent.document.getElementById("forma2").height = document.getElementById("Contenido2").offsetHeight;
}

function GuardarHV()
{
	document.getElementById('ocuguahv').value=1;
	document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
	document.form3.submit();
}
function imprimir(ventana)
{
	window.open(ventana,'','width=700,height=450,resizable=yes,scrollbars=yes');
}

</script>

<script type="text/javascript">
//redimencionamiento del iframe segun el contenido
    window.onload = function() {
    window.parent.document.getElementById("forma2").height = document.getElementById("Contenido2").offsetHeight;
    }
</script>

<body>

<form action="historia_visit.php" method="post" name="form3">

<?php  
if($_POST['ocuguahv']==1)
{
  $chv=$_POST['contCondiHV'];
  $visita=$_POST['oidvishv'];
  $guard=true;
  for($i=1;$i<=$chv;$i++)
  {
		$usu=$_SESSION['cedu_usu'];
		$condi=$_POST['condiHV'.$i];
		$valorcm='';
		if($_POST['valorHV'.$i])
		{ 
			if($_POST['valorHV'.$i]!="")
			{
				$valorcm=$_POST['valorHV'.$i];
			}
		}
		
		$bandgua=true;
		if(isset($_POST['rbHV'.$i]))
		{                      
			$hv= new historiaV('',$visita,$condi,$_POST['rbHV'.$i],$valorcm, $usu);
			$acc=$hv->consul_hist_hvu();
			if($acc=='ins')
				if($hv->ins_hist_hv()==false)
					$bandgua=false;
			if($acc=='upd')
				if($hv->mod_hist_hvu()==false)
					$bandgua=false;
		}
		else
		{
			$poscq='occhhv'.$i;
			if($_POST[$poscq])
			{
				$hv= new historiaV('',$visita, $condi,'', '', $usu);
				$elihvm=$hv->eli_hist_hvm();
				for($k=1;$k<=$_POST[$poscq];$k++)
				{
					$opcqd='cqHV*'.$i.'*'.$k;
					if($_POST[$opcqd])
					{
						$hv= new historiaV('',$visita,$condi,$_POST[$opcqd],$valorcm, $usu);
						if($hv->ins_hist_hv()==false)
							$bandgua=false;
					}
				}
			}
			else
			{
				if($valorcm!='')
				{
					$hv= new historiaV('',$visita,$condi,0,$valorcm, $usu);
					$acc=$hv->consul_hist_hvu();
					if($acc=='ins')
						if($hv->ins_hist_hv()==false)
							$bandgua=false;
					if($acc=='upd')
						if($hv->mod_hist_hvu()==false)
							$bandgua=false;
				}
			}
		}
  }
  if($bandgua==true)
    echo "<script>alert('Historia - Visita Guardada con Exito')</script>";
  else
    echo "<script>alert('Error al guardar Historia - Visita')</script>";

	$visita=$_POST['oidvishv'];	
	$ipaci=$_POST['oidpachv'];
	$devi=$_POST['oiddevihv'];
	//die();
} 
?>

<div id="Contenido2"> 
<input name="oidpachv" id="oidpachv" type="hidden" value="<?php  echo $ipaci; ?>" />
<input name="oidvishv" id="oidvishv" type="hidden" value="<?php  echo $visita; ?>" />
<input name="oiddevihv" id="oiddevihv" type="hidden" value="<?php  echo $devi; ?>" />

<table width="704" border="0" cellspacing="1" cellpadding="0" >
  <tr>
    <td  height="30" colspan="3" align="center" class="titulofor">HISTORIA DE LA VISITA </td>
  </tr>
  <tr>
    <td colspan="3"><?php 
		$vis= new visita($visita,'','','','','','','','','','','','');
	 	$tipHV=$vis->tipos_cond_H('2'); 
		if ($tipHV==false)
		{
		   echo "<script>alert('Verifique las condiciones asociadas a la historia');</script>";
		} 
		else
		{  
			$contHV=0;
			echo '<table width="702" border="0" cellspacing="1" cellpadding="0">';
			while ($row4 = mysql_fetch_row($tipHV))
			{
				echo '<tr class="titulorep"><td height="20" style="cursor:hand" onclick="ver_tipoc('.$row4[0].');">'.$row4[1].'</td></tr>';
				if ($row4[0]==5) {
				
						$sql_sv="SELECT id_visita from slc_visita where slc_paciente_id_paciente='$ipaci' 
						and fecha_ing_visita>'$fecha_ac' and ((slc_servicio_id_servicio='226')or(slc_servicio_id_servicio='228')or(slc_servicio_id_servicio='227'))";
						$resultado_sv=mysql_query($sql_sv);
						$DATOS_sv=mysql_fetch_array($resultado_sv);
						if(($DATOS_sv[0])!=''){
							$visita2=$DATOS_sv[0];
							
				$condHV=$vis->condicionesHVI($row4[0],$visita2);
				}else{$condHV=$vis->condicionesHVI($row4[0],$visita);}
			}else{
				$condHV=$vis->condicionesHVI($row4[0],$visita);}
				if($condHV!=false)
				{
					  echo '<tr><td><table width="700" border="0" cellspacing="1" cellpadding="0" id="tipcon'.$row4[0].'" style="display:none">';
					  $cont2=0;
					  while($row5 = mysql_fetch_row($condHV))
					  {
							$contHV++;
							if ($cont2%2!=0) $color2='bgcolor="#E3E3E6"'; else $color2='';
							$cont2++;
							echo'<tr height="15"  class="texto" '.$color2.' >
								<td width="200" class="textoN">'.$row5[1].'<input name="condiHV'.$contHV.'" id="condiHV'.$contHV.'" type="hidden" value="'.$row5[0].'" /></td>
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
											echo '<input name="cqHV*'.$contHV.'*'.$cchhv.'" id="cqHV*'.$contHV.'*'.$cchhv.'" type="checkbox" '.$ck.' value="'.$row6[0].'" />'.$row6[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
										if($cchhv>0)
											echo '<input name="occhhv'.$contHV.'" id="occhhv'.$contHV.'" type="hidden" value="'.$cchhv.'" />';
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
											?> <input type="radio" <?php  echo $ck;?>   name="rbHV<?php  echo $contHV; ?>" id="rbHV<?php  echo $contHV; ?>" value="<?php  echo $row6[0]; ?>" />
											<?php  echo $row6[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
									}
								}
							
							 if($row5[5]!=NULL) $vcc=$row5[5]; else $vcc='';
							 if($row5[2]=='S') $posdiv='<td width="140" class="texto">'; else $posdiv='<td width="500" class="texto">';
							 echo $posdiv.'<input name="valorHV'.$contHV.'" id="valorHV'.$contHV.'" type="text" value="'.$vcc.'" class="texto"  size="60"/></td>';
							?> <input name="idvchv<?php  echo $contHV; ?>" id="idvchv<?php  echo $contHV; ?>" type="hidden" value="0" /> <?php 
							echo '</tr></table></td></tr>';
					  }
					  echo '</table></td></tr>';
				}
			}
			echo '</table>'; 
		} // Fin si encuentra tipos
		?>
		
		<input name="contCondiHV" id="contCondiHV" type="hidden" value="<?php  echo $contHV; ?>" />
		<div id="cargar" align="center">
			<input class="textoN" name="HistoVisi" id="HistoVisi" type="button" value="Guardar Historia - Visita"  onclick="GuardarHV();" />
			<input class="textoN" name="imprHV" id="imprHV" type="button" value="Imprimir Historia - Visita" onclick="imprimir('historia_vis_pdf.php?vis=<?php  echo $visita; ?>');" />
		</div>
		<input name="ocuguahv" id="ocuguahv" type="hidden" value="0" />
		<br>
	</td>
  </tr>
</table>
</form>
</div>
</body>
</html>
