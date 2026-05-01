<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class TipoContactoController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_metodos;
    protected $_acciones;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected ITipoContactoServicio $_tcService;

    public function __construct(ITipoContactoServicio $tcServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_tcService = $tcServ;
        $this->_tokenServicio = $tokenServicio;
        $this->_metodo = $metodo;
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
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
                if (is_numeric($this->_parametros[0])) {
                    $respuesta = $this->_getTipoContactos();
                } else {
                    $respuesta->errores[] = "Error en los parametros";
                }
            }else {
                if (is_numeric($this->_parametros[0])) {
                    $servRes = $this->usuarioService->getUsuario($this->parametros[0]);
                    if (count($servRes->errores) > 0) {
                        $respuesta->errores = $servRes->errores;
                    }else {
                        $respuesta->respuesta = $servRes->listaDatos;
                    }
                }else {
                    $respuesta->errores[] = "No se proporciono el id requerido";
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

    protected function _getTipoContactos() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $cantidad = $this->_tcService->_getCantidad();
        $tipos = $this->_tcService->_getTiposContactos($this->_parametros[0], $this->_parametros[1]);
        $respuesta->respuesta["cantidad"] = $cantidad->resultado;
        $respuesta->respuesta["resultados"] = $tipos->resultado;
        $respuesta->errores = $tipos->errores;
        return $respuesta;
    }
}

?>