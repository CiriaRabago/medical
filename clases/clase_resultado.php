<?php  
/* 
CLASE ORDEN
CREADA POR: Ing. Mónica María Batista Contreras
FECHA DE CREACIÓN: 23/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LA ORDEN DE UN LABORATORIO
*/

/* DECLARACIÓN DE LA CLASE */
class resultado
{
   var $id;
   var $od;
   var $exa;
   var $cedemp;
   var $obs;
   var $fing;
   var $usu;
   
/* FUNCIÓN CONSTRUCTORA */  
   function resultado($id,$o,$e,$ce,$obs,$fi,$u)
   {
		$this->conexion=Conectarse();
		$this->id=$id;
   		$this->od=$o;
   		$this->exa=$e;
		$this->cedemp=$ce;
   		$this->obs=$obs;
   		$this->fing=$fi;
   		$this->usu=$u;
	} //fin del constructor
	

/* FUNCIÓN PARA INSERTAR UN RESULTADO */  	
	function ins_result()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$usu=$_SESSION['cedu_usu'];
		$sql="INSERT INTO slc_resultados (slc_orden_id_orden, slc_examen_id_examen, 
		      slc_empleado_ced_empleado,observacion, fecha_ing_res,usuario) 
			  values ('$this->od','$this->exa','$this->cedemp','$this->obs','$hoy','$usu')";
		//echo $sql.'<br>';
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
			   $sql2="Select last_insert_id() from dual";
			   //echo $sql2.'<br>';
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
	} // fin de funcion insertar RESULTADO 
	
/* FUNCIÓN PARA INSERTAR UN RESULTADO */  	
	function mod_result()
	{
	   	$usu=$_SESSION['cedu_usu'];
		$sql="UPDATE slc_resultados
				SET slc_empleado_ced_empleado='$this->cedemp',
				observacion='$this->obs'
				WHERE id_resultados=$this->id
				AND slc_orden_id_orden=$this->od
				AND slc_examen_id_examen=slc_examen_id_examen";
		//echo $sql.'<br>';
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 	return true;   }
		else
		{	return false;  }
			   
	} // fin de funcion insertar RESULTADO 
	
	
	/* FUNCIÓN PARA MODIFICAR EL DETALLE DE UN RESULTADO */  	
	function mod_det_result($car,$res,$um,$tb)
	{

//mod_det_result($idcaract,$_POST[$idcar],$_POST[$idunime],$_POST[$idtabla]);

	   	$sql="UPDATE slc_det_resultados
				SET valor_resultado='$res',
				unid_medida_car='$um',
				tabla_proc_res='$tb'
				WHERE slc_resultados_id_resultados=$this->id
				AND slc_caract_id_caract=$car";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return true;
		else
	   		return false;

	} // fin de FUNCIÓN PARA MODIFICAR EL DETALLE DE UN RESULTADO
	
	function ins_det_result($car,$res,$um,$tb)
	{

	   	$sql="INSERT INTO slc_det_resultados (slc_resultados_id_resultados, slc_caract_id_caract, 
		      valor_resultado, unid_medida_car, tabla_proc_res) 
			  values ($this->id,$car,'$res','$um','$tb')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return true;
		else
	   		return false;

	} // fin de UNCIÓN PARA INSERTAR DETALLE DE UN RESULTADO

	function consul_det_result($exa,$car)
	{
	   	$sql="select slc_det_resultados.valor_resultado, slc_det_resultados.tabla_proc_res
			from slc_resultados, slc_det_resultados
			where slc_resultados.slc_orden_id_orden=$this->od
			and slc_resultados.slc_examen_id_examen=$exa
			and slc_det_resultados.slc_caract_id_caract=$car
			AND slc_det_resultados.slc_resultados_id_resultados = slc_resultados.id_resultados";
		$result=mysql_query($sql,$this->conexion);
		if($result)
		{
		   $row = mysql_fetch_row($result);
		   return $row;
		}
		else
		   return '';
	} // Fin FUNCIÓN PARA CONSULTAR EL DETALLE DE UN RESULTADO GUARDADO
	function consul_valor_result($exa,$car)
	{
	   	$sql="select slc_det_resultados.valor_resultado, slc_det_resultados.tabla_proc_res
			from slc_resultados, slc_det_resultados
			where slc_resultados.slc_orden_id_orden=$this->od			
			and slc_det_resultados.slc_caract_id_caract=$car
			AND slc_det_resultados.slc_resultados_id_resultados = slc_resultados.id_resultados";
		$result=mysql_query($sql,$this->conexion);
		if($result)
		{
		   $row = mysql_fetch_row($result);
		   return $row[0];
		}
		else
		   return '';
	} // Fin FUNCIÓN PARA CONSULTAR EL DETALLE DE UN RESULTADO GUARDADO
	
	function ver_resultado()
	{
		   	$sql="select 
			slc_resultados.slc_empleado_ced_empleado, slc_resultados.observacion,  
			slc_resultados.id_resultados
			from slc_resultados
			where slc_resultados.slc_orden_id_orden=$this->od
			and slc_resultados.slc_examen_id_examen=$this->exa";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if($result)
		{
		   $row = mysql_fetch_row($result);
		   return $row;
		}
		else
		   return false;
	} // fin de la función ver_resultado()
	
	function ver_total_examenes($feci,$fecf)
{
	$sql="SELECT count( slc_examen_id_examen ) , nomb_examen FROM slc_examen, slc_resultados WHERE id_examen = slc_examen_id_examen AND (fecha_ing_res between '$feci' AND '$fecf') GROUP BY slc_examen_id_examen order by nomb_examen";
	$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   //$row = mysql_fetch_row($result);
		   return $result;
		}
		else
			return false;
}
function mod_result_firma($ex)
	{

	   	$sql="update slc_examen_firmado set firma='C' where slc_examen_id_examen=".$ex." and slc_orden_id_orden=$this->od";
		  
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			return $sql;
		else
	   		return $sql;

	}	
	
}// fin de la clase orden

?>