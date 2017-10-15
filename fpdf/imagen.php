<?php session_start();//Inicio de sesi�n

$md5 = md5(microtime() * mktime()); //Creaci�n de cadena aleatoria

$string = substr($md5,0,4);//No necesitamos 32 caracteres (generados anteriormente) y por lo tanto reducimos a 5

$captcha = imagecreatefrompng("Imagenes/imag3.png");//Creamos una imagen partiendo de una de fondo (debemos subir una imagen de fondo al servidor)

//Configuramos los colores usados para generan las lineas (formato RGB)
    $black = imagecolorallocate($captcha, 0, 0, 0);
    $line = imagecolorallocate($captcha,233,239,239);

//A�adimos algunas lineas a nuestra imagen para dificultar la tarea a los robots
    imageline($captcha,0,0,39,29,$line);
    imageline($captcha,40,0,64,29,$line);

imagestring($captcha, 5, 8, 3, $string, $black);//Ahora escribimos la cadena generada aleatoriamente en la imagen

$_SESSION['key'] = md5($string);//Encriptamos y almacenamos el valor en una variable de sesion

//Devolvemos la imagen para mostrarla
header("Content-type: image/png");
imagepng($captcha);
?>