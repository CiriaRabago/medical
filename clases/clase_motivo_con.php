<?php 
/* 
CLASE TIPO DE CARACTERISTICAS
CREADA POR: JOSE RAMIREZ
FECHA DE CREACIÓN: 08/03/2017
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS AL MOTIVO DE LA VISITA
*/

/* DECLARACIÓN DE LA CLASE */
class motivo_v
{
   var $cod;
   var $nom;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function motivo_v($c,$n)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
   		
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN motivo */  	
	function ins_motivo_v()
	{
	   	$sql="INSERT INTO slc_motivo_con (des_motivo) VALUES (upper('$this->nom'))";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar tipos de caracteristicas 
function modf_motivo_v()
	{
	   	$sql="UPDATE slc_motivo_con SET des_motivo= upper('$this->nom') WHERE id_motivo_v='$this->cod'";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar tipos de caracteristicas 

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE TIPOS DE CARATERISTICAS EXISTENTES */  		
	function ver_motivo_v()
	{
		$sql="SELECT id_motivo, des_motivo from slc_motivo_con order by des_motivo";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="700" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="700"><div align="left">Motivo de Visita</div></td>
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
	}
	function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_motivo_con where des_motivo='$this->nom'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
	function guardar_motivo_v($usu)
	{	$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_motivo_con (des_motivo, fecha_ing_motivo, usuario_motivo) VALUES (upper('$this->nom'),'$hoy','$usu')";		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}
	function modificar_motivo_v()
	{
	   	$sql="UPDATE slc_motivo_con SET des_motivo=upper('$this->nom') WHERE id_motivo ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;

	}
	
/* FUNCIÓN PARA LLENAR COMBO DE TIPOS DE CARACTERISTICAS */  		
	function combo_motivo_v($nom)
	{
	   	$sql="SELECT id_motivo, des_motivo from slc_motivo_con order by des_motivo";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {		   	 
		    $sel='';
		    if($nom==$row[1]) $sel=' selected ';
			$HTML.='<option value="'.$row[1].'" '.$sel.'>'.strtoupper($row[1]).'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE TIPOS DE CARACTERISTICAS		
function eliminar_motivo($id)
{
	$sql="DELETE FROM slc_motivo_con WHERE id_motivo ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
}// fin de la clase tipos de carateristicas

?>