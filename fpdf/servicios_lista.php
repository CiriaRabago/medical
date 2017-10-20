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
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
-->
</style>
</head>
 
<script>
function elim(codi)
{  	     
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{
		 document.form1.action='servicios_elim.php';
         document.getElementById('codauxser').value=codi;
	     document.getElementById('codaccion').value='M';
	     document.form1.submit();
		}
}		
function modif(codi)
{
	document.form1.action='servicios_modif.php';
	document.getElementById('codauxser').value=codi;
	document.getElementById('codaccion').value='M';
	document.form1.submit();
}

    
function Nuevo()
{  
	document.form1.action='servicios_nuevo.php';
	document.form1.submit();
}
function ver_ser(codi)
{
	if (document.getElementById('servi'+codi).style.display=="none")
	{	document.getElementById('servi'+codi).style.display='block'; }
	else
	{	document.getElementById('servi'+codi).style.display="none"; }


}
</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="servicios_lista.php">
  <table width="600" border="0" align="center">
    <tr class="titulofor">
      <td height="30"><div align="center" class="titulofor">Servicios</div></td>
    </tr>
	<tr>
      <td class="td-btn">
		<div align="center">
		<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

		<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

	      </div></td>
    <tr>
	 <tr>
      <td><div id="ls">
	  <?php  
	  
	    $ser= new servicio(0,'','','','','','',0);
   		$ver=$ser->ver_servicios();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Servicios');</script>";
		} 
		else
		{
		    echo $ver;
		}		
	?>
	     </div>
	  </td>
	 </tr>
  </table>
<input name="codauxser" id="codauxser" type="hidden" value="0" />
<input name="codaccion" id="codaccion" type="hidden" value="0" />


</form>
</body>
</html>
