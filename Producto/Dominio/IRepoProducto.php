<?php
interface IRepoProducto
{
    public function _crear(Producto $entidad) : RespuestaRepositorio;
    public function _modificar(Producto $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getByCodigo(string $codigo, string $tipoCodigo) : RespuestaRepositorio; 
}

?>