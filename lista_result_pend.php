<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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

function enviar()
{

	var indice = document.form1.perfil.selectedIndex; 
	document.form1.perfilocu.value=document.form1.perfil.options[indice].text;
	document.form1.action='resultado_examen.php';
	document.form1.submit();
}

function generar_pdf()
{
	document.form1.action='resultado_orden_pdf.php';
	document.form1.submit();
}

function volver()
{
	 alert("La Orden no existe");
	 document.form1.action='resultado.php';
	 document.form1.submit();
}
</script>
<body>
<?php 
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php";
include "clases/clase_orden.php";
?>

<form name="form1" id="form1" method="post" action="resultado_exa.php">
<table width="700" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="2"><div align="center" class="titulofor">Exámenes Pendientes por Resultados</div></td>
    </tr>
	<tr>
      <td height="30" colspan="2"><div align="center">
  <?php    $ord= new orden('','','','','','','');
		$resu=$ord->result_ordenes_pend();
		echo  $resu;
	 ?>
	  </div></td>
     </tr>
	 <tr>
      <td height="30" colspan="2"><div align="center">
	  <img src="imagenes/p_salir1.gif" alt="Salir" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="top.mainFrame.location.href='salir.php'" 
	  onmouseover="this.src='imagenes/a_salir1.gif'"  
	  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
  </table>
</form>
</body>
</html>
