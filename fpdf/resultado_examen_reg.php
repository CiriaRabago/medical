<?php  
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

function enviar()
{

	var indice = document.form1.perfil.selectedIndex; 
	document.form1.perfilocu.value=document.form1.perfil.options[indice].text;
	document.form1.action='resultado_examen.php';
	document.form1.submit();
}

</script>
<body>
<?php 
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
?>

<form name="form1" id="form1" method="post" action="resultado_examen_reg.php">
<table width="500" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="3"><div align="center" class="titulofor">Resultados</div></td>
    </tr>
    <tr>
      <td width="130" class="etiqueta">C&eacute;dula de Identidad:</td>
      <td width="360" colspan="2" class="texto"><?php echo $_POST['cedula']; ?>
	  <input name="cedula" id="cedula" type="hidden" value="<?php echo $_POST['cedula']; ?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre y Apellido:</td>
      <td colspan="2"  class="texto"><?php echo $_POST['nombre']; ?>
            <input name="nombre" id="nombre" type="hidden" value="<?php echo $_POST['nombre']; ?>" />
      </td>
    </tr>
	<tr>
      <td class="etiqueta">Edad:</td>
      <td colspan="2"  class="texto"><?php echo $_POST['edad']; ?>
            <input name="edad" id="edad" type="hidden" value="<?php echo $_POST['edad']; ?>" />
      </td>
    </tr>
	<?php 
	if($_POST['sexo']=='F') $nombsexo='Femenino';
	     else
    if($_POST['sexo']=='M') $nombsexo='Masculino'; ?>
	<tr>
      <td class="etiqueta">Sexo:</td>
      <td colspan="2"  class="texto"><?php echo $nombsexo; ?>
            <input name="sexo" id="sexo" type="hidden" value="<?php echo $_POST['sexo']; ?>" />
			<input name="sexonom" id="sexonom" type="hidden" value="<?php echo $nombsexo; ?>" />
      </td>
    </tr>
	<tr>
      <td class="etiqueta">Perfil:</td>
      <td colspan="2">
	  <?php $perf=new perfil($_POST['perfil'],'','');
	        $listaperf=$perf->combo_perfil(); ?>

          <select name="perfil" class="texto" id="perfil" onchange="submit();">
            <option value="0">Seleccione</option>
			<?php if ($listaperf!=false) echo $listaperf;?>
			
        </select>
        <input name="perfilocu" type="hidden" value="0" />
      </td>
    </tr>
	<?php if($_POST['perfil']!='')
	{ 
		$exa=new examen('','','','','','','','','');
	    $listaexa=$exa->combo_examen_perf($_POST['perfil']);
	
	} ?>
	<tr>
      <td class="etiqueta">Examen:</td>
      <td colspan="2">
      <select name="exame" class="texto" id="exame">
        <option value="0">Seleccione</option>
		<?php if ($listaexa!=false) echo $listaexa;?>
      </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center"><img src="imagenes/p_ingresar1.gif" alt="Nueva unidad de medida" width="140" height="50" style="cursor:hand" onclick="enviar();" 
		onmouseover="this.src='imagenes/a_ingresar1.gif'"  onmouseout="this.src='imagenes/p_ingresar1.gif'"/><img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='resultado.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
  </table>
</form>
</body>
</html>
