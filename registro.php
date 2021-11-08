<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>REGISTRO</title>
        <link rel="stylesheet" href="./css/registro.css">
            <link rel="stylesheet" href="./css/menu.css">
    </head>
    <body>
    <img class="log" src="./images/logo.png"  width="300px" alt="">
    <header id="cabecera">
            <nav class="menu">
                <ul >
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="login.php"> Iniciar Sesion</a></li>
                    <li><a href="registro.php">Registro</a></li>
                    
            </nav>

        </header>

    <form>
        <h1>REGISTRO USUARIO</h1>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="text" name="correo" placeholder="Correo Electronico" required>
        <input type="submit" id="registrarse">

        <hr width="100%" align="auto">
        <span>¿Ya tienes cuenta?<a href="login.php"> Iniciar Sesion</a></span>
    </form>

<script>
document.querySelector("form").onsubmit = function(event) {
    event.stopPropagation();
    event.preventDefault();
}

document.querySelector("#registrarse").addEventListener("click", function() {

    if (!document.querySelector("form").checkValidity())
    {
        alert("Por favor llenar los campos vacios ");

        return;
    }

    var datos = new FormData(document.querySelector("form"));
    datos.append("accion","registrarse");

    var peticion = new XMLHttpRequest();
    peticion.open("POST", "php/usuario.php", true);
    peticion.send(datos);

    peticion.onreadystatechange = function()
    {
        if(peticion.readyState == 4 && peticion.status == 200)
        {
            if(peticion.response =="realizado")
            {
                alert("Usuario Registrado Exitosamente!");
                window.location.href='cursos.php?user='+document.querySelector("[name=usuario]").value;
            } else
            {
                alert("Error al Registrar Usuario: "+peticion.response);
            }
        }
    }
});

</script>
</body>
</html>
