<?php
require_once "./Motivo/Aplicacion/IMotivoServicio.php";

class MotivoServicio implements IMotivoServicio
{
    protected IRepoMotivo $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoMotivo $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(MotivoDTO $motivo) : RespuestaServicioDatos{
        return $this->_respuesta;
    }

    public function _modificar(MotivoDTO $motivo) : RespuestaServicioDatos{
        return $this->_respuesta;
    }

    public function _eliminar(int $id) : RespuestaServicioDatos{
        return $this->_respuesta;
    }

    public function _getById(int $id) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _getTodo() : RespuestaServicioDatos{
        $resRepo = $this->_repo->_getTodo();
        if ($this->_checkErrores($resRepo->errores)) {
            $this->_respuesta->errores = $resRepo->errores;
            $this->_respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            if (count($listaT) > 0) {
                $listaMapeada = [];
                foreach ($listaT as $key) {
                    $listaMapeada[] = $this->_MapearEntidadDto($key);
                }
                $this->_respuesta->resultado = $listaMapeada;
            } else {
                $this->_respuesta->errores[] = "No hay resultados";
            }
        }
        return $this->_respuesta;
    }
    
    private function _MapearEntidadDto(Motivo $entidad) : MotivoDTO {
        $dto = new MotivoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->descripcion = $entidad->_descripcion;
        $dto->tipo = $entidad->_tipo;
        return $dto;
    }

    private function _MapearDTOEntidad(MotivoDTO $dto) : Motivo{
        $entidad = new Motivo();
        $entidad->_id = $dto->id;
        $entidad->_fechaCreacion = $dto->fechaCreacion;
        $entidad->_fechaModif = $dto->fechaModif;
        $entidad->_descripcion = $dto->descripcion;
        $entidad->_tipo = $dto->tipo;
        return $entidad;
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