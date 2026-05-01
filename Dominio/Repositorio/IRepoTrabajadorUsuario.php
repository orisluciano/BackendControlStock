<?php
interface IRepoTrabajadorUsuario
{
    public function _getTrabajadorUsuarioById(int $id) : RespuestaRepositorio;
    public function _getTrabajadoresUsuarios(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getTrabajadorByUsuarioId(int $id) : RespuestaRepositorio;
    public function _nuevoTrabajadorUsuario(TrabajadorUsuario $trabajadorUsuario) : RespuestaRepositorio;
    public function _modificarTrabajadorUsuario(TrabajadorUsuario $trabajadorUsuario) : RespuestaRepositorio;
    public function _eliminarTrabajadorUsuario(int $id) : RespuestaRepositorio;
}
?>