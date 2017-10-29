<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
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
  
  if (document.getElementById("servicio").value!='' || document.getElementById("cedula").value!='') {
	
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
		
		document.getElementById("ingreso").value=1;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		document.form1.submit();
	
} else alert('Debe ingresar el servicio o la cedula');
}

function ir_orden_pac(val)
{
  if(val=='S')
  {
		   document.form1.action="orden_pac.php";
		   document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
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

function inac_vis(visit)
{
	if(confirm("¿Desea Eliminar el registro Seleccionado?"))
	{
		document.getElementById("elimvis").value=visit;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		document.form1.submit();
	}
}

</script>
<body>
<?php  if ($_POST["primera"]=='')
 {
   //// buscar el id de menu que le corresponde esta pagina
   $men= new menu('', '', '', 'listado_pac.php', '','', '', '');
   $_POST["primera"]=$men->buscar_idmenu();
   $per= new permisologia('', $_POST["primera"], $_SESSION["cedu_usu"],'','','','','');
   $_POST["busper"]=$per->buscar_permisos();
   ////////////////////////////////////////////////////////// 
 }
 ?>
<form name="form1" id="form1" method="post" action="">
<input name="ingreso" id="ingreso" type="hidden" value="0" />

<?php  /////////////////////////Mostrar u ocultar Botones///////////////////////////
  $ope1='style="display:none"'; 
  $ope4='style="display:none"';
  $ope5='style="display:none"';
  $ope2='style="display:none"';

   if ($_POST["busper"]!='FALSE')
  { 
    	$vecper=explode('**',$_POST["busper"]); 
  
		/*if ($vecper[0]=='1')//puede guardar
		{
			$ope1='';
			$pgu='1';
		}*/
		if ($vecper[1]=='1') //puede consultar
		{
			$ope2='';
		}
		if ($vecper[2]=='1')//puede modificar
		{
			$ope1='';
			$pmo='1';
		}
		if ($vecper[3]=='1')// puede eliminar
			$ope4='';
			
		if ($vecper[4]=='1')//puede listar
		{	
			$ope5='';
		}	
	
  }

 /////////////////////////////////////////////////////////////////////////////
 ?>
	   		<table width="520" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="3"><div align="center" class="titulofor">Busqueda de Expediente </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="5">
				<table width="520" border="0" cellpadding="0" cellspacing="0">
                  <tr class="textoN">
                    <td width="160" height="22">DESDE</td>
                    <td width="160">HASTA</td>
                    <td  width="160">PACIENTE</td>
                  </tr>
                  <tr>
                    <td>
					<?php 
					  if($_POST['fna1']=="") $_POST['fna1']=substr(date('d-m-Y'),0,2);
					  if($_POST['fna2']=="") $_POST['fna2']=substr(date('d-m-Y'),3,2);
					  if($_POST['fna3']=="") $_POST['fna3']=substr(date('d-m-Y'),6,4);
					  if($_POST['fnf1']=="") $_POST['fnf1']=substr(date('d-m-Y'),0,2);
					  if($_POST['fnf2']=="") $_POST['fnf2']=substr(date('d-m-Y'),3,2);
					  if($_POST['fnf3']=="") $_POST['fnf3']=substr(date('d-m-Y'),6,4);  
					  ?>
					<select name="fna1" class="texto" id="fna1">
          <option value="">--</option>
		      <option value="01" <?php  if($_POST['fna1']=="01")echo "selected='selected'";?>>01</option>
          <option value="02" <?php  if($_POST['fna1']=="02")echo "selected='selected'";?>>02</option>
          <option value="03" <?php  if($_POST['fna1']=="03")echo "selected='selected'";?>>03</option>
          <option value="04" <?php  if($_POST['fna1']=="04")echo "selected='selected'";?>>04</option>
          <option value="05" <?php  if($_POST['fna1']=="05")echo "selected='selected'";?>>05</option>
          <option value="06" <?php  if($_POST['fna1']=="06")echo "selected='selected'";?>>06</option>
          <option value="07" <?php  if($_POST['fna1']=="07")echo "selected='selected'";?>>07</option>
          <option value="08" <?php  if($_POST['fna1']=="08")echo "selected='selected'";?>>08</option>
          <option value="09" <?php  if($_POST['fna1']=="09")echo "selected='selected'";?>>09</option>
          <option value="10" <?php  if($_POST['fna1']=="10")echo "selected='selected'";?>>10</option>
          <option value="11" <?php  if($_POST['fna1']=="11")echo "selected='selected'";?>>11</option>
          <option value="12" <?php  if($_POST['fna1']=="12")echo "selected='selected'";?>>12</option>
          <option value="13" <?php  if($_POST['fna1']=="13")echo "selected='selected'";?>>13</option>
          <option value="14" <?php  if($_POST['fna1']=="14")echo "selected='selected'";?>>14</option>
          <option value="15" <?php  if($_POST['fna1']=="15")echo "selected='selected'";?>>15</option>
          <option value="16" <?php  if($_POST['fna1']=="16")echo "selected='selected'";?>>16</option>
          <option value="17" <?php  if($_POST['fna1']=="17")echo "selected='selected'";?>>17</option>
          <option value="18" <?php  if($_POST['fna1']=="18")echo "selected='selected'";?>>18</option>
          <option value="19" <?php  if($_POST['fna1']=="19")echo "selected='selected'";?>>19</option>
          <option value="20" <?php  if($_POST['fna1']=="20")echo "selected='selected'";?>>20</option>
          <option value="21" <?php  if($_POST['fna1']=="21")echo "selected='selected'";?>>21</option>
          <option value="22" <?php  if($_POST['fna1']=="22")echo "selected='selected'";?>>22</option>
          <option value="23" <?php  if($_POST['fna1']=="23")echo "selected='selected'";?>>23</option>
          <option value="24" <?php  if($_POST['fna1']=="24")echo "selected='selected'";?>>24</option>
          <option value="25" <?php  if($_POST['fna1']=="25")echo "selected='selected'";?>>25</option>
          <option value="26" <?php  if($_POST['fna1']=="26")echo "selected='selected'";?>>26</option>
          <option value="27" <?php  if($_POST['fna1']=="27")echo "selected='selected'";?>>27</option>
          <option value="28" <?php  if($_POST['fna1']=="28")echo "selected='selected'";?>>28</option>
          <option value="29" <?php  if($_POST['fna1']=="29")echo "selected='selected'";?>>29</option>
          <option value="30" <?php  if($_POST['fna1']=="30")echo "selected='selected'";?>>30</option>
          <option value="31" <?php  if($_POST['fna1']=="31")echo "selected='selected'";?>>31</option>
        </select>
			/
<select name="fna2" class="texto" id="fna2">
  <option value="">--</option>
  <option value="01" <?php  if($_POST['fna2']=="01")echo "selected='selected'";?>>01</option>
  <option value="02" <?php  if($_POST['fna2']=="02")echo "selected='selected'";?>>02</option>
  <option value="03" <?php  if($_POST['fna2']=="03")echo "selected='selected'";?>>03</option>
  <option value="04" <?php  if($_POST['fna2']=="04")echo "selected='selected'";?>>04</option>
  <option value="05" <?php  if($_POST['fna2']=="05")echo "selected='selected'";?>>05</option>
  <option value="06" <?php  if($_POST['fna2']=="06")echo "selected='selected'";?>>06</option>
  <option value="07" <?php  if($_POST['fna2']=="07")echo "selected='selected'";?>>07</option>
  <option value="08" <?php  if($_POST['fna2']=="08")echo "selected='selected'";?>>08</option>
  <option value="09" <?php  if($_POST['fna2']=="09")echo "selected='selected'";?>>09</option>
  <option value="10" <?php  if($_POST['fna2']=="10")echo "selected='selected'";?>>10</option>
  <option value="11" <?php  if($_POST['fna2']=="11")echo "selected='selected'";?>>11</option>
  <option value="12" <?php  if($_POST['fna2']=="12")echo "selected='selected'";?>>12</option>
</select>
/<input name="fna3" type="text" class="texto" id="fna3"  value="<?php  echo $_POST['fna3'];?>" onChange="ver1()" onkeypress='return soloNumeros(event)' size="4" maxlength="4">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_fi" id="ocu_fi" type="hidden" value="" />
					</td>
                    <td>
					<select name="fnf1" class="texto" id="fnf1">
          <option value="">--</option>
		      <option value="01" <?php  if($_POST['fnf1']=="01")echo "selected='selected'";?>>01</option>
          <option value="02" <?php  if($_POST['fnf1']=="02")echo "selected='selected'";?>>02</option>
          <option value="03" <?php  if($_POST['fnf1']=="03")echo "selected='selected'";?>>03</option>
          <option value="04" <?php  if($_POST['fnf1']=="04")echo "selected='selected'";?>>04</option>
          <option value="05" <?php  if($_POST['fnf1']=="05")echo "selected='selected'";?>>05</option>
          <option value="06" <?php  if($_POST['fnf1']=="06")echo "selected='selected'";?>>06</option>
          <option value="07" <?php  if($_POST['fnf1']=="07")echo "selected='selected'";?>>07</option>
          <option value="08" <?php  if($_POST['fnf1']=="08")echo "selected='selected'";?>>08</option>
          <option value="09" <?php  if($_POST['fnf1']=="09")echo "selected='selected'";?>>09</option>
          <option value="10" <?php  if($_POST['fnf1']=="10")echo "selected='selected'";?>>10</option>
          <option value="11" <?php  if($_POST['fnf1']=="11")echo "selected='selected'";?>>11</option>
          <option value="12" <?php  if($_POST['fnf1']=="12")echo "selected='selected'";?>>12</option>
          <option value="13" <?php  if($_POST['fnf1']=="13")echo "selected='selected'";?>>13</option>
          <option value="14" <?php  if($_POST['fnf1']=="14")echo "selected='selected'";?>>14</option>
          <option value="15" <?php  if($_POST['fnf1']=="15")echo "selected='selected'";?>>15</option>
          <option value="16" <?php  if($_POST['fnf1']=="16")echo "selected='selected'";?>>16</option>
          <option value="17" <?php  if($_POST['fnf1']=="17")echo "selected='selected'";?>>17</option>
          <option value="18" <?php  if($_POST['fnf1']=="18")echo "selected='selected'";?>>18</option>
          <option value="19" <?php  if($_POST['fnf1']=="19")echo "selected='selected'";?>>19</option>
          <option value="20" <?php  if($_POST['fnf1']=="20")echo "selected='selected'";?>>20</option>
          <option value="21" <?php  if($_POST['fnf1']=="21")echo "selected='selected'";?>>21</option>
          <option value="22" <?php  if($_POST['fnf1']=="22")echo "selected='selected'";?>>22</option>
          <option value="23" <?php  if($_POST['fnf1']=="23")echo "selected='selected'";?>>23</option>
          <option value="24" <?php  if($_POST['fnf1']=="24")echo "selected='selected'";?>>24</option>
          <option value="25" <?php  if($_POST['fnf1']=="25")echo "selected='selected'";?>>25</option>
          <option value="26" <?php  if($_POST['fnf1']=="26")echo "selected='selected'";?>>26</option>
          <option value="27" <?php  if($_POST['fnf1']=="27")echo "selected='selected'";?>>27</option>
          <option value="28" <?php  if($_POST['fnf1']=="28")echo "selected='selected'";?>>28</option>
          <option value="29" <?php  if($_POST['fnf1']=="29")echo "selected='selected'";?>>29</option>
          <option value="30" >30</option>
          <option value="31" >31</option>
        </select>
		/
<select name="fnf2" class="texto" id="fnf2">
  <option value="">--</option>
  <option value="01" <?php  if($_POST['fnf2']=="01")echo "selected='selected'";?>>01</option>
  <option value="02" <?php  if($_POST['fnf2']=="02")echo "selected='selected'";?>>02</option>
  <option value="03" <?php  if($_POST['fnf2']=="03")echo "selected='selected'";?>>03</option>
  <option value="04" <?php  if($_POST['fnf2']=="04")echo "selected='selected'";?>>04</option>
  <option value="05" <?php  if($_POST['fnf2']=="05")echo "selected='selected'";?>>05</option>
  <option value="06" <?php  if($_POST['fnf2']=="06")echo "selected='selected'";?>>06</option>
  <option value="07" <?php  if($_POST['fnf2']=="07")echo "selected='selected'";?>>07</option>
  <option value="08" <?php  if($_POST['fnf2']=="08")echo "selected='selected'";?>>08</option>
  <option value="09" <?php  if($_POST['fnf2']=="09")echo "selected='selected'";?>>09</option>
  <option value="10" <?php  if($_POST['fnf2']=="10")echo "selected='selected'";?>>10</option>
  <option value="11" <?php  if($_POST['fnf2']=="11")echo "selected='selected'";?>>11</option>
  <option value="12" <?php  if($_POST['fnf2']=="12")echo "selected='selected'";?>>12</option>
</select>
/
<input name="fnf3" type="text" class="texto" id="fnf3"  value="<?php  echo $_POST['fnf3'];?>" onChange="ver2()" onkeypress='return soloNumeros(event)' size="4" maxlength="4">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_ff" id="ocu_ff" type="hidden" value="" />

					
					</td>
                    <td><input name="cedula" type="text" class="texto" id="cedula" size="15" /></td>
                  </tr>
				  <input name="empresa" type="hidden"  id="empresa" value="" />
				  <input name="medico" type="hidden"  id="medico" value="" />
				  <input name="estado" type="hidden"  id="estado" value="" />

                   
                 
                  <tr>
                     <td colspan="2"  height="30">
                     <span class="Estilo2"><strong>SERVICIO </strong></span>
          <?php   $ser= new servicio('','','','','','','','','','','',''); ?> 
            <select name="servicio" class="texto" id="servicio" >
              <option value="" >TODOS</option>
              <?php   if ($ser->combo_servicios()!= false)
                echo $ser->combo_servicios(); ?>
            </select>
            </td>
                  </tr>
                   <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
               		
			  <td colspan="5" class="td-btn"><div id="cargar" align="center">
				<a href="#" onclick="validar();" class="button-sort" alt="Ordenar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a></div>
				<input name="orden" id="orden" type="hidden" value="0" /></td>
			</tr>
		  </table>
	<?php    

	if($_POST['elimvis']!=0)
 	{
	  $vis= new visita($_POST['elimvis'],'','','','','','','','','','','','');
	  if($vis->mod_sta_visita_uni("E"))
	  	echo '<script>alert("Visita Eliminada con Exito")</script>';
	  else
	  	echo '<script>alert("Ocurrio un Error al Eliminar la Visita")</script>';
	}

	
	if($_POST['ingreso']==1)
 	{	

    	//$reg=$ser->listado_atenc( $_POST['ocu_fi'],$_POST['ocu_ff'],$_POST['servicio'],$_POST['cedula'],$_POST['estado'],$_POST['empresa'],$_POST['medico']);//echo 'entro a verificar';// aqui se modifica la busqueda por los parametros a seleccionar 
    	$ser= new servicio('','','','','','','','','','','','');
    	$reg=$ser->listado_atenc($_POST['ocu_fi'],$_POST['ocu_ff'],$_POST['servicio'],$_POST['cedula'],'','','');
    	$cont=0;
		if($reg!=false)
		{
		
			$titulo='LISTADO DE ATENCI&Oacute;N';
			if($_POST['ocu_fi']!='') $titulo.='<br>DESDE: '.$_POST['fna1'].'-'.$_POST['fna2'].'-'.$_POST['fna3'];
			if($_POST['ocu_ff']!='') $titulo.=' HASTA: '.$_POST['fnf1'].'-'.$_POST['fnf2'].'-'.$_POST['fnf3'];
			if($_POST['cedula']!='') $titulo.='<br>DEL PACIENTE: '.$_POST['cedula'];
			

		
	?> 
		  <table width="1040" align="center">
		    <tr >
			  <td width="1040" colspan="12" align="center" class="etiqueta"><input type="checkbox" name="log" />Imprimir con logo el documento</td>
			</tr>
		  	<tr class="titulofor">
			  <td width="1040" colspan="12" align="center"><?php  echo $titulo; ?></td>
			</tr>	
			<tr class="titulorep">
			  <td width="20">N°</td>
			  <td width="70">FECHA</td>
			  <td width="70">CEDULA</td>
			  <td width="150">NOMBRE</td>
			  <td width="150">EMPRESA</td>
			  <td width="150">SERVICIO</td>
			  <td width="140">MEDICO</td>
			  <td width="140">USUARIO</td>
			  <td width="90">ESTADO</td>
			  <td width="90">IMPRIMIR</td>
			</tr>	   
	   
<?php 		 $xy=0;  
         while ($row=mysql_fetch_array($reg))
		   { 
		      $xy++;
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
			 $emple= new empleado($row[14],'','','','','','','','','','','','','','','','','','');
			 $busemple=$emple->buscar_nom_emple();
			 
		   ?>
				<tr class="texto" <?php  echo $color; ?>>
				  <td width="20"><?php  echo $cont; ?></td>
				  <td width="70"><?php  echo $row[5]; ?></td>
				  <td width="70"><?php  echo $row[2]; ?></td>
				  <td width="150"><?php  echo $row[3]; ?></td>
				  <td width="150"><?php  echo $empresa; ?></td>
				  <td width="150"><?php  echo $row[11]; ?></td>
				  <td width="140"><?php  echo $row[10]; ?></td>
				  <td width="140"><?php  echo $busemple; ?></td>
				  <td width="90"><?php  echo $sta; ?></td>				  
				  <td width="90" align="center"><input type="checkbox" name="<?php   echo 'id'.$xy;?>"  /></td>
				</tr>
                  <input type="hidden" value="<?php   echo $row[0];?>"   name="<?php   echo 'ide'.$xy;?>" /> 
	<?php 		}  
	          echo "<input type='hidden' name='xy' value='".$xy."' id='xy'/>";?>
				<tr >
				  <td colspan="12" align="center" class="td-buttons">
<a href="#" onclick="irpdf('documentos_pdf.php?fi=<?php  echo $_POST['log'];?>&ff=<?php  echo $_POST['ocu_ff'];?>&serv=<?php  echo $_POST['servicio'];?>&ced=<?php  echo $_POST['cedula'];?>&sta=<?php  echo $_POST['estado'];?>&empr=<?php  echo $_POST['empresa'];?>&medi=<?php  echo $_POST['medico'];?>')"  class="button-print" alt="Imprimir"  <?php  echo $ope5;?> > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>

				<input name="consulta" id="consulta" type="hidden" value="<?php  echo $row; ?>" />
				<input name="titu" id="titu" type="hidden" value="<?php  echo $titulo; ?>" />
				<input name="elimvis" id="elimvis" type="hidden" value="0" />
				<input name="primera" type="hidden" id="primera" value="<?php  echo $_POST["primera"]; ?>" />
                <input name="busper" type="hidden" id="busper" value="<?php  echo $_POST["busper"]; ?>" />
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
