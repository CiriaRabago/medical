<?php  
/* 
CLASE EXAMEN
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS EXAMENES
*/

/* DECLARACIÓN DE LA CLASE */
class examen
{
   var $cod;
   var $nom;
   var $abr;
   var $obs;
   var $pro;
   var $valo;
   var $met;
   var $pre;
   var $tip;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function examen($c, $n, $a, $o, $po, $v, $m, $pe, $t)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
		$this->abr=$a;   		
		$this->obs=$o;
   		$this->pro=$po;
   		$this->valo=$v;
		$this->met=$m;
   		$this->pre=$pe;
   		$this->tip=$t;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN EXAMEN */  	
	function ins_examen()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_examen (nomb_examen, abrev_examen, obs_examen, proc_examen, valores_examen, metod_examen, precio_examen, tipo_mues_examen) VALUES (upper('$this->nom'), upper('$this->abr'), upper('$this->obs'), upper('$this->pro'), '$this->valo', upper('$this->met'), '$this->pre',	upper('$this->tip'))";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			
			$usu=$_SESSION['cedu_usu'];
			$sqlp="insert into slc_precios
					(slc_examen_id_examen,precio,fecha_ing_precio,fecha_fin_precio,usuario)
					select last_insert_id(),'$this->pre','$hoy',NULL,'$usu' from dual";
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
	} // fin de funcion  insertar examenes 
function modf_examen()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="UPDATE slc_examen SET nomb_examen=upper('$this->nom'), abrev_examen=upper('$this->abr'), obs_examen=upper('$this->obs'), proc_examen=upper('$this->pro'), valores_examen='$this->valo', metod_examen=upper('$this->met'), precio_examen='$this->pre', tipo_mues_examen=upper('$this->tip') WHERE id_examen ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			$sqlm="UPDATE slc_precios
					set fecha_fin_precio='$hoy'
					where slc_examen_id_examen=$this->cod
					and fecha_fin_precio is NULL";
			$resultm=mysql_query($sqlm,$this->conexion);
			if ($resultm) 
			{
				$usu=$_SESSION['cedu_usu'];
				$sqlp="insert into slc_precios
						(slc_examen_id_examen,precio,fecha_ing_precio,fecha_fin_precio,usuario)
						values($this->cod,$this->pre,'$hoy',NULL,'$usu')";
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
		}
		else
			   return false;
	} // fin de funcion  modificar examenes

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE LOS EXAMENES EXISTENTES */  		
	function ver_examen()
	{
	   	$sql="SELECT * from slc_examen where estatus_examen=0 order by nomb_examen";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="300"><div align="left">Nombre</div></td>
				<td width="200"><div align="left">Abreviatura</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[2].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver examenes


/* FUNCIÓN PARA LLENAR COMBO DE PERFILES */  		
	function combo_examen_perf($p)
	{  if ($p=='')
		$sql="SELECT distinct id_examen, nomb_examen from slc_examen where estatus_examen=0 order by nomb_examen";
	else
	   	$sql="SELECT distinct id_examen, nomb_examen from slc_examen, slc_examen_perfil where slc_perfil_id_perfil=$p and estatus_examen=0  and id_examen=slc_examen_id_examen
			order by nomb_examen";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE PERFILES 

function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_examen where nomb_examen='$this->nom' and abrev_examen='$this->abr' and obs_examen='$this->obs' and  proc_examen='$this->pro' and valores_examen='$this->valo' and metod_examen='$this->met' and precio_examen='$this->pre' and tipo_mues_examen='$this->tip'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}


/*FUNCION PARA CONSULTAR LOS DATOS GENERALES DE UN EXAMEN PARA EL REPORTE*/
	function consul_examen()
	{
	   	$sql="SELECT nomb_examen, metod_examen, tipo_mues_examen, id_examen
			  from slc_examen
			  where id_examen=$this->cod";
			  //echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $row = mysql_fetch_row($result);
		   return $row;
		}
		else
			return false;
	}

/* FUNCION PARA CONSULTAR LAS CARACTERISTICAS ASOCIADAS A UN EXAMEN */
	function consul_caract_examen()
	{
	   	$sql="SELECT tc.nomb_tipo_caract, c.id_caract, c.nomb_caract, ce.orden_caract_examen, u.nomenc_unid_medida, c.res_pn_caract, u.id_unid_medida,c.descrip_caract
				FROM  slc_caract c, slc_caract_examen ce, slc_unid_medida u, slc_tipo_caract tc
				WHERE ce.slc_examen_id_examen=$this->cod
				AND c.id_caract=ce.slc_caract_id_caract
				and c.slc_unid_medida_id_unid_medida=u.id_unid_medida
				and c.slc_tipo_caract_id_tipo_caract=tc.id_tipo_caract
				order by tc.nomb_tipo_caract, ce.orden_caract_examen";
				//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}

/* FUNCIONES PARA CONSULTAR LOS VALORES DE UNA CARACTERISTICAS*/

	function consul_valores_caract($car)
	{
	   	$sql="select distinct id_lista_valores, valor_lista_valores
			  from slc_lista_valores
			  where slc_caract_id_caract=$car;";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		{ 
		return false;
		}
	}


	function consul_valores_caract2($car,$r)
	{
	   	$sql="select distinct id_lista_valores, valor_lista_valores
			  from slc_lista_valores
			  where slc_caract_id_caract=$car;";
	
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		     
			$sel='';
			if ($row[0]==$r)
			  $sel='selected ';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		{ 
		return false;
		}
	}


	function consul_valores_caract3($car,$r)
	{
	   	$sql="select valor_lista_valores
			  from slc_lista_valores
			  where slc_caract_id_caract=$car
			  and id_lista_valores=$r";
			  
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		  $row = mysql_fetch_row($result);
		  return $row[0];
		}
		else
		{ 
		return '';
		}
	}


	function consul_valores_ref($car,$s,$e)
	{
	   	$sql="select id_valor_referencia, valor_min_referencia, valor_max_referencia, sexo_referencia
				from slc_valor_referencia
				where slc_caract_id_caract=$car";
		//echo '<-'.$sql.'->';
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		  // $row = mysql_fetch_row($result);
		   return $result;
		}
		else
			return false;
	}
/* FUNCION PARA CAMBIAR EL ORDEN DE LAS CARACTERISTICAS POR EXAMEN */
	function camb_orden_caract_examen($car,$o)
	{
	   	$sql="update slc_caract_examen
				set orden_caract_examen=$o
				where slc_examen_id_examen=$this->cod
				and slc_caract_id_caract=$car";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}

/* FUNCION PARA ELIMINAR UNA CARACTERISTICA DE UN EXAMEN */
	function elim_caract_examen($car)
	{
	   	$sql="delete from slc_caract_examen
				where slc_examen_id_examen=$this->cod
				and slc_caract_id_caract=$car";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}
	
/* FUNCION PARA AGREGAR UNA CARACTERISTICA A UN EXAMEN */	
	function ins_caract_examen($car)
	{
	   	$sql="insert into slc_caract_examen
				(slc_examen_id_examen,
				 slc_caract_id_caract)
				values($this->cod,$car)";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}	
	
/* FUNCION PARA CONSULTAR LAS CARACTERISTICAS NO ASOCIADAS A UN EXAMEN*/	
	function consul_caract_examen_no()
	{
	   	$sql="SELECT distinct tc.nomb_tipo_caract, c.id_caract, ltrim(c.nomb_caract), u.nomenc_unid_medida,c.descrip_caract
			FROM slc_caract c, slc_unid_medida u, slc_tipo_caract tc
			WHERE estatus_caract=0 
			AND c.slc_unid_medida_id_unid_medida = u.id_unid_medida
			AND c.slc_tipo_caract_id_tipo_caract = tc.id_tipo_caract
			AND c.id_caract NOT IN (
				SELECT slc_caract_id_caract
				FROM slc_caract_examen
				WHERE slc_examen_id_examen=$this->cod
			)
			ORDER BY ltrim(tc.nomb_tipo_caract), ltrim(c.nomb_caract)";
		//echo $sql;	
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	}
function eliminar()
{
	$sql="delete FROM slc_examen WHERE id_examen ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function bus_examen1() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_caract_examen where slc_examen_id_examen= '$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'Caracteristicas';
	}
function bus_examen2() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_examen_perfil where slc_examen_id_examen= '$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'Perfiles';
	}

	function consul_examen_todo()
	{
	   	$sql="SELECT *
			  from slc_examen
			  where id_examen=$this->cod";
			  //echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $row = mysql_fetch_row($result);
		   return $row;
		}
		else
			return false;
	}
}// fin de la clase examenes

?>