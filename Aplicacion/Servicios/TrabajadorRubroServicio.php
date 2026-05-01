<?php
require_once "./Aplicacion/Interfaces/ITrabajadorRubroServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/TrabajadorRubroDTO.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Utiles/MensajesServicios.php";

class TrabajadorRubroServicio implements ITrabajadorRubroServicio
{
    protected IRepoTrabajadorRubro $_repo;
    protected RespuestaServicioDatos $_respuesta;
    protected TokenServicio $_tokenService;
    protected MensajesServicios $_mensajes;

    public function __construct(IRepoTrabajadorRubro $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
        $this->_mensajes = new MensajesServicios();
        $this->_tokenService = new TokenServicio();
    }

    public function _getTrabajadorRubroById(int $id) : RespuestaServicioDatos{}
    public function _getTrabajadoresRubros(int $desde, int $cantidad) : RespuestaServicioDatos{}
    public function _getCantidad() : RespuestaServicioDatos{}

    public function _getRubrosByTrabajadorId(int $id) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getRubrosByTrabajadorId($id);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $respuesta->resultado = $listaT;
        }
        return $respuesta;
    }

    public function _nuevoTrabajadorRubro(TrabajadorRubroDTO $trabajadorRubro, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $entidad = $this->_MapearDtoEntidad($trabajadorRubro);
                $resServ = $this->_repo->_crear($entidad);
                $this->_respuesta->resultado = $resServ->resultado;
                $this->_respuesta->errores = $resServ->errores;
                $this->_respuesta->mensajes = $resServ->mensajes;
            } else {
                $this->_respuesta->mensajes[] = $this->_mensajes->_tokenNoValido;
            }
            
        } else {
            $this->_respuesta->mensajes[] = $this->_mensajes->_faltaToken;
        }
        
        return $this->_respuesta;
    }

    public function _modificarTrabajador(TrabajadorRubroDTO $trabajadorRubro, string $token) : RespuestaServicioDatos{}

    public function _eliminarTrabajador(int $id, string $token) : RespuestaServicioDatos {
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                if ($id != null) {
                    $resServ = $this->_repo->_eliminar($id);
                    $this->_respuesta->resultado = $resServ->resultado;
                    $this->_respuesta->errores = $resServ->errores;
                    $this->_respuesta->mensajes = $resServ->mensajes;
                } else {
                    $this->_respuesta->errores[] = "No se proporciono un id";
                }
                
            } else {
                $this->_respuesta->mensajes[] = $this->_mensajes->_tokenNoValido;
            }
            
        } else {
            $this->_respuesta->mensajes[] = $this->_mensajes->_faltaToken;
        }
        return $this->_respuesta;
    }

    private function _MapearDtoEntidad(TrabajadorRubroDTO $dto) : TrabajadorRubro {
        $t = new TrabajadorRubro();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_trabajadorId = $dto->trabajadorId;
        $t->_rubroId = $dto->rubroId;
        return $t;
    }

    private function _MapearEntidadDto(TrabajadorRubro $entidad) : TrabajadorRubroDTO {
        $dto = new TrabajadorRubroDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->trabajadorId = $entidad->_trabajadorId;
        $dto->rubroId = $entidad->_rubroId;
        return $dto;
    }

    private function _checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            $this->_respuesta->errores = $listaErrores;
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }

    private function _hayToken(string $token) : bool {
        return ($token !== "");
    }

    private function _tokenValido($token) : bool {
        return $this->_tokenService->is_jwt_valid($token);
    }
}
?>