<?php session_start();
include "clases/clase_conexion.php";
include "clases/clase_empresa.php";
include "clases/clase_paciente.php";
include "clases/clase_beneficiario.php";
include "clases/clase_benef.php";
include "clases/clase_pac_req.php";
$fecha_ac= @date("Y-m-d");//fecha
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilolab.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
  color: #FF0000;
  font-weight: bold;
}
.Estilo2 {color: #FF0000}
-->
</style>
<link href="../laboratorio/estilolab.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">

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
function buscar()
{
 if(document.getElementById('ced').value!='')
 {
   document.form1.ocu_b.value=1;
   document.form1.submit();
 }
 else
    alert('Debe indicar el Número de Cedula');

}
</script>
<form name="form1" id="form1" method="post" action="verificar_documentos.php" enctype="multipart/form-data">
  <?php 

$pac= new paciente($_POST["ced"],'','','','','','','','','','','','','','');

  if ($_POST["ocu_b"]=='1')
  {

      $bus=$pac->buscar();
    if ($bus!='false')
    { 
      $datos=explode('**',$bus);
      $f1=substr($datos[10],8,2).'/'.substr($datos[10],5,2).'/'.substr($datos[10],0,4);
      $_POST["imafot"]="fotos"."/".$datos[0].".jpg";
      $dian=substr($datos[10],8,2);
      $mesn=substr($datos[10],5,2);
      $añon=substr($datos[10],0,4);
    }
    else
      echo '<script>alert("El Paciente no se encuentra Registrado");</script>';
  }
    ?>
     <table width="791" border="0" align="center">
    <tr class="titulofor">
      <td height="30" colspan="4"><div align="center" class="titulofor">Verificar requisitos</div></td>
    </tr>
   <tr>
      <td class="etiqueta">C&eacute;dula: </td>
      <td colspan="2" class="texto"><label>
        <input name="ced" type="text" class="texto" id="ced" size="25"  value="<?php  echo $datos[1]; ?>" onkeypress='return soloNumeros(event)'/>
        <img src="imagenes/p_buspeq1.gif" alt="Buscar paciente Si EXISTE" width="35" height="25"  style="cursor:hand" onClick="buscar();" onMouseOver="this.src='imagenes/a_buspeq1.gif'"  onMouseOut="this.src='imagenes/p_buspeq1.gif'"/><span class="Estilo1">*</span> s&oacute;lo n&uacute;meros  </label></td>
      <td width="321" rowspan="5" class="texto"><div align="right">
<img src="<?php  echo $_POST["imafot"]?>?<?=time()?>" width="120" height="100" id="foto" name="foto">
<input name="ocu_fot" type="hidden" id="ocu_fot" value="0">
<input name="imafot" type="hidden" id="imafot" value="<?php  echo $_POST["imafot"]; ?>">
 <input type="hidden" name="ocu_b" value="0" />
      </div></td>
    </tr>
        <?php 
    $ben= new benef('','','',''); // PARA DETERMINAR EL PARENTESCO Y SABER QUE DOCUMENTOS MOSTRAR :::::::::::::::: JOSE RAMIREZ
    $regb=$ben->cons_benef2($datos[0]);
    
    if($regb)
     { $benefe=explode('**',$regb);
    }
    if ($benefe!='') {
    if ($benefe[0]==$benefe[1]) {

      $t_paciente=1; //titular
      # code...
    }else $t_paciente=2; // beneficiario
     }?>
    <tr>
      <td  colspan="2" class="etiqueta">Paciente: <?php  echo $datos[2].' '.$datos[3].' '.$datos[4].' '.$datos[5]?></td></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo de paciente:</td>
      <td class="etiqueta">
      <?php  if ($t_paciente==1) {
         echo 'Titular';
         ?>
          </td>
          </tr>
          </table>
          <table width="791" border="0" align="center">
          <tr class="titulofor">
          <td height="30" colspan="4"><div align="center" class="titulofor">Consignados</div></td>
          </tr>
          <?php if(file_exists('cedula/'.$datos[0].'.jpg')) {
          ?>
          <tr><td width="321" rowspan="5" class="texto">Cedula:<div align="right">
          <img src="cedula/<?php echo$datos[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }
          if(file_exists('cedula/'.$datos[0].'.JPG')) {
          ?>
          <tr><td width="321" rowspan="5" class="texto">Cedula:<div align="right">
          <img src="cedula/<?php echo$datos[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }
          if(file_exists('carnet/'.$datos[0].'.jpg')) {?>
          <td width="321" rowspan="5" class="texto">Carnet:<div align="right">
          <img src="carnet/<?php  echo $datos[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          <?php }
         if(file_exists('carnet/'.$datos[0].'.JPG')) {?>
          <td width="321" rowspan="5" class="texto">Carnet:<div align="right">
          <img src="carnet/<?php  echo $datos[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
         
          <?php }
          ?>  </td>
          </tr>
          </table>
          <?php 
      }
    if ($t_paciente==2){
        echo 'Beneficiario';
      ?>
          </td>
          </tr>
          <table width="791" border="0" align="center">
          <tr class="titulofor">
          <td height="30" colspan="4"><div align="center" class="titulofor">Consignados</div></td>
          </tr>
          <?php if(file_exists('cedula/'.$benefe[0].'.jpg')) {//titular
          ?>
          <tr><td width="321" rowspan="5" class="texto">Cedula titular:<div align="right">
          <img src="cedula/<?php echo$benefe[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }if(file_exists('cedula/'.$benefe[0].'.JPG')) {
          ?>
          <tr><td width="321" rowspan="5" class="texto">Cedula titulart:<div align="right">
          <img src="cedula/<?php echo$benefe[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }
          if(file_exists('carnet/'.$benefe[0].'.jpg')) {?>
          <td width="321" rowspan="5" class="texto">Carnet titular:<div align="right">
          <img src="carnet/<?php  echo $benefe[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
          </table>  
         <?php }
         if(file_exists('carnet/'.$benefe[0].'.JPG')) {?>
          <td width="321" rowspan="5" class="texto">Carnet titular:<div align="right">
          <img src="carnet/<?php  echo $benefe[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
           </table>  
          <?php }
          if(file_exists('cedula/'.$datos[0].'.jpg')) {//beneficiario
          ?>
          <table width="791" border="0" align="center">
          <tr><td width="321" rowspan="5" class="texto">Cedula Beneficiario:<div align="right">
          <img src="cedula/<?php echo$datos[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }?>
           <?php if(file_exists('cedula/'.$datos[0].'.JPG')) {
          ?>
          <table width="791" border="0" align="center">
          <tr><td width="321" rowspan="5" class="texto">Cedula Beneficiario:<div align="right">
          <img src="cedula/<?php echo$datos[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          <?php }
          if(file_exists('acta/'.$datos[0].'.jpg')) {?>
          <td width="321" rowspan="5" class="texto">Acta/Partida Beneficiario:<div align="right">
          <img src="acta/<?php  echo $datos[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
          </table>
         <?php }
         if(file_exists('acta/'.$datos[0].'.JPG')) {?>
          <td width="321" rowspan="5" class="texto">Acta/Partida Beneficiario:<div align="right">
          <img src="acta/<?php  echo $datos[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
          </table>
          <?php 
        }
          if(file_exists('carnet/'.$datos[0].'.jpg')) {?>
          <table width="791" border="0" align="center">
          <tr>
          <td width="321" rowspan="5" class="texto">Acta/Partida Beneficiario:<div align="right">
          <img src="carnet/<?php  echo $datos[0]?>.jpg" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
          </table>
         <?php }
         if(file_exists('carnet/'.$datos[0].'.JPG')) {?>
         <table width="791" border="0" align="center">
          <tr>
          <td width="321" rowspan="5" class="texto">Acta/Partida Beneficiario:<div align="right">
          <img src="carnet/<?php  echo $datos[0]?>.JPG" width="200" height="180" id="foto" name="foto">
          </div>
          </td>
          </tr>
          </table>
          <?php 
        }
      }
          ?>

</form>
</body>
</html>

