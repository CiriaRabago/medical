<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script>
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

function posicion()
{
	document.getElementById('orden').focus();
}


function buscar()
{
 if(document.getElementById('orden').value!='')
 {
	 document.form1.ocu_bus.value=1;
	  document.form1.ocu_ord.value=document.getElementById("orden").value;
	 document.form1.submit();
 }
 else
   	alert('Debe indicar el Número de Orden');

}
function Guardar()
{  
	if (document.getElementById("fac").value!='')
	{
		document.form1.ocu_g.value=1;			
		document.form1.submit();
	}
		else
			alert("Ingrese el Número de la Factura");
	
}
</script>
<body onload="posicion();">
<form id="form1" name="form1" method="post" action="pagar_orden.php">
  <?php  $mos='style="display:none"';
   if (isset($_POST["ocu_bus"])!='0' && $_POST["ocu_bus"]!='0' ) //para eliminar
	{	 $ord= new orden($_POST['orden'],'','','','','','');  
	   	 $bus=$ord->buscar_orden();
		if ($bus!='false')
			{
				$monto=$bus;
				$mos='style="display:block"';
				$mos1='style="display:none"';
			}
		else
			echo '<script>alert("No existe número de orden");</script>';
		
	} 
	if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  
	$ord= new orden($_POST['ocu_ord'],'',$_POST['fac'],'','','','');  
	$gua=$ord->pagar();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
  }
	 ?>
  <table width="537" border="0" align="center" cellpadding="0" cellspacing="0" <?php  echo $mos1; ?>>
    <tr class="titulofor">
      <td colspan="4"><div align="center">Pagar la Orden </div></td>
    </tr>
    <tr>
      <td height="3" colspan="4"><img src="imagenes/blanco.gif" alt="ima" width="100%" height="3" /></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons"><div align="center">
          <p class="textoN"><br />
            Orden No.
            <input name="orden" id="orden" type="text" class="texto" onkeypress='return soloNumeros(event)'/>
            <br />
            <a href="#" onclick="buscar();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>
             <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

            <input name="ocu_bus" type="hidden" id="ocu_bus" value="0" />
          </p>
      </div></td>
    </tr>
    <tr>
      <td height="30" colspan="4"><img src="imagenes/naranja.gif" alt="ima" width="100%" height="3" /></td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">
      </td>
    </tr>
  </table>
  <table width="537" height="174" border="0" align="center" <?php  echo $mos; ?>>
    <tr class="titulofor">
      <td height="20" colspan="2"><div align="center">Pagar la Orden </div></td>
    </tr>
    <tr>
      <td height="22" colspan="2" class="etiqueta"><div align="left"> Monto a pagar de la Orden: <?php  echo $monto; ?>  </div></td>
    </tr>
    <tr>
      <td width="257" height="44" class="etiqueta"><div align="right">Nro. de Factura: </div></td>
      <td width="270"><label>
        <input name="fac" type="text" class="texto" id="fac" size="30" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2" class="etiqueta td-buttons"><div align="center"><span class="textoN">

      <a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>
      <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></span>
        <input name="ocu_g" type="hidden" id="ocu_g" value="0" />
        <span class="textoN">
        <input name="ocu_ord" type="hidden" id="ocu_ord" value="<?php  echo $_POST['ocu_ord']; ?>" />
        </span>      </div></td>
    </tr>
    <tr>
      <td colspan="2" class="etiqueta"><div align="center"><img src="imagenes/naranja.gif" alt="ima" width="100%" height="3" /></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
