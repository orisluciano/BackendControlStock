<?php
require_once "IStockServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "StockDTO.php";

class StockServicio implements IStockServicio
{
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
    public function _getStockByProductoId(int $productoId, string $desde, string $hasta) : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }
    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos;
    }
}
?>