<?php
require_once "./Aplicacion/Interfaces/ITipoContactoServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/TipoContactoDTO.php";
require_once "./Dominio/Entidades/TipoContacto.php";

class TipoContactoServicio implements ITipoContactoServicio
{
    protected IRepoTipoContacto $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoTipoContacto $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _getTipoContactoById(int $id) : RespuestaServicioDatos{}

    public function _getTiposContactos(int $desde, int $cantidad) : RespuestaServicioDatos{
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
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error al obtenes cantidad de rubros";
        } else {
            $respuesta->resultado = $resRepo->resultado;
        }
        
        return $respuesta;
    }

    public function _nuevoTipoContacto(TipoContactoDTO $tipoContacto) : RespuestaServicioDatos{
        
    }

    public function _modificarTipoContacto(TipoContactoDTO $tipoContacto) : RespuestaServicioDatos{}
    public function _eliminarTipoContacto(int $id) : RespuestaServicioDatos{}

    private function _MapearDtoEntidad(TipoContactoDTO $dto) : TipoContacto {
        $t = new TipoContacto();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_descripcion = $dto->descripcion;
        return $t;
    }

    private function _MapearEntidadDto(TipoContacto $entidad) : TipoContactoDTO {
        $dto = new TipoContactoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
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
}
?>