<?php 

/**
 * Clase MuebleReciclado. Añade la propiedad PorcentajeReciclado a las de MuebleBase
 * No se pueden crear subclases
 */
final class MuebleReciclado extends MuebleBase{
    private int $_PorcentajeReciclado;
    
    /**
     * Constructor que llama al de MuebleBase y asigna porcentajeReciclado
     *
     * @param string $nombre
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param integer $precio
     * @param integer $material
     * @param integer $porcentajeReciclado
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", 
            string $fechaFinVenta = "31/12/2040", float $precio = 30, int $material = 10, float $porcentajeReciclado = 10)
    {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio, $material);
        if(!$this->setPorcentajeReciclado($porcentajeReciclado)){
            $this->_PorcentajeReciclado = 10;
        }
    }

    /**
     * Porcentaje reciclado entero entre 0 y 100
     *
     * @param integer $porcentaje
     * @return boolean
     */
    public function setPorcentajeReciclado(int $porcentaje): bool{
        $resultado = true;
        $num = $porcentaje;
        if(!validaEntero($num, 0, 100, 10)){
            $resultado = false;
        }
        else
            $this->_PorcentajeReciclado = $porcentaje;
        return $resultado;
    }

    public function getPorcentajeReciclado(): int{
        return $this->_PorcentajeReciclado;
    }

    /**
     * Redefinición con las propiedades adicionales de esta clase
     *
     * @return array
     */
    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return ["PorcentajeReciclado"];
    }

    /**
     * Redefinición del método toString
     *
     * @return string
     */
    #[Override]
    public function __toString()
    {
        return parent::__toString() . " con un porcentaje de reciclado de " . $this->_PorcentajeReciclado;
    }
}