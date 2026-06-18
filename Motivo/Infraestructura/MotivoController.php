<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class MotivoController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_parametros;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected IMotivoServicio $_motivoServicio;

    public function __construct($metodo, $datos, $parametros, IMotivoServicio $_motivoServicio){
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_motivoServicio = $_motivoServicio;
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
                switch ($this->_parametros) {
                    case is_numeric($this->_parametros[0]):
                        $respuesta = $this->_getMotivoById();
                        break;
                    default:
                        $respuesta->errores[] = "No coincide ningun parametro";
                        break;
                }
            }else{
                $respuesta->errores[] = "No coincide ningun parametro";
            }
        } else {
            $respuesta = $this->_getMotivos();
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
            if (!property_exists($this->_datos, "tipo") || $this->_datos->tipo === "") {
                $respuesta->errores[] = "Falta tipo";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $motivo = new MotivoDTO();
            $motivo->tipo = (string)$this->_datos->tipo;
            $motivo->descripcion = (string)$this->_datos->descripcion;
            $resServ = $this->_motivoServicio->_nuevo($motivo);
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
            if (!property_exists($this->_datos, "tipo") || $this->_datos->tipo === "") {
                $respuesta->errores[] = "Falta tipo";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $motivo = new MotivoDTO();
            $motivo->id = (int)$this->_datos->id;
            $motivo->tipo = (string)$this->_datos->tipo;
            $motivo->descripcion = (string)$this->_datos->descripcion;
            $resServ = $this->_motivoServicio->_modificar($motivo);
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
            $resServ = $this->_motivoServicio->_eliminar($this->_datos->id);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    protected function _getMotivos() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $motivos = $this->_motivoServicio->_getTodo();
        if (count($motivos->errores) > 0) {
            $respuesta->errores = $motivos->errores;
        }else{
            $respuesta->respuesta = $motivos->resultado;
            $respuesta->mensajes = $motivos->mensajes;
            $respuesta->errores = $motivos->errores;
        }
        return $respuesta;
    }

    protected function _getMotivoById() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        /*$stock = $this->_stockServicio->_getStockByProductoId($this->_parametros[0]);
        if (count($stock->errores) > 0) {
            $respuesta->errores = $stock->errores;
        } else {
            $tipoStock = $this->_tipoStockServicio->_getById($stock->resultado[0]->tipoStockId);
            if (count($tipoStock->errores) > 0) {
                $respuesta->errores[] = "Hubo un error al buscar el tipo de stock";
            } else {
                $respuesta->respuesta['stock'] = $stock->resultado[0];
                $respuesta->respuesta['tipoStock'] = $tipoStock->resultado[0];
                $respuesta->mensajes = $stock->mensajes;
                $respuesta->errores = $stock->errores;
            }
        }*/
        return $respuesta;
    }
}

?>