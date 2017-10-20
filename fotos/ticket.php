<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Unidad Medica Churchil c.a.</title>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<p><img src="imagenes/Logo1.png" height="47" /></p>
<p>
  <?php 
 $ms=$_GET['ms'];
 $datos=explode(';',$ms);
 echo "Cita registrada con Numero : <span class='Estilo2'>".$datos[0]."</span>";
 echo "</br>Para el dia : <span class='Estilo2'>".$datos[1]."</span>";
 echo "<script>window.print();window.close;</script>";
?> 
</body>
</html>
