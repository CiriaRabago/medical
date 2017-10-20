<?php  
/* 
CLASE EMPRESA
CREADA POR: MONICA BATISTA
FECHA DE CREACIÓN: 25/06/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS MEDICO
*/

/* DECLARACIÓN DE LA CLASE */

 

class medico
{
   var $cod;
   var $rif;
   var $nom;
   var $sex;
   var $dire;
   var $te1;
   var $te2;
   var $email;
   var $por;
   var $mpp;
   var $col;
   var $fir;
   var $hue;
   var $sta;
   var $usu;
   var $pic;

/* FUNCIÓN CONSTRUCTORA */  
   function medico($cd, $ri, $no, $sx, $di, $t1, $t2, $em, $po, $mp, $co, $f, $h, $st, $us, $pi)
   {
		$this->conexion=Conectarse();
		$this->cod=$cd;
		$this->rif=$ri;
   		$this->nom=$no;
		$this->sex=$sx;
		$this->dire=$di;   		
   		$this->te1=$t1;
   		$this->te2=$t2;
		$this->email=$em;
		$this->por=$po;
		$this->mpp=$mp;
		$this->col=$co;
		$this->fir=$f;
		$this->hue=$h;
		$this->sta=$st;
		$this->usu=$us;
		$this->pic=$pi;
	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_medico($es)
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_medico (ced_rif_medico, nomb_medico, sexo_medico, dir_medico,
		 telf1_medico,telf2_medico, email_medico, porc_medico, mpps_medico,coleg_medico,
		 firma_medico,huella_medico, status_medico,fecha_ing_med,usuario_med, id_esp) VALUES
		 ('$this->rif', upper('$this->nom'), upper('$this->sex'), upper('$this->dire'), 
		 '$this->te1', '$this->te2', '$this->email','$this->por','$this->mpp','$this->col',
		 '$this->fir','$this->hue','$this->sta','$hoy','$this->usu','$es')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 

function modf_medico($es)
	{
	   	$sql="UPDATE slc_medico SET ced_rif_medico='$this->rif', nomb_medico=upper('$this->nom'),
		 sexo_medico=upper('$this->sex'), dir_medico=upper('$this->dire'),
		 telf1_medico='$this->te1',telf2_medico='$this->te2', email_medico='$this->email', 
		 porc_medico='$this->por', mpps_medico='$this->mpp',coleg_medico='$this->col', id_esp='$es', nomb_foto='$this->pic'
		 WHERE id_medico =$this->cod";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_medico()
	{
	   	$sql="SELECT * from slc_medico where status_medico='A' order by nomb_medico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="50"><div align="center">#</div></td>
				<td width="100"><div align="left">Rif/Cedula</div></td>
				<td width="300"><div align="left">Nombre</div></td>
				<td width="100"><div align="left">Telefono 1</div></td>
				<td width="100"><div align="left">Telefono 2</div></td>
			  </tr>';
           $xx=0;
		   while ($row = mysql_fetch_row($result))
		   {$xx++;
			$cadena=implode('/*',$row);
			$HTML.='<tr onClick="ver_modif('."'".$cadena."'".')">
			    <td style="cursor:hand" class="texto" align="left"><strong>'.$xx.'</strong></td> 
				<td style="cursor:hand" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" class="texto">'.$row[2].'</td>
				<td style="cursor:hand" class="texto">'.$row[5].'</td>
				<td style="cursor:hand" class="texto">'.$row[6].'</td>
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
	$sql="select * from slc_medico where ced_rif_medico='$this->rif'
		  and nomb_medico=upper('$this->nom') "; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}


function eliminar($id)
	{
		$sql="UPDATE slc_medico SET status_medico='I' WHERE id_medico=$id";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
	}

	function combo_medico($c)
	{
	   	$sql="SELECT ced_rif_medico, nomb_medico from slc_medico where status_medico='A' order by nomb_medico";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    if($c=='0')$sel=''; else if($row[0]==$c) $sel=' selected ';else $sel="";
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
		//echo $sql;   
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
		    if($row[0]==$idm)
			  $sel='selected';
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
	  
	}
function lista_med()  
	{
	$sql="SELECT * FROM slc_medico,slc_especialidad where slc_medico.id_esp=slc_especialidad.id_esp and status_medico='A' order by slc_especialidad.id_esp,nomb_medico"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else		
	    return $result;
	  
	}
function buscar_med_id()  
	{
	$sql="select * from slc_medico where id_medico='$this->cod' and status_medico='A'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		$cadena=$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[16].'**'.$row[17].'** ** ** ';
	  return $cadena;
	  
	}
	
}// fin de la clase 

?>