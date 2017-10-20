<?php 
/*
FUNCIÓN DE CONEXION
CREADA POR: Gratelly Garza Morillo
FECHA DE CREACIÓN: 21/01/2010
OBJETIVO: REALIZAR LA CONEXION A LA BASE DE DATOS
*/

function Conectarse()
{
	if (!($link=mysql_connect("localhost","root","temporal")))
	{
		echo "Error conectando a la base de datos.";
		exit();
	}
	if (!mysql_select_db("servinet_sislabcli",$link))
	{
		echo "Error seleccionando la base de datos.";
		exit();
	}
	return $link;
}
function Desconectarse($link)
{
	mysql_close($link);
}
?>
