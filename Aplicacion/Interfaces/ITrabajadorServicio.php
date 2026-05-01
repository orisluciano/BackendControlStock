<?php
interface ITrabajadorServicio{
    public function _getTrabajadorById(int $id) : RespuestaServicioDatos;
    public function _getTrabajadores(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _nuevoTrabajador(TrabajadorDTO $trabajador, string $token) : RespuestaServicioDatos;
    public function _modificarTrabajador(TrabajadorDTO $trabajador, string $token) : RespuestaServicioDatos;
    public function _eliminarTrabajador(int $id, string $token) : RespuestaServicioDatos;
    public function _getByRubro(int $desde, int $cantidad, int $rubroId) : RespuestaServicioDatos;
    public function _getCantidadByRubro(int $rubroId) : RespuestaServicioDatos;
}
?>