<?php
require_once "IStockServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "StockDTO.php";

class StockServicio implements IStockServicio
{
    protected IRepoStock $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoStock $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(StockDTO $stock) : RespuestaServicioDatos{
        if (is_null($stock->productoId)) {
            $this->_respuesta->errores[] = "El productoId no puede estar vacio";
        }
        if (is_null($stock->minimo)) {
            $this->_respuesta->errores[] = "El minimo de stock no puede estar vacio";
        }
        if (is_null($stock->maximo)) {
            $this->_respuesta->errores[] = "El maximo de stock no puede estar vacio";
        }
        if (is_null($stock->tipoStockId)) {
            $this->_respuesta->errores[] = "El tipo de stock no puede estar vacio";
        }
        if (!$this->_checkErrores($this->_respuesta->errores)) {
            $nuevo = new Stock();
            $nuevo->_minimo = $stock->minimo;
            $nuevo->_maximo = $stock->maximo;
            $nuevo->_productoId = $stock->productoId;
            $nuevo->_tipoStockId = $stock->tipoStockId;
            $resRepo = $this->_repo->_crear($nuevo);
            $this->_respuesta->errores = $resRepo->errores;
            $this->_respuesta->mensajes = $resRepo->mensajes;
        }
        return $this->_respuesta;
    }
    public function _modificar(StockDTO $stock) : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }
    public function _eliminar(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }
    public function _getById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }
    public function _getStockByProductoId(int $productoId) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getStockByProductoId($productoId);
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
                $respuesta->resultado = $listaMapeada;
            } else {
                $respuesta->errores[] = "No hay resultados";
            }
        }
        return $respuesta;
    }
    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }

    private function _MapearDtoEntidad(PrecioDTO $dto) : Precio {
        $t = new Precio();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_costo = $dto->costo;
        $t->_venta = $dto->venta;
        $t->_productoId = $dto->productoId;
        return $t;
    }

    private function _MapearEntidadDto(Stock $entidad) : StockDTO {
        $dto = new StockDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->productoId = $entidad->_productoId;
        $dto->minimo = $entidad->_minimo;
        $dto->maximo = $entidad->_maximo;
        $dto->actual = $entidad->_actual;
        $dto->tipoStockId = $entidad->_tipoStockId;
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