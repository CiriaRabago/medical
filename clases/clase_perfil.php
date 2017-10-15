<?php 
/* 
CLASE PERFILES
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS PERFILES DE EXAMENTES
*/

/* DECLARACIÓN DE LA CLASE */
class perfil
{
   var $cod;
   var $nom;
   var $des;
   var $pre;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function perfil($c, $a, $d, $p)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$a;
   		$this->des=$d;
		$this->pre=$p;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN PERFIL */  	
	function ins_perfil($tip)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_perfil (nomb_perfil, desc_perfil, precio,tipo_perfil) VALUES (upper('$this->nom'), upper('$this->des'), '$this->pre','$tip')";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	$usu=$_SESSION['cedu_usu'];
			$sqlp="insert into slc_precios (id_perfil,precio,fecha_ing_precio,fecha_fin_precio,usuario) select last_insert_id(), '$this->pre','$hoy',NULL,'$usu' from dual";
			$resultp=mysql_query($sqlp,$this->conexion);
			if ($resultp) 
			{
			   return true;
			}
			else
				return false;
		}
		else
			   return false;
	} // fin de funcion  insertar perfiles

	function cambio_de_precio($pr,$pe,$us)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="UPDATE slc_precios SET  fecha_fin_precio='$hoy' where id_perfil='$pe' and fecha_fin_precio is NULL";
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			$sqlp="INSERT INTO slc_precios (precio, fecha_ing_precio, usuario,id_perfil) VALUES ('$pr', '$hoy','$us', '$pe')";
			$resultp=mysql_query($sqlp,$this->conexion);
			if ($resultp) 
			{
			   return true;
			}
			else
				return false;
		}
		else
			   return false;
	} // fin de funcion  insertar perfiles


function modf_perfil($tip)
	{
	   	$sql="UPDATE slc_perfil SET nomb_perfil= upper('$this->nom'), desc_perfil= upper('$this->des'), precio='$this->pre', tipo_perfil='$tip' WHERE id_perfil ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE PERFILES EXISTENTES */  		
	function ver_perfil()
	{
	   	$sql="SELECT id_perfil, nomb_perfil, desc_perfil, precio, tipo_perfil from slc_perfil where estatus_perfil=0 order by nomb_perfil";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200"><div align="left">Nombre</div></td>
				<td width="300"><div align="left">Descripción</div></td>
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


/* FUNCIÓN PARA LLENAR COMBO DE PERFILES */  		
	function combo_perfil()
	{
	   	$sql="SELECT 
			id_perfil, 
			nomb_perfil
			from slc_perfil
			where estatus_perfil=0
			order by nomb_perfil";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
		    if($this->cod==$row[0]) $sel=' selected ';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion combo de perfiles

function buscar($tip) //funcion para ver si el registro existe 
	{
	$sql="select * from slc_perfil where nomb_perfil= '$this->nom' and desc_perfil= '$this->des' and precio='$this->pre' and tipo_perfil='$tip'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
function eliminar()
{
	$sql="delete FROM slc_perfil WHERE id_perfil ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function bus_perfil() //funcion para ver si el registro existe 
	{
	$sql="select * from  slc_examen_perfil where slc_perfil_id_perfil= '$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
function busca_perfil() //funcion para ver si el registro existe 
	{
	$sql="select * from  slc_perfil where id_perfil= '$this->cod' and estatus_perfil='0'";	 	
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return $result;
	}

}// fin de la clase perfiles

?>