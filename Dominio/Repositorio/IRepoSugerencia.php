<?php
interface IRepoSugerencia
{
    public function _crear(Sugerencia $entidad) : RespuestaRepositorio;
    public function _modificar(Sugerencia $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
}
?>