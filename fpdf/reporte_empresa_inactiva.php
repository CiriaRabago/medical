<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>
<script>
function sincomillas(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode == 34 || charCode ==39) {
  		alert("No se permite comillas");
 		return false;
  	}
	return true;
} 

function soloNumeros(evt){
	evt = (evt) ? evt : event;
   	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
 	((evt.which) ? evt.which : 0));
  	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  		alert("Solo se permiten números en este campo.");
 		return false;
  	}
	return true;
}

function eliminar()
{  if (document.form1.ocu_N.value==0)
	{	
		alert("Para Eliminar, Debe Seleccionar un registro de la lista");
	}
	else
	{	
		resp=confirm("¿Desea Eliminar el registro Seleccionado?");
		if (resp==true)
		{	
   			document.form1.ocu_e.value=1;
			document.form1.submit();
		}
	}
}
function Nuevo()
{  
	document.getElementById("rif").value='';
	document.getElementById("nom").value='';
	document.getElementById("dire").value='';
	document.getElementById("sex").value='';
	document.getElementById("te1").value='';
	document.getElementById("te2").value='';
	document.getElementById("email").value='';
	document.getElementById("porce").value='';
	document.getElementById("mpps").value='';
	document.getElementById("cole").value='';
	document.getElementById("espec").value='';
	document.getElementById("firma").value='';
    document.form1.ocu_N.value=0;
	document.form1.submit();
}
function empresa_i_pdf()
{
document.form1.action="empresa_i_pdf.php";
document.form1.submit();
}
function Guardar()
{  
	if (document.getElementById("rif").value!='' && document.getElementById("nom").value!='' && document.getElementById("sex").value!='' && document.getElementById("te1").value!='' && document.getElementById("porce").value!='' && document.getElementById("espec").value!='0')
	{
		if (document.form1.ocu_N.value==0)//modificar
			{	
				document.form1.ocu_g.value=1;			
				document.form1.submit();
			}
		else
			{
				document.form1.ocu_g.value=2;
   				document.form1.submit();
			}
	}
		else
			alert("Falta ingresar Datos");
	
}

function ver_modif(cadena)
{
	var trozos = cadena.split("/*");
	document.getElementById("rif").value=trozos[1];
	document.getElementById("nom").value=trozos[2];
	document.getElementById("sex").value=trozos[3];
	document.getElementById("dire").value=trozos[4];
	document.getElementById("te1").value=trozos[5];
	document.getElementById("te2").value=trozos[6];
	document.getElementById("email").value=trozos[7];
	document.getElementById("porce").value=trozos[8];
	document.getElementById("mpps").value=trozos[9];
	document.getElementById("cole").value=trozos[10];
	document.getElementById("espec").value=trozos[16];	
	document.getElementById("firma").value=trozos[17];;
	document.form1.ocu_N.value=trozos[0];
    document.form1.submit();
}
function fotox()
 {
   document.getElementById("firma").value=document.form1.fotofile.value;
 }
</script>
<body>
<form action="" method="post" name="form1" enctype="multipart/form-data">
<?php    
/* 
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' && $_POST["ocu_g"]!='')
  {  
    
	$med= new medico($_POST["ocu_N"], $_POST["rif"],$_POST["nom"],$_POST["sex"],
	$_POST["dire"],	$_POST["te1"],$_POST["te2"],$_POST["email"],$_POST["porce"],
	$_POST["mpps"],$_POST["cole"],'','','A',$_SESSION["cedu_usu"],'firm/'.$_POST["rif"].'.jpg');
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' && $_POST["ocu_N"]!='' )
	{
		$gua=$med->modf_medico($_POST["espec"]);
		
		if ($gua){		    
			if(substr($_POST['firma'],0,5)!='firm/' and $_POST['firma']!='')
			  {
			  $nombre_archivo = $_FILES['fotofile']['name'];
				if($nombre_archivo!='') 
				{				   
					$a=move_uploaded_file($_FILES['fotofile']['tmp_name'], 'firm/'.$_POST["rif"].'.jpg');
				}
			  }
			echo '<script>alert("Registro Modificado Exitosamente");</script>';
		  }
		else
			echo '<script>alert("El Registro no pudo ser Modificado");</script>';
	}
	if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' && $_POST["ocu_N"]!='' )
	{	
		$bus=$med->buscar();
		if ($bus=='true')
			echo '<script>alert("Este registro YA Existe");</script>';
		else
		{
			$gua=$med->ins_medico($_POST["espec"]);
			if ($gua){
			    if(substr($_POST['firma'],0,5)!='firm/' and $_POST['firma']!='')
			  {
			  $nombre_archivo = $_FILES['fotofile']['name'];
				if($nombre_archivo!='') 
				{				   
					$a=move_uploaded_file($_FILES['fotofile']['tmp_name'], 'firm/'.$_POST["rif"].'.jpg');
				}
			  }
				echo '<script>alert("Registro Guardado Exitosamente");</script>';
				}
			else
				echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		}
	}
	$_POST["ocu_N"]=0;$_POST["ocu_g"]=0;
  }
  if (isset($_POST["ocu_e"])!='0' && $_POST["ocu_e"]!='0' && $_POST["ocu_e"]!='') //para eliminar
	{	
	   $gua=$med->eliminar($_POST["ocu_N"]);
		if ($gua)
			echo '<script>alert("Registro Eliminado Exitosamente");</script>';
		else
			echo '<script>alert("El Registro no pudo ser Eliminado");</script>';
		$_POST["ocu_e"]=0;	
	} 
	
	
*/
 ?>
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Empresas Eliminadas</div></td>
    </tr>
	 <tr >
      <td height="30" colspan="4">
       <?php  
	    $emp=new empresa('','','','','','','','','','');
        $ver=$emp->ver_empresa_inactiva();
        if ($ver!=false)
		    echo $ver;
         ?></td>
     </tr> 
    <tr>
      <td colspan="4"><p><div align="center">
	     <img src="imagenes/p_imprimir1.gif" alt="Imprimir Orden" width="140" height="50" 
	  	style="cursor:hand" 
	 	 onclick="empresa_i_pdf();" 
	  	onmouseover="this.src='imagenes/a_imprimir1.gif'"  
	  	onmouseout="this.src='imagenes/p_imprimir1.gif'"/></div></p>      </td>
    </tr>
  </table>
    
</form>
</body>
</html>
