<?php
interface IProductoServicio
{
    public function _nuevo(ProductoDTO $producto) : RespuestaServicioDatos;
    public function _modificar(ProductoDTO $producto) : RespuestaServicioDatos;
    public function _eliminar($id) : RespuestaServicioDatos;
    public function _getById(int $id) : RespuestaServicioDatos;
    public function _getProductos(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function _getCantidad() : RespuestaServicioDatos;
    public function _getByCodigo(string $codigo, string $tipoCodigo) : RespuestaServicioDatos;
}
?>