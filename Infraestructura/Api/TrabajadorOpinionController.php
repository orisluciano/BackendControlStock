<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class TrabajadorOpinionController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_metodos;
    protected $_acciones;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected ITrabajadorOpinionServicio $_toService;

    public function __construct(ITrabajadorOpinionServicio $toServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_toService = $toServ;
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
                    if ($this->_parametros[0] === "opiniones") {
                        $respuesta = $this->_getOpinionesByTrabajador();
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
        if ($this->_datos === null) {
            $respuesta->errores[] = "No hay datos";
        }else {
            if (!property_exists($this->_datos, "usuarioId")) {
            $respuesta->errores[] = "Falta usuarioId";
            }
            if (!property_exists($this->_datos, "trabajadorId")) {
                $respuesta->errores[] = "Falta trabajadorId";
            }
            if (!property_exists($this->_datos, "trabajadorId")) {
                $respuesta->errores[] = "Falta trabajadorId";
            }
            if (!property_exists($this->_datos, "calificacion")) {
                $respuesta->errores[] = "Falta calificacion";
            }
            if (!property_exists($this->_datos, "opinion")) {
                $respuesta->errores[] = "Falta opinion";
            }
            if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
                $dto = new TrabajadorOpinionDTO;
                $dto->id = 0;
                $dto->fechaCreacion = "";
                $dto->fechaModif = "";
                $dto->trabajadorId = $this->_datos->trabajadorId;
                $dto->usuarioId = $this->_datos->usuarioId;
                $dto->calificacion = $this->_datos->calificacion;
                $dto->opinion = $this->_datos->opinion;
                $resCrear = $this->_toService->_nuevoTrabajadorOpinion($dto, $this->_token);
                $respuesta->respuesta = $resCrear->resultado;
                $respuesta->errores = $resCrear->errores;
                $respuesta->mensajes = $resCrear->mensajes;
            }
        }
        return $respuesta;
    }
    public function _put(){}
    public function _delete(){}

    protected function _getOpinionesByTrabajador() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $opiniones = $this->_toService->_getOpinionesByTrabajadorId($this->_parametros[1], $this->_parametros[2], $this->_parametros[3]);
        $respuesta->respuesta["resultados"] = $opiniones->resultado;
        $respuesta->errores = $opiniones->errores;
        return $respuesta;
    }
}
?>