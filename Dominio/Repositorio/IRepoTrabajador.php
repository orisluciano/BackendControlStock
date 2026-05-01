<?php
interface IRepoTrabajador{
    public function _crear(Trabajador $entidad) : RespuestaRepositorio;
    public function _modificar(Trabajador $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getByRubro(int $desde, int $cantidad, int $rubroId) : RespuestaRepositorio;
    public function _getCantidadByRubro(int $rubroId) : RespuestaRepositorio;
}
?>