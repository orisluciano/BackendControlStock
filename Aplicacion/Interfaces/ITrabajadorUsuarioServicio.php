<?php
interface ITrabajadorUsuarioServicio
{
    public function _getTrabajadorUsuarioById(int $id, string $token) : RespuestaServicioDatos;
    public function _getTrabajadoresUsuarios(int $desde, int $cantidad, string $token) : RespuestaServicioDatos;
    public function _getCantidad(string $token) : RespuestaServicioDatos;
    public function _getTrabajadorByUsuarioId(int $id, string $token) : RespuestaServicioDatos;
    public function _nuevoTrabajadorUsuario(TrabajadorUsuarioDTO $trabajadorUsuario, string $token) : RespuestaServicioDatos;
    public function _modificarTrabajadorUsuario(TrabajadorUsuarioDTO $trabajadorUsuario, string $token) : RespuestaServicioDatos;
    public function _eliminarTrabajadorUsuario(int $id, string $token) : RespuestaServicioDatos;
}
?>