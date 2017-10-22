<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
include "clases/clase_medico.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_presupuesto.php";
include "clases/clase_empresa_pres.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
  if (document.getElementById('ch_p').checked==true)
  {
   
    document.getElementById('ch_p2').value=1;
  }
  if (document.getElementById('ch_m').checked==true)
  {
    document.getElementById('ch_m2').value=1;
  }
   if (document.getElementById('ch_c').checked==true)
  {
    document.getElementById('ch_c2').value=1;
  }
   if (document.getElementById('ch_v').checked==true)
  {
    document.getElementById('ch_v2').value=1;
  }
  document.getElementById("ingreso").value=1;
  document.form1.submit();
	/*
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		
    */
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

function irpdf(pag)
{
	document.form1.action=pag;
	document.form1.submit();
}
function ver_modif($pag)
{
  //alert('erteg'+$pag);
 window.open($pag);
}


</script>
<body>
<?php  if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'listado_pac.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   ////////////////////////////////////////////////////////// 
 }
 ?>
<form name="form1" id="form1" method="post" action="listado_presupuestos.php">
<input name="ingreso" id="ingreso" type="hidden" value="0" />
<input name="nser" id="nser" type="hidden" value="" />
<input name="nemp" id="nemp" type="hidden" value="" />
<input name="nmed" id="nmed" type="hidden" value="" />
<input name="nsta" id="nsta" type="hidden" value="" />
<?php  /////////////////////////Mostrar u ocultar Botones///////////////////////////
  $ope1='style="display:none"'; 
  $ope4='style="display:none"';
  $ope5='style="display:none"';
  $ope2='style="display:none"';

   if ($_POST["busper"]!='FALSE')
  { 
    	$vecper=explode('**',$_POST["busper"]); 
  
		/*if ($vecper[0]=='1')//puede guardar
		{
			$ope1='';
			$pgu='1';
		}*/
		if ($vecper[1]=='1') //puede consultar
		{
			$ope2='';
		}
		if ($vecper[2]=='1')//puede modificar
		{
			$ope1='';
			$pmo='1';
		}
		if ($vecper[3]=='1')// puede eliminar
			$ope4='';
			
		if ($vecper[4]=='1')//puede listar
		{	
			$ope5='';
		}	
	
  }

 /////////////////////////////////////////////////////////////////////////////
 ?>
	   	<table width="500" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="4"><div align="center" class="titulofor">Listado de Presupuestos </div></td>
			</tr>
      <tr class="textoN">
      <td width="160" height="22" colspan="2"> Proveedor: 
      <select name="comemp" class="texto" id="comemp">
      <option value="0" selected="selected" >SELECCIONE --></option>
      <?php   $emp= new empresa_pres('','','','','','','','','','');
      $cemp=$emp->combo_emp_pres2($_POST['comemp']);
            if($cemp!=false) echo $cemp;
      
    ?>
      </select></td>      
      <td width="160" colspan="2"> Estatus: 
      <select name="estado" class="texto" id="estado" height="22">
      <option value="" selected="selected" >SELECCIONE --></option>
      <option value="A"  <?php  if($_POST['estado']=="A" ) echo "selected='selected'";?>>Activo</option>
      <option value="F" <?php  if($_POST['estado']=="F") echo "selected='selected'";?>>Finalizado</option>
      <option value="J" <?php  if($_POST['estado']=="J") echo "selected='selected'";?>>Ejecutado</option>
      <option value="F" <?php  if($_POST['estado']=="X") echo "selected='selected'";?>>X Ejecutar</option>
      <option value="V" <?php  if($_POST['estado']=="V") echo "selected='selected'";?>>Vencido</option>
      <option value="E" <?php  if($_POST['estado']=="E") echo "selected='selected'";?>>Eliminado</option>
      </select></td>
      </tr>
      <tr class="textoN">
        <td width="160" colspan="4" height="22" > FECHA DE CREACI&Oacute;N:        
        </td>
        </tr>
        <tr class="textoN">
        <td height="22" colspan="2"> Desde: <input type="date" name="c_desde" id="c_desde" value="<?php echo $_POST['c_desde']?>">
        </td>
        <td height="22" colspan="2"> Hasta: <input type="date" name="c_hasta" id="c_hast" value="<?php echo $_POST['c_hasta']?>">
        </td>
      </tr>
       <tr class="textoN">
        <td width="160" colspan="4" height="22" > FECHA DE VENCIMIENTO:        
        </td>
        </tr>
        <tr class="textoN">
        <td height="22" colspan="2"> Desde: <input type="date" name="v_desde" id="c_desde" value="<?php echo $_POST['v_desde']?>">
        </td>
        <td height="22" colspan="2"> Hasta: <input type="date" name="v_hasta" id="c_hast" value="<?php echo $_POST['v_hasta']?>">
        </td>
      </tr>
       <tr class="textoN">
        <td width="160" colspan="4" height="22" > ORDEN DE BUSQUEDA: debe seleccionar una sola opci&oacute;n     
        </td>
        </tr>
          <tr class="textoN">
        <td width="160" colspan="4" height="22" align="center">
        Proveedor<input type="checkbox" name="ch_p" id="ch_p" <?php if ($_POST['ch_p2']!='') 
        { echo "checked='checked'"; } ?>> <input type="hidden" name="ch_p2" id="ch_p2" value=''>
        Monto<input type="checkbox" name="ch_m" id="ch_m" <?php if ($_POST['ch_m2']!='')
         { echo "checked='checked'"; } ?>> <input type="hidden" name="ch_m2" id="ch_m2" value=''>
        Creaci&oacute;n<input type="checkbox" name="ch_c" id="ch_c" <?php if ($_POST['ch_c2']!='')
         { echo "checked='checked'"; } ?>> <input type="hidden" name="ch_c2" id="ch_c2" value=''>
        Vencimiento<input type="checkbox" name="ch_v" id="ch_v"<?php if ($_POST['ch_v2']!='')
         { echo "checked='checked'"; } ?>> <input type="hidden" name="ch_v2" id="ch_v2" value=''>
        </td>
        </tr>
          <tr>
        <td colspan="5" class="td-btn"><div id="cargar" align="center">
        <a href="#" onclick="validar();" class="button-search" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a></div>
        <input name="orden" id="orden" type="hidden" value="0" /></td>
      </tr>
      
		<?php    

	if($_POST['elimvis']!=0)
 	{
	  $vis= new visita($_POST['elimvis'],'','','','','','','','','','','','');
	  if($vis->mod_sta_visita_uni("E"))
	  	echo '<script>alert("Visita Eliminada con Exito")</script>';
	  else
	  	echo '<script>alert("Ocurrio un Error al Eliminar la Visita")</script>';
	}

	
	if($_POST['ingreso']==1)
 	{   
      $pres= new presup();
    	$ver_pres=$pres->ver_listado_presup($_POST['comemp'],$_POST['estado'],$_POST['c_desde'],$_POST['c_hasta'],$_POST['v_desde'],$_POST['v_hasta'],$_POST['ch_p2'],$_POST['ch_m2'],$_POST['ch_c2'],$_POST['ch_v2']);
   		$cont=0;
		if($ver_pres!=false)
		{
      echo $ver_pres;
		}
		else
		{ echo '<br><p class="textoN" align="center">No se encontró ninguna coincidencia</p>'; }
	
//echo 'estoy en la busqueda '.$_POST['comemp'].'estado '.$_POST['estado'].'f_c_d '.$_POST['c_desde'].'f_c_h '.$_POST['c_hasta'].'fv_d '.$_POST['v_desde'].'fv_h'.$_POST['v_hasta'];
} ?>
<?php if($_POST['ingreso']==1)
  {?>
<tr>
<td class="td-btn"><div align="center">
<a href="#" class="button-print" alt="Imprimir"   onclick="irpdf('listado_presupuestos_pdf.php?comemp=<?php echo $_POST['comemp']?>&amp;estado=<?php echo $_POST['estado']?>&amp;c_desde=<?php echo $_POST['c_desde']?>&amp;c_hasta=<?php echo $_POST['c_hasta']?>&amp;v_desde=<?php echo $_POST['v_desde']?>&amp;v_hasta=<?php echo $_POST['v_hasta']?>')" > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>
</div>
</td>
</tr>
<?php }?>
</table>
</form>
</body>
</html>
