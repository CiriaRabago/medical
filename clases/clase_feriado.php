<?php  
class feriado
{
   var $idf;
   var $dia;
   var $mes;
   var $des;
/* FUNCIÓN CONSTRUCTORA */  
   function feriado($a, $b, $c, $d)
   {
		$this->conexion=Conectarse();
		$this->idf=$a;
		$this->dia=$b;
   		$this->mes=$c;
		$this->des=$d;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_feriado()
	{
	    $sql="INSERT INTO slc_feriado  VALUES ('', '$this->dia', '$this->mes', upper('$this->des'))";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 

function mod_feriado()
	{
	   	$sql="UPDATE slc_feriado SET desc_feriado=upper('$this->des')
		 WHERE dia_feriado ='$this->dia' and mes_feriado ='$this->mes'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_feriados()
	{
	   	$sql="SELECT * from slc_feriado  order by mes_feriado,dia_feriado";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="100"><div align="left">FECHA</div></td>
				<td width="300"><div align="left">MOTIVO</div></td>				
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr onClick="ver_modif('."'".$cadena."'".')">
				<td style="cursor:hand" class="texto" align="left">'.$row[1].'/'.$row[2].'/....</td>
				<td style="cursor:hand" class="texto">'.$row[3].'</td>				
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 



function buscar() //funcion para ver si el registro existe 
	{
	 $sql="select * from slc_feriado where dia_feriado='$this->dia'
		  and mes_feriado='$this->mes' "; 
	 //echo $sql;	  
	 $result=mysql_query($sql,$this->conexion);
	 while ($row = mysql_fetch_row($result))
	   if($row[3]!='')   		   
		 return $row[3];
	   else
		 return 'false';
	}


function eliminar()
	{
		$sql="DELETE FROM slc_feriado WHERE dia_feriado='$this->dia' and mes_feriado='$this->mes'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
	}
/*
	function combo_medico()
	{
	   	$sql="SELECT ced_rif_medico, nomb_medico from slc_medico where status_medico='A' order by nomb_medico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    $sel='';
			$HTML.='<option value="'.$row[0].'" '.$sel.'>'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	}
  function combo_medico_new($ide,$idm)
	{
	    if($ide=='0')		
	   	   $sql="SELECT ced_rif_medico, nomb_medico from slc_medico where status_medico='A' order by nomb_medico";
		else
		   $sql="SELECT ced_rif_medico, nomb_medico from slc_medico where status_medico='A' and id_esp= ".$ide." order by nomb_medico";  
		echo $sql;   
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    if($row[0]==$idm)
			  $sel="selected";
			else
		      $sel='';
			$HTML.='<option value="'.$row[0].'" '.$sel.' >'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} 	
function buscar_med()  
	{
	$sql="select * from slc_medico where ced_rif_medico='$this->rif' and status_medico='A'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		$cadena=$row[1].'**'.$row[2].'** ** ** ';
	  return $cadena;
	  
	}*/
}// fin de la clase 
?>
