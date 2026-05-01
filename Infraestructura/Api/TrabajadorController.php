<?php 
require_once("IApiController.php");
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class TrabajadorController implements IApiController
{
    protected $_metodo;
    protected $_datos;
    protected $_metodos;
    protected $_acciones;
    protected $_mensajes;
    protected $_parametros;
    protected $_token;
    protected TokenServicio $_tokenServicio;
    protected ITrabajadorServicio $_trService;
    protected ITrabajadorUsuarioServicio $_tuService;
    protected $_rutasAlternativas;

    public function __construct(ITrabajadorServicio $trServ,ITrabajadorUsuarioServicio $tuServ , TokenServicio $tokenServicio, $metodo, $datos, $parametros, $token){
        $this->_trService = $trServ;
        $this->_tuService = $tuServ;
        $this->_tokenServicio = $tokenServicio;
        $this->_metodo = $metodo;
        $this->_metodos = new HttpMethods();
        $this->_acciones = new Acciones();
        $this->_mensajes = new Mensajes();
        $this->_metodo = $metodo;
        $this->_datos = $datos;
        $this->_parametros = $parametros;
        $this->_token = $token;
        $this->_rutasAlternativas = ["usuario" => "usuario", "rubro" => "rubro"];
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
                    $respuesta = $this->_getTrabajadores();
                } else {
                    switch($this->_parametros[0]){
                        case $this->_rutasAlternativas["usuario"]:
                            $respuesta = $this->_getTrabajadorPorUsuarioId($this->_parametros[1]);
                            break;
                        case $this->_rutasAlternativas["rubro"]:
                            $respuesta = $this->_getTrabajadoresByRubro();
                            break;
                    }
                }
                
            }else {
                if (is_numeric($this->_parametros[0])) {
                    $respuesta = $this->_getTrabajador($this->_parametros[0]);
                }else {
                    $respuesta->errores[] = "No se proporciono el id del trabajador requerido";
                }
            }
        }else {
            $respuesta->errores[] = "No se proporciono ningun parametro";
        }
        return $respuesta;
    }
    public function _post(){
        $respuesta = new RespuestaPeticion();
        $dto = new TrabajadorDTO();
        $dto->id = 0;
        $dto->fechaCreacion = "";
        $dto->fechaModif = "";
        $dto->nombre = $this->_datos->nombre;
        $dto->apellido = $this->_datos->apellido;
        $dto->descripcion = $this->_datos->descripcion;
        $resCrear = $this->_trService->_nuevoTrabajador($dto, $this->_token);
        $respuesta->respuesta = $resCrear->resultado;
        $respuesta->errores = $resCrear->errores;
        $respuesta->mensajes = $resCrear->mensajes;
        return $respuesta;
    }
    public function _put(){
        $respuesta = new RespuestaPeticion();
        $dto = new TrabajadorDTO();
        $dto->id = $this->_datos->id;
        $dto->fechaCreacion = "";
        $dto->fechaModif = "";
        $dto->nombre = $this->_datos->nombre;
        $dto->apellido = $this->_datos->apellido;
        $dto->descripcion = $this->_datos->descripcion;
        $resCrear = $this->_trService->_modificarTrabajador($dto, $this->_token);
        $respuesta->respuesta = $resCrear->resultado;
        $respuesta->errores = $resCrear->errores;
        $respuesta->mensajes = $resCrear->mensajes;
        return $respuesta;
    }
    public function _delete(){
        $respuesta = new RespuestaPeticion();
        $reseliminar = $this->_trService->_eliminarTrabajador($this->_datos->id, $this->_token);
        $respuesta->respuesta = $reseliminar->resultado;
        $respuesta->errores = $reseliminar->errores;
        $respuesta->mensajes = $reseliminar->mensajes;
        return $respuesta;
    }
    
    protected function _getTrabajadores() {
        $respuesta = new RespuestaPeticion();
        $resCantidad = $this->_trService->_getCantidad();
        $respuesta->respuesta["cantidad"] = $resCantidad->resultado;
        $resServ = $this->_trService->_getTrabajadores($this->_parametros[0], $this->_parametros[1]);
        $respuesta->respuesta["resultados"] = $resServ->resultado;
        $respuesta->errores = $resServ->errores;
        return $respuesta;
    }

    protected function _getTrabajadorPorUsuarioId(int $id) : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $resServ = $this->_tuService->_getTrabajadorByUsuarioId($id, $this->_token);
        $respuesta->respuesta["resultados"] = $resServ->resultado;
        $respuesta->errores = $resServ->errores;
        return $respuesta;
    }

    protected function _getTrabajador(int $id) : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $resServ = $this->_trService->_getTrabajadorById($id);
        $respuesta->respuesta = $resServ->resultado;
        $respuesta->errores = $resServ->errores;
        return $respuesta;
    }

    protected function _getTrabajadoresByRubro() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $resCantidad = $this->_trService->_getCantidadByRubro($this->_parametros[3]);
        $respuesta->respuesta["cantidad"] = $resCantidad->resultado;
        $resServ = $this->_trService->_getByRubro($this->_parametros[1],$this->_parametros[2],$this->_parametros[3]);
        $respuesta->respuesta["resultados"] = $resServ->resultado;
        $respuesta->errores = $resServ->errores;
        return $respuesta;
    }
}
?>