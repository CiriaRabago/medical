<?php  
/* DECLARACIÓN DE LA CLASE */
class res_estudio
{	
	var $id;
   var $id_v;
   var $des;
   var $id_u;
   var $fecha;

   
   
/* FUNCIÓN CONSTRUCTORA */  
   function res_estudio($id, $id_v, $des, $id_u, $fecha)
   {
		$this->conexion=Conectarse();
		$this->id=$id;
		$this->id_v=$id_v;
   		$this->des=$des;
   		$this->id_u=$id_u;
   		$this->fecha=$fecha;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_res_estudio()
	{
	   	$sql="INSERT INTO slc_res_estudio (id_visita, des_estudio, id_usuario, fecha_ing_res) VALUES ('$this->id_v', '$this->des', '$this->id_u', '$this->fecha')";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		   return true;		
		else
			 return mysql_error();
	} // fin de funcion  insertar 
	
	
	function cons_res_estudio2($id_v)
	{
	   	$sql="SELECT * FROM slc_res_estudio WHERE id_visita=".$id_v;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			  $cad=$reg[2];
			     return $cad;
			}
			   	 
		 }
		 else
			 return false; 
		
	}// fin de funcion  consulta beneficiario 
	function cons_res_estudio($id_v)
	{
	   	$sql="SELECT * FROM slc_res_estudio WHERE id_visita=".$id_v;
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
	   	if($n>0)
		   return true;
		else
			return false;
	}
		
	function mod_res_estudio($id_v) 
	{	
	   	$sql="UPDATE slc_res_estudio set des_estudio='$this->des', id_usuario='$this->id_u', fecha_ing_res='$this->fecha' where id_visita=".$id_v;
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}
	
	

}// fin de la clase beneficiario


?>
