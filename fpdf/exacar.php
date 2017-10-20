<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>

function enviar()
{
	if(document.getElementById("perfil").value==0 || document.getElementById("exame").value==0)
	{
		alert('Debe seleccionar tanto el perfil como el examen')
	}
	else
	{
		var indice = document.form1.perfil.selectedIndex; 
		document.form1.perfilocu.value=document.form1.perfil.options[indice].text;
		var indice2 = document.form1.exame.selectedIndex; 
		document.form1.exaocu.value=document.form1.exame.options[indice2].text;
		document.form1.action ="exacardet.php";
		document.form1.submit();
	}
}
</script>
<body>
<?php  
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
?>
<form name="form1" id="form1" method="post" action="exacar.php">
<table width="436" border="0" align="center">
  <tr class="titulofor">
    <td height="30" colspan="3"><div align="center" class="titulofor">Caracter&iacute;sticas del Examen </div></td>
  </tr>
  <tr>
    <td width="60" class="etiqueta">Perfil:</td>
    <td width="366" colspan="2">
      <?php  $perf=new perfil($_POST['perfil'],'','','');
	        $listaperf=$perf->combo_perfil(); ?>
      <select name="perfil" class="texto" id="perfil" onchange="submit();">
        <option value="0">Seleccione</option>
        <?php  if ($listaperf!=false) echo $listaperf;?>
      </select>
      <input name="perfilocu" type="hidden" value="0" />
    </td>
  </tr>
  <?php  if($_POST['perfil']!='')
	{ 
		$exa=new examen('','','','','','','','','');
	    $listaexa=$exa->combo_examen_perf($_POST['perfil']);
	
	} ?>
  <tr>
    <td class="etiqueta">Examen:</td>
    <td colspan="2">
      <select name="exame" class="texto" id="exame">
        <option value="0">Seleccione</option>
        <?php  if ($listaexa!=false) echo $listaexa;?>
      </select>
	  <input name="exaocu" type="hidden" value="0" />
    </td>
  </tr>

  <tr>
    <td colspan="3"><div align="center">
	<img src="imagenes/p_ingresar1.gif" alt="Nueva unidad de medida" width="140" height="50" style="cursor:hand" onclick="enviar();" 
		onmouseover="this.src='imagenes/a_ingresar1.gif'"  onmouseout="this.src='imagenes/p_ingresar1.gif'"/>
	<img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
  </tr>
</table>

</form>
</body>
</html>
