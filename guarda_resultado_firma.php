<?php  
session_start();
include "clases/clase_conexion.php";
include "clases/clase_perfil.php"; 
include "clases/clase_examen.php";
include "clases/clase_orden.php";
include "clases/clase_usuario.php";
include "clases/clase_resultado.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form method="post" name="form1">
<input type="hidden" name="orden" id="orden" value="<?=$_POST['orden'];?>"  />
 <?php 
  $orden = $_POST['orden'];
  $usu=$_SESSION["cedu_usu"];
  $verif= new usuario($usu,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
  $datusu=$verif->buscar_usuario_perm();
  $datos=explode('**',$datusu);  
  $orden = $_POST['orden'];
  $ord= new orden($orden,'','','','','','');
  $dat=$ord->ver_orden();
  $err=0;
  $bien=0;
  $nue=0;
  $mod=0;
  $total=0;
  while ($row = mysql_fetch_row($dat))
  {
    $cedula=$row[4];
	$cantidadex=$row[11];
   }

      $resultadito=$ord->result_orden_new();
      if($resultadito!='')
	     {
		   if ($resultadito) 
			{
				$no=mysql_num_rows($resultadito);
				if($no!=0)
				{
				    $cont=0;
					$vectexa="";
					$conta=0;
					while ($row2 = mysql_fetch_row($resultadito))
					{				
						$cont++;
						$status=' ';
						if($row2[6]=='N') $status='Pendiente';
						if($row2[6]=='M') $status='Guardado Incompleto'; 						
						$examen=$row2[4];				
						$rr= new resultado('',$orden,$examen,$datos[0],'','','');
						$inforesult=$rr->ver_resultado();
						if($inforesult!=false)
						 {
						  $idresulta=$_POST['idresulta'.$inforesult[2]];						  
						  $obs='obs'.$row2[8];
						  $rr= new resultado($idresulta,$orden,$examen,$datos[0],$_POST[$obs],'','');
	                      $idresul=$rr->mod_result();
						  if($idresul==false)				              
						  {
						    $err=1;						    
						   }
						 }
						else
						 {
						 $rr= new resultado('',$orden,$examen,$datos[0],$_POST['obs'],'','');
	                     $idresul=$rr->ins_result();
						 $idresulta=$idresul;
						 if($idresul==false)				              
						  {
						    $err=1; 						    
						   }
						 }
	                    $n=0;
						$exa=new examen($examen,'','','','','','','','');
		                $caractexa=$exa->consul_caract_examen($examen);
		                $n=mysql_num_rows($caractexa);
	  	  	            if($n!=0)
		                 {				           
					      $indi=0;
						  						  
					      while ($row=mysql_fetch_array($caractexa))
					       {
						     if($row[7]=='CALCULADO') $nue++; 
						     $car =$row[1];
							 $res =$_POST['caract'.$examen.$row[1]];
							 $um  =$row[6]; 						     
							 $re= new resultado($idresulta,$orden,$examen,$datos[0],'','','');
							 $exis=$re->consul_det_result($examen,$car);
							 if($exis!='')
							 { 
							   if($res!='' && $res!='0') 
							   $mod++;
							   $guarde=$re->mod_det_result($car,$res,$um,$idresulta);
				               if($guarde!=false)				              
							    { $bien++;	}
							    else
							    {  $err=1;	 }
							  }
							  else
							   {	  
							    if($res!='' && $res!='0') 
							      $nue++;
							    $guard=$re->ins_det_result($car,$res,$um,'1');
				                if($guard==false)
				                 { $err=1; }
								else
								 { $bien++; } 
							 
							  }
							  	$total++;
							  
						   } //END while ($row=
						   if($total==($nue+$mod))
							    $conta++;						   
						  } //END if($n!=0) 
				     } // END while ($row2 =
					 $modor=$ord->mod_orden($orden,'','','','','','',$total,($nue+$mod));
				 } // END if($no!=0)
			   } // END if ($resultadito)
			} // END if($resultadito!='')	 	 
			if($err==0)
			{
			 echo "<script>alert('GUARDADO EXITOSAMENTE');
			               document.form1.action='mod_resu_exam.php';
                           document.form1.submit(); 
			       </script>";
			 }
			else
			{ 
			 echo "<script>alert('ERROR GUARDANDO RESULTADOS...INTENTE NUEVAMENTE');
			               document.form1.action='firma_resultado.php';
                           document.form1.submit(); 
			       </script>";
			}	  		    

?>
</form>
</body>
</html>
