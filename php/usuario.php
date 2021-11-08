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

            session_name("usuario");
            session_start();
            $_SESSION["user"]=$usuario;
           echo "realizado";
        }

        else
        {
            echo "ERROR al insertar ".mysqli_error($conexion);
        }
}

else if($_POST["accion"] == "iniciarsesion"){
    $usuario = $_POST["usuario"];
    $password = hash("sha1", $_POST["password"]);

    $query="SELECT tipo_usuario, password FROM usuarios WHERE usuario = '".$usuario."' and password = '".$password."'";
           $resultado=mysqli_query($conexion,$query);
            if($resultado)
            {
               while($valor=mysqli_fetch_assoc($resultado))
               {
                    if($password == $valor["password"])
                    {;

                        session_name("usuario");
                        session_start();
                        $_SESSION["user"]=$usuario;

                        if($valor["tipo_usuario"]=="administrador"){
                            echo "admin";
                        }
                        else
                            echo "estud";
                    }


               }
                mysqli_close($conexion);
            }
            else
            echo "error ".mysqli_error($conexion);
        }

   else if($_GET["accion"]=="salir"){
       session_name("usuario");
       session_start();
       session_destroy();
       header("location: ../index.php");
}

?>
