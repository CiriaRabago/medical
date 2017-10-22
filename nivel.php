<?php   
session_start();
include "clases/clase_conexion.php";
include "clases/clase_nivmenu.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo3 {color: #FF0000}
-->
</style>


<script type="text/javascript" src="colores.js" >
</script>


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
	document.getElementById("nomb").value='';
	document.getElementById("descrip").value='';
	document.getElementById("pre").value='';
	document.getElementById("tipo").value='0';
    document.form1.ocu_N.value=0;
}
function Guardar()
{  
	 if ((document.getElementById("nomb").value!='') && (document.getElementById("orden").value!='')
	 && ( ( (document.getElementById("imagena").value!='') && (document.getElementById("imagenp").value!='') )
	      || (document.getElementById("colo").value!='') ) 	 )
	{	
		if (  ( (document.getElementById("imagena").value!='') || (document.getElementById("imagenp").value!='') )
	      && (document.getElementById("colo").value!='') )
		{
		  alert("Solo debe seleccionar SOLO imagenes o color. NO AMBOS ELEMENTOS")
		  return false;
		}
		
		if ( ( (document.getElementById("imagena").value!='') && (document.getElementById("imagenp").value=='') )
		  || ( (document.getElementById("imagena").value=='') && (document.getElementById("imagenp").value!='') ) )
		{
		  alert("Debe seleccionar ambas imagenes")
		  return false;
		}
		
		if (document.form1.ocu_N.value==0)
		{
			document.form1.ocu_g.value=1;
   			document.form1.submit();
		}
		if (document.form1.ocu_N.value!=0)
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
	document.getElementById("nomb").value=trozos[1];
	//'<img src="imagenes/'+trozos[2]+'" />'
	//<img src="imagenes/'+trozos[3]+'" />
	if(trozos[2]!='')
		document.getElementById("ocuimaa").innerHTML='<img src="imagenes/'+trozos[2]+'" />';
	if(trozos[3]!='')
		document.getElementById("ocuimap").innerHTML='<img src="imagenes/'+trozos[3]+'" />';
	document.getElementById("orden").value=trozos[4];
	document.getElementById("muestrapaleta").style.backgroundColor=trozos[5];
	document.form1.colo.value=trozos[5];
	if(trozos[5]!='')
	{
		document.getElementById("ocuimaa").innerHTML='';
		document.getElementById("ocuimap").innerHTML='';
	}
	document.form1.ocu_N.value=trozos[0];
}
</script>
<body>
<p>&nbsp;</p>
<form name="form1" id="form1" method="post" action="nivel.php" enctype="multipart/form-data">
<?php  
//nivel($c, $n, $ia, $ip, $o, $co)
 $niv= new nivel($_POST["ocu_N"],$_POST["nomb"],'','',$_POST["orden"],$_POST["colo"]);
 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
  { 
	//die("entro a guardar");
	$bus=$niv->buscar($_POST["tipo"]);
	if ($bus=='true')
		echo '<script>alert("Este registro YA Existe");</script>';
	else
	{
		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]!='0' )
		{	
				$gua=$niv->modf_nivel();
				if ($gua)
				{
					echo '<script>alert("Registro Modificado Exitosamente");</script>';
				}
				else
					echo '<script>alert("El Registro no pudo ser Modificado");</script>';
		}
		
		if (isset($_POST["ocu_N"]) && $_POST["ocu_N"]=='0' )
		{

				$gua=$niv->ins_nivel();
				if ($gua!=false)
				{
					$niv->cod=$gua;
					echo '<script>alert("Registro Guardado Exitosamente");</script>';
				}
				else
					echo '<script>alert("El Registro no pudo ser Guardado");</script>';
			// aqui llave
		}
		
		
		//////// DESDE AQUI REEMPLAZO DE IMAGENES
					$bandimaa=1;
					$bandimap=1;
					
					
					$nombre_archivo1 = $HTTP_POST_FILES['imagena']['name']; 
					if($nombre_archivo1!='') 
					{
						$tipo_archivo1 = $HTTP_POST_FILES['imagena']['type']; 
						$tamano_archivo1 = $HTTP_POST_FILES['imagena']['size']; 
						//compruebo si las características del archivo son las que deseo 
						if (!((strpos($tipo_archivo1, "gif") || strpos($tipo_archivo1, "GIF") || strpos($tipo_archivo1, "JPEG") 
							|| strpos($tipo_archivo1, "jpeg") || strpos($tipo_archivo1, "jpg") || strpos($tipo_archivo1, "JPG")) 
							&& ($tamano_archivo1 < 100000))) 
						{ 
							echo "La extensión o el tamaño de los archivos no es correcta. <br><br>
								<table><tr><td><li>Se permiten archivos .gif o .jpg<br>
								<li>se permiten archivos de 100 Kb máximo.</td></tr></table>"; 
							$bandimaa=0;
						}
						else
						{ 
							$imaa= 'nivel'.$niv->cod.'a'.'.'.substr($tipo_archivo1, strpos($tipo_archivo1, "/")+1);
							if (!move_uploaded_file($HTTP_POST_FILES['imagena']['tmp_name'], 'imagenes/'.$imaa))
							{ 
							   echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
							   $bandimaa=0;
							} 
							else
							{ 
							   $niv->imaa=$imaa;
							   $cia=$niv->cambiar_imagen('a');
							   if($cia==false)
									echo '<script>alert("Ocurrio un error al cambiar la imagen onmouseover");</script>';
							}
						} 
					} 
				
					$nombre_archivo2 = $HTTP_POST_FILES['imagenp']['name']; 
					if($nombre_archivo2!='') 
					{
						$tipo_archivo2 = $HTTP_POST_FILES['imagenp']['type']; 
						$tamano_archivo2 = $HTTP_POST_FILES['imagenp']['size']; 
						//compruebo si las características del archivo son las que deseo 
						if (!((strpos($tipo_archivo2, "gif") || strpos($tipo_archivo2, "GIF") || strpos($tipo_archivo2, "JPEG") 
							|| strpos($tipo_archivo2, "jpeg") || strpos($tipo_archivo2, "jpg") || strpos($tipo_archivo2, "JPG")) 
							&& ($tamano_archivo2 < 100000))) 
						{ 
							echo "La extensión o el tamaño de los archivos no es correcta. <br><br>
							<table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>"; 				
							$bandimap=0;
						}
						else
						{ 
							$imap= 'nivel'.$niv->cod.'p'.'.'.substr($tipo_archivo2, strpos($tipo_archivo2, "/")+1);
							if (!move_uploaded_file($HTTP_POST_FILES['imagenp']['tmp_name'], 'imagenes/'.$imap))
							{ 
							   echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
							   $bandimap=0;
							} 
							else
							{ 
							   $niv->imap=$imap;
							   $cip=$niv->cambiar_imagen('p');
							   if($cip==false)
									echo '<script>alert("Ocurrio un error al cambiar la imagen onmouseout");</script>';
							}
						}
					}


		
		//////// HASTA AQUI REEMPLAZO DE IMAGENES
		
		
	}
  }

 ?>
  <table width="600" border="0" align="center" >
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Nivel de Menu </div></td>
    </tr>
    <tr>
      <td width="160" class="etiqueta">Nombre del Nivel:</td>
      <td width="425" colspan="3" class="texto Estilo2"><label>
        <input name="nomb" type="text" class="texto" id="nomb" size="50" onkeypress='return sincomillas(event)' />
        <span class="Estilo3">*</span> </label></td>
    </tr>
    <tr>
      <td class="etiqueta">Imagen onmouseover:</td>
      <td colspan="2">
          <input name="imagena" type="file" id="imagena" size="20" />          
        <span class="texto Estilo2"><span class="Estilo3">*</span></span></td>
      <td><div id="ocuimaa"></div></td>

    </tr>
	<tr>
      <td class="etiqueta">Imagen onmouseout:</td>
      <td colspan="2"><label><input name="imagenp" type="file" id="imagenp" size="20" />
          <span class="texto Estilo2"><span class="Estilo3">*</span></span> </label></div></td>
      <td><div id="ocuimap"></div></td>
    </tr>
	<tr>
      <td width="160" class="etiqueta">Orden:</td>
      <td width="425" colspan="3" class="texto Estilo2"><label>
        <input name="orden" type="text" class="texto" id="orden" size="10" onkeypress='return sincomillas(event)' />
        <span class="Estilo3">*</span> </label></td>
    </tr>
	<tr>
      <td width="160" class="etiqueta">Color:</td>
      <td width="425" colspan="3" class="texto Estilo2"><label>
        <input name="colo" type="text" class="texto" id="colo" size="20" onkeypress='return sincomillas(event)' />
        <span class="Estilo3">*</span> </label></td>
    </tr> 
		<tr>
      <td width="160" class="etiqueta">Selecciones el Color:</td>
      <td width="425" colspan="3" class="texto Estilo2"><label>
 <div id="visor">
	  <script type="text/javascript">
		var colorpaleta = "#FF6633";
		function metodopaleta(color)	{
			document.form1.colo.value = "#" + color;
		}
		document.writeln(ponerPaleta2("paleta", 5, colorpaleta, 6, false, true));
		</script>
        </div>    </tr>    
   
	<tr>
      <td>&nbsp;</td>
      <td colspan="3"><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span></td>
    </tr>
    <tr>
      <td colspan="4" class="td-buttons"><div align="center">

      <a href="#" onclick="eliminar();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>

	<a href="#" onclick="Nuevo();" class="button-new" alt="Nuevo"  > <i class="fa fa-file-o" aria-hidden="true"></i> Nuevo </a>

	<a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>


	<a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a>

	        <input name="ocu_g" type="hidden" value="0"/> 
		<input type="hidden" name="ocu_N" id="ocu_N" value="0"/>  
          <input type="hidden" name="ocu_e" value="0"/>        
     </div></td>
    </tr>
  </table>
  <?php  
   $ver=$niv->ver_nivel();
        if ($ver==false)
		{
		   echo "<script>alert('Error para mostrar los Perfiles');</script>";
		} 
		else
		{
		    echo $ver;
		}
	?>
</form>
</body>
</html>
