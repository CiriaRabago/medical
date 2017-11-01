<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilolab.css" rel="stylesheet" type="text/css" />
<link href="churchil.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script>


function mostcar(val)
{
//alert(val);
 if (val!=0)
 {
  //alert('entra en val');
  document.getElementById('tablcar').style.display='block';
  //document.form1.submit();
  }
}

function orden()
{
	document.getElementById('ordenar').value=1;
	document.form1.submit();
}

function elim()
{
	document.getElementById('eliminar').value=1;
	document.form1.submit();
}


function agreg()
{
	document.getElementById('agregar').value=1;
	document.form1.submit();
}
</script>
<body>
<?php  
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php"; 
?>
<form name="form1" id="form1" method="post" action="exacardet.php">

<?php  if ($_POST['ordenar']==1)
{
	for($i=0;$i<$_POST['cantiocu'];$i++)
	{
		$exa=new examen($_POST['exame'],'','','','','','','','');
  		$cambio=$exa->camb_orden_caract_examen($_POST['codcar'.$i],$_POST['orden'.$i]);
	}
}


if ($_POST['eliminar']==1)
{
	for($i=0;$i<$_POST['cantiocu'];$i++)
	{
	
	   if($_POST['codcarch'.$i])
	   { 
		  $exa=new examen($_POST['exame'],'','','','','','','','');
		  $borrar=$exa->elim_caract_examen($_POST['codcar'.$i]);
	   }
	}
}

if ($_POST['agregar']==1)
{
	for($i=0;$i<$_POST['cantiocu2'];$i++)
	{
	
	   if($_POST['nocodcarch'.$i])
	   { 
		  $exa=new examen($_POST['exame'],'','','','','','','','');
		  $agreg=$exa->ins_caract_examen($_POST['nocodcar'.$i]);
	   }
	}
}

?>

<table width="436" border="0" align="center">
  <tr class="titulofor">
    <td height="30" colspan="3"><div align="center" class="titulofor">Caracter&iacute;sticas del Examen </div></td>
  </tr>
  <tr>
    <td width="60" class="etiqueta">Perfil:</td>
    <td width="366" colspan="2" class="textoN"><?php  echo $_POST['perfilocu']; ?><input name="perfil" type="hidden" value="<?php  echo $_POST['perfil']; ?>" /><input name="perfilocu" type="hidden" value="<?php  echo $_POST['perfilocu']; ?>" /></td>
  </tr>
  <tr>
    <td class="etiqueta">Examen:</td>
    <td colspan="2" class="textoN"><?php  echo $_POST['exaocu']; ?><input name="exame" type="hidden" value="<?php  echo $_POST['exame']; ?>" /><input name="exaocu" type="hidden" value="<?php  echo $_POST['exaocu']; ?>" /></td>
  </tr>

  <tr>
    <td colspan="3" class="td-buttons"><div align="center">
      <a href="#" onclick="top.mainFrame.location.href='exacar.php'" class="button-close" alt="Nuevo"  > <i class="fa fa-arrow-left" aria-hidden="true"></i> Salir </a></div></td>
  </tr>
</table>

  	<?php   
	    $n=0;
		$exa=new examen($_POST['exame'],'','','','','','','','');
  		$caractexa=$exa->consul_caract_examen(); 
		$n=mysql_num_rows($caractexa);
  ?>
<input name="cantiocu" id="cantiocu" type="hidden" value="<?php  echo $n; ?>" />
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulorep" align="center">
    <td width="20">&nbsp;</td>
    <td width="400">Caracter&iacute;sticas Asociadas </td>
    <td width="90">Unidad<br>Medida</td>
    <td width="90">orden</td>
  </tr>
<?php  				
$indi=0;
while ($row=mysql_fetch_array($caractexa))
{ $codigo='codcar'.$indi;
  $codigoch='codcarch'.$indi;
  $orden='orden'.$indi;
  if ($indi==0)
    $tipoaux=$row[0];

  if($row[0]!=$tipoaux)
  {
      $tipoaux=$row[0];
	  echo '<tr>
    <td colspan="4"><img src="imagenes/morado.gif" width="100%" height="3" /></td>
    </tr>';
  }
 ?>
  <tr <?php  if ($indi%2!=0) echo 'bgcolor="#E3E3E6"'; ?>   class="texto">
    <td><input name="<?php  echo $codigo;?>" id="<?php  echo $codigo;?>" type="hidden" value="<?php  echo $row[1]; ?>" /> 
	    <input name="<?php  echo $codigoch;?>" id="<?php  echo $codigoch;?>" type="checkbox" value="<?php  echo $row[1]; ?>" /></td>
    <td><?php  echo $row[2]; ?></td>
    <td><?php  echo $row[4]; ?></td>
    <td><input class="texto" name="<?php  echo $orden; ?>" id="<?php  echo $orden; ?>" type="text" value="<?php  echo $row[3]; ?>" size="5" /></td>
  </tr>
<?php  
$indi++; }  ?>
	<tr>
    <td colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
    </tr>
     <td colspan="4" align="center" class="td-buttons">
	  <input type="hidden"  name="ordenar" id="ordenar" value="0"/>
      <input type="hidden" name="eliminar" id="eliminar" value="0" />
      <a href="#" onclick="orden();" class="button-sort" alt="Ordenar"  > <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Ordenar </a>
      <a href="#" onclick="elim();" class="button-delete" alt="Eliminar"  ><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar </a>
	 
	 </td>
    </tr>	

	<tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr class="titulorep" align="center">
    <td width="20">&nbsp;</td>
    <td width="400">Caracter&iacute;sticas No Asociadas </td>
    <td colspan="2">Unidad<br>Medida</td>
    </tr>	
	
<?php 	  		
$caractexa2=$exa->consul_caract_examen_no(); 
$n2=mysql_num_rows($caractexa2);
$indi2=0;
?>
<input name="cantiocu2" id="cantiocu2" type="hidden" value="<?php  echo $n2;?>" />
<?php 
while ($row2=mysql_fetch_array($caractexa2))
{ 
  $nocodigo='nocodcar'.$indi2;
  $nocodigoch='nocodcarch'.$indi2;
?>
  <tr <?php  if ($indi2%2!=0) echo 'bgcolor="#E3E3E6"'; ?>   class="texto">
    <td>
	<input name="<?php  echo $nocodigo;?>" id="<?php  echo $nocodigo;?>" type="hidden" value="<?php  echo $row2[1]; ?>" />
	<input name="<?php  echo $nocodigoch;?>" id="<?php  echo $nocodigoch;?>"  type="checkbox" value="<?php  echo $row2[1]; ?>" /></td>
    <td><?php  echo $row2[2]; ?></td>
    <td colspan="2"><?php  echo $row2[3]; ?></td>
  </tr>
<?php  
$indi2++; 
 }  ?>
  <tr>
    <td height="3" colspan="4"><img src="imagenes/blanco.gif" width="100%" height="3" /></td>
    </tr>
	<tr>
    <td colspan="4" align="center" class="td-btn"><input type="hidden" name="agregar" id="agregar" value="0" />
    <a href="#" onclick="agreg();" class="button-add" alt="Agregar"  > <i class="fa fa-plus" aria-hidden="true"></i> Agregar </a>
	</td>
    </tr>


</table>

</form>
</body>
</html>
