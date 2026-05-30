<?php
require_once "IMovimientoStockServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "MovimientoStockDTO.php";

class MovimientoStockServicio  implements IMovimientoStockServicio
{
    protected IRepoMovimientoStock $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoMovimientoStock $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(MovimientoStockDTO $movStock) : RespuestaServicioDatos{
        if (is_null($movStock->stockId)) {
            $this->_respuesta->errores[] = "El stockId no puede estar vacio";
        }
        if (is_null($movStock->cantidad)) {
            $this->_respuesta->errores[] = "La cantidad no puede estar vacia";
        }
        if (is_null($movStock->tipoMovimientoId)) {
            $this->_respuesta->errores[] = "El tipoMovimientoId no puede estar vacio";
        }
        if (is_null($movStock->motivoMovId)) {
            $this->_respuesta->errores[] = "El motivoMovId no puede estar vacio";
        }
        if (!$this->_checkErrores($this->_respuesta->errores)) {
            $nuevo = new MovimientoStock();
            $nuevo->_stockId = $movStock->stockId;
            $nuevo->_cantidad = $movStock->cantidad;
            $nuevo->_tipoMovimientoId = $movStock->tipoMovimientoId;
            $nuevo->_motivoMovId = $movStock->motivoMovId;
            $resRepo = $this->_repo->_nuevo($nuevo);
            $this->_respuesta->errores = $resRepo->errores;
            $this->_respuesta->mensajes = $resRepo->mensajes;
        }
        return $this->_respuesta;
    }
    public function _modificar(MovimientoStockDTO $movStock) : RespuestaServicioDatos{
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

    public function _getMovsById(int $id) : RespuestaServicioDatos {
        $resRepo = $this->_repo->_getMovsById($id);
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

    private function _MapearEntidadDto(MovimientoStock $entidad) : MovimientoStockDTO {
        $dto = new MovimientoStockDTO;
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->stockId = $entidad->_stockId;
        $dto->cantidad = $entidad->_cantidad;
        $dto->tipoMovimientoId = $entidad->_tipoMovimientoId;
        $dto->motivoMovId = $entidad->_motivoMovId;
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