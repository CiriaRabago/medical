<?php   
			  // Nombre del archivo de con el cual queremos que se guarde la base de datos
			  
			     
				$filename = "RespaldoBDLAB".date("d/m/Y").".sql";  
				// Cabeceras para forzar al navegador a guardar el archivo 
				header("Pragma: no-cache"); 
				header("Expires: 0"); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-type: application/force-download"); 
				header("Content-Disposition: attachment; filename=$filename"); 
				 
				$usuario="gratelly_monigra";  // Usuario de la base de datos, un ejemplo podria ser 'root' 
				$passwd="m2280G2679";  // Contraseña asignada al usuario 
				$bd="gratelly_sislabcli";  // Nombre de la Base de Datos a exportar 
				 
				// Funciones para exportar la base de datos 
				
				//$executa = "c:\\mysql\\bin\\mysqldump.exe -u $usuario --password=$passwd --opt $bd"; 
				//$executa = "..\\..\\mysql\\bin\\mysqldump.exe -u $usuario --password=$passwd --opt $bd";
				$executa = "mysqldump.exe -u $usuario --password=$passwd --opt $bd"; 
				system($executa, $resultado); 
				 
				// Comprobar si se ha realizado bien, si no es así, mostrará un mensaje de error 
				if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; } 
?>