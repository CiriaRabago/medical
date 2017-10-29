<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
include "clases/clase_orden.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Laboratorio</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
function soloNumerico(obj){ 
var tecla = window.event.keyCode;
	if ( tecla < 10 ) {
        return true;
    }
    if ( tecla != 46 && (tecla < 48 || tecla > 59) ) 
	{
	   window.event.keyCode=0;
    } else {
        return true;
    }
}

function desplega(pf)
{
  if(document.getElementById("per"+pf).style.display=="none")
		document.getElementById("per"+pf).style.display="block";
  else  
  		document.getElementById("per"+pf).style.display="none";

}


function sumarexaper(pf,exa)
{
	var perfil='maxexaper'+String(pf);
	document.getElementById(perfil).value=exa;
}

function sumarper(pf)
{
	document.getElementById('maxper').value=pf;
	//alert(document.getElementById('maxper').value);
}


function marcarexa(pf)
{
	 var perfil='perfil'+String(pf);
	 var montoperf='ocumontoper'+String(pf);
	 var ind=1;
	 var maxperfil='maxexaper'+String(pf);
	 var cantiexa=document.getElementById(maxperfil).value;
	 
	 if(document.getElementById(perfil).checked==true)
	 {       
			 document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)+parseFloat(document.getElementById(montoperf).value);
			 while(ind<=cantiexa)
			 {
				if (document.getElementById('examen'+String(pf)+'**'+String(ind)).checked==true)
				{
					document.getElementById('examen'+String(pf)+'**'+String(ind)).click();
				}
				document.getElementById('examen'+String(pf)+'**'+String(ind)).checked=true;
				document.getElementById('examen'+String(pf)+'**'+String(ind)).disabled=true;
				ind++;
			 }
	 }
	 else
	 {
	 		 //alert('resta perfil y desmarca todos');
			 document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)-parseFloat(document.getElementById(montoperf).value);
			 while(ind<=cantiexa)
			 {
				if (document.getElementById('examen'+String(pf)+'**'+String(ind)).checked==true)
				{
				    document.getElementById('examen'+String(pf)+'**'+String(ind)).checked=false;
				}
				document.getElementById('examen'+String(pf)+'**'+String(ind)).disabled=false;
				ind++;
			 }
	 }
}

function cuenta(pf,exa,m)
{
  if (document.getElementById('examen'+String(pf)+'**'+String(exa)).checked==false)
  {
		document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)-parseFloat(m);
  }
  if (document.getElementById('examen'+String(pf)+'**'+String(exa)).checked==true)
  {
		document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)+parseFloat(m);
  }
  
}

function Guardar()
{
  if(parseFloat(document.getElementById('monto').value)>0)
  {
  	
	var perles=document.getElementById('maxper').value;
	var indper=1;
	while(indper<=perles)
	{
	   var ind=1;
	   var maxperfil='maxexaper'+String(indper);
	   var cantiexa=document.getElementById(maxperfil).value;
	   while(ind<=cantiexa)
	   {
			if (document.getElementById('examen'+String(indper)+'**'+String(ind)).checked==true)
			{
  				//alert('entra a examen chequedao');
				document.getElementById('examen'+String(indper)+'**'+String(ind)).disabled=false;
			}
			ind++;
	   }   
	   indper++;
	}
	
	document.getElementById('guar').value=1;
	document.form1.action="orden_pac_reg.php";
	document.form1.submit();
  }
  else
  {
	alert('Debe seleccionar al menos un examen para guardar la orden');
  }
}

</script>
<body>

<form name="form1" id="form1" method="post" action="">

<?php 
$ord= new orden('','','','','','','');

if($_POST['paci'])
{
 	$datpac=$_POST['paci'];
}
else
{
 
	$reg=$ord->consul_pac_ID($_GET['pac']);
 	$datpac=$reg;   
}

   $datos=explode('/*',$datpac); 
    if($datos[6]=='F')
	   $sexo='Femenino';
	 else
	   $sexo='Masculino'; 

?>
<input name="visita" id="visita" type="hidden" value="<?php  echo $_GET['visi']; ?>" />

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr bgcolor="#E3E3C6">
    <td width="500" bgcolor="#E3E3C6" class="texto">
	  <div align="left"><img src="imagenes/Logo1.png" /></div></td>
    <td width="300" bgcolor="#E3E3C6" class="texto">
	  <span class="textoN">FECHA</span>:  <?php  echo date('d-m-Y'); ?><br>
	  <span class="textoN">CÉDULA: <?php  echo $datos[11]; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php  echo $datos[11]; ?>" />
	  <input name="idpac" type="hidden" id="idpac" value="<?php  echo $datos[0]; ?>"/>
	  <br>
      <span class="textoN">NOMBRE</span>: <?php  echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?><input name="nombre" id="nombre" type="hidden" value="<?php  echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?>" /><br>
	  <span class="textoN">EDAD</span>: <?php  echo calculaedad($datos[5]); ?><input name="edad" id="edad" type="hidden" value="<?php  echo calculaedad($datos[5]); ?>" /><br>
	  <span class="textoN">SEXO</span>: <?php  echo $sexo; ?><input name="sexo" id="sexo" type="hidden" value="<?php  echo $datos[6]; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php  echo $sexo; ?>" /><br>
	  <span class="textoN">EMPRESA: </span><?php  echo $datos[8]; ?><input name="empresa" id="empresa" type="hidden" value="<?php  echo $datos[7]; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php  echo $datos[8]; ?>" />
	  </td>
    </tr>
	  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3"  class="textoN">MONTO
      <input name="monto" id="monto" type="text"  value="0" class="textoN" /></td>
	<td height="3">
	
	<img src="imagenes/p_guardar1.gif" alt="Registrar la Orden" width="140" height="50" style="cursor:hand" onclick="Guardar();" onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>

	 <?php  if($_GET['visi']) { ?>
	<img src="imagenes/p_salir1.gif" alt="Salir de la Orden" width="140" height="50" style="cursor:hand" onclick="window.close();" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
	 <?php  } else{ ?>
	<img src="imagenes/p_salir1.gif" alt="Salir de la Orden" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='servicio.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
	 <?php  } ?>

	<input name="guar" id="guar" type="hidden" value="0" />
	</td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td colspan="2" ><?php  
	
	$ord= new orden('','','','','','','');
	echo $ord->perfil_exa(); ?>
	
	</td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
</table>
</form>
</body>
</html>
