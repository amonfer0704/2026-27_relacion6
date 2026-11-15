<?php

class Caracteristicas implements Iterator{

    private array $_propiedades = [];
    private array $_claves = [];
    private int $_posicion = 0;

    public function __set(string $name, mixed $value): void
    {
        if(array_key_exists("ULTIMA", $this->_propiedades) && !array_key_exists($name, $this->_propiedades)){
            throw new Exception("No se pueden añadir más características");
        }
        $this->_propiedades[$name] = $value;
    }

    public function __get($name): mixed
    {
        if(!array_key_exists($name, $this->_propiedades)){
            throw new Exception("La característica $name no existe");
        }
        return $this->_propiedades[$name];
    }

    public function __isset($name): bool
    {
        return array_key_exists($name, $this->_propiedades);
    }

    public function __unset($name): void
    {
        unset($this->_propiedades[$name]);
    }

    #[Override]
    public function next(): void
    {
        $this->_posicion--;
    }

    #[Override]
    public function current(): mixed
    {
        return $this->_propiedades[$this->_claves[$this->_posicion]];
    }

    #[Override]
    public function key(): mixed
    {
        return $this->_claves[$this->_posicion];
    }

    #[Override]
    public function rewind(): void
    {
        $this->_claves = array_keys($this->_propiedades);
        $this->_posicion = count($this->_claves) - 1;
    }

    #[Override]
    public function valid(): bool
    {
        return $this->_posicion >= 0;
    }

    public function __toString()
    {
        $cadena = "";
        foreach($this->_propiedades as $clave => $valor){
            $cadena .= $clave . ":" . $valor . ";";
        }   
        return $cadena;
    }


}