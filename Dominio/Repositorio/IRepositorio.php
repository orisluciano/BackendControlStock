<?php
require_once "../Back/Dominio/Entidades/EntidadBase.php";
interface IRepositorio
{
    public function crear($entidad);
    public function modificar($entidad);
    public function eliminar(int $id);
    public function getById(int $id);
    public function getTodo();
}
?>