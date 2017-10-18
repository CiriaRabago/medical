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
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

function expand(el){
  x = document.getElementsByClassName("option-menu");
 console.info(el.childNodes[1].innerHTML);
 if( el.childNodes[1].innerHTML == '<i class="fa fa-angle-down" aria-hidden="true"></i>' )
 	el.childNodes[1].innerHTML="<i class='fa fa-angle-right' aria-hidden='true'></i>";
 else{
 	var i;
 	for (i = 0; i < x.length; i++) {
  	option = x[i];
  	if(option.childNodes.length > 1)
  		option.childNodes[1].innerHTML="<i class='fa fa-angle-right' aria-hidden='true'></i>";
 //    x[i].style.backgroundColor = "#2a2e3d";
 //    x[i].onmouseover = function() {
 //  		this.style.backgroundColor ="434859";
	// };
  }
  //el.style.backgroundColor = "#434859";  
  el.childNodes[1].innerHTML="<i class='fa fa-angle-down' aria-hidden='true'></i>"	
 }
  
}
</script>

<style type="text/css">

body {
	background-color: #2a2e3d;
	margin-left: 0px;
	margin-right: 0px;
	font-family: sans-serif;
	margin: 0px;
}

</style></head>

<body >
<div class="menu-left">
<table width="100%" border="0" style="margin-bottom: 5px; padding-top:5px">
  <tr>
    <td class="titulo-md text-center">Bienvenido</td>
  </tr>
  <tr>
    <td class="name-user" align="center"><?php echo $_SESSION["nom_usu"];?></td>
  </tr>
</table>
<?php

 $men= new menu('','','','','','','',$_SESSION["cedu_usu"]);
 echo $men->pinta_menu();
 
 ?>
</div>
</body>
</html>
