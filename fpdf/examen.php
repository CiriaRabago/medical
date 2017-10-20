<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_examen.php";
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
	document.getElementById("nomb").value='';
	document.getElementById("abrev").value='';
	document.getElementById("obser").value='';
	document.getElementById("proc").value='';
	document.getElementById("meto").value='';
	document.getElementById("tipm").value='';
	document.getElementById("pre").value='';
	document.getElementById("valo").value='2';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	
	if (!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("pre").value))
  	{
  		alert("El valor " + document.getElementById("pre").value + " no es un número");
 		return false;
  	}
	
	if (document.getElementById("abrev").value!='' && document.getElementById("nomb").value!='' && document.getElementById("valo").value!='2' && document.form1.ocu_N.value==0 && !isNaN(parseFloat(document.getElementById("pre").value)))
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("abrev").value!='' && document.getElementById("nomb").value!='' && document.getElementById("valo").value!='2' && document.form1.ocu_N.value!=0 && !isNaN(parseFloat(document.getElementById("pre").value)))
	{
		document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("abrev").value=='' || document.getElementById("nomb").value=='' || document.getElementById("valo").value=='2' || document.getElementById("pre").value=='')
	{
		alert("Falta ingresar Datos");
	}
}

function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("nomb").value=trozos[1];
	document.getElementById("abrev").value=trozos[2];
	document.getElementById("obser").value=trozos[3];
	document.getElementById("proc").value=trozos[4];
	document.getElementById("valo").value=trozos[5];
	document.getElementById("meto").value=trozos[6];
	document.getElementById("pre").value=trozos[7];
	document.getElementById("tipm").value=trozos[8];
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
<form name="form1" id="form1" method="post" action="examen.php">
<?php  
 $exa= new examen($_POST["ocu_N"],$_POST["nomb"],$_POST["abrev"],$_POST["obser"], $_POST["proc"], $_POST["valo"], $_POST["meto"], $_POST["pre"], $_POST["tipm"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$exa->buscar();
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$exa->modf_examen();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$exa->ins_examen();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	$re='';
		$gua=$exa->bus_examen1();
		if ($gua!='false')
			$re=$gua;
		$gua=$exa->bus_examen2();
		if ($gua!='false')
			$re=$re.' y '.$gua;		
		if ($re!='')
			echo '<script>alert("Registro No puede ser eliminado por tener '.$re.' asociados");</script>';
		else
	    	{
				$gua=$exa->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
	}
?>
 
  <table width="600" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Ex&aacute;men</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto"><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50"  onkeypress='return sincomillas(event)'/><input name="ocu_N" type="hidden" value="0"/>
        <span class="Estilo1">*</span>      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Abreviatura:</td>
      <td colspan="3" class="texto"><label>
        <input name="abrev" type="text" class="texto" id="abrev" size="50"  onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span> </label></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Observaci&oacute;n:</td>
      <td colspan="3" class="texto"><textarea name="obser" cols="50" rows="2" class="texto" id="obser"  onkeypress='return sincomillas(event)'></textarea></td>
    </tr>
    <tr>
      <td class="etiqueta">Procedimiento:</td>
      <td colspan="3" class="texto"><textarea name="proc" cols="50" rows="2" class="texto" id="proc"  onkeypress='return sincomillas(event)'></textarea></td>
    </tr>
    <tr>
      <td class="etiqueta">M&eacute;todo:</td>
      <td colspan="3" class="texto"><input name="meto" type="text" class="texto" id="meto" size="50"  onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo de Muestra: </td>
      <td colspan="3" class="texto"><input name="tipm" type="text" class="texto" id="tipm" size="50"  onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta">Precio:</td>
      <td colspan="3" class="texto"><input name="pre" type="text" class="texto" id="pre" />  <span class="Estilo1">*</span>Ejemplo: 30.5</td>
    </tr>
    <tr>
      <td class="etiqueta">&iquest;Posee Valores? Si/No:</td>
      <td colspan="3" class="texto"><select name="valo" class="texto" id="valo">
        <option value="2">Seleccione--&gt;</option>
        <option value="1">Si</option>
        <option value="0">No</option>
      </select>
      <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
      <td colspan="3" class="texto">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">
	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

	  <input name="ocu_g" type="hidden" value="0"/>   <input type="hidden" name="ocu_e" value="0"/>   </td>
    </tr>
  </table>
 <div><?php  
 $ver=$exa->ver_examen();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los examenes');</script>";
		} 
		else
		{
		    echo $ver;
		}?>
  </div>
</form>
</body>
</html>
