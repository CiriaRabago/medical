<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_empresa_pres.php";
include "clases/clase_presupuesto.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
function cal_iva(){
	var c_iva=document.getElementById("iva").value;
	var b_im=document.getElementById("b_imp").value;
	var iva_t = parseFloat(b_im)*0.12;
	var redondeo_iva_t=parseFloat(iva_t)*parseFloat(c_iva)/100;

	document.getElementById("t_IVA").value=Math.round(redondeo_iva_t * Math.pow(10, 2)) / Math.pow(10, 2);//redondeo decimales
}
function total_monto(){
	var t_ISR=document.getElementById("t_ISR").value;
	var monto=document.getElementById("monto").value;
	var t_iva=document.getElementById("t_IVA").value;
	var total_retenciones=(parseFloat(t_ISR)+parseFloat(t_iva));
	var total_monto=parseFloat(monto)-parseFloat(total_retenciones);
	document.getElementById("t_monto").value=Math.round(total_monto * Math.pow(10, 2)) / Math.pow(10, 2);
	

}
function posicion()
{
document.getElementById('cedula').focus();
}
function mos_pres()
{
document.form1.submit();
}

function caracter(a)
{
	var textonom=document.getElementById("des").value;
	if (a==0)
	document.getElementById('caract').innerHTML=textonom.length+1+' caracteres';
	else
	document.getElementById('caract').innerHTML=textonom.length+' caracteres';
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
{	if (document.getElementById("c_prov").value!='' && document.getElementById("monto").value!='' && document.getElementById("des").value!='') {
	
		var monto_real= parseFloat(document.getElementById("monto").value)
		document.getElementById("monto_r").value=monto_real;
		document.getElementById("ingreso").value=1;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		//alert('fin');
		document.form1.submit();
	
} else alert('Todos los campos con * deben ser correctamente llenados');
}

function ir_orden_pac(val)
{
  if(val=='S')
  {
		   document.form1.action="orden_pac.php";
		   document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
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

function irpdf(pag)
{
	document.form1.action=pag;
	document.form1.submit();
}

function ing_iva()
{	


	var cadena2 = document.getElementById("comemp").value
	var trozos = cadena2.split("*");
	document.getElementById("c_prov").value=trozos[0];
	document.getElementById("iva").value=trozos[1];
	document.getElementById("n_empre").value=trozos[2];
}
</script>
<body>
<?php  if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'reg_presupuesto.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   ////////////////////////////////////////////////////////// 
   
 }
 ?>
<form name="form1" id="form1" method="post" action="">
<input name="ingreso" id="ingreso" type="hidden" value="0" />

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
 	if($_POST['ingreso']==1)
 	{$ver_id='';
/*
echo 'f_ini '.$_POST['fecha_p_i'].' f_f: '.$_POST['fecha_p_f'].' monto: '.$_POST['monto'].' x_canc: '.$_POST['t_monto'].'pro: '.$_POST['c_prov'].' iva: '.$_POST['t_IVA'].' islr: '.$_POST['t_ISR'].' usuario: '.$_SESSION['cedu_usu'].' des: '.$_POST['des'].'estatus A, null numero de factura, base impo: '.$_POST['b_imp'];
exit();
*/
 	$pres= new presup('',$_POST['fecha_p_i'],$_POST['fecha_p_f'],$_POST['monto'],$_POST['t_monto'],$_POST['c_prov'],$_POST['t_IVA'],$_POST['t_ISR'],$_SESSION['cedu_usu'],'',$_POST['des'],'A','',$_POST['b_imp']);
 	$gua_pre=$pres->ins_presup();
			if ($gua_pre){
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
				
			}
			else 
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	  

	}
	if($_POST['ingreso']==2)//buscar o modificar
 	{echo 'dentro';

	}
$emp= new empresa_pres('','','','','','','','','','');
 /////////////////////////////////////////////////////////////////////////////
	$pres= new presup();
 	$ver_id=$pres->ver_max_id_presup();
			if ($ver_id){
				$ver_id=$ver_id+1;//saber cual es el numero de presupuesto que le corresponde
			}
 ?>
	   		<table width="520" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="3"><div align="center" class="titulofor">Presupuesto N: <?php echo $ver_id?> </div></td>
			</tr>
			<tr class="texto">
			<td height="30" colspan="5">
			<table width="520" border="0" cellpadding="0" cellspacing="0">
			<tr class="textoN">
			<td width="160" height="22">Proveedor:</td>
			<td class="texto" colspan="3" ><select name="comemp" class="texto" id="comemp" onchange="ing_iva();">
			<?php   
			if ($emp->combo_emp_pres()!= false)
			echo $emp->combo_emp_pres(); ?>
			</select><script> document.getElementById("comemp").value="<?php  echo $_POST["c_prov"];?>"; </script>
			<span class="Estilo1"> &nbsp;* </span></td>
			</tr>
			<tr>
				<td colspan="5"><div id="div_edit" ></div></td>
			</tr>
			<tr class="textoN">
			<td width="160" height="22">Fecha Inicio</td>
			<td width="160" height="22">Fecha Fin</td>
			<td width="160" height="22">Monto Factura</td>
			</tr>
			<tr>
			<td><input name="fecha_p_i" type="date" class="texto" id="fecha_p_i" size="15" /></td>	
			<td><input name="fecha_p_f" type="date" class="texto" id="fecha_p_f" size="15" /></td>	
			<td><input name="monto" type="text" class="texto" id="monto" size="15" /><span class="Estilo1"> &nbsp;* </span></td>
			<input name="monto_r" type="hidden" class="texto" id="monto_r" size="15" />
			</tr>
			<tr class="textoN">
			<td width="160" height="35">B. Imponible <input name="b_imp" type="text" class="texto" id="b_imp" size="5" onblur="cal_iva();"/></td>
			<td width="160" height="35">% Ret. IVA: <input name="iva" type="text" class="texto" id="iva" size="5" readonly="readonly" /></td>
			<td>T. Ret. IVA: <input name="t_IVA" type="text" class="texto" id="t_IVA" size="10" /> Bs</td>
			</tr>
			<tr class="textoN">
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">T. Ret. ISR: <input name="t_ISR" type="text" class="texto" id="t_ISR" size="10" onblur="total_monto();" /> Bs</td>
			</tr>
			<tr class="textoN">
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">T. Cancelar: <input name="t_monto" type="text" class="texto" id="t_monto" size="10" /> Bs</td>
			</tr>
			<tr>
			<td width="160" height="22" class="textoN">Descripci&oacute;n:</td>
			</tr>
			<tr>
			<td width="73" colspan="3" class="texto"><label>
			<textarea name="des" cols="80" rows="3" class="texto" id="des" onkeypress="caracter(0);"></textarea>
			<span class="Estilo1"> &nbsp;* </span>
			<div id="caract">0 caracteres.</div>
      		<span class="textoN" height="22">M&aacute;x 150 ctrs.</span></td>
			</tr>

				  <input name="empresa" type="hidden"  id="empresa" value="" />
				  <input name="servicio" type="hidden"  id="servicio" value="" />
				  <input name="medico" type="hidden"  id="medico" value="" />
				  <input name="estado" type="hidden"  id="estado" value="" />
				  <input name="c_prov" type="hidden" class="texto" id="c_prov" size="5" />

                   
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			
			<tr>
			  <td colspan="5"><div id="cargar" align="center">
				<img src="imagenes/p_guardar1.gif" alt="Guardar" 
				width="140" height="50" style="cursor:hand" onclick="validar()" 
				onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/></div>
				<input name="orden" id="orden" type="hidden" value="0" /></td>
			</tr>
		  </table>
		
</form>
</body>
</html>
