<?php 
/**
 * Pruebas de la clase Mueblebase, MuebleReciclado, MuebleTradicional y Características
 */
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");
//controlador
$barra = [
    [
        "TEXTO" => "inicio",
        "ENLACE" => "/index.php"
    ],
    [
        "TEXTO" => "principal",
        "ENLACE" => "/aplicacion/principal/index.php",
    ],
    [
        "TEXTO" => "pruebas",
    ]
];
$pruebas = [];
$lineas = [];
/**
 * Pruebas con el constructor, comprobación de que se crean sin problema
 */
$reciclado = new MuebleReciclado("silla", "Lola", "Portugal", 2022, "01/03/2022", "31/12/2030", 120, 35);
$tradicional = new MuebleTradicional("sofá", "Gómez", "Francia", 2021, "15/06/2021", "31/12/2035", 450.5, 120, "S07");
$lineas[] = "Constructor MuebleReciclado: " . $reciclado;
$lineas[] = "Constructor MuebleTradicional: " . $tradicional;
try{
    $muebleError = new MuebleReciclado("");
    $lineas[] = "ERROR: se ha creado un mueble con el nombre vacío";
}
catch(Exception $e){
    $lineas[] = "Nombre vacío -> excepción: " . $e->getMessage();
}
$pruebas[] = ["TITULO" => "1. Constructores", "LINEAS" => $lineas];

/**
 * Prueba de los métodos getters y setters
 * MuebleBase
 */
$reciclado->setNombre("mesa");
$lineas[] = "setNombre / getNombre: " . $reciclado->getNombre();
$reciclado->setFabricante("Ikea");
$lineas[] = "setFabricante / getFabricante: " . $reciclado->getFabricante();
$reciclado->setPais("Italia");
$lineas[] = "setPais / getPais: " . $reciclado->getPais();
$reciclado->setAnio(2021);
$lineas[] = "setAnio / getAnio: " . $reciclado->getAnio();
$reciclado->setFechaIniVenta("10/05/2022");
$lineas[] = "setFechaIniVenta / getFechaIniVenta: " . $reciclado->getFechaIniVenta();
$reciclado->setFechaFinVenta("01/12/2028");
$lineas[] = "setFechaFinVenta / getFechaFinVenta: " . $reciclado->getFechaFinVenta();
$reciclado->setPrecio(99.9);
$lineas[] = "setPrecio / getPrecio: " . $reciclado->getPrecio();

/**
 * MuebleReciclado
 */
$reciclado->setPorcentajeReciclado(60);
$lineas[] = "setPorcentajeReciclado / getPorcentajeReciclado: " . $reciclado->getPorcentajeReciclado();
$lineas[] = "damePropiedadesAdicionales (MuebleReciclado):";
foreach($reciclado->damePropiedadesAdicionales() as $propiedad){
    $lineas[] = "- " . $propiedad;
}

/**
 * MuebleTradicional
 */
$tradicional->setPeso(200);
$lineas[] = "setPeso / getPeso: " . $tradicional->getPeso();
$tradicional->setSerie("S09");
$lineas[] = "setSerie / getSerie: " . $tradicional->getSerie();
$lineas[] = "damePropiedadesAdicionales (MuebleTradicional):";
foreach($tradicional->damePropiedadesAdicionales() as $propiedad){
    $lineas[] = "- " . $propiedad;
}

/**
 * Características
 */
$reciclado->anadirCaracteristicas("material", "roble", "color", "rojo");
$lineas[] = "anadirCaracteristicas / getCaracteristicas: " . $reciclado->getCaracteristicas();
$lineas[] = "foreach sobre las características (orden inverso):";
foreach($reciclado->getCaracteristicas() as $clave => $valor){
    $lineas[] = "- " . $clave . ": " . $valor;
}
$caracteristicas = $reciclado->getCaracteristicas();
$caracteristicas->peso = 12;
$lineas[] = "__set y __get: ->peso = " . $caracteristicas->peso;
if(isset($caracteristicas->peso)){
    $lineas[] = "__isset: peso existe";
}
unset($caracteristicas->peso);
if(!isset($caracteristicas->peso)){
    $lineas[] = "__unset: peso ya no existe";
}
$reciclado->anadirCaracteristicas("ULTIMA", true);
try{
    $reciclado->anadirCaracteristicas("nueva", 1);
}
catch(Exception $e){
    $lineas[] = "Añadir una característica después de ULTIMA -> excepción: " . $e->getMessage();
}

/**
 * ToString
 */
$lineas[] = "__toString de MuebleReciclado: " . $reciclado;
$lineas[] = "__toString de MuebleTradicional: " . $tradicional;

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("PRUEBAS DE LAS CLASES", $barra);
cuerpo($lineas);  //llamo a la vista
finCuerpo();
//vista
function cabecera()
{}

//vista
function cuerpo(array $lineas)
{
    echo "<br><br>";
    foreach($lineas as $linea){
        echo "<p>" . $linea . "</p>";
    }
}
