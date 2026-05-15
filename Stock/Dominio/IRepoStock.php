<?php
interface IRepoStock {
    public function _crear(Stock $entidad) : RespuestaRepositorio;
    public function _modificar(Stock $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getStockByProductoId(int $productoId) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;   
}
?>