<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_medico.php";
include "clases/clase_espec.php";
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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
function medico_pdf()
{
document.form1.action="medico_pdf.php";
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
 $med= new medico('','','','','','','','','','','','','','','');
 $esp= new especialidad('','');

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
	
	

 ?>
  <table width="649" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Médico</div></td>
    </tr>
    <tr>
      <td class="etiqueta">RIF / Cedula: </td>
      <td colspan="3" class="texto"><label>
        <input name="rif" type="text" class="texto" id="rif" size="25" onkeypress='return sincomillas(event)' value="<?php=$_POST['rif'];?>"/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td colspan="3" class="texto"><label>
        <input name="nom" type="text" class="texto" id="nom" size="50" onkeypress='return sincomillas(event)' value="<?php=$_POST['nom'];?>"/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
	<tr>
      <td class="etiqueta">Sexo:</td>
      <td class="texto"><select name="sex" class="texto" id="sex">
        <option value="">Seleccione---&gt;</option>
        <option value="F" <?php if($_POST['sex']=='F') echo 'selected';?>>Femenino</option>
        <option value="M" <?php if($_POST['sex']=='M') echo 'selected';?>>Masculino</option>
      </select>
        <span class="Estilo1">*</span></td>
    </tr>
    <tr>
      <td width="197" class="etiqueta">Direcci&oacute;n :</td>
      <td colspan="3" class="texto"><label>
        <textarea name="dire" cols="50" class="texto" id="dire" onkeypress='return sincomillas(event)'><?php=$_POST['dire'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 1:</td>
      <td colspan="3" class="texto"><label>
        <input name="te1" type="text" class="texto" id="te1" size="25" onkeypress='return sincomillas(event)' value="<?php=$_POST['te1'];?>"/>
        <span class="texto Estilo2"><span class="Estilo1">*</span></span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefono 2 :</td>
      <td colspan="3" class="texto"><label>
        <input name="te2" type="text" class="texto" id="te2" size="25" onkeypress='return sincomillas(event)' value="<?php=$_POST['te2'];?>"/>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Correo electr&oacute;nico :</td>
      <td colspan="3" class="texto"><label>
        <input name="email" type="text" class="texto" id="email" size="50" onkeypress='return sincomillas(event)' value="<?php=$_POST['email'];?>"/>
      </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Porcentaje:</td>
      <td colspan="3" class="texto"><label> </label>
          <input name="porce" type="text" class="texto" id="porce" onkeypress='return soloNumeros(event)' size="3" maxlength="3" value="<?php=$_POST['porce'];?>"/> %
          <span class="texto Estilo2"><span class="Estilo1">*</span></span> </td>
    </tr>

    <tr>
      <td class="etiqueta">Mpps:</td>
      <td class="texto"><label class="texto">
        <input name="mpps" type="text" class="texto" id="mpps" value="<?php=$_POST['mpps'];?>">
      </label></td>
    </tr>
	 <tr>
	   <td class="etiqueta">Colegio: </td>
	   <td class="texto"><input name="cole" type="text" class="texto" id="cole" value="<?php=$_POST['cole'];?>"></td>
    </tr>
	 <tr>
      <td class="etiqueta">Especialidad:</td>
      <td class="texto"><select name="espec" id="espec" class="texto">
        <option value="">Seleccione --&gt;</option>
		<?php $esp= new especialidad($_POST['espec'],'');
	   echo $esp->combo_esp(); ?> 
      </select>
       <span class="texto Estilo2"><span class="Estilo1">*</span></span></td>
	 </tr>
	 <tr>
      <td height="25" class="etiqueta">Subir firma digital:</td>
      <td colspan="3" class="texto">
	         <div id="archivos">
			    <input type="text" name="firma" id="firma" class="texto"  value="<?php=$_POST['firma'];?>"/>
			    <input name="fotofile" type="file" class="texto" id="fotofile" size="30" onChange="fotox()" />
				<?php if(substr($_POST['firma'],0,5)=='firm/'){?>
				<img src="<?php=$_POST["firma"]?>?<?php=time()?>" width="120" height="100" id="foto" name="foto">
				<?php }?>
	         </div>
        <span class="Estilo2">Los Archivos pueden ser tipo JPEG, jpg, bmp, GIF &oacute; gif. </span>      </td>
    </tr>
    <tr>
      <td colspan="4"><span class="Estilo1">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons"><p>
      	<a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>


	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>

            <input name="ocu_N" type="hidden" value="<?php=$_POST['ocu_N'];?>"/>
			<input name="ocu_g" type="hidden" value="<?php=$_POST['ocu_g'];?>"/>
            <input type="hidden" name="ocu_e" value="<?php=$_POST['ocu_e'];?>"/>
			<a href="#" onclick="medico_pdf();" class="button-print" alt="Imprimir"  > <i class="fa fa-print" aria-hidden="true"></i> Imprimir </a></p>      </td>
    </tr>
  </table>
       <?php 
$ver=$med->ver_medico();
        if ($ver==false)
		{
		   
		} 
		else
		{
		    echo $ver;
		}
?>
</form>
</body>
</html>
