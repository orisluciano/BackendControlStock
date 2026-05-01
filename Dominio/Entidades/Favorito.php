<?php
require_once "./Dominio/Entidades/EntidadBase.php";

class Favorito extends EntidadBase
{
    public string $_etiqueta;
    public string $_descripcion;
    public int $_usuarioId;
    public int $_trabajadorId; 
}

?>