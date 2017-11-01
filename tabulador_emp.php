<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_empresa.php";
include "clases/clase_tab_pre.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
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


function mostrarlista()
{
	if (document.getElementById('ls').style.display=="none")
	{	document.getElementById('ls').style.display='block'; }
	else
	{	document.getElementById('ls').style.display="none"; }
}
function Guardar(){
	document.form1.ocu_g.value=1;
	alert('guardando');
	document.form1.submit();
}
</script>
<?php if($_POST["ocu_g"]==1){
		$fecha_ac= @date("Y-m-d");
	for ($i=0; $i < $_POST["serv_totales"]; $i++) { 

		$tab= new tab_pre($_POST["idp".$i],$_POST["nocodcar".$i],$_POST["c_emp"],$fecha_ac,$_SESSION["cedu_usu"],$_POST["monto".$i]);
	//echo 'id '.$_POST["idp".$i].' hola '.$_POST["nocodcar".$i].' '.$_POST["c_emp"].' '.$fecha_ac.' 17932496 '.$_POST["monto".$i].'<br>';
  	if (isset($_POST["ocu_g"]) && $_POST["nocodcar".$i]!='0' && $_POST["c_emp"]!='0' && $_POST["monto".$i]!='')
		{

	$ver_tab=$tab->bus_tab_pre($_POST["nocodcar".$i],$_POST["c_emp"]);
	if($ver_tab!=false)
	   { 

	   	$mod_tab=$tab->mod_tab_pre();
	  	}else{
			$gua_tab=$tab->ins_tab_pre();
		}
	
	}
	}
	}
?>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="tabulador_emp.php">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="titulofor">
      <td height="30" colspan="6"><div align="center" class="titulofor">Tabulador por Empresa</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Empresa: </td>
      <td colspan="3" class="texto"><select name="comemp" class="texto" id="comemp" onchange="submit();">
        <option value="0" selected="selected" >Particular</option>
        <?php   
        $emp= new empresa('','','','','','','','',$_SESSION["cedu_usu"],'');
		 if ($emp->combo_emp()!= false)
		        echo $emp->combo_emp(); ?>
      </select>
      </td>
      <tr>
      <td colspan="3">
        <span class="etiqueta">Seleccione una empresa a la cual quiera asignar tabulador</span> </td>
        </tr>
        <tr>
       	<td height="30">&nbsp;</td>
        </tr>
    <?php 
	if($_POST["comemp"]!=0)
	{ $v_emp=$emp->ver_empre($_POST["comemp"]);

    ?>
	<tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Tabulador de Servicios de <?php echo $v_emp ?></div></td>
    </tr>
	 <tr>
      <td colspan="4"><div id="prod" style="display:block">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulorep" align="center">
    <td width="20">&nbsp;</td>
    <td width="380">Servicios </td>
    <td width="100">Precio </td>
	<td>Precio Empresa</td>
    </tr>	
	
<?php 
$ser= new servicio(0,'','','','','','',0);	  		
$serviprod2=$ser->lista_serv_tab_emp(); 
$n2=mysql_num_rows($serviprod2);
$indi2=0;
?>
<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php  echo $n2;?>" />
<?php 
while ($row2=mysql_fetch_array($serviprod2))
{ 
  $nocodigo='nocodcar'.$indi2;
  $nocodigoch='nocodcarch'.$indi2;
  $monto='monto'.$indi2;
  $idpre='idp'.$indi2;
  
  if ($indi2%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
?>
  <tr class="texto" <?php  echo $color; ?>  >
    <td width="20">
	<input name="<?php  echo $nocodigo;?>" id="<?php  echo $nocodigo;?>" type="hidden" value="<?php  echo $row2[1]; ?>" />
	</td>
    <td><?php  echo $row2[0]; ?></td>
    <td> <div align="right"><?php  echo $row2[2]; ?></div></td>
	<td><div align="center">
	<?php 
		//para leer el monto si se encuentra guardado:::::
	$dat_pre='';
	$tab2= new tab_pre();
	$ver_tab=$tab2->bus_tab_pre($row2[1],$_POST["comemp"]);
	if($ver_tab)
	   { $dat_pre=explode('**',$ver_tab);
		}
	?>
	  <input class="texto" name="<?php  echo $monto; ?>" id="<?php  echo $monto; ?>" type="text" value="<?php echo $dat_pre[1];?>" size="5" />
	  <input name="<?php  echo $idpre; ?>" id="<?php  echo $idpre; ?>" type="hidden" value="<?php echo $dat_pre[0];?>"/>
	  </div></td>
  </tr>
<?php  
$indi2++; 
 }?>
 <tr>
      <td colspan="4"><div align="center"><img src="imagenes/p_guardar1.gif" width="140" height="50" style="cursor:hand" onclick="Guardar();" 
		onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
		<input name="ocu_g" type="hidden" value="0"/> 
		<input type="hidden" name="serv_totales" value="<?php  echo $indi2; ?>"/>
		<input type="hidden" name="c_emp" id="c_emp" value="<?php  echo $_POST["comemp"] ?>"/>
          <input type="hidden" name="ocu_e" value="0"/>        
      <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='tabulador_emp.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/></div></td>
    </tr>
 <?php }?>
</table>
	     
		 </div>
	  </td>
	 </tr>
  </table>

</form>
</body>
</html>
