<?php 
class firma
{
   var $ido;
   var $fec;
   var $idm;
   var $nom;
   var $sta;
   
   function firma($a,$b,$c,$d,$e)
   {
		$this->conexion=Conectarse();
		$this->ido=$a;
   		$this->fec=$b;
   		$this->idm=$c;
		$this->nom=$d;
   		$this->sta=$e;
	}
	
   function consultar()
   {
     $sql="select * from slc_examen_firmado where slc_orden_id_orden=$this->ido and firma='N' ";
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return false;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  $cadena=$row[0].'/*'.$row[1].'/*'.$row[2].'/*'.$row[3].'/*'.$row[4].'/*'.$row[5];
		  return $cadena;
		}
	   }
   } 	
   
  function chequea_firma_medico($m)
   {
     $sql="select id_medico,nomb_foto from slc_medico where ced_rif_medico=".$m." and nomb_foto<>''";
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return false;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  $cadena=$row[0]."**".$row[1];
		  return $cadena;
		}
	   }
   }   
  function firma_resultado($o,$e,$m,$n) 
  {
    $zone=(3600*-4.5); 
    $hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	$sql="update slc_examen_firmado set fecha_ing='".$hoy."',firma='S', slc_medico_id_medico=".$m.", nomb_firma='".$n."', estatus='A' where slc_orden_id_orden=".$o." and slc_examen_id_examen=".$e;
	
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	  return true;
	else
	  return false;
	
  } 
  function busca_firma_medico()
   {
     $sql="select * from slc_res_firma where slc_orden_id_orden=$this->ido and status='A'  and nomb_firma<>''";
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return false;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  $cadena=$row[2]."**".$row[3];
		  return $cadena;
		}
	  }
   }
  function busca_examen($o)
   {
      $ret='';
	  $sql="select slc_examen_id_examen from slc_examen_firmado where slc_orden_id_orden=".$o;
	  $result=mysql_query($sql,$this->conexion);
	  while ($row = mysql_fetch_row($result))
		{
		  $ret.=$row[0].'-';			
		}			
		return $ret;
   }
   function chequea_examen_firmado($o,$e)
   {
     $sql="select * from slc_examen_firmado where slc_orden_id_orden=".$o." and slc_examen_id_examen=".$e;
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return false;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  if($row[3]=='N')
		    return false;
		  else
		    return true;	
		}
	  }
   
   }
 function consultar_firmados()
   {
     $sql="select * from slc_examen_firmado where slc_orden_id_orden=$this->ido and firma='S' ";
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return false;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  $cadena=$row[0].'/*'.$row[1].'/*'.$row[2].'/*'.$row[3].'/*'.$row[4].'/*'.$row[5];
		  return $cadena;
		}
	   }
   } 	
 function consultar_examen_firma($o,$e)
   {
     $sql="select * from slc_examen_firmado where slc_orden_id_orden=".$o." and slc_examen_id_examen=".$e." and firma<>'N' ";
	 $result=mysql_query($sql,$this->conexion);
     if ($result) 
	  { 
		$n=mysql_num_rows($result);
	  	if($n==0)
		{
		  return $sql;
		 }
		else
		{
		  $row = mysql_fetch_row($result);
		  $cadena=$row[0].'/*'.$row[1].'/*'.$row[2].'/*'.$row[3].'/*'.$row[4].'/*'.$row[5];
		  return $cadena;
		}
	   }
   } 	
      
}
?>