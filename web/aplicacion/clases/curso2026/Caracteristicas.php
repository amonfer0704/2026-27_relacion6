<?php

/**
 * Clase características para muebles, se puede recorrer con un foreach en orden inverso
 * Se crean las propiedades de forma dinámica
 */
class Caracteristicas implements Iterator{

    /**
     * Características guardadas con clave valor en orden
     */
    private array $_propiedades = [];
    /**
     * Nombre de las características
     *
     * @var array
     */
    private array $_claves = [];
    /**
     * Posición actual del recorrido
     *
     * @var integer
     */
    private int $_posicion = 0;

    /**
     * Añade o modifica una característica, si ya existe última, no se puede añadir
     * ninguna nueva y lanza excepción, pero si se puede modificar las que existan
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        if(array_key_exists("ULTIMA", $this->_propiedades) && !array_key_exists($name, $this->_propiedades)){
            throw new Exception("No se pueden añadir más características");
        }
        $this->_propiedades[$name] = $value;
    }

    /**
     * Devuelve el valor de una característica y si no existe, excepción
     *
     * @param [type] $name
     * @return mixed
     */
    public function __get($name): mixed
    {
        if(!array_key_exists($name, $this->_propiedades)){
            throw new Exception("La característica $name no existe");
        }
        return $this->_propiedades[$name];
    }

    /**
     * Indica si existe la característica
     *
     * @param [type] $name
     * @return boolean
     */
    public function __isset($name): bool
    {
        return array_key_exists($name, $this->_propiedades);
    }

    /**
     * Elimina una característica
     *
     * @param [type] $name
     * @return void
     */
    public function __unset($name): void
    {
        unset($this->_propiedades[$name]);
    }

    /**
     * Redefinición de los métodos de iterator
     * Next pasa a la característica anterior
     *
     * @return void
     */
    #[Override]
    public function next(): void
    {
        $this->_posicion--;
    }

    /**
     * Valor de la característica actual
     *
     * @return mixed
     */
    #[Override]
    public function current(): mixed
    {
        return $this->_propiedades[$this->_claves[$this->_posicion]];
    }

    /**
     * Nombre de la característica actual
     *
     * @return mixed
     */
    #[Override]
    public function key(): mixed
    {
        return $this->_claves[$this->_posicion];
    }

    /**
     * Empieza el recorrido por la última característica añadida
     *
     * @return void
     */
    #[Override]
    public function rewind(): void
    {
        $this->_claves = array_keys($this->_propiedades);
        $this->_posicion = count($this->_claves) - 1;
    }

    /**
     * Mientras haya posiciones por recorrer, se cumplirá la condición
     *
     * @return boolean
     */
    #[Override]
    public function valid(): bool
    {
        return $this->_posicion >= 0;
    }

    /**
     * Redefinición del método toString para mostrar car1:valor1;
     *
     * @return string
     */
    public function __toString()
    {
        $cadena = "";
        foreach($this->_propiedades as $clave => $valor){
            $cadena .= $clave . ":" . $valor . ";";
        }   
        return $cadena;
    }


}