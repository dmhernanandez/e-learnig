<?php

session_name("usuario");
session_start();
if(!isset($_SESSION["user"])){
    header("location: index.php");
}
?>
<html>

<head>

    <meta charset="utf-8">
    <title>Proyecto II parcial</title>
    <!--	  <link href="css/leccionesC.css" rel="stylesheet">-->

    <link href="css/cursosAdministrador.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" href="css/estiloTablas.css">
<!---->

</head>
<body>
<?php
session_name("usuario");
session_start();
 if(!isset($_SESSION["user"])){
   header("location: index.php");
 }?>

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
<?php
			 include 'php/conexion.php';
			 $query="SELECT id_leccion,nombre_leccion,estado,descripcion,url_documento FROM lecciones WHERE id_curso=(select id_curso FROM cursos where codigo='".$_GET["codigo"]."')";
			 $resultado=mysqli_query($conexion,$query);
			 $codigoCurso=$_GET["codigo"];
			 if($resultado) {
                 echo "<form enctype=multipart/form-data>";

                 //Extraemos el nombre del curso
                 $getNombre = mysqli_query($conexion, "SELECT id_curso,nombre FROM cursos where codigo='" . $codigoCurso . "'");
                 while ($valor = mysqli_fetch_assoc($getNombre))
                     echo "<label class='titulo'>Lecciones del curso \"" . $valor["nombre"] . "\"</label><br>
                             <input type='hidden' value=" . $valor["id_curso"] . " name='idCurso'>
                             <input type=hidden value=" . $_GET["codigo"] . " name='codigoCurso'>";
                 //Estos input ocultos solo se usan para utilizarlos al guardar los datos
                 echo "
                        <label class='etiquetas'>Escriba el nombre de la leccion</label><br>
                        <input type=text name=nombreLeccion required placeholder='Nombre de lección'><br><br>
                        <label class='etiquetas'>Escriba una breve descripcion sobre lo que tratara la lección</label><br>
                        <textarea name=descripcion required placeholder='Descripción'></textarea><br><br>
                        <label class='etiquetas'>Estado de la lección</label><br>
                        <select name=estado>
                            <option>Activo</option>
                            <option>Inactivo</option>
                        </select><br><br>
                        <label class='etiquetas'>Cargar documento</label><br>
                        <input type=file accept=application/pdf required name=leccion><br><br>
                         <button id=nuevo>Nueva leccion</button>
                        <button id=guardar>Registrar </button>
                        <button id=modificar disabled>Actualizar</button>
                        <button id=eliminar disabled>Eliminar</button>
                       	<div id=mostrarLogo>
						<img src=images/lecciones.png name=logoActual><br>
					</div>
                    </form>
                    <table id=tabla-lecciones>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Leccion</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Opcion</th>
                        </tr>
                        </thead>
                        <tbody>";
                 while ($fila = mysqli_fetch_assoc($resultado)) {
                     echo "<tr>
                               <td>" . $fila["id_leccion"] . "</td>
                               <td>" . $fila["nombre_leccion"] . "</td>
                               <td>" . $fila["descripcion"] . "</td>
                               <td>" . $fila["estado"] . "</td>
                               <td> <a href=mostrarLeccion.php?idLeccion=" . $fila["id_leccion"] . " class=verLeccion target='_blank'>Ver leccion</a></td>
                             </tr>
                              ";
                 }

                 echo "
                    </tbody>
                </table>";
             }
			 else
             {
              echo mysqli_error($conexion);
              echo "<button onclick=window.location='cursosAdmin.php'>Regresar a todos los cursos</button>";
             }

			//Fin de php
			?>

    <div class="espana">


<script>
    /*Creamos las variables glabales que vamos a utilizar*/
    var TERMINO_PETICION=4;
    var COMPLETO_PETICION=200;
    var url="php/crearCursos/Lecciones.php";
    var idFila=1;
    var idModificar=0;
    //Esta funcion se va utilizar para extraer el nombre del archivo una vez que se cambie una leccion
    var nombreLeccion="";

    document.querySelector("form").addEventListener("submit", function(event){
        event.stopPropagation();
        event.preventDefault();
    });

    document.querySelector("body").onload=function ()
    {
        document.querySelectorAll("tbody tr").forEach(function (value,index)
        {
            //Cuando se cargan las filas les asignamos los eventos
            agregarEventosFila(value);
        });
    }

    //------------------------------------------------------------------------------

    //GUARDAR Con esta funcion se guardan los datos y se muestran en la tabla
    document.querySelector("#guardar").addEventListener("click",function(){
        //Validamos que todos los campos requeridos esten llenos
        if(!document.querySelector("form").checkValidity())
        {
            alert("Campos requeridos");
            return;
        }
        let peticion= new XMLHttpRequest();
        let contDatos=new FormData(document.querySelector("form"));
        contDatos.append("accion","crearLeccion");
        peticion.open("POST", url,true);
        peticion.send(contDatos);

        peticion.onreadystatechange=function ()
        {
            if(peticion.readyState==TERMINO_PETICION && peticion.status==COMPLETO_PETICION)
            {
                if(peticion.response=="error")
                {
                    document.querySelector("body").innerHTML+=peticion.response;
                }

                else {
                    //Creamos un elemento con que sera la fila que agregaremos
                    var fila = document.createElement("tr");
                    getValues(peticion.response).forEach(function (value, index) {
                        fila.innerHTML += "<td>" + value + "</td>";
                    });

                    document.querySelector("tbody").appendChild(fila);

                    //Llamamos a la funcion que agrega los  eventos a las filas
                    agregarEventosFila(fila);
                    limpiarSeleccionTabla();
                    resetDefault();

                }
            }
        }
    });//Fin del EVENTO GUARDAR
    //-------------------EVENTO NUEVA LECCION--------------------------------------------------------------------------
    document.querySelector("#nuevo").onclick=function ()
    {
        limpiarSeleccionTabla();
        resetDefault();
    }//Fin del evento NUEVO

    //-----------------------------------------------------------------------------------------------------------------------
    //BOTON DE MODIFICAR: Esta funcion permite guardar las modificaciones en los datos
    document.querySelector("#modificar").addEventListener("click",function()
    {
        if(idModificar==0)
        {
            alert("Debe dar doble click en un elemento de la tabla \npara poder modificar");
            return;
        }

        let peticion= new XMLHttpRequest();
        let contDatos=new FormData(document.querySelector("form"));
        contDatos.append("accion","actualizar");
        contDatos.append("idLeccion",idModificar);
        peticion.open("POST", url,true);
        peticion.send(contDatos);
        peticion.onreadystatechange=function ()
        {
            if (peticion.readyState == TERMINO_PETICION && peticion.status == COMPLETO_PETICION)
            {
                if (peticion.response == "realizado")
                {
                    document.querySelectorAll("tbody tr").forEach(function(fila, indexFIla){
                        if(fila.children[0].innerText==idModificar)
                        {
                            let valores=getValues(idModificar);
                            fila.children[1].innerText=valores[1];
                            fila.children[2].innerText=valores[2];
                            fila.children[3].innerText=valores[3];
                            fila.children[4].innerHTML=valores[4];
                        }
                    });
                    //Reseteamos los campos
                    limpiarSeleccionTabla();
                    resetDefault();
                }
                else
                {
                    document.querySelector("body").innerHTML += peticion.response;
                }

            }


        }

    });//

    //-----------------------------------------------------------------------------------------------------------------------
    document.querySelector("#eliminar").onclick=function(){
        if(document.querySelectorAll(".selected").length==0){
            alert("De click sobre la leccion que desea eliminar");
            return;
        }
        //Obtenemos el id de la fila seleccionada
        let idEliminar=parseInt(document.querySelector(".selected").children[0].innerText);
        let peticion= new XMLHttpRequest();
        let contDatos=new FormData();
        contDatos.append("accion","eliminar");
        contDatos.append("idLeccion",idEliminar);
        peticion.open("POST", url,true);
        peticion.send(contDatos);
        peticion.onreadystatechange=function ()
        {
            if (peticion.readyState == TERMINO_PETICION && peticion.status == COMPLETO_PETICION)
            {
                if (peticion.response != "error")
                {
                    //Eliminamos la fila de la tabla
                    document.querySelectorAll(".selected").forEach(function (value, index) {
                        value.remove();

                    });
                    //Reseteamos los campos
                    resetDefault();
                }
                else
                {
                    document.querySelector("body").innerHTML = peticion.response;
                }

            }
        }


    }
    //########################################################## FUNCIONES ########################################################
    //Con esta funcion agregamos los eventos a las filas cada vez que agregamos una nueva
    function agregarEventosFila(filaSeleccionada)
    {
        filaSeleccionada.onclick = function ()
        {
            document.querySelectorAll("tbody tr").forEach(function (filaSeleccionada, index){
                filaSeleccionada.classList.remove("selected");
            });
            filaSeleccionada.classList.add("selected");
            //Cuando seleccionemos una fila se habilitara el boton de eliminar
            document.querySelector("#eliminar").removeAttribute("disabled");
        }
        //-----------------------------------------------------------------------------------------------------------------------
        //Agregamos los datos cuando se doble click sobre los datos
        filaSeleccionada.ondblclick = function ()
        {
            let valores = filaSeleccionada.children;
            //Asignamos a modificar el valor de ID en la tabla
            idModificar = valores[0].innerText;
            document.querySelector("[name=nombreLeccion]").value = valores[1].innerText;
            document.querySelector("[name=descripcion]").value = valores[2].innerText;
            document.querySelector("[name=estado]").value = valores[3].innerText;

            document.querySelector("#modificar").removeAttribute("disabled");
            document.querySelector("#eliminar").removeAttribute("disabled");

            document.querySelector("#guardar").setAttribute("disabled",true);

            //Creamos una peticion para obtener el nombre del archivo en caso de modificarlo para reemplazarlo por el aterior
            let peticion= new XMLHttpRequest();
            let contDatos=new FormData();
            contDatos.append("accion","consultaNombreDocumento");
            contDatos.append("idLeccion",idModificar);
            peticion.open("POST", url,true);
            peticion.send(contDatos);
            peticion.onreadystatechange=function ()
            {
                if (peticion.readyState == TERMINO_PETICION && peticion.status == COMPLETO_PETICION)
                {
                    if (peticion.response == "error")

                        document.querySelector("body").innerHTML = peticion.response;
                    else
                        //Recuperamos el nombre del curso que estamos seleccionando para eliminarlo en caso de actualizar
                        nombreLeccion = peticion.response;
                }
            }
        }
    }
    //-------------------------------------------------------------
    function limpiarSeleccionTabla(){
        //Limpiamos la seleccion de la tabla
        document.querySelectorAll("tbody tr").forEach(function(value,index)
        {
            value.classList.remove("selected");
        });
    }
    //-------------------------------------------------------
    function  resetDefault()
    {
        //Reseteamos el formulario
        document.querySelector("form").reset();
        //colocamos el foco en el primer campo
        document.querySelector("[name=nombreLeccion]").focus();
        nombreLeccion="";
        idModificar=0;
        document.querySelector("#modificar").setAttribute("disabled",true);
        document.querySelector("#eliminar").setAttribute("disabled",true);
        document.querySelector("#guardar").removeAttribute("disabled");
    }
    //-------------------------------------------------------------------
    //FUNCION OBTENER VALORES DE LOS CAMPOS: Con esta funcion obtenemos los valores de los campos del formulario
    function getValues(id)
    {
        let valores=[];
        valores[0]=parseInt(id);
        valores[1]=document.querySelector("[name=nombreLeccion]").value;
        valores[2]=document.querySelector("[name=descripcion]").value;
        valores[3]=document.querySelector("[name=estado]").value;
        valores[4]="<a href=mostrarLeccion.php?idLeccion="+id+" target='_blank' class='verLeccion'>Ver leccion</a>";
        return valores;
    }
</script>
</body>
</html>
