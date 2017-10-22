<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p>&nbsp;</p>
<?php  $visita=35; ?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="vertical-align:middle;">
  <tr>
    <td width="175" align="center"><img src="imagenes/p_referencia1.gif" name="agreg" width="150" height="50" border="0" id="agreg" style="cursor:hand" onclick="window.open('referencia_pdf.php?vis=<?php  echo $visita; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')" 
		onmouseover="this.src='imagenes/a_referencia1.gif'"  
		onmouseout="this.src='imagenes/p_referencia1.gif'"/></td>
    <td width="175" align="center"><img name="agreg" id="agreg" src="imagenes/p_solicitud1.gif" width="150" height="50" style="cursor:hand" onclick="window.open('solicitud_pdf.php?vis=<?php  echo $visita; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')" 
		onmouseover="this.src='imagenes/a_solicitud1.gif'"  
		onmouseout="this.src='imagenes/p_solicitud1.gif'"/></td>
    <td width="175" align="center"><img name="agreg" id="agreg" src="imagenes/p_recipeindic1.gif" width="150" height="50" style="cursor:hand" onclick="window.open('recipe_indic_pdf.php?vis=<?php  echo $visita; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')"  
		onmouseover="this.src='imagenes/a_recipeindic1.gif'"  
		onmouseout="this.src='imagenes/p_recipeindic1.gif'"/></td>
    <td width="175" align="center"><img name="agreg" id="agreg" src="imagenes/p_informed1.gif" width="150" height="50" style="cursor:hand" onclick="window.open('informe_med_pdf.php?vis=<?php  echo $visita; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')" 
		onmouseover="this.src='imagenes/a_informed1.gif'"  
		onmouseout="this.src='imagenes/p_informed1.gif'"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><img name="agreg" id="agreg" src="imagenes/p_histant1.gif" width="150" height="50" style="cursor:hand" onclick="window.open('historia_ant_pdf.php?vis=<?php  echo $visita; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')" 
		onmouseover="this.src='imagenes/a_histant1.gif'"  
		onmouseout="this.src='imagenes/p_histant1.gif'"/></td>
    <td align="center"><img name="agreg" id="agreg" src="imagenes/p_exafis1.gif" width="150" height="50" style="cursor:hand" onclick="referencia();" 
		onmouseover="this.src='imagenes/a_exafis1.gif'"  
		onmouseout="this.src='imagenes/p_exafis1.gif'"/></td>
    <td align="center"><img name="agreg" id="agreg" src="imagenes/p_infmedocu1.gif" width="150" height="50" style="cursor:hand" onclick="referencia();" 
		onmouseover="this.src='imagenes/a_infmedocu1.gif'"  
		onmouseout="this.src='imagenes/p_infmedocu1.gif'"/></td>
    <td align="center"><img name="agreg" id="agreg" src="imagenes/p_infmedfam1.gif" width="150" height="50" style="cursor:hand" onclick="referencia();" 
		onmouseover="this.src='imagenes/a_infmedfam1.gif'"  
		onmouseout="this.src='imagenes/p_infmedfam1.gif'"/></td>
  </tr>
</table>

</body>
</html>
