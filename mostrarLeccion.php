<?php

session_name("usuario");
session_start();
if(!isset($_SESSION["user"])){
    header("location: index.php");
}
?>
<!doctype html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>
 <?php
     include './php/conexion.php';
     $query = "SELECT url_documento, nombre_leccion AS nombre, CONCAT('cursos/',codigo,'/lecciones/',lecciones.url_documento) AS ruta
               FROM lecciones JOIN cursos USING(id_curso)
               WHERE id_leccion=".$_GET["idLeccion"];
     $resultado=mysqli_query($conexion,$query);
     if($resultado)
     {

       while ($valor=mysqli_fetch_assoc($resultado))
       {

           header('content-type: application/pdf');
           header("Content-Disposition: inline; filename=".$valor["url_documento"]."");
           @readfile($valor["ruta"]);


       }
     }
     ?>
</body>
</html>
