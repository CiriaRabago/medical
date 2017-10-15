<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php";
include "clases/clase_examen.php";
include "clases/clase_perexa.php";
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
function ver()
{
 document.form1.submit();
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
	document.getElementById("perfil").value='0';
	document.getElementById("exame").value='0';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  
	if (document.getElementById("perfil").value!='0' && document.getElementById("exame").value!='0' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("perfil").value!='' && document.getElementById("exame").value!='' && document.form1.ocu_N.value!=0)
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("perfil").value=='0' || document.getElementById("exame").value=='0')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");	
	document.getElementById("perfil").value=trozos[3];
	document.getElementById("exame").value=trozos[4];
	document.getElementById("orden").value=trozos[5];
	document.form1.ocu_N.value=trozos[0].toString();
	
}
</script>
<body>
<form id="form1" name="form1" method="post" action="perexa.php">
<?php
 
if ($_POST["perfil"]>'0')
		$val=$_POST["perfil"]; 
  else
		$val='0';
 $pex= new perexa($_POST["ocu_N"],$_POST["perfil"],$_POST["exame"],$_POST["orden"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$pex->buscar();
	if ($bus=='true')
	 {
	  if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	   {
		$gua=$pex->modf_perexa();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	    }
	}	
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		$gua=$pex->ins_perexa();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	
  }
   if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{			$gua=$pex->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
 ?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Examenes por Perfil</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Perfil:</td>
      <td colspan="3" class="texto Estilo2"><label>
         <?php $perf=new perfil('','','','');
	        $listaperf=$perf->combo_perfil(); ?>

          <select name="perfil" class="texto" id="perfil" onchange="ver();" >
			<option value="0">Seleccione---&gt;</option>
			<?php if ($listaperf!=false) echo $listaperf;?>
			
          </select>
		   <script> document.getElementById("perfil").value="<?php echo $val; ?>"; </script>
          <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Examen:</td>
      <td colspan="3"><label>      
	  <select name="exame" class="texto" id="exame">
		<option value="0">Seleccione---&gt;</option>
		<?php 
				$exa=new examen('','','','','','','','','');
	    $listaexa=$exa->combo_examen_perf('');
		if ($listaexa!=false) echo $listaexa;?>
      </select>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Orden de examen:</td>
      <td colspan="3"><label> 
      <input name="orden" id="orden" type="text" value="0" class="texto"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">
      		<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>

      <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/>    

	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
	  </td>
    </tr>
  </table>
 <?php 
   $ver=$pex->ver_perexa($val);
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Examenes por Perfil');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?>
</form>
</body>
</html>
