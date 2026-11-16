<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

/**
 * Indice del mueble que se muestra
 */
$indexSeleccionado = 0;
if(isset($_POST["mostrar"]) && isset($_POST["mueble"])){
    $indice = (int) $_POST["mueble"];
    if(isset($arrayMuebles[$indice])){
        $indexSeleccionado = $indice;
    }
}

/**
 * Botón modificar Mueble que redirige a modificar.php
 */
if(isset($_REQUEST["modificar"]) && isset($_REQUEST["mueble"])){
    $indice = (int) $_REQUEST["mueble"];
    if(isset($arrayMuebles[$indice])){
        header("Location: /aplicacion/principal/modificar.php?mueble=" . $indice);
    }
}

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
        "TEXTO" => "index",
    ]
];

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION", $barra);
cuerpo($arrayMuebles, $indexSeleccionado);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(array $arrayMuebles, int $indexSeleccionado)
{
?>
    <br><br>
    <a href="./pruebas.php">Pruebas</a>
    <br><br>
    <table class="tabla">
        <tr>
            <th>Indice</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Fabricante</th>
            <th>Pais</th>
            <th>Inicio venta</th>
            <th>Fin venta</th>
            <th>Precio</th>
            <th>Material</th>
        </tr>
            <?php 
            for($i = 1; $i < count($arrayMuebles) + 1; $i++){
                echo "<tr>";
                echo "<td>" . $i ."</td>";
                echo "<td>" . get_class($arrayMuebles[$i]) . "</td>";
                echo "<td> " . $arrayMuebles[$i]->getNombre() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getFabricante() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getPais() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getFechaIniVenta() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getFechaFinVenta() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getPrecio() . "</td>";
                echo "<td>" . $arrayMuebles[$i]->getMaterial()->value . "</td>";
                echo "</tr>";
            }
            ?>
    </table>
    <form method="post" action="index.php">
        <label>Mueble:</label>
        <select name="mueble">
        <?php
        foreach($arrayMuebles as $clave =>$mueble){
            $texto = $clave . " - " . get_class($mueble) . " - " . $mueble->getNombre() . " (" . $mueble->getPrecio() . "€)";
            $seleccionado = ($clave === $indexSeleccionado)? " selected":"";
            echo '<option value="' . $clave . '"' . $seleccionado . '>' . $texto . '</option>';
        }
        ?>
        </select>
        <input type="submit" name="mostrar" value="Mostrar Mueble">
        <input type="submit" name="modificar" value="Modificar Mueble">
    </form>
<?php
    if($indexSeleccionado > 0){
        muestraMueble($arrayMuebles[$indexSeleccionado]);
    }
}

/**
 * Muestra todas las propiedades del mueble y sus características
 *
 * @param MuebleBase $mueble
 * @return void
 */
function muestraMueble(MuebleBase $mueble){
    echo "<h3>Datos del mueble</h3>";
    echo "<p>Tipo: " . get_class($mueble) . "</p>";
    echo "<p>Nombre: " . $mueble->getNombre() . "</p>";
    echo "<p>Fabricante: " . $mueble->getFabricante() . "</p>";
    echo "<p>País: " . $mueble->getPais(). "</p>";
    echo "<p>Año de fabricación: " . $mueble->getAnio() ."</p>";
    echo "<p>Inicio de venta: " . $mueble->getFechaIniVenta() . "</p>";
    echo "<p>Fin de venta: " . $mueble->getFechaFinVenta() . "</p>";
    echo "<p>Precio: " . $mueble->getPrecio() . "</p>";
    foreach($mueble->damePropiedadesAdicionales() as $propiedad){
        $prop = "get". $propiedad;
        echo "<p>". $propiedad . ": " . $mueble->$prop() . "</p>";
    }
    echo "<h3>Características</h3>";
    foreach($mueble->getCaracteristicas() as $clave=>$valor){
        echo "<p>" . $clave . ": " . $valor . "</p>";
    }
}
