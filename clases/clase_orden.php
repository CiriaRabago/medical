<?php 
/* 
CLASE ORDEN
CREADA POR: Ing. Mónica María Batista Contreras
FECHA DE CREACIÓN: 23/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LA ORDEN DE UN LABORATORIO
*/

/* DECLARACIÓN DE LA CLASE */
class orden
{
   var $id;
   var $pac;
   var $fact;
   var $tipo;
   var $monto;
   var $fing;
   var $usu;
   
/* FUNCIÓN CONSTRUCTORA */  
   function orden($id,$p,$f,$t,$m,$fi,$u)
   {
		$this->conexion=Conectarse();
		$this->id=$id;
   		$this->pac=$p;
   		$this->fact=$f;
		$this->tipo=$t;
   		$this->monto=$m;
   		$this->fing=$fi;
   		$this->usu=$u;
	} //fin del constructor
	
	
/* FUNCIÓN PARA CONSULTAR A UN PACIENTE POR CEDULA*/  	
	function consul_pac($idpac)
	{

	   	$sql="SELECT distinct slc_paciente.id_paciente, slc_paciente.ced_paciente, 
		 slc_paciente.nom1_paciente, slc_paciente.nom2_paciente, slc_paciente.ape1_paciente, 
		 slc_paciente.ape2_paciente, slc_paciente.direc_hab_pac, slc_paciente.telf_hab_pac, 
		 slc_paciente.tefl_cel_pac, slc_paciente.email_paciente, slc_paciente.fecha_nac_pac, 
		 slc_paciente.edo_civil_pac, slc_paciente.sexo_paciente, slc_paciente.fecha_ing_pac, 
		 slc_paciente.usuario, slc_paciente_empresa.slc_empresa_id_empresa,
		 IF(slc_paciente_empresa.slc_empresa_id_empresa=0,'',rif_empresa),
		 IF(slc_paciente_empresa.slc_empresa_id_empresa=0,'Particular',nom_empresa)
		 from slc_paciente, slc_empresa, slc_paciente_empresa
		 where slc_paciente.ced_paciente='$idpac'
		 and slc_paciente.id_paciente=slc_paciente_empresa.slc_empleado_id_paciente 
		 and (slc_empresa.id_empresa=slc_paciente_empresa.slc_empresa_id_empresa OR slc_paciente_empresa.slc_empresa_id_empresa=0)
		 and slc_paciente_empresa.status_pac_emp='A'
		 and slc_paciente.sta_paciente='A'";
		 //die($sql);
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   	 $n=mysql_num_rows($result);
	  		 if($n==0)
			 {
			 	return false;
			 }
			 else
			 {
			   $row = mysql_fetch_row($result);
			   $cadena=$row[0].'/*'.$row[2].'/*'.$row[3].'/*'.$row[4].'/*'.$row[5].'/*'.$row[10].'/*'.$row[12].'/*'.$row[15].'/*'.$row[17].'/*'.$row[7].'/*'.$row[8].'/*'.$row[1];
			   return $cadena;
			 }
		 }
	}
/* FUNCIÓN PARA CONSULTAR A UN PACIENTE POR CODIGO (ID)*/  	
	function consul_pac_ID($idpac)
	{

	   	$sql="SELECT distinct slc_paciente.id_paciente, slc_paciente.ced_paciente, 
		 slc_paciente.nom1_paciente, slc_paciente.nom2_paciente, slc_paciente.ape1_paciente, 
		 slc_paciente.ape2_paciente, slc_paciente.direc_hab_pac, slc_paciente.telf_hab_pac, 
		 slc_paciente.tefl_cel_pac, slc_paciente.email_paciente, slc_paciente.fecha_nac_pac, 
		 slc_paciente.edo_civil_pac, slc_paciente.sexo_paciente, slc_paciente.fecha_ing_pac, 
		 slc_paciente.usuario, slc_paciente_empresa.slc_empresa_id_empresa,
		 IF(slc_paciente_empresa.slc_empresa_id_empresa=0,'',rif_empresa),
		 IF(slc_paciente_empresa.slc_empresa_id_empresa=0,'Particular',nom_empresa)
		 from slc_paciente, slc_empresa, slc_paciente_empresa
		 where slc_paciente.id_paciente='$idpac'
		 and slc_paciente.id_paciente=slc_paciente_empresa.slc_empleado_id_paciente 
		 and (slc_empresa.id_empresa=slc_paciente_empresa.slc_empresa_id_empresa OR slc_paciente_empresa.slc_empresa_id_empresa=0)
		 and slc_paciente_empresa.status_pac_emp='A'
		 and slc_paciente.sta_paciente='A'";
		 //die($sql);
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   	 $n=mysql_num_rows($result);
	  		 if($n==0)
			 {
			 	return false;
			 }
			 else
			 {
			   $row = mysql_fetch_row($result);
			   $cadena=$row[0].'/*'.$row[2].'/*'.$row[3].'/*'.$row[4].'/*'.$row[5].'/*'.$row[10].'/*'.$row[12].'/*'.$row[15].'/*'.$row[17].'/*'.$row[7].'/*'.$row[8].'/*'.$row[1];
			   return $cadena;
			 }
		 }
	}


	function perfil_exa()
	{
	   	$sql="SELECT DISTINCT id_examen_perfil, nomb_perfil, nomb_examen, 
		      slc_perfil_id_perfil, slc_examen_id_examen, precio_examen, slc_perfil.precio  
			  FROM slc_examen_perfil, slc_examen, slc_perfil 
			  WHERE id_perfil = slc_perfil_id_perfil 
			  AND id_examen = slc_examen_id_examen 
			  AND estatus_examen=0
			  ORDER BY slc_perfil_id_perfil, slc_examen_id_examen";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<input name="maxper" id="maxper" type="hidden" value="0">
		   <table width="500" border="0" cellpadding="1" cellspacing="1" align="left">';
		   
		   $band=0;
		   $indiper=0;
		   $indiexa=0;
		   while ($row = mysql_fetch_row($result))
		   {
				$cadena=implode('/*',$row);
				if($band==1 && $perfilaux!=$row[3])
				{
					$HTML.='</table></td></tr>';
					$band=0;
					$indiexa=0;
				
				}
				if($band==0)
				{
					$indiper++;
					$HTML.='<tr class="texto">
				    <td width="10">
					<script>sumarper('.$indiper.')</script>
					<input type="checkbox" name="perfil'.$indiper.'" id="perfil'.$indiper.'" onClick="marcarexa('."'".$indiper."'".')" value="checkbox" />
					<input name="ocumontoper'.$indiper.'" id="ocumontoper'.$indiper.'" type="hidden" value="'.$row[6].'">
					</td>
					<td width="490" style="cursor:hand" onClick="desplega('."'".$indiper."'".')" class="texto" align="left"><span>'.$row[1].' Bs.'.$row[6].'</span></td>
					</tr>
					<tr class="texto">
				      <td width="500" colspan="2"><input name="maxexaper'.$indiper.'" id="maxexaper'.$indiper.'" type="hidden" value="">
					    <table id="per'.$indiper.'" width="500" border="0"  style="display:none" cellpadding="0" cellspacing="0" align="center">';
					$band=1;
					$perfilaux=$row[3];
					
					
				}
				$indiexa++;
				$HTML.='<tr class="texto">
					<td   width="400" class="texto" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <script>sumarexaper('.$indiper.','.$indiexa.')</script>
					  <input type="checkbox" onClick="cuenta('.$indiper.','.$indiexa.','.$row[5].')" name="examen'.$indiper.'**'.$indiexa.'" id="examen'.$indiper.'**'.$indiexa.'" value="checkbox" />'.$row[2].'
					  <input name="ocuexamen'.$indiper.'**'.$indiexa.'" id="ocuexamen'.$indiper.'**'.$indiexa.'" type="hidden" value="'.$row[4].'">
					  <input name="ocuprecio'.$indiper.'**'.$indiexa.'" id="ocuprecio'.$indiper.'**'.$indiexa.'" type="hidden" value="'.$row[5].'">
					  </td>
					<td width="100">'.$row[5].'</td>
					
					</tr>';
		   }
       	  $HTML.='</table></td></tr></table>';
		  
		  return $HTML;
		}
		else
		return false;
	} //fin de funcion perfil_exa




/* FUNCIÓN PARA INSERTAR UNA ORDEN */  	
	function ins_orden()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	    $con="select id_orden,count(*) from slc_orden where slc_paciente_id_paciente=$this->pac and monto_orden=$this->monto and substr(fecha_ing_orden , 1 , 10) = '".substr($hoy,0,10)."' and usuario=$this->usu"; 
		$resu=mysql_query($con,$this->conexion);
		$resp=mysql_fetch_row($resu);
		if($resp[1]=='0')
		{    
		 	$sql="INSERT INTO slc_orden (slc_paciente_id_paciente, id_factura, tipo_orden,
		      monto_orden,fecha_ing_orden,usuario) 
			  values ($this->pac,'NULL',$this->tipo,$this->monto,'$hoy','$this->usu')";
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
			 return mysql_error();  
      }else
	   {
	      $er="**;".$resp[0];
			  return $er;}
	} // fin de funcion insertar orden 


/* FUNCIÓN PARA INSERTAR EL DETALLE DE UNA ORDEN */  	
	function ins_det_orden($exa,$m)
	{
	   	$n=0;
		$zone=(3600*-4.5); 
        $hoy=gmdate("Y-m-d H:i:s", time() + $zone);
		$sql2="SELECT * from slc_det_orden
		       where slc_orden_id_orden= (select last_insert_id() from dual)
			   and slc_examen_id_examen=$exa";
		$result2=mysql_query($sql2,$this->conexion);
		if ($result2) 
		{
		    $n=mysql_num_rows($result2);
		}
		if($n>0)
		{
		    return true;
		}
		else
		{
		   	$sql="INSERT INTO slc_det_orden (slc_orden_id_orden, slc_examen_id_examen, monto_examen)
			  select last_insert_id(),$exa,$m from dual";
			$result=mysql_query($sql,$this->conexion);
			$sql3="INSERT INTO slc_examen_firmado (slc_orden_id_orden,slc_examen_id_examen,fecha_ing) 
			  values ((select last_insert_id() from dual),$exa,'$hoy')";
			$resulta2=mysql_query($sql3,$this->conexion);
			if ($result) 
				   return true;
			else
				   return false;
		}
	} // fin de funcion insertar orden 
function ins_det_orden_new($o,$exa,$m)
	{
	   	$zone=(3600*-4.5); 
        $hoy=gmdate("Y-m-d H:i:s", time() + $zone);
		   	$sql="INSERT INTO slc_det_orden (slc_orden_id_orden, slc_examen_id_examen, monto_examen)
			  VALUES ($o,$exa,$m)";
			$result=mysql_query($sql,$this->conexion);
			$sql3="INSERT INTO slc_examen_firmado (slc_orden_id_orden,slc_examen_id_examen,fecha_ing) 
			  values ($o,$exa,'$hoy')";
			$resulta2=mysql_query($sql3,$this->conexion);
			if ($result) 
				   return true;
			else
				   return false;
		
	} // fin de funcion insertar orden new

	function ver_orden()
	{
	   	$sql="SELECT slc_examen.id_examen, slc_examen.nomb_examen,
			slc_examen.precio_examen, slc_det_orden.monto_examen,
			slc_orden.slc_paciente_id_paciente, slc_orden.id_factura, 
			slc_orden.tipo_orden, slc_orden.monto_orden, 
			Date_format(slc_orden.fecha_ing_orden,'%d-%m-%Y %h:%i:%s %p'),
			slc_det_orden.result_examen,
			slc_perfil.nomb_perfil,slc_orden.cant_exa_res
			FROM slc_examen, slc_det_orden, slc_orden, slc_examen_perfil, slc_perfil
			where slc_det_orden.slc_orden_id_orden=".$this->id."
			and slc_det_orden.slc_orden_id_orden=slc_orden.id_orden
			and slc_det_orden.slc_examen_id_examen= slc_examen.id_examen
			and slc_examen_perfil.slc_perfil_id_perfil=slc_perfil.id_perfil
			and slc_examen_perfil.slc_examen_id_examen=slc_det_orden.slc_examen_id_examen
			and slc_perfil.tipo_perfil='A'
			GROUP BY slc_examen.nomb_examen
			order by slc_perfil.nomb_perfil, slc_examen.nomb_examen";
		//echo $sql;	
		$result=mysql_query($sql,$this->conexion);
   		return $result;
	} //Fin de la funcion ver_orden

	function result_ordenes_pend()
	{
		$HTML='';
	   	$sql="SELECT slc_orden.id_orden, slc_orden.slc_paciente_id_paciente,
				slc_paciente.nom1_paciente, slc_paciente.ape1_paciente, 
				slc_det_orden.slc_examen_id_examen, 
				slc_examen.nomb_examen,
				slc_det_orden.result_examen,slc_paciente.ced_paciente
			  FROM slc_orden, slc_det_orden, slc_examen, slc_paciente 
			  where slc_det_orden.result_examen in ('N','M')
			  and slc_orden.id_orden=slc_det_orden.slc_orden_id_orden
			  and slc_orden.slc_paciente_id_paciente=slc_paciente.id_paciente
			  and slc_det_orden.slc_examen_id_examen=slc_examen.id_examen";
			
			$HTML.='<table width="700" border="0" cellpadding="1" cellspacing="1" align="center">';
			$result=mysql_query($sql,$this->conexion);
			if ($result) 
			{
				$n=mysql_num_rows($result);
				if($n==0)
				{
					$HTML.='<tr class="titulofor">
    				<td colspan="5">
					<div align="center">NO HAY EXAMENES PENDIENTES POR RESULTADOS</div>
					</td>
  					</tr>';
				}
				else
				{
					$HTML.='<tr class="titulorep">
							<td width="40">Orden</td>
							<td width="80">C&eacute;dula</td>
							<td width="200">Nombre</td>
							<td width="250">Examen</td>
							<td width="130">Estado</td>
							</tr>';
				    $cont=0;
					while ($row = mysql_fetch_row($result))
					{
						
						if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
						$cont++;
						if($row[6]=='N')
						{
						 $status='Pendiente'; 
						 $link='<a href="resultado_examen.php?ord='.$row[0].'&ced='.$row[1].'&exa='.$row[4].'&sta='.$row[6].'&pagi=lista_result_pend.php">'.$row[5].'</a>';
						 }
						 else
						 { 
						 $status='Guardado Incompleto';
						 $link='<a href="resultado_examen_mod.php?ord='.$row[0].'&ced='.$row[1].'&exa='.$row[4].'&sta='.$row[6].'&pagi=lista_result_pend.php">'.$row[5].'</a>';
						}
						
						$HTML.='<tr class="texto" '.$color.'>
								<td>'.$row[0].'</td>
								<td>'.$row[7].'</td>
								<td  align="left">'.$row[2].' '.$row[3].'</td>
								<td  align="left">'.$link.'</td>
								<td>'.$status.'</td>
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


/* FUNCION PARA INGRESAR LOS RESULTADOS DE UNA ORDEN ESPECÍFICA */
	function result_orden()
	{
		$HTML='';
	   	$sql="SELECT slc_orden.id_orden, slc_orden.slc_paciente_id_paciente,
				slc_paciente.nom1_paciente, slc_paciente.ape1_paciente, 
				slc_det_orden.slc_examen_id_examen, 
				slc_examen.nomb_examen, slc_det_orden.result_examen
			  FROM slc_orden, slc_det_orden, slc_examen, slc_paciente 
			  where slc_orden.id_orden=".$this->id."
			  and slc_orden.id_orden=slc_det_orden.slc_orden_id_orden
			  and slc_orden.slc_paciente_id_paciente=slc_paciente.id_paciente
			  and slc_det_orden.slc_examen_id_examen=slc_examen.id_examen";
			  //echo die($sql);
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
							<td width="300">Examen</td>
							<td width="160">Status</td>
							<td width="70" align="center">Original<br><input align="center" name="original" id="original" type="checkbox" checked="checked" onClick="marca('."'original'".','."'org'".');" /></td>
							<td width="70" align="center">Copia<br><input align="center"    name="copia"    id="copia"    type="checkbox" checked="checked" onClick="marca('."'copia'".','."'cop'".')" /></td>
							</tr>';
				    $cont=0;
					$vectexa="";
					while ($row = mysql_fetch_row($result))
					{
						if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
						$cont++;
						$status='&nbsp;';
						if($row[6]=='N') $status='Pendiente';
						if($row[6]=='M') $status='Guardado Incompleto'; 
						if($row[6]=='M' || $row[6]=='S')
							$link='<a href="resultado_examen_mod.php?ord='.$row[0].'&ced='.$row[1].'&exa='.$row[4].'&sta='.$row[6].'&pagi=resultado_exa.php">'.$row[5].'</a>';
						else
							$link='<a href="resultado_examen.php?ord='.$row[0].'&ced='.$row[1].'&exa='.$row[4].'&sta='.$row[6].'&pagi=resultado_exa.php">'.$row[5].'</a>';
						$HTML.='<tr class="texto" '.$color.'>
								<td width="300">'.$link.'</td>
								<td width="160">'.$status.'</td>
								<td width="70" align="center"><input align="center" name="org'.$row[4].'" id="org'.$row[4].'"  type="checkbox" checked="checked" /></td>
								<td width="70" align="center"><input align="center" name="cop'.$row[4].'" id="cop'.$row[4].'" type="checkbox" checked="checked" /></td>
								</tr>';
						if($cont==$n) $vectexa.=$row[4]; else $vectexa.=$row[4].'**';
					} // Fin del while
					$HTML.='<input name="vexa" id="vexa" type="hidden" value="'.$vectexa.'" />';
				} // Fin de else si no hay resultados
			} // Fin del if result
			else
			{
			$HTML.='';
			}
 			return $HTML;
   		
	} //Fin de la funcion result_ordenes

	function result_orden_new()
	{
		$HTML='';
		$sql="SELECT slc_orden.id_orden,
			          slc_orden.slc_paciente_id_paciente,
					  slc_paciente.nom1_paciente,
					  slc_paciente.ape1_paciente,
					  slc_det_orden.slc_examen_id_examen,
					  slc_examen.nomb_examen,
					  slc_det_orden.result_examen,
					  slc_perfil_id_perfil,
					  slc_examen.ABREV_examen,
					  slc_medico_id_medico
			    FROM  slc_orden,
				      slc_det_orden,
					  slc_examen, 
					  slc_paciente,
					  slc_examen_perfil,
					  slc_examen_firmado
				WHERE slc_orden.id_orden=".$this->id."
				  and slc_orden.id_orden=slc_det_orden.slc_orden_id_orden
				  and slc_orden.id_orden=slc_examen_firmado.slc_orden_id_orden
				  and slc_orden.slc_paciente_id_paciente=slc_paciente.id_paciente
				  and slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
                  and slc_examen.id_examen=slc_examen_firmado.slc_examen_id_examen
				  and slc_examen.id_examen=slc_examen_perfil.slc_examen_id_examen
				GROUP BY slc_medico_id_medico,slc_examen.ABREV_examen,SLC_EXAMEN_ID_EXAMEN  
                ORDER BY slc_medico_id_medico,slc_examen.ABREV_examen,orden_area,orden_examen,slc_perfil_id_perfil,SLC_EXAMEN_ID_EXAMEN";
			  //echo die($sql);
			$result=mysql_query($sql,$this->conexion);
	
 			return $result;
   		
	} //Fin de la funcion result_ordenes
   function result_orden_new2()
	{
		$HTML='';
		$sql="SELECT slc_orden.id_orden,
			          slc_orden.slc_paciente_id_paciente,
					  slc_paciente.nom1_paciente,
					  slc_paciente.ape1_paciente,
					  slc_det_orden.slc_examen_id_examen,
					  slc_examen.nomb_examen,
					  slc_det_orden.result_examen,
					  slc_perfil_id_perfil,
					  slc_examen.ABREV_examen
			    FROM  slc_orden,
				      slc_det_orden,
					  slc_examen, 
					  slc_paciente,
					  slc_examen_perfil
				WHERE slc_orden.id_orden=".$this->id."
				  and slc_orden.id_orden=slc_det_orden.slc_orden_id_orden
				  and slc_orden.slc_paciente_id_paciente=slc_paciente.id_paciente
				  and slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
				  and slc_examen.id_examen=slc_examen_perfil.slc_examen_id_examen
				GROUP BY slc_examen.ABREV_examen,SLC_EXAMEN_ID_EXAMEN  
                ORDER BY slc_examen.ABREV_examen,orden_area,orden_examen,slc_perfil_id_perfil,SLC_EXAMEN_ID_EXAMEN";
			$result=mysql_query($sql,$this->conexion);
 			return $result;
   		
	} //Fin de la funcion result_ordenes


/* FUNCION PARA VER LOS RESULTADOS DE UNA ORDEN ESPECÍFICA */
	function ver_results()
	{
		$HTML='';
	   	$sql="SELECT slc_orden.id_orden, slc_orden.slc_paciente_id_paciente,
				slc_paciente.nom1_paciente, slc_paciente.ape1_paciente, 
				slc_det_orden.slc_examen_id_examen, 
				slc_examen.nomb_examen, slc_det_orden.result_examen
			  FROM slc_orden, slc_det_orden, slc_examen, slc_paciente 
			  where slc_orden.id_orden=".$this->id."
			  and slc_orden.id_orden=slc_det_orden.slc_orden_id_orden
			  and slc_orden.slc_paciente_id_paciente=slc_paciente.id_paciente
			  and slc_det_orden.slc_examen_id_examen=slc_examen.id_examen";
			  //echo die($sql);
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
							<td width="300">Examen</td>
							<td width="160">Status</td>
							<td width="140" align="center">Copia<br><input align="center"    name="copia"    id="copia"    type="checkbox" checked="checked" onClick="marca('."'copia'".','."'cop'".')" /></td>
							</tr>';
				    $cont=0;
					$vectexa="";
					while ($row = mysql_fetch_row($result))
					{
						if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
						$cont++;
						$status='&nbsp;';
						if($row[6]=='N') $status='Pendiente';
						if($row[6]=='M') $status='Guardado Incompleto'; 
						$HTML.='<tr class="texto" '.$color.'>
								<td width="300">'.$row[5].'</td>
								<td width="160">'.$status.'</td>
								<td width="140" align="center"><input align="center" name="cop'.$row[4].'" id="cop'.$row[4].'" type="checkbox" checked="checked" /></td>
								</tr>';
						if($cont==$n) $vectexa.=$row[4]; else $vectexa.=$row[4].'**';
					} // Fin del while
					$HTML.='<input name="vexa" id="vexa" type="hidden" value="'.$vectexa.'" />';
				} // Fin de else si no hay resultados
			} // Fin del if result
			else
			{
			$HTML.='';
			}
 			return $HTML;
   		
	} //Fin de la funcion ver_results



	function modif_status_res($exa,$sta)
	{
	   	$sql="UPDATE slc_det_orden
			  SET slc_det_orden.result_examen='$sta'
			  WHERE slc_det_orden.slc_orden_id_orden=$this->id
			  AND slc_det_orden.slc_examen_id_examen=$exa";
	    //echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if (!$result) 
		{
		   	echo '<script>alert("No se pudo actualizar el Estatus de Finalizado");</script>';
		}
	} // Fin de la Función modif_status_res
	
/* FUNCIÓN PARA LISTAR LAS ORDENES POR PACIENTE */  	
	function lista_orden_pac($idpac)
	{

	   	$sql="SELECT id_orden, fecha_ing_orden, monto_orden, IF( id_factura, id_factura, 'no' ) 
				FROM slc_orden
				WHERE slc_paciente_id_paciente = '$idpac'
				ORDER BY fecha_ing_orden desc";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			 	return $result;
		}
		else
		{
			   return false;
		 }
	} // Fin de la Funcion Lista ordenes por cédula
function buscar_orden()
{
	$sql="select * from slc_orden where id_orden='$this->id'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		return $row[4];
}	
	function pagar()
	{
	   	$sql="UPDATE slc_orden SET id_factura='$this->fact'  WHERE id_orden='$this->id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}
	
	
/* FUNCIÓN PARA LISTAR LAS CARACTERISTICAS PARA EL HISTORIAL */  	
	function caract_hist($idpac)
	{

	   	$sql="SELECT slc_det_resultados.slc_caract_id_caract, 
				   slc_caract.nomb_caract, slc_examen.nomb_examen, 
				   count(slc_det_resultados.slc_caract_id_caract)
			FROM slc_resultados,slc_det_resultados,slc_caract,
				 slc_orden,slc_examen,slc_det_orden, slc_caract_examen
			where slc_resultados.id_resultados=slc_det_resultados.slc_resultados_id_resultados
			AND slc_caract.id_caract=slc_det_resultados.slc_caract_id_caract
			AND slc_resultados.slc_orden_id_orden=slc_orden.id_orden
			AND slc_det_orden.slc_orden_id_orden=slc_orden.id_orden
			AND slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
			AND slc_caract_examen.slc_examen_id_examen=slc_det_orden.slc_examen_id_examen
			AND slc_caract_examen.slc_caract_id_caract=slc_det_resultados.slc_caract_id_caract
			AND slc_resultados.id_resultados=slc_det_resultados.slc_resultados_id_resultados
			AND slc_caract_examen.slc_examen_id_examen=slc_examen.id_examen
			AND slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
			AND slc_det_orden.slc_orden_id_orden=slc_orden.id_orden
			AND slc_resultados.slc_orden_id_orden=slc_det_orden.slc_orden_id_orden
			AND slc_resultados.slc_examen_id_examen=slc_examen.id_examen
			AND slc_orden.slc_paciente_id_paciente='$idpac'
			AND slc_caract.id_caract not in (select distinct slc_caract_id_caract from slc_lista_valores)
			group by slc_det_resultados.slc_caract_id_caract, slc_caract.nomb_caract, slc_examen.nomb_examen
			having count(slc_det_resultados.slc_caract_id_caract)>1
			ORDER BY slc_caract.nomb_caract";
		// echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			 	return $result;
		}
		else
		{
			   return false;
		 }
	} // Fin de la FUNCION PARA LISTAR LAS CARACTERISTICAS PARA EL HISTORIAL

/* FUNCIÓN PARA BUSCAR VALORES DEL HISTORIAL */
	function val_hist($idpac,$car)
	{

	   	$sql="SELECT ttdatos.vr, Date_format(ttdatos.fr,'%d-%m-%y %h:%i:%s %p'), ttdatos.idc, ttdatos.nc, ttdatos.ne
		      FROM ( SELECT slc_det_resultados.valor_resultado vr, 
			  			slc_resultados.fecha_ing_res fr,
						slc_det_resultados.slc_caract_id_caract idc, 
						slc_caract.nomb_caract nc, slc_examen.nomb_examen ne
						FROM slc_resultados,slc_det_resultados,slc_caract,
							 slc_orden,slc_examen,slc_det_orden, slc_caract_examen
						where slc_resultados.id_resultados=slc_det_resultados.slc_resultados_id_resultados
						AND slc_caract.id_caract=slc_det_resultados.slc_caract_id_caract
						AND slc_resultados.slc_orden_id_orden=slc_orden.id_orden
						AND slc_det_orden.slc_orden_id_orden=slc_orden.id_orden
						AND slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
						AND slc_caract_examen.slc_examen_id_examen=slc_det_orden.slc_examen_id_examen
						AND slc_caract_examen.slc_caract_id_caract=slc_det_resultados.slc_caract_id_caract
						AND slc_resultados.id_resultados=slc_det_resultados.slc_resultados_id_resultados
						AND slc_caract_examen.slc_examen_id_examen=slc_examen.id_examen
						AND slc_det_orden.slc_examen_id_examen=slc_examen.id_examen
						AND slc_det_orden.slc_orden_id_orden=slc_orden.id_orden
						AND slc_resultados.slc_orden_id_orden=slc_det_orden.slc_orden_id_orden
						AND slc_resultados.slc_examen_id_examen=slc_examen.id_examen
						AND slc_orden.slc_paciente_id_paciente='$idpac'
						AND slc_det_resultados.slc_caract_id_caract=$car
						AND not slc_det_resultados.valor_resultado=''
						ORDER BY slc_resultados.fecha_ing_res desc
						LIMIT 10) ttdatos
				ORDER BY ttdatos.fr asc";
		// echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			 	return $result;
		}
		else
		{
			   return false;
		 }
	} // Fin de la FUNCION PARA LISTAR LAS CARACTERISTICAS PARA EL HISTORIAL
	
	



function mod_orden($idor,$idpac,$idfac,$tipor,$monto,$fecha,$usu,$cantex,$cantres)
	{
	    $ins='';
		$c=0;
		if($idpac!=""){$ins.="slc_paciente_id_paciente=".$idpac; $c++;}
		if($idfac!=""){if($c>=1) $ins.=", "; $ins.="id_factura=".$idfac; $c++;}
		 if($tipor!=""){if($c>=1)$ins.=", "; $ins.="tipo_orden=".$tipor; $c++;}	
         if($monto!=""){if($c>=1)$ins.=", "; $ins.="monto_orden=".$monto; $c++;}	
		 if($fecha!=""){if($c>=1)$ins.=", "; $ins.="fecha_ing_orden=".$fecha; $c++;}	
         if($usu!="")  {if($c>=1)$ins.=", "; $ins.="usuario=".$usu; $c++;}	
         if($cantex!=""){if($c>=1)$ins.=", "; $ins.="cant_exa=".$cantex; $c++;}	
         if($cantres!="") {if($c>=1)$ins.=", "; $ins.="cant_exa_res=".$cantres; $c++;}	
		$sql="UPDATE slc_orden SET ".$ins." WHERE id_orden=".$idor; 
		//echo $sql;			  
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		  {return true;}
		else
		  {return mysql_error();}  
 
		
	} // fin de funcion modificar orden 

function buscar_orden_pendiente()
{
	$sql="select * from slc_orden where cant_exa<>cant_exa_res order by fecha_ing_orden desc"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		return $result;
}
function buscar_orden_lista()
{
	//$sql="select * from slc_orden where cant_exa=cant_exa_res and fecha_ing_orden>'2013-12-16 99:00:00' order by fecha_ing_orden desc"; 
	$sql="SELECT SLC_ORDEN_ID_ORDEN,slc_paciente_id_paciente,fecha_ing_orden,count(*) FROM `slc_examen_firmado`,slc_orden where slc_orden_id_orden=id_orden and firma='N' and cant_exa=cant_exa_res  group by slc_orden_id_orden order by SLC_ORDEN_ID_ORDEN desc"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		return $result;
}
function buscar_orden_lista2()
{
	$sql="SELECT SLC_ORDEN_ID_ORDEN,slc_paciente_id_paciente,fecha_ing_orden,count(*) FROM `slc_examen_firmado`,slc_orden where slc_orden_id_orden=id_orden and firma<>'N' and cant_exa=cant_exa_res  group by slc_orden_id_orden order by SLC_ORDEN_ID_ORDEN desc"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		return $result;
}

function elimina_examen($o,$e)
{
	$sql="select valor_resultado 
	      from slc_resultados,
		       slc_det_resultados 
		  where id_resultados=slc_resultados_id_resultados
		    and slc_orden_id_orden=".$o." 
			and slc_examen_id_examen=".$e;			
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 //if($row[0]=='')
	 //  {
	    $sql2="update slc_orden set cant_exa=(cant_exa-1) where id_orden=".$o;
		$result=mysql_query($sql2,$this->conexion);
		$sql2="delete from slc_det_orden  where slc_orden_id_orden=".$o." and slc_examen_id_examen=".$e;
		$result=mysql_query($sql2,$this->conexion);
		return '1';
	//	}
	  //else
	//	return '2';  //2 significa que el examen tiene valor y no puede ser borrado
}	
function consulta_examen_orden($o,$e)
{
	 $sql="select * from slc_det_orden  where slc_orden_id_orden=".$o." and slc_examen_id_examen=".$e;			
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 if($row[1]>0)
	  {	 
		$sql2="select * from slc_examen where id_examen=".$e;			
		$result2=mysql_query($sql2,$this->conexion);
	    $row2=mysql_fetch_array($result2);
		return $row2[1];
	   }
	   else
	     return false;	 
	   
}	
	
}// fin de la clase orden
/*** FUNCIONES INDEPENDIENTES *****/

function calculaedad($fechanacimiento){
	list($ano,$mes,$dia) = explode("-",$fechanacimiento);
	$ano_diferencia  = date("Y") - $ano;
	$mes_diferencia = date("m") - $mes;
	$dia_diferencia   = date("d") - $dia;
	if ($dia_diferencia < 0 || $mes_diferencia < 0)
		$ano_diferencia--;
	return $ano_diferencia;
}

?>
