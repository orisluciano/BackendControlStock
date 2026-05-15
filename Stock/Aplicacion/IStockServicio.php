<?php
interface IStockServicio {
    public function _nuevo(StockDTO $stock) : RespuestaServicioDatos;
    public function _modificar(StockDTO $stock) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getStockByProductoId(int $productoId) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
}
?>