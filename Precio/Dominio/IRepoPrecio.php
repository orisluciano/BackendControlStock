<?php
interface IRepoPrecio
{
    public function _crear(Precio $precio) : RespuestaRepositorio;
    public function _modificar(Precio $precio) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getByProductoId(int $productoId, string $desde, string $hasta) : RespuestaRepositorio;
}

?>