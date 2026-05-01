<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class FavoritoController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected IFavoritoServicio $_fvService;

    public function __construct(IFavoritoServicio $rbServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_fvService = $rbServ;
        $this->_tokenServicio = $tokenServicio;
        $this->_metodo = $metodo;
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_token = $token;
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
        $respuesta = $this->checkToken($this->_token);
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
                if ($this->_parametros != null) {
                    $bandera = false;
                if (count($this->_parametros) === 1) {
                    $respuesta = $this->_getFavorito();
                    $bandera = true;
                }
                if (is_numeric($this->_parametros[0]) && is_numeric($this->_parametros[1])) {
                    $respuesta = $this->_getFavoritos();
                    $bandera = true;
                }
                if ($this->_parametros[0] === "usuario" && is_numeric($this->_parametros[1])) {
                    $respuesta = $this->_getByUsuario();
                    $bandera = true;
                }
                if ($bandera === false) {
                    $respuesta->errores[] = "Parametro equivocado";
                }
            }else {
                $respuesta->errores[] = "No se proporciono ningun parametro";
            }
        }
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        $respuesta = $this->checkToken($this->_token);
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            if (!property_exists($this->_datos, "etiqueta")) {
                $respuesta->errores[] = "Falta etiqueta";
            }
            if (!property_exists($this->_datos, "descripcion")) {
                $respuesta->errores[] = "Falta descripcion";
            }
            if (!property_exists($this->_datos, "usuarioId")) {
                $respuesta->errores[] = "Falta usuarioId";
            }
            if (!property_exists($this->_datos, "trabajadorId")) {
                $respuesta->errores[] = "Falta trabajadorId";
            }
            if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
                $favorito = new FavoritoDTO();
                $favorito->etiqueta = $this->_datos->etiqueta;
                $favorito->descripcion = $this->_datos->descripcion;
                $favorito->usuarioId = $this->_datos->usuarioId;
                $favorito->trabajadorId = $this->_datos->trabajadorId;
                $resServ = $this->_fvService->_nuevo($favorito);
                $respuesta->respuesta = $resServ->resultado;
                $respuesta->errores = $resServ->errores;
                $respuesta->mensajes = $resServ->mensajes;
            }
        }
        return $respuesta;
    }

    public function _put(){}
    public function _delete(){}

    protected function _getFavorito() : RespuestaPeticion {
        return new RespuestaPeticion();
    }

    protected function _getFavoritos() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $cant = $this->_fvService->_getCantidad();
        if (count($cant->errores) > 0) {
            $respuesta->errores = $cant->errores;
            $respuesta->errores[] = "Hubo un error";
        } else {
            $respuesta->respuesta["cantidad"] = $cant->resultado;
            $resServ = $this->_fvService->_getFavoritos($this->_parametros[0], $this->_parametros[1]);
            $respuesta->respuesta["resultados"] = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
        }
        return $respuesta;
    }

    protected function _getByUsuario() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $favs = $this->_fvService->_getByUsuario($this->_parametros[1]);
        $respuesta->respuesta["resultados"] = $favs->resultado;
        $respuesta->errores = $favs->errores;
        $respuesta->mensajes = $favs->mensajes;
        return $respuesta;
    }

    private function checkToken(string $token) : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        if ($this->_token !== "") {
            if ($this->_tokenServicio->is_jwt_valid($this->_token)) {
                $respuesta->mensajes[] = "Token valido";
            } else {
                $respuesta->respuesta = null;
                $respuesta->errores[] = $this->_mensajes->TokenNoValido;
            }
        } else {
            $respuesta->respuesta = null;
            $respuesta->errores[] = $this->_mensajes->FaltaToken;
        }
        return $respuesta;
    }
}

?>