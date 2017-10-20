<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
include "clases/clase_paciente.php";
include "clases/clase_beneficiario.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<link href="../laboratorio/estilolab.css" rel="stylesheet" type="text/css">
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
	document.getElementById("cargo").value='';
	document.getElementById("fing").value='';
	document.getElementById("edo").value='0';
	document.getElementById("comemp").value='0';
	document.getElementById("sex").value='0';
	document.getElementById("grado").value='0';
	document.getElementById("foto").src="Dibujo.JPG";
	document.getElementById("archivos").innerHTML='<input name="fotofile" id="fotofile" type="file" class="texto" size="30" />';
	document.form1.ocu_N.value=0;
}
function Guardar()
{   document.form1.ocu_fi.value=document.getElementById("fna1").value+'/'+document.getElementById("fna2").value+'/'+document.getElementById("fna3").value; 
	if (document.getElementById("ced").value!='' && document.getElementById("nom1").value!='' && document.getElementById("ape1").value!='' && document.getElementById("fna1").value!='' && document.getElementById("fna2").value!='' && document.getElementById("fna3").value!='' && document.getElementById("grado").value!='0' && document.getElementById("te1").value!='' && document.getElementById("sex").value!='0')
	{
	if (document.getElementById("comemp").value!='0')
	{	if (document.getElementById("cargo").value!='' && document.getElementById("fing").value!='') 
		{if (document.form1.ocu_N.value==0)//modificar
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
		alert("Falta ingresar el Cargo y la fecha que ingresó a la empresa");
	}
	else
	{	if (document.form1.ocu_N.value==0)//modificar
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
	}
		else
			alert("Falta ingresar Datos");
	
}
function ver_modif(cadena)
{ 
	var trozos = cadena.split("/*");
	document.getElementById("ced").value=trozos[1];
	document.getElementById("nom1").value=trozos[2];
	document.getElementById("nom2").value=trozos[3];
	document.getElementById("ape1").value=trozos[4];
	document.getElementById("ape2").value=trozos[5];
	document.getElementById("dire").value=trozos[6];
	document.getElementById("te1").value=trozos[7];
	document.getElementById("te2").value=trozos[8];
	document.getElementById("cor").value=trozos[9];
	var fecha=new String(trozos[10]);
	var año = fecha.substr(0, 4);
	var  mes = fecha.substr(5, 2); 
	var dia = fecha.substr(8, 2);
	document.getElementById("fna1").value=dia;
	document.getElementById("fna2").value=mes;
	document.getElementById("fna3").value=año;
	document.getElementById("fing").value=trozos[15];
	document.getElementById("edo").value=trozos[11];
	document.getElementById("cargo").value=trozos[14];
	document.getElementById("sex").value=trozos[12];
	document.getElementById("comemp").value=trozos[13];
	document.getElementById("grado").value=trozos[16];
	document.getElementById("foto").src="fotos/"+trozos[0]+".jpg";
	document.form1.imafot.value="fotos/"+trozos[0]+".jpg";
	document.form1.ocu_N.value=trozos[0];
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
function eliminar_foto()
{ 			
   document.form1.ocu_fot.value=document.form1.imafot.value;
   document.form1.submit();
}
function posicion()
{
	document.getElementById('ced').focus();
}
function buscar()
{
 if(document.getElementById('ced').value!='')
 {
	 document.form1.ocu_b.value=1;
	 document.form1.submit();
 }
 else
   	alert('Debe indicar el Número de Cedula');

}
function verf_foto()
{
	if(document.getElementById("fotofile").value!='')
	{
		var ext=document.getElementById("fotofile").value.substr(document.getElementById("fotofile").value.length - 3);
		if(ext=='JPG' || ext=='jpg' || ext=='gif' || ext=='bmp' || ext=='GIF')
			Guardar();
		else

 			alert("archivo de foto no es valido tiene que ser JPG, jpg, gif, GIF o bmp");
	}
	else
		Guardar();
}
function ver()
{
	if (document.getElementById("fna3").value<1850)
		alert("Año de nacimiento erroneo");
}

</script>
<body onload="posicion();">
<?php  ?>
<form name="form1" id="form1" method="post" action="paciente.php" enctype="multipart/form-data">
  <div align="center">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="500" height="255" align="baseline">
      <param name="movie" value="capture4.swf">
      <param name="quality" value="high">
      <embed src="capture4.swf" width="500" height="255" align="baseline" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
  </object>
  
  <?php  
error_reporting(0);
$w = (int)$_POST['width'];
$h = (int)$_POST['height'];
$img = imagecreatetruecolor($w, $h);
imagefill($img, 0, 0, 0xFFFFFF);
$rows = 0;
$cols = 0;
for($rows = 0; $rows < $h; $rows++){
    $c_row = explode(",", $_POST['px' . $rows]);
    for($cols = 0; $cols < $w; $cols++){
        $value = $c_row[$cols];
         if($value != ""){
            $hex = $value;
            while(strlen($hex) < 6){
                $hex = "0" . $hex;
            }
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $test = imagecolorallocate($img, $r, $g, $b);
            imagesetpixel($img, $cols, $rows, $test);
        }
    }
}
//header("Content-type:image/jpeg");
imagejpeg($img,$_SESSION["cedu_usu"].".jpg", 90);
imagedestroy($img);
$_POST["imafot"]=$_SESSION["cedu_usu"].".jpg";
$f1='';
$datos[0]='0';
$datos[11]='0';
$datos[12]='0';
$datos[13]='0';
$datos[16]='0';

$pac= new paciente($_POST["ced"],'','','','','','','','','','','','','','');

  if ($_POST["ocu_b"]=='1')
  {
  		$bus=$pac->buscar();
		if ($bus!='false')
		{	
			$datos=explode('**',$bus);
	 		$f1=substr($datos[10],8,2).'/'.substr($datos[10],5,2).'/'.substr($datos[10],0,4);
			$_POST["imafot"]="fotos"."/".$datos[0].".jpg";
			$dian=substr($datos[10],8,2);
			$mesn=substr($datos[10],5,2);
			$añon=substr($datos[10],0,4);
		}
		else
			echo '<script>alert("El Paciente no se encuentra Registrado");</script>';

  }
    if ($_POST["ocu_fot"]!='0')
  {
		unlink($_POST["ocu_fot"]);
  }
$_POST["ususis"]=$_SESSION["cedu_usu"];
 $pac= new paciente('','','','','','','','','','','','','','','');
 $emp= new empresa('','','','','','','','',$_SESSION["cedu_usu"],'');

 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
     if($_POST["nomtit"]!='' || $_POST["cedtit"]!='' || $_POST["teltit"]!='')
	 {
	  $ben= new beneficiario($_POST["cedtit"],$_POST["ced"],$_POST["nomtit"],$_POST["teltit"]); 
	  $regb=$ben->cons_beneficiario($_POST["ced"]);
	  if($regb)
	   {
	     $modi=$ben->mod_beneficiario();		 
	   }
	   else
	   {
	     $inse=$ben->ins_beneficiario();		 
	   }
	 } 
	if($_POST["nomcon"]!='' || $_POST["telcon"]!='' )
	 {
	  $ben= new beneficiario($_POST["cedtit"],$_POST["ced"],$_POST["nomcon"],$_POST["telcon"]); 
	  $regb=$ben->cons_contacto($_POST["ced"]);
	  if($regb)
	   {
	     $modi=$ben->mod_contacto();		 
	   }
	   else
	   {
	     $inse=$ben->ins_contacto();		 
	   }
	 }  
        $feci=$_POST["ocu_fi"];
	$fec=substr($feci,6,4).'-'.substr($feci,3,2).'-'.substr($feci,0,2); 
	$pac= new paciente($_POST["ced"],$_POST["nom1"],$_POST["nom2"],$_POST["ape1"],$_POST["ape2"],$_POST["dire"],$_POST["te1"],
	$_POST["te2"],$_POST["cor"],$fec,$_POST["edo"],$_POST["sex"],$_SESSION["cedu_usu"],$_POST["ocu_N"], $_POST["grado"]);
		if($_POST['claveold']!=$_POST['clave'])
	 {
	   $apr=new aprobacion($_POST['ced'],gmdate("Y-m-d H:i:s",time()+(3600*-4.5)),$_POST['clave'],$_SESSION['cedu_usu'],'0');
	   if($_POST['claveold']=='')
	     $ins=$apr->insertar_clave();
	   else
	     $mod=$apr->modificar_clave();  	 
	 }    
	 $_POST['clave']='';
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		$gua=$pac->modf_paciente();
		if ($gua)
		{
				$nombre_archivo = $_FILES['fotofile']['name'];
				if($nombre_archivo!='') 
				{
					$a=move_uploaded_file($_FILES['fotofile']['tmp_name'], 'fotos/'.$_POST["ocu_N"].'.jpg');
				}

			$gua1=$emp->modf_empresa_paciente($_POST["ocu_N"],$_POST["comemp"],$_POST["cargo"],$_POST["fing"]); //si modifica la empresa a la cual trabaja		
			 $a=rename($_SESSION["cedu_usu"].".jpg","fotos"."/".$_POST["ocu_N"].".jpg");	
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		}
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{	
		$bus=$pac->buscar();
		if ($bus!='false')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$pac->ins_paciente();
			if ($gua)
			{
				$nombre_archivo = $_FILES['fotofile']['name'];
				if($nombre_archivo!='') 
				{
					$a=move_uploaded_file($_FILES['fotofile']['tmp_name'], 'fotos/'.$_POST["ced"].'.jpg');
				}
				$gua1=$emp->ing_empresa_paciente($_POST["ced"],$_POST["comemp"],$_POST["cargo"],$_POST["fing"]); //guardar la empresa a la cual trabaja
			    $a=rename($_SESSION["cedu_usu"].".jpg","fotos"."/".$_POST["ced"].".jpg");
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
		if ($gua)
			{
				echo '<script>alert("Registro Eliminado Exitosamente");</script>';
			}
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
	}
  
 ?>
  </div>
  <table width="791" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Paciente</div></td>
    </tr>
    <tr>
      <td class="etiqueta">C&eacute;dula: </td>
      <td colspan="2" class="texto"><label>
        <input name="ced" type="text" class="texto" id="ced" size="25"  value="<?php  echo $datos[1]; ?>" onkeypress='return soloNumeros(event)'/>
        <img src="imagenes/p_buspeq1.gif" alt="Buscar paciente Si EXISTE" width="35" height="25"  style="cursor:hand" onClick="buscar();"	onMouseOver="this.src='imagenes/a_buspeq1.gif'"  onMouseOut="this.src='imagenes/p_buspeq1.gif'"/><span class="Estilo1">*</span> s&oacute;lo n&uacute;meros  </label></td>
      <td width="321" rowspan="5" class="texto"><div align="right">
<img src="<?php  echo $_POST["imafot"]?>?<?=time()?>" width="120" height="100" id="foto" name="foto"><img src="imagenes/p_elifoto1.gif" alt="Eliminar la Foto" width="25" height="25" style="cursor:hand" onClick="eliminar_foto();"	onMouseOver="this.src='imagenes/a_elifoto1.gif'"  onMouseOut="this.src='imagenes/p_elifoto1.gif'">
<input name="ocu_fot" type="hidden" id="ocu_fot" value="0">
<input name="imafot" type="hidden" id="imafot" value="<?php  echo $_POST["imafot"]; ?>">
      </div></td>
    </tr>
    <tr>
      <td class="etiqueta">Primer Nombre:</td>
      <td colspan="2" class="texto"><input name="nom1" type="text" class="texto" id="nom1" size="25"  value="<?php  echo $datos[2]; ?>"onkeypress='return sincomillas(event)'/>
        <span class="Estilo2">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Segundo Nombre:</td>
      <td colspan="2" class="texto"><input name="nom2" type="text" class="texto" id="nom2" size="25" value="<?php  echo $datos[3]; ?>" onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta"><p>Primer Apellido:</p>      </td>
      <td colspan="2" class="texto"><input name="ape1" type="text" class="texto" id="ape1" size="25" value="<?php  echo $datos[4]; ?>" onkeypress='return sincomillas(event)'/>
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Segundo Apellido:</td>
      <td colspan="2" class="texto"><label>
        <input name="ape2" type="text" class="texto" id="ape2" size="25" value="<?php  echo $datos[5]; ?>" onkeypress='return sincomillas(event)'/>
      </label></td>
    </tr>
    <tr>
      <td height="25" class="etiqueta">Subir Archivo de foto:</td>
      <td colspan="3" class="texto"><div id="archivos"><input name="fotofile" type="file" class="texto" id="fotofile" size="30" /></div>
        <span class="Estilo2">Los Archivos pueden ser tipo JPEG, jpg, bmp, GIF &oacute; gif. </span>      </td>
    </tr>
    <tr>
      <td width="179" class="etiqueta">Direcci&oacute;n :</td>
      <td colspan="3" class="texto"><label>
        <textarea name="dire" cols="50" class="texto" id="dire" onkeypress='return sincomillas(event)'><?php  echo $datos[6]; ?></textarea>
      </label></td>
    </tr>
     <tr>
      <td height="19" class="etiqueta">Telefono Habitaci&oacute;n:</td>
      <td colspan="3" class="texto"><label>
        <input name="te1" type="text" class="texto" id="te1" size="25" value="<?php  echo $datos[7]; ?>" onkeypress='return soloNumeros(event)'/>
        <span class="Estilo1">*</span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono Celular :</td>
      <td colspan="3" class="texto"><label>
        <input name="te2" type="text" class="texto" id="te2" size="25" value="<?php  echo $datos[8]; ?>"  onkeypress='return soloNumeros(event)'/>
      </label></td>
    </tr>
     <tr>
      <td class="etiqueta">correo electr&oacute;nico:</td>
      <td colspan="3" class="texto"><input name="cor" type="text" class="texto" id="cor" size="50" value="<?php  echo $datos[9]; ?>" onkeypress='return sincomillas(event)'/></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Nacimiento: </td>
      <td colspan="3" class="texto"><label>
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
        </select><script> document.getElementById("fna1").value="<?php  echo $dian; ?>"; </script>
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
</select><script> document.getElementById("fna2").value="<?php  echo $mesn; ?>"; </script>
</label>
/
<label>
<input name="fna3" type="text" class="texto" id="fna3"  value="<?php  echo $añon; ?>"onChange="ver()" onkeypress='return soloNumeros(event)' size="8" maxlength="4">
</label>
<span class="Estilo2"><strong>
<input name="ocu_fi" type="hidden" value="" />
* d&iacute;a/mes/a&ntilde;o Ejemplo: 04/06/1998</strong></span>
        <span class="Estilo2"></span></td>
    </tr>
    <tr>
      <td class="etiqueta">Estado civil: </td>
      <td colspan="3" class="texto"><select name="edo" class="texto" id="edo">
        <option value="0">Seleccione---&gt;</option>
        <option value="C">Casado(a)</option>
        <option value="S">Soltero(a)</option>
        <option value="V">Viudo(a)</option>
        <option value="D">Divorciado(a)</option>
        <option value="U">Unión Libre</option>
      </select> <script> document.getElementById("edo").value="<?php  echo $datos[11]; ?>"; </script></td>
    </tr>
    <tr>
      <td class="etiqueta">Sexo:</td>
      <td colspan="3" class="texto"><select name="sex" class="texto" id="sex">
        <option value="0">Seleccione---&gt;</option>
        <option value="F">Femenino</option>
        <option value="M">Masculino</option>
      </select><script> document.getElementById("sex").value="<?php  echo $datos[12]; ?>"; </script>
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Grado de Instrucci&oacute;n: </td>
      <td colspan="3" class="texto"><label>
        <select name="grado" class="texto" id="grado">
          <option value="0">Seleccione--&gt;</option>
          <option value="Analfabeto">Analfabeta</option>
          <option value="Primaria">Primaria</option>
          <option value="Bachiller">Bachiller</option>
          <option value="Universitario">Universitario</option>
          <option value="Postgrado">Postgrado</option>
          <option value="T. S. U.">T. S. U.</option>
        </select><script> document.getElementById("grado").value="<?php  echo $datos[16]; ?>"; </script>
        <span class="Estilo1">*</span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Empresa donde Trabaja: </td>
      <td colspan="3" class="texto"><select name="comemp" class="texto" id="comemp">
        <option value="0" selected="selected" >Particular</option>
        <?php   
		 if ($emp->combo_emp()!= false)
		        echo $emp->combo_emp(); ?>
      </select><script> document.getElementById("comemp").value="<?php  echo $datos[13]; ?>"; </script>
        <input name="ocu_N" type="hidden" value="<?php  echo $datos[0]; ?>"/>
        <span class="Estilo2">Si proviene de una empresa solicitar Fecha de Ingreso y Cargo Obligatoriamente.</span> </td>
    </tr>
    <tr>
      <td class="etiqueta">Tiempo en la Empresa: </td>
      <td colspan="3" class="texto"><label>
      <input name="fing" type="text" class="texto" id="fing" size="20" maxlength="10" value="<?php  echo $datos[15]; ?>">
      </label>
        <span class="Estilo2"><strong>* </strong></span>Ejemplo: 10 meses ó 2 años</td>
    </tr>
    <tr>
      <td class="etiqueta">Cargo:</td>
      <td colspan="3" class="texto"><label>
        <input name="cargo" type="text" class="texto" id="cargo" size="50" value="<?php  echo $datos[14]; ?>">
      <span class="Estilo2"><strong>*</strong></span>      </label></td>
    </tr>
    
<?php  
	  $ben= new beneficiario('','','',''); 
	  $regb=$ben->cons_beneficiario($datos[1]);
	  if($regb)
	   { $benefe=explode('**',$regb);		  
	   ?>
	 <tr>
      <td class="etiqueta">Titular:</td>
      <td  class="texto"><label>
        <input name="nomtit" type="text" class="texto" id="nomtit" size="50" value="<?php  echo $benefe[2]; ?>"> </label></td>
	  <td class="etiqueta">CI:</td>
      <td  class="texto"><label><input name="cedtit" type="text" class="texto" id="cedtit" size="50" value="<?php  echo $benefe[0]; ?>">
      </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Telf. Titular:</td>
      <td colspan="3"  class="texto"><label>
        <input name="teltit" type="text" class="texto" id="teltit" size="50" value="<?php  echo $benefe[3]; ?>"> </label></td>	  
    </tr>
	   <?php  
	   }
	   $regs=$ben->cons_contacto($datos[1]);
	  if($regs)
	   { 
	    while($contac= mysql_fetch_row($regs))
	     { ?>
	 <tr>
      <td class="etiqueta">Contacto:</td>
      <td  class="texto"><label>
        <input name="nomcon" type="text" class="texto" id="nomcon" size="50" value="<?php  echo $contac[1]; ?>"> </label></td>
	  <td class="etiqueta">Telf:</td>
      <td  class="texto"><label><input name="telcon" type="text" class="texto" id="telcon" size="50" value="<?php  echo $contac[2]; ?>">
      </label></td>
    </tr>	
	   <?php  }	   
	   } ?>
    <tr>
      <td height="32" colspan="4" class="texto"><label><span class="Estilo2">* </span><span class="etiqueta">campos obligatorios </span></label>
      <input name="ocu_e" type="hidden" id="ocu_e" value="0"></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">

      <a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="verf_foto();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>


          <input name="ocu_g" type="hidden" value="0"/>
         
          <input name="ususis" type="hidden" id="ususis" value="<?php  echo $_SESSION["cedu_usu"]; ?>">
          <input type="hidden" name="ocu_b" value="0" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>

