<?php
class RespuestaPeticion
{
 public $estado;
 public $respuesta;
 public $mensajes;
 public $errores;

 public function __construct(){
    $this->respuesta = null;
    $this->errores = array();
    $this->mensajes = array();
}
}
?>