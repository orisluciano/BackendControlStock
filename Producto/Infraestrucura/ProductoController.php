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
                $respuesta = $this->_getProductos();
            } else {
                $respuesta = $this->_getproducto();
            }
            
        } else {
            $respuesta->errores[] = "No se proporciono ningun parametro";
        }
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        if (empty($this->_datos)) {
            $respuesta->errores[] = "Faltan todos los datos";
        }else {
            if (!property_exists($this->_datos, "nombre")) {
                $respuesta->errores[] = "Falta nombre del producto";
            }else {
                if ($this->_datos->nombre === null) {
                    $respuesta->errores[] = "El nombre no puede estar vacio";
                }
            }
            if (!property_exists($this->_datos, "descripcion")) {
                $respuesta->errores[] = "Falta descripcion del producto";
            }elseif ($this->_datos->descripcion === null) {
                $respuesta->errores[] = "La descripcion no puede estar vacia";
            }

            if (!property_exists($this->_datos, "codigo")) {
                $respuesta->errores[] = "Falta codigo";
            }
            if (!property_exists($this->_datos, "tipoCodigo")) {
                $respuesta->errores[] = "Falta tipoCodigo";
            }
            if (!property_exists($this->_datos, "tipoProductoId")) {
                $respuesta->errores[] = "Falta tipoProductoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $producto = new ProductoDTO();
            //$producto->id = $this->_datos->id;
            $producto->nombre = $this->_datos->nombre;
            $producto->descripcion = $this->_datos->descripcion;
            $producto->codigo= $this->_datos->codigo;
            $producto->tipoCodigo= $this->_datos->tipoCodigo;
            $producto->tipoProdId = (int)$this->_datos->tipoProductoId;
            $resServ = $this->_prodServicio->_nuevo($producto);
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
            if (!property_exists($this->_datos, "nombre") || $this->_datos->nombre === null) {
                $respuesta->errores[] = "Falta nombre del producto";
            }
            if (!property_exists($this->_datos, "descripcion") || $this->_datos->descripcion === null) {
                $respuesta->errores[] = "Falta descripcion del producto";
            }
            if (!property_exists($this->_datos, "codigo")) {
                $respuesta->errores[] = "Falta codigo";
            }
            if (!property_exists($this->_datos, "tipoCodigo")) {
                $respuesta->errores[] = "Falta tipoCodigo";
            }
            if (!property_exists($this->_datos, "tipoProductoId")) {
                $respuesta->errores[] = "Falta tipoProductoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $producto = new ProductoDTO();
            $producto->id = $this->_datos->id;
            $producto->nombre = $this->_datos->nombre;
            $producto->descripcion = $this->_datos->descripcion;
            $producto->codigo = $this->_datos->codigo;
            $producto->tipoCodigo = $this->_datos->tipoCodigo;
            $producto->tipoProdId = (int)$this->_datos->tipoProductoId;
            $resServ = $this->_prodServicio->_modificar($producto);
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