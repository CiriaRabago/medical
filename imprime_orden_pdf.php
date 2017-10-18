<?php
session_start(); 
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_examen.php";
include "clases/clase_resultado.php";
include "clases/clase_empleado.php";
include "clases/clase_perfil.php";
include "clases/clase_usuario.php";
include "clases/clase_calcula.php";
include "clases/clase_firma.php";
include "clases/clase_medico.php";
require('fpdf/fpdf.php');
class PDF extends FPDF
{
		function Header()
		{
			$this->SetFont('Arial','B',8);
			$ord= new orden($_POST['orden'],'','','','','','');
			$result= $ord->ver_orden();
			if ($result) 
			{ $row = mysql_fetch_row($result); }
			$pac=$ord->consul_pac_ID($row[4]);
			$datos=explode('/*',$pac); 
			if($datos[6]=='F')
			   $sexo='Femenino';
			 else
			   $sexo='Masculino';
			$this->Image('imagenes/LogoPDF2.jpg',1,1,19.5,0);
			if(file_exists('fotos/'.$row[4].'.jpg'))
			{
				$this->Image('fotos/'.$row[4].'.jpg',9,1.3,2.5,2);
			}
			$this->SetFont('Arial','B',8);                        
			if($datos[10]!='') $telf=$datos[10]; else $telf=$datos[9];
			$this->SetXY(12,0.8); $this->Cell(0,1,'ORDEN No.:  '.$_POST['orden'],0,0,'L',false); 
			$this->SetXY(12,1.1); $this->Cell(0,1,'FECHA:        '.$row[8],0,0,'L',false); 
			$this->SetXY(12,1.4); $this->Cell(0,1,'CEDULA:      '.$datos[11],0,0,'L',false); 
			$this->SetXY(12,1.7); $this->Cell(0,1,'NOMBRE:     '.$datos[1].' '.$datos[2].' '.$datos[3].' '.$datos[4],0,0,'L',false); 
			$this->SetXY(12,2.0); $this->Cell(0,1,'EDAD:          '.calculaedad($datos[5]),0,0,'L',false); 
			$this->SetXY(12,2.3); $this->Cell(0,1,'TELF:           '.$telf,0,0,'L',false); 
			$this->SetXY(12,2.7); $this->Cell(0,1,'EMPRESA: ',0,0,'L',false);
			$this->SetXY(13.7,3.0); $this->MultiCell(6.5,0.3,$datos[8],0,'J',false);
			$this->Ln(1); 
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final			
			$this->SetY(-1);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Número de página
			$this->Cell(0,0,'Página '.$this->PageNo().'/{nb}',0,0,'C');
		//	$this->Image('firm/18802038.jpg',19,25,2.5,2);
		}
} // fin de la clase
$nom='';
$pdf=new PDF('P','cm','Letter');
$pdf->AliasNbPages();
$linea=0;
$canimpre=0;
$pdf->AddPage();
////////////////////////inicio//////////////////////////////////////////////////////////////
  $con421=0;
  $con456=0;
  $con436=0;
  $con457=0;
  $con414=0;
  $contt=0;
  $orden = $_POST['orden'];
  $fir= new firma($orden,'','','','');
  $rfir=$fir->busca_firma_medico();
  $fi=explode('**',$rfir);
  $ord= new orden($orden,'','','','','','');
  $dat=$ord->ver_orden();
  $err=0;
  $bien=0;
  while ($row = mysql_fetch_row($dat))
  {
    $cedula=$row[4];
   }
  $usu=$cedula;
  $med='0';
  $v= new usuario($usu,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
  $datusu=$v->buscar_usuario_perm();
  $datos=explode('**',$datusu);  
  $f=new firma('','','','','');
  $rv=$f->busca_examen($orden);
  if($rv!='')
      $resultadito=$ord->result_orden_new();
  else	  
      $resultadito=$ord->result_orden_new2();
      if($resultadito!='')
	     {
		   if ($resultadito) 
			{
				$no=mysql_num_rows($resultadito);
				if($no!=0)
				{
				    $cont=0;
					$vectexa="";
					$perfil='';
					$viejo='';
					while ($row2 = mysql_fetch_row($resultadito))
					{						   
	             //      $firm=$f->chequea_examen_firmado($orden,$row2[4]);
	              //     if($firm!=false || $rv=='')
					  // { 
						$cont++;									
						$linea=1;			
						$examen=$row2[4];
						$inforesult=false;
	                    $rr= new resultado('',$orden,$examen,$datos[0],'','','');
						$inforesult=$rr->ver_resultado();
						if($inforesult!=false)
						 {
						 /****************************FIRMA*********************************/							
                           $fn=$f->consultar_examen_firma($orden,$row2[4]);
						   $fni=explode('/*',$fn);	
							if($med!='0' && $med!=$fni[5])
							  {							   	  
							    $linea=$pdf->GetY();
								if($linea<5) $firma=0;
			                    if($med!=''){
								  $firma=1;  
								  $pdf->Image($med,16,$linea,4.5,4.5);
								  }								
							    $med=$fni[5];
								$pdf->AddPage();
							  }
							  $linea=$pdf->GetY();
							  if($linea>19 && $firma==0)
							  {
								if($med!='' && $med!='0'){								    
			                      $pdf->Image($med,16,$linea,4.5,4.5);
								  $firma=1;
								  }							    
							  }							  
							 if($med=='0' && $med!=$fni[5] )
							  {
							  $med=$fni[5];							  
							  }
	                     /****************************FIN FIRMA*********************************/							  
						  if($perfil!=$row2[8] )
						  {
							if($perfil!='' && $obsi!='')
							 {
							  $yprov=$pdf->GetY()+0.1;
			                  $pdf->SetTextColor(0,0,0);
			                  $pdf->SetLineWidth(0.05);
			                  $pdf->SetFont('Arial','B',10);
			                  $pdf->SetXY(1,$yprov);
                              if($obsi!='')
						        { $pdf->MultiCell(19.5,0.5,'Observacion:'.$obsi,'TB','L',true);}
							  $obsi='';
							  }
						    $per = new perfil($row2[7],'','',''); 
							$rper=mysql_fetch_row($per->busca_perfil());
		  			        $yprov=$pdf->GetY()+0.1;
			                $pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
			                $pdf->SetFillColor(227,227,230);
			                $pdf->SetTextColor(0,0,0);
			                $pdf->SetFont('Arial','B',10);
			                $pdf->SetXY(1,$yprov);
			                $pdf->MultiCell(19.5,0.5,'AREA: '.$row2[8],'TB','L',false);
			                if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
	
                            $perfil=$row2[8];
						  }
						  $obsi=$inforesult[1];
						  $idresulta=$_POST['idresulta'.$inforesult[2]];
						  $rr= new resultado($idresulta,$orden,$examen,$datos[0],'','','');
	                      $yprov=$pdf->GetY();
			              $pdf->SetDrawColor(255,255,255);//naranja (245,130,33)
						  $pdf->SetFillColor(227,227,230);
						  $pdf->SetTextColor(0,0,0);
			              $pdf->SetFont('Arial','B',8);			
						 }
	/****************************NUEVO*********************************/	
	
	                   $examen=$row2[4];					
						$res= new resultado('',$orden,$examen,'','','','');
						$infore=$res->ver_resultado();
	                    $n=0;
						$exa=new examen($examen,'','','','','','','','');
		                $caractexa=$exa->consul_caract_examen($examen);
		                $n=mysql_num_rows($caractexa);
	  	  	            if($n!=0)
		                 {						 
				           $indi=0;
					       while ($row3=mysql_fetch_array($caractexa))
					         { 
							   if($examen!='421' && $examen!='456' && $examen!='436' && $examen!='457' && $examen!='414')
							   {
							     $contt=1;
							     $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
						         $resu= new resultado('',$orden,'','','','','');
						         $valo= $resu->consul_det_result($examen,$row3[1]);	
						         if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
						         if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
							     $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
							      if($valores==false)
							            { 			
										if($valo[0]!= 'P' && $valo[0]!= 'N')
										 {
										   
										  if($row3[7]=='CALCULADO')
										   {										      
										     $val=calcula_valor($orden,$examen,$row3[1]);
											 if($val=='0')$val='-';
                                             else {											 
											 if($examen=='463' && $val>100) $val=100;
                                             $decimal=explode('.',$val);	  
										     //$valorcito=number_format($val);
										     if($decimal[1]!=0)$val=number_format($val,1,',','');
											    }
										   }
										   else
										      $val=$valo[0];										   	   
										  $pdf->Cell(4,0.5,$val,0,0,'L',false);
										 }
							            }
							         else
							          {	
									  $pdf->Cell(4,0.5,$valores,0,0,'L',false);
									  }
						             if($row3[4]!=' ' && !empty($row3[4])) 
						             {
									 $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);
						             }	
									 else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
						            $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
						            $dato='';								 
						            if($valoresref!=false)
						             {
									 while ($rowsa=mysql_fetch_array($valoresref))
					                  {									   
									   $yprov=$pdf->GetY()+0.1;			                     
			                           $pdf->SetXY(17,$yprov);
									   $pdf->MultiCell(15,0.2,$rowsa[1].'       '.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
									   }
						             }


									 else
									 $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
						            $pdf->Cell(4,0.5,'',0,1,'L',false);			
			 	                } //end  if($examen!=421 $$ $examen!=456 && $examen!=436 && $examen!=457)
								else
								{
								  if($examen=='421') $con421=$row3[1];
								  if($examen=='456') $con456=$row3[1];
								  if($examen=='436') $con436=$row3[1];
								  if($examen=='457') $con457=$row3[1];
								  if($examen=='414') $con414=$row3[1];
								}
							}}
			 	 				 
	/****************************FIN NUEVO*********************************/	
				if($pdf->GetY()>=24 && $fi[1]!=''){
	                    // $pdf->Image($fi[1],16,23.5,4.5,4.5);
							    $linea=0;}
					//	} //if($firm!		
				     } // END while ($row2 =
				 } // END if($no!=0)
			   } // END if ($resultadito)
			} // END if($resultadito!='')	 	 
			$pdf->SetTextColor(0,0,0);
			                  $pdf->SetLineWidth(0.05);
			                  $pdf->SetFont('Arial','B',10);
			                  $yprov=$pdf->GetY()+0.1;
			                  $pdf->SetXY(1,$yprov+2);
            if($obsi!='')
			{			              
              $pdf->MultiCell(19.5,0.5,'Observacion:'.$obsi,'TB','L',true);
			 }			 
	/****************************FIRMA*********************************/														
	        if($med!='0' && $contt>0 && $rv!='')
			  {  	  
				 $linea=$pdf->GetY();		
				 if($med!='' && $med!='0' )						  
			     $pdf->Image($med,16,$linea,4.5,4.5);
			   }
	/****************************FIN FIRMA*********************************/							  
////////////////////////fin/////////////////////////////////////////////////////////////////
if($con421!='0' || $con456!='0' || $con457!='0')
 {
  $exa=new examen('421','','','','','','','','');
  if($contt==1)
   {
    $pdf->AddPage();
    $yprov=$pdf->GetY()+0.1;
    $pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
    $pdf->SetFillColor(227,227,230);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetLineWidth(0.05);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetXY(1,$yprov);
    $pdf->MultiCell(19.5,0.5,'AREA: SEROLOGIA','TB','L',false);
   }
   if($con421!='0')
    {
   $contt=1;
   if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
   $caractexa=$exa->consul_caract_examen('421');
   $n=mysql_num_rows($caractexa);
   if($n!=0)
    {						 
     $indi=0;
     while ($row3=mysql_fetch_array($caractexa))
      { 
	   $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
	   $resu= new resultado('',$orden,'','','','','');
	   $valo= $resu->consul_det_result('421',$row3[1]);	
	   if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
	   if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
	   $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
	   if($valores==false)
	    { 			
	     if($valo[0]!= 'P' && $valo[0]!= 'N')
		  {
		  if($row3[7]=='CALCULADO')
		   {										      
		     $val=calcula_valor($orden,'421',$row3[1]);
		     if($val=='0')$val='-';
             else {
              $decimal=explode('.',$val);	  
			  if($decimal[1]!=0)$val=number_format($val,3,',','');
			  }
			}
			else
			  $val=$valo[0];										   	   
			$pdf->Cell(4,0.5,$val,0,0,'L',false);
		  }
	     }
	    else
	   {	$pdf->Cell(4,0.5,$valores,0,0,'L',false);  }
	    if($row3[4]!=' ' && !empty($row3[4])) 
		  { $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);}	
	    else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
	    $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
	    $dato='';								 
	    if($valoresref!=false)
	     {
		  while ($rowsa=mysql_fetch_array($valoresref))
		   {									   
		    $yprov=$pdf->GetY()+0.1;			                     
		    $pdf->SetXY(17,$yprov);
		    $pdf->MultiCell(15,0.2,$rowsa[1].'-'.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
		   }
	     }
	  else
	    $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
	  $pdf->Cell(4,0.5,'',0,1,'L',false);	
	   }  //end while($row3
	  }
	} 
if($con456!='0')
    {
	$exa=new examen('456','','','','','','','','');
   $contt=1;
   if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
   $caractexa=$exa->consul_caract_examen('456');
   $n=mysql_num_rows($caractexa);
   if($n!=0)
    {						 
     $indi=0;
     while ($row3=mysql_fetch_array($caractexa))
      { 
	   $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
	   $resu= new resultado('',$orden,'','','','','');
	   $valo= $resu->consul_det_result('456',$row3[1]);	
	   if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
	   if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
	   $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
	   if($valores==false)
	    { 			
	     if($valo[0]!= 'P' && $valo[0]!= 'N')
		  {
		  if($row3[7]=='CALCULADO')
		   {										      
		     $val=calcula_valor($orden,'456',$row3[1]);
		     if($val=='0')$val='-';
             else {
              $decimal=explode('.',$val);	  
			  if($decimal[1]!=0)$val=number_format($val,3,',','');
			  }
			}
			else
			  $val=$valo[0];										   	   
			$pdf->Cell(4,0.5,$val,0,0,'L',false);
		  }
	     }
	    else
	   {	$pdf->Cell(4,0.5,$valores,0,0,'L',false);  }
	    if($row3[4]!=' ' && !empty($row3[4])) 
		  { $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);}	
	    else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
	    $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
	    $dato='';								 
	    if($valoresref!=false)
	     {
		  while ($rowsa=mysql_fetch_array($valoresref))
		   {									   
		    $yprov=$pdf->GetY()+0.1;			                     
		    $pdf->SetXY(17,$yprov);
		    $pdf->MultiCell(15,0.2,$rowsa[1].'-'.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
		   }
	     }
	  else
	    $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
	  $pdf->Cell(4,0.5,'',0,1,'L',false);	
	   }  //end while($row3
	  }
	}   
if($con456!='0')
    {
	$exa=new examen('457','','','','','','','','');
   $contt=1;
   if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
   $caractexa=$exa->consul_caract_examen('457');
   $n=mysql_num_rows($caractexa);
   if($n!=0)
    {						 
     $indi=0;
     while ($row3=mysql_fetch_array($caractexa))
      { 
	   $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
	   $resu= new resultado('',$orden,'','','','','');
	   $valo= $resu->consul_det_result('457',$row3[1]);	
	   if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
	   if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
	   $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
	   if($valores==false)
	    { 			
	     if($valo[0]!= 'P' && $valo[0]!= 'N')
		  {
		  if($row3[7]=='CALCULADO')
		   {										      
		     $val=calcula_valor($orden,'457',$row3[1]);
		     if($val=='0')$val='-';
             else {
              $decimal=explode('.',$val);	  
			  if($decimal[1]!=0)$val=number_format($val,3,',','');
			  }
			}
			else
			  $val=$valo[0];										   	   
			$pdf->Cell(4,0.5,$val,0,0,'L',false);
		  }
	     }
	    else
	   {	$pdf->Cell(4,0.5,$valores,0,0,'L',false);  }
	    if($row3[4]!=' ' && !empty($row3[4])) 
		  { $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);}	
	    else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
	    $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
	    $dato='';								 
	    if($valoresref!=false)
	     {
		  while ($rowsa=mysql_fetch_array($valoresref))
		   {									   
		    $yprov=$pdf->GetY()+0.1;			                     
		    $pdf->SetXY(17,$yprov);
		    $pdf->MultiCell(15,0.2,$rowsa[1].'-'.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
		   }
	     }
	  else
	    $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
	  $pdf->Cell(4,0.5,'',0,1,'L',false);	
	   }  //end while($row3
	  }
	}   	
	/****************************FIRMA*********************************/												
    $fir= new firma($orden,'','','','');
	$firma=$fir->consultar_examen_firma($orden,'421');
	$fi=explode('/*',$firma);	  
	$linea=$pdf->GetY();
	if($fi[5]!='')								  
	 $pdf->Image($fi[5],16,$linea,4.5,4.5);
	/****************************FIN FIRMA*********************************/							  
}
if($con436!='0')
{
$exa=new examen('436','','','','','','','','');
if($contt==1){
$pdf->AddPage();
$yprov=$pdf->GetY()+0.1;
$pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
$pdf->SetFillColor(227,227,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(0.05);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(1,$yprov);
$pdf->MultiCell(19.5,0.5,'AREA: SEROLOGIA','TB','L',false);
if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
}$contt=1;


 $caractexa=$exa->consul_caract_examen('436');
 $n=mysql_num_rows($caractexa);
 if($n!=0)
  {						 
   $indi=0;
   while ($row3=mysql_fetch_array($caractexa))
    { 
	 $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
	 $resu= new resultado('',$orden,'','','','','');
	 $valo= $resu->consul_det_result('436',$row3[1]);	
	 if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
	 if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
	 $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
	 if($valores==false)
	  { 			
	   if($valo[0]!= 'P' && $valo[0]!= 'N')
		{
		  if($row3[7]=='CALCULADO')
		   {										      
		     $val=calcula_valor($orden,'436',$row3[1]);
		     if($val=='0')$val='-';
             else {
              $decimal=explode('.',$val);	  
			  if($decimal[1]!=0)$val=number_format($val,3,',','');
			  }
			}
			else
			  $val=$valo[0];										   	   
			$pdf->Cell(4,0.5,$val,0,0,'L',false);
		}
	  }
	  else
	   {	$pdf->Cell(4,0.5,$valores,0,0,'L',false);  }
	  if($row3[4]!=' ' && !empty($row3[4])) 
		{ $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);}	
	  else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
	  $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
	  $dato='';								 
	  if($valoresref!=false)
	   {
		while ($rowsa=mysql_fetch_array($valoresref))
		{									   
		 $yprov=$pdf->GetY()+0.1;			                     
		 $pdf->SetXY(17,$yprov);
		 $pdf->MultiCell(15,0.2,$rowsa[1].'-'.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
		}
	   }
	  else
	   $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
	  $pdf->Cell(4,0.5,'',0,1,'L',false);	
	}  //end while($row3
	}
/****************************FIRMA******************************/
	$fir= new firma($orden,'','','','');
	$firma=$fir->consultar_examen_firma($orden,'436');
	$fi=explode('/*',$firma);	  
	$linea=$pdf->GetY();					
	if($fi[5]!='')			  
	$pdf->Image($fi[5],16,$linea,4.5,4.5);
	/****************************FIN FIRMA*********************************/							  
}
if($con414!='0')
{
$exa=new examen('414','','','','','','','','');
if($contt==1){
$pdf->AddPage();
$yprov=$pdf->GetY()+0.1;
$pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
$pdf->SetFillColor(227,227,230);
$pdf->SetTextColor(0,0,0);
$pdf->SetLineWidth(0.05);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(1,$yprov);
$pdf->MultiCell(19.5,0.5,'AREA: COAGULACION','TB','L',false);
if($n>1) $pdf->Ln(0.1); else $pdf->Ln(0.3);
}$contt=1;


 $caractexa=$exa->consul_caract_examen('414');
 $n=mysql_num_rows($caractexa);
 if($n!=0)
  {						 
   $indi=0;
   while ($row3=mysql_fetch_array($caractexa))
    { 
	 $pdf->Cell(8,0.5,$row3[2],0,0,'L',false);
	 $resu= new resultado('',$orden,'','','','','');
	 $valo= $resu->consul_det_result('414',$row3[1]);	
	 if($valo[0]== 'P') $pdf->Cell(4,0.5,'Positivo',0,0,'L',false);
	 if($valo[0]== 'N') $pdf->Cell(4,0.5,'Negativo',0,0,'L',false);
	 $valores=$exa->consul_valores_caract3($row3[1],$valo[0]);
	 if($valores==false)
	  { 			
	   if($valo[0]!= 'P' && $valo[0]!= 'N')
		{
		  if($row3[7]=='CALCULADO')
		   {										      
		     $val=calcula_valor($orden,'414',$row3[1]);
		     if($val=='0')$val='-';
             else {
              $decimal=explode('.',$val);	  
			  if($decimal[1]!=0)$val=number_format($val,3,',','');
			  }
			}
			else
			  $val=$valo[0];										   	   
			$pdf->Cell(4,0.5,$val,0,0,'L',false);
		}
	  }
	  else
	   {	$pdf->Cell(4,0.5,$valores,0,0,'L',false);  }
	  if($row3[4]!=' ' && !empty($row3[4])) 
		{ $pdf->Cell(4,0.5,' ('.$row3[4].')',0,0,'L',false);}	
	  else { $pdf->Cell(4,0.5,' ',0,0,'L',false);    }
	  $valoresref=$exa->consul_valores_ref($row3[1],$datos[6],calculaedad($datos[5]));
	  $dato='';								 
	  if($valoresref!=false)
	   {
		while ($rowsa=mysql_fetch_array($valoresref))
		{									   
		 $yprov=$pdf->GetY()+0.1;			                     
		 $pdf->SetXY(17,$yprov);
		 $pdf->MultiCell(15,0.2,$rowsa[1].' a '.$rowsa[2].' ('.$rowsa[3].')','','L',false);					
		}
	   }
	  else
	   $pdf->Cell(4,0.5,'-',0,0,'L',false);									 
	  $pdf->Cell(4,0.5,'',0,1,'L',false);	
	}  //end while($row3
	}
/****************************FIRMA*********************************/											
	$fir= new firma($orden,'','','',''); 
	$firma=$fir->consultar_examen_firma($orden,'414');
	$fi=explode('/*',$firma);	  
	$linea=$pdf->GetY();
	if($fi[5]!='')								  
	$pdf->Image($fi[5],16,$linea,4.5,4.5);
	/****************************FIN FIRMA*********************************/							  
  $ord= new orden($_POST['orden'],'','','','','','');
  $result= $ord->ver_orden();
  if ($result) 
  { $row = mysql_fetch_row($result); }
  $pac=$ord->consul_pac_ID($row[4]);
  $datos=explode('/*',$pac);
	$pdf->Image('imagenes/propaganda.jpg',1,15,6,8);
    $pdf->SetXY(8,15);
	$pdf->Cell(1,0.5,'Nombre :',0,1,'C',false);	
	$pdf->Image('imagenes/Logo1.png',11,15,2,2);
	$pdf->SetXY(7,16);
	$pdf->Cell(1,0.5,$datos[1].' '.$datos[2].' ',0,1,'L',false);	
	$pdf->SetXY(7,16.5);
	$pdf->Cell(1,0.5,$datos[3].' '.$datos[4],0,1,'L',false);	
	$pdf->SetXY(7,17);
	$pdf->Cell(1,0.5,'C.I. :'.$datos[0],0,1,'L',false);	
	$pdf->SetXY(7,17.5);
	$pdf->Cell(1,0.5,'Fecha Emisiòn: ',0,1,'L',false);	
	$pdf->SetXY(7,18);
	$pdf->Cell(1,0.5,gmdate("d-m-Y"),0,1,'L',false);
	$pdf->SetXY(8,21);

if($fi[5]!='')
  {
  $linea=$pdf->GetY();
  $pdf->Image($fi[5],8,20.5,2.5,2.5);
   }
else
	$pdf->Cell(1,0.5,'____________________',0,1,'L',false);
	$pdf->SetXY(8,21.5);
	$pdf->Cell(1,0.5,'BIOANALISTA',0,1,'L',false);		
	$pdf->SetFont('Arial','B',14);	
	$pdf->SetXY(10,18.5);
    $grupo=explode(' ',$valores);	  
	$pdf->Cell(1,0.5,'GRUPO',0,1,'C',false);	
	$pdf->SetXY(10,19);
	$pdf->Cell(1,0.5,'"'.$grupo[0].'"',0,1,'C',false);
    $pdf->SetXY(10,19.5);
    $pdf->Cell(1,0.5,'FACTOR Rh',0,1,'C',false);	
	$pdf->SetXY(10,20);
	$pdf->Cell(1,0.5,$grupo[1],0,1,'C',false);	
	
}
$pdf->Output();
?>
