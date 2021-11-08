<?php
include '../conexion.php';
include 'manejoArchivos.php';

// Creamos el dirRaizecorio donde se almacenar el curso
if($_POST["accion"]=="crear")
{
	$codigo=$_POST["codigo"];
	$dirRaiz="cursos/".$codigo;
	$nombre=$_POST["nombre"];
	$descripcion=$_POST["descripcion"];
	$habilidades=$_POST["habilidades"];
	$categoria=$_POST["categoria"];
	$instructor=$_POST["instructor"];
	$oferta=$_POST["oferta"];
	$estado=$_POST["estado"];
	if(crearDirectorio("../../".$dirRaiz))
	{
	  //$srcFoto=mysqli_real_escape_string($conexion,$dirRaiz."/".$_FILES["logo"]["name"]);
      $srcLogo=nuevoNombre($_FILES["logo"],$codigo);//Creamos un nuevo nombre tomando su codigo como refenrecia;
	  $query="INSERT INTO cursos VALUES(DEFAULT,'$codigo', '$nombre','$descripcion','$habilidades','$oferta','$estado','$srcLogo',".$categoria.",".$instructor.")";
	   $resultado=mysqli_query($conexion,$query);
		if($resultado)  
		{
			if(subirArchivo($_FILES["logo"], "../../".$dirRaiz,$srcLogo))
			{
				echo 
			  "<div class=registro-exitoso>
				   <form method=GET>
						<h3>El curso a sido creado con exito!!!</h3>
						<h2 name=nombreCurso>".$nombre."</h2>
						<h3 name=codigoCurso>".$codigo."</h3><br>
						<button onclick=window.location='leccionesCurso.php?codigo=".$codigo."'>Subir Archivos</button>
						<button onclick=window.location='cursosAdmin.php'> Todos los cursos</button>
				   </form>
			   </div>";
			  //echo mysqli_insert_id($conexion) se usa para obtener el ultimo idate
			}
			else 
				echo "Error al subir el archivo ".$_FILES["urlFoto"]["name"];
				//echo "<span class=error-subir-foto>Error al subir el foto </span>";

		}
		else
		{
			//al haber un error elimnamos el dirRaizectorio del curso ya que no se pudo guardar
			eliminarDirectorio("../../".$dirRaiz);
			echo "Error al guardar los datos en la base de datos  ".mysqli_error($conexion);
			//echo  "<span class=error-guardar-curso>No se pudo crear el dirRaizectorio en la ruta <br> ".mysqli_error($conexion)."</span>";
		}
	}
	else
		echo "Error al crear el direcotrio en la ruta ".$dirRaiz." ya hay un directorio con ese nombre";
}


elseif($_POST["accion"]=="consultar")
{
	if($conexion)
	{
	  $filas="";
	  $query="SELECT codigo, nombre FROM cursos";
	   $resultado=mysqli_query($conexion,$query);
		if($resultado)
		{
			while($valor=mysqli_fetch_assoc($resultado))
			{
				$filas.="<tr> <td class=contenido-tabla>".$valor["codigo"]."</td>
						  <td class=contenido-tabla>".$valor["nombre"]."</td>
						  <td><a href=actualizarCurso.php?codigo=".$valor["codigo"]." class='actualizarCurso'> Actualizar curso</a></td>
						  <td><a href=leccionesCurso.php?codigo=".$valor["codigo"]." class='leccionesCurso'> Lecciones del curso</a></td>
						</tr>";
			}
			echo $filas;
			mysqli_close($conexion);
		}
		else
		echo "error";
	}
	else
		echo "error";
}

//Se cargan los datos pasando como para parametro el ID del curso a actualizar, y asi selecionar sus datos
elseif($_POST["accion"]=="consultaActualizar")
{
    
	$categorias="";
	$query="SELECT  id_curso,codigo,nombre,descripcion,habilidades,oferta,estado,
            CONCAT('cursos/',codigo,'/',url_foto) AS rutaLogo,
             id_categoria,id_instructor  FROM cursos
            WHERE codigo='".$_POST["codigo"]."'";
	
	$resultado=mysqli_query($conexion,$query);
	if($resultado)
	{
		while($valor=mysqli_fetch_assoc($resultado))
	    {
			 echo    "<input type=hidden name=idCurso value=".$valor["id_curso"]." required>
					 <label class=etiquetas>Codigo del Curso</label> <br>
					  <input type=text name=codigo value=".$valor["codigo"]." required><br><br>
					 <label class=etiquetas>Nombre</label><br>
					  <input type=text name=nombre required value=".$valor["nombre"]."><br><br>
				     <label class=etiquetas>Categoria</label><br>
					 <select name=categoria>";//Creamos un select para mostrar todas las categorias que tenemos guardadas
						//Creamos una segunda consula para traer todos las categorias
						$queryCategoria="SELECT id_categoria, nombre_categoria FROM categorias";
						$resultadoCategoria=mysqli_query($conexion,$queryCategoria);
						  if ($resultadoCategoria)
						  {
								while($value=mysqli_fetch_assoc($resultadoCategoria))
								{
								  //Este if se utiliza para seleccionar la categoria del curso actual
								 if($value["id_categoria"]==$valor["id_categoria"])
									 echo "<option value=".$value["id_categoria"]." selected >".$value["nombre_categoria"]."</option>";
								 else
									echo "<option value=".$value["id_categoria"]." >".$value["nombre_categoria"]."</option>";
								}  
						  }
						  else
						  {
							  echo "<option value=0>No se pudo cargar categorias</option>";
						  }

			       echo  "</select><br><br>
							<label class=etiquetas>Instructor asignado</label><br>
						  <select name='instructor'>
                         ";

						$queryInstructor= "SELECT idinstructores, CONCAT(Nombres,' ',Apellidos) as nombre FROM instructores";
						$resultadoInstructor=mysqli_query($conexion,$queryInstructor);
						if ($resultadoInstructor)
						{
							while($value=mysqli_fetch_assoc($resultadoInstructor))
							{
								//Este if se utiliza para seleccionar la categoria del curso actual
								if($value["idinstructores"]==$valor["id_instructor"])
									echo "<option value=".$value["idinstructores"]." selected >".$value["nombre"]."</option>";
								else
									echo "<option value=".$value["idinstructores"]." >".$value["nombre"]."</option>";
							}
						}
						else
						{
							echo "<option value=0>No se pudo cargar los instructores</option>";
						}
				echo "</select><br><br>	
					<label class=etiquetas>Descripcion</label><br>
					<textarea name=descripcion required>".$valor["descripcion"]."</textarea><br><br>

					 <label class=etiquetas>Lo que ofrece el curso al usuario</label><br>
					 <p>En este campo se colocara lo que el curso ofrece al usuario, separando cada item con una coma.</p>
					<textarea name=oferta required placeholder=Escriba lo que el curso ofrece>".$valor["oferta"]."</textarea><br><br>
					 <label class=etiquetas>Habilidades que aprendera el usario al tomar el curso</label><br>
					  <p>En este campo se escribira lo que el usuario aprendera una vez que termine el curso, separando cada item con una coma.</p>
					<textarea name=habilidades required placeholder=Escriba las habilidades que aprendera el usuario>".$valor["habilidades"]."</textarea><br><br>
					<label class=etiquetas>Estado del curso</label><br>
					<p>Si cambia al estado Inactivo, el curso no sera visible, pero si podran seguirlo cursando los que ya lo tienen inscrito.</p>
					<select name=estado>";
			            if($valor["estado"]=="Activo")
						echo "<option selected>Activo</option>
						      <option>Inactivo</option>
					</select><br><br>";
					    else
						echo"<option>Activo</option>
						     <option selected>Inactivo</option>
					 </select><br><br>";

					 echo   "
                     <label class=etiquetas>Cambiar imagen</label><br>
						<input type=file accept=image/* name=logo >
					<div id=mostrarLogo>
						<label >Logo actual</label><br>
						<img src=".$valor["rutaLogo"]." name=logoActual><br>
					</div>";

	    }
		
		mysqli_close($conexion);
	}
	else
		echo "error ".mysqli_error($conexion);
}
//Una vez que se pulsa el boton acutalizar entonces actualizamos los datos
elseif ($_POST["accion"]=="actualizar") {
    $idCurso = $_POST["idCurso"];
    $codigo = $_POST["codigo"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $habilidades = $_POST["habilidades"];
	$categoria=$_POST["categoria"];
	$instructor=$_POST["instructor"];
    $oferta = $_POST["oferta"];
    $estado = $_POST["estado"];
	$dirRaiz="cursos/".explode("/",$_POST["logoActual"])[1]; //Obtenemos el directorio raiz actual
    /*Extraigo el nombre del directorio actual del curso para compararlo con el codigo del curso ya que el nombre del directorio del
    curso tiene el mismo nombre que el codigo del curso y se es diferente entonces renombro el directorio con el nuevo codigo de curso.*/
    $dirActual = explode("/", $_POST["logoActual"])[1];

    //Comprobamos si se cambio el codigo de curso para renombrar el directorio
    if ($dirActual != $_POST["codigo"])
    {
        if(rename("../../cursos/".explode("/",$_POST["logoActual"])[1],"../../cursos/".$_POST["codigo"]))
            $dirRaiz="cursos/".$_POST["codigo"];  //Si se pudo renombrar el archivo entonces la carpeta raiz cambiara
        else
        {
            exit("Error al renombrar el directorio");
        }

    }

    /*Esta condicion se utiliza para comprobar si al actualizar se ha cambiado el logo del curso, en caso de estar vacia, entoces no se a
    actualiza la ruta del logo*/
	if(empty($_FILES["logo"]["name"]))
	{
		$query="UPDATE cursos SET codigo='$codigo',nombre='$nombre',descripcion='$descripcion',habilidades='$habilidades', 
                                oferta='$oferta',estado='$estado',id_categoria=".$categoria.", id_instructor=".$instructor." WHERE id_curso=".$idCurso."";
		$resultado=mysqli_query($conexion,$query);
		if($resultado)
		{
		   echo "Realizado";
		}
		else
			echo mysqli_error($conexion);
	}
	//Si el logo no esta vacio entonces realizamos una actualizacion, cambiando los archivos actualizaos
	else
	{
       $srcLogo=nuevoNombre($_FILES["logo"],$codigo);//Creamos un nuevo nombre tomando su codigo como refenrecia

		$query="UPDATE cursos SET codigo='$codigo',nombre='$nombre',descripcion='$descripcion',habilidades='$habilidades', 
                                oferta='$oferta',estado='$estado',url_foto='$srcLogo',id_categoria=".$categoria.",id_instructor=".$instructor." WHERE id_curso=".$idCurso."";
		$resultado=mysqli_query($conexion,$query);
		//Si se actualizo la base datos procedemos a subir el nuevo archivo
	//echo $query;
		if($resultado)
		{
			if(subirArchivo($_FILES["logo"], "../../".$dirRaiz, $srcLogo))//Si ese actualizo la base de datos entonces movemos los archivos a la carpeta del servidor
			{
				//Si el archivo se subio, entonces borramos el actual, logoActual contiene la ruta de la imagen actual
                if(eliminarArchivo("../../".$_POST["logoActual"]))
				{
                   echo "realizado";
				}
                else
                	echo "error";
			}
			echo "error";
		}
		else
			echo mysqli_error($conexion);
	}
}


//Esta consulta devuelve cuando se busca
elseif($_POST["accion"]=="buscar")
{
	if($conexion)
	{
		$filas="";
		$query="SELECT codigo, nombre FROM cursos WHERE codigo like CONCAT('%','".$_POST["filtro"]."','%') or nombre like CONCAT('%','".$_POST["filtro"]."','%') ";
		$resultado=mysqli_query($conexion,$query);
		if($resultado)
		{
			while($valor=mysqli_fetch_assoc($resultado))
			{
				$filas.="<tr> <td class=contenido-tabla>".$valor["codigo"]."</td>
						  <td class=contenido-tabla>".$valor["nombre"]."</td>
						  <td><a href=actualizarCurso.php?codigo=".$valor["codigo"]." class='actualizarCurso'> Actualizar curso</a></td>
						  <td><a href=leccionesCurso.php?codigo=".$valor["codigo"]." class='leccionesCurso'> Lecciones del curso</a></td>
						</tr>";
			}
			echo $filas;
			mysqli_close($conexion);
		}
		else
			echo "error";
	}
	else
		echo "error";
}

?>
