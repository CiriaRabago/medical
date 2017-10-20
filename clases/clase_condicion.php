<?php  
/* 
CLASE CONDICIONES DE LA HISTORIA
CREADA POR: GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 21/08/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS TIPOS DE CONDICIONES DE LA HISTORIA MÉDICA
*/

/* DECLARACIÓN DE LA CLASE */
class condicion
{
   var $cod; 
   var $tip;
   var $nom;
   var $des;
   var $lis;
   var $mul;
   var $orde;
   var $usu;
   var $sta;
   
/* FUNCIÓN CONSTRUCTORA */  
   function condicion($c, $t, $n, $d, $l, $m, $o, $u, $s)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
		$this->tip=$t;
   		$this->nom=$n;
		$this->des=$d;  
		$this->lis=$l;  
		$this->mul=$m;   		
		$this->orde=$o;
   		$this->usu=$u;
		$this->sta=$s;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UNA CONDICION */  	
	function ins_condicion()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_condicion  (slc_tipo_condicion_id_tipocond, nomb_condicion, lista_val_condicion, desc_condicion, selec_multiple_condicion, orden_condicion, fecha_ing_condicion, usu_condicion) VALUES ('$this->tip', upper('$this->nom'), '$this->lis', upper('$this->des'), '$this->mul', '$this->orde', '$hoy','$this->usu')";
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
function modf_condicion()
	{
	   	$sql="UPDATE slc_condicion SET slc_tipo_condicion_id_tipocond= '$this->tip', nomb_condicion=upper('$this->nom'),lista_val_condicion= '$this->lis',desc_condicion=upper('$this->des'), selec_multiple_condicion='$this->mul', orden_condicion='$this->orde' WHERE id_condicion ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		   return true;
		else
		   return false;

	} // fin de funcion  modificar 

/* FUNCIÓN PARA VISUALIZAR UN LISTADO*/  		
	function ver_condicion($tipc)
	{	if ($tipc=='0')
			$a='';
		else
	     	$a="and slc_tipo_condicion_id_tipocond = '$tipc'";
	   	$sql="SELECT * from slc_condicion where status_condicion='A' $a order by orden_condicion";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="300"><div align="left">Nombre</div></td>
				<td width="100"><div align="left">Lista de Valores</div></td>
				<td width="100"><div align="left">Orden</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			if ($row[3]=='S')
				$l='Si';
			else
				$l='No';
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$l.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[6].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver

function ins_condicion_valor($idcon, $valcon, $usucon)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_valor_condicion (slc_condicion_id_condicion, valor_condicion, fecha_ing_valorcond, usu_valorcond) VALUES ('$idcon', '$valcon', '$hoy','$usucon')";
	
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 

//////////////////////////////////////////////////////////////////////////////	
/* FUNCIÓN PARA LLENAR COMBO DE TIPOS DE CONDICION */  		
	function combo_tipcon()
	{  $sql="SELECT distinct id_tipocond, nomb_tipocond from slc_tipo_condicion order by nomb_tipocond";
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
	$sql="select * from slc_condicion where nomb_condicion='$this->nom'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
	function eliminar($id)
	{
	$sql="UPDATE slc_condicion SET status_condicion='I' WHERE id_condicion ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}
}
?>