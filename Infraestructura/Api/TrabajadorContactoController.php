<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class TrabajadorContactoController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_metodos;
    protected $_acciones;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected ITrabajadorContactoServicio $_tcService;

    public function __construct(ITrabajadorContactoServicio $tcServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
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
                    $respuesta = $this->_getTrabajadoresContactos();
                } else {
                    if ($this->_parametros[0] === "contactos") {
                        $respuesta = $this->_getContactosByTrabajador();
                    } else {
                        $respuesta->errores[] = "Parametro erroneo";
                    }
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

    public function _post(){
        $respuesta = new RespuestaPeticion();
        $respuesta->errores = [];
        if (!property_exists($this->_datos, "tipoContactoId")) {
            $respuesta->errores[] = "Falta tipoContactoId";
        }
        if (!property_exists($this->_datos, "trabajadorId")) {
            $respuesta->errores[] = "Falta trabajadorId";
        }
        if (!property_exists($this->_datos, "descripcion")) {
            $respuesta->errores[] = "Falta descripcion";
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $dto = new TrabajadorContactoDTO();
            $dto->id = 0;
            $dto->fechaCreacion = "";
            $dto->fechaModif = "";
            $dto->tipoContactoId = $this->_datos->tipoContactoId;
            $dto->trabajadorId = $this->_datos->trabajadorId;
            $dto->descripcion = $this->_datos->descripcion;
            $resCrear = $this->_tcService->_nuevoTrabajadorContacto($dto, $this->_token);
            $respuesta->respuesta = $resCrear->resultado;
            $respuesta->errores = $resCrear->errores;
            $respuesta->mensajes = $resCrear->mensajes;
        }
        return $respuesta;
    }

    public function _put(){}

    public function _delete(){
        $respuesta = new RespuestaPeticion();
        $respuesta->errores = [];
        if (!property_exists($this->_datos, "id")) {
            $respuesta->errores[] = "Falta Id";
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $resCrear = $this->_tcService->_eliminarTrabajadorContacto($this->_datos->id, $this->_token);
            $respuesta->respuesta = $resCrear->resultado;
            $respuesta->errores = $resCrear->errores;
            $respuesta->mensajes = $resCrear->mensajes;
        }
        return $respuesta;
    }

    protected function _getTrabajadoresContactos() {
        
    }

    protected function _getContactosByTrabajador() {
        $respuesta = new RespuestaPeticion();
        $contactos = $this->_tcService->_getContactosByTrabajadorId($this->_parametros[1]);
        $respuesta->respuesta["resultados"] = $contactos->resultado;
        $respuesta->errores = $contactos->errores;
        return $respuesta;
    }
}
?>