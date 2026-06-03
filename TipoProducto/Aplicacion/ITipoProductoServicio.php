<?php
interface ITipoProductoServicio
{
    public function _nuevo(TipoProductoDTO $tipoProducto) : RespuestaServicioDatos;
    public function _modificar(TipoProductoDTO $tipoProducto) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getTodo() : RespuestaServicioDatos;
}
?>