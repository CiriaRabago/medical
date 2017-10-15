<?php
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
//We've included ../Includes/FusionCharts_Gen.php, which contains FusionCharts PHP Class
//to help us easily embed the charts.
include("FusionCharts/Code/PHPClass/Includes/FusionCharts_Gen.php");
?>
<HTML>
<HEAD>
  <TITLE>
    FusionCharts Free - Simple Column 3D Chart 
  </TITLE>

  <?php
  //You need to include the following JS file, if you intend to embed the chart using JavaScript.
  //Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
  //When you make your own charts, make sure that the path to this JS file is correct. 
  //Else, you would get JavaScript errors.
  ?> 
  <SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/Code/FusionCharts/FusionCharts.js"></SCRIPT>
  <script>
  function buscapac()  
  {
    if(document.getElementById('cedula').value!="")
	{
	    document.getElementById('ingreso').value=1;
		document.form1.submit();
	}
	else
	   alert('Debe ingresar el Numero de Cedula');
  }
  
 
function activerhis()
{
  if(document.getElementById('caracts').value!=0)
  {
	  document.getElementById('verhis').style.display='block';
	  var indice = document.form1.caracts.selectedIndex;
	  var textoEscogido = document.form1.caracts.options[indice].text; 
	  var nomb=textoEscogido.split("-"); 
	  document.getElementById('nombcarocu').value=nomb[0];
	  //alert(textoEscogido);
  }
  else 
  {
    document.getElementById('verhis').style.display='none';
  }
} 
  function irhisto()
	{
		document.getElementById('ingreso').value=1;
		document.getElementById('mostrargrafi').value=1;
		document.form1.action="historial_pac.php";
		document.form1.submit();
	}
  </script>
  <link href="estilolab.css" rel="stylesheet" type="text/css">
  <link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</HEAD> 

<BODY>
<form name="form1" id="form1" method="post" action="historial_pac.php">
<?php
 if($_POST['ingreso']==1)
 {
    //echo 'entro a verificar';
    $ord= new orden('','','','','','','');
	//$reg=$ord->lista_orden_pac($_POST['cedula']);
	$paci=$ord->consul_pac($_POST['cedula']);
	if($paci)
	{
	   
		//$paci=$ord->consul_pac($_POST['cedula']);
		$datos=explode('/*',$paci); 
		 if($datos[6]=='F')
		   $sexo='Femenino';
		 else
		   $sexo='Masculino'; }$reg=$ord->lista_orden_pac($datos[0]); }
		 ?>

	   	<table width="700" border="0" align="center" >
			<tr class="titulofor">
			  <td height="30" colspan="6"><div align="center" class="titulofor">Resultados por Paciente </div></td>
			</tr>
			
			<tr class="texto">
			  <td height="30" colspan="4"><div align="left" class="texto"> 
	  			<span class="textoN">C&Eacute;DULA: <?php echo $datos[11]; ?></span>
	  			<input name="cedula" id="cedula" type="text" value="<?php echo $datos[11]; ?>" class="texto" />
      			<br>
				<span class="textoN">NOMBRE</span>: <?php echo utf8_encode($datos[1]).' '.utf8_encode($datos[2]).' '.utf8_encode($datos[3]).' '.utf8_encode($datos[4]); ?><input name="nombre" id="nombre" type="hidden" value="<?php echo $datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4]; ?>" /><br>
	  			<span class="textoN">EDAD</span>: <?php if($_POST['cedula']) echo calculaedad($datos[5]); ?><input name="edad" id="edad" type="hidden" value="<?php echo calculaedad($datos[5]); ?>" /><br>
	  			<span class="textoN">SEXO</span>: <?php echo $sexo; ?><input name="sexo" id="sexo" type="hidden" value="<?php echo $datos[6]; ?>" /><input name="sexonom" id="sexonom" type="hidden" value="<?php echo $sexo; ?>" /><br>
	  			<span class="textoN">EMPRESA: </span><?php echo $datos[8]; ?><input name="empresa" id="empresa" type="hidden" value="<?php echo $datos[7]; ?>" /><input name="empresanom" id="empresanom" type="hidden" value="<?php echo $datos[8]; ?>" />
				<input name="ingreso" id="ingreso" type="hidden" value="0">
				<input name="mostrargrafi" id="mostrargrafi" type="hidden" value="0">
				</div><br>
			  </td>
			    <td height="30" colspan="2"><div align="center" class="texto">
				<span class="textoN">HISTORIAL</span><br>
				<select name="caracts" id="caracts" class="texto" onChange="activerhis()">
				  <option value="0">Seleccione</option>
				  <?php if($_POST['ingreso']==1)
				     {
				      $resulth=$ord->caract_hist($datos[0]);
				  	  if($resulth)  
				  	  while ($rowh = mysql_fetch_row($resulth))
					  {
					      echo '<option value="'.$rowh[0].'">'.utf8_encode($rowh[1]).' - '.utf8_encode($rowh[2]).'</option>';
					  }
					 }  ?> 
				</select><input name="nombcarocu" id="nombcarocu" type="hidden" value="" /><br>
			   <?php if($resulth) { ?>
			        <span id="verhis" onClick="irhisto();" style="cursor:hand; text-decoration:underline; display:none ">VER HISTORIAL</span>
			   <?php } ?>
			  <br>
			  </div>
			</tr>
			<tr class="texto" align="center">
			  <td height="30" colspan="6" align="center" class="td-buttons">
			  
<a href="#" onclick="buscapac();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>

<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

			  </td></tr>
	    </table>
<div align="center" id="grafico">
  <?php
  //This page demonstrates the ease of generating charts using FusionCharts PHP Class.
  //For this chart, we've created an instance of FusionCharts PHP Class,
  //fed chart data and configuration parameters to it and rendered chart using the instance.

 if($_POST['mostrargrafi']==1)
 {

  //Here, we've kept this example very simple.

  # Create object for Column 3D chart
  $FC = new FusionCharts("Line","600","300"); 

  # Setting Relative Path of chart swf file.
  $FC->setSwfPath("FusionCharts/Code/FusionCharts/");

  # Store chart attributes in a variable
  $strParam="caption=".$_POST['nombcarocu'].";xAxisName=Fecha;yAxisName=Valor;decimalPrecision=0;formatNumberScale=0;lineColor=FF6600";

  # Set chart attributes
  $FC->setChartParams($strParam);

    $ord= new orden('','','','','','','');
 	$result=$ord->val_hist($datos[0],$_POST['caracts']);
	if($result)  
	{
	   echo '<table width="300"  border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr class="titulorep" align="center">
				<td width="300" colspan="2" align="center">'.$_POST['nombcarocu'].'
				<hr size="1" color="#FFFFFF"></td>
			  </tr>
			 <tr class="titulorep" align="center">
				<td width="150">Fecha</td>
				<td width="150">Valor</td>
			  </tr>';
		while ($row = mysql_fetch_row($result))
		{
				 echo '<tr align="center" class="texto">
						<td>'.$row[1].'</td>
						<td>'.$row[0].'</td>
					  </tr>';
				$FC->addChartData($row[0],"name=".substr($row[1],0,8));
		} 
		echo '</table>';
	}

  # Add chart data along with category names 
 /* $FC->addChartData("462","name=Jan");
  $FC->addChartData("857","name=Feb");
  $FC->addChartData("671","name=Mar");
  $FC->addChartData("494","name=Apr");
  $FC->addChartData("761","name=May");
  $FC->addChartData("960","name=Jun");
  $FC->addChartData("629","name=Jul");
  $FC->addChartData("622","name=Aug");
  $FC->addChartData("376","name=Sep");
  $FC->addChartData("494","name=Oct");
  $FC->addChartData("761","name=Nov");
  $FC->addChartData("960","name=Dec");*/

  # Render chart 
  $FC->renderChart();
}
  ?>
</div>

</form>
</BODY>
</HTML>
