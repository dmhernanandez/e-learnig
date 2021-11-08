<?php

session_name("usuario");
session_start();
if(!isset($_SESSION["user"])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- nuevo -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="./css/cursos.css">
     <link rel="stylesheet" href="./css/menu.css">
    <title>JAVA</title>
</head>

<body>
  <img class="logo" src="./images/logo.png" width="300px" height="" alt="">
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

 <div id="contenido-curso">
  <?php
  if(isset($_GET["idcurso"]))
  {
      include 'php/conexion.php';
      $query="SELECT
                    id_curso,codigo,nombre AS nombreCurso, nombres AS instructor,nombre_categoria,
                    CONCAT('cursos/',codigo,'/',url_foto) AS rutaLogo,
                    cur.descripcion,habilidades,cur.oferta
                     FROM cursos cur JOIN instructores ON id_instructor=idinstructores
                     JOIN categorias ca USING(id_categoria)
                     WHERE estado='Activo' AND id_curso=".$_GET["idcurso"];
      $resultado=mysqli_query($conexion,$query);
      if($resultado)
      {
          while($valor=mysqli_fetch_assoc($resultado))
          {
              echo "
          <p class=titulo>".$valor["nombreCurso"]."</p>
            <div class=imagen>
                <img src=".$valor["rutaLogo"]." width=720 height=455 alt=><br>
                <bottom class='ver' onclick=window.location.href='detalleCurso.php?idcurso=".$_GET["idcurso"]."'>Ver lecciones de este curso</bottom>
                <hr id=barra>
             </div>
           <div class=detalle>
                    <h1 class='categoria'>Categoria: ".$valor["nombre_categoria"]."</h1>
                    <h1 class='instructor'>Instructor: ".$valor["instructor"]."</h1>
                     <p class=desc-curso>".$valor["descripcion"]."</p>
             </div>

        <div class=inCur>
            <p>¿Qué incluye este curso?</p>
            <ul class='oferta'>";
            //Aqui se agrega lo que el curso ofrece al estudiante
               $oferta=explode(",",$valor["oferta"]);
               for($i=0;$i<count($oferta);$i++)
               {
                   echo "<li>".$oferta[$i]."</li>";
               }
           echo" </ul><br>
            <p >¡Lo que aprenderas!</p>
            <ul class='habilidades'>";
              //Aqui se agrega lo que el curso ofrece al estudiante
              $habilidades=explode(",",$valor["habilidades"]);
              for($i=0;$i<count($habilidades);$i++)
              {
                  echo "<li>".$habilidades[$i]."</li>";
              }
              echo"</ul>
        </div>";
          }

      }
  }
  ?>
    </div>
</div>
</body>

</html>
