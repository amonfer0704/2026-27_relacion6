<?php

class Caracteristicas implements Iterator{

    private array $_propiedades = [];
<<<<<<< HEAD
    private int $_posicion = 0;
    private array $_claves = [];
=======
    private array $_claves;
    private int $_posicion = 0;
>>>>>>> bff5b07f081398447eb0ec17f167b506dd59319f

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
        return isset($this->_propiedades[$name]);
    }

    public function __unset($name): void
    {
        unset($this->_propiedades[$name]);
    }

    #[Override]
<<<<<<< HEAD
    public function rewind(): void
    {
        $_claves = array_reverse(array_keys($this->_propiedades));
        $this->_posicion = 0;
    }

    #[Override]
    public function valid(): bool
    {
        return $this->_posicion < count($this->_claves);
=======
    public function next(): void
    {
        $this->_posicion--;
>>>>>>> bff5b07f081398447eb0ec17f167b506dd59319f
    }

    #[Override]
    public function current(): mixed
    {
<<<<<<< HEAD
        return $this->_propiedades[$this->_claves[$this->_posicion]];
=======
        return $this->_posicion;
>>>>>>> bff5b07f081398447eb0ec17f167b506dd59319f
    }

    #[Override]
    public function key(): mixed
    {
        return $this->_claves[$this->_posicion];
    }

    #[Override]
<<<<<<< HEAD
    public function next(): void
    {
        $this->_posicion++;
    }

    public function __toString()
    {
        $cadena = "";
        foreach($this->_propiedades as $clave => $valor){
            $cadena .= $clave . ":" . $valor;
        }   
        return $cadena;
    }

=======
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
>>>>>>> bff5b07f081398447eb0ec17f167b506dd59319f
}