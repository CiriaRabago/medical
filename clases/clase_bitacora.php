<?php
/* 
CLASE BITACORA
CREADA POR: ING. GRATELLY GARZA MORILLO
FECHA DE CREACIÓN: 23/04/11
OBJETIVO: VALIDAR BITACORA
*/


/* DECLARACIÓN DE LA CLASE */
class bitacora
{
   var $pac;
   var $usu;
   var $nue;
   var $ant;
   var $pag;
   var $ope;

/* FUNCIÓN CONSTRUCTORA */  
   function bitacora($pa,$us,$nu,$an,$pg,$op)
   {
		$this->conexion=Conectarse();
		$this->pac=$pa;
		$this->usu=$us;
		$this->nue=$nu;
		$this->ant=$an;
		$this->pag=$pg;
		$this->ope=$op;
   }
	
function guardar_bitaco()
	{
		$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
		$sql="INSERT INTO slc_bitacora (slc_paciente_id_paciente, slc_usuario_id_usuario, fecha_bit, valor_bit, pagina_bit, operacion_bit) VALUES ('$this->pac', '$this->usu', '$hoy','$this->nue', '$this->pag','$this->ope')"; 
		//echo $sql;
	    $result=mysql_query($sql,$this->conexion);
			if ($result)
			   return true;
			else
			   return false;
	}
	
}// fin de la clase
?>
