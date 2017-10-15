<?php 
/* 
CLASE EMPLEADO
CREADA POR: Ing. GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 22/04/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LOS EMPLEADOS
*/

/* DECLARACIÓN DE LA CLASE */
class empleado
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
   var $car;
   var $mpp;
   var $col;
   var $fei;
   var $fef;
   var $sta;
   var $usu;
   
/* FUNCIÓN CONSTRUCTORA */  
   function empleado($ce, $no1, $no2, $ap1, $ap2, $di, $tr, $tc, $co, $fn, $ed, $se, $ca, $mp, $cl, $fi, $ff, $st, $us)
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
		$this->car=$ca;
		$this->mpp=$mp;
		$this->col=$cl;
		$this->fei=$fi;
		$this->fef=$ff;
		$this->sta=$st;
		$this->usu=$us;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_empleado()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_empleado(ced_empleado, nom1_empleado, nom2_empleado, ape1_empleado, ape2_empleado, direc_hab_emp,telf_hab_emp, tefl_cel_emp, email_empleado, fecha_nac_emp, edo_civil_emp,sexo_empleado,cargo_empleado, mpps_empleado, coleg_empleado, fecha_ini_emp, fecha_fin_emp, fecha_ing_emp,usuario_emp) VALUES
		 ('$this->ced', upper('$this->nom1'), upper('$this->nom2'), upper('$this->ape1'), upper('$this->ape2'), upper('$this->dire'), '$this->ter', '$this->tec','$this->cor', '$this->fna', '$this->edo','$this->sex', '$this->car', '$this->mpp', '$this->col', '$this->fei', '$this->fef','$hoy','$this->usu')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
	
function modf_empleado($id)
	{
	   	$sql="UPDATE slc_empleado SET nom1_empleado= upper('$this->nom1'), nom2_empleado= upper('$this->nom2'), 
		ape1_empleado= upper('$this->ape1'), ape2_empleado= upper('$this->ape2'), direc_hab_emp= upper('$this->dire'), telf_hab_emp='$this->ter', tefl_cel_emp='$this->tec', email_empleado='$this->cor', fecha_nac_emp='$this->fna', edo_civil_emp='$this->edo',	sexo_empleado='$this->sex', cargo_empleado='$this->car', mpps_empleado='$this->mpp', coleg_empleado='$this->col', fecha_ini_emp='$this->fei' WHERE ced_empleado ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar

/* FUNCIÓN PARA VISUALIZAR UN LISTADO */  		
	function ver_empleado()
	{
	   	$sql="SELECT ced_empleado, nom1_empleado, nom2_empleado, ape1_empleado, ape2_empleado, direc_hab_emp,telf_hab_emp, tefl_cel_emp, email_empleado, fecha_nac_emp, edo_civil_emp,sexo_empleado,cargo_empleado, mpps_empleado, coleg_empleado, fecha_ini_emp from slc_empleado where status_empleado='A'order by nom1_empleado";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="600" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
				<td width="50"><div align="left">Cédula</div></td>
				<td width="150"><div align="left">Nombre</div></td>
				<td width="150"><div align="left">Apellido</div></td>
				<td width="250"><div align="left">Cargo</div></td>
			  </tr>';

		   while ($row = mysql_fetch_row($result))
		   {
			$cadena=implode('/*',$row);
			$HTML.='<tr>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[0].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[3].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[12].'</td>
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
	$sql="select * from slc_empleado where ced_empleado='$this->ced'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}

function buscar_nom_emple() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_empleado where ced_empleado='$this->ced'"; 
	//echo $sql;
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return '';
			else
			   { $cadena=$row[1].' '.$row[3];
	  			return $cadena;}
	}
function buscar_emp() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_empleado where ced_empleado='$this->ced' and status_empleado='A'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else
		$cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4];
	  return $cadena;
	  
	}
		
function eliminar($id)
{   $fecha= date("Y-m-d h:i:s");
	$sql="UPDATE  slc_empleado SET status_empleado='I', fecha_fin_emp='$fecha' where ced_empleado='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}

	

/* FUNCIÓN PARA CONSULTAR LOS DATOS DE LOS BIOANALISTAS */  	
	function buscar_bioanalista()
	{
	   	$sql="SELECT DISTINCT 
		 slc_empleado.ced_empleado, slc_empleado.nom1_empleado, slc_empleado.nom2_empleado,
		 slc_empleado.ape1_empleado, slc_empleado.ape2_empleado, 
		 slc_empleado.mpps_empleado, slc_empleado.coleg_empleado
		 FROM slc_empleado
		 WHERE slc_empleado.status_empleado='A'
		 AND slc_empleado.cargo_empleado='Bioanalista'";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
   		return $result;
	} // fin de funcion buscar_bioanalista

	function datos_bioanalista($ced)
	{
	   	$sql="SELECT DISTINCT 
		 slc_empleado.ced_empleado, slc_empleado.nom1_empleado, slc_empleado.nom2_empleado,
		 slc_empleado.ape1_empleado, slc_empleado.ape2_empleado, 
		 slc_empleado.mpps_empleado, slc_empleado.coleg_empleado
		 FROM slc_empleado
		 WHERE slc_empleado.ced_empleado='$ced' 
		 and slc_empleado.status_empleado='A'";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
   		return $result;
	} // fin de funcion buscar_bioanalista


}// fin de la clase empleado


?>