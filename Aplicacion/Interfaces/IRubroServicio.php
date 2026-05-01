<?php
interface IRubroServicio{
    public function _getRubroById($id);
    public function _getRubros($desde, $cantidad);
    public function _getCantidad();
    public function _nuevoRubro(RubroDTO $rubro);
    public function _modificarRubro(RubroDTO $rubro);
    public function _eliminarRubro($id);
}
?>