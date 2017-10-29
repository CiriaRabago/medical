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
	if(document.getElementById("nombre").value!='' && document.getElementById("edad").value!='' && document.getElementById("sexo").value!='')
	   document.form1.submit();
	else
	  alert('Falta ingresar Datos')

}

</script>
<body>
<form name="form1" id="form1" method="post" action="resultado.php">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulofor">
    <td colspan="4"><div align="center">RESULTADOS</div></td>
  </tr>
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr> 
  <tr>
    <td colspan="4" class="td-btn">
	  <div align="center">
	  <br><input name="orden" id="orden" type="text" class="texto" /><br>
    <a href="#" onclick="top.mainFrame.location.href='servicio.php'" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>
	  
	    </div></td>
  </tr> 
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>  
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr> 
  <?php     $ord= new orden('','','','','','','');
		$resu=$ord->result_ordenes();
		echo  $resu;
	 ?>
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td colspan="4" class="td-btn"><div align="center">
    <a href="#" onclick="top.mainFrame.location.href='servicio.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
	
  </tr>
</table>
<p>&nbsp;</p>
</form>
</body>
</html>
