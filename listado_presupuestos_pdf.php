<?php
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php"; 
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empleado.php";
include "clases/clase_permiso.php";//
include "clases/clase_menu.php";//
include "clases/clase_empresa_pres.php";
include "clases/clase_presupuesto.php";
class PDF extends FPDF
{
//Cabecera de página
    function Header()
    {
      $this->Image('imagenes/Logotipo.jpg',4,4,40);
      $this->SetFont('Arial','BI',10); 
      $this->SetXY(10,12); 
      $zone=(3600*-4.5); 
      $fecha=gmdate("d-m-Y", time() + $zone);
      $hora=gmdate("h:i:s A", time() + $zone);
      $this->Cell(0,4,'FECHA: '.$fecha,0,1,'R',false);
      $this->Cell(0,4,'HORA: '.$hora,0,0,'R',false); 
      
      $this->SetFont('Arial','B',18);
      $this->SetXY(10,30); 
      $this->MultiCell(0,10,'Listado de Presupuestos',0,'C',false); 
      $this->SetFont('Arial','BI',10); 
      $this->Ln();  
    }
//Pie de página
    function Footer()
    {
    //Posición: a 1,5 cm del final
    $this->SetY(-6);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','letter'); //
$pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetDrawColor(235,235,235);
    $pres= new presup();
      $ver_pres=$pres->ver_listado_presup3($_GET['comemp'],$_GET['estado'],$_GET['c_desde'],$_GET['c_hasta'],$_GET['v_desde'],$_GET['v_hasta'],$_GET['ch_p2'],$_GET['ch_m2'],$_GET['ch_c2'],$_GET['ch_v2']);
      $cont=0;
    if($ver_pres!=false)
    {
       $pdf->SetFont('Arial','BI',10); 
       $pdf->Cell(7,5,'N',0,0,'L',false);
       $pdf->Cell(50,5,'Proveedor',0,0,'L',false);
       $pdf->Cell(60,5,'Detalle',0,0,'L',false);
       $pdf->Cell(25,5,'Inicio',0,0,'L',false);
       $pdf->Cell(25,5,'Vence',0,0,'L',false);
       $pdf->Cell(25,5,'Monto',0,0,'L',false);
       $pdf->Cell(25,5,'Abonado',0,0,'L',false);
       $pdf->Cell(25,5,'Saldo',0,0,'L',false);
       $pdf->Cell(25,5,'Estatus',0,1,'L',false);
       $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
    
      while ($row=mysql_fetch_array($ver_pres))
       { 

        $cont++;
         if($cont==1)$posy=$pdf->GetY(); else $posy=$ymax;
        {
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(9,$posy);
        $pdf->Cell(7,5,$row[0],0,0,'L',false);

        $ymax=$pdf->GetY(); $pdf->SetXY(15,$posy);
          $pdf->MultiCell(50,5,$row[1],30,'L',false);

        if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();  
        $pdf->SetXY(60,$posy);

          $pdf->MultiCell(60,5,$row[2],20,'L',false);
        if($pdf->GetY()>$ymax) 
        $ymax=$pdf->GetY();  
        $pdf->SetXY(125,$posy);

        $pdf->MultiCell(25,5,$row[3],50,'L',false);
        if($pdf->GetY()>$ymax) 
        $ymax=$pdf->GetY(); 
        $pdf->SetXY(150,$posy);

        $pdf->MultiCell(25,5,$row[4],0,'L',false);
        if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();  
        $pdf->SetXY(175,$posy);

        $pdf->MultiCell(25,5,number_format($row[5], 2, ',', '. '),0,'L',false);
        if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();  
        $pdf->SetXY(200,$posy);

        //calculo montos:::::::::::::

        $sql2="select  SUM(monto_abono) from slc_abono_presu 
        where id_presu=".$row[0]." and estatus='A'";
        $result2 = mysql_query($sql2);
        while($row2 = mysql_fetch_row($result2))
        {
        $monto_abono=$row2[0];
        $monto_xcancelar=$row[5]-$row2[0];
        } 
        $acum_mxc=$acum_mxc+$row[5];//acumulador de montos x cancelar 
        $acum_abo=$acum_abo+$monto_abono;//acumulador de montos abonado
        $acum_sal=$acum_sal+$monto_xcancelar;//acumulador de saldo

       
        $pdf->MultiCell(25,5,number_format($monto_abono, 2, ',', '. '),0,'L',false);
        if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();  
        $pdf->SetXY(225,$posy);

        $pdf->MultiCell(25,5,number_format($monto_xcancelar, 2, ',', '. '),0,'L',false);
        if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();
        $pdf->SetXY(255,$posy);
        switch ($row[6]) 
        {case 'A': $sta='Activo'; break;
        case 'F': $sta='Finalizado'; break;
        case 'J': $sta='Ejecutado'; break;
        case 'X': $sta='X Ejecutar'; break;
        case 'V': $sta='Vencido'; break; 
        case 'E': $sta='Eliminado'; break; 
         }
        $pdf->MultiCell(25,5,$sta,0,'L',false);
        if($pdf->GetY()>$ymax) $ymax=$pdf->GetY();    
          $pdf->Line(10,$ymax,272,$ymax);
       }
       }
       if($pdf->GetY()>$ymax)
        $ymax=$pdf->GetY();  
        $pdf->SetXY(235,$posy);

        $pdf->MultiCell(25,5,number_format($acum_mxc, 2, ',', '. '),0,'L',false);
     }

      
$pdf->Output();
?>