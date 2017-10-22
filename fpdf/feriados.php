<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_feriado.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
function eliminar()
{  if (document.form1.ocu_N.value==0)
	{	
		alert("Para Eliminar, Debe Seleccionar un registro de la lista");
	}
	else
	{	
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
			document.form1.ocu_e.value=1;
   			document.form1.submit();
		}
	}
}
function Nuevo()
{  
	document.getElementById("perfil").value='0';
	document.getElementById("exame").value='0';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  
	if (document.getElementById("dia").value!='0' && document.getElementById("mes").value!='0' && document.getElementById("descr").value!='')
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	
	if (document.getElementById("dia").value=='0' || document.getElementById("mes").value=='0' || document.getElementById("descr").value=='')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("dia").value=trozos[1];
	document.getElementById("mes").value=trozos[2];
	document.getElementById("descr").value=trozos[3];
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body>
<form id="form1" name="form1" method="post" action="feriados.php">
<?php 
 $fer=new feriado('',$_POST["dia"],$_POST["mes"],$_POST["descr"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$fer->buscar();
	if ($bus=='true')
	{   
		$gua=$fer->mod_feriado();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	else
	{   
		$gua=$fer->ins_feriado();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	//}
  }
   if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{			$gua=$fer->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
 ?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Dias Feriados</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Dia:</td>
      <td colspan="3" class="texto Estilo2"><label>
          <select name="dia" class="texto" id="dia" >
			<option value="0" selected="selected">Seleccione---&gt;</option>
			<?php  for($x=1;$x<32;$x++) echo "<option value='".$x."'>".$x."</option>";?>			
          </select>		   
          <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Mes:</td>
      <td colspan="3"><label>      
	  <select name="mes" class="texto" id="mes">
		<option value="0" selected="selected">Seleccione---&gt;</option>
		<?php  for($x=1;$x<13;$x++) echo "<option value='".$x."'>".$x."</option>";?>			
      </select>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Descripcion:</td>
      <td colspan="3"><label>  		     
      <input name="descr" id="descr" type="text" class="texto" size="80" value=""/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">

      	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

      <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/>  </td>
    </tr>
  </table>
 <?php    
   $ver=$fer->ver_feriados();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los dias Feriados');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?>
</form>
</body>
</html>
