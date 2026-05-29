<?php
interface IRepoMovimientoStock {
    public function _nuevo(MovimientoStock $movimientoStock) : RespuestaRepositorio;
    public function _modificar(MovimientoStock $movimientoStock) : RespuestaRepositorio;
    public function _eliminar(int $id) : RespuestaRepositorio;
    public function _getById(int $id) : RespuestaRepositorio;
    public function _getTodo() : RespuestaRepositorio;
    public function _getMovsById(int $id) : RespuestaRepositorio;
}
?>