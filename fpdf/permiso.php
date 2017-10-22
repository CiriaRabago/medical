<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_permiso.php";
include "clases/clase_usuario.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>
<script>
function sincomillas(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode == 34 || charCode ==39) {
  		alert("No se permite comillas");
 		return false;
  	}
	return true;
} 
function eliminar()
{  if (document.form1.ocu_N.value==0)
	{	
		alert("Para Eliminar, Debe Seleccionar un registro de la lista");
	}
	else
	{	
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
   			document.form1.ocu_e.value=1;
			document.form1.submit();
		}
	}
}
function Nuevo()
{  
	document.getElementById("nivel").value='0';
	document.getElementById("alias").value='';
	document.getElementById("pag").value='';
	document.getElementById("des").value='';
	document.getElementById("padre").value='0';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  
	//alert(document.getElementById("ftot").value);
	document.form1.ocu_g.value=1;		
	/*document.getElementById("ingreso").value=1;*/	
	document.form1.submit();
}

function Salir()
{  
	document.form1.ocu_g.value=0;		
	document.getElementById("ingreso").value=0;	
	document.form1.submit();
}


function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("nivel").value=trozos[1];
	document.getElementById("alias").value=trozos[2];
	document.getElementById("pag").value=trozos[3];
	document.getElementById("des").value=trozos[8];
	document.getElementById("padre").value=trozos[5];
	document.form1.ocu_N.value=trozos[0];
}
function ver()
{
 document.form1.submit();
}

function posicion()
{
document.getElementById('cedula').focus();
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

function volver()
{
   //alert(document.getElementById("cedula").value);
   if(document.getElementById("cedula").value!='')
	{
		document.getElementById("ingreso").value=1;
		document.form1.submit();
	}
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



</script>
<body>
<form name="form1" method="post" action="permiso.php">
<input name="ingreso" id="ingreso" type="hidden" value="0" />
<?php  
if($_POST['ingreso']==1)
 {
    $usua= new usuario($_POST["cedula"],'','','','','','','');
	$reg=$usua->buscar_usuario_perm();
	if($reg)
	{
	   $usuario=explode('**',$reg);
	   if($usuario[5]=='A')
	   { ?>
	   	  <table width="436" border="0" align="center" class="texto" >
		<tr class="titulofor">
		  <td height="30" colspan="2"><div align="center" class="titulofor">Permisos de Usuario </div></td>
		</tr>
		<tr>
		  <td width="222" height="20"><div align="center" class="textoN">
		    <div align="center">Cedula</div>
		  </div></td>
		  <td width="204" height="20" ><?php  echo $usuario[0]; ?>
	      <input name="cedula" id="cedula" type="hidden" value="<?php  echo $usuario[0]; ?>"></td>
		</tr>
		<tr>
		  <td height="20"><div align="center" class="textoN">
		    <div align="center">Nombre</div>
		  </div></td>
		  <td height="20" ><?php  echo $usuario[1].' '.$usuario[2].' '.$usuario[3].' '.$usuario[4]; ?>
	      <div align="left"></div> </td>
		</tr>
<?php 
			$men= new menu_perm('','','','','','','','');
			$ver=$men->ver_menu_perm($usuario[0]);
			if ($ver==false)
			{
			   
			} 
			else
			{ ?>
				<tr><td colspan="2">
				<?php  echo $ver; ?>
				</td></tr>
		<?php   }
	   }
	   else
	   {
	      echo "<script>alert('El usuario se encuentra inactivo');document.form1.submit();</script>";
	   }
	}
	else
	   echo "<script>alert('Usuario NO registrado');document.form1.submit();</script>"; ?>
	<tr><td colspan="2" align="center">
	<img src="imagenes/p_guardar1.gif" width="140" height="50" style="cursor:hand" onclick="Guardar();" 
		onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
<img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="Salir()" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>
			</td></tr>
	</table>
<?php 
 }
 else
 {
	 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
	  {  
			?> <input name="cedula" id="cedula" type="hidden" value="<?php  echo $_POST["cedula"]; ?>"> <?php 
			$permi= new permisologia('', '', $_POST["cedula"], '', '', '', '', '');
			$elimi=$permi->eli_permisos();
			if($elimi)
			{
				$auxgua=true;
				for($i=1;$i<=$_POST["ftot"];$i++)
				{
					  $cr=0; $mo=0; $el=0; $co=0; $im=0;
					  if($_POST[$i."**C"] || $_POST[$i."**M"] || $_POST[$i."**E"] || $_POST[$i."**V"] || $_POST[$i."**I"])
					  {
						  $idmen=$_POST["o".$i];
						  if($_POST[$i."**C"]) $cr=1;
						  if($_POST[$i."**M"]) $mo=1;
						  if($_POST[$i."**E"]) $el=1;
						  if($_POST[$i."**V"]) $co=1;
						  if($_POST[$i."**I"]) $im=1;
						  $permi= new permisologia('', $idmen, $_POST["cedula"], $cr, $mo, $el, $co, $im);
						  $gua=$permi->ins_permiso();
						  if ($gua==false)
							  $auxgua=false;
					  }
				}
				if ($auxgua==false)		
					echo '<script>alert("Ocurrio un error al guardar los permisos");</script>';
				else
					echo '<script>alert("Permisos Guardados Exitosamente");volver();</script>';
			} else
					echo '<script>alert("Ocurrio un error al guardar los permisos");</script>';
	  }
	 ?>
	  <table width="436" border="0" align="center" >
		<tr class="titulofor">
		  <td height="30" colspan="3"><div align="center" class="titulofor">Permisos de Usuario </div></td>
		</tr>
		<tr >
		  <td width="136" class="etiqueta" >C&eacute;dula de Identidad:</td>
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
			</div></td>
		</tr>
	  </table>

<?php  }?>

<input name="ocu_g" id="ocu_g" type="hidden" value="0"/>
</form>
</body>
</html>