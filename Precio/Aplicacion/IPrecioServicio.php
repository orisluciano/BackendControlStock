<?php
interface IPrecioServicio
{
    public function _nuevo(PrecioDTO $precio) : RespuestaServicioDatos;
    public function _modificar(PrecioDTO $precio) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getPrecios(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getByIdFechas(int $id, string $desde, string $hasta) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getUltimoById(int $id) : RespuestaServicioDatos;
}
?>