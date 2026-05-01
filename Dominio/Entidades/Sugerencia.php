<?php
require_once "./Dominio/Entidades/EntidadBase.php";

class Sugerencia extends EntidadBase
{
    public string $_descripcion;
    public bool $_leido;
    public int $_usuarioId;
}
?>