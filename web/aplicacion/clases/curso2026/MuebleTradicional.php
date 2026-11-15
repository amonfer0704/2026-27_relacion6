<?php

/**
 * Clase MuebleTradicional. Añade las propiedades Peso y Serie
 * No se pueden crear subclases
 */
final class MuebleTradicional extends MuebleBase{
    private float $_Peso;
    private string $_Serie;

    /**
     * Constructor que llama al de MuebleBase y asigna Peso y Serie
     *
     * @param string $nombre
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param integer $precio
     * @param integer $peso
     * @param string $serie
     */
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30, float $peso = 15, string $serie = "S01")
    {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);

        if(!$this->setPeso($peso)){
            $this->_Peso = 15;
        }
        if(!$this->setSerie($serie)){
            $this->_Serie = "S01";
        }

    }

    /**
     * Peso, número real entre 15 y 300
     *
     * @param float $peso
     * @return boolean
     */
    public function setPeso(float $peso): bool{
        $resultado = true;
        $num = $peso;
        if(!validaReal($num, 15, 300, 15)){
            $resultado = false;
        }
        else
            $this->_Peso = $peso;
        return $resultado;
    }

    public function getPeso(): float{
        return $this->_Peso;
    }

    /**
     * Serie, cadena que no sea vacía y con carácteres 3 como máximo
     *
     * @param string $serie
     * @return boolean
     */
    public function setSerie(string $serie): bool{
        $resultado = true;
        $cadena = $serie;
        if($cadena == "" || !validaCadena($cadena, 3, "")){
            $resultado = false;
        }
        else
            $this->_Serie = $serie;
        return $resultado;
    }

    public function getSerie(): string{
        return $this->_Serie;
    }

    /**
     * Nombre de las propiedades adicionales de esta clase
     *
     * @return array
     */
    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return ["Peso", "Serie"];
    }

    /**
     * Redefinición del método toString
     *
     * @return string
     */
    #[Override]
    public function __toString()
    {
        return parent::__toString() . " con un peso de " . $this->_Peso . " y de serie " . $this->_Serie;
    }
}