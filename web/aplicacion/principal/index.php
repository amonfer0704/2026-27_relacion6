<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($arrayMuebles);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(array $arrayMuebles)
{
?>
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
        </tr>
        <tr>
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
                echo "</tr>";
            }
            ?>
        </tr>
    </table>
<?php
}
