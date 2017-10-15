<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_medico.php";
include "clases/clase_visita.php";
include "clases/clase_diagnostico.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilolab.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo2 {color: #FF0000}
-->
</style>
<title>Unidad Medica San Luis</title>
</head>
<body>
<?php 
    $mos='style="display:none"';
?>
<form name="form1" method="post" action="">
  	<table width="440" border="0" align="center" >
    	<tr class="titulofor">
      		<td colspan="2"><div align="center">Estadistica de Diagnostico </div></td>
    	</tr>
  	</table>
	<?php	
	echo '<table width="660" border="0" align="center">
             <tr class="etiqueta_grande">
                <td colspan="7"><div align="center">REPORTE DE DIAGNOSTICOS</div></td>
             </tr>';
	$fi=$_POST["ocu_fi"];
	$ff=$_POST["ocu_ff"];
	$medic=$_POST["medico"];
        $diagnostic=$_POST["diagnostico"];		 
	if ($medic!='0' && $medic!='9'){
	$med=new medico('',$_POST["medico"],'','','','','','','','','','','','','');	 		 
	echo    '<tr class="etiqueta_grande">
                <td colspan="7"><div align="center">Medico-'.$med->buscar_med().'</div></td>
             </tr>';
			 }
	if ($diagnostic!='0' && $diagnostic!='9'){
	$di=new diagnostico($_POST["diagnostico"],'','');	 		 
	echo    '<tr class="etiqueta_grande">
                <td colspan="7"><div align="center">Diagnostico-'.$di->nomb_diag().'</div></td>
             </tr>';}		 
	echo '<table width="660" border="0" align="center">
             <tr class="etiqueta_grande">
                <td colspan="7"><div align="center">Diagnosticos Desde '.$fi.' - Hasta '.$ff.'</div></td>
             </tr>';
    if ($medic=='9' && $diagnostic=='9'){
   	echo	'<tr class="titulofor">
      			<td width="10"><div align="center">DIAGNOSTICO</div></td>
      			<td width="50"><div align="center">CANTIDAD</div></td>      			
    		 </tr>';
			 
	$sql="select fecha_ing_visita, 	
    			 id_visita, 
       			 motivo_consulta,
       			 ced_especialista, 
       			 nomb_medico,
       			 exafis_visita, 
       			 exalab_visita, 
       			 ced_paciente, 
       			 nom1_paciente, 
       			 nom2_paciente, 
       			 ape1_paciente,
        		 ape2_paciente,            
       			 nomb_servicio,       
       			 desc_servicio,       
       			 slc_diagnostico_id_diagnostico,
       			 nomb_diagnostico,
       			 tipo_diag_visita
	  	  FROM   slc_visita, 
     			 slc_paciente, 
     			 slc_medico, 
     			 slc_servicio,
     			 slc_diag_visita, 
     			 slc_diagnostico
		  WHERE  id_paciente = slc_paciente_id_paciente			
     			 and (ced_especialista = ced_rif_medico or ced_especialista='0') 	
     			 and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
     			 and slc_diagnostico_id_diagnostico=id_diagnostico
     			 and slc_visita_id_visita=id_visita
     			 and fecha_ing_visita>'2012-01-01'
		  ORDER BY fecha_ing_visita asc";
	$vista=new visita('','','','','','','','','','','','','');   
	echo $vista->lista_todos_diagnosticos($fi,$ff);	
	
	}	
	if ($medic!='9' && $diagnostic=='9'){
   	echo	'<tr class="titulofor">
      			<td width="10"><div align="center">DIAGNOSTICO</div></td>
      			<td width="50"><div align="center">CANTIDAD</div></td>      			
    		 </tr>';
	$vista=new visita('','','','','','','','','','','','','');   
	echo $vista->lista_diagnosticos_x_med($fi,$ff,$medic);
	}
	if ($medic=='9' && $diagnostic!='9'){
   	     echo	'<tr class="titulofor">
      			<td width="10"><div align="center">MEDICO</div></td>
      			<td width="50"><div align="center">CANTIDAD</div></td>      			
    		 </tr>';
		$vista=new visita('','','','','','','','','','','','','');   
	    echo $vista->lista_medicos_x_diag($fi,$ff,$diagnostic);	 
	}		 
	if ($medic!='9' && $diagnostic!='9'){
		$vista=new visita('','','','','','','','','','','','','');   
	    echo $vista->cantidad_diag_x_medico($fi,$ff,$diagnostic,$medic);	 

	}
	echo '<tr><td colspan="7">&nbsp;</td></tr></table>';
	?>
  </form>
</body>
</html>
