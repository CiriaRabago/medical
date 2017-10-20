<?php  
/* 
CLASE EMPRESA
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 22/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS EMPRESAS
*/

/* DECLARACIÓN DE LA CLASE */
class empresa_pres
{
   var $rif;
   var $nom;
   var $dire;
   var $fax;
   var $te1;
   var $te2;
   var $con;
   var $des;
   var $usu;
   var $cod;
   var $iva;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function empresa_pres($ri, $no, $di, $fa, $t1, $t2, $co, $de, $us,$cd,$iv)
   {
		$this->conexion=Conectarse();
		$this->rif=$ri;
   		$this->nom=$no;
		$this->dire=$di;   		
		$this->fax=$fa;
   		$this->te1=$t1;
   		$this->te2=$t2;
		$this->con=$co;
   		$this->des=$de;   		
		$this->usu=$us;
		$this->cod=$cd;
		$this->iva=$iv;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_empresa_pres()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_empresa_pres (rif_empresa, nom_empresa, direc_empresa, telf_fax_empresa,
		 telf1_empresa, telf2_empresa, cont_empresa, desc_empresa,fecha_ing_emp,usuario, reten_iva) VALUES
		 ('$this->rif', upper('$this->nom'), upper('$this->dire'), '$this->fax', '$this->te1', '$this->te2', upper('$this->con'),
		 upper('$this->des'),'$hoy','$this->usu','$this->iva')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
function modf_empresa_pres()
	{
	   	$sql="UPDATE slc_empresa_pres SET rif_empresa='$this->rif', nom_empresa=upper('$this->nom'), direc_empresa=upper('$this->dire'),
		 telf_fax_empresa='$this->fax', telf1_empresa='$this->te1', telf2_empresa='$this->te2', cont_empresa=upper('$this->con'),
		  desc_empresa=upper('$this->des'), reten_iva='$this->iva' WHERE id_empresa ='$this->cod'";
		
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_empresa_pres()
	{
	   	$sql="SELECT * from slc_empresa_pres where sta_empresa='A' order by nom_empresa";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="550" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="50"><div align="center">#</div></td>
				<td width="400"><div align="left">Nombre</div></td>
				<td width="150"><div align="left">Rif</div></td>
			  </tr>';
           $xx=0;   
		   while ($row = mysql_fetch_row($result))
		   {$xx++;
			$cadena=implode('/*',$row);
			$HTML.='<tr>
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$xx.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[1].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 

	function ver_empresa_inactiva_pres()
	{
	   	$sql="SELECT * from slc_empresa_pres where sta_empresa<>'A' order by nom_empresa";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="550" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="50"><div align="center">#</div></td>
				<td width="400"><div align="left">Nombre</div></td>
				<td width="150"><div align="left">Rif</div></td>
				<td width="150"><div align="left">Direccion</div></td>
				<td width="150"><div align="left">Telefono</div></td>
			  </tr>';
           $xx=0;   
		   while ($row = mysql_fetch_row($result))
		   {$xx++;
			$cadena=implode('/*',$row);
			$HTML.='<tr>
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$xx.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[3].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[5].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 


/* FUNCIÓN PARA LLENAR COMBO DE EMPRESAS */  		
	function combo_emp_pres2($p)
	{  $sql="SELECT id_empresa, nom_empresa from slc_empresa_pres where sta_empresa='A' order by nom_empresa";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			if($p==$row[0]) $sel=' selected '; else $sel=' ';
			$HTML.='<option value="'.$row[0].'" '.$sel.' >'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE EMPRESAS 
	function combo_emp_pres($p)
	{  $sql="SELECT id_empresa, nom_empresa, reten_iva from slc_empresa_pres where sta_empresa='A' order by nom_empresa";
		$result=mysql_query($sql,$this->conexion);
			if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			if($p==$row[0]) $sel=' selected '; else $sel=' ';
			$HTML.='<option value="'.$row[0].'*'.$row[2].'*'.$row[1].'" '.$sel.' >'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	}
function buscar_pres() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_empresa_pres where nom_empresa='$this->nom'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
function ver_empre_pres($id) //funcion para ver si el registro existe 
	{
	$sql="select nom_empresa from slc_empresa_pres where id_empresa =".$id; 
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_fetch_array($result);
		//echo $sql;
		if ($n) 
			   return $n[0];
		else
			   return false;
		}


function eliminar_pres($id)
{
	$sql="UPDATE slc_empresa_pres SET sta_empresa='I' WHERE id_empresa ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function restaurar_pres($id)
{
	$sql="UPDATE slc_empresa_pres SET sta_empresa='A' WHERE id_empresa ='$id'";
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	   return true;
	else
	   return false;
}
	function lista_emp_pres()  
	{
	$sql="SELECT * FROM slc_empresa_pres where  sta_empresa='A' order by nom_empresa"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else		
	    return $result;
	  
	}
	function lista_emp_i_pres()  
	{
	$sql="SELECT * FROM slc_empresa_pres where  sta_empresa<>'A' order by nom_empresa"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else		
	    return $result;
	  
	}

}// fin de la clase 

?>