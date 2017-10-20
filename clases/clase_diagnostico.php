<?php  
/* 
CLASE DIAGNÓSTICO
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 08/07/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS DIAGNÓSTICOS
*/

/* DECLARACIÓN DE LA CLASE */
class diagnostico
{
   var $cod;
   var $nom;
   var $des;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function diagnostico($c, $a, $d)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$a;
   		$this->des=$d;
	} //fin del constructor
	

	/* FUNCIÓN PARA LLENAR COMBO DE DIAGNOSTICOS GENERALES */  		
	function diag_gral($des)
	{
	   	$sql="SELECT 
			id_diagnostico, 
			nomb_diagnostico
			from slc_diagnostico
			where length(id_diagnostico)=3
			order by nomb_diagnostico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
		    if(substr($des,0,3)==$row[0]) $sel=' selected ';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion combo de diagnósticos generales

	/* FUNCIÓN PARA LLENAR COMBO DE DIAGNOSTICOS ESPECÍFICOS DADO UN DIAGNOSTICO GENERAL */  		
	function diag_espec($dg,$des)
	{
		$sql="SELECT 
			id_diagnostico, 
			nomb_diagnostico
			from slc_diagnostico
			where id_diagnostico like '$dg%'
			and  id_diagnostico not like '$dg'
			order by id_diagnostico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
		    if($des==$row[0]) $sel=' selected ';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion combo de diagnósticos específicos
	
	
	/* FUNCIÓN PARA LLENAR COMBO DE DIAGNOSTICOS */  		
	function combo_diag($des)
	{
		$sql="SELECT 
			id_diagnostico, 
			nomb_diagnostico
			from slc_diagnostico
			where status_diagnostico='A'
			order by nomb_diagnostico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
		    if($des==$row[0]) $sel=' selected ';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion combo de diagnósticos 


	/* FUNCIÓN PARA BUSCAR NOMBRE DIAGNÓSTICO */  		
	function nomb_diag()
	{
		$sql="SELECT nomb_diagnostico
			from slc_diagnostico
			where id_diagnostico=$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   if($row = mysql_fetch_row($result))
		   	 return $row[0];
		   else
		     return false;
		}
		else
			return false;
	} // fin de funcion nombre de diagnóstico


	
/* FUNCIÓN PARA INSERTAR*/  	
function guardar_dia($usu)
	{	$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_diagnostico (nomb_diagnostico, desc_diagnostico, fecha_ing_diagnostico, usuario_diagnostico) VALUES (upper('$this->nom'), upper('$this->des'),'$hoy','$usu')";		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar
function modificar_dia()
	{
	   	$sql="UPDATE slc_diagnostico SET nomb_diagnostico=upper('$this->nom'), desc_diagnostico=upper('$this->des') WHERE id_diagnostico ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;

	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_diagnostico()
	{
	   	$sql="SELECT * from slc_diagnostico where status_diagnostico='A' order by nomb_diagnostico";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="700" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="700"><div align="left">Diagnóstico</div></td>
			  </tr>';
			 $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
		   if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$HTML.='<tr '.$color.'>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver examenes


function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_diagnostico where nomb_diagnostico='$this->nom'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}


function eliminar($id)
{
		$sql="UPDATE slc_diagnostico SET status_diagnostico='I' WHERE id_diagnostico='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}


}// fin de la clase diagnósticos

?>