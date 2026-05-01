<?php
interface ITrabajadorRubroServicio
{
    public function _getTrabajadorRubroById(int $id) : RespuestaServicioDatos;
    public function _getTrabajadoresRubros(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getRubrosByTrabajadorId(int $id) : RespuestaServicioDatos;
    public function _nuevoTrabajadorRubro(TrabajadorRubroDTO $trabajadorRubro, string $token) : RespuestaServicioDatos;
    public function _modificarTrabajador(TrabajadorRubroDTO $trabajadorRubro, string $token) : RespuestaServicioDatos;
    public function _eliminarTrabajador(int $id, string $token) : RespuestaServicioDatos;
}
?>