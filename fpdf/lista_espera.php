<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
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

</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="lista_espera.php">
<?php  $ser= new servicio(0,'','','','','','',0);
   		$ver=$ser->ver_serv_LE();
		//echo  '<br>'.$ver.'<br>';
        if ($ver==false)
		{
		   echo "<script>alert('No hay Pacientes en Espera de Servicio');</script>";
		} 
		else
		{  
			echo '<table width="700" border="0" cellspacing="1" cellpadding="0" style="background-color:#A8A9AD">
					<tr class="titulofor">
					  <td height="30"><div align="center" class="titulofor">Servicios</div></td>
					</tr>';
			while ($row = mysql_fetch_row($ver))
			{
				 echo '<tr><td height="20" class="textoN" style="background-color:#F9D5B2;cursor:hand" onclick="ver_ser('.$row[0].');">'.$row[1].'</td></tr>';
				 $ser->cod=$row[0];
				 $pac=$ser->ver_pac_LE();
				 if ($pac==false)
				{
					echo "<script>alert('No hay Pacientes en Espera de Servicio');</script>";
				} 
				else
				{
					echo '<tr><td><table width="698" border="0" cellspacing="0" cellpadding="0" id="servi'.$row[0].'" style="display:none;">
					  <tr class="titulorep" height="15">
					    <td width="20">N?</td>
						<td width="80">Cedula</td>
						<td width="260">Nombre</td>
						<td width="40">Edad</td>
						<td width="60">Hora</td>
						<td width="238">Medico</td>
					  </tr>';
					$cont=0;
					while ($row2 = mysql_fetch_row($pac))
					{
						$cont++;
						echo '<tr class="textoN" style="background-color:#FFFFFF"  height="15">
								<td width="20">'.$cont.'</td>
								<td width="80">'.$row2[2].'</td>
								<td width="260">'.$row2[3].'</td>
								<td width="40">'.$row2[8].'</td>
								<td width="60">'.$row2[7].'</td>
								<td width="238">'.$row2[11].'</td>
							  </tr>';
					}
					echo '</table></td></tr>';
				}  
			}
			echo '</table>';
		}
		?>
		
</form>
</body>
</html>
