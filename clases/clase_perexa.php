<?php  
/* 
CLASE PERFILES
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 05/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS PERFILES Y EXAMENTES
*/

/* DECLARACIÓN DE LA CLASE */
class perexa
{
   var $cod;
   var $idp;
   var $ide;
   var $ord;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function perexa($c, $p, $e, $o)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->idp=$p;
   		$this->ide=$e;
		$this->ord=$o;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN PERFIL CON SU EXAMEN */  	
	function ins_perexa()
	{
	   	$sql="INSERT INTO slc_examen_perfil VALUES ('','$this->idp', '$this->ide', '$this->ord','')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar perfiles y examen
function modf_perexa()
	{
	   	$sql="UPDATE slc_examen_perfil SET slc_perfil_id_perfil= '$this->idp', slc_examen_id_examen= '$this->ide', orden_examen='$this->ord' WHERE id_examen_perfil ='$this->cod'";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE PERFILES EXISTENTES */  		
	function ver_perexa($per)
	{
	
		if ($per=='0')
			$a='';
		else
	     	$a="and slc_perfil_id_perfil = '$per'";
	   	$sql="SELECT DISTINCT id_examen_perfil, nomb_perfil, nomb_examen, slc_perfil_id_perfil, slc_examen_id_examen, orden_examen  FROM slc_examen_perfil, slc_examen, slc_perfil WHERE estatus_examen=0 and id_perfil = slc_perfil_id_perfil AND id_examen = slc_examen_id_examen $a ORDER BY nomb_perfil, orden_examen";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Perfil</div></td>
				<td width="300"><div align="left">Examen</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr  >
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
	function ver_exa_per_planti($per)
	{
	
		if ($per=='0')
			$a='';
		else
	     	$a="and slc_perfil_id_perfil = '$per'";
	   	$sql="SELECT DISTINCT id_examen_perfil, nomb_perfil, nomb_examen, 
		      slc_perfil_id_perfil, slc_examen_id_examen  
			  FROM slc_examen_perfil, slc_examen, slc_perfil 
			  WHERE id_perfil = slc_perfil_id_perfil 
			  AND id_examen = slc_examen_id_examen $a 
			  ORDER BY nomb_perfil, nomb_examen";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Perfil</div></td>
				<td width="300"><div align="left">Examen</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<tr  >
				<td style="cursor:hand" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_planti('.$row[4].",'".$row[3]."'".')" class="texto">'.$row[2].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver perfiles




function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from  slc_examen_perfil where slc_perfil_id_perfil= '$this->idp' and slc_examen_id_examen= '$this->ide'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
	function eliminar()
{
	$sql="delete FROM slc_examen_perfil WHERE id_examen_perfil ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
}// fin de la clase perfiles

?>