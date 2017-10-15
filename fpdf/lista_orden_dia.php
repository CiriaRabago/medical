<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
include "clases/clase_medico.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_usuario.php";
include "clases/clase_paciente.php";
$conexion=Conectarse(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
var x=0;
function posicion()
{
document.getElementById('cedula').focus();
}


function soloNumerico(obj){ 
var tecla = window.event.keyCode;
	if ( tecla < 10 ) {
        return true;
    }
    if ( tecla != 46 && (tecla < 48 || tecla > 59) ) 
	{
	   window.event.keyCode=0;
    } else {
        return true;
    }
}

function validar()
{  
	if(document.getElementById("servicio").value!='0')
	{
		if(document.getElementById("fna1").value!='' && 
		   document.getElementById("fna2").value!='' && 
		   document.getElementById("fna3").value!='')
			document.form1.ocu_fi.value=document.getElementById("fna3").value+'-'+document.getElementById("fna2").value+'-'+document.getElementById("fna1").value; 
		else
		{
			if(document.getElementById("fna1").value=='' || 
			   document.getElementById("fna2").value=='' || 
			   document.getElementById("fna3").value=='')
			   {	alert('Debe ingresar todos los datos de la fecha Desde');
				    return false;
			    }
		}
		
		if(document.getElementById("fnf1").value!='' && 
		   document.getElementById("fnf2").value!='' && 
		   document.getElementById("fnf3").value!='')
			document.form1.ocu_ff.value=document.getElementById("fnf3").value+'-'+document.getElementById("fnf2").value+'-'+document.getElementById("fnf1").value; 
		else
		{
			if(document.getElementById("fnf1").value=='' || 
			   document.getElementById("fnf2").value=='' || 
			   document.getElementById("fnf3").value=='')
			{	alert('Debe ingresar todos los datos de la fecha Hasta');
				return false;
			}
		}
		
		
		document.getElementById("ingreso").value=1;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		document.form1.submit();
	}
	else
	{
		var cadena='';
		var union=0;
		if(document.getElementById("servicio").value=='0') { cadena="Servicio"; union=1; }
		alert('Debe seleccionar: '+cadena);
	}
}

function ir_orden_pac(val)
{
  if(val=='S')
  {
		   document.form1.action="orden_pac.php";
		   document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		   document.form1.submit();
  }
  else
  {
    alert('Usuario no Registrado');
  }

}

function soloNumeros(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  		alert("Solo se permiten números en este campo.");
 		return false;
  	}
	return true;
}

function irpdf(pag)
{
	document.form1.action=pag;
	document.form1.submit();
}

function ver1()
{
	if (document.getElementById("fna3").value<1850)
		alert("Año de Inicio Erroneo");
		document.form1.submit();
}
function ver2()
{
	if (document.getElementById("fnf3").value<1850)
		alert("Año de Fin Erroneo");
		document.form1.submit();
}

function inac_vis(visit)
{
	if(confirm("¿Desea Eliminar el registro Seleccionado?"))
	{
		document.getElementById("elimvis").value=visit;
		document.getElementById('cargar').innerHTML = "<img src='imagenes/loader.gif' />";
		document.form1.submit();
	}
}

</script>
<body>
<form name="form1" id="form1" method="post" action="lista_orden_dia.php">
            <input name="ingreso" id="ingreso" type="hidden" value="0" />
			<table width="700" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="5"><div align="center" class="titulofor">Listado de Ordenes Laboratorio </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="5">
				<table width="690" border="0" cellpadding="0" cellspacing="0">
                  <tr class="textoN">
                    <td width="160" height="22">DESDE</td>
                    <td width="160">HASTA</td>
                    <td colspan="3" align="center">SERVICIO</td>
                  </tr>
                  <tr>
                    <td>
					<?php  
					   if($_POST['fna3']==''){
					   $fecha=gmdate("d-m-Y", time() + $zone);
					   $dia1=substr($fecha,0,2); 
					   $mes1=substr($fecha,3,2); 
					   $ano1=substr($fecha,6,4);
					   $dia2=substr($fecha,0,2); 
					   $mes2=substr($fecha,3,2); 
					   $ano2=substr($fecha,6,4);
					   } 
					   else{
					    $dia1=$_POST['fna1'];
						$mes1=$_POST['fna2'];
						$ano1=$_POST['fna3'];
						$dia2=$_POST['fnf1'];
						$mes2=$_POST['fnf2'];
						$ano2=$_POST['fnf3'];
					   }
					   ?>
					<select name="fna1" class="texto" id="fna1" onchange="submit()" >
                       <option value="">--</option>
		               <?php for($x=1;$x<32;$x++)
					      { if($x<10)$x='0'.$x; 
					        if($x==$dia1)
		                      echo "<option value='".$x."' selected>".$x."</option>";
							else 
							  echo "<option value='".$x."'>".$x."</option>";
						   }?>         
                    </select>
		                 /
                    <select name="fna2" class="texto" id="fna2" onchange="submit()">
                       <option value="">--</option>
					   <?php for($x=1;$x<13;$x++)
		                   {if($x<10)$x='0'.$x; 
					        if($x==$mes1)
		                      echo "<option value='".$x."' selected>".$x."</option>";
							else 
							  echo "<option value='".$x."'>".$x."</option>";
						   }?>         
                     </select>
                         /
<input name="fna3" type="text" class="texto" id="fna3" onChange="ver1()" onkeypress='return soloNumeros(event)' size="4" maxlength="4" value="<?php echo $ano1;?>">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_fi" id="ocu_fi" type="hidden" value="" />
					</td>
                    <td>
					<select name="fnf1" class="texto" id="fnf1" onchange="submit()">
                        <option value="">--</option>
		                <?php for($x=1;$x<32;$x++){
						    if($x<10)$x='0'.$x; 
					        if($x==$dia2)
		                      echo "<option value='".$x."' selected>".$x."</option>";
							else 
							  echo "<option value='".$x."'>".$x."</option>";
						   }?>         
                    </select>
		                /
                    <select name="fnf2" class="texto" id="fnf2" onchange="submit()">
                       <option value="">--</option>
                       <?php for($x=1;$x<13;$x++){
					        if($x<10)$x='0'.$x; 
					        if($x==$mes2)
		                      echo "<option value='".$x."' selected>".$x."</option>";
							else 
							  echo "<option value='".$x."'>".$x."</option>";
						   }?>         
                    </select>
                       /
<input name="fnf3" type="text" class="texto" id="fnf3" onChange="ver2()" onkeypress='return soloNumeros(event)' size="4" maxlength="4" value="<?php echo $ano2;?>">

<span class="Estilo2"><strong>d&iacute;a/mes/a&ntilde;o </strong></span>
<input name="ocu_ff" id="ocu_ff" type="hidden" value="" />					
					</td>
                    <td colspan="3" align="center">
						<select name="servicio" class="texto" id="servicio" >
						  <option value="0" selected="selected" >SELECCIONE --></option>
						  <option value="1" >Fecha y Hora</option>
						  <option value="2" >Perfil Examen</option>
						  <?php						    
							$sql="select abrev_examen                                    
                                   from slc_orden,                                       
                  					    slc_det_orden,                                   
                                        slc_examen_perfil,                               
                                        slc_examen,                                      
                                        slc_perfil                                       
                                   where slc_orden_id_orden= id_orden                    
               						 and year(fecha_ing_orden)>='".$_POST['fna3']."'                      
			   						 and year(fecha_ing_orden)<='".$_POST['fnf3']."'                      
               						 and month(fecha_ing_orden)>='".$_POST['fna2']."'                       
			   						 and month(fecha_ing_orden)<='".$_POST['fnf2']."'                       
               						 and day(fecha_ing_orden)>='".$_POST['fna1']."'                         
			   						 and day(fecha_ing_orden)<='".$_POST['fnf1']."'                         
               						 and slc_det_orden.slc_examen_id_examen=id_examen      
               						 and id_perfil = slc_perfil_id_perfil                  
               						 and tipo_perfil='A'                                   
         					         and id_examen = slc_examen_perfil.slc_examen_id_examen
              						 group by abrev_examen
			  						 order by abrev_examen";		 							
									 
							$result=mysql_query($sql,$conexion);
							while ($row = mysql_fetch_row($result))
							 {
							   echo "<option value='".$row[0]."' >".$row[0]."</option>";
							  }		 
						  ?>
   					    </select>
						<?php //echo "aca ".$sql;?>
					</td>
				  <tr>
				    <td class="textoN" colspan="2">Desde la Orden :<input type="text" class="texto" name="noi" id="noi" value="<?php echo $_POST['noi'];?>" /></td>
					<td class="textoN" colspan="2">Hasta la Orden :<input type="text" class="texto" name="nof" id="nof" value="<?php echo $_POST['nof'];?>" /></td>
				  </tr>	                    
                  </tr>
				  <tr>
                    <td height="19">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="174">&nbsp;
					</td>
                    <td width="74">&nbsp;</td>
                    <td>&nbsp;</td>
				  </tr>

                  
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" class="textoN">&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			
			<tr>
			  <td colspan="5"><div id="cargar" align="center">
				<img src="imagenes/p_buscar1.gif" alt="Buscar" 
				width="140" height="50" style="cursor:hand" onclick="validar()" 
				onmouseover="this.src='imagenes/a_buscar1.gif'"  onmouseout="this.src='imagenes/p_buscar1.gif'"/></div>
				<input name="orden" id="orden" type="hidden" value="0" />
			   </td>
			</tr>
		  </table>
</form>
<?php
  if($_POST['ingreso']=='1')
  {
    /*echo "<script>alert('".$fna1."-".$fna2."-".$fna3."-".$fnf1."-".$fnf2."-".$fnf3."-".$servicio."');</script>";
	*/
	$f1=$_POST['fna1']."-".$_POST['fna2']."-".$_POST['fna3'];
    $f2=$_POST['fnf1']."-".$_POST['fnf2']."-".$_POST['fnf3'];
	if ($_POST['servicio']=='1')
	 {	   
	   $sql="select id_orden,                                      
                    slc_paciente_id_paciente,                      
                    fecha_ing_orden,                               
                    slc_examen_perfil.slc_examen_id_examen,        
                    slc_examen_perfil.id_examen_perfil,            
                    slc_perfil_id_perfil,                          
                    nomb_examen,                                   
                    nomb_perfil                                    
             from slc_orden,                                       
                  slc_det_orden,                                   
                  slc_examen_perfil,                               
                  slc_examen,                                      
                  slc_perfil                                       
             where slc_orden_id_orden= id_orden                    
               and year(fecha_ing_orden)>='".$_POST['fna3']."'                      
			   and year(fecha_ing_orden)<='".$_POST['fnf3']."'                      
               and month(fecha_ing_orden)>='".$_POST['fna2']."'                       
			   and month(fecha_ing_orden)<='".$_POST['fnf2']."'                       
               and day(fecha_ing_orden)>='".$_POST['fna1']."'                         
			   and day(fecha_ing_orden)<='".$_POST['fnf1']."'                         
               and slc_det_orden.slc_examen_id_examen=id_examen      
               and id_perfil = slc_perfil_id_perfil                  
               and tipo_perfil='A'                                   
               and id_examen = slc_examen_perfil.slc_examen_id_examen
			  order by fecha_ing_orden";
			  //echo $sql;
		?>
		<table align="center">		   
		<tr><td colspan="5"><div align="center" class="titulofor">Listado de Ordenes Laboratorio del <?php echo $f1." al ".$f2;?> </div></td></tr>
		<tr class="titulorep"><td>ORDEN</td><td>PACIENTE</td><td>FECHA ORDEN</td><td>EXAMEN</td><td>PERFIL</td></tr>
		<?php
		  
		  $result=mysql_query($sql,$conexion);
		  $cont=1;
		  $orden=0;
		  while ($row = mysql_fetch_row($result))
		   {
		     if($orden!=$row[0])
			 {
		      if ($cont%2!=0 )$color='bgcolor="#E3E3E6"'; else $color='';
		      $orden=$row[0];
			  $cont++;
			  $cont2=0;
			 }
			  
		     echo "<tr class='texto' ".$color." >";
			 if($cont2=='0')
			  {
			   echo    "<td>".$row[0]."</td>
				  	    <td>".$row[1]."</td>
					    <td>".$row[2]."</td>";
			   }
			 else  
			 echo    "<td colspan='3'>&nbsp;</td>";
					  $cont2++;
			 echo    "<td>".$row[6]."</td>
					  <td>".$row[7]."</td>
			       </tr>";
		    }
			if($cont>1){
			?>
			<tr><td colspan="5" align="center"><img src="imagenes/p_imprimir1.gif" alt="Imprimir" 
				width="140" height="50"  style="cursor:hand" onclick="irpdf('listado_ord_pdf.php?fi=<?php echo $_POST['ocu_fi'];?>&ff=<?php echo $_POST['ocu_ff'];?>&serv=<?php echo $_POST['servicio'];?>')" 
				onmouseover="this.src='imagenes/a_imprimir1.gif'"  onmouseout="this.src='imagenes/p_imprimir1.gif'"/></td></tr>
			<?php	}
			else
			 {?>
			 <tr><td colspan="5" align="center" class="texto" bgcolor="#FF9999">NO EXISTEN REGISTROS EN ESA FECHA..</td></tr>
			  <?php }		
		  echo "</table>";	  
	  }
	if ($_POST['servicio']=='2')
	 {
	   $sql="select id_orden,                                      
                    slc_paciente_id_paciente,                      
                    fecha_ing_orden,                               
                    slc_examen_perfil.slc_examen_id_examen,        
                    slc_examen_perfil.id_examen_perfil,            
                    slc_perfil_id_perfil,                          
                    nomb_examen,                                   
                    nomb_perfil                                    
             from slc_orden,                                       
                  slc_det_orden,                                   
                  slc_examen_perfil,                               
                  slc_examen,                                      
                  slc_perfil                                       
             where slc_orden_id_orden= id_orden                    
               and year(fecha_ing_orden)>='".$_POST['fna3']."'                      
			   and year(fecha_ing_orden)<='".$_POST['fnf3']."'                      
               and month(fecha_ing_orden)>='".$_POST['fna2']."'                       
			   and month(fecha_ing_orden)<='".$_POST['fnf2']."'                       
               and day(fecha_ing_orden)>='".$_POST['fna1']."'                         
			   and day(fecha_ing_orden)<='".$_POST['fnf1']."'                         
               and slc_det_orden.slc_examen_id_examen=id_examen      
               and id_perfil = slc_perfil_id_perfil                  
               and tipo_perfil='A'                                   
               and id_examen = slc_examen_perfil.slc_examen_id_examen
			  order by nomb_perfil";
			  //echo $sql;
		?>
		<table align="center">		   
		<tr><td colspan="4"><div align="center" class="titulofor">Listado de Ordenes Laboratorio del <?php echo $f1." al ".$f2;?> </div></td></tr>		
		<?php
		  $conexion=Conectarse(); 
		  $result=mysql_query($sql,$conexion);
		  $cont=1;
		  $orden=0;
		  $perfil="";
		  while ($row = mysql_fetch_row($result))
		   {
		     if($perfil!=$row[7])
			 {
			 if ($cont%2!=0 )$color='bgcolor="#E3E3E6"'; else $color='';
		      $perfil=$row[7];
			  $cont++;
			  $cont2=0;
			  echo "<tr><td colspan='4'><div align='center' class='titulofor'>ORDENES DE PERFIL  ".$perfil." </div></td></tr><tr class='titulorep'><td>ORDEN</td><td>PACIENTE</td><td>FECHA ORDEN</td><td>EXAMEN</td></tr>";
		      
			 }
			  
		     echo "<tr class='texto' ".$color." >";
			 echo    "<td>".$row[0]."</td>
			    	  <td>".$row[1]."</td>
					  <td>".$row[2]."</td>";
			   
					  $cont2++;
			 echo    "<td>".$row[6]."</td>
					  <td>".$row[7]."</td>
			       </tr>";
		    }
			if($cont>1){
			?>
			<tr><td colspan="5" align="center"><img src="imagenes/p_imprimir1.gif" alt="Imprimir" 
				width="140" height="50"  style="cursor:hand" onclick="irpdf('listado_ord_pdf.php?fi=<?php echo $_POST['ocu_fi'];?>&ff=<?php echo $_POST['ocu_ff'];?>&serv=<?php echo $_POST['servicio'];?>')" 
				onmouseover="this.src='imagenes/a_imprimir1.gif'"  onmouseout="this.src='imagenes/p_imprimir1.gif'"/></td></tr>
			<?php	}
			else
			 {?>
			 <tr><td colspan="5" align="center" class="texto" bgcolor="#FF9999">NO EXISTEN REGISTROS EN ESA FECHA..</td></tr>
			  <?php }		
		  echo "</table>";
	 }
	 if($_POST['servicio']!='1' && $_POST['servicio']!='2')
	 {
	    $cedusu=$_SESSION["cedu_usu"];
		$bus1= new usuario('','','','',$cedusu,'','','');
		$usua=$bus1->consulta_usu();
	    $ce1=explode('**',$usua);
		$condi=$ce1[8];
		$cond='';
		if($_POST['noi']<=$_POST['nof'] && $_POST['noi']!='' && $_POST['nof']!='')		
		   $cond=" and id_orden>=".$_POST['noi']." and id_orden<=".$_POST['nof']." ";
		if($_POST['servicio']=='SEROLOGIA')$xxx='ORDER BY nomb_examen,slc_orden.id_orden'; else $xxx='ORDER BY slc_orden.id_orden,orden_area';
	    $sql="SELECT           slc_orden.id_orden,
            				   slc_paciente_id_paciente, 
				               fecha_ing_orden, 
            				   nomb_examen, 
            				   abrev_examen,
							   usuario,   
            				   count(*)
					  FROM      slc_orden, 
            					slc_det_orden, 
            					slc_examen_perfil, 
            					slc_examen, 
            					slc_perfil 
					  WHERE   slc_orden_id_orden= id_orden 
    					  and year(fecha_ing_orden)>='".$_POST['fna3']."'                      
			   			  and year(fecha_ing_orden)<='".$_POST['fnf3']."'                      
               			  and month(fecha_ing_orden)>='".$_POST['fna2']."'                       
			   			  and month(fecha_ing_orden)<='".$_POST['fnf2']."'                       
               			  and day(fecha_ing_orden)>='".$_POST['fna1']."'                         
			   			  and day(fecha_ing_orden)<='".$_POST['fnf1']."' 
     					  and slc_det_orden.slc_examen_id_examen=id_examen 
     					  and id_perfil = slc_perfil_id_perfil 
     					  and tipo_perfil='A' 
     					  and id_examen = slc_examen_perfil.slc_examen_id_examen      
     					  and abrev_examen='".$_POST['servicio']."'".$cond." 
					  GROUP BY slc_orden.id_orden,nomb_examen 
					  ".$xxx;	
			  //echo $sql;
		?>
		<table align="center">		   
		<tr><td colspan="6"><div align="center" class="titulofor">Listado de Ordenes Laboratorio del <?php echo $f1." al ".$f2;?> </div></td></tr>		
		<?php	
		  $conexion=Conectarse(); 
		  $result=mysql_query($sql,$conexion);
		  $cont=0;
		  $orden=0;
		  $perfil="";
		  // if($perfil!=$row[7])
			 //{
			 if ($cont%2!=0 )$color='bgcolor="#E3E3E6"'; else $color='';
		      $perfil=$row[7];
			  $cont++;
			  $cont2=0;
			  echo "<tr><td colspan='6'><div align='center' class='titulofor'>ORDENES DE PERFIL  ".$_POST['servicio']." </div></td></tr><tr class='titulorep'><td>ORDEN</td><td colspan='2'>PACIENTE</td><td>Edad</td><td>FECHA ORDEN</td><td>EXAMEN</td></tr>";
		      
			 //}
		  while ($row = mysql_fetch_row($result))
		   {
		     $cont++;
		    
			 $bus1= new usuario('','','','',$row[5],'','','');
		     $usua=$bus1->consulta_usu();
	         $ce1=explode('**',$usua); 
			 if($ce1[8]==$condi || $condi=='1' || $row[2]<'2013-07-11 99:00:00')
			 {
			   $pac= new paciente($row[1],'','','','','','','','','','','','','','');
	           $regp=$pac->buscar();
	           $datosp=explode('**',$regp);
		       echo "<tr class='texto' ".$color." >";
			   echo    "<td>".$row[0]."</td>
			      	    <td>".$row[1]."</td>
						<td>".$datosp[2]." ".$datosp[3]." ".$datosp[4]." ".$datosp[5]."</td>
						<td>".calculaedad($datosp[10])."</td>						
					    <td>".$row[2]."</td>";			   
			   $cont2++;
			   echo    "<td>".$row[3]."</td>
					    <td>".$row[4]."</td>
			         </tr>";
			  }		 
		    }
			if($cont>0){
			?>
			<tr><td colspan="5" align="center"><img src="imagenes/p_imprimir1.gif" alt="Imprimir" 
				width="140" height="50"  style="cursor:hand" onclick="irpdf('listado_ord_pdf.php?fi=<?php echo $_POST['ocu_fi'];?>&ff=<?php echo $_POST['ocu_ff'];?>&serv=<?php echo $_POST['servicio'];?>')" 
				onmouseover="this.src='imagenes/a_imprimir1.gif'"  onmouseout="this.src='imagenes/p_imprimir1.gif'"/></td></tr>
			<?php	}
			else
			 {?>
			 <tr><td colspan="5" align="center" class="texto" bgcolor="#FF9999">NO EXISTEN REGISTROS EN ESA FECHA..</td></tr>
			  <?php }		
		  echo "</table>";
	   
	 } 
  }
?>
</body>
</html>
