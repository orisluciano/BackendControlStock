<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class TipoStockController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_parametros;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected ITipoStockServicio $_tipoStockServicio;

    public function __construct($metodo, $datos, $parametros, ITipoStockServicio $_tipoStockServicio){
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_tipoStockServicio = $_tipoStockServicio;
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
        if ($this->_parametros != null) {
            if (count($this->_parametros) > 1) {
                /*switch ($this->_parametros) {
                    case is_numeric($this->_parametros[0]):
                        $respuesta = $this->_getStock();
                        break;
                    default:
                        $respuesta->errores[] = "No coincide ningun parametro";
                        break;
                }*/
                $respuesta->mensajes[] = "Proximamente";
            } else {
                //$respuesta = $this->_getStockByProductoId();
                $respuesta->mensajes[] = "Proximamente";
            }
            
        } else {
            $respuesta = $this->_getTipoStock();
        }
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "descripcion") || $this->_datos->descripcion === "") {
                $respuesta->errores[] = "Falta descripcion";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $tipoStock = new TipoStockDTO();
            $tipoStock->descripcion = (string)$this->_datos->descripcion;
            $resServ = $this->_tipoStockServicio->_nuevo($tipoStock);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    public function _put(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "id" )|| $this->_datos->id === null) {
                $respuesta->errores[] = "Falta id";
            }
            if (!property_exists($this->_datos, "descripcion") || $this->_datos->descripcion === null) {
                $respuesta->errores[] = "Falta descripcion";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $tipoStock = new TipoStockDTO();
            $tipoStock->id = (int)$this->_datos->id;
            $tipoStock->descripcion = (string)$this->_datos->descripcion;
            $resServ = $this->_tipoStockServicio->_modificar($tipoStock);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }
    public function _delete(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "id" )|| $this->_datos->id === null) {
                $respuesta->errores[] = "Falta id";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $resServ = $this->_tipoStockServicio->_eliminar($this->_datos->id);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    protected function _getTipoStock() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $tipos = $this->_tipoStockServicio->_getTodo();
        if (count($tipos->errores) > 0) {
            $respuesta->errores = $tipos->errores;;
        } else {
            $respuesta->respuesta = $tipos->resultado;
            $respuesta->mensajes = $tipos->mensajes;
            $respuesta->errores = $tipos->errores;
        }
        return $respuesta;
    }
}

?>