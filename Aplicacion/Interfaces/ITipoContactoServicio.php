<?php 
interface ITipoContactoServicio
{
    public function _getTipoContactoById(int $id) : RespuestaServicioDatos;
    public function _getTiposContactos(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _nuevoTipoContacto(TipoContactoDTO $tipoContacto) : RespuestaServicioDatos;
    public function _modificarTipoContacto(TipoContactoDTO $tipoContacto) : RespuestaServicioDatos;
    public function _eliminarTipoContacto(int $id) : RespuestaServicioDatos;
}
?>