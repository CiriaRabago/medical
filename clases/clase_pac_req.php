<?php 
/* DECLARACIÓN DE LA CLASE */
class pac_req
{
   var $id;
   var $id_p;
   var $id_req;
   var $sta;
 
   
/* FUNCIÓN CONSTRUCTORA */  
   function pac_req($id, $id_p, $id_req, $sta)
   {
		$this->conexion=Conectarse();
		$this->id=$id;
   		$this->id_p=$id_p;
	    $this->id_req=$id_req;
	    $this->sta=$sta;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_pac_req()
	{
	   	$sql="INSERT INTO slc_paciente_requisito (id_paciente, id_requisito, est_pac_req) VALUES ('$this->id_p', '$this->id_req', '$this->sta')";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		   return true;		
		else
			 return mysql_error();
	} // fin de funcion  insertar 
	
	
	function cons_pac_req()
	{
	   	$sql="SELECT * FROM slc_paciente_requisito WHERE id_paciente='$this->id_p' and id_requisito='$this->id_req'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
			   return $result;
		else
			   return false;
	} // fin de funcion  consulta beneficiario 
	function cons_pac_req2()
	{
	   	$sql="SELECT * FROM slc_paciente_requisito WHERE id_paciente='$this->id_p' and id_requisito='$this->id_req' and est_pac_req='$this->sta' ";
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return $n;
	
	}
		function cons_pac_req3($ced)
	{
	   	$sql="SELECT * FROM slc_paciente_requisito WHERE id_paciente=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			   if($reg[2]==$ced)
			   { $cad=$reg[1].'**'.$reg[2];
			     return $cad;
				 }
			   else
				 return false; 	 
			   }
		  }	   
		else
			   return false;
	}
	function mod_pac_req() 
	{	
	   	$sql="UPDATE slc_paciente_requisito set id_paciente='$this->id_p', id_requisito='$this->id_req', estatus_pac_req='$this->sta' where id_paciente='$this->id_p' and id_requisito='$this->id_req'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}
	
	function eliminar_pac_req($id_p, $id_req)
{
	$sql="DELETE FROM slc_paciente_requisito WHERE id_paciente ='$id_p' and id_requisito='$id_req'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}

}// fin de la clase beneficiario


?>
