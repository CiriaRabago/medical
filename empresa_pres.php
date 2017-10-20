<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa_pres.php";
include "clases/clase_menu.php";//
include "clases/clase_permiso.php";//
include "clases/clase_orden.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	document.getElementById("rif").value='';
	document.getElementById("nom").value='';
	document.getElementById("dire").value='';
	document.getElementById("des").value='';
	document.getElementById("te1").value='';
	document.getElementById("te2").value='';
	document.getElementById("fax").value='';
	document.getElementById("con").value='';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	if (document.getElementById("rif").value!='' || document.getElementById("nom").value!='' || document.getElementById("te1").value!='')
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
	document.getElementById("des").value=trozos[8];
	document.getElementById("te1").value=trozos[5];
	document.getElementById("te2").value=trozos[6];
	document.getElementById("fax").value=trozos[4];
	document.getElementById("con").value=trozos[7];
	document.getElementById("iva").value=trozos[12];
	document.form1.ocu_N.value=trozos[0];
}
function empresa_pdf()
{
document.form1.action="empresa_pdf.php";
document.form1.submit();
}

</script>
<body>
<?php  if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'empresa_pres.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   ////////////////////////////////////////////////////////// 
   
 }
 ?>
<form name="form1" method="post" action="empresa_pres.php">
<?php  /////////////////////////Mostrar u ocultar Botones///////////////////////////
  $ope1='style="display:none"'; 
  $ope4='style="display:none"';
  $ope5='style="display:none"';
  $ope2='style="display:none"';
   if ($_POST["busper"]!='FALSE')
  { 
    	$vecper=explode('**',$_POST["busper"]); 
  
		/*if ($vecper[0]=='1')//puede guardar
		{
			$ope1='';
			$pgu='1';
		}*/
		if ($vecper[1]=='1') //puede consultar
		{
			$ope2='';
		}
		if ($vecper[2]=='1')//puede modificar
		{
			$ope1='';
			$pmo='1';
		}
		if ($vecper[3]=='1')// puede eliminar
			$ope4='';
			
		if ($vecper[4]=='1')//puede listar
		{	
			$ope5='';
		}	
	
  }
 $emp= new empresa_pres('','','','','','','','','','');

 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  
	$emp= new empresa_pres($_POST["rif"],$_POST["nom"],$_POST["dire"],$_POST["fax"],$_POST["te1"],$_POST["te2"],$_POST["con"],$_POST["des"],$_SESSION["cedu_usu"],$_POST["ocu_N"],$_POST["iva"]);
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$emp->modf_empresa_pres();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{	
		$bus=$emp->buscar_pres();
		if ($bus=='true')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$emp->ins_empresa_pres();
			if ($gua)
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
	   $gua=$emp->eliminar_pres($_POST["ocu_N"]);
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
		
	} 
 ?>
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Empresa Presupuesto</div></td>
    </tr>
    <tr>
      <td class="etiqueta">RIF: </td>
      <td colspan="3" class="texto"><label>
        <input name="rif" type="text" class="texto" id="rif" size="25" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto"><label>
        <input name="nom" type="text" class="texto" id="nom" size="50" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Direcci&oacute;n :</td>
      <td colspan="3" class="texto"><label>
        <textarea name="dire" cols="50" class="texto" id="dire" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Actividad :</td>
      <td colspan="3" class="texto"><label>
        <textarea name="des" cols="50" rows="3" class="texto" id="des" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 1:</td>
      <td colspan="3" class="texto"><label>
        <input name="te1" type="text" class="texto" id="te1" size="25" onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 2 :</td>
      <td colspan="3" class="texto"><label>
        <input name="te2" type="text" class="texto" id="te2" size="25" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Correo electr&oacute;nico :</td>
      <td colspan="3" class="texto"><label>
        <input name="fax" type="text" class="texto" id="fax" size="50" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombres y Apellidos del Contacto:</td>
      <td colspan="3" class="texto"><label> </label>
          <input name="con" type="text" class="texto" id="con" size="25" onkeypress='return sincomillas(event)'/>
    </tr>
    <tr>
      <td class="etiqueta">% Retencion de IVA:</td>
      <td colspan="3" class="texto"><label> </label>
          <input name="iva" type="text" class="texto" id="iva" size="5" onkeypress='return sincomillas(event)'/>
          <input name="ocu_N" type="hidden" value="0"/></td>
      </tr>
    <tr>
      <td colspan="4"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">
      	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  <?php  echo $ope4;?> ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar" <?php  echo $ope1;?>   > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


          <input name="ocu_g" type="hidden" value="0"/>
          <input type="hidden" name="ocu_e" value="0"/>
          </td>
    </tr>
  </table>
       <?php  
$ver=$emp->ver_empresa_pres();
        if ($ver==false)
		{
		   
		} 
		else
		{
		    echo $ver;
		}
?>
</form>
</body>
</html>
