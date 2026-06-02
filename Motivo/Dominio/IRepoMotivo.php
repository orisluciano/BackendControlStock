<?php
interface IRepoMotivo
{
    public function _crear(Motivo $motivo) : RespuestaRepositorio;
    public function _modificar(Motivo $motivo) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo() : RespuestaRepositorio;
}

?>