<?php  
session_start();
//include "Clases/clase_conexion.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="Estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="597" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
  <tr>
    <td colspan="2"><div align="left" class="titulofor">
      <div align="center">Respaldo de la Base de Datos </div>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p>&nbsp;</p>
    <p>Al realizar un respaldo de la Base de Datos se crear&aacute; un archivo con extensi&oacute;n sql el cual se podr&aacute; utilizar para importar la base de datos en caso de una emergencia.</p>
    <form name="form1" method="post" action="GuardaResp.php">
	<img src="imagenes/p_guardar1.gif" alt="Guardar Respaldo" width="140" height="50" style="cursor:hand" onclick="document.form1.submit();" onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
    <img src="imagenes/p_salir1.gif" alt="Salir" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
    </form>    </td>
  </tr>
</table>
</body>
</html>
