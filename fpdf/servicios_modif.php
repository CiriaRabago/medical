<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
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


function Guardar()
{  
	 if ((document.getElementById("nomb").value!='') && (document.getElementById("pre").value!='') && document.getElementById("agenda").value!=''&& document.getElementById("vigilancia").value!='')
	{	
		if (document.form1.ocu_N.value==0)
		{
			document.form1.ocu_g.value=1;
   			document.form1.submit();
		}
		if (document.form1.ocu_N.value!=0)
		{
    		document.form1.ocu_g.value=2;
   			document.form1.submit();
		}
    }
	else
		alert("Falta ingresar Datos");
}



function marcaprod(elem)
{
	if (document.getElementById(elem).disabled==false)
	{	document.getElementById(elem).disabled==true; }
	else
	{	document.getElementById(elem).disabled==false; }
}

function elimproducto(pa)
{
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
			document.form1.ocu_e.value=1;
			document.form1.ocu_prodeli.value=pa;
   			document.form1.submit();
		}


}

</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="servicios_modif.php">
<input name="codauxser" id="codauxser" type="hidden" value="0" />

<?php  
$codser=$_POST["codauxser"];
$codacc=$_POST["codaccion"];
?>
<input name="codauxser" id="codauxser" type="hidden" value="<?php  echo $codser; ?>" />
<input name="codaccion" id="codaccion" type="hidden" value="<?php  echo $codacc; ?>" />
<?php 
// Guardar servicio modificado
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
		$ser= new servicio($_POST["ocu_C"],$_POST["nomb"],$_POST["descrip"],'A',$_POST["agenda"],$_POST["vigilancia"],'NULL',$_POST["pre"]);
		$gua=$ser->modf_servicio();
		if ($gua!=false)
		{
			$gprods=true;
			for($i=0;$i<$_POST['cantiocu2'];$i++)
			{
			   if($_POST['nocodcarch'.$i])
			   { 
				  //$ser->cod=$gua;
				  $agregprod=$ser->ins_prod($_POST['nocodcar'.$i],$_POST['noorden'.$i]);
				  if($gprods==true && $agregprod==false) $gprods=false;
			   }
			}
			$mprods=true;
			for($i=0;$i<$_POST['cantiocu'];$i++)
			{
			   if($_POST['codcarch'.$i])
			   { 
				  //$ser->cod=$gua;
				  $modifprod=$ser->mod_prod($_POST['codcar'.$i],$_POST['orden'.$i]);
				  if($mprods==true && $modifprod==false) $mprods=false;
			   }
			}
			
		    if($gprods==true && $mprods==true)
			  echo '<script>alert("Registro Guardado Exitosamente");</script>';
			else
			  echo '<script>alert("Ocurrio un error al guardar servicios asociados");</script>';
		}
		else
			echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	  
	  echo '<script>document.form1.action="servicios_lista.php";document.form1.submit();</script>';
  }
// Eliminar productos asociados al servicio
  
   if(isset($_POST["ocu_e"]) && $_POST["ocu_e"]!='0' )
  { 
		$ser= new servicio($_POST["ocu_C"],$_POST["nomb"],$_POST["descrip"],'A',$_POST["agenda"],'NULL',$_POST["pre"]);
		$elimprod=$ser->eli_prod($_POST['ocu_prodeli']);
	    if($elimprod!=false)
			  echo '<script>alert("Registro eliminado exitosamente");</script>';
			else
			  echo '<script>alert("Ocurrio un error al eliminar el Servicio Asociado");</script>';
	  echo '<script>document.form1.submit();</script>';
  }

  
  else 
  {
	   $ser= new servicio($codser,'','','','','','',0);
	   if($codacc=='M') // Mostrar actual
	   { 
	      $datosser=$ser->ver_serv();
	   }
	   if ($codacc=='E') // Eliminar todo
	   {
	   
	   }
  }

 ?>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="titulofor">
      <td height="30" colspan="6"><div align="center" class="titulofor">Servicios</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto Estilo2" z><label>
	  <input name="ocu_C" id="ocu_C" type="hidden" value="<?php  if($codacc=='M') echo $datosser[0]; ?>" />
        <input name="nomb" type="text" class="texto" id="nomb" value="<?php  if($codacc=='M') echo $datosser[1]; ?>" size="50" onkeypress='return sincomillas(event)' />
        <span class="Estilo3" >*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td colspan="3"><label>
        <input name="descrip" type="text" class="texto" id="descrip" value="<?php  if($codacc=='M') echo $datosser[2]; ?>" size="50" onkeypress='return sincomillas(event)'/>
		<input name="ocu_N" type="hidden" value="0" /> 
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Precio:</td>
      <td colspan="3"><label class="texto">
          <input name="pre" type="text" class="texto" id="pre" value="<?php  if($codacc=='M') echo $datosser[3]; ?>" />      
        <span class="Estilo3">* </span>      
      <input name="ocu_pre" type="hidden" id="ocu_pre" value="0" />
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Posee Agenda:</td>
      <td colspan="3"><span class="texto">
        <select name="agenda" class="texto" id="agenda">
          <option value="">Seleccione---&gt;</option>
          <option value="S" <?php  if($codacc=='M' && $datosser[4]=='S') echo 'selected'; ?>>Si</option>
          <option value="N" <?php  if($codacc=='M' && $datosser[4]=='N') echo 'selected'; ?>>No</option>
        </select>
        <span class="Estilo3">*</span></span></td>
    </tr>
    <tr>
      <td class="etiqueta">Reporte Vigilancia:</td>
      <td colspan="3"><span class="texto">
        <select name="vigilancia" class="texto" id="vigilancia">
          <option value="">Seleccione---&gt;</option>
          <option value="S" <?php  if($codacc=='M' && $datosser[5]=='S') echo 'selected'; ?>>Si</option>
          <option value="N" <?php  if($codacc=='M' && $datosser[5]=='N') echo 'selected'; ?>>No</option>
        </select>
        <span class="Estilo3">*</span></span></td>
    </tr>
	
    <tr>
      <td colspan="4"><div align="center"><img src="imagenes/p_guardar1.gif" width="140" height="50" style="cursor:hand" onclick="Guardar();" 
		onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>            <input name="ocu_g" type="hidden" value="0"/> 
          <input type="hidden" name="ocu_e" id="ocu_e" value="0"/>   
		  <input type="hidden" name="ocu_prodeli" id="ocu_prodeli" value="0"/>     
      <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='servicios_lista.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    <?php 	  		
	$serviprod=$ser->consul_prod_serv(); 
	$n=mysql_num_rows($serviprod); 
	if($n>0)
	{ ?>
	</tr>
		<tr class="titulofor" > <!-- onclick="mostrarprod()" -->
      <td height="30" colspan="4"><div align="center" class="titulofor">Servicios Asociados</div></td>
    </tr>
	 <tr>
      <td colspan="4"><div id="prod" style="display:block">
		<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr class="titulorep" align="center">
			<td width="20">&nbsp;</td>
			<td width="380"><div align="left">Servicios </div></td>
			<td width="100">Precio </td>
			<td>Orden </td>
			</tr>	
			
			<?php 	  		
			$indi=0;
			?>
			<input name="cantiocu" id="cantiocu" type="hidden" value="<?php  echo $n;?>" />
			<?php 
			while ($row=mysql_fetch_array($serviprod))
			{ 
			  $codigo='codcar'.$indi;
			  $codigoch='codcarch'.$indi;
			  $orden='orden'.$indi;
			  
			  if ($indi%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			?>
			  <tr class="texto" <?php  echo $color; ?>  >
				<td width="20">
				<input name="<?php  echo $codigo;?>" id="<?php  echo $codigo;?>" type="hidden" value="<?php  echo $row[4]; ?>" />
				<input name="<?php  echo $codigoch;?>" id="<?php  echo $codigoch;?>"  type="checkbox" value="<?php  echo $row[4]; ?>" 
				             onclick="document.form1.<?php  echo $orden; ?>.disabled=!document.form1.<?php  echo $orden; ?>.disabled" /></td>
				<td><?php  echo $row[0]; ?></td>
				<td> <div align="right"><?php  echo $row[1]; ?></div></td>
				<td>
			      <div align="right">
			        <input class="texto" name="<?php  echo $orden; ?>" id="<?php  echo $orden; ?>" type="text" value="<?php  echo $row[2]; ?>" size="5" disabled />
			        <img src="imagenes/delete.gif" style="cursor:hand" alt="Eliminar Servicio Asociado" title="Eliminar Servicio Asociado" onclick="elimproducto('<?php  echo $row[4]; ?>');" />
		          </div></td></tr>
			<?php  
			$indi++; 
			 }  ?>
			</table>
	     
		 </div>
	  </td>
	 </tr>
    <?php  } ?>
	<tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Servicios Por Asociar</div></td>
    </tr>
	 <tr>
      <td colspan="4"><div id="prod" style="display:block">
		<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr class="titulorep" align="center">
			<td width="20">&nbsp;</td>
			<td width="380"><div align="left">Servicios </div></td>
			<td width="100">Precio </td>
			<td>Orden </td>
			</tr>	
			
		<?php 	  		
		$serviprod2=$ser->consul_prod_serv_no(); 
		$n2=mysql_num_rows($serviprod2);
		$indi2=0;
		?>
		<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php  echo $n2;?>" />
		<?php 
		while ($row2=mysql_fetch_array($serviprod2))
		{ 
		  $nocodigo='nocodcar'.$indi2;
		  $nocodigoch='nocodcarch'.$indi2;
		  $noorden='noorden'.$indi2;
		  
		  if ($indi2%2!=0) $color2='bgcolor="#E3E3E6"'; else $color2='';
		?>
		  <tr class="texto" <?php  echo $color2; ?>  >
			<td width="20">
			<input name="<?php  echo $nocodigo;?>" id="<?php  echo $nocodigo;?>" type="hidden" value="<?php  echo $row2[2]; ?>" />
			<input name="<?php  echo $nocodigoch;?>" id="<?php  echo $nocodigoch;?>"  type="checkbox" value="<?php  echo $row2[2]; ?>" 
			onclick="document.form1.<?php  echo $noorden; ?>.disabled=!document.form1.<?php  echo $noorden; ?>.disabled" /></td>
			<td><?php  echo $row2[0]; ?></td>
			<td> <div align="right"><?php  echo $row2[1]; ?></div></td>
			<td>
			    <div align="right">
			      <input class="texto" name="<?php  echo $noorden; ?>" id="<?php  echo $noorden; ?>" type="text" value="0" size="5" disabled />
		        &nbsp;&nbsp;&nbsp;</div></td></tr>
		<?php  
		$indi2++; 
		 }  ?>
		</table>
	     
	   </div>
	  </td>
	 </tr>
  </table>

</form>
</body>
</html>
