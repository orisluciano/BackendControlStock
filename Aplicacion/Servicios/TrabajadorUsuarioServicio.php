<?php
require_once "./Aplicacion/Interfaces/ITrabajadorUsuarioServicio.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/TrabajadorUsuarioDTO.php";
require_once "./Aplicacion/Utiles/MensajesServicios.php";

class TrabajadorUsuarioServicio implements ITrabajadorUsuarioServicio
{
    protected IRepoTrabajadorUsuario $_repo;
    protected RespuestaServicioDatos $_respuesta;
    protected TokenServicio $_tokenService;
    protected MensajesServicios $_mensajes;

    public function __construct(IRepoTrabajadorUsuario $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
        $this->_tokenService = new TokenServicio();
        $this->_mensajes = new MensajesServicios;
    }

    public function _getTrabajadorUsuarioById(int $id, string $token) : RespuestaServicioDatos {
        return new RespuestaServicioDatos();
    }

    public function _getTrabajadoresUsuarios(int $desde, int $cantidad, string $token) : RespuestaServicioDatos {
        return new RespuestaServicioDatos();
    }

    public function _getCantidad(string $token) : RespuestaServicioDatos {
        return new RespuestaServicioDatos();
    }

    public function _getTrabajadorByUsuarioId(int $id, string $token) : RespuestaServicioDatos {
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $resRepo = $this->_repo->_getTrabajadorByUsuarioId($id, $token);
                if ($this->_checkErrores($resRepo->errores)) {
                    $this->_respuesta->errores = $resRepo->errores;
                    $this->_respuesta->errores[] = "Error en el servicio";
                } else {
                    $listaT = $resRepo->resultado;
                    $this->_respuesta->resultado = $listaT;
                }
            } else {
                $this->_respuesta->mensajes[] = $this->_mensajes->_tokenNoValido;
            }
        } else {
            $this->_respuesta->mensajes[] = $this->_mensajes->_faltaToken;
        }
        return $this->_respuesta;
    }

    public function _nuevoTrabajadorUsuario(TrabajadorUsuarioDTO $trabajadorUsuario, string $token) : RespuestaServicioDatos {
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $entidad = $this->_MapearDtoEntidad($trabajadorUsuario);
                $resServ = $this->_repo->_nuevoTrabajadorUsuario($entidad);
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

    public function _modificarTrabajadorUsuario(TrabajadorUsuarioDTO $trabajadorUsuario, string $token) : RespuestaServicioDatos {
        return new RespuestaServicioDatos();
    }

    public function _eliminarTrabajadorUsuario(int $id, string $token) : RespuestaServicioDatos {
        return new RespuestaServicioDatos();
    }

    private function _MapearDtoEntidad(TrabajadorUsuarioDTO $dto) : TrabajadorUsuario {
        $t = new TrabajadorUsuario();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_trabajadorId = $dto->trabajadorId;
        $t->_usuarioId = $dto->usuarioId;
        return $t;
    }

    private function _MapearEntidadDto(TrabajadorUsuario $entidad) : TrabajadorUsuarioDTO {
        $dto = new TrabajadorUsuarioDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->trabajadorId = $entidad->_trabajadorId;
        $dto->usuarioId = $entidad->_usuarioId;
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