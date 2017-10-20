<?php  
class cita
{
   var $id_cit;
   var $id_cci;
   var $feccit;
   var $cedpac;
   var $estcit;
   
/* FUNCIÓN CONSTRUCTORA */  
   function cita($c, $d, $e, $f, $g)
   {
		$this->conexion=Conectarse();
		$this->id_cit=$c;
   		$this->id_cci=$d;
   		$this->feccit=$e;
		$this->cedpac=$f;
   		$this->estcit=$g;   		
	} //fin del constructor
	

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE CUPOS POR SERVICIOS */  		
	function ver_citas($espe,$medi,$fechas)
	{   $a=''; 
	    $feci=substr($fechas,6,4).'-'.substr($fechas,3,2).'-'.substr($fechas,0,2).' 00:00:00'; 
	    $fecf=substr($fechas,6,4).'-'.substr($fechas,3,2).'-'.substr($fechas,0,2).' 99:00:00'; 
	    if($espe!=0)
		   $a.=' and slc_especialidad_id_esp='.$espe;
		if($medi!=0)
		   $a.=' and slc_medico_id_medico='.$medi;   
	    $sql="SELECT nomb_esp,
                     nomb_medico,                     
					 cant_cita,
					 slc_especialidad.id_esp,
					 slc_medico_id_medico,
					 id_cant_cita,
					 dias_labor  
              FROM slc_cant_cita , 
                   slc_especialidad, 
                   slc_medico
              WHERE slc_especialidad_id_esp=slc_especialidad.id_esp  
                AND slc_medico_id_medico=ced_rif_medico
                AND estatus_cant=0 ".$a." 
		      GROUP BY nomb_esp, nomb_medico";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Especialidad</div></td>
				<td width="300"><div align="left">Doctor</div></td>
				<td width="100"><div align="left">Cupos Registrados</div></td>
				<td width="100"><div align="left">Cupos Disponibles</div></td>
			  </tr>';           
		   while ($row = mysql_fetch_row($result))
		   {
		    $sql2="SELECT count(*) 
			       FROM slc_cita 
				   WHERE fecha_cita>='".$feci."' 
				     and fecha_cita<='".$fecf."' 
					 and estatus_cita=0 
					 and id_cant_cita=".$row[5];
			//echo $sql2;		 
			$resulta2=mysql_query($sql2,$this->conexion); 
			$citado=0;
			while ($row2 = mysql_fetch_row($resulta2))
			  { $citado=$row2[0]; }
			$cadena=implode('/*',$row);
			$HTML.='<tr  >
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[0].'</td> 
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$citado.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.($row[2]-$citado).'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver perfiles

	function ver_citas_asignadas($espe,$medi,$fechas)
	{   $a=''; 
	    $feci=substr($fechas,6,4).'-'.substr($fechas,3,2).'-'.substr($fechas,0,2).' 00:00:00'; 
	    $fecf=substr($fechas,6,4).'-'.substr($fechas,3,2).'-'.substr($fechas,0,2).' 99:00:00'; 
	    if($espe!=0)
		   $a.=' and slc_especialidad_id_esp='.$espe;
		if($medi!=0)
		   $a.=' and slc_medico_id_medico='.$medi;   
	    $sql="SELECT nomb_esp,
                     nomb_medico,                     
					 cant_cita,
					 slc_especialidad.id_esp,
					 slc_medico_id_medico,
					 id_cant_cita,
					 dias_labor  
              FROM slc_cant_cita , 
                   slc_especialidad, 
                   slc_medico
              WHERE slc_especialidad_id_esp=slc_especialidad.id_esp  
                AND slc_medico_id_medico=ced_rif_medico
                AND estatus_cant=0 ".$a." 
		      GROUP BY nomb_esp, nomb_medico";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="800" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="100"><div align="center">Numero Paciente</div></td>
			    <td width="100"><div align="center">Numero Cita</div></td>
				<td width="200"><div align="left">Especialidad</div></td>
				<td width="300"><div align="left">Doctor</div></td>
				<td width="300"><div align="left">Paciente</div></td>				
			  </tr>';           
			$count=0;  
		   while ($row = mysql_fetch_row($result))
		   {
		    $sql2="SELECT * 
			       FROM slc_cita
				   WHERE fecha_cita>='".$feci."' 
				     and fecha_cita<='".$fecf."' 
					 and estatus_cita=0 					 
					 and id_cant_cita=".$row[5]."
				   ORDER BY id_cita";
			//echo $sql2;		 
			$resulta2=mysql_query($sql2,$this->conexion); 
			$citado=0;
			while ($row2 = mysql_fetch_row($resulta2))
			  { $citado=$row2[0]; 
			    $sql3="SELECT * 
			           FROM slc_paciente
				       WHERE ced_paciente=".$row2[3];
			//echo $sql2;		 
			$resulta3=mysql_query($sql3,$this->conexion); 			
			while ($row3 = mysql_fetch_row($resulta3))
			  {  $nom=$row3[2].' '.$row3[3].' '.$row3[4].' '.$row3[5];}
			$cadena=implode('/*',$row);
			$count++;
			$HTML.='<tr  >
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="center"><strong>'.$count.'</strong></td> 
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="center"><strong>'.$row2[0].'</strong></td> 
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[0].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row2[3].'-'.$nom.'</td>
				</tr>';
				}
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver perfiles

/* FUNCIÓN PARA CONSULTAR DATOS DE CANTIDAD DE CUPOS POR ESPECIALIDAD*/  		
	function ver_cantidad($exa,$med)
	{		
	   	$sql="SELECT * FROM slc_cant_cita where slc_especialidad_id_esp=".$exa." and slc_medico_id_medico='".$med."' and estatus_cant=0";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $dat='';
		   while ($row = mysql_fetch_row($result))
		   {
			$dat=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**';
			}	  
			return $dat;
		}
		else
		return false;
	} // fin de funcion ver cantidad cupos




function buscar_citas_fecha($espe,$medi,$fecha) //funcion para ver si el registro existe 
	{
	$feci=substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2).' 00:00:00'; 
	$fecf=substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2).' 99:00:00'; 
	$sql="select count(*) 
	      from  slc_cita,
		        slc_cant_cita 
		   where slc_cita.id_cant_cita=slc_cant_cita.id_cant_cita 
		     and slc_cant_cita.slc_especialidad_id_esp=".$espe.
			" and slc_cant_cita.slc_medico_id_medico=".$medi.
			" and fecha_cita>='".$feci.
			"' and fecha_cita<='".$fecf."'";
	  //echo $sql;		 
	 $result=mysql_query($sql,$this->conexion);
	  if($result)
	   {
		while ($row = mysql_fetch_row($result))
		 {
		   return $row[0];
		  }
	   }
	  else
	   return '0';
	  
	}
	
function ins_cita() //funcion para insertar cita 
	{
	$fec=substr($this->feccit,6,4).'-'.substr($this->feccit,3,2).'-'.substr($this->feccit,0,2); 
	$sql="INSERT INTO slc_cita VALUES('',$this->id_cci,'$fec',$this->cedpac,'0')"; 
	//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 
	  if($result)	   
	   {
	     $sql2="select max(id_cita) from slc_cita";
		 //echo $sql2;
		 $result2=mysql_query($sql2,$this->conexion);
	     while ($row2 = mysql_fetch_row($result2))
		   {
		     return $row2[0];
		   }
	    }
	  else
	     return false;	
	}		  
			
function validar_cita() //funcion para insertar cita 
	{
	$fec=substr($this->feccit,6,4).'-'.substr($this->feccit,3,2).'-'.substr($this->feccit,0,2); 
	$sql="SELECT * FROM slc_cita WHERE fecha_cita='".$fec."' and cedula_paciente=$this->cedpac and estatus_cita=0"; 
	//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 
	  if($result)	   
	   {$r=0;
	     while ($row2 = mysql_fetch_row($result))
		   {  
		     $r=$row2[0];
		   }
		   return $r;
	    }
	  else
	     return false;	
	}					  
}// fin de la clase perfiles

?>
