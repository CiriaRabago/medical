<?php  
/* 
CLASE EMPRESA
CREADA POR: GRATELLY GARZA
FECHA DE CREACIÓN: 22/02/2011
OBJETIVO: RECOPILACIÓN DE FUNCIONES RELATIVAS A LAS EMPRESAS
*/

/* DECLARACIÓN DE LA CLASE */
class presup
{
   var $id_pres;
   var $f_ini;
   var $f_fin;
   var $mon;
   var $mxc;
   var $id_p;
   var $riva;
   var $rislr;
   var $usu;
   var $fecha;
   var $des;
   var $est;
   var $fac;
   var $b_imp;
   
   
/* FUNCIÓN CONSTRUCTORA */  
   function presup($id_pre,$fi, $ff, $mo, $mc, $ip, $iva, $islr, $us, $fec,$de,$es,$fa,$bi)
   {
		$this->conexion=Conectarse();
		$this->id_pres=$id_pre;
		$this->f_ini=$fi;
   		$this->f_fin=$ff;
		$this->mon=$mo;   		
		$this->mxc=$mc;
   		$this->id_p=$ip;
   		$this->riva=$iva;
		$this->rislr=$islr;
   		$this->usu=$us;
		$this->fecha=$fec;
		$this->des=$de;
		$this->est=$es;
		$this->fac=$fa;
		$this->b_imp=$bi;

	} //fin del constructor
	
/* FUNCIÓN PARA INSERTAR*/  	
	function ins_presup()
	{$zone=(3600*-4.5); 
$hoy=gmdate("Y-m-d H:i:s", time() + $zone);
	   	$sql="INSERT INTO slc_presupuestos (f_inicio, f_fin, monto, monto_xcancelar,id_proveedor,r_iva, r_islr, id_usuario, fecha_ing_pres, des_presupuesto,estatus,n_factura,base_imp) VALUES
		 ('$this->f_ini', '$this->f_fin', '$this->mon', '$this->mxc', '$this->id_p', '$this->riva', '$this->rislr','$this->usu','$hoy',upper('$this->des'),upper('$this->est'),upper('$this->fac'), '$this->b_imp')";
			$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	} // fin de funcion  insertar 
	function ver_max_id_presup() //funcion para ver si el registro existe 
	{
	$sql="select max(id_presupuesto) from slc_presupuestos"; 
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_fetch_array($result);
		//echo $sql;
		if ($n) 
			   return $n[0];
		else
			   return false;
		}
function ver_det_abono($id_p) //funcion para ver detalles de abonos
	{$xx=0;
	$sql2="SELECT  *  from slc_abono_presu 
		   	where id_presu=$id_p and estatus='A'";
		$result2=mysql_query($sql2,$this->conexion);
		$HTML.='<table width="520" border="0" align="center" >';
		 while($row2 = mysql_fetch_row($result2))
		{		
			$xx++;
		 	$HTML.='<tr>
		 	<td><input type="text" name="m_abono_car'.$xx.'" id="m_abono_car'.$xx.'" size="15" value='.$row2[2].'></td>
		 	<td><input type="date" name="f_abono_car'.$xx.'" id="f_abono_car'.$xx.'" size="15" value='.$row2[3].'></td>
		 	<td><input type="text" name="des_abono_car'.$xx.'" id="des_abono_car'.$xx.'" size="15" value='.$row2[6].'><img src="imagenes/delete_16x16.gif" id="elimi" title="Eliminar" alt="Eliminar" onClick="elimina_abono('.$row2[0].');" '.$impagre.'></td>
		 	<input type="hidden" name="id_abono_car'.$xx.'" id="id_abono_car'.$xx.'" size="15" value='.$row2[0].'>
		 	<input type="hidden" name="m_abono_car_ocul'.$xx.'" id="m_abono_car_ocul'.$xx.'" size="15" value='.$row2[2].'>
		 	<input type="hidden" name="f_abono_car_ocul'.$xx.'" id="f_abono_car_ocul'.$xx.'" size="15" value='.$row2[3].'>
		 	<input type="hidden" name="des_abono_car_ocul'.$xx.'" id="des_abono_car_ocul'.$xx.'" size="15" value='.$row2[6].'>
		 	</tr>';
		
		}
		$HTML.='<input type="hidden" name="c_a" id="c_a" size="15" value='.$xx.'>
		</table>';
		 return $HTML;

	}
	function ver_det_abono2($id_p) //funcion para ver detalles de abonos
	{
	$sql2="SELECT  *  from slc_abono_presu 
		   	where id_presu=$id_p and estatus='A'";
		$result2=mysql_query($sql2,$this->conexion);
		$HTML.='<table width="520" border="0" align="center" >';
		 while($row2 = mysql_fetch_row($result2))
		{
			 $cad=$row2[2]."**".$row2[3].'**'.$row2[4].'**'.$row2[5].'**'.$row2[6];
			     return $cad;
		}
		

	}
	function insertar_a($id_p,$m_a,$f_a,$id_u,$est,$det) //funcion para insertar abonos
	{
		$sql="INSERT INTO slc_abono_presu (id_presu, monto_abono, fecha_ing_abono, id_usuario, estatus, det_abono) VALUES
		 ('$id_p', '$m_a', '$f_a', '$id_u', '$est', upper('$det'))";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;

	}
		function finaliza_p($id_p,$n_f,$n_es) //funcion para insertar abonos
	{
		$sql="UPDATE slc_presupuestos SET estatus='$n_es' , n_factura='$n_f' WHERE id_presupuesto ='$id_p'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;

	}
		function ver_fact($id_p) //funcion para insertar abonos
	{
		$sql="SELECT * from slc_presupuestos WHERE id_presupuesto ='$id_p'";
		$result=mysql_query($sql,$this->conexion);
		$n=mysql_fetch_row($result);
		if ($n) 
			   return $n[12].'**'.$n[11];
		else
			   return false;
		
	}
function ver_listado_presup($pro,$est,$c_des,$c_has,$v_des,$v_has,$ch_p2,$ch_m2,$ch_c2,$ch_v2){

		$spro=' ';
		$sest=' ';
		$sc_des=' ';
		$sc_has=' ';
		$sv_des=' ';
		$sv_has=' ';
		$se_eliminado=" a.estatus<>'E'";//para q no muestre los eliminados :::
		
		if($pro!='0' ) 
		  $spro=" and id_proveedor=$pro";
		if($est!='' ) 
		{
		  $sest=" a.estatus='$est'";
		  $se_eliminado='';
		}
		if($c_des!='' ) 
		$sc_des=" and a.f_inicio>='$c_des'";
		if($c_has!='' ) 
		$sc_has=" and a.f_inicio<='$c_has'";
		if($v_des!='' ) 
		$sv_des=" and a.f_fin>='$v_des'";
		if($v_has!='' ) 
		$sv_has=" and a.f_fin<='$v_has'";
		if($ch_p2!='' || $ch_m2!='' || $ch_c2!='' || $ch_v2!='')
		$order=' order by '; 
		if($ch_p2!='' ) 
		$ch_p2=" b.nom_empresa";
		if($ch_m2!='' ) 
		$ch_m2=" a.monto_xcancelar";
		if($ch_c2!='' ) 
		$ch_c2=" a.f_inicio";
		if($ch_v2!='' ) 
		$ch_v2=" a.f_fin";



		
		$sql="SELECT a.id_presupuesto, b.nom_empresa,a.des_presupuesto,a.f_inicio,a.f_fin,a.monto_xcancelar,a.estatus from slc_presupuestos as a
			join slc_empresa_pres as b
			on a.id_proveedor=b.id_empresa 
			where".$se_eliminado.$sest.$spro.$sc_des.$sc_has.$sv_des.$sv_has.$order.$ch_p2.$ch_e2.$ch_m2.$ch_c2.$ch_v2;
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="1000" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="5"><div align="center">#</div></td>
			    <td width="5"><div align="center">N Pres.</div></td>
				<td width="100"><div align="left">Proveedor</div></td>
				<td width="100"><div align="left">Descripci&oacute;n</div></td>
				<td width="30"><div align="left">Fecha Inicio</div></td>
				<td width="30"><div align="left">Fecha Vencimiento</div></td>
				<td width="30"><div align="left">Monto</div></td>
				<td width="30"><div align="left">Abonado</div></td>
				<td width="30"><div align="left">Saldo</div></td>
				<td width="30"><div align="left">Estatus</div></td>
			  </tr>';
           $xx=0;
           $acum_mxc=0;   
		   while ($row = mysql_fetch_row($result))
		   	{

		   	$sql2="SELECT  SUM(monto_abono) from slc_abono_presu 
		   	where id_presu=$row[0] and estatus='A'";
		$result2=mysql_query($sql2,$this->conexion);
		 while($row2 = mysql_fetch_row($result2))
		 {
		$monto_abono=$row2[0];
		$monto_xcancelar=$row[5]-$row2[0];
		}	
			$acum_mxc=$acum_mxc+$row[5];//acumulador de montos x cancelar 
			$acum_abo=$acum_abo+$monto_abono;//acumulador de montos abonado
			$acum_sal=$acum_sal+$monto_xcancelar;//acumulador de saldo
	   		$xx++;
			$pagina='abono_presupuesto.php?id_p='.$row[0];
			$HTML.='<tr>
			    <td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto" align="left">'.$xx.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto" align="left">'.$row[0].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.$row[3].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.$row[4].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.number_format($row[5], 2, ',', '. ').'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.number_format($monto_abono, 2, ',', '.').'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.number_format($monto_xcancelar, 2, ',', '.').'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$pagina."'".')" class="texto">'.$row[6].'</td>
				</tr>';
			}
       	  $HTML.='<tr  class="titulorep">
       	  <td width="5">&nbsp;</td>
       	  <td width="5">&nbsp;</td>
       	  <td width="5">&nbsp;</td>
       	  <td width="5">&nbsp;</td>
       	  <td width="5">&nbsp;</td>
       	  <td width="5">Totales:</td>
       	  <td style="cursor:hand"class="texto">'.number_format($acum_mxc, 2, ',', '.').'</td>
       	  <td style="cursor:hand"class="texto">'.number_format($acum_abo, 2, ',', '.').'</td>
       	  <td style="cursor:hand"class="texto">'.number_format($acum_sal, 2, ',', '.').'</td>
       	  <td width="5">&nbsp;</td>
				</tr></table>';
		  return $HTML;
		}
		else
		return false;
		}
		function ver_listado_presup3($pro,$est,$c_des,$c_has,$v_des,$v_has,$ch_p2,$ch_m2,$ch_c2,$ch_v2){

		$spro=' ';
		$sest=' ';
		$sc_des=' ';
		$sc_has=' ';
		$sv_des=' ';
		$sv_has=' ';
		$se_eliminado=" a.estatus<>'E'";//para q no muestre los eliminados :::
		
		if($pro!='0' ) 
		  $spro=" and id_proveedor=$pro";
		if($est!='' ) 
		{
		  $sest=" a.estatus='$est'";
		  $se_eliminado='';
		}
		if($c_des!='' ) 
		$sc_des=" and a.f_inicio>='$c_des'";
		if($c_has!='' ) 
		$sc_has=" and a.f_inicio<='$c_has'";
		if($v_des!='' ) 
		$sv_des=" and a.f_fin>='$v_des'";
		if($v_has!='' ) 
		$sv_has=" and a.f_fin<='$v_has'";
		if($ch_p2!='' || $ch_m2!='' || $ch_c2!='' || $ch_v2!='')
		$order=' order by '; 
		if($ch_p2!='' ) 
		$ch_p2=" b.nom_empresa";
		if($ch_m2!='' ) 
		$ch_m2=" a.monto_xcancelar";
		if($ch_c2!='' ) 
		$ch_c2=" a.f_inicio";
		if($ch_v2!='' ) 
		$ch_v2=" a.f_fin";

		$sql="SELECT a.id_presupuesto, b.nom_empresa,a.des_presupuesto,a.f_inicio,a.f_fin,a.monto_xcancelar,a.estatus from slc_presupuestos as a
			join slc_empresa_pres as b
			on a.id_proveedor=b.id_empresa 
			where".$se_eliminado.$sest.$spro.$sc_des.$sc_has.$sv_des.$sv_has.$order.$ch_p2.$ch_e2.$ch_m2.$ch_c2.$ch_v2;
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
		{ 
			$n=mysql_num_rows($result);
	  		if($n==0)
			   return false;
			else
			   return $result;
		 }
		 else 
		 	return false;
	} // Fin de la función 
	function ver_listado_presup2(){

		$sql="SELECT a.id_presupuesto, b.nom_empresa,a.des_presupuesto,a.f_inicio,a.f_fin,a.monto_xcancelar,a.estatus,a.monto from slc_presupuestos as a
			join slc_empresa_pres as b
			on a.id_proveedor=b.id_empresa 
			order by b.nom_empresa";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="700" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="5"><div align="center">#</div></td>
			    <td width="5"><div align="center">N Pres.</div></td>
				<td width="100"><div align="left">Proveedor</div></td>
				<td width="100"><div align="left">Descripci&oacute;n</div></td>
				<td width="30"><div align="left">Monto</div></td>
			</tr>';
           $xx=0;   
		   while ($row = mysql_fetch_row($result))
		   	{
	   		$xx++;
	   		$cad=$row[0]."**".$row[1]."**".$row[2]."**".$row[3].'**'.$row[4].'**'.$row[5].'**'.$row[6].'**'.$row[7];
			$HTML.='<tr>
			    <td style="cursor:hand" onClick="ver_actualizar('."'".$cad."'".')" class="texto" align="left">'.$xx.'</td>
				<td style="cursor:hand" onClick="ver_actualizar('."'".$cad."'".')" class="texto" align="left">'.$row[0].'</td>
				<td style="cursor:hand" onClick="ver_actualizar('."'".$cad."'".')" class="texto">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_actualizar('."'".$cad."'".')" class="texto">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_actualizar('."'".$cad."'".')" class="texto">'.$row[5].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
		}
	
	function buscar_presup($id_pres)
	{
		$sql="SELECT a.id_presupuesto, b.nom_empresa,a.des_presupuesto,a.f_inicio,a.f_fin,a.monto_xcancelar,a.r_iva, a.r_islr,a.monto,b.reten_iva,a.base_imp,a.estatus from slc_presupuestos as a
			join slc_empresa_pres as b
			on a.id_proveedor=b.id_empresa 
			where a.id_presupuesto=".$id_pres;
		$result=mysql_query($sql,$this->conexion);
		if ($result)
		 { 
			while($reg= mysql_fetch_row($result))
			 {	
				$sql2="SELECT  SUM(monto_abono) from slc_abono_presu 
				where id_presu=$reg[0] and estatus='A'";
				$result2=mysql_query($sql2,$this->conexion);
				while($row2 = mysql_fetch_row($result2))
				{
				$monto_abono=$row2[0];
				$monto_xcancelar=$reg[5]-$row2[0];
				}

			    $cad=$reg[0]."**".$reg[1]."**".$reg[2]."**".$reg[3].'**'.$reg[4].'**'.$reg[5].'**'.$reg[6].'**'.$reg[7].'**'.$reg[8].'**'.$monto_abono.'**'.$monto_xcancelar.'**'.$reg[9].'**'.$reg[10].'**'.$reg[11];
			     return $cad;
			  }	
			  }   
		else
			   return false;
	   	
	} //buscar_presup

	function ver_empresa_inactiva_pres()
	{
	   	$sql="SELECT * from slc_empresa_pres where sta_empresa<>'A' order by nom_empresa";
		$result=mysql_query($sql,$this->conexion);
		
		if ($result) 
		{ 
		   $HTML.='<table width="550" border="0" cellpadding="1" cellspacing="1" align="center">
			  <tr class="titulorep">
			    <td width="50"><div align="center">#</div></td>
				<td width="400"><div align="left">Nombre</div></td>
				<td width="150"><div align="left">Rif</div></td>
				<td width="150"><div align="left">Direccion</div></td>
				<td width="150"><div align="left">Telefono</div></td>
			  </tr>';
           $xx=0;   
		   while ($row = mysql_fetch_row($result))
		   {$xx++;
			$cadena=implode('/*',$row);
			$HTML.='<tr>
			    <td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$xx.'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto" align="left">'.$row[2].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[1].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[3].'</td>
				<td style="cursor:hand" onClick="ver_modif('."'".$cadena."'".')" class="texto">'.$row[5].'</td>
				</tr>';
			}
       	  $HTML.='</table>';
		  return $HTML;
		}
		else
		return false;
	} // fin de funcion ver 

function buscar_pres() //funcion para ver si el registro existe 
	{
	$sql="select * from slc_empresa_pres where nom_empresa='$this->nom'"; 
	 $result=mysql_query($sql,$this->conexion);
	 $n=mysql_num_rows($result);
	  if($n==0)
			   return 'false';
			else
			   return 'true';
	}
function ver_empre_pres($id) //funcion para ver si el registro existe 
	{
	$sql="select nom_empresa from slc_empresa_pres where id_empresa =".$id; 
	$result=mysql_query($sql,$this->conexion);
	 $n=mysql_fetch_array($result);
		//echo $sql;
		if ($n) 
			   return $n[0];
		else
			   return false;
		}


function eliminar_pres($id)
{
	$sql="UPDATE slc_empresa_pres SET sta_empresa='I' WHERE id_empresa ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function eliminar_presupuesto($id)
{	$sql1="UPDATE slc_abono_presu  SET estatus='E' WHERE id_presu='$id'";
		$result1=mysql_query($sql1,$this->conexion);//para cambiar el estatus de los abonos;; 


	$sql="UPDATE slc_presupuestos  SET estatus='E' WHERE id_presupuesto ='$id'";
		$result=mysql_query($sql,$this->conexion);//para cambiar el estatus de los presupuestos
		if ($result) 
			   return true;
		else
			   return false;
	
}
function modificar_pres()
{
	$sql="UPDATE slc_presupuestos SET f_inicio='$this->f_ini', f_fin='$this->f_fin', monto='$this->mon', monto_xcancelar='$this->mxc', r_iva='$this->riva', r_islr='$this->rislr', id_usuario='$this->usu', fecha_ing_pres='$this->fecha', des_presupuesto=upper('$this->des'), base_imp='$this->b_imp' WHERE id_presupuesto='$this->id_pres'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	
}
function modificar_abono($id_a, $mon, $fec, $usu, $des)
{
		$sql="UPDATE slc_abono_presu SET monto_abono='$mon', fecha_ing_abono='$fec', id_usuario='$usu', det_abono='$des' WHERE id_abono_presu=$id_a";
		$result=mysql_query($sql,$this->conexion);

		if ($result) 
		return true;
		else
		return false;
	
}
function restaurar_pres($id)
{
	$sql="UPDATE slc_empresa_pres SET sta_empresa='A' WHERE id_empresa ='$id'";
	$result=mysql_query($sql,$this->conexion);
	if ($result) 
	   return true;
	else
	   return false;
}
	function lista_emp_pres()  
	{
	$sql="SELECT * FROM slc_empresa_pres where  sta_empresa='A' order by nom_empresa"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else		
	    return $result;
	  
	}
	function lista_emp_i_pres()  
	{
	$sql="SELECT * FROM slc_empresa_pres where  sta_empresa<>'A' order by nom_empresa"; 
	 $result=mysql_query($sql,$this->conexion);
	 $row=mysql_fetch_array($result); 
	 $n=mysql_num_rows($result);
	  if($n==0)
		return 'false';
	  else		
	    return $result;
	  
	}
	function elimina_a($id) //funcion para ver si el registro existe 
	{
	$sql="UPDATE slc_abono_presu SET estatus='I' WHERE id_abono_presu ='$id'";
		$result=mysql_query($sql,$this->conexion);
		if ($result) 
			   return true;
		else
			   return false;
	}

}// fin de la clase 

?>