<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
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


function mostrarlista()
{
	if (document.getElementById('ls').style.display=="none")
	{	document.getElementById('ls').style.display='block'; }
	else
	{	document.getElementById('ls').style.display="none"; }
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
	 if ((document.getElementById("nomb").value!='') && (document.getElementById("pre").value!='') && document.getElementById("agenda").value!='' && document.getElementById("vigilancia").value!='')
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


function adjotro(a)
{
 /* if (navigator.appName=="Microsoft Internet Explorer")
	{
	document.getElementById('ajdo'+a).style.display="none";
	}
	else
	{
	document.all('ajdo'+a).style.visibility="hidden";
	}*/
var ela = document.all('ajdo'+a);
var padre = ela.parentNode;
padre.removeChild(ela);

 document.getElementById('eliadj'+a).style.display="block";

 b=a;
 a=parseInt(a)+1;
// cade=document.getElementById('valos'+b).value;
 // alert(cade);
 var texto='<div id="a'+a+'"><table id="ta'+a+'" width="200" border="0" cellpadding="0" cellpadding="0"><tr><td><select name="proceso'+a+'" id="proceso'+a+'" class="texto"><option value="">Seleccione--></option></select></td><td><input name="ajdo'+a+'" id="adjo'+a+'" type="button" value="Adjuntar Otro" onclick="adjotro('+a+')"/></td><td><input name="eliadj'+a+'" id="eliadj'+a+'" type="button" value="X" onclick="elimadj('+a+')" style="display:none"/></td></tr></table></div><div id="masadj'+a+'"></div>';

document.getElementById('masadj'+b).innerHTML=texto;
document.form1.ocufile.value=a;
}

function elimadj(x)
{
 x="a"+x;
// Obtenemos el elemento
var el = document.getElementById(x);
// Obtenemos el padre de dicho elemento
// con la propiedad “parentNode”
var padre = el.parentNode;
// Eliminamos el hijo (el) del elemento padre
padre.removeChild(el);
}

</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="servicios_nuevo.php">
<?php 
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
    $ser= new servicio(0,$_POST["nomb"],$_POST["descrip"],'A',$_POST["agenda"],$_POST["vigilancia"],'NULL',$_POST["pre"]);
	$bus=$ser->buscar();
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
			$ser= new servicio($_POST["ocu_N"],$_POST["nomb"],$_POST["descrip"],'A',$_POST["agenda"],$_POST["vigilancia"],'NULL',$_POST["pre"]);
			$gua=$ser->ins_servicio();
			if ($gua!=false)
			{
				$gprods=true;
				for($i=0;$i<$_POST['cantiocu2'];$i++)
				{
				   if($_POST['nocodcarch'.$i])
				   { 
					  $ser->cod=$gua;
					  $agregprod=$ser->ins_prod($_POST['nocodcar'.$i],$_POST['orden'.$i]);
					  if($gprods==true && $agregprod==false) $gprods=false;
				   }
				}
			    if($gprods==true)
				  echo '<script>alert("Registro Guardado Exitosamente");document.form1.action="servicios_lista.php";document.form1.submit();</script>';
				else
				  echo '<script>alert("El Registro no pudo ser Guardado");</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
  }
  else 
   $ser= new servicio(0,'','','','','','',0);

 ?>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="titulofor">
      <td height="30" colspan="6"><div align="center" class="titulofor">Servicios</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto Estilo2" z><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50" onkeypress='return sincomillas(event)' />
        <span class="Estilo3" >*</span> </label></td>
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
      <td class="etiqueta">Posee Agenda:</td>
      <td colspan="3"><span class="texto">
        <select name="agenda" class="texto" id="agenda">
          <option value="">Seleccione---&gt;</option>
          <option value="S">Si</option>
          <option value="N">No</option>
        </select>
        <span class="Estilo3">*</span></span></td>
    </tr>
    <tr>
      <td class="etiqueta">Reporte Vigilancia:</td>
      <td colspan="3"><span class="texto">
        <select name="vigilancia" class="texto" id="vigilancia">
          <option value="">Seleccione---&gt;</option>
          <option value="S">Si</option>
          <option value="N">No</option>
        </select>
        <span class="Estilo3">*</span></span></td>
    </tr>
	
    <tr>
      <td colspan="4"><div align="center"><img src="imagenes/p_guardar1.gif" width="140" height="50" style="cursor:hand" onclick="Guardar();" 
		onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>            <input name="ocu_g" type="hidden" value="0"/> 
          <input type="hidden" name="ocu_e" value="0"/>        
      <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='servicios_lista.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
	<tr class="titulofor" onclick="mostrarprod()">
      <td height="30" colspan="4"><div align="center" class="titulofor">Servicios Asociados</div></td>
    </tr>
	 <tr>
      <td colspan="4"><div id="prod" style="display:block">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulorep" align="center">
    <td width="20">&nbsp;</td>
    <td width="380">Servicios </td>
    <td width="100">Precio </td>
	<td>Orden </td>
    </tr>	
	
<?php	  		
$serviprod2=$ser->consul_prod_serv_no(); 
$n2=mysql_num_rows($serviprod2);
$indi2=0;
?>
<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php echo $n2;?>" />
<?php
while ($row2=mysql_fetch_array($serviprod2))
{ 
  $nocodigo='nocodcar'.$indi2;
  $nocodigoch='nocodcarch'.$indi2;
  $orden='orden'.$indi2;
  
  if ($indi2%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
?>
  <tr class="texto" <?php echo $color; ?>  >
    <td width="20">
	<input name="<?php echo $nocodigo;?>" id="<?php echo $nocodigo;?>" type="hidden" value="<?php echo $row2[2]; ?>" />
	<input name="<?php echo $nocodigoch;?>" id="<?php echo $nocodigoch;?>"  type="checkbox" value="<?php echo $row2[2]; ?>" /></td>
    <td><?php echo $row2[0]; ?></td>
    <td> <div align="right"><?php echo $row2[1]; ?></div></td>
	<td><div align="center">
	  <input class="texto" name="<?php echo $orden; ?>" id="<?php echo $orden; ?>" type="text" value="0" size="5" />
	  </div></td>
  </tr>
<?php 
$indi2++; 
 }  ?>
</table>
	     
		 </div>
	  </td>
	 </tr>
  </table>

</form>
</body>
</html>
