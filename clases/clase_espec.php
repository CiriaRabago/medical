<?php 
class especialidad
{
   var $cod;
   var $nom;
   function especialidad($c, $n)
   {
		$this->conexion=Conectarse();
		$this->cod=$c;
   		$this->nom=$n;
	}
	function combo_esp()
	{
	   	$sql="SELECT 
			id_esp, 
			nomb_esp
			from slc_especialidad
			where status_esp='A'
			order by nomb_esp";
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
	}
	function ins_especialidad()
	{
	   	$usu=$_SESSION['cedu_usu'];
		$zone=(3600*-4.5); 
		$hoy=gmdate("Y-m-d H:i ", time() + $zone);
		$sql="INSERT INTO slc_especialidad (nomb_esp,fecha_ing_esp,usuario_esp) VALUES (upper('$this->nom'),'$hoy','$usu')";
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
	} // fin de funcion  insertar especialidad

/* FUNCIÓN PARA LISTAR LAS ESPECIALIDADES CON SUS REFERENCIAS */  	
	function ver_especialidad()
	{
	   	$sql="SELECT id_esp, nomb_esp from slc_especialidad
		      where status_esp='A'
			  order by nomb_esp";
		
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr class="titulorep">
				<td width="600" colspan="3"><div align="left">Nombre</div></td>
			  </tr>';

		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
			if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
			$cont++;
			$cadena=implode('/*',$row);
			$this->cod=$row[0];
			$refes=$this->consul_ref_esp();
			$nume_refes=mysql_num_rows($refes);
			if($refes!=false && ($nume_refes>0))
			{ $dp='style="cursor:hand" onClick="ver_refe('.$row[0].')"';
			  $imag='<img src="imagenes/vineta.gif" width="16" height="8" /> ';
			 }	else 
			 { $dp='';
			   $imag='&nbsp; ';
			 }
			$HTML.='<tr '.$color.'>
				<td '.$dp.'class="texto" align="left">'.$imag.$row[1].'</td>
				<td class="texto"><div align="center" style="display:block"><img src="imagenes/edit.gif" style="cursor:hand" alt="Modificar Especialidad" title="Modificar Especialidad" onclick="modifes('.$row[0].','."'".$row[1]."'".');" /></div></td>
				<td class="texto"><div align="center" style="display:none"><img src="imagenes/delete.gif" style="cursor:hand" alt="Eliminar Especialidad" title="Eliminar Especialidad" onclick="elim('.$row[0].');" /></div></td>
				</tr>
				<tr '.$color.'>
				<td colspan="3"><div id="refea'.$row[0].'" align="center" style="display:none">';
				if($refes!=false && ($nume_refes>0))
				{  
					$HTML.='<table width="500" border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:#F9D5B2; border:border-width:thin; border-style: double; border-color: #F0953D">';
					while ($row2 = mysql_fetch_row($refes))
		        	{ 
						$cadena=implode('/*',$row2);
						$HTML.='<tr class="texto"><td width="380"><div align="left">'.$row2[3].'</div></td>
								<td width="80"><div align="left">'.$row2[7].'</div></td>
								<td width="20"><div align="center" style="display:block"><img src="imagenes/edit.gif" style="cursor:hand" alt="Modificar Referencia" title="Modificar Referencia" onclick="modifref('."'".$cadena."'".','."'".$row[1]."'".');" /></div</td>
								<td width="20"><div align="center" style="display:block"><img src="imagenes/delete.gif" style="cursor:hand" alt="Eliminar Referencia" title="Eliminar Referencia" onclick="elimref('.$row2[0].','."'".$row2[3]."'".');" /></div</td>
							  </tr>'; 
					}
					$HTML.='</table>'; 
				 }
				$HTML.='</div></td></tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver especialidades

/* FUNCIÓN PARA CONSULTAR LAS REFERENCIAS POR UNA ESPECIALIDAD */  	
	function consul_ref_esp()
	{
	   	$sql="SELECT id_referencia,
		      slc_especialidad_id_esp, 
			  ced_rif, nomb_ref, 
			  dir_empresa_ref, telf1_ref, telf2_ref,
			  precio_ref
			  from slc_referencia
			  where slc_especialidad_id_esp=$this->cod
			  and status_ref='A'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   return $result;
		}
		else
			return false;
	} // fin de funcion para consultar referencias por especialidad

/* FUNCIÓN PARA VERIFICAR SI LA ESPECIALIDAD YA EXISTE */  	
	function buscaresp() 
	{
	 $sql="select * from slc_especialidad where nomb_esp='$this->nom'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	} // Fin de funcion para ver si el registro existe 

/* FUNCIÓN PARA MODIFICAR ESPECIALIDAD */  	
	function modf_espe()
	{
	   	$sql="UPDATE slc_especialidad SET nomb_esp= upper('$this->nom')
			  WHERE id_esp='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar especiakidad

/* FUNCIÓN PARA INACTIVAR ESPECIALIDAD */  	
	function inact_espe()
	{
	   	$sql="UPDATE slc_especialidad SET status_esp= 'I'
			  WHERE id_esp='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar especiakidad
	function busca_id_esp() 
	{
	 $sql="select * from slc_especialidad where id_esp='$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			  {while ($row = mysql_fetch_row($result))		   
			   {return $row;}}
	} // Fin de funcion para ver si el registro existe 
} //Fin de la clase especialidad
?>