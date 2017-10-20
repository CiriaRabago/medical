<script type="text/javascript" src="../javascript/js.js"></script>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="../estilos/estilos.css" rel="stylesheet" type="text/css" />
<?php 
session_start();
include ("../clases/claseconexion.php");
include ("../clases/proveedor.php");
include ("../clases/descripcion.php");
include ("../clases/materiales.php");
global $conn;
$id_emp=$_SESSION['id_emp'];//EMPLEADO
$fecha_ac= @date("Y-m-d");//fecha
$hora= date ("h:i:s");//hora
$lista=$_POST['idContenido']; 
$word=$_POST['word'];
$accion=$_POST['accion'];
$obj_proveedor = new proveedores();
$obj_descripcion = new descripcion();
$h_guadado=$fecha_ac.' '.$hora;
/*
global $conn;
$obj_indemnizacion = new indemnizacion();
$indemnizacion=$obj_indemnizacion->consultar();*/
	if($accion!=NULL)
{
	//COMIENZAN LAS CONSULTAS PARA CONTROL_OFICIO:::::::::::::::::::::::::::::::::
	if($accion=="id_sede")	//consulta hecha para determinar los locales u oficinas de cada sede!!!!!!!!!!!!!
	{

     $queryto="select * from local where sede_id_sede= $word";
     $datos=$conn->ejecutar($queryto);
     ?>
		 <select name="local" id="local">
    <option value="0">---Seleccione---</option>
    <?php 
    while($fila=$conn->siguiente($datos))
	{if(isset($buscar)){
			if ($fila[0] == $DATOS['muni']){
				echo  '<option value='.$fila[0].' selected="selected">'.utf8_encode($fila[1]).'</option>';
			}
		}
		echo  '<option value='.$fila[0].'>'.utf8_encode($fila[1]).'</option>';
		}
	
	?>      
    </select>
		<?php 
	} //fin de consulta ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	if($accion=="insertar_insumos")	//se insertan los insumos por requisicion de inventario !!!!!!!!!!!!!
	{	
		$monto = 0; //en este caso no se guarda el monto por eso lo igualo a 0
		$proveedor = 0;
		echo$ultima="select max(id_mat) from material";
		$OBJ = $conn->ejecutar($ultima);
		$DATOS = $conn->siguiente($OBJ);
		$ultimo_material=$DATOS[0];
		if($ultimo_material==''){
			$ultimo_material=1;
		}else{$ultimo_material=$ultimo_material+1;}
		list($can_insumo,$des_insumo,$n_oficio) = explode("¬",$word);
		$query = 'INSERT INTO material (id_mat,can_material,des_material,fec_material,oficios_id_ofi,empleados_id_emp,monto_mat,proveedor_id_proveedor)
			VALUES (\''.$ultimo_material.'\',\''.$can_insumo.'\',\''.utf8_encode($des_insumo).'\',\''.$h_guadado.'\',\''.$n_oficio.'\',\''.$id_emp.'\',\''.$monto.'\',\''.$proveedor.'\')';
					mysql_query($query) or die(mysql_error());
	
	}
	if($accion=="gua_bitacora")	//se insertan se guarda la bitacora !!!!!!!!!!!!!
	{
		$ultima="select max(id_bit) from bitacora_oficios";
		$OBJ = $conn->ejecutar($ultima);
		$DATOS = $conn->siguiente($OBJ);
		$ultimo_oficio=$DATOS[0];
		if($ultimo_oficio==''){
			$ultimo_oficio=1;
		}else{$ultimo_oficio=$ultimo_oficio+1;}
     	list($n_oficio,$estatus,$des_obs) = explode("¬",$word);
     	$des_obs = html_entity_decode($des_obs, ENT_QUOTES | ENT_HTML401, "UTF-8");
		$query = 'INSERT INTO bitacora_oficios (id_bit,fecha_bit,estatus_bit,obser_ofi,empleados_id_emp,oficios_id_ofi)
			VALUES (\''.$ultimo_oficio.'\',\''.$h_guadado.'\',\''.$estatus.'\',\''.($des_obs).'\',\''.$id_emp.'\',\''.$n_oficio.'\')';
					mysql_query($query) or die(mysql_error());
		}
	if($accion=="gua_oficio")	//se insertan se guarda la bitacora !!!!!!!!!!!!!
	{	//$total = 0;
		list($n_oficio,$depar,$id_emp,$local) = explode("¬",$word);
		$query = 'INSERT INTO oficios (id_ofi,fecha_ofi,total_oficio,departamento_id_dep,empleados_id_emp,local_id_local)
			VALUES (\''.$n_oficio.'\',\''.$h_guadado.'\',\''.$total.'\',\''.$depar.'\',\''.$id_emp.'\',\''.$local.'\')';
					mysql_query($query) or die(mysql_error());
		}
	if($accion=="mostrar_oficio")	//se lista la busqueda de oficos!!!!!!!!!!!!!
	{	//$total = 0;
		echo 'estamos en prueba';
	}
		if($accion=="proveedor")	
	{
		$ultima="select max(id_proveedor) from proveedor";
		$OBJ = $conn->ejecutar($ultima);
		$DATOS = $conn->siguiente($OBJ);
		$ultimo_pro=$DATOS[0];
		if($ultimo_pro==''){
			$ultimo_pro=1;
		}else{$ultimo_pro=$ultimo_pro+1;}
			list($rif1,$nom1,$dir1,$tlf1,$tlf2) = explode("@",$word);
		$consulta=("select rif from proveedor where rif='$rif1'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(empty($DATOS[0]))
		{	

		$query = 'INSERT INTO proveedor (id_proveedor,rif,nombre,telefono1,telefono2,direccion)
			VALUES (\''.$ultimo_pro.'\',\''.$rif1.'\',\''.$nom1.'\',\''.$tlf1.'\',\''.$tlf2.'\',\''.$dir1.'\')';
					mysql_query($query) or die(mysql_error());
		echo 'El proveedor: '.$nom1.' ha sido registrado<br>';
		echo	' de manera satisfactoria!!<br />';
					
		}else {echo'El proveedor: '.$nom1.' no se puede registrar<br>';
						echo'El R.I.F. ya ha sido utilizado';		
		}	

		}


///////////////////////////////////////////////////////////////////////VIEJAS////////////////////////
	if($accion=="cedula_acta")	
	{
		
		$consulta = ("SELECT cedula FROM historico WHERE cedula = '$word' and estatus!='M'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(!empty($DATOS[0]))
		{
			
		echo "<font color='blue'><b>Acta localizada</b></font>";
		}
		
		
	} 
	if($accion=="numero_acta")	
	{
		
		$consulta = ("SELECT n_acta FROM historico WHERE n_acta = '$word'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(!empty($DATOS[0]))
		{
			
		echo "<font color='blue'><b>Acta localizada</b></font>";
		}
		
		
	} 
	
	if($accion=="persona")	
	{
		
			list($ced,$nom,$tlf,$cel,$dir,$mun) = explode("@",$word);
		
		$consulta=("select cedula from persona where cedula='$ced'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(empty($DATOS[0]))
		{	
					
			$query = 'INSERT INTO persona (cedula,nombre,tlf,celu,resi,muni)
			VALUES (\''.$ced.'\',\''.strtoupper($nom).'\',\''.$tlf.'\',\''.$cel.'\',\''.$dir.'\',\''.$mun.'\')';
					mysql_query($query) or die(mysql_error());
					echo 'La Persona de CI: '.$ced.' ha sido registrada<br>';
					echo	' de manera satisfactoria!!<br />';
					
		}else {echo"La persona de CI: ".$extension." se encuentra registrada con anterioridad";
		}
	} 
	if($accion=="servicio_ver")	
	{
		
		
		
			
		echo "<font color='red'><b>Numero de consultas superado</b></font>";
		
		
		
	} 
	if($accion=="rif")	
	{
		
		$consulta = ("SELECT rif FROM proveedor WHERE rif = '$word'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(!empty($DATOS[0]))
		{
			
		echo "<font color='red'><b>Proveedor Registrado</b></font>";
		}
		
		
	}

if($accion=="person")	
	{ 
		
		$consulta = ("SELECT nombre FROM persona WHERE cedula = '$word'");
		$OBJ = $conn->ejecutar($consulta);
		$DATOS = $conn->siguiente($OBJ);
		if(!empty($DATOS[0]))
		{
			
		echo "<font color='blue'><b> ".$DATOS[0]."</b></font>";
		}
		
		
	} 
	if($accion=="lista")	
	{ 
		?>
	
	<table width="650" height="" border="0" align="center" cellpadding="0" cellspacing="0" id="indemnizacion">
  <tr>
    <td width="100" height="30"><label>
    <select name="med_id<?php echo $word;?>" id="med_nom_ape<?php echo $word;?>" onchange="cargarCombo('../ajax/inde_sele.php', 'med_nom_ape<?php echo $word;?>', 'indemnizacion<?php echo $word;?>',<?php  echo $word; ?> );">
    <option value="0">-----------------SELECCIONE-----------------</option>
    <?php 
    while($fila=$conn->siguiente($indemnizacion))
	{
	echo  '<option value='.$fila[0].'>'.utf8_encode($fila[1]).'</option>';
	}
	?>      
    </select>
    </label></td>
    <td height="30" class="subSubTitulo2"><div  id="indemnizacion<?php echo $word;?>"></div></td>
    </tr>
    </table>
   <?php 
	}		
	if($accion=="autorizacion")	
	{
	?>
			<form name="fomulario2" action="../Autorizacion.php" method ="post" target="_blank">
			<input type="text" size="40" readonly="true"  name="palabra" value="<?php echo$word;?>" >
			<input  type="submit" value="Generar pdf"  /></br></br>
			
			</form>
	<?php 
		//echo "estoy a punto de crear el pdf";
		
	}		//echo "no recibo accion";
	if($accion=="gua_materiales")
	{
		list($ciclo,$n_acta)=explode("@",$word);
		$cuantas=($ciclo * 4)+2;
		//echo $cuantas;
		
		echo substr_count($word, '@');
		for($i=1; $i<=$cuantas;$i++)
		{
			
		}
		/*for($i=1; $i<=$ciclo; $i++)
		{
			list($ciclo,$n_acta,$id_mat[$i],$can[$i],$cos[$i],$tot[$i]) = explode("@",$word);
			echo $i.'<br>';
			echo $n_acta[$i]." material ".$id_mat[$i]." cantidad ".$can[$i]." costo ".$cos[$i]." total ".$tot[$i].'<br>';
			//exit();
			//$obj_descripcion->agregar($id_mat,$n_acta,$can,$cos);
		
		}*/
	}
	//agregar_prestamo::::::_
	else if($accion=="prest")	
	{ //echo "estoy en prestamo";
		list($pos,$con) = explode("@",$word);
		$obj_materiales = new material();
		$mat = $obj_materiales->consultar('','des','');
		?>
		<table width="600" height="" border="0" align="center" cellpadding="0" cellspacing="0" id="coberturas"><tr></br>
    <td colspan="6" class="titulo">Nueva Lista
    </tr>
    <tr>
	   <td width="30" height="30">
	</td>
	<td height="25" class="subSubTitulo2">
	Descripción
	</td>
	<td width="233" height="25" class="subSubTitulo2">
	<div align="center">
	Unidad
	</div>
	</td>
	<td width="233" height="25" class="subSubTitulo2">
	<div align="center">
	Cantidad
	</div>
	</td>
	<td width="233" height="25" class="subSubTitulo2">
	<div align="center">
	Bs. Cobertura
	</div>
	</td>
	<td width="233" height="25" class="subSubTitulo2">
	<div align="center">
	Total
	</div>
	</td>
	</tr><?php 
	$i=1;
		while($fila=$conn->siguiente($mat))
		{ 
	   ?>
          <tr>
            <td height="25">&nbsp;</td>
            <td width="498" height="25"><span class="subSubTitulo2">
              <input type="hidden" name="cob_id<?php  echo $i ?>" id="cob_id<?php  echo $i ?>" value="<?php  echo $fila[0]?>"/>
              <input name="dsc_cover<?php  echo $i ?>" type="text" class="cuadros_de_texto" id="dsc_cover<?php  echo $i ?>" size="50" value="<?php  echo utf8_encode($fila[1])?>"  readonly="readonly" />
            </span></td>
             <td width="233" height="25"><div align="center">
                <input name="unidad<?php  echo $i ?>" type="text" class="cuadros_de_texto" id="unidad<?php  echo $i ?>" size="14" value="<?php  echo utf8_encode($fila[2])?>"readonly="readonly" />
            </div></td>
            <td width="233" height="25"><div align="center">
                <input name="cantidad<?php  echo $i ?>" type="text" class="input_numerico" id="cantidad<?php  echo $i ?>" size="10"  onblur="calculo_total(<?php echo $i?>);" />
            </div></td>
            <td width="233" height="25"><div align="center">
                <input name="bs_cover<?php  echo $i ?>" type="text" class="input_numerico" id="bs_cover<?php  echo $i ?>" size="10" value="<?php  echo ($fila[3])?>"  readonly="readonly" />
            </div></td>
            <td width="233" height="25"><div align="center">
                <input name="total<?php  echo $i ?>" type="text" class="input_numerico" id="total<?php  echo $i ?>" size="10"  readonly="readonly" />
            </div></td>
          
        </tr>
        <?php  $i++;}
      ?>
		<tr><input name="posicion" type="hidden" class="input_numerico" id="posicion" size="10" value="<?php echo $i?>"/></td><td></td><td></td><td></td><td></td>
           <td  width="233" height="25" class="subSubTitulo2">
	<div align="center">
	SUB-Total
	</div>
	</td>
	<td width="233" height="25"><div align="center">
                <input name="acumulado" type="text" class="input_numerico" id="acumulado" size="10" readonly="readonly"/>
                <input name="acumulado_oculto" type="hidden" class="input_numerico" id="acumulado_oculto" size="10" value="0" readonly="readonly" />
            </div></td></tr>
                   <tr><td></td><td></td><td></td><td></td>
           <td  width="233" height="25" class="subSubTitulo2">
	<div align="center">
	I.V.A.
	</div>
	</td>
	<td width="233" height="25"><div align="center">
                <input name="iva" type="text" class="input_numerico" id="iva" size="10"readonly="readonly" />
                <input name="acumulado_iva" type="hidden" class="input_numerico" id="acumulado_iva" size="10" value="0" readonly="readonly" />
            </div></td></tr>
                   <tr><td></td><td></td><td></td><td></td>
           <td  width="233" height="25" class="subSubTitulo2">
	<div align="center">
	Total
	</div>
	</td>
	<td width="233" height="25"><div align="center">
                <input name="final" type="text" class="input_numerico" id="final" size="10" readonly="readonly"/>
                <input name="acumulado_final" type="hidden" class="input_numerico" id="acumulado_final" size="10" value="0" readonly="readonly" />
            </div></td></tr>
		</table>
		
		<?php 
		
	}
}	
		
?>
	
