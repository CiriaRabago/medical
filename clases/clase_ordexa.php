<?php 
/* DECLARACIÓN DE LA CLASE */
class ordexa
{
   var $cod;
   var $idp;
   var $ide;
   var $ord;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function ordexa($c, $p, $e, $o)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->idp=$p;
   		$this->ide=$e;
		$this->ord=$o;
	} //fin del constructor
	
function modf_ordexa()
	{ $x=0;
	  $sql="SELECT id_examen_perfil
		    FROM slc_examen_perfil, slc_examen 
            WHERE estatus_examen=0 
			  and id_examen = slc_examen_id_examen 
			  and abrev_examen='".$this->idp."'
			  and nomb_examen='".$this->ide."'"; 
	  $result=mysql_query($sql,$this->conexion);	 
	  if ($result) 
		{
		  while ($row = mysql_fetch_row($result))
		   {
	   	    $sql2="UPDATE slc_examen_perfil SET orden_area='$this->ord' WHERE id_examen_perfil =".$row[0];
		    $result=mysql_query($sql2,$this->conexion);
		    if (!$result) 
			   $x=1;
		    }
		 }
		 if($x=='0')
		    return true;
		 else
		    return false;		
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE PERFILES EXISTENTES */  		
	function ver_ordexa($per)
	{
	
		if ($per=='0')
			$a='';
		else
	     	$a="and abrev_examen= '$per'";
	   	$sql="SELECT abrev_examen, nomb_examen  ,orden_area,count(*)
              FROM slc_examen_perfil, slc_examen, slc_perfil 
              WHERE estatus_examen=0 and id_perfil = slc_perfil_id_perfil AND id_examen = slc_examen_id_examen $a
              group by abrev_examen, nomb_examen
              ORDER BY abrev_examen, orden_area";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Area</div></td>
				<td width="300"><div align="left">Examen</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr  >
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[0].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[1].'</td>
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

function combo_perfil()
	{
	$sql="SELECT abrev_examen ,count(*)
		  FROM  slc_examen
		  WHERE estatus_examen=0 
          group by abrev_examen
          ORDER BY abrev_examen"; 
	 $result=mysql_query($sql,$this->conexion);	 
	 if ($result) 
		{ 
		   $HTML.='';
		   while ($row = mysql_fetch_row($result))
		   {			
			$HTML.='<option value="'.$row[0].'">'.$row[0].'</option>';
			}       	  
		  return $HTML;
		}
		else
		return false;	
}
		
function combo_exam($a)
	{
	  $x='';
	  if($a!='' && $a!='0')
	    $x=" and abrev_examen='".$a."'";
	$sql="SELECT nomb_examen 
		  FROM slc_examen_perfil, slc_examen, slc_perfil 
          WHERE estatus_examen=0 and id_perfil = slc_perfil_id_perfil AND id_examen = slc_examen_id_examen ".$x."          
		  GROUP BY nomb_examen
          ORDER BY abrev_examen"; 	 
	 $result=mysql_query($sql,$this->conexion);	 
	 if ($result) 
		{ 
		   $HTML.='';
		   while ($row = mysql_fetch_row($result))
		   {			
			$HTML.='<option value="'.$row[0].'">'.$row[0].'</option>';
			}       	  
		  return $HTML;
		}
		else
		return false;	
 }

}// fin de la clase perfiles

?>