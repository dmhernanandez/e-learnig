<?php 
$conexion= mysqli_connect("localhost","root","","dbgadalearning");
mysqli_set_charset($conexion,"utf8");

if(!$conexion)
{
	exit ("Error al conectar a la base de datos  ".mysqli_error($conexion));
}
