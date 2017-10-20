<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_usuario.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo22 {	font-size: 18px;
	color: #FFFFFF;
}
.Estilo24 {font-size: 10px}
.Estilo25 {font-weight: bold; font-size: 10px; }
.Estilo26 {font-size: 12px}
.Estilo28 {color: #000066}
.Estilo29 {	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<script>
function Guardar()
{  
if (document.getElementById("claa").value!='' && document.getElementById("clan").value!='' && document.getElementById("clac").value!='')
	{
		  	if (document.getElementById("clan").value == document.getElementById("clac").value)
		   {
		   		document.form1.ocu_g.value='1';
				document.form1.submit();
			}
			else
				alert("La nueva Clave y la confirmación no coinciden");
	}
		else
			alert("Falta ingresar Datos");
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
</script>
<body>
<form id="form1" name="form1" method="post" action="mantenimiento.php">
    <?php 
			     $ver='style="display:none"';
				 $bus= new usuario($_SESSION["cedu_usu"],'','','','','','','');
			     $CAD= $bus->buscar_usuario();
				 if ($CAD!='FALSE')
				 	{$vec=explode('**',$CAD);
					 $nombre=$vec[0].' '.$vec[1].' '.$vec[2].' '.$vec[3];
					 $buscla=$vec[4];
				     $ver='style="display:block"';
				    }
				 else
					{  echo '<script>alert("No se consiguen los datos del usuario");</script>';
			     	$ver='style="display:none"'; 
			    	}

 if($_POST["ocu_g"]=='1')
  { $bus= new usuario($_SESSION["cedu_usu"],$_POST["clan"],'','','','','','');
  		if($_POST["claa"]==$buscla)
		{
		$gua=$bus->modificar_clave();
		if ($gua)
			{
				echo '<script>alert("Clave Modificada Exitosamente");</script>';
			}
		else
			echo '<script>alert("Clave no pudo ser Modificada");</script>';
		}
		else
			echo '<script>alert("Clave Actual Erronea");</script>';
  }
  
     ?></p>
    <table width="536" border="0" align="center"  bgcolor="#FFFFFF" <?php  echo $ver; ?>>
      <tr class="titulofor">
        <td colspan="2"><div align="center"><?php  echo $nombre; ?> </div></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo24 Etiqueta"><div align="center" class="Estilo29">
            <label class="etiqueta">Cambiar mi Clave</label>
        </div></td>
      </tr>
      <tr >
        <td colspan="2"> <div align="center"></div></td>
      </tr>
      <tr>
        <td width="164" class="etiqueta"><strong>Clave Actual: </strong></td>
        <td width="364" class="texto"><label>
          <input name="claa" type="password" class="texto" id="claa" maxlength="6" />
          <input name="claact" type="hidden" id="claact"  value="<?php  echo $buscla; ?>"/>
          </label>
       </td>
      </tr>
      <tr>
        <td class="etiqueta"><strong>Clave Nueva: </strong></td>
        <td class="texto">
          <label>
          <input name="clan" type="password" class="texto" id="clan" maxlength="6" />
          </label>
       
        <label><span class="etiqueta"> m&aacute;ximo 6 caracteres </span></label>        </td>
      </tr>
      <tr>
        <td class="etiqueta">Confirmar Clave: </td>
        <td class="texto"><span class="Estilo26">
          <label>
          <input name="clac" type="password" class="texto" id="clac" maxlength="6" />
          </label>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" class="Etiqueta"><div align="center"><span class="textoN"><img src="imagenes/p_guardar1.gif" alt="Guardar la caracteristica" width="140" height="50" style="cursor:hand" onclick="Guardar();" onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/><img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" 
	width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='salir.php'" 
	onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></span><span class="Texto"><span class="Estilo26">
            <input type="hidden" name="ocu_g"  value="0"/>
        </span></span></div></td>
      </tr>
    </table>
</form>
</body>
</html>