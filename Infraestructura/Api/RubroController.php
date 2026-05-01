<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";
class RubroController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected HttpMethods $_metodos;
    protected Acciones $_acciones;
    protected Mensajes $_mensajes;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected IRubroServicio $_rbService;

    public function __construct(IRubroServicio $rbServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_rbService = $rbServ;
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
                $respuesta = $this->_getRubros();
            }else {
                if (is_numeric($this->_parametros[0])) {
                    $servRes = $this->_rbService->_getRubroById($this->_parametros[0]);
                    if (count($servRes->errores) > 0) {
                        $respuesta->errores = $servRes->errores;
                    }else {
                        $respuesta->respuesta = $servRes->listaDatos;
                    }
                }else {
                    $respuesta->errores[] = "No se proporciono el id del trabajador requerido";
                }
            }
        }else {
            $respuesta->errores[] = "No se proporciono ningun parametro";
        }
        return $respuesta;
    }
    public function _post(){}
    public function _put(){}
    public function _delete(){}

    protected function _getRubros(){
        $respuesta = new RespuestaPeticion();
        $cant = $this->_rbService->_getCantidad();
        if (count($cant->errores) > 0) {
            $respuesta->errores = $cant->errores;
            $respuesta->errores[] = "Hubo un error";
        } else {
            $respuesta->respuesta["cantidad"] = $cant->resultado;
            $resServ = $this->_rbService->_getRubros($this->_parametros[0], $this->_parametros[1]);
            $respuesta->respuesta["resultados"] = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
        }
        return $respuesta;
    }
}

?>