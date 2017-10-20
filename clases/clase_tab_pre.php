<?php  
/* 
CLASE TAB_PRE
CREADA POR: JOSE RAMIREZ
FECHA DE CREACIÓN: 04/05/2017
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS Al tabulador de precios por empresa
*/

/* DECLARACIÓN DE LA CLASE */
class tab_pre
{
   var $id_t;
   var $id_s;
   var $id_e;
   var $fecha;
   var $id_u;
   var $pre;
   
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function tab_pre($i_t,$i_s,$i_e,$fec,$i_u,$pr)
   {
		$this->conexion=Conectarse();
		$this->id_t=$i_t;
   		$this->id_s=$i_s;
		$this->id_e=$i_e;   		
		$this->fecha=$fec;
   		$this->id_u=$i_u;
   		$this->pre=$pr;
		
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_tab_pre()
	{
	   	$sql="INSERT INTO slc_tab_pre (id_servicio,id_empresa,fecha_ing,id_usuario,precio) 
	   	VALUES ('$this->id_s', '$this->id_e', '$this->fecha', '$this->id_u','$this->pre')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}
	function bus_tab_pre($serv,$empr)
	{
	   	$sql="SELECT id_tab_pre, precio from slc_tab_pre where id_servicio= $serv and id_empresa= $empr" ;
	   	$result=mysql_query($sql,$this->conexion);
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {
			   
			   $cad=$reg[0]."**".$reg[1];
	    	   }
			     return $cad;
		  }	   
		else
			   return false;
	}
	function mod_tab_pre() 
	{	
	   	$sql="UPDATE slc_tab_pre set fecha_ing='$this->fecha', id_usuario='$this->id_u', precio='$this->pre' where id_tab_pre='$this->id_t'";
		$result=mysql_query($sql,$this->conexion);
		//echo $sql;
		if ($result) 
		  return true;
		else
		  return false;
	}


}// fin de la clase 

?>