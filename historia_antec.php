<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_historia.php";
$visita=$_GET['visi'];	
$ipaci=$_GET['idpac'];
$npaci=$_GET['npac'];
$devi=$_GET['detvis'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<script>
function ver_tipoc(codi)
{
	if (document.getElementById('tipcon'+codi).style.display=="none")
	{	document.getElementById('tipcon'+codi).style.display='block'; }
	else
	{	document.getElementById('tipcon'+codi).style.display="none"; }
    window.parent.document.getElementById("forma1").height = document.getElementById("Contenido").offsetHeight;
}

function guardarHA()
{
	document.getElementById('ocugua').value=1;
	document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
	document.form1.submit();
}

function imprimir(ventana)
{
	window.open(ventana,'','width=700,height=450,resizable=yes,scrollbars=yes');
}
</script>

<script type="text/javascript">
//redimencionamiento del iframe segun el contenido
    window.onload = function() {
    window.parent.document.getElementById("forma1").height = document.getElementById("Contenido").offsetHeight;
    }
</script>

<body>
<form action="historia_antec.php" method="post" name="form1">

<?php 
if($_POST['ocugua']==1)
{
  $cha=$_POST['contCondiHA'];
  $cp=$_POST['oidpac'];
  $guard=true;
  for($i=1;$i<=$cha;$i++)
  {
		$usu=$_SESSION['cedu_usu'];
		$condi=$_POST['condiHA'.$i];
		$valorcm='';
		if($_POST['valorHA'.$i])
		{ 
			if($_POST['valorHA'.$i]!="")
			{
				$valorcm=$_POST['valorHA'.$i];
			}
		}
		
		$bandgua=true;
		if(isset($_POST['rbHA'.$i]))
		{
			$ha= new historiaA('',$cp,$condi,$_POST['rbHA'.$i],$valorcm, $usu);
			$acc=$ha->consul_hist_hau();
			if($acc=='ins')
				if($ha->ins_hist_ha()==false)
					$bandgua=false;
			if($acc=='upd')
				if($ha->mod_hist_hau()==false)
					$bandgua=false;
		}
		else
		{
			$poscq='occhha'.$i;
			if($_POST[$poscq])
			{
				$ha= new historiaA('',$cp, $condi, '', '', $usu);
				$eliham=$ha->eli_hist_ham();
				for($k=1;$k<=$_POST[$poscq];$k++)
				{
					$opcqd='cqHA*'.$i.'*'.$k;
					if($_POST[$opcqd])
					{
						$ha= new historiaA('',$cp,$condi,$_POST[$opcqd],$valorcm, $usu);
						if($ha->ins_hist_ha()==false)
							$bandgua=false;
					}
				}
			}
			else
			{
				if($valorcm!='')
				{
					$ha= new historiaA('',$cp,$condi,0,$valorcm, $usu);
					$acc=$ha->consul_hist_hau();
					if($acc=='ins')
						if($ha->ins_hist_ha()==false)
							$bandgua=false;
					if($acc=='upd')
						if($ha->mod_hist_hau()==false)
							$bandgua=false;
				}
			}
		}
  }
  if($bandgua==true)
    echo "<script>alert('Historia - Antecedentes Guardada con Exito')</script>";
  else
    echo "<script>alert('Error al guardar Historia - Antecedentes')</script>";

	$visita=$_POST['oidvis'];	
	$ipaci=$_POST['oidpac'];
	$devi=$_POST['oiddevi'];
} 
?>

<div id="Contenido"> 
<input name="oidpac" id="oidpac" type="hidden" value="<?php echo $ipaci; ?>" />
<input name="oidvis" id="oidvis" type="hidden" value="<?php echo $visita; ?>" />
<input name="oiddevi" id="oiddevi" type="hidden" value="<?php echo $devi; ?>" />

<table width="704" border="0" cellspacing="1" cellpadding="0" >
  <tr>
    <td height="30" colspan="3" align="center" class="titulofor">HISTORIA - ANTECEDENTES</td>
  </tr>
  <tr>
    <td colspan="3"><?php
	    $vis= new visita($visita,'','','','','','','','','','','','');
	 	$tipHA=$vis->tipos_cond_H('1');
		if ($tipHA==false)
		{
		   echo "<script>alert('Verifique las condiciones asociadas a la historia');</script>";
		} 
		else
		{  
			echo '<table width="702" border="0" cellspacing="1" cellpadding="0">';
			$contHA=0;
			while ($row = mysql_fetch_row($tipHA))
			{
				
				echo '<tr class="titulorep"><td height="20" style="cursor:hand" onclick="ver_tipoc('.$row[0].');">'.$row[1].'</td></tr>';
				$condHA=$vis->condicionesH($row[0],$ipaci);
				if($condHA!=false)
				{
					  echo '<tr><td><table width="700" border="0" cellspacing="1" cellpadding="0" id="tipcon'.$row[0].'" style="display:none">';
					  $cont=0;
					  while($row2 = mysql_fetch_row($condHA))
					  {
							$contHA++;
							if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
							$cont++;
							echo'<tr height="15"  class="texto" '.$color.' >
								<td width="200" class="textoN">'.$row2[1].'<input name="condiHA'.$contHA.'" id="condiHA'.$contHA.'" type="hidden" value="'.$row2[0].'" /></td>
								<td width="500"><table cellspacing="0" cellpadding="0"  border="0"><tr>';
			
								$valcond=$vis->valorescond($row2[0],$ipaci);
								if($row2[4]=='S')
								{
									
									if($row2[2]=='S')
									{
										$cchha=0;
										echo '<td width="360" class="texto">';
										while($row3 = mysql_fetch_row($valcond))
										{
											$cchha++;
											if($row3[2]==0) $ck=''; else $ck='checked';
											echo '<input name="cqHA*'.$contHA.'*'.$cchha.'" id="cqHA*'.$contHA.'*'.$cchha.'" type="checkbox" '.$ck.' value="'.$row3[0].'" />'.$row3[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
										if($cchha>0)
											echo '<input name="occhha'.$contHA.'" id="occhha'.$contHA.'" type="hidden" value="'.$cchha.'" />';
									}
								}
								else
								{
									if($row2[2]=='S')
									{
										echo '<td width="360" class="texto">';
										while($row3 = mysql_fetch_row($valcond))
										{
											if($row3[2]==0) $ck=''; else $ck='checked';
											?> <input type="radio" <?php echo $ck;?>   name="rbHA<?php echo $contHA; ?>" id="rbHA<?php echo $contHA; ?>" value="<?php echo $row3[0]; ?>" />
											<?php echo $row3[1].'&nbsp;&nbsp;';
										}
										echo '&nbsp;</td>';
									}
								}

							  if($row2[5]!=NULL) $vcc=$row2[5]; else $vcc='';
							  if($row2[2]=='S') $posdiv='<td width="140" class="texto">'; else $posdiv='<td width="500" class="texto">';
							  echo $posdiv.'<input name="valorHA'.$contHA.'" id="valorHA'.$contHA.'" type="text" value="'.$vcc.'" class="texto" /></td>';
							?> <input name="idvcha<?php echo $contHA; ?>"  id="idvcha<?php echo $contHA; ?>"   type="hidden" value="0" /> <?php
							echo '</tr></table></td></tr>';
					  }
					  echo '</table></td></tr>';
				}
			}
			echo '</table>'; 
		} // Fin si encuentra tipos
		?>
		<input name="contCondiHA" id="contCondiHA" type="hidden" value="<?php echo $contHA; ?>" />
		<div id="cargar" align="center">
			<input class="textoN" name="HistoAnte" id="HistoAnte" type="button" value="Guardar Historia - Antecedentes" onclick="guardarHA();" />
			<input class="textoN" name="imprHA" id="imprHA" type="button" value="Imprimir Historia - Antecedentes" onclick="imprimir('historia_ant_pdf.php?vis=<?php echo $visita; ?>');" />
		</div>
		<input name="ocugua" id="ocugua" type="hidden" value="0" />
		<br>
	</td>
  </tr>
</table>
</form>
</div>
</body>
</html>
