<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php";
include "clases/clase_examen.php";
include "clases/clase_ordexa.php";
include "clases/clase_perexa.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
-->
</style>
</head>
<script>
function ver()
{
 document.form1.submit();
}
function Guardar()
{  
	if (document.getElementById("perfil").value!='0' && document.getElementById("exame").value!='0' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("perfil").value!='' && document.getElementById("exame").value!='' && document.form1.ocu_N.value!=0)
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("perfil").value=='0' || document.getElementById("exame").value=='0')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");	
	document.getElementById("perfil").value=trozos[0];
	document.getElementById("exame").value=trozos[1];
	document.getElementById("orden").value=trozos[2];
	document.form1.ocu_N.value=trozos[0].toString();
	
}
</script>
<body>
<form id="form1" name="form1" method="post" action="">
<?php
 
if ($_POST["perfil"]>'0')
		$val=$_POST["perfil"]; 
  else
		$val='0';
 $pex= new ordexa($_POST["ocu_N"],$_POST["perfil"],$_POST["exame"],$_POST["orden"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$gua=$pex->modf_ordexa();
	if ($gua)
		echo '<script>alert("Registro Modificado Exitosamente");</script>';
	else
		echo '<script>alert("El Registro no pudo ser Modificado");</script>';
  }
 ?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Examenes por Area</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Area:</td>
      <td colspan="3" class="texto Estilo2"><label>
         <?php 
	        $listaperf=$pex->combo_perfil(); ?>
          <select name="perfil" class="texto" id="perfil" onchange="ver();" >
			<option value="0">Seleccione---&gt;</option>
			<?php if ($listaperf!=false) echo $listaperf;?>
			
          </select>
		   <script> document.getElementById("perfil").value="<?php echo $val; ?>"; </script>
          <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Examen:</td>
      <td colspan="3"><label>      
	  <select name="exame" class="texto" id="exame">
		<option value="0">Seleccione---&gt;</option>
		<?php 
		 $listaexa=$pex->combo_exam($_POST['perfil']);
		if ($listaexa!=false) echo $listaexa;?>
      </select>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Orden de examen:</td>
      <td colspan="3"><label> 
      <input name="orden" id="orden" type="text" value="0" class="texto"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4"><img src="imagenes/p_guardar1.gif" alt="Guardar La relacion del perfil con el examen" width="140" height="50" style="cursor:hand" onclick="Guardar();" 
		onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
      <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/>      <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></td>
    </tr>
  </table>
 <?php 
   $ver=$pex->ver_ordexa($val);
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Examenes por Perfil');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?>
</form>
</body>
</html>
