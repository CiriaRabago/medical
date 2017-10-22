<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
include "clases/clase_visita.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo2 {color: #FF0000}
-->
</style>
</head>
<script>
function ver()
{
 document.form1.submit();
}
function Nuevo()
{
	document.getElementById("comemp").value='0';
	document.getElementById("año").value='0';
	document.getElementById("mes").value='0';
	document.form1.submit();
}
function buscar()
{
	if (document.getElementById("comemp").value!='0' && document.getElementById("año").value!='0' && document.getElementById("mes").value!='' && document.getElementById("año2").value!='0' && document.getElementById("mes2").value!='')
	{
	   if(document.getElementById("año").value>document.getElementById("año2").value || (document.getElementById("año").value==document.getElementById("año2").value && (document.getElementById("mes2").value-document.getElementById("mes").value)<0))
	   alert("Error ingresando fechas. La fecha desde debe ser menor o igual a la fecha hasta");
	   else{
		document.form1.ocu_b.value=1;
   		document.form1.submit();}
	}
	else
		alert("Falta ingresar Datos");
}
function atras()
{
	document.form1.ocu_atr.value=1;
	document.form1.submit();
}
function imprimir(a)
{
var   msg=a+'&c1='+document.form1.com1.value+'&c2='+document.form1.com2.value+'&c3='+document.form1.com3.value+'&c4='+document.form1.com4.value+'\'';
window.open(msg,'','width=700,height=450,resizable=yes,scrollbars=yes');
}

</script>
<body>
<form name="form1" method="post" action="vigilancia.php">
<input type="hidden" id="fe1" name="fe1" value="<?=$_POST['fe1'];?>">
<input type="hidden" id="fe2" name="fe2" value="<?=$_POST['fe2'];?>">

<?php 
$emp= new empresa('','','','','','','','','','');
$vis= new visita('','','','','','','','','','','','','');
if ($_POST["ocu_atr"]!=0)
{
	$mos='style="display:block"';
	$_POST["ocu_b"]='0';
}
if ($_POST["comemp"]!='' and $_POST["comemp"]!='0')
		$val=$_POST["comemp"]; 
  else
		$val='0';
if ($_POST["año"]!='')
		$vala=$_POST["año"]; 
  else
		$vala='0';
if ($_POST["año2"]!='')
		$vala2=$_POST["año2"]; 
  else
		$vala2='0';

if ($_POST["mes"]!='')
		$valm=$_POST["mes"]; 
  else
		$valm='0';
if ($_POST["mes2"]!='')
		$valm2=$_POST["mes2"]; 
  else
		$valm2='0';
if($valm<10)$valm='0'.$valm;
if($valm2<10)$valm2='0'.$valm2;
  if(isset($_POST["ocu_b"]) && $_POST["ocu_b"]=='1' )
{
    $f1=$vala.$valm;
	$f2=$vala2.$valm2;
	$fe1=$f1;
	$fe2=$f2;
	$vige=$vis->inf_empresa($val,$f1,$f2);
	if ($vige)
	{	
		$mos='style="display:none"';
	}
}

?>
  <table width="440" border="0" align="center" <?php  echo $mos; ?>>
    <tr class="titulofor">
      <td colspan="4"><div align="center">Vigilancia Epidemiol&oacute;gica </div></td>
    </tr>
    <tr>
      <td width="62" class="etiqueta">Empresa:</td>
      <td width="368" colspan="3"><select name="comemp" class="texto" id="comemp" onchange="ver();">
        <option value="0" selected="selected" >Particular</option>
        <?php   
		  $em=$emp->combo_emp();
		 if ($em!= false)
		        echo $em; ?>
      </select><script> document.getElementById("comemp").value="<?php  echo $val; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
    <tr>
      <td class="etiqueta">A&ntilde;o desde:</td>
      <td><select name="año" class="texto" id="año" onchange="ver();">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php  
		  $an=false;
		  $an=$vis->buscar_año($_POST['comemp']);
		  if ($an!= false)
		        echo $an; ?>
      </select><script> document.getElementById("año").value="<?php  echo $vala; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    
      <td class="etiqueta">Mes desde:</td>
      <td><select name="mes" class="texto" id="mes">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php   
		 if ($vis->buscar_mes($vala,$val)!= false)
		        echo $vis->buscar_mes($vala,$val); ?>
      </select><script> document.getElementById("mes").value="<?php  echo $valm; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
	<tr>
      <td class="etiqueta">A&ntilde;o hasta:</td>
      <td><select name="año2" class="texto" id="año2" onchange="ver();">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php   
		  $an2=false;
		  $an2=$vis->buscar_año($_POST['comemp']);
		 if ($an2!= false)
		        echo $an2; ?>
      </select><script> document.getElementById("año2").value="<?php  echo $vala2; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    
      <td class="etiqueta">Mes hasta:</td>
      <td><select name="mes2" class="texto" id="mes2">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php   
		 if ($vis->buscar_mes($vala2,$val)!= false)
		        echo $vis->buscar_mes($vala2,$val); ?>
      </select><script> document.getElementById("mes2").value="<?php  echo $valm2; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
    <tr>
      <td colspan="4" class="etiqueta"><span class="texto"><span class="Estilo2">* </span>campos obligatorios</span></td>
    </tr>
    <tr>
      <td colspan="4" class="etiqueta td-buttons">
      <a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

     <a href="#" onclick="buscar();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>
     
     <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
      <input name="ocu_b" type="hidden" id="ocu_b" value="0">
      <input name="ocu_atr" type="hidden" id="ocu_atr" value="0">
      <input name="ocu_imp" type="hidden" id="ocu_imp" value="0"></td>
    </tr>
  </table>
  
  <p><?php 
  if(isset($_POST["ocu_b"]) && $_POST["ocu_b"]=='1' )
{
	if ($vige)
	{	?>
  <p>
  <a href="#" onclick="atras();" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Atras </a>

  <p>
  <?php 
		echo $vige;		
		$f1=$vala.$valm;
	    $f2=$vala2.$valm2;
		$_POST['fe1']=$f1;
	    $_POST['fe2']=$f2;
		$vig_ae=$vis->enfermedades_accidentes($val,$f1,$f2,$_POST["ocu_imp"]);
		if ($vig_ae)
			$dat=explode('**',$vig_ae);
			echo $dat[0];
		$vig_rex=$vis->resultado_examenes($val,$f1,$f2,$_POST["ocu_imp"]);
		if ($vig_rex)
			echo $vig_rex;
		$vig_r=$vis->referencias_visitas($val,$f1,$f2,$_POST["ocu_imp"]);
			echo $vig_r;
		$vig_rp=$vis->reposos_visitas($val,$f1,$f2);
			echo $vig_rp;
		$vig_ge=$vis->grupo_etario($val,$f1,$f2,$dat[2]);
			$datos=explode('**',$vig_ge);
			echo $datos[0];
		$vig_sx=$vis->grupo_sexo($val,$f1,$f2,$dat[2]);
			echo $vig_sx;
		$vig_gi=$vis->grupo_grado($val,$f1,$f2,$dat[2]);
			echo $vig_gi;
		$vig_ec=$vis->grupo_enfcomunes($val,$f1,$f2,$dat[2]);
			echo $vig_ec;
		$vig_mot=$vis->grupo_motivo($val,$f1,$f2,$dat[2]);
			echo $vig_mot;
		$vig_result=$vis->grupo_result($val,$f1,$f2,$dat[2]);
			echo $vig_result;
		$vig_patolog=$vis->patologias($val,$vala,$valm,$dat[2],$dat[1]);
			echo $vig_patolog;
		$vig_relenfdis=$vis->relacion_enf_dis($val,$f1,$f2,$dat[2],$_POST["ocu_imp"]);
			echo $vig_relenfdis;
			$msg="'Vigilancia_pdf.php?empre=".$val."&anio=".$_POST['fe1']."&mes=".$_POST['fe2']."'";	?>
  <p align="center"><p align="center">  
  <a href="#" onclick="imprimir(<?=$msg;?>);" class="button-print" alt="Imprimir"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>

  <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

   </p>
  <p align="center">&nbsp;</p>
  <?php 
	}
	
}
?>
    </p>
  </p>
  
</form>
</body>
</html>
