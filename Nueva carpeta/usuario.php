<?php
include "conexion.php";

if ($_POST["accion"] == "registrarse"){

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $password = hash("sha1", $_POST['password']);
    $correo = $_POST['correo'];
    $query = "INSERT INTO usuarios (nombre, apellido,correo,usuario, password) 
        VALUES ('$nombre', '$apellido', '$correo', '$usuario', '$password')";
    $resultado = mysqli_query($conexion, $query);

        if ($resultado)
        {
           echo 1;
        }
        else
        {
            echo "ERROR al insertar ".mysqli_error($conexion);
        }
}

else if($_POST["accion"] == "iniciarsesion"){
    $usuario = $_POST["usuario"];
    $password = hash("sha1", $_POST["password"]);
    
    $query="SELECT password FROM usuarios WHERE usuario = '".$usuario."' and password = '".$password."'";
           $resultado=mysqli_query($conexion,$query);
            if($resultado)
            {
               while($valor=mysqli_fetch_assoc($resultado))
               {
                    if($password == $valor["password"]){
                       echo trim("realizado");
                    }     
               }
                
                             
                mysqli_close($conexion);
            }
            else
            echo "error".mysqli_error($conexion);
        }
    
    
?>        