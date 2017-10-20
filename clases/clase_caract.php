<?php  
/* 
CLASE EXAMEN
CREADA POR: Gratelly Garza Morillo
FECHA DE CREACIÓN: 05/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS CARACTETISTICAS DE LOS EXAMENES
*/

/* DECLARACIÓN DE LA CLASE */
class caract
{
   var $cod;
   var $unim;
   var $tipc;
   var $nom;
   var $valr;
   var $vpn;
   var $valo;
   var $vall;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function caract($c, $u, $t, $n, $vr, $pn, $vo, $vl, $d)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->unim=$u;   		
		$this->tipc=$t;
   		$this->nom=$n;
		$this->valr=$vr;
   		$this->vpn=$pn;
		$this->valo=$vo;
   		$this->vall=$vl;
		$this->desc=$d;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UNA CARACTERISTICA */  	
	function ins_caract()
	{
	   	$sql="INSERT INTO slc_caract (slc_unid_medida_id_unid_medida, 
		slc_tipo_caract_id_tipo_caract , nomb_caract, descrip_caract, val_ref_caract, 
		res_pn_caract , val_obs_caract, val_lista_caract) 
		VALUES ('$this->unim', 
		'$this->tipc', upper('$this->nom'), upper('$this->desc'), '$this->valr', 
		'$this->vpn', '$this->valo', '$this->vall')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar examenes 
function modf_caract()
	{
	   	$sql="UPDATE slc_caract SET slc_unid_medida_id_unid_medida='$this->unim',
		 slc_tipo_caract_id_tipo_caract= '$this->tipc', nomb_caract=upper('$this->nom'), 
		 val_ref_caract='$this->valr', res_pn_caract='$this->vpn', val_obs_caract='$this->valo', 
		 val_lista_caract='$this->vall', descrip_caract=upper('$this->desc')
		  WHERE id_caract ='$this->cod'";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar las carateristicas


/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE CARACTERISTICAS EXISTENTES */  		
	function ver_caract()
	{
	   	$sql="SELECT id_caract, slc_unid_medida_id_unid_medida,
		 slc_tipo_caract_id_tipo_caract, ltrim(nomb_caract), val_ref_caract,
		  res_pn_caract , val_obs_caract, val_lista_caract, descrip_caract
		  FROM slc_caract 
		  WHERE estatus_caract=0
		  ORDER BY ltrim(nomb_caract)";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="500" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="200" align="left">Caracteristicas</td>
				<td width="200" align="left">Descripcion</td>
				<td width="100" align="center">Valores</td>
			  </tr>';
           
		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
		    if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$HTML.='<tr '.$color.' >
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[3].'</td>
				<td class="texto" align="left">'.$row[8].'</td>
				<td class="texto" align="center"><img src="imagenes/edit.gif" alt="Editar Valores" onclick="valores('."'".$cadena."'".')" style="cursor:hand" /></td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver caracteristicas

function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_caract where slc_unid_medida_id_unid_medida='$this->unim' 
	and slc_tipo_caract_id_tipo_caract= '$this->tipc' 
	and nomb_caract='$this->nom'
	and descrip_caract='$this->desc'
	and val_ref_caract='$this->valr' 
	and  res_pn_caract='$this->vpn' and  val_obs_caract='$this->valo' 
	and val_lista_caract='$this->vall'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
	
/* FUNCION PARA BUSCAR LOS VALORES DE REFERENCIA ASOCIADOS A UNA CARACTERÍSTICA  */
function buscar_valor_ref()
{
	   	$sql="select id_valor_referencia, 
				valor_min_referencia, 
				valor_max_referencia,
				dia_min_referncia,
				mes_min_referencia,
				ano_min_referencia,
				dia_max_referencia,
				mes_max_referencia,
				ano_max_referencia,
				sexo_referencia
				from slc_valor_referencia
				where slc_caract_id_caract=$this->cod";
				
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr class="titulorep" align="center" >
				  <td rowspan="2"><div align="center">Valor Minimo </div></td>
				  <td rowspan="2"><div align="center">Valor M&aacute;ximo</div></td>
				  <td colspan="3"><div align="center">Desde</div></td>
				  <td colspan="3"><div align="center">Hasta</div></td>
				  <td rowspan="2"><div align="center">Sexo</div></td>
				  <td rowspan="2">Acci&oacute;n</td>
				</tr>
				<tr class="titulorep" align="center">
				  <td><div align="center">Dia</div></td>
				  <td><div align="center">Mes</div></td>
				  <td>A&ntilde;o</td>
				  <td>Dia</td>
				  <td>Mes</td>
				  <td>A&ntilde;o</td>
				</tr>';
           
		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
		    if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$HTML.='<tr class="texto" '.$color.' align="center">
			  <td>'.$row[1].'</td>
			  <td>'.$row[2].'</td>
			  <td>'.$row[3].'</td>
			  <td>'.$row[4].'</td>
			  <td>'.$row[5].'</td>
			  <td>'.$row[6].'</td>
			  <td>'.$row[7].'</td>
			  <td>'.$row[8].'</td>
			  <td>'.$row[9].'</td>
			  <td align="center"><img alt="Editar Valores" src="imagenes/edit.gif" onclick="editvalores('."'".$cadena."'".')" style="cursor:hand" />
				  <img src="imagenes/delete.gif" alt="Eliminar Valores" onclick="elimvalores('.$row[0].')" style="cursor:hand" /></td>
			</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
}

/*FUNCION PARA BUSCAR LOS VALORES DE UNA LISTA ASOCIADOS A UNA CARACTERISTICA */
function buscar_valor_lista()
{
	   	$sql="select id_lista_valores, 
				valor_lista_valores
				from slc_lista_valores
				where slc_caract_id_caract=$this->cod";
				
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr class="titulorep" align="center" >
				  <td width="300" >Valor</td>
				  <td width="100">Acci&oacute;n</td>
				</tr>';
           
		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
		    if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$HTML.='<tr class="texto" '.$color.' align="center">
			  <td align="left">'.$row[1].'</td>
			  <td align="center"><img alt="Editar Valor" src="imagenes/edit.gif" onclick="editvalis('."'".$cadena."'".')" style="cursor:hand" />
				  <img src="imagenes/delete.gif" alt="Eliminar Valor" onclick="elimvalis('.$row[0].')" style="cursor:hand" /></td>
			</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
}




function eliminar()
{
	$sql="delete FROM slc_caract WHERE id_caract ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function bus_caract1() //funcion para ver si el registro existe antes de ser eliminado
	{
	$sql="select * from slc_caract_examen where slc_caract_id_caract='$this->cod'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'Examenes';
	}
function bus_caract2() //funcion para ver si el registro existe antes de ser eliminado
	{
	$sql="select * from slc_lista_valores  where slc_caract_id_caract='$this->cod'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'Lista de Valores';
	}
function bus_caract3() //funcion para ver si el registro existe antes de ser eliminado
	{
	$sql="select * from slc_valor_referencia where slc_caract_id_caract='$this->cod'"; 

	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'Valores de Referencia';
	}
}// fin de la clase caract


class valoresref
{
   var $cod;
   var $cara;
   var $valmin;
   var $valmax;
   var $diades;
   var $mesdes;
   var $aniodes;
   var $diahas;
   var $meshas;
   var $aniohas;
   var $sexo;
   
/* FUNCIÓN CONSTRUCTORA */  
   function valoresref($c, $ca, $vm, $vx, $dd, $md, $ad, $dh, $mh, $ah, $s)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->cara=$ca;   		
		$this->valmin=$vm;
   		$this->valmax=$vx;
		$this->diades=$dd;
   		$this->mesdes=$md;
		$this->aniodes=$ad;
		$this->diahas=$dh;
   		$this->meshas=$mh;
		$this->aniohas=$ah;
		$this->sexo=$s;
	} //fin del constructor


	function ins_valref()
	{
	   	$sql="insert into slc_valor_referencia
			(slc_caract_id_caract,
			 valor_min_referencia,
			 valor_max_referencia,
			 dia_min_referncia,
			 mes_min_referencia,
			 ano_min_referencia,
			 dia_max_referencia,
			 mes_max_referencia,
			 ano_max_referencia,
			 sexo_referencia)
			VALUES ('$this->cara', '$this->valmin', '$this->valmax', 
			'$this->diades', '$this->mesdes', '$this->aniodes', 
			'$this->diahas', '$this->meshas', '$this->aniohas', '$this->sexo')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

	function eli_valref()
	{
	   	$sql="delete from slc_valor_referencia
			  where id_valor_referencia=$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

	function modif_valref()
	{
	   	$sql="update slc_valor_referencia
			 set slc_caract_id_caract=$this->cara,
			 valor_min_referencia=$this->valmin,
			 valor_max_referencia=$this->valmax,
			 dia_min_referncia=$this->diades,
			 mes_min_referencia=$this->mesdes,
			 ano_min_referencia=$this->aniodes,
			 dia_max_referencia=$this->diahas,
			 mes_max_referencia=$this->meshas,
			 ano_max_referencia=$this->aniohas,
			 sexo_referencia='$this->sexo'
			 where id_valor_referencia=$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

} // Fin de la clase valoresref



class valorlist
{
   var $cod;
   var $cara;
   var $valor;
   
/* FUNCIÓN CONSTRUCTORA */  
   function valorlist($c, $ca, $v)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->cara=$ca;   		
		$this->valor=$v;
	} //fin del constructor


	function ins_valorlist()
	{
	   	$sql="insert into slc_lista_valores
			(slc_caract_id_caract,
			 valor_lista_valores)
			VALUES ($this->cara, '$this->valor')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

	function eli_valorlist()
	{
	   	$sql="delete from slc_lista_valores
			  where id_lista_valores=$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

	function modif_valorlist()
	{
	   	$sql="update slc_lista_valores
			 set slc_caract_id_caract=$this->cara,
			 valor_lista_valores='$this->valor'
			 where id_lista_valores=$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar valores de referencia 

} // Fin de la clase valorlist



?>