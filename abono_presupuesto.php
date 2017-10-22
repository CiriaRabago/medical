<?php   
session_start();
if ($_SESSION["cedu_usu"]!='') {
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_empresa_pres.php";
include "clases/clase_presupuesto.php";
$id_presupuesto=$_GET['id_p'];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
{	
		document.getElementById("ingreso").value=1;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		//alert('fin');
		document.form1.submit();
	
}
function validar2()
{

	if (document.getElementById("c_prov").value!='' && document.getElementById("monto").value!='' && document.getElementById("des").value!='') {
	
		var monto_real= parseFloat(document.getElementById("monto").value)
		document.getElementById("monto_r").value=monto_real;
		document.getElementById("ingreso").value=4;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		//alert('fin');
		document.form1.submit();
	
} else alert('Todos los campos con * deben ser correctamente llenados');
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
}
function mostrar(a)
{
	
	var c_ab=document.getElementById("c_ab").value;
	var cont=parseInt(c_ab)+1;
	document.getElementById("c_ab").value=cont;
	document.getElementById("div_abono"+cont).innerHTML = "<table width='520' border='0' align='center' ><tr><td><input type='text' name='m_abono"+cont+"' id='m_abono"+cont+"' size='15' onblur='valido_monto("+cont+");''></td><td><input type='date' name='f_abono"+cont+"' size='15'></td><td><input type='text' name='des_abono"+cont+"' size='15'></td></tr></table>";

}
function elimina_abono(id)
{
	
	alert('Eliminando');
	document.getElementById("ingreso").value=2;
	document.getElementById("id_a_eliminar").value=parseFloat(id);
	document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
	document.form1.submit();

}
function eliminar_presu()
{
	
if (window.confirm('Desea eliminar el Presupuesto')) { 

	if (document.getElementById("c_prov").value!='') {
 	document.getElementById("ingreso").value=5;
	document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
	document.form1.submit();
	} else {alert('No hay presupuesto a eliminar');}
}

}
function valido_monto(campo)
{	
	if(parseFloat(document.getElementById("m_abono"+campo).value) > parseFloat(document.getElementById("t_s").value)){
	alert('El monto no puede ser superior al saldo');
	document.getElementById("m_abono"+campo).value=0;
}
else  { total_montoo= parseFloat(document.getElementById("t_s").value)-parseFloat(document.getElementById("m_abono"+campo).value)
		document.getElementById("t_s").value=Math.round(total_montoo * Math.pow(10, 2)) / Math.pow(10, 2);
}
}
function finalizar()
{	

	var i 
   	for (i=0;i<document.form1.n_estado.length;i++){ 
      	if (document.form1.n_estado[i].checked)
         	break; 
        }
        document.getElementById("n_estado2").value=document.form1.n_estado[i].value; 
	
if (document.getElementById("n_factura").value!='' && document.getElementById("n_factura").value!='0' && document.getElementById("n_estado2").value!='' ) {
document.getElementById("ingreso").value=3;

document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
document.form1.submit();
} else {alert('Ingrese N Factura y Estatus');
document.getElementById('n_factura').focus();
}
}
function ejecutar()
{	

	var i 
   	for (i=0;i<document.form1.n_estado.length;i++){ 
      	if (document.form1.n_estado[i].checked)
         	break; 
        }
        document.getElementById("n_estado2").value=document.form1.n_estado[i].value; 
	
if ( document.getElementById("n_estado2").value!='' ) {
document.getElementById("ingreso").value=6;
document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
document.form1.submit();
} else {alert('Ingrese Estatus');
document.getElementById('n_estado').focus();
}
}
</script>
<body>
<?php  if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'listado_presupuestos.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   ////////////////////////////////////////////////////////// 
   
 }
 ?>
<form name="form1" id="form1" method="post" action="">
<input name="ingreso" id="ingreso" type="hidden" value="0" />
<input name="id_a_eliminar" id="id_a_eliminar" type="hidden" value="0" />

<?php  /////////////////////////Mostrar u ocultar Botones///////////////////////////
  $ope1='style="display:none"'; 
  $ope4='style="display:none"';
  $ope5='style="display:none"';
  $ope2='style="display:none"';

  $con_abonos=0;

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
  	if($_POST['ingreso']==4)
 	{
			
 		$pres= new presup($id_presupuesto,$_POST['fecha_p_i'],$_POST['fecha_p_f'],$_POST['monto'],$_POST['t_monto'],'',$_POST['t_IVA'],$_POST['t_ISR'],$_SESSION['cedu_usu'],'',$_POST['des'],'A','',$_POST['b_imp']);
 	$gua_pre=$pres->modificar_pres();
			if ($gua_pre){
				echo '<script>alert("Registro Modificado Exitosamente");</script>';
				
			}
			else 
				echo '<script>alert("El Registro no pudo ser Modificar");</script>';
	  

	}
	if($_POST['ingreso']==5)
 	{
	  $pres= new presup();
	  $eli_pre=$pres->eliminar_presupuesto($id_presupuesto);
		if ($eli_pre) {
 			 echo '<script>alert("Presupuesto Eliminado");</script>';
 			
 		}else echo '<script>alert("El Presupuesto no pudo ser Eliminado");</script>';
 	}
 	if($_POST['ingreso']==1)
 	{
//para modificar abonos
 		if ($_POST['c_a']!='') {
 			for ($j=1; $j <= $_POST['c_a']; $j++) {
			
 			if ($_POST['id_abono_car'.$j]!='' && $_POST['m_abono_car'.$j]!='' && $_POST['f_abono_car'.$j]!=''&& $_POST['des_abono_car'.$j]!=''){
 				if ($_POST['m_abono_car'.$j]!=$_POST['m_abono_car_ocul'.$j] || $_POST['f_abono_car'.$j]!=$_POST['f_abono_car_ocul'.$j] || $_POST['des_abono_car'.$j]!=$_POST['des_abono_car_ocul'.$j]) {
			/*echo 'estoy dentro'.$j.' id_ab '.$_POST['id_abono_car'.$j].' monto '.$_POST['m_abono_car'.$j].' fecha '.$_POST['f_abono_car'.$j].' descr '.$_POST['des_abono_car'.$j];*/
 		$pres= new presup();
		$mod_a=$pres->modificar_abono($_POST['id_abono_car'.$j], $_POST['m_abono_car'.$j], $_POST['f_abono_car'.$j],$_SESSION['cedu_usu'],$_POST['des_abono_car'.$j]);
 		if ($mod_a) {
 			 //echo '<script>alert("Abono GUARDADO");</script>';
 		    }
			} 			
			}
			}
		}
			
 		$n_abonos=$_POST['c_ab'];
 		for ($i=1; $i <= $n_abonos; $i++) {

			if ($id_presupuesto!='' && $_POST['m_abono'.$i]!='' && $_POST['f_abono'.$i]!='' && $_POST['des_abono'.$i]!='') {
				

		$pres= new presup();
		$inser_a=$pres->insertar_a($id_presupuesto,$_POST['m_abono'.$i],$_POST['f_abono'.$i],$_SESSION['cedu_usu'],'A',$_POST['des_abono'.$i]);
 		if ($inser_a) {
 			 echo '<script>alert("Abono GUARDADO");</script>';
 			
 		}else echo '<script>alert("El Abono no pudo ser GUARDADO");</script>';
 		}else echo '<script>alert("No se Guardo.. Debe llenar todos los Campos del Abono");</script>';
	 	}

	}
	
$emp= new empresa_pres('','','','','','','','','','');
 /////////////////////////////////////////////////////////////////////////////

	if($_POST['ingreso']==2)
 	{
 		$pres= new presup();
 		$elimi_a=$pres->elimina_a($_POST['id_a_eliminar']);
	 

	}
		if($_POST['ingreso']==3)
 	{


 		$pres= new presup();
 		$final_p=$pres->finaliza_p($id_presupuesto,$_POST['n_factura'],$_POST['n_estado2']);
 		if ($final_p){
				 echo '<script>alert("El presupuesto cambia a estatus FINALIZADO");</script>';
				}
			else {
				echo '<script>alert("No se pudo Finalizar");</script>';
				}

	}
		if($_POST['ingreso']==6)
 	{
 		$pres= new presup();
 		$final_p=$pres->finaliza_p($id_presupuesto,$_POST['n_factura'],$_POST['n_estado2']);
 		if ($final_p){
				 echo '<script>alert("El presupuesto cambia de Estatus ");</script>';
				}
			else {
				echo '<script>alert("No se pudo Cambiar el Estatus");</script>';
				}
}
	$pres= new presup();
 	$bus_pre=$pres->buscar_presup($id_presupuesto);
			if ($bus_pre){
				$datos=explode('**',$bus_pre);
				}
			else {
				echo '<script>alert("El Registro no pudo ser ENCONTRADO");</script>';
				}

 ?>
	   		<table width="520" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="3"><div align="center" class="titulofor">Presupuesto N: <?php echo $id_presupuesto?> </div></td>
			</tr>
			<tr class="texto">
			<td height="30" colspan="5">
			<table width="520" border="0" cellpadding="0" cellspacing="0">
			<tr class="textoN">
			<td width="160" height="22">Proveedor:</td><input name="c_prov" type="hidden" class="texto" id="c_prov" value="<?php echo $datos[0]?>" />
			<td class="texto" colspan="3" ><?php echo $datos[1]?>
			</td>
			</tr>
			<tr class="textoN">
			<td width="160" height="22">Fecha Inicio</td>
			<td width="160" height="22">Fecha Fin</td>
			<td width="160" height="22">Monto Factura</td>
			</tr>
			<tr>
			<td><input name="fecha_p_i" type="date" class="texto" id="fecha_p_i" size="15" value="<?php echo $datos[3]?>" /></td>	
			<td><input name="fecha_p_f" type="date" class="texto" id="fecha_p_f" size="15" value="<?php echo $datos[4]?>" /></td>	
			<td><input name="monto" type="text" class="texto" id="monto" size="15" value="<?php echo $datos[8]?>" />
			<input name="monto_r" type="hidden" class="texto" id="monto_r" size="15" />
			</tr>
			<tr class="textoN">
			<td width="160" height="35">B. Imponible <input name="b_imp" type="text" class="texto" id="b_imp" size="10" value="<?php echo $datos[12]?>" onblur="cal_iva();"/></td>
			<td width="160" height="35">% Ret. IVA: <input name="iva" type="text" class="texto" id="iva" size="10" readonly="readonly" value="<?php echo $datos[11]?>" /></td>
			<td>T. Ret. IVA: <input name="t_IVA" type="text" class="texto" id="t_IVA" size="10" value="<?php echo $datos[6]?>" /> Bs</td>
			</tr>
			<tr class="textoN">
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">T. Ret. ISR: <input name="t_ISR" type="text" class="texto" id="t_ISR" size="10"  value="<?php echo $datos[7]?>"onblur="total_monto();" /> Bs</td>
			</tr>
			<tr class="textoN">
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">&nbsp;</td>
			<td width="160" height="35">T. Cancelar: <input name="t_monto" type="text" class="texto" id="t_monto" size="10" value="<?php echo $datos[5]?>" /> Bs</td>
			</tr>
			<tr>
			<td width="160" height="22" class="textoN">Descripci&oacute;n:</td>
			</tr>
			<tr>
			<td width="73" colspan="3" class="texto"><label>
			<textarea name="des" cols="80" rows="3" class="texto" id="des" ><?php echo $datos[2]?></textarea>
			<span class="Estilo1"> &nbsp;* </span>
			</tr>
			<tr>
			  <td colspan="5"><div id="cargar" align="center">
				<a href="#" onclick="validar2();" class="button" alt="Actualizar" <?php  echo $ope1;?>  >
  					<i class="fa fa-edit" aria-hidden="true"></i> Actualizar </a>
				<a href="#" onclick="eliminar_presu();" class="button" alt="Eliminar" <?php  echo $ope4;?>  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>
				</div>
				<input name="orden" id="orden" type="hidden" value="0" /></td>
			</tr>
			<tr class="titulofor">
			  <td height="30" colspan="3"><div align="center" class="titulofor">Relacion de Abonos</div></td>
			</tr>
			<tr class="textoN">
			<td width="160" height="22">Total a Pagar</td>
			<td width="160" height="22">Abonado</td>
			<td width="160" height="22">Saldo</td>
			</tr>
			<tr>
			<td><input type="text" name="t_p" id="t_p" readonly="readonly" value="<?php echo $datos[5]?>" size="15" ></td>	
			<td><input type="text" name="t_a" id="t_a" readonly="readonly" value="<?php echo $datos[9]?>" size="15"></td>	
			<td><input type="text" name="t_s" id="t_s" readonly="readonly" value="<?php echo $datos[10]?>" size="15"></td>	
			</tr>
			<tr class="textoN">
			<td width="60" height="22">Agregar Abono<img src="imagenes/add_16x16.gif" id="agred'.$contdi.'" title="Agregar Abono" alt="Agregar Abono" onClick="mostrar('.$contdi.');" '.$impagre.'></td>
			</tr>
			<tr class="textoN">
			<td width="160" height="22">Monto Abono</td>
			<td width="160" height="22">Fecha Abono</td>
			<td width="160" height="22">Detalle</td>
			</tr>
			<?php 
				$ver_d_abono=$pres->ver_det_abono($_GET['id_p']);
				echo $ver_d_abono;

			?>
			<tr>
				<td colspan="3"><div id="div_abono1" ></div></td>
			</tr>
			<tr>
				<td colspan="3"><div id="div_abono2" ></div></td>
			</tr>
			<tr>
				<td colspan="3"><div id="div_abono3" ></div></td>
			</tr>
			<tr>
				<td colspan="3"><div id="div_abono4" ></div></td>
			</tr>
			<tr>
				<td colspan="3"><div id="div_abono5" ></div></td>
			</tr>
			<tr class="textoN">
				<?php 
				if ( $datos[10]==0) {
		$pres= new presup();
 		$ver_fa=$pres->ver_fact($id_presupuesto);
 		if ($ver_fa){
 			$datos2=explode('**',$ver_fa);
				$Factura=$datos2[0];
				$n_est=$datos2[1];
				}
				
			?>
								
			<td>N de Factura <input type="text" name="n_factura" id="n_factura"  value="<?php echo $Factura?>" size="15">
				<input name="orden" id="orden" type="hidden" value="0" />
				<input type="radio" name="n_estado" id="n_estado" value="F"  <?php if ($n_est==F) 
        { echo "checked='checked'"; } ?>>Finalizado
				<input type="radio" name="n_estado" id="n_estado" value="X"  <?php if ($n_est==X)
        { echo "checked='checked'"; } ?>>X Ejecutar
				<input type="hidden" name="n_estado2" id="n_estado2" value="">
				<img src="imagenes/save_16x16.gif" title="Modificar" alt="Modificar" onclick="finalizar();" border="0" <?php  echo $ope1;?>/></td>	
				<?php }else{
				$pres= new presup();
 		$ver_fa=$pres->ver_fact($id_presupuesto);
 		if ($ver_fa){
 			$datos2=explode('**',$ver_fa);
				$Factura=$datos2[0];
				$n_est=$datos2[1];
				}			
				?>
				<td>Estatus:
				<input type="radio" name="n_estado" id="n_estado" value="J"  <?php if ($n_est==J) 
        { echo "checked='checked'"; } ?>>Ejecutado
				<input type="radio" name="n_estado" id="n_estado" value="I"  <?php if ($n_est==I)
        { echo "checked='checked'"; } ?>>Inactivo
				<input type="hidden" name="n_estado2" id="n_estado2" value="">
				<img src="imagenes/save_16x16.gif" title="Cambiar Estatus" alt="Cambiar Estatus" onclick="ejecutar();" border="0" <?php  echo $ope1;?>/></td>
				<?php }?>
			</tr>
				  <input name="empresa" type="hidden"  id="empresa" value="" />
				  <input name="servicio" type="hidden"  id="servicio" value="" />
				  <input name="medico" type="hidden"  id="medico" value="" />
				  <input name="estado" type="hidden"  id="estado" value="" />
				  <input name="c_prov" type="hidden" class="texto" id="c_prov"/>
				  <input name="c_ab" type="hidden"  id="c_ab" value="0" />

                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			
			<tr>
			  <td colspan="5"><div id="cargar" align="center">
				<img src="imagenes/p_guardar1.gif" alt="Guardar"  <?php  echo $ope1;?>
				width="140" height="50" style="cursor:hand" onclick="validar()" 
				onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
				<input name="orden" id="orden" type="hidden" value="0" />
				<img src="imagenes/p_imprimir1.gif" alt="Imprimir" width="140" height="50" style="cursor:hand" onclick="irpdf('detalle_presupuesto_pdf.php?id_p=<?php echo $id_presupuesto?>')" onmouseover="this.src='imagenes/a_imprimir1.gif'" onmouseout="this.src='imagenes/p_imprimir1.gif'"></div></td>

			</tr>
		  </table>
	
</form>
</body>
</html>
<?php 
}else echo "No tiene permisos para visualizar esta pagina!!<br> Cierre he ingrese nuevamente al sistema";
?>