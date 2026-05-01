<?php
require_once "./Aplicacion/Interfaces/ITrabajadorServicio.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/TrabajadorDTO.php";
require_once "./Aplicacion/Utiles/MensajesServicios.php";
require_once "./Dominio/Entidades/TrabajadorUsuario.php";

class TrabajadorServicio implements ITrabajadorServicio
{
    protected IRepoTrabajador $_repo;
    protected IRepoTrabajadorUsuario $_repoTU;
    protected RespuestaServicioDatos $_respuesta;
    protected TokenServicio $_tokenService;
    protected MensajesServicios $_mensajes;

    public function __construct(IRepoTrabajador $repo, IRepoTrabajadorUsuario $repoTU) {
        $this->_repo = $repo;
        $this->_repoTU = $repoTU;
        $this->_respuesta = new RespuestaServicioDatos();
        $this->_tokenService = new TokenServicio();
        $this->_mensajes = new MensajesServicios;
    }

    public function _getTrabajadorById($id) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getById($id);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            if (count($listaT) > 0) {
                $listaMapeada = [];
                foreach ($listaT as $key) {
                    $listaMapeada[] = $this->_MapearEntidadDto($key);
                }
                $respuesta->resultado = $listaMapeada[0];
            } else {
                $respuesta->errores[] = "No hay resultados";
            }
        }
        return $respuesta;
    }
    public function _getTrabajadores($desde, $cantidad) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getTodo($desde, $cantidad);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $listaMapeada = [];
            foreach ($listaT as $key) {
                $listaMapeada[] = $this->_MapearEntidadDto($key);
            }
            $respuesta->resultado = $listaMapeada;
        }
        return $respuesta;
    }

    public function _getCantidad() : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidad();
        $respuesta->resultado = $resRepo->resultado;
        $respuesta->errores = $resRepo->errores;
        return $respuesta;
    }

    public function _getByRubro(int $desde, int $cantidad, int $rubroId) : RespuestaServicioDatos {
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getByRubro($desde, $cantidad, $rubroId);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $listaMapeada = [];
            foreach ($listaT as $key) {
                $listaMapeada[] = $this->_MapearEntidadDto($key);
            }
            $respuesta->resultado = $listaMapeada;
        }
        return $respuesta;
    }
    public function _getCantidadByRubro(int $rubroId) : RespuestaServicioDatos {
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidadByRubro($rubroId);
        $respuesta->resultado = $resRepo->resultado;
        $respuesta->errores = $resRepo->errores;
        return $respuesta;
    }

    public function _nuevoTrabajador(TrabajadorDTO $trabajador, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                $entidad = $this->_MapearDtoEntidad($trabajador);
                $resServ = $this->_repo->_crear($entidad);
                $this->_respuesta->resultado = $resServ->resultado;
                $this->_respuesta->errores = $resServ->errores;
                $this->_respuesta->mensajes = $resServ->mensajes;
                $tUser = new TrabajadorUsuario();
                $tUser->_usuarioId = $this->_tokenService->getUsuario($token);
                $tUser->_trabajadorId = $resServ->resultado;
                $resTu = $this->_repoTU->_nuevoTrabajadorUsuario($tUser);
            } else {
                $this->_respuesta->mensajes[] = $this->_mensajes->_tokenNoValido;
            }
            
        } else {
            $this->_respuesta->mensajes[] = $this->_mensajes->_faltaToken;
        }
        
        return $this->_respuesta;
    }
    public function _modificarTrabajador(TrabajadorDTO $trabajador, string $token) : RespuestaServicioDatos{
        if ($this->_hayToken($token)) {
            if ($this->_tokenValido($token)) {
                if ($trabajador->id != null) {
                    $entidad = $this->_MapearDtoEntidad($trabajador);
                    $resServ = $this->_repo->_modificar($entidad);
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
    public function _eliminarTrabajador(int $id, string $token) : RespuestaServicioDatos{
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

    private function _MapearDtoEntidad(TrabajadorDTO $dto) : Trabajador {
        $t = new Trabajador();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_nombre = $dto->nombre;
        $t->_apellido = $dto->apellido;
        $t->_descripcion = $dto->descripcion;
        return $t;
    }

    private function _MapearEntidadDto(Trabajador $entidad) : TrabajadorDTO {
        $dto = new TrabajadorDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->nombre = $entidad->_nombre;
        $dto->apellido = $entidad->_apellido;
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