<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>

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

function marca(nomb,abr)
{
  vect=document.form1.vexa.value;
  examenes=vect.split('**');
  cantiexa=examenes.length;
  if(document.getElementById(nomb).checked==false)
  {
	  for(i=0;i<cantiexa;i++)
	  { 
		document.getElementById(abr+String(examenes[i])).checked=false;
		document.getElementById(abr+String(examenes[i])).disabled=true;
	  }
  }
  if(document.getElementById(nomb).checked==true)
  {
	  for(i=0;i<cantiexa;i++)
	  { 
		document.getElementById(abr+String(examenes[i])).checked=true;
		document.getElementById(abr+String(examenes[i])).disabled=false;
		//alert(examenes[i]); 
	  }
  }
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
<?php   if($_POST['ingreso']) {?>
    <input name="ingreso" id="ingreso" type="hidden" value="<?php  echo $_POST['ingreso']; ?>" /> <?php  } ?>  
<?php   if($_POST['cedula']) {?>
    <input name="cedula" id="cedula" type="hidden" value="<?php  echo $_POST['cedula']; ?>" /> <?php  } 
$pagina=$_SERVER['HTTP_REFERER'];
if($pagina!='http://www.umsanluis.com/resultado.php' && $pagina!='http://www.umsanluis.com/lista_result.php')
  $pagina='http://www.umsanluis.com/resultado.php'; 



	?>  


<input name="pagina" id="pagina" type="hidden" value="<?php  echo $pagina; ?>" />
<table width="600" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Resultados de la Orden No. <?php  echo $_POST['orden'];  ?></div></td>
    </tr>
  <?php     $ord= new orden($_POST['orden'],'','','','','','');
		$resu=$ord->result_orden();
		if($resu!='')
			echo  $resu;
		else
			echo '<script>volver();</script>';
	 ?>
	 
	 <tr>
      <td height="30" colspan="4"><div align="center">
	  <input name="orden" id="orden" type="hidden" value="<?php  echo $_POST['orden']; ?>" />
	  <img src="imagenes/p_imprimir1.gif" alt="Imprimir Resultados" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="generar_pdf();" 
	  onmouseover="this.src='imagenes/a_imprimir1.gif'"  
	  onmouseout="this.src='imagenes/p_imprimir1.gif'"/>
	  
	  <img src="imagenes/p_salir1.gif" alt="Salir" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="top.mainFrame.location.href='<?php  echo $pagina; ?>'" 
	  onmouseover="this.src='imagenes/a_salir1.gif'"  
	  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
  </table>
</form>
</body>
</html>
