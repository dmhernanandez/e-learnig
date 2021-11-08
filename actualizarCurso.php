
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
    <link rel="stylesheet" href="css/cursosAdministrador.css">
    <link rel="stylesheet" href="css/menu.css">
    <title>Actualizar Datos del curso</title>
</head>
<body>

` <img class="logo" src="./images/logo.png"  width="300px" alt="">
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
<!------------------------------------------------------------------>
<form enctype="multipart/form-data">
    <label class="titulo">Actualizar curso</label><br>
    <div id="mostrarDatos">
        <!--Aqui se mostra todos los datos obtenidos de la base de datos-->
    </div>
    <div id="warning"></div>
    <button name="actualizar">Guardar cambios</button>
    <button onclick="window.location='cursosAdmin.php'">Cancelar y volver a cursos</button>
</form>

<script>
    document.querySelector("form").onsubmit=function(event){
        event.stopPropagation();
        event.preventDefault();
    }
    //------------------------Cargar Datos -----------------------------
    document.querySelector("body").onload=function()
    {
        let url="php/crearCursos/Curso.php";
        let peticion=new XMLHttpRequest();

        let datos=new FormData();
        datos.append("accion","consultaActualizar");
        datos.append("codigo","<?php echo $_GET["codigo"] ?>");

        peticion.open("POST",url,true);
        peticion.send(datos);

        peticion.onreadystatechange=function()
        {
            if(peticion.readyState==4 && peticion.status==200)
            {
                if(peticion.response=="error")
                {
                    alert("Error al recuperar datos del curso");
                    document.querySelector("#mostrarDatos").innerHTML=peticion.response;
                }
                else
                {
                    document.querySelector("#mostrarDatos").innerHTML=peticion.response;
                }
            }
        }

    }
    //---------------------------Enviar datos del formulario-----------------------------------------
    document.querySelector("[name=actualizar]").onclick=function()
    {
        if(!document.querySelector("form").checkValidity()){
            document.querySelector("#warning").innerHTML="<h3>Complete todos los campos</h3>";
            return;
        }
        let url="php/crearCursos/Curso.php";
        let peticion=new XMLHttpRequest();

        let datos=new FormData(document.querySelector("form"));
        datos.append("accion","actualizar");
        datos.append("logoActual",document.querySelector("[name=logoActual]").getAttribute("src"))
        peticion.open("POST",url,true);
        peticion.send(datos);
        peticion.onreadystatechange=function()
        {
            if(peticion.readyState==4 && peticion.status==200)
            {
                if(peticion.response=="error")
                {
                    alert("Error al actualizar datos del curso");
                }
                else
                {
                    alert("Los datos se actualizaron con exito\n"+peticion.response);
                   window.location='cursosAdmin.php';
                    // document.querySelector("body").innerHTML+=peticion.response;
                    //document.querySelector("form").innerHTML=peticion.response;
                }
            }
        }
    }
</script>
</body>
</html>