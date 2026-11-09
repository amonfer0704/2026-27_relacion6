<?php 

class MuebleBase{
    private const int MAXIMO_MUEBLES = 0;
    private int $_mueblesCreados = 0;
    private string $_nombre;
    private string $_fabricante;
    private string $_pais;
    private int $_anio;
    private string $_fechaIniVenta;
    private string $_fechaFinVenta;
    private float $_precio;

    public function __set($name, $value)
    {
        throw new \Exception('No existe la propiedad $name');
    }
    public function __unset($name)
    {
        throw new \Exception('No existe la propiedad $name');
    }
    public function __isset($name)
    {
        throw new \Exception('No existe la propiedad $name');
    }
    public function __get($name)
    {
        throw new \Exception('No existe la propiedad $name');
    }

    public function __construct(string $nombre, string $fabricante, string $pais, int $anio, string $fechaIniVenta, string $fechaFinVenta, float $precio)
    {
        $this->_nombre = $nombre;
        $this->_fabricante = $fabricante;
        $this->_pais = $pais;
        $this->_anio = $anio;
        $this->_fechaIniVenta = $fechaIniVenta;
        $this->_fechaFinVenta = $fechaFinVenta;
        $this->_precio = $precio;
        self::$_mueblesCreados++;
    }

    public function setNombre(string $_nombre): bool{
        return validaCadena($_nombre, 40, mb_strtoupper($_nombre));
    }

    public function getNombre(): string{
        return $this->_nombre;
    }

    public function setFabricante(string $_fabricante): bool{
        $prefijo = "FaMu";
        $resultado = true;
        if(substr($_fabricante,0,3) == 'FaMu'){
            $_fabricante = "FaMu" . $_fabricante;
            $resultado = false;
        }
        return $resultado?validaCadena($_fabricante, 30, ""):validaCadena($_fabricante, 30 - strlen($prefijo), "");
    }

    public function getFabricante(): string{
        return $this->_fabricante;
    }

    public function setPais(string $_pais): bool{
        return validaCadena($_pais, 20, "ESPAÑA");
    }

    public function getPais(): string{
        return $this->_pais;
    }

    public function setAnio(int $_anio): bool{
        $anioActual = date("Y");
        return validaEntero($_anio, 2020, $anioActual, 2020);
    }

    public function getAnio(): int{
        return $this->_anio;
    }

    public function setFechaIniVenta(string $_fechaIniVenta): bool{
        $fechaFormateada = validaFecha($_fechaIniVenta, "01/01".$this->getAnio());
        $anioVenta = $fechaFormateada->format("Y");
        return $anioVenta < $this->_anio?true:false;

    }
}