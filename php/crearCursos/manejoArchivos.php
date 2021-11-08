<?php
//Definicion de constantes que para retorno de funciones
define("NO_ES_DIRECTORIO",0);
define("DIRECTORIO_BORRADO",1);
define("ERROR_DEL_DIRECTORIO",2);

//Con esta funcion subimos archivos
function subirArchivo($archivo, $directorio,$nuevoNombre)
{
   //movemos el archivo al valor a la ruta especificada
    if(move_uploaded_file($archivo["tmp_name"], $directorio."/".$nuevoNombre))
	{
			return true;
	}
    else
        return false;
}

function nuevoNombre($archivo,$codigo)
{
//Extraigo el nombre y la extencion del archivo y luego selecciono obtengo la extension con la funcion end
    $nombre = explode(".", $archivo["name"]);
    $extension=end($nombre);
    $newName=$codigo."_".time().".".$extension;
      return $newName;//Creamos el nuevo nombre del archivo
}

//con esta funcion eliminamos los archivos y directorios
function eliminarArchivo($url)
{
    //Retorna 1 si se realizo con exito
    //Retorna 2 si el parametor pasado no es un archivo
    //Retorna 0 si no se pudo borrar el archivo
    //Retorna 3 si el arhivo no existe
    if(file_exists($url))
    {
        if(is_file($url)){
            if(unlink($url))
            {
                return 1;
            }
            else
                return 0;
        }
        else
            return 2;
    }
    else
        return 3;

}

function renombrar($archivo,$nuevo_nombre)
{


}
//Con esta funcion eliminamos un directorio
// Devuelve 0 si lo que se paso por la url no es un direcotorio
//Retorna 1 si el directorio fue borrado exitosamente
//Retorna 2 si no se pudo borrar el directorio
function eliminarDirectorio($url)
{
	//Inicializamos el retorno con la constate que indica que no es un diretorio  por si no es un directorio
	$retorno=NO_ES_DIRECTORIO;
	
	if(is_dir($url))
	{
		if(rmdir($url))
			$retorno=DIRECTORIO_BORRADO;
		else
			$retorno=ERROR_DEL_DIRECTORIO;
	}
	
	return $retorno;
}

//Esta funcion sirve para crear directorios 
function crearDirectorio($url)
{
	//Si el retorno es 1 la carpeta fue creada exitosamente
	//Si retorno es 2 la carpeta no se pudo crear
	//Si el retorno es 0, la carpeta ya existe
   $retorno=false;
	if(!file_exists($url))
	{
		if(mkdir($url,0777,true))
		{
			$retorno=true;
		}
		else
			$retorno=false;
	}
	return $retorno;
}
?>