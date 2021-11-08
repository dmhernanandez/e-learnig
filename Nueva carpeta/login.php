<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>INICIO</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <form action="login.php" method="post">
            <h1>LOGIN</h1>
            <input type="text" name="usuario" placeholder="Usuario o Correo">
            <input type="password" name="password" placeholder="Contraseña">
            <input type="submit" id="iniciarsesion" value="Iniciar Sesion">
            
            <hr width="100%" align="auto">
            <span>¿No tienes cuenta cuenta aún?<a href="registro.php"> Registrate</a></span>
        </form>
    </body>
</html>

<script>
    document.querySelector("form").onsubmit = function(event)
    {
        event.stopPropagation();
        event.preventDefault();
    }

    document.querySelector("#iniciarsesion").addEventListener("click", function()
    {
        if (!document.querySelector("form").checkValidity())
        {
            alert("Por favor llenar los campos");
            return;
        }

        var datos = new FormData(document.querySelector("form"));
        datos.append("accion","iniciarsesion");

        var peticion = new XMLHttpRequest();
        peticion.open("POST","usuario.php",true);
        peticion.send(datos);

        peticion.onreadystatechange = function()
        {
            if(peticion.readyState == 4 && peticion.status == 200)
            {
                if(peticion.response == "realizado        ")
                {
                    alert("BIENVENIDO");
                } else
                {
                    alert("INTENTELO DE NUEVO "+peticion.response);
                }
            }
        }
    });

</script>

