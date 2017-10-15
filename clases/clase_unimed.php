<?php 
/* 
CLASE UNIDAD DE MEDIDA
CREADA POR: Gratelly Garza Morillo
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS  UNIDADES DE MEDIDA
*/

/* DECLARACIÓN DE LA CLASE */
class unimed
{
   var $cod;
   var $abr;
   var $des;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function unimed($c,$a,$d)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->abr=$a;
   		$this->des=$d;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UNA UNIDAD DE MEDIDA */  	
	function ins_unimed()
	{
	   	$sql="INSERT INTO slc_unid_medida (nomenc_unid_medida, desc_unid_medida) VALUES ('$this->abr', '$this->des')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar unidad de medida 
function modf_unimed()
	{
	   	$sql="UPDATE slc_unid_medida SET nomenc_unid_medida= '$this->abr', desc_unid_medida= '$this->des' WHERE id_unid_medida ='$this->cod'";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar unidad de medida

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE UNIDADES DE MEDIDA EXISTENTES */  		
	function ver_unimed()
	{
	   	$sql="SELECT id_unid_medida, nomenc_unid_medida, desc_unid_medida from slc_unid_medida order by nomenc_unid_medida";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="400" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="100"><div align="left">Abreviatura</div></td>
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
	} // fin de funcion ver unidad de medida 
	
function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_unid_medida where nomenc_unid_medida= '$this->abr' and desc_unid_medida= '$this->des'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
/* FUNCIÓN PARA LLENAR COMBO DE UNIDADES DE MEDIDA */  		
	function combo_unimed()
	{
	   	$sql="SELECT distinct id_unid_medida, nomenc_unid_medida from slc_unid_medida order by nomenc_unid_medida";
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
	} // fin de funcion COMBO DE UNIDADES DE MEDIDA 	
function eliminar()
{
	$sql="delete FROM slc_unid_medida WHERE id_unid_medida ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function bus_unimed() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_caract where slc_unid_medida_id_unid_medida= '$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
}// fin de la clase unidad de medida

?>