<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_firma.php";
include "clases/clase_usuario.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script>
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
	if(document.getElementById("nombre").value!='' && document.getElementById("edad").value!='' && document.getElementById("sexo").value!='')
	   document.form1.submit();
	else
	  alert('Falta ingresar Datos')

}

function posicion()
{
	document.getElementById('orden').focus();
}


function buscar()
{
 if(document.getElementById('orden').value!='')
 {
	 document.form1.action='mod_resu_exam.php';
	 document.form1.submit();
 }
 else
   	alert('Debe indicar el Número de Orden');

}

</script>
<body onload="posicion();">
<form name="form1" id="form1" method="post" action="firma_resultado.php">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulofor">
    <td colspan="4"><div align="center">FIRMAR RESULTADOS</div></td>
  </tr>
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr> 
  <tr>
    <td colspan="4" class="td-buttons">
	  <div align="center">
	    <p class="textoN"><br>
	        Orden No. <input name="orden" id="orden" type="text" class="texto" />
	        <br>
	        <a href="#" onclick="buscar();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a>
	        <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>
</p>
	  </div></td>
  </tr>   
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
  </tr>  
</table>
<?php    
     $cedusu=$_SESSION["cedu_usu"];
	 $bus1= new usuario('','','','',$cedusu,'','','');
	 $usua=$bus1->consulta_usu();
	 $ce1=explode('**',$usua);
	 $condi=$ce1[8];
     $cont=0;
     $ord= new orden('','','','','','','');
	 $resu=$ord->buscar_orden_lista();	 
     if((mysql_num_rows($resu))!=0)
	 {
	    echo "<table align='center'>
                <tr class='titulorep'>
		          <td width='160'>NUMERO DE ORDEN</td>
		          <td width='160'>CEDULA PACIENTE</td>
		          <td width='160'>FECHA INGRESO ORDEN</td>
		        </tr>";
	    while ($row = mysql_fetch_row($resu))
		 {
		   $bus1= new usuario('','','','',$row[6],'','','');
		   $usua=$bus1->consulta_usu();
	       $ce1=explode('**',$usua); 
		   if($ce1[8]==$condi || $condi=='1')
			 {
			  $f=new firma($row[0],'','','','');
			  $fir=$f->consultar();
	          if($fir==false)
			   {
		        if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
		          $cont++;
                echo "<tr class='textoN' ".$color."><td><a href='mod_resu_exam.php?orden=".$row[0]."'>".$row[0]."</a></td><td>".$row[1]."</td><td>".$row[5]."</td></tr>";  } 
		      }
		   }	  
		 echo "</table>";
	   }// end if((mysql_num_rows($result))>0)				
	 ?>

</form>
</body>
</html>
