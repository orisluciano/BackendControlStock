<?php
interface IFavoritoServicio{
    public function _nuevo(FavoritoDTO $favorito) : RespuestaServicioDatos;
    public function _modificar(FavoritoDTO $favorito) : RespuestaServicioDatos;
    public function _eliminar($id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getFavoritos(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getByUsuario(int $id): RespuestaServicioDatos;
}
?>