<?php
class aprobacion
{
  var $idevis;
  var $reskey;
  var $idepac;
  var $fecing;
  var $keyapr;
  var $usureg;
  var $estapr;
  function aprobacion($idevis,$reskey,$idepac,$fecing,$keyapr,$usureg,$estapr)
  {
    $this->conexion=Conectarse();
	$this->idevis=$idevis;
	$this->reskey=$reskey;
	$this->idepac=$idepac;
	$this->fecing=$fecing;
	$this->keyapr=$keyapr;
	$this->usureg=$usureg;
	$this->estapr=$estapr;
  } 
  function busca_clave()
  {
     $sql="select * from slc_aprobacion where slc_visita_id_visita=$this->idevis and estatus=0";
	 $res=mysql_query($sql,$this->conexion);
	 if($res)
	  {
	    while($r=mysql_fetch_row($res))
		 {
		   if($r[4]!='')
		     { $cad= $r[4]."-".$r[1];
		     return $cad;}
		    else
			  return "";			  	  
		 }
	  }
	  else
	    return "";
  }
  function insertar_clave()
  {
    $sql="insert into slc_aprobacion values($this->idevis,'$this->reskey',$this->idepac,'$this->fecing',$this->keyapr,$this->usureg,'0')";
	$res=mysql_query($sql,$this->conexion);
	if($res)
	 return true;
	else 
	 return false; 
  }
  function modificar_clave()
  {
   $sql="update slc_aprobacion set estatus=1 where slc_paciente_id_paciente=$this->idepac";
   $res=mysql_query($sql,$this->conexion);
   if($res)
     {
	   $sql2="insert into slc_aprobacion values($this->idepac,'$this->fecing',$this->keyapr,$this->usureg,'0')";
	   $res2=mysql_query($sql2,$this->conexion);
	   if($res2)
	    return true;
	   else
	    return false; 	
	 }
	else
	  return false; 
  }
}
?>