<?php
interface IRepoTrabajadorOpinion
{
    public function _getTrabajadorOpinionById(int $id) : RespuestaRepositorio;
    public function _getTrabajadoresOpiniones(int $desde, int $cantidad) : RespuestaRepositorio;
    public function _getCantidad() : RespuestaRepositorio;
    public function _getOpinionesByTrabajadorId(int $id, int $desde, int $cantidad) : RespuestaRepositorio;
    public function _nuevoTrabajadorOpinion(TrabajadorOpinion $trabajadorContacto) : RespuestaRepositorio;
    public function _modificarTrabajadorOpinion(TrabajadorOpinion $trabajadorContacto) : RespuestaRepositorio;
    public function _eliminarTrabajadorOpinion(int $id) : RespuestaRepositorio;
}
?>