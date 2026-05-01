<?php
require_once "./Aplicacion/Interfaces/ITrabajadorContactoServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Dominio/Repositorio/RespuestaRepositorio.php";
require_once "./Aplicacion/DTO/TrabajadorContactoDTO.php";
require_once "./Dominio/Entidades/TrabajadorContacto.php";

class TrabajadorContactoServicio implements ITrabajadorContactoServicio
{
    protected IRepoTrabajadorContacto $_repo;
    protected RespuestaServicioDatos $_respuesta;
    protected TokenServicio $_tokenService;
    protected MensajesServicios $_mensajes;

    public function __construct(IRepoTrabajadorContacto $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
        $this->_tokenService = new TokenServicio();
        $this->_mensajes = new MensajesServicios;
    }

    public function _getTrabajadorContactoById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _getTrabajadoresContactos(int $desde, int $cantidad) : RespuestaServicioDatos{
    
        return new RespuestaServicioDatos();
    }

    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _getContactosByTrabajadorId(int $id) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getContactosByTrabajadorId($id);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $respuesta->resultado = $listaT;
        }
        return $respuesta;
    }

    public function _nuevoTrabajadorContacto(TrabajadorContactoDTO $trabajadorContacto, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $entidad = $this->_MapearDtoEntidad($trabajadorContacto);
                $resServ = $this->_repo->_nuevoTrabajadorContacto($entidad);
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

    public function _modificarTrabajadorContacto(TrabajadorContactoDTO $trabajadorContacto, string $token) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _eliminarTrabajadorContacto(int $id, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $resServ = $this->_repo->_eliminarTrabajadorContacto($id);
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

    private function _MapearDtoEntidad(TrabajadorContactoDTO $dto) : TrabajadorContacto {
        $t = new TrabajadorContacto();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_trabajadorId = $dto->trabajadorId;
        $t->_tipoContactoId = $dto->tipoContactoId;
        $t->_descripcion = $dto->descripcion;
        return $t;
    }

    private function _MapearEntidadDto(TrabajadorContacto $entidad) : TrabajadorContactoDTO {
        $dto = new TrabajadorContactoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->trabajadorId = $entidad->_trabajadorId;
        $dto->tipoContactoId = $entidad->_tipoContactoId;
        $dto->descripcion = $entidad->_descripcion;
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