<?php
 include 'manejoArchivos.php';
 include  '../conexion.php';
 if($_POST["accion"]=="crearLeccion")
 {
       $idCurso=$_POST["idCurso"];
       $nombreLeccion=$_POST["nombreLeccion"];
       $descripcion=$_POST["descripcion"];
       $estado=$_POST["estado"];
       $dir="cursos/".$_POST["codigoCurso"]."/lecciones";
       //creamos un nuevo hombre para el documento reemplazando los espacios en el nombre que le hayamos dado a la leccion
       $srcDocumento=nuevoNombre($_FILES["leccion"],str_replace(" ","_",$nombreLeccion));

       $query = "INSERT INTO lecciones VALUES(DEFAULT,'$nombreLeccion','$descripcion','$srcDocumento','$estado',DEFAULT,".$idCurso.")";
       $resultado=mysqli_query($conexion,$query);
       if($resultado)
       {
            crearDirectorio("../../".$dir);

           if(subirArchivo($_FILES["leccion"],"../../".$dir,$srcDocumento))//srcDocumento es el nuevo nombre del documento
           {
               echo mysqli_insert_id($conexion);
           }
           else
               echo "error";
           mysqli_close($conexion);

       }
       else
           echo mysqli_error($conexion);
 }
 //Consultamos el nombre del documento una vez que vamos a actualizar
 elseif ($_POST["accion"]=="consultaNombreDocumento")
 {
     $query = "SELECT url_documento FROM lecciones WHERE id_leccion=".$_POST["idLeccion"];
     $resultado=mysqli_query($conexion,$query);
     if($resultado)
     {
         echo mysqli_fetch_assoc($resultado)["url_documento"];
     }
     mysqli_close($conexion);
 }

 //En esta condicion se eliminan Lecciones de la base de datos y de los archivos
 elseif ($_POST["accion"]=="eliminar")
 {
         $urlLeccion=getRuta($_POST["idLeccion"]);//Obtengo la ruta donde se almacena la leccion

         //Una vez recuperada la ruta para eliminar el archivo eliminamos el registro
         $query="DELETE FROM lecciones WHERE id_leccion=".$_POST["idLeccion"];
         $resultado=mysqli_query($conexion,$query);
         if($resultado)
         {
             //Si se elimino el registro entonces eliminamos el archivo si se recupero su direccion
             if($urlLeccion!="")
               eliminarArchivo("../../".$urlLeccion);
             echo "realizado";
         }
         else
             echo "error";
         mysqli_close($conexion);
 }

 elseif ($_POST["accion"]=="actualizar")
 {
         $idCurso=$_POST["idCurso"];
         $nombreLeccion=$_POST["nombreLeccion"];
         $descripcion=$_POST["descripcion"];
         $estado=$_POST["estado"];
         //Comprobamo que no se haya cargado un nuevo archivo
         if (empty($_FILES["leccion"]["name"]))
         {
             $query = "UPDATE lecciones SET nombre_leccion='".$idCurso."',descripcion='".$descripcion."',
              estado='".$estado."' WHERE id_leccion=".$_POST["idLeccion"];
             $resultado=mysqli_query($conexion,$query);
             if($resultado)
             {
                 echo  "realizado";
             }
             else echo "error ".mysqli_error($conexion);
         }
         else
         {
             //Creamos  la ruta y el nombre del nuevo archivo
             $dir="cursos/".$_POST["codigoCurso"]."/lecciones";
             $srcDocumento=nuevoNombre($_FILES["leccion"],str_replace(" ","_",$nombreLeccion));
             $urlLeccion=getRuta($_POST["idLeccion"]);//Extraemos la ruta del arch

             $query = "UPDATE lecciones SET nombre_leccion='".$nombreLeccion."',descripcion='".$descripcion."',
                        url_documento='".$srcDocumento."', estado='".$estado."' WHERE id_leccion=".$_POST["idLeccion"];
             $resultado=mysqli_query($conexion,$query);
             if($resultado)
             {
                 if(subirArchivo($_FILES["leccion"],"../../".$dir,$srcDocumento))//srcDocumento es el nuevo nombre del documento
                 {
                     if($urlLeccion!="")
                         eliminarArchivo("../../".$urlLeccion);
                     echo "realizado";
                 }
                 else echo "error";
             }

             else
                 echo "error";
         }
 }

 //Declaro una funcion que me devuelve la ruta del archivo de acuerdo al id que yo le paso
 function getRuta($id_Leccion)
 {
     include  '../conexion.php';
     //Extraemos la ruta completa del archivo y lo guardamos en una variable para eliminar el archivo
     $query = "SELECT  CONCAT('cursos/',codigo,'/lecciones/',url_documento) AS ruta 
                FROM lecciones JOIN cursos USING(id_curso) WHERE id_leccion=".$id_Leccion;
     $resultado=mysqli_query($conexion,$query);
     if($resultado)
     {
         //Retorno la url donde esta almacena esta leccion
         return mysqli_fetch_assoc($resultado)["ruta"];
     }
     else
         return "";

 }
?>