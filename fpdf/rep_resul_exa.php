<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_examen.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte de Exámenes Realizados</title>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<script>
function Consultar()
{ 
		document.form1.ocu_fi.value=document.getElementById("fi1").value+'/'+document.getElementById("fi2").value+'/'+document.getElementById("fi3").value; 
		document.form1.ocu_ff.value=document.getElementById("ff1").value+'/'+document.getElementById("ff2").value+'/'+document.getElementById("ff3").value;

fi=document.getElementById("fi3").value+document.getElementById("fi2").value+document.getElementById("fi1").value; 
		ff=document.getElementById("ff3")+document.getElementById("ff2").value+document.getElementById("ff1").value; 
		if (document.getElementById("fi1").value!='' && document.getElementById("fi2").value!='' && document.getElementById("fi3").value!='' && document.getElementById("ff1").value!='' && document.getElementById("ff2").value!='' && document.getElementById("ff3").value!='')
	    if (fi<=ff)
		{ 
   		document.form1.submit();
		}
		else
		alert("La Fecha Hasta es menor que Fecha Inicio Debe arreglar");
		else
		alert("Debe ingresar el Rango de Fechas a Consultar");
}
function ver()
{
	if (document.getElementById("fi3").value<1850)
	{
		alert("Año inicio Erroneo");
		document.getElementById("fi3").value='';
	}
}
function ver1()
{
	if (document.getElementById("ff3").value<1850)
	{
		alert("Año fin Erroneo");
		document.getElementById("ff3").value='';
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
<form id="form1" name="form1" method="post" action="rep_resul_exa_PDF.php">
  <table width="453" border="0" align="center">
    <tr class="titulofor">
      <td colspan="2"><div align="center">Ex&aacute;menes Realizados </div></td>
    </tr>
    <tr>
      <td width="125" height="29" class="etiqueta"><div align="right"> <span class="Etiqueta">Fecha Desde:</span> </div></td>
      <td width="318" class="texto"><label>
<select name="fi1" class="texto" id="fi1">
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
</label>
/
<label>
<select name="fi2" class="texto" id="fi2">
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
</label>
/
<label>
<input name="fi3" type="text" class="texto" id="fi3"onchange="ver()" onkeypress='return soloNumeros(event)' size="8" maxlength="4" />
</label>
<span class="Estilo1"><strong> </strong></span><input name="ocu_fi" type="hidden" value="" /></td></tr>
    <tr>
      <td height="26" class="etiqueta"><div align="right"> <span class="Etiqueta">Fecha Hasta:</span> </div></td>
      <td class="texto"><label>
        <select name="ff1" class="texto" id="ff1">
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
      </label>
/
<label>
<select name="ff2" class="texto" id="ff2">
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
</label>
/
<label>
<input name="ff3" type="text" class="texto" id="ff3"onchange="ver1()" onkeypress='return soloNumeros(event)' size="8" maxlength="4" />
</label>
<span class="Estilo1"><strong> </strong></span>
        <input name="ocu_ff" type="hidden" value="" /></td>
    </tr>
    <tr>
      <td height="71" colspan="2" class="td-buttons"><label>
          <div align="center"><a href="#" onclick="Consultar();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>

          <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></div>
        </label></td>
    </tr>
  </table>

</form>
</body>
</html>
