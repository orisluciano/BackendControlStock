<?php
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/Acciones.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/SugerenciaServicio.php";
require_once "./Aplicacion/DTO/SugerenciaDTO.php";

class SugerenciaController implements IApiController
{
    protected $metodos;
    protected $acciones;
    protected $mensajes;
    protected $datos;
    protected $metodo;
    protected $parametros;
    protected $token;
    protected TokenServicio $tokenService;
    protected ISugerenciaServicio $sugerenciaService;

    public function __construct(ISugerenciaServicio $iSugerenciaServicio, TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->metodos = new HttpMethods();
        $this->acciones = new Acciones();
        $this->mensajes = new Mensajes();
        $this->tokenService = $tokenServicio;
        $this->sugerenciaService = $iSugerenciaServicio;
        $this->metodo = $metodo;
        $this->datos = $datos;
        $this->parametros = $parametros;
        $this->token = $token;
    }

    public function _ejecutar(){
        $respuesta = new RespuestaPeticion();
        switch ($this->metodo) {
            case $this->metodos->GET:
                $respuesta = $this->_get();
                break;
            case $this->metodos->POST:
                $respuesta = $this->_post();
                break;
            case $this->metodos->PUT:
                $respuesta = $this->_put();
                break;
            case $this->metodos->DELETE:
                $respuesta = $this->_delete();
                break;
            default:
            $respuesta->errores[] = "Metodo equivocado";
                break;
        }
        echo(json_encode($respuesta));
    }

    public function _get(){
        $respuesta = new RespuestaPeticion();
        return $respuesta;
    }

    public function _post(){
        $respuesta = new RespuestaPeticion();
        $respuesta = $this->checkToken($this->token);
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            if (!property_exists($this->datos, "descripcion")) {
                $respuesta->errores[] = "Falta descripcion";
            }
            if (!property_exists($this->datos, "usuarioId")) {
                $respuesta->errores[] = "Falta usuarioId";
            }
            if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
                $sugerencia = new SugerenciaDTO();
                $sugerencia->descripcion = $this->datos->descripcion;
                $sugerencia->usuarioId = $this->datos->usuarioId;
                $resServ = $this->sugerenciaService->_nuevo($sugerencia);
                $respuesta->respuesta = $resServ->resultado;
                $respuesta->errores = $resServ->errores;
                $respuesta->mensajes = $resServ->mensajes;
            }
        }
        return $respuesta;
    }

    public function _put(){
        $respuesta = new RespuestaPeticion();
        return $respuesta;
    }

    public function _delete(){
        $respuesta = new RespuestaPeticion();
        return $respuesta;
    }

    private function checkToken(string $token) : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        if ($this->token !== "") {
            if ($this->tokenService->is_jwt_valid($this->token)) {
                $respuesta->mensajes[] = "Token valido";
            } else {
                $respuesta->respuesta = null;
                $respuesta->errores[] = $this->mensajes->TokenNoValido;
            }
        } else {
            $respuesta->respuesta = null;
            $respuesta->errores[] = $this->mensajes->FaltaToken;
        }
        return $respuesta;
    }
}
?>