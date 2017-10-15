<?php 
class cupos
{
   var $id_can;
   var $id_esp;
   var $id_med;
   var $cantidad;
   var $fecha;
   var $estatus;
   var $labor;
   
/* FUNCIÓN CONSTRUCTORA */  
   function cupos($c, $d, $e, $f, $g, $h, $l)
   {
		$this->conexion=Conectarse();
		$this->id_can=$c;
   		$this->id_esp=$d;
   		$this->id_med=$e;
		$this->cantidad=$f;
   		$this->fecha=$g;
   		$this->estatus=$h;
		$this->labor=$l;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN CUPO PARA SERVICIO */  	
	function ins_cupo()
	{
	    $zone=(3600*-4.5); 
        $fecha=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_cant_cita  VALUES ('','$this->id_esp','$this->id_med','$this->cantidad','$fecha','0','$this->labor')";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar cupo
	
function mod_cupos()
	{
	   	$sql="UPDATE slc_cant_cita SET estatus_cant= '1' WHERE slc_medico_id_medico ='$this->id_med' and slc_especialidad_id_esp='$this->id_esp' and estatus_cant=0";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		 {
		   $zone=(3600*-4.5); 
           $fecha=gmdate("Y-m-d H:i:s", time() + $zone);
	   	   $sql="INSERT INTO slc_cant_cita  VALUES ('','$this->id_esp','$this->id_med','$this->cantidad','$fecha','0','$this->labor')";
		   //echo $sql;
		   $result=mysql_query($sql,$this->conexion);
		   if ($result) 
			   return true;
		   else
		       return false;	   
		  }	   
		else
			   return false;
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE CUPOS POR SERVICIOS */  		
	function ver_cupos($per)
	{
	
		if ($per=='0')
			$a='';
		else
	     	$a="and slc_especialidad_id_esp = '$per'";
	   	$sql="SELECT nomb_esp,
                     nomb_medico,
                     cant_cita,
					 slc_especialidad.id_esp,
					 slc_medico_id_medico,
					 dias_labor  
              FROM slc_cant_cita , 
                   slc_especialidad, 
                   slc_medico
              WHERE slc_especialidad_id_esp=slc_especialidad.id_esp  
                AND slc_medico_id_medico=ced_rif_medico
                AND estatus_cant=0 ".$a;
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Especialidad</div></td>
				<td width="300"><div align="left">Doctor</div></td>
				<td width="100"><div align="left">Cupos</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr  >
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[0].'</td> 
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[2].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver perfiles


/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE EXAMENES POR PERFIL PARA PLANTILLAS */  		
	function ver_cantidad()
	{		
	   	$sql="SELECT * FROM slc_cant_cita where slc_especialidad_id_esp='$this->id_esp' and slc_medico_id_medico='$this->id_med' and estatus_cant='0'";
                
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $dat='';
		   while ($row = mysql_fetch_row($result))
		   {
			$dat=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[6].'**';
			}	  
			return $dat;
		}
		else
		return false;
	} // fin de funcion ver cantidad cupos
function buscar_dia_lab() //funcion para ver si el registro existe 
	{
	$sql="select * from  slc_cant_cita where slc_medico_id_medico ='$this->id_med' and slc_especialidad_id_esp='$this->id_esp' and estatus_cant=0";
	//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 while ($row = mysql_fetch_row($result))
	    if($row[0]!='')
	  	   return $row[6];
	    else
		   return 'false';
	}
	
function eliminar()
{
	$sql="UPDATE slc_cant_cita SET estatus_cant= '1' WHERE slc_medico_id_medico ='$this->id_med' and slc_especialidad_id_esp='$this->id_esp' and estatus_cant=0";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
}// fin de la clase perfiles

?>
