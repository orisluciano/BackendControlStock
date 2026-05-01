<?php
interface ITrabajadorOpinionServicio
{
    public function _getTrabajadorOpinionById(int $id) : RespuestaServicioDatos;
    public function _getTrabajadoresOpiniones(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getOpinionesByTrabajadorId(int $id, int $desde, int $cant) : RespuestaServicioDatos;
    public function _nuevoTrabajadorOpinion(TrabajadorOpinionDTO $trabajadorOpinion, string $token) : RespuestaServicioDatos;
    public function _modificarTrabajadorOpinion(TrabajadorOpinionDTO $trabajadorOpinion, string $token) : RespuestaServicioDatos;
    public function _eliminarTrabajadorOpinion(int $id, string $token) : RespuestaServicioDatos;
}
?>