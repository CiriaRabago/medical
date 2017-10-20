<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php";
include "clases/clase_examen.php";
include "clases/clase_perexa.php";
include "clases/clase_espec.php";
include "clases/clase_medico.php";
include "clases/clase_paciente.php";
include "clases/clase_cupos_cita.php";
include "clases/clase_cita.php";
include "clases/clase_feriado.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
-->
</style>
<?php 
$anoInicial = '2013';
$anoFinal = '2100';
$funcionTratarFecha = 'document.location = "?dia="+dia+"&mes="+mes+"&ano="+ano;';
?><script>
function mostrar(s)
 { 
  if(s!=1 || s=='')
  {   s=1;   
    document.form1.sw.value=1;
	document.getElementById("sw").value=1;}
else   { s=2; 
   document.form1.sw.value=2;
   document.getElementById("sw").value=2;}
   document.form1.submit(); 
   return s;
 }
function tratarFecha(dia,mes,ano){
  document.form1.fechas.value=dia+'-'+mes+'-'+ano;
  //document.getElementById("fecha").value=dia;
  <?=$funcionTratarFecha?>
  document.form1.submit();
}
</script>
<style>
.m1 {
   font-family:MS Sans Serif;
   font-size:8pt
}
a {
   text-decoration:none;
   color:#000000;
}
</style>

</head>
<script>
function ver()
{
 document.form1.submit();
}
function eliminar()
{  if (document.getElementById("espe").value!='0' && document.getElementById("exame").value!='0' && document.getElementById("cantida").value!='0')
	{	
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
			document.form1.ocu_e.value=1;
   			document.form1.submit();
		}
	}
	else
	  {	
		alert("Para Eliminar, Debe Seleccionar un registro de la lista");
	}

}
function Nuevo()
{  
	document.getElementById("perfil").value='0';
	document.getElementById("exame").value='0';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function Guardar()
{  
    var f = new Date();
	var dia , mes ,ano,fe;
	if (f.getDate()<10)
	   dia='0'+(f.getDate().toString());
	else
	   dia=f.getDate().toString();
	if (f.getMonth()<10)
	   mes='0'+(f.getMonth()+1).toString();
	else      
	   mes=(f.getMonth()+1).toString();
	ano=f.getFullYear().toString();   
    fe=ano+mes+dia;	
	if (document.getElementById("espe").value!='0' && document.getElementById("medi").value!='0' && document.getElementById("cedu").value!='' && document.getElementById("fechas").value!='')
	{
	    if(fe>document.getElementById("newf").value)
		   alert('La Cita debe ser con FECHA mayor a HOY..');
		else    
		   {document.form1.ocu_g.value=1;
   		    document.form1.submit();}
	}
	
	 if (document.getElementById("espe").value=='0' || document.getElementById("medi").value=='0' || document.getElementById("cedu").value=='' || document.getElementById("fechas").value=='')
	{
		alert("Falta ingresar Datos");
	}
}
function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("espe").value=trozos[3];
	document.getElementById("medi").value=trozos[4];	
	document.form1.ocu_N.value=trozos[4];
	document.form1.submit();
}
function busca()
{
	
	document.form1.submit();
}

</script>
<body>
<form id="form1" name="form1" method="post" action="gestion_citas.php">
<?php 
 $dia=substr($_POST['fechas'],0,2);
 $mes=substr($_POST['fechas'],3,2);
 $ano=substr($_POST['fechas'],6,4);
 $cit= new cita('','','',$_POST["cedu"],'');
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
   $fer= new feriado('',$dia,$mes,'');
   if($fer->buscar()==false)
    {
	  $nd=date("w",mktime(0,0,0,$mes,$dia,$ano));
	  $cu = new cupos('',$_POST["espe"],$_POST["medi"],'','','',''); 
	  $dial=$cu->buscar_dia_lab();
	  if($dial!=false)
	   {  
	     $nl=0;
	     if(substr($dial,($nd-1),1)=='0')
		  $nl=1;
		 }
	  if($nl=='0')
	   {	 
	    $bus=$cit->ver_cantidad($_POST["espe"],$_POST["medi"]);	
	    if ($bus!=false)
	     {   
	      $datoscupo=explode('**',$bus);
		  $gua=$cit->buscar_citas_fecha($_POST["espe"],$_POST["medi"],$_POST["fechas"]);			
		  if ($gua<$datoscupo[3] )
		    {
		     $cit= new cita('',$datoscupo[0],$_POST["fechas"],$_POST["cedu"],'0');
			 $va=$cit->validar_cita();
			 if($va==0)
			  {
			   $ins=$cit->ins_cita();	
			   $ms=$ins.";".$_POST['fechas'];		
			   if($ins!=false) 
			     echo '<script>alert("Cita registrada con numero '.$ins.' para el '.$_POST["fechas"].'");window.open("ticket.php?ms='.$ms.'","","toolbar=no,titlebar=no,scrollbars=no,menubar=no,location=no");</script>';
			   else
			     echo '<script>alert("Error insrtando cita. Intente nuevamente..");</script>';  
			   }
			   else
			   	 echo '<script>alert("Este paciente ya tiene una cita para este dia..");</script>';  
			 }
		   else
			   echo '<script>alert("Ya alcanzo el maximo de citas diarias intente otra fecha");</script>';
	       }
	      if ($bus==false)
	       echo '<script>alert("No existe cantidad de pacientes a a tender para ese doctor");</script>';
		 }
		 else  
		   echo '<script>alert("El doctor no labora este dia. seleccione otro...");</script>';
	}
  else
       echo '<script>alert("El dia seleccionado es feriado y no se labora. Seleccione otro..");</script>';	
  }
   if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' ) //para eliminar
	{			$gua=$cup->eliminar();
				if ($gua)
					echo '<script>alert("Registro Eliminado Exitosamente");</script>';
				else
					echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
			}
 ?>
  <table width="582" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Solicitud de Citas por Especialidad</div></td>
    </tr>
    <tr>
      <td width="139" class="etiqueta">Especialidad:</td>
      <td colspan="3" class="texto Estilo2"><label>
         <?php  $esp=new especialidad($_POST['espe'],'');
	        $listaperf=$esp->combo_esp(); ?>

          <select name="espe" class="texto" id="espe" onchange="ver();" >
			<option value="0">Seleccione---&gt;</option>
			<?php  if ($listaperf!=false) echo $listaperf;?>			
          </select>
		   <script> document.getElementById("perfil").value="<?php  echo $val; ?>"; </script>
          <span class="Estilo3">* </span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Doctor:</td>
      <td colspan="3"><label>  <?php  if($_POST["ocu_N"]!='0') $medi=$_POST["ocu_N"];?>
	  <select name="medi" class="texto"  id="medi" onchange="ver();">
		<option value="0">Seleccione---&gt;</option>
		<?php  
		$exa=new medico('','','','','','','','','','','','','','','');
	    $listaexa=$exa->combo_medico_new($_POST['espe'],$_POST['medi']);
		if ($listaexa!=false) echo $listaexa;?>
      </select>
      <input name="ocu_N" type="hidden" value="0"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Cedula del Paciente:</td>
      <td colspan="3"><label>	      
      <input name="cedu" id="cedu" type="text" value="<?=$_POST['cedu']?>" class="texto" onchange="busca()"/>
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
	<?php  if($_POST['cedu']!='')
	    {
		$pac= new paciente($_POST["cedu"],'','','','','','','','','','','','','','');
		$bus=$pac->buscar();
		$swi=0;
		if ($bus!='false')
		{	$swi=1;
			$dat=explode('**',$bus);			
			$nom=$dat[2].' '.$dat[3].' '.$dat[4].' '.$dat[5];		  
		?>
	<tr>
      <td class="etiqueta">Nombre y Apellidos :</td>
      <td colspan="3"><label>     
      <span class="texto Estilo2"><span class="Estilo3"><?php  echo $nom;?> </span> </span> </label></td>
    </tr>
     <?php  } }?>
	<tr>
      <td class="etiqueta">Fecha de la Cita:</td>
      <td colspan="3"><label>	      
	  <?php  $zone=(3600*-4.5); 
        $fec=gmdate("Y-m-d H:i:s", time() + $zone);
		$datos=explode('-',$fec);
		$fec=substr($datos[2],0,2).'-'.$datos[1].'-'.$datos[0];
		if($_POST['fechas']=='')$ff=$fec;
		else 
		 {
		 $fech=explode('-',$_POST['fechas']);
		 if(strlen($fech[0])==1)
		   $dia='0'.$fech[0]; else $dia=$fech[0];
		  if(strlen($fech[1])==1)
		   $mes='0'.$fech[1]; else $mes=$fech[1]; 
		 $ff=$dia.'-'.$mes.'-'.$fech[2];
		 $newf=$fech[2].$mes.$dia;}?>
	  <input type="hidden" id="sw" name="sw" value="0" />
	  <input type="hidden" id="newf" name="newf" value="<?=$newf;?>" />
      <input name="fechas" id="fechas" type="text" class="texto" value="<?php  echo $ff;?>" class="texto"/>
	  <img src="imagenes/boton_calendario.png" alt="Mostrar almanaque"  style="cursor:hand" onclick="mostrar('<?php  echo $_POST['sw'];?>')" 
		onmouseover="this.src='imagenes/boton_calendario.png'"  onmouseout="this.src='imagenes/boton_calendario.png'"/><br /><label class="etiqueta">dd-mm-aaaa</label>
		<!-- *********************almanaque **************************-->
		
             <?php  
               if($_POST['sw']==1)
			   { $_POST['sw']=1; ?><td colspan="2" width="200">
			<table border="0" cellpadding="5" cellspacing="0" bgcolor="#D4D0C8">
              <tr>
                <td width="100%">
			   <?php 
                 $fecha = getdate(time());
                 if(isset($_POST["dia"]))$dia = $_POST["dia"];
                 else $dia = $fecha['mday'];
                 if(isset($_POST["mes"]))$mes = $_POST["mes"];
                 else $mes = $fecha['mon'];
                 if(isset($_POST["ano"]))$ano = $_POST["ano"];
                 else $ano = $fecha['year'];
                 $fecha = mktime(0,0,0,$mes,$dia,$ano);
                 $fechaInicioMes = mktime(0,0,0,$mes,1,$ano);
                 $fechaInicioMes = date("w",$fechaInicioMes);				 
				 
                  ?>
                 <select size="1" name="mes" class="m1" onChange="mostrar('2')">
                 <?php 
                 $meses = Array ('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
                 for($i = 1; $i <= 12; $i++)
				 {
                    echo '      <option ';
                    if($mes == $i)echo 'selected ';
                    echo 'value="'.$i.'">'.$meses[$i-1]."\n";
                  }
                  ?>
                  </select>&nbsp;&nbsp;&nbsp;
				  <select size="1" name="ano" class="m1" onChange="mostrar('2')">
                  <?php 
                  for ($i = $anoInicial; $i <= $anoFinal; $i++)
				   {
                   echo '      <option ';
                   if($ano == $i)echo 'selected ';
                   echo 'value="'.$i.'">'.$i."\n";
                   } ?>
                  </select><br>
                  <font size="1">&nbsp;</font>
				  <table border="0" cellpadding="2" cellspacing="0" width="100%" class="m1" bgcolor="#FFFFFF" height="100%"> 
                    <?php 
                    $diasSem = Array ('L','M','M','J','V','S','D');
                    $ultimoDia = date('t',$fecha);
                    $numMes = 0;
                    for ($fila = 0; $fila < 7; $fila++)
					 {
                      echo "      <tr>\n";
                      for ($coln = 0; $coln < 7; $coln++)
					   {
                        $posicion = Array (1,2,3,4,5,6,0);
                        echo '        <td width="14%" height="19"';
                        if($fila == 0)echo ' bgcolor="#808080"';
                        if($dia-1 == $numMes)echo ' bgcolor="#0A246A"';
                        echo " align=\"center\">\n";
                        echo '        ';
                        if($fila == 0)echo '<font color="#D4D0C8">'.$diasSem[$coln];
                        elseif(($numMes && $numMes < $ultimoDia) || (!$numMes && $posicion[$coln] == $fechaInicioMes))
						 {
                          echo '<a href="#" onclick="tratarFecha('.(++$numMes).',document.form1.mes.value,document.form1.ano.value)">';
                          if($dia == $numMes)echo '<font color="#FFFFFF">';
                          echo ($numMes).'</a>';
                          }
                         echo "</td>\n";
                        }
                       echo "      </tr>\n";
                      }?>     
                    </table>
                  </td>
                </tr>
            </table></td><?php  }?>
		<!-- fin almanaque--> 
      <span class="texto Estilo2"><span class="Estilo3">* </span> </span> </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons" >
	      <a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>

      <input name="ocu_g" type="hidden" value="0"/>  <input type="hidden" name="ocu_e" value="0"/>  <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></td>
    </tr>
  </table>
 <?php  
    //if($_POST["exam"]!=0 && $_POST["espe"]!=0 && $_POST["cedu"]!='')
	 //{
	  //$dat=$cit->ver_cantidad($_POST["espe"],$_POST["exam"]); 
	  //$datos=explode('**',$dat); 
       $ver=$cit->ver_citas($_POST["espe"],$_POST["medi"],$ff);
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Examenes por Perfil');</script>";
		} 
		else
		{
		    echo $ver;
		}
	  //}	
	?>
</form>
</body>
</html>
