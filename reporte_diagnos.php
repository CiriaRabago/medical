<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_diagnostico.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
include "clases/clase_medico.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
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
    
		if(document.getElementById("fna1").value!='' && 
		   document.getElementById("fna2").value!='' && 
		   document.getElementById("fna3").value!='')
           {    document.form1.ocu_fi.value=document.getElementById("fna3").value+'-'+document.getElementById("fna2").value+'-'+document.getElementById("fna1").value;
		        document.form1.oc_fi.value =document.getElementById("fna1").value+'-'+document.getElementById("fna2").value+'-'+document.getElementById("fna3").value; 
		   }
		else
		{
			if(document.getElementById("fna1").value=='' || 
			   document.getElementById("fna2").value=='' || 
			   document.getElementById("fna3").value=='')
			   {	alert('Debe ingresar todos los datos de la fecha Desde');
				    return false;}
		}
		
		if(document.getElementById("fnf1").value!='' && 
		   document.getElementById("fnf2").value!='' && 
		   document.getElementById("fnf3").value!='')
			{   document.form1.ocu_ff.value=document.getElementById("fnf3").value+'-'+document.getElementById("fnf2").value+'-'+document.getElementById("fnf1").value;
			document.form1.oc_ff.value=document.getElementById("fnf1").value+'-'+document.getElementById("fnf2").value+'-'+document.getElementById("fnf3").value;
			} 
		else
		{
			if(document.getElementById("fnf1").value=='' || 
			   document.getElementById("fnf2").value=='' || 
			   document.getElementById("fnf3").value=='')
			    {	alert('Debe ingresar todos los datos de la fecha Hasta');
				    return false;}
		 }
		
	if(document.getElementById("diagnostico").value!='0'  && 
	   document.getElementById("medico").value!='0')
	   {
	   document.form1.submit();
	   }
	else
	  {
		var cadena='';
		var union=0;
		if(document.getElementById("diagnostico").value=='0') { cadena="diagnostico"; union=1; }
		if(document.getElementById("medico").value=='0') { if(union==0) cadena+="Medico"; else cadena+=", Medico";  union=1; }
		alert('Debe seleccionar: '+cadena);
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
<form name="form1" id="form1" method="post" action="reporte_diagnos2.php">
<input name="ingreso" id="ingreso" type="hidden" value="0" />
<input name="nser" id="nser" type="hidden" value="" />
<input name="nemp" id="nemp" type="hidden" value="" />
<input name="nmed" id="nmed" type="hidden" value="" />
<input name="nsta" id="nsta" type="hidden" value="" />

	   		<table width="800" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="5"><div align="center" class="titulofor">REPORTE DE DIAGNOSTICOS </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="5">
				<table width="790" border="0" cellpadding="0" cellspacing="0">
                  <tr class="textoN">
				    <td>&nbsp;</td>
                    <td width="160" height="22">DESDE</td>
                    <td width="160">HASTA</td>
                  </tr>
                  <tr>
				    <td>&nbsp;</td>
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
<input name="oc_fi"  id="oc_fi" type="hidden" value="" />
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
<input name="oc_ff"  id="oc_ff" type="hidden" value="" />

					
					</td>                                     
                  </tr>
				  <tr>
				      <td colspan="2">DIAGNOSTICO</td>
                      <td width="122">DOCTOR</td>
 				  </tr>	
				  <tr>
				     <td colspan="2">
					<?php   $ser= new diagnostico('','',''); ?> 
						<select name="diagnostico" class="texto" id="diagnostico" >
						  <option value="0" selected="selected" >SELECCIONE --></option>
						  <option value="9" >TODOS</option>
						  <?php   if ($ser->combo_diag('')!= false)
								echo $ser->combo_diag(''); ?>
			  		    </select>
					
					</td>                    
                    <td colspan="5"><select name="medico" class="texto" id="medico">
					<option value="0" selected="selected" >SELECCIONE --></option>
						  <option value="9" >TODOS</option>
                      <?php   $med= new medico('','','','','','','','','','');
						$cmed=$med->combo_medico('');
						if($cmed!=false) echo $cmed;
						?>
                    </select></td>

				  </tr>
				  <tr>
                    <td height="19">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="174">&nbsp;
					</td>
                    <td width="74">&nbsp;</td>
                    <td>&nbsp;</td>
				  </tr>                                    
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			
			<tr>
			  <td colspan="5" class="td-btn"><div id="cargar" align="center">
				<a href="#" onclick="validar();" class="button-search" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a></div>
				<input name="orden" id="orden" type="hidden" value="0" /></td>
			</tr>
		  </table>

</form>
</body>
</html>
