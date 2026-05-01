<?php
interface IRepoTrabajadorContacto
{
    public function _getTrabajadorContactoById(int $id) : RespuestaRepositorio;
    public function _getTrabajadoresContactos(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getContactosByTrabajadorId(int $id) : RespuestaRepositorio;
    public function _nuevoTrabajadorContacto(TrabajadorContacto $trabajadorContacto) : RespuestaRepositorio;
    public function _modificarTrabajadorContacto(TrabajadorContacto $trabajadorContacto) : RespuestaRepositorio;
    public function _eliminarTrabajadorContacto(int $id) : RespuestaRepositorio;
}
?>