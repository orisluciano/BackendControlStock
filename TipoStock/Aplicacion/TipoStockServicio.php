<?php
require_once "ITipoStockServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "TipoStockDTO.php";

class TipoStockServicio  implements ITipoStockServicio
{
    protected IRepoTipoStock $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoTipoStock $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(TipoStockDTO $stock) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _modificar(TipoStockDTO $stock) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _eliminar(int $id) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _getById(int $id) : RespuestaServicioDatos{
        $resRepo = $this->_repo->_getById($id);
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

    private function _MapearEntidadDto(TipoStock $entidad) : TipoStockDTO {
        $dto = new TipoStockDTO;
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