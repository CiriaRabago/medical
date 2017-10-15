<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_espec.php";
include "clases/clase_referencia.php";
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

function elimref(cod,nom)
{  
	resp=confirm("¿Desea Eliminar la Referencia \n "+nom+"?");
	if (resp==true)
	{	
		document.form1.ocu_N.value=cod;
		document.form1.ocu_e.value=1;
   		document.form1.submit();
	}

}

function Nuevo()
{  
	document.getElementById("nombes").value='';
	document.getElementById("nombes").disabled=false;
	document.getElementById("nombes").style.display='none';
	document.getElementById("espec").style.display='block';
	document.getElementById("espec").value='';
	document.getElementById("rif").value='';
	document.getElementById("nomb").value='';
	document.getElementById("direc").value='';
	document.getElementById("telf1").value='';
	document.getElementById("telf2").value='';
	document.getElementById("pre").value='';
	document.getElementById("tablaespe").style.display='block';
    document.form1.ocu_N.value=0;
}

function Guardar()
{  
	if(document.getElementById("ocu_N").value=='0')
	{
		var espenue=0;
		var refnue=0;
		if (document.getElementById("rif").value!='' || document.getElementById("nomb").value!=''
		   || document.getElementById("direc").value!='' || document.getElementById("telf1").value!=''
		   || document.getElementById("telf2").value!='' || document.getElementById("pre").value!='')
		{
		   if(document.getElementById("rif").value=='' || document.getElementById("nomb").value==''
		   || document.getElementById("direc").value=='' || document.getElementById("telf1").value==''
		   || isNaN(parseFloat(document.getElementById("pre").value)))
		   {
			  if(isNaN(parseFloat(document.getElementById("pre").value)))
			  {
				 alert('El precio no es un valor válido');
				 return false;
			  }
			  else
			  {
				 alert("Falta ingresar Datos");
				 return false;
			  }
		   }
		   else
		   {
			 refnue=1;
		   }
		}
		else
		{
		  if ( document.getElementById("espec").style.display == 'block' && document.getElementById("espec").value == '')
		  {
			alert('Debe ingresar datos para guardar');
			return false;
		  }
		  if ( document.getElementById("espec").style.display == 'block' && document.getElementById("espec").value != '')
		  {
			alert('Debe indicar datos de la referencia o agregar una nueva especialidad');
			return false;
		  }
		}
		  
		  
		if (document.getElementById("espec").style.display == 'block')
		{ 
		  if (document.getElementById("espec").value == '')
		  {
			alert('Debe Seleccionar la Especialidad');
			return false;
		  }
	   }
	   else
	   { 
		  if (document.getElementById("nombes").value == '')
		  {
			alert('Debe Escribir el nombre de la Especialidad');
			return false;
		  }
		  else
		  {
			espenue=1;
		  }
	   }
	   document.getElementById("guardaesp").value=espenue;
	   document.getElementById("guardaref").value=refnue;
    }
	
	if(document.getElementById("ocu_N").value!='0')
	{
		if(document.getElementById("ocu_M").value=='E')
		{
		  if (document.getElementById("nombes").value == '')
		  {
			alert('Debe Escribir el nombre de la Especialidad');
			return false;
		  }
		}
		if(document.getElementById("ocu_M").value=='R')
		{
			
			if(document.getElementById("rif").value=='' || document.getElementById("nomb").value==''
		   	|| document.getElementById("direc").value=='' || document.getElementById("telf1").value==''
		   	|| isNaN(parseFloat(document.getElementById("pre").value)))
		   	{
			  if(isNaN(parseFloat(document.getElementById("pre").value)))
			  {
				 alert('El precio no es un valor válido');
				 return false;
			  }
			  else
			  {
				 alert("Falta ingresar Datos");
				 return false;
			  }
		   }
		}
	}
   
   document.form1.ocu_g.value=1;
   document.form1.submit();
}


function modifes(cod,nom)
{
	document.getElementById("espec").style.display='none';
	document.getElementById("nombes").style.display='block';
	document.getElementById("nombes").value=nom;
	document.getElementById("nombes").disabled=false;
	document.getElementById("rif").value='';
	document.getElementById("rif").disabled=true;
	document.getElementById("nomb").value='';
	document.getElementById("nomb").disabled=true;
	document.getElementById("direc").value='';
	document.getElementById("direc").disabled=true;
	document.getElementById("telf1").value='';
	document.getElementById("telf1").disabled=true;
	document.getElementById("telf2").value='';
	document.getElementById("telf2").disabled=true;
	document.getElementById("pre").value='';
	document.getElementById("pre").disabled=true;
	document.getElementById("tablaespe").style.display='none';
	document.form1.ocu_N.value=cod;
	document.form1.ocu_M.value='E';
	
}


function modifref(cadena,nombe)
{
	var trozos = cadena.split("/*");
	document.getElementById("espec").style.display='none';
	document.getElementById("nombes").style.display='block';
	document.getElementById("nombes").value=nombe;
	document.getElementById("nombes").disabled=true;
	document.getElementById("rif").value=trozos[2];
	document.getElementById("nomb").value=trozos[3];
	document.getElementById("direc").value=trozos[4];
	document.getElementById("telf1").value=trozos[5];
	document.getElementById("telf2").value=trozos[6];
	document.getElementById("pre").value=trozos[7];
	document.getElementById("tablaespe").style.display='none';
	document.form1.ocu_pre.value=trozos[7];
	document.form1.ocu_N.value=trozos[0];
	document.form1.ocu_M.value='R';
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

function agregar()
{
	document.getElementById("espec").style.display='none';
	document.getElementById("nombes").style.display='block';
	document.getElementById("agreg").style.display='none';
	document.getElementById("cancel").style.display='block';
	//document.getElementById("existeesp").value=0;
}

function cancelar()
{
	document.getElementById("espec").style.display='block';
	document.getElementById("nombes").style.display='none';
	document.getElementById("agreg").style.display='block';
	document.getElementById("cancel").style.display='none';
	document.getElementById("tablaespe").style.display='block';
	//document.getElementById("existeesp").value=1;
}

function ver_refe(codi)
{
	if (document.getElementById('refea'+codi).style.display=="none")
	{	document.getElementById('refea'+codi).style.display='block'; }
	else
	{	document.getElementById('refea'+codi).style.display="none"; }
}
</script>
<body>
<form name="form1" id="form1" method="post" action="especialidad.php">
<?php 
 //$exa= new examen($_POST["ocu_N"],$_POST["nomb"],$_POST["abrev"],$_POST["obser"], $_POST["proc"], $_POST["valo"], $_POST["meto"], $_POST["pre"], $_POST["tipm"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	if($_POST["ocu_N"]=='0')
	{
		if($_POST["guardaesp"]==1)
		{
			$espe= new especialidad('',$_POST["nombes"]);
			$buse=$espe->buscaresp();
			if ($buse=='true')
				echo '<script>alert("La Especialidad YA EXISTE");</script>';
			else
			{
				$guae=$espe->ins_especialidad();
				if ($guae!=false)
				{
					$codespe=$guae;
					echo '<script>alert("Especialidad Guardada Exitosamente");</script>';
				}
				else
					echo '<script>alert("La Especialidad no pudo ser Guardada");</script>';
			}
		}
		else
		{
			$codespe=$_POST["espec"];
		}
		if($_POST["guardaref"]==1)
		{
			$refe= new referencia('',$codespe,$_POST["rif"],$_POST["nomb"],$_POST["direc"],$_POST["telf1"],$_POST["telf2"],$_POST["pre"],'A','','');
			$busr=$refe->buscarref();
			if ($busr=='true')
				echo '<script>alert("Este registro YA Existe");</script>';
			else
			{
				$guar=$refe->ins_referencia();
				if ($guar)
					echo '<script>alert("Referencia Guardada Exitosamente");</script>';
				else
					echo '<script>alert("La Referencia no pudo ser Guardada");</script>';
			}
		}
	}
	if($_POST["ocu_N"]!='0')
	{
		if($_POST["ocu_M"]=='E') //Esta modificando especialidad
		{
			$espe= new especialidad($_POST["ocu_N"],$_POST["nombes"]);
			$guam=$espe->modf_espe();
			if ($guam)
			{
				echo '<script>alert("Especialidad Modificada Exitosamente");</script>';
			}
			else
				echo '<script>alert("La Especialidad no pudo ser Modificada");</script>';
		}

		if($_POST["ocu_M"]=='R') //Esta modificando referencia
		{
			$refe= new referencia($_POST["ocu_N"],'',$_POST["rif"],$_POST["nomb"],$_POST["direc"],$_POST["telf1"],$_POST["telf2"],$_POST["pre"],'A','','');
			$guam=$refe->modf_refe();
			if ($guam)
			{
				if($_POST["ocu_pre"]!=$_POST["pre"])
					$camp=$refe->cambio_de_precio($_POST["pre"],$_POST["ocu_N"],$_SESSION['cedu_usu']);
				echo '<script>alert("Referencia Modificada Exitosamente");</script>';
			}
			else
				echo '<script>alert("La Referencia no pudo ser Modificada");</script>';
		}
		
 	} // Fin de si esta modificando
  } // Fin de si esta guardando

  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	
		$refe= new referencia($_POST["ocu_N"],'','','','','','','','I','','');
		$guae=$refe->eliminar();
		if ($guae)
			echo '<script>alert("Referencia Eliminada Exitosamente");</script>';
		else
			echo '<script>alert("La Referencia no pudo ser Eliminada");</script>';
	}
	
	if (isset($_POST["ocu_ee"])!='0' && $_POST["ocu_ee"]!='0' ) //para eliminar
	{	
		$espe= new especialidad($_POST["ocu_N"],$_POST["nombes"]);
		$elies=$espe->inact_espe();
		if ($elies)
		{
			echo '<script>alert("Especialidad Eliminada Exitosamente");</script>';
		}
		else
			echo '<script>alert("La Especialidad no pudo ser Eliminada");</script>';
	}
?>
 
  <table width="600" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr class="titulofor">
      <td colspan="4"><div align="center" class="titulofor">Especialidad</div></td>
    </tr>
	<input name="guardaesp" id="guardaesp" type="hidden" value="0" />
	<input name="guardaref" id="guardaref" type="hidden" value="0" />
    <tr>
      <td class="etiqueta" colspan="2">Especialidad: <span class="Estilo1">*</span></td>
      <td class="texto" colspan="2"><label><select name="espec" id="espec" class="texto"  style="display:block">
        <option value="">Seleccione --&gt;</option>
		<?php $espe= new especialidad('','');
	   echo $espe->combo_esp(); ?> 
      </select>
        <input name="nombes" id="nombes" type="text" class="texto"  size="50"  onkeypress='return sincomillas(event)' style="display:none "/>
		 
		 <input name="ocu_N" id="ocu_N" type="hidden" value="0"/>
		 <input name="ocu_M" id="ocu_M" type="hidden" value=""/>
             </label></td>
    </tr>
	<tr>
      <td colspan="4" class="td-buttons">
	    <div align="center">
	    <a name="agreg" id="agreg" href="#" onclick="agregar();" class="button-add" alt="Agregar"  > <i class="fa fa-plus" aria-hidden="true"></i> Agregar </a>
	    <a name="cancel" id="cancel"  href="#" onclick="cancelar();" class="button-close" alt="Salir" style="cursor:hand;display:none"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>

		  <input name="ocu_a" type="hidden" value="0"/>   
	      <input type="hidden" name="ocu_c" value="0"/>      
        </div>
    </tr>
	<tr class="titulofor">
      <td colspan="2">&nbsp;</td>
	  <td width="324" ><div align="center" class="titulofor">Referencia</div></td>
	  <td width="135"><div align="right"></div></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Cedula o Rif :</td>
      <td  colspan="2" class="texto"><label>
        <input name="rif" type="text" class="texto" id="rif"  onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Nombre</td>
      <td  colspan="2"class="texto"><input name="nomb" type="text" class="texto" id="nomb" onkeypress="return sincomillas(event)" value="" size="50" />
      <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Direcci&oacute;n:</td>
      <td colspan="2" class="texto"><textarea name="direc" cols="50" rows="2" class="texto" id="direc"  onkeypress='return sincomillas(event)'></textarea> <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Telefono 1 :</td>
      <td  colspan="2" class="texto"><input name="telf1" type="text" class="texto" id="telf1" size="50"  onkeypress='return sincomillas(event)'/> <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Tel&eacute;fono 2: </td>
      <td  colspan="2" class="texto"><input name="telf2" type="text" class="texto" id="telf2" size="50"  onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta"  colspan="2">Precio:</td>
      <td  colspan="2" class="texto"><input name="pre" type="text" class="texto" id="pre" />  <span class="Estilo1">*</span>Ejemplo: 30.5 <input name="ocu_pre" type="hidden" id="ocu_pre" value="0" /></td>
    </tr>
    
    <tr>
      <td  colspan="2"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
      <td colspan="2" class="texto">&nbsp;</td>
    </tr>
	
	
    <tr>
      <td colspan="4" class="td-buttons">
      	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

           <input name="ocu_g" type="hidden" value="0"/>   <input type="hidden" name="ocu_e" value="0"/>    </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <div id="tablaespe" style="display:block"><?php 
    $ver=$espe->ver_especialidad();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar las referencias');</script>";
		} 
		else
		{
		    echo $ver;
		}  ?>
  </div>
</form>
</body>
</html>
