<?php
interface IRepoFavorito
{
    public function _crear(Favorito $entidad) : RespuestaRepositorio;
    public function _modificar(Favorito $entidad) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getByUsuario(int $id) : RespuestaRepositorio;
}
?>