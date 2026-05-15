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
        return new RespuestaServicioDatos;
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
        $dto->tipoStock = $entidad->_tipoStock;
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