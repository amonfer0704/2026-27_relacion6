<?php

class Caracteristicas implements Iterator{

    private array $_propiedades = [];
    private bool $_cerrada = false;

    public function __set(string $name, mixed $value): void
    {
        if($this->_cerrada && array_key_exists($name, $this->_propiedades)){
            throw new Exception("No se pueden añadir más características");
        }
        $this->_propiedades[$name] = $value;
        if($name === "ULTIMA"){
            $_cerrada = true;
        }
    }

    public function __get($name): mixed
    {
        if(array_key_exists($name, $this->_propiedades)){
            throw new Exception("La característica $name no existe");
        }
        return $this->_propiedades[$name];
    }

    public function __isset($name): bool
    {
        return isset($this->_propiedades[$name]);
    }

    public function __unset($name): void
    {
        unset($this->_propiedades[$name]);
    }
}