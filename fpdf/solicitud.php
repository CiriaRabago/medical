<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_solicitud.php";
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
.Estilo1 {color: #FF0000}
-->
</style>
</head>
<script>
function sincomillas(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode == 34 || charCode ==39) {
  		alert("No se permite comillas");
 		return false;
  	}
	return true;
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
	document.getElementById("nom").value='';
	document.getElementById("pre").value='';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	
	if (!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("pre").value))
  	{
  		alert("El valor " + document.getElementById("pre").value + " no es un número");
 		return false;
  	}
	
	if (document.getElementById("nom").value!='' && !isNaN(parseFloat(document.getElementById("pre").value)))
	{
		if (document.form1.ocu_N.value==0)
			{	
				document.form1.ocu_g.value=1;			
				document.form1.submit();
			}
		else
			{
				document.form1.ocu_g.value=2;
   				document.form1.submit();
			}
	}
		else
			alert("Falta ingresar Datos");
}

function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("nom").value=trozos[1];
	document.getElementById("pre").value=trozos[2];
	document.form1.ocu_N.value=trozos[0];
}
function soloNumeros(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  		alert("Solo se permiten números en este campo.");
 		return false;
  	}
	return true;
}

</script>
<body>
<form name="form1" id="form1" method="post" action="solicitud.php">
<?php  
 $sol= new solicitud($_POST["ocu_N"],$_POST["nom"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$sol->modf_solicitud($_POST["pre"]);
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$sol->ins_solicitud($_POST["pre"],$_SESSION["cedu_usu"]);
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	$gua=$sol->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	}
?>
 
  <table width="600" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center">Solicitudes</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto"><label>
        <input name="nom" type="text" class="texto" id="nom" size="50"  onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span>      </label></td>
    </tr>
      <tr>
      <td class="etiqueta">Precio:</td>
      <td colspan="3" class="texto"><input name="pre" type="text" class="texto" id="pre" />  <span class="Estilo1">*</span>Ejemplo: 30.5</td>
    </tr>
    <tr>
      <td class="etiqueta">&nbsp;</td>
      <td colspan="3" class="texto">&nbsp;</td>
    </tr>
    <tr>
      <td><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
      <td colspan="3" class="texto">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons" >
      <div align="center">

      	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>

          <input name="ocu_g" type="hidden" value="0"/>   
        <input type="hidden" name="ocu_e" value="0"/>       
        <span class="texto">
          <input name="ocu_N" type="hidden" value="0"/>
          </span>

	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</div></td>
    </tr>
  </table>
 <div><?php  
 $ver=$sol->ver_solicitud();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar las solicitudes');</script>";
		} 
		else
		{
		    echo $ver;
		}?>
  </div>
</form>
</body>
</html>
