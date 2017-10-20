<?php  
/* 
CLASE VISITA
CREADA POR: Ing. GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 05/05/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LA VISITA
*/

/* DECLARACIÓN DE LA CLASE */
class visita
{
   var $idv;
   var $ser;
   var $ced;
   var $nll;
   var $fac;
   var $mot;
   var $obs;
   var $con;
   var $sta;
   var $fin;
   var $usu;
   var $esp;
   var $emp;
 
   
/* FUNCIÓN CONSTRUCTORA */  
   function visita($id, $se, $ce, $nl, $fa, $mo, $ob, $co, $st, $fi, $us, $es, $em)
   {
		$this->conexion=Conectarse();
		$this->idv=$id;
   		$this->ser=$se;
	    $this->ced=$ce;
		$this->nll=$nl;
		$this->fac=$fa;
		$this->mot=$mo;   		
		$this->obs=$ob;
   		$this->con=$co;
   		$this->sta=$st;
		$this->fin=$fi;
   		$this->usu=$us;   		
		$this->esp=$es;
		$this->emp=$em;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_visita()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_visita(slc_servicio_id_servicio, slc_paciente_id_paciente, num_llegada, num_factura, motivo_consulta, fecha_ing_visita, usuario_visita,ced_especialista, id_empresa, status_visita) VALUES ('$this->ser', '$this->ced', '$this->nll', '$this->fac', '$this->mot','$hoy', '$this->usu', '$this->esp','$this->emp', '$this->sta')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{	   $sql2="Select last_insert_id() from dual";
			   $result2=mysql_query($sql2,$this->conexion);
			   if($result2)
			   {
			   		$row2 = mysql_fetch_row($result2);
			   		return $row2[0];
			   }
			   else
			   {
			   		return false;
			   }
		}
		else
			 return mysql_error(); ;
	} // fin de funcion  insertar 
	
	function ins_det_visita($idv, $ids,$usd,$st)
	{	$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_detalle_visita(slc_visita_id_visita, slc_servicio_id_servicio, fecha_ing_dv, usuario_dv,status_det_visita) VALUES ('$idv', '$ids', '$hoy','$usd','$st')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			$sql2="Select last_insert_id() from dual";
		   $result2=mysql_query($sql2,$this->conexion);
		   if($result2)
		   {
				$row2 = mysql_fetch_row($result2);
				return $row2[0];
		   }
		   else
		   {
				return false;
		   }
		}
		else
			   return false;
	} // fin de funcion  insertar 
	
	function ins_sta_det_visita($idd, $sta,$ids,$usd,$idv,$obs)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_status_det_visita(slc_detalle_visita_id_det_visita, status_ante_dv, fecha_ing_status_dv, usuario_status_dv, slc_servicio_id_servicio, id_visita, observacion_st) VALUES ('$idd', '$sta', '$hoy','$usd','$ids','$idv', '$obs')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
	
	//MODIFICAR LA VISITA
	function mod_visita()
	{$fecha= date("Y-m-d h:i:s");
	   	$sql="UPDATE slc_visita SET num_factura= '$this->fac', motivo_consulta= '$this->mot', ced_especialista= '$this->esp', id_empresa='$this->emp', status_visita='$this->sta' WHERE id_visita ='$this->idv'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;

	} // fin de funcion  modificar 
	
	function mod_sta_visita_mult()
	{
		$sql="select distinct status_det_visita from slc_detalle_visita
		where slc_visita_id_visita='$this->idv'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			$cambsvm='true';
			while($row = mysql_fetch_row($result))
			{
				if($row[0]!='A' && $row[0]!='E')
				{
					$cambsvm='false';
				}
			}
			if($cambsvm=='true')
			{	
				$sql2="update slc_visita
					  set status_visita='A'
					  where id_visita='$this->idv'";
				$result2=mysql_query($sql2,$this->conexion);
				if($result2) 
					return true;
				else
					return false;
			}
			else
			{
				return true;
			}
		}
		else
			return false;
	}
	
	
	function mod_sta_visita_uni($sta)
	{   
	   	$sql="UPDATE slc_visita SET status_visita='$sta' WHERE id_visita ='$this->idv'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar 
	
function mod_det_visita($idv, $idd,$usd,$st,$ob)
{  	$sql="UPDATE slc_detalle_visita SET status_det_visita='$st', observacion_dv='$ob'
 where slc_visita_id_visita='$idv' and id_det_visita='$idd'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
}

function num_llegada() //funcion para ver si el registro existe 
	{$fecha= date("Y-m-d").'%';
	$sql="SELECT count(slc_paciente_id_paciente) FROM slc_visita WHERE   fecha_ing_visita like '$fecha'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row = mysql_fetch_row($result);
	  if ($result)
			   return $row[0];
	else
			   return 'false';
	}
function visitas_pend($cedpac)
	{
		$HTML='';
	   	$sql="SELECT id_visita,slc_servicio_id_servicio, slc_paciente_id_paciente, num_llegada, num_factura, 
motivo_consulta, fecha_ing_visita, usuario_visita,ced_especialista, id_empresa, status_visita, nomb_servicio
FROM slc_visita, slc_servicio where slc_paciente_id_paciente='$cedpac' and status_visita<>'A' and status_visita<>'E' and slc_servicio_id_servicio=id_servicio order by fecha_ing_visita desc";
			$HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">';
			$result=mysql_query($sql,$this->conexion);
			if ($result) 
			{
				$n=mysql_num_rows($result);
				if($n==0)
				{
					$HTML.='';
				}
				else
				{
					$HTML.='<tr class="titulorep">
							<td width="100">Fecha</td>
							<td width="150">Motivo de la Visita</td>
							<td width="250">Servicio</td>
							<td width="100">Estado</td>
							</tr>';
				    $cont=0;
					while ($row = mysql_fetch_row($result))
					{
						
						if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
						$cont++;
						if($row[10]=='P')
						 {	$status='Pendiente'; 
						 	$fuente='class="mensaje"';
						 }
						if($row[10]=='L')
						 {
						 	$status='Lista de Espera'; 
						    $fuente='class="azul"';	
						}	
						if($row[10]=='A')
						 {
						 	$status='Atendido'; 
							$fuente='class="verde"';
						}	
						if($row[10]=='I')
						 {
						 	$status='Incompleto'; 
							$fuente='class="naranja"';
						}
						if($row[10]=='E')
						{
						 	$status='Eliminado'; 
							$fuente='class="textoN"';	
						}	
					   $cadena=implode('/*',$row);
					   $fec=substr($row[6],8,2).'/'.substr($row[6],5,2).'/'.substr($row[6],0,4); 
				$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$fec.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[5].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[11].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" '.$fuente.' align="left">'.$status.'</td>
				</tr>';
	
					}

				} // Fin de else si no hay resultados
			} // Fin del if result
			else
			{
			$HTML.='<tr class="titulofor">
    				<td colspan="4">
					<div align="center">OCURRIÓ UN ERROR. COMUNÍQUESE CON UN ADMINISTRADOR</div>
					</td>
  					</tr>';
			}
			$HTML.='</table>';
 			return $HTML;
   		
	} //Fin de la funcion result_ordenes
function consul_det_vis($id)
	{
	   	$sql="SELECT id_det_visita, nomb_servicio, precio_servicio, status_det_visita, slc_visita_id_visita, slc_servicio_id_servicio, observacion_dv 
FROM slc_detalle_visita, slc_servicio where slc_visita_id_visita='$id' and  slc_servicio_id_servicio=id_servicio ORDER BY id_det_visita";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}

function consul_det_exist($id)
	{
	   	$sql="SELECT * FROM slc_detalle_visita WHERE slc_visita_id_visita = '$id'";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
	   	if($n==0)
		{
		   return false;
		}
		else
			return true;
	}

function consul_det($id)
	{
	   	$sql="SELECT * FROM slc_detalle_visita WHERE slc_visita_id_visita = '$id' AND status_det_visita = 'A'";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
	   	if($n>0)
		   return true;
		else
			return false;
	}
function eliminar_v($id, $obs)
{   
	$sql="UPDATE  slc_visita SET  status_visita ='E', observa_visita='$obs' where id_visita = '$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function eliminar_d($id, $obs)
{   
	$sql="UPDATE  slc_detalle_visita SET  status_det_visita ='E', observacion_dv='$obs' where slc_visita_id_visita = '$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}

	/********** DE AQUI EN ADELANTE CREADAS POR MÓNICA PARA LA VISITA **********/
	
	function tipos_cond_H($th)
	{
	   	
		//SCRIPT LOCAL
		/*$sql="SELECT DISTINCT `id_tipocond` , UPPER(`nomb_tipocond`) , `desc_tipocond` 
				FROM `slc_tipo_condicion` 
				where ` histo_tipocond` LIKE CONVERT( _utf8 '$th' USING latin1 ) 
				COLLATE latin1_general_ci
				AND status_tipocond ='A'
				ORDER BY `orden_tipocond` ASC";*/
		
		//SCRIPT SERVIDOR
		$sql="SELECT DISTINCT `id_tipocond` , UPPER(`nomb_tipocond`) , `desc_tipocond` 
				FROM `slc_tipo_condicion` 
				WHERE `histo_tipocond` = '$th'
				AND status_tipocond ='A'
				ORDER BY `orden_tipocond` ASC";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return 'false';
	  	else
   			return $result;
	} // fin de funcion buscar_bioanalista
	
	function condicionesH($tc,$pac)
	{
		$sql="SELECT id_condicion, nomb_condicion, lista_val_condicion, desc_condicion, selec_multiple_condicion,
		     (SELECT distinct valor_cond_ha
				FROM slc_historia_ant
				WHERE slc_condicion_id_condicion =id_condicion
				AND slc_paciente_id_paciente = '$pac'
				and valor_cond_ha<>'') vaco
				FROM slc_condicion
				WHERE slc_tipo_condicion_id_tipocond=$tc
				and status_condicion='A'
				order by orden_condicion";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
	}

	function valorescond($c,$pac)
	{
		$sql="SELECT id_valorcond, valor_condicion,
				(SELECT count(distinct slc_historia_ant.slc_valor_condicion_id_valorcond)
				FROM slc_historia_ant
				WHERE slc_historia_ant.slc_valor_condicion_id_valorcond =slc_valor_condicion.id_valorcond
				AND slc_historia_ant.slc_paciente_id_paciente = '$pac'
				and slc_historia_ant.slc_condicion_id_condicion=$c) vaco
				FROM slc_valor_condicion
				WHERE slc_condicion_id_condicion=$c
				and status_valorcond='A'";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
	}

	function condicionesHVI($tc,$vis)
	{
		$sql="SELECT id_condicion, nomb_condicion, lista_val_condicion, desc_condicion, selec_multiple_condicion,
		     (SELECT distinct valor_cond_hv
				FROM slc_historia_vis
				WHERE slc_condicion_id_condicion =id_condicion
				AND slc_visita_id_visita = '$vis'
				and valor_cond_hv<>'') vaco
				FROM slc_condicion
				WHERE slc_tipo_condicion_id_tipocond=$tc
				and status_condicion='A'
				order by orden_condicion";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
	}


	function valorescondVI($c,$vis)
	{
		$sql="SELECT id_valorcond, valor_condicion,
				(SELECT count(distinct slc_historia_vis.slc_valor_condicion_id_valorcond)
				FROM slc_historia_vis
				WHERE slc_historia_vis.slc_valor_condicion_id_valorcond =slc_valor_condicion.id_valorcond
				AND slc_historia_vis.slc_visita_id_visita = '$vis'
				and slc_historia_vis.slc_condicion_id_condicion=$c) vaco
				FROM slc_valor_condicion
				WHERE slc_condicion_id_condicion=$c
				and status_valorcond='A'";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
	}
	
	function guardResVis($ef,$el,$di,$tr,$in,$rec,$rep,$raz,$def,$ddi)
	{
	  $sql="UPDATE slc_visita set
	  		exafis_visita='$ef',
	  		exalab_visita='$el',
	  		trat_visita='$tr',
	  		indi_visita='$in',
	  		recom_visita='$rec',
	  		repos_visita='$rep',
			conclusion_visita='$this->con',
			observa_visita='$this->obs',
			razon_visita='$raz',
			detexafis_visita='$def'
			where id_visita='$this->idv'"; //,status_visita='$this->sta'
		$result=mysql_query($sql,$this->conexion);
	  	if($result)
			return true;
	  	else
   			return false;
	}


	function guardDiagVis($id,$di,$tp,$ob)
	{
		if($id!='0')
		{
		  $sql="UPDATE slc_diag_visita set
				slc_diagnostico_id_diagnostico=$di,
				tipo_diag_visita='$tp',
				obs_diag_visita='$ob'
				where slc_visita_id_visita='$this->idv'
				and id_diag_visita=$id";
		}
		else
		{
		  $sql="INSERT INTO slc_diag_visita 
		  		(slc_visita_id_visita,slc_diagnostico_id_diagnostico,
				 tipo_diag_visita,obs_diag_visita)
				 VALUES ($this->idv,$di,'$tp','$ob')"; 
		}
		$result=mysql_query($sql,$this->conexion);
	  	if($result)
			return true;
	  	else
   			return false;
	}
	
	
	function eliDiagVis($id)
	{
		if($id!='0')
		{
		  $sql="delete from slc_diag_visita 
				where slc_visita_id_visita='$this->idv'
				and id_diag_visita=$id";
		}
		$result=mysql_query($sql,$this->conexion);
	  	if($result)
			return true;
	  	else
   			return false;
	}
	
function ver_result_vis()
{
		$sql="SELECT exafis_visita,exalab_visita,'',trat_visita,indi_visita,
			recom_visita,repos_visita,conclusion_visita,status_visita,observa_visita,
			razon_visita,detexafis_visita,'',motivo_consulta, ced_especialista
			from slc_visita
			where id_visita='$this->idv'";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
}

function ver_diag_vis()
{
		$sql="SELECT id_diag_visita,
			slc_diagnostico_id_diagnostico,
			tipo_diag_visita,
			obs_diag_visita
			from slc_diag_visita
			where slc_visita_id_visita='$this->idv'";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
}


function ina_ref_vis()
{
	$sql1="select count(*) 
		from slc_ref_visita
	  	where slc_visita_id_visita=$this->idv";
	$result1=mysql_query($sql1,$this->conexion);
	if($result1)
	{
		$row1=mysql_fetch_array($result1); 
		if($row1[0]>0)
		{
	
			$sql="update slc_ref_visita
				set status_rv='I'
				where slc_visita_id_visita='$this->idv'";
				$result=mysql_query($sql,$this->conexion);
				if($result)
					return true;
				else
					return false;
		}
		else
			return true;
	}
	else
		return false;
} // fin de la funcion ina_ref_vis

function ins_ref_vis($idr,$pr,$obs,$ides)
{
	$zone=(3600*-4.5); 
	$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	$usu=$_SESSION["cedu_usu"];
	$sql="select count(*) 
		from slc_ref_visita
	  	where slc_visita_id_visita=$this->idv
		and id_esp_ref=$ides";
	$result=mysql_query($sql,$this->conexion);
	if($result)
	{
		$row=mysql_fetch_array($result); 
		if($row[0]==0)
		{
			$sql1="insert into slc_ref_visita
			(slc_visita_id_visita, slc_referencia_id_referencia, precio_rv, observacion_rv,id_esp_ref,fecha_ing_rv,usuario_rv)
			values($this->idv,$idr,$pr,'$obs',$ides,'$hoy','$usu')";
			$result1=mysql_query($sql1,$this->conexion);
			if($result1)
				return true;
			else
				return false;
		}
		else
		{
			$sql2="update slc_ref_visita
			set precio_rv=$pr,
				observacion_rv='$obs', 
				status_rv='A'
			where slc_visita_id_visita=$this->idv
			and id_esp_ref=$ides";
			$result2=mysql_query($sql2,$this->conexion);
			if($result2)
				return true;
			else
				return false;
		}
	}
	else
		return false;
} // Fin de la funcion ins_ref_vis


function ina_sol_vis()
{
	$sql1="select count(*) 
		from slc_sol_visita
	  	where slc_visita_id_visita=$this->idv";
	$result1=mysql_query($sql1,$this->conexion);
	if($result1)
	{
		$row1=mysql_fetch_array($result1); 
		if($row1[0]>0)
		{
	
			$sql="update slc_sol_visita
				set status_sv='I'
				where slc_visita_id_visita='$this->idv'";
				$result=mysql_query($sql,$this->conexion);
				if($result)
					return true;
				else
					return false;
		}
		else
			return true;
	}
	else
		return false;
} // fin de la funcion ina_ref_vis

function ins_sol_vis($ids,$prs,$obs)
{

	$sql="select count(*) 
		from slc_sol_visita
	  	where slc_visita_id_visita=$this->idv
		and slc_solicitud_id_solicitud=$ids";
	$result=mysql_query($sql,$this->conexion);
	if($result)
	{
		$row=mysql_fetch_array($result); 
		if($row[0]==0)
		{
			$sql1="insert into slc_sol_visita
			(slc_visita_id_visita, slc_solicitud_id_solicitud, precio_sv, observacion_sv)
			values($this->idv,$ids,$prs,'$obs')";
			$result1=mysql_query($sql1,$this->conexion);
			if($result1)
				return true;
			else
				return false;
		}
		else
		{
			$sql2="update slc_sol_visita
			set precio_sv=$prs,
			observacion_sv='$obs', 
			status_sv='A'
			where slc_visita_id_visita=$this->idv
			and slc_solicitud_id_solicitud=$ids";
			$result2=mysql_query($sql2,$this->conexion);
			if($result2)
				return true;
			else
				return false;
		}
	}
	else
		return false;
} // Fin de la funcion ins_ref_vis

function datos_pac_vis($pa)
{
	
	$sql="SELECT id_paciente, ced_paciente, 
		concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
		sexo_paciente, CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
			 THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			 WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) 
			 AND (DAY( fecha_nac_pac ) <= DAY( current_date )) 
			 THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			 ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1 END AS edad, 
		 IF(sexo_paciente='F', 'Femenino', 'Masculino') FROM  slc_paciente
		WHERE id_paciente = '$pa' ";
	 $result=mysql_query($sql,$this->conexion);

	 $n=mysql_num_rows($result);
	 if($n==0)
		return 'false';
	else
	{  
		return $result;
	}
}

function datos_empres_vis()
{
	
	$sql="SELECT slc_visita.id_empresa, (SELECT nom_empresa
		FROM slc_empresa
		WHERE id_empresa = slc_visita.id_empresa) noem
		FROM slc_visita
		WHERE slc_visita.id_visita =$this->idv";
	 $result=mysql_query($sql,$this->conexion);

	 $n=mysql_num_rows($result);
	 if($n==0)
		return 'false';
	else
	{  
		return $result;
	}
}

function ins_lab_visita($preor,$obslv,$stlv)
{
	$zone=(3600*-4.5); 
	$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	$usu=$_SESSION["cedu_usu"];
	$sql1="insert into slc_lab_visita
			select last_insert_id(),$this->idv,$preor,'$obslv','$stlv','$hoy','$usu'";
			$result1=mysql_query($sql1,$this->conexion);
			if($result1)
				return true;
			else
				return false;
}

function ver_lab_visita()
{
	$sql1="select slc_orden_id_orden 
			from slc_lab_visita
			where slc_visita_id_visita=$this->idv
			and status_lv='A'";
			$result1=mysql_query($sql1,$this->conexion);
			$n=mysql_num_rows($result1);
			if($n<=0)
				return false;
			else
			{  
				return $result1;
			}
}

function ver_visitas_antes()
{
	$sql1="select id_visita, 
			motivo_consulta, 
			date_format(fecha_ing_visita,'%d/%m/%Y %h:%m:%s %p'),  
			status_visita
			from slc_visita
			where id_visita not in ($this->idv)
			and slc_paciente_id_paciente='$this->ced'
			order by fecha_ing_visita desc";
			$result1=mysql_query($sql1,$this->conexion);
			$n=mysql_num_rows($result1);
			if($n<=0)
				return 'false';
			else
			{  
				return $result1;
			}
}

/////////////VIGILANCIA EPIDEMIOLOGICA///////////////////////
function buscar_año($e)
{    $sql="select distinct left(fecha_ing_visita,4)  from slc_visita where id_empresa=".$e." and status_visita='A' order by fecha_ing_visita  desc";
	$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[0].'</option>';
			}
		  return $HTML;
		}
		else 
		return false;

}
function nombre_mes($m)
{
			if($m=='01')
				$mes='ENERO';
		   	if($m=='02')
				$mes='FEBRERO';
		   	if($m=='03')
				$mes='MARZO';
		   	if($m=='04')
				$mes='ABRIL';
		   	if($m=='05')
				$mes='MAYO';
		   	if($m=='06')
				$mes='JUNIO';
		   	if($m=='07')
				$mes='JULIO';
		   	if($m=='08')
				$mes='AGOSTO';
		   	if($m=='09')
				$mes='SEPTIEMBRE';
		   	if($m=='10')
				$mes='OCTUBRE';
		   	if($m=='11')
				$mes='NOVIEMBRE';
		   	if($m=='12')
				$mes='DICIEMBRE';
		return $mes;
}
function buscar_mes($año, $e)
{
$sql="select distinct MONTHNAME(fecha_ing_visita), MONTH(fecha_ing_visita) from slc_visita where id_empresa ='$e' and left(fecha_ing_visita,4)='$año' and status_visita='A' order by fecha_ing_visita  desc";
$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		   	$visi= new visita('','','','','','','','','','','','','');
			$row[0]=$visi->nombre_mes($row[1]);
			$HTML.='<option value="'.$row[1].'">'.$row[0].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
}
function inf_empresa($e,$a,$m)
{
    $cond='';
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
    
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	     
	$sql="select count(id_visita), nom_empresa  from slc_visita, slc_empresa where slc_visita.id_empresa='$e' and  slc_visita.id_empresa= slc_empresa.id_empresa  and status_visita='A' ".$cond." group by slc_visita.id_empresa";
   
	$result=mysql_query($sql,$this->conexion);
	$row = mysql_fetch_row($result);
		if ($result) 
		{	$visi= new visita('','','','','','','','','','','','','');
		  if($f1==$f2)
		     $fem='DEL MES DE '.$visi->nombre_mes(substr($a,4,2)).' DEL AÑO '.substr($a,0,4);
		  else		    
		     $fem='</td></tr><tr><td class="etiqueta_grande">DE LOS MESES DESDE '.$visi->nombre_mes(substr($a,4,2)).'-'.substr($a,0,4).' HASTA '.$visi->nombre_mes(substr($m,4,2)).'-'.substr($m,0,4); 	 
		   $HTML='<table width="660" border="0" align="center">
				<tr>
				  <td class="etiqueta_grande">'.$row[1].'</td>
				</tr>
				<tr>
				  <td class="etiqueta_grande">VIGILANCIA EPIDEMIOL&Oacute;GICA '.$fem.'</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
			  </table>';
		  return $HTML;
		}
		else
		return false;
}
function enfermedades_accidentes($e, $a, $m, $ccom)
{
	$asis=0;
	$san=0;
	$enf=0;	
	$enfc=0;
	$enfl=0;
	$ac=0;
	$al=0;
	$aa=$a;
	$mm=$m;
	$tenfc=0;
	$visi= new visita('','','','','','','','','','','','','');   
	if ($m <7)
		$mini=1;
	else
		$mini=$m-5;
	$cond='';
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
    
		
	$HTML.='<table width="660" border="0" align="center">
	<tr class="titulofor">
	  <td><div align="center">PERIODO </div></td>
	  <td><div align="center">ACCIDENTES COMUNES</div></td>
	  <td><div align="center">ACCIDENTES DE TRABAJO</div></td>
	  <td><div align="center">ENFERMEDADES COMUNES</div></td>
	  <td><div align="center">ENFERMEDADES OCUPACIONALES </div></td>
	</tr>';	
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	$mini=substr($a,4,2);
	while($m>=$a)
	{  $i=substr($a,4,2);
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
		//ENFERMEDADES COMUNES
	$sql="SELECT count(id_visita) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e'  and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Comun' and slc_diagnostico_id_diagnostico<>'' and slc_diagnostico_id_diagnostico>0 and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	 if($n>0)
	{ 
		$row = mysql_fetch_row($result);
		$enfc=$row[0];
	}
	else
		$enfc=0;
		$tenfc+=$enfc;
	//ENFERMEDADES OCUPACIONALES/////////////
	$sql="SELECT count(id_visita) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Laboral' and slc_diagnostico_id_diagnostico<>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	 if($n>0)
	{ 
		$row = mysql_fetch_row($result);
		$enfl=$row[0];
	}
	else
		$enfl=0;
	//ACCIDENTES COMUNES/////////////
	$sql="SELECT count(id_visita) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Accidente Comun' and slc_diagnostico_id_diagnostico<>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	 if($n>0)
	{ 
		$row = mysql_fetch_row($result);
		$ac=$row[0];
	}
	else
		$ac=0;
	//ACCIDENTES LABORALES/////////////
	$sql="SELECT count(id_visita) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Accidente Laboral' and slc_diagnostico_id_diagnostico<>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	 if($n>0)
	{ 
		$row = mysql_fetch_row($result);
		$al=$row[0];
	}
	else
		$al=0;
	/////////////////////
	if ($i%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
	$HTML.='<tr class="textoN" '.$color.'>
			  <td>'.$visi->nombre_mes($i).'</td>
			  <td><div align="center">'.$ac.'</div></td>
			  <td><div align="center">'.$al.'</div></td>
			  <td><div align="center">'.$enfc.'</div></td>
			  <td><div align="center">'.$enfl.'</div></td>
			</tr>';
	if($i==12)
	   $a=(substr($a,0,4)+1).'01';
	else
	 { if((substr($a,4,2)+1)<10) 
	    $mesx='0'.(substr($a,4,2)+1);
	  else 
	    $mesx=(substr($a,4,2)+1);
        $a=substr($a,0,4).$mesx;	}	
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($a,0,4).'-'.substr($a,4,2);			
	}
	$enf=$enfm;
	$cond='';
	$f1=substr($aa,0,4).'-'.substr($aa,4,2);
	$f2=substr($mm,0,4).'-'.substr($mm,4,2);
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$sql1="select count(id_visita) from slc_visita, slc_diag_visita  where id_empresa='$e' and slc_paciente_id_paciente <>'' and status_visita='A' and slc_visita_id_visita=id_visita and (slc_diagnostico_id_diagnostico='1' or slc_diagnostico_id_diagnostico='2') ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result1=mysql_query($sql1,$this->conexion);
	$row1 = mysql_fetch_row($result1);
	if ($result1)
	{
		$san=$row1[0]; // cantidad de sanos
	}
	$sqla="select count(id_visita) from slc_visita  where id_empresa='$e' and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$resulta=mysql_query($sqla,$this->conexion);
	$rowa = mysql_fetch_row($resulta);
	if ($resulta)
	{
		$asis=$rowa[0]; //cantidad que asistieron
	}		
	$sqlns="SELECT count(distinct id_visita) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Comun' and slc_diagnostico_id_diagnostico<>''  and slc_diagnostico_id_diagnostico>=3 and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$resultns=mysql_query($sqlns,$this->conexion);
	$rowns = mysql_fetch_row($resultns);
	if ($resultns)
	{
		$nosan=$rowns[0]; //cantidad de no sanos
	}
	if($f1==$f2) $comen="EN EL MES DE ".$visi->nombre_mes(substr($aa,4,2));
	else $comen="EN EL PERIODO DE ".$visi->nombre_mes(substr($aa,4,2))." DEL ".substr($aa,0,4)." AL ".$visi->nombre_mes(substr($mm,4,2))." DEL ".substr($mm,0,4);
	if ($ccom==0)
		$com="COMENTARIO: SE EVIDENCIA QUE ".$comen." ASISTIERON ".$asis." PACIENTE(S) DE LOS CUAL(ES) ".$san." ESTÁN SANO(S) Y ".$tenfc." ENFERMEDAD(ES) COMUN(ES) EN ".$nosan." TRABAJADORES, ES IMPORTANTE RESALTAR QUE LAS ENFERMEDADES COMUNES SE PUEDEN REPORTAR VARIAS EN UN MISMO PACIENTE.";
	else
		$com=$_POST["com1"];
	$HTML.='<tr><td colspan="5" align="center">&nbsp;</td></tr><tr><td colspan="5"><textarea name="com1" cols="125" rows="3" class="texto">'.$com.'</textarea></td></tr><tr><td colspan="5">&nbsp;</td></tr><tr></table>';
	return $HTML.'**'.$enfc.'**'.$asis;


} 
	
function resultado_examenes($e,$a,$m, $ccom)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$sql="SELECT  fecha_ing_visita, motivo_consulta, conclusion_visita, slc_paciente_id_paciente FROM slc_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC ";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($result) 
	{ 
	   $HTML.='<table width="660" border="0" align="center">
    <tr class="etiqueta_grande">
      <td colspan="7"><div align="center">RESULTADO DE LOS &Eacute;XAMEN DE SALUD PRACTICADOS </div></td>
    </tr>
    <tr class="titulofor">
      <td width="10"><div align="center">N&ordm;</div></td>
      <td width="50"><div align="center">FECHA</div></td>
      <td width="250"><div align="center">NOMBRE</div></td>
      <td width="50"><div align="center">C.I.</div></td>
      <td width="250"><div align="center">CARGO</div></td>
      <td width="30"><div align="center">CONSULTA</div></td>
      <td width="30"><div align="center">RESULTADO</div></td>
    </tr>';
	$p=0;	   	
	while ($row = mysql_fetch_row($result))
	{	
		$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
		$resultn=mysql_query($sqln,$this->conexion);	   
		$rown = mysql_fetch_row($resultn);
		$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
		$resultc=mysql_query($sqlc,$this->conexion);	   
		$rowc= mysql_fetch_row($resultc);
		if ($resultc)
			$carg=$rowc[0];
		else
			$carg='';
		$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$HTML.='<tr class="textoN" '.$color.'>
	  <td>'.$p.'</td>
	  <td><div align="center">'.$row[0].'</div></td>
	  <td><div align="left">'.$rown[0].' '.$rown[1].'</div></td>
	  <td><div align="center">'.$rown[2].'</div></td>
	  <td><div align="left">'.$rowc[0].'</div></td>
	  <td><div align="left">'.$row[1].'</div></td>
	  <td><div align="left">'.$row[2].'</div></td>
	</tr>';
	}
	if ($ccom==0)
		$com="EL COMIT&Eacute; DE HIGIENE Y SEGURIDAD DE LA EMPRESA DEBE REALIZAR SEGUIMIENTO DE LOS NO APTOS Y APTOS CON LIMITACI&Oacute;N, DE MANERA DE DISMINUIR LAS ENFERMEDADES COMUNES Y OCUPACIONALES.";
	else
		$com=$_POST["com2"];
    $HTML.='<tr><td colspan="7">&nbsp;</td></tr><tr>
			  <td colspan="7" align="center"><textarea name="com2" cols="125" rows="3" class="texto">'.$com.'</textarea></td>
			</tr><tr><td colspan="7">&nbsp;</td></tr><tr></table>';
	  return $HTML;
	}
	else
		return false;
}
function referencias_visitas($e,$a,$m,$ccom)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";

		 $HTML.='<table width="660" border="0" align="center">
    <tr class="etiqueta_grande">
      <td colspan="7"><div align="center">REFERENCIAS A OTROS MÉDICOS</div></td>
    </tr>
    <tr class="titulofor">
      <td width="10"><div align="center">N&ordm;</div></td>
      <td width="50"><div align="center">FECHA</div></td>
      <td width="250"><div align="center">NOMBRE</div></td>
      <td width="50"><div align="center">C.I.</div></td>
      <td width="250"><div align="center">CARGO</div></td>
      <td width="30"><div align="center">CONSULTA</div></td>
      <td width="30"><div align="center">REFERENCIA</div></td>
    </tr>';
	$sql="SELECT fecha_ing_visita, motivo_consulta, nomb_esp, slc_paciente_id_paciente,id_visita FROM slc_visita, slc_ref_visita, slc_especialidad WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and id_esp_ref=id_esp and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
	$p=0;	   	
	while ($row = mysql_fetch_row($result))
	{	
		$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
		$resultn=mysql_query($sqln,$this->conexion);	   
		$rown = mysql_fetch_row($resultn);
		$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
		$resultc=mysql_query($sqlc,$this->conexion);	   
		$rowc= mysql_fetch_row($resultc);
		if ($resultc)
			$carg=$rowc[0];
		else
			$carg='';
		$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$HTML.='<tr class="textoN" '.$color.'>
	  <td>'.$p.'</td>
	  <td><div align="center">'.$row[0].'</div></td>
	  <td><div align="left">'.$rown[0].' '.$rown[1].'</div></td>
	  <td><div align="center">'.$rown[2].'</div></td>
	  <td><div align="left">'.$rowc[0].'</div></td>
	  <td><div align="left">'.$row[1].'</div></td>
	  <td><div align="left">'.$row[2].'</div></td>
	</tr>';
	}
	if ($ccom==0)
		$com="EL COMIT&Eacute; DE HIGIENE Y SEGURIDAD DE LA EMPRESA DEBE REALIZAR SEGUIMIENTO DE LAS REFERENCIAS MÉDICAS PARA ASEGURAR QUE SEAN CUMPLIDAS.";
	else
		$com=$_POST["com3"];
    $HTML.='<tr><td colspan="7">&nbsp;</td></tr><tr>
			  <td colspan="7"><textarea name="com3" cols="125" rows="3" class="texto">'.$com.'</textarea></td>
			</tr><tr><td colspan="7">&nbsp;</td></tr></table>';

	}
	else
	{
	if ($ccom==0)
		$com="EL COMIT&Eacute; DE HIGIENE Y SEGURIDAD DE LA EMPRESA DEBE REALIZAR SEGUIMIENTO DE LAS REFERENCIAS MÉDICAS PARA ASEGURAR QUE SEAN CUMPLIDAS. ";
	else
		$com=$_POST["com3"];
	$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
	  <td>-</td>
	  <td><div align="center">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="center">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="left">-</div></td>
	</tr><tr><td colspan="7">&nbsp;</td></tr><tr>
			  <td colspan="7" align="center"><textarea name="com3" cols="125" rows="3" class="texto">'.$com.'</textarea></td>
			</tr><tr><td colspan="7">&nbsp;</td></tr></table>';
	
	}	
	
	return $HTML;
}
function reposos_visitas($e,$a,$m)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
    <tr class="etiqueta_grande">
      <td colspan="7"><div align="center">REPOSOS</div></td>
    </tr>
    <tr class="titulofor">
      <td width="10"><div align="center">N&ordm;</div></td>
      <td width="50"><div align="center">FECHA</div></td>
      <td width="250"><div align="center">NOMBRE</div></td>
      <td width="50"><div align="center">C.I.</div></td>
      <td width="250"><div align="center">CARGO</div></td>
      <td width="30"><div align="center">CONSULTA</div></td>
      <td width="30"><div align="center">REPOSO</div></td>
    </tr>';
	$sql="SELECT  fecha_ing_visita, motivo_consulta, repos_visita, slc_paciente_id_paciente FROM slc_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and repos_visita!=''  and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC ";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
	$p=0;	   	
	while ($row = mysql_fetch_row($result))
	{	
		$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
		$resultn=mysql_query($sqln,$this->conexion);	   
		$rown = mysql_fetch_row($resultn);
		$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
		$resultc=mysql_query($sqlc,$this->conexion);	   
		$rowc= mysql_fetch_row($resultc);
		if ($resultc)
			$carg=$rowc[0];
		else
			$carg='';
		$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$HTML.='<tr class="textoN" '.$color.'>
	  <td>'.$p.'</td>
	  <td><div align="center">'.$row[0].'</div></td>
	  <td><div align="left">'.$rown[0].' '.$rown[1].'</div></td>
	  <td><div align="center">'.$rown[2].'</div></td>
	  <td><div align="left">'.$rowc[0].'</div></td>
	  <td><div align="left">'.$row[1].'</div></td>
	  <td><div align="left">'.$row[2].'</div></td>
	</tr>';
	}
    $HTML.='<tr><td colspan="7">&nbsp;</td></tr><tr><td colspan="7">&nbsp;</td></tr></table>';

	}
	else
	{$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
	  <td>-</td>
	  <td><div align="center">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="center">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="left">-</div></td>
	  <td><div align="left">-</div></td>
	</tr><tr><td colspan="7">&nbsp;</td></tr></table>';
	
	}	
	
	return $HTML;
}
function grupo_etario($e,$a,$m,$et)
{ 
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$sql="SELECT slc_paciente_id_paciente, CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date )) THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
		WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad FROM slc_paciente, slc_visita WHERE id_paciente=slc_paciente_id_paciente and id_empresa = '$e' 
			and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC ";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
	$e1=0; $e2=0; $e3=0; $e4=0; $e5=0;
	while ($row = mysql_fetch_row($result))
	{	
 		//if(($row[1]>=51) && ($row[1]<=60))
		if($row[1]>=51)
			$e1+=1;
		if(($row[1]>=41) && ($row[1]<=50))
			$e2+=1;
		if(($row[1]>=31) && ($row[1]<=40))
			$e3+=1;
		 if(($row[1]>=21) && ($row[1]<=30))
			$e4+=1;
	 	if(($row[1]>=15) && ($row[1]<=20))
			$e5+=1;
	}
	//$et=$e1+$e2+$e3+$e4+$e5;
	$pe1=($e1*100)/$et;
	$pe2=($e2*100)/$et;
	$pe3=($e3*100)/$et;
	$pe4=($e4*100)/$et;
	$pe5=($e5*100)/$et;
	$visi= new visita('','','','','','','','','','','','','');   
	if($m==$a)
		     $fema='DEL MES DE '.$visi->nombre_mes(substr($a,4,2)).' DEL AÑO '.substr($a,0,4);
	else		    
		     $fema=' DE LOS MESES DESDE '.$visi->nombre_mes(substr($a,4,2)).'-'.substr($a,0,4).' HASTA '.$visi->nombre_mes(substr($m,4,2)).'-'.substr($m,0,4);
			 
	$HTML.='<table width="660" border="0" align="center">
    <tr class="etiqueta_grande">
      <td colspan="3"><div align="center">TABLA CARACTERISTICAS GENERALES '.$fema.'</div></td>
    </tr>
    <tr class="titulofor">
      <td width="400"><div align="center">GRUPO ETARIO</div></td>
      <td width="130"><div align="center">'.$et.'</div></td>
      <td width="130"><div align="center">%</div></td>
    </tr><tr class="textoN">
	  <td>51-60 Y MÁS</td>
	  <td><div align="left">'.$e1.'</div></td>
	  <td><div align="center">'.number_format($pe1,2).'</div></td>
	</tr>
	<tr class="textoN" bgcolor="#E3E3E6">
	  <td>41-50</td>
	  <td><div align="left">'.$e2.'</div></td>
	  <td><div align="center">'.number_format($pe2,2).'</div></td>
	</tr>
	<tr class="textoN">
	  <td>31-40</td>
	  <td><div align="left">'.$e3.'</div></td>
	  <td><div align="center">'.number_format($pe3,2).'</div></td>
	</tr>
	<tr class="textoN" bgcolor="#E3E3E6">
	  <td>21-30</td>
	  <td><div align="left">'.$e4.'</div></td>
	  <td><div align="center">'.number_format($pe4,2).'</div></td>
	</tr>
	<tr class="textoN">
	  <td>15-20</td>
	  <td><div align="left">'.$e5.'</div></td>
	  <td><div align="center">'.number_format($pe5,2).'</div></td>
	</tr></table>';

	}
	return $HTML.'**'.$et;
}
function grupo_sexo($e,$a,$m,$tp)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$sql="select count(sexo_paciente), sexo_paciente from slc_visita, slc_paciente where id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_paciente_id_paciente=id_paciente and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by sexo_paciente
";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$s1=0; $s2=0; $st=0;	
		$sf=0;
		$sm=0;
		while ($row = mysql_fetch_row($result))
		{	
			if($row[1]=='F')
				$sf=$row[0];
			if($row[1]=='M')
				$sm=$row[0];
			$st+=$row[0];
		}
		$psf=($sf*100)/$st;
		$psm=($sm*100)/$st;
		$HTML.='<table width="660" border="0" align="center">
		<tr class="titulofor">
		  <td width="400"><div align="center">GRUPO POR SEXO</div></td>
		  <td width="130"><div align="center">'.$tp.'</div></td>
		  <td width="130"><div align="center">%</div></td>
		</tr>
		<tr class="textoN">
		  <td>FEMENINO</td>
		  <td><div align="left">'.$sf.'</div></td>
		  <td><div align="center">'.number_format($psf,2).'</div></td>
		</tr>
		<tr class="textoN" bgcolor="#E3E3E6">
		  <td>MASCULINO</td>
		  <td><div align="left">'.$sm.'</div></td>
		  <td><div align="center">'.number_format($psm,2).'</div></td>
		</tr>
		</table>';
	
	}
	return $HTML;
}
function grupo_grado($e,$a,$m,$tp)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr class="titulofor">
		  <td width="400"><div align="center">GRADO DE INSTRUCCIÓN</div></td>
		  <td width="130"><div align="center">'.$tp.'</div></td>
		  <td width="130"><div align="center">%</div></td>
		</tr>';
	$sql="select count(grado_inst_pac), grado_inst_pac from slc_visita, slc_paciente where id_empresa = '$e' and slc_paciente_id_paciente <>'' 
and slc_paciente_id_paciente=id_paciente and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by grado_inst_pac";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$giu=0;
		$gip=0;
		$git=0;
		$got=0;
		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Analfabeto')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Bachiller')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='Primaria')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			if ($row[1]=='Universitario')
			{
				$pgu=($row[0]*100)/$tp;
				$giu=$row[0];
			}
			if ($row[1]=='Postgrado')
			{
				$pgp=($row[0]*100)/$tp;
				$gip=$row[0];
			}
			if ($row[1]=='T. S. U.')
			{
				$pgt=($row[0]*100)/$tp;
				$git=$row[0];
			}
			if ($row[1]=='')
			{
				$pgo=($row[0]*100)/$tp;
				$got=$row[0];
			}
		}
	}
	$HTML.='<tr class="textoN">
			  <td>Analfabeta</td>
			  <td><div align="left">'.$gia.'</div></td>
			  <td><div align="center">'.number_format($pga,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Primaria</td>
			  <td><div align="left">'.$gipr.'</div></td>
			  <td><div align="center">'.number_format($pgpr,2).'</div></td>
			</tr>			
			<tr class="textoN">
			  <td>Bachiller</td>
			  <td><div align="left">'.$gib.'</div></td>
			  <td><div align="center">'.number_format($pgb,2).'</div></td>
			</tr>

			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Universitario</td>
			  <td><div align="left">'.$giu.'</div></td>
			  <td><div align="center">'.number_format($pgu,2).'</div></td>
			</tr>
			<tr class="textoN">
			  <td>Postgrado</td>
			  <td><div align="left">'.$gip.'</div></td>
			  <td><div align="center">'.number_format($pgp,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>T. S. U.</td>
			  <td><div align="left">'.$git.'</div></td>
			  <td><div align="center">'.number_format($pgt,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Otros</td>
			  <td><div align="left">'.$got.'</div></td>
			  <td><div align="center">'.number_format($pgo,2).'</div></td>
			</tr></table>';
	
	return $HTML;
}
function grupo_enfcomunes($e,$a,$m,$tp)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr class="titulofor">
		  <td width="400"><div align="center">ENFERMEDADES COMUNES</div></td>
		  <td width="130"><div align="center">'.$tp.'</div></td>
		  <td width="130"><div align="center">%</div></td>
		</tr>';
	$sql="SELECT count(slc_diagnostico_id_diagnostico), nomb_diagnostico FROM slc_visita, slc_diag_visita, slc_diagnostico WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Comun' and slc_diagnostico_id_diagnostico<>'' and status_visita='A' and id_diagnostico=slc_diagnostico_id_diagnostico ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by slc_diagnostico_id_diagnostico";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$pga=0;
		$p=0;
		while ($row = mysql_fetch_row($result))
		{	
			   $pga=($row[0]*100)/$tp;

			$p++;
			if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$HTML.='<tr class="textoN" '.$color.'>
					  <td>'.$row[1].'</td>
					  <td><div align="left">'.$row[0].'</div></td>
					  <td><div align="center">'.number_format($pga,2).'</div></td>
					</tr>';
		}
	}
	else
	{
				$HTML.='<tr class="textoN" '.$color.'>
					  <td>NO</td>
					  <td><div align="left">0</div></td>
					  <td><div align="center">0.00%</div></td>
					</tr>';
	}
	$HTML.='</table>';
	return $HTML;
}
function grupo_motivo($e,$a,$m,$tp)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr class="titulofor">
		  <td width="400"><div align="center">MOTIVO DE CONSULTA</div></td>
		  <td width="130"><div align="center">'.$tp.'</div></td>
		  <td width="130"><div align="center">%</div></td>
		</tr>';
	$sql="select count(motivo_consulta ), motivo_consulta from slc_visita where id_empresa = '$e' and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by motivo_consulta";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$giu=0;
		$gip=0;
		$git=0;
		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Egreso')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Ingreso')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='Periodico')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			if ($row[1]=='Post-vacacional')
			{
				$pgu=($row[0]*100)/$tp;
				$giu=$row[0];
			}
			if ($row[1]=='Pre-empleo')
			{
				$pgp=($row[0]*100)/$tp;
				$gip=$row[0];
			}
			if ($row[1]=='Pre-vacacional')
			{
				$pgt=($row[0]*100)/$tp;
				$git=$row[0];
			}			
		}
	}
	$HTML.='<tr class="textoN">
			  <td>Egreso</td>
			  <td><div align="left">'.$gia.'</div></td>
			  <td><div align="center">'.number_format($pga,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Periodico</td>
			  <td><div align="left">'.$gipr.'</div></td>
			  <td><div align="center">'.number_format($pgpr,2).'</div></td>
			</tr>			
			<tr class="textoN">
			  <td>Ingreso</td>
			  <td><div align="left">'.$gib.'</div></td>
			  <td><div align="center">'.number_format($pgb,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Post-vacacional</td>
			  <td><div align="left">'.$giu.'</div></td>
			  <td><div align="center">'.number_format($pgu,2).'</div></td>
			</tr>
			<tr class="textoN">
			  <td>Pre-empleo</td>
			  <td><div align="left">'.$gip.'</div></td>
			  <td><div align="center">'.number_format($pgp,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Pre-vacacional</td>
			  <td><div align="left">'.$git.'</div></td>
			  <td><div align="center">'.number_format($pgt,2).'</div></td>
			</tr></table>';
	
	return $HTML;
}
function grupo_result($e,$a,$m,$tp)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr class="titulofor">
		  <td width="400"><div align="center">RESULTADO DE LA CONSULTA</div></td>
		  <td width="130"><div align="center">'.$tp.'</div></td>
		  <td width="130"><div align="center">%</div></td>
		</tr>';
	$sql="select count(conclusion_visita), conclusion_visita from slc_visita where id_empresa = '$e' and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by conclusion_visita";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$giex=0;

		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Apto')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Apto con Limitación')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='No Apto')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			$giex=$tp-($gia+$gib+$gipr);
			$pgex=($giex*100)/$tp;
		}
	}
	$HTML.='<tr class="textoN">
			  <td>Apto</td>
			  <td><div align="left">'.$gia.'</div></td>
			  <td><div align="center">'.number_format($pga,2).'</div></td>
			</tr>
			<tr class="textoN" bgcolor="#E3E3E6">
			  <td>Apto con Limitación</td>
			  <td><div align="left">'.$gib.'</div></td>
			  <td><div align="center">'.number_format($pgb,2).'</div></td>
			</tr>
			<tr class="textoN">
			  <td>No Apto</td>
			  <td><div align="left">'.$gipr.'</div></td>
			  <td><div align="center">'.number_format($pgpr,2).'</div></td>
			</tr>
			<tr class="textoN">
			  <td>N/A</td>
			  <td><div align="left">'.$giex.'</div></td>
			  <td><div align="center">'.number_format($pgex,2).'</div></td>
			</tr></table>';
	
	return $HTML;
}

function patologias($e,$a,$m,$tp,$ec)
{
	$f1=$a.'-'.$m;
	$f2=$a.'-'.$m;
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr><td> </td></tr><tr><td> </td></tr><tr class="etiqueta_grande"><td><div align="center">PATOLOGÍAS SUSCEPTIBLES DE NOTIFICACIÓN EN INPSASEL</div></td></tr>
		  <tr><td></td></tr>
		  <tr class="etiqueta_grande"><td>Posibles enfermedades ocupacionales en estudio</td></tr></table>
    <table width="660" border="0" align="center">
    <tr class="titulofor">
      <td width="550">Enfermedades</td>
	  <td width="50">Cantidad</td>
      <td width="50">%</div></td>
    </tr>
    <tr>';
	$sql="SELECT count(slc_diagnostico_id_diagnostico) FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita and (tipo_diag_visita='Enfermedad Laboral' or tipo_diag_visita='Accidente Laboral') and slc_diagnostico_id_diagnostico<>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$row = mysql_fetch_row($result);
		if($row[0]>0)
		{
			$res='SI';
			$cant=$row[0];
			//$por=($row[0]*100)/($row[0]+$ec);
			$por=($row[0]*100)/$tp;
		}
		else		
		{
			$res='NO';
			$cant=0;
			$por=0;
		}
  	}
$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
					  <td width="550">'.$res.'</td>
					  <td width="50">'.$cant.'</td>
					  <td width="50">'.number_format($por,2).'%</td>
					</tr></table>';
	return $HTML;
}
function relacion_mot_dia($e,$a,$m,$tp)
{
	$HTML.='<table width="660" border="0" align="center">
		<tr><td> </td></tr><tr><td> </td></tr>
		  <tr><td></td></tr>
		  <tr class="etiqueta_grande"><td>Relación del motivo de consulta y diagnostico</td></tr></table>
    <table width="660" border="0" align="center">
    <tr class="titulofor">
      <td width="200">Nombre</td>
	  <td width="200">Diagnóstico</td>
      <td width="200">Conclusión</div></td>
	  <td width="50">Chequeo</div></td>
    </tr>
    <tr>';
	$sql="select slc_paciente_id_paciente, nomb_diagnostico, conclusion_visita FROM slc_visita, slc_diag_visita, slc_diagnostico where id_empresa = '$e' AND MONTH( fecha_ing_visita ) = '$m' AND left( fecha_ing_visita, 4 ) = '$a' and slc_paciente_id_paciente <>'' and status_visita='A' and slc_visita_id_visita=id_visita and slc_diagnostico_id_diagnostico<>'' and id_diagnostico=slc_diagnostico_id_diagnostico";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;

		while ($row = mysql_fetch_row($result))
		{	
			$sqln="SELECT  nom1_paciente, ape1_paciente FROM slc_paciente WHERE (id_paciente='$row[0]' OR ced_paciente='$row[0]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
					  <td width="200">'.$rown[0].' '.$rown[1].'</td>
					  <td width="200">'.$row[1].'</td>
					  <td width="200">'.$row[2].'</td>
					  <td width="50">-</td>
					</tr>';
		}
	

	}
	else
	{
		$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
				  <td width="200">-</td>
				  <td width="200">-</td>
				  <td width="200">-</td>
				  <td width="50">-</td>
				</tr>';
	}
	$HTML.='<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4"><span aling="justify"><span class="texto">PATOLOGÍAS NO REPORTADAS POR EL TRABAJADOR EN EL MOMENTO DEL INCIDENTE, PERO DIAGNOSTICADAS EN LA CONSULTA, LA CUAL AMERITAN SER INVESTIGADAS Y NOTIFICADAS DE INMEDIATO A INPSASEL COMO </span><span class="textoN">POSIBLE ENFERMEDAD OCUPACIONAL EN ESTUDIO O INVESTIGACIÓN.</span></span></td></tr><tr><td colspan="4">&nbsp;</td></tr></table>';
	return $HTML;
}
function relacion_enf_dis($e,$a,$m,$tp,$ccom)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$HTML.='<table width="660" border="0" align="center">
		<tr><td> </td></tr><tr><td> </td></tr><tr class="etiqueta_grande"><td>
		<div align="center">PATOLOGÍAS SUSCEPTIBLES DE CERTIFICACIÓN DE LA CONDICIÓN DE LA PERSONA CON DISCAPACIDAD</div></td></tr>
		  <tr><td></td></tr>
		  <tr class="etiqueta_grande"><td>Relación de la Enfermedad y la Discapacidad</td></tr></table>
    <table width="660" border="0" align="center">
    <tr class="titulofor">
      <td width="200">Nombre</td>
	  <td width="200">C.I.</td>
      <td width="200">Cargo</div></td>
    </tr>
    <tr>';
	$sql="select slc_paciente_id_paciente, nomb_diagnostico, conclusion_visita from slc_visita,slc_diag_visita, slc_diagnostico where id_empresa = '$e' and slc_paciente_id_paciente <>'' and status_visita='A' and tipo_diag_visita='Discapacidad Certificada' and slc_visita_id_visita=id_visita and slc_diagnostico_id_diagnostico<>'' and id_diagnostico=slc_diagnostico_id_diagnostico ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
   
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$p=0;
		while ($row = mysql_fetch_row($result))
		{	
		$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente, cargo_pac FROM slc_paciente,slc_paciente_empresa WHERE (id_paciente='$row[0]' OR ced_paciente='$row[0]') and id_paciente=slc_empleado_id_paciente";
		$resultn=mysql_query($sqln,$this->conexion);	   
		$rown = mysql_fetch_row($resultn);
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$HTML.='<tr class="textoN" '.$color.'>
					  <td width="200">'.$rown[0].' '.$rown[1].'</td>
					  <td width="200">'.$rown[2].'</td>
					  <td width="200">'.$rown[3].'</td>
					</tr>';
		}
	

	}
	else
	{
		$HTML.='<tr class="textoN" bgcolor="#E3E3E6">
      <td width="200">-</td>
	  <td width="200">-</td>
      <td width="200">-</div></td>
	  <td width="50">-</div></td>
				</tr>';
	}
	if($ccom==0)
		$com="PATOLOGÍAS AMERITAN SER INVESTIGADAS Y NOTIFICADAS AL CONSEJO NACIONAL PARA PERSONAS CON DISCAPACIDAD.";
	else
		$com=$_POST["com4"];
	$HTML.='<tr><td colspan="3" align="center">&nbsp;</td></tr>
	<tr><td colspan="3"><textarea name="com4" cols="125" rows="3" class="texto">'.$com.'</textarea></td></tr><tr><td colspan="4">&nbsp;</td></tr></table>';
	return $HTML;
}
///////////////////////VIGILANCIA PDF///////////////////////
function inf_empresa_pdf($e,$a,$m)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	   
	$sql="select count(id_visita), nom_empresa  
	from slc_visita, slc_empresa where slc_visita.id_empresa='$e' 
	and  slc_visita.id_empresa= slc_empresa.id_empresa  and status_visita='A' ".$cond." group by slc_visita.id_empresa";
	
	$result=mysql_query($sql,$this->conexion);
	$row = mysql_fetch_row($result);
		if ($result) 
		{	
		   // 0- Nombre de la Empresa
		   // 1- Nombre del mes de vigilancia
		   // 2- Nombre del mes de informe
		   //$HTML='';
		   $HTML[0]=$row[1];
		   $HTML[1]=$this->nombre_mes($m);
		   $HTML[2]=$this->nombre_mes($m+1);
		   return $HTML;
		}
		else
		return false;
}

function enfermedades_accidentes_pdf($e, $a, $m)
{
	$asis=0;
	$san=0;
	$enf=0;	
	$enfc=0;
	$enfl=0;
	$ac=0;
	$al=0;
	$mini=1;
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	
	if(substr($a,0,4)!=substr($m,0,4))
	  {$mini=substr($a,4,2);
	   $m=12;}
	 else
	   {$mini=substr($a,4,2);
	    $m=substr($m,4,2);}
	$mes=substr($a,4,2)-1;	   
	$ano=substr($a,0,4);	   
	for($i=$mini;$i<=$m;$i++)
	{	//ENFERMEDADES COMUNES
		$mes++;
		if($mes>12)
		  if(substr($a,0,4)<=substr($m,0,4))
		     {$mes=1;
			 $ano++;}
			 
		if(strlen($mes)==1) $mes='0'.$mes;
		
	   $cond=" and fecha_ing_visita>='".$ano."-".$mes."-01 00:00:00' and fecha_ing_visita<='".$ano."-".$mes."-31 24:00:00' ";	   
		$sql="SELECT count(id_visita) 
			FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e'  
			and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita 
			and tipo_diag_visita='Enfermedad Comun' 
			and slc_diagnostico_id_diagnostico<>'' and slc_diagnostico_id_diagnostico>0
			and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
		
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
		if($n>0)
		{ 
			$row = mysql_fetch_row($result);
			$enfc=$row[0];
		}
		else
			$enfc=0;
		//////////////////////////////
		//ENFERMEDADES OCUPACIONALES/////////////
		$sql="SELECT count(id_visita) 
		FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' 
		and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita 
		and tipo_diag_visita='Enfermedad Laboral' and slc_diagnostico_id_diagnostico<>'' 
		and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
		
		$result=mysql_query($sql,$this->conexion);
		 $n=mysql_num_rows($result);
		 if($n>0)
		{ 
			$row = mysql_fetch_row($result);
			$enfl=$row[0];
		}
		else
			$enfl=0;
		/////////////////////
		//ACCIDENTES COMUNES/////////////
		$sql="SELECT count(id_visita) 
		FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' 
		and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita 
		and tipo_diag_visita='Accidente Comun' and slc_diagnostico_id_diagnostico<>'' 
		and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
		if($n>0)
		{ 
			$row = mysql_fetch_row($result);
			$ac=$row[0];
		}
		else
			$ac=0;
		/////////////////////
		//ACCIDENTES LABORALES/////////////
		$sql="SELECT count(id_visita) 
		FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' 
		and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita 
		and tipo_diag_visita='Accidente Laboral' and slc_diagnostico_id_diagnostico<>'' 
		and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
		if($n>0)
		{ 
			$row = mysql_fetch_row($result);
			$al=$row[0];
		}
		else
			$al=0;
		/////////////////////
		$HTML[$i][0]=$ac;
		$HTML[$i][1]=$al;
		$HTML[$i][2]=$enfc;
		$HTML[$i][3]=$enfl;
		$HTML[$i][4]=$this->nombre_mes($i);
		
	}
	$i++;
	$sql1="select count(id_visita) from slc_visita, slc_diag_visita  
	where id_empresa='$e'  
	and slc_paciente_id_paciente <>'' and status_visita='A' and slc_visita_id_visita=id_visita 
	and (slc_diagnostico_id_diagnostico='1' or slc_diagnostico_id_diagnostico='2') ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result1=mysql_query($sql1,$this->conexion);
	$row1 = mysql_fetch_row($result1);
	if ($result1)
	{
		$san=$row1[0];
	}
	$sqla="select count(id_visita) from slc_visita  where id_empresa='$e' 
	and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$resulta=mysql_query($sqla,$this->conexion);
	$rowa = mysql_fetch_row($resulta);
	if ($resulta)
	{
		$asis=$rowa[0];
	}		
	$sqlns="SELECT count(distinct id_visita) FROM slc_visita, slc_diag_visita 
	WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' 
	and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Comun' 
	and slc_diagnostico_id_diagnostico<>'' and slc_diagnostico_id_diagnostico>=3 and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$resultns=mysql_query($sqlns,$this->conexion);
	$rowns = mysql_fetch_row($resultns);
	if ($resultns)
	{
		$nosan=$rowns[0];
	}	
	$HTML[$i][0]=$san;
	$HTML[$i][1]=$asis;
	$HTML[$i][2]=$nosan;
	$HTML[$i][3]=$enfc;
	$HTML[$i][4]='';
	
	return $HTML;
} 

function resultado_examenes_pdf($e,$a,$m)
{
   $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT  fecha_ing_visita, motivo_consulta, conclusion_visita, slc_paciente_id_paciente 
		FROM slc_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' 
		and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC ";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($result) 
	{ 
		$p=0;	   	
		while ($row = mysql_fetch_row($result))
		{	
			$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
			$resultc=mysql_query($sqlc,$this->conexion);	   
			$rowc= mysql_fetch_row($resultc);
			if ($resultc)
				$carg=$rowc[0];
			else
				$carg='';
			$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
			$p++;
			
			$HTML[$p][0]=$p;
			$HTML[$p][1]=$row[0];
			$HTML[$p][2]=$rown[0].' '.$rown[1];
			$HTML[$p][3]=$rown[2];
			$HTML[$p][4]=$rowc[0];
			$HTML[$p][5]=$row[1];
			$HTML[$p][6]=$row[2];
		}
	  	return $HTML;
	}
	else
		return false;
}


function referencias_visitas_pdf($e,$a,$m)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT fecha_ing_visita, motivo_consulta, nomb_esp, slc_paciente_id_paciente,id_visita 
		 FROM slc_visita, slc_ref_visita, slc_especialidad
		 WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' 
		 and slc_visita_id_visita=id_visita and id_esp_ref=id_esp and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." 
		 ORDER BY fecha_ing_visita ASC";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$p=0;	   	
		while ($row = mysql_fetch_row($result))
		{	
			$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
			$resultc=mysql_query($sqlc,$this->conexion);	   
			$rowc= mysql_fetch_row($resultc);
			if ($resultc)
				$carg=$rowc[0];
			else
				$carg='';
			$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
			$p++;
			$HTML[$p][0]=$p;
			$HTML[$p][1]=$row[0];
			$HTML[$p][2]=$rown[0].' '.$rown[1];
			$HTML[$p][3]=$rown[2];
			$HTML[$p][4]=$rowc[0];
			$HTML[$p][5]=$row[1];
			$HTML[$p][6]=$row[2];
		}
	}
	else
	{  		$p=1;
			$HTML[$p][0]='-';
			$HTML[$p][1]='-';
			$HTML[$p][2]='-';
			$HTML[$p][3]='-';
			$HTML[$p][4]='-';
			$HTML[$p][5]='-';
			$HTML[$p][6]='-';	
	}	
	
	return $HTML;
}


function reposos_visitas_pdf($e,$a,$m)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT  fecha_ing_visita, motivo_consulta, repos_visita, slc_paciente_id_paciente FROM slc_visita WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' and repos_visita!=''  and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." ORDER BY fecha_ing_visita ASC ";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$p=0;	   	
		while ($row = mysql_fetch_row($result))
		{	
			$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[3]' OR ced_paciente='$row[3]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$sqlc="SELECT  cargo_pac FROM slc_paciente_empresa WHERE slc_empleado_id_paciente='$row[3]' and slc_empresa_id_empresa='$e'";
			$resultc=mysql_query($sqlc,$this->conexion);	   
			$rowc= mysql_fetch_row($resultc);
			if ($resultc)
				$carg=$rowc[0];
			else
				$carg='';
			$row[0]=substr($row[0],8,2).'/'.substr($row[0],5,2).'/'.substr($row[0],0,4);	 
			$p++;
			
			$HTML[$p][0]=$p;
			$HTML[$p][1]=$row[0];
			$HTML[$p][2]=$rown[0].' '.$rown[1];
			$HTML[$p][3]=$rown[2];
			$HTML[$p][4]=$rowc[0];
			$HTML[$p][5]=$row[1];
			$HTML[$p][6]=$row[2];
		}
	}
	else
	{  		$p=1;
			$HTML[$p][0]='-';
			$HTML[$p][1]='-';
			$HTML[$p][2]='-';
			$HTML[$p][3]='-';
			$HTML[$p][4]='-';
			$HTML[$p][5]='-';
			$HTML[$p][6]='-';	
	}	
	return $HTML;
}


function grupo_etario_pdf($e,$a,$m,$et)
{
	$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT slc_paciente_id_paciente, 
		CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date )) THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
		WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) 
		AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
		THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
		ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
		END AS edad 
		FROM slc_paciente, slc_visita 
		WHERE id_paciente=slc_paciente_id_paciente and id_empresa = '$e' 
		and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"."
		ORDER BY fecha_ing_visita ASC ";
	
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$e1=0; $e2=0; $e3=0; $e4=0; $e5=0; 
		while ($row = mysql_fetch_row($result))
		{	
			if($row[1]>=51)
				$e1+=1;
			if(($row[1]>=41) && ($row[1]<=50))
				$e2+=1;
			if(($row[1]>=31) && ($row[1]<=40))
				$e3+=1;
			 if(($row[1]>=21) && ($row[1]<=30))
				$e4+=1;
			if(($row[1]>=15) && ($row[1]<=20))
				$e5+=1;
		}
		//$et=$e1+$e2+$e3+$e4+$e5;
		$pe1=($e1*100)/$et;
		$pe2=($e2*100)/$et;
		$pe3=($e3*100)/$et;
		$pe4=($e4*100)/$et;
		$pe5=($e5*100)/$et;
		$HTML[0][0]='GRUPO ETARIO'; $HTML[0][1]= $et; $HTML[0][2]='%';
		$HTML[1][0]='51-60 Y MÁS'; 		$HTML[1][1]= $e1; $HTML[1][2]=number_format($pe1,2);
		$HTML[2][0]='41-50'; 		$HTML[2][1]= $e2; $HTML[2][2]=number_format($pe2,2);
		$HTML[3][0]='31-40'; 		$HTML[3][1]= $e3; $HTML[3][2]=number_format($pe3,2);
		$HTML[4][0]='21-30'; 		$HTML[4][1]= $e4; $HTML[4][2]=number_format($pe4,2);
		$HTML[5][0]='15-20'; 		$HTML[5][1]= $e5; $HTML[5][2]=number_format($pe5,2);
	}
	return $HTML;
}


function grupo_sexo_pdf($e,$a,$m,$tp)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="select count(sexo_paciente), sexo_paciente from slc_visita, slc_paciente 
	where id_empresa = '$e' and slc_paciente_id_paciente <>'' 
	and slc_paciente_id_paciente=id_paciente 
	and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"."
	group by sexo_paciente";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$s1=0; $s2=0; $st=0;	
		$sf=0;
		$sm=0;
		while ($row = mysql_fetch_row($result))
		{	
			if($row[1]=='F')
				$sf=$row[0];
			if($row[1]=='M')
				$sm=$row[0];
			$st+=$row[0];
		}
		$psf=($sf*100)/$st;
		$psm=($sm*100)/$st;
		$HTML[0][0]='GRUPO POR SEXO'; 	$HTML[0][1]= $tp; $HTML[0][2]='%';
		$HTML[1][0]='FEMENINO'; 		$HTML[1][1]= $sf; $HTML[1][2]=number_format($psf,2);
		$HTML[2][0]='MASCULINO'; 		$HTML[2][1]= $sm; $HTML[2][2]=number_format($psm,2);
	}
	return $HTML;
}


function grupo_grado_pdf($e,$a,$m,$tp)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="select count(grado_inst_pac), grado_inst_pac from slc_visita, slc_paciente where id_empresa = '$e'
and slc_paciente_id_paciente <>'' 
and slc_paciente_id_paciente=id_paciente and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"." group by grado_inst_pac";

	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$giu=0;
		$gip=0;
		$git=0;
		$got=0;
		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Analfabeto')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Bachiller')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='Primaria')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			if ($row[1]=='Universitario')
			{
				$pgu=($row[0]*100)/$tp;
				$giu=$row[0];
			}
			if ($row[1]=='Postgrado')
			{
				$pgp=($row[0]*100)/$tp;
				$gip=$row[0];
			}
			if ($row[1]=='T. S. U.')
			{
				$pgt=($row[0]*100)/$tp;
				$git=$row[0];
			}
			if ($row[1]=='')
			{
				$pgo=($row[0]*100)/$tp;
				$got=$row[0];
			}
		}
	}


		$HTML[0][0]='GRADO DE INSTRUCCIÓN'; $HTML[0][1]= $tp; $HTML[0][2]='%';
		$HTML[1][0]='ANALFABETA'; 			$HTML[1][1]= $gia; $HTML[1][2]=number_format($pga,2);
		$HTML[2][0]='PRIMARIA'; 			$HTML[2][1]= $gipr; $HTML[2][2]=number_format($pgpr,2);
		$HTML[3][0]='BACHILLER'; 			$HTML[3][1]= $gib; $HTML[3][2]=number_format($pgb,2);
		$HTML[4][0]='T. S. U.'; 			$HTML[4][1]= $git; $HTML[4][2]=number_format($pgt,2);
		$HTML[5][0]='UNIVERSITARIO'; 		$HTML[5][1]= $giu; $HTML[5][2]=number_format($pgu,2);
		$HTML[6][0]='POSTGRADO'; 			$HTML[6][1]= $gip; $HTML[6][2]=number_format($pgp,2);
		$HTML[7][0]='OTROS'; 				$HTML[7][1]= $got; $HTML[7][2]=number_format($pgo,2);
	return $HTML;
}


function grupo_enfcomunes_pdf($e,$a,$m,$tp)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT count(slc_diagnostico_id_diagnostico), nomb_diagnostico 
		FROM slc_visita, slc_diag_visita, slc_diagnostico 
		WHERE id_empresa = '$e' and slc_paciente_id_paciente <>'' 
		and slc_visita_id_visita=id_visita and tipo_diag_visita='Enfermedad Comun' 
		and slc_diagnostico_id_diagnostico<>'' and status_visita='A' 
		and id_diagnostico=slc_diagnostico_id_diagnostico ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"."
		group by slc_diagnostico_id_diagnostico";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	$p=0;
	$HTML[$p][0]='ENFERMEDADES COMUNES';
	$HTML[$p][1]= $tp; 
	$HTML[$p][2]='%';
	if ($n>0) 
	{ 
		$pga=0;
		while ($row = mysql_fetch_row($result))
		{	
			$pga=($row[0]*100)/$tp;
			$p++;
			$HTML[$p][0]=$row[1]; 
			$HTML[$p][1]=$row[0]; 
			$HTML[$p][2]=number_format($pga,2);
		}
	}
	else
	{
			$p=1;
			$HTML[$p][0]='NO'; 
			$HTML[$p][1]='0'; 
			$HTML[$p][2]='0.00%';
	}
	return $HTML;
}


function grupo_motivo_pdf($e,$a,$m,$tp)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="select count(motivo_consulta ), motivo_consulta 
		from slc_visita where id_empresa = '$e'
		and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"."
		group by motivo_consulta";
  
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$giu=0;
		$gip=0;
		$git=0;
		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Egreso')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Ingreso')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='Periodico')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			if ($row[1]=='Post-vacacional')
			{
				$pgu=($row[0]*100)/$tp;
				$giu=$row[0];
			}
			if ($row[1]=='Pre-empleo')
			{
				$pgp=($row[0]*100)/$tp;
				$gip=$row[0];
			}
			if ($row[1]=='Pre-vacacional')
			{
				$pgt=($row[0]*100)/$tp;
				$git=$row[0];
			}			
		}
	}
	$HTML[0][0]='MOTIVO DE CONSULTA'; 	$HTML[0][1]= $tp; $HTML[0][2]='%';
	$HTML[1][0]='EGRESO'; 				$HTML[1][1]= $gia; $HTML[1][2]=number_format($pga,2);
	$HTML[2][0]='PERIODICO'; 			$HTML[2][1]= $gipr; $HTML[2][2]=number_format($pgpr,2);
	$HTML[3][0]='INGRESO'; 				$HTML[3][1]= $gib; $HTML[3][2]=number_format($pgb,2);
	$HTML[4][0]='PRE-VACACIONAL'; 		$HTML[4][1]= $git; $HTML[4][2]=number_format($pgt,2);
	$HTML[5][0]='POST-VACACIONAL'; 		$HTML[5][1]= $giu; $HTML[5][2]=number_format($pgu,2);
	$HTML[6][0]='PRE-EMPLEO'; 			$HTML[6][1]= $gip; $HTML[6][2]=number_format($pgp,2);
	return $HTML;
}


function grupo_result_pdf($e,$a,$m,$tp)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="select count(conclusion_visita), conclusion_visita 
		from slc_visita where id_empresa = '$e'
		and slc_paciente_id_paciente <>'' and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")"."
		group by conclusion_visita";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;

		while ($row = mysql_fetch_row($result))
		{	
			if ($row[1]=='Apto')
			{
				$pga=($row[0]*100)/$tp;
				$gia=$row[0];
			}
			if ($row[1]=='Apto con Limitación')
			{
				$pgb=($row[0]*100)/$tp;
				$gib=$row[0];
			}
			if ($row[1]=='No Apto')
			{
				$pgpr=($row[0]*100)/$tp;
				$gipr=$row[0];
			}
			$giex=$tp-($gia+$gib+$gipr);
			$pgex=($giex*100)/$tp;
		}
	}
	$HTML[0][0]='RESULTADO DE LA CONSULTA'; $HTML[0][1]= $tp; $HTML[0][2]='%';
	$HTML[1][0]='APTO'; 					$HTML[1][1]= $gia; $HTML[1][2]=number_format($pga,2);
	$HTML[2][0]='APTO CON LIMITACIÓN'; 		$HTML[2][1]= $gib; $HTML[2][2]=number_format($pgb,2);
	$HTML[3][0]='NO APTO'; 					$HTML[3][1]= $gipr; $HTML[3][2]=number_format($pgpr,2);
	$HTML[4][0]='N/A'; 						$HTML[4][1]= $giex; $HTML[4][2]=number_format($pgex,2);
	return $HTML;
}


function patologias_pdf($e,$a,$m,$tp,$ec)
{
    $f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	
	$sql="SELECT count(slc_diagnostico_id_diagnostico) 
		FROM slc_visita, slc_diag_visita WHERE id_empresa = '$e' 
		and slc_paciente_id_paciente <>'' and slc_visita_id_visita=id_visita 
		and (tipo_diag_visita='Enfermedad Laboral' or tipo_diag_visita='Accidente Laboral') and slc_diagnostico_id_diagnostico<>''
		and status_visita='A' ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$row = mysql_fetch_row($result);
		if($row[0]>0)
		{
			$res='SI';
			$cant=$row[0];
			$por=($row[0]*100)/$tp;
		}
		else		
		{
			$res='NO';
			$cant=0;
			$por=0;
		}
  	}
	$HTML[0]=$res;
	$HTML[1]=$cant;
	$HTML[2]=number_format($por,2);
	return $HTML;
}


function relacion_mot_dia_pdf($e,$a,$m,$tp)
{
	$sql="select slc_paciente_id_paciente, nomb_diagnostico, conclusion_visita 
		FROM slc_visita, slc_diag_visita, slc_diagnostico 
		where id_empresa = '$e' AND MONTH( fecha_ing_visita ) = '$m' 
		AND left( fecha_ing_visita, 4 ) = '$a' and slc_paciente_id_paciente <>'' 
		and status_visita='A' and slc_visita_id_visita=id_visita 
		and slc_diagnostico_id_diagnostico<>'' 
		and id_diagnostico=slc_diagnostico_id_diagnostico";
	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$gia=0;
		$gipr=0;
		$gib=0;
		$p=0;
		while ($row = mysql_fetch_row($result))
		{	
			$p++;
			$sqln="SELECT  nom1_paciente, ape1_paciente FROM slc_paciente 
				WHERE (id_paciente='$row[0]' OR ced_paciente='$row[0]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$HTML[$p][0]=$rown[0].' '.$rown[1];
			$HTML[$p][1]=$row[1];
			$HTML[$p][2]=$row[2];
			$HTML[$p][3]='-';
		}
	}
	else
	{
		$HTML[$p][0]='-';
		$HTML[$p][1]='-';
		$HTML[$p][2]='-';
		$HTML[$p][3]='-';
	}
	return $HTML;
}


function relacion_enf_dis_pdf($e,$a,$m,$tp)
{
$f1=substr($a,0,4).'-'.substr($a,4,2);
	$f2=substr($m,0,4).'-'.substr($m,4,2);
	$condExtra = "SELECT id_servicio FROM slc_servicio where status_servicio = 'A' and vigilan_servicio = 'S' and elimina_servicio = 0";
	if($f1==$f2)
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f1."-31 24:00:00' ";
	 else
	   $cond=" and fecha_ing_visita>='".$f1."-01 00:00:00' and fecha_ing_visita<='".$f2."-31 24:00:00' ";
	$sql="select slc_paciente_id_paciente, nomb_diagnostico, conclusion_visita 
			from slc_visita,slc_diag_visita, slc_diagnostico where id_empresa = '$e'
and slc_paciente_id_paciente <>'' and status_visita='A' 
and tipo_diag_visita='Discapacidad Certificada' 
and slc_visita_id_visita=id_visita and slc_diagnostico_id_diagnostico<>'' 
and id_diagnostico=slc_diagnostico_id_diagnostico ".$cond." and slc_servicio_id_servicio in (".$condExtra.")";

	$result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);
	if ($n>0) 
	{ 
		$p=0;
		while ($row = mysql_fetch_row($result))
		{	
			$sqln="SELECT  nom1_paciente, ape1_paciente, ced_paciente FROM slc_paciente WHERE (id_paciente='$row[0]' OR ced_paciente='$row[0]')";
			$resultn=mysql_query($sqln,$this->conexion);	   
			$rown = mysql_fetch_row($resultn);
			$p++;
			$HTML[$p][0]=$rown[0].' '.$rown[1];
			$HTML[$p][1]=$row[0];
			$HTML[$p][2]=$row[2];
			$HTML[$p][3]='-';
		}
	}
	else
	{
		$p=1;
		$HTML[$p][0]='-';
		$HTML[$p][1]='-';
		$HTML[$p][2]='-';
		$HTML[$p][3]='-';
	}
	return $HTML;
}

/////////////////////////////////

function mod_emp_visita()
{
	$fecha= date("Y-m-d h:i:s");
	$sql="UPDATE slc_visita SET id_empresa='$this->emp' WHERE id_visita ='$this->idv'";
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	   return true;
	else
	   return false;
}// fin de funcion  modificar empresa de la visita


function mod_mot_visita()
{
	$fecha= date("Y-m-d h:i:s");
	$sql="UPDATE slc_visita SET motivo_consulta='$this->mot' WHERE id_visita ='$this->idv'";
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	   return true;
	else
	   return false;
}// fin de funcion  modificar empresa de la visita

function mod_medico_visita()
{
	$fecha= date("Y-m-d h:i:s");
	$sql="UPDATE slc_visita SET ced_especialista='$this->esp' WHERE id_visita ='$this->idv'";
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	   return true;
	else
	   return false;
}// fin de funcion  modificar medico de la visita

function lista_todos_diagnosticos($f1,$f2)
{
     $sql=" ";
	 $sql="SELECT nomb_diagnostico,
                  COUNT(*)
		   FROM slc_visita, 
     			slc_paciente, 
     			slc_medico, 
     			slc_servicio,
     			slc_diag_visita, 
     			slc_diagnostico
		   WHERE id_paciente = slc_paciente_id_paciente			
     			 and (ced_especialista = ced_rif_medico or ced_especialista='0') 	
     			 and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
     			 and slc_diagnostico_id_diagnostico=id_diagnostico
     			 and slc_visita_id_visita=id_visita
     			 and fecha_ing_visita>='".$f1." 00:00:00'
				 and fecha_ing_visita<='".$f2." 24:00:00'
		   GROUP BY nomb_diagnostico
		   ORDER BY count(*) desc";
    $result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);	
	if ($n>0) 
	{ 
	 $p=0;	   	
	 $acu=0;
	 while ($row = mysql_fetch_row($result))
	 {	
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$html.= '<tr class="textoN" '.$color.'>	  
	              <td><div align="center">'.$row[0].'</div></td>
	              <td><div align="center">'.$row[1].'</div></td>	 
	           </tr>';
		$acu+=$row[1];
			   
	  }
	  $html.= '<tr class="titulofor">
      			<td width="10"><div align="center">TOTAL</div></td>
      			<td width="50"><div align="center">'.$acu.'</div></td>      			
    		 </tr>';
	
	}else
	   return false;
	return $html;   
  
}
function lista_diagnosticos_x_med($f1,$f2,$med)
{
     $sql=" ";
	 $sql="SELECT nomb_diagnostico,
                  COUNT(*)
		   FROM slc_visita, 
     			slc_paciente, 
     			slc_medico, 
     			slc_servicio,
     			slc_diag_visita, 
     			slc_diagnostico
		   WHERE id_paciente = slc_paciente_id_paciente			
     			 and (ced_especialista = ced_rif_medico or ced_especialista='0') 	
     			 and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
     			 and slc_diagnostico_id_diagnostico=id_diagnostico
     			 and slc_visita_id_visita=id_visita
     			 and fecha_ing_visita>='".$f1." 00:00:00'
				 and fecha_ing_visita<='".$f2." 24:00:00'
				 and ced_especialista='".$med."'
		   GROUP BY nomb_diagnostico
		   ORDER BY count(*) desc";
    $result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);	
	if ($n>0) 
	{ 
	 $p=0;	 
	 $acu=0;  	
	 while ($row = mysql_fetch_row($result))
	 {	
		$p++;		
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$html.= '<tr class="textoN" '.$color.'>	  
	              <td><div align="center">'.$row[0].'</div></td>
	              <td><div align="center">'.$row[1].'</div></td>	 
	           </tr>';
			   $acu+=$row[1];
	  }
	  $html.= '<tr class="titulofor">
      			<td width="10"><div align="center">TOTAL</div></td>
      			<td width="50"><div align="center">'.$acu.'</div></td>      			
    		 </tr>';
	}else
	   return false;
	return $html;   
  
}
function lista_medicos_x_diag($f1,$f2,$diag)
{
     $sql=" ";
	 $sql="SELECT nomb_medico,
                  COUNT(*)
		   FROM slc_visita, 
     			slc_paciente, 
     			slc_medico, 
     			slc_servicio,
     			slc_diag_visita, 
     			slc_diagnostico
		   WHERE id_paciente = slc_paciente_id_paciente			
     			 and (ced_especialista = ced_rif_medico or ced_especialista='0') 	
     			 and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
     			 and slc_diagnostico_id_diagnostico=id_diagnostico
     			 and slc_visita_id_visita=id_visita
     			 and fecha_ing_visita>='".$f1." 00:00:00'
				 and fecha_ing_visita<='".$f2." 24:00:00'
				 and slc_diagnostico_id_diagnostico=".$diag."
		   GROUP BY nomb_medico
		   ORDER BY count(*) desc";
    $result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);	
	if ($n>0) 
	{ 
	 $p=0;	   	
	 $acu=0;
	 while ($row = mysql_fetch_row($result))
	 {	
		$p++;
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		$html.= '<tr class="textoN" '.$color.'>	  
	              <td><div align="center">'.$row[0].'</div></td>
	              <td><div align="center">'.$row[1].'</div></td>	 
	           </tr>';
			   $acu+=$row[1];
	  }
	  $html.= '<tr class="titulofor">
      			<td width="10"><div align="center">TOTAL</div></td>
      			<td width="50"><div align="center">'.$acu.'</div></td>      			
    		 </tr>';
	}else
	   return false;
	return $html;   
  
}
function cantidad_diag_x_medico($f1,$f2,$diag,$med)
{
     $sql=" ";
	 $sql="SELECT COUNT(*)                  
		   FROM slc_visita, 
     			slc_paciente, 
     			slc_medico, 
     			slc_servicio,
     			slc_diag_visita, 
     			slc_diagnostico
		   WHERE id_paciente = slc_paciente_id_paciente			
     			 and (ced_especialista = ced_rif_medico or ced_especialista='0') 	
     			 and slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
     			 and slc_diagnostico_id_diagnostico=id_diagnostico
     			 and slc_visita_id_visita=id_visita
     			 and fecha_ing_visita>='".$f1." 00:00:00'
				 and fecha_ing_visita<='".$f2." 24:00:00'
				 and slc_diagnostico_id_diagnostico=".$diag."
				 and ced_especialista=".$med;
    $result=mysql_query($sql,$this->conexion);
	$n=mysql_num_rows($result);	
	if ($n>0) 
	{ 
	 $p=0;	 
	 $acu=0;  	
	 while ($row = mysql_fetch_row($result))
	 {	
		$p++;		
		if ($p%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		 $html.= '<tr class="titulofor">
      		   	     <td width="10"><div align="center">CANTIDAD PACIENTES ATENDIDOS</div></td>
      			     <td width="50"><div align="center">'.$row[0].'</div></td>      			
    		      </tr>';
				  $acu+=$row[1];
			  }
			  $html.= '<tr class="titulofor">
      			<td width="10"><div align="center">TOTAL</div></td>
      			<td width="50"><div align="center">'.$acu.'</div></td>      			
    		 </tr>';
	}else
	   return false;
	return $html;   
  
}

}// fin de la clase visita


?>
