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
	<title>Crear Curso</title>
	<script type="text/javascript" src="js/"></script>
	<link rel="stylesheet" href="./css/cursosAdministrador.css">
	<link rel="stylesheet" href="./css/menu.css">
</head>
<body >

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
</header>




				<article>
    <div class="espana">
     <form  enctype="multipart/form-data" >
         <label class="titulo">Crear curso</label><br>
     	<label class="etiquetas">Código de curso</label><br>
     	<input type="text" name="codigo" required placeholder="Escriba el Codigo"><br><br>

     	<label class="etiquetas">Nombre del cuso</label><br>
     	<input type="text" name="nombre" required placeholder="Escriba el Nombre"> <br><br>
        <label class="etiquetas">Seleccione una categoria para el curso</label><br>

        	<?php
			 include 'php/conexion.php';
			  $query= "SELECT id_categoria, nombre_categoria FROM categorias";
			  $resultado=mysqli_query($conexion,$query);
                if($resultado)
                {
                    echo "<select name=categoria>";
                     while($opcion=mysqli_fetch_assoc($resultado))
                         echo  "<option value=".$opcion["id_categoria"].">".$opcion["nombre_categoria"]."</option>";

                     echo "</select>";

                     echo "</select><br><br>";
                }
                //Con esta consulta extraemos los nombres de los instructores

                $query= "SELECT idinstructores, CONCAT(Nombres,' ',Apellidos) as nombre FROM instructores";
                $resultado=mysqli_query($conexion,$query);
                if($resultado)
                {
                    echo "<label class=etiquetas>Seleccione un instructor a este curso</label><br>
                            <select name=instructor>";
                    while($opcion=mysqli_fetch_assoc($resultado))
                        echo  "<option value=".$opcion["idinstructores"].">".$opcion["nombre"]."</option>";

                    echo "</select>";

                    echo "</select><br><br>";

                }
			?>
         <label class="etiquetas">Descripcion del Curso</label><br>
        <textarea name="descripcion" required placeholder="Escriba la descripcion"></textarea><br><br>
         <label class="etiquetas">Lo que ofrece el curso al usuario</label><br>
         <p>En este campo se colocara lo que el curso ofrece al usuario, separando cada item con una coma.</p>
        <textarea name="oferta" required placeholder="Escriba la descripcion"></textarea><br><br>
         <label class="etiquetas">Habilidades que aprendera el usario al tomar el curso</label><br>
          <p>En este campo se escribira lo que el usuario aprendera una vez que termine el curso, separando cada item con una coma.</p>
        <textarea name="habilidades" required placeholder="Escriba la descripcion"></textarea><br><br>
        <label class="etiquetas">Estado del curso</label><br>
        <p>Cuando establezca el estado en inactivo no sera visible en la pagina de cursos y no se podra seleccionar para inscribir.</p>
        <select name="estado">
        	<option >Activo</option>
        	<option>Inactivo</option>
        </select><br><br>
         <div id="foto">
         	 <label class="etiquetas">Foto del curso</label><br>
     	     <input type="file" accept="image/*" name="logo" required><br>
     	     <p>Se creara un directorio para almacenar todos los datos  de este curso que tendra el mismo nombre que el codigo de curso</p>
     	     <!--img src="imagenes/curso-virtual.jpg" alt=""-->
         </div>

     	<div id="warning"></div>
     	<button id="crearCurso">Crear curso</button>
         <button onclick="window.location='cursosAdmin.php'">Ver todos los cursos</button>
         <div id="mostrarLogo">
             <img src="images/curso-virtual.jpg" name="logoActual"><br>
         </div>";
	 </form>
                </article>


     <!--Este div se crea cuando el curso se ha creado exitosamente-->

    <script>
//---------------------------------------------------------------------------------------------------
	  document.querySelector("#crearCurso").onclick=function()
	  {

		  if(!document.querySelector("form").checkValidity())
			  {
			     document.querySelector("#warning").innerHTML="<p class=warning-campos-incompletos>Debes llenar todos los campos y subir una foto.</p>";

				 let camposRequeridos= document.querySelectorAll("textarea:required, input:required");

				for(i=0;i<camposRequeridos.length;i++)
					{
					 console.log(camposRequeridos[i].value);
						if(camposRequeridos[i].value===""){

							camposRequeridos[i].classList.add("inputs-requeridos");
						}
					}

						 //valor.setAttribute("class","inputs-requeridos");

				 return;
		     }

		  let TERMINO_PETICION=4;
	      let COMPLETO_PETICION=200;
		  /*
		    var datos=new FormData();
			datos.append("nombre",dat[0])
		  */
		  //Creamos la ruta donde se hara la consulta
		  var url="php/crearCursos/Curso.php";

		  var peticion= new XMLHttpRequest();
		  let datos=new FormData(document.querySelector("form"));
		  datos.append("accion","crear");

		  peticion.open("POST",url,true); //Establezco el metodo, el archivo de peticion y desimos que la peticion es asincrona
		  peticion.send(datos);

		  peticion.onreadystatechange=function()
		  {
				if(peticion.readyState==TERMINO_PETICION && peticion.status==COMPLETO_PETICION)
				{
					if(peticion.response=="error")
					{
						  document.querySelector("form").innerHTML=peticion.response;
					}
				    else
					 {
						 document.querySelector("form").innerHTML=peticion.response;
					 }
				}
		  }
	  }
//----------------------------------------------------------------------------------------------

	</script>
</body>
</html>
