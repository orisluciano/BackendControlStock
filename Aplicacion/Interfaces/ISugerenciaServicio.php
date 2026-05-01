<?php
interface ISugerenciaServicio
{
    public function _getSugerenciasById(int $id) : RespuestaServicioDatos;
    public function _getSugerencias(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _nuevo(SugerenciaDTO $sugerencia) : RespuestaServicioDatos;
    public function _modificar(SugerenciaDTO $sugerencia) : RespuestaServicioDatos;
    public function _eliminar(int $id) : RespuestaServicioDatos;
}
?>