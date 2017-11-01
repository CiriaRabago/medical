<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_menu.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilolab.css" rel="stylesheet" type="text/css">

<script> 
function mostrar(id,nm)
{ 
  var t=document.getElementById('cuantos').value;
  var cn=document.getElementById('cantiniv').value;
  var niveles = cn.split("***");
  var numniv=niveles.length;
  var i; var j;
  
  
 	  for(i=1;i<=t;i++)
	  {
		//alert('tabla'+i+'**'+niveles[j]);
		for(j=0;j<numniv;j++)
  		{
			if(document.getElementById('tabla'+i+'**'+niveles[j]))
			{
				if(i==id)
				{
				   if(document.getElementById('tabla'+i+'**'+niveles[j]).style.display=="none")
				         document.getElementById('tabla'+i+'**'+niveles[j]).style.display='block';
				   else
				   		if(document.getElementById('tabla'+i+'**'+niveles[j]).style.display=="block")
				        	document.getElementById('tabla'+i+'**'+niveles[j]).style.display="none";
				}
				else
				{
				   if(niveles[j]==nm && i!=id)
				   {
				      document.getElementById('tabla'+i+'**'+niveles[j]).style.display='none';
				   }
				}   
			}
		}
	  }
}


</script>

<style type="text/css">
<!--
body {
	background-color: #a8a9ad;
	margin-left: 0px;
	margin-right: 0px;
}
-->
</style></head>

<body>

<table width="146" border="0">
  <tr>
    <td class="titulofor">Bienvenido</td>
  </tr>
</table>
<?php 

 $men= new menu('','','','','','','',$_SESSION["cedu_usu"]);
 echo $men->pinta_menu();
 
 ?>
</body>
</html>
