<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php";
include "clases/clase_examen.php";
include "clases/clase_perexa.php";
include "clases/clase_espec.php";
include "clases/clase_medico.php";
include "clases/clase_cupos_cita.php";
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
{  if (document.getElementById("espe").value!='0' && document.getElementById("exame").value!='0' && document.getElementById("cantida").value!='0')
	{	
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
			document.form1.ocu_e.value=1;
   			document.form1.submit();
		}
	}
	else
	  {	
		alert("Para Eliminar, Debe Seleccionar un registro de la lista");
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
	if (document.getElementById("espe").value!='0' && document.getElementById("exame").value!='0' && document.getElementById("cantida").value!='0' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("espe").value!='' && document.getElementById("exame").value!='' && document.form1.ocu_N.value!=0)
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("espe").value=='0' || document.getElementById("exame").value=='0' || document.getElementById("cantida").value=='0')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("espe").value=trozos[3];
	document.getElementById("exame").value=trozos[4];
	document.getElementById("labor").value=trozos[5];
	document.form1.ocu_N.value=trozos[0];
	document.form1.submit();
}
</script>
<body>
<form id="form1" name="form1" method="post" action="cupos_especialidad.php">
<?php
 
if ($_POST["espe"]>'0')
		$val=$_POST["espe"]; 
  else
		$val='0';
 $lab='';
 echo $lu;		
 if(isset($_POST['lu'])) $lab.='1'; else $lab.='0'; 
 if(isset($_POST['ma'])) $lab.='1'; else $lab.='0';
 if(isset($_POST['mi'])) $lab.='1'; else $lab.='0';  		
 if(isset($_POST['ju'])) $lab.='1'; else $lab.='0';
 if(isset($_POST['vi'])) $lab.='1'; else $lab.='0';
 if(isset($_POST['sa'])) $lab.='1'; else $lab.='0';
 if(isset($_POST['do'])) $lab.='1'; else $lab.='0';
 $cup= new cupos('',$_POST["espe"],$_POST["exame"],$_POST["cantida"],'','',$lab);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	$bus=$cup->ver_cantidad();	
	if ($bus!=false)
	{   
		$gua=$cup->mod_cupos();
		if ($gua)
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if ($bus==false)
	{   
		$gua=$cup->ins_cupo();
		if ($gua)
			echo '<script>alert("Registro Guardado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
	
  }
   if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{			$gua=$cup->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
 ?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Cupos de Citas por Especialidad</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Especialidad:</td>
      <td colspan="3" class="texto Estilo2"><label>
         <?php $esp=new especialidad($_POST['espe'],'');
	        $listaperf=$esp->combo_esp(); ?>

          <select name="espe" class="texto" id="espe" onchange="ver();" >
			<option value="0">Seleccione---&gt;</option>
			<?php if ($listaperf!=false) echo $listaperf;?>
			
          </select>
		   <script> document.getElementById("perfil").value="<?php echo $val; ?>"; </script>
          <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Doctor:</td>
      <td colspan="3"><label>      
	  <select name="exame" class="texto"  id="exame" onchange="ver();">
		<option value="0">Seleccione---&gt;</option>
		<?php 
				$exa=new medico('','','','','','','','','','','','','','','');
	    $listaexa=$exa->combo_medico_new($_POST['espe'],$_POST['exame']);
		if ($listaexa!=false) echo $listaexa;?>
      </select>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Cantidad de pacientes por dia:</td>
      <td colspan="3"><label>      	  
		<?php 
		$cup=new cupos('',$_POST['espe'],$_POST['exame'],'','','');
	    $cantid=$cup->ver_cantidad();
		if ($cantid!=false)  
		 { $dat=explode('**',$cantid); 
		   $totcan=$dat[3];
		   $labor=$dat[6];}
		else $totcan=0;?>      
      <input name="cantida" id="cantida" type="text" value="<?php echo $totcan;?>" class="texto"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td width="139" colspan="4" class="etiqueta">Dias que Labora:</td>      
    </tr>
	<tr>
	<td>&nbsp;</td>
	<td colspan="3">	
	 <table>
	  <tr>
      <td class="etiqueta">Lunes</td>      
	  <td class="etiqueta">Martes</td>      
	  <td class="etiqueta">Miercoles</td>      
	  <td class="etiqueta">Jueves</td>      
	  <td class="etiqueta">Viernes</td>      
	  <td class="etiqueta">Sabado</td>      
	  <td class="etiqueta">Domingo</td>      
	 </tr>
	 <tr>	 
	  <input type="hidden" id="labor" name="labor" value="<?=$labor;?>"  />
      <td class="etiqueta" align="center"><input type="checkbox" name="lu" <?php if(substr($labor,0,1)=='1') echo 'checked="checked"';?> /></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="ma" <?php if(substr($labor,1,1)=='1') echo 'checked="checked"';?>/></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="mi" <?php if(substr($labor,2,1)=='1') echo 'checked="checked"';?>/></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="ju" <?php if(substr($labor,3,1)=='1') echo 'checked="checked"';?>/></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="vi" <?php if(substr($labor,4,1)=='1') echo 'checked="checked"';?>/></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="sa" <?php if(substr($labor,5,1)=='1') echo 'checked="checked"';?>/></td>      
	  <td class="etiqueta" align="center"><input type="checkbox" name="do" <?php if(substr($labor,6,1)=='1') echo 'checked="checked"';?>/></td>      
	 </tr>
	 </table>
	 </td>
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


<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver </a>

      <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/> 
      </td>
    </tr>
  </table>
 <?php 
   $ver=$cup->ver_cupos($val);
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
