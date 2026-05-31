<?php
interface IMovimientoStockServicio {
    public function _nuevo(MovimientoStockDTO $movStock) : RespuestaServicioDatos;
    public function _modificar(MovimientoStockDTO $movStock) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getTodo() : RespuestaServicioDatos;
    public function _getMovsById(int $id, string $desde, string $hasta) : RespuestaServicioDatos;
}
?>