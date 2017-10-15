<?php 
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php";
include "clases/clase_orden.php";
include "clases/clase_firma.php";
include "clases/clase_usuario.php";
include "clases/clase_resultado.php";
include "clases/clase_paciente.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<script>
function volver()
{	 
	 document.form1.action='firma_resultado.php';
	 document.form1.submit();
}
function Guardar(tipo)
{
  
  document.form1.action="guarda_resultado_firma.php";
  document.form1.submit();
}
function generar_pdf()
{
	document.form1.action='imprime_orden_pdf.php';
	document.form1.submit();
}
function firmar(c)
 {
   document.form1.xxx.value='69';
   document.form1.submit();
 }
</script>
</head>
<body>
<form name="form1" method="post">
<?php
  $usu=$_SESSION["cedu_usu"]; 
  if($_POST['xxx']=='69')
    {
	  $f=new firma('','','','','');
	  $firm=$f->chequea_firma_medico($usu);
	  if($firm!=false)
	   {
	    $co=explode('**',$firm);
		/* NUEVO */
		$be=$f->busca_examen($_POST['orden']);
		$rr=0;
		$ex=explode('-',$be);
		$xx=0;
		$err=0;
		while($ex[$rr]!='')
		 {
		   $nom='f'.$ex[$rr];
		  if($_POST[$nom])
		    {
		     $xx++;
			 $regf=$f->firma_resultado($_POST['orden'],$ex[$rr],$co[0],$co[1]);
		     if($regf!=true) 
	           $err=1;
			 }
		  $rr++;
		 }
		if($xx==0)
		  echo "<script>alert('Debe seleccionar algun examen para Firmar.');</script>";
		else   
		if($err==0)
		   echo "<script>alert('Resultado Firmado exitosamente.');</script>";
		else   
		   echo "<script>alert('Se produjo algun error intente de nuevo...');</script>";  
		
		/* FIN NUEVO */
	    
		}
	   else
	    echo "<script>alert('Ud no tiene firma registrada favor comunicarse con el Administrador del sistema.');</script>";	
	}
  $verif= new usuario($usu,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
  $datusu=$verif->buscar_usuario_perm();
  $datos=explode('**',$datusu);  
  $orden = $_POST['orden'];
  if($orden=='')
    $orden = $_GET['orden'];
  $ord= new orden($orden,'','','','','','');
  $dat=$ord->ver_orden();
  while ($row = mysql_fetch_row($dat))
  {
    $cedula=$row[4];
	$pac= new paciente($cedula,'','','','','','','','','','','','','','');
	$regp=$pac->buscar();
	$datosp=explode('**',$regp);  
   }   
  ?>
<input type="hidden" name="xxx" id="xxx" />  
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	  </tr>
	  <tr bgcolor="#E3E3C6">
		<td height="55" colspan="2" bgcolor="#E3E3C6">
		  <div align="left"><img src="imagenes/Logo1.png" /></div>
		</td>  
		<input name="orden" id="orden" type="hidden" value="<?php echo $orden; ?>"/>
		<td colspan="2" bgcolor="#E3E3C6"  class="texto">
		  <span class="textoN">FECHA</span>:  <?php echo date('d-m-Y'); ?><br>
		  <span class="textoN">ORDEN No. </span>: <?php echo $orden; ?><br>		  
		  <span class="textoN">CÉDULA</span>: <?php echo $cedula; ?><br>
		  <span class="textoN">NOMBRE</span>: <?php echo $datosp[2].' '.$datosp[3].' '.$datosp[4].' '.$datosp[5]; ?><br>
		  <span class="textoN">EDAD</span>: <?php echo calculaedad($datosp[10]);?><br>
		</td>
		</tr>
	    <tr>
		   <td height="3" colspan="4"><img src="imagenes/naranja.gif" width="100%" height="3" /></td>
	    </tr>
	    <tr>
		   <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	    </tr>
	    <tr> 
	  	   <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
	    </tr>
</table> 
<table width="800" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="7"><div align="center" class="titulofor">Bioanalista : <?php echo $datos[1]." ".$datos[2]." ".$datos[3]." ".$datos[4];  ?></div></td>
    </tr>
    <tr class="titulofor">
      <td height="30" colspan="7"><div align="center" class="titulofor">Resultados de la Orden No. <?php echo $orden;  ?></div></td>
    </tr>
	<tr class="textoN" class="titulorep">
	   <td >Perfil</td>
	   <td colspan="3" >Examen Solicitado: </td>
	   <td >Muestra:</td>	   
	   <td >Valor Referencia:</td>	   
	   <td >U. Medida:</td>
   	   <td >Firmar</td>	   
	</tr>
	<?php
	  $sw=0; 
      $resultadito=$ord->result_orden_new();
      if($resultadito!='')
	     {
		   if ($resultadito) 
			{
				$no=mysql_num_rows($resultadito);
				if($no!=0)
				{					
				    $cont=0;
					$swo=0;
					$vectexa="";
					$perf='';
					while ($row2 = mysql_fetch_row($resultadito))
					{   
					   $f=new firma('','','','','');
	                   $firm=$f->chequea_examen_firmado($orden,$row2[4]);
	                   if($firm==false)
					   {   
						if($row2[8]!=$perf)
						 {
						  if($perf!='')
						  {
						   $swo=1;
						 ?>
		 	                 <tr <?php echo $color;?>> 
	                           <td class="texto">Observaciones <?php echo $perf;?>:</td>
	                           <td class="texto" colspan="6" ><textarea <?php echo "name='obs".$perf."' id='obs".$perf."'";?> cols="90" rows="3" class="texto"><?php echo $inforesult[1];?></textarea></td>
	                         </tr>
			<?php             } 
						  $cont++;
						  $perf=$row2[8];
						  } 
						if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';						
						$status='&nbsp;';
						if($row2[6]=='N') $status='Pendiente';
						if($row2[6]=='M') $status='Guardado Incompleto'; 
		   			    ///////////////////////////////////////NUEVO//////////////////////////////////////////////////////////////////////
						$examen=$row2[4];					
						$rr= new resultado('',$orden,$examen,'','','','');
						$inforesult=$rr->ver_resultado();
	                    if($inforesult!=false)		                
	                      echo '<input name="idresulta'.$inforesult[2].'" id="idresulta'.$inforesult[2].'" type="hidden" value="'.$inforesult[2].'" />';
	                    $n=0;
						$exa=new examen($examen,'','','','','','','','');
		                $caractexa=$exa->consul_caract_examen();
		                $n=mysql_num_rows($caractexa);						
	?>	                <input name="canticar" id="canticar" type="hidden" value="<?php echo $n; ?>" />
	<?php
	  	  	            if($n!=0)
		                 {						 
				           if($n<=20)
				             {
					          $indi=0;
					          while ($row=mysql_fetch_array($caractexa))
					           { 
					            $indi=$indi+1;
					            if ($indi==1)
					             {
						          $tipoaux=$row[0];
					              }
					            else
					             {
						          if($tipoaux!=$row[0])
						          {
						           $band=1;
						           $tipoaux=$row[0];				
						           }
						          else 
						           $band=0;
					             }
					            if($band==1)
					           { ?>
					            <tr>
						          <td height="3" colspan="4"><img src="imagenes/morado.gif" width="100%" height="3" /></td>
					            </tr> 
	                        <?php	}
							 							       
							   if($row[7]!='CALCULADO'){ 	
							     $swo=2;?>
					           <tr class="texto" <?php echo $color;?>>
							      <td width="100"><?php echo $row2[8]."-".$row2[5];?></td>
						          <td colspan="2"><?php  echo $row[2];  ?> <input name="nombcar<?php echo $indi-1;?>" id="nombcar<?php echo $indi-1;?>" type="hidden" value="<?php echo $row[2];?>" /></td>
						         <td colspan="2">
						<?php  	 $resu= new resultado('',$orden,'','','','','');
						         $valo= $resu->consul_det_result($examen,$row[1]);	
						         if($row[5]==1)
						            { 	?> 
						             <select name="caract<?php echo $examen.$row[1];?>" id="caract<?php echo $examen.$row[1];?>" class="texto">
						                <option value="P" <?php if($valo[0]== 'P') echo 'selected'; ?> >Positivo</option>
						                <option value="N" <?php if($valo[0]== 'N') echo 'selected'; ?> >Negativo</option>
						             </select> 
						             <input name="ocucaract<?php echo $indi-1;?>" id="ocucaract<?php echo $indi-1;?>" type="hidden" value="caract<?php echo $row[1];?>" />
						             <input name="tabla<?php echo $row[1];?>" id="tabla<?php echo $row[1];?>" type="hidden" value="" />

						<?php			}
						           else
						            {
							         $valores=$exa->consul_valores_caract2($row[1],$valo[0]);
							         if($valores==false)
							            { 			?>
							            <input name="caract<?php echo $examen.$row[1];?>" id="caract<?php echo $examen.$row[1];?>" type="text" class="texto"  value="<?php echo $valo[0];  ?>" size="5" />
							            <input name="ocucaract<?php echo $indi-1;?>" id="ocucaract<?php echo $indi-1;?>" type="hidden" value="caract<?php echo $row[1];?>" />
							            <input name="tabla<?php echo $examen.$row[1];?>" id="tabla<?php echo $examen.$row[1];?>" type="hidden" value="" />
			<?php				
							            }
							         else
							          {							?>
							            <select name="caract<?php echo $examen.$row[1];?>" id="caract<?php echo $examen.$row[1];?>" class="texto" >								          
								          <?php echo $valores; ?>
							            </select>	
							            <input name="ocucaract<?php echo $indi-1;?>" id="ocucaract<?php echo $indi-1;?>" type="hidden" value="caract<?php echo $row[1];?>" />
							            <input name="tabla<?php echo $examen.$row[1];?>" id="tabla<?php echo $examen.$row[1];?>" type="hidden" value="slc_lista_Valores" />
<?php							           }
						             }
									 
						         $valoresref=$exa->consul_valores_ref($row[1],$datos[6],calculaedad($datos[5]));
						         $dato='';
						            if($valoresref!=false)
						             {echo '</td><td>';
									  while ($rowsa=mysql_fetch_array($valoresref))
					                  {
						             echo '</br>'.$rowsa[1].'-'.$rowsa[2].' ('.$rowsa[3].')';
						             $dato.=$valoresref[1].'-'.$valoresref[2];
									 }echo '</td><td>';
						             }
						            if($row[4]!=' ') 
						             {
						             echo ' ('.$row[4].')'; 
						             $dato.=' ('.$row[4].')';
						             }				 ?>
						             <input name="unime<?php echo $row[1];?>" id="unime<?php echo $row[1];?>" type="hidden" value="<?php echo $row[6];?>" />
						             <input name="datoscar<?php echo $indi-1;?>" id="datoscar<?php echo $indi-1;?>" type="hidden" value="<?php echo $dato;?>" />
						             <input name="tipocar<?php echo $indi-1;?>" id="tipocar<?php echo $indi-1;?>" type="hidden" value="<?php echo $row[0];?>" />
	                               </td>
							<?php  if($examen!=$sw)
						           {	$sw=$examen; ?>
								   <td align="center" bgcolor="#FF0000" rowspan="<?php=$n;?>"><input type="checkbox" name="<?php='f'.$examen;?>" id="<?php='f'.$examen;?>" /></td>
						     <?php     }?>
					            </tr>
								
			<?php 	            
			 	           }}} 
						   }						   	  
				    ///////////////////////////////////////FIN DE NUEVO///////////////////////////////////////////////////////////////	   
					   }// fin de if($firm!=false
					 } // Fin del while
					 echo '<input name="vexa" id="vexa" type="hidden" value="'.$vectexa.'" />';				
			    } // Fin de else si no hay resultados
		    } // Fin del if result		
		 }
      else  
	     echo '<script>volver();</script>';
	  if($swo>1)
	    {?>
		  <tr <?php echo $color;?>> 
	         <td class="texto">Observaciones <?php echo $perf;?>:</td>
	         <td class="texto" colspan="3" ><textarea <?php echo "name='obs".$perf."' id='obs".$perf."'";?> cols="90" rows="3" class="texto"><?php echo $inforesult[1];?></textarea></td>
	      </tr>
		<?php }
		if($swo==0) echo '<script>volver();</script>';?>
	<tr>
	   <td height="30" colspan="7"><div align="center">	      
	  <img src="imagenes/firmar.jpg" alt="firmar" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="firmar(<?php=$orden;?>);" 
	  onmouseover="this.src='imagenes/firmar2.jpg'"  
	  onmouseout="this.src='imagenes/firmar.jpg'"/></div>
	   </td>
	</tr>
    <tr>
      <td height="30" colspan="7"><div align="center">
	  <input name="orden" id="orden" type="hidden" value="<?php echo $orden; ?>" />
	  <img src="imagenes/p_guardar1.gif" alt="Guardar Resultado" width="130" height="50" 
	  style="cursor:hand" 
	  onclick="Guardar('G');" 
	  onmouseover="this.src='imagenes/a_guardar1.gif'"  
	  onmouseout="this.src='imagenes/p_guardar1.gif'"/>
	  
	  <img src="imagenes/p_imprimir1.gif" alt="Imprimir Resultados" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="generar_pdf();" 
	  onmouseover="this.src='imagenes/a_imprimir1.gif'"  
	  onmouseout="this.src='imagenes/p_imprimir1.gif'"/>
	  
	  <img src="imagenes/p_salir1.gif" alt="Salir" width="140" height="50" 
	  style="cursor:hand" 
	  onclick="volver();" 
	  onmouseover="this.src='imagenes/a_salir1.gif'"  
	  onmouseout="this.src='imagenes/p_salir1.gif'"/>
	  
	    </div>
	    </td>
	  </tr>
  </table>
</form>
</body>
</html>
