<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empleado.php";
include "clases/clase_usuario.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo2 {color: #FF0000}
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
function Nuevo()
{  
	document.getElementById("ced").value='';
	document.getElementById("nom1").value='';
	document.getElementById("nom2").value='';
	document.getElementById("ape1").value='';
	document.getElementById("ape2").value='';
	document.getElementById("dire").value='';
	document.getElementById("te1").value='';
	document.getElementById("te2").value='';
	document.getElementById("cor").value='';
	document.getElementById("fna1").value='01';
	document.getElementById("fna2").value='01';
	document.getElementById("fna3").value='';
	document.getElementById("fi1").value='01';
	document.getElementById("fi2").value='01';
	document.getElementById("fi3").value='';
	document.getElementById("edo").value='0';
	document.getElementById("cargo").value='';
	document.getElementById("sex").value='0';
	document.getElementById("mpps").value='';
	document.getElementById("cole").value='';
	document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  document.form1.ocu_fi.value=document.getElementById("fna1").value+'/'+document.getElementById("fna2").value+'/'+document.getElementById("fna3").value;
document.form1.ocu_fei.value=document.getElementById("fi1").value+'/'+document.getElementById("fi2").value+'/'+document.getElementById("fi3").value;
	if (document.getElementById("ced").value!='' && document.getElementById("cor").value!='' && document.getElementById("nom1").value!='' && document.getElementById("ape1").value!='' && document.getElementById("fna1").value!='' && document.getElementById("fna2").value!='' && document.getElementById("fna3").value!='' && document.getElementById("te1").value!='' && document.getElementById("sex").value!='0' && document.getElementById("fi1").value!='' && document.getElementById("fi2").value!='' && document.getElementById("fi3").value!='' && document.getElementById("cargo").value!='')
	{
		if (document.form1.ocu_N.value==0)//modificar
			{	
				document.form1.ocu_g.value=1;			
				document.form1.submit();
			}
		else
			{
				document.form1.ocu_g.value=2;
   				document.form1.submit();
			}
	}
		else
			alert("Falta ingresar Datos");
	
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("ced").value=trozos[0];
	document.getElementById("nom1").value=trozos[1];
	document.getElementById("nom2").value=trozos[2];
	document.getElementById("ape1").value=trozos[3];
	document.getElementById("ape2").value=trozos[4];
	document.getElementById("dire").value=trozos[5];
	document.getElementById("te1").value=trozos[6];
	document.getElementById("te2").value=trozos[7];
	document.getElementById("cor").value=trozos[8];
	var fecha=new String(trozos[9]);
	var ao = fecha.substr(0, 4);
	var  mes = fecha.substr(5, 2); 
	var dia = fecha.substr(8, 2);
	document.getElementById("fna1").value=dia;
	document.getElementById("fna2").value=mes;
	document.getElementById("fna3").value=ao;
	var fecha1=new String(trozos[15]);
	var ao1 = fecha1.substr(0, 4);
	var  mes1 = fecha1.substr(5, 2); 
	var dia1 = fecha1.substr(8, 2);
	document.getElementById("fi1").value=dia1;
	document.getElementById("fi2").value=mes1;
	document.getElementById("fi3").value=ao1;
	document.getElementById("edo").value=trozos[10];
	document.getElementById("sex").value=trozos[11];
	document.getElementById("cargo").value=trozos[12];
	document.getElementById("mpps").value=trozos[13];
	document.getElementById("cole").value=trozos[14];
	document.form1.ocu_N.value=trozos[0];
	document.getElementById("ced").disabled="disabled";
}
function soloNumeros(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  		alert("Solo se permiten nmeros en este campo.");
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
		resp=confirm("Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
			document.form1.ocu_e.value=1;
   			document.form1.submit();
		}
	}
}
function ver()
{
	if (document.getElementById("fna3").value<1850)
	{
		alert("Año de Nacimiento Erroneo");
		document.getElementById("fna3").value='';
	}
}
function ver1()
{
	if (document.getElementById("fi3").value<1850)
	{
		alert("Año de Ingreso Erroneo");
		document.getElementById("fi3").value='';
	}
}
</script>
<body>
<form name="form1" method="post" action="empleado.php">
  <div align="center">
  <?php  
 $pac= new empleado('','','','','','','','','','','','','','','','','','','');
 $usu= new usuario('','','','','','','','');

 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { $feci=$_POST["ocu_fi"];
	$fec=substr($feci,6,4).'-'.substr($feci,3,2).'-'.substr($feci,0,2); 
	$fein=substr($_POST["ocu_fei"],6,4).'-'.substr($_POST["ocu_fei"],3,2).'-'.substr($_POST["ocu_fei"],0,2); 
	$pac= new empleado($_POST["ced"],$_POST["nom1"],$_POST["nom2"],$_POST["ape1"],$_POST["ape2"],$_POST["dire"],$_POST["te1"],
	$_POST["te2"],$_POST["cor"],$fec,$_POST["edo"],$_POST["sex"],$_POST["cargo"],$_POST["mpps"],$_POST["cole"],$fein,'','',$_SESSION["cedu_usu"]);
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$pac->modf_empleado($_POST["ocu_N"]);
		if ($gua)
		{
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		}
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{	
		$bus=$pac->buscar();
		if ($bus=='true')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$pac->ins_empleado();
			if ($gua)
			{
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
	}
  }
  
   if ($_POST["ocu_e"]=='1') //para eliminar
	{	
		$gua=$pac->eliminar($_POST["ocu_N"]);
		$eli=$usu->eliminar($_POST["ocu_N"]);
		if ($gua)
			{
				echo '<script>alert("Registro Eliminado Exitosamente");</script>';
			}
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	}
  
 ?>
  </div>
  <table width="650" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="2"><div align="center" class="titulofor">Empleado</div></td>
    </tr>
    <tr>
      <td class="etiqueta">C&eacute;dula: </td>
      <td class="texto"><label>
        <input name="ced" type="text" class="texto" id="ced" size="25" onkeypress='return soloNumeros(event)'/>
        <span class="Estilo1">*</span> s&oacute;lo n&uacute;meros  </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Primer Nombre:</td>
      <td class="texto"><input name="nom1" type="text" class="texto" id="nom1" size="25" onkeypress='return sincomillas(event)'/>
        <span class="Estilo2">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Segundo Nombre:</td>
      <td class="texto"><input name="nom2" type="text" class="texto" id="nom2" size="25" onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta"><p>Primer Apellido:</p>      </td>
      <td class="texto"><input name="ape1" type="text" class="texto" id="ape1" size="25" onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Segundo Apellido:</td>
      <td class="texto"><label>
        <input name="ape2" type="text" class="texto" id="ape2" size="25" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
    <tr>
      <td width="152" class="etiqueta">Direcci&oacute;n:</td>
      <td class="texto"><label>
        <textarea name="dire" cols="50" class="texto" id="dire" onkeypress='return sincomillas(event)'></textarea>
      </label></td>
    </tr>
     <tr>
      <td class="etiqueta">Telefono Habitaci&oacute;n:</td>
      <td class="texto"><label>
        <input name="te1" type="text" class="texto" id="te1" size="25" onkeypress='return sincomillas(event)' />
        <span class="Estilo1">*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono Celular :</td>
      <td class="texto"><label>
        <input name="te2" type="text" class="texto" id="te2" size="25" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
     <tr>
      <td class="etiqueta">correo electr&oacute;nico:</td>
      <td class="texto"><input name="cor" type="text" class="texto" id="cor" size="50" onkeypress='return sincomillas(event)'/>
       <span class="Estilo1">*</span> indique un correo Valido. </td>
    </tr>
    <tr>
      <td height="29" class="etiqueta">Fecha de Nacimiento: </td>
      <td class="texto">        <a id="lanzador1">  </a>
        <label>
        <select name="fna1" class="texto" id="fna1">
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
<select name="fna2" class="texto" id="fna2">
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
<input name="fna3" type="text" class="texto" id="fna3"onChange="ver()" onkeypress='return soloNumeros(event)' size="8" maxlength="4">
</label>
<span class="Estilo2"><strong> </strong></span>
<input name="ocu_fi" type="hidden" value="" />
      <span class="Estilo2"><strong>* <strong> d&iacute;a/mes/a&ntilde;o Ejemplo: 04/06/1998</strong> </strong></span></td>
    </tr>
    <tr>
      <td class="etiqueta">Estado civil: </td>
      <td class="texto"><select name="edo" class="texto" id="edo">
        <option value="0">Seleccione---&gt;</option>
        <option value="C">Casado(a)</option>
        <option value="S">Soltero(a)</option>
        <option value="V">Viudo(a)</option>
        <option value="D">Divorciado(a)</option>
        <option value="U">Uni&oacute;n Libre</option>
      </select></td>
    </tr>
    <tr>
      <td class="etiqueta">Sexo:</td>
      <td class="texto"><select name="sex" class="texto" id="sex">
        <option value="0">Seleccione---&gt;</option>
        <option value="F">Femenino</option>
        <option value="M">Masculino</option>
      </select>
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Mpps:</td>
      <td class="texto"><label class="texto">
        <input name="mpps" type="text" class="texto" id="mpps">
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Colegio: </td>
      <td class="texto"><input name="cole" type="text" class="texto" id="cole"></td>
    </tr>
    <tr>
      <td class="etiqueta">Cargo:</td>
      <td class="texto"><input name="cargo" type="text" class="texto" id="cargo" size="50">
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Ingreso a la Empresa: </td>
      <td class="texto">          <label>
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
<input name="fi3" type="text" class="texto" id="fi3"onChange="ver1()" onkeypress='return soloNumeros(event)' size="8" maxlength="4">
</label>
<span class="Estilo2"><strong> </strong></span>
<input name="ocu_fei" type="hidden" value="" />
      <span class="Estilo2"><strong>* <strong><strong>d&iacute;a/mes/a&ntilde;o Ejemplo: 04/06/1998</strong> </strong></strong></span></td>
    </tr>
    <tr>
      <td height="32" colspan="2" class="texto"><label><span class="Estilo2">* </span><span class="etiqueta">campos obligatorios </span></label>
      <input name="ocu_e" type="hidden" id="ocu_e" value="0">
      <input name="ocu_N" type="hidden" value="0"/></td>
    </tr>
    <tr>
      <td colspan="2" class="td-buttons">

      <a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

  <a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


  <a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


  <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</td>
    </tr>
  </table>
       <?php  
$ver=$pac->ver_empleado();
        if ($ver==false)
		{
		   
		} 
		else
		{
		    echo $ver;
		}
?>
</form>
</body>
</html>