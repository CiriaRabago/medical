<?php  
/* 
CLASE TIPO DE CARACTERISTICAS
CREADA POR: Gratelly Garza Morillo
FECHA DE CREACIÓN: 03/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS TIPOS DE CARACTERISTICAS
*/

/* DECLARACIÓN DE LA CLASE */
class tipcar
{
   var $cod;
   var $nom;
   var $des;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function tipcar($c,$n,$d)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
   		$this->des=$d;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UNA UNIDAD DE MEDIDA */  	
	function ins_tipcar()
	{
	   	$sql="INSERT INTO slc_tipo_caract (nomb_tipo_caract, desc_tipo_caract) VALUES (upper('$this->nom'), upper('$this->des'))";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar tipos de caracteristicas 
function modf_tipcar()
	{
	   	$sql="UPDATE slc_tipo_caract SET nomb_tipo_caract= upper('$this->nom'), desc_tipo_caract= upper('$this->des') WHERE id_tipo_caract='$this->cod'";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar tipos de caracteristicas 

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE TIPOS DE CARATERISTICAS EXISTENTES */  		
	function ver_tipcar()
	{
	   	$sql="SELECT id_tipo_caract, nomb_tipo_caract, desc_tipo_caract from slc_tipo_caract order by nomb_tipo_caract";
		
		$result=mysql_query($sql,$this->conexion);

		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="300"><div align="left">Nombre</div></td>
				<td width="300"><div align="left">Descripción</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[2].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver tipos de caracteristicas 
	
function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_tipo_caract where nomb_tipo_caract= '$this->nom' and desc_tipo_caract= '$this->des'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
/* FUNCIÓN PARA LLENAR COMBO DE TIPOS DE CARACTERISTICAS */  		
	function combo_tipcar()
	{
	   	$sql="SELECT distinct id_tipo_caract, nomb_tipo_caract from slc_tipo_caract order by nomb_tipo_caract";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE TIPOS DE CARACTERISTICAS		
function eliminar()
{
	$sql="delete FROM slc_tipo_caract WHERE id_tipo_caract ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function bus_tipcar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_caract where slc_tipo_caract_id_tipo_caract= '$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
}// fin de la clase tipos de carateristicas

?>