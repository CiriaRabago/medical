<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php";
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
	document.getElementById("descrip").value='';
	document.getElementById("pre").value='';
	document.getElementById("tipo").value='0';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	 if ((document.getElementById("nomb").value!='') && (document.getElementById("pre").value!='') && document.getElementById("tipo").value!='0')
	{	
	
		if (document.form1.ocu_N.value==0)
		{
			document.form1.ocu_g.value=1;
   			document.form1.submit();
		}
		if (document.form1.ocu_N.value!=0)
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
	document.getElementById("nomb").value=trozos[1];
	document.getElementById("descrip").value=trozos[2];
	document.getElementById("pre").value=trozos[3];
	document.getElementById("tipo").value=trozos[4];
	document.form1.ocu_pre.value=trozos[3];
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="perfil.php">
<?php  
 $per= new perfil($_POST["ocu_N"],$_POST["nomb"],$_POST["descrip"],$_POST["pre"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$per->buscar($_POST["tipo"]);
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{	
		$gua=$per->modf_perfil($_POST["tipo"]);
		if ($gua)
		{
			if($_POST["ocu_pre"]!=$_POST["pre"])
				$camp=$per->cambio_de_precio($_POST["pre"],$_POST["ocu_N"],$_SESSION['cedu_usu']);
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		}
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$per->ins_perfil($_POST["tipo"]);
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	$gua=$per->bus_perfil();
		if ($gua=='true')
			echo '<script>alert("Registro No puede ser eliminado por tener Examenes asociados");</script>';
		else
			{
				$gua=$per->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
	} 
 ?>
  <table width="611" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Perfil</div></td>
    </tr>
    <tr>
      <td width="149" class="etiqueta">Nombre:</td>
      <td width="452" colspan="3" class="texto Estilo2"><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50" onkeypress='return sincomillas(event)' />
        <span class="Estilo3">*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td colspan="3"><label>
        <input name="descrip" type="text" class="texto" id="descrip" size="50" onkeypress='return sincomillas(event)'/><input name="ocu_N" type="hidden" value="0" onkeypress='return sincomillas(event)'/> 
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Precio:</td>
      <td colspan="3"><label class="texto">
        <input name="pre" type="text" class="texto" id="pre" />
      <span class="Estilo3">* </span>      
      <input name="ocu_pre" type="hidden" id="ocu_pre" value="0" />
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo:</td>
      <td colspan="3"><span class="texto">
        <select name="tipo" class="texto" id="tipo">
          <option value="0">Seleccione---&gt;</option>
          <option value="P">Perfil</option>
          <option value="A">&Aacute;rea</option>
                                                </select>
        <span class="Estilo3">*</span></span></td>
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
	     <input name="ocu_g" type="hidden" value="0"/> <input type="hidden" name="ocu_e" value="0"/>  </td>
    </tr>
  </table>
  <?php  
   $ver=$per->ver_perfil();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Perfiles');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?>
</form>
</body>
</html>
