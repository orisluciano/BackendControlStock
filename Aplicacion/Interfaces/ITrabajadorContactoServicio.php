<?php
interface ITrabajadorContactoServicio
{
    public function _getTrabajadorContactoById(int $id) : RespuestaServicioDatos;
    public function _getTrabajadoresContactos(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getContactosByTrabajadorId(int $id) : RespuestaServicioDatos;
    public function _nuevoTrabajadorContacto(TrabajadorContactoDTO $trabajadorContacto, string $token) : RespuestaServicioDatos;
    public function _modificarTrabajadorContacto(TrabajadorContactoDTO $trabajadorContacto, string $token) : RespuestaServicioDatos;
    public function _eliminarTrabajadorContacto(int $id, string $token) : RespuestaServicioDatos;
}
?>