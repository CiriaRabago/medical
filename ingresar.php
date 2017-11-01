<?php  session_start();
include "clases/clase_conexion.php";
include "clases/clase_usuario.php";
include("securimage.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css"></style>
<!-- <link href="clases/Estilos.css" rel="stylesheet" type="text/css"> -->
<body>
<form name="ing" action="centro.php">
<?php 
$usu=$_POST["USUARIO"];
$cla=$_POST["CLAVE"];
$cod=$_POST["code"];   
$verif= new usuario($usu,$cla,NULL,NULL,NULL,NULL,NULL,NULL);
$img = new Securimage();
$valid = true;
//$valid = $img->check($cod);
if($valid == true)
{

$us=$verif->consult_usu();
if ($us=='0')
		{  
			session_unregister("cedu_usu");
			session_unregister("tipo_usu");
			session_unregister("nom_usu");
			session_destroy();
		   echo '<script>alert("Usuario o Contraseña Incorrecto")</script>';
           echo '<script>document.ing.submit()</script>';
	    }
if (($us!='0') && ($us!='1'))
		{   
			session_register("cedu_usu");
			session_register("tipo_usu");
			session_register("nom_usu");
			$vec=explode('**',$us);
			$_SESSION["cedu_usu"]=$vec[0];
			$_SESSION["tipo_usu"]=$vec[1];
			$cad = $verif->buscar_usuario();
			$vec1 = explode('**',$cad);
			$_SESSION["nom_usu"] = $vec1[0]." ".$vec1[1]." ".$vec1[2]." ".$vec1[3];
    	    ?>
				<p>
	    		<script>
				timerId = setTimeout("top.leftFrame.location.href = 'izquierdo.php'",0)
				</script> 
	    	<?php 
	   }
if ($us=='1')
		{  
			session_unregister("cedu_usu");
			session_unregister("tipo_usu");
			session_unregister("nom_usu");
			session_destroy();
		   echo '<script>alert("Usuario Desactivado")</script>';
           echo '<script>document.ing.submit()</script>';
	    }
}
else
{
	echo '<script>alert("Codigo de Imagen Erroneo")</script>';
	echo '<script>document.ing.submit()</script>';
}
?>
 </form>
</body>
</html>

