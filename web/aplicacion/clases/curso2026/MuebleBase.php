<?php 

abstract class MuebleBase{
    private const int MAXIMO_MUEBLES = 10;
    private static int $_mueblesCreados = 0;
    private string $_nombre;
    private string $_fabricante;
    private string $_pais;
    private int $_anio;
    private string $_fechaIniVenta;
    private string $_fechaFinVenta;
    private float $_precio;
    private Caracteristicas $_caracteristica;

    public function __set($name, $value)
    {
        throw new \Exception("No existe la propiedad $name");
    }
    public function __unset($name)
    {
        throw new \Exception("No existe la propiedad $name");
    }
    public function __isset($name)
    {
        throw new \Exception("No existe la propiedad $name");
    }
    public function __get($name)
    {
        throw new \Exception("No existe la propiedad $name");
    }

    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30)
    {

        if(self::$_mueblesCreados >= self::MAXIMO_MUEBLES){
            throw new Exception("No se pueden crear más muebles, el máximo es: " . self::MAXIMO_MUEBLES);
        }
        if(!$this->setNombre($nombre)){
            throw new Exception("El nombre del mueble no es válido");
        }
        if(!$this->setPais($pais)){
            $this->_pais = "ESPAÑA";
        }
        if(!$this->setFabricante($fabricante)){
            $this->_fabricante = "FaMu:";
        }
        if(!$this->setAnio($anio)){
            $this->_anio = 2020;
        }
        if(!$this->setFechaIniVenta($fechaIniVenta)){
            $this->_fechaIniVenta = "01/01/" . $this->_anio;
        }
        $this->_fechaFinVenta = "31/12/2040";
        if(!$this->setPrecio($precio)){
            $this->_precio = 30;
        }
        $this->_caracteristica = new Caracteristicas();
        self::$_mueblesCreados++;
    }

    public function setNombre(string $_nombre): bool{
        $resultado = true;
        $_nombre = mb_strtoupper(mb_trim($_nombre));
        if($_nombre == "" || !validaCadena($_nombre, 40, $_nombre))
            $resultado = false;
        $this->_nombre = $_nombre;
        return $resultado;
    }

    public function getNombre(): string{
        return $this->_nombre;
    }

    public function setFabricante(string $_fabricante): bool{
        $prefijo = "FaMu:";
        if(mb_substr($_fabricante,0,mb_strlen($prefijo)) !== $prefijo){
            $_fabricante = $prefijo . $_fabricante;
        }
        $this->_fabricante = mb_substr($_fabricante, 0, 30);
        return true;
    }

    public function getFabricante(): string{
        return $this->_fabricante;
    }

    public function setPais(string $_pais): bool{
        $resultado = true;
        if(!validaCadena($_pais, 20, "ESPAÑA")){
            $resultado = false;
        }
        $this->_pais = $_pais;
        return $resultado;
    }

    public function getPais(): string{
        return $this->_pais;
    }

    public function setAnio(int $_anio): bool{
        $resultado = true;
        $anioActual = (int)date("Y");
        if(!validaEntero($_anio, 2020, $anioActual, 2020)){
            $resultado = false;
        }
        $this->_anio = $_anio;
        return $resultado;
    }

    public function getAnio(): int{
        return $this->_anio;
    }

    public function setFechaIniVenta(string $_fechaIniVenta): bool{
        $resultado = true;
        $fechaFormateada = $_fechaIniVenta;
        if(!validaFecha($fechaFormateada, "01/01/".$this->getAnio())){
            $resultado = false;
        }
        $anioVenta = (int)mb_substr($fechaFormateada, 6, 4);
        if ($anioVenta < $this->_anio){
            $resultado = false;
        }
        $this->_fechaIniVenta = $fechaFormateada;
        return $resultado;
    }

    public function getFechaIniVenta(): string{
        return $this->_fechaIniVenta;
    }

    public function setPrecio(float $_precio): bool{
        $resultado = true;
        if($_precio < 30)
            $resultado = false;
        $this->_precio = $_precio;
        return $resultado;
    }

    public function getPrecio(): float{
        return $this->_precio;
    }

    public function damePropiedadesAdicionales(): array{
        return [];
    }

    public function getCaracteristicas(): Caracteristicas{
        return $this->_caracteristica;
    }

    public function anadirCaracteristicas(mixed ...$parametros): void{
        for($i = 0; $i < count($parametros) - 1; $i+=2){
            $nombre= $parametros[$i];
            if($nombre == "" || !is_string($nombre)){
                throw new Exception("El nombre de la característica debe ser una cadena que no esté vacía");
            }
            $this->_caracteristica->$nombre = $parametros[$i + 1];
        }
    }
    public static function puedeCrear(int &$numero): bool{
        $resultado = true;
        if(self::$_mueblesCreados >= self::MAXIMO_MUEBLES){
            $numero = 0;
            $resultado = false;
        }
        else{
            $numero = self::MAXIMO_MUEBLES - self::$_mueblesCreados;
        }
        return $resultado;
    }

    public function __toString()
    {
        return "MUEBLE de clase " . self::$_mueblesCreados . " con nombre " . $this->_nombre . ", fabricante " . $this->_fabricante . ", fabricado en " . $this->_pais . 
        " a partir del año " . $this->_anio . ", vendido desde " . $this->_fechaIniVenta . " hasta " . $this->_fechaFinVenta . 
        " precio " . $this->_precio . ", características " . $this->_caracteristica;
    }
}