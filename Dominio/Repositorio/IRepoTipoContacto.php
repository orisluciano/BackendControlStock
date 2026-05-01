<?php
interface IRepoTipoContacto
{
    public function _crear(TipoContacto $entidad) : RespuestaRepositorio;
    public function _modificar(TipoContacto $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
}
?>