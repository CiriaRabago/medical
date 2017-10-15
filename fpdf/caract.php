<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_tipcar.php";
include "clases/clase_unimed.php";
include "clases/clase_caract.php";
include "clases/clase_bitacora.php";//
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
function Nuevo()
{  
	document.getElementById("comtip").value='0';
	document.getElementById("comuni").value='0';
	document.getElementById("nomb").value='';
	document.getElementById("descrip").value='';
	document.getElementById("valr").value='2';
	document.getElementById("vpn").value='2';
	document.getElementById("valo").value='2';
	document.getElementById("vall").value='2';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	if (document.getElementById("comtip").value!='0' && document.getElementById("comuni").value!='0' && document.getElementById("nomb").value!='' && document.getElementById("valr").value!='2' && document.getElementById("vpn").value!='2' && document.getElementById("valo").value!='2' && document.getElementById("vall").value!='2' && document.form1.ocu_N.value==0)
	{
		document.form1.ocu_g.value=1;
   		document.form1.submit();
	}
	if (document.getElementById("comtip").value!='0' && document.getElementById("comuni").value!='0' && document.getElementById("nomb").value!='' && document.getElementById("valr").value!='2' && document.getElementById("vpn").value!='2' && document.getElementById("valo").value!='2' && document.getElementById("vall").value!='2' && document.form1.ocu_N.value!=0)
	{
    	document.form1.ocu_g.value=2;
   		document.form1.submit();
	}
	 if (document.getElementById("comtip").value=='0' || document.getElementById("comuni").value=='0' || document.getElementById("nomb").value=='' || document.getElementById("valr").value=='2' || document.getElementById("vpn").value=='2' || document.getElementById("valo").value=='2' || document.getElementById("vall").value=='2' )
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("comuni").value= trozos[1];
	document.form1.ocuuni.value=trozos[1];
	document.getElementById("comtip").value=trozos[2];
	document.form1.ocutip.value=trozos[2];
	document.getElementById("nomb").value=trozos[3];
	document.form1.ocunom.value=trozos[3];
	document.getElementById("descrip").value=trozos[8];
	document.form1.ocudes.value=trozos[8];
	document.getElementById("valr").value=trozos[4];
	document.form1.ocuvr.value=trozos[4];
	document.getElementById("vpn").value=trozos[5];
	document.form1.ocuvpn.value=trozos[5];
	document.getElementById("valo").value=trozos[6];
	document.form1.ocuvo.value=trozos[6];
	document.getElementById("vall").value=trozos[7];
	document.form1.oculv.value=trozos[7];
	document.form1.ocu_N.value=trozos[0];
	document.form1.ocu_con.value=1;
}

function valores(cadena)
{
  //alert(cadena);
  var trozos = cadena.split("/*");
  //alert(trozos[4]);
  if(trozos[4]!="0" || trozos[7]!="0")
  {
     if(trozos[4]!="0")
	   document.form1.action='carval.php?car='+trozos[0]+'&nomb='+trozos[3]+'&val=1';
     if(trozos[7]!="0")
	   document.form1.action='carval.php?car='+trozos[0]+'&nomb='+trozos[3]+'&val=2';	
	 document.form1.submit();
  }
  else
	 alert('Debe indicar los tipos de valores asociados a esta caracteristica');
}

</script>
<body>
<?php 
	
 if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'caract.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   //-------------guardar el acceso a la página--------------//
   $bit= new bitacora('',$_SESSION["cedu_usu"],'','','caract.php','ING');
   $gbit=$bit->guardar_bitaco();
   //--------------------------------------------------------//
   ////////////////////////////////////////////////////////// 
 } 
?>
<form name="form1" id="form1" method="post" action="caract.php">
  <?php 
//--------------Guardar en Bitacora la Consulta--------------//
if(isset($_POST["ocu_con"]) && $_POST["ocu_con"]=='1' )
{
   $bit= new bitacora('',$_SESSION["cedu_usu"],'Id:'.$_POST["ocu_N"].' Unid:'.$_POST["ocuuni"].' Tip:'.$_POST["ocutip"].' Nomb:'.$_POST["ocunom"].' Vr:'.$_POST["ocuvr"].' Vpn:'.$_POST["ocuvpn"].' Vo:'.$_POST["ocuvo"].' Lv:'.$_POST["oculv"].' Desc:'.$_POST["ocudes"],'','caract.php','CON');
   $gbit=$bit->guardar_bitaco();
}
//---------------------------------------------------------------//

  
 $tip= new tipcar('','','');
 $uni= new unimed('','','');
    
  /////////////////////////Mostrar u ocultar Botones///////////////////////////
  $ope1='style="display:none"'; 
  $ope4='style="display:none"';
  $ope2=''; 

   if ($_POST["busper"]!='FALSE')
  { 
    	$vecper=explode('**',$_POST["busper"]); 
  
		if ($vecper[0]=='1')//puede guardar
		{
			$ope1='';
			$pgu='1';
		}
		if ($vecper[1]=='1') //puede consultar
		{
			$ope2='1';
		}
		if ($vecper[2]=='1')//puede modificar
		{
			$ope1='';
			$ope2='1';
			$pmo='1';
		}
		if ($vecper[3]=='1')// puede eliminar
			$ope4='';
			
		if ($vecper[4]=='1')//puede listar
		{	
			$ope5='1';
		}	
	
  }

 /////////////////////////////////////////////////////////////////////////////
 
$car= new caract($_POST["ocu_N"],$_POST["comuni"],$_POST["comtip"],$_POST["nomb"],$_POST["valr"],$_POST["vpn"],$_POST["valo"],$_POST["vall"],$_POST["descrip"]); 
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  {  
	$bus=$car->buscar();
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
	{
		if($pmo=='1')//
		{//
			$gua=$car->modf_caract();
			if ($gua)
			{
				//--------------Guardar en Bitacora la modificación--------------//
				   $bit= new bitacora('',$_SESSION["cedu_usu"],'Id:'.$_POST["ocu_N"].' Unid:'.$_POST["comuni"].' Tip:'.$_POST["comtip"].' Nomb:'.$_POST["nomb"].' Vr:'.$_POST["valr"].' Vpn:'.$_POST["vpn"].' Vo:'.$_POST["valo"].' Lv:'.$_POST["vall"].' Desc:'.$_POST["descrip"],'','caract.php','MOD');
   				   $gbit=$bit->guardar_bitaco();
				//---------------------------------------------------------------//
				echo '<script>alert("Registro Modificado Exitosamente");</script>';
			}
			else
				echo '<script>alert("El Registro no pudo ser Modificado");</script>';
		}//
		else //
			echo '<script>alert("No tiene permiso para modificar");</script>';//
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
	{
		if ($pgu=='1')//
		{//
			$gua=$car->ins_caract();
			if ($gua)
			{
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
				//--------------Guardar en Bitacora la Insercion--------------//
				   $bit= new bitacora('',$_SESSION["cedu_usu"],'Id:'.$_POST["ocu_N"].' Unid:'.$_POST["comuni"].' Tip:'.$_POST["comtip"].' Nomb:'.$_POST["nomb"].' Vr:'.$_POST["valr"].' Vpn:'.$_POST["vpn"].' Vo:'.$_POST["valo"].' Lv:'.$_POST["vall"].' Desc:'.$_POST["descrip"],'','caract.php','INS');
   				   $gbit=$bit->guardar_bitaco();
				//---------------------------------------------------------------//
			}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}//
		else//
			echo '<script>alert("No tiene permiso para registrar");</script>';//
	}
	}
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{	$re='';
		$gua=$car->bus_caract1();
		if ($gua!='false')
			$re=$gua;
		$gua=$car->bus_caract2();
		if ($gua!='false')
			$re=$re.', '.$gua;
		$gua=$car->bus_caract3();
		if ($gua!='false')
			$re=$re.' y '.$gua;		
		if ($re!='')
			echo '<script>alert("Registro No puede ser eliminado por tener '.$re.' asociados");</script>';
		else
		{
		$gua=$car->eliminar();
		if ($gua)
		{
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
			//--------------Guardar en Bitacora la Eliminacion--------------//
			   $bit= new bitacora('',$_SESSION["cedu_usu"],'Id:'.$_POST["ocu_N"].' Unid:'.$_POST["comuni"].' Tip:'.$_POST["comtip"].' Nomb:'.$_POST["nomb"].' Vr:'.$_POST["valr"].' Vpn:'.$_POST["vpn"].' Vo:'.$_POST["valo"].' Lv:'.$_POST["vall"].' Desc:'.$_POST["descrip"],'','caract.php','ELI');
			   $gbit=$bit->guardar_bitaco();
			//---------------------------------------------------------------//
		}
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
		}
	} 
 ?>
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Caracter&iacute;sticas</div></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo: </td>
      <td colspan="3" class="texto"><label>
        <select name="comtip" class="texto" id="comtip">
       <option value="0" selected="selected" >Seleccione -------&gt;</option>
		 <?php 
		 if ($tip->combo_tipcar()!= false)
		        echo $tip->combo_tipcar(); ?>
        </select>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocutip" type="hidden" id="ocutip" value="0" />
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Unidad de Medida:</td>
      <td colspan="3" class="texto"><label>
        <select name="comuni" class="texto" id="comuni">
		<option value="0" selected="selected" >Seleccione -------&gt;</option>
		 <?php 
		 if ($uni->combo_unimed()!= false)
		        echo $uni->combo_unimed(); ?>
        </select>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocuuni" type="hidden" id="ocuuni" value="0" />
      </label></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Nombre :</td>
      <td colspan="3" class="texto"><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50"  onkeypress='return sincomillas(event)'/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocunom" type="hidden" id="ocunom" value="0" />
      </label></td>
    </tr>
	<tr>
      <td width="197" class="etiqueta">Descripci&oacute;n :</td>
      <td colspan="3" class="texto"><label>
        <input name="descrip" type="text" class="texto" id="descrip" size="50" onkeypress='return sincomillas(event)'/>
        <input name="ocudes" type="hidden" id="ocudes" value="0" />
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Valores de Referencia Si/No:</td>
      <td colspan="3" class="texto"><label><span class="texto">
        <select name="valr" class="texto" id="valr">
          <option value="2">Seleccione--&gt;</option>
              <option value="1">Si</option>
              <option value="0">No</option>
        </select>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocuvr" type="hidden" id="ocuvr" value="0" />
      </span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Valores Positvo/Negativo <span class="etiqueta">Si/No:</span></td>
      <td colspan="3" class="texto"><label><span class="texto">
        <select name="vpn" class="texto" id="vpn">
          <option value="2">Seleccione--&gt;</option>
              <option value="1">Si</option>
              <option value="0">No</option>
        </select>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocuvpn" type="hidden" id="ocuvpn" value="0" />
      </span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Valores Observables <span class="etiqueta">Si/No:</span></td>
      <td colspan="3" class="texto"><label><span class="texto">
        <select name="valo" class="texto" id="valo">
          <option value="2">Seleccione--&gt;</option>
              <option value="1">Si</option>
              <option value="0">No</option>
        </select>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> 
        <input name="ocuvo" type="hidden" id="ocuvo" value="0" />
      </span></label></td>
    </tr>
    <tr>
      <td class="etiqueta">Lista de Valores <span class="etiqueta">Si/No:</span></td>
      <td colspan="3" class="texto"><label><span class="texto">
        <select name="vall" class="texto" id="vall">
              <option value="2">Seleccione--&gt;</option>
              <option value="1">Si</option>
              <option value="0">No</option>
        </select>
      </span></label>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo1">*
      <input name="oculv" type="hidden" id="oculv" value="0" />
      </span></span></td>
    </tr>
    <tr>
      <td colspan="4"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons">
      	
	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

      <input name="primera" type="hidden" id="primera" value="<?php echo $_POST["primera"]; ?>" />
      <input name="busper" type="hidden" id="busper" value="<?php echo $_POST["busper"]; ?>" />
      <input name="ocu_con" type="hidden" id="ocu_con" value="0" /></td>
    </tr>
  </table>
  <div>
    <?php 
	if ($ope2=='1')//
    { //
		$ver=$car->ver_caract();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Tipos de Caracteristicas');</script>";
		} 
		else
		{
		    echo $ver;
		}
	} //
	?>
  </div>
</form>
</body>
</html>
