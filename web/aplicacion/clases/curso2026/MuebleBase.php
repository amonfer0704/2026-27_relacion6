<?php 

/**
 * Clase abstracta con los muebles de una tienda
 * No se puede instanciar al ser abstracta
 */
abstract class MuebleBase{
    /**
     * Número máximo de muebles que se pueden crear
     */
    private const int MAXIMO_MUEBLES = 10;
    /**
     * Variable de clase que muestra la cantidad de muebles creados
     *
     * @var integer
     */
    private static int $_mueblesCreados = 0;
    private string $_nombre;
    private string $_fabricante;
    private string $_pais;
    private int $_anio;
    private string $_fechaIniVenta;
    private string $_fechaFinVenta;
    private float $_precio;

    /**
     * Características adicionales de mueble
     *
     * @var Caracteristicas
     */
    private Caracteristicas $_caracteristica;

    /**
     * Métodos mágicos sin sobrecarga
     *
     * @param [type] $name
     * @param [type] $value
     */
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

    /**
     * Constructor, solo el nombre es obligatorio, los demás tienen valores por defecto
     *
     * @param string $nombre
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param integer $precio
     */
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
        if(!$this->setFechaFinVenta($fechaFinVenta)){
            $this->_fechaFinVenta =  "31/12/2040";
        }
        if(!$this->setPrecio($precio)){
            $this->_precio = 30;
        }
        $this->_caracteristica = new Caracteristicas();
        self::$_mueblesCreados++;
    }

    /**
     * Nombre en mayúsculas, que no esté vacío y máximo de 40 carácteres
     *
     * @param string $_nombre
     * @return boolean devuelve true y se asigna si es correcto y si no, devuelve falso y no asigna nada
     */
    public function setNombre(string $_nombre): bool{
        $resultado = true;
        $_nombre = mb_strtoupper(mb_trim($_nombre));
        if($_nombre == "" || !validaCadena($_nombre, 40, ""))
            $resultado = false;
        else
            $this->_nombre = $_nombre;
        return $resultado;
    }

    public function getNombre(): string{
        return $this->_nombre;
    }

    /**
     * Fabricante siempre empieza por "FaMu:", se añade si no lo tiene y se recorta de caracteres máximos (30)
     *
     * @param string $_fabricante
     * @return boolean
     */
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

    /**
     * País, cadena de 20 carácteres como máximo
     *
     * @param string $_pais
     * @return boolean
     */
    public function setPais(string $_pais): bool{
        $resultado = true;
        if(!validaCadena($_pais, 20, "ESPAÑA")){
            $resultado = false;
        }
        else{
            $this->_pais = $_pais;
        }
        return $resultado;
    }

    public function getPais(): string{
        return $this->_pais;
    }

    /**
     * Año de inicio de fabricación, entero entre 2020 y el año actual
     *
     * @param integer $_anio
     * @return boolean
     */
    public function setAnio(int $_anio): bool{
        $resultado = true;
        $anioActual = (int)date("Y");
        if(!validaEntero($_anio, 2020, $anioActual, 2020)){
            $resultado = false;
        }
        else
            $this->_anio = $_anio;
        return $resultado;
    }

    public function getAnio(): int{
        return $this->_anio;
    }

    /**
     * Fecha de inicio de venta, fecha válida y no anterior al año de fabricación
     *
     * @param string $_fechaIniVenta
     * @return boolean
     */
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
        if($resultado)
            $this->_fechaIniVenta = $fechaFormateada;
        return $resultado;
    }

    public function getFechaIniVenta(): string{
        return $this->_fechaIniVenta;
    }

    /**
     * Precio, número real no menor de 30
     *
     * @param float $_precio
     * @return boolean
     */
    public function setPrecio(float $_precio): bool{
        $resultado = true;
        if($_precio < 30)
            $resultado = false;
        if($resultado)
            $this->_precio = $_precio;
        return $resultado;
    }

    public function getPrecio(): float{
        return $this->_precio;
    }

    /**
     * Fecha de fin de venta, fecha válida que no puede ser anterior a la de inicio de venta
     *
     * @param string $fechaFinVenta
     * @return boolean
     */
    public function setFechaFinVenta(string $fechaFinVenta): bool{
        $resultado = true;
        $fecha = $fechaFinVenta;
        if(!validaFecha($fecha, "31/12/2040")){
            $resultado = false;
        }
        if($fecha < $this->_fechaIniVenta){
            $resultado = false;
        }
        if($resultado)
            $this->_fechaFinVenta = $fecha;
        return $resultado;
    }

    public function getFechaFinVenta(): string{
        return $this->_fechaFinVenta;
    }

    /**
     * Método que devuelve el nombre de las propiedades adicionales a las de la clase base
     *
     * @return array
     */
    public function damePropiedadesAdicionales(): array{
        return [];
    }

    /**
     * Devuelve las características del mueble
     *
     * @return Caracteristicas
     */
    public function getCaracteristicas(): Caracteristicas{
        return $this->_caracteristica;
    }

    /**
     * Añade características reciviendo pares de clave valor, si el número de argumentos es impar
     * el último no se usa
     *
     * @param mixed ...$parametros
     * @return void
     */
    public function anadirCaracteristicas(mixed ...$parametros): void{
        for($i = 0; $i < count($parametros) - 1; $i+=2){
            $nombre= $parametros[$i];
            if($nombre == "" || !is_string($nombre)){
                throw new Exception("El nombre de la característica debe ser una cadena que no esté vacía");
            }
            $this->_caracteristica->$nombre = $parametros[$i + 1];
        }
    }

    /**
     * Método de clase que devuelve true si se pueden crear más muebles y false si no
     *
     * @param integer $numero
     * @return boolean
     */
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

    /**
     * Método toString para devolver una cadena de mueble
     *
     * @return string
     */
    public function __toString()
    {
        return "MUEBLE de clase " . get_class($this) . " con nombre " . $this->_nombre . ", fabricante " . $this->_fabricante . ", fabricado en " . $this->_pais . 
        " a partir del año " . $this->_anio . ", vendido desde " . $this->_fechaIniVenta . " hasta " . $this->_fechaFinVenta . 
        ",  precio " . $this->_precio . ", características " . $this->_caracteristica;
    }
}