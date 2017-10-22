<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
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
	if(document.getElementById("servicio").value!='0' && document.getElementById("empresa").value!='0' && document.getElementById("estado").value!='0')
	{
		if(document.getElementById("fna1").value!='' && document.getElementById("fna2").value!='' && document.getElementById("fna3").value!='')
			document.form1.ocu_fi.value=document.getElementById("fna3").value+'-'+document.getElementById("fna2").value+'-'+document.getElementById("fna1").value; 
		else
		{
			if(document.getElementById("fna1").value!='' || document.getElementById("fna2").value!='' || document.getElementById("fna3").value!='')
			{	alert('Debe ingresar todos los datos de la fecha Desde');
				return false;}
		}
		
		if(document.getElementById("fnf1").value!='' && document.getElementById("fnf2").value!='' && document.getElementById("fnf3").value!='')
			document.form1.ocu_ff.value=document.getElementById("fnf3").value+'-'+document.getElementById("fnf2").value+'-'+document.getElementById("fnf1").value; 
		else
		{
			if(document.getElementById("fnf1").value!='' || document.getElementById("fnf2").value!='' || document.getElementById("fnf3").value!='')
			{	alert('Debe ingresar todos los datos de la fecha Hasta');
				return false;}
		}
		
		document.getElementById("nser").value=document.getElementById("servicio").options[document.getElementById("servicio").selectedIndex].text;
		document.getElementById("nemp").value=document.getElementById("empresa").options[document.getElementById("empresa").selectedIndex].text;
		document.getElementById("nsta").value=document.getElementById("estado").options[document.getElementById("estado").selectedIndex].text;
		document.getElementById("ingreso").value=1;
		document.form1.submit();
	}
	else
	{
		var cadena='';
		var union=0;
		if(document.getElementById("servicio").value=='0') { cadena="Servicio"; union=1; }
		if(document.getElementById("empresa").value=='0') { if(union==0) cadena+="Empresa"; else cadena+=", Empresa";  union=1; }
		if(document.getElementById("estado").value=='0') { if(union==0) cadena+="Estado"; else cadena+=", Estado";  union=1; }
		alert('Debe seleccionar: '+cadena);
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

function irpdf(pag)
{
	document.form1.action=pag;
	document.form1.submit();
}

function ver1()
{
	if (document.getElementById("fna3").value<1850)
		alert("Año de Inicio Erroneo");
}
function ver2()
{
	if (document.getElementById("fnf3").value<1850)
		alert("Año de Fin Erroneo");
}

</script>
<body>
<form name="form1" id="form1" method="post" action="listado_pac.php">
<input name="ingreso" id="ingreso" type="hidden" value="0" />
<input name="nser" id="nser" type="hidden" value="" />
<input name="nemp" id="nemp" type="hidden" value="" />
<input name="nsta" id="nsta" type="hidden" value="" />
	   		<table width="700" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="5"><div align="center" class="titulofor">Listado de Pacientes </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="5">
				<table width="690" border="0" cellpadding="0" cellspacing="0">
                  <tr class="textoN">
                    <td width="160" height="22">DESDE</td>
                    <td width="160">HASTA</td>
                    <td colspan="2">SERVICIO</td>
                    <td width="122">PACIENTE</td>
                  </tr>
                  <tr>
                    <td>
					
					<select name="fna1" class="texto" id="fna1">
          <option value="">--</option>
		  <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
		/
<select name="fna2" class="texto" id="fna2">
  <option value="">--</option>
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
</select>
/
<input name="fna3" type="text" class="texto" id="fna3"  value="" onChange="ver1()" onkeypress='return soloNumeros(event)' size="4" maxlength="4">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_fi" id="ocu_fi" type="hidden" value="" />
					</td>
                    <td>
					<select name="fnf1" class="texto" id="fnf1">
          <option value="">--</option>
		  <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
		/
<select name="fnf2" class="texto" id="fnf2">
  <option value="">--</option>
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
</select>
/
<input name="fnf3" type="text" class="texto" id="fnf3"  value="" onChange="ver2()" onkeypress='return soloNumeros(event)' size="4" maxlength="4">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_ff" id="ocu_ff" type="hidden" value="" />

					
					</td>
                    <td colspan="2">
					<?php   $ser= new servicio('','','','','','','','','','','',''); ?> 
						<select name="servicio" class="texto" id="servicio" >
						  <option value="0" selected="selected" >SELECCIONE --></option>
						  <option value="" >TODOS</option>
						  <?php   if ($ser->combo_servicios()!= false)
								echo $ser->combo_servicios(); ?>
					  </select>
					
					</td>
                    <td><input name="cedula" type="text" class="texto" id="cedula" size="15" /></td>
                  </tr>
				  <tr>
                    <td height="19">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="174">&nbsp;
					</td>
                    <td width="74">&nbsp;</td>
                    <td>&nbsp;</td>
				  </tr>

                  <tr class="textoN">
                    <td height="21" colspan="4"><span class="textoN">EMPRESA</span> </td>
                    <td>ESTADO</td>
                  </tr>

                  <tr>
                    <td colspan="4"><select name="empresa" class="texto" id="empresa">
					<option value="0" selected="selected" >SELECCIONE --></option>
						  <option value="" >TODOS</option>
                      <?php   $emp= new empresa('','','','','','','','','','');
						$cemp=$emp->combo_emp('');
						if($cemp!=false) echo $cemp;
						?>
                    </select></td>
                    <td><select name="estado" class="texto" id="estado">
                      <option value="0" selected="selected" >SELECCIONE --></option>
					  <option value="" >TODOS</option>
                      <option value="A">ATENDIDO</option>
                      <option value="L">LISTA DE ESPERA</option>
                      <option value="P">PENDIENTE</option>
                      <option value="I">INCOMPLETO</option>
                      <option value="E">ELIMINADO</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			
			<tr>
			  <td colspan="5" class="td-btn"><div align="center">
				<a href="#" onclick="validar();" class="button-search" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>
				<input name="orden" id="orden" type="hidden" value="0" /></div></td>
			</tr>
		  </table>
	<?php    
	
	if($_POST['ingreso']==1)
 	{
    	$reg=$ser->listado_atenc( $_POST['ocu_fi'],$_POST['ocu_ff'],$_POST['servicio'],$_POST['cedula'],$_POST['estado'],$_POST['empresa']);//echo 'entro a verificar';
   		$cont=0;
		if($reg!=false)
		{
			$titulo='LISTADO DE ATENCIÓN';
			if($_POST['estado']!='') $titulo.='<br>'.$_POST['nsta'];
			if($_POST['ocu_fi']!='') $titulo.='<br>DESDE: '.$_POST['fna1'].'-'.$_POST['fna2'].'-'.$_POST['fna3'];
			if($_POST['ocu_ff']!='') $titulo.=' HASTA: '.$_POST['fnf1'].'-'.$_POST['fnf2'].'-'.$_POST['fnf3'];
			if($_POST['servicio']!='') $titulo.='<br>EN EL SERVICIO: '.$_POST['nser'];
			if($_POST['cedula']!='') $titulo.='<br>DEL PACIENTE: '.$_POST['cedula'];
			if($_POST['empresa']!='') $titulo.='<br>DE LA EMPRESA: '.$_POST['nemp'];
		
	?> 
		  <table width="930">
		  	<tr class="titulofor">
			  <td width="950" colspan="8" align="center"><?php  echo $titulo; ?></td>
			</tr>	
			<tr class="titulorep">
			  <td width="20">N°</td>
			  <td width="70">FECHA</td>
			  <td width="70">CEDULA</td>
			  <td width="220">NOMBRE</td>
			  <td width="200">EMPRESA</td>
			  <td width="150">SERVICIO</td>
			  <td width="140">MEDICO</td>
			  <td width="90">ESTADO</td>
			</tr>	   
	   
<?php 		   while ($row=mysql_fetch_array($reg))
		   { 
			  if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			  $cont++;
			  $vis= new visita($row[0],'','','','','','','','','','','','');
			  $reg2=$vis->datos_empres_vis();
			  $row2=mysql_fetch_array($reg2);
			  if($row2[1]=='') $empresa='PARTICULAR'; else $empresa=$row2[1];
			  switch ($row[12]) 
			  {	case 'A': $sta='ATENDIDO'; break;
				case 'L': $sta='LISTA DE ESPERA'; break;
				case 'P': $sta='PENDIENTE'; break;
				case 'I': $sta='INCOMPLETO'; break;
				case 'E': $sta='ELIMINADO'; break; }
		   ?>
				<tr class="texto" <?php  echo $color; ?>>
				  <td width="20"><?php  echo $cont; ?></td>
				  <td width="70"><a href="visita_especifica.php?visi=<?php  echo $row[0]; ?>&ipaci=<?php  echo $row[1]; ?>&fecha=<?php  echo $row[5]; ?>&emp=<?php  echo $empresa; ?>&esta=<?php  echo $sta; ?>&motivo=<?php  echo $row[13]; ?>&cpaci=<?php  echo $row[2]; ?>&npaci=<?php  echo $row[3]; ?>" target="_blank"><?php  echo $row[5]; ?></a></td>
				  <td width="70"><?php  echo $row[2]; ?></td>
				  <td width="220"><?php  echo $row[3]; ?></td>
				  <td width="200"><?php  echo $empresa; ?></td>
				  <td width="150"><?php  echo $row[11]; ?></td>
				  <td width="140"><?php  echo $row[10]; ?></td>
				  <td width="90"><?php  echo $sta; ?></td>
				</tr>

	<?php 		}  ?>
				<tr >
				  <td colspan="8" align="center" class="td-btn">
				  <a href="#" class="button-print" alt="Imprimir" onclick="irpdf('listado_pac_pdf.php?fi=<?php  echo $_POST['ocu_fi'];?>&ff=<?php  echo $_POST['ocu_ff'];?>&serv=<?php  echo $_POST['servicio'];?>&ced=<?php  echo $_POST['cedula'];?>&sta=<?php  echo $_POST['estado'];?>&empr=<?php  echo $_POST['empresa'];?>')"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>
				<input name="consulta" id="consulta" type="hidden" value="<?php  echo $row; ?>" />
				<input name="titu" id="titu" type="hidden" value="<?php  echo $titulo; ?>" />
				</td>
				</tr>
	    </table>
	<?php 	}
		else
		{ echo '<br><p class="textoN" align="center">No se encontró ninguna coincidencia</p>'; }?>
<?php 	} ?>


</form>
</body>
</html>
