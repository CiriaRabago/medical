<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<script>
function posicion()
{
document.getElementById('cedula').focus();
}


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

function validar()
{
	if(document.getElementById("cedula").value!='' && document.getElementById("nombre").value!='' && document.getElementById("telefono").value!='')
	{
	       document.form1.action="presu_pac.php";
		   document.getElementById("ingreso").value=1;
		   document.form1.submit();
	}

	else
	  alert('Debe ingresar todos los datos..')
}

function ir_orden_pac(val)
{
  if(val=='S')
  {
		   document.form1.action="presu_pac.php";
		   document.form1.submit();
  }
  else
  {
    alert('Usuario no Registrado');
  }

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

</script>
<body onload="posicion();">
<form name="form1" id="form1" method="post"  action="">

<?php  
 if($_POST['ingreso']==1)
 {
    //echo 'entro a verificar';
    $ord= new orden('','','','','','','');
	$reg=$ord->consul_pac($_POST['cedula']);
	//echo 'reg'.$reg.'fin reg';
	if($reg)
	{
	   ?>
	   <input name="paci" id="paci" type="hidden" value="<?php  echo $reg; ?>" />
	   <?php 
	   echo "<script>ir_orden_pac('S');</script>";
	}
	else
	   echo "<script>ir_orden_pac('N');</script>";
	
 }

?>
<table width="436" border="0" align="center" >
    <tr class="titulofor">
      <td height="30" colspan="3"><div align="center" class="titulofor">Presupuesto de Laboratorio </div></td>
    </tr>
    <tr>
      <td width="136" class="etiqueta">C&eacute;dula de Identidad:</td>
      <td width="290" colspan="2" class="texto">
        <input name="cedula" type="text" class="texto" id="cedula"  onkeypress='return soloNumeros(event)' />
      </td>
    </tr>
        <tr>
      <td width="136" class="etiqueta">Nombre:</td>
      <td width="350" colspan="2" class="texto">
        <input name="nombre" size="80" type="text" class="texto" id="nombre"   />
      </td>
    </tr>
    <tr>
      <td width="136" class="etiqueta">Telefono:</td>
      <td width="290" colspan="2" class="texto">
        <input name="telefono" type="text" class="texto" id="telefono"  onkeypress='return soloNumeros(event)' />
      </td>
    </tr> 
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" class="td-buttons"><div align="center">
<a href="#" onclick="validar();" class="button-add" alt="Ingresar"  > <i class="fa fa-plus" aria-hidden="true"></i> Ingresar </a>
<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
		<input name="ingreso" id="ingreso" type="hidden" value="0" /></div></td>
    </tr>
  </table>
</form>
</body>
</html>
