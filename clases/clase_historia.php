<?php  
/* 
CLASE HISTORIA
CREADA POR: Ing. MONICA BATISTA
FECHA DE CREACIÓN: 16/07/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LA HISTORIA
*/

/* DECLARACIÓN DE LA CLASE */
class historiaA
{
   var $idha;
   var $cedha;
   var $coha;
   var $idvcha;
   var $vcha;
   var $usuha;

/* FUNCIÓN CONSTRUCTORA */  
   function historiaA($id, $ced, $co, $idvc, $vc, $usu)
   {
		$this->conexion=Conectarse();
		$this->idha=$id;
   		$this->cedha=$ced;
	    $this->coha=$co;
		$this->idvcha=$idvc;
		$this->vcha=$vc;
		$this->usuha=$usu;   		
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_hist_ha()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_historia_ant
		     (slc_paciente_id_paciente,slc_condicion_id_condicion,
			  slc_valor_condicion_id_valorcond,valor_cond_ha,fecha_ing_ha,usuario_ha)
			  VALUES ('$this->cedha', '$this->coha',
			  '$this->idvcha', '$this->vcha','$hoy','$this->usuha')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{	 
			return true;
		}
		else
			return false;
	} // fin de funcion  insertar 

/* FUNCIÓN PARA MODIFICAR*/  	
	function mod_hist_hau()
	{
	   	$sql="update slc_historia_ant
			set slc_valor_condicion_id_valorcond='$this->idvcha', 
			valor_cond_ha='$this->vcha'
			where slc_paciente_id_paciente='$this->cedha'
			and slc_condicion_id_condicion='$this->coha'";
		$result=mysql_query($sql,$this->conexion);
		if($result)
		    return true;
		else
			return false;
	} // fin de funcion mod_hist_hau 


/* FUNCIÓN PARA consultar la historia de un pac que almacena un valor unico*/  	
	function consul_hist_hau()
	{
	   	$sql="select slc_valor_condicion_id_valorcond, valor_cond_ha
			from slc_historia_ant
			where slc_paciente_id_paciente='$this->cedha'
			and slc_condicion_id_condicion='$this->coha'";
		$result=mysql_query($sql,$this->conexion);
		$row=mysql_fetch_array($result); 
		$n=mysql_num_rows($result);
	  	if($n==0)
			return 'ins';
	  	else
   		{
			if($row[0]==$this->idvcha && $row[1]==$this->vcha)
				return 'igu';
			else 
				return 'upd';
		}
	} // fin de funcion consul_hist_hau 

/* FUNCIÓN PARA consultar la historia de un pac que almacena un valor multiple*/  	
	function eli_hist_ham()
	{
	   	$sql="delete from slc_historia_ant
			where slc_paciente_id_paciente='$this->cedha'
			and slc_condicion_id_condicion=$this->coha";
			//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if($result)
		    return true;
		else
			return false;
	} // fin de funcion eli_hist_ham 
}// fin de la clase historiaA



/* DECLARACIÓN DE LA CLASE */
class historiaV
{
   var $idhv;
   var $vishv;
   var $cedhv;
   var $cohv;
   var $idvchv;
   var $vchv;
   var $usuhv;
 
/* FUNCIÓN CONSTRUCTORA */  
   function historiaV($id, $vi, $co, $idvc, $vc, $usu)
   {
		$this->conexion=Conectarse();
		$this->idhv=$id;
   		$this->vihv=$vi;
	    $this->cohv=$co;
		$this->idvchv=$idvc;
		$this->vchv=$vc;
		$this->usuhv=$usu;   		
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_hist_hv()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_historia_vis
		     (slc_visita_id_visita,slc_condicion_id_condicion,
			  slc_valor_condicion_id_valorcond,valor_cond_hv,fecha_ing_hv,usuario_hv)
			  VALUES ('$this->vihv', '$this->cohv',
			  '$this->idvchv', '$this->vchv','$hoy','$this->usuhv')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{	 
			return true;
		}
		else
			return false;
	} // fin de funcion  insertar 

/* FUNCIÓN PARA MODIFICAR*/  	
	function mod_hist_hvu()
	{
	   	$sql="update slc_historia_vis
			set slc_valor_condicion_id_valorcond='$this->idvchv', 
			valor_cond_hv='$this->vchv'
			where slc_visita_id_visita='$this->vihv'
			and slc_condicion_id_condicion='$this->cohv'";
		$result=mysql_query($sql,$this->conexion);
		if($result)
		    return true;
		else
			return false;
	} // fin de funcion mod_hist_hvu 


/* FUNCIÓN PARA consultar la historia de un pac que almacena un valor unico*/  	
	function consul_hist_hvu()
	{
	   	$sql="select slc_valor_condicion_id_valorcond, valor_cond_hv
			from slc_historia_vis
			where slc_visita_id_visita='$this->vihv'
			and slc_condicion_id_condicion='$this->cohv'";
		$result=mysql_query($sql,$this->conexion);
		$row=mysql_fetch_array($result); 
		$n=mysql_num_rows($result);
	  	if($n==0)
			return 'ins';
	  	else
   		{
			if($row[1]==$this->vchv && $row[0]==$this->idvchv)
				return 'igu';
			else 
				return 'upd';
		}	
	} // fin de funcion consul_hist_hvu 

/* FUNCIÓN PARA consultar la historia de un pac que almacena un valor multiple*/  	
	function eli_hist_hvm()
	{
	   	$sql="delete from slc_historia_vis
			where slc_visita_id_visita='$this->vihv'
			and slc_condicion_id_condicion=$this->cohv";
		$result=mysql_query($sql,$this->conexion);
		if($result)
		    return true;
		else
			return false;
	} // fin de funcion eli_hist_hvm 
}// fin de la clase historiaV

?>