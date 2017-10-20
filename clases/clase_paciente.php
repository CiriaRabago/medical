<?php  
/* 
CLASE PACIENTE
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 22/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS PACIENTES
*/

/* DECLARACIÓN DE LA CLASE */
class paciente
{
   var $ced;
   var $nom1;
   var $nom2;
   var $ape1;
   var $ape2;
   var $dire;
   var $ter;
   var $tec;
   var $cor;
   var $fna;
   var $edo;
   var $sex;
   var $usu;
  var $cod;
   var $gra;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function paciente($ce, $no1, $no2, $ap1, $ap2, $di, $tr, $tc, $co, $fn, $ed, $se, $us, $cd, $gr)
   {
		$this->conexion=Conectarse();
		$this->ced=$ce;
   		$this->nom1=$no1;
	    $this->nom2=$no2;
		$this->ape1=$ap1;
		$this->ape2=$ap2;
		$this->dire=$di;   		
		$this->ter=$tr;
   		$this->tec=$tc;
   		$this->cor=$co;
		$this->fna=$fn;
   		$this->edo=$ed;   		
		$this->sex=$se;
		$this->usu=$us;
		$this->cod=$cd;
		$this->gra=$gr;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_paciente()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_paciente (id_paciente, ced_paciente, nom1_paciente, nom2_paciente, ape1_paciente, ape2_paciente, direc_hab_pac, telf_hab_pac, tefl_cel_pac, email_paciente, fecha_nac_pac, edo_civil_pac,sexo_paciente,fecha_ing_pac,usuario, grado_inst_pac) VALUES ('$this->ced','$this->ced', upper('$this->nom1'), upper('$this->nom2'), upper('$this->ape1'), upper('$this->ape2'), upper('$this->dire'), '$this->ter','$this->tec','$this->cor', '$this->fna', '$this->edo','$this->sex','$hoy','$this->usu','$this->gra')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
	
function modf_paciente()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="UPDATE slc_paciente SET ced_paciente='$this->ced', nom1_paciente= upper('$this->nom1'), nom2_paciente= upper('$this->nom2'), ape1_paciente= upper('$this->ape1'), ape2_paciente= upper('$this->ape2'), direc_hab_pac= upper('$this->dire'), telf_hab_pac='$this->ter', tefl_cel_pac='$this->tec', email_paciente='$this->cor', fecha_nac_pac='$this->fna', edo_civil_pac='$this->edo',	sexo_paciente='$this->sex',fecha_ing_pac='$hoy',usuario='$this->usu', grado_inst_pac='$this->gra' WHERE id_paciente ='$this->cod'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_paciente()
	{
	   	$sql="SELECT id_paciente, ced_paciente, nom1_paciente, nom2_paciente, ape1_paciente, ape2_paciente, direc_hab_pac, 
		telf_hab_pac, tefl_cel_pac, email_paciente, fecha_nac_pac, edo_civil_pac,sexo_paciente, slc_empresa_id_empresa, cargo_pac, fecha_ing_trab, grado_inst_pac from slc_paciente, slc_paciente_empresa where id_paciente=slc_empleado_id_paciente and sta_paciente='A'order by nom1_paciente";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
		   $HTML.='<table width="450" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="150"><div align="left">Nombre</div></td>
				<td width="150"><div align="left">Apellido</div></td>
				<td width="150"><div align="left">Cédula</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[4].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
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
	$sql="SELECT distinct id_paciente, ced_paciente, nom1_paciente, nom2_paciente, ape1_paciente, ape2_paciente, direc_hab_pac, telf_hab_pac, tefl_cel_pac, email_paciente, fecha_nac_pac, edo_civil_pac, sexo_paciente, slc_empresa_id_empresa, cargo_pac, fecha_ing_trab, grado_inst_pac, IF(slc_empresa_id_empresa='0', 'PARTICULAR', nom_empresa)
FROM slc_paciente, slc_paciente_empresa, slc_empresa WHERE id_paciente = slc_empleado_id_paciente AND sta_paciente = 'A'
AND ced_paciente = '$this->ced' and (slc_empresa_id_empresa=id_empresa OR slc_empresa_id_empresa='0') group by id_paciente"; 
  //echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   {  $cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[6].'**'.$row[7].'**'.$row[8].'**'.$row[9].'**'.$row[10].'**'.$row[11].'**'.$row[12].'**'.$row[13].'**'.$row[14].'**'.$row[15].'**'.$row[16].'**'.$row[17];
			   return $cadena;}
	}
	
function eliminar($id)
{
	$sql="UPDATE  slc_paciente SET sta_paciente='I' where id_paciente='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
	
function datos_pac_vis($pa)
{
	$sql="SELECT id_paciente, ced_paciente, 
		    concat(nom1_paciente,' ',nom2_paciente,' ',ape1_paciente,' ',ape2_paciente), 
			sexo_paciente,  slc_visita.id_empresa, cargo_pac, fecha_ing_trab, grado_inst_pac, 
		    IF(slc_empresa_id_empresa='0', 'PARTICULAR', nom_empresa), 
			CASE WHEN (MONTH( fecha_nac_pac ) < MONTH( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			WHEN (MONTH( fecha_nac_pac ) = MONTH( current_date )) AND (DAY( fecha_nac_pac ) <= DAY( current_date ))
				THEN YEAR( current_date ) - YEAR( fecha_nac_pac ) 
			ELSE (YEAR( current_date ) - YEAR( fecha_nac_pac )) -1
			END AS edad, 
			ced_especialista, ced_rif_medico, nomb_medico,
			IF(sexo_paciente='F', 'Femenino', 'Masculino')
			FROM slc_visita, slc_paciente, slc_detalle_visita, slc_medico, slc_paciente_empresa, slc_empresa
			WHERE id_paciente = slc_visita.slc_paciente_id_paciente
			AND id_paciente=$pa
			and (slc_visita.id_empresa=slc_empresa.id_empresa OR slc_visita.id_empresa='0')
			AND ced_especialista = id_medico";
	// echo $sql;
	 $result=mysql_query($sql,$this->conexion);

	 $n=mysql_num_rows($result);
	 if($n==0)
		return 'false';
	else
	{  //$cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[6].'**'.$row[7].'**'.$row[8].'**'.$row[9].'**'.$row[10].'**'.$row[11].'**'.$row[12].'**'.$row[13];
	   return $result;
	}
}
	
	
}// fin de la clase 

?>
