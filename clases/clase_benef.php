<?php 
/* DECLARACIÓN DE LA CLASE */
class benef
{
   var $cedt;
   var $cedb;
   var $nomt;
   var $fech;
   var $usua;
   var $telt;
   var $pare;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function benef($cedt, $cedb, $nomt, $fech, $usua, $telt, $pare)
   {
		$this->conexion=Conectarse();
		$this->cedt=$cedt;
   		$this->cedb=$cedb;
	    $this->nomt=$nomt;
	    $this->fech=$fech;
		$this->usua=$usua;
		$this->telt=$telt;
		$this->pare=$pare;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_benef()
	{
	   	$sql="INSERT INTO slc_benef (ced_titular, ced_benf, nomb_titular, fecha_ing, usuario_ing, tel_titular, par_titular) VALUES ('$this->cedt', '$this->cedb', upper('$this->nomt'), '$this->fech', '$this->usua', '$this->telt', '$this->pare')";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		   return true;		
		else
			 return mysql_error();
	} // fin de funcion  insertar 
	
	
	function cons_benef2($ced)
	{
	   	$sql="SELECT * FROM slc_benef WHERE ced_benf=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			   if($reg[2]==$ced)
			   { $cad=$reg[1]."**".$reg[2]."**".$reg[3]."**".$reg[6].'**'.$reg[7];
			     return $cad;
				 }
			   else
				 return false; 	 
			   }
		  }	   
		else
			   return false;
	} // fin de funcion  consulta beneficiario 
	function cons_benef($ced)
	{
	   	$sql="SELECT * FROM slc_benef WHERE ced_benf=".$ced;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
			   return $result;
		else
			   return false;
	}
		function cons_benef3($ced)
	{
	   	$sql="SELECT * FROM slc_benef WHERE ced_benf=".$ced;
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
	function mod_benef() 
	{	
	   	$sql="UPDATE slc_benef set ced_titular='$this->cedt', nomb_titular=upper('$this->nomt'), tel_titular='$this->telt',par_titular='$this->pare' where ced_benf='$this->cedb'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}
	
	

}// fin de la clase beneficiario


?>
