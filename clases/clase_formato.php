<?php  
/* 
CLASE FORMATOS
CREADA POR: Ing. Monica Batista
FECHA DE CREACIÓN: 07/09/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS FORMATOS IMPRESOS
*/

/* DECLARACIÓN DE LA CLASE */
class formato
{
  
   
/* FUNCIÓN CONSTRUCTORA */  
   function formato()
   {
		$this->conexion=Conectarse();
	} //fin del constructor
	

	function datos_bas_vis($idvis)
	{
	   	$sql="select 
			slc_paciente.ced_paciente, 
			concat(slc_paciente.nom1_paciente,' ',slc_paciente.nom2_paciente,' ',slc_paciente.ape1_paciente,' ',slc_paciente.ape2_paciente),
			telf_hab_pac, 
			tefl_cel_pac,
			edo_civil_pac,
			CASE edo_civil_pac 
				WHEN 'S' THEN 'Soltero' 
				WHEN 'C' THEN 'Casado' 
				WHEN 'V' THEN 'Viudo' 
				WHEN 'D' THEN 'Divorciado' 
				ELSE edo_civil_pac 
			END as edocivil, 
			sexo_paciente,
			CASE sexo_paciente 
				WHEN 'F' THEN 'Femenino' 
				WHEN 'M' THEN 'Masculino' 
				ELSE sexo_paciente 
			END as sexopac, 
			grado_inst_pac,
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad,
			nomb_medico,
			IF(slc_visita.id_empresa='0', '', rif_empresa),	
			IF(slc_visita.id_empresa='0', 'PARTICULAR', nom_empresa),
			nomb_servicio,
			'',
			motivo_consulta,
			observa_visita,
			conclusion_visita,
			exafis_visita,
			exalab_visita,
			'',
			trat_visita,
			indi_visita,
			recom_visita,
			repos_visita,
			DATE_FORMAT(slc_paciente.fecha_nac_pac, '%d/%m/%Y'),
			slc_paciente.direc_hab_pac,
			slc_paciente.id_paciente,
			(select DATE_FORMAT(max(fecha_ing_status_dv), '%d/%m/%Y') from slc_status_det_visita where id_visita=$idvis),
			razon_visita,
			detexafis_visita,
			detdiag_visita
			FROM slc_servicio, slc_visita, slc_paciente, slc_empresa, slc_medico
			where slc_visita.id_visita=$idvis
			and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
			and slc_visita.slc_paciente_id_paciente=slc_paciente.id_paciente
			and slc_visita.ced_especialista=slc_medico.ced_rif_medico
			and (slc_visita.id_empresa=slc_empresa.id_empresa or slc_visita.id_empresa='0')";
		
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return $result;
		else
			return false;
	} 

	function cargo_act($idemp)
	{
	   	$sql="select max(slc_paciente_empresa.fecha_ing), 
			  	slc_paciente_empresa.cargo_pac, slc_paciente_empresa.fecha_ing
				from slc_paciente_empresa 
				where slc_paciente_empresa.slc_empleado_id_paciente='$idemp'
				group by slc_paciente_empresa.cargo_pac";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			if($row=mysql_fetch_row($result))
				return $row;
			else
			  return '';
		}
		else
			return '';
	} // Fin de funcion cargo_Act


	function signos_vitales($idvis,$idc)
	{
	   	$sql="select valor_cond_hv, slc_condicion_id_condicion
				from slc_historia_vis 
				where slc_visita_id_visita=$idvis
				and slc_condicion_id_condicion=$idc";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			if($rowsv=mysql_fetch_row($result))
				return $rowsv[0];
			else
			  return '';
		}
		else
			return '';
	} 

	function diag_vis($idvis)
	{
	   	
		$sql="select id_diag_visita, slc_diagnostico_id_diagnostico, 
		nomb_diagnostico, obs_diag_visita
		from slc_diag_visita, slc_diagnostico
		where slc_diagnostico_id_diagnostico=id_diagnostico
		and slc_visita_id_visita='".$idvis."'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return $result;
		else
			return false;
	} 

	function hist_ant($idpac)
	{
	   	$sql="SELECT distinct slc_tipo_condicion.id_tipocond, slc_tipo_condicion.nomb_tipocond, 
			slc_condicion.id_condicion, slc_condicion.nomb_condicion,
			slc_historia_ant.slc_valor_condicion_id_valorcond,
			if(slc_historia_ant.slc_valor_condicion_id_valorcond=0,slc_historia_ant.valor_cond_ha,slc_valor_condicion.valor_condicion) val
			FROM slc_tipo_condicion, slc_condicion, slc_historia_ant, slc_valor_condicion
			WHERE slc_tipo_condicion.histo_tipocond = '1'
			AND slc_condicion.slc_tipo_condicion_id_tipocond = slc_tipo_condicion.id_tipocond
			and slc_historia_ant.slc_condicion_id_condicion=slc_condicion.id_condicion
			and slc_historia_ant.slc_paciente_id_paciente='".$idpac."'
			and (slc_historia_ant.slc_valor_condicion_id_valorcond=slc_valor_condicion.id_valorcond or
				slc_historia_ant.slc_valor_condicion_id_valorcond=0)
			ORDER BY slc_tipo_condicion.orden_tipocond asc, slc_condicion.orden_condicion asc, 
			slc_condicion.id_condicion";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return $result;
		else
			return false;
	} 

	function hist_vis($idvis)
	{
	   	$sql="SELECT distinct slc_tipo_condicion.id_tipocond, slc_tipo_condicion.nomb_tipocond, 
			slc_condicion.id_condicion, slc_condicion.nomb_condicion,
			slc_historia_vis.slc_valor_condicion_id_valorcond,
			if(slc_historia_vis.slc_valor_condicion_id_valorcond=0,slc_historia_vis.valor_cond_hv,slc_valor_condicion.valor_condicion) val
			FROM slc_tipo_condicion, slc_condicion, slc_historia_vis, slc_valor_condicion
			WHERE slc_tipo_condicion.histo_tipocond = '2'
			AND slc_condicion.slc_tipo_condicion_id_tipocond = slc_tipo_condicion.id_tipocond
			and slc_historia_vis.slc_condicion_id_condicion=slc_condicion.id_condicion
			and slc_historia_vis.slc_visita_id_visita='".$idvis."'
			and (slc_historia_vis.slc_valor_condicion_id_valorcond=slc_valor_condicion.id_valorcond or
				slc_historia_vis.slc_valor_condicion_id_valorcond=0)
			ORDER BY slc_tipo_condicion.orden_tipocond asc, slc_condicion.orden_condicion asc, 
			slc_condicion.id_condicion";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return $result;
		else
			return false;
	} 

	
}// fin de la clase formato


?>
