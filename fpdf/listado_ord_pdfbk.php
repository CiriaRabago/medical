<?php 
session_start();
require('fpdf/fpdf.php');
include "clases/clase_conexion.php";
include "clases/clase_orden.php";
include "clases/clase_servicio.php";
include "clases/clase_visita.php";
include "clases/clase_empresa.php";
include "clases/clase_usuario.php";
include "clases/clase_paciente.php";
class PDF extends FPDF
{
//Cabecera de página
		function Header()
		{
			//$this->Image('imagenes/Logotipo.gif',4,4,70);
			if($xxx=='')
			  $xxx=1;
			else
			  $xxx++;  
			$this->SetFont('Arial','BI',10); 
			$this->SetXY(10,12); 
			$zone=(3600*-4.5); 
			$fecha=gmdate("d-m-Y", time() + $zone);
			$hora=gmdate("h:i:s A", time() + $zone);
			$this->Cell(0,4,'PAGINA: '.$this->PageNo(),0,1,'R',false);
			$this->Cell(0,4,'FECHA: '.$fecha,0,1,'R',false);
			$this->Cell(0,4,'HORA: '.$hora,0,0,'R',false); 
			
			$this->SetFont('Arial','B',18);
			$this->SetXY(10,30); 
			$titulo=str_replace('<br>',' ',$_POST['titu']);
			$this->MultiCell(0,10,$titulo,0,'C',false); 
			$this->SetFont('Arial','BI',10); 
			$this->Ln();  
			
		}
//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-10);
			$this->SetFont('Arial','BI',8);
			$this->Cell(0,0,'Avenida Principal Pirineos I lote A Vereda 1, Teléfonos: 0276 - 3568903 4167803 - San Cristóbal',0,0,'C');
			$this->SetY(-7);
			$this->Cell(0,0,'unidadmedicasanluis@hotmail.com',0,0,'C');
		}
} // fin de la clase

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter'); //
$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetDrawColor(235,235,235);
		$xxx=1;
    	$fi=$_GET['fi'];
		$ff=$_GET['ff'];
		$serv=$_GET['serv'];
   		$cont=0;
        $fna1=substr($fi,8,2);
        $fna2=substr($fi,5,2);
	    $fna3=substr($fi,0,4);
	    $fnf1=substr($ff,8,2);
	    $fnf2=substr($ff,5,2);
	    $fnf3=substr($ff,0,4);
		if($serv=='1')
		{
	     $sql="select id_orden,                                      
                    slc_paciente_id_paciente,                      
                    fecha_ing_orden,                               
                    slc_examen_perfil.slc_examen_id_examen,        
                    slc_examen_perfil.id_examen_perfil,            
                    slc_perfil_id_perfil,                          
                    nomb_examen,                                   
                    nomb_perfil                                    
             from slc_orden,                                       
                  slc_det_orden,                                   
                  slc_examen_perfil,                               
                  slc_examen,                                      
                  slc_perfil                                       
             where slc_orden_id_orden= id_orden                    
               and year(fecha_ing_orden)>='".$fna3."'                      
			   and year(fecha_ing_orden)<='".$fnf3."'                      
               and month(fecha_ing_orden)>='".$fna2."'                       
			   and month(fecha_ing_orden)<='".$fnf2."'                       
               and day(fecha_ing_orden)>='".$fna1."'                         
			   and day(fecha_ing_orden)<='".$fnf1."'                         
               and slc_det_orden.slc_examen_id_examen=id_examen      
               and id_perfil = slc_perfil_id_perfil                  
               and tipo_perfil='A'                                   
               and id_examen = slc_examen_perfil.slc_examen_id_examen
			  order by fecha_ing_orden";
		  $titulo= "LISTADO ORDENES LABORATORIO DEL ".$fna1."/".$fna2."/".$fna3." AL ".$fnf1."/".$fnf2."/".$fnf3;
		  $conexion=Conectarse(); 
		  $result=mysql_query($sql,$conexion);
		  $cont=1;
		  $orden=0;
		  $pdf->SetFont('Arial','BI',10); 
		  $pdf->SetXY(39,6);
		  $pdf->Cell(50,5,$titulo,0,0,'C',false);
		  $pdf->SetFont('Arial','BI',6); 
		  while ($row = mysql_fetch_row($result))
		   {
           if($row[0]!=$orden)
		    {
			 $pdf->Ln();
		     $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);
			 $pdf->Ln();
		     $pdf->Cell(50,5,'ORDEN: '.$row[0],0,0,'L',false);
		     $pdf->Ln();
		     $pdf->Cell(50,5,'PACIENTE: '.$row[1],0,0,'L',false);
   		     $pdf->Ln();
		     $pdf->Cell(50,5,'FECHA ORDEN: '.$row[2],0,0,'L',false);
			 $orden=$row[0];
			 $pdf->Ln();
			 $pdf->Cell(60,5,'EXAMEN: ',0,0,'L',false);
		     $pdf->Cell(30,5,'PERFIL: ',0,0,'L',false);
			 $pdf->Cell(10,5,'RESULTADO:',0,0,'L',false);
			 $pdf->Ln();		   
			 }
   		   if($row[6]!='ORINA' && $row[6]!='HECES' && $row[6]!='HEMATOLOGIA COMPLETA')
		      {     
		       $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
		       $pdf->Cell(60,5,$row[6],0,0,'L',false);		   
		       $pdf->Cell(30,5,$row[7],0,0,'L',false);
		       $pdf->Cell(10,5,'________',0,1,'L',false);
			   }
			   else
			    {
	 	          $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
		          $pdf->Cell(60,5,'----------------'.$row[6].' :',0,0,'L',false);		   
				  $sql2="SELECT nomb_caract
						 FROM  slc_caract_examen ce, 
           					   SLC_EXAMEN E,
           					   SLC_CARACT C
						 WHERE CE.SLC_EXAMEN_ID_EXAMEN=E.ID_EXAMEN
                          AND  CE.SLC_CARACT_ID_CARACT=C.ID_CARACT
                          AND  NOMB_EXAMEN = '".$row[6]."'";
				  $xx=3;		   
				  $resulta=mysql_query($sql2,$conexion);
				  while ($row2 = mysql_fetch_row($resulta))
		           {
				    $xx++;
					if($xx>='4')
					 { 
				      $pdf->Ln();
					  $xx=0;
					  }
 		            $pdf->Cell(30,5,$row2[0],0,0,'L',false);
					$pdf->Cell(10,5,'________',0,0,'L',false);		   
					
				    }
					$pdf->Ln();
				}

           }
	   }
	 if($serv=='2')
		{
	     $sql="select id_orden,                                      
                    slc_paciente_id_paciente,                      
                    fecha_ing_orden,                               
                    slc_examen_perfil.slc_examen_id_examen,        
                    slc_examen_perfil.id_examen_perfil,            
                    slc_perfil_id_perfil,                          
                    nomb_examen,                                   
                    nomb_perfil                                    
             from slc_orden,                                       
                  slc_det_orden,                                   
                  slc_examen_perfil,                               
                  slc_examen,                                      
                  slc_perfil                                       
             where slc_orden_id_orden= id_orden                    
               and year(fecha_ing_orden)>='".$fna3."'                      
			   and year(fecha_ing_orden)<='".$fnf3."'                      
               and month(fecha_ing_orden)>='".$fna2."'                       
			   and month(fecha_ing_orden)<='".$fnf2."'                       
               and day(fecha_ing_orden)>='".$fna1."'                         
			   and day(fecha_ing_orden)<='".$fnf1."'                         
               and slc_det_orden.slc_examen_id_examen=id_examen      
               and id_perfil = slc_perfil_id_perfil                  
               and tipo_perfil='A'                                   
               and id_examen = slc_examen_perfil.slc_examen_id_examen
			  order by nomb_perfil, id_orden";
		  $titulo= "LISTADO ORDENES LABORATORIO DEL ".$fna1."/".$fna2."/".$fna3." AL ".$fnf1."/".$fnf2."/".$fnf3;
		  $conexion=Conectarse(); 
		  $result=mysql_query($sql,$conexion);
		  $cont=1;
		  $orden=0;
		  $pdf->SetFont('Arial','BI',10); 
		  $pdf->SetXY(39,6);
		  $pdf->Cell(50,5,$titulo,0,0,'C',false);
		  $pdf->SetFont('Arial','BI',6); 
		  $perfil="";
		  $orden="";
		  while ($row = mysql_fetch_row($result))
		   {
           if($row[7]!=$perfil)
		    {
			$perfil=$row[7];
			 $pdf->Ln();
		     $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);
			 $pdf->Ln();
		     $pdf->Cell(50,5,'ORDENES DE PERFIL '.$perfil,0,0,'C',false);
			 $pdf->Ln();
		     $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);			 
			 }
			 if ($orden!=$row[0]){
			 $orden=$row[0];
			 $pdf->Ln();
		     $pdf->Cell(20,5,'ORDEN: '.$row[0],0,0,'L',false);
		     //$pdf->Ln();
		     $pdf->Cell(25,5,'PACIENTE: '.$row[1],0,0,'L',false);
   		     //$pdf->Ln();
		     $pdf->Cell(30,5,'FECHA ORDEN: '.$row[2],0,0,'L',false);			
			 $pdf->Ln();
			 $pdf->Cell(60,5,'EXAMEN: ',0,0,'L',false);
			 $pdf->Cell(10,5,'RESULTADO:',0,0,'L',false);
			  }	    		   
			  $pdf->Ln();
			  if($row[6]!='ORINA' && $row[6]!='HECES' && $row[6]!='HEMATOLOGIA COMPLETA')
		      {
		        $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
		        $pdf->Cell(60,5,$row[6],0,0,'L',false);		   
		        $pdf->Cell(10,5,'________',0,0,'L',false);
			   }
			   else
			    {
	 	          $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
		          $pdf->Cell(60,5,'----------------'.$row[6].' :',0,0,'L',false);		   
				  $sql2="SELECT nomb_caract
						 FROM  slc_caract_examen ce, 
           					   SLC_EXAMEN E,
           					   SLC_CARACT C
						 WHERE CE.SLC_EXAMEN_ID_EXAMEN=E.ID_EXAMEN
                          AND  CE.SLC_CARACT_ID_CARACT=C.ID_CARACT
                          AND  NOMB_EXAMEN = '".$row[6]."'";
				  $xx=3;		   
				  $resulta=mysql_query($sql2,$conexion);
				  while ($row2 = mysql_fetch_row($resulta))
		           {
				    $xx++;
					if($xx>='4')
					 { 
				      $pdf->Ln();
					  $xx=0;
					  }
 		            $pdf->Cell(30,5,$row2[0],0,0,'L',false);
					$pdf->Cell(10,5,'________',0,0,'L',false);		   
					
				    }
					$pdf->Ln();
				}	
           }
		 }  
		if($serv!='1' && $serv!='2')
		{
		  $cedusu=$_SESSION["cedu_usu"];
		  $bus1= new usuario('','','','',$cedusu,'','','');
		  $usua=$bus1->consulta_usu();
	      $ce1=explode('**',$usua);
		  $condi=$ce1[8];	
		  		if($serv=='SEROLOGIA')$xxx='ORDER BY nomb_examen,slc_orden.id_orden'; else $xxx='ORDER BY slc_orden.id_orden,orden_area';		  
		  $cond='';
		if($_POST['noi']<=$_POST['nof'] && $_POST['noi']!='' && $_POST['nof']!='')		
		   $cond=" and id_orden>=".$_POST['noi']." and id_orden<=".$_POST['nof']." ";		
			   $sql="SELECT   slc_orden.id_orden,
            				   slc_paciente_id_paciente, 
				               fecha_ing_orden, 
            				   nomb_examen, 
            				   abrev_examen,
							   usuario,   
            				   count(*)
					  FROM      slc_orden, 
            					slc_det_orden, 
            					slc_examen_perfil, 
            					slc_examen, 
            					slc_perfil 
					  WHERE   slc_orden_id_orden= id_orden 
    					  and year(fecha_ing_orden)>='".$fna3."'                      
			   			  and year(fecha_ing_orden)<='".$fnf3."'                      
               			  and month(fecha_ing_orden)>='".$fna2."'                       
			   			  and month(fecha_ing_orden)<='".$fnf2."'                       
               			  and day(fecha_ing_orden)>='".$fna1."'                         
			   			  and day(fecha_ing_orden)<='".$fnf1."' 
     					  and slc_det_orden.slc_examen_id_examen=id_examen 
     					  and id_perfil = slc_perfil_id_perfil 
     					  and tipo_perfil='A' 
     					  and id_examen = slc_examen_perfil.slc_examen_id_examen      
     					  and abrev_examen='".$serv."' ".$cond."
					  GROUP BY slc_orden.id_orden,nomb_examen 
					  ".$xxx;		
			
			//echo $sql;   
		  $titulo= "LISTADO ORDENES LABORATORIO DEL ".$fna1."/".$fna2."/".$fna3." AL ".$fnf1."/".$fnf2."/".$fnf3;
		  $conexion=Conectarse(); 
		  $result=mysql_query($sql,$conexion);
		  $cont=1;
		  $orden=0;
		  $pdf->SetFont('Arial','BI',10); 
		  $pdf->SetXY(39,6);
		  $pdf->Cell(50,5,$titulo,0,0,'C',false);
		  $pdf->SetFont('Arial','BI',6); 
		  $perfil="";
		  $orden="";
		  $ex='';
		  while ($row = mysql_fetch_row($result))
		   {
           if($row[4]!=$perfil)
		    {
			$perfil=$row[4];
			 $pdf->Ln();
		     $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);
			 $pdf->Ln();
		     $pdf->Cell(50,5,'ORDENES DE PERFIL '.$perfil,0,0,'C',false);
			 $pdf->Ln();
		     $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);			 
			 }
			 $bus1= new usuario('','','','',$row[5],'','','');
		     $usua=$bus1->consulta_usu();
	         $ce1=explode('**',$usua);			 
			 if($ce1[8]==$condi || $condi=='1')
			 {
			 if ($orden!=$row[0]){
			 $orden=$row[0];
			 $pdf->Ln();
			 /*********  nuevo ********/
			 $yprov=$pdf->GetY()+0.1;
			                  $pdf->SetDrawColor(100,100,100);//naranja (245,130,33)
			                  $pdf->SetFillColor(227,227,230);
			                  $pdf->SetTextColor(0,0,0);
			                  $pdf->SetLineWidth(0.05);
			                  $pdf->SetFont('Arial','B',10);
			 /*******fin nuevo ********/
			 if($serv=='SEROLOGIA' && $ex!=$row[3])
			   	{
				  $ex=$row[3];			      
		          $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);
			      $pdf->Ln();
		          $pdf->Cell(50,5,'EXAMEN : '.$row[3],0,1,'L',false);
			      //$pdf->Ln();
		          $pdf->Cell(50,5,'__________________________________________________________________________________________________',0,0,'L',false);			                  $pdf->Ln();
				}
			 $pac= new paciente($row[1],'','','','','','','','','','','','','','');
	         $regp=$pac->buscar();
	         $datosp=explode('**',$regp);		 
			 $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());			 
		     $pdf->Cell(40,5,'ORDEN: '.$row[0],0,0,'L',false);		     
		     $pdf->Cell(60,5,'PACIENTE: '.$row[1],0,0,'L',false);   		     
		     $pdf->Cell(90,5,'FECHA ORDEN: '.$row[2],0,1,'L',false);			
			 $pdf->Cell(40,5,'NOMBRE: '.$datosp[2]." ".$datosp[3]." ".$datosp[4]." ".$datosp[5],0,0,'L',false);   		     
		     if($serv!='SEROLOGIA')
			   $pdf->Cell(100,5,'EDAD: '.calculaedad($datosp[10]),0,1,'R',false);			
			 else
			   $pdf->Cell(100,5,'EDAD: '.calculaedad($datosp[10]),0,0,'R',false);			  
			 //$pdf->Ln();
			 if($serv!='SEROLOGIA')
			   $pdf->Cell(70,5,'EXAMEN: ',0,0,'L',false);
			 if($serv!='SEROLOGIA')
			 {
			   $pdf->Cell(10,5,'RESULTADO:',0,0,'L',false);
			   $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
			   $pdf->Ln();
			   }
			 else
			   $pdf->Cell(10,5,'RESULTADO:    _________________',0,1,'L',false);  
			   
			  }			  
			  $pdf->SetFont('Arial','BI',6); 
			      		   
			 if($row[3]!='ORINA' && $row[3]!='HECES' && $row[3]!='HEMATOLOGIA COMPLETA')
		      {
			    
		      //  $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
			    if($serv!='SEROLOGIA'){
		          $pdf->Cell(60,5,$row[3],0,0,'L',false);		   
		          $pdf->Cell(10,5,'________',0,1,'L',false);}
				}
			   else
			    {
		   
				  $sql2="select nomb_caract from slc_caract_examen ce,slc_examen e, slc_caract c where ce.slc_examen_id_examen=e.id_examen and ce.slc_caract_id_caract=c.id_caract and nomb_examen = '".$row[3]."' and estatus_examen='0' and estatus_caract='0' ORDER BY orden_caract_examen";
	 	          $pdf->Line(10,$pdf->GetY(),272,$pdf->GetY());
		          $pdf->Cell(60,5,'----------------'.$row[3].' :',0,0,'L',false);
				  $xx=3;		   
				  $resulta=mysql_query($sql2,$conexion);
				  while ($row2 = mysql_fetch_row($resulta))
		           {
				    $xx++;
					if($xx>='4')
					 { 
				      $pdf->Ln();
					  $xx=0;
					  }
 		            $pdf->Cell(30,5,$row2[0],0,0,'L',false);
					$pdf->Cell(10,5,'________',0,0,'L',false);		   
					
				    }
					$pdf->Ln();
				}
           }}
	   } 
		 
$pdf->Output();
?>
