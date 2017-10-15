<?php 
/* 
CLASE MENU
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 30/03/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS AL MENU
*/

/* DECLARACIÓN DE LA CLASE */
class menu
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
   function menu($co, $ni, $al, $pa, $de, $pad, $st, $us)
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
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_menu()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_menu(slc_nivel_menu_id_nivel, alias_menu, pantalla_menu,
		 desc_menu, id_padre, usuario_menu,fecha_ing,status_menu) VALUES
		 ('$this->niv', upper('$this->alias'), '$this->pant', upper('$this->des'), '$this->padre', '$this->usu','$hoy','$this->sta')";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
function modf_menu()
	{
	   	$sql="UPDATE slc_menu SET slc_nivel_menu_id_nivel=$this->niv, alias_menu=upper('$this->alias'), pantalla_menu='$this->pant',
		 desc_menu='$this->des', id_padre=$this->padre
		 WHERE id_menu=$this->cod";
		//echo $sql;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  modificar


	function ver_menu2()
	{
	
	   	$sql="SELECT id_nivel,nom_nivel,orden_nivel FROM slc_nivel_menu order by orden_nivel";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_num_rows($result);
		$ancho=700/$n;
		if ($result) 
		{ 
		   $HTML.='<table width="700" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr class="titulorep">';	
		   $cont=0;
		   while ($row = mysql_fetch_row($result))
		   {
				$cont++;
				$vectniv[$cont]=$row[0];
				$cadena=implode('/*',$row);
				$HTML.='<td width='.$ancho.'class="texto" align="left">'.$row[1].'</td>';
		   }
		    $HTML.='</tr>';
			
			$sqla="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu
				      FROM slc_menu
					  where status_menu='A' and slc_nivel_menu_id_nivel=".$vectniv[1];
			$resulta=mysql_query($sqla,$this->conexion);
		    while ($rowa = mysql_fetch_row($resulta))
		    {
				$cadenaa=implode('/*',$rowa);
				$HTML.='<tr bgcolor="#F7D49E"><td width="700" class="texto" align="left" colspan="'.$n.'" style="cursor:hand"  
				         onclick="ver_modif('."'".$cadenaa."'".');">'.$rowa[2].'</td></tr>';
				$sqlb="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu
				      FROM slc_menu
					  where status_menu='A' and slc_nivel_menu_id_nivel=".$vectniv[2]."
					  and id_padre=".$rowa[0];
				$resultb=mysql_query($sqlb,$this->conexion);
				while ($rowb = mysql_fetch_row($resultb))
				{
					$cadenab=implode('/*',$rowb);
					$HTML.='<tr bgcolor="#FDEACE"><td  class="texto" align="left" colspan="1">&nbsp;</td>
								<td  class="texto" align="left" colspan="'.($n-1).'" style="cursor:hand"  
								onclick="ver_modif('."'".$cadenab."'".');">'.$rowb[2].'</td></tr>';
					$sqlc="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu
				      FROM slc_menu
					  where status_menu='A' and slc_nivel_menu_id_nivel=".$vectniv[3]."
					  and id_padre=".$rowb[0];
					$resultc=mysql_query($sqlc,$this->conexion);
					while ($rowc = mysql_fetch_row($resultc))
					{
						$cadenac=implode('/*',$rowc);
						$HTML.='<tr bgcolor="#FFF4E1"><td class="texto" align="left" colspan="2">&nbsp;</td>
									<td class="texto" align="left" colspan="'.($n-2).'" style="cursor:hand"  
									onclick="ver_modif('."'".$cadenac."'".');">'.$rowc[2].'</td></tr>';
					    $sqld="SELECT  id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu
						  FROM slc_menu
						  where status_menu='A' and slc_nivel_menu_id_nivel=".$vectniv[4]."
						  and id_padre=".$rowc[0];
						$resultd=mysql_query($sqld,$this->conexion);
						while ($rowd = mysql_fetch_row($resultd))
						{
							$cadenad=implode('/*',$rowd);
							$HTML.='<tr><td class="texto" align="left" colspan="3">&nbsp;</td>
										<td class="texto" align="left" colspan="'.($n-3).'" style="cursor:hand"
										onclick="ver_modif('."'".$cadenad."'".');">'.$rowd[2].'</td></tr>';
						}
					}
				}
		    } 
			return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 2



/* FUNCIÓN PARA LLENAR COMBO DE NIVELES DEL MENU */  		
	function combo_niv()
	{  $sql="SELECT id_nivel, nom_nivel from slc_nivel_menu order by id_nivel";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE menus 
function combo_men($p)
	{
	$sql="SELECT id_menu, alias_menu from slc_menu where slc_nivel_menu_id_nivel='$p' order by id_menu";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{
		   $HTML='';
		   while ($row = mysql_fetch_row($result))
		   {
			$HTML.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion COMBO DE menus 
function buscar() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_menu where id_padre='$this->padre' and alias_menu='$this->alias' and id_menu<>'$this->cod'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}


function eliminar($id)
{
	$sql="UPDATE slc_menu SET status_menu='I' WHERE id_menu ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}

	function pinta_menu()
	{
		$sqlver="select count(*) from slc_permisologia where slc_usuario_id_usuario='$this->usu'";
		$resultver=mysql_query($sqlver,$this->conexion);
		$nver=mysql_fetch_row($resultver);
		if($nver[0]>0)
		{
			$sql="SELECT id_nivel,nom_nivel,orden_nivel FROM slc_nivel_menu order by orden_nivel";
			//echo $sql;
			$result=mysql_query($sql,$this->conexion);
			$n=mysql_num_rows($result);
			if ($result) 
			{ 
			   $HTML='<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#a8a9ad" 
						align="center" class="textoN">';
			   $cont=0;
			   while ($row = mysql_fetch_row($result))
			   {
					$cont++;
					$vectniv[$cont]=$row[0];
			   }
				$supercont=0;
				$contamenu=0;
				$sqla="SELECT id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu, 
						imagen_a, imagen_p, color_nivel, (select count(slc_menu_id_menu) from slc_permisologia
														  where slc_menu_id_menu=id_menu
														  and slc_usuario_id_usuario=$this->usu)
						FROM slc_menu, slc_nivel_menu
						where status_menu='A' 
						and slc_nivel_menu_id_nivel=".$vectniv[1]."
						and slc_nivel_menu_id_nivel=id_nivel
						order by alias_menu";
					
				$resulta=mysql_query($sqla,$this->conexion);
				$HTMLauxA = array();
				while ($rowa = mysql_fetch_row($resulta))
				{
					$abrioa=0;
					$contamenu++;
					$HTMLa='';
					$supercont++;
					$HTMLaux='';
					$cadenaa=implode('/*',$rowa);
					$muestraa=0;
					
					$imagena='';
					if($rowa[7]!='' && $rowa[8]!='')
				      $imagena=' background-color:red';
					
					//	$imagena=' background="imagenes/'.$rowa[8].'" 
					// 			  onmouseover="this.background='."'imagenes/".$rowa[7]."'".'"  
					// 			  onmouseout="this.background='."'imagenes/".$rowa[8]."'".'"';
					$colora='';
					if($rowa[9]!='')
						$colora=' bgcolor="'.$rowa[9].'" onMouseOver="this.bgColor = '."'".'#F0F0F0'."'".'" 
								onMouseOut ="this.bgColor ='."'".$rowa[9]."'".'"';
					
					
					$sqlb="SELECT id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu, 
							imagen_a, imagen_p, color_nivel, (select count(slc_menu_id_menu) from slc_permisologia
														  where slc_menu_id_menu=id_menu
														  and slc_usuario_id_usuario=$this->usu)
							FROM slc_menu, slc_nivel_menu
							where status_menu='A' 
							and slc_nivel_menu_id_nivel=".$vectniv[2]."
							and slc_nivel_menu_id_nivel=id_nivel
							and id_padre=".$rowa[0]." order by alias_menu";
					
					$resultb=mysql_query($sqlb,$this->conexion);
					$nb=mysql_num_rows($resultb);
	
					$pagia='';
					if($rowa[4]!='')
						$pagia=' onclick="top.mainFrame.location.href='."'".$rowa[4]."'".'" ';
					else
					{
					   if($nb>0)
						$pagia=' onclick="mostrar('.$contamenu.','.$rowa[1].');" ';
					}
					
					$HTMLa.='<td width="200"  height="28" class="texto option-menu" align="center" 
									style="cursor:hand" '.$colora.$imagena.$pagia.'>'.strtoupper(ucwords(strtolower($rowa[2]))).
									'</td>';
					
					if($nb>0)
					{
					  $HTMLa.='<tr><td width="100%" class="texto option-submenu" border="0" align="center" cellpadding="0" cellspacing="0"><table id="tabla'.$contamenu.'**'.$rowa[1].'" style="display:none"  cellpadding="0" cellspacing="1" width="100%" >';
					}
					
					$HTMLauxB = array();
					while ($rowb = mysql_fetch_row($resultb))
					{
						$contamenu++;
						$HTMLb='';
						$cadenab=implode('/*',$rowb);
						$muestrab=0;
						$imagenb='';
						// if($rowb[7]!='' && $rowb[8]!='')
						// 	$imagenb=' background="imagenes/'.$rowb[8].'" 
						// 			  onmouseover="this.background='."'imagenes/".$rowb[7]."'".'"  
						// 			  onmouseout="this.background='."'imagenes/".$rowb[8]."'".'"';
						$colorb='';
						if($rowb[9]!='')
							$colorb=' bgcolor="'.$rowb[9].'" onMouseOver="this.bgColor = '."'".'#F0F0F0'."'".'" 
									onMouseOut ="this.bgColor ='."'".$rowb[9]."'".'"';
						
						$sqlc="SELECT id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu, 
								imagen_a, imagen_p, color_nivel, (select count(slc_menu_id_menu) from slc_permisologia
															  where slc_menu_id_menu=id_menu
															  and slc_usuario_id_usuario=$this->usu)
								FROM slc_menu, slc_nivel_menu
								where status_menu='A' 
								and slc_nivel_menu_id_nivel=".$vectniv[3]."
								and slc_nivel_menu_id_nivel=id_nivel
								and id_padre=".$rowb[0]." order by alias_menu";
						$resultc=mysql_query($sqlc,$this->conexion);
						$nc=mysql_num_rows($resultc);
	
						$pagib='';
						if($rowb[4]!='')
							$pagib=' onclick="top.mainFrame.location.href='."'".$rowb[4]."'".'" ';
						else
						{
							if($nc>0)
								$pagib=' onclick="mostrar('.$contamenu.','.$rowb[1].');" ';
						}
	
						$HTMLb.='<tr><td width="100%"  height="28" class="texto option-submenu" align="center" 
										style="cursor:hand" '.$colorb.$imagenb.$pagib.'>'.ucwords(strtolower($rowb[2])).'</td></tr>';
	
						if($nc>0)
						{
						  $HTMLb.='<td width="100%" class="texto" border="0" align="left" cellpadding="0" cellspacing="0"><table id="tabla'.$contamenu.'**'.$rowb[1].'" style="display:none;margin-left:10px" width="100%" cellpadding="0" cellspacing="1">';
						}
	
						$HTMLauxC = array();
						while ($rowc = mysql_fetch_row($resultc))
						{ 
							$contamenu++;
							$HTMLc='';
							$cadenac=implode('/*',$rowc);
							$muestrac=0;
							$imagenc='';
							if($rowc[7]!='' && $rowc[8]!='')
								$imagenc=' background="imagenes/'.$rowc[8].'" 
										  onmouseover="this.background='."'imagenes/".$rowc[7]."'".'"  
										  onmouseout="this.background='."'imagenes/".$rowc[8]."'".'"';
							$colorc='';
							// if($rowc[9]!='')
							// 	$colorc=' bgcolor="'.$rowc[9].'" onMouseOver="this.bgColor = '."'".'#F0F0F0'."'".'" 
							// 			onMouseOut ="this.bgColor ='."'".$rowc[9]."'".'"';
							
	
							$sqld="SELECT id_menu, slc_nivel_menu_id_nivel, alias_menu, id_padre, pantalla_menu, desc_menu, status_menu, 
									imagen_a, imagen_p, color_nivel, (select count(slc_menu_id_menu) from slc_permisologia
																  where slc_menu_id_menu=id_menu
																  and slc_usuario_id_usuario=$this->usu)
									FROM slc_menu, slc_nivel_menu
									where status_menu='A' 
									and slc_nivel_menu_id_nivel=id_nivel
									and slc_nivel_menu_id_nivel=".$vectniv[4]."
									and id_padre=".$rowc[0]." order by alias_menu";
									//echo $sqld;
							
							$resultd=mysql_query($sqld,$this->conexion);
							$nd=mysql_num_rows($resultd);
	
							$pagic='';
							if($rowc[4]!='')
								$pagic=' onclick="top.mainFrame.location.href='."'".$rowc[4]."'".'" ';
							else
							{
								if($nd>0)
									$pagic=' onclick="mostrar('.$contamenu.','.$rowc[1].');" ';
							}
	
							$HTMLc.='<tr><td width="100%"  height="28" class="texto option-submenu" align="left" 
											style="cursor:hand" '.$colorc.$imagenc.$pagic.'>'.ucwords(strtolower($rowc[2])).'</td></tr>';
	
							if($nd>0)
							{
								$HTMLc.='<tr><td width="100%" class="texto" border="0" align="left" cellpadding="0" 
										cellspacing="0"><table id="tabla'.$contamenu.'**'.$rowc[1].'" width="100%" style="display:none"  cellpadding="0" cellspacing="1">';
							}
							$HTMLauxD = array();
							while ($rowd = mysql_fetch_row($resultd))
							{
								$contamenu++;
								$HTMLd='';
								$cadenad=implode('/*',$rowd);
								$imagend='';
								if($rowd[7]!='' && $rowd[8]!='')
									$imagend=' background="imagenes/'.$rowd[8].'" 
											  onmouseover="this.background='."'imagenes/".$rowd[7]."'".'"  
											  onmouseout="this.background='."'imagenes/".$rowd[8]."'".'"';
								$colord='';
								// if($rowd[9]!='')
								// 	$colord=' bgcolor="'.$rowd[9].'" onMouseOver="this.bgColor = '."'".'#F0F0F0'."'".'" 
								// 			onMouseOut ="this.bgColor ='."'".$rowd[9]."'".'"';
								$pagid='';
								if($rowd[4]!='')
									$pagid=' onclick="top.mainFrame.location.href='."'".$rowd[4]."'".'" ';
							
								$HTMLd='<tr><td width="100%"  height="28" class="texto option-submenu" align="center" 
												style="cursor:hand" '.$colord.$imagend.$pagid.'>'.ucwords(strtolower($rowd[2])).'</td></tr>';
								
								if($rowd[10]>0)
								{
									$HTMLauxD[]=$HTMLd;
									$muestrac=1;
								} 
							} // fIN DEL CICLO D
							
							if($rowc[10]>0 || $muestrac==1)
							{
								$HTMLc.= implode('',$HTMLauxD);
								if($nd>0)
								{
									$HTMLc.='</table></td></tr>';
								}
								$muestrab=1;
								$muestrac=0;
								$HTMLauxC[]=$HTMLc;
							} 
							
						} // FIN DEL CICLO C
						
						if($rowb[10]>0 || $muestrab==1)
						{
							$HTMLb.= implode('',$HTMLauxC);
							if($nc>0)
							{
								$HTMLb.='</table></td></tr>';
							}
							$muestraa=1;
							$muestrab=0;
							$HTMLauxB[]=$HTMLb;
						} 
						
					} // FIN DEL CICLO B
					
					if($rowa[10]>0 || $muestraa==1)
					{
						$HTMLa.= implode('',$HTMLauxB);
						if($nb>0)
						{
							$HTMLa.='</table></td></tr>';
						}
						$muestraa=0;
						$htmluni[$supercont]=$HTMLa;
					} 
					
				} // FIN DEL CICLO A
				return $HTML.implode('',$htmluni).'
				<td width="100%"  height="28" class="texto option-menu" align="center" 				
				onclick="top.mainFrame.location.href='."'centro.php'".'; top.leftFrame.location.href = '."'menu.php'".'" >SALIR</td></tr>
				</table>
				<input name="cuantos" id="cuantos" type="hidden" value="'.$contamenu.'"/>
				<input name="cantiniv" id="cantiniv" type="hidden" value="'.implode('***',$vectniv).'"/>';
			}
			/*else
			return false;*/
		}
		else
		  return  '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#a8a9ad" 
						align="center" class="textoN">
				  <tr><td width="100%"  height="28" class="texto" align="center" >No tiene permisos asignados. Comuniquese con un administrador</td></tr>
				<tr><td width="100%"  height="28" class="texto" align="center" 
				style="cursor:hand" 
				background="" 
				onmouseover="this.background='."''".'"  
				onmouseout="this.background='."''".'" 
				onclick="top.mainFrame.location.href='."'centro.php'".'; top.leftFrame.location.href = '."'menu.php'".'" >SALIR</td></tr>
				</table>';
		  
	} // fin de funcion pinta_menu
function buscar_idmenu()
{
	$sql="select id_menu from slc_menu where pantalla_menu='$this->pant'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	 $row=mysql_fetch_array($result); 
	  if($n==0)
			   return 'false';
			else
			   return $row[0];
}
}// fin de la clase 

?>