<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
include "clases/clase_orden.php";
include "clases/clase_visita.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orden de Laboratorio</title>
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script>
function volver()
{
	document.form1.action='lista_orden.php';
	document.form1.submit();
}

function generar_pdf()
{
	document.form1.action='orden_pdf.php';
	document.form1.submit();
}
function findPrinter() {
         var applet = document.jzebra;
         if (applet != null) {            
            applet.findPrinter("LP2824");
         }         
         monitorFinding();
      }
      function printZPLImage(a,b,c) {  	  
         var applet = document.jzebra;
		 var ced = "A21,77,0,4,1,1,N,\"CEDULA : "+a+"\"\n";
		 var nom = "A20,115,0,4,1,1,N,\"NOMBRE : "+b+"\"\n";
		 var orden ="B21,150,0,1,6,18,60,B,\""+c+"\"\n";
		 var barra = "A164,20,0,4,2,2,N,\""+c+"\"\n";
		 
         if (applet != null) {
            applet.append("I8,A,001\n");
            applet.append("\n");
			applet.append("\n");
			applet.append("Q405,024\n");
			applet.append("q448\n");
			applet.append("rN\n");
			applet.append("S4\n");
			applet.append("D7\n");
			applet.append("ZT\n");
			applet.append("JF\n");
			applet.append("O\n");
			applet.append("R0,0\n");
			applet.append("f100\n");
			applet.append("N\n");
			applet.append("A22,29,0,4,1,1,N,\"ORDEN : \"\n");
			applet.append(orden);
			applet.append(ced);
			applet.append(nom);
			applet.append(barra);

            while (!applet.isDoneAppending()) {
	      
	         }           
		    applet.append("P1\n");
            findPrinter();
            applet.print();
	       }
	 monitorPrinting();
      }
 function monitorPrinting() {
	var applet = document.jzebra;
	if (applet != null) {
	   if (!applet.isDonePrinting()) {
	      window.setTimeout('monitorPrinting()', 100);
	   } else {
	      var e = applet.getException();
            if(e != null  ) 
	      alert("Exception occured: " + e.getLocalizedMessage());
	   }
	} else {
            alert("Applet not loaded!");
        }
      }
 function monitorFinding() {
	var applet = document.jzebra;
	if (applet != null) {
	   if (!applet.isDoneFinding()) {
	      window.setTimeout('monitorFinding()', 100);
	   } else {
	      var printer = applet.getPrinter();
		  if(printer == null)
              alert("La impresora esta apagada o no esta configurada..");
	   }
	} else {
            alert("Applet not loaded!");
        }
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

function desplega(pf)
{
  if(document.getElementById("per"+pf).style.display=="none")
		document.getElementById("per"+pf).style.display="block";
  else  
  		document.getElementById("per"+pf).style.display="none";

}


function sumarexaper(pf,exa)
{
	var perfil='maxexaper'+String(pf);
	document.getElementById(perfil).value=exa;
}

function sumarper(pf)
{
	document.getElementById('maxper').value=pf;
	//alert(document.getElementById('maxper').value);
}


function marcarexa(pf)
{
	 var perfil='perfil'+String(pf);
	 var montoperf='ocumontoper'+String(pf);
	 var ind=1;
	 var maxperfil='maxexaper'+String(pf);
	 var cantiexa=document.getElementById(maxperfil).value;
	 
	 if(document.getElementById(perfil).checked==true)
	 {       
			 document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)+parseFloat(document.getElementById(montoperf).value);
			 while(ind<=cantiexa)
			 {
				if (document.getElementById('examen'+String(pf)+'**'+String(ind)).checked==true)
				{
					document.getElementById('examen'+String(pf)+'**'+String(ind)).click();
				}
				document.getElementById('examen'+String(pf)+'**'+String(ind)).checked=true;
				document.getElementById('examen'+String(pf)+'**'+String(ind)).disabled=true;
				ind++;
			 }
	 }
	 else
	 {
	 		 //alert('resta perfil y desmarca todos');
			 document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)-parseFloat(document.getElementById(montoperf).value);
			 while(ind<=cantiexa)
			 {
				if (document.getElementById('examen'+String(pf)+'**'+String(ind)).checked==true)
				{
				    document.getElementById('examen'+String(pf)+'**'+String(ind)).checked=false;
				}
				document.getElementById('examen'+String(pf)+'**'+String(ind)).disabled=false;
				ind++;
			 }
	 }
}

function cuenta(pf,exa,m)
{
  if (document.getElementById('examen'+String(pf)+'**'+String(exa)).checked==false)
  {
		document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)-parseFloat(m);
  }
  if (document.getElementById('examen'+String(pf)+'**'+String(exa)).checked==true)
  {
		document.getElementById('monto').value=parseFloat(document.getElementById('monto').value)+parseFloat(m);
  }
  
}
function agregar()
{  	
    var sw=0;
	var perles=document.getElementById('maxper').value;
	var indper=1;
	while(indper<=perles)
	{
	   var ind=1;
	   var maxperfil='maxexaper'+String(indper);
	   var cantiexa=document.getElementById(maxperfil).value;	   	   
	   while(ind<=cantiexa)
	   {
			if (document.getElementById('examen'+String(indper)+'**'+String(ind)).checked==true)
			{  		    
				document.getElementById('examen'+String(indper)+'**'+String(ind)).disabled=false;
				 sw++;
			}			
			ind++;
	   }   
	   indper++;
	}	 
	if(sw=='0')
	  alert('Debe seleccionar un examen nuevo almenos... ');
	else
	 {
      document.getElementById('agreg').value='1';	  
	  document.form1.submit();  
	  }
}
function eliminar()
{ 
document.getElementById('elim').value='1';
document.form1.submit();
}

</script>
<body>

<form name="form1" id="form1" method="post" action="">
<?php  
   $ord= new orden('','','','','','','');  
   if($_POST['guar']==1)
    { 	$ordenver=$gua;	}
	else
	{	$ordenver=$_GET['orden'];
	    $ced=$_GET['ced']; 
     }
	
	$paci=$ord->consul_pac($ced);
	if($paci)
	{$datos=explode('/*',$paci); 
		 if($datos[6]=='F')
		   $sexo='Femenino';
		 else
		   $sexo='Masculino';	
     }

   if($_POST['agreg']==1)
    {
	   $perles=$_POST['maxper'];
	   $indper=1;
	   while($indper<=$perles)
	   {
	     $ind=1;
	     $maxperfil='maxexaper'.$indper;
	     $cantiexa=$_POST[$maxperfil];	   	   
		 echo "<script>alert(".$maxperfil.'-'.$cantiexa.");</script>";
	     while($ind<=$cantiexa)
	      {
		    $no='examen'.$indper.'**'.$ind;			
			if (isset($_POST[$no]))
			{   $nn='ocuexamen'.$indper.'**'.$ind;
	   		    $pp='ocuprecio'.$indper.'**'.$ind;
				$con=$ord->consulta_examen_orden($ordenver,$_POST[$nn]);
				if($con==false){
				  $er=$ord->ins_det_orden_new($ordenver,$_POST[$nn],$_POST[$pp]);
				  if($er==false)
				    echo "<script>alert('Se produjo un error registrando un examen intente de nuevo');</script>";}
				else  
				  echo "<script>alert('La orden ya tiene incluido ".$con."');</script>";
			}			
			$ind++;
	   }   
	   $indper++;
	}
		echo "<script>alert('agregado');</script>";
	}
   if($_POST['elim']==1)
    {
	$ord->id=$ordenver;
	$result=$ord->ver_orden();	
	if ($result) 
	{ 		
	  $m=0;		
	  $n=0;
	  while ($row = mysql_fetch_row($result))
		{  			
			$nom='reg'.$row[0];
			if(isset($_POST[$nom])){
			  $m++; 
			  $el=$ord->elimina_examen($ordenver,$row[0]);
			  if($el=='2') $n++;}
		} 
	 if($m>0)
	    if($n>0)
		  echo "<script>alert('Al menos un examen no pudo eliminarse porque tiene resultado..');</script>";
		else
		  echo "<script>alert('Eliminados ".$m."');</script>";
	 else 	
	    echo "<script>alert('Debe seleccionar algun examen para eliminar..');</script>";
	}
 }
 ?>
 <input type="hidden" name="ingreso" value="1" />
<input type="hidden" name="agreg" id="agreg" value="0" />
<input type="hidden" name="elim" id="elim" value="0" />

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr bgcolor="#E3E3C6">
    <td height="55" bgcolor="#E3E3C6" ><div align="left"><img src="imagenes/Logo1.png" /></div>
	  </td>
    <td bgcolor="#E3E3C6" class="texto">
	  <span class="textoN">FECHA</span>:  <?php  echo date('d-m-Y'); ?><br>
	  <span class="textoN">CÉDULA: <?php  echo $ced; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php  echo $ced; ?>" />
	  <input name="idpac" type="hidden" id="idpac" value="<?php  echo $_POST['idpac']; ?>"/>
	  <br>
      <span class="textoN">NOMBRE</span>: <?php  echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?><input name="nombre" id="nombre" type="hidden" value="<?php  echo  $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?>" /><br>
	  <span class="textoN">EDAD</span>: <?php  echo calculaedad($datos[5]); ?><input name="edad" id="edad" type="hidden" value="<?php  echo $_POST['edad']; ?>" /><br>
	  <span class="textoN">SEXO</span>: <?php  echo $sexo; ?><input name="sexo" id="sexo" type="hidden" value="<?php  echo $_POST['sexo']; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php  echo $_POST['sexonom']; ?>" /><br>
	  <span class="textoN">EMPRESA</span>: <?php  echo $datos[8]; ?><input name="empresa" id="empresa" type="hidden" value="<?php  echo $_POST['empresa']; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php  echo $_POST['empresanom']; ?>" /><br>
	  <span class="textoN">ORDEN No. </span>: <?php  echo $ordenver; ?><input name="orden" id="orden" type="hidden" value="<?php  echo $ordenver; ?>" />
	</td>
    </tr>
	  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td colspan="2" ><?php  
	$ord->id=$ordenver;
	$result=$ord->ver_orden();
	
	if ($result) 
	{ 
		$monto=0; ?>
		<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr class="titulorep">
				<td width="600">EXAMEN</td>
				<td width="100">MONTO</td>
			  </tr>
<?php 		
		$monto2=0;
		while ($row = mysql_fetch_row($result))
		{  ?>
			<tr class="texto">
				<td align="left"><input type="checkbox" name="<?php  echo 'reg'.$row[0];?>" /><?php  echo $row[1]; ?></td>
				<td align="right">&nbsp;<?php  echo $row[2]; ?></td>
			</tr>
<?php 			$monto=$monto+(float)$row[2];
            $monto2=$row[7];
		} ?>
		<tr class="textoN">
			<td align="left" class="textoN">Total</td>
			<td align="right" class="textoN"><?php  echo $monto2; ?></td>
		</tr>
		</table>
<?php 	} ?>
	</td>
  </tr>
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="center" class="td-buttons">  
    	<a href="#" onclick="agregar();" class="button-add" alt="Agregar"  > <i class="fa fa-plus" aria-hidden="true"></i> Agregar </a>
    	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>
    	<a href="#" onclick="generar_pdf();" class="button-print" alt="Imprimir"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a>
		<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="50px" height="50px">
         <param name="printer" value="zebra">
       </applet>
		<img src="imagenes/tag.png" alt="Imprimir Etiqueta"  
	  	style="cursor:hand" 
	 	 onclick="printZPLImage(document.form1.cedula.value,document.form1.nombre.value,document.form1.orden.value)" 
	  	onmouseover="this.src='imagenes/tag.png'"  
	  	onmouseout="this.src='imagenes/tag.png'"/>
	 <?php  if($_POST['visita']!='') { ?>
	   <a href="#" onclick="window.close();" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>	</td>
	 <?php  } else{ ?>
	    <a href="#" onclick="volver();" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></td>
	 <?php  } ?>
	 
  </tr>
  <tr>
    <td colspan="2" ><?php  
	echo $ord->perfil_exa(); ?>
	
	</td>
  </tr>
</table>

</form>
</body>
</html>
