<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class ProductoController implements IApiController
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
                # code...
                break;
            case $this->_metodos->DELETE:
                # code...
                break;
            }
        echo(json_encode($respuesta));
    }

    public function _get(){
        $respuesta = new RespuestaPeticion();
        if ($this->_parametros != null) {
            if (count($this->_parametros) > 1) {
                $respuesta = $this->_getProductos();
            } else {
                $respuesta = $this->_getproducto();
            }
            
        } else {
            $respuesta->errores[] = "No se proporciono ningun parametro";
        }
        return $respuesta;
    }
    public function _post(){}
    public function _put(){}
    public function _delete(){}

    protected function _getproducto() : RespuestaPeticion {
        return new RespuestaPeticion();
    }

    protected function _getProductos() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $cant = $this->_prodServicio->_getCantidad();
        if (count($cant->errores) > 0) {
            $respuesta->errores = $cant->errores;
            $respuesta->errores[] = "Hubo un error";
        } else {
            $respuesta->respuesta["cantidad"] = $cant->resultado;
            $resServ = $this->_prodServicio->_getProductos($this->_parametros[0], $this->_parametros[1]);
            $respuesta->respuesta["resultados"] = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
        }
        return $respuesta;
    }
}

?>