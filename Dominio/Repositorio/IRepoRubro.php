<?php
interface IRepoRubro
{
    public function _crear(Rubro $entidad);
    public function _modificar(Rubro $entidad);
    public function _eliminar(int $id);
    public function _getById(int $id);
    public function _getTodo(int $desde, int $cantidad);
    public function _getCantidad();
}
?>