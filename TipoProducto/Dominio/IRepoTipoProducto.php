<?php
interface IRepoTipoProducto
{
    public function _crear(TipoProducto $tipoProducto) : RespuestaRepositorio;
    public function _modificar(TipoProducto $tipoProducto) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo() : RespuestaRepositorio;
}

?>