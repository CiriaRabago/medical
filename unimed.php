<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_unimed.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo2 {color: #003300}
.Estilo3 {color: #FF0000}
-->
</style></head>
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
	document.getElementById("abrev").value='';
	document.getElementById("descrip").value='';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	if (document.getElementById("abrev").value!='' && document.getElementById("descrip").value!='' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("abrev").value!='' && document.getElementById("descrip").value!='' && document.form1.ocu_N.value!=0)
	{
		document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("abrev").value=='' || document.getElementById("descrip").value=='')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("abrev").value=trozos[1];
	document.getElementById("descrip").value=trozos[2];
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="unimed.php">
<?php  
 $uni= new unimed($_POST["ocu_N"],$_POST["abrev"],$_POST["descrip"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$uni->buscar();
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$uni->modf_unimed();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$uni->ins_unimed();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	$gua=$uni->bus_unimed();
		if ($gua=='true')
			echo '<script>alert("Registro No puede ser eliminado por tener caracteristicas asociadas");</script>';
		else
			{
				$gua=$uni->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
	}
 ?>

  <table width="608" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Unidades de Medida </div></td>
    </tr>
    <tr>
      <td width="147" class="etiqueta">Abreviatura:</td>
      <td width="451" colspan="3" class="texto Estilo2"><label>
        <input name="abrev" type="text" class="texto" id="abrev"  onkeypress='return sincomillas(event)'/>
        <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td colspan="3"><label>
        <input name="descrip" type="text" class="texto" id="descrip" size="50" onkeypress='return sincomillas(event)'/>
<input name="ocu_N" type="hidden" value="0"/> 
<span class="Estilo3">* </span> </label></td>
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

    <input name="ocu_g" type="hidden" value="0"/>   <input type="hidden" name="ocu_e" value="0"/>     

	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</td>
    </tr>
  </table>
  <div><?php  
   $ver=$uni->ver_unimed();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar las Unidades de Medida');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?></div>
</form>
</body>
</html>
