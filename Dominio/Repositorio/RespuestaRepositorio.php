<?php
class RespuestaRepositorio
{
    public $resultado;
    public $errores;
    public $mensajes;

    public function __construct(){
        $this->resultado = array();
        $this->errores = array();
        $this->mensajes = array();
    }
}
?>