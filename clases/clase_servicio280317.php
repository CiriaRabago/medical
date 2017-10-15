<?php 
/* 
CLASE SERVICIOS
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS SERVICIOS
*/

/* DECLARACIÓN DE LA CLASE */
class servicio
{
   var $cod;
   var $nom;
   var $des;
   var $sta;
   var $age;
   var $vig;
   var $ico;
   var $pre;
   
/* FUNCIÓN CONSTRUCTORA */  
   function servicio($c, $n, $d, $s, $a, $v, $i, $p)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
   		$this->des=$d;
		$this->sta=$s;
		$this->age=$a;
		$this->vig=$v;
		$this->ico=$i;
		$this->pre=$p;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN SERVICIO */  	
	function ins_servicio()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
		$usu=$_SESSION['cedu_usu'];
	   	$sql="INSERT INTO slc_servicio (nomb_servicio, desc_servicio, 
			status_servicio,agenda_servicio,vigilan_servicio,
			icono_servicio,precio_servicio,
			fecha_ing_servicio,usuario_servicio) 
			VALUES (upper('$this->nom'), upper('$this->des'), 
			upper('$this->sta'), upper('$this->age'), upper('$this->vig'),
			'$this->ico', '$this->pre','$hoy','$usu')";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			$sqlp="insert into slc_precios (id_servicio,precio,fecha_ing_precio,fecha_fin_precio,usuario) select last_insert_id(), '$this->pre','$hoy',NULL,'$usu' from dual";
			$resultp=mysql_query($sqlp,$this->conexion);
			if ($resultp) 
			{
			  $sqlid="select last_insert_id() from dual"; 
			  $resultid=mysql_query($sqlid,$this->conexion);
			  if($resultid)
			  {			  
			  		$rowid = mysql_fetch_row($resultid);
			  		return $rowid[0];
			  }
			}
			else
				return false;
		}
		else
			   return false;
	} // fin de funcion  insertar servicios

	function cambio_de_precio($pr,$pe,$us)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="UPDATE slc_precios SET  fecha_fin_precio='$hoy' where id_servicio='$pe' and fecha_fin_precio is NULL";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			$sqlp="INSERT INTO slc_precios (precio, fecha_ing_precio, usuario,id_perfil) VALUES ('$pr', '$hoy','$us', '$pe')";
			$resultp=mysql_query($sqlp,$this->conexion);
			if ($resultp) 
			{
			   return true;
			}
			else
				return false;
		}
		else
			   return false;
	} // fin de funcion  insertar servicios


function modf_servicio()
	{
	   	$sql="UPDATE slc_servicio SET nomb_servicio= upper('$this->nom'), 
		     desc_servicio= upper('$this->des'), precio_servicio='$this->pre', agenda_servicio=upper('$this->age'), vigilan_servicio=upper('$this->vig')
			 WHERE id_servicio='$this->cod'";
			 //echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE SERVICIOS EXISTENTES */  		
	function ver_servicios()
	{
	   	$sql="SELECT id_servicio, nomb_servicio, desc_servicio, agenda_servicio, vigilan_servicio, precio_servicio 
		      from slc_servicio where elimina_servicio=0 order by nomb_servicio";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Nombre</div></td>
				<td width="250"><div align="left">Descripción</div></td>
				<td width="50"><div align="left">Posee Agenda</div></td>
				<td width="50"><div align="left">Vigilancia</div></td>
				<td width="60"><div align="left">Precio</div></td>
				<td width="20"><div align="left">&nbsp;</div></td>
				<td width="20"><div align="left">&nbsp;</div></td>
			  </tr>';

		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
			if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$this->cod=$row[0];
			$produc=$this->consul_prod_serv();
			$nume_prods=mysql_num_rows($produc);
			if($produc!=false && ($nume_prods>0))
			{ $dp='style="cursor:hand" onClick="ver_ser('.$row[0].')"';
			  $imag='<img src="imagenes/vineta.gif" width="16" height="8" /> ';
			 }	else 
			 { $dp='';
			   $imag='&nbsp; ';
			 }
			if($row[3]=='S') $agenda='SI'; else $agenda='NO';
			if($row[4]=='S') $vigilancia='SI'; else $vigilancia='NO';
			$HTML.='<tr '.$color.'>
				<td '.$dp.'class="texto" align="left">'.$imag.$row[1].'</td>
				<td class="texto">'.$row[2].'</td>
				<td class="texto">'.$agenda.'</td>
				<td class="texto">'.$vigilancia.'</td>
				<td class="texto"><div align="right">'.$row[5].'</div></td>
				<td class="texto"><div align="center" style="display:block"><img src="imagenes/edit.gif" style="cursor:hand" alt="Modificar Servicio" title="Modificar Servicio" onclick="modif('.$row[0].');" /></div></td>
                <td class="texto"><div align="center" style="display:block"><img src="imagenes/delete.gif" style="cursor:hand" alt="Eliminar Servicio" title="Eliminar Servicio"   onclick="elim('.$row[0].');" /></div></td>
				</tr>
				<tr '.$color.'>
				<td colspan="6"><div id="servi'.$row[0].'" align="center" style="display:none">';
				if($produc!=false && ($nume_prods>0))
				{  
					$HTML.='<table width="400" border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:#F9D5B2; border:border-width:thin; border-style: double; border-color: #F0953D">';
					while ($row2 = mysql_fetch_row($produc))
		        	{ $HTML.='<tr class="texto"><td width="320"><div align="left">'.$row2[0].'</div></td>
						<td width="80"><div align="left">'.$row2[1].'</div></td></tr>'; }
					  $HTML.='</table>'; 
				 }
				$HTML.='</div></td></tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver servicios


	function ver_serv()
	{
	   	$sql="SELECT id_servicio, nomb_servicio, desc_servicio, precio_servicio, agenda_servicio, vigilan_servicio
		      from slc_servicio 
			  where id_servicio=$this->cod";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
			$row = mysql_fetch_row($result);
			return $row;
		 }
		 else
		 	return false;
	} // fin de funcion ver servicios


/* FUNCIÓN PARA LLENAR COMBO DE SERVICIOS */  		
	function combo_servicios()
	{
	   	$sql="SELECT 
			id_servicio, 
			nomb_servicio
			from slc_servicio
			where elimina_servicio='0'
			order by nomb_servicio";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    if($this->cod=="")
		      $sel='';
			else
			  if($row[0]==$this->cod)
			     $sel="selected='selected'";
			  else	  
			     $sel=''; 
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion combo de servicios


	function ins_prod($sh,$ord)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
		$usu=$_SESSION['cedu_usu'];
		$sql="insert into slc_servicio_prod
				(id_serv_padre,
				 id_serv_hijo,
				 orden_sp,
				 fecha_ing_sp,
				 usuario_sp)
				values($this->cod,$sh,$ord,'$hoy','$usu')";
				//echo $sql.'<br>';
				
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}	



	function eli_prod($sh)
	{
		$usu=$_SESSION['cedu_usu'];
		$sql="delete from slc_servicio_prod
		where id_serv_padre=$this->cod
		and id_serv_hijo=$sh";
				//echo $sql.'<br>';
				
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return true;
		}
		else
			return false;
	}	

	function mod_prod($sh,$om)
	{
		$usu=$_SESSION['cedu_usu'];
		$sql="update slc_servicio_prod
		set orden_sp=$om
		where id_serv_padre=$this->cod
		and id_serv_hijo=$sh";
		//echo $sql.'<br>';
				
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return true;
		}
		else
			return false;
	}	


	function consul_prod_serv()
	{
	   	$sql="SELECT s.nomb_servicio, 
		s.precio_servicio, 
		sp.orden_sp, 
		sp.id_serv_padre,
		sp.id_serv_hijo
		from slc_servicio_prod sp, 
		slc_servicio s
		where sp.id_serv_padre=$this->cod
		and s.id_servicio=sp.id_serv_hijo
		order by sp.orden_sp";
		//echo $sql;

		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}

	function consul_prod_serv_no()
	{
	   	$sql="SELECT s.nomb_servicio, s.precio_servicio, s.id_servicio
		from slc_servicio s
		where s.id_servicio not in (
			SELECT sp.id_serv_hijo
			from slc_servicio_prod sp
			where sp.id_serv_padre=$this->cod)
			and s.id_servicio not in ($this->cod)";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}



function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_servicio where nomb_servicio= '$this->nom' and desc_servicio= '$this->des' and precio_servicio=$this->pre and agenda_servicio='$this->age'"; 
	//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
function eliminar()
{
	$sql="delete FROM slc_perfil WHERE id_perfil ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
}
function eliminar_servicio($sql)
{	    
		$result=mysql_query($sql,$this->conexion);		
		if ($result) 
		    {   return true;}
		else 
			{   return false;}

}
	/********** DE AQUI EN ADELANTE CREADAS POR MÓNICA PARA LA VISITA **********/
	function ver_serv_LE()
	{
		$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d", time() + $zone);
		$usu=$_SESSION['cedu_usu'];
		
		/*$sql="SELECT distinct slc_servicio_id_servicio,nomb_servicio, desc_servicio, precio_servicio
		from slc_detalle_visita, slc_servicio,
		(select slc_status_det_visita.slc_detalle_visita_id_det_visita iddv, MAX(fecha_ing_status_dv) fechareg
		 from slc_status_det_visita
		 where DATE(fecha_ing_status_dv)='$hoy'
		 GROUP BY slc_status_det_visita.slc_detalle_visita_id_det_visita) stadetv
		where slc_detalle_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
		and slc_detalle_visita.id_det_visita=stadetv.iddv
		and status_det_visita in ('L','I')
		and DATE(stadetv.fechareg)='$hoy'
		UNION
		SELECT distinct slc_servicio_id_servicio,nomb_servicio, desc_servicio, precio_servicio
		from slc_visita, slc_servicio,
		(select slc_status_det_visita.id_visita iddv, MAX(fecha_ing_status_dv) fechareg
		 from slc_status_det_visita
		 where DATE(fecha_ing_status_dv)='$hoy'
		 AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0
		 GROUP BY slc_status_det_visita.id_visita) stadetv
		where slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
		and slc_visita.id_visita=stadetv.iddv
		and status_visita in ('L','I')
		and DATE(stadetv.fechareg)='$hoy'";
	   	*/
		/*$sql="SELECT distinct slc_servicio_id_servicio,nomb_servicio, desc_servicio, precio_servicio
		from slc_detalle_visita, slc_servicio,
		(select slc_status_det_visita.slc_detalle_visita_id_det_visita iddv, MAX(fecha_ing_status_dv) fechareg
		 from slc_status_det_visita
		 where DATE(fecha_ing_status_dv)='$hoy'
		 GROUP BY slc_status_det_visita.slc_detalle_visita_id_det_visita) stadetv
		where slc_detalle_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
		and slc_detalle_visita.id_det_visita=stadetv.iddv
		and status_det_visita in ('L','I')
		and DATE(stadetv.fechareg)='$hoy'";
		*/
		$sql="SELECT distinct slc_servicio_id_servicio,nomb_servicio, desc_servicio, precio_servicio
		from slc_visita, slc_servicio,
		(select slc_status_det_visita.id_visita iddv, MAX(fecha_ing_status_dv) fechareg
		 from slc_status_det_visita
		 where DATE(fecha_ing_status_dv)='$hoy'
		 AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0
		 GROUP BY slc_status_det_visita.id_visita) stadetv
		where slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
		and slc_visita.id_visita=stadetv.iddv
		and status_visita in ('L','I')
		and DATE(stadetv.fechareg)='$hoy' ORDER BY nomb_servicio";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
		//echo '<br>'.$n.'<br>';
	  	if($n==0)
			   return false;
		else
			   return $result;
	} // fin de funcion ver servicios Lista Espera


	function listado_atenc($des,$has,$serv,$pac,$edo,$emp,$med)
	{
		$stiempo=' ';
		$sserv=' ';
		$spac=' ';
		$sedo=' ';
		$semp=' ';
		$smed=' ';
		
		if($des!='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des'
					  and DATE(fecha_ing_visita)<='$has' ";
		if($des!='' && $has=='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des' ";					  
		if($des=='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)<='$has' ";
		if($stiempo!=' ')
			$stiempo2=$stiempo.' AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';
		else
			$stiempo2=' WHERE slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';

		if($serv!='') 
			$sserv=" AND slc_visita.slc_servicio_id_servicio = $serv ";

		if($pac!='') 
			$spac=" AND ced_paciente = '$pac' ";

		if($edo!='') 
			$sedo=" and status_visita in ('$edo') ";
		
		if($emp!='') 
			$semp=" and id_empresa in ('$emp') ";
			
		if($med!='') 
			$smed=" and ced_especialista in ('$med') ";
			
			$sql="SELECT distinct id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente, fecha_ing_visita,  TIME(fecha_ing_visita), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista, 
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico),
			nomb_servicio, status_visita, motivo_consulta,usuario_visita
			FROM slc_visita, slc_paciente, slc_medico, slc_servicio
			WHERE id_paciente = slc_paciente_id_paciente
			 ".$sserv.$stiempo.$sedo.$spac.$semp.$smed." 
			AND (ced_especialista = ced_rif_medico or ced_especialista='0')
			AND slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
			ORDER BY fecha_ing_visita asc";

		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else 
		 	return false;
	} // Fin de la función listado_Atenc
	function listado_fact($des,$has,$serv,$pac,$edo,$emp,$med)
	{
		$stiempo=' ';
		$sserv=' ';
		$spac=' ';
		$sedo=' ';
		$semp=' ';
		$smed=' ';
		
		if($des!='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des'
					  and DATE(fecha_ing_visita)<='$has' ";
		if($des!='' && $has=='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des' ";					  
		if($des=='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)<='$has' ";
		if($stiempo!=' ')
			$stiempo2=$stiempo.' AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';
		else
			$stiempo2=' WHERE slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';

		if($serv!='') 
			$sserv=" AND slc_visita.slc_servicio_id_servicio = $serv ";

		if($pac!='') 
			$spac=" AND ced_paciente = '$pac' ";

		if($edo!='') 
			$sedo=" and status_visita in ('$edo') ";
		
		if($emp!='') 
			$semp=" and id_empresa in ('$emp') ";
			
		if($med!='') 
			$smed=" and ced_especialista in ('$med') ";
			
			$sql="SELECT distinct id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',ape1_paciente),telf_hab_pac, 
			sexo_paciente, fecha_ing_visita,  TIME(fecha_ing_visita), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista, 
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico),
			IF(ced_especialista='0', ' ', telf1_medico),
			nomb_servicio, status_visita, motivo_consulta,usuario_visita,ced_titular,nomb_titular
			FROM slc_visita, slc_paciente, slc_medico, slc_servicio, slc_benef
			WHERE id_paciente = slc_paciente_id_paciente
			 ".$sserv.$stiempo.$sedo.$spac.$semp.$smed." 
			AND (ced_especialista = ced_rif_medico or ced_especialista='0')
			AND slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
			AND slc_visita.slc_paciente_id_paciente=slc_benef.ced_benf
			AND slc_paciente.id_paciente=slc_benef.ced_benf
			ORDER BY fecha_ing_visita asc";

		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else 
		 	return false;
	} // Fin de la función listado_Atenc
	function listado_fact2($des,$has,$serv,$pac,$edo,$emp,$med)
	{
		$stiempo=' ';
		$sserv=' ';
		$spac=' ';
		$sedo=' ';
		$semp=' ';
		$smed=' ';
		
		if($des!='' && $has!='') 
		  $stiempo=" and DATE(a.fecha_ing_visita)>='$des'
					  and DATE(a.fecha_ing_visita)<='$has' ";
		if($des!='' && $has=='') 
		  $stiempo=" and DATE(a.fecha_ing_visita)>='$des' ";					  
		if($des=='' && $has!='') 
		  $stiempo=" and DATE(a.fecha_ing_visita)<='$has' ";
		if($serv!='') 
			$sserv=" and s.id_servicio = $serv ";

		if($pac!='') 
			$spac=" and p.id_paciente='$pac' ";

		if($emp!='') 
			$semp=" and a.id_empresa ='$emp' ";
			
		if($med!='') 
			$smed=" and m.ced_rif_medico='$med' ";
			
			$sql="SELECT distinct a.id_visita,a.fecha_ing_visita,p.ced_paciente,p.nom1_paciente,p.ape1_paciente,p.telf_hab_pac
			,s.nomb_servicio,m.ced_rif_medico,m.nomb_medico
			from slc_visita as a 
			join slc_paciente as p
			on a.slc_paciente_id_paciente=p.id_paciente ".$spac."
			join slc_servicio as s
			on a.slc_servicio_id_servicio=s.id_servicio".$sserv."
			join slc_medico as m
			on a.ced_especialista=m.ced_rif_medico".$smed."
			where a.status_visita='A' ".$stiempo.$semp."";
			

		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else 
		 	return false;
	} // Fin de la función listado_Atenc
	function listado_atenc_res($des,$has,$serv,$pac,$edo,$emp,$med)
	{
		$stiempo=' ';
		$sserv=' ';
		$spac=' ';
		$sedo=' ';
		$semp=' ';
		$smed=' ';
		
		if($des!='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des'
					  and DATE(fecha_ing_visita)<='$has' ";
		if($des!='' && $has=='') 
		  $stiempo=" and DATE(fecha_ing_visita)>='$des' ";					  
		if($des=='' && $has!='') 
		  $stiempo=" and DATE(fecha_ing_visita)<='$has' ";
		if($stiempo!=' ')
			$stiempo2=$stiempo.' AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';
		else
			$stiempo2=' WHERE slc_status_det_visita.slc_detalle_visita_id_det_visita=0 ';

		if($serv!='') 
			$sserv=" AND slc_visita.slc_servicio_id_servicio = $serv ";

		if($pac!='') 
			$spac=" AND ced_paciente = '$pac' ";

		if($edo!='') 
			$sedo=" and status_visita in ('$edo') ";
		
		if($emp!='') 
			$semp=" and id_empresa in ('$emp') ";
			
		if($med!='') 
			$smed=" and ced_especialista in ('$med') ";

		if($med=='X')
		{ 
			$smed="";
			$c_med=",ced_especialista ,nomb_medico";
			$o_med=",ced_especialista";
		}	
			
			$sql="SELECT COUNT(*), nomb_servicio, status_visita".$c_med."
			FROM slc_visita, slc_paciente, slc_medico, slc_servicio
			WHERE id_paciente = slc_paciente_id_paciente
			 ".$sserv.$stiempo.$sedo.$spac.$semp.$smed." 
			AND (ced_especialista = ced_rif_medico or ced_especialista='0')
			AND slc_visita.slc_servicio_id_servicio=slc_servicio.id_servicio
			group BY slc_servicio_id_servicio, status_visita".$o_med."
			order by nomb_servicio, status_visita";

		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else 
		 	return false;
	} // Fin de la función listado_Atenc_Res

	function ver_pac_LE()
	{
	   	$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d", time() + $zone);
		/*$sql="SELECT id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente, fechareg, id_det_visita, TIME(fechareg), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista, 
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico)
			FROM slc_visita, slc_paciente, slc_detalle_visita, slc_medico,
			(select slc_status_det_visita.slc_detalle_visita_id_det_visita iddv, MAX(fecha_ing_status_dv) fechareg
			 from slc_status_det_visita
			 where DATE(fecha_ing_status_dv)='$hoy'
			 GROUP BY slc_status_det_visita.slc_detalle_visita_id_det_visita) stadetv
			WHERE id_paciente = slc_paciente_id_paciente
			AND slc_detalle_visita.slc_servicio_id_servicio =$this->cod
			AND slc_visita_id_visita = id_visita
			AND status_det_visita in ('L','I')
			AND (ced_especialista = ced_rif_medico OR ced_especialista='0')
			and id_det_visita=stadetv.iddv
			ORDER BY fechareg asc";*/
			
			$sql="SELECT distinct id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente, fechareg, 0, TIME(fechareg), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista,
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico)
			FROM slc_visita, slc_paciente, slc_detalle_visita, slc_medico,
			(select slc_status_det_visita.id_visita iddv, MAX(fecha_ing_status_dv) fechareg
			 from slc_status_det_visita
			 where DATE(fecha_ing_status_dv)='$hoy'
			 AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0
			 GROUP BY slc_status_det_visita.id_visita) stadetv
			WHERE id_paciente = slc_paciente_id_paciente
			AND slc_visita.slc_servicio_id_servicio =$this->cod
			and slc_visita.id_visita=stadetv.iddv
			and status_visita in ('L','I')
			AND (ced_especialista = ced_rif_medico OR ced_especialista='0')
			and id_visita=stadetv.iddv
			ORDER BY fechareg asc";
			
			/*
			$sql="SELECT id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente, fechareg, id_det_visita, TIME(fechareg), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista, 
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico)
			FROM slc_visita, slc_paciente, slc_detalle_visita, slc_medico,
			(select slc_status_det_visita.slc_detalle_visita_id_det_visita iddv, MAX(fecha_ing_status_dv) fechareg
			 from slc_status_det_visita
			 where DATE(fecha_ing_status_dv)='$hoy'
			 GROUP BY slc_status_det_visita.slc_detalle_visita_id_det_visita) stadetv
			WHERE id_paciente = slc_paciente_id_paciente
			AND slc_detalle_visita.slc_servicio_id_servicio =$this->cod
			AND slc_visita_id_visita = id_visita
			AND status_det_visita in ('L','I')
			AND (ced_especialista = ced_rif_medico OR ced_especialista='0')
			and id_det_visita=stadetv.iddv
			UNION
			SELECT distinct id_visita, id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente, fechareg, 0, TIME(fechareg), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista,
			IF(ced_especialista='0', ' ', ced_rif_medico), 
			IF(ced_especialista='0', ' ', nomb_medico)
			FROM slc_visita, slc_paciente, slc_detalle_visita, slc_medico,
			(select slc_status_det_visita.id_visita iddv, MAX(fecha_ing_status_dv) fechareg
			 from slc_status_det_visita
			 where DATE(fecha_ing_status_dv)='$hoy'
			 AND slc_status_det_visita.slc_detalle_visita_id_det_visita=0
			 GROUP BY slc_status_det_visita.id_visita) stadetv
			WHERE id_paciente = slc_paciente_id_paciente
			AND slc_visita.slc_servicio_id_servicio =$this->cod
			and slc_visita.id_visita=stadetv.iddv
			and status_visita in ('L','I')
			AND (ced_especialista = ced_rif_medico OR ced_especialista='0')
			and id_visita=stadetv.iddv
			ORDER BY fechareg asc";
			*/

	   
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else
		 	return false;
	} // fin de funcion ver pacientes Lista de Espera


}// fin de la clase servicios

?>