<?php  
/* 
CLASE TIPOS DE CONDICIONES DE LA HISTORIA
CREADA POR: GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 09/08/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS TIPOS DE CONDICIONES DE LA HISTORIA MÉDICA
*/

/* DECLARACIÓN DE LA CLASE */
class tipcon
{
   var $cod;
   var $nom;
   var $des;
   var $orde;
   var $tiph;
   var $usu;
   var $sta;
   
/* FUNCIÓN CONSTRUCTORA */  
   function tipcon($c, $n, $d, $o, $th, $u, $s)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
		$this->des=$d;   		
		$this->orde=$o;
   		$this->tiph=$th;
   		$this->usu=$u;
		$this->sta=$s;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN TIPO DE CONDICION */  	
	function ins_tipcon()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_tipo_condicion  (nomb_tipocond, desc_tipocond, orden_tipocond, histo_tipocond, usuario_tipocond, fecha_ing_tipocond) VALUES (upper('$this->nom'), upper('$this->des'), '$this->orde', '$this->tiph', '$this->usu', '$hoy')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			$sqlp="select last_insert_id() from dual";
			$resultp=mysql_query($sqlp,$this->conexion);
			$row=mysql_fetch_array($resultp); 
			if ($resultp) 
			{
			   return $row[0];
			}
		else
			return 'false';

	} // fin de funcion  insertar 
function modf_tipcon()
	{
	   	$sql="UPDATE slc_tipo_condicion SET nomb_tipocond=upper('$this->nom'), desc_tipocond=upper('$this->des'), orden_tipocond='$this->orde', histo_tipocond='$this->tiph' WHERE id_tipocond ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		   return true;
		else
		   return false;

	} // fin de funcion  modificar 

/* FUNCIÓN PARA VISUALIZAR UN LISTADO*/  		
	function ver_tipcon()
	{
	   	$sql="SELECT * from slc_tipo_condicion where status_tipocond='A' order by orden_tipocond";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="300"><div align="left">Nombre</div></td>
				<td width="100"><div align="left">Tipo de historia</div></td>
				<td width="100"><div align="left">Orden</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[4].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[3].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver


/* FUNCIÓN PARA LLENAR COMBO DE TIPOS DE CONDICION */  		
	function combo_tipcon()
	{  $sql="SELECT distinct id_tipocond, nomb_tipocond from slc_tipo_condicion where status_tipocond<>'I' order by nomb_tipocond";
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
	} // fin de funcion COMBO

function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_tipo_condicion where nomb_tipocond='$this->nom'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
	function eliminar($id)
	{
	$sql="UPDATE slc_tipo_condicion SET status_tipocond='I' WHERE id_tipocond ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}
	

	
}// fin de la clase 

?>
