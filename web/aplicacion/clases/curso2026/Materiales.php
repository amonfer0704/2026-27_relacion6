<?php 

/**
 * Enumeración materiales con los posibles materiales disponibles.
 * Para cada material se define un valor numérico múltiplo de 5
 */
enum Materiales: int{
    case Madera = 5;
    case Hierro = 10;
    case Plástico = 15;
    case Latón = 20;
}