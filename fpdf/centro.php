<?php session_start();
if(session_is_registered("principal"))
{
	session_unregister("principal");
	session_unregister("glob_usu");
	session_destroy();
	session_start();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
-->
</style>
<script>

function verifi()
{  
	if (document.getElementById("USUARIO").value!='' && document.getElementById("CLAVE").value!='')
	{
		document.form1.submit();
	}
	else
	 alert("Debe ingresar Usuario, Clave y letras de la imagen");
}
function posicion()
{
document.getElementById('USUARIO').focus();
}
</script>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>

<body onload="posicion();">
<div align="center">
<form id="form1" name="form1" method="post" action="ingresar.php">
  <table width="533" height="169" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#D4D0C8" bgcolor="#FFFFFF">
    <tr bordercolor="#CCCCCC" bgcolor="#00CCCC" class="titulofor">
      <td height="26" colspan="3" ><div align="center" class="TituloF">Acceso al Sistema </div></td>
    </tr>
    <tr>
      <td width="273" height="26"><div align="right" class="Estilo2 Estilo3 Estilo9 Estilo13 Estilo15 Estilo21">
          <div align="left" class="Estilo1 Estilo15 Estilo22">
            <div align="right"><strong><span class="Etiqueta"><span class="etiqueta">Usuario:</span></span></strong></div>
          </div>
      </div></td>
      <td colspan="2"><div align="left">
          <label> <span class="Estilo14">
          <input name="USUARIO" type="text" class="texto" id="USUARIO" size="15" />
          </span></label>
            </div>
          </td>
    </tr>
    <tr>
      <td height="23"><div align="right" class="Estilo3 Estilo9 Estilo13 Estilo15 Estilo21">
          <div align="left">
            <div align="right"><span class="etiqueta"><strong>Clave:</strong></span></div>
          </div>
      </div></td>
      <td colspan="2"><div align="left"><span>
          <input name="CLAVE" type="password" class="texto" id="CLAVE" size="15" onchange="submit();" />
      </span></div></td>
    </tr>
    
    <tr>
      <td height="47" colspan="3"><div align="center"><img src="imagenes/p_ingresar1.gif" style="cursor:hand" onclick="verifi();" 
		onmouseover="this.src='imagenes/a_ingresar1.gif'"  onmouseout="this.src='imagenes/p_ingresar1.gif'"/>&nbsp;</div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
