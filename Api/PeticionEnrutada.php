<?php
class PeticionEnrutada
{
    protected $metodo;
    protected $parametros;
    protected $datos;

    public function __construct($metodo, $parametros, $datos) {
        $this->metodo = $metodo;
        $this->parametros = $parametros;
        $this->datos = $datos;
    }
}

?>