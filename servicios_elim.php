<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="">
<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_servicio.php";
     $codser=$_POST["codauxser"];
     $sql ="update slc_servicio set elimina_servicio=1 where id_servicio=".$codser;	
     echo $sql."  - servicio :".$codauxser;    
	$ser= new servicio($codauxser,'','','','','','',0);	
	if($ser->eliminar_servicio($sql)==true)
	   { echo "<script> alert('Registro Eliminado')</script>"; }
	else  
	   { echo "<script>alert('Error eliminando registro intente mas tarde')</script>";	}
    echo "<script>
             document.form1.action='servicios_lista.php';
	         document.form1.submit();
          </script>";
?>

</form>
</body>
