<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
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

function restaurar()
{  if (document.form1.ocu_N.value==0)
	{	
		alert("Para Restaurar, Debe Seleccionar una Empresa de la lista");
	}
	else
	{	
		resp=confirm("¿Desea Restaurar la Empresa Seleccionada?");
		if (resp==true)
		{	
   			document.form1.ocu_r.value=1;
			document.form1.submit();
		}
	}
}
function empresa_i_pdf()
{
document.form1.action="empresa_i_pdf.php";
document.form1.submit();
}
function Guardar()
{  
	if (document.getElementById("rif").value!='' && document.getElementById("nom").value!='' && document.getElementById("sex").value!='' && document.getElementById("te1").value!='' && document.getElementById("porce").value!='' && document.getElementById("espec").value!='0')
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
	document.getElementById("rif").value=trozos[1];
	document.getElementById("nom").value=trozos[2];
	document.getElementById("dire").value=trozos[3];
	document.getElementById("telf").value=trozos[4];
	document.getElementById("te1").value=trozos[5];
	document.getElementById("te2").value=trozos[6];
	document.getElementById("con").value=trozos[7];
	document.getElementById("des").value=trozos[8];
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body><?php 
$emp=new empresa('','','','','','','','','','');
if(isset($_POST["ocu_r"])!='0' && $_POST["ocu_r"]!='0'){	
	$gua = $emp->restaurar($_POST["ocu_N"]);
	if($gua)
		echo '<script>alert("Registro Restaurado Exitosamente");</script>';
	else
		echo '<script>alert("El Registro no pudo ser Restaurado");</script>';
}?>
<form action="" method="post" name="form1">
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Empresas Eliminadas</div></td>
    </tr>
    <tr>
      <td class="etiqueta">RIF: </td>
      <td colspan="3" class="texto"><label>
        <input name="rif" readonly type="text" class="texto" id="rif" size="25" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1"></span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto"><label>
        <input name="nom" readonly type="text" class="texto" id="nom" size="50" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1"></span></span> </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Direcci&oacute;n:</td>
      <td colspan="3" class="texto"><label>
        <textarea name="dire" readonly cols="50" class="texto" id="dire" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono Fax:</td>
      <td colspan="3" class="texto"><label>
        <input name="telf" readonly type="text" class="texto" id="telf" size="25" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1"></span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 1:</td>
      <td colspan="3" class="texto"><label>
        <input name="te1" readonly type="text" class="texto" id="te1" size="25" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1"></span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 2 :</td>
      <td colspan="3" class="texto"><label>
        <input name="te2" readonly type="text" class="texto" id="te2" size="25" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombres y Apellidos del Contacto:</td>
      <td colspan="3" class="texto"><label> </label>
          <input name="con" readonly type="text" class="texto" id="con" size="25" onkeypress='return sincomillas(event)'/>
      </td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Descripci&oacute;n de la Empresa:</td>
      <td colspan="3" class="texto"><label>
        <textarea name="des" readonly cols="50" class="texto" id="des" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="4" class="td-btn"><p><div align="center">
	     <a href="#" onclick="restaurar();" class="button-edit" alt="Actualizar"  > Restaurar </a>
       <a href="#" onclick="empresa_i_pdf();" class="button-print" alt="Imprimir"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>
        </div></p>      </td>
    </tr>
    <tr >
      <td height="30" colspan="4">
       <?php  
        $ver=$emp->ver_empresa_inactiva();
        if ($ver!=false)
		    echo $ver;
         ?></td>
     </tr>
  </table>
  <input name="ocu_N" type="hidden" value="0"/>
  <input type="hidden" name="ocu_r" value="0"/>
</form>
</body>
</html>
