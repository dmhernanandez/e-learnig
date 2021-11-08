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
    <meta charset="utf-8">
    <title>Cursos creados
    </title>
    <link rel="stylesheet" href="./css/Admin.css">
    <link rel="stylesheet" href="./css/estiloTablas.css">
    <link rel="stylesheet" href="./css/menu.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body>
<!--Menu-->
<img class="log" src="./images/logo.png"  width="300px" alt="">
<header id="cabecera">
    <nav class="menu">
        <ul >
            <li><a href="crearCurso.php">Crear Curso</a></li>
            <li><a href="cursosAdmin.php">Administrar Cursos</a></li>
            <li id="usuario"><a href="">Opciones</a>
                <ul>
                    <li><a href="php/usuario.php?accion=salir">Cerrar sesion</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!------------------------------------------------------------------>
    <div class="espana">


        <article>
            <form>
                <i class='fas fa-search'></i>
                <label for="">Buscar curso</label>
                <input type="text"  id="buscar" placeholder="Busca un curso...  ">
                <table id="cursos-registrados">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Curso</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </form>

        </article>


    </div>

</body>

<script>
    document.querySelector("body").onload = function() {

            let TERMINO_PETICION = 4;
            let COMPLETO_PETICION = 200;
            let url = "php/crearCursos/Curso.php";
            let datos = new FormData();
            datos.append("accion", "consultar");
            let peticion = new XMLHttpRequest();
            peticion.open("POST", url, true);
            peticion.send(datos);
            peticion.onreadystatechange = function() {
                if (peticion.readyState == TERMINO_PETICION && peticion.status == COMPLETO_PETICION) {

                    if (peticion.response == "error")
                        alert("Se a producido un error al recuperar los dato");
                    else {
                        document.querySelector("tbody").innerHTML = peticion.response;
                    }

                }
            }
        }
        //------------------------------------------------------------------------
    document.querySelector("#buscar").onkeyup=function () {
        let TERMINO_PETICION = 4;
        let COMPLETO_PETICION = 200;
        let url = "php/crearCursos/Curso.php";
        let datos = new FormData();
        datos.append("filtro", document.querySelector("#buscar").value)
        datos.append("accion", "buscar");
        let peticion = new XMLHttpRequest();
        peticion.open("POST", url, true);
        peticion.send(datos);
        peticion.onreadystatechange = function () {
            if (peticion.readyState == TERMINO_PETICION && peticion.status == COMPLETO_PETICION) {

                if (peticion.response == "error")
                    alert("Se a producido un error al recuperar los dato");
                else
                    document.querySelector("tbody").innerHTML = peticion.response;

            }
        }
    }
</script>

</html>
