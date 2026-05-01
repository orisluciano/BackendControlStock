<?php
require_once "./Aplicacion/Interfaces/ITrabajadorOpinionServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Dominio/Repositorio/RespuestaRepositorio.php";
require_once "./Aplicacion/DTO/TrabajadorOpinionDTO.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Utiles/MensajesServicios.php";
require_once "./Dominio/Entidades/TrabajadorOpinion.php";

class TrabajadorOpinionServicio implements ITrabajadorOpinionServicio
{
    protected IRepoTrabajadorOpinion $_repo;
    protected RespuestaServicioDatos $_respuesta;
    protected TokenServicio $_tokenService;
    protected MensajesServicios $_mensajes;

    public function __construct(IRepoTrabajadorOpinion $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
        $this->_mensajes = new MensajesServicios();
        $this->_tokenService = new TokenServicio();
    }

    public function _getTrabajadorOpinionById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getTrabajadoresOpiniones(int $desde, int $cantidad) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getOpinionesByTrabajadorId(int $id, int $desde, int $cant) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getOpinionesByTrabajadorId($id, $desde, $cant);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $respuesta->resultado = $listaT;
        }
        return $respuesta;
        return new RespuestaServicioDatos();
    }
    public function _nuevoTrabajadorOpinion(TrabajadorOpinionDTO $trabajadorOpinion, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $entidad = $this->_MapearDtoEntidad($trabajadorOpinion);
                $resServ = $this->_repo->_nuevoTrabajadorOpinion($entidad);
                $this->_respuesta->resultado = $resServ->resultado;
                $this->_respuesta->errores = $resServ->errores;
                $this->_respuesta->mensajes = $resServ->mensajes;
            } else {
                $this->_respuesta->errores[] = $this->_mensajes->_tokenNoValido;
            }
            
        } else {
            $this->_respuesta->errores[] = $this->_mensajes->_faltaToken;
        }
        
        return $this->_respuesta;
    }
    public function _modificarTrabajadorOpinion(TrabajadorOpinionDTO $trabajadorOpinion, string $token) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _eliminarTrabajadorOpinion(int $id, string $token) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    private function _MapearDtoEntidad(TrabajadorOpinionDTO $dto) : TrabajadorOpinion {
        $t = new TrabajadorOpinion();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_trabajadorId = $dto->trabajadorId;
        $t->_calificacion = $dto->calificacion;
        $t->_opinion = $dto->opinion;
        $t->_usuarioId = $dto->usuarioId;
        return $t;
    }

    private function _MapearEntidadDto(TrabajadorOpinion $entidad) : TrabajadorOpinionDTO {
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