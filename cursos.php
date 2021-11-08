<?php

session_name("usuario");
session_start();
if(!isset($_SESSION["user"])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos-GADA</title>
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/cursos.css">
    <link rel="stylesheet" href="./css/menu.css">

</head>

<body>
  <img class="logo" src="./images/logo.png"  width="300px" alt="">
    <!--Menu-->
    <header id="cabecera">
            <nav class="menu">
                <ul >
                    <li><a href="cursos.php"> Cursos</a></li>
                    <li id="usuario"><a href="">Opciones</a>
                        <ul>
                            <li><a href="php/usuario.php?accion=salir">Cerrar sesion</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

        </header>


    <!------------------------------------------------------------------>
    <div class="descripcion">


        <article class="contenido">
            <h1>Explora una carrera profesional con GADA e-learning </h1><br>
            <hr>
            <p class="parrafo">
                Encuentra cursos en línea gratis para aprender sobre programacion, uno de los lenguajes de programación más usados del mundo. Con los cursos en línea gratis, aprenderás todo lo necesario para dominar los algoritmos de programación en Java, la entrada
                y salida de datos y en general la programación orientada a objetos. Aprender a programar desde ahora es más fácil, aprovecha la oportunidad y la gran demanda laboral de este lenguaje de programación. La experiencia no es requerida, así
                que puedes disfrutar el proceso de aprender a programar desde cero con los cursos y certificaciones profesionales en línea de GADA e-learning .</p>

        </article>
      </div>

      <div class="espana">
          <?php
        include 'php/conexion.php';
        $query="SELECT id_curso, nombre, nombres As instructor,CONCAT('cursos/',codigo,'/',url_foto) AS rutaLogo   FROM  
                cursos JOIN instructores ON id_instructor=idinstructores  WHERE estado='Activo'";
        $resultado=mysqli_query($conexion,$query);
        if($resultado)
        {
            while($valor=mysqli_fetch_assoc($resultado))
            {
                echo" <article id=c3 class=cur>
                <a class=ver-curso href=verCurso.php?idcurso=".$valor["id_curso"].">
                   <img src=".$valor["rutaLogo"]."  alt=>
                    <hr>
                    <h2 class=nombre-curso>".$valor["nombre"]."</h2>
                     <span class=separador></span>
                    <p class=nombre-instructor>".$valor["instructor"]."</p>
                    <h4 class=tutor>Instructor</h4>
                    <hr class=barra-inferior>
                    </a>
                </article>";
            }
        }


          ?>

          




    </div>
</body>

</html>
