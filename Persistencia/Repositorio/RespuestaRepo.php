<?php
class RespuestaRepo {
    public $resultado;
    public $errores;
    public $mensajes;

    public function __construct(){
        $this->resultado = null;
        $this->errores = array();
        $this->mensajes = array();
    }
}
?>