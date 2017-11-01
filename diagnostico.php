<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_diagnostico.php";
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
function caracter(a)
{
	var textonom=document.getElementById("nom").value;
	if (a==0)
	document.getElementById('caract').innerHTML=textonom.length+1+' caracteres';
	else
	document.getElementById('caract').innerHTML=textonom.length+' caracteres';
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
	document.getElementById('caract').innerHTML='0 caracteres';
	document.form1.ocu_N.value=0;
}

function Guardar()
{  
	if (document.getElementById("nom").value!='')
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
	document.form1.ocu_N.value=trozos[0];
	document.getElementById("nom").value=trozos[1];
	document.getElementById("des").value=trozos[2];
	caracter(1);
}

</script>
<body>
 
<form id="form1" name="form1" method="post"  action="diagnostico.php">
<?php 
 $dia= new diagnostico('', '','');
  if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  $dia= new diagnostico($_POST["ocu_N"], $_POST["nom"],$_POST["des"]);
  	
		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0')
		{
			$gua=$dia->modificar_dia($_POST["ocu_N"]);
			if ($gua)
			{	
				echo '<script>alert("Registro Modificado Exitosamente");</script>';	
			}
			else
				 echo '<script>alert("El Registro no pudo ser Modificado");</script>';
		}

		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0')
		{
			$bus=$dia->buscar();
			if ($bus=='true')
				echo '<script>alert("Este registro YA Existe");</script>';
			else
			{
			$gua=$dia->guardar_dia($_SESSION["cedu_usu"]);
			if ($gua)
			{
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			}
			else
				echo '<script>alert("El registro no pudo ser Guardado");</script>';
		}

  		}
}
    if ($_POST["ocu_e"]=='1') //para eliminar
	{	
		$gua=$dia->eliminar($_POST["ocu_N"]);
		if ($gua)
			{
				echo '<script>alert("Registro Eliminado Exitosamente");</script>';
			}
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	}
?>
  <table width="619" border="0" align="center" bgcolor="#FFFFFF">
    <tr class="titulofor">
      <td colspan="3"><div align="center">Diagnóstico </div></td>
    </tr>
    <tr>
      <td width="73" class="etiqueta">Diagnóstico:</td>
      <td width="367" class="texto"><label>
        <textarea name="nom" cols="70" rows="4" class="texto" id="nom" onkeypress="caracter(0);"></textarea>
        
      </label></td>
      <td width="165" class="texto"><span class="Estilo1">*</span>
        <div id="caract">0 caracteres.</div>
      <span class="textoN">M&aacute;ximo 200 caracteres.</span></td></tr>
    <tr>
      <td height="71" class="etiqueta">Descripción</td>
      <td colspan="2" class="texto"><label>
        <textarea name="des" cols="70" rows="4" class="texto" id="des"></textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="3"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="3" class="td-buttons">

      <div align="center">
<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

     </div></td>
    </tr>
    <tr class="Etiqueta">
      <td height="32" colspan="3"><p align="center">
        <label>
          <input name="ocu_N" type="hidden" value="0"/>
          <input type="hidden" name="ocu_e" value="0"/>
          <input name="ocu_g" type="hidden" value="0"/>
        </label>
      </p></td>
    </tr>
  </table>
 <div>    
 <?php  
 $ver=$dia->ver_diagnostico();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Diagnósticos');</script>";
		} 
		else
		{
		    echo $ver;
		}?>
  </div>
</form>
</body>
</html>
