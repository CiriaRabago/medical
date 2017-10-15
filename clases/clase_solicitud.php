<?php 
/* 
CLASE SOLICITUDES
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS SOLICITUDES DE ESTUDIOS ESPECÍFICOS
*/

/* DECLARACIÓN DE LA CLASE */
class solicitud
{
   var $cod;
   var $nom;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function solicitud($c, $n)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
	} //fin del constructor
	
/* FUNCIÓN PARA LISTAR LAS SOLICITUDES EN LA VISITA */  		
	function lista_sol($vi)
	{
	   	$sql="SELECT id_solicitud, 
			nomb_solicitud,
			precio_solicitud,
			(select count(slc_solicitud_id_solicitud) 
			 from slc_sol_visita
			 where slc_visita_id_visita=$vi
			 and status_sv='A'
			 and slc_solicitud_id_solicitud=id_solicitud) sovi,
			(select observacion_sv obse
			 from slc_sol_visita
			 where slc_visita_id_visita=$vi
			 and status_sv='A'
			 and slc_solicitud_id_solicitud=id_solicitud) obse
			from slc_solicitud
			where status_solicitud='A'
			order by nomb_solicitud";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
			 $n=mysql_num_rows($result);
	  	if($n==0)
			return 'false';
	  	else
   			return $result;
	} // fin de funcion combo

/* FUNCIÓN PARA INSERTAR*/  	
	function ins_solicitud($pre, $usu)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO  slc_solicitud (nomb_solicitud, precio_solicitud, fecha_ing_solicitud, usuario_solicitud) VALUES
		 (upper('$this->nom'), '$pre', '$hoy', '$usu')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
	
function modf_solicitud($pre)
	{
	   	$sql="UPDATE slc_solicitud SET nomb_solicitud= upper('$this->nom'), precio_solicitud= upper('$pre') WHERE id_solicitud ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_solicitud()
	{
	   	$sql="SELECT * FROM slc_solicitud where status_solicitud='A'order by nomb_solicitud";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="500"><div align="left">Nombre de la Solicitud</div></td>
				<td width="100"><div align="left">Precio</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 

function eliminar()
{   
	$sql="UPDATE  slc_solicitud SET status_solicitud='I' where id_solicitud='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
}// fin de la clase

?>