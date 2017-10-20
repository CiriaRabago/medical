<?php  
/* 
CLASE REFERENCIA
CREADA POR: Ing. GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 05/05/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS REFERENCIAS MEDICAS
*/

/* DECLARACIÓN DE LA CLASE */
class referencia
{
   var $idr;
   var $esp;
   var $ced;
   var $nom;
   var $dire;
   var $te1;
   var $te2;
   var $pre;
   var $sta;
   var $fin;
   var $usu;
 
/* FUNCIÓN CONSTRUCTORA */  
   function referencia($id, $es, $ce, $no, $di, $t1, $t2, $pr, $st, $fi, $us)
   {
		$this->conexion=Conectarse();
		$this->idr=$id;
   		$this->esp=$es;
	    $this->ced=$ce;
		$this->nom=$no;
		$this->dire=$di;
		$this->te1=$t1;   		
		$this->te2=$t2;
   		$this->pre=$pr;
   		$this->sta=$st;
		$this->fin=$fi;
   		$this->usu=$us;   		
	} //fin del constructor

/* FUNCIÓN PARA INSERTAR UNA REFERENCIA */  	
	function ins_referencia()
	{
	    $zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i ", time() + $zone);
	    $usu=$_SESSION['cedu_usu'];
	   	$sql="INSERT INTO slc_referencia 
		      (slc_especialidad_id_esp, ced_rif, nomb_ref, dir_empresa_ref, telf1_ref, telf2_ref,
			   precio_ref, status_ref, fecha_ing_ref, usuario_ref) 
			   VALUES ($this->esp, '$this->ced', upper('$this->nom'), upper('$this->dire'), '$this->te1', '$this->te2',
			          '$this->pre',upper('$this->sta'),'$hoy','$usu')";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			$sqlp="insert into slc_precios (id_referencia,precio,fecha_ing_precio,fecha_fin_precio,usuario) select last_insert_id(), '$this->pre','$hoy',NULL,'$usu' from dual";
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
	} // fin de funcion  insertar referencia

/* FUNCIÓN PARA CAMBIAR DE PRECIO UNA REFERENCIA */  	
	function cambio_de_precio($pr,$pe,$us)
	{
	   	$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i ", time() + $zone);
		$sql="UPDATE slc_precios SET  fecha_fin_precio='$hoy' 
		      where id_referencia=$pe and fecha_fin_precio is NULL";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			$sqlp="INSERT INTO slc_precios (precio, fecha_ing_precio, usuario,id_referencia) VALUES ('$pr', '$hoy' ,'$us', $pe)";
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
	} // fin de funcion cambiar precio de referencia
	
/* FUNCIÓN PARA MODIFICAR UNA REFERENCIA */  	
	function modf_refe()
	{
		$sql="UPDATE slc_referencia 
				SET ced_rif='$this->ced',
				nomb_ref= upper('$this->nom'), 
				dir_empresa_ref= upper('$this->dire'), 
				telf1_ref=$this->te1,
				telf2_ref=$this->te2,
				precio_ref='$this->pre' 
				WHERE id_referencia=$this->idr";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar referencia


/* FUNCIÓN PARA ELIMINAR UNA REFERENCIA */  		
	function eliminar()
	{
		$sql="UPDATE slc_referencia 
				SET status_ref='$this->sta'
				WHERE id_referencia=$this->idr";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  eliminar referencia

//FUNCIÓN PARA VERIFICAR SI LA REFERENCIA EXISTE
	function buscarref() 
	{
		$sql="select * 
		from slc_referencia 
		where slc_especialidad_id_esp=$this->esp and ced_rif='$this->ced' 
		and nomb_ref='$this->nom' and  dir_empresa_ref='$this->dire' 
		and telf1_ref='$this->te1' and telf2_ref='$this->te2' and precio_ref='$this->pre' 
		and status_ref='$this->sta'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	} // Fin de funcion para ver si el registro existe 

	
	function combo_referencia()
	{
	   	$sql="SELECT id_referencia, nombre from slc_referencia order by nombre";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} 
///////////////////////////////////////////////////////////

	function lista_ref($vi)
	{
	   	$sql="SELECT id_referencia,nomb_esp, nomb_ref, precio_ref,
			(select count(slc_referencia_id_referencia) 
			 from slc_ref_visita
			 where slc_visita_id_visita=$vi
			 and status_rv='A'
			 and slc_referencia_id_referencia=id_referencia) revi,
			(select observacion_rv obse
			 from slc_ref_visita
			 where slc_visita_id_visita=$vi
			 and status_rv='A'
			 and slc_referencia_id_referencia=id_referencia) obse
			from slc_referencia, slc_especialidad
			where slc_especialidad_id_esp=id_esp
			and status_esp='A'
			and status_ref='A'
			order by nomb_esp, nomb_ref";
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return false;
	  	else
   			return $result;
	}
	
	function lista_esp_ref($vi)
	{
	   $band=true;
	   $cont=0;
	   $sql1="select 'E', id_esp, nomb_esp,0,
			(select count(id_esp_ref) 
			 from slc_ref_visita
			 where slc_visita_id_visita=$vi
			 and status_rv='A'
			 and id_esp_ref=id_esp
			 and slc_referencia_id_referencia=0) revi,
			(select observacion_rv obse
			 from slc_ref_visita
			 where slc_visita_id_visita=$vi
			 and status_rv='A'
			 and id_esp_ref=id_esp
			 and slc_referencia_id_referencia=0) obse
			from slc_especialidad
			where status_esp='A'
			order by nomb_esp";
		$result1=mysql_query($sql1,$this->conexion);
		$n=mysql_num_rows($result1);
		if($n>0)
		{
			while($row1 = mysql_fetch_row($result1))
			{
				if($cont>0) $sqlT.=" UNION "; 
				$sqlT.="
				select 'E', id_esp espe, 0 refe, nomb_esp nombr,0 prec,
				(select count(id_esp_ref) 
				 from slc_ref_visita
				 where slc_visita_id_visita=$vi
				 and status_rv='A'
				 and id_esp_ref=id_esp
				 and slc_referencia_id_referencia=0) revi,
				(select observacion_rv obse
				 from slc_ref_visita
				 where slc_visita_id_visita=$vi
				 and status_rv='A'
				 and id_esp_ref=id_esp
				 and slc_referencia_id_referencia=0) obse, ''
				from slc_especialidad
				where status_esp='A'
				and id_esp=".$row1[1]."
				UNION
				SELECT 'R',".$row1[1]." espe, id_referencia refe, nomb_ref nombr, precio_ref prec,
				(select count(slc_referencia_id_referencia) 
				 from slc_ref_visita
				 where slc_visita_id_visita=$vi
				 and status_rv='A'
				 and slc_referencia_id_referencia=id_referencia) revi,
				(select observacion_rv obse
				 from slc_ref_visita
				 where slc_visita_id_visita=$vi
				 and status_rv='A'
				 and slc_referencia_id_referencia=id_referencia) obse, 
  				concat(nomb_esp,' - ')
				from slc_referencia, slc_especialidad
				where slc_especialidad_id_esp=".$row1[1]."
				and slc_especialidad_id_esp=id_esp
				and status_ref='A'";
				$cont++;
			}
			//echo $sqlT;
			$result2=mysql_query($sqlT,$this->conexion);
			$n2=mysql_num_rows($result2);
			if($n2>0)
			{
				//echo $sqlT;
				return $result2;
			}
			else
				return false;
		}
		else
			return false;
	}

}// fin de la clase referencia


?>