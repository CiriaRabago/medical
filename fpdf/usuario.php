<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_empleado.php";
include "clases/clase_usuario.php";
include "clases/clase_bitacora.php";
include "clases/clase_medico.php";
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #FFFFFF;
}
-->
</style>
<link href="foro.css" rel="stylesheet" type="text/css" />
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
<!--
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo3 {color: #FF0000}
-->
</style>
</head>
<script>
function buscar()
{  
	if (document.getElementById("cedbus").value!='')
	{
	    document.form1.ocu.value=1;
		document.form1.ocu_tc.value=1;
		document.form1.submit();
	
	}
	else
	 alert("Debe ingresar un número de cédula");
}

function guardar()
{  
	if (document.getElementById("tipo").value!='0' && document.getElementById("clave").value!='' && document.getElementById("conclave").value!='')
	{
		if(document.getElementById("clave").value==document.getElementById("conclave").value) 
		{
			document.form1.ocu_g.value=1;
			document.form1.ocu_tc.value=1;
   			document.form1.submit();
	    }
		else
			 alert("la Clave y la Confirmación NO coinciden");
	}
	else
	 alert("Falta ingresar Datos");
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
</script>
<body>

<form id="form1" name="form1" method="post" action="usuario.php">
  
  <p>
    <?php	
			
			$etiq='style="display:none"';
			$eti='Usuario';
	  		if(isset($_POST["ocu"]) && $_POST["ocu"]!='0') 
			{ $bus=  new empleado($_POST["cedbus"],'','','','','','','','','','','','','','','','','','');
			  $med=  new medico('',$_POST["cedbus"],'','','','','','','','','','','','','');
			  $CAD2= $bus->buscar_emp();
			  if ($CAD2!='false')
			  		$CAD= $CAD2;
			  else
			  	{
					$CAD3= $med->buscar_med();
					$CAD= $CAD3;
			  	}
			  if ($CAD!='false')
			  {
			     $bus1= new usuario('','','','',$_POST["cedbus"],'','','');
			     $CAD1= $bus1->consult();
				 if ($CAD1=='0')
				 	{$vec=explode('**',$CAD);
					 $usua=$bus1->consulta_usu();
					 $ce1=explode('**',$usua);
					 $cede=$ce1[8];					 
				    $ver='style="display:block"';
				    $mos='display:none';}
				 else
					{  
						$eti='Este Usuario ya se encuentra registrado, Puede Cambiar su Clave y Tipo';
						$vec=explode('**',$CAD);
						$usua=$bus1->consulta_usu();
					    $ce1=explode('**',$usua);
					    $cede=$ce1[8];					   
						$cl=$ce1[2];
				    	$ver='style="display:block"';
				    	$mos='display:none';
						
			    	}
			  }
			  else 
			  {  echo '<script>alert("No se encuentra registrado como Empleado");</script>';
			     	$ver='style="display:none"'; 
			  }
			 }
			 else 
			 	$ver='style="display:none"';   
			 
			 if(isset($_POST["ocu_g"]) && $_POST["ocu_g"]!='0' )
			 {    $usu= new usuario($_POST["ocuced"], $_POST["clave"],'','',$_POST["ocuced"],'',$_POST["tipo"],$_SESSION["cedu_usu"]);
    				if ($_POST["gua_mod"]=='0')
						$gua=$usu->guardar_usuario();
					else
						$gua=$usu->modificar_clave_otro($_POST["cede"]);
						if ($gua)
					   	{	
						   	$ver='style="display:none"'; 
							$etiq='style="display:block"';
							///////////////Guardar e Bitacora////////////////////////
							
							/////////////////////////////////////////////////////////
						}
					    else
					   		 echo '<script>alert("El Registro no pudo ser Guardado");</script>';
		    }
			if(isset($_POST["ocu_tc"]) && $_POST["ocu_tc"]!='0' )

			$mos='style="display:none"';
			
  else 
  			$mos='style="display:block"';?>
  <table width="573" border="0" align="center" <?php echo $mos; ?>>
      <tr class="titulofor">
        <td width="563" height="21" class="Titulo_tab"><div align="center" class="TituloF">Usuario</div></td>
    </tr>
      <tr class="Etiqueta">
        <td height="36" class="etiqueta td-btn">
          <div align="center" class="Etiqueta">
            <p class="Etiqueta">Introduzca su n&uacute;mero de c&eacute;dula &oacute; RIF y presione Buscar. </p>
            <p>Cedula: <span class="Texto">
            <input name="cedbus" type="text" class="texto" id="cedbus" size="15" />
            </span>

            <a href="#" onclick="buscar();" class="button-sort" alt="Buscar"  > <i class="fa fa-search" aria-hidden="true"></i> Buscar </a><span class="Texto">
            <input name="ocu" type="hidden" value="0" />
           
                </span> </p>
        </div></td>
      </tr>
  </table>
  <input name="ocu_tc" type="hidden" value="0" />
    <table width="891" border="0" align="center" <?php echo $ver;?>>
      <tr class="TituloF">
        <td colspan="4" class="Titulo_tab"><div align="center" class="titulofor"><?php echo $eti; ?></div></td>
      </tr>
      <tr class="Etiqueta">
        <td colspan="4" class="etiqueta"><ol>
          <li>Ingrese una contrase&ntilde;a y confirmela.</li>
          <li>
            <div align="left" class="Etiqueta">Guardar.</div>
          </li>
        </ol>        </td>
      </tr>
      <tr class="Etiqueta">
        <td width="145" class="etiqueta">C&eacute;dula:</td>
        <td width="307" class="texto"><input name="cedula" type="text" disabled="disabled" class="texto" id="cedula" value="<?php echo $vec[0]; ?>" size="25"  />
        <input name="ocuced" type="hidden" value="<?php  echo $vec[0]; ?>" />
        <input name="gua_mod" type="hidden" id="gua_mod" value="<?php  echo $CAD1; ?>" /></td>
        <td width="154" class="etiqueta"><div align="left"><span class="etiqueta"> Nombre de Usuario: </span></div></td>
        <td width="323" class="Texto"><div align="left"><span class="etiqueta">
          <input name="usuario" type="text" class="texto" id="usuario" maxlength="10"  disabled="disabled"  value="<?php  echo $vec[0]; ?>"/>
        </span></div>          
        <label></label></td>
      </tr>
      <tr class="Etiqueta">
        <td class="etiqueta"><div align="left">Primer Nombre: </div></td>
        <td class="texto"><input name="ocun1" type="hidden" value="<?php echo $vec[1];?>" />
        <input name="nomdoc1" type="text" disabled="disabled" class="texto" id="nomdoc1" size="50" value="<?php echo $vec[1];?>"/></td>
        <td class="etiqueta"><div align="left"><span class="etiqueta">Ingrese una Contrase&ntilde;a: </span></div></td>
        <td class="Texto"><div align="left"><span class="etiqueta">
          <input name="clave" type="password" class="texto" id="clave"  value="<?php echo $cl; ?>" maxlength="6" />
          <span class="Estilo2">* </span></span><span class="etiqueta">(m&aacute;ximo 8 caracteres</span>).</div></td>
      </tr>
      <tr class="Etiqueta">
        <td height="20" class="etiqueta"><div align="left">Segundo Nombre: </div></td>
        <td class="texto"><input name="ocun2" type="hidden" value="<?php echo $vec[2];?>" />
        <input name="nomdoc2" type="text"disabled="disabled" class="texto" id="nomdoc2" size="25" value="<?php echo $vec[2];?>"/></td>
        <td class="etiqueta">Confirmar Contrase&ntilde;a: </td>
        <td class="Texto"><label>
          <input name="conclave" type="password" class="texto" id="conclave" maxlength="6" value="<?php echo $cl; ?>" />
          <span class="etiqueta"> </span><span class="etiqueta"><span class="Estilo2">*</span>(m&aacute;ximo 8 caracteres</span>).</label></td>
      </tr>
      <tr class="Etiqueta">
        <td class="etiqueta"><div align="left">Primer Apellido: </div></td>
        <td class="texto"><input name="ocua1" type="hidden" value="<?php echo $vec[3];?>" />
        <input name="apedoc1" type="text" disabled="disabled" class="texto" id="apedoc1" size="25" value="<?php echo $vec[3];?>"/></td>
        <td class="etiqueta">Tipo de Usuario:</td>
        <td class="Texto"><label>
          <select name="tipo" class="texto" id="tipo">
            <option value="0">Seleccione--&gt;</option>
            <option value="A">Administrador</option>
            <option value="O">Operador</option>
        </select>
          <span class="Estilo2">*</span></label></td>
      </tr>
      <tr class="Etiqueta">
        <td class="etiqueta"><div align="left">Segundo Apellido: </div></td>
        <td class="texto"><input name="ocua2" type="hidden" value="<?php echo $vec[4];?>" />
        <input name="apedoc2" type="text" disabled="disabled" class="texto" id="apedoc2" size="25" value="<?php echo $vec[4];?>"/></td>
		<td class="etiqueta"><div align="left">Sede de Trabajo: </div></td>
        <td class="texto"><select name="cede" id="cede" class="texto">
		                   <option value="0">Seleccionar--></option>
						   <option value="1" <?php if($cede=='1') echo "selected";?>>Administrador</option>
						   <option value="2" <?php if($cede=='2') echo "selected";?>>DonVale</option>
						   <option value="3" <?php if($cede=='3') echo "selected";?>>Pirineos</option> 
		                  </select></td>
     </tr>
	 <tr>
	    <td colspan="4" class="texto" align="center"><label><span class="Estilo3">* </span><span class="etiqueta">campos obligatorios </span> </label></td>
      </tr>
      <tr>
        <td colspan="4" class="td-btn">
            <hr align="left" />
            <div align="center">
            <a href="#" onclick="Guardar();" class="button-save" alt="Guardar"  > <i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </a>
          <input name="ocu_g" type="hidden" value="0"/>
          <input name="ocu_N" type="hidden" id="ocu_N" value="0" />
          </div></td></tr>
  </table>
       <table width="200" border="0" align="center">
        <tr>
          <td height="87"><div class="etiqueta"  id="Etiqueta" <?php echo $etiq; ?>>
            
            <p align="center" class="Etiqueta">El Usuario ha sido Registrado Satisfactoriamente </p>
            <p align="center" class="Etiqueta">"BIENVENIDO"</p>
          </div>            
          <div align="center">
          <a href="#" onclick="top.mainFrame.location.href='salir.php'" class="button-close" alt="Salir"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></div></td>
        </tr>
      </table>
</form>
</body>
</html>
