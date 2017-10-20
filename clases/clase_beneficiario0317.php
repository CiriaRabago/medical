<?php  
/* DECLARACIÓN DE LA CLASE */
class beneficiario
{
   var $cedt;
   var $cedb;
   var $nomt;
   var $telt;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function beneficiario($cedt, $cedb, $nomt, $telt)
   {
		$this->conexion=Conectarse();
		$this->cedt=$cedt;
   		$this->cedb=$cedb;
	    $this->nomt=$nomt;
		$this->telt=$telt;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_beneficiario()
	{
	   	$sql="INSERT INTO slc_beneficiario VALUES ('$this->cedt', '$this->cedb', '$this->nomt', '$this->telt')";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		   return true;		
		else
			 return mysql_error();
	} // fin de funcion  insertar 
	
	function ins_contacto()
	{	
	   	$sql="INSERT INTO slc_contacto VALUES ('$this->cedt', '$this->nomt', '$this->telt')";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	} // fin de funcion  insertar 
	
	function cons_beneficiario($ced)
	{
	   	$sql="SELECT * FROM slc_beneficiario WHERE ced_beneficiario=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			   if($reg[1]==$ced)
			   { $cad=$reg[0]."**".$reg[1]."**".$reg[2]."**".$reg[3];
			     return $cad;
				 }
			   else
				 return false; 	 
			   }
		  }	   
		else
			   return false;
	} // fin de funcion  consulta beneficiario 

	function cons_contacto($ced)
	{
	   	$sql="SELECT * FROM slc_contacto WHERE ced_paciente=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
			   return $result;
		else
			   return false;
	} // fin de funcion  consulta contacto
function cons_titular($ced)
	{
	   	$sql="SELECT * FROM slc_beneficiario WHERE ced_titular=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			   if($reg[1]==$ced)
			   { $cad=$reg[0]."**".$reg[1]."**".$reg[2]."**".$reg[3];
			     return $cad;
				 }
			   else
				 return false; 	 
			   }
		  }	   
		else
			   return false;
	} // fin de funcion  consulta beneficiario 
	function mod_beneficiario()
	{	
	   	$sql="UPDATE slc_beneficiario set ced_titular='$this->cedt', nomb_titular='$this->nomt', telf_titular='$this->telt' where ced_beneficiario='$this->cedb'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}
	
	function mod_contacto()
	{	
	   	$sql="UPDATE slc_contacto set nomb_contacto='$this->nomt', telf_contacto='$this->telt' where ced_paciente='$this->cedb'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}

}// fin de la clase beneficiario


?>
