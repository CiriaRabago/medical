<?php 

   header("Content-type: application/vnd.ms-excel; name='excel'");
   header("Content-Disposition: filename=ListaExcel.xls");
   header("Pragma: no-cache");
   header("Expires: 0");
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
include "clases/clase_medico.php";
include "clases/clase_empleado.php";
include "clases/clase_beneficiario.php";
include "clases/clase_permiso.php";
include "clases/clase_menu.php";

//"listado_fac_excel.php?getf_in="+getf_in+"&getf_fi="+getf_fi+"&getser="+getser+"getced="+getced+"getemp="+getemp+"getmed"+getmed+"";
$ser= new servicio($_GET["getser"],'','','','','','','','','','','');
$reg=$ser->listado_fact2($_GET["getf_in"],$_GET["getf_fi"],$_GET["getser"],$_GET["getced"],'',$_GET["getemp"],$_GET["getmed"]);//echo 'entro a verificar';
            $emp= new empresa('','','','','','','','','','');
            $emp=$emp->ver_empre($_GET["getemp"]);
            if($emp!=false) 
            {
              $nom_empresa=$emp;
            }
    if($reg!=false)
    {
      $titulo='LISTADO DE FACTURACI&Oacute;N';
      if($_POST['estado']!='') $titulo.='<br> ATENDIDO';
      if($_GET["getf_in"]!='') $titulo.='<br>DESDE: '.$_GET["getf_in"];
      if($_GET["getf_fi"]!='') $titulo.=' HASTA: '.$_GET["getf_fi"];
      if($nom_empresa!='false') $titulo.='<br>EMPRESA: '.$nom_empresa;

      /*if($_POST['servicio']!='') $titulo.='<br>EN EL SERVICIO: '.$_POST['nser'];
      if($_POST['cedula']!='') $titulo.='<br>DEL PACIENTE: '.$_POST['cedula'];
      if($_POST['empresa']!='') $titulo.='<br>DE LA EMPRESA: '.$_POST['nemp'];
      if($_POST['medico']!='') $titulo.='<br>MEDICO: '.$_POST['nmed'];*/


    
  ?> <table width="500" border="1">
  <tr>
    <td width="20">RAZON SOCIAL</td>
    <td width="20">UNIDAD MEDICA CHURCHIL</td>
  <tr>
    <td width="20">RIF</td>
    <td width="20">J-30843945-2</td>
  </tr>
  <tr>
    <td width="20">ELABORADO POR</td>
<td width="20">MARIA HERMINIA SIFONTES</td>
  </tr>
  <tr>
    <td width="20">CARGO</td>
    <td width="20">OPERARIO</td>
  </tr>
  <tr>
    <td width="20">RESPONSABLE</td>
    <td width="20">EMMA HERRERA</td>
  </tr>
  <tr>
    <td width="20">CARGO</td>
    <td width="20">GERENTE ADMINISTRATIVO</td>
  </tr>
  <tr>
    <td width="20">FECHA DE ATENCION</td>
    <td width="20"><?php  echo $_GET["getf_in"]?></td>
     </tr>
  <tr>
    <td width="20">SEMANA</td>
    <td width="20"></td>
     </tr>
  <tr>
    <td width="20">N DE FACTURA</td>
    <td width="20"></td>
  </tr>
  </table>
  <table width="1040" border="1">
        <tr class="titulofor">
        <td width="1040" colspan="12" align="center"><?php  echo $titulo; ?></td>
        
      </tr> 
        <tr class="titulorep">
        <td width="20">N</td>
        <td width="70">FECHA</td>
        <td width="70">MONTO</td>
        <td width="70">C.I. BENEF</td>
        <td width="150">BENEFICIARIO</td>
        <td width="150">TLF. BENEF</td>
        <td width="150">SERVICIO</td>
        <td width="150">C.I. TLAR</td>
        <td width="150">TITULAR</td>
        <td width="140">C.I. MEDICO</td>
        <td width="140">MEDICO</td>
        <td width="140">TLF. MEDICO</td>
        </tr>  
     
<?php        while ($row=mysql_fetch_array($reg))
       { 
        if ($cont%2!=0) $color='bgcolor="#E3E3E6"'; else $color='';
        $cont++;
        $vis= new visita($row[0],'','','','','','','','','','','','');
        $reg2=$vis->datos_empres_vis();
        $row2=mysql_fetch_array($reg2);
        if($row2[1]=='') $empresa='PARTICULAR'; else $empresa=$row2[1];
        switch ($row[12]) 
        { case 'A': $sta='ATENDIDO'; break;
        case 'L': $sta='LISTA DE ESPERA'; break;
        case 'P': $sta='PENDIENTE'; break;
        case 'I': $sta='INCOMPLETO'; break;
        case 'E': $sta='ELIMINADO'; break; }
       $emple= new empleado($row[14],'','','','','','','','','','','','','','','','','','');
       $busemple=$emple->buscar_nom_emple();

       ?>
       <tr class="texto">
          <td width="20"><?php  echo $cont; ?></td>
          <td width="70"><?php  echo $row[1]; ?></td>
           <?php 
           //consulta para ver precio
          $sql_pre="select precio from slc_tab_pre where id_servicio='$row[9]' and id_empresa='$row[10]' ";
          $result_pre=mysql_query($sql_pre);
          $datos_pre=mysql_fetch_array($result_pre);
          $precio=$precio+$datos_pre[0];
          ?>
          <td width="70"><?php  echo $datos_pre[0]; ?></td>
          <td width="70"><?php  echo $row[2]; ?></td>
          <td width="150"><?php  echo $row[3].' '.$row[4]; ?></td>
          <td width="150"><?php  echo $row[5]; ?></td>
          <td width="150"><?php  echo $row[6]; ?></td>
           <?php 

          $sql_benef="select ced_titular,nomb_titular from slc_benef where ced_benf='$row[2]' ";
          $result_benef=mysql_query($sql_benef);
          $datos_benef=mysql_fetch_array($result_benef);
          ?>
          <td width="150"><?php  echo $datos_benef[0]; ?></td>
          <td width="150"><?php  echo $datos_benef[1]; ?></td>
          <td width="140"><?php  echo $row[7]; ?></td>
          <td width="140"><?php  echo $row[8]; ?></td>
          <td width="140">0276-3417815</td></tr>
          <?php }
          ?>
       </table>
      <?php 

}
  ?>