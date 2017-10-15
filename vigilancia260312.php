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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	if (document.getElementById("comemp").value!='0' && document.getElementById("año").value!='0' && document.getElementById("mes").value!='')
	{
		document.form1.ocu_b.value=1;
   		document.form1.submit();
	}
	else
		alert("Falta ingresar Datos");
}
function atras()
{
	document.form1.ocu_atr.value=1;
	document.form1.submit();
}

</script>
<body>
<form name="form1" method="post" action="">
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
if ($_POST["mes"]!='')
		$valm=$_POST["mes"]; 
  else
		$valm='0';
  if(isset($_POST["ocu_b"]) && $_POST["ocu_b"]=='1' )
{
	$vige=$vis->inf_empresa($val,$vala,$valm);
	if ($vige)
	{	
		$mos='style="display:none"';
	}
}
?>
  <table width="440" border="0" align="center" <?php echo $mos; ?>>
    <tr class="titulofor">
      <td colspan="2"><div align="center">Vigilancia Epidemiol&oacute;gica </div></td>
    </tr>
    <tr>
      <td width="62" class="etiqueta">Empresa:</td>
      <td width="368"><select name="comemp" class="texto" id="comemp" onchange="ver();">
        <option value="0" selected="selected" >Particular</option>
        <?php  
		 if ($emp->combo_emp()!= false)
		        echo $emp->combo_emp(); ?>
      </select><script> document.getElementById("comemp").value="<?php echo $val; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
    <tr>
      <td class="etiqueta">A&ntilde;o:</td>
      <td><select name="año" class="texto" id="año" onchange="ver();">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php  
		 if ($vis->buscar_año($val)!= false)
		        echo $vis->buscar_año($val); ?>
      </select><script> document.getElementById("año").value="<?php echo $vala; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
    <tr>
      <td class="etiqueta">Mes:</td>
      <td><select name="mes" class="texto" id="mes">
        <option value="0" selected="selected" >Seleccione---></option>
        <?php  
		 if ($vis->buscar_mes($vala,$val)!= false)
		        echo $vis->buscar_mes($vala,$val); ?>
      </select><script> document.getElementById("mes").value="<?php echo $valm; ?>"; </script>
      <span class="etiqueta"><span class="texto"><span class="Estilo2">*</span></span></span></td>
    </tr>
    <tr>
      <td colspan="2" class="etiqueta"><span class="texto"><span class="Estilo2">* </span>campos obligatorios</span></td>
    </tr>
    <tr>
      <td colspan="2" class="etiqueta td-buttons">
		<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>
      
      <a href="#" onclick="buscar();" class="button-search" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>

     <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

      <input name="ocu_b" type="hidden" id="ocu_b" value="0">
      <input name="ocu_atr" type="hidden" id="ocu_atr" value="0"></td>
    </tr>
  </table>
  
  <p><?php
  if(isset($_POST["ocu_b"]) && $_POST["ocu_b"]=='1' )
{
	if ($vige)
	{	?><p><img src="imagenes/p_atr1.gif" alt="retroceder" width="100" height="20" style="cursor:hand" onclick="atras();" onmouseover="this.src='imagenes/a_atr1.gif'"  onmouseout="this.src='imagenes/p_atr1.gif'"></p> 
  <p>
  <?php
		echo $vige;
		$vig_ae=$vis->enfermedades_accidentes($val,$vala,$valm);
		if ($vig_ae)
			$dat=explode('**',$vig_ae);
			echo $dat[0];
			//echo $dat[2];
		$vig_rex=$vis->resultado_examenes($val,$vala,$valm);
		if ($vig_rex)
			echo $vig_rex;
		$vig_r=$vis->referencias_visitas($val,$vala,$valm);
			echo $vig_r;
		$vig_rp=$vis->reposos_visitas($val,$vala,$valm);
			echo $vig_rp;
		$vig_ge=$vis->grupo_etario($val,$vala,$valm,$dat[2]);
			$datos=explode('**',$vig_ge);
			echo $datos[0];
		$vig_sx=$vis->grupo_sexo($val,$vala,$valm,$dat[2]);
			echo $vig_sx;
		$vig_gi=$vis->grupo_grado($val,$vala,$valm,$dat[2]);
			echo $vig_gi;
		$vig_ec=$vis->grupo_enfcomunes($val,$vala,$valm,$dat[2]);
			echo $vig_ec;
		$vig_mot=$vis->grupo_motivo($val,$vala,$valm,$dat[2]);
			echo $vig_mot;
		$vig_result=$vis->grupo_result($val,$vala,$valm,$dat[2]);
			echo $vig_result;
		$vig_patolog=$vis->patologias($val,$vala,$valm,$dat[2],$dat[1]);
			echo $vig_patolog;
		$vig_reldiamot=$vis->relacion_mot_dia($val,$vala,$valm,$dat[2]);
			echo $vig_reldiamot;
		$vig_relenfdis=$vis->relacion_enf_dis($val,$vala,$valm,$dat[2]);
			echo $vig_relenfdis;?>
  <p align="center"><p align="center">  <a href="#" onclick="generar_pdf();" class="button-print" alt="Imprimir" onclick="window.open('Vigilancia_pdf.php?empre=<?php echo $val; ?>&anio=<?php echo $vala; ?>&mes=<?php echo $valm; ?>','','width=700,height=450,resizable=yes,scrollbars=yes')"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>

  <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</p>
  <p align="center">&nbsp;</p>
  <?php
	}
	
}?>
    </p>
  </p>
  
</form>
</body>
</html>
