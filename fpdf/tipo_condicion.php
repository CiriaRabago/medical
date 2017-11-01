<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_tipocondicion.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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
	document.getElementById("des").value='';
	document.getElementById("ord").value='0';
	document.getElementById("his").value='0';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
if (document.getElementById("nom").value!='' && document.getElementById("ord").value!='' && document.getElementById("his").value!='0')
	{
		if (document.form1.ocu_N.value==0)//modificar
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
	document.getElementById("des").value=trozos[2];
	document.getElementById("ord").value=trozos[3];
	document.getElementById("his").value=trozos[4];
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
<form name="form1" id="form1" method="post" action="tipo_condicion.php">
<?php  
 $con= new tipcon($_POST["ocu_N"],$_POST["nom"],$_POST["des"],$_POST["ord"],$_POST["his"],$_SESSION["cedu_usu"],'');
 
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
 { 
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$con->modf_tipcon();
		if ($gua)
			{
				?>
	   				<input name="condic" id="condic" type="hidden" value="<?php  echo $_POST["ocu_N"]; ?>" />
	   			<?php 
				echo '<script>document.form1.action="condicion_hist.php";document.form1.submit();</script>';
			}
			else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$bus=$con->buscar();
		if ($bus=='true')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$con->ins_tipcon();
			if ($gua!='false')
			{
				?>
	   				<input name="condic" id="condic" type="hidden" value="<?php  echo $gua; ?>" />
	   			<?php 
				echo '<script>document.form1.action="condicion_hist.php";document.form1.submit();</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}

  	}
 }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
		$gua=$con->eliminar($_POST["ocu_N"]);
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	}
?>
 
  <table width="750" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Tipos de condiciones en la Historia M&eacute;dica </div></td>
    </tr>
    <tr>
      <td width="170" class="etiqueta">Nombre:</td>
      <td width="570" colspan="3" class="texto"><label>
        <input name="nom" type="text" class="texto" id="nom" size="50"  onkeypress='return sincomillas(event)'/>
      <span class="Estilo1">*</span>      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td colspan="3" class="texto"><textarea name="des" cols="50" rows="2" class="texto" id="des"  onkeypress='return sincomillas(event)'></textarea></td>
    </tr>
    <tr>
      <td class="etiqueta">Orden de Visualizaci&oacute;n:</td>
      <td colspan="3" class="texto"><input name="ord" type="text" class="texto" id="ord" onkeypress='return soloNumeros(event)' value="0" size="5" />
      <span class="Estilo1">*</span> Indique el orden Cardinal de esta condici&oacute;n en el reporte Historia M&eacute;dica </td>
    </tr>
    <tr>
      <td class="etiqueta">Historia Antecedentes:</td>
      <td colspan="3" class="texto"><select name="his" class="texto" id="his">
        <option value="0">Seleccione--&gt;</option>
        <option value="1">Si</option>
        <option value="2">No</option>
                  </select>
      <span class="Estilo1">*</span> Indique si esta condici&oacute;n forma parte de los antecedentes del paciente</td>
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

	<span class="texto">
        <input name="ocu_g" type="hidden" value="0"/>
        <input type="hidden" name="ocu_e" value="0"/>
        <input name="ocu_N" type="hidden" value="0"/>
      </span></td>
    </tr>
  </table>
 <div><?php  
 $ver=$con->ver_tipcon();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Tipos de Condiciones');</script>";
		} 
		else
		{
		    echo $ver;
		}?>
  </div>
</form>
</body>
</html>
