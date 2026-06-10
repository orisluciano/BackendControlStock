<?php
require_once "./Utiles/DTOBase.php";

class ProductoDTO extends DTOBase
{
    public string $nombre;
    public string $descripcion;
    public string $codigo;
    public string $tipoCodigo;
    public int $tipoProdId;
}

?>