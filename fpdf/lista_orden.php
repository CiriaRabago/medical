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
	if(document.getElementById("cedula").value!='')
	{
		   document.getElementById("ingreso").value=1;
		   document.form1.submit();
	}

	else
	  alert('Debe ingresar la cédula o identificación')
}

function ir_orden_pac(val)
{
  if(val=='S')
  {
		   document.form1.action="orden_pac.php";
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

function irpdf(ord,pag)
{
	document.getElementById('orden').value=ord; 
	//alert(document.getElementById('orden').value);
	document.form1.action=pag;
	document.form1.submit();
}

</script>
<body>
<form name="form1" id="form1" method="post">

<?php  
 if($_POST['ingreso']==1)
 {
    //echo 'entro a verificar';
    $ord= new orden('','','','','','','');
	//$reg=$ord->lista_orden_pac($_POST['cedula']);
	$paci=$ord->consul_pac($_POST['cedula']);
	if($paci)
	{
	   
		//$paci=$ord->consul_pac($_POST['cedula']);
		$datos=explode('/*',$paci); 
		 if($datos[6]=='F')
		   $sexo='Femenino';
		 else
		   $sexo='Masculino';
		$reg=$ord->lista_orden_pac($datos[0]);
	   ?>
	   
	   		<table width="700" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="5"><div align="center" class="titulofor">Ordenes por Paciente </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="5"><div align="left" class="texto"> 
	  			<span class="textoN">CÉDULA: <?php  echo $datos[11]; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php  echo $datos[11]; ?>" /><br>
      			<span class="textoN">NOMBRE</span>: <?php  echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?><input name="nombre" id="nombre" type="hidden" value="<?php  echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?>" /><br>
	  			<span class="textoN">EDAD</span>: <?php  echo calculaedad($datos[5]); ?><input name="edad" id="edad" type="hidden" value="<?php  echo calculaedad($datos[5]); ?>" /><br>
	  			<span class="textoN">SEXO</span>: <?php  echo $sexo; ?><input name="sexo" id="sexo" type="hidden" value="<?php  echo $datos[6]; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php  echo $sexo; ?>" /><br>
	  			<span class="textoN">EMPRESA: </span><?php  echo $datos[8]; ?><input name="empresa" id="empresa" type="hidden" value="<?php  echo $datos[7]; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php  echo $datos[8]; ?>" />
				</div><br></td>
			</tr>
			
			<tr class="titulorep">
			  <td width="20">ORDEN</td>
			  <td width="200">FECHA</td>
			  <td width="100">MONTO</td>
			  <td width="80">PAGADO</td>
			  <td width="150">IMPRIMIR ORDEN</td>
			</tr>	   
	   
<?php 	   $cont=0;
	   while ($row=mysql_fetch_array($reg))
	   { 
	      if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		  $cont++;
	   ?>
			<tr class="texto" <?php  echo $color; ?>>
			  <td width="20"><?php  echo $row[0]; ?></td>
			  <td width="100"><?php  echo $row[1]; ?></td>
			  <td width="100"><?php  echo $row[2]; ?></td>
			  <td width="80"><?php  echo $row[3]; ?></td>
			  <td width="200"><a href="det_orden_pac.php?orden=<?php  echo $row[0]; ?>&ced=<?php  echo $datos[11]; ?>">ORDEN</a></td>
			</tr>
           <?php  } ?>  
			<tr>
			  <td colspan="5"><div align="center">
				<img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" 
				width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
				onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
				<input name="orden" id="orden" type="hidden" value="0" /></div></td>
			</tr>
		  </table>
	   
	<?php    
	}
	die();
 }

?>

<table width="436" border="0" align="center" >
    <tr class="titulofor">
      <td height="30" colspan="3"><div align="center" class="titulofor">Ordenes por Paciente </div></td>
    </tr>
    <tr>
      <td width="136" class="etiqueta">C&eacute;dula de Identidad:</td>
      <td width="290" colspan="2" class="texto">
        <input name="cedula" type="text" class="texto" id="cedula"  onkeypress='return soloNumeros(event)' />
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center"><img src="imagenes/p_ingresar1.gif" alt="Nueva unidad de medida" width="140" height="50" style="cursor:hand" onclick="validar();" 
		onmouseover="this.src='imagenes/a_ingresar1.gif'"  onmouseout="this.src='imagenes/p_ingresar1.gif'"/>
		<img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" 
		width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
		<input name="ingreso" id="ingreso" type="hidden" value="0" /></div></td>
    </tr>
  </table>
</form>
</body>
</html>
