<?php
interface IRepoTipoStock {
    public function _nuevo(TipoStock $tipoStock) : RespuestaRepositorio;
    public function _modificar(TipoStock $tipoStock) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo() : RespuestaRepositorio;
}
?>