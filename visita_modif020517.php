<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_referencia.php";
include "clases/clase_solicitud.php";
include "clases/clase_diagnostico.php";
include "clases/clase_empresa.php";
include "clases/clase_medico.php";
include "clases/clase_res_estudio.php";
$vis=$_GET['visi'];	
$ipaci=$_GET['idpac'];
$iemp=$_GET['idemp'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Modificar Visita</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<script>

function mostrarVentana()
{
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.marginTop = "100px"; // Definimos su posición vertical. La ponemos fija para simplificar el código
    ventana.style.marginLeft = ((document.body.clientWidth-350) / 2) +  "px"; // Definimos su posición horizontal
    ventana.style.display = 'block'; // Y lo hacemos visible
}

function ocultarVentana()
{
    var ventana = document.getElementById('miVentana'); // Accedemos al contenedor
    ventana.style.display = 'none'; // Y lo hacemos invisible
}
function guardaVis(sta)
{
	if(	(document.getElementById("ExaFis").value=='') && 
		(document.getElementById("ExaLab").value=='') && 
		(document.getElementById("DiagEsp").value=='') && 
		(document.getElementById("Tratam").value=='') && 
		(document.getElementById("Indic").value=='') && 
		(document.getElementById("Conclu").value=='') && 
		(document.getElementById("Recom").value=='') && 
		(document.getElementById("Repos").value=='') && 
		(document.getElementById("resuL_infor").value=='') && 
		(document.getElementById("razonVisita").value=='') )
	{    alert('No hay datos que guardar');	}
	else
	{ 
		document.getElementById("ocugua").value=1;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		document.form1.submit();
	} // Fin del else
} // Fin de funcion guardar visita

function marcar(v,e)
{
 if(v==false)
   document.form1[e].disabled=true;
 else
   document.form1[e].disabled=false;
}

function imprimir(ventana)
{
	window.open(ventana,'','width=700,height=450,resizable=yes,scrollbars=yes');
}


function mostrar(a)
{
	var b=parseInt(a)+1;
	var c=parseInt(a)+2;
	if (document.getElementById("DiagEsp"+a).value!='' && document.getElementById("TipoDiag"+a).value!='')
	{
		document.getElementById('elid'+a).style.display="block";
		var texto='<div id="a'+b+'"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="200">&nbsp;</td><td width="120">&nbsp;</td><td width="110">&nbsp;</td><td width="60">&nbsp;</td><td width="60">&nbsp;</td></tr><tr><td width="320" colspan="2"><input name="iddivi'+b+'" id="iddivi'+b+'" type="hidden" value="0"><select name="DiagEsp'+b+'" id="DiagEsp'+b+'" class="texto"><option value="">Seleccione el Diagnóstico</option>'+document.getElementById("ocucombo").value+'</select></td><td width="230" colspan="3"><select name="TipoDiag'+b+'" id="TipoDiag'+b+'" class="texto"><option value="">Seleccione tipo Diag.</option><option value="Enfermedad Comun">Enfermedad Comun</option><option value="Enfermedad Laboral">Enfermedad Laboral</option><option value="Accidente Comun">Accidente Comun</option><option value="Accidente Laboral">Accidente Laboral</option><option value="Discapacidad Certificada">Discapacidad Certificada</option></select></td></tr><tr><td width="430" colspan="3"><textarea name="detaDiag'+b+'" id="detaDiag'+b+'" cols="80" rows="2" class="texto"></textarea></td><td width="60" align="right"><img src="imagenes/add_16x16.gif" id="agred'+b+'" title="Agregar Diagnóstico" alt="Agregar Diagnóstico" onClick="mostrar('+b+');"></td><td width="60" align="left"><img src="imagenes/delete_16x16.gif" id="elid'+b+'" title="Eliminar Diagnóstico" alt="Eliminar Diagnóstico" onClick="elimdi('+b+');" style="display:none"></td></tr></table></div><div id="ddee'+c+'"></div>';
  		document.getElementById('ddee'+b).innerHTML=texto;
		document.getElementById("DiagEsp"+b).focus();
		document.getElementById('agred'+a).visible=false;
		var ela = document.getElementById('agred'+a);
		document.getElementById('cantidiag').value=b;
		var padre = ela.parentNode;
		padre.removeChild(ela);
	}	
	else
	{
 		alert('Debe seleccionar todo lo relacionado al diagnostico anterior');
	}	
}


function elimdi(x,di)
{
 
 document.getElementById('elidiag').value=document.getElementById('elidiag').value+'**'+di;
 
 x="a"+x;
// Obtenemos el elemento
var el = document.getElementById(x);
// Obtenemos el padre de dicho elemento
// con la propiedad “parentNode”
var padre = el.parentNode;
// Eliminamos el hijo (el) del elemento padre
padre.removeChild(el);
}
</script>

<body>
<form name="form1" id="form1" method="post" action="visita_modif.php">

<?php  
if($_POST['ocugua']==1)
{
		$vis=$_POST['oidvis'];
		$usu=$_SESSION['cedu_usu'];
		$visita= new visita($vis,'','','','',$_POST['mot'],$_POST['obsvis'],$_POST['Conclu'],'','',$usu,$_POST['esp'],$_POST['comemp']);
		$bagv=true;
		
		if($_POST['ocuguaemp']==1)
		{
			if($visita->mod_emp_visita()==false)
			{  	echo "<script>alert('Error al modificar la Empresa');</script>";
				$bagv=false;
			}
		}
		
		if($_POST['ocuguatipvis']==1)
		{
			if($visita->mod_mot_visita()==false)
			{  	echo "<script>alert('Error al modificar la Empresa');</script>";
				$bagv=false;
			}
		}		


		if($_POST['ocuguamedico']==1)
		{
			if($visita->mod_medico_visita()==false)
			{  	echo "<script>alert('Error al modificar el Medico de la Visita');</script>";
				$bagv=false;
			}
		}		
		
		if($visita->guardResVis($_POST['ExaFis'],$_POST['ExaLab'],$_POST['DiagEsp'],$_POST['Tratam'],$_POST['Indic'],$_POST['Recom'],$_POST['Repos'],$_POST['razonVisita'],$_POST['detaExaFis'],$_POST['detaDiag'])==false)
		{  	echo "<script>alert('Error al guardar los Resultados de la Visita\n Verifique los datos Guardados');</script>";
			$bagv=false;
		}
		
		if($bagv==true)
		{
			$vecde=explode('**',$_POST['elidiag']);
			$cantieli=count($vecde);
			for ($i=0;$i<$cantieli;$i++)
			{
				if($vecde[$i]!='')
				{ $visita->eliDiagVis($vecde[$i]); }
			} 

			$cantdi=$_POST['cantidiag'];
			for ($k=1;$k<=$cantdi;$k++)
			{	
				if($_POST['DiagEsp'.$k])
				 /* echo '<script>alert("va a imprimir '.$_POST['a'.$k].'**'.$_POST['iddivi'.$k].'**'.$_POST['DiagEsp'.$k].'")</script>';*/
				$visita->guardDiagVis($_POST['iddivi'.$k],$_POST['DiagEsp'.$k],$_POST['TipoDiag'.$k],$_POST['detaDiag'.$k]);
			}
		}
		
		
		if($bagv==true)
		{
			if($visita->ina_ref_vis()==false)
			{
			  	echo "<script>alert('Error al guardar las Referencias de la Visita\n Verifique los datos Guardados');</script>";
				$bagv=false;
			}
			if($bagv==true)
			{
				$cref=$_POST['ocref'];
				for ($j=1;$j<=$cref;$j++)
				{ 
					$numref='refe'.$j;
					$pref='preref'.$j;
					$obref='cmref'.$j;
					$cespe='codes'.$j;
					if($_POST[$numref])
					{
						if($visita->ins_ref_vis(substr($_POST[$numref],1),$_POST[$pref],$_POST[$obref],$_POST[$cespe])==false)
						{
							echo "<script>alert('Error al guardar las Referencias de la Visita Verifique los datos Guardados');</script>";
							$bagv=false;
						}	
					}
				}
			}
		} // Fin si guardo los resultados para guardar las referencias
		if($bagv==true)
		{
			if($visita->ina_sol_vis()==false)
			{
			  	echo "<script>alert('Error al guardar las Solicitudes de la Visita\n Verifique los datos Guardados');</script>";
				$bagv=false;
			}
			if($bagv==true)
			{
				$csol=$_POST['ocsol'];
				for ($k=1;$k<=$csol;$k++)
				{ 
					
					$numsol='soli'.$k;
					$psol='presol'.$k;
					$obsol='cmsol'.$k;
					if($_POST[$numsol])
					{
						if($visita->ins_sol_vis($_POST[$numsol],$_POST[$psol],$_POST[$obsol])==false)
						{
							echo "<script>alert('Error al guardar las Solicitudes de la Visita\n Verifique los datos Guardados');</script>";
							$bagv=false;
						}	
					}
				}
			}
		} // Fin si guardo los resultados para guardar las solicitudes
		//guardo el resultado de los estudios José Ramirez:::::::::::::::::::
		if($_POST['resuL_infor']!='')
		{
			
		$r_estu= new res_estudio('',$vis,$_POST['resuL_infor']);
		$bus_r_e=$r_estu->cons_res_estudio($vis);
			if ($bus_r_e!=false)
			{	
				
				$mod_r_e=$r_estu->mod_res_estudio($vis);
			}
			else
			{
				
				$ins_r_e=$r_estu->ins_reS_estudio();
			}
		}

$vis=$_POST['oidvis'];
$ipaci=$_POST['oidpac'];
$iemp=$_POST['comemp'];
}
 ?>

<input name="oidpac" id="oidpac" type="hidden" value="<?php  echo $ipaci; ?>" />
<input name="oidvis" id="oidvis" type="hidden" value="<?php  echo $vis; ?>" />

<table width="704" border="0" cellpadding="0" cellspacing="1">

  <?php  $visita= new visita($vis,'','','','','','','','','','','','');
     $dpac=$visita->datos_pac_vis($ipaci);
	 if($dpac!='false') 
	 {
	 	 $rowp=mysql_fetch_array($dpac);
	     if ($rowp[3]=='F') $sexo='Femenino';
		 if ($rowp[3]=='M') $sexo='Masculino';
	 
	 } ?>

	<tr>
	  <td width="150" class="textoN">CÉDULA:</td>
      <td width="551" colspan="2" class="texto"><?php  echo $rowp[1]; ?></td>
	</tr>
	<tr>
	  <td width="150" class="textoN">NOMBRE:</td>
      <td width="551" colspan="2" class="texto"><?php  echo $rowp[2]; ?></td>
	</tr>	
	<tr>
	  <td width="150" class="textoN">EDAD:</td>
      <td width="551" colspan="2" class="texto"><?php  echo $rowp[4]; ?></td>
	</tr>
	<tr>
	  <td width="150" class="textoN">SEXO:</td>
      <td width="551" colspan="2" class="texto"><?php  echo $sexo; ?></td>
	</tr>
  <tr>
   <td width="150" class="textoN">EMPRESA:</td>
      <td width="551" colspan="2">
	  <select name="comemp" class="texto" id="comemp" onChange="document.getElementById('ocuguaemp').value=1;">
        <option value="0" selected="selected">Particular</option>
        <?php   
		 $emp= new empresa('','','','','','','','','','');
		 $empre=$emp->combo_emp($iemp);
		 if ($empre!= false)
		        echo $empre; ?>
      </select>
	  <input name="ocuguaemp" id="ocuguaemp" type="hidden" value="0">
	  </td>
  </tr>
    <?php  $rv=$visita->ver_result_vis();
     if($rv!=false)
	   $rowr=mysql_fetch_array($rv);
   ?> 
  <tr>
    <td width="150" class="textoN">TIPO DE VISITA:</td>
      <td width="551" colspan="2">
          <select name="mot" class="texto" id="mot" onChange="document.getElementById('ocuguatipvis').value=1;">
          <option value="0" selected="selected" >Seleccione--></option>
          <option value="Egreso" <?php  if($rowr[13]=="Egreso") echo 'selected'; ?> >Egreso</option>
          <option value="Ingreso" <?php  if($rowr[13]=="Ingreso") echo 'selected'; ?> >Ingreso</option>
          <option value="Periodico" <?php  if($rowr[13]=="Periodico") echo 'selected'; ?>>Periodico</option>
          <option value="Post-vacacional" <?php  if($rowr[13]=="Post-vacacional") echo 'selected'; ?>>Post-vacacional</option>
          <option value="Pre-empleo" <?php  if($rowr[13]=="Pre-empleo") echo 'selected'; ?> >Pre-empleo</option>
          <option value="Pre-vacacional" <?php  if($rowr[13]=="Pre-vacacional") echo 'selected'; ?>>Pre-vacacional</option>
      </select>	
	  <input name="ocuguatipvis" id="ocuguatipvis" type="hidden" value="0">
    </td>
  </tr>
  <tr>
    <td width="150" class="textoN">MEDICO TRATANTE:</td>
      <td width="551" colspan="2">
	  <?php   
		$med= new medico('','','','','','','','','','','','','','','');
	  ?>
	  <select name="esp" class="texto" id="esp" onChange="document.getElementById('ocuguamedico').value=1;">
          <option value="0" selected="selected" >Seleccione--></option>
          <?php   if ($med->combo_medico()!= false)
		        echo $med->combo_medico(); ?>
        </select>
		<script> document.getElementById("esp").value="<?php  echo $rowr[14]; ?>"; </script>
		<input name="ocuguamedico" id="ocuguamedico" type="hidden" value="0">
      </td>
  </tr>
  <tr>
    <td  height="30" colspan="3"  align="center" class="titulofor">RESULTADOS DE LA VISITA</td>
  </tr>
  <?php  $rv=$visita->ver_result_vis();
     if($rv!=false)
	   $rowr=mysql_fetch_array($rv);
   ?> 
  <tr>
    <td width="150" class="textoN">Motivo de la Visita</td>
    <td width="551" colspan="2"><textarea name="razonVisita" id="razonVisita" cols="90" rows="3" class="texto"><?php  if($rowr[10]!="") echo $rowr[10]; ?></textarea></td>
  </tr>
  <tr>
    <td width="150" class="textoN">Examen F&iacute;sico </td>
    <td width="551" colspan="2"><select name="ExaFis" class="texto" id="ExaFis">
	  <option value=" <?php  if($rowr[0]=="") echo 'selected'; ?> ">Seleccione</option>
      <option value="Buenas Condiciones Generales" <?php  if($rowr[0]=="Buenas Condiciones Generales") echo 'selected'; ?> >Buenas Condiciones Generales</option>
      <option value="Regulares Condiciones Generales" <?php  if($rowr[0]=="Regulares Condiciones Generales") echo 'selected'; ?> >Regulares Condiciones Generales</option>
      <option value="Malas Condiciones Generales" <?php  if($rowr[0]=="Malas Condiciones Generales") echo 'selected'; ?> >Malas Condiciones Generales</option>
      <option  value="Satisfactorio" <?php  if($rowr[0]=="Satisfactorio") echo 'selected'; ?> >Satisfactorio</option>
      <option value="En Estudio" <?php  if($rowr[0]=="En Estudio") echo 'selected'; ?> >En Estudio</option>
      <option value="No Satisfactorio" <?php  if($rowr[0]=="No Satisfactorio") echo 'selected'; ?> >No Satisfactorio</option>
    </select></td>
  </tr>
  <tr>
    <td width="150" class="textoN">Comentario Examen F&iacute;sico</td>
    <td width="551" colspan="2"><textarea name="detaExaFis" id="detaExaFis" cols="90" rows="3" class="texto"><?php  if($rowr[11]!="") echo $rowr[11]; ?></textarea></td>
  </tr>
  <tr>
    <td class="textoN">Examen de Laboratorio </td>
    <td colspan="2"><select name="ExaLab" class="texto" id="ExaLab">
	  <option value=""  <?php  if($rowr[1]=="") echo 'selected'; ?> >Seleccione</option>
      <option value="Satisfactorio" <?php  if($rowr[1]=="Satisfactorio") echo 'selected'; ?> >Satisfactorio</option>
      <option value="En Estudio" <?php  if($rowr[1]=="En Estudio") echo 'selected'; ?> >En Estudio</option>
      <option value="No Satisfactorio" <?php  if($rowr[1]=="No Satisfactorio") echo 'selected'; ?> >No Satisfactorio</option>
    </select>
	</td>
  </tr>
  <?php   $cantidiag=1;
      $printdiag='';
  	  $diag= new diagnostico('','','');
	  $dvs=$visita->ver_diag_vis();

		if($dvs!=false)
		{
			$n=mysql_num_rows($dvs);		
		 	$contdi=0;
		   	$printdiag.='<tr>
				<td class="textoN">Diagn&oacute;stico y Comentario </td>
				<td colspan="2" class="textoN">';
			while($rowdv=mysql_fetch_array($dvs))
			{ 
				$contdi=$contdi+1;
				$dg=$diag->combo_diag($rowdv[1]);
				if ($dg!=false) $dgact=$dg;
					
				if($n==$contdi)
				{	$impagre='style="display:block"'; $impeli='style="display:none"';  }
				else
				{	$impagre='style="display:none"'; $impeli='style="display:block"'; }
					
				if($rowdv[2]=='Enfermedad Comun') 
					$ec='<option value="Enfermedad Comun" selected>Enfermedad Comun</option>';
				else
					$ec='<option value="Enfermedad Comun">Enfermedad Comun</option>';
					
				if($rowdv[2]=='Enfermedad Laboral') 
					$el='<option value="Enfermedad Laboral" selected>Enfermedad Laboral</option>';
				else
					$el='<option value="Enfermedad Laboral">Enfermedad Laboral</option>';
					
				if($rowdv[2]=='Accidente Comun') 
					$ac='<option value="Accidente Comun" selected>Accidente Comun</option>';
				else
					$ac='<option value="Accidente Comun">Accidente Comun</option>';
					
				if($rowdv[2]=='Accidente Laboral') 
					$al='<option value="Accidente Laboral" selected>Accidente Laboral</option>';
				else
					$al='<option value="Accidente Laboral">Accidente Laboral</option>';

				if($rowdv[2]=='Discapacidad Certificada') 
					$dc='<option value="Discapacidad Certificada" selected>Discapacidad Certificada</option>';
				else
					$dc='<option value="Discapacidad Certificada">Discapacidad Certificada</option>';
										
				$printdiag.='<div id="ddee'.$contdi.'"><div id="a'.$contdi.'">
					<table cellpadding="0" cellspacing="0" border="0">
					  <tr><td width="200">&nbsp;</td><td width="120">&nbsp;</td><td width="110">&nbsp;</td><td width="60">&nbsp;</td><td width="60">&nbsp;</td></tr>
					  <tr>
						<td width="320" colspan="2">
						  <input name="iddivi'.$contdi.'" id="iddivi'.$contdi.'" type="hidden" value="'.$rowdv[0].'">
						  <select name="DiagEsp'.$contdi.'" id="DiagEsp'.$contdi.'" class="texto">
							<option value="">Seleccione el Diagnóstico</option>'.$dgact.'</select>
						</td>
						<td width="230" colspan="3">
						  <select name="TipoDiag'.$contdi.'" id="TipoDiag'.$contdi.'" class="texto">
							<option value="">Seleccione tipo Diag.</option>'.$ec.$el.$ac.$al.$dc.'
						  </select>
						</td>
					  </tr>
					  <tr>
						<td width="430" colspan="3"><textarea name="detaDiag'.$contdi.'" id="detaDiag'.$contdi.'" cols="80" rows="2" class="texto">'.$rowdv[3].'</textarea></td>				
						<td width="60" align="right"><img src="imagenes/add_16x16.gif" id="agred'.$contdi.'" title="Agregar Diagnóstico" alt="Agregar Diagnóstico" onClick="mostrar('.$contdi.');" '.$impagre.'></td>
						<td width="60" align="left"><img src="imagenes/delete_16x16.gif" id="elid'.$contdi.'" title="Eliminar Diagnóstico" alt="Eliminar Diagnóstico" onClick="elimdi('.$contdi.','.$rowdv[0].');" '.$impeli.'></td>
					  </tr>
					 </table>
				   </div>
				   </div>';   
			} // Fin del whilea
			$contdi=$contdi+1;
			/*$printdiag=substr($printdiag,0,strlen($printdiag)-10).'<div id="ddee'.$contdi.'"></div></td></tr>';*/
			$printdiag.='<div id="ddee'.$contdi.'"></div></td></tr>';
			echo $printdiag;
	   
		}
		else
		{ ?>
		   
		   <tr>
			<td class="textoN">Diagn&oacute;stico y Comentario </td>
			<td colspan="2" class="textoN">
			<div id="ddee1"><div id="a1">
			<table cellpadding="0" cellspacing="0" border="0">
			  <tr><td width="200">&nbsp;</td>
			  	<td width="120">&nbsp;</td>
				<td width="110">&nbsp;</td>
				<td width="60" >&nbsp;</td>
				<td width="60" >&nbsp;</td>
			  </tr>
			  <tr>
				<td width="320" colspan="2">
				  <input name="iddivi1" id="iddivi1" type="hidden" value="0">
				  <select name="DiagEsp1" id="DiagEsp1" class="texto">
					<option value="">Seleccione el Diagn&oacute;stico</option>
			<?php   $dg=$diag->combo_diag('');
				if ($dg!=false) echo $dg; ?>
				  </select>
				</td>
				<td width="230" colspan="3">
				  <select name="TipoDiag1" id="TipoDiag1" class="texto">
					<option value="">Seleccione tipo Diag.</option>
					<option value="Enfermedad Comun">Enfermedad Comun</option>
					<option value="Enfermedad Laboral">Enfermedad Laboral</option>
					<option value="Accidente Comun">Accidente Comun</option>
					<option value="Accidente Laboral">Accidente Laboral</option>
					<option value="Discapacidad Certificada">Discapacidad Certificada</option>
				  </select>
				</td>
			  </tr>
			  <tr>
				<td width="430" colspan="3"><textarea name="detaDiag1" id="detaDiag1" cols="80" rows="2" class="texto"><?php  if($rowr[12]!="") echo $rowr[12]; ?></textarea></td>
				<td width="60" align="right"><img src="imagenes/add_16x16.gif" id="agred1" title="Agregar Diagnóstico" alt="Agregar Diagnóstico" onClick="mostrar(1);"></td>
			    <td width="60" align="left"><img src="imagenes/delete_16x16.gif" id="elid1" title="Eliminar Diagnóstico" alt="Eliminar Diagnóstico" onClick="elimdi(1);" style="display:none"></td>
			  </tr>
			 </table>
		   </div>
		   </div>
		   <div id="ddee2"></div>
			</td>
		  </tr>				   
		 <?php   
		} // Fin del if
	$dg=$diag->combo_diag(''); ?>
  <tr>
    <td class="textoN">Tratamiento / Plan  
	<input name='ocucombo' id='ocucombo' type='hidden' value='<?php  echo $dg; ?>'>
	<input name='elidiag' id='elidiag' type='hidden' value=''>
	<input name="cantidiag" id="cantidiag" type="hidden" value="<?php  if($dvs!=false) echo $contdi; else echo 1;?>">
	
	 </td>
    <td colspan="2"><textarea name="Tratam" cols="90" rows="3" class="texto" id="Tratam"><?php  if($rowr[3]!="") echo $rowr[3]; ?></textarea></td>
  </tr>
   <?php 
  $r_estu= new res_estudio('',$vis,'');
		$bus_r_e=$r_estu->cons_res_estudio2($vis);
  ?><tr>
   	<td class="textoN">
  		Ingresar Informe <a href="javascript:mostrarVentana();">aquí</a>
<div id="miVentana" style="position: fixed; width: 450px; height: 300px; top: 0; left: 0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; border: #000000 3px solid; background-color: #FAFAFA; color: #000000; display:none;">
 <div style="font-weight: bold; text-align: left; color: #FFFFFF; padding: 5px; background-color:#FF8C00" align="center"><img src="imagenes/inf_medico.png" width="60" height="60"> &nbsp;&nbsp;INFORME RESULTADO DE ESTUDIO</div>
 <p style="padding: 5px; text-align: justify; line-height:normal"><textarea id="resuL_infor" name="resuL_infor" cols="60" rows="13"><?php  if($bus_r_e!="") echo $bus_r_e; ?></textarea></p>
  <div style="padding: 5px; background-color: ; text-align: center; margin-top: 10px;"><input id="btnAceptar" onclick="ocultarVentana();" name="btnAceptar" size="20" type="button" value="Aceptar" />
 </div>
</div>
  	</td>
  </tr>
    <tr>
    <td class="textoN">Indicaciones</td>
    <td colspan="2"><textarea name="Indic" cols="90" rows="3" class="texto"><?php  if($rowr[4]!="") echo $rowr[4]; ?></textarea></td>
  </tr>

  <tr>
    <td class="textoN">Conclusiones</td>
   <td colspan="2"><select name="Conclu" class="texto" id="Conclu">
	  <option value="" <?php  if($rowr[7]=="") echo 'selected'; ?>>Seleccione</option>
      <option value="Apto" <?php  if($rowr[7]=="Apto") echo 'selected'; ?>>Apto</option>
      <option value="Apto con Limitación" <?php  if($rowr[7]=="Apto con Limitación") echo 'selected'; ?>>Apto con Limitación</option>
      <option value="No Apto" <?php  if($rowr[7]=="No Apto") echo 'selected'; ?>>No Apto</option>
      <option value="Control Medico" <?php  if($rowr[7]=="Control Medico") echo 'selected'; ?>>Control Médico</option>
      <option value="Control Odontológico" <?php  if($rowr[7]=="Control Odontológico") echo 'selected'; ?>>Control Odontológico</option>
      <option value="Control Quirúrgico" <?php  if($rowr[7]=="Control Quirúrgico") echo 'selected'; ?>>Control Quirúrgico</option>
        </select></td>
  </tr>
  <tr>
    <td class="textoN">Recomendaciones</td>
    <td colspan="2"><textarea name="Recom" cols="90" rows="3" class="texto" id="Recom"><?php  if($rowr[5]!="") echo $rowr[5]; ?></textarea></td>
  </tr>
  <tr>
    <td class="textoN">Reposo</td>
    <td colspan="2" ><textarea name="Repos" cols="90" rows="3" class="texto" id="Repos"><?php  if($rowr[6]!="") echo $rowr[6]; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="3" ><hr size="0" width="100%"></td>
  </tr>
   <tr>
    <td class="textoN">Referencias</td>
    <td colspan="2" class="texto">
		<table width="474" border="0" cellspacing="1" cellpadding="0"><?php  
			$ref= new referencia('','','','','','','','','','',''); 
	       	$lref=$ref->lista_esp_ref($vis);
			if($lref!=false)
			{
				$contRef=0;
				while($row7 = mysql_fetch_row($lref))
				{
					$contRef++;
					$cqr='';
					$obr='';
					$espa='';
					if ($row7[5]>0)
					{ $cqr='checked';
					  if($row7[6]!=NULL) $obr=$row7[6];
					  $habil='';
					}
					else
					{
					  $habil='disabled="true";';
					}
					
					if($row7[0]=='R')
					{
					  $espa='&nbsp;&nbsp;&nbsp;&nbsp;';
					  $color='bgcolor="#FFFFFF"';
					  $valor=$row7[2];
					}
					else
					{
					  $color='bgcolor="#E3E3E6"';
					  $valor=$row7[1];
					}
					echo '<tr class="texto" >
					 		<td width="251">'.$espa.'<input  onClick="marcar(this.checked,'."'".'cmref'.$contRef."'".');"  name="refe'.$contRef.'" id="refe'.$contRef.'" type="checkbox" '.$cqr.' value="'.$row7[0].$row7[2].'" />'.ucwords(strtolower($row7[3])).'</td>
							<td width="223"><input class="texto" name="cmref'.$contRef.'" id="cmref'.$contRef.'" type="text" value="'.$obr.'" size="40" '.$habil.' />
							<input name="preref'.$contRef.'" id="preref'.$contRef.'" type="hidden" value="'.$row7[4].'" />
							<input name="codes'.$contRef.'" id="codes'.$contRef.'" type="hidden" value="'.$row7[1].'" /></td></tr>';
				}
				echo '<input name="ocref" id="ocref" type="hidden" value="'.$contRef.'" />';
			}
			else
			   echo '<tr class="texto"><td><span class="mensaje">No hay referencias para listar</span></td></tr>';
		    ?>&nbsp;
	</table>
	</td>
  </tr>
  <tr>
    <td colspan="3" ><hr size="0" width="100%"></td>
  </tr>

   <tr>
    <td class="textoN">Solicitudes</td>
    <td colspan="2" class="texto" >
		<table width="474" border="0" cellspacing="0" cellpadding="0">
		<?php 	$sol= new solicitud('',''); 
			$lsol=$sol->lista_sol($vis);
			if($lsol!='false')
			{
				$contSol=0;
				while($row8 = mysql_fetch_row($lsol))
				{
					$contSol++;
					$cqs='';
					$obs='';
					if ($row8[3]>0)
					{ $cqs='checked';
					  $obs=$row8[4];
					  $habil='';
					}
					else
					{
					  $habil='disabled="true";';
					}

					echo '<tr class="texto"><td width="251"><input  onClick="marcar(this.checked,'."'".'cmsol'.$contSol."'".');" name="soli'.$contSol.'" id="soli'.$contSol.'" type="checkbox" '.$cqs.' value="'.$row8[0].'" />'.$row8[1].'</td>
						<td width="223"><input class="texto" name="cmsol'.$contSol.'" id="cmsol'.$contSol.'" type="text" value="'.$obs.'" size="40" '.$habil.' />
						<input name="presol'.$contSol.'" id="presol'.$contSol.'" type="hidden" value="'.$row8[2].'" /></td></tr>';
				}
				echo '<input name="ocsol" id="ocsol" type="hidden" value="'.$contSol.'" />';
			}
			else
			   echo '<tr class="texto"><td><span class="mensaje">No hay solicitudes para listar</span></td></tr>';

		 ?>
		</table>
	</td>
  </tr>
  <tr>
    <td colspan="3" ><hr size="0" width="100%"></td>
  </tr>

  <tr>
    <td class="textoN">Observaci&oacute;n</td>
    <td colspan="2" ><textarea name="obsvis" cols="90" rows="3" class="texto" id="obsvis"><?php  if($rowr[9]!="") echo $rowr[9]; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="3" ><hr size="0" width="100%"></td>
  </tr>
  <?php  $labv=$visita->ver_lab_visita();
     if($labv!=false)
	 {   ?>
  <tr>
    <td class="textoN">&Oacute;rdenes de Laboratorio Asociadas </td>
    <td colspan="2" >
	  <?php  while($rowlv=mysql_fetch_array($labv))
		 { echo '<span class="texto" onclick="imprimir('."'".'orden_pdf.php?orden='.$rowlv[0]."'".');" style="cursor:hand; text-decoration:underline ">Orden de Laboratorio No. '.$rowlv[0].'</span> - 
		 		 <span class="texto" onclick="imprimir('."'".'resultado_exa_imp.php?orden='.$rowlv[0]."'".');" style="cursor:hand; text-decoration:underline ">Resultado de Orden No. '.$rowlv[0].'</span><br>'; 
		 }?>
	</td>
  </tr>
  <tr>
    <td colspan="3" ><hr size="0" width="100%"></td>
  </tr>
  <?php  } // Fin si encontro ordenes de lab asociadas  ?>
  <tr>
    <td colspan="3">
	 <div align="center" id="cargar">
	 <img src="imagenes/p_guardar1.gif" title="Guardar Cambios" alt="Guardar Cambios" width="140" height="50" style="cursor:hand" onclick="guardaVis('A');" onmouseover="this.src='imagenes/a_guardar1.gif'"  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
 	 </div>
	 <input name="ocugua" id="ocugua" type="hidden" value="0">
	 
  </td>
</table>
</form>
</body>
</html>
