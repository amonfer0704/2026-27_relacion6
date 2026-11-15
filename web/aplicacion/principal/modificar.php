<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
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
        "TEXTO" => "modificar",
    ]
];

$indice = 0;
$valores = [];
$errores = [];
$modificado = false;

$datos = ["nombre", "fabricante", "pais", "anio", "fechaIni", "fechaFin", "precio"];
if (isset($_REQUEST["mueble"]) && isset($arrayMuebles[(int) $_REQUEST["mueble"]])) {
    $indice = (int) $_REQUEST["mueble"];
}

if($indice > 0){
    $mueble = $arrayMuebles[$indice];
    $propiedades = $mueble->damePropiedadesAdicionales();
    if (!isset($_REQUEST["guardar"])) {
        $valores["nombre"] = $mueble->getNombre();
        $valores["fabricante"] = $mueble->getFabricante();
        $valores["pais"] = $mueble->getPais();
        $valores["anio"] = (string) $mueble->getAnio();
        $valores["fechaIni"] = $mueble->getFechaIniVenta();
        $valores["fechaFin"] = $mueble->getFechaFinVenta();
        $valores["precio"] = (string) $mueble->getPrecio();
        foreach ($propiedades as $propiedad) {
            $getter = "get" . $propiedad;
            $valores[$propiedad] = (string) $mueble->$getter();
        }
    } 
    else {
        foreach (array_merge($datos, $propiedades) as $campo) {
            $valores[$campo] = trim($_REQUEST[$campo] ?? "");
        }
        $aux = clone $mueble;
        if (!$aux->setNombre($valores["nombre"])) {
            $errores["nombre"] = "Obligatorio, máximo 40 caracteres";
        }
        if (!$aux->setFabricante($valores["fabricante"])) {
            $errores["fabricante"] = "Fabricante no válido";
        }
        if (!$aux->setPais($valores["pais"])) {
            $errores["pais"] = "Máximo 20 caracteres";
        }
        $anioTexto = $valores["anio"];
        if (!validaExpresion($anioTexto, "/^[0-9]+$/", "") || !$aux->setAnio((int) $anioTexto)) {
            $errores["anio"] = "Entero entre 2020 y el año actual";
        }
        $anio = $aux->getAnio();
        $fechaIni = $valores["fechaIni"];
        $iniCorrecta = validaFecha($fechaIni, "01/01/" . $anio) && (int) mb_substr($fechaIni, 6, 4) >= $anio;
        if (!$iniCorrecta) {
            $errores["fechaIni"] = "Fecha válida (dd/mm/aaaa) no anterior al 1 de enero de " . $anio;
        }
        $fechaFin = $valores["fechaFin"];
        if (!validaFecha($fechaFin, "31/12/2040")) {
            $errores["fechaFin"] = "Fecha válida (dd/mm/aaaa)";
        }
        else if($iniCorrecta && $iniCorrecta > $fechaFin){
            $errores["fechaFin"] = "La fecha de fin no puede ser menor que la de inicio";
        }
        $precioTexto = $valores["precio"];
        if (!validaExpresion($precioTexto, "/^[0-9]+(\.[0-9]+)?$/", "") || (float) $precioTexto < 30) {
            $errores["precio"] = "Número no menor de 30";
        }
        if ($mueble instanceof MuebleReciclado) {
            $porcentaje = $valores["PorcentajeReciclado"];
            if (!validaExpresion($porcentaje, "/^[0-9]+$/", "") || (int) $porcentaje > 100) {
                $errores["PorcentajeReciclado"] = "Entero entre 0 y 100";
            }
        } elseif ($mueble instanceof MuebleTradicional) {
            $peso = $valores["Peso"];
            if (!validaExpresion($peso, "/^[0-9]+(\.[0-9]+)?$/", "") || (float) $peso < 15 || (float) $peso > 300) {
                $errores["Peso"] = "Número entre 15 y 300";
            }
            if (mb_strlen($valores["Serie"]) === 0) {
                $errores["Serie"] = "No puede estar vacía";
            }
        }
        if (count($errores) === 0) {
            $aux->setFechaIniVenta($fechaIni);
            $aux->setFechaFinVenta($fechaFin);
            $aux->setPrecio((float) $valores["precio"]);
            if ($aux instanceof MuebleReciclado) {
                $aux->setPorcentajeReciclado((int) $valores["PorcentajeReciclado"]);
            } elseif ($aux instanceof MuebleTradicional) {
                $aux->setPeso((float) $valores["Peso"]);
                $aux->setSerie($valores["Serie"]);
            }
            $arrayMuebles[$indice] = $aux;
            $modificado = true;
        }
    }
}
//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION", $barra);
cuerpo($indice, $arrayMuebles, $valores, $errores, $modificado);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(int $indice, array $arrayMuebles, array $valores, array $errores, bool $modificado)
{
    echo "<br><br>";
    if ($indice === 0) {
        echo "<p>No se ha indicado un mueble válido.</p>";
    } elseif ($modificado) {
        resumen($arrayMuebles[$indice]);
    } else {
        formulario($indice, $arrayMuebles[$indice], $valores, $errores);
    }
    echo '<p><a href="index.php">Ir a index.php</a></p>';
}
function formulario(int $indice, MuebleBase $mueble, array $valores, array $errores)
{
    $campos = [
        "nombre" => "Nombre",
        "fabricante" => "Fabricante",
        "pais" => "País",
        "anio" => "Año de fabricación",
        "fechaIni" => "Inicio de venta (dd/mm/aaaa)",
        "fechaFin" => "Fin de venta (dd/mm/aaaa)",
        "precio" => "Precio",
    ];
    foreach ($mueble->damePropiedadesAdicionales() as $propiedad) {
        $campos[$propiedad] = $propiedad;
    }
    echo '<form method="post" action="modificar.php">';
    echo '<input type="hidden" name="mueble" value="' . $indice . '">';
    echo "<p>Tipo: " . get_class($mueble) . "</p>";
    foreach ($campos as $nombre => $etiqueta) {
       echo "<p><label>" . $etiqueta . ": ";
        echo '<input type="text" name="' . $nombre . '" value="' . $valores[$nombre] . '">';
        echo "</label>";
        if (isset($errores[$nombre])) {
            echo ' <span class="error">' . $errores[$nombre] . "</span>";
        }
        echo "</p>";
    }
    echo '<input type="submit" name="guardar" value="Guardar cambios">';
    echo "</form>";
}
function resumen(MuebleBase $mueble)
{
    echo "<h3>Mueble modificado correctamente</h3>";
    echo "<p>Tipo: " . get_class($mueble) . "</p>";
    echo "<p>Nombre: " . $mueble->getNombre() . "</p>";
    echo "<p>Fabricante: " . $mueble->getFabricante() . "</p>";
    echo "<p>País: " . $mueble->getPais() . "</p>";
    echo "<p>Año de fabricación: " . $mueble->getAnio() . "</p>";
    echo "<p>Inicio de venta: " . $mueble->getFechaIniVenta() . "</p>";
    echo "<p>Fin de venta: " . $mueble->getFechaFinVenta() . "</p>";
    echo "<p>Precio: " . $mueble->getPrecio() . "</p>";
    foreach ($mueble->damePropiedadesAdicionales() as $propiedad) {
        $getter = "get" . $propiedad;
        echo "<p>" . $propiedad . ": " . $mueble->$getter() . "</p>";
    }
}