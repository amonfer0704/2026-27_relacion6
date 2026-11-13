<?php 

final class MuebleReciclado extends MuebleBase{
    private int $_PorcentajeReciclado;
    
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30, int $porcentajeReciclado = 10)
    {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
        if(!$this->setPorcentajeReciclado($porcentajeReciclado)){
            $this->_PorcentajeReciclado = 10;
        }

    }

    public function setPorcentajeReciclado(int $porcentaje): bool{
        $resultado = true;
        $num = $porcentaje;
        if(!validaEntero($num, 0, 100, 10)){
            $resultado = false;
        }
        $this->_PorcentajeReciclado = $porcentaje;
        return $resultado;
    }

    public function getPorcentajeReciclado(): int{
        return $this->_PorcentajeReciclado;
    }

    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        $miArray = [];
        array_push($miArray, $this->_PorcentajeReciclado);
        return $miArray;
    }

    #[Override]
    public function __toString()
    {
        return parent::__toString() . " con un porcentaje de reciclado de " . $this->_PorcentajeReciclado;
    }
}