<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>

/*function enviar()
{

	var indice = document.form1.perfil.selectedIndex; 
	document.form1.perfilocu.value=document.form1.perfil.options[indice].text;
	document.form1.action='resultado_examen.php';
	document.form1.submit();
}*/


function ver()
{
 document.form1.submit();
}

function ver_planti(idexa,idper)
{
	document.form1.action='plantilla.php?exa='+idexa+'&per='+idper;
	document.form1.submit();
}

</script>
<body>
<?php  
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php";
include "clases/clase_orden.php";
include "clases/clase_perexa.php";
?>

<form name="form1" id="form1" method="post" action="ver_plantilla.php">
<?php 
 
if ($_POST["perfil"]>'0')
		$val=$_POST["perfil"]; 
  else
		$val='0';
 $pex= new perexa($_POST["ocu_N"],$_POST["perfil"],$_POST["exame"]);
?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Examenes por Perfil</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Perfil:</td>
      <td colspan="3" class="texto Estilo2"><label>
         <?php  $perf=new perfil('','','','');
	        $listaperf=$perf->combo_perfil(); ?>

          <select name="perfil" class="texto" id="perfil" onchange="ver();" >
			<option value="0">Seleccione---&gt;</option>
			<?php  if ($listaperf!=false) echo $listaperf;?>
			
          </select>
		   <script> document.getElementById("perfil").value="<?php  echo $val; ?>"; </script>
          <span class="Estilo3">* </span> </label></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4">
        <div align="center">
          <input name="ocu_g" type="hidden" value="0"/>  
          <input type="hidden" name="ocu_e" value="0"/>      
      <img src="imagenes/p_salir1.gif" alt="Salir al Menu Reportes" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
  </table>
 <?php  
   $ver=$pex->ver_exa_per_planti($val);
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
