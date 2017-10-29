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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Laboratorio</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<script>
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
		 var barra = "A164,20,0,4,2,2,N,\""+c+"\"\n"
		
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
              if(e != null)  
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

     
</script>
<body>

<form name="form1" id="form1" method="post" action="orden_pdf.php">

<?php   if($_POST['guar']==1)
    {
		$usuario=$_SESSION['cedu_usu'];
		$ord= new orden('',$_POST['idpac'],'',$_POST['empresa'],$_POST['monto'],'',$usuario);
		$gua= $ord->ins_orden();
		if ($gua)
		{
			$bandet=0;
			$perfil=$_POST['maxper'];
			for($i=1;$i<=$perfil;$i++)
			{
			   $exaper=$_POST['maxexaper'.$i];
			   for($j=1;$j<=$exaper;$j++)
			   {
			       if($_POST['examen'.$i.'**'.$j])
				   {
					   $guadet=$ord->ins_det_orden($_POST['ocuexamen'.$i.'**'.$j],$_POST['ocuprecio'.$i.'**'.$j]);
					   if ($guadet==false)
					   {  echo '<script>alert("Ocurrio un error al guardar la orden");</script>'; }
					   $bandet++;
				   }
			   }			   
			}
			$modor=$ord->mod_orden($gua,'','','','','','',$bandet,'');
			if($_POST['visita']!='')
			{
			   /*echo '<script>alert("trae visita");</script>';*/
			   $visit= new visita($_POST['visita'],'','','','','','','','','','','','');
			   $lbvis=$visit->ins_lab_visita($_POST['monto'],'','A');
			   if($lbvis==false)
			   	 echo '<script>alert("Ocurrio un error al asociar la orden a la visita");</script>';

			}
		}
		else
			echo '<script>alert("Ocurrio un error al guardar la orden");</script>';
			//die();
	}


if($_POST['guar']==1)
    { 	$ordenver=$gua;	}
	else
	{	$ordenver=$_POST['orden']; }

 ?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3" colspan="2"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>
  <tr bgcolor="#E3E3C6">
    <td height="55" bgcolor="#E3E3C6" ><div align="left"><img src="imagenes/Logo1.png" /></div>
	  </td>
    <td bgcolor="#E3E3C6" class="texto">
	  <span class="textoN">FECHA</span>:  <?php  echo date('d-m-Y'); ?><br>
	  <span class="textoN">CÉDULA: <?php  echo $_POST['cedula']; ?></span><input name="cedula" id="cedula" type="hidden" value="<?php  echo $_POST['cedula']; ?>" />
	  <input name="idpac" type="hidden" id="idpac" value="<?php  echo $_POST['idpac']; ?>"/>
	  <br>
      <span class="textoN">NOMBRE</span>: <?php  echo $_POST['nombre']; ?><input name="nombre" id="nombre" type="hidden" value="<?php  echo $_POST['nombre']; ?>" /><br>
	  <span class="textoN">EDAD</span>: <?php  echo $_POST['edad']; ?><input name="edad" id="edad" type="hidden" value="<?php  echo $_POST['edad']; ?>" /><br>
	  <span class="textoN">SEXO</span>: <?php  echo $_POST['sexonom']; ?><input name="sexo" id="sexo" type="hidden" value="<?php  echo $_POST['sexo']; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php  echo $_POST['sexonom']; ?>" /><br>
	  <span class="textoN">EMPRESA</span>: <?php  echo $_POST['empresanom']; ?><input name="empresa" id="empresa" type="hidden" value="<?php  echo $_POST['empresa']; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php  echo $_POST['empresanom']; ?>" /><br>
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
				<td align="left"><?php  echo $row[1]; ?></td>
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
    <td height="3" colspan="2" align="center">  
		<img src="imagenes/p_imprimir1.gif" alt="Imprimir Orden" width="140" height="50" 
	  	style="cursor:hand" 
	 	 onclick="generar_pdf();" 
	  	onmouseover="this.src='imagenes/a_imprimir1.gif'"  
	  	onmouseout="this.src='imagenes/p_imprimir1.gif'"/>
		<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="50px" height="50px">
         <param name="printer" value="zebra">
       </applet>
		<img src="imagenes/tag.png" alt="Imprimir Etiqueta"  height="50"
	  	style="cursor:hand" 
	 	 onclick="printZPLImage(document.form1.cedula.value,document.form1.nombre.value,document.form1.orden.value)" 
	  	onmouseover="this.src='imagenes/tag.png'"  
	  	onmouseout="this.src='imagenes/tag.png'"/>
	 <?php  if($_POST['visita']!='') { ?>
	    <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="window.close();" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>	</td>
	 <?php  } else{ ?>
	    <img src="imagenes/p_salir1.gif" alt="salir al men&uacute; de an&aacute;lisis" width="140" height="50" style="cursor:hand" onclick="top.mainFrame.location.href='servicio.php'" 
		onmouseover="this.src='imagenes/a_salir1.gif'"  onmouseout="this.src='imagenes/p_salir1.gif'"/>	</td>
	 <?php  } ?>
  </tr>
</table>

</form>
</body>
</html>
