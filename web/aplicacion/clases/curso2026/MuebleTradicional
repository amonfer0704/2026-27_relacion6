<?php

final class MuebleTradicional extends MuebleBase{
    private float $_Peso;
    private string $_Serie;

    #[Override]
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

    public function setPeso(float $peso): bool{
        $resultado = true;
        $num = $peso;
        if(!validaReal($num, 15, 300, 15)){
            $resultado = false;
        }
        $this->_Peso = $peso;
        return $resultado;
    }

    public function getPeso(): float{
        return $this->_Peso;
    }

    public function setSerie(string $serie): bool{
        $resultado = true;
        $cadena = $serie;
        if($cadena == "" || validaCadena($cadena, 3, "")){
            $resultado = false;
        }
        $this->_Serie = $serie;
        return $resultado;
    }

    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        $miArray = [];
        array_push($miArray, $this->_Peso);
        array_push($miArray, $this->_Serie);
        return $miArray;
    }

    #[Override]
    public function __toString()
    {
        return parent::__toString() . " con un peso de " . $this->_Peso . " y de serie " . $this->_Serie;
    }
}