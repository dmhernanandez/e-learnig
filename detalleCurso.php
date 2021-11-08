<?php
session_name("usuario");
session_start();
if(!isset($_SESSION["user"])){
    header("location: index.php");
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Curso</title>
    <link rel="stylesheet" href="./css/elerarning.css">
    <link rel="stylesheet" href="css/estiloTablas.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <!--menu-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./css/main.css">
<!--    <link rel="stylesheet" href="./css/util.css">-->
    <link rel="stylesheet" href="./css/menu.css">



</head>

<body>
    <div class="w3-display-container w3-" style="height:300px;">

 ` <img class="logo" src="./images/logo.png"  width="300px" alt="">
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

`
<!--  <header>-->
<!--      <nav class="navegacion">-->
<!--          <ul class="menu">-->
<!--              <li><a href="index.php">Inicio</a></li>-->
<!--              <li><a href="cursos.php">Cursos</a></li>-->
<!--              <li><a href="registro.php">Registrar</a></li>-->
<!--              <li><a href="php/usuario.php?accion=salir">Cerrar sesion</a></li>-->
<!---->
<!--          </ul>-->
<!---->
<!--      </nav>-->
<!--  </header>-->
<!--        <div class="dropdown">-->
<!--            <button class="dropbtn">Ajustes</button>-->
<!--            <div class="dropdown-content">-->
<!--                <a href="Cursos.php"><i class='fas fa-inbox' style='font-size:15px;color:black'></i>Volver</a>-->
<!--                <a href="cursos.html"><i class='fas fa-power-off' style='font-size:15px;color:black'></i>Salir</a>-->
<!--            </div>-->
<!--        </div>-->


                <table id="tabla-lecciones-usuarios">
                    <thead>
                    <tr>
                        <th class="nombreLeccion">Lección</th>
                        <th class="contenido">¡Lo que aprenderas!</th>
                        <th class="opcion">¿Quieres verla?</th>
                    </tr>
                    </thead>
                    <tbody>
                            <?php
                            include 'php/conexion.php';
                            $query="SELECT id_leccion,nombre_leccion,descripcion,url_documento FROM lecciones WHERE id_curso=".$_GET["idcurso"];
                            $resultado=mysqli_query($conexion,$query);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "
                                <tr>
                               <td>" . $fila["nombre_leccion"] . "</td>
                               <td>" . $fila["descripcion"] . "</td>
                               <td> <a href=mostrarLeccion.php?idLeccion=" . $fila["id_leccion"] . " class=verLeccion target='_blank'>Ver leccion</a></td>
                             </tr>
                              ";
                            }

                            ?>
                    </tbody>
                </table>
</body>

</html>
