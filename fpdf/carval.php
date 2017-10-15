<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_caract.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
function editvalores(cadena)
{

	var trozos = cadena.split("/*");
	document.getElementById("valmin").value= trozos[1];
	document.getElementById("valmax").value=trozos[2];
	document.getElementById("diades").value=trozos[3];
	document.getElementById("mesdes").value=trozos[4];
	document.getElementById("aniodes").value=trozos[5];
	document.getElementById("diahas").value=trozos[6];
	document.getElementById("meshas").value=trozos[7];
	document.getElementById("aniohas").value=trozos[8];
	document.getElementById("sexo").value=trozos[9];
	document.form1.ocu_N.value=trozos[0];
}

function editvalis(cadena)
{

	var trozos = cadena.split("/*");
	document.getElementById("valor").value= trozos[1];
	document.form1.ocu_N2.value=trozos[0];
}

function elimvalis(val)
{
		if (confirm("¿Desea Eliminar el registro Seleccionado?"))
		{	
			document.form1.ocu_N2.value=val;
			document.form1.ocu_e2.value=1;
			document.form1.submit();
		}
}
function ver()
{
		
			document.form1.submit();
		
}

function elimvalores(val)
{
		if (confirm("¿Desea Eliminar el registro Seleccionado?"))
		{	
			document.form1.ocu_N.value=val;
			document.form1.ocu_e.value=1;
			document.form1.submit();
		}
}

function NuevoVR()
{  
	document.getElementById("valmin").value='0';
	document.getElementById("valmax").value='0';
	document.getElementById("diades").value='0';
	document.getElementById("mesdes").value='0';
	document.getElementById("aniodes").value='0';
	document.getElementById("diahas").value='0';
	document.getElementById("meshas").value='0';
	document.getElementById("aniohas").value='99';
	document.getElementById("sexo").value='';
    document.form1.ocu_N.value=0;
}

function NuevoLV()
{  
	document.getElementById("valor").value='';
    document.form1.ocu_N2.value=0;
}

function GuardarVR()
{  
	if ((document.getElementById("aniohas").value!='0' || document.getElementById("aniohas").value!='') && document.getElementById("sexo").value!='' && document.form1.ocu_N.value==0 && document.getElementById("valmin").value!='' && document.getElementById("valmax").value!='')
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if ((document.getElementById("aniohas").value!='0' || document.getElementById("aniohas").value!='') && document.getElementById("sexo").value!='' && document.form1.ocu_N.value!=0 && document.getElementById("valmin").value!='' && document.getElementById("valmax").value!='')
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("aniohas").value=='0' || document.getElementById("sexo").value=='' || document.getElementById("aniohas").value=='' ||  document.getElementById("valmin").value=='' || document.getElementById("valmax").value=='')
	{
		alert("Debe ingresar los valores minimo y máximo, año maximo y seleccionar sexo");
	}
}

function GuardarLV()
{  
	if (document.getElementById("valor").value!='' && document.form1.ocu_N2.value==0)
	{
		document.form1.ocu_g2.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("valor").value!='' && document.form1.ocu_N2.value!=0)
	{
    	document.form1.ocu_g2.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("valor").value=='')
	{
		alert("Debe ingresar el valor a guardar");
	}
}


</script>

<body>
<form name="form1" id="form1" method="post" action="">


<?php 
//echo 'carct'.$_GET['car'];
$car= new caract($_GET['car'],'','','','','','','',''); 

if($_GET['val']==1)
   echo  '<div id="valoref" style="display:block ">';
   else
   echo '<div id="valoref" style="display:none ">'; 
   
   
 if($_POST["sexo"]=='O')$ref=$_POST['otro'];else  $ref=$_POST["sexo"];
 $vr= new valoresref($_POST["ocu_N"], $_GET['car'], $_POST["valmin"], $_POST["valmax"], $_POST["diades"], $_POST["mesdes"], $_POST["aniodes"], $_POST["diahas"], $_POST["meshas"], $_POST["aniohas"], $ref);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  
        
		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' && $_POST["ocu_g"]==2 )
		{
			$gua=$vr->modif_valref();
			if ($gua)
				echo '<script>alert("Registro Modificado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Modificado");</script>';
		}
		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
		{
			$gua=$vr->ins_valref();
			if ($gua)
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
  }


  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
		$gua=$vr->eli_valref();
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	} 

 ?>   

<table width="590" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Valores de Referencia: <?php echo $_GET['nomb']; ?> </div></td>
    </tr>
    <tr>
      <td class="etiqueta">Valor Minimo : </td>
      <td colspan="3" class="texto">
        <input name="valmin" type="text" class="texto" id="valmin" size="10"  onkeypress='return sincomillas(event)' value="<?php echo $_POST['valmin'];?>"/>
        <span class="texto Estilo2"><span class="Estilo3">* </span></span>        <label>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Valor M&aacute;ximo:</td>
      <td colspan="3" class="texto"><label>
      <input name="valmax" type="text" class="texto" id="valmax" size="10" onkeypress='return sincomillas(event)' value="<?php echo $_POST['valmax'];?>" />
      <span class="texto Estilo2"><span class="Estilo3">* </span></span> </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Desde:</td>
      <td colspan="3" class="texto"><label>Dia 
          <input name="diades" type="text" class="texto" id="diades" value="0" size="10" onkeypress='return soloNumeros(event)' value="<?php echo $_POST['diades'];?>" />
Mes      </label> <input name="mesdes" type="text" class="texto" id="mesdes" value="0" size="10" onkeypress='return soloNumeros(event)' value="<?php echo $_POST['mesdes'];?>"/> 
A&ntilde;o  
      <input name="aniodes" type="text" class="texto" id="aniodes" value="0" size="10" value="<?php echo $_POST['aniodes'];?>" onkeypress='return soloNumeros(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta">Hasta:</td>
      <td colspan="3" class="texto"><label><span class="texto">Dia
            <input name="diahas" type="text" class="texto" id="diahas" value="0" size="10" onkeypress='return soloNumeros(event)'/>
Mes
<input name="meshas" type="text" class="texto" id="meshas" value="0" size="10" onkeypress='return soloNumeros(event)'/>
A&ntilde;o
<input name="aniohas" type="text" class="texto" id="aniohas" value="0" size="10" onkeypress='return soloNumeros(event)'/>
      <span class="texto Estilo2"><span class="Estilo3">* </span></span></span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Valor Referencia<span class="etiqueta">:</span></td>
      <td colspan="3" class="texto"><select name="sexo" class="texto" id="sexo" onchange="ver()">
		  <option value="">Seleccione</option>
          <option value="M" <?php if($_POST['sexo']=='M') echo 'selected';?>>Masculino</option>
          <option value="F" <?php if($_POST['sexo']=='F') echo 'selected';?>>Femenino</option>
		  <option value="A" <?php if($_POST['sexo']=='A') echo 'selected';?>>Ambos</option>
		  <option value="O" <?php if($_POST['sexo']=='O') echo 'selected';?>>Otros</option>
        </select> 
		<input name="ocu_N" id="ocu_N" type="hidden" value="0"/>
		<input type="hidden" name="ocu_e" id="ocu_e" value="0"/> 
	  <span class="texto Estilo2"><span class="Estilo3">* </span></span>	  </td>
    </tr>
	<?php if($_POST['sexo']=='O'){?>
	<tr>
	  <td class="etiqueta"><span class="etiqueta">Indique cual Otro:</span></td>
      <td colspan="3" class="texto"><input type="text" class="texto" name="otro" id="otro" />
	</tr>
	<?php }?>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="td-btn">
      	<a href="#" onclick="NuevoVR();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>
    </td>
      <td width="207" class="td-btn"><a href="#" onclick="GuardarVR();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>
          <input name="ocu_g" id="ocu_g" type="hidden" value="0"/></td>
      <td width="169" class="td-btn"><a href="#" onclick="top.mainFrame.location.href='caract.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
    </td>
    </tr>
  </table>
  
  <br>
 <?php $verVR=$car->buscar_valor_ref();
    echo $verVR; ?>
  </div>
  
<?php if($_GET['val']==2)
   echo  '<div id="valolis" style="display:block ">';
   else
   echo '<div id="valolis" style="display:none ">'; 
   
   
 $lv= new valorlist($_POST["ocu_N2"], $_GET['car'], $_POST["valor"]);
 if(isset($_POST["ocu_g2"]) && $_POST["ocu_g2"]!='0' )
  {  
		if (isset($_POST["ocu_N2"]) && $_POST["ocu_N2"]!='0' && $_POST["ocu_g2"]==2 )
		{
			$gua=$lv->modif_valorlist();
			if ($gua)
				echo '<script>alert("Registro Modificado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Modificado");</script>';
		}
		if (isset($_POST["ocu_N2"]) && $_POST["ocu_N2"]=='0' )
		{
			$gua=$lv->ins_valorlist();
			if ($gua)
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
  }


  if (isset($_POST["ocu_e2"])!='0' && $_POST["ocu_e2"]!='0' ) //para eliminar
	{	
		$gua=$lv->eli_valorlist();
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	} 
      
   ?>



<table width="590" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Valores de Lista </div></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Valor : </td>
      <td colspan="3" class="texto">
        <input name="valor" type="text" id="valor" size="50" /> 
		<input name="ocu_N2" id="ocu_N2" type="hidden" value="0"/>
		<input name="ocu_e2" id="ocu_e2" type="hidden" value="0"/> 
        <span class="texto Estilo2"><span class="Estilo3">* </span></span>        <label>
      </label></td>
    </tr>
    <tr>
      <td colspan="2">

      <a href="#" onclick="NuevoLV();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

      <img src="imagene</td>
      <td width="207" class="td-btn"><a href="#" onclick="GuardarLV();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>
          <input name="ocu_g" id="ocu_g" type="hidden" value="0"/></td>
      <td width="169" class="td-btn"><a href="#" onclick="top.mainFrame.location.href='caract.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
    </td>

    </tr>
  </table>
  
  
   <?php $verVL=$car->buscar_valor_lista();
    echo $verVL; ?>
  
  
  </div>
  
</form>
</body>
</html>
