<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_visita.php";
include "clases/clase_servicio.php";
include "clases/clase_paciente.php";
include "clases/clase_medico.php";
include "clases/clase_empresa.php";
include "clases/clase_beneficiario.php";
include "clases/clase_aprobacion.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {	color: #FF0000;
	font-weight: bold;
}
.Estilo3 {color: #0000FF}
-->
</style>
</head>
<script>
function Guardar()
{ if (document.getElementById("mot").value!='0' && document.form1.ocuced.value!='' && document.getElementById("comemp").value!=''  && document.form1.ocuser.value>'0' )
	{
	     
		if (document.form1.ocu_N.value==0 || document.form1.ocu_N.value=='')//modificar
			{	
				document.form1.ocu_g.value=1;		
				document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";	
				document.form1.submit();
			}
		else
			{
				document.form1.ocu_g.value=2;
				document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
   				document.form1.submit();
			}
	}
		else
			alert("Falta ingresar Datos");
	
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
    document.getElementById("comemp").value=trozos[9];
	document.getElementById("esp").value=trozos[8];
	document.getElementById("ser").value=trozos[1];
	document.form1.ocuser.value=trozos[1];
	document.getElementById("mot").value=trozos[5];
	document.getElementById("fac").value=trozos[4];
	document.form1.ocu_N.value=trozos[0];
	document.form1.disab.value='disabled="disabled"';
	document.form1.submit();
}
function ver()
{	
	if (document.getElementById("ser").value>'0')
	{
		document.form1.ocuser.value=document.getElementById("ser").value;
	 	document.form1.submit();
	}
} 
function soloNumeros(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  		alert("Solo se permiten nÃºmeros en este campo.");
 		return false;
  	}
	return true;
}
function buscar()
{ 
if(document.form1.ocuced.value!=document.form1.cedreg.value){
 document.form1.titular.checked=false;
 document.form1.beneficiario.checked=false;}
 if(document.getElementById('cedreg').value!='')
 {
	 document.form1.ocu_b.value=1;
	 document.form1.submit();
 }
 else
   	alert('Debe indicar el NÃºmero de Cedula');

}
function Nuevo()
{
 	document.form1.ocuced.value='';
	document.form1.ocunom.value='';
	//document.form1.ocuemp.value='';
	document.form1.ocuser.value='';
	document.form1.codemp.value='';
	document.getElementById("comemp").value='0';
	document.getElementById("esp").value='0';
	document.getElementById("ser").value='0';
	document.getElementById("mot").value='0';
	document.getElementById("fac").value='';
    document.form1.ocu_N.value=0;
	document.form1.submit();
	
}
function eliminar()
{  if (document.form1.ocu_N.value==0)
	{	
		alert("Para Eliminar, Debe Seleccionar una visita previa del Paciente");
	}
	else
	{	
		//resp=confirm("Â¿Desea Eliminar el registro Seleccionado?");
		//if (resp==true)
		//{	
			document.form1.ocu_e.value=1;
			document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
   			document.form1.submit();
		//}
	}
}
function eliminar_conobs()
{  
	if (document.getElementById("obser").value!='')
	{
		document.form1.ocu_e.value=2;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
   		document.form1.submit();
	}
	else
		alert("Debe indicar el motivo de la eliminación de la Visita");
}
function salir()
{
		document.form1.ocu_e.value=0;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
   		document.form1.submit();
}
function posicion()
{
document.getElementById('cedreg').focus();
}
</script>
<body onload="posicion();">
<form id="form1" name="form1" method="post" action="reg_llegada.php">
<?php  
$activabene=0;
$activatitu=0;
$idpac=$_POST["ocuid"];
$ced=$_POST["ocuced"];
$nom=$_POST["ocunom"];
$emp=$_POST["codemp"];
$fact=$_POST["fac"];
if ($_POST["ser"]!='')
	    $val=$_POST["ser"]; 
  else
		$val='0';
if ($_POST["mot"]!='')
	    $mt=$_POST["mot"]; 
  else
		$mt='0';
if ($_POST["esp"]!='')
	    $es=$_POST["esp"]; 
  else
		$es='0';
if ($_POST["comemp"]!='')
	    $_POST["codemp"]=$_POST["comemp"]; 
  else
		$_POST["codemp"]='0';
$mosvis='style="display:none"';
$mosobs='style="display:none"';
$emp= new empresa('','','','','','','','','','');
 $ser= new servicio($_POST["ocuser"],'','','','','','','','','','','');
 $ref= new medico('','','','','','','','','','','','','','','');
 $pac= new paciente($_POST["cedreg"],'','','','','','','','','','','','','','');
 $vis= new visita('','','','','','','','','','','','','');
 $ben= new beneficiario($_POST["cedreg"],'','','','','','','','','','','','','','');
 $num=$vis->num_llegada()+1;

if ($_POST["ocu_b"]=='1')
  {
       
  		$bus=$pac->buscar();
		if ($bus!='false')
		{	
			$datos=explode('**',$bus);
			$idpac=$datos[0];
			$ced=$datos[1];
			$nom=$datos[2].' '.$datos[3].' '.$datos[4].' '.$datos[5];
			$_POST["codemp"]=$datos[13];
			$vispen=$vis->visitas_pend($idpac);
			if ($vispen!='')
				$mosvis='style="display:block"';
		$infc=$ben->cons_beneficiario($_POST["cedreg"]);		
	    if($infc!=false)
	     {
		  $activabene=1;
		 }	 
		 
		$infc=$ben->cons_titular($_POST["cedreg"]);		
	    if($infc!=false)
	     {
		  $activatitu=1;
		 }
		}
		else
		{
			$idpac='';
			$ced='';
			$nom='';
			$emp='';
			echo '<script>alert("El Paciente no se encuentra Registrado");document.form1.submit();</script>';
		}
  }
 if(isset($_POST["ocu_e"]) && $_POST["ocu_e"]=='1' )
 { 	$mosobs='style="display:block"';
 	$mosreg='style="display:none"';
	$vispen=$vis->visitas_pend($idpac);
 }

if(isset($_POST["ocu_e"]) && $_POST["ocu_e"]=='2' )
  {
  		$eli=$vis->consul_det_exist($_POST["ocu_N"]);
		if ($eli)
		{
			$elid=$vis->consul_det($_POST["ocu_N"]);
			if($elid==false)
			{
				$eliv=$vis->eliminar_v($_POST["ocu_N"],$_POST["obser"]);///ELIMINAR LA VISITA
				$elid=$vis->eliminar_d($_POST["ocu_N"],$_POST["obser"]);
				$agregsta=$vis->ins_sta_det_visita('','E',$_POST["ocuser"],$_SESSION["cedu_usu"],$_POST["ocu_N"],$_POST["obser"]);
				for($i=0;$i<$_POST['cantiocu2'];$i++)// eliminar detalle de la visita
				{
					$agregsta=$vis->ins_sta_det_visita($_POST['nocodcar'.$i],'E',$_POST['servi'.$i],$_SESSION["cedu_usu"],$_POST["ocu_N"],$_POST["obser"]);
				}	
				echo '<script>alert("La Visita ha sido Eliminada Satisfactoriamente");</script>';
			}
			else
				echo '<script>alert("No puede ser Eliminada, porque esta parcialmente Atendida");</script>';
		}
		else
		{
				$eliv=$vis->eliminar_v($_POST["ocu_N"], $_POST["obser"]);///ELIMINAR LA VISITA
				$agregsta=$vis->ins_sta_det_visita('','E',$_POST["ocuser"],$_SESSION["cedu_usu"],$_POST["ocu_N"],$_POST["obser"]);
				if($eliv==true && $agregsta==true)
					echo '<script>alert("La Visita ha sido Eliminada Satisfactoriamente");</script>';
		}
		$vispen=$vis->visitas_pend($idpac);
		$_POST["ocuser"]='0';
		$_POST["ocu_N"]='0';
  }

   if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
   				if ($_POST['cantiocu2']>'0')
					$stav='P';
				else
					$stav='L';
	if($_POST["nomco"]!='' && $_POST["telfco"]!='')
	   {
        $ben= new beneficiario($_POST["cedreg"],'',$_POST["nomco"],$_POST["telfco"]);
	    $guarda=$ben->ins_contacto();
		if($guarda==false)		
			echo '<script>alert("Error guardando Contacto. Intente despues");</script>'; 
	   }	
	 if($_POST["nomtit"]!='' && $_POST["teltit"]!='' && $_POST["cedtit"]!='')
	   {
	    $infc=$ben->cons_beneficiario($_POST["cedreg"]);
	    if($infc==false)
	     {	     
         $ben= new beneficiario($_POST["cedtit"],$_POST["cedreg"],$_POST["nomtit"],$_POST["teltit"]);
	     $guarda2=$ben->ins_beneficiario();
		 if($guarda2==false)		
			echo '<script>alert("Error guardando Beneficiario. Intente despues");</script>'; 
		  }		  
	   }	
	   
	  if(isset($_POST['titular']) && $activatitu=='0' )
		 {
		   $ben= new beneficiario($_POST["cedreg"],$_POST["cedreg"],$_POST["ocunom"],$_POST["teltit"]);
	       $guarda2=$ben->ins_beneficiario();
		   if($guarda2==false)		
			 echo '<script>alert("Error guardando Beneficiario. Intente despues");</script>'; 
		 }   			

	$vis= new visita($_POST["ocu_N"],$_POST["ser"],$_POST["ocuid"],$num,$_POST["fac"],$_POST["mot"],'','',$stav,'',$_SESSION["cedu_usu"],$_POST["esp"],$_POST["codemp"]);
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]>'0' )
	{
		$gua=$vis->mod_visita();
		if ($gua)
		{
		   		if ($_POST['cantiocu2']=='0' || $_POST['cantiocu2']=='' )
					$agregsta=$vis->ins_sta_det_visita('',$stav,$_POST["ocuser"],$_SESSION["cedu_usu"],$_POST["ocu_N"],'');

				$gprods=true;
				for($i=0;$i<$_POST['cantiocu2'];$i++)
				{
				   if($_POST['nocodcarch'.$i])
				   {
				   	 $sta='L'; 
					//else
				   		 //if($_POST['stat'.$i]=='P' || $_POST['stat'.$i]=='L')
				   	 		//$sta='P';
					 $agregprod=$vis->mod_det_visita($_POST["ocu_N"],$_POST['nocodcar'.$i],'',$sta,'');
					 if ($agregprod!=false)
					  	$agregsta=$vis->ins_sta_det_visita($_POST['nocodcar'.$i],$sta,$_POST['servi'.$i],$_SESSION["cedu_usu"],$_POST["ocu_N"],'');
					 if($gprods==true && $agregprod==false) $gprods=false;}
				}
				if($gprods==true)
					echo '<script>alert("Registro Modificado Exitosamente");document.form1.submit();</script>';
				else
					echo '<script>alert("El Registro de detalle no pudo ser Modificado");document.form1.submit();</script>';
			
		}	
		else
			echo '<script>alert("El Registro no pudo ser Modificado");document.form1.submit();</script>';
	}
	if (isset($_POST["ocu_N"]) && ($_POST["ocu_N"]=='0' || $_POST["ocu_N"]==''))
	{	
	        
			$gua=$vis->ins_visita();
			if ($gua!=false)
			{
			 if($_POST['keyacc']!='' && $_POST['codemp']=='226')
	          {
	           $apr=new aprobacion($gua,$_POST['resacc'],$_POST['ocuid'],gmdate("Y-m-d H:i:s",time()+(3600*-4.5)),$_POST['keyacc'],$_SESSION['cedu_usu'],'0');
	           $ins=$apr->insertar_clave();	             	 
	           }    
   
				$agregsta=$vis->ins_sta_det_visita('',$stav,$_POST["ser"],$_SESSION["cedu_usu"],$gua,'');
				$gprods=true;
				for($i=0;$i<$_POST['cantiocu2'];$i++)
				{
				   if($_POST['nocodcarch'.$i])
				   	 $sta='L'; 
				   else
				   	 $sta='P';
					 $agregprod=$vis->ins_det_visita($gua,$_POST['nocodcar'.$i],$_SESSION["cedu_usu"],$sta);
					 if ($agregprod!=false)
					  	$agregsta=$vis->ins_sta_det_visita($agregprod,$sta,$_POST['nocodcar'.$i],$_SESSION["cedu_usu"],$gua,'');
					 if($gprods==true && $agregprod==false) $gprods=false;
				}
		
				if($gprods==true)
					echo '<script>alert("Registro Guardado Exitosamente");document.form1.submit();</script>';
				else
					echo '<script>alert("El Registro de detalle no pudo ser Guardado");document.form1.submit();</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
	}
  }
 $cedreg=$_POST["cedreg"];
?>
  <table width="683" border="0" align="center" <?php  echo $mosreg; ?>>
    <tr class="titulofor">
      <td colspan="2"><div align="center">Registro de llegada </div></td>
    </tr>
    <tr>
      <td width="143" height="32" class="etiqueta">C&eacute;dula:</td>
      <td width="530" class="texto"><label>
        <input name="cedreg" type="text" class="texto" id="cedreg" onkeypress='return soloNumeros(event)' value="<?php  echo $_POST["cedreg"];?>"/>
        </label>
          <img src="imagenes/p_buspeq1.gif" alt="Buscar paciente" width="35" height="25"  style="cursor:hand" onclick="buscar();"	onmouseover="this.src='imagenes/a_buspeq1.gif'"  onmouseout="this.src='imagenes/p_buspeq1.gif'"/><span class="Estilo1"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* </span><span class="etiqueta">campos obligatorios</span></td>
    </tr>
    <tr class="titulorep">
      <td colspan="2">Datos del Paciente </td>
    </tr>
    <tr>
      <td class="etiqueta">C&eacute;dula:</td>
      <td class="texto"><?php  echo $ced; ?>
      <input name="ocuced" type="hidden" id="ocuced" value="<?php  echo $ced; ?>" />
      <span class="Estilo2">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombres y Apellidos: </td>
      <td class="texto"><?php  echo $nom; ?>
        <input name="ocunom" type="hidden" id="ocunom" value="<?php  echo $nom; ?>" />
      <span class="Estilo2">*</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Empresa:</td>      
     <td class="texto"><select name="comemp" class="texto" id="comemp">
        <option value="0" selected="selected" >Particular</option>
        <?php   
		 if ($emp->combo_emp()!= false)
		        echo $emp->combo_emp(); ?>
      </select><script> document.getElementById("comemp").value="<?php  echo $_POST["codemp"];?>"; </script>

      <span class="Estilo2">*</span></td>
    </tr>
	<?php 
	  $sw=0;
	  $infc=$ben->cons_contacto($ced);
	  if($infc)
	   {
	    while($reg= mysql_fetch_row($infc))
		{
		  $sw=1;
		  $nomco=$reg[1];
		  $telfco=$reg[2];
		 }
	   }
	 ?>
	<tr>
	     <td  class="etiqueta">Persona contacto :</td><td class="texto"><?php  if($sw==0) echo "<input type='text' class='texto' size='70'  name='nomco' id='nomco' value='".$_POST["nomco"]."' />"; else { echo $nomco; echo "<input type='hidden' name='nomco' id='nomco' value=''/>";}?></td>
	</tr>
	<tr>
	     <td  class="etiqueta">Telefono persona contacto :</td><td class="texto"><?php  if($sw==0) echo "<input type='text' class='texto'  name='telfco' id='telfco' value='".$_POST["telfco"]."'/>"; else { echo $telfco; echo "<input type='hidden' name='nomco' id='nomco' value=''/>";}?></td>
	</tr>
	<tr>
	  <td colspan="2" class="etiqueta">Indique tipo de paciente :
	     <input name="titular" id="titular"  type="checkbox"  onclick="buscar()" <?php  if(isset($_POST['titular']) || $activatitu=='1'){ echo "checked='checked'"; } ?>/>Titular 
	     <input name="beneficiario" id="beneficiario"  type="checkbox"  onclick="buscar()"  <?php  if(isset($_POST['beneficiario']) || $activabene=='1'){ echo "checked='checked'"; } ?> />Beneficiario
	  </td>
	</tr>
	<?php 
	 if(isset($_POST['beneficiario']) || $activabene=='1')
	  {	   
	   $infc=$ben->cons_beneficiario($ced);
	   if($infc)
	   { 
	      $benefe=explode('**',$infc);
		  $_POST['cedtit']=$benefe[0]; 
		  $_POST['nomtit']=$benefe[2];
		  $_POST['teltit']=$benefe[3];
	   }
	  ?>
	  <tr>
	     <td  class="etiqueta">Cedula del titular :</td><td> <input type="text" class="texto" name="cedtit" id="cedtit" value="<?php  echo $_POST["cedtit"];?>" /></td>
	  </tr>
	  <tr>
	     <td  class="etiqueta">Nombre del titular : </td><td><input type="text" class="texto" name="nomtit" id="nomtit" value="<?php  echo $_POST["nomtit"];?>"/></td>
	  </tr>
	  <tr>
	     <td  class="etiqueta">Telefono del titular : </td><td><input type="text" class="texto" name="teltit" id="teltit" value="<?php  echo $_POST["teltit"];?>"/></td>
	  </tr>
	  
	  <?php 
	  }
	   if($_POST['codemp']=='226'){
	?>
	<tr>
	  <td class="etiqueta">Clave de Aprobacion :</td><td class="textoN"><input type="text" class="texto" name="keyacc" id="keyacc" value="<?=$_POST['keyacc'];?>"/></td>
	</tr>
	<tr>
	  <td class="etiqueta">Responsable :</td><td class="textoN"><input size="100" type="text" class="texto" name="resacc" id="resacc" value="<?=$_POST['resacc'];?>"/></td>
	</tr>
	<?php  }?>
    <tr>
      <td colspan="2" class="mensaje"><strong>Puede Seleccionar un servicio que est&eacute; p&eacute;ndiente en una visita o crear una nueva visita </strong></td>
    </tr>
    <tr class="titulorep">
      <td colspan="2">Datos de la  Visita </td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo de Visita:</td>
      <td class="texto"><label>
        <select name="mot" class="texto" id="mot">
          <option value="0" selected="selected" >Seleccione--></option>
          <option value="Egreso">Egreso</option>
          <option value="Ingreso">Ingreso</option>
          <option value="Periodico">Periodico</option>
          <option value="Post-vacacional">Post-vacacional</option>
          <option value="Pre-empleo">Pre-empleo</option>
          <option value="Pre-vacacional">Pre-vacacional</option>
        </select><script> document.getElementById("mot").value="<?php  echo $mt; ?>"; </script>
        <span class="Estilo2">*</span></label></td>
    </tr>

    <tr>
      <td class="etiqueta">M&eacute;dico/Especialista:</td>
      <td class="texto">
        <select name="esp" class="texto" id="esp">
          <option value="0" selected="selected" >Seleccione--></option>
          <?php   if ($ref->combo_medico()!= false)
		        echo $ref->combo_medico(); ?>
        </select><script> document.getElementById("esp").value="<?php  echo $es; ?>"; </script></td>
    </tr>
    <tr>
      <td class="etiqueta">Nro. Factura:</td>
      <td class="texto"><label>
        <input name="fac" type="text" class="texto" id="fac" accesskey="F2" size="15"  value="<?php  echo $fact; ?>"/>
        <span class="Estilo1">indique el n&uacute;mero de Factura que cancela este Servicio.      </span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Servicio:</td>
      <td class="texto"><span class="Estilo2">
        <select name="ser" class="texto" id="ser"  onchange="ver();"  <?php  echo  $_POST["disab"]; ?>>
          <option value="0" selected="selected" >Seleccione--></option>
          <?php   if ($ser->combo_servicios()!= false)
		        echo $ser->combo_servicios(); ?>
        </select><script>document.getElementById("ser").value="<?php  echo $val; ?>"; </script>
      </span></td>
    </tr>
    <tr>
      <td colspan="2">
          <?php 	  	
if ($_POST["ocuser"]>'0' && ($_POST["ocu_N"]=='0' || $_POST["ocu_N"]==''))	//LISTAR PRODUCTO DE UN SERVICIO EN UNA NUEVA VISITA
{
$serviprod2=$ser->consul_prod_serv(); 
$n2=mysql_num_rows($serviprod2);
if ($n2>'0') 
{$indi2=0;
?><table width="600" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr class="titulorep" align="center">
            <td width="20">&nbsp;</td>
            <td width="380">Servicios Asociados </td>
            <td width="100">Precio </td>
          </tr>
<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php  echo $n2;?>" />
<?php 
while ($row2=mysql_fetch_array($serviprod2))
{ 
  $nocodigo='nocodcar'.$indi2;
  $nocodigoch='nocodcarch'.$indi2;
  if ($indi2%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
?>
          <tr class="texto" <?php  echo $color; ?>  >
            <td width="20">
              <input name="<?php  echo $nocodigo;?>" id="<?php  echo $nocodigo;?>" type="hidden" value="<?php  echo $row2[4]; ?>" />
              <input name="<?php  echo $nocodigoch;?>" id="<?php  echo $nocodigoch;?>"  type="checkbox" value="<?php  echo $row2[4]; ?>" /></td>
            <td><?php  echo $row2[0]; ?></td>
            <td>
              <div align="right"><?php  echo $row2[1]; ?></div></td>
          </tr>
          <?php  
$indi2++; 
 } ?>
        </table><?php  }}
if ($_POST["ocuser"]>'0' && $_POST["ocu_N"]>'0')	///LISTAR PRODUCTOS DE UN VISITA PENDIENTE
{
$serviprod2=$vis->consul_det_vis($_POST["ocu_N"]); 
$n2=mysql_num_rows($serviprod2);
if ($n2>'0') 
{$indi2=0;
?><table width="600" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr class="titulorep" align="center">
            <td width="20">&nbsp;</td>
            <td width="380">Servicios Asociados </td>
            <td width="100">Precio </td>
			<td width="20">&nbsp;</td>
			<td width="150">Estado </td>
          </tr>
<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php  echo $n2;?>" />
<?php 
while ($row2=mysql_fetch_array($serviprod2))
{ 
  $nocodigo='nocodcar'.$indi2;
  $nocodigoch='nocodcarch'.$indi2;
  $nostatus='stat'.$indi2;
  $noser='servi'.$indi2;
  $fuente='';
    if($row2[3]=='P')
	{$status='Pendiente'; 
	$fuente='class="mensaje"';
	$che='';} 
if($row2[3]=='L')
	{$status='Lista de Espera'; 
	 $fuente='class="azul"';
	$che='checked="checked"';}
if($row2[3]=='A')
	{$status='Atendido'; 
	 $fuente='class="verde"';
	$che='style="display:none"';}
if($row2[3]=='I')
	{$status='Incompleto'; 
	 $fuente='class="naranja"';
	$che='';}
if($row2[3]=='E')
	{$status='Eliminado'; 
	 $fuente='class="textoN"';
	$che='style="display:none"';}
  if ($indi2%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
?>
          <tr  class="texto" <?php  echo $color; ?> >
            <td width="20">
              <input name="<?php  echo $nocodigo;?>" id="<?php  echo $nocodigo;?>" type="hidden" value="<?php  echo $row2[0]; ?>" />
              <input name="<?php  echo $nocodigoch;?>" id="<?php  echo $nocodigoch;?>"  type="checkbox" <?php  echo $che;?> value="<?php  echo $row2[0]; ?>" / ></td>
            <td><?php  echo $row2[1]; ?></td>
            <td>
              <div align="right"><?php  echo $row2[2]; ?></div></td>
			  <td width="20">&nbsp;</td>
			<td><input name="<?php  echo $nostatus;?>" id="<?php  echo $nostatus;?>" type="hidden" value="<?php  echo $row2[3]; ?>" />
			<input name="<?php  echo $noser;?>" id="<?php  echo $noser;?>" type="hidden" value="<?php  echo $row2[5]; ?>" />
              <div <?php  echo $fuente?> align="left"><?php  echo $status; ?></div></td>
          </tr>
          <?php  
$indi2++; 
 } ?>
        </table><?php  }} 
?></td>
    </tr>
    <tr <?php  echo $mosvis; ?>>
      <td colspan="2" class="titulorep">Visitas por Concluir </td>
    </tr>
    <tr>
      <td colspan="2" class="etiqueta"><?php  echo $vispen; ?></td>
    </tr>
    
    <tr>
      <td colspan="2" class="td-buttons">
	  <div id="cargar" align="center">
		  <a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

      </div>
		<input name="ocu_g" type="hidden" value="0"/>
        <input type="hidden" name="ocu_b" value="0" />
        <input name="ocuser" type="hidden" id="ocuser" value="<?php  echo $_POST["ocuser"]; ?>" />
        <input name="ocu_N" type="hidden" id="ocu_N" value="<?php  echo $_POST["ocu_N"]; ?>" />
        <input name="ocu_e" type="hidden" id="ocu_e" value="0" />
        <input name="disab" type="hidden" id="disab" value="0" />
        <input name="codemp" type="hidden" id="codemp" value="<?php  echo $codemp; ?>"/>
		<input name="ocuid" type="hidden" id="ocuid" value="<?php  echo $idpac; ?>"/>
      </td>
    </tr>
  </table>
  <table width="299" border="0" align="center" <?php  echo $mosobs; ?>>
    <tr class="titulorep">
      <td><div align="center">Indique el Motivo de la Eliminaci&oacute;n de la visita </div></td>
    </tr>
    <tr>
      <td><label>
        <textarea name="obser" cols="50" class="texto" id="obser"></textarea>
        <span class="Estilo2">*</span></label></td>
    </tr>
    <tr>
      <td class="mensaje">Recuerde que la visita no puede ser eliminada si ha sido parcialmente Atendida </td>
    </tr>
    <tr>
      <td class="td-buttons"> <div align="center">
      <a href="#" onclick="eliminar_conobs();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>
      <a href="#" onclick="salir();" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
