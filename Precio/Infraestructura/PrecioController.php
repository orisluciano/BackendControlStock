<?php
require_once "./Api/IApiController.php";
require_once "./Api/HttpMethods.php";
require_once "./Api/RespuestaPeticion.php";
require_once "./Api/Mensajes.php";
require_once "./Api/Errores.php";
require_once "./Api/Acciones.php";

class PrecioController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_parametros;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected IPrecioServicio $_precioServicio;

    public function __construct($metodo, $datos, $parametros, IPrecioServicio $_precioServicio){
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_precioServicio = $_precioServicio;
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
                $respuesta = $this->_getPreciosByProductoId();
            } else {
                $respuesta = $this->_getprecio();
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

            if (!property_exists($this->_datos, "codSKU")) {
                $respuesta->errores[] = "Falta codigo";
            }
            if (!property_exists($this->_datos, "tipoProductoId")) {
                $respuesta->errores[] = "Falta tipoProductoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $producto = new PrecioDTO();
            //$producto->id = $this->_datos->id;
            /*$producto->nombre = $this->_datos->nombre;
            $producto->descripcion = $this->_datos->descripcion;
            $producto->codSKU = $this->_datos->codSKU;
            $producto->tipoProdId = (int)$this->_datos->tipoProductoId;
            $resServ = $this->_precioServicio->_nuevo($precio);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;*/
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
            if (!property_exists($this->_datos, "codSKU")) {
                $respuesta->errores[] = "Falta codigo";
            }
            if (!property_exists($this->_datos, "tipoProductoId")) {
                $respuesta->errores[] = "Falta tipoProductoId";
            }
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $producto = new ProductoDTO();
            /*$producto->id = $this->_datos->id;
            $producto->nombre = $this->_datos->nombre;
            $producto->descripcion = $this->_datos->descripcion;
            $producto->codSKU = $this->_datos->codSKU;
            $producto->tipoProdId = (int)$this->_datos->tipoProductoId;
            $resServ = $this->_prodServicio->_modificar($producto);*/
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

    protected function _getprecio() : RespuestaPeticion {
        return new RespuestaPeticion();
    }

    protected function _getPreciosByProductoId() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        if (!is_numeric($this->_parametros[0])) {
            $respuesta->errores[] = "El id debe ser numerico";
        }
        if (count($respuesta->errores) === 0) {
            $precios = $this->_precioServicio->_getByIdFechas($this->_parametros[0], $this->_parametros[1], $this->_parametros[2]);
            $respuesta->respuesta["resultados"] = $precios->resultado;
            $respuesta->errores = $precios->errores;
            $respuesta->mensajes = $precios->mensajes;
        }
        return $respuesta;
    }
}

?>