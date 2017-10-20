<?php 
function calcula_valor($orden,$exam,$carac)
{
$valor=0;
$resu= new resultado('',$orden,$exam,'','','','');
if($carac=='659')
 {	   
   $total= $resu->consul_valor_result($exam,'660');	
   $directa= $resu->consul_valor_result($exam,'658');
   if($total && $directa !='')
   {
    $valor=$total-$directa;
    }
   }

if($carac=='669')
 {	   
   $trigliceridos= $resu->consul_valor_result($exam,'716');	
   $hdl= $resu->consul_valor_result($exam,'668');	
   $colesterol= $resu->consul_valor_result($exam,'667');	
   if($hdl && $colesterol && $trigliceridos!='')
   {
    $valor=$colesterol-(($trigliceridos/5)+$hdl);
    }
   }

if($carac=='670')
 {	   
   $trigliceridos= $resu->consul_valor_result($exam,'716');	
   if($trigliceridos!='')
   {
    $valor=$trigliceridos/5;
    }
   }
if($carac=='768' || $carac=='769' )
 {	   
   $albumina= $resu->consul_valor_result($exam,'648');	
   $proteinas= $resu->consul_valor_result($exam,'702');
   if($albumina && $proteinas !='')
   {
    if($carac=='768')
      $valor=$albumina/($proteinas-$albumina);
	else
	  $valor=$proteinas-$albumina;  
    }
   }


if($carac=='780')
 {	   
   $total= $resu->consul_valor_result($exam,'705');	
   $libre= $resu->consul_valor_result($exam,'704');	
   if($total && $libre!='')
   {
    $valor=($libre/$total)*100;
    }
   }

if($carac=='773')
 {	  
   $talla= $resu->consul_valor_result($exam,'775');	
   $peso = $resu->consul_valor_result($exam,'774');	
   if($talla!=0 && $peso!=0)
    {$valor=sqrt(($talla*$peso)/3600);}
   }
if($carac=='779')
 {	   
   $talla= $resu->consul_valor_result($exam,'775');	
   $peso = $resu->consul_valor_result($exam,'774');	
   $volo = $resu->consul_valor_result($exam,'772');	
   $creo = $resu->consul_valor_result($exam,'777');	
   $cres = $resu->consul_valor_result($exam,'778');	
   $sc = $resu->consul_valor_result($exam,'773');	
   if($talla!=0 && $peso!=0 && $volo!=0 && $creo!=0 && $cres!=0 )
     {$valor= ($creo/$cres)*($volo/1440)*(1.73/$sc);}
   }
if($carac=='783' || $carac=='784' || $carac=='785'  )
 {	  
   $tpcontrol= $resu->consul_valor_result($exam,'781');	
   $tp = $resu->consul_valor_result($exam,'711');	
   $isi = $resu->consul_valor_result($exam,'782');	
   if($tpcontrol!=0 && $tp!=0 && $isi!=0)
    {
	   if($carac=='783')
	    $valor=($tpcontrol/$tp)*100;
	   else	
	      if($carac=='784')
	        $valor=$tp/$tpcontrol;
	      else
		    $valor=($tp/$tpcontrol)*$isi; 
     }
   }
   
 return $valor;
}
?>
