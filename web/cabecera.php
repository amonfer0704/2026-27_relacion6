<?php 
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO","desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO=="produccion")
    error_reporting(0);
    else 
        error_reporting(E_ALL);  

spl_autoload_register(function ($clase){
    $ruta=RUTABASE."/aplicacion/clases/curso2026/";
    $fichero=$ruta."$clase.php";
    
    if (file_exists($fichero))
        {
            require_once($fichero);
        }
      else
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE."/aplicacion/plantilla/plantilla.php");
include_once(RUTABASE."/scripts/librerias/validacion.php");

//creo todos los objetos que necesita mi aplicación
$arrayMuebles = [
    1=> new MuebleReciclado("Mesa", "Ikea", "Suecia", 2020, "13/11/2026", "30/11/2026", 40.6, 5),
    2=> new MuebleTradicional("Armario", "Artesanos del sur", "Italia", 2024, "01/09/2024", "31/12/2040", 480, 85, "S05"),
    3=> new MuebleReciclado("Mesa de centro", "Ecomuebles", 0, 2023, "15/07/2023", "10/10/2023", 45.99, 10),
    4=> new MuebleTradicional("Cómoda", "Carpintería Sánchez", "francia"),
    5=> new MuebleReciclado("Silla", "Maderas Pedro", "Italia", 2024, "01/09/2024", "31/12/2027", 480, 20)
];