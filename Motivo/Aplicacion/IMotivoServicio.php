<?php
interface IMotivoServicio
{
    public function _nuevo(MotivoDTO $motivo) : RespuestaServicioDatos;
    public function _modificar(MotivoDTO $motivo) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getTodo() : RespuestaServicioDatos;
}
?>