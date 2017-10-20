<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
include "clases/clase_orden.php";
include "clases/clase_visita.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orden de Laboratorio</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
function generar_pdf()
{
	document.form1.action='presupuesto_pdf.php';
	document.form1.submit();
}
      
</script>
<body>

<form name="form1" id="form1" method="post" action="">

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3" colspan="2"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
  </tr>
  <tr bgcolor="#E3E3C6">
    <td height="55" bgcolor="#E3E3C6" ><div align="left"><img src="imagenes/Logo1.png" /></div>
	  </td>
    <td bgcolor="#E3E3C6" class="texto">
	  <span class="textoN">FECHA</span>:  <?php  echo date('d-m-Y'); ?><br>
	  <span class="textoN">CÉDULA: <?php  echo $_POST['cedula']; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php  echo $_POST['cedula']; ?>" />
	  <input name="idpac" type="hidden" id="idpac" value="<?php  echo $_POST['idpac']; ?>"/>
	  <br>
      <span class="textoN">NOMBRE</span>: <?php  echo $_POST['nombre']; ?><input name="nombre" id="nombre" type="hidden" value="<?php  echo $_POST['nombre']; ?>" /><br>
  <span class="textoN">TELEFONO</span>: <?php  echo $_POST['telefono']; ?><input name="telefono" id="telefono" type="hidden" value="<?php  echo $_POST['telefono']; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php  echo $_POST['empresanom']; ?>" /><br>
	
	</td>
    </tr>
	  <tr>
    <td height="3" colspan="2"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td colspan="2" >
	    <input type="hidden" name="x" id="x" value="" />
		<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr class="titulorep">
				<td width="600">EXAMEN</td>
				<td width="100">MONTO</td>
			  </tr>
<?php 	         $x=0;
	         $acum=0;
			$bandet=0;
			$perfil=$_POST['maxper'];
			for($i=1;$i<=$perfil;$i++)
			{
			   $exaper=$_POST['maxexaper'.$i];
			   for($j=1;$j<=$exaper;$j++)
			   {
			       if($_POST['examen'.$i.'**'.$j])
				   {
				       $ex=new examen($_POST['ocuexamen'.$i.'**'.$j],'','','','','','','','');
					   $exa=$ex->consul_examen_todo();
					   echo '<input type="hidden" name="exa'.$x.'" id="exa'.$x.'"  value="'.$exa[1].'" />';
					   echo '<input type="hidden" name="mon'.$x.'" id="mon'.$x.'" value="'.$exa[7].'" />';
					   echo "<tr class='texto'>
				<td align='left'>".$exa[1]."</td>
				<td align='right'>".$exa[7]."</td>
			</tr>";
			       $x++; 
				   $acum+=$exa[7];
				   $bandet++;
				   }
			   }			   
			}
			
	echo '<input type="hidden" name="x" id="x" value="'.$x.'" />';
  ?>
			
		<tr class="textoN">
			<td align="left" class="textoN">Total</td>
			<td align="right" class="textoN"><?php  echo $acum; ?></td>
		</tr>
		</table>

	</td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="center">  
		<img src="imagenes/p_imprimir1.gif" alt="Imprimir Orden" width="140" height="50" 
	  	style="cursor:hand" 
	 	 onclick="generar_pdf();" 
	  	onmouseover="this.src='imagenes/a_imprimir1.gif'"  
	  	onmouseout="this.src='imagenes/p_imprimir1.gif'"/>
		
	 <?php  if($_POST['visita']!='') { ?>
	    <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="window.close();" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>	</td>
	 <?php  } else{ ?>
	    <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='servicio.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>	</td>
	 <?php  } ?>
  </tr>
</table>

</form>
</body>
</html>
