<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class MovimientoStockController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_parametros;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected IMovimientoStockServicio $_movStockServicio;

    public function __construct($metodo, $datos, $parametros, IMovimientoStockServicio $_movStockServicio){
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_movStockServicio = $_movStockServicio;
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
            if (count($this->_parametros) >= 1) {
                switch ($this->_parametros) {
                    case is_numeric($this->_parametros[0]) && count($this->_parametros) === 1:
                        $respuesta = $this->_movStockById();
                        break;
                    case count($this->_parametros) === 3:
                        $respuesta = $this->_movStockById();
                        break;
                    default:
                        $respuesta->errores[] = "No coincide ningun parametro";
                        break;
                }
            } else {
                //$respuesta = $this->_getStockByProductoId();
                $respuesta->mensajes[] = "Proximamente";
            }
            
        } else {
            $respuesta = $this->_getTodoMovStock();
        }
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "minimo") || $this->_datos->minimo === "") {
                $respuesta->errores[] = "Falta minimo del stock";
            }
            if (!property_exists($this->_datos, "maximo") || $this->_datos->maximo === "") {
                $respuesta->errores[] = "Falta maximo del stock";
            }
            if (!property_exists($this->_datos, "tipoStockId") || $this->_datos->tipoStockId === "") {
                $respuesta->errores[] = "Falta tipoStockId";
            }
            if (!property_exists($this->_datos, "productoId") || $this->_datos->productoId === "") {
                $respuesta->errores[] = "Falta productoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $movStock = new MovimientoStockDTO();
            $movStock->stockId = (int)$this->_datos->stockId;
            $movStock->cantidad = (float)$this->_datos->cantidad;
            $movStock->tipoMovimientoId = (int)$this->_datos->tipoMovimientoId;
            $movStock->motivoMovId = (int)$this->_datos->motivoMovId;
            $resServ = $this->_movStockServicio->_nuevo($movStock);
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
            if (!property_exists($this->_datos, "actual") || $this->_datos->actual === null) {
                $respuesta->errores[] = "Falta actual";
            }
            if (!property_exists($this->_datos, "minimo") || $this->_datos->minimo === null) {
                $respuesta->errores[] = "Falta minimo del stock";
            }
            if (!property_exists($this->_datos, "maximo") || $this->_datos->maximo === null) {
                $respuesta->errores[] = "Falta maximo del stock";
            }
            if (!property_exists($this->_datos, "tipoStockId") || $this->_datos->tipoStockId === null) {
                $respuesta->errores[] = "Falta tipoStockId";
            }
            if (!property_exists($this->_datos, "productoId") || $this->_datos->productoId === null) {
                $respuesta->errores[] = "Falta productoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $stock = new StockDTO();
            $stock->id = (int)$this->_datos->id;
            $stock->actual = (float)$this->_datos->actual;
            $stock->minimo = (float)$this->_datos->minimo;
            $stock->maximo = (float)$this->_datos->maximo;
            $stock->tipoStockId = (int)$this->_datos->tipoStockId;
            $stock->productoId = (int)$this->_datos->productoId;
            $resServ = $this->_stockServicio->_modificar($stock);
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
            $resServ = $this->_prodServicio->_eliminar($this->_datos->id);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    protected function _movStockById() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $tipos = $this->_movStockServicio->_getMovsById($this->_parametros[0], $this->_parametros[1], $this->_parametros[2]);
        if (count($tipos->errores) > 0) {
            $respuesta->errores = $tipos->errores;;
        } else {
            $respuesta->respuesta = $tipos->resultado;
            $respuesta->mensajes = $tipos->mensajes;
            $respuesta->errores = $tipos->errores;
        }
        return $respuesta;
    }

    protected function _getTodoMovStock() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $tipos = $this->_movStockServicio->_getTodo();
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