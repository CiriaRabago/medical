<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_tipocondicion.php";
include "clases/clase_condicion.php";
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
function ver()
{
 document.form1.submit();
}
function agregar()
{
	document.form1.action="tipo_condicion.php";
	 document.form1.submit();
}
function adjotro(a)
{
 
var ela = document.all('ajdo'+a);
var padre = ela.parentNode;
padre.removeChild(ela);
document.getElementById('eliadj'+a).style.display="block";

 b=a;
 a=parseInt(a)+1;
 var texto='<div id="a'+a+'"><table id="ta'+a+'" width="200" border="0" cellpadding="0" cellpadding="0"><tr><td><input name="valo'+a+'" id="valo'+a+'" type="text" class="texto" size="50" onkeypress="return sincomillas(event)"/></td><td><input name="ajdo'+a+'" id="adjo'+a+'" type="button" value="Agregar Otro" onclick="adjotro('+a+')"/></td><td><input name="eliadj'+a+'" id="eliadj'+a+'" type="button" value="X" onclick="elimadj('+a+')" style="display:none"/></td></tr></table></div><div id="masadj'+a+'"></div>';
document.getElementById('masadj'+b).innerHTML=texto;
document.form1.ocufile.value=a;
}

function elimadj(x)
{
 x="a"+x;
// Obtenemos el elemento
el = document.getElementById(x);
// Obtenemos el padre de dicho elemento
// con la propiedad “parentNode”
var padre = el.parentNode;
// Eliminamos el hijo (el) del elemento padre
padre.removeChild(el);
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
	document.getElementById("tip").value='0';
	document.form1.submit();
}
function Guardar()
{  
if (document.getElementById("tip").value!='0' && document.getElementById("nom").value!='' && document.getElementById("ord").value!='' && document.getElementById("lis").value!='0')
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
	document.getElementById("tip").value=trozos[1];
	document.getElementById("nom").value=trozos[2];
	document.getElementById("des").value=trozos[4];
	document.getElementById("ord").value=trozos[6];
	document.getElementById("lis").value=trozos[3];
	document.getElementById("opc").value=trozos[5];
	document.form1.ocu_N.value=trozos[0];
	if (trozos[3]=='S')
	{
		mostrar();
	}
}

function mostrar()
{
	if (document.getElementById("lis").value=='N')
	{
		document.getElementById("ocu").style.display='none';
		document.getElementById("opc").value='N';
		document.getElementById("opc").style.display='none';
		document.getElementById("ocu1").style.display='none';
		document.getElementById('masadj1').innerHTML='';
	}	
	else
	{
		document.getElementById("ocu").style.display='block';
		document.getElementById("opc").style.display='block';
	    document.getElementById("ocu1").style.display='block';
var texto='<div id="a2"><table width="200" border="0"><tr><td><label><input name="valo2" type="text" class="texto" id="valo2" size="50" onkeypress="return sincomillas(event)"/></label></td><td><label><input name="ajdo2" type="submit" class="texto" id="ajdo2" onclick="adjotro(2)" value="Agregar Otro"/></label></td><td><label><input name="eliadj2" type="submit" class="texto" id="eliadj2" value="X" onclick="elimadj(2)" style="display:none"/></label></td></tr></table></div><div id="masadj2"></div>';
		document.getElementById('masadj1').innerHTML=texto;

	}	
}
</script>
<body>
<form id="form1" name="form1" method="post" action="condicion_hist.php">
<?php 
$tcon= new tipcon('','','','','','','');
if ($_POST["tip"]>'0')
	$tipc= $_POST["tip"];
	
if ($_POST["condic"]>'0')
	$tipc= $_POST["condic"];


 $con= new condicion($_POST["ocu_N"],$_POST["tip"],$_POST["nom"],$_POST["des"],$_POST["lis"],$_POST["opc"],$_POST["ord"],$_SESSION["cedu_usu"],'');
 
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
 { 
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$con->modf_condicion();
		if ($gua)
				echo '<script>alert("Registro Modificado Exitosamente");</script>';
			else
				echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$con->ins_condicion();
			if ($gua!='false')
			{
				if(isset($_POST["ocufile"]) && $_POST["ocufile"]>'0' )
				{
					for ($i='1';$i<=$_POST["ocufile"];$i++)
			  		{  
						if ($_POST["valo".$i]!='')
							$gua1=$con->ins_condicion_valor($gua, $_POST["valo".$i], $_SESSION["cedu_usu"]);
					}
				}	
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
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
  <table width="797" border="0" align="center">
    <tr class="titulofor">
      <td colspan="2"><div align="center">Condiciones de la Historia M&eacute;dica </div></td>
    </tr>
    <tr>
      <td width="281" class="etiqueta">Tipo de Condici&oacute;n: </td>
      <td width="522" class="texto td-btn" ><label>
        <select name="tip" class="texto" id="tip"  onchange="ver();">
          <option value="0">Seleccione---&gt;</option>
		  <?php  if ($con->combo_tipcon()!= false)
		        echo $con->combo_tipcon(); ?>
        </select>
        <span class="Estilo1">*</span>
		<script> document.getElementById("tip").value="<?php  echo $tipc; ?>"; </script>
        <a href="#" onclick="agregar();" class="button" alt="agregar tipo de condici&oacute;n" id="agreg" > <i class="fa fa-plus" aria-hidden="true"></i> Agregar </a>

       </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre de la Condici&oacute;n: </td>
      <td class="texto"><label>
        <input name="nom" type="text" class="texto" id="nom" size="50" onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n de la Condici&oacute;n: </td>
      <td class="texto"><label>
        <textarea name="des" cols="40" class="texto" id="des" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Orden de Visualizaci&oacute;n:</td>
      <td class="texto"><input name="ord" type="text" class="texto" id="ord" onkeypress='return soloNumeros(event)' value="0" size="5" />
        <span class="Estilo1">*</span> Indique el orden Cardinal de esta condici&oacute;n en el reporte de Historia M&eacute;dica </td>
    </tr>
    <tr>
      <td class="etiqueta">&iquest;Su resultado proviene de una Lista de Valores?: </td>
      <td class="texto"><label>
        <select name="lis" class="texto" id="lis" onchange="mostrar();">
          <option value="0">Seleccione---&gt;</option>
          <option value="S">Si</option>
          <option value="N">No</option>
        </select>
        <span class="Estilo1">*</span></label></td>
    </tr>
    <tr>
      <td class="etiqueta"><div id="ocu" style="display:none">&iquest;Puede seleccionar m&aacute;s de un resultado?: </div></td>
      <td class="texto"><select name="opc" class="texto" id="opc" style="display:none">
          <option value="0">Seleccione---&gt;</option>
          <option value="S">Si</option>
          <option value="N">No</option>
      </select></td>
    </tr>
    <tr>
      <td class="etiqueta"><div id="ocu1" style="display:none">Resultados Asociados: </div></td>
      <td class="texto" ><div id="masadj1"></div><input name="ocufile" type="hidden" value="1" /></td>
    </tr>
    <tr>
      <td colspan="2" class="td-buttons">
      	<a href="#" onclick="eliminar();" class="button" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

<a href="#" onclick="Nuevo();" class="button" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


<a href="#" onclick="Guardar();" class="button" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>

      <input name="ocu_g" type="hidden" value="0"/>
      <input type="hidden" name="ocu_e" value="0"/>
      <input name="ocu_N" type="hidden" id="ocu_N" value="0" /></td>
    </tr>
  </table>
       <?php  
$ver=$con->ver_condicion($tipc);
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
