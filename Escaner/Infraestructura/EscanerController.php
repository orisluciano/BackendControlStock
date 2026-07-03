<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class EscanerController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_parametros;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected IProductoServicio $_prodServicio;

    public function __construct($metodo, $datos, $parametros, IProductoServicio $_prodServicio){
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_prodServicio = $_prodServicio;
    }

    public function _ejecutar(){
        $respuesta = new RespuestaPeticion();
        switch($this->_metodo){
            case $this->_metodos->GET:
                $respuesta = $this->_get();
                break;
            case $this->_metodos->POST:
                $respuesta = $this->_post();
                break;
            case $this->_metodos->PUT:
                $respuesta = $this->_put();
                break;
            case $this->_metodos->DELETE:
                $respuesta = $this->_delete();
                break;
            }
        echo(json_encode($respuesta));
    }

    public function _get(){
        $respuesta = new RespuestaPeticion();
        $respuesta->errores[] = "Metodo equivocado";
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "codigo") || $this->_datos->codigo === "") {
                $respuesta->errores[] = "Falta codigo";
            }
            if (!property_exists($this->_datos, "tipoCodigo") || $this->_datos->tipoCodigo === "") {
                $respuesta->errores[] = "Falta tipoCodigo";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
           $respuesta = $this->_getByCodigo();
        }
        return $respuesta;
    }
    public function _put(){
        $respuesta = new RespuestaPeticion();
        $respuesta->errores[] = "Metodo equivocado";
        return $respuesta;
    }
    public function _delete(){
        $respuesta = new RespuestaPeticion();
        $respuesta->errores[] = "Metodo equivocado";
        return $respuesta;
    }

    protected function _getByCodigo() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $producto = $this->_prodServicio->_getByCodigo($this->_datos->codigo, $this->_datos->tipoCodigo);
        if (count($producto->errores) > 0) {
            $respuesta->errores = $producto->errores;
        } else {
            $respuesta->respuesta = $producto->resultado;
            $respuesta->mensajes = $producto->mensajes;
        }
        return $respuesta;
    }
}
?>