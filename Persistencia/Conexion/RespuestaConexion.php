<?php
class RespuestaConexion
{
    public /*PDO*/ $conexion;
    public $mensajes;
    public $errores;
    
    function __construct(){
        //$this->conexion = null;
        $this->mensajes = array();
        $this->errores = array();
    }
}
?>