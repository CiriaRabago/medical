<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_menu.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
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
	document.getElementById("nivel").value='0';
	document.getElementById("alias").value='';
	document.getElementById("pag").value='';
	document.getElementById("des").value='';
	document.getElementById("padre").value='0';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  
   //&& document.getElementById("pag").value!=''
	if (((document.getElementById("nivel").value=='1' && document.getElementById("padre").value=='0') || (document.getElementById("nivel").value>'1' && document.getElementById("padre").value!='0')) && document.getElementById("alias").value!='' )
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
	document.getElementById("nivel").value=trozos[1];
	document.getElementById("alias").value=trozos[2];
	document.getElementById("pag").value=trozos[4];
	document.getElementById("des").value=trozos[5];
	document.getElementById("padre").value=trozos[3];
	document.form1.ocu_N.value=trozos[0];
}
function ver()
{
 document.form1.submit();
}
</script>
<body>
<form name="form1" method="post" action="menu_maestro.php">
<?php  
if ($_POST["nivel"]>'0')
{
	$val=$_POST["nivel"]; 
	$pad=$val-1;
	if ($pad=='0')
		$mos='disabled="disabled"';
	else
		{
			$mos='';
		}
}
  else
		$val='0';
 $men= new menu('','','','','','','','');
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  
	$men= new menu($_POST["ocu_N"],$_POST["nivel"],$_POST["alias"],$_POST["pag"],$_POST["des"],$_POST["padre"],'A',$_SESSION["cedu_usu"]);
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$men->modf_menu();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{	
		$bus=$men->buscar();
		if ($bus=='true')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$men->ins_menu();
			if ($gua)
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
	   $gua=$men->eliminar($_POST["ocu_N"]);
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
		
	} 
 ?>
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Crear Menu </div></td>
    </tr>
    <tr>
      <td class="etiqueta">Nivel: </td>
      <td colspan="3" class="texto"><label>
          <select name="nivel" class="texto" id="nivel" onchange="ver();">
          <option value="0" selected="selected" >Seleccione--></option>
		  <?php   
		 if ($men->combo_niv()!= false)
		        echo $men->combo_niv(); ?>
	    </select>    
		<script> document.getElementById("nivel").value="<?php  echo $val; ?>"; </script>    
        <span class="texto Estilo2"><span class="Estilo1">*</span></span>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Alias:</td>
      <td colspan="3" class="texto"><label>
        <input name="alias" type="text" class="texto" id="alias" onkeypress='return sincomillas(event)' size="50" maxlength="22"/>         
        <span class="texto Estilo2"><span class="Estilo1">*</span></span>      </label></td>
    </tr>
    <tr>
      <td width="197" height="19" class="etiqueta">Nombre de la p&aacute;gina PHP:</td>
      <td colspan="3" class="texto"><label>
        <input name="pag" type="text" class="texto" id="pag" onKeyPress="return sincomillas(event)" value="" size="50">
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Descripci&oacute;n :</td>
      <td colspan="3" class="texto"><label>
        <textarea name="des" cols="50" rows="3" class="texto" id="des" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Padre:</td>
      <td colspan="3" class="texto"><label>
          <select name="padre" class="texto" id="padre" <?php  echo $mos; ?>>
		   <option value="0" selected="selected" >Seleccione--></option>
		   <?php   
		 if ($men->combo_men($pad)!= false)
		        echo $men->combo_men($pad); ?>
          </select>        
        <span class="texto Estilo2"><span class="Estilo1">*</span></span>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">&nbsp;</td>
      <td colspan="3" class="texto">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios <span class="texto">
        <input name="ocu_N" type="hidden" value="0"/>
      </span></span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">

	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>

          <input name="ocu_g" type="hidden" value="0"/>
          <input type="hidden" name="ocu_e" value="0"/>
       <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
       </td>
    </tr>
  </table>
       <?php  
$ver=$men->ver_menu2();
        if ($ver==false)
		{
		   
		} 
		else
		{
		    echo $ver;
		}
?>
       <p>&nbsp;</p>
</form>
</body>
</html>