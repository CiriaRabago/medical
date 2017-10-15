<?php
/* 
CLASE USUARIO
CCREADA POR: Gratelly Garza Morillo
FECHA DE CREACIÓN: 21/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS AL USUARIO
*/


/* DECLARACIÓN DE LA CLASE */
class usuario
{
   var $usu;
   var $cla;
   var $fei;
   var $fed;
   var $ced;
   var $sta;
   var $tip;
   var $usur;
   //var $cede;
   
  
/* FUNCIÓN CONSTRUCTORA */  
   function usuario($us,$ca,$fi,$fd,$cd,$st,$tp,$ur)
   {
       	$this->conexion=Conectarse();
		$this->usu=$us;
		$this->cla=$ca;
		$this->fei=$fi;
		$this->fed=$fd;
		$this->ced=$cd;
		$this->sta=$st;
		$this->tip=$tp;
  		$this->usur=$ur;
	//	$this->cede=$ce;
   }
	
function buscar_usuario()
	{
	$sql="select nom1_empleado, nom2_empleado, ape1_empleado, ape2_empleado, clave from slc_empleado, slc_usuario where cedula=ced_empleado and cedula='$this->usu'";
	 $result=mysql_query($sql,$this->conexion);
     $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	   	if($n==0)
		{
		  $cadena='FALSE';
		 }
		 else
		 {
		    $cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4];
		 }
		 return $cadena;
	}


function buscar_usuario_perm()
	{
	$sql="select ced_empleado, nom1_empleado, nom2_empleado, ape1_empleado, ape2_empleado, status_usu 
	      from slc_empleado, slc_usuario 
		  where cedula=ced_empleado 
		  and cedula='$this->usu'";
	 $result=mysql_query($sql,$this->conexion);
     $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	   	if($n==0)
		{
		  $cadena=false;
		 }
		 else
		 {
		    $cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5];
		 }
		 return $cadena;
	}	
	
function modificar_clave()
{
	$sql="UPDATE slc_usuario SET CLAVE = '$this->cla' where cedula='$this->usu'"; 

	 $result=mysql_query($sql,$this->conexion);
			if ($result)
			   return true;
			else
			   return false;
}

function modificar_clave_otro($cede)
{
	$sql="UPDATE slc_usuario SET clave = '$this->cla', tipo='$this->tip', cede='$cede', status_usu='A' where cedula='$this->usu'"; 
//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
			if ($result)
			   return true;
			else
			   return false;
}
	
function guardar_usuario()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	$sql="INSERT INTO slc_usuario(cedula, clave, tipo,fecha_ing_usu,usuario,status_usu,cede) 
	 VALUES ('$this->ced', '$this->cla', '$this->tip','$hoy','$this->usur', 'A','$this->cede')"; 
	 $result=mysql_query($sql,$this->conexion);
			if ($result)
			   return true;
			else
			   return false;
	}
	
function eliminar($id)
{ $zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	$sql="UPDATE  slc_usuario SET status_usu='I', fecha_fin_usu='$hoy' where cedula='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}

/* FUNCIÓN PARA VERIFICAR SI UN USUARIO ESTA REGISTRADO */ 	
	function consult_usu()
	{
	   	$sql="select * from slc_usuario where cedula='$this->usu' and clave='$this->cla'";
		$result=mysql_query($sql,$this->conexion);
		$row=mysql_fetch_array($result); 
	   	$n=mysql_num_rows($result);
	   	
	   	if($n==0)
		  return '0';
		 else
		 {
		 	 if($row[4]=='A')
		   		{$cadena=$row[1].'**'.$row[3];
		   		return $cadena;}
			  else
				return '1';
		 }	

	}// fin de la funcion consult_usu
	
function consulta_usu()
	{
	   	$sql="select * from slc_usuario where cedula='$this->ced' ";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		$row=mysql_fetch_array($result); 
	    if($row[4]=='A')
		  {$cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[6].'**'.$row[7].'**'.$row[8];
		   return $cadena;}
		else
		    return '1';		 	

	}// fin de la funcion consult_usu	
function consult()
	{
	   	$sql="select * from slc_usuario where cedula='$this->ced'";
		$result=mysql_query($sql,$this->conexion);
		$row=mysql_fetch_array($result); 
	   	$n=mysql_num_rows($result);
	   	if($n==0)
		  return '0';
		 else
          return '1';

	}// fin de la funcion consult_usu

}// fin de la clase
?>
