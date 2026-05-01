<?php
interface IRepoTrabajadorRubro
{
    public function _crear(TrabajadorRubro $entidad) : RespuestaRepositorio;
    public function _modificar(TrabajadorRubro $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getRubrosByTrabajadorId(int $id) : RespuestaRepositorio;
}
?>