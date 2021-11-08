<?php
include '../conexion.php';
	//echo "<script>anlert(volor de filtro:".$_POST["filtro"].");</script>";
if(isset($_POST["consultarDatos"]))
{
	if($conexion)
	{
	  $filas="";
	  //$query="SELECT codigo, nombre, descripcion FROM cursos WHERE codigo LIKE '%".$_POS["filtro"]."%'";
	  $query="SELECT codigo, nombre FROM cursos";
	   $resultado=mysqli_query($conexion,$query);
		if($resultado)
		{
			while($valor=mysqli_fetch_assoc($resultado))
			{
				$filas.="<tr> <td>".$valor["codigo"]."</td>
						  <td>".$valor["nombre"]."</td>
						  <td><a href=actualizarCurso.php?cod=".$valor["codigo"]."> Actualizar curso</a></td>
						  <td><a href=actualizarCurso.html?cod=".$valor["codigo"]."> Lecciones del curso</a></td>
						</tr>";
               
			}
			$_POST=array();
			echo $filas;
			mysqli_close($conexion);
		}
		else
		echo "error";
	}
	else
		echo "error";
}

//Cargamos los datos cuando los vamos a acutualizar
if(isset($_POST["actualizarDatos"]))
{
    //$query="SELECT id, codigo, nombre, descripcion, url_foto FROM cursos WHERE codigo=".$_POST["codigo"]."";
	$retorno="";
	$categorias="";
	$query="SELECT * FROM cursos WHERE codigo='".$_POST["codig"]."'";
	//Creamos una segunda consula para traer todos las categorias
	$queryCat="SELECT nombre FROM categorias";
	$resultado=mysqli_query($conexion,$query);
	if($resultado)
	{
		while($valor=mysqli_fetch_assoc($resultado))
	    {
			$retorno.="<input type=hidden name=idCurso value=".$valor["id_curso"]." required>
					 <label>Codigo del Curso</label> <br>
					 <input type=text name=codigo value=".$valor["codigo"]." required><br>
					 <label>Nombre</label><br>
					<input type=text name=nombre required value=".$valor["nombre"]."><br>
					<label>Descripción</label><br>
					  <select>";
			 $resultCategoria=mysqli_query($conexion,$queryCat);
			  if ($resultCategoria)
			  {
					while($value=mysqli_fetch_assoc($resultCategoria))
					{
					 $retorno.="<option >".$value["nombre"]."</option>";
					}  
			  }
			  else
				   $retorno.="<option >No se pudo cargar categorias</option>";
			
			  $retorno.="</select><br>
			            <textarea name=descripcion required>".$valor["descripcion"]."</textarea><br>
						<label>Cambiar imagen</label><br>
						<input type=file accept=image/* name=urlFoto ><br><br>
						<img src=".$valor["url_foto"].">";
	    }
		echo $retorno;
		mysqli_close($conexion);
	}
	else
		echo "error";

}

?>
<!--
f (mysqli_connect_errno() == 0 && $conexion == true){

    $query = "select * from ejercicio 
              WHERE ID = 3";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado){

        echo "<table border='1px' width='100%'> 
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Primer Nombre</th>
                        <th>Segundo Nombre</th>
                        <th>Apellido</th>
                    </tr>    
                </thead>
                <tbody>";

        while ($fila = mysqli_fetch_assoc($resultado)){
            echo "<tr><td>".$fila["ID"]."</td><td>".$fila["Campo1"]."</td><td>".$fila["Campo2"]."</td><td>".$fila["Campo3"]."</td></tr>";
        }

        echo "</tbody></table>";

        mysqli_close($conexion);
    }else{
        echo "ERROR en la consulta.".mysqli_error($conexion);
    }-->
