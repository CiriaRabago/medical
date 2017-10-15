<?php 
/* 
CLASE MENU
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 30/03/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS AL MENU
*/

/* DECLARACIÓN DE LA CLASE */
class menu_perm
{
   var $cod;
   var $niv;
   var $alias;
   var $pant;
   var $des;
   var $padre;
   var $sta;
   var $usu;
   
/* FUNCIÓN CONSTRUCTORA */  
   function menu_perm($co, $ni, $al, $pa, $de, $pad, $st, $us)
   {
		$this->conexion=Conectarse();
		$this->cod=$co;
   		$this->niv=$ni;
		$this->alias=$al;   		
		$this->pant=$pa;
   		$this->des=$de;
   		$this->padre=$pad;
		$this->sta=$st;
		$this->usu=$us;

	} //fin del constructor
	
	function ver_menu_perm($usu)
	{
		$HTML='';
	   	$sql="SELECT id_nivel,nom_nivel,orden_nivel FROM slc_nivel_menu order by orden_nivel";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			
			$HTML.='<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr height="22" class="titulorep">
				<td width="175" height="22" >OPCION</td>
				<td width="25">C</td>
				<td width="25">M</td>
				<td width="25">E</td>
				<td width="25">V</td>
				<td width="25">I</td>
			  </tr>';
			
		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
				$cont++;
				$vectniv[$cont]=$row[0];
		   }
			
			$i=0;
			$sqla="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu
				      FROM slc_menu
					  where slc_nivel_menu_id_nivel=".$vectniv[1];
			$resulta=mysql_query($sqla,$this->conexion);
		    while ($rowa = mysql_fetch_row($resulta))
		    {
				$HTML.='<tr height="22" bgcolor="#F7D49E" ><td width="175" height="22" >'.$rowa[2].'</td>';
				if($rowa[4] !='')
				{ 
				  $i++;
				  $marcaC=''; $marcaM=''; $marcaE=''; $marcaV=''; $marcaI='';
				  $sqlpu="SELECT crear_per, modif_per, elimi_per, consu_per, impri_per
				          from slc_permisologia
						  where slc_menu_id_menu=$rowa[0]
						  and slc_usuario_id_usuario=$usu";
				  $resultpu=mysql_query($sqlpu,$this->conexion);
				  $npu=mysql_num_rows($resultpu);
				  if($npu>0)
				  {
				     $rowpu = mysql_fetch_row($resultpu);
					 if($rowpu[0]==1) $marcaC='checked';
					 if($rowpu[1]==1) $marcaM='checked';
					 if($rowpu[2]==1) $marcaE='checked';
					 if($rowpu[3]==1) $marcaV='checked';
					 if($rowpu[4]==1) $marcaI='checked'; }

						  $HTML.='<td width="25"><input type="checkbox" name="'.$i.'**C"  id="'.$i.'**C" value="checkbox"  '.$marcaC.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**M"  id="'.$i.'**M" value="checkbox"  '.$marcaM.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**E"  id="'.$i.'**E" value="checkbox"  '.$marcaE.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**V"  id="'.$i.'**V" value="checkbox"  '.$marcaV.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**I"  id="'.$i.'**I" value="checkbox"  '.$marcaI.' >
						  						 <input type="hidden"   name="o'.$i.'" id="o'.$i.'" value="'.$rowa[0].'"></td>';
				}
				else
				  $HTML.='<td width="125" colspan="5"></td>';
				$HTML.='</tr>';
				$sqlb="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu
				      FROM slc_menu
					  where slc_nivel_menu_id_nivel=".$vectniv[2]."
					  and id_padre=".$rowa[0];
				$resultb=mysql_query($sqlb,$this->conexion);
				while ($rowb = mysql_fetch_row($resultb))
				{
					$HTML.='<tr height="22" bgcolor="#FDEACE" ><td width="175" height="22" >&nbsp;&nbsp;'.$rowb[2].'</td>';
					if($rowb[4] !='')
					{
						  $i++;
						  $marcaC=''; $marcaM=''; $marcaE=''; $marcaV=''; $marcaI='';
						  $sqlpu="SELECT crear_per, modif_per, elimi_per, consu_per, impri_per
								  from slc_permisologia
								  where slc_menu_id_menu=$rowb[0]
								  and slc_usuario_id_usuario=$usu";
						  $resultpu=mysql_query($sqlpu,$this->conexion);
						  $npu=mysql_num_rows($resultpu);
						  if($npu>0)
						  {
							 $rowpu = mysql_fetch_row($resultpu);
							 if($rowpu[0]==1) $marcaC='checked';
							 if($rowpu[1]==1) $marcaM='checked';
							 if($rowpu[2]==1) $marcaE='checked';
							 if($rowpu[3]==1) $marcaV='checked';
							 if($rowpu[4]==1) $marcaI='checked'; }
		
						  $HTML.='<td width="25"><input type="checkbox" name="'.$i.'**C"  id="'.$i.'**C" value="checkbox"  '.$marcaC.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**M"  id="'.$i.'**M" value="checkbox"  '.$marcaM.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**E"  id="'.$i.'**E" value="checkbox"  '.$marcaE.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**V"  id="'.$i.'**V" value="checkbox"  '.$marcaV.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**I"  id="'.$i.'**I" value="checkbox"  '.$marcaI.' >
						  						 <input type="hidden"   name="o'.$i.'" id="o'.$i.'" value="'.$rowb[0].'"></td>';
					}
					else
					  $HTML.='<td width="125" colspan="5"></td>';
					$HTML.='</tr>';
					$sqlc="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu
				      FROM slc_menu
					  where slc_nivel_menu_id_nivel=".$vectniv[3]."
					  and id_padre=".$rowb[0];
					$resultc=mysql_query($sqlc,$this->conexion);
					while ($rowc = mysql_fetch_row($resultc))
					{
						$HTML.='<tr height="22" bgcolor="#FFF4E1"><td width="175" height="22">&nbsp;&nbsp;&nbsp;&nbsp;'.$rowc[2].'</td>';
						if($rowc[4] !='')
						{
							  $i++;
							  $marcaC=''; $marcaM=''; $marcaE=''; $marcaV=''; $marcaI='';
							  $sqlpu="SELECT crear_per, modif_per, elimi_per, consu_per, impri_per
									  from slc_permisologia
									  where slc_menu_id_menu=$rowc[0]
									  and slc_usuario_id_usuario=$usu";
							  $resultpu=mysql_query($sqlpu,$this->conexion);
							  $npu=mysql_num_rows($resultpu);
							  if($npu>0)
							  {
								 $rowpu = mysql_fetch_row($resultpu);
								 if($rowpu[0]==1) $marcaC='checked';
								 if($rowpu[1]==1) $marcaM='checked';
								 if($rowpu[2]==1) $marcaE='checked';
								 if($rowpu[3]==1) $marcaV='checked';
								 if($rowpu[4]==1) $marcaI='checked'; }
			
						  $HTML.='<td width="25"><input type="checkbox" name="'.$i.'**C"  id="'.$i.'**C" value="checkbox"  '.$marcaC.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**M"  id="'.$i.'**M" value="checkbox"  '.$marcaM.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**E"  id="'.$i.'**E" value="checkbox"  '.$marcaE.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**V"  id="'.$i.'**V" value="checkbox"  '.$marcaV.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**I"  id="'.$i.'**I" value="checkbox"  '.$marcaI.' >
						  						 <input type="hidden"   name="o'.$i.'" id="o'.$i.'" value="'.$rowc[0].'"></td>';
						}
						else
						  $HTML.='<td width="125" colspan="5"></td>';
					    $HTML.='</tr>';
						$sqld="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu
						  FROM slc_menu
						  where slc_nivel_menu_id_nivel=".$vectniv[4]."
						  and id_padre=".$rowc[0];
						$resultd=mysql_query($sqld,$this->conexion);
						while ($rowd = mysql_fetch_row($resultd))
						{
							$HTML.='<tr height="22"><td width="175" height="22" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowd[2].'</td>';
							if($rowd[4] !='')
							{
								  $i++;
								  $marcaC=''; $marcaM=''; $marcaE=''; $marcaV=''; $marcaI='';
								  $sqlpu="SELECT crear_per, modif_per, elimi_per, consu_per, impri_per
										  from slc_permisologia
										  where slc_menu_id_menu=$rowd[0]
										  and slc_usuario_id_usuario=$usu";
								  $resultpu=mysql_query($sqlpu,$this->conexion);
								  $npu=mysql_num_rows($resultpu);
								  if($npu>0)
								  {
									 $rowpu = mysql_fetch_row($resultpu);
									 if($rowpu[0]==1) $marcaC='checked';
									 if($rowpu[1]==1) $marcaM='checked';
									 if($rowpu[2]==1) $marcaE='checked';
									 if($rowpu[3]==1) $marcaV='checked';
									 if($rowpu[4]==1) $marcaI='checked'; }
				
						  $HTML.='<td width="25"><input type="checkbox" name="'.$i.'**C"  id="'.$i.'**C" value="checkbox"  '.$marcaC.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**M"  id="'.$i.'**M" value="checkbox"  '.$marcaM.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**E"  id="'.$i.'**E" value="checkbox"  '.$marcaE.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**V"  id="'.$i.'**V" value="checkbox"  '.$marcaV.' ></td>
								  <td width="25"><input type="checkbox" name="'.$i.'**I"  id="'.$i.'**I" value="checkbox"  '.$marcaI.' >
						  						 <input type="hidden"   name="o'.$i.'" id="o'.$i.'" value="'.$rowd[0].'"></td>';
							}
							else
							  $HTML.='<td width="125" colspan="5"></td>';
							$HTML.='</tr>';
						}
					}
				}
		    } 
			
			$HTML.='</table><input name="ftot" id="ftot" type="hidden" value="'.$i.'" />';
			return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 2

}// fin de la clase 



/* DECLARACIÓN DE LA CLASE */
class permisologia
{
   var $cod;
   var $men;
   var $usu;
   var $cre;
   var $mod;
   var $eli;
   var $con;
   var $imp;
   
/* FUNCIÓN CONSTRUCTORA */  
   function permisologia($co, $me, $u, $c, $m, $e, $v, $i)
   {
		$this->conexion=Conectarse();
		$this->cod=$co;
   		$this->men=$me;
		$this->usu=$u;   		
		$this->cre=$c;
   		$this->mod=$m;
   		$this->eli=$e;
		$this->con=$v;
		$this->imp=$i;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  
function eli_permisos()
{
		$sqle="delete from slc_permisologia
		       where slc_usuario_id_usuario=$this->usu";	
			   //echo   $sqle
		$resulte=mysql_query($sqle,$this->conexion);
		if($resulte)
			return true;
		else
			return false;
}

	
	function ins_permiso()
	{   //$fecha= date("Y-m-d h:i:s");
		$sql="INSERT INTO slc_permisologia(slc_menu_id_menu, slc_usuario_id_usuario, 
			  crear_per, modif_per, elimi_per, consu_per, impri_per)
			  VALUES ($this->men, $this->usu, $this->cre, $this->mod, $this->eli, $this->con, $this->imp)";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		   return true;
		else
		   return false;
	} // fin de funcion  insertar 

function buscar_permisos()
	{
	$sql="select crear_per, consu_per, modif_per, elimi_per, impri_per from slc_permisologia where slc_menu_id_menu='$this->men' and slc_usuario_id_usuario='$this->usu'";
	 $result=mysql_query($sql,$this->conexion);
     $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	   	if($n==0)
		{
		  $cadena='FALSE';
		 }
		 else
		 {
		    $cadena=$row[0].'**'.$row[1].'**'.$row[2].'**'.$row[3].'**'.$row[4];
		 }
		 return $cadena;
	}


}// fin de la clase permisologia



?>