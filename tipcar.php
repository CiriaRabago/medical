<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_tipcar.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	document.getElementById("nomb").value='';
	document.getElementById("descrip").value='';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	if (document.getElementById("nomb").value!='' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("nomb").value!='' && document.form1.ocu_N.value!=0)
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("nomb").value=='')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("nomb").value=trozos[1];
	document.getElementById("descrip").value=trozos[2];
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body>

<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="tipcar.php">
<?php  
 $tip= new tipcar($_POST["ocu_N"],$_POST["nomb"],$_POST["descrip"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$tip->buscar();
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$tip->modf_tipcar();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$tip->ins_tipcar();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	}
  }
  if (isset($_POST["ocu_e"]) && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
	$gua=$tip->bus_tipcar();
		if ($gua=='true')
			echo '<script>alert("Registro No puede ser eliminado por estar asignado a caracteristicas");</script>';
		else
			{
				$gua=$tip->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
	}
 ?>
 <table width="633" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Tipos de Caracter&iacute;sticas</div></td>
    </tr>
    <tr>
      <td width="147" class="etiqueta">Nombre del Tipo :</td>
      <td width="476" colspan="3" class="texto Estilo2"><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50" onkeypress='return sincomillas(event)'/>
        <span class="Estilo3">*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td colspan="3"><label>
        <input name="descrip" type="text" class="texto" id="descrip" size="50" onkeypress='return sincomillas(event)'/>
<input name="ocu_N" type="hidden" value="0"/>        </label></td>
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

   <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/>   
   <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
	</td>
    </tr>
  </table>
  <div><?php  
   $ver=$tip->ver_tipcar();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Tipos de Caracteristicas');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?></div>
</form>
</body>
</html>
