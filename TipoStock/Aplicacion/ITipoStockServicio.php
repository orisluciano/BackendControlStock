<?php
interface ITipoStockServicio {
    public function _nuevo(TipoStockDTO $stock) : RespuestaServicioDatos;
    public function _modificar(TipoStockDTO $stock) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getTodo() : RespuestaServicioDatos;
}
?>