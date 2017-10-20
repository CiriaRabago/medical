<?php  
/* 
CLASE NIVELES
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 02/09/2010
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS PERFILES DE EXAMENTES
*/

/* DECLARACIÓN DE LA CLASE */
class nivel
{
   var $cod;
   var $nom;
   var $imaa;
   var $imap;
   var $orden;
   var $col;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function nivel($c, $n, $ia, $ip, $o, $co)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
   		$this->imaa=$ia;
		$this->imap=$ip;
		$this->col=$co;
		$this->orden=$o;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR UN PERFIL */  	
	function ins_nivel()
	{
	   	
		$sql="INSERT INTO slc_nivel_menu (nom_nivel,imagen_a,imagen_p,orden_nivel,color_nivel) 
		      VALUES (upper('$this->nom'),'$this->imaa','$this->imap',$this->orden,'$this->col')";
			  //echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		{	
			   $sql2="Select last_insert_id() from dual";
			   //echo $sql2;
			   $result2=mysql_query($sql2,$this->conexion);
			   if($result2)
			   {
			   		$row2 = mysql_fetch_row($result2);
			   		return $row2[0];
			   }
			   else
			   {
			   		return false;
			   }
		}
		else
			   return false;
	} // fin de funcion  insertar perfiles

function modf_nivel()
	{
		$sql="UPDATE slc_nivel_menu SET nom_nivel= upper('$this->nom'), 
		imagen_a='$this->imaa', imagen_p='$this->imap', orden_nivel=$this->orden, color_nivel='$this->col'
		WHERE id_nivel ='$this->cod'";
		//echo $sql; 
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar perfiles

/* FUNCIÓN PARA VISUALIZAR UN LISTADO DE PERFILES EXISTENTES */  		
	function ver_nivel()
	{
		
		$sql="SELECT id_nivel, nom_nivel, imagen_a, imagen_p, orden_nivel, color_nivel
		      from slc_nivel_menu order by orden_nivel";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="172" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#a8a9ad" align="center">
			  <tr>
				<td class="titulorep" width="152" height="20" >Niveles</td>
				<td class="titulorep" width="20" height="20" >&nbsp;</td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$imagen='';
			if($row[2]!='' && $row[3]!='')
				$imagen=' background="imagenes/'.$row[3].'" onmouseover="this.background='."'imagenes/".$row[2]."'".'"  onmouseout="this.background='."'imagenes/".$row[3]."'".'"';
			$color='';
			if($row[5]!='')
				$color=' bgcolor="'.$row[5].'" onMouseOver="this.bgColor = '."'".'#F0F0F0'."'".'" onMouseOut ="this.bgColor ='."'".$row[5]."'".'"';
			$HTML.='<tr width="152" height="20">
				<td width="152" height="20" '.$color.$imagen.' class="textoN" align="left"><div align="center">'.$row[1].'</div></td>
				<td width="20" height="20"><img src="imagenes/edit.gif" style="cursor:hand" alt="Modificar Nivel" title="Modificar Nivel" onclick="ver_modif('."'".$cadena."'".');" /></td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver perfiles


/* FUNCIÓN PARA CAMBIAR LA IMAGEN DEL NIVEL */  	
	function cambiar_imagen($c)
	{
	    $campo='imagen_'.$c;
		if($c=='a')
			$ig=$this->imaa;
		if($c=='p')
			$ig=$this->imap;
	
	   	$sql="UPDATE slc_nivel_menu SET ".$campo." = '$ig' 
		WHERE id_nivel ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}


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

}// fin de la clase 

?>