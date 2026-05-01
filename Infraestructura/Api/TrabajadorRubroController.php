<?php
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class TrabajadorRubroController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_metodos;
    protected $_acciones;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected ITrabajadorRubroServicio $_trService;

    public function __construct(ITrabajadorRubroServicio $trServ, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_trService = $trServ;
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
                echo("TrabajadorRubro put");
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
                    $respuesta = $this->_getTrabajadoresRubros();
                } else {
                    if ($this->_parametros[0] === "rubros") {
                        $respuesta = $this->_getRubrosByTrabajador();
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
        if (!property_exists($this->_datos, "rubroId")) {
            $respuesta->errores[] = "Falta rubroId";
        }
        if (!property_exists($this->_datos, "trabajadorId")) {
            $respuesta->errores[] = "Falta trabajadorId";
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $dto = new TrabajadorRubroDTO;
            $dto->id = 0;
            $dto->fechaCreacion = "";
            $dto->fechaModif = "";
            $dto->trabajadorId = $this->_datos->trabajadorId;
            $dto->rubroId = $this->_datos->rubroId;
            $resCrear = $this->_trService->_nuevoTrabajadorRubro($dto, $this->_token);
            $respuesta->respuesta = $resCrear->resultado;
            $respuesta->errores = $resCrear->errores;
            $respuesta->mensajes = $resCrear->mensajes;
        }
        return $respuesta;
    }

    public function _put(){}

    public function _delete(){
        $respuesta = new RespuestaPeticion();
        if (isset($this->_datos->id)) {
            $rubros = $this->_trService->_eliminarTrabajador($this->_datos->id, $this->_token);
            $respuesta->respuesta["resultados"] = $rubros->resultado;
            $respuesta->errores = $rubros->errores;
            $respuesta->mensajes = $rubros->mensajes;
        } else {
            $respuesta->errores[] = "No se proporcionaron los datos requidos";
        }
        return $respuesta;
    }

    protected function _getTrabajadorRubro() {
        
    }

    protected function _getTrabajadoresRubros() {
        print_r($this->_parametros);
    }

    protected function _getRubrosByTrabajador() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $rubros = $this->_trService->_getRubrosByTrabajadorId($this->_parametros[1]);
        $respuesta->respuesta["resultados"] = $rubros->resultado;
        $respuesta->errores = $rubros->errores;
        $respuesta->mensajes = $rubros->mensajes;
        return $respuesta;
    }
}
?>